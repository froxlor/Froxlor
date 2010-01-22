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
 * @author     Froxlor Team <team@froxlor.org> (2010)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 * @version    $Id: index.php 2693 2009-03-27 19:31:48Z flo $
 */

define('AREA', 'login');

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if($action == '')
{
	$action = 'login';
}

if($action == 'login')
{
	if(isset($_POST['send'])
	   && $_POST['send'] == 'send')
	{
		$loginname = validate($_POST['loginname'], 'loginname');
		$password = validate($_POST['password'], 'password');
		$row = $db->query_first("SELECT `loginname` AS `customer` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `loginname`='" . $db->escape($loginname) . "'");

		if($row['customer'] == $loginname)
		{
			$table = "`" . TABLE_PANEL_CUSTOMERS . "`";
			$uid = 'customerid';
			$adminsession = '0';
		}
		else
		{
			$row = $db->query_first("SELECT `loginname` AS `admin` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `loginname`='" . $db->escape($loginname) . "'");

			if($row['admin'] == $loginname)
			{
				$table = "`" . TABLE_PANEL_ADMINS . "`";
				$uid = 'adminid';
				$adminsession = '1';
			}
			else
			{
				redirectTo('index.php', Array('showmessage' => '2'), true);
				exit;
			}
		}

		$userinfo = $db->query_first("SELECT * FROM $table WHERE `loginname`='" . $db->escape($loginname) . "'");

		if($userinfo['loginfail_count'] >= $settings['login']['maxloginattempts']
		   && $userinfo['lastlogin_fail'] > (time() - $settings['login']['deactivatetime']))
		{
			redirectTo('index.php', Array('showmessage' => '3'), true);
			exit;
		}
		elseif($userinfo['password'] == md5($password))
		{
			// login correct
			// reset loginfail_counter, set lastlogin_succ

			$db->query("UPDATE $table SET `lastlogin_succ`='" . time() . "', `loginfail_count`='0' WHERE `$uid`='" . (int)$userinfo[$uid] . "'");
			$userinfo['userid'] = $userinfo[$uid];
			$userinfo['adminsession'] = $adminsession;
		}
		else
		{
			// login incorrect

			$db->query("UPDATE $table SET `lastlogin_fail`='" . time() . "', `loginfail_count`=`loginfail_count`+1 WHERE `$uid`='" . (int)$userinfo[$uid] . "'");
			unset($userinfo);
			redirectTo('index.php', Array('showmessage' => '2'), true);
			exit;
		}

		if(isset($userinfo['userid'])
		   && $userinfo['userid'] != '')
		{
			$s = md5(uniqid(microtime(), 1));

			if(isset($_POST['language']))
			{
				$language = validate($_POST['language'], 'language');

				if($language == 'profile')
				{
					$language = $userinfo['def_language'];
				}
				elseif(!isset($languages[$language]))
				{
					$language = $settings['panel']['standardlanguage'];
				}
			}
			else
			{
				$language = $settings['panel']['standardlanguage'];
			}

			if($settings['session']['allow_multiple_login'] != '1')
			{
				$db->query("DELETE FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid` = '" . (int)$userinfo['userid'] . "' AND `adminsession` = '" . $db->escape($userinfo['adminsession']) . "'");
			}

			$db->query("INSERT INTO `" . TABLE_PANEL_SESSIONS . "` (`hash`, `userid`, `ipaddress`, `useragent`, `lastactivity`, `language`, `adminsession`) VALUES ('" . $db->escape($s) . "', '" . (int)$userinfo['userid'] . "', '" . $db->escape($remote_addr) . "', '" . $db->escape($http_user_agent) . "', '" . time() . "', '" . $db->escape($language) . "', '" . $db->escape($userinfo['adminsession']) . "')");

			if($userinfo['adminsession'] == '1')
			{
				redirectTo('admin_index.php', Array('s' => $s), true);
				exit;
			}
			else
			{
				redirectTo('customer_index.php', Array('s' => $s), true);
				exit;
			}
		}
		else
		{
			redirectTo('index.php', Array('showmessage' => '2'), true);
			exit;
		}
	}
	else
	{
		$language_options = '';
		$language_options.= makeoption($lng['login']['profile_lng'], 'profile', 'profile', true, true);

		while(list($language_file, $language_name) = each($languages))
		{
			$language_options.= makeoption($language_name, $language_file, 'profile', true);
		}

		$smessage = isset($_GET['showmessage']) ? (int)$_GET['showmessage'] : 0;
		$message = '';

		switch($smessage)
		{
			case 1:
				$message = $lng['pwdreminder']['success'];
				break;
			case 2:
				$message = $lng['error']['login'];
				break;
			case 3:
				$message = $lng['error']['login_blocked'];
				break;
			case 4:
				$message = $lng['error']['errorsendingmail'];
				break;
		}

		eval("echo \"" . getTemplate("login") . "\";");
	}
}

if($action == 'forgotpwd')
{
	if(isset($_POST['send'])
	   && $_POST['send'] == 'send')
	{
		$adminchecked = false;
		$loginname = validate($_POST['loginname'], 'loginname');
		$email = validateEmail($_POST['loginemail'], 'email');
		$sql = "SELECT `customerid`, `firstname`, `name`, `email`, `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "`
				WHERE `loginname`='" . $db->escape($loginname) . "'
				AND `email`='" . $db->escape($email) . "'";
		$result = $db->query($sql);

		if($db->num_rows() == 0)
		{
			$sql = "SELECT `adminid`, `firstname`, `name`, `email`, `loginname` FROM `" . TABLE_PANEL_ADMINS . "`
				WHERE `loginname`='" . $db->escape($loginname) . "'
				AND `email`='" . $db->escape($email) . "'";
			$result = $db->query($sql);
			$adminchecked = true;
		}

		$user = $db->fetch_array($result);

		if(($adminchecked && $settings['panel']['allow_preset_admin'] == '1')
		   || $adminchecked == false)
		{
			if($user !== false)
			{
				$password = substr(md5(uniqid(microtime(), 1)), 12, 6);

				if($adminchecked)
				{
					$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `password`='" . md5($password) . "'
							WHERE `loginname`='" . $user['loginname'] . "'
							AND `email`='" . $user['email'] . "'");
				}
				else
				{
					$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `password`='" . md5($password) . "'
							WHERE `loginname`='" . $user['loginname'] . "'
							AND `email`='" . $user['email'] . "'");
				}

				$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'), $db, $settings);
				$rstlog->logAction(USR_ACTION, LOG_WARNING, "Password for user '" . $user['loginname'] . "' has been reset!");
				$body = strtr($lng['pwdreminder']['body'], array('%s' => $user['firstname'] . ' ' . $user['name'], '%p' => $password));
				$mail->From = $settings['panel']['adminmail'];
				$mail->FromName = 'Froxlor';
				$mail->Subject = $lng['pwdreminder']['subject'];
				$mail->Body = $body;
				$mail->AddAddress($user['email'], $user['firstname'] . ' ' . $user['name']);

				if(!$mail->Send())
				{
					if($mail->ErrorInfo != '')
					{
						$mailerr_msg = $mail->ErrorInfo;
					}
					else
					{
						$mailerr_msg = $email;
					}

					$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'), $db, $settings);
					$rstlog->logAction(ADM_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
					redirectTo('index.php', Array('showmessage' => '4'), true);
					exit;
				}

				$mail->ClearAddresses();
				redirectTo('index.php', Array('showmessage' => '1'), true);
				exit;
			}
			else
			{
				$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'), $db, $settings);
				$rstlog->logAction(USR_ACTION, LOG_WARNING, "User '" . $loginname . "' tried to reset pwd but wasn't found in database!");
				$message = $lng['login']['usernotfound'];
			}

			unset($user, $adminchecked);
		}
		else
		{
			$message = '';
		}
	}
	else
	{
		$message = '';
	}

	if($settings['panel']['allow_preset'] != '1')
	{
		$message = $lng['pwdreminder']['notallowed'];
	}

	eval("echo \"" . getTemplate("fpwd") . "\";");
}

?>
