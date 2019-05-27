<?php
namespace Froxlor;

use Froxlor\Database\Database;

final class Froxlor
{

	// Main version variable
	const VERSION = '0.10.0-rc2';

	// Database version (YYYYMMDDC where C is a daily counter)
	const DBVERSION = '201904250';

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
		return dirname(dirname(__DIR__)) . '/';
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

	/**
	 * compare of froxlor versions
	 *
	 * @param string $a
	 * @param string $b
	 *
	 * @return integer 0 if equal, 1 if a>b and -1 if b>a
	 */
	public static function versionCompare2($a, $b)
	{

		// split version into pieces and remove trailing .0
		$a = explode(".", $a);
		$b = explode(".", $b);

		self::parseVersionArray($a);
		self::parseVersionArray($b);

		while (count($a) != count($b)) {
			if (count($a) < count($b)) {
				$a[] = '0';
			} elseif (count($b) < count($a)) {
				$b[] = '0';
			}
		}

		foreach ($a as $depth => $aVal) {
			// iterate over each piece of A
			if (isset($b[$depth])) {
				// if B matches A to this depth, compare the values
				if ($aVal > $b[$depth]) {
					return 1; // A > B
				} elseif ($aVal < $b[$depth]) {
					return - 1; // B > A
				}
				// an equal result is inconclusive at this point
			} else {
				// if B does not match A to this depth, then A comes after B in sort order
				return 1; // so A > B
			}
		}
		// at this point, we know that to the depth that A and B extend to, they are equivalent.
		// either the loop ended because A is shorter than B, or both are equal.
		return (count($a) < count($b)) ? - 1 : 0;
	}

	private static function parseVersionArray(&$arr = null)
	{
		// -svn or -dev or -rc ?
		if (stripos($arr[count($arr) - 1], '-') !== false) {
			$x = explode("-", $arr[count($arr) - 1]);
			$arr[count($arr) - 1] = $x[0];
			if (stripos($x[1], 'rc') !== false) {
				$arr[] = '-1';
				$arr[] = '2'; // rc > dev > svn
				              // number of rc
				$arr[] = substr($x[1], 2);
			} elseif (stripos($x[1], 'dev') !== false) {
				$arr[] = '-1';
				$arr[] = '1'; // svn < dev < rc
				              // number of dev
				$arr[] = substr($x[1], 3);
			} elseif (stripos($x[1], 'svn') !== false) {
				// -svn version are deprecated
				$arr[] = '-1';
				// svn < dev < rc
				$arr[] = '0';
				// number of svn
				$arr[] = substr($x[1], 3);
			}
		}
	}
}
