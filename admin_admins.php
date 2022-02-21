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
require __DIR__ .  '/lib/init.php';

use Froxlor\Api\Commands\Admins as Admins;
use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

$id = (int) Request::get('id');

if ($page == 'admins' && $userinfo['change_serversettings'] == '1') {

	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_admins");
        $admin_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/admin/tablelisting.admin.php';

        /*
        $fields = array(
			'loginname' => $lng['login']['username'],
			'name' => $lng['customer']['name'],
			'diskspace' => $lng['customer']['diskspace'],
			'diskspace_used' => $lng['customer']['diskspace'] . ' (' . $lng['panel']['used'] . ')',
			'traffic' => $lng['customer']['traffic'],
			'traffic_used' => $lng['customer']['traffic'] . ' (' . $lng['panel']['used'] . ')',
			'deactivated' => $lng['admin']['deactivated']
		);
        */
        try {
			// get total count
			$json_result = Admins::getLocal($userinfo)->listingCount();
			$result = json_decode($json_result, true)['data'];
			// initialize pagination and filtering
			$paging = new \Froxlor\UI\Pagination($userinfo, $admin_list_data['admin_list']['columns'], $result);
			// get list
			$json_result = Admins::getLocal($userinfo, $paging->getApiCommandParams())->listing();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
        /*
        $result = json_decode($json_result, true)['data'];

		$admins = '';
		$sortcode = $paging->getHtmlSortCode($lng, true);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$count = 0;

		$dec_places = Settings::Get('panel.decimal_places');

		foreach ($result['list'] as $row) {

			$row['traffic_used'] = round($row['traffic_used'] / (1024 * 1024), $dec_places);
			$row['traffic'] = round($row['traffic'] / (1024 * 1024), $dec_places);
			$row['diskspace_used'] = round($row['diskspace_used'] / 1024, $dec_places);
			$row['diskspace'] = round($row['diskspace'] / 1024, $dec_places);

			// percent-values for progressbar
			// For Disk usage
			if ($row['diskspace'] > 0) {
				$disk_percent = round(($row['diskspace_used'] * 100) / $row['diskspace'], 0);
				$disk_doublepercent = round($disk_percent * 2, 2);
			} else {
				$disk_percent = 0;
				$disk_doublepercent = 0;
			}
			// For Traffic usage
			if ($row['traffic'] > 0) {
				$traffic_percent = round(($row['traffic_used'] * 100) / $row['traffic'], 0);
				$traffic_doublepercent = round($traffic_percent * 2, 2);
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

			$row = \Froxlor\PhpHelper::strReplaceArray('-1', 'UL', $row, 'customers domains diskspace traffic mysqls emails email_accounts email_forwarders email_quota ftps subdomains');
			$row = \Froxlor\PhpHelper::htmlentitiesArray($row);

			$row['custom_notes'] = ($row['custom_notes'] != '') ? nl2br($row['custom_notes']) : '';

			eval("\$admins.=\"" . \Froxlor\UI\Template::getTemplate("admins/admins_admin") . "\";");
			$count ++;
		}

		$admincount = $result['count'] . " / " . $paging->getEntries();
		eval("echo \"" . \Froxlor\UI\Template::getTemplate("admins/admins") . "\";");
        */

        UI::twigBuffer('user/table.html.twig', [
            'api_response' => json_decode($json_result, true)['data'],
            'table_options' => $admin_list_data['admin_list'],
        ]);
        UI::twigOutputBuffer();
    } elseif ($action == 'su') {

		try {
			$json_result = Admins::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		$destination_admin = $result['loginname'];

		if ($destination_admin != '' && $result['adminid'] != $userinfo['userid']) {
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid` = :userid
			");
			$result = Database::pexecute_first($result_stmt, array(
				'userid' => $userinfo['userid']
			));

			$s = \Froxlor\Froxlor::genSessionId();
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
			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "switched adminuser and is now '" . $destination_admin . "'");
			\Froxlor\UI\Response::redirectTo('admin_index.php', array(
				's' => $s
			));
		} else {
			\Froxlor\UI\Response::redirectTo('index.php', array(
				'action' => 'login'
			));
		}
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = Admins::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['loginname'] != '') {
			if ($result['adminid'] == $userinfo['userid']) {
				\Froxlor\UI\Response::standard_error('youcantdeleteyourself');
			}

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				Admins::getLocal($userinfo, array(
					'id' => $id
				))->delete();
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				\Froxlor\UI\HTML::askYesNo('admin_admin_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['loginname']);
			}
		}
	} elseif ($action == 'add') {

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				Admins::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page,
				's' => $s
			));
		} else {

			$ipaddress = [];
			$ipaddress[-1] = $lng['admin']['allips'];
			$ipsandports_stmt = Database::query("
				SELECT `id`, `ip` FROM `" . TABLE_PANEL_IPSANDPORTS . "` GROUP BY `ip` ORDER BY `ip` ASC
			");
			while ($row = $ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
				$ipaddress[$row['id']] = $row['ip'];
			}

			$admin_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/admin/formfield.admin_add.php';

			UI::twigBuffer('user/form.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'admins')),
				'formdata' => $admin_add_data['admin_add']
			]);
			UI::twigOutputBuffer();
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = Admins::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['loginname'] != '') {

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Admins::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				$dec_places = Settings::Get('panel.decimal_places');
				$result['traffic'] = round($result['traffic'] / (1024 * 1024), $dec_places);
				$result['diskspace'] = round($result['diskspace'] / 1024, $dec_places);
				$result['email'] = $idna_convert->decode($result['email']);

				$ipaddress = [];
				$ipaddress[-1] = $lng['admin']['allips'];
				$ipsandports_stmt = Database::query("
					SELECT `id`, `ip` FROM `" . TABLE_PANEL_IPSANDPORTS . "` GROUP BY `ip` ORDER BY `ip` ASC
				");
				while ($row = $ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
					$ipaddress[$row['id']] = $row['ip'];
				}

				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$admin_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/admin/formfield.admin_edit.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'admins', 'id' => $id)),
					'formdata' => $admin_edit_data['admin_edit']
				]);
				UI::twigOutputBuffer();
			}
		}
	}
}
