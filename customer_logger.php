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
 * @package    Panel
 *
 */

define('AREA', 'customer');
require './lib/init.php';

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options','extras.logger')) {
	redirectTo('customer_index.php');
}

if ($page == 'log'
) {
	if ($action == '') {
		$fields = array(
			'date' => $lng['logger']['date'],
			'type' => $lng['logger']['type'],
			'user' => $lng['logger']['user'],
			'text' => $lng['logger']['action']
		);
		$paging = new paging($userinfo, TABLE_PANEL_LOG, $fields, null, null, 0, 'desc');
		$result_stmt = Database::prepare('
			SELECT * FROM `' . TABLE_PANEL_LOG . '` WHERE `user` = :loginname ' . $paging->getSqlWhere(true) . ' ' . $paging->getSqlOrderBy() . ' ' . $paging->getSqlLimit()
		);
		Database::pexecute($result_stmt, array("loginname" => $userinfo['loginname']));
		$logs_count = Database::num_rows();
		$paging->setEntries($logs_count);
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$clog = array();

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			if (!isset($clog[$row['action']])
				|| !is_array($clog[$row['action']])
			) {
				$clog[$row['action']] = array();
			}
			$clog[$row['action']][$row['logid']] = $row;
		}

		if ($paging->sortfield == 'date'
			&& $paging->sortorder == 'desc'
		) {
			krsort($clog);
		} else {
			ksort($clog);
		}

		$i = 0;
		$count = 0;
		$log_count = 0;
		$log = '';
		foreach ($clog as $action => $logrows) {
			$_action = 0;
			foreach ($logrows as $row) {
				if ($paging->checkDisplay($i)) {
					$row = htmlentities_array($row);
					$row['date'] = date("d.m.y H:i:s", $row['date']);

					if ($_action != $action) {
						switch ($action) {
							case USR_ACTION:
								$_action = $lng['admin']['customer'];
								break;
							case RES_ACTION:
								$_action = $lng['logger']['reseller'];
								break;
							case ADM_ACTION:
								$_action = $lng['logger']['admin'];
								break;
							case CRON_ACTION:
								$_action = $lng['logger']['cron'];
								break;
							case LOGIN_ACTION:
								$_action = $lng['logger']['login'];
								break;
							case LOG_ERROR:
								$_action = $lng['logger']['intern'];
								break;
							default:
								$_action = $lng['logger']['unknown'];
								break;
						}

						$row['action'] = $_action;
						eval("\$log.=\"" . getTemplate('logger/logger_action') . "\";");
					}

					$log_count++;
					$row['type'] = getLogLevelDesc($row['type']);
					eval("\$log.=\"" . getTemplate('logger/logger_log') . "\";");
					$count++;
					$_action = $action;
				}
				$i++;
			}
			$i++;
		}

		eval("echo \"" . getTemplate('logger/logger') . "\";");

	}
}
