<?php
namespace Froxlor\Validate;

class Validate
{

	/**
	 * Validates the given string by matching against the pattern, prints an error on failure and exits
	 *
	 * @param string $str
	 *        	the string to be tested (user input)
	 * @param
	 *        	string the $fieldname to be used in error messages
	 * @param string $pattern
	 *        	the regular expression to be used for testing
	 * @param
	 *        	string language id for the error
	 * @return string the clean string
	 *        
	 *         If the default pattern is used and the string does not match, we try to replace the
	 *         'bad' values and log the action.
	 *        
	 */
	public static function validate($str, $fieldname, $pattern = '', $lng = '', $emptydefault = array(), $throw_exception = false)
	{
		global $log;

		if (! is_array($emptydefault)) {
			$emptydefault_array = array(
				$emptydefault
			);
			unset($emptydefault);
			$emptydefault = $emptydefault_array;
			unset($emptydefault_array);
		}

		// Check if the $str is one of the values which represent the default for an 'empty' value
		if (is_array($emptydefault) && ! empty($emptydefault) && in_array($str, $emptydefault) && isset($emptydefault[0])) {
			return $emptydefault[0];
		}

		if ($pattern == '') {

			$pattern = '/^[^\r\n\t\f\0]*$/D';

			if (! preg_match($pattern, $str)) {
				// Allows letters a-z, digits, space (\\040), hyphen (\\-), underscore (\\_) and backslash (\\\\),
				// everything else is removed from the string.
				$allowed = "/[^a-z0-9\\040\\.\\-\\_\\\\]/i";
				$str = preg_replace($allowed, "", $str);
				$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_WARNING, "cleaned bad formatted string (" . $str . ")");
			}
		}

		if (preg_match($pattern, $str)) {
			return $str;
		}

		if ($lng == '') {
			$lng = 'stringformaterror';
		}

		\Froxlor\UI\Response::standard_error($lng, $fieldname, $throw_exception);
		exit();
	}

	/**
	 * Checks whether it is a valid ip
	 *
	 * @param string $ip
	 *        	ip-address to check
	 * @param bool $return_bool
	 *        	whether to return bool or call \Froxlor\UI\Response::standard_error()
	 * @param string $lng
	 *        	index for error-message (if $return_bool is false)
	 * @param bool $allow_localhost
	 *        	whether to allow 127.0.0.1
	 * @param bool $allow_priv
	 *        	whether to allow private network addresses
	 * @param bool $allow_cidr
	 *        	whether to allow CIDR values e.g. 10.10.10.10/16
	 *        	
	 * @return string|bool ip address on success, false on failure
	 */
	public static function validate_ip2($ip, $return_bool = false, $lng = 'invalidip', $allow_localhost = false, $allow_priv = false, $allow_cidr = false, $throw_exception = false)
	{
		$cidr = "";
		if ($allow_cidr) {
			$org_ip = $ip;
			$ip_cidr = explode("/", $ip);
			if (count($ip_cidr) == 2) {
				$ip = $ip_cidr[0];
				$cidr = "/" . $ip_cidr[1];
			} else {
				$ip = $org_ip;
			}
		} elseif (strpos($ip, "/") !== false) {
			if ($return_bool) {
				return false;
			} else {
				\Froxlor\UI\Response::standard_error($lng, $ip, $throw_exception);
				exit();
			}
		}

		$filter_lan = $allow_priv ? FILTER_FLAG_NO_RES_RANGE : (FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE);

		if ((filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) && filter_var($ip, FILTER_VALIDATE_IP, $filter_lan)) {
			return $ip . $cidr;
		}

		// special case where localhost ip is allowed (mysql-access-hosts for example)
		if ($allow_localhost && $ip == '127.0.0.1') {
			return $ip . $cidr;
		}

		if ($return_bool) {
			return false;
		} else {
			\Froxlor\UI\Response::standard_error($lng, $ip, $throw_exception);
			exit();
		}
	}

	/**
	 * Check if the submitted string is a valid domainname
	 *
	 * @param string $domainname
	 *        	The domainname which should be checked.
	 * @param bool $allow_underscore
	 *        	optional if true, allowes the underscore character in a domain label (DKIM etc.)
	 *        	
	 * @return string|boolean the domain-name if the domain is valid, false otherwise
	 */
	public static function validateDomain($domainname, $allow_underscore = false)
	{
		if (is_string($domainname)) {
			$char_validation = '([a-z\d](-*[a-z\d])*)(\.?([a-z\d](-*[a-z\d])*))*\.([a-z\d])+';
			if ($allow_underscore) {
				$char_validation = '([a-z\d\_](-*[a-z\d\_])*)(\.([a-z\d\_](-*[a-z\d])*))*(\.?([a-z\d](-*[a-z\d])*))+\.([a-z\d])+';
			}

			// valid chars check && overall length check && length of each label
			if (preg_match("/^" . $char_validation . "$/i", $domainname) && preg_match("/^.{1,253}$/", $domainname) && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domainname)) {
				return $domainname;
			}
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
	public static function validateLocalHostname($hostname)
	{
		$pattern = '/^([a-zA-Z0-9\-])+$/i';
		if (preg_match($pattern, $hostname)) {
			return $hostname;
		}
		return false;
	}

	/**
	 * Returns if an emailaddress is in correct format or not
	 *
	 * @param string $email
	 *        	The email address to check
	 * @return bool Correct or not
	 */
	public static function validateEmail($email)
	{
		$email = strtolower($email);
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Returns if an username is in correct format or not.
	 *
	 * @param
	 *        	string The username to check
	 * @return bool Correct or not
	 * @author Michael Duergner <michael@duergner.com>
	 *        
	 */
	public static function validateUsername($username, $unix_names = 1, $mysql_max = '')
	{
		if ($unix_names == 0) {
			if (strpos($username, '--') === false) {
				return (preg_match('/^[a-z][a-z0-9\-_]{0,' . (int) ($mysql_max - 1) . '}[a-z0-9]{1}$/Di', $username) != false);
			} else {
				return false;
			}
		} else {
			return (preg_match('/^[a-z][a-z0-9]{0,' . $mysql_max . '}$/Di', $username) != false);
		}
	}

	public static function validateSqlInterval($interval = null)
	{
		if (! $interval === null || $interval != '') {
			if (strstr($interval, ' ') !== false) {
				/*
				 * [0] = ([0-9]+)
				 * [1] = valid SQL-Interval expression
				 */
				$valid_expr = array(
					'SECOND',
					'MINUTE',
					'HOUR',
					'DAY',
					'WEEK',
					'MONTH',
					'YEAR'
				);

				$interval_parts = explode(' ', $interval);

				if (is_array($interval_parts) && isset($interval_parts[0]) && isset($interval_parts[1])) {
					if (preg_match('/([0-9]+)/i', $interval_parts[0])) {
						if (in_array(strtoupper($interval_parts[1]), $valid_expr)) {
							return true;
						}
					}
				}
			}
		}
		return false;
	}
}
