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
class ConfigServicesCmd extends CmdLineHandler
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
		'create',
		'apply',
		'import-settings',
		'daemon',
		'list-daemons',
		'froxlor-dir',
		'help'
	);

	public static $action_class = '\\Froxlor\\Cli\\Action\\ConfigServicesAction';

	public static function printHelp()
	{
		self::println("");
		self::println("Help / command line parameters:");
		self::println("");
		// commands
		self::println("--create\t\tlets you create a services list configuration for the 'apply' command");
		self::println("");
		self::println("--apply\t\t\tconfigure your services by given configuration file. To create one run the --create command");
		self::println("\t\t\tExample: --apply=/path/to/my-config.json or --apply=http://domain.tld/my-config.json");
		self::println("");
		self::println("--list-daemons\t\tOutput the services that are going to be configured using a given config file. No services will be configured.");
		self::println("\t\t\tExample: --apply=/path/to/my-config.json --list-daemons");
		self::println("");
		self::println("--daemon\t\tWhen running --apply you can specify a daemon. This will be the only service that gets configured");
		self::println("\t\t\tExample: --apply=/path/to/my-config.json --daemon=apache24");
		self::println("");
		self::println("--import-settings\tImport settings from another froxlor installation. This should be done prior to running --apply or alternatively in the same command together.");
		self::println("\t\t\tExample: --import-settings=/path/to/Froxlor_settings-[version]-[dbversion]-[date].json or --import-settings=http://domain.tld/Froxlor_settings-[version]-[dbversion]-[date].json");
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
