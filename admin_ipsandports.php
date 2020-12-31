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

use Froxlor\Settings;
use Froxlor\Api\Commands\IpsAndPorts;

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'ipsandports' || $page == 'overview') {
	// Do not display attributes that are not used by the current webserver
	$websrv = Settings::Get('system.webserver');
	$is_nginx = ($websrv == 'nginx');
	$is_apache = ($websrv == 'apache2');
	$is_apache24 = $is_apache && (Settings::Get('system.apache24') === '1');

	if ($action == '') {

		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_ipsandports");
		$fields = array(
			'ip' => $lng['admin']['ipsandports']['ip'],
			'port' => $lng['admin']['ipsandports']['port']
		);
		try {
			// get total count
			$json_result = IpsAndPorts::getLocal($userinfo)->listingCount();
			$result = json_decode($json_result, true)['data'];
			// initialize pagination and filtering
			$paging = new \Froxlor\UI\Pagination($userinfo, $fields, $result);
			// get list
			$json_result = IpsAndPorts::getLocal($userinfo, $paging->getApiCommandParams())->listing();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		$ipsandports = '';
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$count = 0;

		foreach ($result['list'] as $row) {
			$row = \Froxlor\PhpHelper::htmlentitiesArray($row);
			if (filter_var($row['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$row['ip'] = '[' . $row['ip'] . ']';
			}
			eval("\$ipsandports.=\"" . \Froxlor\UI\Template::getTemplate("ipsandports/ipsandports_ipandport") . "\";");
			$count ++;
		}
		eval("echo \"" . \Froxlor\UI\Template::getTemplate("ipsandports/ipsandports") . "\";");
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = IpsAndPorts::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['id']) && $result['id'] == $id) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {

				try {
					IpsAndPorts::getLocal($userinfo, array(
						'id' => $id
					))->delete();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}

				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				\Froxlor\UI\HTML::askYesNo('admin_ip_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['ip'] . ':' . $result['port']);
			}
		}
	} elseif ($action == 'add') {
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				IpsAndPorts::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page,
				's' => $s
			));
		} else {

			$ipsandports_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/ipsandports/formfield.ipsandports_add.php';
			$ipsandports_add_form = \Froxlor\UI\HtmlForm::genHTMLForm($ipsandports_add_data);

			$title = $ipsandports_add_data['ipsandports_add']['title'];
			$image = $ipsandports_add_data['ipsandports_add']['image'];

			eval("echo \"" . \Froxlor\UI\Template::getTemplate("ipsandports/ipsandports_add") . "\";");
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = IpsAndPorts::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['ip'] != '') {

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					IpsAndPorts::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$ipsandports_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/ipsandports/formfield.ipsandports_edit.php';
				$ipsandports_edit_form = \Froxlor\UI\HtmlForm::genHTMLForm($ipsandports_edit_data);

				$title = $ipsandports_edit_data['ipsandports_edit']['title'];
				$image = $ipsandports_edit_data['ipsandports_edit']['image'];

				eval("echo \"" . \Froxlor\UI\Template::getTemplate("ipsandports/ipsandports_edit") . "\";");
			}
		}
	} elseif ($action == 'jqCheckIP') {
		$ip = $_POST['ip'] ?? "";
		if ((filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE) == false) {
			// returns notice if private network detected so we can display it
			echo json_encode($lng['admin']['ipsandports']['ipnote']);
		} else {
			echo 0;
		}
		exit();
	}
}
