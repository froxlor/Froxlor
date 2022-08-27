<?php
if (!defined('AREA')) {
	header("Location: index.php");
	exit();
}

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2018 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2018-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Panel
 * @since 0.10.0
 *       
 */

use Froxlor\Database\Database;

// This file is being included in admin_index and customer_index
// and therefore does not need to require lib/init.php

$del_stmt = Database::prepare("DELETE FROM `" . TABLE_API_KEYS . "` WHERE id = :id");
$success_message = "";
$id = isset($_POST['id']) ? (int) $_POST['id'] : (isset($_GET['id']) ? (int) $_GET['id'] : 0);
$area = AREA;

// do the delete and then just show a success-message and the apikeys list again
if ($action == 'delete') {
	if ($id > 0) {
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			$chk = (AREA == 'admin' && $userinfo['customers_see_all'] == '1') ? true : false;
			if (AREA == 'customer') {
				$chk_stmt = Database::prepare("
					SELECT c.customerid FROM `" . TABLE_PANEL_CUSTOMERS . "` c
					LEFT JOIN `" . TABLE_API_KEYS . "` ak ON ak.customerid = c.customerid
					WHERE ak.`id` = :id AND c.`customerid` = :cid
				");
				$chk = Database::pexecute_first($chk_stmt, array(
					'id' => $id,
					'cid' => $userinfo['customerid']
				));
			} elseif (AREA == 'admin' && $userinfo['customers_see_all'] == '0') {
				$chk_stmt = Database::prepare("
					SELECT a.adminid FROM `" . TABLE_PANEL_ADMINS . "` a
					LEFT JOIN `" . TABLE_API_KEYS . "` ak ON ak.adminid = a.adminid
					WHERE ak.`id` = :id AND a.`adminid` = :aid
				");
				$chk = Database::pexecute_first($chk_stmt, array(
					'id' => $id,
					'aid' => $userinfo['adminid']
				));
			}
			if ($chk !== false) {
				Database::pexecute($del_stmt, array(
					'id' => $id
				));
				$success_message = sprintf($lng['apikeys']['apikey_removed'], $id);
			}
		} else {
			\Froxlor\UI\HTML::askYesNo('api_reallydelete', $filename, array(
				'page' => $page,
				'action' => $action,
				'id' => $id
			), $id);
		}
	}
} elseif ($action == 'add') {
	$ins_stmt = Database::prepare("
		INSERT INTO `" . TABLE_API_KEYS . "` SET
		`apikey` = :key, `secret` = :secret, `adminid` = :aid, `customerid` = :cid, `valid_until` = '-1', `allowed_from` = ''
	");
	// customer generates for himself, admins will see a customer-select-box later
	if (AREA == 'admin') {
		$cid = 0;
	} elseif (AREA == 'customer') {
		$cid = $userinfo['customerid'];
	}
	$key = hash('sha256', openssl_random_pseudo_bytes(64 * 64));
	$secret = hash('sha512', openssl_random_pseudo_bytes(64 * 64 * 4));
	Database::pexecute($ins_stmt, array(
		'key' => $key,
		'secret' => $secret,
		'aid' => $userinfo['adminid'],
		'cid' => $cid
	));
	$success_message = $lng['apikeys']['apikey_added'];
} elseif ($action == 'jqEditApiKey') {
	$keyid = isset($_POST['id']) ? (int) $_POST['id'] : 0;
	$allowed_from = isset($_POST['allowed_from']) ? $_POST['allowed_from'] : "";
	$valid_until = isset($_POST['valid_until']) ? (int) $_POST['valid_until'] : -1;

	// validate allowed_from
	if (!empty($allowed_from)) {
		$ip_list = array_map('trim', explode(",", $allowed_from));
		$_check_list = $ip_list;
		foreach ($_check_list as $idx => $ip) {
			if (\Froxlor\Validate\Validate::validate_ip2($ip, true, 'invalidip', true, true) == false) {
				unset($ip_list[$idx]);
			}
		}
		$ip_list = array_map('inet_ntop', array_map('inet_pton', $ip_list));
		$allowed_from = implode(",", array_unique($ip_list));
	}

	if ($valid_until <= 0 || !is_numeric($valid_until)) {
		$valid_until = -1;
	}

	$upd_stmt = Database::prepare("
		UPDATE `" . TABLE_API_KEYS . "` SET
		`valid_until` = :vu, `allowed_from` = :af
		WHERE `id` = :keyid AND `adminid` = :aid AND `customerid` = :cid
	");
	if (AREA == 'admin') {
		$cid = 0;
	} elseif (AREA == 'customer') {
		$cid = $userinfo['customerid'];
	}
	Database::pexecute($upd_stmt, array(
		'keyid' => $keyid,
		'af' => $allowed_from,
		'vu' => $valid_until,
		'aid' => $userinfo['adminid'],
		'cid' => $cid
	));
	echo json_encode(true);
	exit();
}

$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed api::api_keys");

// select all my (accessible) certificates
$keys_stmt_query = "SELECT ak.*, c.loginname, a.loginname as adminname
	FROM `" . TABLE_API_KEYS . "` ak
	LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` c ON `c`.`customerid` = `ak`.`customerid`
	LEFT JOIN `" . TABLE_PANEL_ADMINS . "` a ON `a`.`adminid` = `ak`.`adminid`
	WHERE ";

$qry_params = array();
if (AREA == 'admin' && $userinfo['customers_see_all'] == '0') {
	// admin with only customer-specific permissions
	$keys_stmt_query .= "ak.adminid = :adminid ";
	$qry_params['adminid'] = $userinfo['adminid'];
	$fields = array(
		'a.loginname' => $lng['login']['username']
	);
} elseif (AREA == 'customer') {
	// customer-area
	$keys_stmt_query .= "ak.customerid = :cid ";
	$qry_params['cid'] = $userinfo['customerid'];
	$fields = array(
		'c.loginname' => $lng['login']['username']
	);
} else {
	// admin who can see all customers / reseller / admins
	$keys_stmt_query .= "1 ";
	$fields = array(
		'a.loginname' => $lng['login']['username']
	);
}

$paging = new \Froxlor\UI\Paging($userinfo, TABLE_API_KEYS, $fields);
$keys_stmt_query .= $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit();

$keys_stmt = Database::prepare($keys_stmt_query);
Database::pexecute($keys_stmt, $qry_params);
$all_keys = $keys_stmt->fetchAll(PDO::FETCH_ASSOC);
$apikeys = "";

if (count($all_keys) == 0) {
	$count = 0;
	$message = $lng['apikeys']['no_api_keys'];
	$sortcode = "";
	$searchcode = "";
	$pagingcode = "";
	eval("\$apikeys.=\"" . \Froxlor\UI\Template::getTemplate("api_keys/keys_error", true) . "\";");
} else {
	$count = count($all_keys);
	$paging->setEntries($count);
	$sortcode = $paging->getHtmlSortCode($lng);
	$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
	$searchcode = $paging->getHtmlSearchCode($lng);
	$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);

	foreach ($all_keys as $idx => $key) {
		if ($paging->checkDisplay($idx)) {

			// my own key
			$isMyKey = false;
			if ($key['adminid'] == $userinfo['adminid'] && ((AREA == 'admin' && $key['customerid'] == 0) || (AREA == 'customer' && $key['customerid'] == $userinfo['customerid']))) {
				// this is mine
				$isMyKey = true;
			}

			$adminCustomerLink = "";
			if (AREA == 'admin') {
				if ($isMyKey) {
					$adminCustomerLink = $key['adminname'];
				} else {
					$adminCustomerLink = '<a href="' . $linker->getLink(array(
						'section' => (empty($key['customerid']) ? 'admins' : 'customers'),
						'page' => (empty($key['customerid']) ? 'admins' : 'customers'),
						'action' => 'su',
						'id' => (empty($key['customerid']) ? $key['adminid'] : $key['customerid'])
					)) . '" rel="external">' . (empty($key['customerid']) ? $key['adminname'] : $key['loginname']) . '</a>';
				}
			} else {
				// customer do not need links
				$adminCustomerLink = $key['loginname'];
			}

			// escape stuff
			$row = \Froxlor\PhpHelper::htmlentitiesArray($key);

			// shorten keys
			$row['_apikey'] = substr($row['apikey'], 0, 20) . '...';
			$row['_secret'] = substr($row['secret'], 0, 20) . '...';

			// check whether the api key is not valid anymore
			$isValid = true;
			if ($row['valid_until'] >= 0) {
				if ($row['valid_until'] < time()) {
					$isValid = false;
				}
				// format
				$row['valid_until'] = date('Y-m-d', $row['valid_until']);
			} else {
				// infinity
				$row['valid_until'] = "";
			}
			eval("\$apikeys.=\"" . \Froxlor\UI\Template::getTemplate("api_keys/keys_key", true) . "\";");
		} else {
			continue;
		}
	}
}
eval("echo \"" . \Froxlor\UI\Template::getTemplate("api_keys/keys_list", true) . "\";");
