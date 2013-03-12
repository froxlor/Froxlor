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
 */
function validate_ip($ip, $return_bool = false, $lng = 'invalidip') {

	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false
			&& filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false
			&& filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE) === false
	) {
		if ($return_bool) {
			return false;
		} else {
			standard_error($lng, $ip);
			exit;
		}
	} else {
		return $ip;
	}
}
