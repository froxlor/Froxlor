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
define('AREA', 'admin');
require './lib/init.php';

use Froxlor\Api\Commands\SysLog;

if ($page == 'log' && $userinfo['change_serversettings'] == '1') {
	if ($action == '') {
		$fields = array(
			'date' => $lng['logger']['date'],
			'type' => $lng['logger']['type'],
			'user' => $lng['logger']['user'],
			'text' => $lng['logger']['action']
		);
		try {
			// get total count
			$json_result = SysLog::getLocal($userinfo)->listingCount();
			$result = json_decode($json_result, true)['data'];
			// initialize pagination and filtering
			$paging = new \Froxlor\UI\Pagination($userinfo, $fields, $result);
			// get list
			$json_result = SysLog::getLocal($userinfo, $paging->getApiCommandParams())->listing();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$clog = array();

		foreach ($result['list'] as $row) {
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

		$count = 0;
		$log_count = 0;
		$log = '';
		foreach ($clog as $action => $logrows) {
			$_action = 0;
			foreach ($logrows as $row) {
				// if ($paging->checkDisplay($i)) {
				$row = \Froxlor\PhpHelper::htmlentitiesArray($row);
				$row['date'] = date("d.m.y H:i:s", $row['date']);

				if ($_action != $action) {
					switch ($action) {
						case \Froxlor\FroxlorLogger::USR_ACTION:
							$_action = $lng['admin']['customer'];
							break;
						case \Froxlor\FroxlorLogger::RES_ACTION:
							$_action = $lng['logger']['reseller'];
							break;
						case \Froxlor\FroxlorLogger::ADM_ACTION:
							$_action = $lng['logger']['admin'];
							break;
						case \Froxlor\FroxlorLogger::CRON_ACTION:
							$_action = $lng['logger']['cron'];
							break;
						case \Froxlor\FroxlorLogger::LOGIN_ACTION:
							$_action = $lng['logger']['login'];
							break;
						case \Froxlor\FroxlorLogger::LOG_ERROR:
							$_action = $lng['logger']['intern'];
							break;
						default:
							$_action = $lng['logger']['unknown'];
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
			}
		}

		eval("echo \"" . \Froxlor\UI\Template::getTemplate('logger/logger') . "\";");
	} elseif ($action == 'truncate') {

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				SysLog::getLocal($userinfo, array(
					'min_to_keep' => 10
				))->delete();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page,
				's' => $s
			));
		} else {
			\Froxlor\UI\HTML::askYesNo('logger_reallytruncate', $filename, array(
				'page' => $page,
				'action' => $action
			), TABLE_PANEL_LOG);
		}
	}
}
