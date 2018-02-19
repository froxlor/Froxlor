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
				try {
					Customers::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
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
