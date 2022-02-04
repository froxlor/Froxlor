<?php
namespace Froxlor;

use Froxlor\Database\Database;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2018 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <d00p@froxlor.org>
 * @author Froxlor team <team@froxlor.org> (2018-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Classes
 *
 * @since 0.9.39
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
	private static $no_export = [
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
		'system.defaultsslip',
		'system.last_tasks_run',
		'system.last_archive_run',
		'system.leprivatekey',
		'system.lepublickey'
	];

	public static function export()
	{
	    $settings_definitions = [];
	    foreach (\Froxlor\PhpHelper::loadConfigArrayDir('./actions/admin/settings/')['groups'] AS $group) {
            foreach ($group['fields'] AS $field) {
                $settings_definitions[$field['settinggroup']][$field['varname']] = $field;
            }
        }

		$result_stmt = Database::query("
			SELECT * FROM `" . TABLE_PANEL_SETTINGS . "` ORDER BY `settingid` ASC
		");
		$_data = array();
		while ($row = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$index = $row['settinggroup'] . "." . $row['varname'];
			if (! in_array($index, self::$no_export)) {
				$_data[$index] = $row['value'];
			}

			if (array_key_exists($row['settinggroup'], $settings_definitions) && array_key_exists($row['varname'], $settings_definitions[$row['settinggroup']])) {
			    // Export image file
			    if ($settings_definitions[$row['settinggroup']][$row['varname']]['type'] === "image") {
			        if ($row['value'] === "") {
			            continue;
                    }

			        $_data[$index.'.image_data'] = base64_encode(file_get_contents(explode('?', $row['value'], 2)[0]));
                }
            }
		}

		// add checksum for validation
		$_data['_sha'] = sha1(var_export($_data, true));
		$_export = json_encode($_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		if (! $_export) {
			throw new \Exception("Error exporting settings: " . json_last_error_msg());
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
				throw new \Exception("Invalid froxlor settings data. Unable to import.");
			}
			// validate import file
			unset($_data['_sha']);
			// compare
			if ($_sha != sha1(var_export($_data, true))) {
				throw new \Exception("SHA check of import data failed. Unable to import.");
			}
			// do not import version info - but we need that to possibly update settings
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
                $index_split = explode('.', $index, 3);

			    // Catch image_data and save it
                if (isset($index_split[2]) && $index_split[2] === 'image_data' && !empty($_data[$index_split[0].'.'.$index_split[1]])) {
                    $path = \Froxlor\Froxlor::getInstallDir().'/img/';
                    if (!is_dir($path) && !mkdir($path, 0775)) {
                        throw new \Exception("img directory does not exist and cannot be created");
                    }

                    // Make sure we can write to the upload directory
                    if (!is_writable($path)) {
                        if (!chmod($path, 0775)) {
                            throw new \Exception("Cannot write to img directory");
                        }
                    }

                    file_put_contents(\Froxlor\Froxlor::getInstallDir() . '/' . explode('?', $_data[$index_split[0].'.'.$index_split[1]], 2)[0], base64_decode($value));
                    continue;
                }

				Settings::Set($index, $value);
			}
			// save to DB
			Settings::Flush();
			// all good
			return true;
		}
		throw new \Exception("Invalid JSON data: " . json_last_error_msg());
	}
}
