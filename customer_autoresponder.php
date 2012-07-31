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

// Required code

define('AREA', 'customer');
require ("./lib/init.php");

// Create new autoresponder

if($action == "add")
{
	if(isset($_POST['send'])
	   && $_POST['send'] == 'send')
	{
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

		if($date_from_off > -1)
		{
			$date_from = $_POST['date_from'];
			$ts_from = mktime(0, 0, 0, substr($date_from, 3, 2), substr($date_from, 0, 2), substr($date_from, 6, 4));
		}
		if($date_until_off > -1)
		{
			$date_until = $_POST['date_until'];
			$ts_until = mktime(0, 0, 0, substr($date_until, 3, 2), substr($date_until, 0, 2), substr($date_until, 6, 4));
		}

		if(empty($account)
		   || empty($subject)
		   || empty($message))
		{
			standard_error('missingfields');
		}

		// Does account exist?

		$result = $db->query("SELECT `email` FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid` = '" . (int)$userinfo['customerid'] . "' AND `email` = '" . $db->escape($account) . "' LIMIT 0,1");

		if($db->num_rows($result) == 0)
		{
			standard_error('accountnotexisting');
		}

		// Does autoresponder exist?

		$result = $db->query("SELECT `email` FROM `" . TABLE_MAIL_AUTORESPONDER . "` WHERE `customerid` = '" . (int)$userinfo['customerid'] . "' AND `email` = '" . $db->escape($account) . "' LIMIT 0,1");

		if($db->num_rows($result) == 1)
		{
			standard_error('autoresponderalreadyexists');
		}

		$db->query("INSERT INTO `" . TABLE_MAIL_AUTORESPONDER . "`
			SET `email` = '" . $db->escape($account) . "',
			`message` = '" . $db->escape($message) . "',
			`enabled` = '" . (int)$_POST['active'] . "',
			`date_from` = '" . (int)$ts_from . "',
			`date_until` = '" . (int)$ts_until . "',
			`subject` = '" . $db->escape($subject) . "',
			`customerid` = '" . $db->escape((int)$userinfo['customerid']) . "'
			");
		$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `email_autoresponder_used` = `email_autoresponder_used` + 1 WHERE `customerid` = '" . $db->escape((int)$userinfo['customerid']). "'");
		redirectTo($filename, Array('s' => $s));
	}

	// Get accounts

	$result = $db->query("SELECT `email` FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid` = '" . (int)$userinfo['customerid'] . "' AND `email` NOT IN (SELECT `email` FROM `" . TABLE_MAIL_AUTORESPONDER . "`) ORDER BY email ASC");

	if($db->num_rows($result) == 0)
	{
		standard_error('noemailaccount');
	}

	$accounts = '';

	while($row = $db->fetch_array($result))
	{
		$accounts.= "<option value=\"" . $row['email'] . "\">" . $row['email'] . "</option>";
	}

	$date_from_off = makecheckbox('date_from_off', $lng['panel']['not_activated'], '-1', false, '-1', true, true);
	$date_until_off = makecheckbox('date_until_off', $lng['panel']['not_activated'], '-1', false, '-1', true, true);

	//$isactive = makeyesno('active', '1', '0', '1');

	$autoresponder_add_data = include_once dirname(__FILE__).'/lib/formfields/customer/autoresponder/formfield.autoresponder_add.php';
	$autoresponder_add_form = htmlform::genHTMLForm($autoresponder_add_data);

	$title = $autoresponder_add_data['autoresponder_add']['title'];
	$image = $autoresponder_add_data['autoresponder_add']['image'];

	eval("echo \"" . getTemplate("autoresponder/autoresponder_add") . "\";");
}

// Edit autoresponder

else

if($action == "edit")
{
	if(isset($_POST['send'])
	   && $_POST['send'] == 'send')
	{
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

		if($date_from_off > -1)
		{
			$date_from = $_POST['date_from'];
			$ts_from = mktime(0, 0, 0, substr($date_from, 3, 2), substr($date_from, 0, 2), substr($date_from, 6, 4));
		}
		if($date_until_off > -1)
		{
			$date_until = $_POST['date_until'];
			$ts_until = mktime(0, 0, 0, substr($date_until, 3, 2), substr($date_until, 0, 2), substr($date_until, 6, 4));
		}

		if(empty($account)
		   || empty($subject)
		   || empty($message))
		{
			standard_error('missingfields');
		}

		// Does account exist?

		$result = $db->query("SELECT `email` FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid` = '" . (int)$userinfo['customerid'] . "' AND `email` = '" . $db->escape($account) . "' LIMIT 0,1");

		if($db->num_rows($result) == 0)
		{
			standard_error('accountnotexisting');
		}

		// Does autoresponder exist?

		$result = $db->query("SELECT `email` FROM `" . TABLE_MAIL_AUTORESPONDER . "` WHERE `customerid` = '" . (int)$userinfo['customerid'] . "' AND `email` = '" . $db->escape($account) . "' LIMIT 0,1");

		if($db->num_rows($result) == 0)
		{
			standard_error('invalidautoresponder');
		}

		$ResponderActive = 0;

		if(isset($_POST['active'])
		   && $_POST['active'] == '1')
		{
			$ResponderActive = 1;
		}

		$db->query("UPDATE `" . TABLE_MAIL_AUTORESPONDER . "`
			SET `message` = '" . $db->escape($message) . "',
			`enabled` = '" . (int)$ResponderActive . "',
			`date_from` = '" . (int)$ts_from . "',
			`date_until` = '" . (int)$ts_until . "',
			`subject` = '" . $db->escape($subject) . "'
			WHERE `email` = '" . $db->escape($account) . "'
			AND `customerid` = '" . $db->escape((int)$userinfo['customerid']) . "'
			");
		redirectTo($filename, Array('s' => $s));
	}

	$email = trim(htmlspecialchars($_GET['email']));

	// Get account data

	$result = $db->query("SELECT * FROM `" . TABLE_MAIL_AUTORESPONDER . "` WHERE `customerid` = '" . (int)$userinfo['customerid'] . "' AND `email` = '" . $db->escape($email) . "' LIMIT 0,1");

	if($db->num_rows($result) == 0)
	{
		standard_error('invalidautoresponder');
	}

	$row = $db->fetch_array($result);
	$subject = htmlspecialchars($row['subject']);
	$message = htmlspecialchars($row['message']);

	$date_from = (int)$row['date_from'];
	$date_until = (int)$row['date_until'];

	if($date_from == -1)
	{
		$deactivated = '-1';
		$date_from = '';
	}
	else
	{
		$deactivated = '0';
		$date_from = date('d-m-Y', $date_from);
	}
	$date_from_off = makecheckbox('date_from_off', $lng['panel']['not_activated'], '-1', false, $deactivated, true, true);

	if($date_until == -1)
	{
		$deactivated = '-1';
		$date_until = '';
	}
	else
	{
		$deactivated = '0';
		$date_until = date('d-m-Y', $date_until);
	}
	$date_until_off = makecheckbox('date_until_off', $lng['panel']['not_activated'], '-1', false, $deactivated, true, true);

	//$isactive = makeyesno('active', '1', '0', $row['enabled']);

	$autoresponder_edit_data = include_once dirname(__FILE__).'/lib/formfields/customer/autoresponder/formfield.autoresponder_edit.php';
	$autoresponder_edit_form = htmlform::genHTMLForm($autoresponder_edit_data);

	$title = $autoresponder_edit_data['autoresponder_edit']['title'];
	$image = $autoresponder_edit_data['autoresponder_edit']['image'];

	eval("echo \"" . getTemplate("autoresponder/autoresponder_edit") . "\";");
}

// Delete autoresponder

else

if($action == "delete")
{
	if(isset($_POST['send'])
	   && $_POST['send'] == 'send')
	{
		$account = trim($_POST['account']);

		// Does autoresponder exist?

		$result = $db->query("SELECT `email` FROM `" . TABLE_MAIL_AUTORESPONDER . "` WHERE `customerid` = '" . (int)$userinfo['customerid'] . "' AND `email` = '" . $db->escape($account) . "' LIMIT 0,1");

		if($db->num_rows($result) == 0)
		{
			standard_error('invalidautoresponder');
		}

		$db->query("DELETE FROM `" . TABLE_MAIL_AUTORESPONDER . "`
			WHERE `email` = '" . $db->escape($account) . "'
			AND `customerid` = '" . $db->escape((int)$userinfo['customerid']) . "'
			");
		$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `email_autoresponder_used` = `email_autoresponder_used` - 1 WHERE `customerid` = '" . $db->escape((int)$userinfo['customerid']). "'");
		redirectTo($filename, Array('s' => $s));
	}

	$email = trim(htmlspecialchars($_GET['email']));
	ask_yesno('autoresponderdelete', $filename, array('action' => $action, 'account' => $email));
}

// List existing autoresponders

else
{
	$autoresponder = '';
	$count = 0;
	$result = $db->query("SELECT * FROM `" . TABLE_MAIL_AUTORESPONDER . "` WHERE `customerid` = '" . (int)$userinfo['customerid'] . "' ORDER BY email ASC");

	while($row = $db->fetch_array($result))
	{
		if($row['date_from'] == -1 && $row['date_until'] == -1)
		{
			$activated_date = $lng['panel']['not_activated'];
		}
		elseif($row['date_from'] == -1 && $row['date_until'] != -1)
		{
			$activated_date = $lng['autoresponder']['date_until'].': '.date('d-m-Y', $row['date_until']);
		}
		elseif($row['date_from'] != -1 && $row['date_until'] == -1)
		{
			$activated_date = $lng['autoresponder']['date_from'].': '.date('d-m-Y', $row['date_from']);
		}
		else
		{
			$activated_date = date('d-m-Y', $row['date_from']) . ' - ' . date('d-m-Y', $row['date_until']);
		}
		eval("\$autoresponder.=\"" . getTemplate("autoresponder/autoresponder_autoresponder") . "\";");
		$count++;
	}

	eval("echo \"" . getTemplate("autoresponder/autoresponder") . "\";");
}
