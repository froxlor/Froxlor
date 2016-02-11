<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2013 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 * @since      0.9.30
 *
 */

/**
 * checks a directory against disallowed paths which could
 * lead to a damaged system if you use them
 *
 * @param string $fieldname
 * @param array $fielddata
 * @param mixed $newfieldvalue
 *
 * @return boolean|array
 */
function checkDisallowedPaths($path = null) {

	/*
	 * disallow base-directories and /
	 */
	$disallowed_values = array(
		"/", "/bin/", "/boot/", "/dev/", "/etc/", "/home/", "/lib/", "/lib32/", "/lib64/",
		"/opt/", "/proc/", "/root/", "/run/", "/sbin/", "/sys/", "/tmp/", "/usr/", "/var/"	
	);

	$path = makeCorrectDir($path);

	// check if it's a disallowed path
	if (in_array($path, $disallowed_values)) {
		return false;
	}
	return true;
}
