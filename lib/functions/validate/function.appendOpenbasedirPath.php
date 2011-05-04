<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * checks give path for security issues
 * and returns a string that can be appended
 * to a line for a open_basedir directive
 * 
 * @param string  $path  the path to check and append
 * @param boolean $first if true, no ':' will be prefixed to the path
 * 
 * @return string
 */
function appendOpenBasedirPath($path = '', $first = false)
{
	$path = makeCorrectDir($path);
	if($path != ''
		&& $path != '/'
		&& !preg_match("#^/dev#i", $path)                                                       
		&& !preg_match("#^/proc#i", $path)                                                                             
		&& !preg_match("#^/etc#i", $path)                                                                                                       
		&& !preg_match("#^/sys#i", $path)
		&& !preg_match("#:#", $path)
	) {
		if($first)
			return $path;

		return ':' . $path;
	}
	return '';
}
