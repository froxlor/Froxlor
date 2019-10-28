<?php
namespace Froxlor\Settings;

use Froxlor\Database\Database;
use Froxlor\Settings;

class Store
{

	public static function storeSettingClearCertificates($fieldname, $fielddata, $newfieldvalue)
	{
		$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

		if ($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && $fielddata['varname'] == 'le_froxlor_enabled' && $newfieldvalue == '0') {
			Database::query("
				DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` = '0'
			");
		}

		return $returnvalue;
	}

	public static function storeSettingDefaultIp($fieldname, $fielddata, $newfieldvalue)
	{
		$defaultips_old = Settings::Get('system.defaultip');

		$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

		if ($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && $fielddata['varname'] == 'defaultip') {
			self::updateStdSubdomainDefaultIp($newfieldvalue, $defaultips_old);
		}

		return $returnvalue;
	}

	public static function storeSettingDefaultSslIp($fieldname, $fielddata, $newfieldvalue)
	{
		$defaultips_old = Settings::Get('system.defaultsslip');

		$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

		if ($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && $fielddata['varname'] == 'defaultsslip') {
			self::updateStdSubdomainDefaultIp($newfieldvalue, $defaultips_old);
		}

		return $returnvalue;
	}

	private static function updateStdSubdomainDefaultIp($newfieldvalue, $defaultips_old)
	{
		// update standard-subdomain of customer if exists
		$customerstddomains_result_stmt = Database::prepare("
			SELECT `standardsubdomain` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `standardsubdomain` <> '0'
		");
		Database::pexecute($customerstddomains_result_stmt);

		$ids = array();
		while ($customerstddomains_row = $customerstddomains_result_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$ids[] = (int) $customerstddomains_row['standardsubdomain'];
		}

		if (count($ids) > 0) {
			$defaultips_new = explode(',', $newfieldvalue);

			if (! empty($defaultips_old) && ! empty($newfieldvalue)) {
				$in_value = $defaultips_old . ", " . $newfieldvalue;
			} elseif (! empty($defaultips_old) && empty($newfieldvalue)) {
				$in_value = $defaultips_old;
			} else {
				$in_value = $newfieldvalue;
			}

			// Delete the existing mappings linking to default IPs
			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_DOMAINTOIP . "`
				WHERE `id_domain` IN (" . implode(', ', $ids) . ")
				AND `id_ipandports` IN (" . $in_value . ")
			");
			Database::pexecute($del_stmt);

			if (count($defaultips_new) > 0) {
				// Insert the new mappings
				$ins_stmt = Database::prepare("
					INSERT INTO `" . TABLE_DOMAINTOIP . "`
					SET `id_domain` = :domainid, `id_ipandports` = :ipandportid
				");

				foreach ($ids as $id) {
					foreach ($defaultips_new as $defaultip_new) {
						Database::pexecute($ins_stmt, array(
							'domainid' => $id,
							'ipandportid' => $defaultip_new
						));
					}
				}
			}
		}
	}

	/**
	 * updates the setting for the default panel-theme
	 * and also the user themes (customers and admins) if
	 * the changing of themes is disallowed for them
	 *
	 * @param string $fieldname
	 * @param array $fielddata
	 * @param mixed $newfieldvalue
	 *
	 * @return boolean|array
	 */
	public static function storeSettingDefaultTheme($fieldname, $fielddata, $newfieldvalue)
	{
		// first save the setting itself
		$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

		if ($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'panel' && isset($fielddata['varname']) && $fielddata['varname'] == 'default_theme') {
			// now, if changing themes is disabled we manually set
			// the new theme (customers and admin, depending on settings)
			if (Settings::Get('panel.allow_theme_change_customer') == '0') {
				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `theme` = :theme
				");
				Database::pexecute($upd_stmt, array(
					'theme' => $newfieldvalue
				));
			}
			if (Settings::Get('panel.allow_theme_change_admin') == '0') {
				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_ADMINS . "` SET `theme` = :theme
				");
				Database::pexecute($upd_stmt, array(
					'theme' => $newfieldvalue
				));
			}
		}

		return $returnvalue;
	}

	public static function storeSettingField($fieldname, $fielddata, $newfieldvalue)
	{
		if (is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] != '' && isset($fielddata['varname']) && $fielddata['varname'] != '') {
			if (Settings::Set($fielddata['settinggroup'] . '.' . $fielddata['varname'], $newfieldvalue) !== false) {
				/*
				 * when fielddata[cronmodule] is set, this means enable/disable a cronjob
				 */
				if (isset($fielddata['cronmodule']) && $fielddata['cronmodule'] != '') {
					\Froxlor\System\Cronjob::toggleCronStatus($fielddata['cronmodule'], $newfieldvalue);
				}

				/*
				 * satisfy dependencies
				 */
				if (isset($fielddata['dependency']) && is_array($fielddata['dependency'])) {
					if ((int) $fielddata['dependency']['onlyif'] == (int) $newfieldvalue) {
						self::storeSettingField($fielddata['dependency']['fieldname'], $fielddata['dependency']['fielddata'], $newfieldvalue);
					}
				}

				return array(
					$fielddata['settinggroup'] . '.' . $fielddata['varname'] => $newfieldvalue
				);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function storeSettingFieldInsertBindTask($fieldname, $fielddata, $newfieldvalue)
	{
		// first save the setting itself
		$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

		if ($returnvalue !== false) {
			\Froxlor\System\Cronjob::inserttask('4');
		}
		return false;
	}

	public static function storeSettingHostname($fieldname, $fielddata, $newfieldvalue)
	{
		$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

		if ($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && ($fielddata['varname'] == 'hostname' || $fielddata['varname'] == 'stdsubdomain')) {
			$idna_convert = new \Froxlor\Idna\IdnaWrapper();
			$newfieldvalue = $idna_convert->encode($newfieldvalue);

			if (($fielddata['varname'] == 'hostname' && Settings::Get('system.stdsubdomain') == '') || $fielddata['varname'] == 'stdsubdomain') {
				if ($fielddata['varname'] == 'stdsubdomain' && $newfieldvalue == '') {
					// clear field, reset stdsubdomain to system-hostname
					$oldhost = $idna_convert->encode(Settings::Get('system.stdsubdomain'));
					$newhost = $idna_convert->encode(Settings::Get('system.hostname'));
				} elseif ($fielddata['varname'] == 'stdsubdomain' && Settings::Get('system.stdsubdomain') == '') {
					// former std-subdomain was system-hostname
					$oldhost = $idna_convert->encode(Settings::Get('system.hostname'));
					$newhost = $newfieldvalue;
				} elseif ($fielddata['varname'] == 'stdsubdomain') {
					// std-subdomain just changed
					$oldhost = $idna_convert->encode(Settings::Get('system.stdsubdomain'));
					$newhost = $newfieldvalue;
				} elseif ($fielddata['varname'] == 'hostname' && Settings::Get('system.stdsubdomain') == '') {
					// system-hostname has changed and no system-stdsubdomain is not set
					$oldhost = $idna_convert->encode(Settings::Get('system.hostname'));
					$newhost = $newfieldvalue;
				}

				$customerstddomains_result_stmt = Database::prepare("
					SELECT `standardsubdomain` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `standardsubdomain` <> '0'
				");
				Database::pexecute($customerstddomains_result_stmt);

				$ids = array();

				while ($customerstddomains_row = $customerstddomains_result_stmt->fetch(\PDO::FETCH_ASSOC)) {
					$ids[] = (int) $customerstddomains_row['standardsubdomain'];
				}

				if (count($ids) > 0) {
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
						`domain` = REPLACE(`domain`, :host, :newval)
						WHERE `id` IN ('" . implode(', ', $ids) . "')
					");
					Database::pexecute($upd_stmt, array(
						'host' => $oldhost,
						'newval' => $newhost
					));
				}
			}
		}

		return $returnvalue;
	}

	public static function storeSettingIpAddress($fieldname, $fielddata, $newfieldvalue)
	{
		$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

		if ($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && $fielddata['varname'] == 'ipaddress') {
			$mysql_access_host_array = array_map('trim', explode(',', Settings::Get('system.mysql_access_host')));
			$mysql_access_host_array[] = $newfieldvalue;
			$mysql_access_host_array = array_unique(\Froxlor\PhpHelper::arrayTrim($mysql_access_host_array));
			$mysql_access_host = implode(',', $mysql_access_host_array);
			\Froxlor\Database\DbManager::correctMysqlUsers($mysql_access_host_array);
			Settings::Set('system.mysql_access_host', $mysql_access_host);
		}

		return $returnvalue;
	}

	public static function storeSettingMysqlAccessHost($fieldname, $fielddata, $newfieldvalue)
	{
		$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

		if ($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && $fielddata['varname'] == 'mysql_access_host') {
			$mysql_access_host_array = array_map('trim', explode(',', $newfieldvalue));

			if (in_array('127.0.0.1', $mysql_access_host_array) && ! in_array('localhost', $mysql_access_host_array)) {
				$mysql_access_host_array[] = 'localhost';
			}

			if (! in_array('127.0.0.1', $mysql_access_host_array) && in_array('localhost', $mysql_access_host_array)) {
				$mysql_access_host_array[] = '127.0.0.1';
			}

			// be aware that ipv6 addresses are enclosed in [ ] when passed here
			$mysql_access_host_array = array_map(array(
				'\\Froxlor\\Settings\\Store',
				'cleanMySQLAccessHost'
			), $mysql_access_host_array);

			$mysql_access_host_array = array_unique($mysql_access_host_array);
			$newfieldvalue = implode(',', $mysql_access_host_array);
			\Froxlor\Database\DbManager::correctMysqlUsers($mysql_access_host_array);
		}

		return $returnvalue;
	}

	private static function cleanMySQLAccessHost($value)
	{
		if (substr($value, 0, 1) == '[' && substr($value, - 1) == ']') {
			return substr($value, 1, - 1);
		}
		return $value;
	}

	public static function storeSettingResetCatchall($fieldname, $fielddata, $newfieldvalue)
	{
		$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

		if ($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'catchall' && isset($fielddata['varname']) && $fielddata['varname'] == 'catchall_enabled' && $newfieldvalue == '0') {
			Database::query("
				UPDATE `" . TABLE_MAIL_VIRTUAL . "` SET `iscatchall` = '0' WHERE `iscatchall` = '1'
			");
		}

		return $returnvalue;
	}

	/**
	 * Whenever the webserver- / FCGID- or FPM-user gets updated
	 * we need to update ftp_groups accordingly
	 */
	public static function storeSettingWebserverFcgidFpmUser($fieldname, $fielddata, $newfieldvalue)
	{
		if (is_array($fielddata) && isset($fielddata['settinggroup']) && isset($fielddata['varname'])) {

			$update_user = null;

			// webserver
			if ($fielddata['settinggroup'] == 'system' && $fielddata['varname'] == 'httpuser') {
				$update_user = Settings::Get('system.httpuser');
			}

			// fcgid
			if ($fielddata['settinggroup'] == 'system' && $fielddata['varname'] == 'mod_fcgid_httpuser') {
				$update_user = Settings::Get('system.mod_fcgid_httpuser');
			}

			// webserver
			if ($fielddata['settinggroup'] == 'phpfpm' && $fielddata['varname'] == 'vhost_httpuser') {
				$update_user = Settings::Get('phpfpm.vhost_httpuser');
			}

			$returnvalue = self::storeSettingField($fieldname, $fielddata, $newfieldvalue);

			if ($returnvalue !== false) {
				/**
				 * only update if anything changed
				 */
				if ($update_user != null && $newfieldvalue != $update_user) {
					$upd_stmt = Database::prepare("UPDATE `" . TABLE_FTP_GROUPS . "` SET `members` = REPLACE(`members`, :olduser, :newuser)");
					Database::pexecute($upd_stmt, array(
						'olduser' => $update_user,
						'newuser' => $newfieldvalue
					));
				}
			}
		}

		return $returnvalue;
	}
}
