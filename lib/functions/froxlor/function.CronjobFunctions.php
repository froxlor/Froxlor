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

/*
 * Function getNextCronjobs
 *
 * checks which cronjobs have to be executed
 *
 * @return	array	array of cron-files which are to be executed
 */
function getNextCronjobs()
{
	global $db, $theme;

	$query = "SELECT `id`, `cronfile` FROM `".TABLE_PANEL_CRONRUNS."` WHERE `interval` <> '0' AND `isactive` = '1' AND (";

	$intervals = getIntervalOptions();

	$x = 0;
	foreach($intervals as $name => $ival)
	{
		if($name == '0') continue;

		if($x == 0) {
			$query.= '(UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME(`lastrun`), INTERVAL '.$ival.')) <= UNIX_TIMESTAMP() AND `interval`=\''.$ival.'\')';
		} else {
			$query.= ' OR (UNIX_TIMESTAMP(DATE_ADD(FROM_UNIXTIME(`lastrun`), INTERVAL '.$ival.')) <= UNIX_TIMESTAMP() AND `interval`=\''.$ival.'\')';
		}
		$x++;
	}

	$query.= ');';

	$result = $db->query($query);

	$cron_files = array();
	while($row = $db->fetch_array($result))
	{
		$cron_files[] = $row['cronfile'];
		$db->query("UPDATE `".TABLE_PANEL_CRONRUNS."` SET `lastrun` = UNIX_TIMESTAMP() WHERE `id` ='".(int)$row['id']."';");
	}

	return $cron_files;
}


function includeCronjobs($debugHandler, $pathtophpfiles)
{
	global $settings, $theme;

	$cronjobs = getNextCronjobs();

	$jobs_to_run = array();
	$cron_path = makeCorrectDir($pathtophpfiles.'/scripts/jobs/');

	if($cronjobs !== false
	&& is_array($cronjobs)
	&& isset($cronjobs[0]))
	{
		foreach($cronjobs as $cronjob)
		{
			$cron_file = makeCorrectFile($cron_path.$cronjob);
			$jobs_to_run[] = $cron_file;
		}
	}

	return $jobs_to_run;
}


function getIntervalOptions()
{
	global $db, $lng, $cronlog, $theme;

	$query = "SELECT DISTINCT `interval` FROM `" . TABLE_PANEL_CRONRUNS . "` ORDER BY `interval` ASC;";
	$result = $db->query($query);
	$cron_intervals = array();

	$cron_intervals['0'] = $lng['panel']['off'];

	while($row = $db->fetch_array($result))
	{
		if(validateSqlInterval($row['interval']))
		{
			$cron_intervals[$row['interval']] = $row['interval'];
		}
		else
		{
			$cronlog->logAction(CRON_ACTION, LOG_ERROR, "Invalid SQL-Interval ".$row['interval']." detected. Please fix this in the database.");
		}
	}

	return $cron_intervals;
}


function getCronjobsLastRun()
{
	global $db, $lng, $theme;

	$query = "SELECT `lastrun`, `desc_lng_key` FROM `".TABLE_PANEL_CRONRUNS."` WHERE `isactive` = '1' ORDER BY `cronfile` ASC";
	$result = $db->query($query);

	$cronjobs_last_run = '';

	while($row = $db->fetch_array($result))
	{
		$lastrun = $lng['cronjobs']['notyetrun'];
		if($row['lastrun'] > 0) {
			$lastrun = date('d.m.Y H:i:s', $row['lastrun']);
		}

		$text = $lng['crondesc'][$row['desc_lng_key']];
		$value = $lastrun;

		eval("\$cronjobs_last_run .= \"" . getTemplate("index/overview_item") . "\";");
	}

	return $cronjobs_last_run;
}

function toggleCronStatus($module = null, $isactive = 0)
{
	global $db, $theme;

	if($isactive != 1) {
		$isactive = 0;
	}

	$query = "UPDATE `".TABLE_PANEL_CRONRUNS."` SET `isactive` = '".(int)$isactive."' WHERE `module` = '".$module."'";
	$db->query($query);

}

function getOutstandingTasks()
{
	global $db, $lng, $theme;

	$query = "SELECT * FROM `".TABLE_PANEL_TASKS."` ORDER BY `type` ASC";
	$result = $db->query($query);

	$value = '<ul class="cronjobtask">';
	$tasks = '';
	while($row = $db->fetch_array($result))
	{
		if($row['data'] != '')
		{
			$row['data'] = unserialize($row['data']);
		}

		/*
		 * rebuilding webserver-configuration
		 */
		if($row['type'] == '1')
		{
			$task_desc = $lng['tasks']['rebuild_webserverconfig'];
		}
		/*
		 * adding new user
		 */
		elseif($row['type'] == '2')
		{
			$loginname = '';
			if(is_array($row['data']))
			{
				$loginname = $row['data']['loginname'];
			}
			$task_desc = $lng['tasks']['adding_customer'];
			$task_desc = str_replace('%loginname%', $loginname, $task_desc);
		}
		/*
		 * rebuilding bind-configuration
		 */
		elseif($row['type'] == '4')
		{
			$task_desc = $lng['tasks']['rebuild_bindconfig'];
		}
		/*
		 * creating ftp-user directory
		 */
		elseif($row['type'] == '5')
		{
			$task_desc = $lng['tasks']['creating_ftpdir'];
		}
		/*
		 * deleting user-files
		 */
		elseif($row['type'] == '6')
		{
			$loginname = '';
			if(is_array($row['data']))
			{
				$loginname = $row['data']['loginname'];
			}
			$task_desc = $lng['tasks']['deleting_customerfiles'];
			$task_desc = str_replace('%loginname%', $loginname, $task_desc);
		}
		elseif($row['type'] == '7')
		{
			$task_desc = $lng['tasks']['remove_emailacc_files'];
		}
		/*
		 * Set FS - quota
		 */
		elseif($row['type'] == '10')
		{
			$task_desc = $lng['tasks']['diskspace_set_quota'];
		}
		else
		{
			$task_desc = "ERROR: Unknown task type '".$row['type'].
			             "'";
		}

		if($task_desc != '') {
			$tasks .= '<li>'.$task_desc.'</li>';
		}
	}

	$query2 = "SELECT DISTINCT `Task` FROM `".TABLE_APS_TASKS."` ORDER BY `Task` ASC";
	$result2 = $db->query($query2);

	while($row2 = $db->fetch_array($result2))
	{
		/*
		 * install
		 */
		if($row2['Task'] == '1')
		{
			$task_desc = $lng['tasks']['aps_task_install'];
		}
		/*
		 * remove
		 */
		elseif($row2['Task'] == '2')
		{
			$task_desc = $lng['tasks']['aps_task_remove'];
		}
		/*
		 * reconfigure
		 */
		elseif($row2['Task'] == '3')
		{
			$task_desc = $lng['tasks']['aps_task_reconfigure'];
		}
		/*
		 * upgrade
		 */
		elseif($row2['Task'] == '4')
		{
			$task_desc = $lng['tasks']['aps_task_upgrade'];
		}
		/*
		 * system update
		 */
		elseif($row2['Task'] == '5')
		{
			$task_desc = $lng['tasks']['aps_task_sysupdate'];
		}
		/*
		 * system download
		 */
		elseif($row2['Task'] == '6')
		{
			$task_desc = $lng['tasks']['aps_task_sysdownload'];
		}

		if($task_desc != '') {
			$tasks .= '<li>'.$task_desc.'</li>';
		}
	}

	if(trim($tasks) == '') {
		$value .= '<li>'.$lng['tasks']['noneoutstanding'].'</li>';
	} else {
		$value .= $tasks;
	}

	$value .= '</ul>';
	$text = $lng['tasks']['outstanding_tasks'];
	eval("\$outstanding_tasks = \"" . getTemplate("index/overview_item") . "\";");

	return $outstanding_tasks;
}
