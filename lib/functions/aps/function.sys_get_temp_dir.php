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

if(!function_exists('sys_get_temp_dir'))
{
	/**
	 * function will return the temporary directory where we can write data
	 * function exists as a fallback for php versions lower than 5.2.1
	 * source copied from php.net
	 *
	 * @author	Sven Skrabal <info@nexpa.de>
	 */

	function sys_get_temp_dir()
	{
		// Try to get from environment variable

		if(!empty($_ENV['TMP']))
		{
			return realpath($_ENV['TMP']);
		}
		elseif(!empty($_ENV['TMPDIR']))
		{
			return realpath($_ENV['TMPDIR']);
		}
		elseif(!empty($_ENV['TEMP']))
		{
			return realpath($_ENV['TEMP']);
		}
		else
		{
			// Detect by creating a temporary file
			// Try to use system's temporary directory
			// as random name shouldn't exist

			$temp_file = tempnam(md5(uniqid(rand(), true)), '');

			if($temp_file)
			{
				$temp_dir = realpath(dirname($temp_file));
				unlink($temp_file);
				return $temp_dir;
			}
			else
			{
				return false;
			}
		}
	}
}
