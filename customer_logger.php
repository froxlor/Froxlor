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

use Froxlor\Database\Database;
use Froxlor\Settings;

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options', 'extras.logger')) {
	\Froxlor\UI\Response::redirectTo('customer_index.php');
}

if ($page == 'log') {
	if ($action == '') {
		$fields = array(
			'date' => \Froxlor\I18N\Lang::getAll()['logger']['date'],
			'type' => \Froxlor\I18N\Lang::getAll()['logger']['type'],
			'user' => \Froxlor\I18N\Lang::getAll()['logger']['user'],
			'text' => \Froxlor\I18N\Lang::getAll()['logger']['action']
		);
		$paging = new \Froxlor\UI\Paging(\Froxlor\User::getAll(), TABLE_PANEL_LOG, $fields, null, null, 0, 'desc', 30);
		$query = 'SELECT * FROM `' . TABLE_PANEL_LOG . '` WHERE `user` = :loginname ' . $paging->getSqlWhere(true) . ' ' . $paging->getSqlOrderBy();
		$result_stmt = Database::prepare($query . ' ' . $paging->getSqlLimit());
		Database::pexecute($result_stmt, array(
			"loginname" => \Froxlor\User::getAll()['loginname']
		));
		$result_cnt_stmt = Database::prepare($query);
		Database::pexecute($result_cnt_stmt, array(
			"loginname" => \Froxlor\User::getAll()['loginname']
		));
		$res_cnt = $result_cnt_stmt->fetch(PDO::FETCH_ASSOC);
		$logs_count = $result_cnt_stmt->rowCount();
		$paging->setEntries($logs_count);
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$clog = array();

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			if (! isset($clog[$row['action']]) || ! is_array($clog[$row['action']])) {
				$clog[$row['action']] = array();
			}
			$clog[$row['action']][$row['logid']] = $row;
		}

		if ($paging->sortfield == 'date' && $paging->sortorder == 'desc') {
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
				// if ($paging->checkDisplay($i)) {
				$row = \Froxlor\PhpHelper::htmlentities_array($row);
				$row['date'] = date("d.m.y H:i:s", $row['date']);

				if ($_action != $action) {
					switch ($action) {
						case USR_ACTION:
							$_action = \Froxlor\I18N\Lang::getAll()['admin']['customer'];
							break;
						case RES_ACTION:
							$_action = \Froxlor\I18N\Lang::getAll()['logger']['reseller'];
							break;
						case ADM_ACTION:
							$_action = \Froxlor\I18N\Lang::getAll()['logger']['admin'];
							break;
						case CRON_ACTION:
							$_action = \Froxlor\I18N\Lang::getAll()['logger']['cron'];
							break;
						case LOGIN_ACTION:
							$_action = \Froxlor\I18N\Lang::getAll()['logger']['login'];
							break;
						case LOG_ERROR:
							$_action = \Froxlor\I18N\Lang::getAll()['logger']['intern'];
							break;
						default:
							$_action = \Froxlor\I18N\Lang::getAll()['logger']['unknown'];
							break;
					}

					$row['action'] = $_action;
					eval("\$log.=\"" . \Froxlor\UI\Template::getTemplate('logger/logger_action') . "\";");
				}

				$log_count ++;
				$row['type'] = \Froxlor\FroxlorLogger::getInstanceOf()->getLogLevelDesc($row['type']);
				eval("\$log.=\"" . \Froxlor\UI\Template::getTemplate('logger/logger_log') . "\";");
				$count ++;
				$_action = $action;
				// }
				$i ++;
			}
			$i ++;
		}

		eval("echo \"" . \Froxlor\UI\Template::getTemplate('logger/logger') . "\";");
	}
}
