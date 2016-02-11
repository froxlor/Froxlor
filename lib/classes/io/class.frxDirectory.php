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
 * @package    Cron
 *
 * @since      0.9.33
 *
 */

/**
 * Class frxDirectory handles directory actions and gives information
 * about a given directory in connections with its usage in froxlor
 *
 * @author Michael Kaufmann (d00p) <d00p@froxlor.org>
 *
 */
class frxDirectory {

	/**
	 * directory string
	 *
	 * @var string
	 */
	private $_dir = null;

	/**
	 * class constructor, optionally set directory
	 *
	 * @param string $dir
	 */
	public function __construct($dir = null) {
		$this->_dir = $dir;
	}

	/**
	 * check whether the directory has options set in panel_htaccess
	 */
	public function hasUserOptions() {
		$uo_stmt = Database::prepare("
			SELECT COUNT(`id`) as `usropts` FROM `".TABLE_PANEL_HTACCESS."` WHERE `path` = :dir
		");
		$uo_res = Database::pexecute_first($uo_stmt, array('dir' => makeCorrectDir($this->_dir)));
		if ($uo_res != false && isset($uo_res['usropts'])) {
			return ($uo_res['usropts'] > 0 ? true : false);
		}
		return false;
	}

	/**
	 * check whether the directory is protected using panel_htpasswd
	 */
	public function isUserProtected() {
		$up_stmt = Database::prepare("
			SELECT COUNT(`id`) as `usrprot` FROM `".TABLE_PANEL_HTPASSWDS."` WHERE `path` = :dir
		");
		$up_res = Database::pexecute_first($up_stmt, array('dir' => makeCorrectDir($this->_dir)));
		if ($up_res != false && isset($up_res['usrprot'])) {
			return ($up_res['usrprot'] > 0 ? true : false);
		}
		return false;
	}

	/**
	 * Checks if a given directory is valid for multiple configurations
	 * or should rather be used as a single file
	 *
	 * @param bool $ifexists also check whether file/dir exists
	 *
	 * @return bool true if usable as dir, false otherwise
	 */
	public function isConfigDir($ifexists = false) {
		
		if (is_null($this->_dir)) {
			trigger_error(__CLASS__.'::'.__FUNCTION__.' has been called with a null value', E_USER_WARNING);
			return false;
		}

		if (file_exists($this->_dir)) {
			if (is_dir($this->_dir)) {
				$returnval = true;
			} else {
				$returnval = false;
			}
		} else {
			if (!$ifexists) {
				if (substr($this->_dir, -1) == '/') {
					$returnval = true;
				} else {
					$returnval = false;
				}
			} else {
				$returnval = false;
			}
		}
		return $returnval;
	}

}
