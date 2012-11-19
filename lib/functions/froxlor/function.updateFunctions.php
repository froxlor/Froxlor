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
 * Function updateToVersion
 *
 * updates the panel.version field
 * to the given value (no checks here!)
 *
 * @param	string		new-version
 *
 * @return	bool		true on success, else false
 */
function updateToVersion($new_version = null)
{
	global $db, $settings, $theme;

	if($new_version !== null && $new_version != '')
	{
		$query = "UPDATE `".TABLE_PANEL_SETTINGS."` SET `value` = '" . $new_version . "' WHERE `settinggroup` = 'panel' AND `varname` = 'version'";
		$db->query($query);
		$settings['panel']['version'] = $new_version;
		return true;
	}
	return false;
}

/*
 * Function isFroxlor
 *
 * checks if the panel is froxlor
 *
 * @return	bool		true if panel is froxlor, else false
 */
function isFroxlor()
{
	global $settings, $theme;

	if(isset($settings['panel']['frontend'])
	&& $settings['panel']['frontend'] == 'froxlor')
	{
		return true;
	}
	return false;
}

/*
 * Function isFroxlorVersion
 *
 * checks if a given version is the
 * current one (and panel is froxlor)
 *
 * @param	string		version to check
 *
 * @return	bool		true if version to check matches, else false
 */
function isFroxlorVersion($to_check = null)
{
	global $settings, $theme;

	if($settings['panel']['frontend'] == 'froxlor'
	&& $settings['panel']['version'] == $to_check)
	{
		return true;
	}
	return false;
}

/*
 * Function isFroxlorVersion
 *
 * checks if a given version is the
 * current one (and panel is froxlor)
 *
 * @param	string		version to check
 *
 * @return	bool		true if version to check matches, else false
 */
function hasUpdates($to_check = null)
{
	global $settings, $theme;

	if(!isset($settings['panel']['version'])
	|| $settings['panel']['version'] != $to_check)
	{
		return true;
	}
	return false;
}

/*
 * Function showUpdateStep
 *
 * outputs and logs the current
 * update progress
 *
 * @param	string		task/status
 * @param	bool		needs_status (if false, a linebreak will be added)
 *
 * @return	string		formatted output and log-entry
 */
function showUpdateStep($task = null, $needs_status = true)
{
	global $updatelog, $filelog, $theme;
	
	// output
	echo $task;
	
	if(!$needs_status)
	{
		echo "<br />";
	}
	
	$updatelog->logAction(ADM_ACTION, LOG_WARNING, $task);
	$filelog->logAction(ADM_ACTION, LOG_WARNING, $task);
}

/*
 * Function lastStepStatus
 * 
 * outputs [OK] (success), [??] (warning) or [!!] (failure)
 * of the last update-step
 * 
 * @param	int			status	(0 = success, 1 = warning, 2 = failure)
 * 
 * @return	string		formatted output and log-entry
 */
function lastStepStatus($status = -1, $message = '')
{
	global $updatelog, $filelog, $theme;
	
	switch($status)
	{
		case 0:
			$status_sign = ($message != '') ? '['.$message.']' : '[OK]';
			$status_color = '1dcd00';
			break;
		case 1:
			$status_sign = ($message != '') ? '['.$message.']' : '[??]';
			$status_color = 'db7100';			
			break;
		case 2:
			$status_sign = ($message != '') ? '['.$message.']' : '[!!]';
			$status_color = 'ff0000';			
			break;
		default:
			$status_sign = '[unknown]';
			$status_color = '000000';			
			break;
	}
	// output
	echo "<span style=\"margin-left: 5em; font-weight: bold; color: #".$status_color."\">".$status_sign."</span><br />";
	
	if($status == -1 || $status == 2)
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, 'Attention - last update task failed!!!');
		$filelog->logAction(ADM_ACTION, LOG_WARNING, 'Attention - last update task failed!!!');
	}
	elseif($status == 0 || $status == 1)
	{
		$filelog->logAction(ADM_ACTION, LOG_WARNING, 'Success');
	}
}

/**
 * validate if full path to update.log is sane
 * if not, the update.log is created in /tmp/
 *  
 * @param string $filename the file name to validate
 * 
 * @return string the full path with filename (can differ if not writeable => /tmp)
 */
function validateUpdateLogFile($filename)
{
	if(!is_dir($filename))
	{
		$fh = @fopen($filename, 'a');
		if($fh)
		{
			fclose($fh);
			return $filename;
		}
	}
	return '/tmp/froxlor_update.log';
}
