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
 * Function which returns a correct dirname, means to add slashes at the beginning and at the end if there weren't some
 *
 * @param string The dirname
 * @return string The corrected dirname
 * @author Florian Lippert <flo@syscp.org>
 */

function makeCorrectDir($dir)
{
	if(substr($dir, -1, 1) != '/')
	{
		$dir.= '/';
	}

	if(substr($dir, 0, 1) != '/')
	{
		$dir = '/' . $dir;
	}

	$dir = makeSecurePath($dir);
	return $dir;
}
