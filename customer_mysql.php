<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

const AREA = 'customer';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\Mysqls as Mysqls;
use Froxlor\Database\Database;
use Froxlor\FroxlorLogger;
use Froxlor\Settings;
use Froxlor\UI\Collection;
use Froxlor\UI\HTML;
use Froxlor\UI\Listing;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;
use Froxlor\UI\Response;

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options', 'mysql')) {
	Response::redirectTo('customer_index.php');
}

// get sql-root access data
Database::needRoot(true);
Database::needSqlData();
$sql_root = Database::getSqlData();
Database::needRoot(false);

$id = (int)Request::get('id');

if ($page == 'overview' || $page == 'mysqls') {
	if ($action == '') {
		$log->logAction(FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_mysql::mysqls");

		$dbservers_stmt = Database::query("SELECT COUNT(DISTINCT `dbserver`) as numservers FROM `" . TABLE_PANEL_DATABASES . "`");
		$dbserver = $dbservers_stmt->fetch(PDO::FETCH_ASSOC);
		$count_mysqlservers = $dbserver['numservers'];

		try {
			$mysql_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/customer/tablelisting.mysqls.php';
			$collection = (new Collection(Mysqls::class, $userinfo))
				->withPagination($mysql_list_data['mysql_list']['columns']);
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}

		Database::needSqlData();
		$sql = Database::getSqlData();
		// FIXME: setting translation on the fly is currently not supported; do we want this; alternatives
		// $lng['mysql']['description'] = str_replace('<SQL_HOST>', $sql['host'], lng('mysql.description'));

		$actions_links = false;
		if ($userinfo['mysqls_used'] < $userinfo['mysqls'] || $userinfo['mysqls'] == '-1') {
			$actions_links = [
				[
					'href' => $linker->getLink(['section' => 'mysql', 'page' => 'mysqls', 'action' => 'add']),
					'label' => lng('mysql.database_create')
				]
			];
		}

		UI::view('user/table.html.twig', [
			'listing' => Listing::format($collection, $mysql_list_data, 'mysql_list'),
			'actions_links' => $actions_links,
			'entity_info' => lng('mysql.description')
		]);
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = Mysqls::getLocal($userinfo, [
				'id' => $id
			])->get();
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['databasename']) && $result['databasename'] != '') {
			Database::needRoot(true, $result['dbserver']);
			Database::needSqlData();
			$sql_root = Database::getSqlData();
			Database::needRoot(false);

			if (!isset($sql_root[$result['dbserver']]) || !is_array($sql_root[$result['dbserver']])) {
				$result['dbserver'] = 0;
			}

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Mysqls::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					Response::dynamicError($e->getMessage());
				}
				Response::redirectTo($filename, [
					'page' => $page
				]);
			} else {
				$dbnamedesc = $result['databasename'];
				if (isset($result['description']) && $result['description'] != '') {
					$dbnamedesc .= ' (' . $result['description'] . ')';
				}
				HTML::askYesNo('mysql_reallydelete', $filename, [
					'id' => $id,
					'page' => $page,
					'action' => $action
				], $dbnamedesc);
			}
		}
	} elseif ($action == 'add') {
		if ($userinfo['mysqls_used'] < $userinfo['mysqls'] || $userinfo['mysqls'] == '-1') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Mysqls::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					Response::dynamicError($e->getMessage());
				}
				Response::redirectTo($filename, [
					'page' => $page
				]);
			} else {
				$dbservers_stmt = Database::query("SELECT DISTINCT `dbserver` FROM `" . TABLE_PANEL_DATABASES . "`");
				$mysql_servers = [];
				while ($dbserver = $dbservers_stmt->fetch(PDO::FETCH_ASSOC)) {
					Database::needRoot(true, $dbserver['dbserver']);
					Database::needSqlData();
					$sql_root = Database::getSqlData();
					$mysql_servers[$dbserver['dbserver']] = $sql_root['caption'];
				}
				Database::needRoot(false);

				$mysql_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/mysql/formfield.mysql_add.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(['section' => 'mysql']),
					'formdata' => $mysql_add_data['mysql_add']
				]);
			}
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = Mysqls::getLocal($userinfo, [
				'id' => $id
			])->get();
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['databasename']) && $result['databasename'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					$json_result = Mysqls::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					Response::dynamicError($e->getMessage());
				}
				Response::redirectTo($filename, [
					'page' => $page
				]);
			} else {
				$dbservers_stmt = Database::query("SELECT COUNT(DISTINCT `dbserver`) as numservers FROM `" . TABLE_PANEL_DATABASES . "`");
				$dbserver = $dbservers_stmt->fetch(PDO::FETCH_ASSOC);
				$count_mysql_servers = $dbserver['numservers'];

				Database::needRoot(true, $result['dbserver']);
				Database::needSqlData();
				$sql_root = Database::getSqlData();
				Database::needRoot(false);

				$mysql_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/mysql/formfield.mysql_edit.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(['section' => 'mysql', 'id' => $id]),
					'formdata' => $mysql_edit_data['mysql_edit'],
					'editid' => $id
				]);
			}
		}
	}
}
