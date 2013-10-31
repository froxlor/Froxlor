<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */

define('AREA', 'customer');
require('./lib/init.php');

if ($action == 'add') {
	// Create new autoresponder
	if (isset($_POST['send'])
	   && $_POST['send'] == 'send'
	) {
		$account = trim($_POST['account']);
		$subject = trim($_POST['subject']);
		$message = trim($_POST['message']);

		$date_from_off = isset($_POST['date_from_off']) ? -1 : 0;
		$date_until_off = isset($_POST['date_until_off']) ? -1 : 0;

		/*
		 * @TODO validate date (DD-MM-YYYY)
		 */
		$ts_from = -1;
		$ts_until = -1;

		if ($date_from_off > -1) {
			$date_from = $_POST['date_from'];
			$ts_from = mktime(0, 0, 0, substr($date_from, 3, 2), substr($date_from, 0, 2), substr($date_from, 6, 4));
		}
		if ($date_until_off > -1) {
			$date_until = $_POST['date_until'];
			$ts_until = mktime(0, 0, 0, substr($date_until, 3, 2), substr($date_until, 0, 2), substr($date_until, 6, 4));
		}

		if (empty($account)
		   || empty($subject)
		   || empty($message)
		) {
			standard_error('missingfields');
		}
		
		// Does account exist?
		$stmt = Database::prepare("SELECT `email` FROM `" . TABLE_MAIL_USERS . "`
			WHERE `customerid` = :customerid
			AND `email` = :account
			LIMIT 0,1"
		);
		Database::pexecute($stmt, array("account" => $account, "customerid" => $userinfo['customerid']));
		if (Database::num_rows() == 0) {
			standard_error('accountnotexisting');
		}

		// Does autoresponder exist?
		$stmt = Database::prepare("SELECT `email` FROM `" . TABLE_MAIL_AUTORESPONDER . "`
			WHERE `customerid` = :customerid
			AND `email` = :account
			LIMIT 0,1"
		);
		Database::pexecute($stmt, array("account" => $account, "customerid" => $userinfo['customerid']));
		if (Database::num_rows() == 1) {
			standard_error('autoresponderalreadyexists');
		}
		
		// Create autoresponder
		$stmt = Database::prepare("INSERT INTO `" . TABLE_MAIL_AUTORESPONDER . "`
			SET `email` = :account,
			`message` = :message,
			`enabled` = :enabled,
			`date_from` = :date_from,
			`date_until` = :date_until,
			`subject` = :subject,
			`customerid` = :customerid"
		);
		$params = array(
			"account" => $account,
			"message" => $message,
			"enabled" => $_POST['active'],
			"date_from" => $ts_from,
			"date_until" => $ts_until,
			"subject" => $subject,
			"customerid" => $userinfo['customerid']
		);
		Database::pexecute($stmt, $params);
		
		// Update email_autoresponder_used count
		$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
			SET `email_autoresponder_used` = `email_autoresponder_used` + 1
			WHERE `customerid` = :customerid"
		);
		Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));
		redirectTo($filename, Array('s' => $s));
	}

	// Get accounts
	$params = array("customerid" => $userinfo['customerid']);
	$acc_stmt = Database::prepare("SELECT `email` FROM `" . TABLE_MAIL_USERS . "`
		WHERE `customerid` = :customerid
		AND `email` NOT IN (SELECT `email` FROM `" . TABLE_MAIL_AUTORESPONDER . "`)
		ORDER BY email ASC"
	);
	Database::pexecute($acc_stmt, $params);
	if (Database::num_rows() == 0) {
		standard_error('noemailaccount');
	}

	$accounts = '';
	while ($row = $acc_stmt->fetch(PDO::FETCH_ASSOC)) {
		$accounts .= '<option value="' . $row['email'] . '">' . $row['email'] . '</option>';
	}

	$date_from_off = makecheckbox('date_from_off', $lng['panel']['not_activated'], '-1', false, '-1', true, true);
	$date_until_off = makecheckbox('date_until_off', $lng['panel']['not_activated'], '-1', false, '-1', true, true);

	//$isactive = makeyesno('active', '1', '0', '1');

	$autoresponder_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/autoresponder/formfield.autoresponder_add.php';
	$autoresponder_add_form = htmlform::genHTMLForm($autoresponder_add_data);

	$title = $autoresponder_add_data['autoresponder_add']['title'];
	$image = $autoresponder_add_data['autoresponder_add']['image'];

	eval("echo \"" . getTemplate('autoresponder/autoresponder_add') . "\";");
} elseif ($action == 'edit') {
	// Edit autoresponder
	if (isset($_POST['send'])
	   && $_POST['send'] == 'send'
	) {
		$account = trim($_POST['account']);
		$subject = trim($_POST['subject']);
		$message = trim($_POST['message']);

		$date_from_off = isset($_POST['date_from_off']) ? -1 : 0;
		$date_until_off = isset($_POST['date_until_off']) ? -1 : 0;

		/*
		 * @TODO validate date (DD-MM-YYYY)
		 */
		$ts_from = -1;
		$ts_until = -1;

		if ($date_from_off > -1) {
			$date_from = $_POST['date_from'];
			$ts_from = mktime(0, 0, 0, substr($date_from, 3, 2), substr($date_from, 0, 2), substr($date_from, 6, 4));
		}
		if ($date_until_off > -1) {
			$date_until = $_POST['date_until'];
			$ts_until = mktime(0, 0, 0, substr($date_until, 3, 2), substr($date_until, 0, 2), substr($date_until, 6, 4));
		}

		if (empty($account)
		   || empty($subject)
		   || empty($message)
		) {
			standard_error('missingfields');
		}

		// Does account exist?
		$stmt = Database::prepare("SELECT `email` FROM `" . TABLE_MAIL_USERS . "`
			WHERE `customerid` = :customerid
			AND `email` = :account
			LIMIT 0,1"
		);
		Database::pexecute($stmt, array("account" => $account, "customerid" => $userinfo['customerid']));
		if (Database::num_rows() == 0) {
			standard_error('accountnotexisting');
		}

		// Does autoresponder exist?
		$stmt = Database::prepare("SELECT `email` FROM `" . TABLE_MAIL_AUTORESPONDER . "`
			WHERE `customerid` = :customerid
			AND `email` = :account
			LIMIT 0,1"
		);
		Database::pexecute($stmt, array("account" => $account, "customerid" => $userinfo['customerid']));
		if (Database::num_rows() == 0) {
			standard_error('invalidautoresponder');
		}

		// Update autoresponder
		$stmt = Database::prepare("UPDATE `" . TABLE_MAIL_AUTORESPONDER . "`
			SET `message` = :message,
			`enabled` = :enabled,
			`date_from` = :date_from,
			`date_until` = :date_until,
			`subject` = :subject
			WHERE `email` = :account
			AND `customerid` = :customerid"
		);
		$params = array(
			"account" => $account,
			"message" => $message,
			"enabled" => $_POST['active'],
			"date_from" => $ts_from,
			"date_until" => $ts_until,
			"subject" => $subject,
			"customerid" => $userinfo['customerid']
		);
		Database::pexecute($stmt, $params);
		redirectTo($filename, Array('s' => $s));
	}

	$email = trim(htmlspecialchars($_GET['email']));

	// Get account data
	$acc_stmt = Database::prepare("SELECT * FROM `" . TABLE_MAIL_AUTORESPONDER . "`
		WHERE `customerid` = :customerid
		AND `email` = :account
		LIMIT 0,1"
	);
	Database::pexecute($acc_stmt, array("account" => $email, "customerid" => $userinfo['customerid']));
	if (Database::num_rows() == 0) {
		standard_error('invalidautoresponder');
	}

	$row = $acc_stmt->fetch(PDO::FETCH_ASSOC);
	$subject = htmlspecialchars($row['subject']);
	$message = htmlspecialchars($row['message']);

	$date_from = (int)$row['date_from'];
	$date_until = (int)$row['date_until'];

	if ($date_from == -1) {
		$deactivated = '-1';
		$date_from = '';
	} else {
		$deactivated = '0';
		$date_from = date('d-m-Y', $date_from);
	}
	$date_from_off = makecheckbox('date_from_off', $lng['panel']['not_activated'], '-1', false, $deactivated, true, true);

	if ($date_until == -1) {
		$deactivated = '-1';
		$date_until = '';
	} else {
		$deactivated = '0';
		$date_until = date('d-m-Y', $date_until);
	}
	$date_until_off = makecheckbox('date_until_off', $lng['panel']['not_activated'], '-1', false, $deactivated, true, true);

	//$isactive = makeyesno('active', '1', '0', $row['enabled']);

	$autoresponder_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/autoresponder/formfield.autoresponder_edit.php';
	$autoresponder_edit_form = htmlform::genHTMLForm($autoresponder_edit_data);

	$title = $autoresponder_edit_data['autoresponder_edit']['title'];
	$image = $autoresponder_edit_data['autoresponder_edit']['image'];

	eval("echo \"" . getTemplate('autoresponder/autoresponder_edit') . "\";");
} elseif ($action == 'delete') {
	// Delete autoresponder
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$account = trim($_POST['account']);

		// Does autoresponder exist?
		$stmt = Database::prepare("SELECT `email` FROM `" . TABLE_MAIL_AUTORESPONDER . "`
			WHERE `customerid` = :customerid
			AND `email` = :account
			LIMIT 0,1"
		);
		Database::pexecute($stmt, array("account" => $account, "customerid" => $userinfo['customerid']));
		if (Database::num_rows() == 0) {
			standard_error('invalidautoresponder');
		}
		
		// Delete autoresponder
		$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_AUTORESPONDER . "`
			WHERE `email` = :account
			AND `customerid` = :customerid"
		);
		Database::pexecute($stmt, array("account" => $account, "customerid" => $userinfo['customerid']));
			
		// Update email_autoresponder_used count
		$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
			SET `email_autoresponder_used` = `email_autoresponder_used` - 1
			WHERE `customerid` = :customerid"
		);
		Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));
		redirectTo($filename, Array('s' => $s));
	}

	$email = trim(htmlspecialchars($_GET['email']));
	ask_yesno('autoresponderdelete', $filename, array('action' => $action, 'account' => $email));
} else {
	// List existing autoresponders
	$autoresponder = '';
	$count = 0;
	$stmt = Database::prepare("SELECT * FROM `" . TABLE_MAIL_AUTORESPONDER . "`
		WHERE `customerid` = :customerid
		ORDER BY email ASC"
	);
	Database::pexecute($stmt, array("customerid" => $userinfo['customerid']));

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if ($row['date_from'] == -1 && $row['date_until'] == -1) {
			$activated_date = $lng['panel']['not_activated'];
		} elseif($row['date_from'] == -1 && $row['date_until'] != -1) {
			$activated_date = $lng['autoresponder']['date_until'].': '.date('d-m-Y', $row['date_until']);
		} elseif($row['date_from'] != -1 && $row['date_until'] == -1) {
			$activated_date = $lng['autoresponder']['date_from'].': '.date('d-m-Y', $row['date_from']);
		} else {
			$activated_date = date('d-m-Y', $row['date_from']) . ' - ' . date('d-m-Y', $row['date_until']);
		}
		eval("\$autoresponder.=\"" . getTemplate('autoresponder/autoresponder_autoresponder') . "\";");
		$count++;
	}

	eval("echo \"" . getTemplate('autoresponder/autoresponder') . "\";");
}
