<?php

namespace Froxlor\Cli;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2022 the Froxlor Team (see authors).
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
class PhpSessioncleanCmd extends CmdLineHandler
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
		'froxlor-dir',
		'max-lifetime',
		'help'
	);

	public static $action_class = '\\Froxlor\\Cli\\Action\\PhpSessioncleanAction';

	public static function printHelp()
	{
		self::println("");
		self::println("Help / command line parameters:");
		self::println("");
		// commands
		self::println("--froxlor-dir\t\tpath to froxlor installation");
		self::println("\t\t\tExample: --froxlor-dir=/var/www/froxlor/");
		self::println("");
		self::println("--max-lifetime\t\tThe number of seconds after which data will be seen as 'garbage' and potentially cleaned up. Defaults to '1440'");
		self::println("\t\t\tExample: --max-lifetime=2000");
		self::println("");
		self::println("--help\t\t\tshow help screen (this)");
		self::println("");
		// switches
		self::println("-h\t\t\tsame as --help");
		self::println("");

		die(); // end of execution
	}
}
