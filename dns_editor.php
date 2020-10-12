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

use Froxlor\Api\Commands\DomainZones as DomainZones;

// This file is being included in admin_domains and customer_domains
// and therefore does not need to require lib/init.php

$domain_id = isset($_GET['domain_id']) ? (int) $_GET['domain_id'] : null;

$record = isset($_POST['record']['record']) ? trim($_POST['record']['record']) : null;
$type = isset($_POST['record']['type']) ? $_POST['record']['type'] : 'A';
$prio = isset($_POST['record']['prio']) ? (int) $_POST['record']['prio'] : null;
$content = isset($_POST['record']['content']) ? trim($_POST['record']['content']) : null;
$ttl = isset($_POST['record']['ttl']) ? (int) $_POST['record']['ttl'] : 18000;

// get domain-name
$domain = \Froxlor\Dns\Dns::getAllowedDomainEntry($domain_id, AREA, $userinfo);

$errors = "";
$success_message = "";

// action for adding a new entry
if ($action == 'add_record' && ! empty($_POST)) {
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
	// get list
	$json_result = DomainZones::getLocal($userinfo, [
		'id' => $domain_id
	])->listing();
} catch (Exception $e) {
	\Froxlor\UI\Response::dynamic_error($e->getMessage());
}
$result = json_decode($json_result, true)['data'];
$dom_entries = $result['list'];

// show editor
$record_list = "";
$existing_entries = "";
$type_select = "";
$entriescount = 0;

if (! empty($dom_entries)) {
	$entriescount = count($dom_entries);
	foreach ($dom_entries as $entry) {
		$entry['content'] = wordwrap($entry['content'], 100, '<br>', true);
		eval("\$existing_entries.=\"" . \Froxlor\UI\Template::getTemplate("dns_editor/entry_bit", true) . "\";");
	}
}

// available types
$type_select_values = array(
	'A',
	'AAAA',
	'CAA',
	'CNAME',
	'DNAME',
	'LOC',
	'MX',
	'NS',
	'RP',
	'SRV',
	'SSHFP',
	'TXT'
);
asort($type_select_values);
foreach ($type_select_values as $_type) {
	$type_select .= \Froxlor\UI\HTML::makeoption($_type, $_type, $type);
}

eval("\$record_list=\"" . \Froxlor\UI\Template::getTemplate("dns_editor/list", true) . "\";");

try {
	$json_result = DomainZones::getLocal($userinfo, array(
		'id' => $domain_id
	))->get();
} catch (Exception $e) {
	\Froxlor\UI\Response::dynamic_error($e->getMessage());
}
$result = json_decode($json_result, true)['data'];
$zonefile = implode("\n", $result);

eval("echo \"" . \Froxlor\UI\Template::getTemplate("dns_editor/index", true) . "\";");
