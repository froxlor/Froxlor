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

define('AREA', 'customer');
require './lib/init.php';

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options','domains')) {
	redirectTo('customer_index.php');
}

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {
	$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_domains");
	eval("echo \"" . getTemplate("domains/domains") . "\";");
} elseif ($page == 'domains') {
	if ($action == '') {
		$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_domains::domains");
		$fields = array(
			'd.domain' => $lng['domains']['domainname']
		);
		$paging = new paging($userinfo, TABLE_PANEL_DOMAINS, $fields);
		$domains_stmt = Database::prepare("SELECT `d`.`id`, `d`.`customerid`, `d`.`domain`, `d`.`documentroot`, `d`.`isbinddomain`, `d`.`isemaildomain`, `d`.`caneditdomain`, `d`.`iswildcarddomain`, `d`.`parentdomainid`, `d`.`letsencrypt`, `d`.`registration_date`, `d`.`termination_date`, `ad`.`id` AS `aliasdomainid`, `ad`.`domain` AS `aliasdomain`, `da`.`id` AS `domainaliasid`, `da`.`domain` AS `domainalias` FROM `" . TABLE_PANEL_DOMAINS . "` `d`
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `ad` ON `d`.`aliasdomain`=`ad`.`id`
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `da` ON `da`.`aliasdomain`=`d`.`id`
			WHERE `d`.`customerid`= :customerid
			AND `d`.`email_only`='0'
			AND `d`.`id` <> :standardsubdomain " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit()
			);
		Database::pexecute($domains_stmt, array("customerid" => $userinfo['customerid'], "standardsubdomain" => $userinfo['standardsubdomain']));
		$paging->setEntries(Database::num_rows());
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$domains = '';
		$parentdomains_count = 0;
		$domains_count = 0;
		$domain_array = array();
		
		while ($row = $domains_stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['domain'] = $idna_convert->decode($row['domain']);
			$row['aliasdomain'] = $idna_convert->decode($row['aliasdomain']);
			$row['domainalias'] = $idna_convert->decode($row['domainalias']);
			
			if ($row['parentdomainid'] == '0' && $row['caneditdomain'] == '1') {
				$parentdomains_count++;
			}
			
			/**
			 * check for set ssl-certs to show different state-icons
			 */
			// nothing (ssl_global)
			$row['domain_hascert'] = 0;
			$ssl_stmt = Database::prepare("SELECT * FROM `".TABLE_PANEL_DOMAIN_SSL_SETTINGS."` WHERE `domainid` = :domainid");
			Database::pexecute($ssl_stmt, array("domainid" => $row['id']));
			$ssl_result = $ssl_stmt->fetch(PDO::FETCH_ASSOC);
			if (is_array($ssl_result) && isset($ssl_result['ssl_cert_file']) && $ssl_result['ssl_cert_file'] != '') {
				// own certificate (ssl_customer_green)
				$row['domain_hascert'] = 1;
			} else {
				// check if it's parent has one set (shared)
				if ($row['parentdomainid'] != 0) {
					$ssl_stmt = Database::prepare("SELECT * FROM `".TABLE_PANEL_DOMAIN_SSL_SETTINGS."` WHERE `domainid` = :domainid");
					Database::pexecute($ssl_stmt, array("domainid" => $row['parentdomainid']));
					$ssl_result = $ssl_stmt->fetch(PDO::FETCH_ASSOC);
					if (is_array($ssl_result) && isset($ssl_result['ssl_cert_file']) && $ssl_result['ssl_cert_file'] != '') {
						// parent has a certificate (ssl_shared)
						$row['domain_hascert'] = 2;
					}
				}
			}
			
			$row['termination_date'] = str_replace("0000-00-00", "", $row['termination_date']);
			if($row['termination_date'] != "") {
				$cdate = strtotime($row['termination_date'] . " 23:59:59");
				$today = time();
				
				if($cdate < $today) {
					$row['termination_css'] = 'domain-expired';
				} else {
					$row['termination_css'] = 'domain-canceled';
				}
			}
			
			$domains_count++;
			$domain_array[$row['domain']] = $row;
		}
		
		ksort($domain_array);
		$domain_id_array = array();
		foreach ($domain_array as $sortkey => $row) {
			$domain_id_array[$row['id']] = $sortkey;
		}
		
		$domain_sort_array = array();
		foreach ($domain_array as $sortkey => $row) {
			if ($row['parentdomainid'] == 0) {
				$domain_sort_array[$sortkey][$sortkey] = $row;
			} else {
				// when searching and the results are subdomains only, we need to get
				// the parent domain to this subdomain
				if (!isset($domain_id_array[$row['parentdomainid']])) {
					$domain_id_array[$row['parentdomainid']] = "[parent-domain]";
				}
				$domain_sort_array[$domain_id_array[$row['parentdomainid']]][$sortkey] = $row;
			}
		}
		
		$domain_array = array();
		
		if ($paging->sortfield == 'd.domain' && $paging->sortorder == 'asc') {
			ksort($domain_sort_array);
		} elseif ($paging->sortfield == 'd.domain' && $paging->sortorder == 'desc') {
			krsort($domain_sort_array);
		}
		
		$i = 0;
		foreach ($domain_sort_array as $sortkey => $domain_array) {
			if ($paging->checkDisplay($i)) {
				
				if (isset($domain_array[$sortkey])) {
					$row = htmlentities_array($domain_array[$sortkey]);
					if (Settings::Get('system.awstats_enabled') == '1') {
						$statsapp = 'awstats';
					} else {
						$statsapp = 'webalizer';
					}
					eval("\$domains.=\"" . getTemplate("domains/domains_delimiter") . "\";");
				}
				
				if ($paging->sortfield == 'd.domain' && $paging->sortorder == 'asc') {
					ksort($domain_array);
				} elseif ($paging->sortfield == 'd.domain' && $paging->sortorder == 'desc') {
					krsort($domain_array);
				}
				
				foreach ($domain_array as $row) {
					if (strpos($row['documentroot'], $userinfo['documentroot']) === 0) {
						$row['documentroot'] = makeCorrectDir(str_replace($userinfo['documentroot'], "/", $row['documentroot']));
					}
					
					// get ssl-ips if activated
					$show_ssledit = false;
					if (Settings::Get('system.use_ssl') == '1' && domainHasSslIpPort($row['id']) && $row['caneditdomain'] == '1' && $row['letsencrypt'] == 0) {
						$show_ssledit = true;
					}
					$row = htmlentities_array($row);
					eval("\$domains.=\"" . getTemplate("domains/domains_domain") . "\";");
				}
			}
			
			$i+= count($domain_array);
		}
		
		eval("echo \"" . getTemplate("domains/domainlist") . "\";");
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = SubDomains::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		
		$alias_stmt = Database::prepare("SELECT COUNT(`id`) AS `count` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `aliasdomain` = :aliasdomain");
		$alias_check = Database::pexecute_first($alias_stmt, array("aliasdomain" => $id));
		
		if (isset($result['parentdomainid']) && $result['parentdomainid'] != '0' && $alias_check['count'] == 0) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					SubDomains::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				ask_yesno('domains_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $idna_convert->decode($result['domain']));
			}
		} else {
			standard_error('domains_cantdeletemaindomain');
		}
	} elseif ($action == 'add') {
		if ($userinfo['subdomains_used'] < $userinfo['subdomains'] || $userinfo['subdomains'] == '-1') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					SubDomains::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				$stmt = Database::prepare("SELECT `id`, `domain`, `documentroot`, `ssl_redirect`,`isemaildomain`,`letsencrypt` FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `customerid` = :customerid
					AND `parentdomainid` = '0'
					AND `email_only` = '0'
					AND `caneditdomain` = '1'
					ORDER BY `domain` ASC"
					);
				Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));
				$domains = '';
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains .= makeoption($idna_convert->decode($row['domain']), $row['domain']);
				}
				
				$aliasdomains = makeoption($lng['domains']['noaliasdomain'], 0, NULL, true);
				$domains_stmt = Database::prepare("SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL
					AND `d`.`id` <> `c`.`standardsubdomain`
					AND `d`.`parentdomainid` = '0'
					AND `d`.`customerid`=`c`.`customerid`
					AND `d`.`email_only`='0'
					AND `d`.`customerid`= :customerid
					ORDER BY `d`.`domain` ASC"
					);
				Database::pexecute($domains_stmt, array("customerid" => $userinfo['customerid']));
				
				while ($row_domain = $domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$aliasdomains .= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id']);
				}
				
				$redirectcode = '';
				if (Settings::Get('customredirect.enabled') == '1') {
					$codes = getRedirectCodesArray();
					foreach ($codes as $rc) {
						$redirectcode .= makeoption($rc['code']. ' ('.$lng['redirect_desc'][$rc['desc']].')', $rc['id']);
					}
				}
				
				// check if we at least have one ssl-ip/port, #1179
				$ssl_ipsandports = '';
				$ssl_ip_stmt = Database::prepare("
					SELECT COUNT(*) as countSSL
					FROM `".TABLE_PANEL_IPSANDPORTS."` pip
					LEFT JOIN `".TABLE_DOMAINTOIP."` dti ON dti.id_ipandports = pip.id
					WHERE pip.`ssl`='1'
				");
				Database::pexecute($ssl_ip_stmt);
				$resultX = $ssl_ip_stmt->fetch(PDO::FETCH_ASSOC);
				if (isset($resultX['countSSL']) && (int)$resultX['countSSL'] > 0) {
					$ssl_ipsandports = 'notempty';
				}
				
				$openbasedir = makeoption($lng['domain']['docroot'], 0, NULL, true) . makeoption($lng['domain']['homedir'], 1, NULL, true);
				$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);
				
				$phpconfigs = '';
				$has_phpconfigs = false;
				if (isset($userinfo['allowed_phpconfigs']) && !empty($userinfo['allowed_phpconfigs']))
				{
					$has_phpconfigs = true;
					$allowed_cfg = json_decode($userinfo['allowed_phpconfigs'], JSON_OBJECT_AS_ARRAY);
					$phpconfigs_result_stmt = Database::query("
						SELECT c.*, fc.description as interpreter
						FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
						LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
						WHERE c.id IN (".implode(", ", $allowed_cfg).")
					");
					while ($phpconfigs_row = $phpconfigs_result_stmt->fetch(PDO::FETCH_ASSOC)) {
						if ((int) Settings::Get('phpfpm.enabled') == 1) {
							$phpconfigs .= makeoption($phpconfigs_row['description'] . " [".$phpconfigs_row['interpreter']."]", $phpconfigs_row['id'], Settings::Get('phpfpm.defaultini'), true, true);
						} else {
							$phpconfigs .= makeoption($phpconfigs_row['description'], $phpconfigs_row['id'], Settings::Get('system.mod_fcgid_defaultini'), true, true);
						}
					}
				}
				
				$subdomain_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/domains/formfield.domains_add.php';
				$subdomain_add_form = htmlform::genHTMLForm($subdomain_add_data);
				
				$title = $subdomain_add_data['domain_add']['title'];
				$image = $subdomain_add_data['domain_add']['image'];
				
				eval("echo \"" . getTemplate("domains/domains_add") . "\";");
			}
		}
	} elseif ($action == 'edit' && $id != 0) {
		
		try {
			$json_result = SubDomains::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		
		if (isset($result['customerid']) && $result['customerid'] == $userinfo['customerid']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					SubDomains::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array('page' => $page, 's' => $s));
			} else {
				$result['domain'] = $idna_convert->decode($result['domain']);
				
				$domains = makeoption($lng['domains']['noaliasdomain'], 0, $result['aliasdomain'], true);
				// also check ip/port combination to be the same, #176
				$domains_stmt = Database::prepare("SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d` , `" . TABLE_PANEL_CUSTOMERS . "` `c` , `".TABLE_DOMAINTOIP."` `dip`
					WHERE `d`.`aliasdomain` IS NULL
					AND `d`.`id` <> :id
					AND `c`.`standardsubdomain` <> `d`.`id`
					AND `d`.`parentdomainid` = '0'
					AND `d`.`customerid` = :customerid
					AND `c`.`customerid` = `d`.`customerid`
					AND `d`.`id` = `dip`.`id_domain`
					AND `dip`.`id_ipandports`
					IN (SELECT `id_ipandports` FROM `".TABLE_DOMAINTOIP."`
						WHERE `id_domain` = :id)
					GROUP BY `d`.`id`, `d`.`domain`
					ORDER BY `d`.`domain` ASC"
					);
				Database::pexecute($domains_stmt, array("id" => $result['id'], "customerid" => $userinfo['customerid']));
				
				while ($row_domain = $domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains .= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['aliasdomain']);
				}
				
				if (preg_match('/^https?\:\/\//', $result['documentroot']) && validateUrl($result['documentroot'])) {
					if (Settings::Get('panel.pathedit') == 'Dropdown') {
						$urlvalue = $result['documentroot'];
						$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);
					} else {
						$urlvalue = '';
						$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $result['documentroot'], true);
					}
				} else {
					$urlvalue = '';
					$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $result['documentroot']);
				}
				
				$redirectcode = '';
				if (Settings::Get('customredirect.enabled') == '1') {
					$def_code = getDomainRedirectId($id);
					$codes = getRedirectCodesArray();
					foreach ($codes as $rc) {
						$redirectcode .= makeoption($rc['code']. ' ('.$lng['redirect_desc'][$rc['desc']].')', $rc['id'], $def_code);
					}
				}
				
				// check if we at least have one ssl-ip/port, #1179
				$ssl_ipsandports = '';
				$ssl_ip_stmt = Database::prepare("
					SELECT COUNT(*) as countSSL
					FROM `".TABLE_PANEL_IPSANDPORTS."` pip
					LEFT JOIN `".TABLE_DOMAINTOIP."` dti ON dti.id_ipandports = pip.id
					WHERE `dti`.`id_domain` = :id_domain AND pip.`ssl`='1'
				");
				Database::pexecute($ssl_ip_stmt, array("id_domain" => $result['id']));
				$resultX = $ssl_ip_stmt->fetch(PDO::FETCH_ASSOC);
				if (isset($resultX['countSSL']) && (int)$resultX['countSSL'] > 0) {
					$ssl_ipsandports = 'notempty';
				}
				
				// Fudge the result for ssl_redirect to hide the Let's Encrypt steps
				$result['temporary_ssl_redirect'] = $result['ssl_redirect'];
				$result['ssl_redirect'] = ($result['ssl_redirect'] == 0 ? 0 : 1);
				
				$openbasedir = makeoption($lng['domain']['docroot'], 0, $result['openbasedir_path'], true) . makeoption($lng['domain']['homedir'], 1, $result['openbasedir_path'], true);
				
				// create serveralias options
				$serveraliasoptions = "";
				$_value = '2';
				if ($result['iswildcarddomain'] == '1') {
					$_value = '0';
				} elseif ($result['wwwserveralias'] == '1') {
					$_value = '1';
				}
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_wildcard'], '0', $_value, true, true);
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_www'], '1', $_value, true, true);
				$serveraliasoptions .= makeoption($lng['domains']['serveraliasoption_none'], '2', $_value, true, true);
				
				$ips_stmt = Database::prepare("SELECT `p`.`ip` AS `ip` FROM `".TABLE_PANEL_IPSANDPORTS."` `p`
					LEFT JOIN `".TABLE_DOMAINTOIP."` `dip`
					ON ( `dip`.`id_ipandports` = `p`.`id` )
					WHERE `dip`.`id_domain` = :id_domain
					GROUP BY `p`.`ip`"
					);
				Database::pexecute($ips_stmt, array("id_domain" => $result['id']));
				$result_ipandport['ip'] = '';
				while ($rowip = $ips_stmt->fetch(PDO::FETCH_ASSOC)) {
					$result_ipandport['ip'] .= $rowip['ip'] . "<br />";
				}
				
				$phpconfigs = '';
				$has_phpconfigs = false;
				if (isset($userinfo['allowed_phpconfigs']) && !empty($userinfo['allowed_phpconfigs']))
				{
					$has_phpconfigs = true;
					$allowed_cfg = json_decode($userinfo['allowed_phpconfigs'], JSON_OBJECT_AS_ARRAY);
					$phpconfigs_result_stmt = Database::query("
						SELECT c.*, fc.description as interpreter
						FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
						LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
						WHERE c.id IN (".implode(", ", $allowed_cfg).")
					");
					while ($phpconfigs_row = $phpconfigs_result_stmt->fetch(PDO::FETCH_ASSOC)) {
						if ((int) Settings::Get('phpfpm.enabled') == 1) {
							$phpconfigs .= makeoption($phpconfigs_row['description'] . " [".$phpconfigs_row['interpreter']."]", $phpconfigs_row['id'], $result['phpsettingid'], true, true);
						} else {
							$phpconfigs .= makeoption($phpconfigs_row['description'], $phpconfigs_row['id'], $result['phpsettingid'], true, true);
						}
					}
				}
				
				$domainip = $result_ipandport['ip'];
				$result = htmlentities_array($result);
				
				$subdomain_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/domains/formfield.domains_edit.php';
				$subdomain_edit_form = htmlform::genHTMLForm($subdomain_edit_data);
				
				$title = $subdomain_edit_data['domain_edit']['title'];
				$image = $subdomain_edit_data['domain_edit']['image'];
				
				eval("echo \"" . getTemplate("domains/domains_edit") . "\";");
			}
		} else {
			standard_error('domains_canteditdomain');
		}
	}
} elseif ($page == 'domainssleditor') {
	
	if ($action == '' || $action == 'view') {
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			$do_insert = isset($_POST['do_insert']) ? (($_POST['do_insert'] == 1) ? true : false) : false;
			try {
				if ($do_insert) {
					Certificates::getLocal($userinfo, $_POST)->add();
				} else {
					Certificates::getLocal($userinfo, $_POST)->update();
				}
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			// back to domain overview
			redirectTo($filename, array('page' => 'domains', 's' => $s));
		}
		
		$stmt = Database::prepare("SELECT * FROM `".TABLE_PANEL_DOMAIN_SSL_SETTINGS."`
			WHERE `domainid`= :domainid"
			);
		$result = Database::pexecute_first($stmt, array("domainid" => $id));
		
		$do_insert = false;
		// if no entry can be found, behave like we have empty values
		if (!is_array($result) || !isset($result['ssl_cert_file'])) {
			$result = array(
				'ssl_cert_file' => '',
				'ssl_key_file' => '',
				'ssl_ca_file' => '',
				'ssl_cert_chainfile' => ''
			);
			$do_insert = true;
		}
		
		$result = htmlentities_array($result);
		
		$ssleditor_data = include_once dirname(__FILE__).'/lib/formfields/customer/domains/formfield.domain_ssleditor.php';
		$ssleditor_form = htmlform::genHTMLForm($ssleditor_data);
		
		$title = $ssleditor_data['domain_ssleditor']['title'];
		$image = $ssleditor_data['domain_ssleditor']['image'];
		
		eval("echo \"" . getTemplate("domains/domain_ssleditor") . "\";");
	}
} elseif ($page == 'domaindnseditor' && $userinfo['dnsenabled'] == '1' && Settings::Get('system.dnsenabled') == '1') {
	
	require_once __DIR__.'/dns_editor.php';
	
} elseif ($page == 'sslcertificates') {
	
	require_once __DIR__.'/ssl_certificates.php';
	
} elseif ($page == 'logfiles') {

	require_once __DIR__.'/logfiles_viewer.php';
}
