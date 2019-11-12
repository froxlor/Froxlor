<?php
if (! defined('AREA')) {
	header("Location: index.php");
	exit();
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

use Froxlor\Settings;
use Froxlor\Api\Commands\Certificates as Certificates;

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
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
	}
}

$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed domains::ssl_certificates");
$fields = array(
	'd.domain' => $lng['domains']['domainname']
);
try {
	// get total count
	$json_result = Certificates::getLocal($userinfo)->listingCount();
	$result = json_decode($json_result, true)['data'];
	// initialize pagination and filtering
	$paging = new \Froxlor\UI\Pagination($userinfo, $fields, $result);
	// get list
	$json_result = Certificates::getLocal($userinfo, $paging->getApiCommandParams())->listing();
} catch (Exception $e) {
	\Froxlor\UI\Response::dynamic_error($e->getMessage());
}
$result = json_decode($json_result, true)['data'];

$all_certs = $result['list'];
$certificates = "";

if (count($all_certs) == 0) {
	$message = $lng['domains']['no_ssl_certificates'];
	$sortcode = "";
	$arrowcode = array(
		'd.domain' => ''
	);
	// keep searching code if something was searched and no results were returned
	$searchcode = $paging->getHtmlSearchCode($lng);
	$pagingcode = "";
	eval("\$certificates.=\"" . \Froxlor\UI\Template::getTemplate("ssl_certificates/certs_error", true) . "\";");
} else {
	$sortcode = $paging->getHtmlSortCode($lng);
	$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
	$searchcode = $paging->getHtmlSearchCode($lng);
	$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);

	foreach ($all_certs as $idx => $cert) {
		// respect froxlor-hostname
		if ($cert['domainid'] == 0) {
			$cert['domain'] = Settings::Get('system.hostname');
			$cert['letsencrypt'] = Settings::Get('system.le_froxlor_enabled');
			$cert['loginname'] = 'froxlor.panel';
		}

		if (empty($cert['domain']) || empty($cert['ssl_cert_file'])) {
			// no domain found to the entry or empty entry - safely delete it from the DB
			try {
				Certificates::getLocal($userinfo, array(
					'id' => $cert['id']
				))->delete();
			} catch (Exception $e) {
				// do nothing
			}
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

			$row = \Froxlor\PhpHelper::htmlentitiesArray($cert);
			eval("\$certificates.=\"" . \Froxlor\UI\Template::getTemplate("ssl_certificates/certs_cert", true) . "\";");
		} else {
			$message = sprintf($lng['domains']['ssl_certificate_error'], $cert['domain']);
			eval("\$certificates.=\"" . \Froxlor\UI\Template::getTemplate("ssl_certificates/certs_error", true) . "\";");
		}
	}
}
eval("echo \"" . \Froxlor\UI\Template::getTemplate("ssl_certificates/certs_list", true) . "\";");
