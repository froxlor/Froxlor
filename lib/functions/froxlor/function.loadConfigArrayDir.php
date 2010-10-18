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
 * @version    $Id$
 */

function loadConfigArrayDir()
{
	// Workaround until we use gettext
	global $lng;

	// we now use dynamic function parameters
	// so we can read from more than one directory
	// and still be valid for old calls
	$numargs = func_num_args();
	if($numargs <= 0) { return null; }

	$configdirs = array();
	for($x=0;$x<$numargs;$x++) {
		$configdirs[] = func_get_arg($x);
	}

	$data = array();
	$data_files = array();
	$has_data = false;

	foreach($configdirs as $data_dirname)
	{
		if(is_dir($data_dirname))
		{
			$data_dirhandle = opendir($data_dirname);
			while(false !== ($data_filename = readdir($data_dirhandle)))
			{
				if($data_filename != '.' && $data_filename != '..' && $data_filename != '' && substr($data_filename, -4 ) == '.php')
				{
					$data_files[] = $data_dirname . $data_filename;
				}
			}
			$has_data = true;
		}
	}
	
	if($has_data)
	{
		sort($data_files);

		foreach($data_files as $data_filename)
		{
			$data = array_merge_recursive($data, include($data_filename));
		}
	}
	
	return $data;
}
