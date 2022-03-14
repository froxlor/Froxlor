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
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\IpsAndPorts;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

$id = (int) Request::get('id');

if ($page == 'ipsandports' || $page == 'overview') {
	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_ipsandports");

		try {
			$ipsandports_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.ipsandports.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\IpsAndPorts::class, $userinfo))
				->withPagination($ipsandports_list_data['ipsandports_list']['columns']);
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::twigBuffer('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $ipsandports_list_data['ipsandports_list']),
			'actions_links' => [[
				'href' => $linker->getLink(['section' => 'ipsandports', 'page' => $page, 'action' => 'add']),
				'label' => $lng['admin']['ipsandports']['add']
			]]
		]);
		UI::twigOutputBuffer();
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
					'page' => $page
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
				'page' => $page
			));
		} else {

			$ipsandports_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/ipsandports/formfield.ipsandports_add.php';

			UI::twigBuffer('user/form.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'ipsandports')),
				'formdata' => $ipsandports_add_data['ipsandports_add']
			]);
			UI::twigOutputBuffer();
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
					'page' => $page
				));
			} else {

				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$ipsandports_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/ipsandports/formfield.ipsandports_edit.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'ipsandports', 'id' => $id)),
					'formdata' => $ipsandports_edit_data['ipsandports_edit'],
					'editid' => $id
				]);
				UI::twigOutputBuffer();
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
