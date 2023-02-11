<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

if (!defined('AREA')) {
	header("Location: index.php");
	exit();
}

use Froxlor\Api\Commands\DomainZones;
use Froxlor\Dns\Dns;
use Froxlor\UI\Collection;
use Froxlor\UI\HTML;
use Froxlor\UI\Listing;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;
use Froxlor\UI\Response;

// This file is being included in admin_domains and customer_domains
// and therefore does not need to require lib/init.php

$domain_id = (int)Request::any('domain_id');

$record = isset($_POST['dns_record']) ? trim($_POST['dns_record']) : null;
$type = isset($_POST['dns_type']) ? $_POST['dns_type'] : 'A';
$prio = isset($_POST['dns_mxp']) ? (int)$_POST['dns_mxp'] : null;
$content = isset($_POST['dns_content']) ? trim($_POST['dns_content']) : null;
$ttl = isset($_POST['dns_ttl']) ? (int)$_POST['dns_ttl'] : 18000;

// get domain-name
$domain = Dns::getAllowedDomainEntry($domain_id, AREA, $userinfo);

$errors = "";
$success_message = "";

// action for adding a new entry
if ($action == 'add_record' && !empty($_POST)) {
	try {
		DomainZones::getLocal($userinfo, [
			'id' => $domain_id,
			'record' => $record,
			'type' => $type,
			'prio' => $prio,
			'content' => $content,
			'ttl' => $ttl
		])->add();
		$success_message = lng('success.dns_record_added');
		$record = $prio = $content = "";
	} catch (Exception $e) {
		$errors = str_replace("\n", "<br>", $e->getMessage());
	}
} elseif ($action == 'delete') {
	$entry_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	HTML::askYesNo('dnsentry_reallydelete', $filename, [
		'id' => $entry_id,
		'domain_id' => $domain_id,
		'page' => $page,
		'action' => 'deletesure'
	], '', [
		'section' => 'domains',
		'page' => $page,
		'domain_id' => $domain_id
	]);
} elseif (isset($_POST['send']) && $_POST['send'] == 'send' && $action == 'deletesure' && !empty($_POST)) {
	$entry_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$domain_id = isset($_POST['domain_id']) ? (int)$_POST['domain_id'] : 0;
	// remove entry
	if ($entry_id > 0 && $domain_id > 0) {
		try {
			DomainZones::getLocal($userinfo, [
				'entry_id' => $entry_id,
				'id' => $domain_id
			])->delete();
			// success message (inline)
			$success_message = lng('success.dns_record_deleted');
		} catch (Exception $e) {
			$errors = str_replace("\n", "<br>", $e->getMessage());
		}
	}
}

// select all entries
try {
	$dns_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/tablelisting.dns.php';
	$collection = (new Collection(DomainZones::class, $userinfo, ['id' => $domain_id]))
		->withPagination($dns_list_data['dns_list']['columns'], $dns_list_data['dns_list']['default_sorting'], ['domain_id='.$domain_id]);
} catch (Exception $e) {
	Response::dynamicError($e->getMessage());
}

try {
	$json_result = DomainZones::getLocal($userinfo, [
		'id' => $domain_id
	])->get();
} catch (Exception $e) {
	Response::dynamicError($e->getMessage());
}
$result = json_decode($json_result, true)['data'];
$zonefile = implode("\n", $result);

$dns_add_data = include_once dirname(__FILE__) . '/lib/formfields/formfield.dns_add.php';

UI::view('user/dns-editor.html.twig', [
	'listing' => Listing::format($collection, $dns_list_data, 'dns_list', ['domain_id' => $domain_id]),
	'actions_links' => [
		[
			'href' => $linker->getLink([
				'section' => 'domains',
				'page' => 'domains',
				'action' => 'edit',
				'id' => $domain_id
			]),
			'label' => lng('admin.domain_edit'),
			'icon' => 'fa-solid fa-pen'
		],
		[
			'href' => $linker->getLink(['section' => 'domains', 'page' => 'domains']),
			'label' => lng('panel.backtooverview'),
			'icon' => 'fa-solid fa-reply'
		]
	],
	'formaction' => $linker->getLink(['section' => 'domains', 'action' => 'add_record', 'domain_id' => $domain_id]),
	'formdata' => $dns_add_data['dns_add'],
	// alert-box
	'type' => (!empty($errors) ? 'danger' : (!empty($success_message) ? 'success' : 'warning')),
	'alert_msg' => (!empty($errors) ? $errors : (!empty($success_message) ? $success_message : lng('dns.howitworks'))),
	'zonefile' => $zonefile,
]);
