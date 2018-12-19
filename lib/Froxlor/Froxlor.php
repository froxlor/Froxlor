<?php
namespace Froxlor;

final class Froxlor
{

	// Main version variable
	const VERSION = '0.10.0';

	// Database version (YYYYMMDDC where C is a daily counter)
	const DBVERSION = '201812170';

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
}
