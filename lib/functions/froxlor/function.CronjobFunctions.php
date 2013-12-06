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

/**
 * Function getNextCronjobs
 *
 * checks which cronjobs have to be executed
 *
 * @return	array	array of cron-files which are to be executed
 */
function getNextCronjobs() {

	$query = "SELECT `id`, `cronfile` FROM `".TABLE_PANEL_CRONRUNS."` WHERE `interval` <> '0' AND `isactive` = '1' AND (";

	$intervals = getIntervalOptions();
	$x = 0;

	foreach($intervals as $name => $ival) {

		if($name == '0') continue;

		if($x == 0) {
			$query.= "(UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME(`lastrun`), INTERVAL ".$ival.")) <= UNIX_TIMESTAMP() AND `interval` = '".$ival."')";
		} else {
			$query.= " OR (UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME(`lastrun`), INTERVAL ".$ival.")) <= UNIX_TIMESTAMP() AND `interval` = '".$ival."')";
		}
		$x++;
	}
	$query.= ');';

	$result = Database::query($query);

	$cron_files = array();
	// Update lastrun-timestamp
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$cron_files[] = $row['cronfile'];
		$upd_stmt = Database::prepare("
			UPDATE `".TABLE_PANEL_CRONRUNS."` SET `lastrun` = UNIX_TIMESTAMP() WHERE `id` = :id;"
		);
		Database::pexecute($upd_stmt, array('id' => $row['id']));
	}

	return $cron_files;
}

function includeCronjobs($debugHandler) {

	global $cronlog;

	$cronjobs = getNextCronjobs();

	$jobs_to_run = array();
	$cron_path = makeCorrectDir(FROXLOR_INSTALL_DIR.'/scripts/jobs/');

	if ($cronjobs !== false
		&& is_array($cronjobs)
		&& isset($cronjobs[0])
	) {
		foreach ($cronjobs as $cronjob) {
			$cron_file = makeCorrectFile($cron_path.$cronjob);
			if (!file_exists($cron_file)) {
				$cronlog->logAction(CRON_ACTION, LOG_ERROR, 'Wanted to include cronfile "'.$cron_file.'" but this file does not exist!!!');
			} else {
				$jobs_to_run[] = $cron_file;
			}
		}
	}

	return $jobs_to_run;
}


function getIntervalOptions() {

	global $lng, $cronlog;

	$query = "SELECT DISTINCT `interval` FROM `" . TABLE_PANEL_CRONRUNS . "` ORDER BY `interval` ASC;";
	$result = Database::query($query);

	$cron_intervals = array();
	$cron_intervals['0'] = $lng['panel']['off'];

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

		if (validateSqlInterval($row['interval'])) {
			$cron_intervals[$row['interval']] = $row['interval'];
		} else {
			$cronlog->logAction(CRON_ACTION, LOG_ERROR, "Invalid SQL-Interval ".$row['interval']." detected. Please fix this in the database.");
		}
	}

	return $cron_intervals;
}


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
		// deleteing email-account
		elseif ($row['type'] == '7') {
			$task_desc = $lng['tasks']['remove_emailacc_files'];
		}
		// Set FS - quota
		elseif ($row['type'] == '10') {
			$task_desc = $lng['tasks']['diskspace_set_quota'];
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
