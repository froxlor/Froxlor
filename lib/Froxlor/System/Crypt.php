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

		$pw = self::special_shuffle($alpha_lower);
		$n = floor(($length) / 4);

		if (Settings::Get('panel.password_alpha_upper')) {
			$pw .= mb_substr(self::special_shuffle($alpha_upper), 0, $n);
		}

		if (Settings::Get('panel.password_numeric')) {
			$pw .= mb_substr(self::special_shuffle($numeric), 0, $n);
		}

		if (Settings::Get('panel.password_special_char_required') && ! $isSalt) {
			$pw .= mb_substr(self::special_shuffle($special), 0, $n);
		}

		$pw = mb_substr($pw, - $length);

		return self::special_shuffle($pw);
	}

	/**
	 * multibyte-character safe shuffle function
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	private static function special_shuffle($str = null)
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
	 *         2 - BLOWFISH $2a$ | $2y$07$ (on php 5.3.7+)
	 *         3 - SHA-256 $5$ (default)
	 *         4 - SHA-512 $6$
	 *        
	 * @param string $password
	 *        	Password to be crypted
	 *        	
	 * @return string encrypted password
	 */
	public static function makeCryptPassword($password)
	{
		$type = Settings::Get('system.passwordcryptfunc') !== null ? (int) Settings::Get('system.passwordcryptfunc') : 3;

		switch ($type) {
			case 0:
				$cryptPassword = crypt($password);
				break;
			case 1:
				$cryptPassword = crypt($password, '$1$' . self::generatePassword(true) . self::generatePassword(true));
				break;
			case 2:
				if (version_compare(phpversion(), '5.3.7', '<')) {
					$cryptPassword = crypt($password, '$2a$' . self::generatePassword(true) . self::generatePassword(true));
				} else {
					// Blowfish hashing with a salt as follows: "$2a$", "$2x$" or "$2y$",
					// a two digit cost parameter, "$", and 22 characters from the alphabet "./0-9A-Za-z"
					$cryptPassword = crypt($password, '$2y$07$' . substr(self::generatePassword(true) . self::generatePassword(true) . self::generatePassword(true), 0, 22));
				}
				break;
			case 3:
				$cryptPassword = crypt($password, '$5$' . self::generatePassword(true) . self::generatePassword(true));
				break;
			case 4:
				$cryptPassword = crypt($password, '$6$' . self::generatePassword(true) . self::generatePassword(true));
				break;
			default:
				$cryptPassword = crypt($password);
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
}