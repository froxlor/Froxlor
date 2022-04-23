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
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

// This file is being included in admin_index and customer_index
// and therefore does not need to require lib/init.php

$del_stmt = Database::prepare("DELETE FROM `" . TABLE_API_KEYS . "` WHERE id = :id");
$success_message = "";
$id = (int) Request::get('id');

// do the delete and then just show a success-message and the apikeys list again
if ($action == 'delete' && $id > 0) {
	\Froxlor\UI\HTML::askYesNo('apikey_reallydelete', $filename, array(
		'id' => $id,
		'page' => $page,
		'action' => 'deletesure'
	), '', [
		'section' => 'index',
		'page' => $page
	]);
} elseif ($action == 'deletesure' && $id > 0) {
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
}

$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed api::api_keys");

// select all my (accessible) api-keys
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

//$keys_stmt_query .= $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit();

$keys_stmt = Database::prepare($keys_stmt_query);
Database::pexecute($keys_stmt, $qry_params);
$all_keys = $keys_stmt->fetchAll(PDO::FETCH_ASSOC);

$apikeys_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/tablelisting.apikeys.php';
$collection = [
	'data' => $all_keys,
	'pagination' => []
];

$tpl = 'user/table.html.twig';
if (!empty($success_message)) {
	$tpl = 'user/table-note.html.twig';
}

UI::view($tpl, [
	'listing' => \Froxlor\UI\Listing::formatFromArray($collection, $apikeys_list_data['apikeys_list']),
	'actions_links' => (int)$userinfo['api_allowed'] == 1 ? [[
		'href' => $linker->getLink(['section' => 'index', 'page' => $page, 'action' => 'add']),
		'label' => $lng['apikeys']['key_add']
	]] : null,
	// alert-box
	'type' => 'success',
	'alert_msg' => $success_message
]);
