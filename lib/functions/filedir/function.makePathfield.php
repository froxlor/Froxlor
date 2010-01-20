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
 * @version    $Id: function.makePathfield.php 2724 2009-06-07 14:18:02Z flo $
 */

/**
 * Returns a valid html tag for the choosen $fieldType for pathes
 *
 * @param  string   path       The path to start searching in
 * @param  integer  uid        The uid which must match the found directories
 * @param  integer  gid        The gid which must match the found direcotries
 * @param  string   fieldType  Either "Manual" or "Dropdown"
 * @return string   The html tag for the choosen $fieldType
 *
 * @author Martin Burchert  <martin.burchert@syscp.de>
 * @author Manuel Bernhardt <manuel.bernhardt@syscp.de>
 */

function makePathfield($path, $uid, $gid, $fieldType, $value = '')
{
	global $lng;
	$value = str_replace($path, '', $value);
	$field = '';

	if($fieldType == 'Manual')
	{
		$field = '<input type="text" name="path" value="' . htmlspecialchars($value) . '" size="30" />';
	}
	elseif($fieldType == 'Dropdown')
	{
		$dirList = findDirs($path, $uid, $gid);
		
		natcasesort($dirList);

		if(sizeof($dirList) > 0)
		{
			$field = '<select name="path">';
			foreach($dirList as $key => $dir)
			{
				if(strpos($dir, $path) === 0)
				{
					$dir = makeCorrectDir(substr($dir, strlen($path)));
				}

				$field.= makeoption($dir, $dir, $value);
			}

			$field.= '</select>';
		}
		else
		{
			$field = $lng['panel']['dirsmissing'];
			$field.= '<input type="hidden" name="path" value="/" />';
		}
	}

	return $field;
}
