<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Checks whether it is a valid ip
 *
 * @return mixed 	ip address on success, standard_error on failure
 * @deprecated use validate_ip2
 */
function validate_ip($ip, $return_bool = false, $lng = 'invalidip', $throw_exception = false) {

	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false
			&& filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false
			&& filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE) === false
	) {
		if ($return_bool) {
			return false;
		} else {
			standard_error($lng, $ip, $throw_exception);
			exit();
		}
	} else {
		return $ip;
	}

}

/**
 * Checks whether it is a valid ip
 *
 * @param string $ip ip-address to check
 * @param bool $return_bool whether to return bool or call standard_error()
 * @param string $lng index for error-message (if $return_bool is false)
 * @param bool $allow_localhost whether to allow 127.0.0.1
 * @param bool $allow_priv whether to allow private network addresses
 * @param bool $allow_cidr whether to allow CIDR values e.g. 10.10.10.10/16
 *
 * @return string|bool ip address on success, false on failure
 */
function validate_ip2($ip, $return_bool = false, $lng = 'invalidip', $allow_localhost = false, $allow_priv = false, $allow_cidr = false, $throw_exception = false) {

	$cidr = "";
	if ($allow_cidr) {
		$org_ip = $ip;
		$ip_cidr = explode("/", $ip);
		if (count($ip_cidr) == 2) {
			$ip = $ip_cidr[0];
			$cidr = "/".$ip_cidr[1];
		} else {
			$ip = $org_ip;
		}
	} elseif (strpos($ip, "/") !== false) {
		if ($return_bool) {
			return false;
		} else {
			standard_error($lng, $ip, $throw_exception);
			exit();
		}
	}

	$filter_lan = $allow_priv ? FILTER_FLAG_NO_RES_RANGE : (FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE);

	if ((filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
			|| filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
			&& filter_var($ip, FILTER_VALIDATE_IP, $filter_lan)
	) {
		return $ip.$cidr;
	}

	// special case where localhost ip is allowed (mysql-access-hosts for example)
	if ($allow_localhost && $ip == '127.0.0.1') {
		return $ip.$cidr;
	}

	if ($return_bool) {
		return false;
	} else {
		standard_error($lng, $ip, $throw_exception);
		exit();
	}
}
