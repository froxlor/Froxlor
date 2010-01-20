<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright	(c) the authors
 * @author		Michael Schlechtinger
 * @author		Sven Skrabal <info@nexpa.de>
 * @license		GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package		Panel
 * @version		$Id: customer_autoresponder.php 2692 2009-03-27 18:04:47Z flo $
 * @todo		- add function to select periods when responders are active
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
			`subject` = '" . $db->escape($subject) . "',
			`customerid` = '" . $db->escape((int)$userinfo['customerid']) . "'
			");
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

	eval("echo \"" . getTemplate("email/autoresponder_add") . "\";");
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
	$checked = '';

	if($row['enabled'] == 1)
	{
		$checked = "checked=\"checked\"";
	}

	eval("echo \"" . getTemplate("email/autoresponder_edit") . "\";");
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
		redirectTo($filename, Array('s' => $s));
	}

	$email = trim(htmlspecialchars($_GET['email']));
	ask_yesno('autoresponderdelete', $filename, array('action' => $action, 'account' => $email));
}

// List existing autoresponders

else 
{
	$autoresponder = '';
	$result = $db->query("SELECT * FROM `" . TABLE_MAIL_AUTORESPONDER . "` WHERE `customerid` = '" . (int)$userinfo['customerid'] . "' ORDER BY email ASC");

	while($row = $db->fetch_array($result))
	{
		eval("\$autoresponder.=\"" . getTemplate("email/autoresponder_autoresponder") . "\";");
	}

	eval("echo \"" . getTemplate("email/autoresponder") . "\";");
}

?>