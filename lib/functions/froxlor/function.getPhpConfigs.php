<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id$
 */

/**
 * returns an array for the settings-array
 * 
 * @return array
 */
function getPhpConfigs()
{
	global $db;
	
	$query = 'SELECT * FROM `' . TABLE_PANEL_PHPCONFIGS . '` ';
	$result = $db->query($query);
	$configs_array = array();

	while($row = $db->fetch_array($result))
	{
		if(!isset($configs_array[$row['id']])
		   && !in_array($row['id'], $configs_array))
		{
			$configs_array[$row['id']] = html_entity_decode($row['description']);
		}
	}

	return $configs_array;
}
