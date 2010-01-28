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
 * @version    $Id$
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
				
				/*
				 * don't allow deletion of 'froxlor' cronjobs
				 */
				$vendor_a = explode('/', $row['module']);
				$vendor = $vendor_a[0];
				
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
		 * @TODO Finish me
		 */
	}
	elseif($action == 'edit'
	&& $id != 0)
	{
		/*
		 * @TODO Finish me
		 */
	}
	elseif($action == 'delete'
	&& $id != 0)
	{
		/*
		 * @TODO Finish me
		 */
	}
}

?>
