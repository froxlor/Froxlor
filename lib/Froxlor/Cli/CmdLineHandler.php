<?php
namespace Froxlor\Cli;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2018 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2018-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 */
abstract class CmdLineHandler
{

	/**
	 * internal variable for passed arguments
	 *
	 * @var array
	 */
	private static $args = null;

	/**
	 * Action object read from commandline/config
	 *
	 * @var \Froxlor\Cli\Action
	 */
	private $action = null;

	/**
	 * Returns a CmdLineHandler object with given
	 * arguments from command line
	 *
	 * @param int $argc
	 * @param array $argv
	 *
	 * @return CmdLineHandler
	 */
	public static function processParameters($argc, $argv)
	{
		$me = get_called_class();
		return new $me($argc, $argv);
	}

	/**
	 * class constructor, validates the command line parameters
	 * and sets the Action-object if valid
	 *
	 * @param int $argc
	 * @param string[] $argv
	 *
	 * @return null
	 * @throws \Exception
	 */
	private function __construct($argc, $argv)
	{
		self::$args = $this->parseArgs($argv);
		$this->action = $this->createAction();
		$this->action->run();
	}

	/**
	 * Parses the arguments given via the command line;
	 * three types are supported:
	 * 1.
	 * --parm1 or --parm2=value
	 * 2. -xyz (multiple switches in one) or -a=value
	 * 3. parm1 parm2
	 *
	 * The 1. will be mapped as
	 * ["parm1"] => true, ["parm2"] => "value"
	 * The 2. as
	 * ["x"] => true, ["y"] => true, ["z"] => true, ["a"] => "value"
	 * And the 3. as
	 * [0] => "parm1", [1] => "parm2"
	 *
	 * @param array $argv
	 *
	 * @return array
	 */
	private function parseArgs($argv)
	{
		array_shift($argv);
		$o = array();
		foreach ($argv as $a) {
			if (substr($a, 0, 2) == '--') {
				$eq = strpos($a, '=');
				if ($eq !== false) {
					$o[substr($a, 2, $eq - 2)] = substr($a, $eq + 1);
				} else {
					$k = substr($a, 2);
					if (! isset($o[$k])) {
						$o[$k] = true;
					}
				}
			} elseif (substr($a, 0, 1) == '-') {
				if (substr($a, 2, 1) == '=') {
					$o[substr($a, 1, 1)] = substr($a, 3);
				} else {
					foreach (str_split(substr($a, 1)) as $k) {
						if (! isset($o[$k])) {
							$o[$k] = true;
						}
					}
				}
			} else {
				$o[] = $a;
			}
		}
		return $o;
	}

	/**
	 * Creates an Action-Object for the Action-Handler
	 *
	 * @return \Froxlor\Cli\Action
	 * @throws \Exception
	 */
	private function createAction()
	{

		// Test for help-switch
		if (empty(self::$args) || array_key_exists("help", self::$args) || array_key_exists("h", self::$args)) {
			static::printHelp();
			// end of execution
		}
		// check if no unknown parameters are present
		foreach (self::$args as $arg => $value) {

			if (is_numeric($arg)) {
				throw new \Exception("Unknown parameter '" . $value . "' in argument list");
			} elseif (! in_array($arg, static::$params) && ! in_array($arg, static::$switches)) {
				throw new \Exception("Unknown parameter '" . $arg . "' in argument list");
			}
		}

		// set debugger switch
		if (isset(self::$args["d"]) && self::$args["d"] == true) {
			// Debugger::getInstance()->setEnabled(true);
			// Debugger::getInstance()->debug("debug output enabled");
		}

		return new static::$action_class(self::$args);
	}

	public static function getInput($prompt = "#", $default = "")
	{
		if (! empty($default)) {
			$prompt .= " [" . $default . "]";
		}
		$result = readline($prompt . ":");
		if (empty($result) && ! empty($default)) {
			$result = $default;
		}
		return mb_strtolower($result);
	}

	public static function getYesNo($prompt = "#", $default = null)
	{
		$value = null;
		$_v = null;

		while (true) {
			$_v = self::getInput($prompt);

			if (strtolower($_v) == 'y' || strtolower($_v) == 'yes') {
				$value = 1;
				break;
			} elseif (strtolower($_v) == 'n' || strtolower($_v) == 'no') {
				$value = 0;
				break;
			} else {
				if ($_v == '' && $default != null) {
					$value = $default;
					break;
				} else {
					echo "Sorry, response " . $_v . " not understood. Please enter 'yes' or 'no'\n";
					$value = null;
					continue;
				}
			}
		}

		return $value;
	}

	public static function println($msg = "")
	{
		print $msg . PHP_EOL;
	}

	private static function printcolor($msg = "", $color = "0")
	{
		print "\033[" . $color . "m" . $msg . "\033[0m" . PHP_EOL;
	}

	public static function printerr($msg = "")
	{
		self::printcolor($msg, "31");
	}

	public static function printsucc($msg = "")
	{
		self::printcolor($msg, "32");
	}

	public static function printwarn($msg = "")
	{
		self::printcolor($msg, "33");
	}
}
