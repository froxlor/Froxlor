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
	if (!isset($filename)
		|| trim($filename) == ''
	) {
		$error = 'Given filename for function '.__FUNCTION__.' is empty.'."\n";
		$error.= 'This is very dangerous and should not happen.'."\n";
		$error.= 'Please inform the Froxlor team about this issue so they can fix it.';
		die($error);
	}

	if(substr($filename, 0, 1) != '/')
	{
		$filename = '/' . $filename;
	}

	$filename = makeSecurePath($filename);
	return $filename;
}
