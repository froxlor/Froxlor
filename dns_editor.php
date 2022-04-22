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

use Froxlor\Api\Commands\DomainZones;
use Froxlor\UI\Request;
use Froxlor\UI\Panel\UI;

// This file is being included in admin_domains and customer_domains
// and therefore does not need to require lib/init.php

$domain_id = (int) Request::get('domain_id');

$record = isset($_POST['dns_record']) ? trim($_POST['dns_record']) : null;
$type = isset($_POST['dns_type']) ? $_POST['dns_type'] : 'A';
$prio = isset($_POST['dns_mxp']) ? (int) $_POST['dns_mxp'] : null;
$content = isset($_POST['dns_content']) ? trim($_POST['dns_content']) : null;
$ttl = isset($_POST['record']['ttl']) ? (int) $_POST['record']['ttl'] : 18000;

// get domain-name
$domain = \Froxlor\Dns\Dns::getAllowedDomainEntry($domain_id, AREA, $userinfo);

$errors = "";
$success_message = "";

// action for adding a new entry
if ($action == 'add_record' && !empty($_POST)) {
	try {
		DomainZones::getLocal($userinfo, array(
			'id' => $domain_id,
			'record' => $record,
			'type' => $type,
			'prio' => $prio,
			'content' => $content,
			'ttl' => $ttl
		))->add();
		$success_message = $lng['success']['dns_record_added'];
		$record = $prio = $content = "";
	} catch (Exception $e) {
		$errors = str_replace("\n", "<br>", $e->getMessage());
	}
} elseif ($action == 'delete') {
	// remove entry
	$entry_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
	if ($entry_id > 0) {
		try {
			DomainZones::getLocal($userinfo, array(
				'entry_id' => $entry_id,
				'id' => $domain_id
			))->delete();
			// success message (inline)
			$success_message = $lng['success']['dns_record_deleted'];
		} catch (Exception $e) {
			$errors = str_replace("\n", "<br>", $e->getMessage());
		}
	}
}

// select all entries
try {
	$dns_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/tablelisting.dns.php';
	$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\DomainZones::class, $userinfo, ['id' => $domain_id]))
		->withPagination($dns_list_data['dns_list']['columns']);
} catch (Exception $e) {
	\Froxlor\UI\Response::dynamic_error($e->getMessage());
}

try {
	$json_result = DomainZones::getLocal($userinfo, array(
		'id' => $domain_id
	))->get();
} catch (Exception $e) {
	\Froxlor\UI\Response::dynamic_error($e->getMessage());
}
$result = json_decode($json_result, true)['data'];
$zonefile = implode("\n", $result);

$dns_add_data = include_once dirname(__FILE__) . '/lib/formfields/formfield.dns_add.php';

UI::view('user/dns-editor.html.twig', [
	'listing' => \Froxlor\UI\Listing::format($collection, $dns_list_data, 'dns_list') ,
	'actions_links' => [[
		'class' => 'btn-secondary',
		'href' => $linker->getLink(['section' => 'domains', 'page' => 'domains', 'action' => 'edit', 'id' => $domain_id]),
		'label' => $lng['panel']['edit'],
		'icon' => 'fa fa-pen'
	], [
		'class' => 'btn-secondary',
		'href' => $linker->getLink(['section' => 'domains', 'page' => 'domains']),
		'label' => $lng['menue']['domains']['domains'],
		'icon' => 'fa fa-globe'
	]],
	'formaction' => $linker->getLink(array('section' => 'domains', 'action' => 'add_record', 'domain_id' => $domain_id)),
	'formdata' => $dns_add_data['dns_add'],
	// alert-box
	'type' => (!empty($errors) ? 'danger' : (!empty($success_message) ? 'success' : 'warning')),
	'alert_msg' => (!empty($errors) ? $errors : (!empty($success_message) ? $success_message : $lng['dns']['howitworks'])),
	'zonefile' => $zonefile
]);
