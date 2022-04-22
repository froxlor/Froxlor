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

use Froxlor\Api\Commands\Customers as Customers;
use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

$id = (int) Request::get('id');

if ($page == 'customers' && $userinfo['customers'] != '0') {
	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_customers");

		try {
			$customer_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.customers.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\Customers::class, $userinfo, ['show_usages' => true]))
				->withPagination($customer_list_data['customer_list']['columns']);
			if ($userinfo['change_serversettings']) {
				$collection->has('admin', \Froxlor\Api\Commands\Admins::class, 'adminid', 'adminid');
			}
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		$actions_links = false;
		if ($userinfo['customers_used'] < $userinfo['customers'] || $userinfo['customers'] == '-1') {
			$actions_links = [[
				'href' => $linker->getLink(['section' => 'customers', 'page' => $page, 'action' => 'add']),
				'label' => $lng['admin']['customer_add']
			]];
		}

		UI::view('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $customer_list_data, 'customer_list') ,
			'actions_links' => $actions_links
		]);
	} elseif ($action == 'su' && $id != 0) {
		try {
			$json_result = Customers::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		$destination_user = $result['loginname'];

		if ($destination_user != '') {

			if ($result['deactivated'] == '1') {
				\Froxlor\UI\Response::standard_error("usercurrentlydeactivated", $destination_user);
			}

			$result['switched_user'] = \Froxlor\CurrentUser::getData();
			$result['adminsession'] = 0;
			$result['userid'] = $result['customerid'];
			\Froxlor\CurrentUser::setData($result);

			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "switched user and is now '" . $destination_user . "'");

			$target = (isset($_GET['target']) ? $_GET['target'] : 'index');
			$redirect = "customer_" . $target . ".php";
			if (!file_exists(\Froxlor\Froxlor::getInstallDir() . "/" . $redirect)) {
				$redirect = "customer_index.php";
			}
			\Froxlor\UI\Response::redirectTo($redirect, null, true);
		} else {
			\Froxlor\UI\Response::redirectTo('index.php', array(
				'action' => 'login'
			));
		}
	} elseif ($action == 'unlock' && $id != 0) {
		try {
			$json_result = Customers::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				$json_result = Customers::getLocal($userinfo, array(
					'id' => $id
				))->unlock();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		} else {
			\Froxlor\UI\HTML::askYesNo('customer_reallyunlock', $filename, array(
				'id' => $id,
				'page' => $page,
				'action' => $action
			), $result['loginname']);
		}
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = Customers::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				$json_result = Customers::getLocal($userinfo, array(
					'id' => $id,
					'delete_userfiles' => (isset($_POST['delete_userfiles']) ? (int) $_POST['delete_userfiles'] : 0)
				))->delete();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		} else {
			\Froxlor\UI\HTML::askYesNoWithCheckbox('admin_customer_reallydelete', 'admin_customer_alsoremovefiles', $filename, array(
				'id' => $id,
				'page' => $page,
				'action' => $action
			), $result['loginname']);
		}
	} elseif ($action == 'add') {

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				Customers::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		} else {

			$phpconfigs = [];
			$configs = Database::query("
				SELECT c.*, fc.description as interpreter
				FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
				LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
			");
			while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
				if ((int) Settings::Get('phpfpm.enabled') == 1) {
					$phpconfigs[] = array(
						'label' => $row['description'] . " [" . $row['interpreter'] . "]",
						'value' => $row['id']
					);
				} else {
					$phpconfigs[] = array(
						'label' => $row['description'],
						'value' => $row['id']
					);
				}
			}

			// hosting plans
			$hosting_plans = [];
			$plans = Database::query("
				SELECT *
				FROM `" . TABLE_PANEL_PLANS . "`
				ORDER BY name ASC
			");
			$hosting_plans = [
				0 => "---"
			];
			while ($row = $plans->fetch(PDO::FETCH_ASSOC)) {
				$hosting_plans[$row['id']] = $row['name'];
			}

			$customer_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/customer/formfield.customer_add.php';

			UI::view('user/form.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'customers')),
				'formdata' => $customer_add_data['customer_add']
			]);
		}
	} elseif ($action == 'edit' && $id != 0) {

		try {
			$json_result = Customers::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['loginname'] != '') {

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					Customers::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page
				));
			} else {

				$dec_places = Settings::Get('panel.decimal_places');
				$result['traffic'] = round($result['traffic'] / (1024 * 1024), $dec_places);
				$result['diskspace'] = round($result['diskspace'] / 1024, $dec_places);
				$result['email'] = $idna_convert->decode($result['email']);

				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$phpconfigs = [];
				$configs = Database::query("
					SELECT c.*, fc.description as interpreter
					FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
					LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
				");
				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					if ((int) Settings::Get('phpfpm.enabled') == 1) {
						$phpconfigs[] = array(
							'label' => $row['description'] . " [" . $row['interpreter'] . "]",
							'value' => $row['id']
						);
					} else {
						$phpconfigs[] = array(
							'label' => $row['description'],
							'value' => $row['id']
						);
					}
				}

				// hosting plans
				$plans = Database::query("
					SELECT *
					FROM `" . TABLE_PANEL_PLANS . "`
					ORDER BY name ASC
				");
				$hosting_plans = [
					0 => "---"
				];
				while ($row = $plans->fetch(PDO::FETCH_ASSOC)) {
					$hosting_plans[$row['id']] = $row['name'];
				}

				$available_admins_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_ADMINS . "`
					WHERE (`customers` = '-1' OR `customers` > `customers_used`)
					AND adminid <> :currentadmin
				");
				Database::pexecute($available_admins_stmt, ['currentadmin' => $result['adminid']]);
				$admin_select = [
					0 => "---"
				];
				while ($available_admin = $available_admins_stmt->fetch()) {
					$admin_select[$available_admin['adminid']] = $available_admin['name'] . " (" . $available_admin['loginname'] . ")";
				}

				$customer_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/customer/formfield.customer_edit.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'customers', 'id' => $id)),
					'formdata' => $customer_edit_data['customer_edit'],
					'editid' => $id
				]);
			}
		}
	}
}
