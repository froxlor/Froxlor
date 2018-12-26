<?php
namespace Froxlor\Cli\Action;

use Froxlor\Database\Database;
use Froxlor\Cli\SwitchServerIpCmd;

class SwitchServerIpAction extends \Froxlor\Cli\Action
{

	public function __construct($args)
	{
		parent::__construct($args);
	}

	public function run()
	{
		$this->validate();
	}

	/**
	 * validates the parsed command line parameters
	 *
	 * @throws \Exception
	 */
	private function validate()
	{
		$need_config = false;
		if (array_key_exists("list", $this->_args) || array_key_exists("switch", $this->_args)) {
			$need_config = true;
		}

		$this->checkConfigParam($need_config);

		$this->parseConfig();

		if (array_key_exists("list", $this->_args)) {
			$this->listIPs();
		}
		if (array_key_exists("switch", $this->_args)) {
			$this->switchIPs();
		}
	}

	private function listIPs()
	{
		$sel_stmt = Database::prepare("SELECT * FROM panel_ipsandports ORDER BY ip ASC, port ASC");
		Database::pexecute($sel_stmt);
		$ips = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
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

	private function switchIPs()
	{
		$ip_list = $this->_args['switch'];

		if (empty($ip_list) || is_bool($ip_list)) {
			throw new \Exception("No paramters given for --switch action.");
		}

		$ips_to_switch = array();
		$ip_list = explode(" ", $ip_list);
		foreach ($ip_list as $ips_combo) {
			$ip_pair = explode(",", $ips_combo);
			if (count($ip_pair) != 2) {
				throw new \Exception("Invalid parameter given for --switch");
			} else {
				if (filter_var($ip_pair[0], FILTER_VALIDATE_IP) == false) {
					throw new \Exception("Invalid source ip address: " . $ip_pair[0]);
				}
				if (filter_var($ip_pair[1], FILTER_VALIDATE_IP) == false) {
					throw new \Exception("Invalid target ip address: " . $ip_pair[1]);
				}
				if ($ip_pair[0] == $ip_pair[1]) {
					throw new \Exception("Source and target ip address are equal");
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

				$ip_check = Database::pexecute_first($check_stmt, array(
					'newip' => $ip_pair[1]
				));
				if ($ip_check) {
					SwitchServerIpCmd::printwarn("Note: " . $ip_pair[0] . " not updated to " . $ip_pair[1] . " - IP already exists in froxlor's database");
					continue;
				}

				Database::pexecute($upd_stmt, array(
					'newip' => $ip_pair[1],
					'oldip' => $ip_pair[0]
				));
				$rows_updated = $upd_stmt->rowCount();

				if ($rows_updated == 0) {
					SwitchServerIpCmd::printwarn("Note: " . $ip_pair[0] . " not updated to " . $ip_pair[1] . " (possibly no entry found in froxlor database. Use --list to see what IP addresses are added in froxlor");
				}

				// check whether the system.ipaddress needs updating
				if ($check_sysip['value'] == $ip_pair[0]) {
					$upd2_stmt = Database::prepare("UPDATE `panel_settings` SET `value` = :newip WHERE `settinggroup` = 'system' and `varname` = 'ipaddress'");
					Database::pexecute($upd2_stmt, array(
						'newip' => $ip_pair[1]
					));
					SwitchServerIpCmd::printsucc("Updated system-ipaddress from '" . $ip_pair[0] . "' to '" . $ip_pair[1] . "'");
				}

				// check whether the system.mysql_access_host needs updating
				if (strstr($check_mysqlip['value'], $ip_pair[0]) !== false) {
					$new_mysqlip = str_replace($ip_pair[0], $ip_pair[1], $check_mysqlip['value']);
					$upd2_stmt = Database::prepare("UPDATE `panel_settings` SET `value` = :newmysql WHERE `settinggroup` = 'system' and `varname` = 'mysql_access_host'");
					Database::pexecute($upd2_stmt, array(
						'newmysql' => $new_mysqlip
					));
					SwitchServerIpCmd::printsucc("Updated mysql_access_host from '" . $check_mysqlip['value'] . "' to '" . $new_mysqlip . "'");
				}

				// check whether the system.axfrservers needs updating
				if (strstr($check_axfrip['value'], $ip_pair[0]) !== false) {
					$new_axfrip = str_replace($ip_pair[0], $ip_pair[1], $check_axfrip['value']);
					$upd2_stmt = Database::prepare("UPDATE `panel_settings` SET `value` = :newaxfr WHERE `settinggroup` = 'system' and `varname` = 'axfrservers'");
					Database::pexecute($upd2_stmt, array(
						'newaxfr' => $new_axfrip
					));
					SwitchServerIpCmd::printsucc("Updated axfrservers from '" . $check_axfrip['value'] . "' to '" . $new_axfrip . "'");
				}
			}
		}

		echo PHP_EOL;
		SwitchServerIpCmd::printwarn("*** ATTENTION *** Remember to replace IP addresses in configuration files if used anywhere.");
		SwitchServerIpCmd::printsucc("IP addresses updated");
	}

	private function parseConfig()
	{
		define('FROXLOR_INSTALL_DIR', $this->_args['froxlor-dir']);
		if (! class_exists('\\Froxlor\\Database\\Database')) {
			throw new \Exception("Could not find froxlor's Database class. Is froxlor really installed to '" . FROXLOR_INSTALL_DIR . "'?");
		}
		if (! file_exists(FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php')) {
			throw new \Exception("Could not find froxlor's userdata.inc.php file. You should use this script only with a fully installed and setup froxlor system.");
		}
	}

	private function checkConfigParam($needed = false)
	{
		if ($needed) {
			if (! isset($this->_args["froxlor-dir"])) {
				$this->_args["froxlor-dir"] = \Froxlor\Froxlor::getInstallDir();
			} elseif (! is_dir($this->_args["froxlor-dir"])) {
				throw new \Exception("Given --froxlor-dir parameter is not a directory");
			} elseif (! file_exists($this->_args["froxlor-dir"])) {
				throw new \Exception("Given froxlor directory cannot be found ('" . $this->_args["froxlor-dir"] . "')");
			} elseif (! is_readable($this->_args["froxlor-dir"])) {
				throw new \Exception("Given froxlor direcotry cannot be read ('" . $this->_args["froxlor-dir"] . "')");
			}
		}
	}
}
