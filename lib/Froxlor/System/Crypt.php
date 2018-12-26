<?php
namespace Froxlor\System;

use Froxlor\Settings;

class Crypt
{

	/**
	 * Generates a random password
	 *
	 * @param boolean $isSalt
	 *        	optional, create a hash for a salt used in \Froxlor\System\Crypt::makeCryptPassword because crypt() does not like some special characters in its salts, default is false
	 */
	public static function generatePassword($isSalt = false)
	{
		$alpha_lower = 'abcdefghijklmnopqrstuvwxyz';
		$alpha_upper = strtoupper($alpha_lower);
		$numeric = '0123456789';
		$special = Settings::Get('panel.password_special_char');
		$length = Settings::Get('panel.password_min_length') > 3 ? Settings::Get('panel.password_min_length') : 10;

		$pw = self::specialShuffle($alpha_lower);
		$n = floor(($length) / 4);

		if (Settings::Get('panel.password_alpha_upper')) {
			$pw .= mb_substr(self::specialShuffle($alpha_upper), 0, $n);
		}

		if (Settings::Get('panel.password_numeric')) {
			$pw .= mb_substr(self::specialShuffle($numeric), 0, $n);
		}

		if (Settings::Get('panel.password_special_char_required') && ! $isSalt) {
			$pw .= mb_substr(self::specialShuffle($special), 0, $n);
		}

		$pw = mb_substr($pw, - $length);

		return self::specialShuffle($pw);
	}

	/**
	 * multibyte-character safe shuffle function
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	private static function specialShuffle($str = null)
	{
		$len = mb_strlen($str);
		$sploded = array();
		while ($len -- > 0) {
			$sploded[] = mb_substr($str, $len, 1);
		}
		shuffle($sploded);
		return join('', $sploded);
	}

	/**
	 * Make crypted password from clear text password
	 *
	 * @author Michal Wojcik <m.wojcik@sonet3.pl>
	 * @author Michael Kaufmann <mkaufmann@nutime.de>
	 * @author Froxlor team <team@froxlor.org> (2010-)
	 *        
	 *         0 - default crypt (depenend on system configuration)
	 *         1 - MD5 $1$
	 *         2 - BLOWFISH $2y$07$
	 *         3 - SHA-256 $5$ (default)
	 *         4 - SHA-512 $6$
	 *        
	 * @param string $password
	 *        	Password to be crypted
	 * @param bool $htpasswd
	 *        	optional whether to generate a SHA1 password for directory protection
	 *        	
	 * @return string encrypted password
	 */
	public static function makeCryptPassword($password, $htpasswd = false)
	{
		if ($htpasswd) {
			return '{SHA}' . base64_encode(sha1($password, true));
		}

		$type = Settings::Get('system.passwordcryptfunc') !== null ? (int) Settings::Get('system.passwordcryptfunc') : 3;

		switch ($type) {
			case 1:
				$cryptPassword = crypt($password, '$1$' . self::generatePassword(true) . self::generatePassword(true));
				break;
			case 2:
				// Blowfish hashing with a salt as follows: "$2a$", "$2x$" or "$2y$",
				// a two digit cost parameter, "$", and 22 characters from the alphabet "./0-9A-Za-z"
				$cryptPassword = crypt($password, '$2y$07$' . substr(self::generatePassword(true) . self::generatePassword(true) . self::generatePassword(true), 0, 22));
				break;
			case 3:
				$cryptPassword = crypt($password, '$5$' . self::generatePassword(true) . self::generatePassword(true));
				break;
			case 4:
				$cryptPassword = crypt($password, '$6$' . self::generatePassword(true) . self::generatePassword(true));
				break;
			default:
				$cryptPassword = crypt($password, self::generatePassword(true) . self::generatePassword(true));
				break;
		}
		return $cryptPassword;
	}

	/**
	 * return an array of available hashes for the crypt() function
	 *
	 * @return array
	 */
	public static function getAvailablePasswordHashes()
	{
		global $lng;

		// get available pwd-hases
		$available_pwdhashes = array(
			0 => $lng['serversettings']['systemdefault']
		);
		if (defined('CRYPT_MD5') && CRYPT_MD5 == 1) {
			$available_pwdhashes[1] = 'MD5';
		}
		if (defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH == 1) {
			$available_pwdhashes[2] = 'BLOWFISH';
		}
		if (defined('CRYPT_SHA256') && CRYPT_SHA256 == 1) {
			$available_pwdhashes[3] = 'SHA-256';
		}
		if (defined('CRYPT_SHA512') && CRYPT_SHA512 == 1) {
			$available_pwdhashes[4] = 'SHA-512';
		}

		return $available_pwdhashes;
	}

	/**
	 * Function validatePassword
	 *
	 * if password-min-length is set in settings
	 * we check against the length, if not matched
	 * an error message will be output and 'exit' is called
	 *
	 * @param string $password
	 *        	the password to validate
	 *        	
	 * @return string either the password or an errormessage+exit
	 */
	public static function validatePassword($password = null, $json_response = false)
	{
		if (Settings::Get('panel.password_min_length') > 0) {
			$password = \Froxlor\Validate\Validate::validate($password, Settings::Get('panel.password_min_length'), '/^.{' . (int) Settings::Get('panel.password_min_length') . ',}$/D', 'notrequiredpasswordlength', array(), $json_response);
		}

		if (Settings::Get('panel.password_regex') != '') {
			$password = \Froxlor\Validate\Validate::validate($password, Settings::Get('panel.password_regex'), Settings::Get('panel.password_regex'), 'notrequiredpasswordcomplexity', array(), $json_response);
		} else {
			if (Settings::Get('panel.password_alpha_lower')) {
				$password = \Froxlor\Validate\Validate::validate($password, '/.*[a-z]+.*/', '/.*[a-z]+.*/', 'notrequiredpasswordcomplexity', array(), $json_response);
			}
			if (Settings::Get('panel.password_alpha_upper')) {
				$password = \Froxlor\Validate\Validate::validate($password, '/.*[A-Z]+.*/', '/.*[A-Z]+.*/', 'notrequiredpasswordcomplexity', array(), $json_response);
			}
			if (Settings::Get('panel.password_numeric')) {
				$password = \Froxlor\Validate\Validate::validate($password, '/.*[0-9]+.*/', '/.*[0-9]+.*/', 'notrequiredpasswordcomplexity', array(), $json_response);
			}
			if (Settings::Get('panel.password_special_char_required')) {
				$password = \Froxlor\Validate\Validate::validate($password, '/.*[' . preg_quote(Settings::Get('panel.password_special_char')) . ']+.*/', '/.*[' . preg_quote(Settings::Get('panel.password_special_char')) . ']+.*/', 'notrequiredpasswordcomplexity', array(), $json_response);
			}
		}

		return $password;
	}

	/**
	 * Function validatePasswordLogin
	 *
	 * compare user password-hash with given user-password
	 * and check if they are the same
	 * additionally it updates the hash if the system settings changed
	 * or if the very old md5() sum is used
	 *
	 * @param array $userinfo
	 *        	user-data from table
	 * @param string $password
	 *        	the password to validate
	 * @param string $table
	 *        	either panel_customers or panel_admins
	 * @param string $uid
	 *        	user-id-field in $table
	 *        	
	 * @return boolean
	 */
	public static function validatePasswordLogin($userinfo = null, $password = null, $table = 'panel_customers', $uid = 'customerid')
	{
		$systype = 3; // SHA256
		if (Settings::Get('system.passwordcryptfunc') !== null) {
			$systype = (int) Settings::Get('system.passwordcryptfunc');
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
			// MD5 || BLOWFISH || SHA256 || SHA512
			if (($systype == 1 && $hash_type_chk != '$1$') || ($systype == 2 && $hash_type_chk != '$2$') || ($systype == 3 && $hash_type_chk != '$5$') || ($systype == 4 && $hash_type_chk != '$6$')) {
				$update_hash = true;
			}
		}

		if ($pwd_hash == $pwd_check) {

			// check for update of hash (only if our database is ready to handle the bigger string)
			$is_ready = (\Froxlor\Froxlor::versionCompare2("0.9.33", \Froxlor\Froxlor::getVersion()) <= 0 ? true : false);
			if ($update_hash && $is_ready) {
				$upd_stmt = \Froxlor\Database\Database::prepare("
					UPDATE " . $table . " SET `password` = :newpasswd WHERE `" . $uid . "` = :uid
				");
				$params = array(
					'newpasswd' => self::makeCryptPassword($password),
					'uid' => $userinfo[$uid]
				);
				\Froxlor\Database\Database::pexecute($upd_stmt, $params);
			}

			return true;
		}
		return false;
	}
}
