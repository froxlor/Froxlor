<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 * @since      0.9.31
 *
 */

/**
 * Class Settings
 *
 * Interaction with settings from the db
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 * 
 * @method static mixed Get ($setting = null) return a setting-value by its group and varname separated by a dot (group.varname)
 * @method static boolean Set ($setting = null, $value = null, $instant_save = true) update a setting / set a new value
 * @method static boolean IsInList ($setting = null, $entry = null) tests if a setting-value that i s a comma separated list contains an entry
 * @method static boolean AddNew ($setting = null, $value = null) add a new setting to the database (mainly used in updater)
 * @method static boolean Flush () Store all un-saved changes to the database and re-read in all settings
 * @method static void Stash () forget all un-saved changes to settings
 */
class Settings {

	/**
	 * current settings object
	 *
	 * @var object
	 */
	private static $_obj = null;

	/**
	 * settings data
	 *
	 * @var array
	 */
	private static $_data = null;

	/**
	 * changed and unsaved settings data
	 *
	 * @var array
	 */
	private static $_updatedata = null;

	/**
	 * prepared statement for updating the
	 * settings table
	 *
	 * @var PDOStatement
	 */
	private static $_updstmt = null;

	/**
	 * private constructor, reads in all settings
	 */
	private function __construct() {
		$this->_readSettings();
		self::$_updatedata = array();
		// prepare statement
		self::$_updstmt = Database::prepare("
				UPDATE `".TABLE_PANEL_SETTINGS."` SET `value` = :value
				WHERE `settinggroup` = :group AND `varname` = :varname
				");
	}

	/**
	 * Read in all settings from the database
	 * and set the internal $_data array
	 */
	private function _readSettings() {
		$result_stmt = Database::query("
				SELECT `settingid`, `settinggroup`, `varname`, `value`
				FROM `" . TABLE_PANEL_SETTINGS . "`
				");
		self::$_data = array();
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			self::$_data[$row['settinggroup']][$row['varname']] = $row['value'];
		}
		return true;
	}

	/**
	 * update a value in the database
	 *
	 * @param string $group
	 * @param string $varname
	 * @param string $value
	 */
	private function _storeSetting($group = null, $varname = null, $value = null) {
		$upd_data = array(
				'group' => $group,
				'varname' => $varname,
				'value' => $value
		);
		Database::pexecute(self::$_updstmt, $upd_data);
	}

	/**
	 * return a setting-value by its group and varname
	 *
	 * @param string $setting a group and a varname separated by a dot (group.varname)
	 *
	 * @return mixed
	 */
	public function pGet($setting = null) {
		$sstr = explode(".", $setting);
		// no separator - do'h
		if (!isset($sstr[1])) {
			return null;
		}
		$result = null;
		if (isset(self::$_data[$sstr[0]][$sstr[1]])) {
			$result = self::$_data[$sstr[0]][$sstr[1]];
		}
		return $result;
	}

	/**
	 * tests if a setting-value that i s a comma separated list contains an entry
	 *
	 * @param string $setting a group and a varname separated by a dot (group.varname)
	 * @param string $entry the entry that is expected to be in the list
	 *
	 * @return boolean true, if the list contains $entry
	 */
	public function pIsInList($setting = null, $entry = null) {
		$s=Settings::Get($setting);
		if ($s==null) {
			return false;
		}
		$slist = explode(",",$s);
		return in_array($entry, $slist);
	}

	/**
	 * update a setting / set a new value
	 *
	 * @param string $setting a group and a varname separated by a dot (group.varname)
	 * @param string $value
	 * @param boolean $instant_save
	 *
	 * @return bool
	 */
	public function pSet($setting = null, $value = null, $instant_save = true) {
		// check whether the setting exists
		if (Settings::Get($setting) !== null) {
			// set new value in array
			$sstr = explode(".", $setting);
			if (!isset($sstr[1])) {
				return false;
			}
			self::$_data[$sstr[0]][$sstr[1]] = $value;
			// should we store to db instantly?
			if ($instant_save) {
				$this->_storeSetting($sstr[0], $sstr[1], $value);
			} else {
				// set temporary data for usage
				if (!isset(self::$_data[$sstr[0]]) || !is_array(self::$_data[$sstr[0]])) {
					self::$_data[$sstr[0]] = array();
				}
				self::$_data[$sstr[0]][$sstr[1]] = $value;
				// set update-data when invoking Flush()
				if (!isset(self::$_updatedata[$sstr[0]]) || !is_array(self::$_updatedata[$sstr[0]])) {
					self::$_updatedata[$sstr[0]] = array();
				}
				self::$_updatedata[$sstr[0]][$sstr[1]] = $value;
			}
			return true;
		}
		return false;
	}

	/**
	 * add a new setting to the database (mainly used in updater)
	 *
	 * @param string $setting a group and a varname separated by a dot (group.varname)
	 * @param string $value
	 *
	 * @return boolean
	 */
	public function pAddNew($setting = null, $value = null) {

		// first check if it doesn't exist
		if (Settings::Get($setting) === null) {
			// validate parameter
			$sstr = explode(".", $setting);
			if (!isset($sstr[1])) {
				return false;
			}
			// prepare statement
			$ins_stmt = Database::prepare("
					INSERT INTO `".TABLE_PANEL_SETTINGS."` SET
					`settinggroup` = :group,
					`varname` = :varname,
					`value` = :value
					");
			$ins_data = array(
					'group' => $sstr[0],
					'varname' => $sstr[1],
					'value' => $value
			);
			Database::pexecute($ins_stmt, $ins_data);
			// also set new value to internal array and make it available
			self::$_data[$sstr[0]][$sstr[1]] = $value;
			return true;
		}
		return false;
	}

	/**
	 * Store all un-saved changes to the database and
	 * re-read in all settings
	 */
	public function pFlush() {
		if (is_array(self::$_updatedata) && count(self::$_updatedata) > 0) {
			// save all un-saved changes to the settings
			foreach (self::$_updatedata as $group => $vargroup) {
				foreach ($vargroup as $varname => $value) {
					$this->_storeSetting($group, $varname, $value);
				}
			}
			// now empty the array
			self::$_updatedata = array();
			// re-read in all settings
			return $this->_readSettings();
		}
		return false;
	}

	/**
	 * forget all un-saved changes to settings
	 */
	public function pStash() {
		// empty update array
		self::$_updatedata = array();
	}

	/**
	 * create new object and return instance
	 *
	 * @return object
	 */
	private static function getInstance() {
		// do we got an object already?
		if (self::$_obj == null) {
			self::$_obj = new self();
		}
		// return it
		return self::$_obj;
	}

	/**
	 * let's us interact with the settings-Object by using static
	 * call like "Settings::function()"
	 *
	 * @param string $name
	 * @param mixed $args
	 *
	 * @return mixed
	 */
	public static function __callStatic($name, $args) {
		// as our functions are not static and therefore cannot
		// be called statically, we prefix a 'p' to all of
		// our public functions so we can use Settings::functionname()
		// which looks cooler and is easier to use
		$callback = array(self::getInstance(), "p".$name);
		$result = call_user_func_array($callback, $args);
		return $result;
	}
}
