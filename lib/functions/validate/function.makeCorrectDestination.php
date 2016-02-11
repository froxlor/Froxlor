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
 * Function which returns a correct destination for Postfix Virtual Table
 *
 * @param string The destinations
 * @return string the corrected destinations
 * @author Florian Lippert <flo@syscp.org>
 */

function makeCorrectDestination($destination)
{
	$search = '/ +/';
	$replace = ' ';
	$destination = preg_replace($search, $replace, $destination);

	if(substr($destination, 0, 1) == ' ')
	{
		$destination = substr($destination, 1);
	}

	if(substr($destination, -1, 1) == ' ')
	{
		$destination = substr($destination, 0, strlen($destination) - 1);
	}

	return $destination;
}
