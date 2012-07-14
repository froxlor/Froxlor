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
 * @package    Panel
 *
 */

define('AREA', 'admin');

require_once("./lib/init.php");

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

if($page == 'cronjobs'
  || $page == 'overview')
{
	if($action == '')
	{
		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_cronjobs");

		$fields = array(
			'c.lastrun' => $lng['cron']['lastrun'],
			'c.interval' => $lng['cron']['interval'],
			'c.isactive' => $lng['cron']['isactive']
		);
		$paging = new paging($userinfo, $db, TABLE_PANEL_CRONRUNS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);

		/*
		 * @TODO Fix sorting
		 */
		$crons = '';
		$result = $db->query("SELECT `c`.* FROM `" . TABLE_PANEL_CRONRUNS . "` `c` ORDER BY `cronfile` ASC");
		$paging->setEntries($db->num_rows($result));
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);

		$i = 0;
		$count = 0;

		while($row = $db->fetch_array($result))
		{
			if($paging->checkDisplay($i))
			{
				$row = htmlentities_array($row);
				
				$row['lastrun'] = date('d.m.Y H:i', $row['lastrun']);
				
				if((int)$row['isactive'] == 1)
				{
					$row['isactive'] = $lng['panel']['yes'];
				}
				else
				{
					$row['isactive'] = $lng['panel']['no'];
				}
				
				$description = $lng['crondesc'][$row['desc_lng_key']];
				
				eval("\$crons.=\"" . getTemplate("cronjobs/cronjobs_cronjob") . "\";");
				$count++;
			}

			$i++;
		}

		eval("echo \"" . getTemplate("cronjobs/cronjobs") . "\";");

	}
	elseif($action == 'new')
	{
		/*
		 * @TODO later
		 */
	}
	elseif($action == 'edit'
	&& $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `id`='" . (int)$id . "'");
		
		if ($result['cronfile'] != '')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$isactive = isset($_POST['isactive']) ? 1 : 0;
				$interval_value = validate($_POST['interval_value'], 'interval_value', '/^([0-9]+)$/Di', 'stringisempty');
				$interval_interval = validate($_POST['interval_interval'], 'interval_interval');
				
				if($isactive != 1)
				{
					$isactive = 0;
				}
				
				$interval = $interval_value.' '.strtoupper($interval_interval);
				
				$db->query("UPDATE `" . TABLE_PANEL_CRONRUNS . "` 
							SET `isactive` = '".(int)$isactive."',
							`interval` = '".$interval."'
							WHERE `id` = '" . (int)$id . "'");

				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				//$isactive = makeyesno('isactive', '1', '0', $result['isactive']);
				// interval
				$interval_nfo = explode(' ', $result['interval']);
				$interval_value = $interval_nfo[0];

				$interval_interval = '';
				$interval_interval.= makeoption($lng['cronmgmt']['seconds'], 'SECOND', $interval_nfo[1]);
				$interval_interval.= makeoption($lng['cronmgmt']['minutes'], 'MINUTE', $interval_nfo[1]);
				$interval_interval.= makeoption($lng['cronmgmt']['hours'], 'HOUR', $interval_nfo[1]);
				$interval_interval.= makeoption($lng['cronmgmt']['days'], 'DAY', $interval_nfo[1]);
				$interval_interval.= makeoption($lng['cronmgmt']['weeks'], 'WEEK', $interval_nfo[1]);
				$interval_interval.= makeoption($lng['cronmgmt']['months'], 'MONTH', $interval_nfo[1]);
				// end of interval
				
				$change_cronfile = false;
				if (substr($result['module'], 0, strpos($result['module'], '/')) != 'froxlor')
				{
					$change_cronfile = true;
				}

				$cronjobs_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/cronjobs/formfield.cronjobs_edit.php';
				$cronjobs_edit_form = htmlform::genHTMLForm($cronjobs_edit_data);

				$title = $cronjobs_edit_data['cronjobs_edit']['title'];
				$image = $cronjobs_edit_data['cronjobs_edit']['image'];

				eval("echo \"" . getTemplate("cronjobs/cronjob_edit") . "\";");
			}
		}
	}
	elseif($action == 'delete'
	&& $id != 0)
	{
		/*
		 * @TODO later
		 */
	}
}
