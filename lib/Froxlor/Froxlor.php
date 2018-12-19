<?php
namespace Froxlor;

use Froxlor\Database\Database;

final class Froxlor
{

	// Main version variable
	const VERSION = '0.10.0';

	// Database version (YYYYMMDDC where C is a daily counter)
	const DBVERSION = '201812190';

	// Distribution branding-tag (used for Debian etc.)
	const BRANDING = '';

	/**
	 * return path to where froxlor is installed, e.g.
	 * /var/www/froxlor
	 *
	 * @return string
	 */
	public static function getInstallDir()
	{
		return dirname(dirname(__DIR__));
	}

	/**
	 * return basic version
	 *
	 * @return string
	 */
	public static function getVersion()
	{
		return self::VERSION;
	}

	/**
	 * return version + branding
	 *
	 * @return string
	 */
	public static function getFullVersion()
	{
		return self::VERSION . self::BRANDING;
	}

	/**
	 * return version + branding and database-version
	 *
	 * @return string
	 */
	public static function getVersionString()
	{
		return self::getFullVersion() . ' (' . self::DBVERSION . ')';
	}

	/**
	 * Function hasUpdates
	 *
	 * checks if a given version is not equal the current one
	 *
	 * @param string $to_check
	 *        	version to check, if empty current version is used
	 *        	
	 * @return bool true if version to check does not match, else false
	 */
	public static function hasUpdates($to_check = null)
	{
		if (empty($to_check)) {
			$to_check = self::VERSION;
		}
		if (Settings::Get('panel.version') == null || Settings::Get('panel.version') != $to_check) {
			return true;
		}
		return false;
	}

	/**
	 * Function hasUpdates
	 *
	 * checks if a given database-version is not equal the current one
	 *
	 * @param int $to_check
	 *        	version to check, if empty current dbversion is used
	 *        	
	 * @return bool true if version to check does not match, else false
	 */
	public static function hasDbUpdates($to_check = null)
	{
		if (empty($to_check)) {
			$to_check = self::DBVERSION;
		}
		if (Settings::Get('panel.db_version') == null || Settings::Get('panel.db_version') != $to_check) {
			return true;
		}
		return false;
	}

	/**
	 * Function isDatabaseVersion
	 *
	 * checks if a given database-version is the current one
	 *
	 * @param int $to_check
	 *        	version to check
	 *        	
	 * @return bool true if version to check matches, else false
	 */
	public static function isDatabaseVersion($to_check = null)
	{
		if (Settings::Get('panel.frontend') == 'froxlor' && Settings::Get('panel.db_version') == $to_check) {
			return true;
		}
		return false;
	}

	/**
	 * Function updateToDbVersion
	 *
	 * updates the panel.version field
	 * to the given value (no checks here!)
	 *
	 * @param string $new_version
	 *        	new-version
	 *        	
	 * @return bool true on success, else false
	 */
	public static function updateToDbVersion($new_version = null)
	{
		if ($new_version !== null && $new_version != '') {
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = :newversion
				WHERE `settinggroup` = 'panel' AND `varname` = 'db_version'");
			Database::pexecute($upd_stmt, array(
				'newversion' => $new_version
			));
			Settings::Set('panel.db_version', $new_version);
			return true;
		}
		return false;
	}

	/**
	 * Function updateToVersion
	 *
	 * updates the panel.version field
	 * to the given value (no checks here!)
	 *
	 * @param string $new_version
	 *        	new-version
	 *        	
	 * @return bool true on success, else false
	 */
	public static function updateToVersion($new_version = null)
	{
		if ($new_version !== null && $new_version != '') {
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = :newversion
				WHERE `settinggroup` = 'panel' AND `varname` = 'version'");
			Database::pexecute($upd_stmt, array(
				'newversion' => $new_version
			));
			Settings::Set('panel.version', $new_version);
			return true;
		}
		return false;
	}

	/**
	 * Function isFroxlor
	 *
	 * checks if the panel is froxlor
	 *
	 * @return bool true if panel is froxlor, else false
	 */
	public static function isFroxlor()
	{
		if (Settings::Get('panel.frontend') !== null && Settings::Get('panel.frontend') == 'froxlor') {
			return true;
		}
		return false;
	}

	/**
	 * Function isFroxlorVersion
	 *
	 * checks if a given version is the
	 * current one (and panel is froxlor)
	 *
	 * @param string $to_check
	 *        	version to check
	 *        	
	 * @return bool true if version to check matches, else false
	 */
	public static function isFroxlorVersion($to_check = null)
	{
		if (Settings::Get('panel.frontend') == 'froxlor' && Settings::Get('panel.version') == $to_check) {
			return true;
		}
		return false;
	}
}
