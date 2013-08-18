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

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

if($page == 'overview')
{
	$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_domains");
	eval("echo \"" . getTemplate("domains/domains") . "\";");
}
elseif($page == 'domains')
{
	if($action == '')
	{
		$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_domains::domains");
		$fields = array(
			'd.domain' => $lng['domains']['domainname'],
			'd.documentroot' => $lng['panel']['path'],
			'd.aliasdomain' => $lng['domains']['aliasdomain']
		);
		$paging = new paging($userinfo, $db, TABLE_PANEL_DOMAINS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$result = $db->query("SELECT `d`.`id`, `d`.`customerid`, `d`.`domain`, `d`.`documentroot`, `d`.`isemaildomain`, `d`.`caneditdomain`, `d`.`iswildcarddomain`, `d`.`parentdomainid`, `d`.`ssl_ipandport`, `ad`.`id` AS `aliasdomainid`, `ad`.`domain` AS `aliasdomain`, `da`.`id` AS `domainaliasid`, `da`.`domain` AS `domainalias` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `ad` ON `d`.`aliasdomain`=`ad`.`id` LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `da` ON `da`.`aliasdomain`=`d`.`id` WHERE `d`.`customerid`='" . (int)$userinfo['customerid'] . "' AND `d`.`email_only`='0' AND `d`.`id` <> " . (int)$userinfo['standardsubdomain'] . " " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		$paging->setEntries($db->num_rows($result));
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$domains = '';
		$parentdomains_count = 0;
		$domains_count = 0;
		$domain_array = array();

		while($row = $db->fetch_array($result))
		{
			$row['domain'] = $idna_convert->decode($row['domain']);
			$row['aliasdomain'] = $idna_convert->decode($row['aliasdomain']);
			$row['domainalias'] = $idna_convert->decode($row['domainalias']);

			if($row['parentdomainid'] == '0'
			   && $row['caneditdomain'] == '1')
			{
				$parentdomains_count++;
			}

			$domains_count++;
/*
			$domainparts = explode('.', $row['domain']);
			$domainparts = array_reverse($domainparts);
			$sortkey = '';
			foreach($domainparts as $key => $part)
			{
				$sortkey.= $part . '.';
			}
			$domain_array[$sortkey] = $row;
*/
			$domain_array[$row['domain']] = $row;
		}

		ksort($domain_array);
		$domain_id_array = array();
		foreach($domain_array as $sortkey => $row)
		{
			$domain_id_array[$row['id']] = $sortkey;
		}

		$domain_sort_array = array();
		foreach($domain_array as $sortkey => $row)
		{
			if($row['parentdomainid'] == 0)
			{
				$domain_sort_array[$sortkey][$sortkey] = $row;
			}
			else
			{
				$domain_sort_array[$domain_id_array[$row['parentdomainid']]][$sortkey] = $row;
			}
		}

		$domain_array = array();

		if($paging->sortfield == 'd.domain'
		   && $paging->sortorder == 'asc')
		{
			ksort($domain_sort_array);
		}
		elseif($paging->sortfield == 'd.domain'
		       && $paging->sortorder == 'desc')
		{
			krsort($domain_sort_array);
		}

		$i = 0;
		foreach($domain_sort_array as $sortkey => $domain_array)
		{
			if($paging->checkDisplay($i))
			{
				$row = htmlentities_array($domain_array[$sortkey]);
				if($settings['system']['awstats_enabled'] == '1') {
					$statsapp = 'awstats';
				} else {
					$statsapp = 'webalizer';
				}
				eval("\$domains.=\"" . getTemplate("domains/domains_delimiter") . "\";");

				if($paging->sortfield == 'd.domain'
				   && $paging->sortorder == 'asc')
				{
					ksort($domain_array);
				}
				elseif($paging->sortfield == 'd.domain'
				       && $paging->sortorder == 'desc')
				{
					krsort($domain_array);
				}

				foreach($domain_array as $row)
				{
					if(strpos($row['documentroot'], $userinfo['documentroot']) === 0)
					{
						$row['documentroot'] = makeCorrectDir(substr($row['documentroot'], strlen($userinfo['documentroot'])));
					}

					// get ssl-ips if activated
					// FIXME for multi-ip later
					$show_ssledit = false;
					if ($settings['system']['use_ssl'] == '1'
							&& $row['ssl_ipandport'] != 0
							&& $row['caneditdomain'] == '1'
					) {
						$show_ssledit = true;
					}
					$row = htmlentities_array($row);
					eval("\$domains.=\"" . getTemplate("domains/domains_domain") . "\";");
				}
			}

			$i+= count($domain_array);
		}

		eval("echo \"" . getTemplate("domains/domainlist") . "\";");
	}
	elseif($action == 'delete'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT `id`, `customerid`, `domain`, `documentroot`, `isemaildomain`, `parentdomainid` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `id`='" . (int)$id . "'");
		$alias_check = $db->query_first('SELECT COUNT(`id`) AS `count` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `aliasdomain`=\'' . (int)$id . '\'');

		if(isset($result['parentdomainid'])
		   && $result['parentdomainid'] != '0'
		   && $alias_check['count'] == 0)
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				if($result['isemaildomain'] == '1')
				{
					$emails = $db->query_first('SELECT COUNT(`id`) AS `count` FROM `' . TABLE_MAIL_VIRTUAL . '` WHERE `customerid`=\'' . (int)$userinfo['customerid'] . '\' AND `domainid`=\'' . (int)$id . '\'');

					if($emails['count'] != '0')
					{
						standard_error('domains_cantdeletedomainwithemail');
					}
				}

				/*
				 * check for APS packages used with this domain, #110
				 */
				if(domainHasApsInstances($id))
				{
					standard_error('domains_cantdeletedomainwithapsinstances');
				}

				$log->logAction(USR_ACTION, LOG_INFO, "deleted subdomain '" . $idna_convert->decode($result['domain']) . "'");
				$result = $db->query("DELETE FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `id`='" . (int)$id . "'");
				$result = $db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `subdomains_used`=`subdomains_used`-1 WHERE `customerid`='" . (int)$userinfo['customerid'] . "'");
				inserttask('1');

				// Using nameserver, insert a task which rebuilds the server config
				inserttask('4');

				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				ask_yesno('domains_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $idna_convert->decode($result['domain']));
			}
		}
		else
		{
			standard_error('domains_cantdeletemaindomain');
		}
	}
	elseif($action == 'add')
	{
		if($userinfo['subdomains_used'] < $userinfo['subdomains']
		   || $userinfo['subdomains'] == '-1')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$subdomain = $idna_convert->encode(preg_replace(Array('/\:(\d)+$/', '/^https?\:\/\//'), '', validate($_POST['subdomain'], 'subdomain', '', 'subdomainiswrong')));
				$domain = $idna_convert->encode($_POST['domain']);
				$domain_check = $db->query_first("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `domain`='" . $db->escape($domain) . "' AND `customerid`='" . (int)$userinfo['customerid'] . "' AND `parentdomainid`='0' AND `email_only`='0' AND `caneditdomain`='1' ");
				$completedomain = $subdomain . '.' . $domain;
				$completedomain_check = $db->query_first("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `domain`='" . $db->escape($completedomain) . "' AND `customerid`='" . (int)$userinfo['customerid'] . "' AND `email_only`='0' AND `caneditdomain` = '1'");
				$aliasdomain = intval($_POST['alias']);
				$aliasdomain_check = array(
					'id' => 0
				);
				$_doredirect = false;

				if($aliasdomain != 0)
				{
					// also check ip/port combination to be the same, #176
					$aliasdomain_check = $db->query_first('SELECT `id` FROM `' . TABLE_PANEL_DOMAINS . '` `d`,`' . TABLE_PANEL_CUSTOMERS . '` `c` WHERE `d`.`customerid`=\'' . (int)$userinfo['customerid'] . '\' AND `d`.`aliasdomain` IS NULL AND `d`.`id`<>`c`.`standardsubdomain` AND `c`.`customerid`=\'' . (int)$userinfo['customerid'] . '\' AND `d`.`id`=\'' . (int)$aliasdomain . '\' AND `d`.`ipandport` = \''.(int)$domain_check['ipandport'].'\'');
				}

				if(isset($_POST['url'])
				   && $_POST['url'] != ''
				   && validateUrl($idna_convert->encode($_POST['url'])))
				{
					$path = $_POST['url'];
					$_doredirect = true;
				}
				else
				{
					$path = validate($_POST['path'], 'path');
				}

				if(!preg_match('/^https?\:\/\//', $path)
				   || !validateUrl($idna_convert->encode($path)))
				{
					// If path is empty or '/' and 'Use domain name as default value for DocumentRoot path' is enabled in settings,
					// set default path to subdomain or domain name
					if((($path == '') || ($path == '/'))
						&& $settings['system']['documentroot_use_default_value'] == 1)
					{
						$path = makeCorrectDir($userinfo['documentroot'] . '/' . $completedomain);
					}
					else
					{
						$path = makeCorrectDir($userinfo['documentroot'] . '/' . $path);
					}
					if (strstr($path, ":") !== FALSE)
					{
						standard_error('pathmaynotcontaincolon');
					}
				}
				else
				{
					$_doredirect = true;
				}

				if(isset($_POST['openbasedir_path'])
				   && $_POST['openbasedir_path'] == '1')
				{
					$openbasedir_path = '1';
				}
				else
				{
					$openbasedir_path = '0';
				}

				if(isset($_POST['ssl_redirect'])
				   && $_POST['ssl_redirect'] == '1')
				{
					$ssl_redirect = '1';
				}
				else
				{
					$ssl_redirect = '0';
				}

				if($path == '')
				{
					standard_error('patherror');
				}
				elseif($subdomain == '')
				{
					standard_error(array('stringisempty', 'domainname'));
				}
				elseif($subdomain == 'www' && $domain_check['wwwserveralias'] == '1')
				{
					standard_error('wwwnotallowed');
				}
				elseif($domain == '')
				{
					standard_error('domaincantbeempty');
				}
				elseif(strtolower($completedomain_check['domain']) == strtolower($completedomain))
				{
					standard_error('domainexistalready', $completedomain);
				}
				elseif(strtolower($domain_check['domain']) != strtolower($domain))
				{
					standard_error('maindomainnonexist', $domain);
				}
				elseif($aliasdomain_check['id'] != $aliasdomain)
				{
					standard_error('domainisaliasorothercustomer');
				}
				else
				{
					// get the phpsettingid from parentdomain, #107
					$phpsid_result = $db->query_first("SELECT `phpsettingid` FROM `".TABLE_PANEL_DOMAINS."` WHERE `id` = '".(int)$domain_check['id']."'");
					if(!isset($phpsid_result['phpsettingid'])
						|| (int)$phpsid_result['phpsettingid'] <= 0
					) {
						// assign default config
						$phpsid_result['phpsettingid'] = 1;
					}

					$result = $db->query("INSERT INTO `" . TABLE_PANEL_DOMAINS . "` SET 
								`customerid` = '" . (int)$userinfo['customerid'] . "',
								`domain` = '" . $db->escape($completedomain) . "', 
								`documentroot` = '" . $db->escape($path) . "', 
								`ipandport` = '" . $db->escape($domain_check['ipandport']) . "', 
								`aliasdomain` = ".(($aliasdomain != 0) ? "'" . $db->escape($aliasdomain) . "'" : "NULL") .", 
								`parentdomainid` = '" . (int)$domain_check['id'] . "', 
								`isemaildomain` = '" . ($domain_check['subcanemaildomain'] == '3' ? '1' : '0') . "', 
								`openbasedir` = '" . $db->escape($domain_check['openbasedir']) . "', 
								`openbasedir_path` = '" . $db->escape($openbasedir_path) . "',
								`speciallogfile` = '" . $db->escape($domain_check['speciallogfile']) . "', 
								`specialsettings` = '" . $db->escape($domain_check['specialsettings']) . "', 
								`ssl_redirect` = '" . $ssl_redirect . "', 
								`phpsettingid` = '" . $phpsid_result['phpsettingid'] . "'");

					if($_doredirect)
					{
						$did = $db->insert_id();
						$redirect = isset($_POST['redirectcode']) ? (int)$_POST['redirectcode'] : $settings['customredirect']['default'];
						addRedirectToDomain($did, $redirect);
					}

					$result = $db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `subdomains_used`=`subdomains_used`+1 WHERE `customerid`='" . (int)$userinfo['customerid'] . "'");
					$log->logAction(USR_ACTION, LOG_INFO, "added subdomain '" . $completedomain . "'");
					inserttask('1');

					// Using nameserver, insert a task which rebuilds the server config
					inserttask('4');

					redirectTo($filename, Array('page' => $page, 's' => $s));
				}
			}
			else
			{
				$result = $db->query("SELECT `id`, `domain`, `documentroot`, `ssl_redirect`,`isemaildomain` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `parentdomainid`='0' AND `email_only`='0' AND `caneditdomain`='1' ORDER BY `domain` ASC");
				$domains = '';

				while($row = $db->fetch_array($result))
				{
					$domains.= makeoption($idna_convert->decode($row['domain']), $row['domain']);
				}

				$aliasdomains = makeoption($lng['domains']['noaliasdomain'], 0, NULL, true);
				$result_domains = $db->query("SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c` WHERE `d`.`aliasdomain` IS NULL AND `d`.`id` <> `c`.`standardsubdomain` AND `d`.`customerid`=`c`.`customerid` AND `d`.`email_only`='0' AND `d`.`customerid`=" . (int)$userinfo['customerid'] . " ORDER BY `d`.`domain` ASC");

				while($row_domain = $db->fetch_array($result_domains))
				{
					$aliasdomains.= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id']);
				}

				$redirectcode = '';
				if($settings['customredirect']['enabled'] == '1')
				{
					$codes = getRedirectCodesArray();
					foreach($codes as $rc)
					{
						$redirectcode .= makeoption($rc['code']. ' ('.$lng['redirect_desc'][$rc['desc']].')', $rc['id'], $settings['customredirect']['default']);
					}
				}

				// check if we at least have one ssl-ip/port, #1179
				$ssl_ipsandports = '';
				$resultX = $db->query_first("SELECT COUNT(*) as countSSL FROM `panel_ipsandports` WHERE `ssl`='1'");
				if (isset($resultX['countSSL']) && (int)$resultX['countSSL'] > 0) {
					$ssl_ipsandports = 'notempty';
				}

				$openbasedir = makeoption($lng['domain']['docroot'], 0, NULL, true) . makeoption($lng['domain']['homedir'], 1, NULL, true);
				$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $settings['panel']['pathedit']);

				$subdomain_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/domains/formfield.domains_add.php';
				$subdomain_add_form = htmlform::genHTMLForm($subdomain_add_data);

				$title = $subdomain_add_data['domain_add']['title'];
				$image = $subdomain_add_data['domain_add']['image'];

				eval("echo \"" . getTemplate("domains/domains_add") . "\";");
			}
		}
	}
	elseif($action == 'edit'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT `d`.`id`, `d`.`customerid`, `d`.`domain`, `d`.`documentroot`, `d`.`isemaildomain`, `d`.`iswildcarddomain`, `d`.`parentdomainid`, `d`.`ssl_redirect`, `d`.`aliasdomain`, `d`.`openbasedir`, `d`.`openbasedir_path`, `d`.`ipandport`, `pd`.`subcanemaildomain` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_DOMAINS . "` `pd` WHERE `d`.`customerid`='" . (int)$userinfo['customerid'] . "' AND `d`.`id`='" . (int)$id . "' AND ((`d`.`parentdomainid`!='0' AND `pd`.`id`=`d`.`parentdomainid`) OR (`d`.`parentdomainid`='0' AND `pd`.`id`=`d`.`id`)) AND `d`.`caneditdomain`='1'");
		$alias_check = $db->query_first('SELECT COUNT(`id`) AS count FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `aliasdomain`=\'' . (int)$result['id'] . '\'');
		$alias_check = $alias_check['count'];
		$_doredirect = false;

		if(isset($result['customerid'])
		   && $result['customerid'] == $userinfo['customerid'])
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				if(isset($_POST['url'])
				   && $_POST['url'] != ''
				   && validateUrl($idna_convert->encode($_POST['url'])))
				{
					$path = $_POST['url'];
					$_doredirect = true;
				}
				else
				{
					$path = validate($_POST['path'], 'path');
				}

				if(!preg_match('/^https?\:\/\//', $path)
				   || !validateUrl($idna_convert->encode($path)))
				{
					// If path is empty or '/' and 'Use domain name as default value for DocumentRoot path' is enabled in settings,
					// set default path to subdomain or domain name
					if((($path == '') || ($path == '/'))
						&& $settings['system']['documentroot_use_default_value'] == 1)
					{
						$path = makeCorrectDir($userinfo['documentroot'] . '/' . $result['domain']);
					}
					else
					{
						$path = makeCorrectDir($userinfo['documentroot'] . '/' . $path);
					}
					if (strstr($path, ":") !== FALSE)
					{
						standard_error('pathmaynotcontaincolon');
					}
				}
				else
				{
					$_doredirect = true;
				}

				$aliasdomain = intval($_POST['alias']);

				if(isset($_POST['iswildcarddomain'])
				   && $_POST['iswildcarddomain'] == '1'
				   && $result['parentdomainid'] == '0'
				){
					$iswildcarddomain = '1';
				}
				else
				{
					$iswildcarddomain = '0';
				}

				if($result['parentdomainid'] != '0'
				   && ($result['subcanemaildomain'] == '1' || $result['subcanemaildomain'] == '2')
				   && isset($_POST['isemaildomain']))
				{
					$isemaildomain = intval($_POST['isemaildomain']);
				}
				else
				{
					$isemaildomain = $result['isemaildomain'];
				}

				$aliasdomain_check = array(
					'id' => 0
				);

				if($aliasdomain != 0)
				{
					$aliasdomain_check = $db->query_first('SELECT `id` FROM `' . TABLE_PANEL_DOMAINS . '` `d`,`' . TABLE_PANEL_CUSTOMERS . '` `c` WHERE `d`.`customerid`=\'' . (int)$result['customerid'] . '\' AND `d`.`aliasdomain` IS NULL AND `d`.`id`<>`c`.`standardsubdomain` AND `c`.`customerid`=\'' . (int)$result['customerid'] . '\' AND `d`.`id`=\'' . (int)$aliasdomain . '\'');
				}

				if($aliasdomain_check['id'] != $aliasdomain)
				{
					standard_error('domainisaliasorothercustomer');
				}

				if(isset($_POST['openbasedir_path'])
				   && $_POST['openbasedir_path'] == '1')
				{
					$openbasedir_path = '1';
				}
				else
				{
					$openbasedir_path = '0';
				}

				if(isset($_POST['ssl_redirect'])
				   && $_POST['ssl_redirect'] == '1')
				{
					$ssl_redirect = '1';
				}
				else
				{
					$ssl_redirect = '0';
				}

				if($path == '')
				{
					standard_error('patherror');
				}
				else
				{
					if(($result['isemaildomain'] == '1')
					   && ($isemaildomain == '0'))
					{
						$db->query("DELETE FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `domainid`='" . (int)$id . "'");
						$db->query("DELETE FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `domainid`='" . (int)$id . "'");
						$log->logAction(USR_ACTION, LOG_NOTICE, "automatically deleted mail-table entries for '" . $idna_convert->decode($result['domain']) . "'");
					}

					if($_doredirect)
					{
						$redirect = isset($_POST['redirectcode']) ? (int)$_POST['redirectcode'] : false;
						updateRedirectOfDomain($id, $redirect);
					}

					if($path != $result['documentroot']
					   || $isemaildomain != $result['isemaildomain']
					   || $iswildcarddomain != $result['iswildcarddomain']
					   || $aliasdomain != $result['aliasdomain']
					   || $openbasedir_path != $result['openbasedir_path']
					   || $ssl_redirect != $result['ssl_redirect'])
					{
						$log->logAction(USR_ACTION, LOG_INFO, "edited domain '" . $idna_convert->decode($result['domain']) . "'");
						$result = $db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `documentroot`='" . $db->escape($path) . "', `isemaildomain`='" . (int)$isemaildomain . "', `iswildcarddomain`='" . (int)$iswildcarddomain . "', `aliasdomain`=" . (($aliasdomain != 0 && $alias_check == 0) ? '\'' . $db->escape($aliasdomain) . '\'' : 'NULL') . ",`openbasedir_path`='" . $db->escape($openbasedir_path) . "', `ssl_redirect`='" . $ssl_redirect . "' WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `id`='" . (int)$id . "'");
						inserttask('1');

						// Using nameserver, insert a task which rebuilds the server config
						inserttask('4');

					}

					redirectTo($filename, Array('page' => $page, 's' => $s));
				}
			}
			else
			{
				$result['domain'] = $idna_convert->decode($result['domain']);
				$domains = makeoption($lng['domains']['noaliasdomain'], 0, $result['aliasdomain'], true);
				// also check ip/port combination to be the same, #176
				$result_domains = $db->query("SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c` WHERE `d`.`aliasdomain` IS NULL AND `d`.`id`<>'" . (int)$result['id'] . "' AND `c`.`standardsubdomain`<>`d`.`id` AND `d`.`customerid`='" . (int)$userinfo['customerid'] . "' AND `c`.`customerid`=`d`.`customerid` AND `d`.`ipandport` = '".(int)$result['ipandport']."' ORDER BY `d`.`domain` ASC");

				while($row_domain = $db->fetch_array($result_domains))
				{
					$domains.= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['aliasdomain']);
				}

				if(preg_match('/^https?\:\/\//', $result['documentroot'])
				   && validateUrl($idna_convert->encode($result['documentroot']))
				) {
					if($settings['panel']['pathedit'] == 'Dropdown')
					{
						$urlvalue = $result['documentroot'];
						$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $settings['panel']['pathedit']);
					}
					else
					{
						$urlvalue = '';
						$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $settings['panel']['pathedit'], $result['documentroot'], true);						
					}
				}
				else
				{
					$urlvalue = '';
					$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $settings['panel']['pathedit'], $result['documentroot']);
				}

				$redirectcode = '';
				if($settings['customredirect']['enabled'] == '1')
				{
					$def_code = getDomainRedirectId($id);
					$codes = getRedirectCodesArray();
					foreach($codes as $rc)
					{
						$redirectcode .= makeoption($rc['code']. ' ('.$lng['redirect_desc'][$rc['desc']].')', $rc['id'], $def_code);
					}
				}

				// check if we at least have one ssl-ip/port, #1179
				$ssl_ipsandports = '';
				$resultX = $db->query_first("SELECT COUNT(*) as countSSL FROM `panel_ipsandports` WHERE `ssl`='1'");
				if (isset($resultX['countSSL']) && (int)$resultX['countSSL'] > 0) {
					$ssl_ipsandports = 'notempty';
				}

				$openbasedir = makeoption($lng['domain']['docroot'], 0, $result['openbasedir_path'], true) . makeoption($lng['domain']['homedir'], 1, $result['openbasedir_path'], true);

				$result_ipandport = $db->query_first("SELECT `ip` FROM `".TABLE_PANEL_IPSANDPORTS."` WHERE `id`='".(int)$result['ipandport']."'");
				if(filter_var($result_ipandport['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
				{
					$result_ipandport['ip'] = '[' . $result_ipandport['ip'] . ']';
				}
				$domainip = $result_ipandport['ip'];
				$result = htmlentities_array($result);

				$subdomain_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/domains/formfield.domains_edit.php';
				$subdomain_edit_form = htmlform::genHTMLForm($subdomain_edit_data);

				$title = $subdomain_edit_data['domain_edit']['title'];
				$image = $subdomain_edit_data['domain_edit']['image'];

				eval("echo \"" . getTemplate("domains/domains_edit") . "\";");
			}
		}
		else
		{
			standard_error('domains_canteditdomain');
		}
	}
}
elseif ($page == 'domainssleditor') {

	if ($action == ''
			|| $action == 'view'
	) {
		if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
		) {

			$ssl_cert_file = isset($_POST['ssl_cert_file']) ? $_POST['ssl_cert_file'] : '';
			$ssl_key_file = isset($_POST['ssl_key_file']) ? $_POST['ssl_key_file'] : '';
			$ssl_ca_file = isset($_POST['ssl_ca_file']) ? $_POST['ssl_ca_file'] : '';
			$ssl_cert_chainfile = isset($_POST['ssl_cert_chainfile']) ? $_POST['ssl_cert_chainfile'] : '';
			$do_insert = isset($_POST['do_insert']) ? (($_POST['do_insert'] == 1) ? true : false) : false;

			if ($ssl_cert_file != '' && $ssl_key_file == '') {
				standard_error('sslcertificateismissingprivatekey');
			}

			$do_verify = true;

			// no cert-file given -> forget everything
			if ($ssl_cert_file == '') {
				$ssl_key_file = '';
				$ssl_ca_file = '';
				$ssl_cert_chainfile = '';
				$do_verify = false;
			}

			// verify certificate content
			if ($do_verify) {
				// array openssl_x509_parse ( mixed $x509cert [, bool $shortnames = true ] )
				// openssl_x509_parse() returns information about the supplied x509cert, including fields such as 
				// subject name, issuer name, purposes, valid from and valid to dates etc.
				$cert_content = openssl_x509_parse($ssl_cert_file);

				if (is_array($cert_content)
						&& isset($cert_content['subject'])
						&& isset($cert_content['subject']['CN'])
				) {
					// TODO self-signed certs might differ and don't need/want this
					/*
					$domain = $db->query_first("SELECT * FROM `".TABLE_PANEL_DOMAINS."` WHERE `id`='".(int)$id."'");
					if (strtolower($cert_content['subject']['CN']) != strtolower($idna_convert->decode($domain['domain']))) {
						standard_error('sslcertificatewrongdomain');
					}
					*/

					// bool openssl_x509_check_private_key ( mixed $cert , mixed $key )
					// Checks whether the given key is the private key that corresponds to cert.
					if (openssl_x509_check_private_key($ssl_cert_file, $ssl_key_file) === false) {
						standard_error('sslcertificateinvalidcertkeypair');
					}

					// check optional stuff
					if ($ssl_ca_file != '') {
						$ca_content = openssl_x509_parse($ssl_ca_file);
						if (!is_array($ca_content)) {
							// invalid
							standard_error('sslcertificateinvalidca');
						}
					}
					if ($ssl_cert_chainfile != '') {
						$chain_content = openssl_x509_parse($ssl_cert_chainfile);
						if (!is_array($chain_content)) {
							// invalid
							standard_error('sslcertificateinvalidchain');
						}
					}
				} else {
					standard_error('sslcertificateinvalidcert');
				}
			}

			// Add/Update database entry
			$qrystart = "UPDATE ";
			$qrywhere = "WHERE ";
			if ($do_insert) {
				$qrystart = "INSERT INTO ";
				$qrywhere = ", ";
			}
			$db->query($qrystart." `".TABLE_PANEL_DOMAIN_SSL_SETTINGS."` SET
					`ssl_cert_file` = '".$db->escape($ssl_cert_file)."',
					`ssl_key_file` = '".$db->escape($ssl_key_file)."',
					`ssl_ca_file` = '".$db->escape($ssl_ca_file)."',
					`ssl_cert_chainfile` = '".$db->escape($ssl_cert_chainfile)."'
					".$qrywhere." `domainid`='".(int)$id."';"
			);

			// back to domain overview
			redirectTo($filename, array('page' => 'domains', 's' => $s));
		}

		$result = $db->query_first("SELECT * FROM `".TABLE_PANEL_DOMAIN_SSL_SETTINGS."`
			WHERE `domainid`='".(int)$id."';"
		);

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
}

