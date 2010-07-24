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
	elseif($type == '7'
			&& $param1 != ''
			&& $param2 != '')
	{
		$data = Array();
		$data['loginname'] = $param1;
		$data['email'] = $param2;
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`) VALUES ("7", "' . $db->escape($data) . '")');
		$doupdate = true;
	}
	elseif($type == '8'
			&& $param1 != ''
			&& $param2 != '')
	{
		$data = Array();
		$data['loginname'] = $param1;
		$data['homedir'] = $param2;
		$data = serialize($data);
		$db->query('INSERT INTO `' . TABLE_PANEL_TASKS . '` (`type`, `data`) VALUES ("8", "' . $db->escape($data) . '")');
		$doupdate = true;
	}

	if($doupdate === true
	   && (int)$settings['system']['realtime_port'] !== 0
	   && function_exists('socket_create'))
	{
		$timeout = 15;
		//$socket = @socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		$socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

		if($socket !== false)
		{
			// create the request packet
			$packet = chr(0) . chr(1) . 'RUN' . chr(0);
			// UDP is connectionless, so we just send on it.
			//@socket_sendto($socket, $packet, strlen($packet), 0x100, '127.0.0.1', (int)$settings['system']['realtime_port']);			

			/*
			 * this is for TCP-Connections
			 */
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
			/**
			 * close socket
			 */
			@socket_close($socket);
		}
	}
}
