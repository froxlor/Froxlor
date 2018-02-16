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

				// get disk-space usages for web, mysql and mail
				$usages_stmt = Database::prepare("SELECT * FROM `".TABLE_PANEL_DISKSPACE."` WHERE `customerid` = :cid ORDER BY `stamp` DESC LIMIT 1");
				$usages = Database::pexecute_first($usages_stmt, array('cid' => $row['customerid']));

				$row['webspace_used'] = round($usages['webspace'] / 1024, $dec_places);
				$row['mailspace_used'] = round($usages['mail'] / 1024, $dec_places);
				$row['dbspace_used'] = round($usages['mysql'] / 1024, $dec_places);

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
					$disk_percent = round(($row['diskspace_used']*100)/$row['diskspace'], 0);
					$disk_doublepercent = round($disk_percent*2, 2);
				} else {
					$disk_percent = 0;
					$disk_doublepercent = 0;
				}

				if ($row['traffic'] > 0) {
					$traffic_percent = round(($row['traffic_used']*100)/$row['traffic'], 0);
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

				// fix progress-bars if value is >100%
				if ($disk_percent > 100) {
					$disk_percent = 100;
				}
				if ($traffic_percent > 100) {
					$traffic_percent = 100;
				}

				$row['custom_notes'] = ($row['custom_notes'] != '') ? nl2br($row['custom_notes']) : '';

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
		try {
			$json_result = Customers::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

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
		try {
			$json_result = Customers::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($_POST['send'])
			&& $_POST['send'] == 'send'
		) {
			try {
				$json_result = Customers::getLocal($userinfo, array(
					'id' => $id
				))->unlock();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			redirectTo($filename, array('page' => $page, 's' => $s));
		} else {
			ask_yesno('customer_reallyunlock', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['loginname']);
		}

	} elseif ($action == 'delete'
		&& $id != 0
	) {
		try {
			$json_result = Customers::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($_POST['send'])
			&& $_POST['send'] == 'send'
		) {
			try {
				$json_result = Customers::getLocal($userinfo, array(
					'id' => $id,
					'delete_userfiles' => (isset($_POST['delete_userfiles']) ? (int)$_POST['delete_userfiles'] : 0)
				))->delete();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			redirectTo($filename, array('page' => $page, 's' => $s));

		} else {
			ask_yesno_withcheckbox('admin_customer_reallydelete', 'admin_customer_alsoremovefiles', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['loginname']);
		}

	} elseif($action == 'add') {

		if (isset($_POST['send'])
			&& $_POST['send'] == 'send'
		) {
			try {
				Customers::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			redirectTo($filename, array('page' => $page, 's' => $s));
		} else {
			$language_options = '';

			foreach ($languages as $language_file => $language_name) {
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

			$phpconfigs = array();
			$configs = Database::query("
				SELECT c.*, fc.description as interpreter
				FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
				LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
			");
			while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
				if ((int) Settings::Get('phpfpm.enabled') == 1) {
					$phpconfigs[] = array(
						'label' => $row['description'] . " [".$row['interpreter']."]<br />",
						'value' => $row['id']
					);
				} else {
					$phpconfigs[] = array(
						'label' => $row['description']."<br />",
						'value' => $row['id']
					);
				}
			}

			// hosting plans
			$hosting_plans = "";
			$plans = Database::query("
				SELECT *
				FROM `" . TABLE_PANEL_PLANS . "`
				ORDER BY name ASC
			");
			if (Database::num_rows() > 0){
				$hosting_plans .= makeoption("---", 0, 0, true, true);
			}
			while ($row = $plans->fetch(PDO::FETCH_ASSOC)) {
				$hosting_plans .= makeoption($row['name'], $row['id'], 0, true, true);
			}

			$customer_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/customer/formfield.customer_add.php';
			$customer_add_form = htmlform::genHTMLForm($customer_add_data);

			$title = $customer_add_data['customer_add']['title'];
			$image = $customer_add_data['customer_add']['image'];

			eval("echo \"" . getTemplate("customers/customers_add") . "\";");
		}

	} elseif($action == 'edit'
		&& $id != 0
	) {

		try {
			$json_result = Customers::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		/*
		 * information for moving customer
		 */
		$available_admins_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_ADMINS . "`
			WHERE (`customers` = '-1' OR `customers` > `customers_used`)"
		);
		Database::pexecute($available_admins_stmt);
		$admin_select = makeoption("-----", 0, true, true, true);
		$admin_select_cnt = 0;
		while ($available_admin = $available_admins_stmt->fetch()) {
			$admin_select .= makeoption($available_admin['name']." (".$available_admin['loginname'].")", $available_admin['adminid'], null, true, true);
			$admin_select_cnt++;
		}
		/*
		 * end of moving customer stuff
		 */

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

				$move_to_admin = isset($_POST['move_to_admin']) ? intval_ressource($_POST['move_to_admin']) : 0;

				$custom_notes = validate(str_replace("\r\n", "\n", $_POST['custom_notes']), 'custom_notes', '/^[^\0]*$/');
				$custom_notes_show = $result['custom_notes_show'];
				if (isset($_POST['custom_notes_show'])) {
				    $custom_notes_show = intval_ressource($_POST['custom_notes_show']);
				}

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

				$allowed_phpconfigs = array();
				if (isset($_POST['allowed_phpconfigs']) && is_array($_POST['allowed_phpconfigs'])) {
					foreach ($_POST['allowed_phpconfigs'] as $allowed_phpconfig) {
						$allowed_phpconfig = intval($allowed_phpconfig);
						$allowed_phpconfigs[] = $allowed_phpconfig;
					}
				}

				$perlenabled = 0;
				if (isset($_POST['perlenabled'])) {
					$perlenabled = intval($_POST['perlenabled']);
				}

				$dnsenabled = 0;
				if (isset($_POST['dnsenabled'])) {
					$dnsenabled = intval($_POST['dnsenabled']);
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
						$password = makeCryptPassword($password);
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
								'adddate' => time()
						);
						$ins_stmt = Database::prepare("
							INSERT INTO `" . TABLE_PANEL_DOMAINS . "` SET
							`domain` = :domain,
							`customerid` = :customerid,
							`adminid` = :adminid,
							`parentdomainid` = '0',
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
						$defaultips = explode(',', Settings::Get('system.defaultip'));
						$ins_stmt = Database::prepare("
							  INSERT INTO `" . TABLE_DOMAINTOIP . "` SET `id_domain` = :domainid, `id_ipandports` = :ipid"
						);
						foreach ($defaultips as $defaultip) {
							Database::pexecute($ins_stmt, array('domainid' => $domainid, 'ipid' => $defaultip));
						}

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

					if ($dnsenabled != '0') {
						$dnsenabled = '1';
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
						'allowed_phpconfigs' => empty($allowed_phpconfigs) ? "" : json_encode($allowed_phpconfigs),
						'imap' => $email_imap,
						'pop3' => $email_pop3,
						'perlenabled' => $perlenabled,
						'dnsenabled' => $dnsenabled,
						'custom_notes' => $custom_notes,
						'custom_notes_show' => $custom_notes_show
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
						`allowed_phpconfigs` = :allowed_phpconfigs,
						`email_quota` = :email_quota,
						`imap` = :imap,
						`pop3` = :pop3,
						`perlenabled` = :perlenabled,
						`dnsenabled` = :dnsenabled,
						`custom_notes` = :custom_notes,
						`custom_notes_show` = :custom_notes_show
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

					/*
					 * move customer to another admin/reseller; #1166
					 */
					if ($move_to_admin > 0 && $move_to_admin != $result['adminid']) {
						$move_result = moveCustomerToAdmin($id, $move_to_admin);
						if ($move_result != true) {
							standard_error('moveofcustomerfailed', $move_result);
						}
					}

					$redirect_props = Array(
						'page' => $page,
						's' => $s
					);

					redirectTo($filename, $redirect_props);
				}

			} else {
				$language_options = '';

				foreach ($languages as $language_file => $language_name) {
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

				$phpconfigs = array();
				$configs = Database::query("
					SELECT c.*, fc.description as interpreter
					FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
					LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
				");
				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					if ((int) Settings::Get('phpfpm.enabled') == 1) {
						$phpconfigs[] = array(
							'label' => $row['description'] . " [".$row['interpreter']."]<br />",
							'value' => $row['id']
						);
					} else {
						$phpconfigs[] = array(
							'label' => $row['description']."<br />",
							'value' => $row['id']
						);
					}
				}

				// hosting plans
				$hosting_plans = "";
				$plans = Database::query("
					SELECT *
					FROM `" . TABLE_PANEL_PLANS . "`
					ORDER BY name ASC
				");
				if (Database::num_rows() > 0){
					$hosting_plans .= makeoption("---", 0, 0, true, true);
				}
				while ($row = $plans->fetch(PDO::FETCH_ASSOC)) {
					$hosting_plans .= makeoption($row['name'], $row['id'], 0, true, true);
				}

				$customer_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/customer/formfield.customer_edit.php';
				$customer_edit_form = htmlform::genHTMLForm($customer_edit_data);

				$title = $customer_edit_data['customer_edit']['title'];
				$image = $customer_edit_data['customer_edit']['image'];

				eval("echo \"" . getTemplate("customers/customers_edit") . "\";");
			}
		}
	}
}
