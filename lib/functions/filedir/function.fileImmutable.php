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
 * set the immutable flag for a file
 * 
 * @param string $filename the file to set the flag for
 * 
 * @return boolean
 */
function setImmutable($filename = null)
{
	safe_exec(_getImmutableFunction(false).escapeshellarg($filename));
}

/**
 * removes the immutable flag for a file
 * 
 * @param string $filename the file to set the flag for
 * 
 * @return boolean
 */
function removeImmutable($filename = null)
{
	safe_exec(_getImmutableFunction(true).escapeshellarg($filename));
}

/**
 * internal function to check whether
 * to use chattr (Linux) or chflags (FreeBSD)
 * 
 * @param boolean $remove whether to use +i|schg (false) or -i|noschg (true)
 * 
 * @return string functionname + parameter (not the file)
 */
function _getImmutableFunction($remove = false)
{
	$output = array();
	$return_var = 0;
	exec('which chattr 2>&1', $output, $return_var);

	if((int)$return_var != 0)
	{
		// FreeBSD style
		return 'chflags '.(($remove === true) ? 'noschg ' : 'schg ');  
	}
	else
	{
		// Linux style
		return 'chattr '.(($remove === true) ? '-i ' : '+i ');
	}
}
