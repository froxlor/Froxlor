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
const AREA = 'customer';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\Certificates as Certificates;
use Froxlor\Api\Commands\SubDomains as SubDomains;
use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options', 'domains')) {
	\Froxlor\UI\Response::redirectTo('customer_index.php');
}

$id = (int) Request::get('id');

if ($page == 'overview' || $page == 'domains') {
	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_domains::domains");

		$parentdomain_id = (int) Request::get('pid', '0');

		try {
			$domain_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/customer/tablelisting.domains.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\SubDomains::class, $userinfo))
				//->addParam(['sql_search' => ['d.parentdomainid' => $parentdomain_id]])
				->withPagination($domain_list_data['domain_list']['columns']);
			$parentDomainCollection = (new \Froxlor\UI\Collection(SubDomains::class, $userinfo, ['sql_search' => ['d.parentdomainid' => 0]]));
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		$actions_links = false;
		if (($userinfo['subdomains_used'] < $userinfo['subdomains'] || $userinfo['subdomains'] == '-1') && $parentDomainCollection->count() != 0) {
			$actions_links = [[
				'href' => $linker->getLink(['section' => 'domains', 'page' => 'domains', 'action' => 'add']),
				'label' => $lng['domains']['subdomain_add']
			]];
		}

		UI::twigBuffer('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $domain_list_data['domain_list']),
			'actions_links' => $actions_links,
			'entity_info' => $lng['domains']['description']
		]);
		UI::twigOutputBuffer();
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = SubDomains::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		$alias_stmt = Database::prepare("SELECT COUNT(`id`) AS `count` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `aliasdomain` = :aliasdomain");
		$alias_check = Database::pexecute_first($alias_stmt, array(
			"aliasdomain" => $id
		));

		if (isset($result['parentdomainid']) && $result['parentdomainid'] != '0' && $alias_check['count'] == 0) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					SubDomains::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page
				));
			} else {
				\Froxlor\UI\HTML::askYesNo('domains_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $idna_convert->decode($result['domain']));
			}
		} else {
			\Froxlor\UI\Response::standard_error('domains_cantdeletemaindomain');
		}
	} elseif ($action == 'add') {
		if ($userinfo['subdomains_used'] < $userinfo['subdomains'] || $userinfo['subdomains'] == '-1') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					SubDomains::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page
				));
			} else {
				$stmt = Database::prepare("SELECT `id`, `domain`, `documentroot`, `ssl_redirect`,`isemaildomain`,`letsencrypt` FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `customerid` = :customerid
					AND `parentdomainid` = '0'
					AND `email_only` = '0'
					AND `caneditdomain` = '1'
					ORDER BY `domain` ASC");
				Database::pexecute($stmt, array(
					"customerid" => $userinfo['customerid']
				));
				$domains = [];
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains[$row['domain']] = $idna_convert->decode($row['domain']);
				}

				$aliasdomains[0] = $lng['domains']['noaliasdomain'];
				$domains_stmt = Database::prepare("SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c`
					WHERE `d`.`aliasdomain` IS NULL
					AND `d`.`id` <> `c`.`standardsubdomain`
					AND `d`.`parentdomainid` = '0'
					AND `d`.`customerid`=`c`.`customerid`
					AND `d`.`email_only`='0'
					AND `d`.`customerid`= :customerid
					ORDER BY `d`.`domain` ASC");
				Database::pexecute($domains_stmt, array(
					"customerid" => $userinfo['customerid']
				));

				while ($row_domain = $domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$aliasdomains[$row_domain['id']] = $idna_convert->decode($row_domain['domain']);
				}

				$redirectcode = [];
				if (Settings::Get('customredirect.enabled') == '1') {
					$codes = \Froxlor\Domain\Domain::getRedirectCodesArray();
					foreach ($codes as $rc) {
						$redirectcode[$rc['id']] = $rc['code'] . ' (' . $lng['redirect_desc'][$rc['desc']] . ')';
					}
				}

				// check if we at least have one ssl-ip/port, #1179
				$ssl_ipsandports = false;
				$ssl_ip_stmt = Database::prepare("
					SELECT COUNT(*) as countSSL
					FROM `" . TABLE_PANEL_IPSANDPORTS . "` pip
					LEFT JOIN `" . TABLE_DOMAINTOIP . "` dti ON dti.id_ipandports = pip.id
					WHERE pip.`ssl`='1'
				");
				Database::pexecute($ssl_ip_stmt);
				$resultX = $ssl_ip_stmt->fetch(PDO::FETCH_ASSOC);
				if (isset($resultX['countSSL']) && (int) $resultX['countSSL'] > 0) {
					$ssl_ipsandports = true;
				}

				$openbasedir = [
					0 => $lng['domain']['docroot'],
					1 => $lng['domain']['homedir']
				];
				$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);

				$phpconfigs = [];
				if (isset($userinfo['allowed_phpconfigs']) && !empty($userinfo['allowed_phpconfigs'])) {
					$allowed_cfg = json_decode($userinfo['allowed_phpconfigs'], JSON_OBJECT_AS_ARRAY);
					$phpconfigs_result_stmt = Database::query("
						SELECT c.*, fc.description as interpreter
						FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
						LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
						WHERE c.id IN (" . implode(", ", $allowed_cfg) . ")
					");
					while ($phpconfigs_row = $phpconfigs_result_stmt->fetch(PDO::FETCH_ASSOC)) {
						if ((int) Settings::Get('phpfpm.enabled') == 1) {
							$phpconfigs[$phpconfigs_row['id']] = $phpconfigs_row['description'] . " [" . $phpconfigs_row['interpreter'] . "]";
						} else {
							$phpconfigs[$phpconfigs_row['id']] = $phpconfigs_row['description'];
						}
					}
				}

				$subdomain_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/domains/formfield.domains_add.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'domains')),
					'formdata' => $subdomain_add_data['domain_add']
				]);
				UI::twigOutputBuffer();
			}
		}
	} elseif ($action == 'edit' && $id != 0) {

		try {
			$json_result = SubDomains::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['customerid']) && $result['customerid'] == $userinfo['customerid']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					SubDomains::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page
				));
			} else {
				$result['domain'] = $idna_convert->decode($result['domain']);

				$domains[0] = $lng['domains']['noaliasdomain'];
				// also check ip/port combination to be the same, #176
				$domains_stmt = Database::prepare("SELECT `d`.`id`, `d`.`domain` FROM `" . TABLE_PANEL_DOMAINS . "` `d` , `" . TABLE_PANEL_CUSTOMERS . "` `c` , `" . TABLE_DOMAINTOIP . "` `dip`
					WHERE `d`.`aliasdomain` IS NULL
					AND `d`.`id` <> :id
					AND `c`.`standardsubdomain` <> `d`.`id`
					AND `d`.`parentdomainid` = '0'
					AND `d`.`customerid` = :customerid
					AND `c`.`customerid` = `d`.`customerid`
					AND `d`.`id` = `dip`.`id_domain`
					AND `dip`.`id_ipandports`
					IN (SELECT `id_ipandports` FROM `" . TABLE_DOMAINTOIP . "`
						WHERE `id_domain` = :id)
					GROUP BY `d`.`id`, `d`.`domain`
					ORDER BY `d`.`domain` ASC");
				Database::pexecute($domains_stmt, array(
					"id" => $result['id'],
					"customerid" => $userinfo['customerid']
				));

				while ($row_domain = $domains_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains[$row_domain['id']] = $idna_convert->decode($row_domain['domain']);
				}

				if (preg_match('/^https?\:\/\//', $result['documentroot']) && \Froxlor\Validate\Validate::validateUrl($result['documentroot'])) {
					if (Settings::Get('panel.pathedit') == 'Dropdown') {
						$urlvalue = $result['documentroot'];
						$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);
					} else {
						$urlvalue = '';
						$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $result['documentroot'], true);
					}
				} else {
					$urlvalue = '';
					$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid'], $result['documentroot']);
				}

				$redirectcode = [];
				if (Settings::Get('customredirect.enabled') == '1') {
					$def_code = \Froxlor\Domain\Domain::getDomainRedirectId($id);
					$codes = \Froxlor\Domain\Domain::getRedirectCodesArray();
					foreach ($codes as $rc) {
						$redirectcode[$rc['id']] = $rc['code'] . ' (' . $lng['redirect_desc'][$rc['desc']] . ')';
					}
				}

				// check if we at least have one ssl-ip/port, #1179
				$ssl_ipsandports = false;
				$ssl_ip_stmt = Database::prepare("
					SELECT COUNT(*) as countSSL
					FROM `" . TABLE_PANEL_IPSANDPORTS . "` pip
					LEFT JOIN `" . TABLE_DOMAINTOIP . "` dti ON dti.id_ipandports = pip.id
					WHERE `dti`.`id_domain` = :id_domain AND pip.`ssl`='1'
				");
				Database::pexecute($ssl_ip_stmt, array(
					"id_domain" => $result['id']
				));
				$resultX = $ssl_ip_stmt->fetch(PDO::FETCH_ASSOC);
				if (isset($resultX['countSSL']) && (int) $resultX['countSSL'] > 0) {
					$ssl_ipsandports = true;
				}

				// Fudge the result for ssl_redirect to hide the Let's Encrypt steps
				$result['temporary_ssl_redirect'] = $result['ssl_redirect'];
				$result['ssl_redirect'] = ($result['ssl_redirect'] == 0 ? 0 : 1);

				$openbasedir = [
					0 => $lng['domain']['docroot'],
					1 => $lng['domain']['homedir']
				];

				// create serveralias options
				$serveraliasoptions = [];
				$serveraliasoptions_selected = '2';
				if ($result['iswildcarddomain'] == '1') {
					$serveraliasoptions_selected = '0';
				} elseif ($result['wwwserveralias'] == '1') {
					$serveraliasoptions_selected = '1';
				}
				$serveraliasoptions[0] = $lng['domains']['serveraliasoption_wildcard'];
				$serveraliasoptions[1] = $lng['domains']['serveraliasoption_www'];
				$serveraliasoptions[2] = $lng['domains']['serveraliasoption_none'];

				$ips_stmt = Database::prepare("SELECT `p`.`ip` AS `ip` FROM `" . TABLE_PANEL_IPSANDPORTS . "` `p`
					LEFT JOIN `" . TABLE_DOMAINTOIP . "` `dip`
					ON ( `dip`.`id_ipandports` = `p`.`id` )
					WHERE `dip`.`id_domain` = :id_domain
					GROUP BY `p`.`ip`");
				Database::pexecute($ips_stmt, array(
					"id_domain" => $result['id']
				));
				$domainips = [];
				while ($rowip = $ips_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domainips[] = ['item' => $rowip['ip']];
				}

				$phpconfigs = [];
				if (isset($userinfo['allowed_phpconfigs']) && !empty($userinfo['allowed_phpconfigs'])) {
					$allowed_cfg = json_decode($userinfo['allowed_phpconfigs'], JSON_OBJECT_AS_ARRAY);
					$phpconfigs_result_stmt = Database::query("
						SELECT c.*, fc.description as interpreter
						FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
						LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fc ON fc.id = c.fpmsettingid
						WHERE c.id IN (" . implode(", ", $allowed_cfg) . ")
					");
					while ($phpconfigs_row = $phpconfigs_result_stmt->fetch(PDO::FETCH_ASSOC)) {
						if ((int) Settings::Get('phpfpm.enabled') == 1) {
							$phpconfigs[$phpconfigs_row['id']] = $phpconfigs_row['description'] . " [" . $phpconfigs_row['interpreter'] . "]";
						} else {
							$phpconfigs[$phpconfigs_row['id']] = $phpconfigs_row['description'];
						}
					}
				}

				$alias_stmt = Database::prepare("SELECT COUNT(`id`) AS count FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `aliasdomain`= :aliasdomain");
				$alias_check = Database::pexecute_first($alias_stmt, array(
					"aliasdomain" => $result['id']
				));
				$alias_check = $alias_check['count'];

				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$subdomain_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/domains/formfield.domains_edit.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'domains', 'id' => $id)),
					'formdata' => $subdomain_edit_data['domain_edit'],
					'editid' => $id
				]);
				UI::twigOutputBuffer();
			}
		} else {
			\Froxlor\UI\Response::standard_error('domains_canteditdomain');
		}
	}
} elseif ($page == 'domainssleditor') {

	if ($action == '' || $action == 'view') {

		// get domain
		try {
			$json_result = SubDomains::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result_domain = json_decode($json_result, true)['data'];

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			$do_insert = isset($_POST['do_insert']) ? (($_POST['do_insert'] == 1) ? true : false) : false;
			try {
				if ($do_insert) {
					Certificates::getLocal($userinfo, $_POST)->add();
				} else {
					Certificates::getLocal($userinfo, $_POST)->update();
				}
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			// back to domain overview
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => 'domains'
			));
		}

		$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
			WHERE `domainid`= :domainid");
		$result = Database::pexecute_first($stmt, array(
			"domainid" => $id
		));

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

		$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

		$ssleditor_data = include_once dirname(__FILE__) . '/lib/formfields/customer/domains/formfield.domain_ssleditor.php';
		$ssleditor_form = \Froxlor\UI\HtmlForm::genHTMLForm($ssleditor_data);

		$title = $ssleditor_data['domain_ssleditor']['title'];
		$image = $ssleditor_data['domain_ssleditor']['image'];

		eval("echo \"" . \Froxlor\UI\Template::getTemplate("domains/domain_ssleditor") . "\";");
	}
} elseif ($page == 'domaindnseditor' && $userinfo['dnsenabled'] == '1' && Settings::Get('system.dnsenabled') == '1') {

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
	$row['domainalias'] = $idna_convert->decode($row['domainalias']);

	/**
	 * check for set ssl-certs to show different state-icons
	 */
	// nothing (ssl_global)
	$row['domain_hascert'] = 0;
	$ssl_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` = :domainid");
	Database::pexecute($ssl_stmt, array(
		"domainid" => $row['id']
	));
	$ssl_result = $ssl_stmt->fetch(PDO::FETCH_ASSOC);
	if (is_array($ssl_result) && isset($ssl_result['ssl_cert_file']) && $ssl_result['ssl_cert_file'] != '') {
		// own certificate (ssl_customer_green)
		$row['domain_hascert'] = 1;
	} else {
		// check if it's parent has one set (shared)
		if ($row['parentdomainid'] != 0) {
			$ssl_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` = :domainid");
			Database::pexecute($ssl_stmt, array(
				"domainid" => $row['parentdomainid']
			));
			$ssl_result = $ssl_stmt->fetch(PDO::FETCH_ASSOC);
			if (is_array($ssl_result) && isset($ssl_result['ssl_cert_file']) && $ssl_result['ssl_cert_file'] != '') {
				// parent has a certificate (ssl_shared)
				$row['domain_hascert'] = 2;
			}
		}
	}

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
