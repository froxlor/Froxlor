<?php
if (!defined('AREA')) {
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

use Froxlor\FroxlorLogger;
use Froxlor\Api\Commands\Certificates;
use Froxlor\UI\Collection;
use Froxlor\UI\Listing;
use Froxlor\UI\Pagination;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Response;

// This file is being included in admin_domains and customer_domains
// and therefore does not need to require lib/init.php

$success_message = "";

// do the delete and then just show a success-message and the certificates list again
if ($action == 'delete') {
	$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
	if ($id > 0) {
		try {
			$json_result = Certificates::getLocal($userinfo, [
				'id' => $id
			])->delete();
			$success_message = sprintf($lng['domains']['ssl_certificate_removed'], $id);
		} catch (Exception $e) {
			Response::dynamic_error($e->getMessage());
		}
	}
}

$log->logAction(FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed domains::ssl_certificates");

try {
	$certificates_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.sslcertificates.php';
	$collection = (new Collection(Certificates::class, $userinfo))
		->has('domains', \Froxlor\Api\Commands\Domains::class, 'domainid', 'id')
		->has('customer', \Froxlor\Api\Commands\Customers::class, 'customerid', 'customerid')
		->withPagination($certificates_list_data['sslcertificates_list']['columns']);
} catch (Exception $e) {
	Response::dynamic_error($e->getMessage());
}

UI::twigBuffer('user/table.html.twig', [
	'listing' => Listing::format($collection, $certificates_list_data['sslcertificates_list']),
]);
UI::twigOutputBuffer();
