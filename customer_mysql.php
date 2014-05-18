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
		$result_stmt = Database::prepare('SELECT `id`, `databasename`, `description`, `dbserver` FROM `' . TABLE_PANEL_DATABASES . '`
			WHERE `customerid`="' . (int)$userinfo['customerid'] . '"
			AND `id`="' . (int)$id . '"'
		);
		Database::pexecute($result_stmt, array("customerid" => $userinfo['customerid']));
		$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($result['databasename']) && $result['databasename'] != '') {

			Database::needRoot(true, $result['dbserver']);
			Database::needSqlData();
			$sql_root = Database::getSqlData();
			Database::needRoot(false);

			if (!isset($sql_root[$result['dbserver']]) || !is_array($sql_root[$result['dbserver']])) {
				$result['dbserver'] = 0;
			}

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				// Begin root-session
				Database::needRoot(true, $result['dbserver']);
				$dbm = new DbManager($log);
				$dbm->getManager()->deleteDatabase($result['databasename']);
				$log->logAction(USR_ACTION, LOG_INFO, "deleted database '" . $result['databasename'] . "'");
				Database::needRoot(false);
				// End root-session

				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DATABASES . "`
					WHERE `customerid` = :customerid
					AND `id` = :id"
				);
				Database::pexecute($stmt, array("customerid" => $userinfo['customerid'], "id" => $id));

				$resetaccnumber = ($userinfo['mysqls_used'] == '1') ? " , `mysql_lastaccountnumber` = '0' " : '';

				$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
					SET `mysqls_used` = `mysqls_used` - 1 " . $resetaccnumber . "
					WHERE `customerid` = :customerid"
				);
				Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));

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
				$password = validate($_POST['mysql_password'], 'password');
				$password = validatePassword($password);

				$sendinfomail = isset($_POST['sendinfomail']) ? 1 : 0;
				if ($sendinfomail != 1) {
					$sendinfomail = 0;
				}

				if ($password == '') {
					standard_error(array('stringisempty', 'mypassword'));
				} else {
					$dbserver = 0;
					$dbservers_stmt = Database::query("SELECT COUNT(DISTINCT `dbserver`) as numservers FROM `".TABLE_PANEL_DATABASES."`");
					$_dbserver = $dbservers_stmt->fetch(PDO::FETCH_ASSOC);
					$count_mysqlservers = $_dbserver['numservers'];
					if ($count_mysqlservers > 1) {
						$dbserver = validate($_POST['mysql_server'], html_entity_decode($lng['mysql']['mysql_server']), '', '', 0);
						Database::needRoot(true, $dbserver);
						Database::needSqlData();
						$sql_root = Database::getSqlData();
						Database::needRoot(false);
						if (!isset($sql_root) || !is_array($sql_root)) {
							$dbserver = 0;
						}
					}

					// validate description before actual adding the database, #1052
					$databasedescription = validate(trim($_POST['description']), 'description');

					// create database, user, set permissions, etc.pp.
					$dbm = new DbManager($log);
					$username = $dbm->createDatabase(
						$userinfo['loginname'],
						$password,
						$userinfo['mysql_lastaccountnumber']
					);

					// we've checked against the password in dbm->createDatabase
					if ($username == false) {
						standard_error('passwordshouldnotbeusername');
					}

					// Statement modified for Database description -- PH 2004-11-29
					$stmt = Database::prepare('INSERT INTO `' . TABLE_PANEL_DATABASES . '`
						(`customerid`, `databasename`, `description`, `dbserver`)
						VALUES (:customerid, :databasename, :description, :dbserver)'
					);
					$params = array(
						"customerid" => $userinfo['customerid'],
						"databasename" => $username,
						"description" => $databasedescription,
						"dbserver" => $dbserver
					);
					Database::pexecute($stmt, $params);

					$stmt = Database::prepare('UPDATE `' . TABLE_PANEL_CUSTOMERS . '`
						SET `mysqls_used` = `mysqls_used` + 1, `mysql_lastaccountnumber` = `mysql_lastaccountnumber` + 1
						WHERE `customerid` = :customerid'
					);
					Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));

					if ($sendinfomail == 1) {
						$pma = $lng['admin']['notgiven'];
						if (Settings::Get('panel.phpmyadmin_url') != '') {
							$pma = Settings::Get('panel.phpmyadmin_url');
						}

						Database::needRoot(true, $dbserver);
						Database::needSqlData();
						$sql_root = Database::getSqlData();
						Database::needRoot(false);

						$replace_arr = array(
							'SALUTATION' => getCorrectUserSalutation($userinfo),
							'CUST_NAME' => getCorrectUserSalutation($userinfo), // < keep this for compatibility
							'DB_NAME' => $username,
							'DB_PASS' => $password,
							'DB_DESC' => $databasedescription,
							'DB_SRV' => $sql_root['caption'],
							'PMA_URI' => $pma
						);

						$def_language = $userinfo['def_language'];
						$result_stmt = Database::prepare("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
							WHERE `adminid` = :adminid
							AND `language` = :lang
							AND `templategroup`='mails'
							AND `varname`='new_database_by_customer_subject'"
						);
						Database::pexecute($result_stmt, array("adminid" => $userinfo['adminid'], "lang" => $def_language));
						$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
						$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['customer']['mysql_add']['infomail_subject']), $replace_arr));

						$result_stmt = Database::prepare("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
							WHERE `adminid`= :adminid
							AND `language`= :lang
							AND `templategroup` = 'mails'
							AND `varname` = 'new_database_by_customer_mailbody'"
						);
						Database::pexecute($result_stmt, array("adminid" => $userinfo['adminid'], "lang" => $def_language));
						$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
						$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['customer']['mysql_add']['infomail_body']['main']), $replace_arr));

						$_mailerror = false;
						try {
							$mail->Subject = $mail_subject;
							$mail->AltBody = $mail_body;
							$mail->MsgHTML(str_replace("\n", "<br />", $mail_body));
							$mail->AddAddress($userinfo['email'], getCorrectUserSalutation($userinfo));
							$mail->Send();
						} catch(phpmailerException $e) {
							$mailerr_msg = $e->errorMessage();
							$_mailerror = true;
						} catch (Exception $e) {
							$mailerr_msg = $e->getMessage();
							$_mailerror = true;
						}

						if ($_mailerror) {
							$log->logAction(USR_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
							standard_error('errorsendingmail', $userinfo['email']);
						}

						$mail->ClearAddresses();
					}

					redirectTo($filename, array('page' => $page, 's' => $s));
				}
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
		$result_stmt = Database::prepare("SELECT `id`, `databasename`, `description`, `dbserver` FROM `" . TABLE_PANEL_DATABASES . "`
			WHERE `customerid` = :customerid
			AND `id` = :id"
		);
		Database::pexecute($result_stmt, array("customerid" => $userinfo['customerid'], "id" => $id));
		$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($result['databasename']) && $result['databasename'] != '') {
			if (!isset($sql_root[$result['dbserver']]) || !is_array($sql_root[$result['dbserver']])) {
				$result['dbserver'] = 0;
			}

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				// Only change Password if it is set, do nothing if it is empty! -- PH 2004-11-29
				$password = validate($_POST['mysql_password'], 'password');
				if ($password != '') {
					// validate password
					$password = validatePassword($password);

					if ($password == $result['databasename']) {
						standard_error('passwordshouldnotbeusername');
					}

					// Begin root-session
					Database::needRoot(true);
					foreach (array_map('trim', explode(',', Settings::Get('system.mysql_access_host'))) as $mysql_access_host) {
						$stmt = Database::prepare("SET PASSWORD FOR :dbname@:host = PASSWORD(:password)");
						$params = array(
							"dbname" => $result['databasename'],
							"host" => $mysql_access_host,
							"password" => $password
						);
						Database::pexecute($stmt, $params);
					}

					$stmt = Database::prepare("FLUSH PRIVILEGES");
					Database::pexecute($stmt);
					Database::needRoot(false);
					// End root-session
				}

				// Update the Database description -- PH 2004-11-29
				$log->logAction(USR_ACTION, LOG_INFO, "edited database '" . $result['databasename'] . "'");
				$databasedescription = validate($_POST['description'], 'description');
				$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_DATABASES . "`
					SET `description` = :desc
					WHERE `customerid` = :customerid
					AND `id` = :id"
				);
				Database::pexecute($stmt, array("desc" => $databasedescription, "customerid" => $userinfo['customerid'], "id" => $id));
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
