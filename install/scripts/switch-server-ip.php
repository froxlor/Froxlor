#!/usr/bin/php
<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *
 */

// Check if we're in the CLI
if(@php_sapi_name() !== 'cli') {
	die('This script will only work in the shell.');
}

// give control to command line handler
try {
	CmdLineHandler::processParameters($argc, $argv);
} catch (Exception $e) {
	CmdLineHandler::printerr($e->getMessage());
}

class CmdLineHandler
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
	 * @var Action
	 */
	private $_action = null;

	/**
	 * list of valid parameters/switches
	 */
	public static $switches = array(
		/* 'd', // debug / output information for everything */
		'h'
	);
 // same as --help
	public static $params = array(
		'switch',
		'list',
		'froxlor-dir',
		'help'
	);

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
		return new CmdLineHandler($argc, $argv);
	}

	/**
	 * returns the Action object generated in
	 * the class constructor
	 *
	 * @return Action
	 */
	public function getAction()
	{
		return $this->_action;
	}

	/**
	 * class constructor, validates the command line parameters
	 * and sets the Action-object if valid
	 *
	 * @param int $argc
	 * @param string[] $argv
	 *
	 * @return null
	 * @throws Exception
	 */
	private function __construct($argc, $argv)
	{
		self::$args = $this->_parseArgs($argv);
		$this->_action = $this->_createAction();
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
	private function _parseArgs($argv)
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
			} else
				if (substr($a, 0, 1) == '-') {
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
	 * @return Action
	 * @throws Exception
	 */
	private function _createAction()
	{

		// Test for help-switch
		if (empty(self::$args) || array_key_exists("help", self::$args) || array_key_exists("h", self::$args)) {
			self::printHelp();
			// end of execution
		}
		// check if no unknown parameters are present
		foreach (self::$args as $arg => $value) {

			if (is_numeric($arg)) {
				throw new Exception("Unknown parameter '" . $value . "' in argument list");
			} elseif (! in_array($arg, self::$params) && ! in_array($arg, self::$switches)) {
				throw new Exception("Unknown parameter '" . $arg . "' in argument list");
			}
		}

		// set debugger switch
		if (isset(self::$args["d"]) && self::$args["d"] == true) {
			// Debugger::getInstance()->setEnabled(true);
			// Debugger::getInstance()->debug("debug output enabled");
		}

		return new Action(self::$args);
	}

	public static function printHelp()
	{
		self::println("");
		self::println("Help / command line parameters:");
		self::println("");
		// commands
		self::println("--switch\t\tlets you switch ip-address A with ip-address B");
		self::println("\t\t\tExample: --switch=A,B");
		self::println("\t\t\tExample: --switch=\"A1,B1 A2,B2 A3,B3 ...\"");
		self::println("");
		self::println("--list\t\t\tshow all currently used ip-addresses in froxlor");
		self::println("");
		self::println("--froxlor-dir\t\tpath to froxlor installation");
		self::println("\t\t\tExample: --froxlor-dir=/var/www/froxlor/");
		self::println("");
		self::println("--help\t\t\tshow help screen (this)");
		self::println("");
		// switches
		// self::println("-d\t\t\tenable debug output");
		self::println("-h\t\t\tsame as --help");
		self::println("");

		die(); // end of execution
	}

	public static function println($msg = "")
	{
		print $msg . PHP_EOL;
	}

	private static function _printcolor($msg = "", $color = "0")
	{
		print "\033[" . $color . "m" . $msg . "\033[0m" . PHP_EOL;
	}

	public static function printerr($msg = "")
	{
		self::_printcolor($msg, "31");
	}

	public static function printsucc($msg = "")
	{
		self::_printcolor($msg, "32");
	}

	public static function printwarn($msg = "")
	{
		self::_printcolor($msg, "33");
	}
}

class Action
{

	private $_args = null;

	private $_name = null;

	private $_db = null;

	public function __construct($args)
	{
		$this->_args = $args;
		$this->_validate();
	}

	public function getActionName()
	{
		return $this->_name;
	}

	/**
	 * validates the parsed command line parameters
	 *
	 * @throws Exception
	 */
	private function _validate()
	{
		$need_config = false;
		if (array_key_exists("list", $this->_args) || array_key_exists("switch", $this->_args)) {
			$need_config = true;
		}

		$this->_checkConfigParam($need_config);

		$this->_parseConfig();

		if (array_key_exists("list", $this->_args)) {
			$this->_listIPs();
		}
		if (array_key_exists("switch", $this->_args)) {
			$this->_switchIPs();
		}
	}

	private function _listIPs()
	{
		$sel_stmt = Database::prepare("SELECT * FROM panel_ipsandports ORDER BY ip ASC, port ASC");
		Database::pexecute($sel_stmt);
		$ips = $sel_stmt->fetchAll(PDO::FETCH_ASSOC);
		$mask = "|%-10.10s |%-50.50s | %10.10s |\n";
		printf($mask, str_repeat("-", 10), str_repeat("-", 50), str_repeat("-", 10));
		printf($mask, 'id', 'IP address', 'port');
		printf($mask, str_repeat("-", 10), str_repeat("-", 50), str_repeat("-", 10));
		foreach ($ips as $ipdata) {
			printf($mask, $ipdata['id'], $ipdata['ip'], $ipdata['port']);
		}
		printf($mask, str_repeat("-", 10), str_repeat("-", 50), str_repeat("-", 10));
		echo PHP_EOL . PHP_EOL;
	}

	private function _switchIPs()
	{
		$ip_list = $this->_args['switch'];

		if (empty($ip_list) || is_bool($ip_list)) {
			throw new Exception("No paramters given for --switch action.");
		}

		$ips_to_switch = array();
		$ip_list = explode(" ", $ip_list);
		foreach ($ip_list as $ips_combo) {
			$ip_pair = explode(",", $ips_combo);
			if (count($ip_pair) != 2) {
				throw new Exception("Invalid parameter given for --switch");
			} else {
				if (filter_var($ip_pair[0], FILTER_VALIDATE_IP) == false) {
					throw new Exception("Invalid source ip address: " . $ip_pair[0]);
				}
				if (filter_var($ip_pair[1], FILTER_VALIDATE_IP) == false) {
					throw new Exception("Invalid target ip address: " . $ip_pair[1]);
				}
				if ($ip_pair[0] == $ip_pair[1]) {
					throw new Exception("Source and target ip address are equal");
				}
			}
			$ips_to_switch[] = $ip_pair;
		}

		if (count($ips_to_switch) > 0) {
			$upd_stmt = Database::prepare("UPDATE panel_ipsandports SET `ip` = :newip WHERE `ip` = :oldip");

			// system.ipaddress
			$check_sysip_stmt = Database::prepare("SELECT `value` FROM `panel_settings` WHERE `settinggroup` = 'system' and `varname` = 'ipaddress'");
			$check_sysip = Database::pexecute_first($check_sysip_stmt);

			// system.mysql_access_host
			$check_mysqlip_stmt = Database::prepare("SELECT `value` FROM `panel_settings` WHERE `settinggroup` = 'system' and `varname` = 'mysql_access_host'");
			$check_mysqlip = Database::pexecute_first($check_mysqlip_stmt);

			// system.axfrservers
			$check_axfrip_stmt = Database::prepare("SELECT `value` FROM `panel_settings` WHERE `settinggroup` = 'system' and `varname` = 'axfrservers'");
			$check_axfrip = Database::pexecute_first($check_axfrip_stmt);

			foreach ($ips_to_switch as $ip_pair) {
				echo "Switching IP \033[1m" . $ip_pair[0] . "\033[0m to IP \033[1m" . $ip_pair[1] . "\033[0m" . PHP_EOL;
				Database::pexecute($upd_stmt, array(
					'newip' => $ip_pair[1],
					'oldip' => $ip_pair[0]
				));
				$rows_updated = $upd_stmt->rowCount();

				if ($rows_updated == 0) {
					CmdLineHandler::printwarn("Note: " . $ip_pair[0] . " not updated to " . $ip_pair[1] . " (possibly no entry found in froxlor database. Use --list to see what IP addresses are added in froxlor");
				}

				// check whether the system.ipaddress needs updating
				if ($check_sysip['value'] == $ip_pair[0]) {
					$upd2_stmt = Database::prepare("UPDATE `panel_settings` SET `value` = :newip WHERE `settinggroup` = 'system' and `varname` = 'ipaddress'");
					Database::pexecute($upd2_stmt, array(
						'newip' => $ip_pair[1]
					));
					CmdLineHandler::printsucc("Updated system-ipaddress from '" . $ip_pair[0] . "' to '" . $ip_pair[1] . "'");
				}

				// check whether the system.mysql_access_host needs updating
				if (strstr($check_mysqlip['value'], $ip_pair[0]) !== false) {
					$new_mysqlip = str_replace($ip_pair[0], $ip_pair[1], $check_mysqlip['value']);
					$upd2_stmt = Database::prepare("UPDATE `panel_settings` SET `value` = :newmysql WHERE `settinggroup` = 'system' and `varname` = 'mysql_access_host'");
					Database::pexecute($upd2_stmt, array(
						'newmysql' => $new_mysqlip
					));
					CmdLineHandler::printsucc("Updated mysql_access_host from '" . $check_mysqlip['value'] . "' to '" . $new_mysqlip . "'");
				}

				// check whether the system.axfrservers needs updating
				if (strstr($check_axfrip['value'], $ip_pair[0]) !== false) {
					$new_axfrip = str_replace($ip_pair[0], $ip_pair[1], $check_axfrip['value']);
					$upd2_stmt = Database::prepare("UPDATE `panel_settings` SET `value` = :newaxfr WHERE `settinggroup` = 'system' and `varname` = 'axfrservers'");
					Database::pexecute($upd2_stmt, array(
						'newaxfr' => $new_axfrip
					));
					CmdLineHandler::printsucc("Updated axfrservers from '" . $check_axfrip['value'] . "' to '" . $new_axfrip . "'");
				}
			}
		}

		echo PHP_EOL;
		CmdLineHandler::printwarn("*** ATTENTION *** Remember to replace IP addresses in configuration files if used anywhere.");
		CmdLineHandler::printsucc("IP addresses updated");
	}

	private function _parseConfig()
	{
		define('FROXLOR_INSTALL_DIR', $this->_args['froxlor-dir']);
		if (!file_exists(FROXLOR_INSTALL_DIR . '/lib/classes/database/class.Database.php')) {
			throw new Exception("Could not find froxlor's Database class. Is froxlor really installed to '".FROXLOR_INSTALL_DIR."'?");
		}
		if (!file_exists(FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php')) {
			throw new Exception("Could not find froxlor's userdata.inc.php file. You should use this script only with a fully installed and setup froxlor system.");
		}
		require FROXLOR_INSTALL_DIR . '/lib/classes/database/class.Database.php';
	}

	private function _checkConfigParam($needed = false)
	{
		if ($needed) {
			if (! isset($this->_args["froxlor-dir"])) {
				throw new Exception("No configuration given (missing --froxlor-dir parameter?)");
			} elseif (! is_dir($this->_args["froxlor-dir"])) {
				throw new Exception("Given --froxlor-dir parameter is not a directory");
			} elseif (! file_exists($this->_args["froxlor-dir"])) {
				throw new Exception("Given froxlor directory cannot be found ('" . $this->_args["froxlor-dir"] . "')");
			} elseif (! is_readable($this->_args["froxlor-dir"])) {
				throw new Exception("Given froxlor direcotry cannot be read ('" . $this->_args["froxlor-dir"] . "')");
			}
		}
	}
}
