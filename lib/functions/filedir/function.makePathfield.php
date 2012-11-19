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
 * Returns a valid html tag for the choosen $fieldType for pathes
 *
 * @param string  path      The path to start searching in
 * @param integer uid       The uid which must match the found directories
 * @param integer gid       The gid which must match the found direcotries
 * @param string  fieldType Either "Manual" or "Dropdown"
 * @param string  value     the value for the input-field
 * 
 * @return string   The html tag for the choosen $fieldType
 *
 * @author Martin Burchert  <martin.burchert@syscp.de>
 * @author Manuel Bernhardt <manuel.bernhardt@syscp.de>
 */

function makePathfield($path, $uid, $gid, $fieldType, $value = '', $dom = false)
{
	global $lng, $theme;

	$value = str_replace($path, '', $value);
	$field = array();

	// path is given without starting slash
	// but dirList holds the paths with starting slash
	// so we just add one here to get the correct
	// default path selected, #225
	if (substr($value, 0, 1) != '/' && !$dom) {
		$value = '/'.$value;
	}

	if($fieldType == 'Manual')
	{
		$field = array(
			'type' => 'text',
			'value' => htmlspecialchars($value)
		);
		
	}
	elseif($fieldType == 'Dropdown')
	{
		$dirList = findDirs($path, $uid, $gid);
		
		natcasesort($dirList);

		if(sizeof($dirList) > 0)
		{
			if(sizeof($dirList) <= 100)
			{
				$_field = '';
				foreach($dirList as $key => $dir)
				{
					if(strpos($dir, $path) === 0)
					{
						$dir = makeCorrectDir(substr($dir, strlen($path)));
					}
	
					$_field.= makeoption($dir, $dir, $value);
				}
				$field = array(
					'type' => 'select',
					'value' => $_field
				);
			}
			else
			{
				// remove starting slash we added
				// for the Dropdown, #225
				$value = substr($value, 1);
				//$field = $lng['panel']['toomanydirs'];
				$field = array(
					'type' => 'text',
					'value' => htmlspecialchars($value),
					'note' => $lng['panel']['toomanydirs']
				);
			}
		}
		else
		{
			//$field = $lng['panel']['dirsmissing'];
			//$field = '<input type="hidden" name="path" value="/" />';
			$field = array(
				'type' => 'hidden',
				'value' => '/',
				'note' => $lng['panel']['dirsmissing']
			);
		}
	}

	return $field;
}
