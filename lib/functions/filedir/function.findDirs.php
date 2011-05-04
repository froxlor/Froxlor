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
 * Returns an array of found directories
 *
 * This function checks every found directory if they match either $uid or $gid, if they do
 * the found directory is valid. It uses recursive function calls to find subdirectories. Due
 * to the recursive behauviour this function may consume much memory.
 *
 * @param  string   path       The path to start searching in
 * @param  integer  uid        The uid which must match the found directories
 * @param  integer  gid        The gid which must match the found direcotries
 * @param  array    _fileList  recursive transport array !for internal use only!
 * @return array    Array of found valid pathes
 *
 * @author Martin Burchert  <martin.burchert@syscp.de>
 * @author Manuel Bernhardt <manuel.bernhardt@syscp.de>
 */

function findDirs($path, $uid, $gid)
{
	$list = array(
		$path
	);
	$_fileList = array();

	while(sizeof($list) > 0)
	{
		$path = array_pop($list);
		$path = makeCorrectDir($path);
		
		if(!is_readable($path) || !is_executable($path))
		{
			//return $_fileList;
			// only 'skip' this directory, #611
			continue;
		}

		$dh = opendir($path);

		if($dh === false)
		{
			/*
			 * this should never be called because we checked
			 * 'is_readable' before...but we never know what might happen
			 */
			standard_error('cannotreaddir', $path);
			return null;
		}
		else
		{
			while(false !== ($file = @readdir($dh)))
			{
				if($file == '.'
				   && (fileowner($path . '/' . $file) == $uid || filegroup($path . '/' . $file) == $gid))
				{
					$_fileList[] = makeCorrectDir($path);
				}

				if(is_dir($path . '/' . $file)
				   && $file != '..'
				   && $file != '.')
				{
					array_push($list, $path . '/' . $file);
				}
			}

			@closedir($dh);
		}
	}

	return $_fileList;
}
