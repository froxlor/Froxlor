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

if ($page == 'admins'
	&& $userinfo['change_serversettings'] == '1'
) {

	if ($action == '') {

		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_admins");
		$fields = array(
			'loginname' => $lng['login']['username'],
			'name' => $lng['customer']['name'],
			'diskspace' => $lng['customer']['diskspace'],
			'diskspace_used' => $lng['customer']['diskspace'] . ' (' . $lng['panel']['used'] . ')',
			'traffic' => $lng['customer']['traffic'],
			'traffic_used' => $lng['customer']['traffic'] . ' (' . $lng['panel']['used'] . ')',
			'deactivated' => $lng['admin']['deactivated']
		);
		$paging = new paging($userinfo, TABLE_PANEL_ADMINS, $fields);
		$admins = '';
		$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_ADMINS . "` " . $paging->getSqlWhere(false) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		$numrows_admins = Database::num_rows();
		$paging->setEntries($numrows_admins);
		$sortcode = $paging->getHtmlSortCode($lng, true);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;

		$dec_places = Settings::Get('panel.decimal_places');

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			if ($paging->checkDisplay($i)) {

				$row['traffic_used'] = round($row['traffic_used'] / (1024 * 1024), $dec_places);
				$row['traffic'] = round($row['traffic'] / (1024 * 1024), $dec_places);
				$row['diskspace_used'] = round($row['diskspace_used'] / 1024, $dec_places);
				$row['diskspace'] = round($row['diskspace'] / 1024, $dec_places);

				// percent-values for progressbar
				// For Disk usage
				if ($row['diskspace'] > 0) {
					$disk_percent = round(($row['diskspace_used']*100)/$row['diskspace'], 0);
					$disk_doublepercent = round($disk_percent*2, 2);
				} else {
					$disk_percent = 0;
					$disk_doublepercent = 0;
				}
				// For Traffic usage
				if ($row['traffic'] > 0) {
					$traffic_percent = round(($row['traffic_used']*100)/$row['traffic'], 0);
					$traffic_doublepercent = round($traffic_percent*2, 2);
				} else {
					$traffic_percent = 0;
					$traffic_doublepercent = 0;
				}

				// fix progress-bars if value is >100%
				if ($disk_percent > 100) {
					$disk_percent = 100;
				}
				if ($traffic_percent > 100) {
					$traffic_percent = 100;
				}

				$row = str_replace_array('-1', 'UL', $row, 'customers domains diskspace traffic mysqls emails email_accounts email_forwarders email_quota ftps subdomains tickets');
				$row = htmlentities_array($row);

				$row['custom_notes'] = ($row['custom_notes'] != '') ? nl2br($row['custom_notes']) : '';

				eval("\$admins.=\"" . getTemplate("admins/admins_admin") . "\";");
				$count++;
			}
			$i++;
		}

		$admincount = $numrows_admins;
		eval("echo \"" . getTemplate("admins/admins") . "\";");

	} elseif($action == 'su') {

		try {
			$json_result = Admins::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		$destination_admin = $result['loginname'];

		if ($destination_admin != ''
			&& $result['adminid'] != $userinfo['userid']
		) {
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid` = :userid
			");
			$result = Database::pexecute_first($result_stmt, array('userid' => $userinfo['userid']));

			$s = md5(uniqid(microtime(), 1));
			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_SESSIONS . "` SET
				`hash` = :hash, `userid` = :userid, `ipaddress` = :ip,
				`useragent` = :ua, `lastactivity` = :la,
				`language` = :lang, `adminsession` = '1'
			");
			$ins_data = array(
				'hash' => $s,
				'userid' => $id,
				'ip' => $result['ipaddress'],
				'ua' => $result['useragent'],
				'la' => time(),
				'lang' => $result['language']
			);
			Database::pexecute($ins_stmt, $ins_data);
			$log->logAction(ADM_ACTION, LOG_INFO, "switched adminuser and is now '" . $destination_admin . "'");
			redirectTo('admin_index.php', array('s' => $s));

		} else {
			redirectTo('index.php', array('action' => 'login'));
		}

	} elseif ($action == 'delete'
		&& $id != 0
	) {
		try {
			$json_result = Admins::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['loginname'] != '') {
			if ($result['adminid'] == $userinfo['userid']) {
				standard_error('youcantdeleteyourself');
			}

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				Admins::getLocal($this->getUserData(), array(
					'id' => $id
				))->delete();
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				ask_yesno('admin_admin_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['loginname']);
			}
		}

	} elseif($action == 'add') {

		if (isset($_POST['send'])
			&& $_POST['send'] == 'send'
		) {
			try {
				Admins::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			redirectTo($filename, array('page' => $page, 's' => $s));
		} else {

			$language_options = '';
			foreach ($languages as $language_file => $language_name) {
				$language_options.= makeoption($language_name, $language_file, $userinfo['language'], true);
			}

			$ipaddress = makeoption($lng['admin']['allips'], "-1");
			$ipsandports_stmt = Database::query("
				SELECT `id`, `ip` FROM `" . TABLE_PANEL_IPSANDPORTS . "` GROUP BY `ip` ORDER BY `ip` ASC
			");

			while ($row = $ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
				$ipaddress.= makeoption($row['ip'], $row['id']);
			}

			$customers_ul = makecheckbox('customers_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$diskspace_ul = makecheckbox('diskspace_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$traffic_ul = makecheckbox('traffic_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$domains_ul = makecheckbox('domains_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$subdomains_ul = makecheckbox('subdomains_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$emails_ul = makecheckbox('emails_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_accounts_ul = makecheckbox('email_accounts_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_forwarders_ul = makecheckbox('email_forwarders_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_quota_ul = makecheckbox('email_quota_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$ftps_ul = makecheckbox('ftps_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$tickets_ul = makecheckbox('tickets_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$mysqls_ul = makecheckbox('mysqls_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);

			$admin_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/admin/formfield.admin_add.php';
			$admin_add_form = htmlform::genHTMLForm($admin_add_data);

			$title = $admin_add_data['admin_add']['title'];
			$image = $admin_add_data['admin_add']['image'];

			eval("echo \"" . getTemplate("admins/admins_add") . "\";");
		}

	} elseif($action == 'edit'
		&& $id != 0
	) {
		try {
			$json_result = Admins::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['loginname'] != '') {

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				try {
					Admins::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {

				$dec_places = Settings::Get('panel.decimal_places');
				$result['traffic'] = round($result['traffic'] / (1024 * 1024), $dec_places);
				$result['diskspace'] = round($result['diskspace'] / 1024, $dec_places);
				$result['email'] = $idna_convert->decode($result['email']);

				$customers_ul = makecheckbox('customers_ul', $lng['customer']['unlimited'], '-1', false, $result['customers'], true, true);
				if ($result['customers'] == '-1') {
					$result['customers'] = '';
				}

				$diskspace_ul = makecheckbox('diskspace_ul', $lng['customer']['unlimited'], '-1', false, $result['diskspace'], true, true);
				if ($result['diskspace'] == '-1') {
					$result['diskspace'] = '';
				}

				$traffic_ul = makecheckbox('traffic_ul', $lng['customer']['unlimited'], '-1', false, $result['traffic'], true, true);
				if ($result['traffic'] == '-1') {
					$result['traffic'] = '';
				}

				$domains_ul = makecheckbox('domains_ul', $lng['customer']['unlimited'], '-1', false, $result['domains'], true, true);
				if ($result['domains'] == '-1') {
					$result['domains'] = '';
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

				$language_options = '';
				foreach ($languages as $language_file => $language_name) {
					$language_options.= makeoption($language_name, $language_file, $result['def_language'], true);
				}

				$ipaddress = makeoption($lng['admin']['allips'], "-1", $result['ip']);
				$ipsandports_stmt = Database::query("
					SELECT `id`, `ip` FROM `" . TABLE_PANEL_IPSANDPORTS . "` GROUP BY `id`, `ip` ORDER BY `ip`, `port` ASC
				");

				while ($row = $ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
					$ipaddress.= makeoption($row['ip'], $row['id'], $result['ip']);
				}

				$result = htmlentities_array($result);

				$admin_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/admin/formfield.admin_edit.php';
				$admin_edit_form = htmlform::genHTMLForm($admin_edit_data);

				$title = $admin_edit_data['admin_edit']['title'];
				$image = $admin_edit_data['admin_edit']['image'];

				eval("echo \"" . getTemplate("admins/admins_edit") . "\";");
			}
		}
	}
}
