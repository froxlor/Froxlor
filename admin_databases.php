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

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

// get sql-root access data
Database::needRoot(true);
Database::needSqlData();
$sql_root = Database::getSqlData();
Database::needRoot(false);

if ($page == 'databases' || $page == 'overview') {
	// List customers
	$stmt = Database::prepare("
		SELECT `customerid` FROM `" . TABLE_PANEL_CUSTOMERS . "` " . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = :adminid"));
	$params = array();
	if ($userinfo['customers_see_all'] == '0') {
		$params['adminid'] = $userinfo['adminid'];
	}
	Database::pexecute($stmt, $params);
	$countcustomers = Database::num_rows();

	$customers = array();

	while ($customerid = $stmt->fetch(PDO::FETCH_COLUMN)) {
		$customers[] = (int) $customerid;
	}

	if ($action == '') {

		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_databases");
		$fields = array(
			'd.databasename' => $lng['mysql']['databasename'],
			'd.description' => $lng['mysql']['databasedescription'],
			'c.name' => $lng['customer']['name'],
			'c.firstname' => $lng['customer']['firstname'],
			'c.company' => $lng['customer']['company'],
			'c.loginname' => $lng['login']['username'],
		);
		$paging = new paging($userinfo, TABLE_PANEL_DATABASES, $fields);
		$result_stmt = Database::prepare("
			SELECT `d`.*, `c`.`loginname`, `c`.`name`, `c`.`firstname`, `c`.`company`
			FROM `" . TABLE_PANEL_DATABASES . "` `d`
			LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`)
			" . ($userinfo['customers_see_all'] ? '' : " WHERE `d`.`customerid` IN (:customers) ") . " " . $paging->getSqlWhere(!$userinfo['customers_see_all']) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		$params = array();
		if ($userinfo['customers_see_all'] == '0') {
			$params['customers'] = $customers;
		}
		Database::pexecute($result_stmt, $params);
		$numrows_databases = Database::num_rows();
		$paging->setEntries($numrows_databases);
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);

		$i = 0;
		$count = 0;
		$mysqls = '';

		$dbservers_stmt = Database::query("SELECT COUNT(DISTINCT `dbserver`) as numservers FROM `" . TABLE_PANEL_DATABASES . "`");
		$dbserver = $dbservers_stmt->fetch(PDO::FETCH_ASSOC);
		$count_mysqlservers = $dbserver['numservers'];

		// Begin root-session
		Database::needRoot(true);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			if (isset($row['databasename']) && $row['databasename'] != '' && $paging->checkDisplay($i)) {
				$row['customername'] = getCorrectFullUserDetails($row);
				$row = htmlentities_array($row);
				$mbdata_stmt = Database::prepare("SELECT SUM(data_length + index_length) as MB FROM information_schema.TABLES
					WHERE table_schema = :table_schema
					GROUP BY table_schema"
				);
				Database::pexecute($mbdata_stmt, array("table_schema" => $row['databasename']));
				$mbdata = $mbdata_stmt->fetch(PDO::FETCH_ASSOC);
				$row['size'] = size_readable($mbdata['MB'], 'GiB', 'bi', '%01.' . (int) Settings::Get('panel.decimal_places') . 'f %s');
				eval("\$mysqls.=\"" . getTemplate("database/database_row") . "\";");
				$count ++;
			}
			$i ++;
		}
		Database::needRoot(false);
		// End root-session

		$databasecount = $numrows_databases;

		// Display the list
		eval("echo \"" . getTemplate("database/database") . "\";");
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
					$dbservers_stmt = Database::query("SELECT COUNT(DISTINCT `dbserver`) as numservers FROM `" . TABLE_PANEL_DATABASES . "`");
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

					$customerid = intval($_POST['customerid']);
					$customer_stmt = Database::prepare("
                        SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
                        WHERE `customerid` = :customerid " . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid"));
					$params = array(
						'customerid' => $customerid
					);
					if ($userinfo['customers_see_all'] == '0') {
						$params['adminid'] = $userinfo['adminid'];
					}
					$customer = Database::pexecute_first($customer_stmt, $params);

					if (empty($customer) || $customer['customerid'] != $customerid) {
						standard_error('customerdoesntexist');
					}

					// validate description before actual adding the database, #1052
					$databasedescription = validate(trim($_POST['description']), 'description');

					$customusername = strlen(trim($_POST['mysql_username'])) > 0;

					if ($customusername) {

						$username = validate(trim($_POST['mysql_username']), strtolower($lng['mysql']['databasename']));

						// check if table is exists
						Database::needRoot(true);
						$mbdata_stmt = Database::prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :table_schema"
						);
						Database::pexecute($mbdata_stmt, array("table_schema" => $username));
						if (Database::num_rows() > 0) {
							standard_error('databaseexists');
						}
						Database::needRoot(false);

						// create database, user, set permissions, etc.pp.
						$dbm = new DbManager($log);
						$username = $dbm->createDatabaseAndUser(
								$username, $password
						);
					} else {
						// create database, user, set permissions, etc.pp.
						$dbm = new DbManager($log);
						$username = $dbm->createDatabase(
								$customer['loginname'], $password, $customer['mysql_lastaccountnumber']
						);
					}


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
						"customerid" => $customer['customerid'],
						"databasename" => $username,
						"description" => $databasedescription,
						"dbserver" => $dbserver
					);
					Database::pexecute($stmt, $params);

					$stmt = Database::prepare('UPDATE `' . TABLE_PANEL_CUSTOMERS . '`
                        SET `mysqls_used` = `mysqls_used` + 1, `mysql_lastaccountnumber` = `mysql_lastaccountnumber` + 1
                        WHERE `customerid` = :customerid'
					);
					Database::pexecute($stmt, array("customerid" => $customer['customerid']));

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
							'SALUTATION' => getCorrectUserSalutation($customer),
							'CUST_NAME' => getCorrectUserSalutation($customer), // < keep this for compatibility
							'DB_NAME' => $username,
							'DB_PASS' => $password,
							'DB_DESC' => $databasedescription,
							'DB_SRV' => $sql_root['host'],
							'PMA_URI' => $pma
						);

						$def_language = $customer['def_language'];
						$result_stmt = Database::prepare("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
							WHERE `adminid` = :adminid
							AND `language` = :lang
							AND `templategroup`='mails'
							AND `varname`='new_database_by_customer_subject'"
						);
						Database::pexecute($result_stmt, array("adminid" => $customer['adminid'], "lang" => $def_language));
						$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
						$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['new_database_by_customer']['subject']), $replace_arr));

						$result_stmt = Database::prepare("SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
							WHERE `adminid`= :adminid
							AND `language`= :lang
							AND `templategroup` = 'mails'
							AND `varname` = 'new_database_by_customer_mailbody'"
						);
						Database::pexecute($result_stmt, array("adminid" => $customer['adminid'], "lang" => $def_language));
						$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
						$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['new_database_by_customer']['mailbody']), $replace_arr));

						$_mailerror = false;
						try {
							$mail->Subject = $mail_subject;
							$mail->AltBody = $mail_body;
							$mail->MsgHTML(str_replace("\n", "<br />", $mail_body));
							$mail->AddAddress($customer['email'], getCorrectUserSalutation($customer));
							$mail->Send();
						} catch (phpmailerException $e) {
							$mailerr_msg = $e->errorMessage();
							$_mailerror = true;
						} catch (Exception $e) {
							$mailerr_msg = $e->getMessage();
							$_mailerror = true;
						}

						if ($_mailerror) {
							$log->logAction(USR_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
							standard_error('errorsendingmail', $customer['email']);
						}

						$mail->ClearAddresses();
					}

					redirectTo($filename, array('page' => $page, 's' => $s));
				}
			} else {

				$dbservers_stmt = Database::query("SELECT DISTINCT `dbserver` FROM `" . TABLE_PANEL_DATABASES . "`");
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

				$customers = makeoption($lng['panel']['please_choose'], 0, 0, true);
				$result_customers_stmt = Database::prepare("
					SELECT `customerid`, `loginname`, `name`, `firstname`, `company`
					FROM `" . TABLE_PANEL_CUSTOMERS . "` " . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = '" . (int) $userinfo['adminid'] . "' ") . " ORDER BY COALESCE(NULLIF(`name`,''), `company`) ASC");
				$params = array();
				if ($userinfo['customers_see_all'] == '0') {
					$params['adminid'] = $userinfo['adminid'];
				}
				Database::pexecute($result_customers_stmt, $params);

				while ($row_customer = $result_customers_stmt->fetch(PDO::FETCH_ASSOC)) {
					$customers .= makeoption(getCorrectFullUserDetails($row_customer) . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid']);
				}

				$mysql_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/database/formfield.database_add.php';
				$mysql_add_form = htmlform::genHTMLForm($mysql_add_data);

				$title = $mysql_add_data['mysql_add']['title'];
				$image = $mysql_add_data['mysql_add']['image'];

				eval("echo \"" . getTemplate('database/database_add') . "\";");
			}
		}
	}
}
