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
 * Checks if a given directory is valid for multiple configurations
 * or should rather be used as a single file
 *
 * @param  string The dir
 * @return bool   true if usable as dir, false otherwise
 *
 * @author Florian Lippert <flo@syscp.org>
 */

function isConfigDir($dir)
{
	if(file_exists($dir))
	{
		if(is_dir($dir))
		{
			$returnval = true;
		}
		else
		{
			$returnval = false;
		}
	}
	else
	{
		if(substr($dir, -1) == '/')
		{
			$returnval = true;
		}
		else
		{
			$returnval = false;
		}
	}

	return $returnval;
}
