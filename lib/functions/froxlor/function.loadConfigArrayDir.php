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

function loadConfigArrayDir()
{
	// Workaround until we use gettext
	global $lng, $theme;

	// we now use dynamic function parameters
	// so we can read from more than one directory
	// and still be valid for old calls
	$numargs = func_num_args();
	if($numargs <= 0) { return null; }

	// variable that holds all dirs that will
	// be parsed for inclusion
	$configdirs = array();
	// if one of the parameters is an array
	// we assume that this is a list of
	// setting-groups to be selected
	$selection = null;
	for($x=0;$x<$numargs;$x++) {
		$arg = func_get_arg($x);
		if(is_array($arg) && isset($arg[0])) {
			$selection = $arg;
		} else {
			$configdirs[] = $arg;
		}
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

	// if we have specific setting-groups
	// to select, we'll handle this here
	// (this is for multiserver-client settings)
	$_data = array();
	if($selection != null
		&& is_array($selection)
		&& isset($selection[0])
	) {
		$_data['groups'] = array();
		foreach($data['groups'] as $group => $data)
		{
			if(in_array($group, $selection)) {
				$_data['groups'][$group] = $data;  
			}
		}
		$data = $_data;
	}

	return $data;
}
