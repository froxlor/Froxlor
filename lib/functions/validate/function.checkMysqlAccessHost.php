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

function checkMysqlAccessHost($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues) {

	$mysql_access_host_array = array_map('trim', explode(',', $newfieldvalue));

	foreach ($mysql_access_host_array as $host_entry) {

		// in mysql access host, using wildcard ('%') is allowed, but
		// the filters won't accept that. By replacing the first wildcard
		// with a '0', we can create "valid" entries:
		//   192.168.1.% becomes 192.168.1.0, which is valid
		//   %.somehost.com becomes 0.somehost.com, which is also valid
		$host_entry_test = preg_replace('/%/', '0', $host_entry, 1);

		if (validate_ip2($host_entry_test, true, 'invalidip', true, true) == false
		   && validateDomain($host_entry_test) == false
		   && validateLocalHostname($host_entry) == false
		   && $host_entry != '%'
		) {
			return array(FORMFIELDS_PLAUSIBILITY_CHECK_ERROR, 'invalidmysqlhost', $host_entry);
		}
	}
	
	return array(FORMFIELDS_PLAUSIBILITY_CHECK_OK);
}
