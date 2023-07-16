<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Validate;

use Exception;
use Froxlor\Database\Database;
use Froxlor\FroxlorLogger;
use Froxlor\Idna\IdnaWrapper;
use Froxlor\System\IPTools;
use Froxlor\UI\Response;

class Validate
{

	const REGEX_DIR = '/^|(\/[\w-]+)+$/';

	const REGEX_PORT = '/^(([1-9])|([1-9][0-9])|([1-9][0-9][0-9])|([1-9][0-9][0-9][0-9])|([1-5][0-9][0-9][0-9][0-9])|(6[0-4][0-9][0-9][0-9])|(65[0-4][0-9][0-9])|(655[0-2][0-9])|(6553[0-5]))$/Di';

	const REGEX_CONF_TEXT = '/^[^\0]*$/';

	const REGEX_DESC_TEXT = '/^[^\0\r\n<>]*$/';

	const REGEX_YYYY_MM_DD = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';

	/**
	 * Validates the given string by matching against the pattern, prints an error on failure and exits.
	 * If the default pattern is used and the string does not match, we try to replace the 'bad' values and log the action.
	 *
	 * @param string $str the string to be tested (user input)
	 * @param string $fieldname to be used in error messages
	 * @param string $pattern the regular expression to be used for testing
	 * @param string|array $lng id for the error
	 * @param string|array $emptydefault fallback value
	 * @param bool $throw_exception whether to display error or throw an exception, default false
	 *
	 * @return string|void the clean string or error
	 * @throws Exception
	 */
	public static function validate(
		string $str,
		string $fieldname,
		string $pattern = '',
		$lng = '',
		$emptydefault = [],
		bool $throw_exception = false
	) {
		if (!is_array($emptydefault)) {
			$emptydefault_array = [
				$emptydefault
			];
			unset($emptydefault);
			$emptydefault = $emptydefault_array;
			unset($emptydefault_array);
		}

		// Check if the $str is one of the values which represent the default for an 'empty' value
		if (is_array($emptydefault) && !empty($emptydefault) && in_array($str, $emptydefault)) {
			return $str;
		}

		if ($pattern == '') {
			$pattern = '/^[^\r\n\t\f\0]*$/D';

			if (!preg_match($pattern, $str)) {
				// Allows letters a-z, digits, space (\\040), hyphen (\\-), underscore (\\_) and backslash (\\\\),
				// everything else is removed from the string.
				$allowed = "/[^a-z0-9\\040\\.\\-\\_\\\\]/i";
				$str = preg_replace($allowed, "", $str);
				$log = FroxlorLogger::getInstanceOf();
				$log->logAction(FroxlorLogger::USR_ACTION, LOG_WARNING, "cleaned bad formatted string (" . $str . ")");
			}
		}

		if (preg_match($pattern, $str)) {
			return $str;
		}

		if ($lng == '') {
			$lng = 'stringformaterror';
		}

		Response::standardError($lng, $fieldname, $throw_exception);
	}

	/**
	 * Checks whether it is a valid ip
	 *
	 * @param string $ip ip-address to check
	 * @param bool $return_bool whether to return bool or call \Froxlor\UI\Response::standard_error()
	 * @param string $lng index for error-message (if $return_bool is false)
	 * @param bool $allow_localhost whether to allow 127.0.0.1
	 * @param bool $allow_priv whether to allow private network addresses
	 * @param bool $allow_cidr whether to allow CIDR values e.g. 10.10.10.10/16
	 * @param bool $cidr_as_netmask whether to format CIDR notation to netmask notation
	 * @param bool $throw_exception whether to throw an exception on failure
	 *
	 * @return string|bool|void ip address on success, false on failure (or nothing if error is displayed)
	 * @throws Exception
	 */
	public static function validate_ip2(
		string $ip,
		bool $return_bool = false,
		string $lng = 'invalidip',
		bool $allow_localhost = false,
		bool $allow_priv = false,
		bool $allow_cidr = false,
		bool $cidr_as_netmask = false,
		bool $throw_exception = false
	) {
		$cidr = "";
		if ($allow_cidr) {
			$org_ip = $ip;
			$ip_cidr = explode("/", $ip);
			if (count($ip_cidr) === 2) {
				$cidr_range_max = 32;
				if (IPTools::is_ipv6($ip_cidr[0])) {
					$cidr_range_max = 128;
				}
				if (strlen($ip_cidr[1]) <= 3 && in_array((int)$ip_cidr[1], array_values(range(1, $cidr_range_max)),
						true) === false) {
					if ($return_bool) {
						return false;
					}
					Response::standardError($lng, $ip, $throw_exception);
				}
				if ($cidr_as_netmask && IPTools::is_ipv6($ip_cidr[0])) {
					// MySQL does not handle CIDR of IPv6 addresses, return error
					if ($return_bool) {
						return false;
					}
					Response::standardError($lng, $ip, $throw_exception);
				}
				$ip = $ip_cidr[0];
				if ($cidr_as_netmask && strlen($ip_cidr[1]) <= 3) {
					$ip_cidr[1] = IPTools::cidr2NetmaskAddr($org_ip);
				}
				$cidr = "/" . $ip_cidr[1];
			} else {
				$ip = $org_ip;
			}
		} elseif (strpos($ip, "/") !== false) {
			if ($return_bool) {
				return false;
			}
			Response::standardError($lng, $ip, $throw_exception);
		}

		$filter_lan = $allow_priv ? FILTER_FLAG_NO_RES_RANGE : (FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE);

		if ((filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) || filter_var($ip, FILTER_VALIDATE_IP,
					FILTER_FLAG_IPV4)) && filter_var($ip, FILTER_VALIDATE_IP, $filter_lan)) {
			return $ip . $cidr;
		}

		// special case where localhost ip is allowed (mysql-access-hosts for example)
		if ($allow_localhost && $ip == '127.0.0.1') {
			return $ip . $cidr;
		}

		if ($return_bool) {
			return false;
		}
		Response::standardError($lng, $ip, $throw_exception);
	}

	/**
	 * Returns whether a URL is in a correct format or not
	 *
	 * @param string $url URL to be tested
	 * @param bool $allow_private_ip optional, default is false
	 *
	 * @return bool
	 */
	public static function validateUrl(string $url, bool $allow_private_ip = false): bool
	{
		if (strtolower(substr($url, 0, 7)) != "http://" && strtolower(substr($url, 0, 8)) != "https://") {
			$url = 'http://' . $url;
		}

		// needs converting
		try {
			$idna_convert = new IdnaWrapper();
			$url = $idna_convert->encode($url);
		} catch (Exception $e) {
			return false;
		}

		if ($allow_private_ip) {
			$pattern = '%^(?:(?:https?):\/\/)(?:\S+(?::\S*)?@)?(?:(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$%iuS';
		} else {
			$pattern = '%^(?:(?:https?):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$%iuS';
		}
		if (preg_match($pattern, $url)) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the submitted string is a valid domainname
	 *
	 * @param string $domainname The domainname which should be checked.
	 * @param bool $allow_underscore optional if true, allowes the underscore character in a domain label (DKIM etc.)
	 *
	 * @return string|boolean the domain-name if the domain is valid, false otherwise
	 */
	public static function validateDomain(string $domainname, bool $allow_underscore = false)
	{
		$char_validation = '([a-z\d](-*[a-z\d])*)(\.?([a-z\d](-*[a-z\d])*))*\.(xn\-\-)?([a-z\d])+';
		if ($allow_underscore) {
			$char_validation = '([a-z\d\_](-*[a-z\d\_])*)(\.([a-z\d\_](-*[a-z\d])*))*(\.?([a-z\d](-*[a-z\d])*))+\.(xn\-\-)?([a-z\d])+';
		}

		// valid chars check && overall length check && length of each label
		if (preg_match("/^" . $char_validation . "$/i", $domainname) && preg_match("/^.{1,253}$/",
				$domainname) && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domainname)) {
			return $domainname;
		}
		return false;
	}

	/**
	 * validate a local-hostname by regex
	 *
	 * @param string $hostname
	 *
	 * @return string|boolean hostname on success, else false
	 */
	public static function validateLocalHostname(string $hostname)
	{
		$pattern = '/^[a-z0-9][a-z0-9\-]{0,62}$/i';
		if (preg_match($pattern, $hostname)) {
			return $hostname;
		}
		return false;
	}

	/**
	 * Returns if an email-address is in correct format or not
	 *
	 * @param string $email The email address to check
	 *
	 * @return mixed
	 */
	public static function validateEmail(string $email)
	{
		$email = strtolower($email);
		// as of php-7.1
		if (defined('FILTER_FLAG_EMAIL_UNICODE')) {
			return filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE);
		}
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Returns if a username is in correct format or not.
	 *
	 * @param string $username The username to check
	 * @param bool $unix_names optional, default true, checks whether it must be UNIX compatible
	 * @param int $mysql_max optional, number of max mysql username characters, default empty
	 *
	 * @return bool
	 */
	public static function validateUsername(string $username, bool $unix_names = true, int $mysql_max = 0): bool
	{
		if (empty($mysql_max) || $mysql_max <= 0) {
			$mysql_max = Database::getSqlUsernameLength() - 1;
		} else {
			$mysql_max--;
		}
		if (!$unix_names) {
			if (strpos($username, '--') === false) {
				return (preg_match('/^[a-z][a-z0-9\-_]{0,' . $mysql_max . '}[a-z0-9]{1}$/Di', $username) != false);
			}
			return false;
		}
		return (preg_match('/^[a-z][a-z0-9]{0,' . $mysql_max . '}$/Di', $username) != false);
	}

	/**
	 * validate sql interval string
	 *
	 * @param string $interval
	 *
	 * @return bool
	 */
	public static function validateSqlInterval(string $interval = ''): bool
	{
		if (!empty($interval) && strstr($interval, ' ') !== false) {
			/*
			 * [0] = ([0-9]+)
			 * [1] = valid SQL-Interval expression
			 */
			$valid_expr = [
				'SECOND',
				'MINUTE',
				'HOUR',
				'DAY',
				'WEEK',
				'MONTH',
				'YEAR'
			];

			$interval_parts = explode(' ', $interval);

			if (count($interval_parts) == 2 && preg_match('/[0-9]+/',
					$interval_parts[0]) && in_array(strtoupper($interval_parts[1]), $valid_expr)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * validates whether a given base64 string decodes to an image
	 *
	 * @param string $base64string
	 * @return bool
	 * @throws Exception
	 */
	public static function validateBase64Image(string $base64string) {

		if (!extension_loaded('gd')) {
			Response::standardError('phpgdextensionnotavailable', null, true);
		}

		// Decode the base64 string
		$data = base64_decode($base64string);

		// Create an image from the decoded data
		$image = @imagecreatefromstring($data);

		// Check if the image was created successfully
		if (!$image) {
			return false;
		}

		// Get the MIME type of the image
		$mime = image_type_to_mime_type(getimagesizefromstring($data)[2]);

		// Check if the MIME type is a valid image MIME type
		if (strpos($mime, 'image/') !== 0) {
			return false;
		}

		// If everything is okay, return true
		return true;
	}
}
