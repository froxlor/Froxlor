<?php
if (! defined('AREA'))
	die('You cannot access this file directly!');

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

$domain_id = isset($_GET['domain_id']) ? (int) $_GET['domain_id'] : null;

$record = isset($_POST['record']['record']) ? trim($_POST['record']['record']) : null;
$type = isset($_POST['record']['type']) ? $_POST['record']['type'] : 'A';
$prio = isset($_POST['record']['prio']) ? (int) $_POST['record']['prio'] : null;
$content = isset($_POST['record']['content']) ? trim($_POST['record']['content']) : null;
$ttl = isset($_POST['record']['ttl']) ? (int) $_POST['record']['ttl'] : 18000;

// get domain-name
$domain = getAllowedDomainEntry($domain_id, AREA, $userinfo, $idna_convert);

// select all entries
$sel_stmt = Database::prepare("SELECT * FROM `" . TABLE_DOMAIN_DNS . "` WHERE domain_id = :did");
Database::pexecute($sel_stmt, array(
	'did' => $domain_id
));
$dom_entries = $sel_stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = array();
$success_message = "";

// action for adding a new entry
if ($action == 'add_record' && ! empty($_POST)) {

	// validation
	if (empty($record)) {
		$record = "@";
	}

	$record = strtolower($record);

	if ($record != '@' && $record != '*') {
		// validate record
		if (strpos($record, '--') !== false) {
			$errors[] = $lng['error']['domain_nopunycode'];
		} else {
			$record = $idna_convert->encode($record);
			if ($type != 'SRV' && $type != 'TXT') {
				$check_dom = $record . '.example.com';
				if (! validateDomain($check_dom)) {
					$errors[] = sprintf($lng['error']['subdomainiswrong'], $idna_convert->decode($record));
				}
			}
			if (strlen($record) > 63) {
				$errors[] = $lng['error']['dns_record_toolong'];
			}
		}
	}

	// TODO regex validate content for invalid characters

	if ($ttl <= 0) {
		$ttl = 18000;
	}

	if (empty($content)) {
		$errors[] = $lng['error']['dns_content_empty'];
	}

	// types
	if ($type == 'A' && filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
		$errors[] = $lng['error']['dns_arec_noipv4'];
	} elseif ($type == 'AAAA' && filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
		$errors[] = $lng['error']['dns_aaaarec_noipv6'];
	} elseif ($type == 'MX') {
		if ($prio === null || $prio < 0) {
			$errors[] = $lng['error']['dns_mx_prioempty'];
		}
		// check for trailing dot
		if (substr($content, - 1) == '.') {
			// remove it for checks
			$content = substr($content, 0, - 1);
		}
		if (! validateDomain($content)) {
			$errors[] = $lng['error']['dns_mx_needdom'];
		} else {
			// check whether there is a CNAME-record for the same resource
			foreach ($dom_entries as $existing_entries) {
				$fqdn = $existing_entries['record'] . '.' . $domain;
				if ($existing_entries['type'] == 'CNAME' && $fqdn == $content) {
					$errors[] = $lng['error']['dns_mx_noalias'];
					break;
				}
			}
		}
		// append trailing dot (again)
		$content .= '.';
	} elseif ($type == 'CNAME') {
		// check for trailing dot
		if (substr($content, - 1) == '.') {
			// remove it for checks
			$content = substr($content, 0, - 1);
		}
		if (! validateDomain($content)) {
			$errors[] = $lng['error']['dns_cname_invaliddom'];
		} else {
			// check whether there are RR-records for the same resource
			foreach ($dom_entries as $existing_entries) {
				if (($existing_entries['type'] == 'A' || $existing_entries['type'] == 'AAAA' || $existing_entries['type'] == 'MX' || $existing_entries['type'] == 'NS') && $existing_entries['record'] == $record) {
					$errors[] = $lng['error']['dns_cname_nomorerr'];
					break;
				}
			}
		}
		// append trailing dot (again)
		$content .= '.';
	} elseif ($type == 'NS') {
		// check for trailing dot
		if (substr($content, - 1) == '.') {
			// remove it for checks
			$content = substr($content, 0, - 1);
		}
		if (! validateDomain($content)) {
			$errors[] = $lng['error']['dns_ns_invaliddom'];
		}
		// append trailing dot (again)
		$content .= '.';
	} elseif ($type == 'TXT' && ! empty($content)) {
		// check that TXT content is enclosed in " "
		$content = encloseTXTContent($content);
	} elseif ($type == 'SRV') {
		if ($prio === null || $prio < 0) {
			$errors[] = $lng['error']['dns_srv_prioempty'];
		}
		// check only last part of content, as it can look like:
		// _service._proto.name. TTL class SRV priority weight port target.
		$_split_content = explode(" ", $content);
		// SRV content must be [weight] [port] [target]
		if (count($_split_content) != 3) {
			$errors[] = $lng['error']['dns_srv_invalidcontent'];
		}
		$target = trim($_split_content[count($_split_content) - 1]);
		if ($target != '.') {
			// check for trailing dot
			if (substr($target, - 1) == '.') {
				// remove it for checks
				$target = substr($target, 0, - 1);
			}
		}
		if ($target != '.' && ! validateDomain($target)) {
			$errors[] = $lng['error']['dns_srv_needdom'];
		} else {
			// check whether there is a CNAME-record for the same resource
			foreach ($dom_entries as $existing_entries) {
				$fqdn = $existing_entries['record'] . '.' . $domain;
				if ($existing_entries['type'] == 'CNAME' && $fqdn == $target) {
					$errors[] = $lng['error']['dns_srv_noalias'];
					break;
				}
			}
		}
		// append trailing dot (again)
		if ($target != '.') {
			$content .= '.';
		}
	}

	$new_entry = array(
		'record' => $record,
		'type' => $type,
		'prio' => $prio,
		'content' => $content,
		'ttl' => $ttl,
		'domain_id' => $domain_id
	);
	ksort($new_entry);

	// check for duplicate
	foreach ($dom_entries as $existing_entry) {
		// compare serialized string of array
		$check_entry = $existing_entry;
		// new entry has no ID yet
		unset($check_entry['id']);
		// sort by key
		ksort($check_entry);
		// format integer fields to real integer (as they are read as string from the DB)
		$check_entry['prio'] = (int) $check_entry['prio'];
		$check_entry['ttl'] = (int) $check_entry['ttl'];
		$check_entry['domain_id'] = (int) $check_entry['domain_id'];
		// serialize both
		$check_entry = serialize($check_entry);
		$new = serialize($new_entry);
		// compare
		if ($check_entry === $new) {
			$errors[] = $lng['error']['dns_duplicate_entry'];
			unset($check_entry);
			break;
		}
	}

	if (empty($errors)) {
		$ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_DOMAIN_DNS . "` SET
			`record` = :record,
			`type` = :type,
			`prio` = :prio,
			`content` = :content,
			`ttl` = :ttl,
			`domain_id` = :domain_id
		");

		Database::pexecute($ins_stmt, $new_entry);

		$new_entry_id = Database::lastInsertId();

		// add temporary to the entries-array (no reread of DB necessary)
		$new_entry['id'] = $new_entry_id;
		$dom_entries[] = $new_entry;

		// success message (inline)
		$success_message = $lng['success']['dns_record_added'];

		$record = "";
		$type = 'A';
		$prio = "";
		$content = "";
		$ttl = "";

		// re-generate bind configs
		inserttask('4');
	} else {
		// show $errors
		$errors = implode("<br>", $errors);
	}
} elseif ($action == 'delete') {
	// remove entry
	$entry_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
	if ($entry_id > 0) {
		$del_stmt = Database::prepare("DELETE FROM `" . TABLE_DOMAIN_DNS . "` WHERE `id` = :id");
		Database::pexecute($del_stmt, array(
			'id' => $entry_id
		));

		// remove deleted entry from internal data array (no reread of DB necessary)
		$_t = $dom_entries;
		foreach ($_t as $idx => $entry) {
			if ($entry['id'] == $entry_id) {
				unset($dom_entries[$idx]);
				break;
			}
		}
		unset($_t);
		// success message (inline)
		$success_message = $lng['success']['dns_record_deleted'];

		// re-generate bind configs
		inserttask('4');
	}
}

// show editor
$record_list = "";
$existing_entries = "";
$type_select = "";
$entriescount = 0;

if (! empty($dom_entries)) {
	$entriescount = count($dom_entries);
	foreach ($dom_entries as $entry) {
		$entry['content'] = wordwrap($entry['content'], 100, '<br>', true);
		eval("\$existing_entries.=\"" . getTemplate("dns_editor/entry_bit", true) . "\";");
	}
}

// available types
$type_select_values = array(
	'A',
	'AAAA',
	'NS',
	'MX',
	'SRV',
	'TXT',
	'CNAME'
);
asort($type_select_values);
foreach ($type_select_values as $_type) {
	$type_select .= makeoption($_type, $_type, $type);
}

eval("\$record_list=\"" . getTemplate("dns_editor/list", true) . "\";");

$zone = createDomainZone($domain_id);
$zonefile = (string) $zone;
eval("echo \"" . getTemplate("dns_editor/index", true) . "\";");
