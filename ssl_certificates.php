<?php
if (! defined('AREA')) {
	header("Location: index.php");
	exit;
}

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Panel
 *
 */

// This file is being included in admin_domains and customer_domains
// and therefore does not need to require lib/init.php

$success_message = "";

// do the delete and then just show a success-message and the certificates list again
if ($action == 'delete') {
	$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
	if ($id > 0) {
		try {
			$json_result = Certificates::getLocal($userinfo, array(
				'id' => $id
			))->delete();
			$success_message = sprintf($lng['domains']['ssl_certificate_removed'], $id);
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
	}
}

$log->logAction(USR_ACTION, LOG_NOTICE, "viewed domains::ssl_certificates");
$fields = array(
	'd.domain' => $lng['domains']['domainname']
);
$paging = new paging($userinfo, TABLE_PANEL_DOMAIN_SSL_SETTINGS, $fields);

// select all my (accessable) certificates
$certs_stmt_query = "SELECT s.*, d.domain, d.letsencrypt, c.customerid, c.loginname
	FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` s
	LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` d ON `d`.`id` = `s`.`domainid`
	LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` c ON `c`.`customerid` = `d`.`customerid`
	WHERE ";

$qry_params = array();

if (AREA == 'admin' && $userinfo['customers_see_all'] == '0') {
	// admin with only customer-specific permissions
	$certs_stmt_query .= "d.adminid = :adminid ";
	$qry_params['adminid'] = $userinfo['adminid'];
} elseif (AREA == 'customer') {
	// customer-area
	$certs_stmt_query .= "d.customerid = :cid ";
	$qry_params['cid'] = $userinfo['customerid'];
} else {
	$certs_stmt_query .= "1 ";
}

// sorting by domain-name
$certs_stmt_query .= $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit();

$certs_stmt = Database::prepare($certs_stmt_query);
Database::pexecute($certs_stmt, $qry_params);
$all_certs = $certs_stmt->fetchAll(PDO::FETCH_ASSOC);
$certificates = "";

if (count($all_certs) == 0) {
	$message = $lng['domains']['no_ssl_certificates'];
	$sortcode = "";
	$arrowcode = array(
		'd.domain' => ''
	);
	$searchcode = "";
	$pagingcode = "";
	eval("\$certificates.=\"" . getTemplate("ssl_certificates/certs_error", true) . "\";");
} else {
	$paging->setEntries(count($all_certs));
	$sortcode = $paging->getHtmlSortCode($lng);
	$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
	$searchcode = $paging->getHtmlSearchCode($lng);
	$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);

	foreach ($all_certs as $idx => $cert) {
		if ($paging->checkDisplay($idx)) {

			// respect froxlor-hostname
			if ($cert['domainid'] == 0) {
				$cert['domain'] = Settings::Get('system.hostname');
				$cert['letsencrypt'] = Settings::Get('system.le_froxlor_enabled');
				$cert['loginname'] = 'froxlor.panel';
			}

			if (empty($cert['domain']) || empty($cert['ssl_cert_file'])) {
				// no domain found to the entry or empty entry - safely delete it from the DB
				Database::pexecute($del_stmt, array(
					'id' => $cert['id']
				));
				continue;
			}

			$cert_data = openssl_x509_parse($cert['ssl_cert_file']);

			$cert['domain'] = $idna_convert->decode($cert['domain']);

			$adminCustomerLink = "";
			if (AREA == 'admin' && $cert['domainid'] > 0) {
				if (! empty($cert['loginname'])) {
					$adminCustomerLink = '&nbsp;(<a href="' . $linker->getLink(array(
						'section' => 'customers',
						'page' => 'customers',
						'action' => 'su',
						'id' => $cert['customerid']
					)) . '" rel="external">' . $cert['loginname'] . '</a>)';
				}
			}

			if ($cert_data) {
				$validFrom = date('d.m.Y H:i:s', $cert_data['validFrom_time_t']);
				$validTo = date('d.m.Y H:i:s', $cert_data['validTo_time_t']);

				$isValid = true;
				if ($cert_data['validTo_time_t'] < time()) {
					$isValid = false;
				}

				$san_list = "";
				if (isset($cert_data['extensions']['subjectAltName']) && ! empty($cert_data['extensions']['subjectAltName'])) {
					$SANs = explode(",", $cert_data['extensions']['subjectAltName']);
					$SANs = array_map('trim', $SANs);
					foreach ($SANs as $san) {
						$san = str_replace("DNS:", "", $san);
						if ($san != $cert_data['subject']['CN'] && strpos($san, "othername:") === false) {
							$san_list .= $san . "<br>";
						}
					}
				}

				$row = htmlentities_array($cert);
				eval("\$certificates.=\"" . getTemplate("ssl_certificates/certs_cert", true) . "\";");
			} else {
				$message = sprintf($lng['domains']['ssl_certificate_error'], $cert['domain']);
				eval("\$certificates.=\"" . getTemplate("ssl_certificates/certs_error", true) . "\";");
			}
		} else {
			continue;
		}
	}
}
eval("echo \"" . getTemplate("ssl_certificates/certs_list", true) . "\";");
