<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2018 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <d00p@froxlor.org>
 * @author     Froxlor team <team@froxlor.org> (2018-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 * @since      0.9.39
 *
 */

/**
 * Class SImExporter
 *
 * Import/Export settings to JSON
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <d00p@froxlor.org>
 * @author Froxlor team <team@froxlor.org> (2018-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Classes
 */
class SImExporter
{

	/**
	 * settings which are not being exported
	 *
	 * @var array
	 */
	private static $_no_export = [
		'panel.adminmail',
		'admin.show_news_feed',
		'system.lastaccountnumber',
		'system.lastguid',
		'system.ipaddress',
		'system.last_traffic_run',
		'system.hostname',
		'system.mysql_access_host',
		'system.lastcronrun',
		'system.defaultip',
		'system.defaultsslip'.
		'system.last_tasks_run',
		'system.last_archive_run',
		'system.leprivatekey',
		'system.lepublickey'
	];

	public static function export()
	{
		$result_stmt = Database::query("
			SELECT * FROM `" . TABLE_PANEL_SETTINGS . "` ORDER BY `settingid` ASC
		");
		$_data = array();
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$index = $row['settinggroup'] . "." . $row['varname'];
			if (! in_array($index, self::$_no_export)) {
				$_data[$index] = $row['value'];
			}
		}
		// add checksum for validation
		$_data['_sha'] = sha1(var_export($_data, true));
		$_export = json_encode($_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		if (! $_export) {
			throw new Exception("Error exporting settings: " . json_last_error_msg());
		}
		return $_export;
	}

	public static function import($json_str = null)
	{
		// decode data
		$_data = json_decode($json_str, true);
		if ($_data) {
			// get validity check data
			$_sha = isset($_data['_sha']) ? $_data['_sha'] : false;
			$_version = isset($_data['panel.version']) ? $_data['panel.version'] : false;
			$_dbversion = isset($_data['panel.db_version']) ? $_data['panel.db_version'] : false;
			// check if we have everything we need
			if (! $_sha || ! $_version || ! $_dbversion) {
				throw new Exception("Invalid froxlor settings data. Unable to import.");
			}
			// validate import file
			unset($_data['_sha']);
			// compare
			if ($_sha != sha1(var_export($_data, true))) {
				throw new Exception("SHA check of import data failed. Unable to import.");
			}
			// do not import version info - but we need that to possibily update settings
			// when there were changes in the variable-name or similar
			unset($_data['panel.version']);
			unset($_data['panel.db_version']);
			// validate we got ssl enabled ips when ssl is enabled
			// otherwise deactivate it
			if ($_data['system.use_ssl'] == 1) {
				$result_ssl_ipsandports_stmt = Database::prepare("
					SELECT COUNT(*) as count_ssl_ip FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='1'
				");
				$result = Database::pexecute_first($result_ssl_ipsandports_stmt);
				if ($result['count_ssl_ip'] <= 0) {
					// no ssl-ip -> deactivate
					$_data['system.use_ssl'] = 0;
					// deactivate other ssl-related settings
					$_data['system.leenabled'] = 0;
					$_data['system.le_froxlor_enabled'] = 0;
					$_data['system.le_froxlor_redirect'] = 0;
				}
			}
			// store new data
			foreach ($_data as $index => $value) {
				Settings::Set($index, $value);
			}
			// save to DB
			Settings::Flush();
			// all good
			return true;
		}
		throw new Exception("Invalid JSON data: " . json_last_error_msg());
	}
}
