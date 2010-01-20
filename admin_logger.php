<?php

/**
 * System-Logger - Admin
 *
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. This program is distributed in the
 * hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @license    http://www.gnu.org/licenses/gpl.txt
 * @package    Panel
 * @version    CVS: $Id: admin_logger.php 2452 2008-11-30 13:12:36Z flo $
 * @link       http://www.nutime.de/
 * @since      File available since Release 1.2.20
 */

define('AREA', 'admin');

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if($page == 'log'
   && $userinfo['change_serversettings'] == '1')
{
	if($action == '')
	{
		$fields = array(
			'action' => $lng['logger']['action'],
			'date' => $lng['logger']['date'],
			'type' => $lng['logger']['type'],
			'user' => $lng['logger']['user']
		);
		$paging = new paging($userinfo, $db, TABLE_PANEL_LOG, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$paging->sortfield = 'date';
		$paging->sortorder = 'desc';
		$result = $db->query('SELECT * FROM `' . TABLE_PANEL_LOG . '` ' . $paging->getSqlWhere(false) . ' ' . $paging->getSqlOrderBy() . ' ' . $paging->getSqlLimit());
		$paging->setEntries($db->num_rows($result));
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$clog = array();

		while($row = $db->fetch_array($result))
		{
			if(!isset($clog[$row['action']])
			   || !is_array($clog[$row['action']]))
			{
				$clog[$row['action']] = array();
			}

			$clog[$row['action']][$row['logid']] = $row;
		}

		if($paging->sortfield == 'date'
		   && $paging->sortorder == 'desc')
		{
			krsort($clog);
		}
		else
		{
			ksort($clog);
		}

		$i = 0;
		$count = 0;
		$log_count = 0;
		$log = '';
		foreach($clog as $action => $logrows)
		{
			$_action = 0;
			foreach($logrows as $row)
			{
				if($paging->checkDisplay($i))
				{
					$row = htmlentities_array($row);
					$row['date'] = date("d.m.y H:i:s", $row['date']);

					if($_action != $action)
					{
						switch($action)
						{
							case USR_ACTION:
								$_action = $lng['admin']['customer'];
								break;
							case RES_ACTION:
								$_action = 'Reseller';
								break;
							case ADM_ACTION:
								$_action = 'Administrator';
								break;
							case CRON_ACTION:
								$_action = 'Cronjob';
								break;
							case LOG_ERROR:
								$_action = 'Internal';
								break;
							default:
								$_action = 'Unknown';
								break;
						}

						$row['action'] = $_action;
						eval("\$log.=\"" . getTemplate("logger/logger_action") . "\";");
					}

					$log_count++;
					$type = $row['type'];
					$_type = 'unknown';

					switch($type)
					{
						case LOG_INFO:
							$_type = 'Information';
							break;
						case LOG_NOTICE:
							$_type = 'Notice';
							break;
						case LOG_WARNING:
							$_type = 'Warning';
							break;
						case LOG_ERR:
							$_type = 'Error';
							break;
						case LOG_CRIT:
							$_type = 'Critical';
							break;
						default:
							$_type = 'Unknown';
							break;
					}

					$row['type'] = $_type;
					eval("\$log.=\"" . getTemplate("logger/logger_log") . "\";");
					$count++;
					$_action = $action;
				}
			}

			$i++;
		}

		eval("echo \"" . getTemplate("logger/logger") . "\";");
	}
	elseif($action == 'truncate')
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$yesterday = time() - (60 * 10);

			/* (60*60*24); */

			$db->query("DELETE FROM `" . TABLE_PANEL_LOG . "` WHERE `date` < '" . $yesterday . "'");
			$log->logAction(ADM_ACTION, LOG_WARNING, "truncated the system-log (mysql)");
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			ask_yesno('logger_reallytruncate', $filename, array('page' => $page, 'action' => $action), TABLE_PANEL_LOG);
		}
	}
}

?>