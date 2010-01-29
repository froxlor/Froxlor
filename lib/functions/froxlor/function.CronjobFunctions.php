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
 * @version    $Id: function.includeCronjobs.php 138 2010-01-27 08:54:31Z Dessa $
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
	global $db;
	
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
	$cronjobs = getNextCronjobs();
	
	$jobs_to_run = array();
	
	if($cronjobs !== false
	&& is_array($cronjobs)
	&& isset($cronjobs[0]))
	{
		$cron_path = makeCorrectDir($pathtophpfiles.'/scripts/jobs/');
		
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
	global $db, $lng, $cronlog;

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
	global $db, $lng;
	
	$query = "SELECT `lastrun`, `desc_lng_key` FROM `".TABLE_PANEL_CRONRUNS."` WHERE `isactive` = '1' ORDER BY `cronfile` ASC";
	$result = $db->query($query);
	
	$cronjobs_last_run = '';

	while($row = $db->fetch_array($result))
	{	
		$lastrun = $lng['cronjobs']['notyetrun'];
		if($row['lastrun'] > 0) {
			$lastrun = date('d.m.Y H:i:s', $row['lastrun']);
		}
		
		$cronjobs_last_run .= '<tr>
			<td class="field_name_border_left">'.$lng['crondesc'][$row['desc_lng_key']].':</td>
			<td class="field_display">'.$lastrun.'</td>
		</tr>';
	}
	
	return $cronjobs_last_run;
}

function toggleCronStatus($module = null, $isactive = 0)
{
	global $db;
	
	if($isactive != 1) {
		$isactive = 0;
	}
	
	$query = "UPDATE `".TABLE_PANEL_CRONRUNS."` SET `isactive` = '".(int)$isactive."' WHERE `module` = '".$module."'";
	$db->query($query);

}

function getOutstandingTasks()
{
	global $db, $lng;
	
	$query = "SELECT * FROM `".TABLE_PANEL_TASKS."` ORDER BY `type` ASC";
	$result = $db->query($query);
	
	$outstanding_tasks = '<tr>
			<td class="field_name_border_left">'.$lng['tasks']['outstanding_tasks'].':</td>
			<td class="field_display" colspan="2"><ul>';

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

		if($task_desc != '') {
			$tasks .= '<li>'.$task_desc.'</li>';
		}
	}
	
	if(trim($tasks) == '') {
		$outstanding_tasks .= '<li>'.$lng['tasks']['noneoutstanding'].'</li>';
	} else {
		$outstanding_tasks .= $tasks;
	}
	
	$outstanding_tasks .= '</ul></td></tr>';
		
	return $outstanding_tasks;
}