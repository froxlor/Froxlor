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
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'domains' || $page == 'overview') {
	// Let's see how many customers we have
	$stmt = Database::prepare("
		SELECT COUNT(`customerid`) as `countcustomers` FROM `" . TABLE_PANEL_CUSTOMERS . "` " . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = :adminid"));
	$params = array();
	if ($userinfo['customers_see_all'] == '0') {
		$params['adminid'] = $userinfo['adminid'];
	}
	$countcustomers = Database::pexecute_first($stmt, $params);
	$countcustomers = (int) $countcustomers['countcustomers'];
	
	if ($action == '') {
		
		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_domains");
		$fields = array(
			'd.domain' => $lng['domains']['domainname'],
			'c.name' => $lng['customer']['name'],
			'c.firstname' => $lng['customer']['firstname'],
			'c.company' => $lng['customer']['company'],
			'c.loginname' => $lng['login']['username'],
			'd.aliasdomain' => $lng['domains']['aliasdomain']
		);
		$paging = new paging($userinfo, TABLE_PANEL_DOMAINS, $fields);
		$domains = "";
		$result_stmt = Database::prepare("
			SELECT `d`.*, `c`.`loginname`, `c`.`deactivated`, `c`.`name`, `c`.`firstname`, `c`.`company`, `c`.`standardsubdomain`, `ad`.`id` AS `aliasdomainid`, `ad`.`domain` AS `aliasdomain`
			FROM `" . TABLE_PANEL_DOMAINS . "` `d`
			LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`)
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `ad` ON `d`.`aliasdomain`=`ad`.`id`
			WHERE `d`.`parentdomainid`='0' " . ($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid ") . " " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		$params = array();
		if ($userinfo['customers_see_all'] == '0') {
			$params['adminid'] = $userinfo['adminid'];
		}
		Database::pexecute($result_stmt, $params);
		$numrows_domains = Database::num_rows();
		$paging->setEntries($numrows_domains);
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$domain_array = array();
		
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			
			formatDomainEntry($row, $idna_convert);
			
			if (! isset($domain_array[$row['domain']])) {
				$domain_array[$row['domain']] = $row;
			} else {
				$domain_array[$row['domain']] = array_merge($row, $domain_array[$row['domain']]);
			}
			
			if (isset($row['aliasdomainid']) && $row['aliasdomainid'] != null && isset($row['aliasdomain']) && $row['aliasdomain'] != '') {
				if (! isset($domain_array[$row['aliasdomain']])) {
					$domain_array[$row['aliasdomain']] = array();
				}
				$domain_array[$row['aliasdomain']]['domainaliasid'] = $row['id'];
				$domain_array[$row['aliasdomain']]['domainalias'] = $row['domain'];
			}
		}
		
		/**
		 * We need ksort/krsort here to make sure idna-domains are also sorted correctly
		 */
		if ($paging->sortfield == 'd.domain' && $paging->sortorder == 'asc') {
			ksort($domain_array);
		} elseif ($paging->sortfield == 'd.domain' && $paging->sortorder == 'desc') {
			krsort($domain_array);
		}
		
		$i = 0;
		$count = 0;
		foreach ($domain_array as $row) {
			
			if (isset($row['domain']) && $row['domain'] != '' && $paging->checkDisplay($i)) {
				$row['customername'] = getCorrectFullUserDetails($row);
				$row = htmlentities_array($row);
				// display a nice list of IP's
				$row['ipandport'] = str_replace("\n", "<br />", $row['ipandport']);
				eval("\$domains.=\"" . getTemplate("domains/domains_domain") . "\";");
				$count ++;
			}
			$i ++;
		}
		
		$domainscount = $numrows_domains;
		
		// Display the list
		eval("echo \"" . getTemplate("domains/domains") . "\";");
	} elseif ($action == 'delete' && $id != 0) {
		
		try {
			$json_result = Domains::getLocal($userinfo, array(
				'id' => $id,
				'no_std_subdomain' => true
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
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
					dynamic_error($e->getMessage());
				}
				
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} elseif ($alias_check['count'] > 0) {
				standard_error('domains_cantdeletedomainwithaliases');
			} else {
				
				$showcheck = false;
				if (domainHasMainSubDomains($id)) {
					$showcheck = true;
				}
				ask_yesno_withcheckbox('admin_domain_reallydelete', 'remove_subbutmain_domains', $filename, array(
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
				dynamic_error($e->getMessage());
			}
			redirectTo($filename, array(
				'page' => $page,
				's' => $s
			));
		} else {
			
			$customers = makeoption($lng['panel']['please_choose'], 0, 0, true);
			$result_customers_stmt = Database::prepare("
					SELECT `customerid`, `loginname`, `name`, `firstname`, `company`
					FROM `" . TABLE_PANEL_CUSTOMERS . "` " . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = '" . (int) $userinfo['adminid'] . "' ") . " ORDER BY COALESCE(NULLIF(`name`,''), `company`) ASC");
			$params = array();
			if ($userinfo['customers_see_all'] == '0') {
				$params['adminid'] = $userinfo['adminid'];
			}
			Database::pexecute($result_customers_stmt, $params);
			
			while ($row_customer = $result_customers_stmt->fetch(PDO::FETCH_ASSOC)) {
				$customers .= makeoption(getCorrectFullUserDetails($row_customer) . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid']);
			}
			
			$admins = '';
			if ($userinfo['customers_see_all'] == '1') {
				
				$result_admins_stmt = Database::query("
						SELECT `adminid`, `loginname`, `name`
						FROM `" . TABLE_PANEL_ADMINS . "`
						WHERE `domains_used` < `domains` OR `domains` = '-1' ORDER BY `name` ASC");
				
				while ($row_admin = $result_admins_stmt->fetch(PDO::FETCH_ASSOC)) {
					$admins .= makeoption(getCorrectFullUserDetails($row_admin) . ' (' . $row_admin['loginname'] . ')', $row_admin['adminid'], $userinfo['adminid']);
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
			
			$domains = makeoption($lng['domains']['noaliasdomain'], 0, NULL, true);
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
				$domains .= makeoption($idna_convert->decode($row_domain['domain']) . ' (' . $row_domain['loginname'] . ')', $row_domain['id']);
			}
			
			$subtodomains = makeoption($lng['domains']['nosubtomaindomain'], 0, NULL, true);
			$result_domains_stmt = Database::prepare("
					SELECT `d`.`id`, `d`.`domain`, `c`.`loginname` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL AND `d`.`parentdomainid` = 0 AND `d`.`ismainbutsubto` = 0 " . $standardsubdomains . ($userinfo['customers_see_all'] ? '' : " AND `d`.`adminid` = :adminid") . "
					AND `d`.`customerid`=`c`.`customerid` ORDER BY `loginname`, `domain` ASC
				");
			// params from above still valid
			Database::pexecute($result_domains_stmt, $params);
			
			while ($row_domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
				$subtodomains .= makeoption($idna_convert->decode($row_domain['domain']) . ' (' . $row_domain['loginname'] . ')', $row_domain['id']);
			}
			
			$phpconfigs = '';
			$configs = Database::query("
					SELECT c.*, fc.description as interpreter
					FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
					LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
				");
			
			while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
				if ((int) Settings::Get('phpfpm.enabled') == 1) {
					$phpconfigs .= makeoption($row['description'] . " [" . $row['interpreter'] . "]", $row['id'], Settings::Get('phpfpm.defaultini'), true, true);
				} else {
					$phpconfigs .= makeoption($row['description'], $row['id'], Settings::Get('system.mod_fcgid_defaultini'), true, true);
				}
			}
			
			// create serveralias options
			$serveraliasoptions = "";
			$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_wildcard'], '0', '0', true, true);
			$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_www'], '1', '0', true, true);
			$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_none'], '2', '0', true, true);
			
			$subcanemaildomain = makeoption($lng['admin']['subcanemaildomain']['never'], '0', '0', true, true);
			$subcanemaildomain .= makeoption($lng['admin']['subcanemaildomain']['choosableno'], '1', '0', true, true);
			$subcanemaildomain .= makeoption($lng['admin']['subcanemaildomain']['choosableyes'], '2', '0', true, true);
			$subcanemaildomain .= makeoption($lng['admin']['subcanemaildomain']['always'], '3', '0', true, true);
			
			$add_date = date('Y-m-d');
			
			$domain_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/domains/formfield.domains_add.php';
			$domain_add_form = htmlform::genHTMLForm($domain_add_data);
			
			$title = $domain_add_data['domain_add']['title'];
			$image = $domain_add_data['domain_add']['image'];
			
			eval("echo \"" . getTemplate("domains/domains_add") . "\";");
		}
	} elseif ($action == 'edit' && $id != 0) {
		
		try {
			$json_result = Domains::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
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
					
					$domain_emails_row['destination'] = explode(' ', makeCorrectDestination($domain_emails_row['destination']));
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
					Domains::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array(
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
						$customers .= makeoption(getCorrectFullUserDetails($row_customer) . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid'], $result['customerid']);
					}
				} else {
					$customer_stmt = Database::prepare("
						SELECT `customerid`, `loginname`, `name`, `firstname`, `company` FROM `" . TABLE_PANEL_CUSTOMERS . "`
						WHERE `customerid` = :customerid
					");
					$customer = Database::pexecute_first($customer_stmt, array(
						'customerid' => $result['customerid']
					));
					$result['customername'] = getCorrectFullUserDetails($customer) . ' (' . $customer['loginname'] . ')';
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
							$admins .= makeoption(getCorrectFullUserDetails($row_admin) . ' (' . $row_admin['loginname'] . ')', $row_admin['adminid'], $result['adminid']);
						}
					} else {
						$admin_stmt = Database::prepare("
							SELECT `adminid`, `loginname`, `name` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid` = :adminid
						");
						$admin = Database::pexecute_first($admin_stmt, array(
							'adminid' => $result['adminid']
						));
						$result['adminname'] = getCorrectFullUserDetails($admin) . ' (' . $admin['loginname'] . ')';
					}
				}
				
				$result['domain'] = $idna_convert->decode($result['domain']);
				$domains = makeoption($lng['domains']['noaliasdomain'], 0, null, true);
				
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
					$domains .= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['aliasdomain']);
				}
				
				$subtodomains = makeoption($lng['domains']['nosubtomaindomain'], 0, null, true);
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
					$subtodomains .= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['ismainbutsubto']);
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
				
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_wildcard'], '0', $_value, true, true);
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_www'], '1', $_value, true, true);
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_none'], '2', $_value, true, true);
				
				$subcanemaildomain = makeoption($lng['admin']['subcanemaildomain']['never'], '0', $result['subcanemaildomain'], true, true);
				$subcanemaildomain .= makeoption($lng['admin']['subcanemaildomain']['choosableno'], '1', $result['subcanemaildomain'], true, true);
				$subcanemaildomain .= makeoption($lng['admin']['subcanemaildomain']['choosableyes'], '2', $result['subcanemaildomain'], true, true);
				$subcanemaildomain .= makeoption($lng['admin']['subcanemaildomain']['always'], '3', $result['subcanemaildomain'], true, true);
				$speciallogfile = ($result['speciallogfile'] == 1 ? $lng['panel']['yes'] : $lng['panel']['no']);
				$result['add_date'] = date('Y-m-d', $result['add_date']);
				
				$phpconfigs = '';
				$phpconfigs_result_stmt = Database::query("
					SELECT c.*, fc.description as interpreter
					FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
					LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
				");
				$c_allowed_configs = getCustomerDetail($result['customerid'], 'allowed_phpconfigs');
				if (! empty($c_allowed_configs)) {
					$c_allowed_configs = json_decode($c_allowed_configs, true);
				} else {
					$c_allowed_configs = array();
				}
				
				while ($phpconfigs_row = $phpconfigs_result_stmt->fetch(PDO::FETCH_ASSOC)) {
					$disabled = ! empty($c_allowed_configs) && ! in_array($phpconfigs_row['id'], $c_allowed_configs);
					if ((int) Settings::Get('phpfpm.enabled') == 1) {
						$phpconfigs .= makeoption($phpconfigs_row['description'] . " [" . $phpconfigs_row['interpreter'] . "]", $phpconfigs_row['id'], $result['phpsettingid'], true, true, null, $disabled);
					} else {
						$phpconfigs .= makeoption($phpconfigs_row['description'], $phpconfigs_row['id'], $result['phpsettingid'], true, true, null, $disabled);
					}
				}
				
				$result = htmlentities_array($result);
				
				$domain_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/domains/formfield.domains_edit.php';
				$domain_edit_form = htmlform::genHTMLForm($domain_edit_data);
				
				$title = $domain_edit_data['domain_edit']['title'];
				$image = $domain_edit_data['domain_edit']['image'];
				
				$speciallogwarning = sprintf($lng['admin']['speciallogwarning'], $lng['admin']['delete_statistics']);
				
				eval("echo \"" . getTemplate("domains/domains_edit") . "\";");
			}
		}
	} elseif ($action == 'jqGetCustomerPHPConfigs') {
		
		$customerid = intval($_POST['customerid']);
		$allowed_phpconfigs = getCustomerDetail($customerid, 'allowed_phpconfigs');
		echo ! empty($allowed_phpconfigs) ? $allowed_phpconfigs : json_encode(array());
		exit();
	} elseif ($action == 'import') {
		
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			
			$customerid = intval($_POST['customerid']);
			$separator = validate($_POST['separator'], 'separator');
			$offset = (int) validate($_POST['offset'], 'offset', "/[0-9]/i");
			
			$file_name = $_FILES['file']['tmp_name'];
			
			$result = array();
			
			try {
				$bulk = new DomainBulkAction($file_name, $customerid);
				$result = $bulk->doImport($separator, $offset);
			} catch (Exception $e) {
				standard_error('domain_import_error', $e->getMessage());
			}
			
			if (!empty($bulk->getErrors())) {
				dynamic_error(implode("<br>", $bulk->getErrors()));
			}

			// update customer/admin counters
			updateCounters(false);
			inserttask('1');
			inserttask('4');
			
			$result_str = $result['imported'] . ' / ' . $result['all'] . (!empty($result['note']) ? ' ('.$result['note'].')' : '');
			standard_success('domain_import_successfully', $result_str, array(
				'filename' => $filename,
				'action' => '',
				'page' => 'domains'
			));
		} else {
			$customers = makeoption($lng['panel']['please_choose'], 0, 0, true);
			$result_customers_stmt = Database::prepare("
				SELECT `customerid`, `loginname`, `name`, `firstname`, `company`
				FROM `" . TABLE_PANEL_CUSTOMERS . "` " . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = '" . (int) $userinfo['adminid'] . "' ") . " ORDER BY `name` ASC");
			$params = array();
			if ($userinfo['customers_see_all'] == '0') {
				$params['adminid'] = $userinfo['adminid'];
			}
			Database::pexecute($result_customers_stmt, $params);
			
			while ($row_customer = $result_customers_stmt->fetch(PDO::FETCH_ASSOC)) {
				$customers .= makeoption(getCorrectFullUserDetails($row_customer) . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid']);
			}
			
			$domain_import_data = include_once dirname(__FILE__) . '/lib/formfields/admin/domains/formfield.domains_import.php';
			$domain_import_form = htmlform::genHTMLForm($domain_import_data);
			
			$title = $domain_import_data['domain_import']['title'];
			$image = $domain_import_data['domain_import']['image'];
			
			eval("echo \"" . getTemplate("domains/domains_import") . "\";");
		}
	}
} elseif ($page == 'domaindnseditor' && Settings::Get('system.dnsenabled') == '1') {
	
	require_once __DIR__ . '/dns_editor.php';

} elseif ($page == 'sslcertificates') {

	require_once __DIR__ . '/ssl_certificates.php';

} elseif ($page == 'logfiles') {

	require_once __DIR__.'/logfiles_viewer.php';
}

function formatDomainEntry(&$row, &$idna_convert)
{
	$row['domain'] = $idna_convert->decode($row['domain']);
	$row['aliasdomain'] = $idna_convert->decode($row['aliasdomain']);
	
	$resultips_stmt = Database::prepare("
		SELECT `ips`.* FROM `" . TABLE_DOMAINTOIP . "` AS `dti`, `" . TABLE_PANEL_IPSANDPORTS . "` AS `ips`
		WHERE `dti`.`id_ipandports` = `ips`.`id` AND `dti`.`id_domain` = :domainid
	");
	
	Database::pexecute($resultips_stmt, array(
		'domainid' => $row['id']
	));
	
	$row['ipandport'] = '';
	while ($rowip = $resultips_stmt->fetch(PDO::FETCH_ASSOC)) {
		
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
