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
 * Function checkLastGuid
 *
 * Checks if the system's last guid
 * is not higher than the one saved
 * in froxlor's database.
 * If it's higher, froxlor needs to
 * set its last guid to this one
 * to avoid conflicts with libnss-users
 *
 * @param	int		guid (from froxlor database)
 *
 * @return	null
 */
function checkLastGuid()
{
	global $log, $cronlog, $db, $settings, $theme;
	
	$mylog = null;
	if (isset($cronlog) && $cronlog instanceof FroxlorLogger) {
		$mylog = $cronlog;
	} else {
		$mylog = $log;
	}

	$group_lines = array();
	$group_guids = array();
	$update_to_guid = 0;
	
	$froxlor_guid = 0;
	$result = $db->query_first("SELECT MAX(`guid`) as `fguid` FROM `".TABLE_PANEL_CUSTOMERS."`");
	$froxlor_guid = $result['fguid'];

	$g_file = '/etc/group';

	if(file_exists($g_file))
	{
		if(is_readable($g_file))
		{
			if(true == ($groups = file_get_contents($g_file)))
			{
				$group_lines = explode("\n", $groups);

				foreach($group_lines as $group)
				{
					$group_guids[] = explode(":", $group);
				}

				foreach($group_guids as $idx => $group)
				{
					/**
					 * nogroup | nobody have very high guids
					 * ignore them
					 */
					if($group[0] == 'nogroup'
						|| $group[0] == 'nobody'
					) {
						continue;
					}

					$guid = isset($group[2]) ? (int)$group[2] : 0;

					if($guid > $update_to_guid)
					{
						$update_to_guid = $guid;
					}
				}

				if($update_to_guid < $froxlor_guid)
				{
					$update_to_guid = $froxlor_guid;
					
					if ($update_to_guid != $settings['system']['lastguid'])
					{
						$mylog->logAction(CRON_ACTION, LOG_NOTICE, 'Updating froxlor last guid to '.$update_to_guid);
						saveSetting('system', 'lastguid', $update_to_guid);
						$settings['system']['lastguid'] = $update_to_guid;
					}
				}
			}
			else
			{
				$mylog->logAction(CRON_ACTION, LOG_NOTICE, 'File /etc/group not readable; cannot check for latest guid');
			}
		}
		else
		{
			$mylog->logAction(CRON_ACTION, LOG_NOTICE, 'File /etc/group not readable; cannot check for latest guid');
		}
	}
	else
	{
		$cronlog->logAction(CRON_ACTION, LOG_NOTICE, 'File /etc/group does not exist; cannot check for latest guid');
	}
}
