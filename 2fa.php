<?php
if (! defined('AREA')) {
	header("Location: index.php");
	exit();
}
if (Settings::Get('2fa.enabled') != '1') {
	dynamic_error("2FA not activated");
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

// This file is being included in admin_index and customer_index
// and therefore does not need to require lib/init.php
if (AREA == 'admin') {
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `type_2fa` = :t2fa, `data_2fa` = :d2fa WHERE adminid = :id");
	$uid = $userinfo['adminid'];
} elseif (AREA == 'customer') {
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `type_2fa` = :t2fa, `data_2fa` = :d2fa WHERE customerid = :id");
	$uid = $userinfo['customerid'];
}
$success_message = "";

$tfa = new FroxlorTwoFactorAuth('Froxlor');

// do the delete and then just show a success-message
if ($action == 'delete') {
	Database::pexecute($upd_stmt, array(
		't2fa' => 0,
		'd2fa' => "",
		'id' => $uid
	));
	standard_success($lng['2fa']['2fa_removed']);
} elseif ($action == 'add') {
	$type = isset($_POST['type_2fa']) ? $_POST['type_2fa'] : '0';
	
	if ($type == 0 || $type == 1) {
		$data = "";
	}
	if ($type == 2) {
		// generate secret for TOTP
		$data = $tfa->createSecret();
	}
	Database::pexecute($upd_stmt, array(
		't2fa' => $type,
		'd2fa' => $data,
		'id' => $uid
	));
	standard_success(sprintf($lng['2fa']['2fa_added'], $filename, $s));
}

$log->logAction(USR_ACTION, LOG_NOTICE, "viewed 2fa::overview");

if ($userinfo['type_2fa'] == '0') {
	
	// available types
	$type_select_values = array(
		0 => '-',
		1 => 'E-Mail',
		2 => 'Authenticator'
	);
	asort($type_select_values);
	foreach ($type_select_values as $_val => $_type) {
		$type_select .= makeoption($_type, $_val);
	}
}
elseif ($userinfo['type_2fa'] == '1') {
	// email 2fa enabled
}
elseif ($userinfo['type_2fa'] == '2') {
	// authenticator 2fa enabled
	$ga_qrcode = $tfa->getQRCodeImageAsDataUri($userinfo['loginname'], $userinfo['data_2fa']);
}
eval("echo \"" . getTemplate("2fa/overview", true) . "\";");
