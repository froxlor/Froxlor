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
} elseif(isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'customers'
	&& $userinfo['customers'] != '0'
) {
	if ($action == '') {
		// clear request data
		unset($_SESSION['requestData']);

		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_customers");
		$fields = array(
			'c.loginname' => $lng['login']['username'],
			'a.loginname' => $lng['admin']['admin'],
			'c.name' => $lng['customer']['name'],
			'c.email' => $lng['customer']['email'],
			'c.firstname' => $lng['customer']['firstname'],
			'c.company' => $lng['customer']['company'],
			'c.diskspace' => $lng['customer']['diskspace'],
			'c.diskspace_used' => $lng['customer']['diskspace'] . ' (' . $lng['panel']['used'] . ')',
			'c.traffic' => $lng['customer']['traffic'],
			'c.traffic_used' => $lng['customer']['traffic'] . ' (' . $lng['panel']['used'] . ')'
		);

		$paging = new paging($userinfo, TABLE_PANEL_CUSTOMERS, $fields);
		$customers = '';
		$result_stmt = Database::prepare("
			SELECT `c`.*, `a`.`loginname` AS `adminname`
			FROM `" . TABLE_PANEL_CUSTOMERS . "` `c`, `" . TABLE_PANEL_ADMINS . "` `a`
			WHERE " .
			($userinfo['customers_see_all'] ? '' : " `c`.`adminid` = :adminid AND ") . "
			`c`.`adminid` = `a`.`adminid` " .
			$paging->getSqlWhere(true) . " " .
			$paging->getSqlOrderBy() . " " .
			$paging->getSqlLimit()
		);
		Database::pexecute($result_stmt, array('adminid' => $userinfo['adminid']));
		$num_rows = Database::num_rows();
		$paging->setEntries($num_rows);
		$sortcode = $paging->getHtmlSortCode($lng, true);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			if ($paging->checkDisplay($i)) {

				$domains_stmt = Database::prepare("
					SELECT COUNT(`id`) AS `domains`
					FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `customerid` = :cid
					AND `parentdomainid` = '0'
					AND `id`<> :stdd"
				);
				Database::pexecute($domains_stmt, array('cid' => $row['customerid'], 'stdd' => $row['standardsubdomain']));
				$domains = $domains_stmt->fetch(PDO::FETCH_ASSOC);
				$row['domains'] = intval($domains['domains']);
				$dec_places = Settings::Get('panel.decimal_places');
				$row['traffic_used'] = round($row['traffic_used'] / (1024 * 1024), $dec_places);
				$row['traffic'] = round($row['traffic'] / (1024 * 1024), $dec_places);
				$row['diskspace_used'] = round($row['diskspace_used'] / 1024, $dec_places);
				$row['diskspace'] = round($row['diskspace'] / 1024, $dec_places);
				$last_login = ((int)$row['lastlogin_succ'] == 0) ? $lng['panel']['neverloggedin'] : date('d.m.Y', $row['lastlogin_succ']);

				/**
				 * percent-values for progressbar
				 */
				//For Disk usage
				if ($row['diskspace'] > 0) {
					$disk_percent = round(($row['diskspace_used']*100)/$row['diskspace'], 2);
					$disk_doublepercent = round($disk_percent*2, 2);
				} else {
					$disk_percent = 0;
					$disk_doublepercent = 0;
				}

				if ($row['traffic'] > 0) {
					$traffic_percent = round(($row['traffic_used']*100)/$row['traffic'], 2);
					$traffic_doublepercent = round($traffic_percent*2, 2);
				} else {
					$traffic_percent = 0;
					$traffic_doublepercent = 0;
				}

				$islocked = 0;
				if ($row['loginfail_count'] >= Settings::Get('login.maxloginattempts')
					&& $row['lastlogin_fail'] > (time() - Settings::Get('login.deactivatetime'))
				) {
					$islocked = 1;
				}

				$row = str_replace_array('-1', 'UL', $row, 'diskspace traffic mysqls emails email_accounts email_forwarders ftps tickets subdomains');
				$row = htmlentities_array($row);
				eval("\$customers.=\"" . getTemplate("customers/customers_customer") . "\";");
				$count++;
			}

			$i++;
		}

		$customercount = $num_rows;
		eval("echo \"" . getTemplate("customers/customers") . "\";");

	} elseif($action == 'su'
	       && $id != 0
	) {
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `customerid` = :id" .
			($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid")
		);
		$params = array('id' => $id);
		if ($userinfo['customers_see_all'] == '0') {
			$params['adminid'] = $userinfo['adminid'];
		}
		$result = Database::pexecute_first($result_stmt, $params);

		$destination_user = $result['loginname'];

		if ($destination_user != '') {

			if ($result['deactivated'] == '1') {
				standard_error("usercurrentlydeactivated", $destination_user);
			}
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_SESSIONS . "`
				WHERE `userid` = :id
				AND `hash` = :hash"
			);
			$result = Database::pexecute_first($result_stmt, array('id' => $userinfo['userid'], 'hash' => $s));

			$s = md5(uniqid(microtime(), 1));
			$insert = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_SESSIONS . "` SET
					`hash` = :hash,
					`userid` = :id,
					`ipaddress` = :ip,
					`useragent` = :ua,
					`lastactivity` = :lastact,
					`language` = :lang,
					`adminsession` = '0'"
				);
			Database::pexecute($insert, array(
				'hash' => $s,
				'id' => $id,
				'ip' => $result['ipaddress'],
				'ua' => $result['useragent'],
				'lastact' => time(),
				'lang' => $result['language']
			));
			$log->logAction(ADM_ACTION, LOG_INFO, "switched user and is now '" . $destination_user . "'");

			$target = (isset($_GET['target']) ? $_GET['target'] : 'index');
			$redirect = "customer_".$target.".php";
			if (!file_exists(FROXLOR_INSTALL_DIR."/".$redirect)) {
				$redirect = "customer_index.php";
			}
			redirectTo($redirect, array('s' => $s), true);

		} else {
			redirectTo('index.php', array('action' => 'login'));
		}

	} elseif($action == 'unlock'
	       && $id != 0
	) {
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `customerid` = :id" .
			($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid")
		);
		$result_data = array('id' => $id);
		if ($userinfo['customers_see_all'] == '0') {
			$result_data['adminid'] = $userinfo['adminid'];
		}
		$result = Database::pexecute_first($result_stmt, $result_data);

		if ($result['loginname'] != '') {

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				$result_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
					`loginfail_count` = '0'
					WHERE `customerid`= :id"
				);
				Database::pexecute($result_stmt, array('id' => $id));
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {
				ask_yesno('customer_reallyunlock', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['loginname']);
			}
		}

	} elseif ($action == 'delete'
		&& $id != 0
	) {
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `customerid` = :id" .
			($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid")
		);
		$params = array('id' => $id);
		if ($userinfo['customers_see_all'] == '0') {
			$params['adminid'] = $userinfo['adminid'];
		}
		$result = Database::pexecute_first($result_stmt, $params);

		if ($result['loginname'] != '') {

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				$databases_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
					WHERE `customerid` = :id ORDER BY `dbserver`"
				);
				Database::pexecute($databases_stmt, array('id' => $id));
				Database::needRoot(true);
				$last_dbserver = 0;

				$dbm = new DbManager($log);

				while ($row_database = $databases_stmt->fetch(PDO::FETCH_ASSOC)) {

					if ($last_dbserver != $row_database['dbserver']) {
						Database::needRoot(true, $row_database['dbserver']);
						$dbm->getManager()->flushPrivileges();
						$last_dbserver = $row_database['dbserver'];
					}

					$dbm->getManager()->deleteDatabase($row_database['databasename']);
				}

				$dbm->getManager()->flushPrivileges();
				Database::needRoot(false);
				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));
				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DATABASES . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));
				// first gather all domain-id's to clean up panel_domaintoip accordingly
				$did_stmt = Database::prepare("SELECT `id` FROM `".TABLE_PANEL_DOMAINS."` WHERE `customerid` = :id");
				Database::pexecute($did_stmt, array('id' => $id));
				while ($row = $did_stmt->fetch(PDO::FETCH_ASSOC)) {
					$stmt = Database::prepare("DELETE FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_domain` = :did");
					Database::pexecute($stmt, array('did' => $row['id']));
				}
				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));
				$domains_deleted = $stmt->rowCount();
				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_HTPASSWDS . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));
				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_HTACCESS . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));
				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid` = :id AND `adminsession` = '0'");
				Database::pexecute($stmt, array('id' => $id));
				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_TRAFFIC . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));
				$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));
				$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));
				$result2_stmt = Database::prepare("SELECT `username` FROM `" . TABLE_FTP_USERS . "` WHERE `customerid` = :id");
				Database::pexecute($result2_stmt, array('id' => $id));
				while ($row = $result2_stmt->fetch(PDO::FETCH_ASSOC)) {
					$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_QUOTATALLIES . "` WHERE `name` = :name");
					Database::pexecute($stmt, array('name' => $row['username']));
				}
				$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_GROUPS . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));
				$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_USERS . "` WHERE `customerid` = :id");
				Database::pexecute($stmt, array('id' => $id));

				// Delete all waiting "create user" -tasks for this user, #276
				// Note: the WHERE selects part of a serialized array, but it should be safe this way
				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_TASKS . "`
					WHERE `type` = '2' AND `data` LIKE :loginname"
				);
				Database::pexecute($del_stmt, array('loginname' => "%:{$result['loginname']};%"));

				$admin_update_query = "UPDATE `" . TABLE_PANEL_ADMINS . "` SET `customers_used` = `customers_used` - 1 ";
				$admin_update_query.= ", `domains_used` = `domains_used` - 0" . (int)($domains_deleted - $result['subdomains_used']);

				if ($result['mysqls'] != '-1') {
					$admin_update_query.= ", `mysqls_used` = `mysqls_used` - 0" . (int)$result['mysqls'];
				}

				if ($result['emails'] != '-1') {
					$admin_update_query.= ", `emails_used` = `emails_used` - 0" . (int)$result['emails'];
				}

				if ($result['email_accounts'] != '-1') {
					$admin_update_query.= ", `email_accounts_used` = `email_accounts_used` - 0" . (int)$result['email_accounts'];
				}

				if ($result['email_forwarders'] != '-1') {
					$admin_update_query.= ", `email_forwarders_used` = `email_forwarders_used` - 0" . (int)$result['email_forwarders'];
				}

				if ($result['email_quota'] != '-1') {
					$admin_update_query.= ", `email_quota_used` = `email_quota_used` - 0" . (int)$result['email_quota'];
				}

				if ($result['subdomains'] != '-1') {
					$admin_update_query.= ", `subdomains_used` = `subdomains_used` - 0" . (int)$result['subdomains'];
				}

				if ($result['ftps'] != '-1') {
					$admin_update_query.= ", `ftps_used` = `ftps_used` - 0" . (int)$result['ftps'];
				}

				if ($result['tickets'] != '-1') {
					$admin_update_query.= ", `tickets_used` = `tickets_used` - 0" . (int)$result['tickets'];
				}

				if (($result['diskspace'] / 1024) != '-1') {
					$admin_update_query.= ", `diskspace_used` = `diskspace_used` - 0" . (int)$result['diskspace'];
				}

				$admin_update_query.= " WHERE `adminid` = '" . (int)$result['adminid'] . "'";
				Database::query($admin_update_query);
				$log->logAction(ADM_ACTION, LOG_INFO, "deleted user '" . $result['loginname'] . "'");
				inserttask('1');

				// Using nameserver, insert a task which rebuilds the server config
				inserttask('4');

				if (isset($_POST['delete_userfiles'])
						&& (int)$_POST['delete_userfiles'] == 1
				) {
					inserttask('6', $result['loginname']);
				}

				// Using filesystem - quota, insert a task which cleans the filesystem - quota
				inserttask('10');

				/*
				 * move old tickets to archive
				 */
				$tickets = ticket::customerHasTickets($id);
				if ($tickets !== false && isset($tickets[0])) {
					foreach ($tickets as $ticket) {
						$now = time();
						$mainticket = ticket::getInstanceOf($userinfo, (int)$ticket);
						$mainticket->Set('lastchange', $now, true, true);
						$mainticket->Set('lastreplier', '1', true, true);
						$mainticket->Set('status', '3', true, true);
						$mainticket->Update();
						$mainticket->Archive();
						$log->logAction(ADM_ACTION, LOG_NOTICE, "archived ticket '" . $mainticket->Get('subject') . "'");
					}
				}
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {
				ask_yesno_withcheckbox('admin_customer_reallydelete', 'admin_customer_alsoremovefiles', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['loginname']);
			}
		}

	} elseif($action == 'add') {

		if ($userinfo['customers_used'] < $userinfo['customers']
		   || $userinfo['customers'] == '-1'
		) {
			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				$name = validate($_POST['name'], 'name');
				$firstname = validate($_POST['firstname'], 'first name');
				$company = validate($_POST['company'], 'company');
				$street = validate($_POST['street'], 'street');
				$zipcode = validate($_POST['zipcode'], 'zipcode', '/^[0-9 \-A-Z]*$/');
				$city = validate($_POST['city'], 'city');
				$phone = validate($_POST['phone'], 'phone', '/^[0-9\- \+\(\)\/]*$/');
				$fax = validate($_POST['fax'], 'fax', '/^[0-9\- \+\(\)\/]*$/');
				$email = $idna_convert->encode(validate($_POST['email'], 'email'));
				$customernumber = validate($_POST['customernumber'], 'customer number', '/^[A-Za-z0-9 \-]*$/Di');
				$def_language = validate($_POST['def_language'], 'default language');
				$gender = intval_ressource($_POST['gender']);

				$diskspace = intval_ressource($_POST['diskspace']);
				if (isset($_POST['diskspace_ul'])) {
					$diskspace = - 1;
				}

				$traffic = doubleval_ressource($_POST['traffic']);
				if (isset($_POST['traffic_ul'])) {
					$traffic = - 1;
				}

				$subdomains = intval_ressource($_POST['subdomains']);
				if (isset($_POST['subdomains_ul'])) {
					$subdomains = - 1;
				}

				$emails = intval_ressource($_POST['emails']);
				if (isset($_POST['emails_ul'])) {
					$emails = - 1;
				}

				$email_accounts = intval_ressource($_POST['email_accounts']);
				if (isset($_POST['email_accounts_ul'])) {
					$email_accounts = - 1;
				}

				$email_forwarders = intval_ressource($_POST['email_forwarders']);
				if (isset($_POST['email_forwarders_ul'])) {
					$email_forwarders = - 1;
				}

				if (Settings::Get('system.mail_quota_enabled') == '1') {
					$email_quota = validate($_POST['email_quota'], 'email_quota', '/^\d+$/', 'vmailquotawrong', array('0', ''));
					if (isset($_POST['email_quota_ul'])) {
						$email_quota = - 1;
					}
				} else {
					$email_quota = - 1;
				}

				$email_imap = 0;
				if (isset($_POST['email_imap'])) {
					$email_imap = intval_ressource($_POST['email_imap']);
				}

				$email_pop3 = 0;
				if (isset($_POST['email_pop3'])) {
					$email_pop3 = intval_ressource($_POST['email_pop3']);
				}

				$ftps = 0;
				if (isset($_POST['ftps'])) {
					$ftps = intval_ressource($_POST['ftps']);
				}
				if (isset($_POST['ftps_ul'])) {
					$ftps = - 1;
				}

				$tickets = (Settings::Get('ticket.enabled') == 1 ? intval_ressource($_POST['tickets']) : 0);
				if (isset($_POST['tickets_ul'])
					&& Settings::Get('ticket.enabled') == '1'
				) {
					$tickets = - 1;
				}

				$mysqls = intval_ressource($_POST['mysqls']);
				if (isset($_POST['mysqls_ul'])) {
					$mysqls = - 1;
				}

				$createstdsubdomain = 0;
				if(isset($_POST['createstdsubdomain'])) {
					$createstdsubdomain = intval($_POST['createstdsubdomain']);
				}

				$password = validate($_POST['new_customer_password'], 'password');
				// only check if not empty,
				// cause empty == generate password automatically
				if ($password != '') {
					$password = validatePassword($password);
				}

				// gender out of range? [0,2]
				if ($gender < 0 || $gender > 2) {
					$gender = 0;
				}

				$sendpassword = 0;
				if (isset($_POST['sendpassword'])) {
					$sendpassword = intval($_POST['sendpassword']);
				}

				$phpenabled = 0;
				if (isset($_POST['phpenabled'])) {
					$phpenabled = intval($_POST['phpenabled']);
				}

				$perlenabled = 0;
				if (isset($_POST['perlenabled'])) {
					$perlenabled = intval($_POST['perlenabled']);
				}

				$store_defaultindex = 0;
				if (isset($_POST['store_defaultindex'])) {
					$store_defaultindex = intval($_POST['store_defaultindex']);
				}

				$diskspace = $diskspace * 1024;
				$traffic = $traffic * 1024 * 1024;

				if (((($userinfo['diskspace_used'] + $diskspace) > $userinfo['diskspace']) && ($userinfo['diskspace'] / 1024) != '-1')
				   || ((($userinfo['mysqls_used'] + $mysqls) > $userinfo['mysqls']) && $userinfo['mysqls'] != '-1')
				   || ((($userinfo['emails_used'] + $emails) > $userinfo['emails']) && $userinfo['emails'] != '-1')
				   || ((($userinfo['email_accounts_used'] + $email_accounts) > $userinfo['email_accounts']) && $userinfo['email_accounts'] != '-1')
				   || ((($userinfo['email_forwarders_used'] + $email_forwarders) > $userinfo['email_forwarders']) && $userinfo['email_forwarders'] != '-1')
				   || ((($userinfo['email_quota_used'] + $email_quota) > $userinfo['email_quota']) && $userinfo['email_quota'] != '-1' && Settings::Get('system.mail_quota_enabled') == '1')
				   || ((($userinfo['ftps_used'] + $ftps) > $userinfo['ftps']) && $userinfo['ftps'] != '-1')
				   || ((($userinfo['tickets_used'] + $tickets) > $userinfo['tickets']) && $userinfo['tickets'] != '-1')
				   || ((($userinfo['subdomains_used'] + $subdomains) > $userinfo['subdomains']) && $userinfo['subdomains'] != '-1')
				   || (($diskspace / 1024) == '-1' && ($userinfo['diskspace'] / 1024) != '-1')
				   || ($mysqls == '-1' && $userinfo['mysqls'] != '-1')
				   || ($emails == '-1' && $userinfo['emails'] != '-1')
				   || ($email_accounts == '-1' && $userinfo['email_accounts'] != '-1')
				   || ($email_forwarders == '-1' && $userinfo['email_forwarders'] != '-1')
				   || ($email_quota == '-1' && $userinfo['email_quota'] != '-1' && Settings::Get('system.mail_quota_enabled') == '1')
				   || ($ftps == '-1' && $userinfo['ftps'] != '-1')
				   || ($tickets == '-1' && $userinfo['tickets'] != '-1')
				   || ($subdomains == '-1' && $userinfo['subdomains'] != '-1')
				) {
					standard_error('youcantallocatemorethanyouhave');
					exit;
				}

				// Either $name and $firstname or the $company must be inserted
				if ($name == '' && $company == '') {
					standard_error(array('stringisempty', 'myname'));

				} elseif($firstname == '' && $company == '') {
					standard_error(array('stringisempty', 'myfirstname'));

				} elseif($email == '') {
					standard_error(array('stringisempty', 'emailadd'));

				} elseif(!validateEmail($email)) {
					standard_error('emailiswrong', $email);

				} else {

					if (isset($_POST['new_loginname'])
						&& $_POST['new_loginname'] != ''
					) {
						$accountnumber = intval(Settings::Get('system.lastaccountnumber'));
						$loginname = validate($_POST['new_loginname'], 'loginname', '/^[a-z][a-z0-9\-_]+$/i');

						// Accounts which match systemaccounts are not allowed, filtering them
						if (preg_match('/^' . preg_quote(Settings::Get('customer.accountprefix'), '/') . '([0-9]+)/', $loginname)) {
							standard_error('loginnameissystemaccount', Settings::Get('customer.accountprefix'));
						}

						// Additional filtering for Bug #962
						if (function_exists('posix_getpwnam')
								&& !in_array("posix_getpwnam", explode(",", ini_get('disable_functions')))
								&& posix_getpwnam($loginname)
						) {
							standard_error('loginnameissystemaccount', Settings::Get('customer.accountprefix'));
						}

					} else {
						$accountnumber = intval(Settings::Get('system.lastaccountnumber')) + 1;
						$loginname = Settings::Get('customer.accountprefix') . $accountnumber;
					}

					// Check if the account already exists
					$loginname_check_stmt = Database::prepare("
						SELECT `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `loginname` = :loginname"
					);
					$loginname_check = Database::pexecute_first($loginname_check_stmt, array('loginname' => $loginname));

					$loginname_check_admin_stmt = Database::prepare("
						SELECT `loginname` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `loginname` = :loginname"
					);
					$loginname_check_admin = Database::pexecute_first($loginname_check_admin_stmt, array('loginname' => $loginname));

					if (strtolower($loginname_check['loginname']) == strtolower($loginname)
						|| strtolower($loginname_check_admin['loginname']) == strtolower($loginname)
					) {
						standard_error('loginnameexists', $loginname);

					} elseif (!validateUsername($loginname, Settings::Get('panel.unix_names'), 14 - strlen(Settings::Get('customer.mysqlprefix')))) {
						if (strlen($loginname) > 14 - strlen(Settings::Get('customer.mysqlprefix'))) {
							standard_error('loginnameiswrong2', 14 - strlen(Settings::Get('customer.mysqlprefix')));
						} else {
							standard_error('loginnameiswrong', $loginname);
						}
					}

					$guid = intval(Settings::Get('system.lastguid')) + 1;
					$documentroot = makeCorrectDir(Settings::Get('system.documentroot_prefix') . '/' . $loginname);

					if (file_exists($documentroot)) {
						standard_error('documentrootexists', $documentroot);
					}

					if ($createstdsubdomain != '1') {
						$createstdsubdomain = '0';
					}

					if ($phpenabled != '0') {
						$phpenabled = '1';
					}

					if ($perlenabled != '0') {
						$perlenabled = '1';
					}

					if ($password == '') {
						$password = substr(md5(uniqid(microtime(), 1)), 12, 6);
					}

					$_theme = Settings::Get('panel.default_theme');

					$ins_data = array(
						'adminid' => $userinfo['adminid'],
						'loginname' => $loginname,
						'passwd' => md5($password),
						'name' => $name,
						'firstname' => $firstname,
						'gender' => $gender,
						'company' => $company,
						'street' => $street,
						'zipcode' => $zipcode,
						'city' => $city,
						'phone' => $phone,
						'fax' => $fax,
						'email' => $email,
						'customerno' => $customernumber,
						'lang' => $def_language,
						'docroot' => $documentroot,
						'guid' => $guid,
						'diskspace' => $diskspace,
						'traffic' => $traffic,
						'subdomains' => $subdomains,
						'emails' => $emails,
						'email_accounts' => $email_accounts,
						'email_forwarders' => $email_forwarders,
						'email_quota' => $email_quota,
						'ftps' => $ftps,
						'tickets' => $tickets,
						'mysqls' => $mysqls,
						'phpenabled' => $phpenabled,
						'imap' => $email_imap,
						'pop3' => $email_pop3,
						'perlenabled' => $perlenabled,
						'theme' => $_theme
					);

					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_PANEL_CUSTOMERS . "` SET
						`adminid` = :adminid,
						`loginname` = :loginname,
						`password` = :passwd,
						`name` = :name,
						`firstname` = :firstname,
						`gender` = :gender,
						`company` = :company,
						`street` = :street,
						`zipcode` = :zipcode,
						`city` = :city,
						`phone` = :phone,
						`fax` = :fax,
						`email` = :email,
						`customernumber` = :customerno,
						`def_language` = :lang,
						`documentroot` = :docroot,
						`guid` = :guid,
						`diskspace` = :diskspace,
						`traffic` = :traffic,
						`subdomains` = :subdomains,
						`emails` = :emails,
						`email_accounts` = :email_accounts,
						`email_forwarders` = :email_forwarders,
						`email_quota` = :email_quota,
						`ftps` = :ftps,
						`tickets` = :tickets,
						`mysqls` = :mysqls,
						`standardsubdomain` = '0',
						`phpenabled` = :phpenabled,
						`imap` = :imap,
						`pop3` = :pop3,
						`perlenabled` = :perlenabled,
						`theme` = :theme"
					);
					Database::pexecute($ins_stmt, $ins_data);

					$customerid = Database::lastInsertId();

					$admin_update_query = "UPDATE `" . TABLE_PANEL_ADMINS . "` SET `customers_used` = `customers_used` + 1";

					if ($mysqls != '-1') {
						$admin_update_query.= ", `mysqls_used` = `mysqls_used` + 0" . (int)$mysqls;
					}

					if ($emails != '-1') {
						$admin_update_query.= ", `emails_used` = `emails_used` + 0" . (int)$emails;
					}

					if ($email_accounts != '-1') {
						$admin_update_query.= ", `email_accounts_used` = `email_accounts_used` + 0" . (int)$email_accounts;
					}

					if ($email_forwarders != '-1') {
						$admin_update_query.= ", `email_forwarders_used` = `email_forwarders_used` + 0" . (int)$email_forwarders;
					}

					if ($email_quota != '-1') {
						$admin_update_query.= ", `email_quota_used` = `email_quota_used` + 0" . (int)$email_quota;
					}

					if ($subdomains != '-1') {
						$admin_update_query.= ", `subdomains_used` = `subdomains_used` + 0" . (int)$subdomains;
					}

					if ($ftps != '-1') {
						$admin_update_query.= ", `ftps_used` = `ftps_used` + 0" . (int)$ftps;
					}

					if ($tickets != '-1'
						&& Settings::Get('ticket.enabled') == 1
					) {
						$admin_update_query.= ", `tickets_used` = `tickets_used` + 0" . (int)$tickets;
					}

					if (($diskspace / 1024) != '-1') {
						$admin_update_query.= ", `diskspace_used` = `diskspace_used` + 0" . (int)$diskspace;
					}

					$admin_update_query.= " WHERE `adminid` = '" . (int)$userinfo['adminid'] . "'";
					Database::query($admin_update_query);

					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_SETTINGS . "` SET
							`value` = :guid
						WHERE `settinggroup` = 'system' AND `varname` = 'lastguid'"
					);
					Database::pexecute($upd_stmt, array('guid' => $guid));

					if ($accountnumber != intval(Settings::Get('system.lastaccountnumber'))) {
						$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_SETTINGS . "` SET
							`value` = :accno
						WHERE `settinggroup` = 'system' AND `varname` = 'lastaccountnumber'"
						);
						Database::pexecute($upd_stmt, array('accno' => $accountnumber));
					}

					$log->logAction(ADM_ACTION, LOG_INFO, "added user '" . $loginname . "'");
					inserttask('2', $loginname, $guid, $guid, $store_defaultindex);

					// Using filesystem - quota, insert a task which cleans the filesystem - quota
					inserttask('10');

					// Add htpasswd for the webalizer stats
					if (CRYPT_STD_DES == 1) {
						$saltfordescrypt = substr(md5(uniqid(microtime(), 1)), 4, 2);
						$htpasswdPassword = crypt($password, $saltfordescrypt);
					} else {
						$htpasswdPassword = crypt($password);
					}

					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_PANEL_HTPASSWDS . "` SET
							`customerid` = :customerid,
							`username` = :username,
							`password` = :passwd,
							`path` = :path"
					);
					$ins_data = array(
						'customerid' => $customerid,
						'username' => $loginname,
						'passwd' => $htpasswdPassword
					);

					if (Settings::Get('system.awstats_enabled') == '1') {
						$ins_data['path'] = makeCorrectDir($documentroot . '/awstats/');
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added awstats htpasswd for user '" . $loginname . "'");
					} else {
						$ins_data['path'] = makeCorrectDir($documentroot . '/webalizer/');
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added webalizer htpasswd for user '" . $loginname . "'");
					}
					Database::pexecute($ins_stmt, $ins_data);

					inserttask('1');
					$cryptPassword = makeCryptPassword($password);
					// FTP-User
					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_FTP_USERS . "` SET `customerid` = :customerid, `username` = :username, `description` = :desc,
							`password` = :passwd, `homedir` = :homedir, `login_enabled` = 'y', `uid` = :guid, `gid` = :guid"
					);
					$ins_data = array(
						'customerid' => $customerid,
						'username' => $loginname,
						'passwd' => $cryptPassword,
						'homedir' => $documentroot,
						'guid' => $guid,
						'desc' => "Default"
					);
					Database::pexecute($ins_stmt, $ins_data);
					// FTP-Group
					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_FTP_GROUPS . "` SET `customerid` = :customerid, `groupname` = :groupname, `gid` = :guid, `members` = :members"
					);
					$ins_data = array(
							'customerid' => $customerid,
							'groupname' => $loginname,
							'guid' => $guid,
							'members' => $loginname.','.Settings::Get('system.httpuser')
					);
					Database::pexecute($ins_stmt, $ins_data);
					// FTP-Quotatallies
					$ins_stmt = Database::prepare("
						INSERT INTO `" . TABLE_FTP_QUOTATALLIES . "` SET `name` = :name, `quota_type` = 'user', `bytes_in_used` = '0',
						`bytes_out_used` = '0', `bytes_xfer_used` = '0', `files_in_used` = '0', `files_out_used` = '0', `files_xfer_used` = '0'"
					);
					Database::pexecute($ins_stmt, array('name' => $loginname));
					$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added ftp-account for user '" . $loginname . "'");

					$_stdsubdomain = '';

					if ($createstdsubdomain == '1') {

						if (Settings::Get('system.stdsubdomain') !== null
							&& Settings::Get('system.stdsubdomain') != ''
						) {
							$_stdsubdomain = $loginname . '.' . Settings::Get('system.stdsubdomain');
						} else {
							$_stdsubdomain = $loginname . '.' . Settings::Get('system.hostname');
						}

						$ins_data = array(
							'domain' => $_stdsubdomain,
							'customerid' => $customerid,
							'adminid' => $userinfo['adminid'],
							'docroot' => $documentroot,
							'adddate' => date('Y-m-d')
						);
						$ins_stmt = Database::prepare("
							INSERT INTO `" . TABLE_PANEL_DOMAINS . "` SET
							`domain` = :domain,
							`customerid` = :customerid,
							`adminid` = :adminid,
							`parentdomainid` = '-1',
							`documentroot` = :docroot,
							`zonefile` = '',
							`isemaildomain` = '0',
							`caneditdomain` = '0',
							`openbasedir` = '1',
							`speciallogfile` = '0',
							`specialsettings` = '',
							`dkim_id` = '0',
							`dkim_privkey` = '',
							`dkim_pubkey` = '',
							`add_date` = :adddate"
						);
						Database::pexecute($ins_stmt, $ins_data);
						$domainid = Database::lastInsertId();

						// set ip <-> domain connection
						$ins_stmt = Database::prepare("
							INSERT INTO `".TABLE_DOMAINTOIP."` SET `id_domain` = :domainid, `id_ipandports` = :ipid"
						);
						Database::pexecute($ins_stmt, array('domainid' => $domainid, 'ipid' => Settings::Get('system.defaultip')));

						$upd_stmt = Database::prepare("
							UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `standardsubdomain` = :domainid WHERE `customerid` = :customerid"
						);
						Database::pexecute($upd_stmt, array('domainid' => $domainid, 'customerid' => $customerid));
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added standardsubdomain for user '" . $loginname . "'");
						inserttask('1');
					}

					if ($sendpassword == '1') {

						$srv_hostname = Settings::Get('system.hostname');
						if (Settings::Get('system.froxlordirectlyviahostname') == '0') {
							$srv_hostname .= '/froxlor';
						}

						$srv_ip_stmt = Database::prepare("
							SELECT ip, port FROM `".TABLE_PANEL_IPSANDPORTS."`
							WHERE `id` = :defaultip
						");
						$srv_ip = Database::pexecute_first($srv_ip_stmt, array('defaultip' => Settings::Get('system.defaultip')));

						$replace_arr = array(
							'FIRSTNAME' => $firstname,
							'NAME' => $name,
							'COMPANY' => $company,
							'SALUTATION' => getCorrectUserSalutation(array('firstname' => $firstname, 'name' => $name, 'company' => $company)),
							'USERNAME' => $loginname,
							'PASSWORD' => $password,
							'SERVER_HOSTNAME' => $srv_hostname,
							'SERVER_IP' => isset($srv_ip['ip']) ? $srv_ip['ip'] : '',
							'SERVER_PORT' => isset($srv_ip['port']) ? $srv_ip['port'] : '',
							'DOMAINNAME' => $_stdsubdomain
						);

						// Get mail templates from database; the ones from 'admin' are fetched for fallback
						$result_stmt = Database::prepare("
							SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
							WHERE `adminid` = :adminid AND `language` = :deflang AND `templategroup` = 'mails' AND `varname` = 'createcustomer_subject'"
						);
						$result = Database::pexecute_first($result_stmt, array('adminid' => $userinfo['adminid'], 'deflang' => $def_language));
						$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['createcustomer']['subject']), $replace_arr));

						$result_stmt = Database::prepare("
							SELECT `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
							WHERE `adminid` = :adminid AND `language` = :deflang AND `templategroup` = 'mails' AND `varname` = 'createcustomer_mailbody'"
						);
						$result = Database::pexecute_first($result_stmt, array('adminid' => $userinfo['adminid'], 'deflang' => $def_language));
						$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['createcustomer']['mailbody']), $replace_arr));

						$_mailerror = false;
						try {
							$mail->Subject = $mail_subject;
							$mail->AltBody = $mail_body;
							$mail->MsgHTML(str_replace("\n", "<br />", $mail_body));
							$mail->AddAddress($email, getCorrectUserSalutation(array('firstname' => $firstname, 'name' => $name, 'company' => $company)));
							$mail->Send();
						} catch(phpmailerException $e) {
							$mailerr_msg = $e->errorMessage();
							$_mailerror = true;
						} catch (Exception $e) {
							$mailerr_msg = $e->getMessage();
							$_mailerror = true;
						}

						if ($_mailerror) {
							$log->logAction(ADM_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
							standard_error('errorsendingmail', $email);
						}

						$mail->ClearAddresses();
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically sent password to user '" . $loginname . "'");
					}
					redirectTo($filename, array('page' => $page, 's' => $s));
				}

			} else {
				$language_options = '';

				while (list($language_file, $language_name) = each($languages)) {
					$language_options.= makeoption($language_name, $language_file, Settings::Get('panel.standardlanguage'), true);
				}

				$diskspace_ul = makecheckbox('diskspace_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$traffic_ul = makecheckbox('traffic_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$subdomains_ul = makecheckbox('subdomains_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$emails_ul = makecheckbox('emails_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$email_accounts_ul = makecheckbox('email_accounts_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$email_forwarders_ul = makecheckbox('email_forwarders_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$email_quota_ul = makecheckbox('email_quota_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$ftps_ul = makecheckbox('ftps_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$tickets_ul = makecheckbox('tickets_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$mysqls_ul = makecheckbox('mysqls_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);

				$gender_options = makeoption($lng['gender']['undef'], 0, true, true, true);
				$gender_options .= makeoption($lng['gender']['male'], 1, null, true, true);
				$gender_options .= makeoption($lng['gender']['female'], 2, null, true, true);

				$customer_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/customer/formfield.customer_add.php';
				$customer_add_form = htmlform::genHTMLForm($customer_add_data);

				$title = $customer_add_data['customer_add']['title'];
				$image = $customer_add_data['customer_add']['image'];

				eval("echo \"" . getTemplate("customers/customers_add") . "\";");
			}
		}

	} elseif($action == 'edit'
		&& $id != 0
	) {

		$result_data = array('id' => $id);
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `customerid` = :id" . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid")
		);
		if ($userinfo['customers_see_all'] == '0') {
			$result_data['adminid'] = $userinfo['adminid'];
		}
		$result = Database::pexecute_first($result_stmt, $result_data);

		if ($result['loginname'] != '') {

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {

				$name = validate($_POST['name'], 'name');
				$firstname = validate($_POST['firstname'], 'first name');
				$company = validate($_POST['company'], 'company');
				$street = validate($_POST['street'], 'street');
				$zipcode = validate($_POST['zipcode'], 'zipcode', '/^[0-9 \-A-Z]*$/');
				$city = validate($_POST['city'], 'city');
				$phone = validate($_POST['phone'], 'phone', '/^[0-9\- \+\(\)\/]*$/');
				$fax = validate($_POST['fax'], 'fax', '/^[0-9\- \+\(\)\/]*$/');
				$email = $idna_convert->encode(validate($_POST['email'], 'email'));
				$customernumber = validate($_POST['customernumber'], 'customer number', '/^[A-Za-z0-9 \-]*$/Di');
				$def_language = validate($_POST['def_language'], 'default language');
				$password = validate($_POST['new_customer_password'], 'new password');
				$gender = intval_ressource($_POST['gender']);

				$diskspace = intval_ressource($_POST['diskspace']);
				if (isset($_POST['diskspace_ul'])) {
					$diskspace = - 1;
				}

				$traffic = doubleval_ressource($_POST['traffic']);
				if (isset($_POST['traffic_ul'])) {
					$traffic = - 1;
				}

				$subdomains = intval_ressource($_POST['subdomains']);
				if (isset($_POST['subdomains_ul'])) {
					$subdomains = - 1;
				}

				$emails = intval_ressource($_POST['emails']);
				if (isset($_POST['emails_ul'])) {
					$emails = - 1;
				}

				$email_accounts = intval_ressource($_POST['email_accounts']);
				if (isset($_POST['email_accounts_ul'])) {
					$email_accounts = - 1;
				}

				$email_forwarders = intval_ressource($_POST['email_forwarders']);
				if (isset($_POST['email_forwarders_ul'])) {
					$email_forwarders = - 1;
				}

				if (Settings::Get('system.mail_quota_enabled') == '1') {
					$email_quota = validate($_POST['email_quota'], 'email_quota', '/^\d+$/', 'vmailquotawrong', array('0', ''));
					if (isset($_POST['email_quota_ul'])) {
						$email_quota = - 1;
					}
				} else {
					$email_quota = - 1;
				}

				$email_imap = 0;
				if (isset($_POST['email_imap'])) {
					$email_imap = intval_ressource($_POST['email_imap']);
				}

				$email_pop3 = 0;
				if (isset($_POST['email_pop3'])) {
					$email_pop3 = intval_ressource($_POST['email_pop3']);
				}

				$ftps = 0;
				if (isset($_POST['ftps'])) {
					$ftps = intval_ressource($_POST['ftps']);
				}
				if (isset($_POST['ftps_ul'])) {
					$ftps = - 1;
				}

				$tickets = (Settings::Get('ticket.enabled') == 1 ? intval_ressource($_POST['tickets']) : 0);
				if (isset($_POST['tickets_ul'])
					&& Settings::Get('ticket.enabled') == '1'
				) {
					$tickets = - 1;
				}

				// gender out of range? [0,2]
				if ($gender < 0 || $gender > 2) {
					$gender = 0;
				}

				$mysqls = 0;
				if (isset($_POST['mysqls'])) {
					$mysqls = intval_ressource($_POST['mysqls']);
				}
				if (isset($_POST['mysqls_ul'])) {
					$mysqls = - 1;
				}

				$createstdsubdomain = 0;
				if (isset($_POST['createstdsubdomain'])) {
					$createstdsubdomain = intval($_POST['createstdsubdomain']);
				}

				$deactivated = 0;
				if (isset($_POST['deactivated'])) {
					$deactivated = intval($_POST['deactivated']);
				}

				$phpenabled = 0;
				if (isset($_POST['phpenabled'])) {
					$phpenabled = intval($_POST['phpenabled']);
				}

				$perlenabled = 0;
				if (isset($_POST['perlenabled'])) {
					$perlenabled = intval($_POST['perlenabled']);
				}

				$diskspace = $diskspace * 1024;
				$traffic = $traffic * 1024 * 1024;

				if (((($userinfo['diskspace_used'] + $diskspace - $result['diskspace']) > $userinfo['diskspace']) && ($userinfo['diskspace'] / 1024) != '-1')
				   || ((($userinfo['mysqls_used'] + $mysqls - $result['mysqls']) > $userinfo['mysqls']) && $userinfo['mysqls'] != '-1')
				   || ((($userinfo['emails_used'] + $emails - $result['emails']) > $userinfo['emails']) && $userinfo['emails'] != '-1')
				   || ((($userinfo['email_accounts_used'] + $email_accounts - $result['email_accounts']) > $userinfo['email_accounts']) && $userinfo['email_accounts'] != '-1')
				   || ((($userinfo['email_forwarders_used'] + $email_forwarders - $result['email_forwarders']) > $userinfo['email_forwarders']) && $userinfo['email_forwarders'] != '-1')
				   || ((($userinfo['email_quota_used'] + $email_quota - $result['email_quota']) > $userinfo['email_quota']) && $userinfo['email_quota'] != '-1' && Settings::Get('system.mail_quota_enabled') == '1')
				   || ((($userinfo['ftps_used'] + $ftps - $result['ftps']) > $userinfo['ftps']) && $userinfo['ftps'] != '-1')
				   || ((($userinfo['tickets_used'] + $tickets - $result['tickets']) > $userinfo['tickets']) && $userinfo['tickets'] != '-1')
				   || ((($userinfo['subdomains_used'] + $subdomains - $result['subdomains']) > $userinfo['subdomains']) && $userinfo['subdomains'] != '-1')
				   || (($diskspace / 1024) == '-1' && ($userinfo['diskspace'] / 1024) != '-1')
				   || ($mysqls == '-1' && $userinfo['mysqls'] != '-1')
				   || ($emails == '-1' && $userinfo['emails'] != '-1')
				   || ($email_accounts == '-1' && $userinfo['email_accounts'] != '-1')
				   || ($email_forwarders == '-1' && $userinfo['email_forwarders'] != '-1')
				   || ($email_quota == '-1' && $userinfo['email_quota'] != '-1' && Settings::Get('system.mail_quota_enabled') == '1')
				   || ($ftps == '-1' && $userinfo['ftps'] != '-1')
				   || ($tickets == '-1' && $userinfo['tickets'] != '-1')
				   || ($subdomains == '-1' && $userinfo['subdomains'] != '-1')
				) {
					standard_error('youcantallocatemorethanyouhave');
					exit;
				}

				// Either $name and $firstname or the $company must be inserted
				if ($name == '' && $company == '') {
					standard_error(array('stringisempty', 'myname'));

				} elseif($firstname == '' && $company == '') {
					standard_error(array('stringisempty', 'myfirstname'));

				} elseif($email == '') {
					standard_error(array('stringisempty', 'emailadd'));

				} elseif(!validateEmail($email)) {
					standard_error('emailiswrong', $email);

				} else {

					if ($password != '') {
						$password = validatePassword($password);
						$password = md5($password);
					} else {
						$password = $result['password'];
					}

					if ($createstdsubdomain != '1') {
						$createstdsubdomain = '0';
					}

					if ($createstdsubdomain == '1'
						&& $result['standardsubdomain'] == '0'
					) {

						if (Settings::Get('system.stdsubdomain') !== null
							&& Settings::Get('system.stdsubdomain') != ''
						) {
							$_stdsubdomain = $result['loginname'] . '.' . Settings::Get('system.stdsubdomain');
						} else {
							$_stdsubdomain = $result['loginname'] . '.' . Settings::Get('system.hostname');
						}

						$ins_data = array(
								'domain' => $_stdsubdomain,
								'customerid' => $result['customerid'],
								'adminid' => $userinfo['adminid'],
								'docroot' => $result['documentroot'],
								'adddate' => date('Y-m-d')
						);
						$ins_stmt = Database::prepare("
							INSERT INTO `" . TABLE_PANEL_DOMAINS . "` SET
							`domain` = :domain,
							`customerid` = :customerid,
							`adminid` = :adminid,
							`parentdomainid` = '-1',
							`documentroot` = :docroot,
							`zonefile` = '',
							`isemaildomain` = '0',
							`caneditdomain` = '0',
							`openbasedir` = '1',
							`speciallogfile` = '0',
							`specialsettings` = '',
							`add_date` = :adddate"
						);
						Database::pexecute($ins_stmt, $ins_data);
						$domainid = Database::lastInsertId();

						// set ip <-> domain connection
						$ins_stmt = Database::prepare("
							INSERT INTO `".TABLE_DOMAINTOIP."` SET `id_domain` = :domainid, `id_ipandports` = :ipid"
						);
						Database::pexecute($ins_stmt, array('domainid' => $domainid, 'ipid' => Settings::Get('system.defaultip')));

						$upd_stmt = Database::prepare("
							UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `standardsubdomain` = :domainid WHERE `customerid` = :customerid"
						);
						Database::pexecute($upd_stmt, array('domainid' => $domainid, 'customerid' => $result['customerid']));
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added standardsubdomain for user '" . $result['loginname'] . "'");
						inserttask('1');
					}

					if ($createstdsubdomain == '0'
						&& $result['standardsubdomain'] != '0'
					) {

						$del_stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `id` = :stdsub");
						Database::pexecute($del_stmt, array('stdsub' => $result['standardsubdomain']));
						$del_stmt = Database::prepare("DELETE FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_domain` = :stdsub");
						Database::pexecute($del_stmt, array('stdsub' => $result['standardsubdomain']));
						$del_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `standardsubdomain`= '0' WHERE `customerid` = :customerid");
						Database::pexecute($del_stmt, array('customerid' => $result['customerid']));
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically deleted standardsubdomain for user '" . $result['loginname'] . "'");
						inserttask('1');
					}

					if ($deactivated != '1') {
						$deactivated = '0';
					}

					if ($phpenabled != '0') {
						$phpenabled = '1';
					}

					if ($perlenabled != '0') {
						$perlenabled = '1';
					}

					if ($phpenabled != $result['phpenabled']
						|| $perlenabled != $result['perlenabled']
					) {
						inserttask('1');
					}

					// activate/deactivate customer services
					if ($deactivated != $result['deactivated']) {

						$yesno = (($deactivated) ? 'N' : 'Y');
						$pop3 = (($deactivated) ? '0' : (int)$result['pop3']);
						$imap = (($deactivated) ? '0' : (int)$result['imap']);

						$upd_stmt = Database::prepare("
							UPDATE `" . TABLE_MAIL_USERS . "` SET `postfix`= :yesno, `pop3` = :pop3, `imap` = :imap WHERE `customerid` = :customerid"
						);
						Database::pexecute($upd_stmt, array('yesno' => $yesno, 'pop3' => $pop3, 'imap' => $imap, 'customerid' => $id));

						$upd_stmt = Database::prepare("
							UPDATE `" . TABLE_FTP_USERS . "` SET `login_enabled` = :yesno WHERE `customerid` = :customerid"
						);
						Database::pexecute($upd_stmt, array('yesno' => $yesno, 'customerid' => $id));

						$upd_stmt = Database::prepare("
							UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `deactivated`= :deactivated WHERE `customerid` = :customerid"
						);
						Database::pexecute($upd_stmt, array('deactivated' => $deactivated, 'customerid' => $id));

						// Retrieve customer's databases
						$databases_stmt = Database::prepare("SELECT * FROM " . TABLE_PANEL_DATABASES . " WHERE customerid = :customerid ORDER BY `dbserver`");
						Database::pexecute($databases_stmt, array('customerid' => $id));

						Database::needRoot(true);
						$last_dbserver = 0;

						$dbm = new DbManager($log);

						// For each of them
						while ($row_database = $databases_stmt->fetch(PDO::FETCH_ASSOC)) {

							if ($last_dbserver != $row_database['dbserver']) {
								$dbm->getManager()->flushPrivileges();
								Database::needRoot(true, $row_database['dbserver']);
								$last_dbserver = $row_database['dbserver'];
							}

							foreach (array_unique(explode(',', Settings::Get('system.mysql_access_host'))) as $mysql_access_host) {
								$mysql_access_host = trim($mysql_access_host);

								// Prevent access, if deactivated
								if ($deactivated) {
									// failsafe if user has been deleted manually (requires MySQL 4.1.2+)
									$dbm->getManager()->disableUser($row_database['databasename'], $mysql_access_host);
								} else {
									// Otherwise grant access
									$dbm->getManager()->enableUser($row_database['databasename'], $mysql_access_host);
								}
							}
						}

						// At last flush the new privileges
						$dbm->getManager()->flushPrivileges();
						Database::needRoot(false);

						$log->logAction(ADM_ACTION, LOG_INFO, "deactivated user '" . $result['loginname'] . "'");
						inserttask('1');
					}

					// Disable or enable POP3 Login for customers Mail Accounts
					if ($email_pop3 != $result['pop3']) {
						$upd_stmt = Database::prepare("UPDATE `" . TABLE_MAIL_USERS . "` SET `pop3` = :pop3 WHERE `customerid` = :customerid");
						Database::pexecute($upd_stmt, array('pop3' => $email_pop3, 'customerid' => $id));
					}

					// Disable or enable IMAP Login for customers Mail Accounts
					if ($email_imap != $result['imap']) {
						$upd_stmt = Database::prepare("UPDATE `" . TABLE_MAIL_USERS . "` SET `imap` = :imap WHERE `customerid` = :customerid");
						Database::pexecute($upd_stmt, array('imap' => $email_imap, 'customerid' => $id));
					}

					$upd_data = array(
						'customerid' => $id,
						'passwd' => $password,
						'name' => $name,
						'firstname' => $firstname,
						'gender' => $gender,
						'company' => $company,
						'street' => $street,
						'zipcode' => $zipcode,
						'city' => $city,
						'phone' => $phone,
						'fax' => $fax,
						'email' => $email,
						'customerno' => $customernumber,
						'lang' => $def_language,
						'diskspace' => $diskspace,
						'traffic' => $traffic,
						'subdomains' => $subdomains,
						'emails' => $emails,
						'email_accounts' => $email_accounts,
						'email_forwarders' => $email_forwarders,
						'email_quota' => $email_quota,
						'ftps' => $ftps,
						'tickets' => $tickets,
						'mysqls' => $mysqls,
						'deactivated' => $deactivated,
						'phpenabled' => $phpenabled,
						'imap' => $email_imap,
						'pop3' => $email_pop3,
						'perlenabled' => $perlenabled
					);
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
						`name` = :name,
						`firstname` = :firstname,
						`gender` = :gender,
						`company` = :company,
						`street` = :street,
						`zipcode` = :zipcode,
						`city` = :city,
						`phone` = :phone,
						`fax` = :fax,
						`email` = :email,
						`customernumber` = :customerno,
						`def_language` = :lang,
						`password` = :passwd,
						`diskspace` = :diskspace,
						`traffic` = :traffic,
						`subdomains` = :subdomains,
						`emails` = :emails,
						`email_accounts` = :email_accounts,
						`email_forwarders` = :email_forwarders,
						`ftps` = :ftps,
						`tickets` = :tickets,
						`mysqls` = :mysqls,
						`deactivated` = :deactivated,
						`phpenabled` = :phpenabled,
						`email_quota` = :email_quota,
						`imap` = :imap,
						`pop3` = :pop3,
						`perlenabled` = :perlenabled
						WHERE `customerid` = :customerid"
					);
					Database::pexecute($upd_stmt, $upd_data);

					// Using filesystem - quota, insert a task which cleans the filesystem - quota
					inserttask('10');

					$admin_update_query = "UPDATE `" . TABLE_PANEL_ADMINS . "` SET `customers_used` = `customers_used` ";

					if ($mysqls != '-1' || $result['mysqls'] != '-1') {
						$admin_update_query.= ", `mysqls_used` = `mysqls_used` ";

						if ($mysqls != '-1') {
							$admin_update_query.= " + 0" . (int)$mysqls . " ";
						}
						if ($result['mysqls'] != '-1') {
							$admin_update_query.= " - 0" . (int)$result['mysqls'] . " ";
						}
					}

					if($emails != '-1' || $result['emails'] != '-1') {
						$admin_update_query.= ", `emails_used` = `emails_used` ";

						if ($emails != '-1') {
							$admin_update_query.= " + 0" . (int)$emails . " ";
						}
						if ($result['emails'] != '-1') {
							$admin_update_query.= " - 0" . (int)$result['emails'] . " ";
						}
					}

					if ($email_accounts != '-1' || $result['email_accounts'] != '-1') {
						$admin_update_query.= ", `email_accounts_used` = `email_accounts_used` ";

						if ($email_accounts != '-1') {
							$admin_update_query.= " + 0" . (int)$email_accounts . " ";
						}
						if ($result['email_accounts'] != '-1') {
							$admin_update_query.= " - 0" . (int)$result['email_accounts'] . " ";
						}
					}

					if ($email_forwarders != '-1' || $result['email_forwarders'] != '-1') {
						$admin_update_query.= ", `email_forwarders_used` = `email_forwarders_used` ";

						if ($email_forwarders != '-1') {
							$admin_update_query.= " + 0" . (int)$email_forwarders . " ";
						}
						if ($result['email_forwarders'] != '-1') {
							$admin_update_query.= " - 0" . (int)$result['email_forwarders'] . " ";
						}
					}

					if ($email_quota != '-1' || $result['email_quota'] != '-1') {
						$admin_update_query.= ", `email_quota_used` = `email_quota_used` ";

						if ($email_quota != '-1') {
							$admin_update_query.= " + 0" . (int)$email_quota . " ";
						}
						if ($result['email_quota'] != '-1') {
							$admin_update_query.= " - 0" . (int)$result['email_quota'] . " ";
						}
					}

					if ($subdomains != '-1' || $result['subdomains'] != '-1') {
						$admin_update_query.= ", `subdomains_used` = `subdomains_used` ";

						if ($subdomains != '-1') {
							$admin_update_query.= " + 0" . (int)$subdomains . " ";
						}
						if ($result['subdomains'] != '-1') {
							$admin_update_query.= " - 0" . (int)$result['subdomains'] . " ";
						}
					}

					if ($ftps != '-1' || $result['ftps'] != '-1') {
						$admin_update_query.= ", `ftps_used` = `ftps_used` ";

						if ($ftps != '-1') {
							$admin_update_query.= " + 0" . (int)$ftps . " ";
						}
						if ($result['ftps'] != '-1') {
							$admin_update_query.= " - 0" . (int)$result['ftps'] . " ";
						}
					}

					if ($tickets != '-1' || $result['tickets'] != '-1') {
						$admin_update_query.= ", `tickets_used` = `tickets_used` ";

						if ($tickets != '-1') {
							$admin_update_query.= " + 0" . (int)$tickets . " ";
						}
						if ($result['tickets'] != '-1') {
							$admin_update_query.= " - 0" . (int)$result['tickets'] . " ";
						}
					}

					if (($diskspace / 1024) != '-1' || ($result['diskspace'] / 1024) != '-1') {
						$admin_update_query.= ", `diskspace_used` = `diskspace_used` ";

						if (($diskspace / 1024) != '-1') {
							$admin_update_query.= " + 0" . (int)$diskspace . " ";
						}
						if (($result['diskspace'] / 1024) != '-1') {
							$admin_update_query.= " - 0" . (int)$result['diskspace'] . " ";
						}
					}

					$admin_update_query.= " WHERE `adminid` = '" . (int)$result['adminid'] . "'";
					Database::query($admin_update_query);
					$log->logAction(ADM_ACTION, LOG_INFO, "edited user '" . $result['loginname'] . "'");
					$redirect_props = Array(
						'page' => $page,
						's' => $s
					);

					redirectTo($filename, $redirect_props);
				}

			} else {
				$language_options = '';

				while (list($language_file, $language_name) = each($languages)) {
					$language_options.= makeoption($language_name, $language_file, $result['def_language'], true);
				}

				$dec_places = Settings::Get('panel.decimal_places');
				$result['traffic'] = round($result['traffic'] / (1024 * 1024), $dec_places);
				$result['diskspace'] = round($result['diskspace'] / 1024, $dec_places);
				$result['email'] = $idna_convert->decode($result['email']);

				$diskspace_ul = makecheckbox('diskspace_ul', $lng['customer']['unlimited'], '-1', false, $result['diskspace'], true, true);
				if ($result['diskspace'] == '-1') {
					$result['diskspace'] = '';
				}

				$traffic_ul = makecheckbox('traffic_ul', $lng['customer']['unlimited'], '-1', false, $result['traffic'], true, true);
				if ($result['traffic'] == '-1') {
					$result['traffic'] = '';
				}

				$subdomains_ul = makecheckbox('subdomains_ul', $lng['customer']['unlimited'], '-1', false, $result['subdomains'], true, true);
				if ($result['subdomains'] == '-1') {
					$result['subdomains'] = '';
				}

				$emails_ul = makecheckbox('emails_ul', $lng['customer']['unlimited'], '-1', false, $result['emails'], true, true);
				if ($result['emails'] == '-1') {
					$result['emails'] = '';
				}

				$email_accounts_ul = makecheckbox('email_accounts_ul', $lng['customer']['unlimited'], '-1', false, $result['email_accounts'], true, true);
				if ($result['email_accounts'] == '-1') {
					$result['email_accounts'] = '';
				}

				$email_forwarders_ul = makecheckbox('email_forwarders_ul', $lng['customer']['unlimited'], '-1', false, $result['email_forwarders'], true, true);
				if ($result['email_forwarders'] == '-1') {
					$result['email_forwarders'] = '';
				}

				$email_quota_ul = makecheckbox('email_quota_ul', $lng['customer']['unlimited'], '-1', false, $result['email_quota'], true, true);
				if ($result['email_quota'] == '-1') {
					$result['email_quota'] = '';
				}

				$ftps_ul = makecheckbox('ftps_ul', $lng['customer']['unlimited'], '-1', false, $result['ftps'], true, true);
				if ($result['ftps'] == '-1') {
					$result['ftps'] = '';
				}

				$tickets_ul = makecheckbox('tickets_ul', $lng['customer']['unlimited'], '-1', false, $result['tickets'], true, true);
				if ($result['tickets'] == '-1') {
					$result['tickets'] = '';
				}

				$mysqls_ul = makecheckbox('mysqls_ul', $lng['customer']['unlimited'], '-1', false, $result['mysqls'], true, true);
				if ($result['mysqls'] == '-1') {
					$result['mysqls'] = '';
				}

				$result = htmlentities_array($result);

				$gender_options = makeoption($lng['gender']['undef'], 0, ($result['gender'] == '0' ? true : false), true, true);
				$gender_options .= makeoption($lng['gender']['male'], 1, ($result['gender'] == '1' ? true : false), true, true);
				$gender_options .= makeoption($lng['gender']['female'], 2, ($result['gender'] == '2' ? true : false), true, true);

				$customer_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/customer/formfield.customer_edit.php';
				$customer_edit_form = htmlform::genHTMLForm($customer_edit_data);

				$title = $customer_edit_data['customer_edit']['title'];
				$image = $customer_edit_data['customer_edit']['image'];

				eval("echo \"" . getTemplate("customers/customers_edit") . "\";");
			}
		}
	}
}
