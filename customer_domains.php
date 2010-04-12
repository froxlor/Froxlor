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
 * @version    $Id$
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
		$result = $db->query("SELECT `d`.`id`, `d`.`customerid`, `d`.`domain`, `d`.`documentroot`, `d`.`isemaildomain`, `d`.`caneditdomain`, `d`.`iswildcarddomain`, `d`.`parentdomainid`, `ad`.`id` AS `aliasdomainid`, `ad`.`domain` AS `aliasdomain`, `da`.`id` AS `domainaliasid`, `da`.`domain` AS `domainalias` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `ad` ON `d`.`aliasdomain`=`ad`.`id` LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `da` ON `da`.`aliasdomain`=`d`.`id` WHERE `d`.`customerid`='" . (int)$userinfo['customerid'] . "' AND `d`.`email_only`='0' AND `d`.`id` <> " . (int)$userinfo['standardsubdomain'] . " " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
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
			   && $row['iswildcarddomain'] != '1'
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
				$domain_check = $db->query_first("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `domain`='" . $db->escape($domain) . "' AND `customerid`='" . (int)$userinfo['customerid'] . "' AND `parentdomainid`='0' AND `email_only`='0' AND `iswildcarddomain`='0' AND `caneditdomain`='1' ");
				$completedomain = $subdomain . '.' . $domain;
				$completedomain_check = $db->query_first("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `domain`='" . $db->escape($completedomain) . "' AND `customerid`='" . (int)$userinfo['customerid'] . "' AND `email_only`='0' AND `caneditdomain` = '1'");
				$aliasdomain = intval($_POST['alias']);
				$aliasdomain_check = array(
					'id' => 0
				);

				if($aliasdomain != 0)
				{
					$aliasdomain_check = $db->query_first('SELECT `id` FROM `' . TABLE_PANEL_DOMAINS . '` `d`,`' . TABLE_PANEL_CUSTOMERS . '` `c` WHERE `d`.`customerid`=\'' . (int)$userinfo['customerid'] . '\' AND `d`.`aliasdomain` IS NULL AND `d`.`id`<>`c`.`standardsubdomain` AND `c`.`customerid`=\'' . (int)$userinfo['customerid'] . '\' AND `d`.`id`=\'' . (int)$aliasdomain . '\'');
				}

				if(isset($_POST['url'])
				   && $_POST['url'] != ''
				   && validateUrl($idna_convert->encode($_POST['url'])))
				{
					$path = $_POST['url'];
				}
				else
				{
					$path = validate($_POST['path'], 'path');
				}

				if(!preg_match('/^https?\:\/\//', $path)
				   || !validateUrl($idna_convert->encode($path)))
				{
					$path = $userinfo['documentroot'] . '/' . $path;
					$path = makeCorrectDir($path);
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
								`safemode` = '" . $db->escape($domain_check['safemode']) . "', 
								`speciallogfile` = '" . $db->escape($domain_check['speciallogfile']) . "', 
								`specialsettings` = '" . $db->escape($domain_check['specialsettings']) . "', 
								`ssl_redirect` = '" . $ssl_redirect . "', 
								`phpsettingid` = '" . $phpsid_result['phpsettingid'] . "'");

					$result = $db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `subdomains_used`=`subdomains_used`+1 WHERE `customerid`='" . (int)$userinfo['customerid'] . "'");
					$log->logAction(USR_ACTION, LOG_INFO, "added subdomain '" . $completedomain . "'");
					inserttask('1');
					inserttask('4');
					redirectTo($filename, Array('page' => $page, 's' => $s));
				}
			}
			else
			{
				$result = $db->query("SELECT `id`, `domain`, `documentroot`, `ssl_redirect`,`isemaildomain` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid`='" . (int)$userinfo['customerid'] . "' AND `parentdomainid`='0' AND `email_only`='0' AND `iswildcarddomain`='0' AND `caneditdomain`='1' ORDER BY `domain` ASC");
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

				$ssl_redirect = makeyesno('ssl_redirect', '1', '0', $result['ssl_redirect']);
				$openbasedir = makeoption($lng['domain']['docroot'], 0, NULL, true) . makeoption($lng['domain']['homedir'], 1, NULL, true);
				$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $settings['panel']['pathedit']);
				eval("echo \"" . getTemplate("domains/domains_add") . "\";");
			}
		}
	}
	elseif($action == 'edit'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT `d`.`id`, `d`.`customerid`, `d`.`domain`, `d`.`documentroot`, `d`.`isemaildomain`, `d`.`iswildcarddomain`, `d`.`parentdomainid`, `d`.`ssl_redirect`, `d`.`aliasdomain`, `d`.`openbasedir_path` ,`pd`.`subcanemaildomain` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_DOMAINS . "` `pd` WHERE `d`.`customerid`='" . (int)$userinfo['customerid'] . "' AND `d`.`id`='" . (int)$id . "' AND ((`d`.`parentdomainid`!='0' AND `pd`.`id`=`d`.`parentdomainid`) OR (`d`.`parentdomainid`='0' AND `pd`.`id`=`d`.`id`)) AND `d`.`caneditdomain`='1'");
		$alias_check = $db->query_first('SELECT COUNT(`id`) AS count FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `aliasdomain`=\'' . (int)$result['id'] . '\'');
		$alias_check = $alias_check['count'];

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
				}
				else
				{
					$path = validate($_POST['path'], 'path');
				}

				if(!preg_match('/^https?\:\/\//', $path)
				   || !validateUrl($idna_convert->encode($path)))
				{
					$path = $userinfo['documentroot'] . '/' . $path;
					$path = makeCorrectDir($path);
				}

				$aliasdomain = intval($_POST['alias']);

				if(isset($_POST['iswildcarddomain'])
				   && $_POST['iswildcarddomain'] == '1'
				   && $result['parentdomainid'] == '0'
				   && $userinfo['subdomains'] != '0')
				{
					$wildcarddomaincheck = $db->query("SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `parentdomainid` = '" . (int)$result['id'] . "'");

					if($db->num_rows($wildcarddomaincheck) != '0')
					{
						standard_error('firstdeleteallsubdomains');
						exit;
					}

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
						inserttask('4');
					}

					redirectTo($filename, Array('page' => $page, 's' => $s));
				}
			}
			else
			{
				$result['domain'] = $idna_convert->decode($result['domain']);
				$domains = makeoption($lng['domains']['noaliasdomain'], 0, $result['aliasdomain'], true);
				$result_domains = $db->query("SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c` WHERE `d`.`aliasdomain` IS NULL AND `d`.`id`<>'" . (int)$result['id'] . "' AND `c`.`standardsubdomain`<>`d`.`id` AND `d`.`customerid`='" . (int)$userinfo['customerid'] . "' AND `c`.`customerid`=`d`.`customerid` ORDER BY `d`.`domain` ASC");

				while($row_domain = $db->fetch_array($result_domains))
				{
					$domains.= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['aliasdomain']);
				}

				if(preg_match('/^https?\:\/\//', $result['documentroot'])
				   && validateUrl($idna_convert->encode($result['documentroot']))
				   && $settings['panel']['pathedit'] == 'Dropdown')
				{
					$urlvalue = $result['documentroot'];
					$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $settings['panel']['pathedit']);
				}
				else
				{
					$urlvalue = '';
					$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $settings['panel']['pathedit'], $result['documentroot']);
				}

				$ssl_redirect = makeyesno('ssl_redirect', '1', '0', $result['ssl_redirect']);
				$iswildcarddomain = makeyesno('iswildcarddomain', '1', '0', $result['iswildcarddomain']);
				$isemaildomain = makeyesno('isemaildomain', '1', '0', $result['isemaildomain']);
				$openbasedir = makeoption($lng['domain']['docroot'], 0, $result['openbasedir_path'], true) . makeoption($lng['domain']['homedir'], 1, $result['openbasedir_path'], true);
				$result = htmlentities_array($result);

				if($settings['system']['use_ssl'] == "1")
				{
				}

				eval("echo \"" . getTemplate("domains/domains_edit") . "\";");
			}
		}
		else
		{
			standard_error('domains_canteditdomain');
		}
	}
}

?>
