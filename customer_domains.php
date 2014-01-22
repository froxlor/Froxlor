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
		$domains_stmt = Database::prepare("SELECT `d`.`id`, `d`.`customerid`, `d`.`domain`, `d`.`documentroot`, `d`.`isemaildomain`, `d`.`caneditdomain`, `d`.`iswildcarddomain`, `d`.`parentdomainid`, `ad`.`id` AS `aliasdomainid`, `ad`.`domain` AS `aliasdomain`, `da`.`id` AS `domainaliasid`, `da`.`domain` AS `domainalias` FROM `" . TABLE_PANEL_DOMAINS . "` `d`
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
				$row = htmlentities_array($domain_array[$sortkey]);
				if (Settings::Get('system.awstats_enabled') == '1') {
					$statsapp = 'awstats';
				} else {
					$statsapp = 'webalizer';
				}
				eval("\$domains.=\"" . getTemplate("domains/domains_delimiter") . "\";");

				if ($paging->sortfield == 'd.domain' && $paging->sortorder == 'asc') {
					ksort($domain_array);
				} elseif ($paging->sortfield == 'd.domain' && $paging->sortorder == 'desc') {
					krsort($domain_array);
				}

				foreach ($domain_array as $row) {
					if (strpos($row['documentroot'], $userinfo['documentroot']) === 0) {
						$row['documentroot'] = makeCorrectDir(substr($row['documentroot'], strlen($userinfo['documentroot'])));
					}

					// get ssl-ips if activated
					$show_ssledit = false;
					if (Settings::Get('system.use_ssl') == '1' && domainHasSslIpPort($row['id']) && $row['caneditdomain'] == '1') {
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
		$stmt = Database::prepare("SELECT `id`, `customerid`, `domain`, `documentroot`, `isemaildomain`, `parentdomainid` FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE `customerid` = :customerid
			AND `id` = :id"
		);
		Database::pexecute($stmt, array("customerid" => $userinfo['customerid'], "id" => $id));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$alias_stmt = Database::prepare("SELECT COUNT(`id`) AS `count` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `aliasdomain` = :aliasdomain");
		Database::pexecute($alias_stmt, array("aliasdomain" => $id));
		$alias_check = $alias_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($result['parentdomainid']) && $result['parentdomainid'] != '0' && $alias_check['count'] == 0) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				if ($result['isemaildomain'] == '1') {
					$emails_stmt = Database::prepare("SELECT COUNT(`id`) AS `count` FROM `" . TABLE_MAIL_VIRTUAL . "`
						WHERE `customerid` = :customerid
						AND `domainid` = :domainid"
					);
					Database::pexecute($emails_stmt, array("customerid" => $userinfo['customerid'], "domainid" => $id));
					$emails = $emails_stmt->fetch(PDO::FETCH_ASSOC);

					if ($emails['count'] != '0') {
						standard_error('domains_cantdeletedomainwithemail');
					}
				}

				$log->logAction(USR_ACTION, LOG_INFO, "deleted subdomain '" . $idna_convert->decode($result['domain']) . "'");
				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DOMAINS . "` WHERE
					`customerid` = :customerid
					AND `id` = :id"
				);
				Database::pexecute($stmt, array("customerid" => $userinfo['customerid'], "id" => $id));

				$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
					SET `subdomains_used` = `subdomains_used` - 1
					WHERE `customerid` = :customerid"
				);
				Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));

				// remove connections to ips and domainredirects
				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_DOMAINTOIP . "`
					WHERE `id_domain` = :domainid"
				);
				Database::pexecute($del_stmt, array('domainid' => $id));

				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_DOMAINREDIRECTS . "`
					WHERE `did` = :domainid"
				);
				Database::pexecute($del_stmt, array('domainid' => $id));

				inserttask('1');

				// Using nameserver, insert a task which rebuilds the server config
				inserttask('4');

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
				$subdomain = $idna_convert->encode(preg_replace(array('/\:(\d)+$/', '/^https?\:\/\//'), '', validate($_POST['subdomain'], 'subdomain', '', 'subdomainiswrong')));
				$domain = $idna_convert->encode($_POST['domain']);
				$domain_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `domain` = :domain
					AND `customerid` = :customerid
					AND `parentdomainid` = '0'
					AND `email_only` = '0'
					AND `caneditdomain` = '1'"
				);
				$domain_check = Database::pexecute_first($domain_stmt, array("domain" => $domain, "customerid" => $userinfo['customerid']));

				$completedomain = $subdomain . '.' . $domain;
				$completedomain_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `domain` = :domain
					AND `customerid` = :customerid
					AND `email_only` = '0'
					AND `caneditdomain` = '1'"
				);
				$completedomain_check = Database::pexecute_first($completedomain_stmt, array("domain" => $completedomain, "customerid" => $userinfo['customerid']));

				$aliasdomain = intval($_POST['alias']);
				$aliasdomain_check = array('id' => 0);
				$_doredirect = false;

				if ($aliasdomain != 0) {
					// also check ip/port combination to be the same, #176
					$aliasdomain_stmt = Database::prepare("SELECT `d`.`id` FROM `" . TABLE_PANEL_DOMAINS . "` `d` , `" . TABLE_PANEL_CUSTOMERS . "` `c` , `".TABLE_DOMAINTOIP."` `dip`
						WHERE `d`.`aliasdomain` IS NULL
						AND `d`.`id` = :id
						AND `c`.`standardsubdomain` <> `d`.`id`
						AND `d`.`customerid` = :customerid
						AND `c`.`customerid` = `d`.`customerid`
						AND `d`.`id` = `dip`.`id_domain`
						AND `dip`.`id_ipandports`
						IN (SELECT `id_ipandports` FROM `".TABLE_DOMAINTOIP."`
							WHERE `id_domain` = :id )
						GROUP BY `d`.`domain`
						ORDER BY `d`.`domain` ASC;"
					);
					$aliasdomain_check = Database::pexecute_first($aliasdomain_stmt, array("id" => $aliasdomain, "customerid" => $userinfo['customerid']));
				}

				if (isset($_POST['url']) && $_POST['url'] != '' && validateUrl($idna_convert->encode($_POST['url']))) {
					$path = $_POST['url'];
					$_doredirect = true;
				} else {
					$path = validate($_POST['path'], 'path');
				}

				if (!preg_match('/^https?\:\/\//', $path) || !validateUrl($idna_convert->encode($path))) {
					// If path is empty or '/' and 'Use domain name as default value for DocumentRoot path' is enabled in settings,
					// set default path to subdomain or domain name
					if ((($path == '') || ($path == '/')) && Settings::Get('system.documentroot_use_default_value') == 1) {
						$path = makeCorrectDir($userinfo['documentroot'] . '/' . $completedomain);
					} else {
						$path = makeCorrectDir($userinfo['documentroot'] . '/' . $path);
					}
					if (strstr($path, ":") !== FALSE) {
						standard_error('pathmaynotcontaincolon');
					}
				} else {
					$_doredirect = true;
				}

				$openbasedir_path = '0';
				if (isset($_POST['openbasedir_path']) && $_POST['openbasedir_path'] == '1') {
					$openbasedir_path = '1';
				}

				$ssl_redirect = '0';
				if (isset($_POST['ssl_redirect']) && $_POST['ssl_redirect'] == '1') {
					// a ssl-redirect only works of there actually is a
					// ssl ip/port assigned to the domain
					if (domainHasSslIpPort($domain_check['id']) == true) {
						$ssl_redirect = '1';
					} else {
						standard_error('sslredirectonlypossiblewithsslipport');
					}
				}

				if ($path == '') {
					standard_error('patherror');
				} elseif ($subdomain == '') {
					standard_error(array('stringisempty', 'domainname'));
				} elseif ($subdomain == 'www' && $domain_check['wwwserveralias'] == '1') {
					standard_error('wwwnotallowed');
				} elseif ($domain == '') {
					standard_error('domaincantbeempty');
				} elseif (strtolower($completedomain_check['domain']) == strtolower($completedomain)) {
					standard_error('domainexistalready', $completedomain);
				} elseif (strtolower($domain_check['domain']) != strtolower($domain)) {
					standard_error('maindomainnonexist', $domain);
				} elseif ($aliasdomain_check['id'] != $aliasdomain) {
					standard_error('domainisaliasorothercustomer');
				} else {
					// get the phpsettingid from parentdomain, #107
					$phpsid_stmt = Database::prepare("SELECT `phpsettingid` FROM `".TABLE_PANEL_DOMAINS."`
						WHERE `id` = :id"
					);
					Database::pexecute($phpsid_stmt, array("id" => $domain_check['id']));
					$phpsid_result = $phpsid_stmt->fetch(PDO::FETCH_ASSOC);

					if (!isset($phpsid_result['phpsettingid']) || (int)$phpsid_result['phpsettingid'] <= 0) {
						// assign default config
						$phpsid_result['phpsettingid'] = 1;
					}

					$stmt = Database::prepare("INSERT INTO `" . TABLE_PANEL_DOMAINS . "` SET
						`customerid` = :customerid,
						`domain` = :domain,
						`documentroot` = :documentroot,
						`aliasdomain` = :aliasdomain,
						`parentdomainid` = :parentdomainid,
						`wwwserveralias` = :wwwserveralias,
						`isemaildomain` = :isemaildomain,
						`iswildcarddomain` = :iswildcarddomain,
						`openbasedir` = :openbasedir,
						`openbasedir_path` = :openbasedir_path,
						`speciallogfile` = :speciallogfile,
						`specialsettings` = :specialsettings,
						`ssl_redirect` = :ssl_redirect,
						`phpsettingid` = :phpsettingid"
					);
					$params = array(
						"customerid" => $userinfo['customerid'],
						"domain" => $completedomain,
						"documentroot" => $path,
						"aliasdomain" => $aliasdomain != 0 ? $aliasdomain : null,
						"parentdomainid" => $domain_check['id'],
						"wwwserveralias" => $domain_check['wwwserveralias'] == '1' ? '1' : '0',
						"iswildcarddomain" => $domain_check['iswildcarddomain'] == '1' ? '1' : '0',
						"isemaildomain" => $domain_check['subcanemaildomain'] == '3' ? '1' : '0',
						"openbasedir" => $domain_check['openbasedir'],
						"openbasedir_path" => $openbasedir_path,
						"speciallogfile" => $domain_check['speciallogfile'],
						"specialsettings" => $domain_check['specialsettings'],
						"ssl_redirect" => $ssl_redirect,
						"phpsettingid" => $phpsid_result['phpsettingid']
					);
					Database::pexecute($stmt, $params);

					if ($_doredirect) {
						$did = Database::lastInsertId();
						$redirect = isset($_POST['redirectcode']) ? (int)$_POST['redirectcode'] : Settings::Get('customredirect.default');
						addRedirectToDomain($did, $redirect);
					}

					$stmt = Database::prepare("INSERT INTO `".TABLE_DOMAINTOIP."`
						(`id_domain`, `id_ipandports`)
						SELECT LAST_INSERT_ID(), `id_ipandports`
							FROM `".TABLE_DOMAINTOIP."`
							WHERE `id_domain` = :id_domain"
					);
					Database::pexecute($stmt, array("id_domain" => $domain_check['id']));

					$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
						SET `subdomains_used` = `subdomains_used` + 1
						WHERE `customerid` = :customerid"
					);
					Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));

					$log->logAction(USR_ACTION, LOG_INFO, "added subdomain '" . $completedomain . "'");
					inserttask('1');

					// Using nameserver, insert a task which rebuilds the server config
					inserttask('4');

					redirectTo($filename, array('page' => $page, 's' => $s));
				}
			} else {
				$stmt = Database::prepare("SELECT `id`, `domain`, `documentroot`, `ssl_redirect`,`isemaildomain` FROM `" . TABLE_PANEL_DOMAINS . "`
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
				$ssl_ip_stmt = Database::prepare("SELECT COUNT(*) as countSSL FROM `panel_ipsandports` WHERE `ssl`='1'");
				Database::pexecute($ssl_ip_stmt);
				$resultX = $ssl_ip_stmt->fetch(PDO::FETCH_ASSOC);
				if (isset($resultX['countSSL']) && (int)$resultX['countSSL'] > 0) {
					$ssl_ipsandports = 'notempty';
				}

				$openbasedir = makeoption($lng['domain']['docroot'], 0, NULL, true) . makeoption($lng['domain']['homedir'], 1, NULL, true);
				$pathSelect = makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);

				$subdomain_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/domains/formfield.domains_add.php';
				$subdomain_add_form = htmlform::genHTMLForm($subdomain_add_data);

				$title = $subdomain_add_data['domain_add']['title'];
				$image = $subdomain_add_data['domain_add']['image'];

				eval("echo \"" . getTemplate("domains/domains_add") . "\";");
			}
		}
	} elseif ($action == 'edit' && $id != 0) {

		$stmt = Database::prepare("SELECT `d`.`id`, `d`.`customerid`, `d`.`domain`, `d`.`documentroot`, `d`.`isemaildomain`, `d`.`wwwserveralias`, `d`.`iswildcarddomain`,
			`d`.`parentdomainid`, `d`.`ssl_redirect`, `d`.`aliasdomain`, `d`.`openbasedir`, `d`.`openbasedir_path`, `pd`.`subcanemaildomain`
			FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_DOMAINS . "` `pd`
			WHERE `d`.`customerid` = :customerid
			AND `d`.`id` = :id
			AND ((`d`.`parentdomainid`!='0'
					AND `pd`.`id` = `d`.`parentdomainid`)
				OR (`d`.`parentdomainid`='0'
					AND `pd`.`id` = `d`.`id`))
			AND `d`.`caneditdomain`='1'");
		$result = Database::pexecute_first($stmt, array("customerid" => $userinfo['customerid'], "id" => $id));

		$alias_stmt = Database::prepare("SELECT COUNT(`id`) AS count FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `aliasdomain`= :aliasdomain");
		$alias_check = Database::pexecute_first($alias_stmt, array("aliasdomain" => $result['id']));
		$alias_check = $alias_check['count'];
		$_doredirect = false;

		if (isset($result['customerid']) && $result['customerid'] == $userinfo['customerid']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				if (isset($_POST['url']) && $_POST['url'] != '' && validateUrl($idna_convert->encode($_POST['url']))) {
					$path = $_POST['url'];
					$_doredirect = true;
				} else {
					$path = validate($_POST['path'], 'path');
				}

				if (!preg_match('/^https?\:\/\//', $path) || !validateUrl($idna_convert->encode($path))) {
					// If path is empty or '/' and 'Use domain name as default value for DocumentRoot path' is enabled in settings,
					// set default path to subdomain or domain name
					if ((($path == '') || ($path == '/')) && Settings::Get('system.documentroot_use_default_value') == 1) {
						$path = makeCorrectDir($userinfo['documentroot'] . '/' . $result['domain']);
					} else {
						$path = makeCorrectDir($userinfo['documentroot'] . '/' . $path);
					}
					if (strstr($path, ":") !== FALSE) {
						standard_error('pathmaynotcontaincolon');
					}
				} else {
					$_doredirect = true;
				}

				$aliasdomain = intval($_POST['alias']);

				if (isset($_POST['selectserveralias']) && $result['parentdomainid'] == '0' ) {
					$iswildcarddomain = ($_POST['selectserveralias'] == '0') ? '1' : '0';
					$wwwserveralias = ($_POST['selectserveralias'] == '1') ? '1' : '0';
				} else {
					$iswildcarddomain = $result['iswildcarddomain'];
					$wwwserveralias = $result['wwwserveralias'];
				}

				if ($result['parentdomainid'] != '0' && ($result['subcanemaildomain'] == '1' || $result['subcanemaildomain'] == '2') && isset($_POST['isemaildomain'])) {
					$isemaildomain = intval($_POST['isemaildomain']);
				} else {
					$isemaildomain = $result['isemaildomain'];
				}

				$aliasdomain_check = array('id' => 0);

				if ($aliasdomain != 0) {
					$aliasdomain_stmt = Database::prepare("SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` `d`,`" . TABLE_PANEL_CUSTOMERS . "` `c`
						WHERE `d`.`customerid`= :customerid
						AND `d`.`aliasdomain` IS NULL
						AND `d`.`id`<>`c`.`standardsubdomain`
						AND `c`.`customerid`= :customerid
						AND `d`.`id`= :id"
					);
					$aliasdomain_check = Database::pexecute_first($aliasdomain_stmt, array("customerid" => $result['customerid'], "id" => $aliasdomain));
				}

				if ($aliasdomain_check['id'] != $aliasdomain) {
					standard_error('domainisaliasorothercustomer');
				}

				if (isset($_POST['openbasedir_path']) && $_POST['openbasedir_path'] == '1') {
					$openbasedir_path = '1';
				} else {
					$openbasedir_path = '0';
				}

				if (isset($_POST['ssl_redirect']) && $_POST['ssl_redirect'] == '1') {
					// a ssl-redirect only works of there actually is a
					// ssl ip/port assigned to the domain
					if (domainHasSslIpPort($id) == true) {
						$ssl_redirect = '1';
					} else {
						standard_error('sslredirectonlypossiblewithsslipport');
					}
				} else {
					$ssl_redirect = '0';
				}

				if ($path == '') {
					standard_error('patherror');
				} else {
					if (($result['isemaildomain'] == '1') && ($isemaildomain == '0')) {
						$params = array("customerid" => $userinfo['customerid'], "domainid" => $id);
						$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid`= :customerid AND `domainid`= :domainid");
						Database::pexecute($stmt, $params);
						$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `customerid`= :customerid AND `domainid`= :domainid");
						Database::pexecute($stmt, $params);
						$log->logAction(USR_ACTION, LOG_NOTICE, "automatically deleted mail-table entries for '" . $idna_convert->decode($result['domain']) . "'");
					}

					if ($_doredirect) {
						$redirect = isset($_POST['redirectcode']) ? (int)$_POST['redirectcode'] : false;
						updateRedirectOfDomain($id, $redirect);
					}

					if ($path != $result['documentroot']
						|| $isemaildomain != $result['isemaildomain']
						|| $wwwserveralias != $result['wwwserveralias']
						|| $iswildcarddomain != $result['iswildcarddomain']
						|| $aliasdomain != $result['aliasdomain']
						|| $openbasedir_path != $result['openbasedir_path']
						|| $ssl_redirect != $result['ssl_redirect']) {
						$log->logAction(USR_ACTION, LOG_INFO, "edited domain '" . $idna_convert->decode($result['domain']) . "'");

						$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
							`documentroot`= :documentroot,
							`isemaildomain`= :isemaildomain,
							`wwwserveralias`= :wwwserveralias,
							`iswildcarddomain`= :iswildcarddomain,
							`aliasdomain`= :aliasdomain,
							`openbasedir_path`= :openbasedir_path,
							`ssl_redirect`= :ssl_redirect
							WHERE `customerid`= :customerid
							AND `id`= :id"
						);
						$params = array(
							"documentroot" => $path,
							"isemaildomain" => $isemaildomain,
							"wwwserveralias" => $wwwserveralias,
							"iswildcarddomain" => $iswildcarddomain,
							"aliasdomain" => ($aliasdomain != 0 && $alias_check == 0) ? $aliasdomain : null,
							"openbasedir_path" => $openbasedir_path,
							"ssl_redirect" => $ssl_redirect,
							"customerid" => $userinfo['customerid'],
							"id" => $id
						);
						Database::pexecute($stmt, $params);
						inserttask('1');

						// Using nameserver, insert a task which rebuilds the server config
						inserttask('4');

					}

					redirectTo($filename, array('page' => $page, 's' => $s));
				}
			} else {
				$result['domain'] = $idna_convert->decode($result['domain']);

				$domains = makeoption($lng['domains']['noaliasdomain'], 0, $result['aliasdomain'], true);
				// also check ip/port combination to be the same, #176
				$domains_stmt = Database::prepare("SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d` , `" . TABLE_PANEL_CUSTOMERS . "` `c` , `".TABLE_DOMAINTOIP."` `dip`
					WHERE `d`.`aliasdomain` IS NULL
					AND `d`.`id` <> :id
					AND `c`.`standardsubdomain` <> `d`.`id`
					AND `d`.`customerid` = :customerid
					AND `c`.`customerid` = `d`.`customerid`
					AND `d`.`id` = `dip`.`id_domain`
					AND `dip`.`id_ipandports`
					IN (SELECT `id_ipandports` FROM `".TABLE_DOMAINTOIP."`
						WHERE `id_domain` = :id)
					GROUP BY `d`.`domain`
					ORDER BY `d`.`domain` ASC"
				);
				Database::pexecute($domains_stmt, array("id" => $result['id'], "customerid" => $userinfo['customerid']));

				while ($row_domain = $domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains .= makeoption($idna_convert->decode($row_domain['domain']), $row_domain['id'], $result['aliasdomain']);
				}

				if (preg_match('/^https?\:\/\//', $result['documentroot']) && validateUrl($idna_convert->encode($result['documentroot']))) {
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
				$ssl_ip_stmt = Database::prepare("SELECT COUNT(*) as countSSL FROM `panel_ipsandports` WHERE `ssl`='1'");
				Database::pexecute($ssl_ip_stmt);
				$resultX = $ssl_ip_stmt->fetch(PDO::FETCH_ASSOC);
				if (isset($resultX['countSSL']) && (int)$resultX['countSSL'] > 0) {
					$ssl_ipsandports = 'notempty';
				}

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

				if (is_array($cert_content) && isset($cert_content['subject']) && isset($cert_content['subject']['CN'])) {
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
			$stmt = Database::prepare($qrystart." `".TABLE_PANEL_DOMAIN_SSL_SETTINGS."` SET
				`ssl_cert_file` = :ssl_cert_file,
				`ssl_key_file` = :ssl_key_file,
				`ssl_ca_file` = :ssl_ca_file,
				`ssl_cert_chainfile` = :ssl_cert_chainfile
				".$qrywhere." `domainid`= :domainid"
			);
			$params = array(
				"ssl_cert_file" => $ssl_cert_file,
				"ssl_key_file" => $ssl_key_file,
				"ssl_ca_file" => $ssl_ca_file,
				"ssl_cert_chainfile" => $ssl_cert_chainfile,
				"domainid" => $id
			);
			Database::pexecute($stmt, $params);

			// insert task to re-generate webserver-configs (#1260)
			inserttask('1');

			// back to domain overview
			redirectTo($filename, array('page' => 'domains', 's' => $s));
		}

		$stmt = Database::prepare("SELECT * FROM `".TABLE_PANEL_DOMAIN_SSL_SETTINGS."`
			WHERE `domainid`= :domainid"
		);
		Database::pexecute($stmt, array("domainid" => $id));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

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
