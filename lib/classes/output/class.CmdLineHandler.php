<?php declare(strict_types=1);
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
     * @var Action
     */
    private $_action = null;

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
            if (substr($a, 0, 2) === '--') {
                $eq = strpos($a, '=');
                if ($eq !== false) {
                    $o[substr($a, 2, $eq - 2)] = substr($a, $eq + 1);
                } else {
                    $k = substr($a, 2);
                    if (! isset($o[$k])) {
                        $o[$k] = true;
                    }
                }
            } elseif (substr($a, 0, 1) === '-') {
                if (substr($a, 2, 1) === '=') {
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
     * @throws Exception
     * @return Action
     */
    private function _createAction()
    {
        
        // Test for help-switch
        if (empty(self::$args) || array_key_exists('help', self::$args) || array_key_exists('h', self::$args)) {
            static::printHelp();
            // end of execution
        }
        // check if no unknown parameters are present
        foreach (self::$args as $arg => $value) {
            if (is_numeric($arg)) {
                throw new Exception("Unknown parameter '" . $value . "' in argument list");
            } elseif (! in_array($arg, static::$params, true) && ! in_array($arg, static::$switches, true)) {
                throw new Exception("Unknown parameter '" . $arg . "' in argument list");
            }
        }
        
        // set debugger switch
        if (isset(self::$args['d']) && self::$args['d'] === true) {
            // Debugger::getInstance()->setEnabled(true);
            // Debugger::getInstance()->debug("debug output enabled");
        }
        
        return new static::$action_class(self::$args);
    }

    public static function getInput($prompt = '#', $default = '')
    {
        if (! empty($default)) {
            $prompt .= ' [' . $default . ']';
        }
        $result = readline($prompt . ':');
        if (empty($result) && ! empty($default)) {
            $result = $default;
        }

        return mb_strtolower($result);
    }

    public static function println($msg = '')
    {
        print $msg . PHP_EOL;
    }

    private static function _printcolor($msg = '', $color = '0')
    {
        print "\033[" . $color . 'm' . $msg . "\033[0m" . PHP_EOL;
    }

    public static function printerr($msg = '')
    {
        self::_printcolor($msg, '31');
    }

    public static function printsucc($msg = '')
    {
        self::_printcolor($msg, '32');
    }

    public static function printwarn($msg = '')
    {
        self::_printcolor($msg, '33');
    }
}
