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
 * Inserts a task into the PANEL_TASKS-Table
 *
 * @param
 *        	int Type of task
 * @param
 *        	string Parameter 1
 * @param
 *        	string Parameter 2
 * @param
 *        	string Parameter 3
 * @author Florian Lippert <flo@syscp.org>
 * @author Froxlor team <team@froxlor.org>
 */
function inserttask($type, $param1 = '', $param2 = '', $param3 = '', $param4 = '')
{

	// prepare the insert-statement
	$ins_stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_TASKS . "` SET `type` = :type, `data` = :data
	");

	if ($type == '1' || $type == '3' || $type == '4' || $type == '5' || $type == '10' || $type == '99') {
		// 4 = bind -> if bind disabled -> no task
		if ($type == '4' && Settings::Get('system.bind_enable') == '0') {
			return;
		}
		// 10 = quota -> if quota disabled -> no task
		if ($type == '10' && Settings::Get('system.diskquota_enabled') == '0') {
			return;
		}

		// delete previously inserted tasks if they are the same as we only need ONE
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = :type
		");
		Database::pexecute($del_stmt, array(
			'type' => $type
		));

		// insert the new task
		Database::pexecute($ins_stmt, array(
			'type' => $type,
			'data' => ''
		));
	} elseif ($type == '2' && $param1 != '' && $param2 != '' && $param3 != '' && ($param4 == 0 || $param4 == 1)) {
		$data = array();
		$data['loginname'] = $param1;
		$data['uid'] = $param2;
		$data['gid'] = $param3;
		$data['store_defaultindex'] = $param4;
		$data = json_encode($data);
		Database::pexecute($ins_stmt, array(
			'type' => '2',
			'data' => $data
		));
	} elseif ($type == '6' && $param1 != '') {
		$data = array();
		$data['loginname'] = $param1;
		$data = json_encode($data);
		Database::pexecute($ins_stmt, array(
			'type' => '6',
			'data' => $data
		));
	} elseif ($type == '7' && $param1 != '' && $param2 != '') {
		$data = array();
		$data['loginname'] = $param1;
		$data['email'] = $param2;
		$data = json_encode($data);
		Database::pexecute($ins_stmt, array(
			'type' => '7',
			'data' => $data
		));
	} elseif ($type == '8' && $param1 != '' && $param2 != '') {
		$data = array();
		$data['loginname'] = $param1;
		$data['homedir'] = $param2;
		$data = json_encode($data);
		Database::pexecute($ins_stmt, array(
			'type' => '8',
			'data' => $data
		));
	} elseif ($type == '11' && $param1 != '') {
		$data = array();
		$data['domain'] = $param1;
		$data = json_encode($data);
		Database::pexecute($ins_stmt, array(
			'type' => '11',
			'data' => $data
		));
	} elseif ($type == '20' && is_array($param1)) {
		$data = json_encode($param1);
		Database::pexecute($ins_stmt, array(
			'type' => '20',
			'data' => $data
		));
	}
}
