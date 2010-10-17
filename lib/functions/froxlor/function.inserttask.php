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
 * @author Florian Lippert <flo@syscp.org> (2003-2009)
 * @author Froxlor team <team@froxlor.org> (2010-)
 */

function inserttask()
{
	global $db, $settings;
	
	$numargs = func_num_args();
	
	if($numargs <= 0) {
		// no arguments given, exiting
		return;
	}

	// type will always be the first argument
	$type = func_get_arg(0);

	// server-id will always be the last argument
	// (if not set, use id of master (0)
	$server_id = ($numargs-1 <= 0) ? 0 : func_get_arg($numargs-1);

	// get the rest of the params
	$taskparams = array();
	for($x=1;$x<$numargs-1;$x++)
	{
		$taskparams[] = func_get_arg($x);		
	}

	// if server_id = -1 then add this task for EVERY froxlor-client
	if($server_id == -1)
	{
		// @TODO implement function to get number of froxlor-clients
		/*
		$numclients = getNumberOfFroxlorClients();
		foreach($numclients as $froxclient_id)
		{
			inserttask($type, implode(', ', $taskparams), $froxclient_id);
		}
		*/
		// also for the master
		inserttask($type, implode(', ', $taskparams), 0);
		return;
	}

	if($type == '1'
	   || $type == '3'
	   || $type == '4'
	   || $type == '5')
	{
		$db->query('DELETE FROM `' . TABLE_PANEL_TASKS . '` WHERE `type`="' . $type . '"');
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `sid`) VALUES ("' . $type . '", "'.$server_id.'")');
	}
	elseif($type == '2'
	       && $taskparams[0] != ''
	       && $taskparams[1] != ''
	       && $taskparams[2] != ''
	       && $taskparams[3] != '')
	{
		$data = Array();
		$data['loginname'] = $taskparams[0];
		$data['uid'] = $taskparams[1];
		$data['gid'] = $taskparams[2];
		$data['store_defaultindex'] = $taskparams[3];
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`, `sid`) VALUES ("2", "' . $db->escape($data) . '", "'.$server_id.'")');
	}
	elseif($type == '6'
			&& $taskparams[0] != '')
	{
		$data = Array();
		$data['loginname'] = $taskparams[0];
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`, `sid`) VALUES ("6", "' . $db->escape($data) . '", "'.$server_id.'")');
	}
	elseif($type == '7'
			&& $taskparams[0] != ''
			&& $taskparams[1] != '')
	{
		$data = Array();
		$data['loginname'] = $taskparams[0];
		$data['email'] = $taskparams[1];
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`, `sid`) VALUES ("7", "' . $db->escape($data) . '", "'.$server_id.'")');
	}
	elseif($type == '8'
			&& $taskparams[0] != ''
			&& $taskparams[1] != '')
	{
		$data = Array();
		$data['loginname'] = $taskparams[0];
		$data['homedir'] = $taskparams[1];
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`, `sid`) VALUES ("8", "' . $db->escape($data) . '", "'.$server_id.'")');
	}
}
