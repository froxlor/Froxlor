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
 * Validates the given string by matching against the pattern, prints an error on failure and exits
 *
 * @param string $str the string to be tested (user input)
 * @param string the $fieldname to be used in error messages
 * @param string $pattern the regular expression to be used for testing
 * @param string language id for the error
 * @return string the clean string
 *
 * If the default pattern is used and the string does not match, we try to replace the
 * 'bad' values and log the action.
 *
 */

function validate($str, $fieldname, $pattern = '', $lng = '', $emptydefault = array())
{
	global $log, $theme;

	if(!is_array($emptydefault))
	{
		$emptydefault_array = array(
			$emptydefault
		);
		unset($emptydefault);
		$emptydefault = $emptydefault_array;
		unset($emptydefault_array);
	}

	// Check if the $str is one of the values which represent the default for an 'empty' value

	if(is_array($emptydefault)
	   && !empty($emptydefault)
	   && in_array($str, $emptydefault)
	   && isset($emptydefault[0]))
	{
		return $emptydefault[0];
	}

	if($pattern == '')
	{
		$pattern = '/^[^\r\n\t\f\0]*$/D';

		if(!preg_match($pattern, $str))
		{
			// Allows letters a-z, digits, space (\\040), hyphen (\\-), underscore (\\_) and backslash (\\\\),
			// everything else is removed from the string.

			$allowed = "/[^a-z0-9\\040\\.\\-\\_\\\\]/i";
			preg_replace($allowed, "", $str);
			$log->logAction(null, LOG_WARNING, "cleaned bad formatted string (" . $str . ")");
		}
	}

	if(preg_match($pattern, $str))
	{
		return $str;
	}

	if($lng == '')
	{
		$lng = 'stringformaterror';
	}

	standard_error($lng, $fieldname);
	exit;
}
