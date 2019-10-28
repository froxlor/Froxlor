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
class SwitchServerIpCmd extends CmdLineHandler
{

	/**
	 * list of valid switches
	 *
	 * @var array
	 */
	public static $switches = array(
		'h'
	);

	/**
	 * list of valid parameters
	 *
	 * @var array
	 */
	public static $params = array(
		'switch',
		'list',
		'froxlor-dir',
		'help'
	);

	public static $action_class = '\\Froxlor\\Cli\\Action\\SwitchServerIpAction';

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
}
