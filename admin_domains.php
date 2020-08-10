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

use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\Api\Commands\Customers as Customers;
use Froxlor\Api\Commands\Domains as Domains;

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'domains' || $page == 'overview') {
	// Let's see how many customers we have
	$json_result = Customers::getLocal($userinfo)->listingCount();
	$countcustomers = json_decode($json_result, true)['data'];

	if ($action == '') {

		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_domains");
		$fields = array(
			'd.domain_ace' => $lng['domains']['domainname'],
			'c.name' => $lng['customer']['name'],
			'c.firstname' => $lng['customer']['firstname'],
			'c.company' => $lng['customer']['company'],
			'c.loginname' => $lng['login']['username'],
			'd.aliasdomain' => $lng['domains']['aliasdomain']
		);
		try {
			// get total count
			$json_result = Domains::getLocal($userinfo)->listingCount();
			$result = json_decode($json_result, true)['data'];
			// initialize pagination and filtering
			$paging = new \Froxlor\UI\Pagination($userinfo, $fields, $result);
			// get list
			$json_result = Domains::getLocal($userinfo, $paging->getApiCommandParams())->listing();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		$domains = '';
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);

		$count = 0;
		foreach ($result['list'] as $row) {
			formatDomainEntry($row, $idna_convert);
			$row['customername'] = \Froxlor\User::getCorrectFullUserDetails($row);
			$row = \Froxlor\PhpHelper::htmlentitiesArray($row);
			// display a nice list of IP's if it's not an alias for another domain
			if (isset($row['aliasdomainid']) && $row['aliasdomainid'] != null && isset($row['aliasdomain']) && $row['aliasdomain'] != '') {
				$row['ipandport'] = sprintf($lng['domains']['isaliasdomainof'], $row['aliasdomain']);
			} else {
				$row['ipandport'] = str_replace("\n", "<br />", $row['ipandport']);
			}
			eval("\$domains.=\"" . \Froxlor\UI\Template::getTemplate("domains/domains_domain") . "\";");
			$count++;
		}

		$domainscount = $result['count'] . " / " . $paging->getEntries();

		// Display the list
		eval("echo \"" . \Froxlor\UI\Template::getTemplate("domains/domains") . "\";");
	} elseif ($action == 'delete' && $id != 0) {

		try {
			$json_result = Domains::getLocal($userinfo, array(
				'id' => $id,
				'no_std_subdomain' => true
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		$alias_check_stmt = Database::prepare("
			SELECT COUNT(`id`) AS `count` FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE `aliasdomain`= :id");
		$alias_check = Database::pexecute_first($alias_check_stmt, array(
			'id' => $id
		));

		if ($result['domain'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send' && $alias_check['count'] == 0) {

				try {
					Domains::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}

				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} elseif ($alias_check['count'] > 0) {
				\Froxlor\UI\Response::standard_error('domains_cantdeletedomainwithaliases');
			} else {

				$showcheck = false;
				if (\Froxlor\Domain\Domain::domainHasMainSubDomains($id)) {
					$showcheck = true;
				}
				\Froxlor\UI\HTML::askYesNoWithCheckbox('admin_domain_reallydelete', 'remove_subbutmain_domains', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $idna_convert->decode($result['domain']), $showcheck);
			}
		}
	} elseif ($action == 'add') {

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				Domains::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page,
				's' => $s
			));
		} else {

			$customers = \Froxlor\UI\HTML::makeoption($lng['panel']['please_choose'], 0, 0, true);
			$result_customers_stmt = Database::prepare("
					SELECT `customerid`, `loginname`, `name`, `firstname`, `company`
					FROM `" . TABLE_PANEL_CUSTOMERS . "` " . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = '" . (int) $userinfo['adminid'] . "' ") . " ORDER BY COALESCE(NULLIF(`name`,''), `company`) ASC");
			$params = array();
			if ($userinfo['customers_see_all'] == '0') {
				$params['adminid'] = $userinfo['adminid'];
			}
			Database::pexecute($result_customers_stmt, $params);

			while ($row_customer = $result_customers_stmt->fetch(PDO::FETCH_ASSOC)) {
				$customers .= \Froxlor\UI\HTML::makeoption(\Froxlor\User::getCorrectFullUserDetails($row_customer) . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid']);
			}

			$admins = '';
			if ($userinfo['customers_see_all'] == '1') {

				$result_admins_stmt = Database::query("
						SELECT `adminid`, `loginname`, `name`
						FROM `" . TABLE_PANEL_ADMINS . "`
						WHERE `domains_used` < `domains` OR `domains` = '-1' ORDER BY `name` ASC");

				while ($row_admin = $result_admins_stmt->fetch(PDO::FETCH_ASSOC)) {
					$admins .= \Froxlor\UI\HTML::makeoption(\Froxlor\User::getCorrectFullUserDetails($row_admin) . ' (' . $row_admin['loginname'] . ')', $row_admin['adminid'], $userinfo['adminid']);
				}
			}

			if ($userinfo['ip'] == "-1") {
				$result_ipsandports_stmt = Database::query("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='0' ORDER BY `ip`, `port` ASC
					");
				$result_ssl_ipsandports_stmt = Database::query("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='1' ORDER BY `ip`, `port` ASC
					");
			} else {
				$admin_ip_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = :ipid ORDER BY `ip`, `port` ASC
					");
				$admin_ip = Database::pexecute_first($admin_ip_stmt, array(
					'ipid' => $userinfo['ip']
				));

				$result_ipsandports_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='0' AND `ip` = :ipid ORDER BY `ip`, `port` ASC
					");
				Database::pexecute($result_ipsandports_stmt, array(
					'ipid' => $admin_ip['ip']
				));

				$result_ssl_ipsandports_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='1' AND `ip` = :ipid ORDER BY `ip`, `port` ASC
					");
				Database::pexecute($result_ssl_ipsandports_stmt, array(
					'ipid' => $admin_ip['ip']
				));
			}

			// Build array holding all IPs and Ports available to this admin
			$ipsandports = array();
			while ($row_ipandport = $result_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {

				if (filter_var($row_ipandport['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
					$row_ipandport['ip'] = '[' . $row_ipandport['ip'] . ']';
				}

				$ipsandports[] = array(
					'label' => $row_ipandport['ip'] . ':' . $row_ipandport['port'] . '<br />',
					'value' => $row_ipandport['id']
				);
			}

			$ssl_ipsandports = array();
			while ($row_ssl_ipandport = $result_ssl_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {

				if (filter_var($row_ssl_ipandport['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
					$row_ssl_ipandport['ip'] = '[' . $row_ssl_ipandport['ip'] . ']';
				}

				$ssl_ipsandports[] = array(
					'label' => $row_ssl_ipandport['ip'] . ':' . $row_ssl_ipandport['port'] . '<br />',
					'value' => $row_ssl_ipandport['id']
				);
			}

			$standardsubdomains = array();
			$result_standardsubdomains_stmt = Database::query("
					SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c` WHERE `d`.`id` = `c`.`standardsubdomain`
				");

			while ($row_standardsubdomain = $result_standardsubdomains_stmt->fetch(PDO::FETCH_ASSOC)) {
				$standardsubdomains[] = $row_standardsubdomain['id'];
			}

			if (count($standardsubdomains) > 0) {
				$standardsubdomains = " AND `d`.`id` NOT IN (" . join(',', $standardsubdomains) . ") ";
			} else {
				$standardsubdomains = '';
			}

			$domains = \Froxlor\UI\HTML::makeoption($lng['domains']['noaliasdomain'], 0, NULL, true);
			$result_domains_stmt = Database::prepare("
					SELECT `d`.`id`, `d`.`domain`, `c`.`loginname` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL AND `d`.`parentdomainid` = 0" . $standardsubdomains . ($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid") . "
					AND `d`.`customerid`=`c`.`customerid` ORDER BY `loginname`, `domain` ASC
				");
			$params = array();
			if ($userinfo['customers_see_all'] == '0') {
				$params['adminid'] = $userinfo['adminid'];
			}
			Database::pexecute($result_domains_stmt, $params);

			while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
				$domains .= \Froxlor\UI\HTML::makeoption($idna_convert->decode($row_domain['domain']) . ' (' . $row_domain['loginname'] . ')', $row_domain['id']);
			}

			$subtodomains = \Froxlor\UI\HTML::makeoption($lng['domains']['nosubtomaindomain'], 0, NULL, true);
			$result_domains_stmt = Database::prepare("
					SELECT `d`.`id`, `d`.`domain`, `c`.`loginname` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL AND `d`.`parentdomainid` = 0 AND `d`.`ismainbutsubto` = 0 " . $standardsubdomains . ($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid") . "
					AND `d`.`customerid`=`c`.`customerid` ORDER BY `loginname`, `domain` ASC
				");
			// params from above still valid
			Database::pexecute($result_domains_stmt, $params);

			while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
				$subtodomains .= \Froxlor\UI\HTML::makeoption($idna_convert->decode($row_domain['domain']) . ' (' . $row_domain['loginname'] . ')', $row_domain['id']);
			}

			$phpconfigs = '';
			$configs = Database::query("
					SELECT c.*, fc.description as interpreter
					FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
					LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
				");

			while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
				if ((int) Settings::Get('phpfpm.enabled') == 1) {
					$phpconfigs .= \Froxlor\UI\HTML::makeoption($row['description'] . " [" . $row['interpreter'] . "]", $row['id'], Settings::Get('phpfpm.defaultini'), true, true);
				} else {
					$phpconfigs .= \Froxlor\UI\HTML::makeoption($row['description'], $row['id'], Settings::Get('system.mod_fcgid_defaultini'), true, true);
				}
			}

			// create serveralias options
			$serveraliasoptions = "";
			$serveraliasoptions .= \Froxlor\UI\HTML::makeoption($lng['domains']['serveraliasoption_wildcard'], '0', '0', true, true);
			$serveraliasoptions .= \Froxlor\UI\HTML::makeoption($lng['domains']['serveraliasoption_www'], '1', '0', true, true);
			$serveraliasoptions .= \Froxlor\UI\HTML::makeoption($lng['domains']['serveraliasoption_none'], '2', '0', true, true);

			$subcanemaildomain = \Froxlor\UI\HTML::makeoption($lng['admin']['subcanemaildomain']['never'], '0', '0', true, true);
			$subcanemaildomain .= \Froxlor\UI\HTML::makeoption($lng['admin']['subcanemaildomain']['choosableno'], '1', '0', true, true);
			$subcanemaildomain .= \Froxlor\UI\HTML::makeoption($lng['admin']['subcanemaildomain']['choosableyes'], '2', '0', true, true);
			$subcanemaildomain .= \Froxlor\UI\HTML::makeoption($lng['admin']['subcanemaildomain']['always'], '3', '0', true, true);

			$add_date = date('Y-m-d');

			$domain_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/domains/formfield.domains_add.php';
			$domain_add_form = \Froxlor\UI\HtmlForm::genHTMLForm($domain_add_data);

			$title = $domain_add_data['domain_add']['title'];
			$image = $domain_add_data['domain_add']['image'];

			eval("echo \"" . \Froxlor\UI\Template::getTemplate("domains/domains_add") . "\";");
		}
	} elseif ($action == 'edit' && $id != 0) {

		try {
			$json_result = Domains::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['domain'] != '') {

			$subdomains_stmt = Database::prepare("
				SELECT COUNT(`id`) AS count FROM `" . TABLE_PANEL_DOMAINS . "` WHERE
				`parentdomainid` = :resultid
			");
			$subdomains = Database::pexecute_first($subdomains_stmt, array(
				'resultid' => $result['id']
			));
			$subdomains = $subdomains['count'];

			$alias_check_stmt = Database::prepare("
				SELECT COUNT(`id`) AS count FROM `" . TABLE_PANEL_DOMAINS . "` WHERE
				`aliasdomain` = :resultid
			");
			$alias_check = Database::pexecute_first($alias_check_stmt, array(
				'resultid' => $result['id']
			));
			$alias_check = $alias_check['count'];

			$domain_emails_result_stmt = Database::prepare("
				SELECT `email`, `email_full`, `destination`, `popaccountid` AS `number_email_forwarders`
				FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `customerid` = :customerid AND `domainid` = :id
			");
			Database::pexecute($domain_emails_result_stmt, array(
				'customerid' => $result['customerid'],
				'id' => $result['id']
			));

			$emails = Database::num_rows();
			$email_forwarders = 0;
			$email_accounts = 0;

			while ($domain_emails_row = $domain_emails_result_stmt->fetch(PDO::FETCH_ASSOC)) {

				if ($domain_emails_row['destination'] != '') {

					$domain_emails_row['destination'] = explode(' ', \Froxlor\FileDir::makeCorrectDestination($domain_emails_row['destination']));
					$email_forwarders += count($domain_emails_row['destination']);

					if (in_array($domain_emails_row['email_full'], $domain_emails_row['destination'])) {
						$email_forwarders -= 1;
						$email_accounts ++;
					}
				}
			}

			$ipsresult_stmt = Database::prepare("
				SELECT `id_ipandports` FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_domain` = :id
			");
			Database::pexecute($ipsresult_stmt, array(
				'id' => $result['id']
			));

			$usedips = array();
			while ($ipsresultrow = $ipsresult_stmt->fetch(PDO::FETCH_ASSOC)) {
				$usedips[] = $ipsresultrow['id_ipandports'];
			}

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					// remove ssl ip/ports if set is empty
					if (!isset($_POST['ssl_ipandport']) || empty($_POST['ssl_ipandport'])) {
						$_POST['remove_ssl_ipandport'] = true;
					}
					Domains::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				if (Settings::Get('panel.allow_domain_change_customer') == '1') {
					$customers = '';
					$result_customers_stmt = Database::prepare("
						SELECT `customerid`, `loginname`, `name`, `firstname`, `company` FROM `" . TABLE_PANEL_CUSTOMERS . "`
						WHERE ( (`subdomains_used` + :subdomains <= `subdomains` OR `subdomains` = '-1' )
						AND (`emails_used` + :emails <= `emails` OR `emails` = '-1' )
						AND (`email_forwarders_used` + :forwarders <= `email_forwarders` OR `email_forwarders` = '-1' )
						AND (`email_accounts_used` + :accounts <= `email_accounts` OR `email_accounts` = '-1' ) " . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid ") . ")
						OR `customerid` = :customerid ORDER BY `name` ASC
					");
					$params = array(
						'subdomains' => $subdomains,
						'emails' => $emails,
						'forwarders' => $email_forwarders,
						'accounts' => $email_accounts,
						'customerid' => $result['customerid']
					);
					if ($userinfo['customers_see_all'] == '0') {
						$params['adminid'] = $userinfo['adminid'];
					}
					Database::pexecute($result_customers_stmt, $params);

					while ($row_customer = $result_customers_stmt->fetch(PDO::FETCH_ASSOC)) {
						$customers .= \Froxlor\UI\HTML::makeoption(\Froxlor\User::getCorrectFullUserDetails($row_customer) . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid'], $result['customerid']);
					}
				} else {
					$customer_stmt = Database::prepare("
						SELECT `customerid`, `loginname`, `name`, `firstname`, `company` FROM `" . TABLE_PANEL_CUSTOMERS . "`
						WHERE `customerid` = :customerid
					");
					$customer = Database::pexecute_first($customer_stmt, array(
						'customerid' => $result['customerid']
					));
					$result['customername'] = \Froxlor\User::getCorrectFullUserDetails($customer) . ' (' . $customer['loginname'] . ')';
				}

				if ($userinfo['customers_see_all'] == '1') {
					if (Settings::Get('panel.allow_domain_change_admin') == '1') {

						$admins = '';
						$result_admins_stmt = Database::prepare("
							SELECT `adminid`, `loginname`, `name` FROM `" . TABLE_PANEL_ADMINS . "`
							WHERE (`domains_used` < `domains` OR `domains` = '-1') OR `adminid` = :adminid ORDER BY `name` ASC
						");
						Database::pexecute($result_admins_stmt, array(
							'adminid' => $result['adminid']
						));

						while ($row_admin = $result_admins_stmt->fetch(PDO::FETCH_ASSOC)) {
							$admins .= \Froxlor\UI\HTML::makeoption(\Froxlor\User::getCorrectFullUserDetails($row_admin) . ' (' . $row_admin['loginname'] . ')', $row_admin['adminid'], $result['adminid']);
						}
					} else {
						$admin_stmt = Database::prepare("
							SELECT `adminid`, `loginname`, `name` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid` = :adminid
						");
						$admin = Database::pexecute_first($admin_stmt, array(
							'adminid' => $result['adminid']
						));
						$result['adminname'] = \Froxlor\User::getCorrectFullUserDetails($admin) . ' (' . $admin['loginname'] . ')';
					}
				}

				$result['domain'] = $idna_convert->decode($result['domain']);
				$domains = \Froxlor\UI\HTML::makeoption($lng['domains']['noaliasdomain'], 0, null, true);

				$result_domains_stmt = Database::prepare("
					SELECT `d`.`id`, `d`.`domain`  FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL AND `d`.`parentdomainid` = '0' AND `d`.`id` <> :id
					AND `c`.`standardsubdomain`<>`d`.`id` AND `d`.`customerid` = :customerid AND `c`.`customerid`=`d`.`customerid`
					ORDER BY `d`.`domain` ASC
				");
				Database::pexecute($result_domains_stmt, array(
					'id' => $result['id'],
					'customerid' => $result['customerid']
				));

				while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains .= \Froxlor\UI\HTML::makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['aliasdomain']);
				}

				$subtodomains = \Froxlor\UI\HTML::makeoption($lng['domains']['nosubtomaindomain'], 0, null, true);
				$result_domains_stmt = Database::prepare("
					SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL AND `d`.`parentdomainid` = '0' AND `d`.`id` <> :id
					AND `c`.`standardsubdomain`<>`d`.`id` AND `c`.`customerid`=`d`.`customerid`" . ($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid") . "
					ORDER BY `d`.`domain` ASC
				");
				$params = array(
					'id' => $result['id']
				);
				if ($userinfo['customers_see_all'] == '0') {
					$params['adminid'] = $userinfo['adminid'];
				}
				Database::pexecute($result_domains_stmt, $params);

				while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$subtodomains .= \Froxlor\UI\HTML::makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['ismainbutsubto']);
				}

				if ($userinfo['ip'] == "-1") {
					$result_ipsandports_stmt = Database::query("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='0' ORDER BY `ip`, `port` ASC
					");
					$result_ssl_ipsandports_stmt = Database::query("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='1' ORDER BY `ip`, `port` ASC
					");
				} else {
					$admin_ip_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = :ipid ORDER BY `ip`, `port` ASC
					");
					$admin_ip = Database::pexecute_first($admin_ip_stmt, array(
						'ipid' => $userinfo['ip']
					));

					$result_ipsandports_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='0' AND `ip` = :ipid ORDER BY `ip`, `port` ASC
					");
					Database::pexecute($result_ipsandports_stmt, array(
						'ipid' => $admin_ip['ip']
					));

					$result_ssl_ipsandports_stmt = Database::prepare("
						SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl`='1' AND `ip` = :ipid ORDER BY `ip`, `port` ASC
					");
					Database::pexecute($result_ssl_ipsandports_stmt, array(
						'ipid' => $admin_ip['ip']
					));
				}

				$ipsandports = array();
				while ($row_ipandport = $result_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
					if (filter_var($row_ipandport['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
						$row_ipandport['ip'] = '[' . $row_ipandport['ip'] . ']';
					}
					$ipsandports[] = array(
						'label' => $row_ipandport['ip'] . ':' . $row_ipandport['port'] . '<br />',
						'value' => $row_ipandport['id']
					);
				}

				$ssl_ipsandports = array();
				while ($row_ssl_ipandport = $result_ssl_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
					if (filter_var($row_ssl_ipandport['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
						$row_ssl_ipandport['ip'] = '[' . $row_ssl_ipandport['ip'] . ']';
					}
					$ssl_ipsandports[] = array(
						'label' => $row_ssl_ipandport['ip'] . ':' . $row_ssl_ipandport['port'] . '<br />',
						'value' => $row_ssl_ipandport['id']
					);
				}

				// create serveralias options
				$serveraliasoptions = "";
				$_value = '2';
				if ($result['iswildcarddomain'] == '1') {
					$_value = '0';
					$letsencrypt = 0;
				} elseif ($result['wwwserveralias'] == '1') {
					$_value = '1';
				}

				// Fudge the result for ssl_redirect to hide the Let's Encrypt steps
				$result['temporary_ssl_redirect'] = $result['ssl_redirect'];
				$result['ssl_redirect'] = ($result['ssl_redirect'] == 0 ? 0 : 1);

				$serveraliasoptions .= \Froxlor\UI\HTML::makeoption($lng['domains']['serveraliasoption_wildcard'], '0', $_value, true, true);
				$serveraliasoptions .= \Froxlor\UI\HTML::makeoption($lng['domains']['serveraliasoption_www'], '1', $_value, true, true);
				$serveraliasoptions .= \Froxlor\UI\HTML::makeoption($lng['domains']['serveraliasoption_none'], '2', $_value, true, true);

				$subcanemaildomain = \Froxlor\UI\HTML::makeoption($lng['admin']['subcanemaildomain']['never'], '0', $result['subcanemaildomain'], true, true);
				$subcanemaildomain .= \Froxlor\UI\HTML::makeoption($lng['admin']['subcanemaildomain']['choosableno'], '1', $result['subcanemaildomain'], true, true);
				$subcanemaildomain .= \Froxlor\UI\HTML::makeoption($lng['admin']['subcanemaildomain']['choosableyes'], '2', $result['subcanemaildomain'], true, true);
				$subcanemaildomain .= \Froxlor\UI\HTML::makeoption($lng['admin']['subcanemaildomain']['always'], '3', $result['subcanemaildomain'], true, true);
				$speciallogfile = ($result['speciallogfile'] == 1 ? $lng['panel']['yes'] : $lng['panel']['no']);
				$result['add_date'] = date('Y-m-d', $result['add_date']);

				$phpconfigs = '';
				$phpconfigs_result_stmt = Database::query("
					SELECT c.*, fc.description as interpreter
					FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
					LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
				");
				$c_allowed_configs = \Froxlor\Customer\Customer::getCustomerDetail($result['customerid'], 'allowed_phpconfigs');
				if (! empty($c_allowed_configs)) {
					$c_allowed_configs = json_decode($c_allowed_configs, true);
				} else {
					$c_allowed_configs = array();
				}

				while ($phpconfigs_row = $phpconfigs_result_stmt->fetch(PDO::FETCH_ASSOC)) {
					$disabled = ! empty($c_allowed_configs) && ! in_array($phpconfigs_row['id'], $c_allowed_configs);
					if ((int) Settings::Get('phpfpm.enabled') == 1) {
						$phpconfigs .= \Froxlor\UI\HTML::makeoption($phpconfigs_row['description'] . " [" . $phpconfigs_row['interpreter'] . "]", $phpconfigs_row['id'], $result['phpsettingid'], true, true, null, $disabled);
					} else {
						$phpconfigs .= \Froxlor\UI\HTML::makeoption($phpconfigs_row['description'], $phpconfigs_row['id'], $result['phpsettingid'], true, true, null, $disabled);
					}
				}

				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$domain_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/domains/formfield.domains_edit.php';
				$domain_edit_form = \Froxlor\UI\HtmlForm::genHTMLForm($domain_edit_data);

				$title = $domain_edit_data['domain_edit']['title'];
				$image = $domain_edit_data['domain_edit']['image'];

				$speciallogwarning = sprintf($lng['admin']['speciallogwarning'], $lng['admin']['delete_statistics']);

				eval("echo \"" . \Froxlor\UI\Template::getTemplate("domains/domains_edit") . "\";");
			}
		}
	} elseif ($action == 'jqGetCustomerPHPConfigs') {

		$customerid = intval($_POST['customerid']);
		$allowed_phpconfigs = \Froxlor\Customer\Customer::getCustomerDetail($customerid, 'allowed_phpconfigs');
		echo ! empty($allowed_phpconfigs) ? $allowed_phpconfigs : json_encode(array());
		exit();
	} elseif ($action == 'import') {

		if (isset($_POST['send']) && $_POST['send'] == 'send') {

			$customerid = intval($_POST['customerid']);
			$separator = \Froxlor\Validate\Validate::validate($_POST['separator'], 'separator');
			$offset = (int) \Froxlor\Validate\Validate::validate($_POST['offset'], 'offset', "/[0-9]/i");

			$file_name = $_FILES['file']['tmp_name'];

			$result = array();

			try {
				$bulk = new \Froxlor\Bulk\DomainBulkAction($file_name, $customerid);
				$result = $bulk->doImport($separator, $offset);
			} catch (Exception $e) {
				\Froxlor\UI\Response::standard_error('domain_import_error', $e->getMessage());
			}

			if (! empty($bulk->getErrors())) {
				\Froxlor\UI\Response::dynamic_error(implode("<br>", $bulk->getErrors()));
			}

			// update customer/admin counters
			\Froxlor\User::updateCounters(false);
			\Froxlor\System\Cronjob::inserttask('1');
			\Froxlor\System\Cronjob::inserttask('4');

			$result_str = $result['imported'] . ' / ' . $result['all'] . (! empty($result['note']) ? ' (' . $result['note'] . ')' : '');
			\Froxlor\UI\Response::standard_success('domain_import_successfully', $result_str, array(
				'filename' => $filename,
				'action' => '',
				'page' => 'domains'
			));
		} else {
			$customers = \Froxlor\UI\HTML::makeoption($lng['panel']['please_choose'], 0, 0, true);
			$result_customers_stmt = Database::prepare("
				SELECT `customerid`, `loginname`, `name`, `firstname`, `company`
				FROM `" . TABLE_PANEL_CUSTOMERS . "` " . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = '" . (int) $userinfo['adminid'] . "' ") . " ORDER BY `name` ASC");
			$params = array();
			if ($userinfo['customers_see_all'] == '0') {
				$params['adminid'] = $userinfo['adminid'];
			}
			Database::pexecute($result_customers_stmt, $params);

			while ($row_customer = $result_customers_stmt->fetch(PDO::FETCH_ASSOC)) {
				$customers .= \Froxlor\UI\HTML::makeoption(\Froxlor\User::getCorrectFullUserDetails($row_customer) . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid']);
			}

			$domain_import_data = include_once dirname(__FILE__) . '/lib/formfields/admin/domains/formfield.domains_import.php';
			$domain_import_form = \Froxlor\UI\HtmlForm::genHTMLForm($domain_import_data);

			$title = $domain_import_data['domain_import']['title'];
			$image = $domain_import_data['domain_import']['image'];

			eval("echo \"" . \Froxlor\UI\Template::getTemplate("domains/domains_import") . "\";");
		}
	}
} elseif ($page == 'domaindnseditor' && Settings::Get('system.dnsenabled') == '1') {

	require_once __DIR__ . '/dns_editor.php';
} elseif ($page == 'sslcertificates') {

	require_once __DIR__ . '/ssl_certificates.php';
} elseif ($page == 'logfiles') {

	require_once __DIR__ . '/logfiles_viewer.php';
}

function formatDomainEntry(&$row, &$idna_convert)
{
	$row['domain'] = $idna_convert->decode($row['domain']);
	$row['aliasdomain'] = $idna_convert->decode($row['aliasdomain']);

	$row['ipandport'] = '';
	foreach ($row['ipsandports'] as $rowip) {
		if (filter_var($rowip['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			$row['ipandport'] .= '[' . $rowip['ip'] . ']:' . $rowip['port'] . "\n";
		} else {
			$row['ipandport'] .= $rowip['ip'] . ':' . $rowip['port'] . "\n";
		}
	}
	$row['ipandport'] = substr($row['ipandport'], 0, - 1);
	$row['termination_date'] = str_replace("0000-00-00", "", $row['termination_date']);

	$row['termination_css'] = "";
	if ($row['termination_date'] != "") {
		$cdate = strtotime($row['termination_date'] . " 23:59:59");
		$today = time();

		if ($cdate < $today) {
			$row['termination_css'] = 'domain-expired';
		} else {
			$row['termination_css'] = 'domain-canceled';
		}
	}
}
