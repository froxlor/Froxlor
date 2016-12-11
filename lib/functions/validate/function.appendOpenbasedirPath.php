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
 * @param string $path
 *        	the path to check and append
 * @param boolean $first
 *        	if true, no ':' will be prefixed to the path
 *
 * @return string
 */
function appendOpenBasedirPath($path = '', $first = false)
{
	if ($path != '' && $path != '/' &&
		(! preg_match("#^/dev#i", $path) || preg_match("#^/dev/urandom#i", $path))
		&& ! preg_match("#^/proc#i", $path)
		&& ! preg_match("#^/etc#i", $path)
		&& ! preg_match("#^/sys#i", $path)
		&& ! preg_match("#:#", $path)) {

		if (preg_match("#^/dev/urandom#i", $path)) {
			$path = makeCorrectFile($path);
		} else {
			$path = makeCorrectDir($path);
		}

		// check for php-version that requires the trailing
		// slash to be removed as it does not allow the usage
		// of the subfolders within the given folder, fixes #797
		if ((PHP_MINOR_VERSION == 2 && PHP_VERSION_ID >= 50216) || PHP_VERSION_ID >= 50304) {
			// check trailing slash
			if (substr($path, - 1, 1) == '/') {
				// remove it
				$path = substr($path, 0, - 1);
			}
		}

		if ($first) {
			return $path;
		}

		return ':' . $path;
	}
	return '';
}
