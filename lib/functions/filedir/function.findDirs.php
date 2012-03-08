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
 * @author Fabian Petzold <mail@fpcom.de>
 */

function _findDirs($list, &$_fileList, $counter, $limit, $filter)
{
	foreach($list AS $path) 
	{
		$_fileList[] = $path;

		$tmp = scandir($path);
		$list2 = array();
		foreach($tmp AS $fo)
		{
			if(is_dir($path.$fo) && $fo != "." && $fo != ".." && !preg_match("/".$filter."/i", $fo))
			{
				array_push($list2, $path.$fo."/");
			}
		}

		if( $counter < $limit)
		{
			_findDirs($list2, &$_fileList, $counter+1, $limit, $filter);
		}
	}
}

function findDirs($path, $uid, $gid)
{
	$list = array(
		$path
	);
	$_fileList = array();
	$filter    = "log|tmp";
	$limit     = 2;
	_findDirs($list, &$_fileList, 0, $limit, $filter);

	return $_fileList;
}

