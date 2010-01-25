<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id$
 */

/**
 * Function which returns a secure path, means to remove all multiple dots and slashes
 *
 * @param string The path
 * @return string The corrected path
 * @author Florian Lippert <flo@syscp.org>
 */

function makeSecurePath($path)
{
	$search = Array(
		'#/+#',
		'#\.+#',
		'#\0+#'
	);
	$replace = Array(
		'/',
		'.',
		''
	);
	$path = preg_replace($search, $replace, $path);
	return $path;
}
