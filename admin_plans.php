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
define('AREA', 'admin');
require './lib/init.php';

use Froxlor\Database\Database;
use Froxlor\Settings;

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == '' || $page == 'overview') {

	if ($action == '') {

		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_plans");
		$fields = array(
			'p.name' => $lng['admin']['plans']['name'],
			'p.description' => $lng['admin']['plans']['description'],
			'adminname' => $lng['admin']['admin'],
			'p.ts' => $lng['admin']['plans']['last_update']
		);
		$paging = new \Froxlor\UI\Paging($userinfo, TABLE_PANEL_PLANS, $fields);
		$plans = '';
		$result_stmt = Database::prepare("
			SELECT p.*, a.loginname as adminname
			FROM `" . TABLE_PANEL_PLANS . "` p, `" . TABLE_PANEL_ADMINS . "` a
			WHERE " . ($userinfo['customers_see_all'] ? '' : " `p`.`adminid` = :adminid AND ") . "
			`p`.`adminid` = `a`.`adminid` " . $paging->getSqlWhere(false) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		Database::pexecute($result_stmt, array(
			'adminid' => $userinfo['adminid']
		));
		$paging->setEntries(Database::num_rows());
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			if ($paging->checkDisplay($i)) {
				$row = \Froxlor\PhpHelper::htmlentitiesArray($row);
				$row['ts_format'] = date("d.m.Y H:i", $row['ts']);
				eval("\$plans.=\"" . \Froxlor\UI\Template::getTemplate("plans/plans_plan") . "\";");
				$count ++;
			}
			$i ++;
		}

		eval("echo \"" . \Froxlor\UI\Template::getTemplate("plans/plans") . "\";");
	} elseif ($action == 'delete' && $id != 0) {

		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_PLANS . "` WHERE `id` = :id");
		$result = Database::pexecute_first($result_stmt, array(
			'id' => $id
		));

		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['adminid'] == $result['adminid']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {

				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_PLANS . "` WHERE `id` = :id");
				Database::pexecute($del_stmt, array(
					'id' => $id
				));

				$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "Plan '" . $result['name'] . "' has been deleted by '" . $userinfo['loginname'] . "'");
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
			$name = \Froxlor\Validate\Validate::validate($_POST['name'], 'name');
			$description = \Froxlor\Validate\Validate::validate(str_replace("\r\n", "\n", $_POST['description']), 'description', '/^[^\0]*$/');

			$value_arr = array();

			if (empty($name)) {
				\Froxlor\UI\Response::standard_error('stringmustntbeempty', 'name');
			}

			$value_arr['diskspace'] = (int)($_POST['diskspace']);
			if (isset($_POST['diskspace_ul'])) {
				$value_arr['diskspace'] = - 1;
			}

			$value_arr['traffic'] = $_POST['traffic'];
			if (isset($_POST['traffic_ul'])) {
				$value_arr['traffic'] = - 1;
			}

			$value_arr['subdomains'] = (int)($_POST['subdomains']);
			if (isset($_POST['subdomains_ul'])) {
				$value_arr['subdomains'] = - 1;
			}

			$value_arr['emails'] = (int)($_POST['emails']);
			if (isset($_POST['emails_ul'])) {
				$value_arr['emails'] = - 1;
			}

			$value_arr['email_accounts'] = (int)($_POST['email_accounts']);
			if (isset($_POST['email_accounts_ul'])) {
				$value_arr['email_accounts'] = - 1;
			}

			$value_arr['email_forwarders'] = (int)($_POST['email_forwarders']);
			if (isset($_POST['email_forwarders_ul'])) {
				$value_arr['email_forwarders'] = - 1;
			}

			if (Settings::Get('system.mail_quota_enabled') == '1') {
				$value_arr['email_quota'] = \Froxlor\Validate\Validate::validate($_POST['email_quota'], 'email_quota', '/^\d+$/', 'vmailquotawrong', array(
					'0',
					''
				));
				if (isset($_POST['email_quota_ul'])) {
					$value_arr['email_quota'] = - 1;
				}
			} else {
				$value_arr['email_quota'] = - 1;
			}

			$value_arr['email_imap'] = 0;
			if (isset($_POST['email_imap'])) {
				$value_arr['email_imap'] = (int)($_POST['email_imap']);
			}

			$value_arr['email_pop3'] = 0;
			if (isset($_POST['email_pop3'])) {
				$value_arr['email_pop3'] = (int)($_POST['email_pop3']);
			}

			$value_arr['ftps'] = (int)($_POST['ftps']);
			if (isset($_POST['ftps_ul'])) {
				$value_arr['ftps'] = - 1;
			}

			$value_arr['mysqls'] = (int)($_POST['mysqls']);
			if (isset($_POST['mysqls_ul'])) {
				$value_arr['mysqls'] = - 1;
			}

			$value_arr['phpenabled'] = 0;
			if (isset($_POST['phpenabled'])) {
				$value_arr['phpenabled'] = intval($_POST['phpenabled']);
			}

			$value_arr['allowed_phpconfigs'] = array();
			if (isset($_POST['allowed_phpconfigs']) && is_array($_POST['allowed_phpconfigs'])) {
				foreach ($_POST['allowed_phpconfigs'] as $allowed_phpconfig) {
					$allowed_phpconfig = intval($allowed_phpconfig);
					$value_arr['allowed_phpconfigs'][] = $allowed_phpconfig;
				}
			}

			$value_arr['perlenabled'] = 0;
			if (isset($_POST['perlenabled'])) {
				$value_arr['perlenabled'] = intval($_POST['perlenabled']);
			}

			$value_arr['dnsenabled'] = 0;
			if (isset($_POST['dnsenabled'])) {
				$value_arr['dnsenabled'] = intval($_POST['dnsenabled']);
			}

			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_PLANS . "`
				SET `adminid` = :adminid, `name` = :name, `description` = :desc, `value` = :valuearr, `ts` = UNIX_TIMESTAMP();
			");
			$ins_data = array(
				'adminid' => $userinfo['adminid'],
				'name' => $name,
				'desc' => $description,
				'valuearr' => json_encode($value_arr)
			);
			Database::pexecute($ins_stmt, $ins_data);

			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, "added plan '" . $name . "'");
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page,
				's' => $s
			));
		} else {

			$diskspace_ul = \Froxlor\UI\HTML::makecheckbox('diskspace_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$traffic_ul = \Froxlor\UI\HTML::makecheckbox('traffic_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$subdomains_ul = \Froxlor\UI\HTML::makecheckbox('subdomains_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$emails_ul = \Froxlor\UI\HTML::makecheckbox('emails_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_accounts_ul = \Froxlor\UI\HTML::makecheckbox('email_accounts_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_forwarders_ul = \Froxlor\UI\HTML::makecheckbox('email_forwarders_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_quota_ul = \Froxlor\UI\HTML::makecheckbox('email_quota_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$ftps_ul = \Froxlor\UI\HTML::makecheckbox('ftps_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$mysqls_ul = \Froxlor\UI\HTML::makecheckbox('mysqls_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);

			$phpconfigs = array();
			$configs = Database::query("
					SELECT c.*, fc.description as interpreter
					FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
					LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
				");
			while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
				if ((int) Settings::Get('phpfpm.enabled') == 1) {
					$phpconfigs[] = array(
						'label' => $row['description'] . " [" . $row['interpreter'] . "]<br />",
						'value' => $row['id']
					);
				} else {
					$phpconfigs[] = array(
						'label' => $row['description'] . "<br />",
						'value' => $row['id']
					);
				}
			}

			// dummy to avoid unknown variables
			$language_options = null;
			$gender_options = null;
			$hosting_plans = null;

			$plans_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/plans/formfield.plans_add.php';
			$cust_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/customer/formfield.customer_add.php';
			// unset unneeded stuff
			unset($cust_add_data['customer_add']['sections']['section_a']);
			unset($cust_add_data['customer_add']['sections']['section_b']);
			unset($cust_add_data['customer_add']['sections']['section_cpre']);
			// merge
			$plans_add_data['plans_add']['sections'] = array_merge($plans_add_data['plans_add']['sections'], $cust_add_data['customer_add']['sections']);
			$plans_add_form = \Froxlor\UI\HtmlForm::genHTMLForm($plans_add_data);

			$title = $plans_add_data['plans_add']['title'];
			$image = $plans_add_data['plans_add']['image'];

			eval("echo \"" . \Froxlor\UI\Template::getTemplate("plans/plans_add") . "\";");
		}
	} elseif ($action == 'edit' && $id != 0) {
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_PLANS . "` WHERE `id` = :id");
		$result = Database::pexecute_first($result_stmt, array(
			'id' => $id
		));

		if ($result['name'] != '') {

			$result['value'] = json_decode($result['value'], true);
			$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

			foreach ($result['value'] as $index => $value) {
				$result[$index] = $value;
			}
			$result['allowed_phpconfigs'] = json_encode($result['allowed_phpconfigs']);

			if (isset($_POST['send']) && $_POST['send'] == 'send') {

				$name = \Froxlor\Validate\Validate::validate($_POST['name'], 'name');
				$description = \Froxlor\Validate\Validate::validate(str_replace("\r\n", "\n", $_POST['description']), 'description', '/^[^\0]*$/');

				$value_arr = array();

				$value_arr['diskspace'] = (int)($_POST['diskspace']);
				if (isset($_POST['diskspace_ul'])) {
					$value_arr['diskspace'] = - 1;
				}

				$value_arr['traffic'] = $_POST['traffic'];
				if (isset($_POST['traffic_ul'])) {
					$value_arr['traffic'] = - 1;
				}

				$value_arr['subdomains'] = (int)($_POST['subdomains']);
				if (isset($_POST['subdomains_ul'])) {
					$value_arr['subdomains'] = - 1;
				}

				$value_arr['emails'] = (int)($_POST['emails']);
				if (isset($_POST['emails_ul'])) {
					$value_arr['emails'] = - 1;
				}

				$value_arr['email_accounts'] = (int)($_POST['email_accounts']);
				if (isset($_POST['email_accounts_ul'])) {
					$value_arr['email_accounts'] = - 1;
				}

				$value_arr['email_forwarders'] = (int)($_POST['email_forwarders']);
				if (isset($_POST['email_forwarders_ul'])) {
					$value_arr['email_forwarders'] = - 1;
				}

				if (Settings::Get('system.mail_quota_enabled') == '1') {
					$value_arr['email_quota'] = \Froxlor\Validate\Validate::validate($_POST['email_quota'], 'email_quota', '/^\d+$/', 'vmailquotawrong', array(
						'0',
						''
					));
					if (isset($_POST['email_quota_ul'])) {
						$value_arr['email_quota'] = - 1;
					}
				} else {
					$value_arr['email_quota'] = - 1;
				}

				$value_arr['email_imap'] = 0;
				if (isset($_POST['email_imap'])) {
					$value_arr['email_imap'] = (int)($_POST['email_imap']);
				}

				$value_arr['email_pop3'] = 0;
				if (isset($_POST['email_pop3'])) {
					$value_arr['email_pop3'] = (int)($_POST['email_pop3']);
				}

				$value_arr['ftps'] = (int)($_POST['ftps']);
				if (isset($_POST['ftps_ul'])) {
					$value_arr['ftps'] = - 1;
				}

				$value_arr['mysqls'] = (int)($_POST['mysqls']);
				if (isset($_POST['mysqls_ul'])) {
					$value_arr['mysqls'] = - 1;
				}

				$value_arr['phpenabled'] = 0;
				if (isset($_POST['phpenabled'])) {
					$value_arr['phpenabled'] = intval($_POST['phpenabled']);
				}

				$value_arr['allowed_phpconfigs'] = array();
				if (isset($_POST['allowed_phpconfigs']) && is_array($_POST['allowed_phpconfigs'])) {
					foreach ($_POST['allowed_phpconfigs'] as $allowed_phpconfig) {
						$allowed_phpconfig = intval($allowed_phpconfig);
						$value_arr['allowed_phpconfigs'][] = $allowed_phpconfig;
					}
				}

				$value_arr['perlenabled'] = 0;
				if (isset($_POST['perlenabled'])) {
					$value_arr['perlenabled'] = intval($_POST['perlenabled']);
				}

				$value_arr['dnsenabled'] = 0;
				if (isset($_POST['dnsenabled'])) {
					$value_arr['dnsenabled'] = intval($_POST['dnsenabled']);
				}

				$ins_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_PLANS . "`
					SET `name` = :name, `description` = :desc, `value` = :valuearr, `ts` = UNIX_TIMESTAMP()
					WHERE `id` = :id
				");
				$ins_data = array(
					'name' => $name,
					'desc' => $description,
					'valuearr' => json_encode($value_arr),
					'id' => $id
				);
				Database::pexecute($ins_stmt, $ins_data);

				$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, "updated plan '" . $name . "'");
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				$diskspace_ul = \Froxlor\UI\HTML::makecheckbox('diskspace_ul', $lng['customer']['unlimited'], '-1', false, $result['diskspace'], true, true);
				if ($result['diskspace'] == '-1') {
					$result['diskspace'] = '';
				}

				$traffic_ul = \Froxlor\UI\HTML::makecheckbox('traffic_ul', $lng['customer']['unlimited'], '-1', false, $result['traffic'], true, true);
				if ($result['traffic'] == '-1') {
					$result['traffic'] = '';
				}

				$subdomains_ul = \Froxlor\UI\HTML::makecheckbox('subdomains_ul', $lng['customer']['unlimited'], '-1', false, $result['subdomains'], true, true);
				if ($result['subdomains'] == '-1') {
					$result['subdomains'] = '';
				}

				$emails_ul = \Froxlor\UI\HTML::makecheckbox('emails_ul', $lng['customer']['unlimited'], '-1', false, $result['emails'], true, true);
				if ($result['emails'] == '-1') {
					$result['emails'] = '';
				}

				$email_accounts_ul = \Froxlor\UI\HTML::makecheckbox('email_accounts_ul', $lng['customer']['unlimited'], '-1', false, $result['email_accounts'], true, true);
				if ($result['email_accounts'] == '-1') {
					$result['email_accounts'] = '';
				}

				$email_forwarders_ul = \Froxlor\UI\HTML::makecheckbox('email_forwarders_ul', $lng['customer']['unlimited'], '-1', false, $result['email_forwarders'], true, true);
				if ($result['email_forwarders'] == '-1') {
					$result['email_forwarders'] = '';
				}

				$email_quota_ul = \Froxlor\UI\HTML::makecheckbox('email_quota_ul', $lng['customer']['unlimited'], '-1', false, $result['email_quota'], true, true);
				if ($result['email_quota'] == '-1') {
					$result['email_quota'] = '';
				}

				$ftps_ul = \Froxlor\UI\HTML::makecheckbox('ftps_ul', $lng['customer']['unlimited'], '-1', false, $result['ftps'], true, true);
				if ($result['ftps'] == '-1') {
					$result['ftps'] = '';
				}

				$mysqls_ul = \Froxlor\UI\HTML::makecheckbox('mysqls_ul', $lng['customer']['unlimited'], '-1', false, $result['mysqls'], true, true);
				if ($result['mysqls'] == '-1') {
					$result['mysqls'] = '';
				}

				$phpconfigs = array();
				$configs = Database::query("
					SELECT c.*, fc.description as interpreter
					FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
					LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
				");
				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					if ((int) Settings::Get('phpfpm.enabled') == 1) {
						$phpconfigs[] = array(
							'label' => $row['description'] . " [" . $row['interpreter'] . "]<br />",
							'value' => $row['id']
						);
					} else {
						$phpconfigs[] = array(
							'label' => $row['description'] . "<br />",
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
				$language_options = null;
				$result['firstname'] = null;
				$gender_options = null;
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
				$hosting_plans = null;
				$admin_select_cnt = null;
				$admin_select = null;

				$plans_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/plans/formfield.plans_edit.php';
				$cust_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/customer/formfield.customer_edit.php';
				// unset unneeded stuff
				unset($cust_edit_data['customer_edit']['sections']['section_a']);
				unset($cust_edit_data['customer_edit']['sections']['section_b']);
				unset($cust_edit_data['customer_edit']['sections']['section_cpre']);
				// merge
				$plans_edit_data['plans_edit']['sections'] = array_merge($plans_edit_data['plans_edit']['sections'], $cust_edit_data['customer_edit']['sections']);
				$plans_edit_form = \Froxlor\UI\HtmlForm::genHTMLForm($plans_edit_data);

				$title = $plans_edit_data['plans_edit']['title'];
				$image = $plans_edit_data['plans_edit']['image'];

				eval("echo \"" . \Froxlor\UI\Template::getTemplate("plans/plans_edit") . "\";");
			}
		}
	} elseif ($action == 'jqGetPlanValues') {
		$planid = isset($_POST['planid']) ? (int) $_POST['planid'] : 0;
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_PLANS . "` WHERE `id` = :id");
		$result = Database::pexecute_first($result_stmt, array(
			'id' => $planid
		));
		echo $result['value'];
		exit();
	}
}
