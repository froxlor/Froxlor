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
 * Function which returns a secure path, means to remove all multiple dots and slashes
 *
 * @param string The path
 * @return string The corrected path
 * @author Florian Lippert <flo@syscp.org>
 */
function makeSecurePath($path) {

	$search = array(
		'#/+#',
		'#\.+#',
		'#\0+#'
	);
	$replace = array(
		'/',
		'.',
		''
	);
	$path = preg_replace($search, $replace, $path);
	// don't just replace a space with an escaped space
	// it might be escaped already
	$path = str_replace("\ ", " ", $path);
	$path = str_replace(" ", "\ ", $path);

	// check for bad characters, some are allowed with escaping
	// but we generally don't want them in our directory-names,
	// thx to aaronmueller for this snipped
	$badchars = array(':', ';', '|', '&', '>', '<', '`', '$', '~', '?');
	foreach ($badchars as $bc) {
		str_replace($bc, "", $path);
	}

	return $path;
}
