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
 * Function which returns a correct filename, means to add a slash at the beginning if there wasn't one
 *
 * @param string filename the filename
 * @return string the corrected filename
 * @author Florian Lippert <flo@syscp.org>
 * @author Michael Russ <mr@edvruss.com>
 * @author Martin Burchert <eremit@adm1n.de>
 */

function makeCorrectFile($filename)
{
	if(substr($filename, 0, 1) != '/')
	{
		$filename = '/' . $filename;
	}

	$filename = makeSecurePath($filename);
	return $filename;
}
