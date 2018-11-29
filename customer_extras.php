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
if (Settings::IsInList('panel.customer_hide_options','extras')) {
	redirectTo('customer_index.php');
}

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {
	$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_extras");
	eval("echo \"" . getTemplate("extras/extras") . "\";");
} elseif ($page == 'htpasswds') {

	// redirect if this customer sub-page is hidden via settings
	if (Settings::IsInList('panel.customer_hide_options','extras.directoryprotection')) {
		redirectTo('customer_index.php');
	}

	if ($action == '') {
		$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_extras::htpasswds");
		$fields = array(
			'username' => $lng['login']['username'],
			'path' => $lng['panel']['path']
		);
		$paging = new paging($userinfo, TABLE_PANEL_HTPASSWDS, $fields);
		$result_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_HTPASSWDS . "`
			WHERE `customerid`= :customerid " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		Database::pexecute($result_stmt, array(
			"customerid" => $userinfo['customerid']
		));
		$paging->setEntries(Database::num_rows());
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;
		$htpasswds = '';

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($paging->checkDisplay($i)) {
				if (strpos($row['path'], $userinfo['documentroot']) === 0) {
					$row['path'] = str_replace($userinfo['documentroot'], "/", $row['path']);
				}
				$row['path'] = makeCorrectDir($row['path']);
				$row = htmlentities_array($row);
				eval("\$htpasswds.=\"" . getTemplate("extras/htpasswds_htpasswd") . "\";");
				$count ++;
			}

			$i ++;
		}

		eval("echo \"" . getTemplate("extras/htpasswds") . "\";");
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = DirProtections::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['username']) && $result['username'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					DirProtections::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				if (strpos($result['path'], $userinfo['documentroot']) === 0) {
					$result['path'] = str_replace($userinfo['documentroot'], "/", $result['path']);
				}

				ask_yesno('extras_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['username'] . ' (' . $result['path'] . ')');
			}
		}
	} elseif ($action == 'add') {
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				DirProtections::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			redirectTo($filename, array(
				'page' => $page,
				's' => $s
			));
		} else {
			$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);

			$htpasswd_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htpasswd_add.php';
			$htpasswd_add_form = htmlform::genHTMLForm($htpasswd_add_data);

			$title = $htpasswd_add_data['htpasswd_add']['title'];
			$image = $htpasswd_add_data['htpasswd_add']['image'];

			eval("echo \"" . getTemplate("extras/htpasswds_add") . "\";");
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = DirProtections::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['username']) && $result['username'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					DirProtections::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				if (strpos($result['path'], $userinfo['documentroot']) === 0) {
					$result['path'] = str_replace($userinfo['documentroot'], "/", $result['path']);
				}

				$result = htmlentities_array($result);

				$htpasswd_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htpasswd_edit.php';
				$htpasswd_edit_form = htmlform::genHTMLForm($htpasswd_edit_data);

				$title = $htpasswd_edit_data['htpasswd_edit']['title'];
				$image = $htpasswd_edit_data['htpasswd_edit']['image'];

				eval("echo \"" . getTemplate("extras/htpasswds_edit") . "\";");
			}
		}
	}
} elseif ($page == 'htaccess') {

	// redirect if this customer sub-page is hidden via settings
	if (Settings::IsInList('panel.customer_hide_options','extras.pathoptions')) {
		redirectTo('customer_index.php');
	}

	if ($action == '') {
		$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_extras::htaccess");
		$fields = array(
			'path' => $lng['panel']['path'],
			'options_indexes' => $lng['extras']['view_directory'],
			'error404path' => $lng['extras']['error404path'],
			'error403path' => $lng['extras']['error403path'],
			'error500path' => $lng['extras']['error500path'],
			'options_cgi' => $lng['extras']['execute_perl']
		);
		$paging = new paging($userinfo, TABLE_PANEL_HTACCESS, $fields);
		$result_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_HTACCESS . "`
			WHERE `customerid`= :customerid " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		Database::pexecute($result_stmt, array(
			"customerid" => $userinfo['customerid']
		));
		$paging->setEntries(Database::num_rows());
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;
		$htaccess = '';

		$cperlenabled = customerHasPerlEnabled($userinfo['customerid']);

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($paging->checkDisplay($i)) {
				if (strpos($row['path'], $userinfo['documentroot']) === 0) {
					$row['path'] = str_replace($userinfo['documentroot'], "/", $row['path']);
				}
				$row['path'] = makeCorrectDir($row['path']);
				$row['options_indexes'] = str_replace('1', $lng['panel']['yes'], $row['options_indexes']);
				$row['options_indexes'] = str_replace('0', $lng['panel']['no'], $row['options_indexes']);
				$row['options_cgi'] = str_replace('1', $lng['panel']['yes'], $row['options_cgi']);
				$row['options_cgi'] = str_replace('0', $lng['panel']['no'], $row['options_cgi']);
				$row = htmlentities_array($row);
				eval("\$htaccess.=\"" . getTemplate("extras/htaccess_htaccess") . "\";");
				$count ++;
			}

			$i ++;
		}

		eval("echo \"" . getTemplate("extras/htaccess") . "\";");
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = DirOptions::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['customerid']) && $result['customerid'] != '' && $result['customerid'] == $userinfo['customerid']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					DirOptions::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				ask_yesno('extras_reallydelete_pathoptions', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), str_replace($userinfo['documentroot'], '/', $result['path']));
			}
		}
	} elseif ($action == 'add') {
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				DirOptions::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			redirectTo($filename, array(
				'page' => $page,
				's' => $s
			));
		} else {
			$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);
			$cperlenabled = customerHasPerlEnabled($userinfo['customerid']);

			$htaccess_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htaccess_add.php';
			$htaccess_add_form = htmlform::genHTMLForm($htaccess_add_data);

			$title = $htaccess_add_data['htaccess_add']['title'];
			$image = $htaccess_add_data['htaccess_add']['image'];

			eval("echo \"" . getTemplate("extras/htaccess_add") . "\";");
		}
	} elseif (($action == 'edit') && ($id != 0)) {
		try {
			$json_result = DirOptions::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ((isset($result['customerid'])) && ($result['customerid'] != '') && ($result['customerid'] == $userinfo['customerid'])) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					DirOptions::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				if (strpos($result['path'], $userinfo['documentroot']) === 0) {
					$result['path'] = str_replace($userinfo['documentroot'], "/", $result['path']);
				}

				$result['error404path'] = $result['error404path'];
				$result['error403path'] = $result['error403path'];
				$result['error500path'] = $result['error500path'];
				$cperlenabled = customerHasPerlEnabled($userinfo['customerid']);
				/*
				 * $options_indexes = makeyesno('options_indexes', '1', '0', $result['options_indexes']);
				 * $options_cgi = makeyesno('options_cgi', '1', '0', $result['options_cgi']);
				 */
				$result = htmlentities_array($result);

				$htaccess_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htaccess_edit.php';
				$htaccess_edit_form = htmlform::genHTMLForm($htaccess_edit_data);

				$title = $htaccess_edit_data['htaccess_edit']['title'];
				$image = $htaccess_edit_data['htaccess_edit']['image'];

				eval("echo \"" . getTemplate("extras/htaccess_edit") . "\";");
			}
		}
	}
} elseif ($page == 'backup') {

	// redirect if this customer sub-page is hidden via settings
	if (Settings::IsInList('panel.customer_hide_options','extras.backup')) {
		redirectTo('customer_index.php');
	}

	if (Settings::Get('system.backupenabled') == 1)
	{
		if ($action == 'abort' && isset($_POST['send']) && $_POST['send'] == 'send') {
			$log->logAction(USR_ACTION, LOG_NOTICE, "customer_extras::backup - aborted scheduled backupjob");
			try {
				CustomerBackups::getLocal($userinfo, $_POST)->delete();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			standard_success('backupaborted');
			redirectTo($filename, array('page' => $page, 'action' => '', 's' => $s));
		}
		if ($action == '') {
			$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_extras::backup");

			// check whether there is a backup-job for this customer
			try {
				$json_result = CustomerBackups::getLocal($userinfo)->listing();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			$result = json_decode($json_result, true)['data'];
			$existing_backupJob = null;
			if ($result['count'] > 0)
			{
				$existing_backupJob = array_shift($result['list']);
			}

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					CustomerBackups::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				standard_success('backupscheduled');
			} else {

				if (!empty($existing_backupJob)) {
					$action = "abort";
					$row = $existing_backupJob['data'];

					$row['path'] = makeCorrectDir(str_replace($userinfo['documentroot'], "/", $row['destdir']));
					$row['backup_web'] = ($row['backup_web'] == '1') ? $lng['panel']['yes'] : $lng['panel']['no'];
					$row['backup_mail'] = ($row['backup_mail'] == '1') ? $lng['panel']['yes'] : $lng['panel']['no'];
					$row['backup_dbs'] = ($row['backup_dbs'] == '1') ? $lng['panel']['yes'] : $lng['panel']['no'];
				}
				$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);
				$backup_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.backup.php';
				$backup_form = htmlform::genHTMLForm($backup_data);
				$title = $backup_data['backup']['title'];
				$image = $backup_data['backup']['image'];

				if (!empty($existing_backupJob)) {
					// overwrite backup_form after we took everything from it we needed
					eval("\$backup_form = \"" . getTemplate("extras/backup_listexisting") . "\";");
				}
				eval("echo \"" . getTemplate("extras/backup") . "\";");
			}
		}
	}
	else
	{
		standard_error('backupfunctionnotenabled');
	}
}
