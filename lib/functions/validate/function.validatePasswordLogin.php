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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Function validatePasswordLogin
 *
 * compare user password-hash with given user-password
 * and check if they are the same
 * additionally it updates the hash if the system settings changed
 * or if the very old md5() sum is used
 *
 * @param array $userinfo user-data from table
 * @param string $password the password to validate
 * @param string $table either panel_customers or panel_admins
 * @param string $uid user-id-field in $table
 *
 * @return boolean
 */
function validatePasswordLogin($userinfo = null, $password = null, $table = 'panel_customers', $uid = 'customerid') {

	global $version;

	$systype = 3; // SHA256
	if (Settings::Get('system.passwordcryptfunc') !== null) {
		$systype = (int)Settings::Get('system.passwordcryptfunc');
	}

	$pwd_hash = $userinfo['password'];

	$update_hash = false;
	// check for good'ole md5
	if (strlen($pwd_hash) == 32 && ctype_xdigit($pwd_hash)) {
		$pwd_check = md5($password);
		$update_hash = true;
	} else {
		// cut out the salt from the hash
		$pwd_salt = str_replace(substr(strrchr($pwd_hash, "$"), 1), "", $pwd_hash);
		// create same hash to compare
		$pwd_check = crypt($password, $pwd_salt);
		// check whether the hash needs to be updated
		$hash_type_chk = substr($pwd_hash, 0, 3);
		if (($systype == 1 && $hash_type_chk != '$1$') || // MD5
			($systype == 2 && $hash_type_chk != '$2$') || // BLOWFISH
			($systype == 3 && $hash_type_chk != '$5$') || // SHA256
			($systype == 4 && $hash_type_chk != '$6$')    // SHA512
		) {
			$update_hash = true;
		}
	}

	if ($pwd_hash == $pwd_check) {

		// check for update of hash (only if our database is ready to handle the bigger string)
		$is_ready = (version_compare2("0.9.33", $version) <= 0 ? true : false);
		if ($update_hash && $is_ready) {
			$upd_stmt = Database::prepare("
				UPDATE " . $table . " SET `password` = :newpasswd WHERE `" . $uid . "` = :uid
			");
			$params = array (
				'newpasswd' => makeCryptPassword($password),
				'uid' => $userinfo[$uid]
			);
			Database::pexecute($upd_stmt, $params);
		}

		return true;
	}
	return false;

}
