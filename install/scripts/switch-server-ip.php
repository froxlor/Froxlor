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
if (@php_sapi_name() !== 'cli') {
	die('This script will only work in the shell.');
}

require dirname(dirname(__DIR__)) . '/lib/classes/output/class.CmdLineHandler.php';

class SwitchServerIp extends CmdLineHandler
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

	public static $action_class = 'Action';

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
			$check_stmt = Database::prepare("SELECT `id` FROM panel_ipsandports WHERE `ip` = :newip");
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

				$ip_check = Database::pexecute_first($check_stmt, array('newip' => $ip_pair[1]));
				if ($ip_check) {
					CmdLineHandler::printwarn("Note: " . $ip_pair[0] . " not updated to " . $ip_pair[1] . " - IP already exists in froxlor's database");
					continue;
				}

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
		if (! file_exists(FROXLOR_INSTALL_DIR . '/lib/classes/database/class.Database.php')) {
			throw new Exception("Could not find froxlor's Database class. Is froxlor really installed to '" . FROXLOR_INSTALL_DIR . "'?");
		}
		if (! file_exists(FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php')) {
			throw new Exception("Could not find froxlor's userdata.inc.php file. You should use this script only with a fully installed and setup froxlor system.");
		}
		require FROXLOR_INSTALL_DIR . '/lib/functions/filedir/function.makeSecurePath.php';
		require FROXLOR_INSTALL_DIR . '/lib/functions/filedir/function.makeCorrectDir.php';
		require FROXLOR_INSTALL_DIR . '/lib/functions/filedir/function.makeCorrectFile.php';
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

// give control to command line handler
try {
	SwitchServerIp::processParameters($argc, $argv);
} catch (Exception $e) {
	SwitchServerIp::printerr($e->getMessage());
}
