<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\HostingPlans;
use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

$id = (int) Request::get('id');

if ($page == '' || $page == 'overview') {

	if ($action == '') {

		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_plans");

		try {
            $plan_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.plans.php';
            $collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\HostingPlans::class, $userinfo))
                ->withPagination($plan_list_data['plan_list']['columns']);
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::twigBuffer('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $plan_list_data['plan_list']),
			'actions_links' => [[
				'href' => $linker->getLink(['section' => 'plans', 'page' => $page, 'action' => 'add']),
				'label' => $lng['admin']['plans']['add']
			]]
		]);
		UI::twigOutputBuffer();
	} elseif ($action == 'delete' && $id != 0) {

		try {
			$json_result = HostingPlans::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['adminid'] == $result['adminid']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {

				try {
					HostingPlans::getLocal($userinfo, array(
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
				\Froxlor\UI\HTML::askYesNo('plan_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['name']);
			}
		} else {
			\Froxlor\UI\Response::standard_error('nopermissionsorinvalidid');
		}
	} elseif ($action == 'add') {

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				HostingPlans::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page,
				's' => $s
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

			// dummy to avoid unknown variables
			$hosting_plans = null;

			$plans_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/plans/formfield.plans_add.php';
			$cust_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/customer/formfield.customer_add.php';
			// unset unneeded stuff
			unset($cust_add_data['customer_add']['sections']['section_a']);
			unset($cust_add_data['customer_add']['sections']['section_b']);
			unset($cust_add_data['customer_add']['sections']['section_cpre']);
			// merge
			$plans_add_data['plans_add']['sections'] = array_merge($plans_add_data['plans_add']['sections'], $cust_add_data['customer_add']['sections']);

			UI::twigBuffer('user/form.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'plans')),
				'formdata' => $plans_add_data['plans_add']
			]);
			UI::twigOutputBuffer();
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = HostingPlans::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['name'] != '') {

			$result['value'] = json_decode($result['value'], true);
			$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

			foreach ($result['value'] as $index => $value) {
				$result[$index] = $value;
			}
			$result['allowed_phpconfigs'] = json_encode($result['allowed_phpconfigs']);

			if (isset($_POST['send']) && $_POST['send'] == 'send') {

				try {
					HostingPlans::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
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

				$result['imap'] = $result['email_imap'];
				$result['pop3'] = $result['email_pop3'];

				// dummy to avoid unknown variables
				$result['loginname'] = null;
				$result['documentroot'] = null;
				$result['standardsubdomain'] = null;
				$result['deactivated'] = null;
				$result['def_language'] = null;
				$result['firstname'] = null;
				$result['gender'] = null;
				$result['company'] = null;
				$result['street'] = null;
				$result['zipcode'] = null;
				$result['city'] = null;
				$result['phone'] = null;
				$result['fax'] = null;
				$result['email'] = null;
				$result['customernumber'] = null;
				$result['custom_notes'] = null;
				$result['custom_notes_show'] = null;
				$result['api_allowed'] = null;
				$hosting_plans = null;
				$admin_select = [];

				$plans_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/plans/formfield.plans_edit.php';
				$cust_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/customer/formfield.customer_edit.php';
				// unset unneeded stuff
				unset($cust_edit_data['customer_edit']['sections']['section_a']);
				unset($cust_edit_data['customer_edit']['sections']['section_b']);
				unset($cust_edit_data['customer_edit']['sections']['section_cpre']);
				unset($cust_edit_data['customer_edit']['sections']['section_d']);
				// merge
				$plans_edit_data['plans_edit']['sections'] = array_merge($plans_edit_data['plans_edit']['sections'], $cust_edit_data['customer_edit']['sections']);

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'plans', 'id' => $id)),
					'formdata' => $plans_edit_data['plans_edit'],
					'editid' => $id
				]);
				UI::twigOutputBuffer();
			}
		}
	} elseif ($action == 'jqGetPlanValues') {
		$planid = isset($_POST['planid']) ? (int) $_POST['planid'] : 0;
		try {
			$json_result = HostingPlans::getLocal($userinfo, array(
				'id' => $planid
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		echo $result['value'];
		exit();
	}
}
