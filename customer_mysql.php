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
if (Settings::IsInList('panel.customer_hide_options','mysql')) {
	redirectTo('customer_index.php');
}

// get sql-root access data
Database::needRoot(true);
Database::needSqlData();
$sql_root = Database::getSqlData();
Database::needRoot(false);

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {
	$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_mysql");
	Database::needSqlData();
	$sql = Database::getSqlData();
	$lng['mysql']['description'] = str_replace('<SQL_HOST>', $sql['host'], $lng['mysql']['description']);
	eval("echo \"" . getTemplate('mysql/mysql') . "\";");
} elseif ($page == 'mysqls') {
	if ($action == '') {
		$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_mysql::mysqls");
		$fields = array(
			'databasename' => $lng['mysql']['databasename'],
			'description' => $lng['mysql']['databasedescription']
		);
		$paging = new paging($userinfo, TABLE_PANEL_DATABASES, $fields);
		$result_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
			WHERE `customerid`= :customerid " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit()
		);
		Database::pexecute($result_stmt, array("customerid" => $userinfo['customerid']));
		$mysqls_count = Database::num_rows();
		$paging->setEntries($mysqls_count);

		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;
		$mysqls = '';

		$dbservers_stmt = Database::query("SELECT COUNT(DISTINCT `dbserver`) as numservers FROM `".TABLE_PANEL_DATABASES."`");
		$dbserver = $dbservers_stmt->fetch(PDO::FETCH_ASSOC);
		$count_mysqlservers = $dbserver['numservers'];

		// Begin root-session
		Database::needRoot(true);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($paging->checkDisplay($i)) {
				$row = htmlentities_array($row);
				$mbdata_stmt = Database::prepare("SELECT SUM(data_length + index_length) as MB FROM information_schema.TABLES
					WHERE table_schema = :table_schema
					GROUP BY table_schema"
				);
				Database::pexecute($mbdata_stmt, array("table_schema" => $row['databasename']));
				$mbdata = $mbdata_stmt->fetch(PDO::FETCH_ASSOC);
				$row['size'] = size_readable($mbdata['MB'], 'GiB', 'bi', '%01.' . (int)Settings::Get('panel.decimal_places') . 'f %s');
				eval("\$mysqls.=\"" . getTemplate('mysql/mysqls_database') . "\";");
				$count++;
			}
			$i++;
		}
		Database::needRoot(false);
		// End root-session

		eval("echo \"" . getTemplate('mysql/mysqls') . "\";");

	} elseif ($action == 'delete' && $id != 0) {

		try {
			$json_result = Mysqls::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
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
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				$dbnamedesc = $result['databasename'];
				if (isset($result['description']) && $result['description'] != '') {
					$dbnamedesc .= ' ('.$result['description'].')';
				}
				ask_yesno('mysql_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $dbnamedesc);
			}
		}
	} elseif ($action == 'add') {
		if ($userinfo['mysqls_used'] < $userinfo['mysqls'] || $userinfo['mysqls'] == '-1') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Mysqls::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {

				$dbservers_stmt = Database::query("SELECT DISTINCT `dbserver` FROM `".TABLE_PANEL_DATABASES."`");
				$mysql_servers = '';
				$count_mysqlservers = 0;
				while ($dbserver = $dbservers_stmt->fetch(PDO::FETCH_ASSOC)) {
					Database::needRoot(true, $dbserver['dbserver']);
					Database::needSqlData();
					$sql_root = Database::getSqlData();
					$mysql_servers .= makeoption($sql_root['caption'], $dbserver['dbserver']);
					$count_mysqlservers++;
				}
				Database::needRoot(false);

				$mysql_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/mysql/formfield.mysql_add.php';
				$mysql_add_form = htmlform::genHTMLForm($mysql_add_data);

				$title = $mysql_add_data['mysql_add']['title'];
				$image = $mysql_add_data['mysql_add']['image'];

				eval("echo \"" . getTemplate('mysql/mysqls_add') . "\";");
			}
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = Mysqls::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['databasename']) && $result['databasename'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					$json_result = Mysqls::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {

				$dbservers_stmt = Database::query("SELECT COUNT(DISTINCT `dbserver`) as numservers FROM `".TABLE_PANEL_DATABASES."`");
				$dbserver = $dbservers_stmt->fetch(PDO::FETCH_ASSOC);
				$count_mysqlservers = $dbserver['numservers'];

				Database::needRoot(true, $result['dbserver']);
				Database::needSqlData();
				$sql_root = Database::getSqlData();
				Database::needRoot(false);

				$mysql_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/mysql/formfield.mysql_edit.php';
				$mysql_edit_form = htmlform::genHTMLForm($mysql_edit_data);

				$title = $mysql_edit_data['mysql_edit']['title'];
				$image = $mysql_edit_data['mysql_edit']['image'];

				eval("echo \"" . getTemplate('mysql/mysqls_edit') . "\";");
			}
		}
	}
}
