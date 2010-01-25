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
 * @version    $Id$
 */

/**
 * Inserts a task into the PANEL_TASKS-Table
 *
 * @param int Type of task
 * @param string Parameter 1
 * @param string Parameter 2
 * @param string Parameter 3
 * @author Florian Lippert <flo@syscp.org>
 */

function inserttask($type, $param1 = '', $param2 = '', $param3 = '')
{
	global $db, $settings;

	if($type == '1'
	   || $type == '3'
	   || $type == '4'
	   || $type == '5')
	{
		$db->query('DELETE FROM `' . TABLE_PANEL_TASKS . '` WHERE `type`="' . $type . '"');
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`) VALUES ("' . $type . '")');
		$doupdate = true;
	}
	elseif($type == '2'
	       && $param1 != ''
	       && $param2 != ''
	       && $param3 != '')
	{
		$data = Array();
		$data['loginname'] = $param1;
		$data['uid'] = $param2;
		$data['gid'] = $param3;
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`) VALUES ("2", "' . $db->escape($data) . '")');
		$doupdate = true;
	}
	elseif($type == '6'
			&& $param1 != '')
	{
		$data = Array();
		$data['loginname'] = $param1;
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`) VALUES ("6", "' . $db->escape($data) . '")');
		$doupdate = true;
	}

	if($doupdate === true
	   && (int)$settings['system']['realtime_port'] !== 0)
	{
		$timeout = 15;
		$socket = @socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

		if($socket !== false)
		{
			// create the request packet
			$packet = chr(0) . chr(1) . 'RUN' . chr(0);
			// UDP is connectionless, so we just send on it.
			@socket_sendto($socket, $packet, strlen($packet), 0x100, '127.0.0.1', (int)$settings['system']['realtime_port']);			

			/*
			 * this is for TCP-Connections
			 * 
			$time = time();

			while(!@socket_connect($socket, '127.0.0.1', (int)$settings['system']['realtime_port']))
			{
				$err = socket_last_error($socket);

				if($err == 115
				   || $err == 114)
				{
					if((time() - $time) >= $timeout)
					{
						break;
					}

					sleep(1);
					continue;
				}
			}
			*/
			@socket_close($socket);
		}
	}
}
