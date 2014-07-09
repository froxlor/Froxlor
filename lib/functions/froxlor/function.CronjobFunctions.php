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
 *
 */

function getCronjobsLastRun() {

	global $lng;

	$query = "SELECT `lastrun`, `desc_lng_key` FROM `".TABLE_PANEL_CRONRUNS."` WHERE `isactive` = '1' ORDER BY `cronfile` ASC";
	$result = Database::query($query);

	$cronjobs_last_run = '';
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

		$lastrun = $lng['cronjobs']['notyetrun'];
		if ($row['lastrun'] > 0) {
			$lastrun = date('d.m.Y H:i:s', $row['lastrun']);
		}

		$text = $lng['crondesc'][$row['desc_lng_key']];
		$value = $lastrun;

		eval("\$cronjobs_last_run .= \"" . getTemplate("index/overview_item") . "\";");
	}

	return $cronjobs_last_run;
}

function toggleCronStatus($module = null, $isactive = 0) {

	if($isactive != 1) {
		$isactive = 0;
	}

	$upd_stmt = Database::prepare("
		UPDATE `".TABLE_PANEL_CRONRUNS."` SET `isactive` = :active WHERE `module` = :module"
	);
	Database::pexecute($upd_stmt, array('active' => $isactive, 'module' => $module));
}

function getOutstandingTasks() {

	global $lng;

	$query = "SELECT * FROM `".TABLE_PANEL_TASKS."` ORDER BY `type` ASC";
	$result = Database::query($query);

	$value = '<ul class="cronjobtask">';
	$tasks = '';
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

		if ($row['data'] != '') {
			$row['data'] = unserialize($row['data']);
		}

		// rebuilding webserver-configuration
		if ($row['type'] == '1') {
			$task_desc = $lng['tasks']['rebuild_webserverconfig'];
		}
		// adding new user/
		elseif ($row['type'] == '2') {
			$loginname = '';
			if (is_array($row['data'])) {
				$loginname = $row['data']['loginname'];
			}
			$task_desc = $lng['tasks']['adding_customer'];
			$task_desc = str_replace('%loginname%', $loginname, $task_desc);
		}
		// rebuilding bind-configuration
		elseif ($row['type'] == '4') {
			$task_desc = $lng['tasks']['rebuild_bindconfig'];
		}
		// creating ftp-user directory
		elseif ($row['type'] == '5') {
			$task_desc = $lng['tasks']['creating_ftpdir'];
		}
		// deleting user-files
		elseif ($row['type'] == '6') {
			$loginname = '';
			if (is_array($row['data'])) {
				$loginname = $row['data']['loginname'];
			}
			$task_desc = $lng['tasks']['deleting_customerfiles'];
			$task_desc = str_replace('%loginname%', $loginname, $task_desc);
		}
		// deleting email-account
		elseif ($row['type'] == '7') {
			$task_desc = $lng['tasks']['remove_emailacc_files'];
		}
		// deleting ftp-account
		elseif ($row['type'] == '8') {
			$task_desc = $lng['tasks']['remove_ftpacc_files'];
		}
		// Set FS - quota
		elseif ($row['type'] == '10') {
			$task_desc = $lng['tasks']['diskspace_set_quota'];
		}
		// re-generating of cron.d-file
		elseif ($row['type'] == '99') {
			$task_desc = $lng['tasks']['regenerating_crond'];
		}
		// unknown
		else {
			$task_desc = "ERROR: Unknown task type '".$row['type']."'";
		}

		if($task_desc != '') {
			$tasks .= '<li>'.$task_desc.'</li>';
		}
	}

	if (trim($tasks) == '') {
		$value .= '<li>'.$lng['tasks']['noneoutstanding'].'</li>';
	} else {
		$value .= $tasks;
	}

	$value .= '</ul>';
	$text = $lng['tasks']['outstanding_tasks'];
	eval("\$outstanding_tasks = \"" . getTemplate("index/overview_item") . "\";");

	return $outstanding_tasks;
}
