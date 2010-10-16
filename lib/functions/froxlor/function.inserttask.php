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

/**
 * Inserts a task into the PANEL_TASKS-Table
 *
 * @param int Type of task
 * @param string Parameter 1
 * @param string Parameter 2
 * @param string Parameter 3
 * @param string Parameter 4
 * 
 * @author Florian Lippert <flo@syscp.org> (2003-2009)
 * @author Froxlor team <team@froxlor.org> (2010-)
 */

function inserttask($type, $param1 = '', $param2 = '', $param3 = '', $param4 = '')
{
	global $db, $settings;
	
	// check for $server_id, if it's not set default to "master"
	$server_id = getServerId();

	if($type == '1'
	   || $type == '3'
	   || $type == '4'
	   || $type == '5')
	{
		$db->query('DELETE FROM `' . TABLE_PANEL_TASKS . '` WHERE `type`="' . $type . '"');
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `sid`) VALUES ("' . $type . '", "'.$server_id.'")');
	}
	elseif($type == '2'
	       && $param1 != ''
	       && $param2 != ''
	       && $param3 != ''
	       && $param4 != '')
	{
		$data = Array();
		$data['loginname'] = $param1;
		$data['uid'] = $param2;
		$data['gid'] = $param3;
		$data['store_defaultindex'] = $param4;
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`, `sid`) VALUES ("2", "' . $db->escape($data) . '", "'.$server_id.'")');
	}
	elseif($type == '6'
			&& $param1 != '')
	{
		$data = Array();
		$data['loginname'] = $param1;
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`, `sid`) VALUES ("6", "' . $db->escape($data) . '", "'.$server_id.'")');
	}
	elseif($type == '7'
			&& $param1 != ''
			&& $param2 != '')
	{
		$data = Array();
		$data['loginname'] = $param1;
		$data['email'] = $param2;
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`, `sid`) VALUES ("7", "' . $db->escape($data) . '", "'.$server_id.'")');
	}
	elseif($type == '8'
			&& $param1 != ''
			&& $param2 != '')
	{
		$data = Array();
		$data['loginname'] = $param1;
		$data['homedir'] = $param2;
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`, `sid`) VALUES ("8", "' . $db->escape($data) . '", "'.$server_id.'")');
	}
}
