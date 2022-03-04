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

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\SysLog;
use Froxlor\UI\Panel\UI;

if ($page == 'log' && $userinfo['change_serversettings'] == '1') {
	if ($action == '') {
		try {
			$syslog_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/tablelisting.syslog.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\SysLog::class, $userinfo))
				->addParam(['sql_orderby' => ['date' => 'DESC']])
				->withPagination($syslog_list_data['syslog_list']['columns']);
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::twigBuffer('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $syslog_list_data['syslog_list']),
			'actions_links' => [[
				'href' => $linker->getLink(['section' => 'logger', 'page' => 'log', 'action' => 'truncate']),
				'label' => $lng['logger']['truncate'],
				'icon' => 'fa-solid fa-recycle',
				'class' => 'btn-warning'
			]]
		]);
		UI::twigOutputBuffer();
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
