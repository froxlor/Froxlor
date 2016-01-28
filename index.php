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

define('AREA', 'login');
require './lib/init.php';

if ($action == '') {
	$action = 'login';
}

if ($action == 'login') {
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$loginname = validate($_POST['loginname'], 'loginname');
		$password = validate($_POST['password'], 'password');

		$stmt = Database::prepare("SELECT `loginname` AS `customer` FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `loginname`= :loginname"
		);
		Database::pexecute($stmt, array("loginname" => $loginname));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row['customer'] == $loginname) {
			$table = "`" . TABLE_PANEL_CUSTOMERS . "`";
			$uid = 'customerid';
			$adminsession = '0';
			$is_admin = false;
		} else {
			$is_admin = true;
			if ((int)Settings::Get('login.domain_login') == 1) {
				$domainname = $idna_convert->encode(preg_replace(array('/\:(\d)+$/', '/^https?\:\/\//'), '', $loginname));
				$stmt = Database::prepare("SELECT `customerid` FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `domain` = :domain"
				);
				Database::pexecute($stmt, array("domain" => $domainname));
				$row2 = $stmt->fetch(PDO::FETCH_ASSOC);

				if (isset($row2['customerid']) && $row2['customerid'] > 0) {
					$loginname = getCustomerDetail($row2['customerid'], 'loginname');
					if ($loginname !== false) {
						$stmt = Database::prepare("SELECT `loginname` AS `customer` FROM `" . TABLE_PANEL_CUSTOMERS . "`
							WHERE `loginname`= :loginname"
						);
						Database::pexecute($stmt, array("loginname" => $loginname));
						$row3 = $stmt->fetch(PDO::FETCH_ASSOC);
						if ($row3['customer'] == $loginname) {
							$table = "`" . TABLE_PANEL_CUSTOMERS . "`";
							$uid = 'customerid';
							$adminsession = '0';
							$is_admin = false;
						}
					}
				}
			}
		}

		if (hasUpdates($version) && $is_admin == false) {
			redirectTo('index.php');
			exit;
		}

		if ($is_admin) {
			if (hasUpdates($version)) {
				$stmt = Database::prepare("SELECT `loginname` AS `admin` FROM `" . TABLE_PANEL_ADMINS . "`
					WHERE `loginname`= :loginname
					AND `change_serversettings` = '1'"
				);
				Database::pexecute($stmt, array("loginname" => $loginname));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if (!isset($row['admin'])) {
					// not an admin who can see updates
					redirectTo('index.php');
					exit;
				}
			} else {
				$stmt = Database::prepare("SELECT `loginname` AS `admin` FROM `" . TABLE_PANEL_ADMINS . "`
					WHERE `loginname`= :loginname"
				);
				Database::pexecute($stmt, array("loginname" => $loginname));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
			}

			if ($row['admin'] == $loginname) {
				$table = "`" . TABLE_PANEL_ADMINS . "`";
				$uid = 'adminid';
				$adminsession = '1';
			} else {
				// Log failed login
				$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => $_SERVER['REMOTE_ADDR']));
				$rstlog->logAction(LOGIN_ACTION, LOG_WARNING, "Unknown user '" . $loginname . "' tried to login.");

				redirectTo('index.php', array('showmessage' => '2'));
				exit;
			}
		}

		$userinfo_stmt = Database::prepare("SELECT * FROM $table
			WHERE `loginname`= :loginname"
		);
		Database::pexecute($userinfo_stmt, array("loginname" => $loginname));
		$userinfo = $userinfo_stmt->fetch(PDO::FETCH_ASSOC);

		if ($userinfo['loginfail_count'] >= Settings::Get('login.maxloginattempts') && $userinfo['lastlogin_fail'] > (time() - Settings::Get('login.deactivatetime'))) {
			redirectTo('index.php', array('showmessage' => '3'));
			exit;
		} elseif (validatePasswordLogin($userinfo, $password, $table, $uid)) {
		    // only show "you're banned" if the login was successful
		    // because we don't want to publish that the user does exist
		    if ($userinfo['deactivated']) {
		        unset($userinfo);
		        redirectTo('index.php', array('showmessage' => '5'));
		        exit;
		    } else {
		        // login correct
		        // reset loginfail_counter, set lastlogin_succ
		        $stmt = Database::prepare("UPDATE $table
		              SET `lastlogin_succ`= :lastlogin_succ, `loginfail_count`='0'
		              WHERE `$uid`= :uid"
		        );
		        Database::pexecute($stmt, array("lastlogin_succ" => time(), "uid" => $userinfo[$uid]));
		        $userinfo['userid'] = $userinfo[$uid];
		        $userinfo['adminsession'] = $adminsession;
		    }
		} else {
			// login incorrect
			$stmt = Database::prepare("UPDATE $table
				SET `lastlogin_fail`= :lastlogin_fail, `loginfail_count`=`loginfail_count`+1
				WHERE `$uid`= :uid"
			);
			Database::pexecute($stmt, array("lastlogin_fail" => time(), "uid" => $userinfo[$uid]));

			// Log failed login
			$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => $_SERVER['REMOTE_ADDR']));
			$rstlog->logAction(LOGIN_ACTION, LOG_WARNING, "User '" . $loginname . "' tried to login with wrong password.");

			unset($userinfo);
			redirectTo('index.php', array('showmessage' => '2'));
			exit;
		}

		if (isset($userinfo['userid']) && $userinfo['userid'] != '') {
			$s = md5(uniqid(microtime(), 1));

			if (isset($_POST['language'])) {
				$language = validate($_POST['language'], 'language');
				if ($language == 'profile') {
					$language = $userinfo['def_language'];
				} elseif (!isset($languages[$language])) {
					$language = Settings::Get('panel.standardlanguage');
				}
			} else {
				$language = Settings::Get('panel.standardlanguage');
			}

			if (isset($userinfo['theme']) && $userinfo['theme'] != '') {
				$theme = $userinfo['theme'];
			} else {
				$theme = Settings::Get('panel.default_theme');
			}

			if (Settings::Get('session.allow_multiple_login') != '1') {
				$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_SESSIONS . "`
					WHERE `userid` = :uid
					AND `adminsession` = :adminsession"
				);
				Database::pexecute($stmt, array("uid" => $userinfo['userid'], "adminsession" => $userinfo['adminsession']));
			}

			// check for field 'theme' in session-table, refs #607
			// Changed with #1287 to new method
			$theme_field = false;
			$stmt = Database::query("SHOW COLUMNS FROM panel_sessions LIKE 'theme'");
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if ($row['Field'] == "theme") {
					$has_theme = true;
				}
			}

			$params = array(
				"hash" => $s,
				"userid" => $userinfo['userid'],
				"ipaddress" => $remote_addr,
				"useragent" => $http_user_agent,
				"lastactivity" => time(),
				"language" => $language,
				"adminsession" => $userinfo['adminsession']
			);

			if ($has_theme) {
				$params["theme"] = $theme;
				$stmt = Database::prepare("INSERT INTO `" . TABLE_PANEL_SESSIONS . "`
					(`hash`, `userid`, `ipaddress`, `useragent`, `lastactivity`, `language`, `adminsession`, `theme`)
					VALUES (:hash, :userid, :ipaddress, :useragent, :lastactivity, :language, :adminsession, :theme)"
				);
			} else {
				$stmt = Database::prepare("INSERT INTO `" . TABLE_PANEL_SESSIONS . "`
					(`hash`, `userid`, `ipaddress`, `useragent`, `lastactivity`, `language`, `adminsession`)
					VALUES (:hash, :userid, :ipaddress, :useragent, :lastactivity, :language, :adminsession)"
				);
			}
			Database::pexecute($stmt, $params);

			$qryparams = array();
			if (isset($_POST['qrystr']) && $_POST['qrystr'] != "") {
				parse_str(urldecode($_POST['qrystr']), $qryparams);
			}
			$qryparams['s'] = $s;

			if ($userinfo['adminsession'] == '1') {
				if (hasUpdates($version)) {
					redirectTo('admin_updates.php', array('s' => $s));
				} else {
					if (isset($_POST['script']) && $_POST['script'] != "") {
						redirectTo($_POST['script'], $qryparams);
					} else {
						redirectTo('admin_index.php', $qryparams);
					}
				}
			} else {
				if (isset($_POST['script']) && $_POST['script'] != "") {
					redirectTo($_POST['script'], $qryparams);
				} else {
					redirectTo('customer_index.php', $qryparams);
				}
			}
		} else {
			redirectTo('index.php', array('showmessage' => '2'));
		}
		exit;
	} else {
		$language_options = '';
		$language_options .= makeoption($lng['login']['profile_lng'], 'profile', 'profile', true, true);

		while (list($language_file, $language_name) = each($languages)) {
			$language_options .= makeoption($language_name, $language_file, 'profile', true);
		}

		$smessage = isset($_GET['showmessage']) ? (int)$_GET['showmessage'] : 0;
		$message = '';
		$successmessage = '';

		switch ($smessage) {
		case 1:
			$successmessage = $lng['pwdreminder']['success'];
			break;
		case 2:
			$message = $lng['error']['login'];
			break;
		case 3:
			$message = sprintf($lng['error']['login_blocked'], Settings::Get('login.deactivatetime'));
			break;
		case 4:
			$cmail = isset($_GET['customermail']) ? $_GET['customermail'] : 'unknown';
			$message = str_replace('%s', $cmail, $lng['error']['errorsendingmail']);
			break;
		case 5:
			$message = $lng['error']['user_banned'];
			break;
		case 6:
			$successmessage = $lng['pwdreminder']['changed'];
			break;
		case 7:
			$message = $lng['pwdreminder']['wrongcode'];
			break;
		case 8:
		    $message = $lng['pwdreminder']['notallowed'];
		    break;
		}

		$update_in_progress = '';
		if (hasUpdates($version)) {
			$update_in_progress = $lng['update']['updateinprogress_onlyadmincanlogin'];
		}
		
		// Pass the last used page if needed
		$lastscript = "";
		if (isset($_REQUEST['script']) && $_REQUEST['script'] != "") {
			$lastscript = $_REQUEST['script'];

			if (!file_exists(__DIR__."/".$lastscript)) {
				$lastscript = "";
			}
		}
		$lastqrystr = "";
		if (isset($_REQUEST['qrystr']) && $_REQUEST['qrystr'] != "") {
			$lastqrystr = strip_tags($_REQUEST['qrystr']);
		}

		eval("echo \"" . getTemplate('login') . "\";");
	}
}

if ($action == 'forgotpwd') {
	$adminchecked = false;
	$message = '';

	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$loginname = validate($_POST['loginname'], 'loginname');
		$email = validateEmail($_POST['loginemail'], 'email');
		$result_stmt = Database::prepare("SELECT `adminid`, `customerid`, `firstname`, `name`, `company`, `email`, `loginname`, `def_language`, `deactivated` FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `loginname`= :loginname
			AND `email`= :email"
		);
		Database::pexecute($result_stmt, array("loginname" => $loginname, "email" => $email));

		if (Database::num_rows() == 0) {
			$result_stmt = Database::prepare("SELECT `adminid`, `name`, `email`, `loginname`, `def_language`, `deactivated` FROM `" . TABLE_PANEL_ADMINS . "`
				WHERE `loginname`= :loginname
				AND `email`= :email"
			);
			Database::pexecute($result_stmt, array("loginname" => $loginname, "email" => $email));

			if (Database::num_rows() > 0) {
				$adminchecked = true;
			} else {
				$result_stmt = null;
			}
		}

		if ($result_stmt !== null) {
			$user = $result_stmt->fetch(PDO::FETCH_ASSOC);

			/* Check whether user is banned */
			if ($user['deactivated']) {
				redirectTo('index.php', array('showmessage' => '8'));
				exit;
			}

			if (($adminchecked && Settings::Get('panel.allow_preset_admin') == '1') || $adminchecked == false) {
				if ($user !== false) {
					// build a activation code
					$timestamp = time();
					$first = substr(md5($user['loginname'] . $timestamp . randomStr(16)), 0, 15);
					$third = substr(md5($user['email'] . $timestamp . randomStr(16)), -15);
					$activationcode = $first . $timestamp . $third . substr(md5($third . $timestamp), 0, 10);

					// Drop all existing activation codes for this user
					$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_ACTIVATION . "`
						WHERE `userid` = :userid
						AND `admin` = :admin"
					);
					$params = array(
						"userid" => $adminchecked ? $user['adminid'] : $user['customerid'],
						"admin" => $adminchecked ? 1 : 0
					);
					Database::pexecute($stmt, $params);

					// Add new activation code to database
					$stmt = Database::prepare("INSERT INTO `" . TABLE_PANEL_ACTIVATION . "`
						(userid, admin, creation, activationcode)
						VALUES (:userid, :admin, :creation, :activationcode)"
					);
					$params = array(
						"userid" => $adminchecked ? $user['adminid'] : $user['customerid'],
						"admin" => $adminchecked ? 1 : 0,
						"creation" => $timestamp,
						"activationcode" => $activationcode
					);
					Database::pexecute($stmt, $params);

					$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'));
					$rstlog->logAction(USR_ACTION, LOG_WARNING, "User '" . $user['loginname'] . "' requested a link for setting a new password.");

					// Set together our activation link
					$protocol = empty( $_SERVER['HTTPS'] ) ? 'http' : 'https';
					// this can be a fixed value to avoid potential exploiting by modifying headers
					$host = Settings::Get('system.hostname'); // $_SERVER['HTTP_HOST'];
					$port = $_SERVER['SERVER_PORT'] != 80 ? ':' . $_SERVER['SERVER_PORT'] : '';
					// don't add :443 when https is used, as it is default (and just looks weird!)
					if ($protocol == 'https' && $_SERVER['SERVER_PORT'] == '443') {
						$port = '';
					}
					// there can be only one script to handle this so we can use a fixed value here
					$script = "/index.php"; // $_SERVER['SCRIPT_NAME'];
					if (Settings::Get('system.froxlordirectlyviahostname') == 0) {
						$script = makeCorrectFile("/".basename(__DIR__)."/".$script);
					}
					$activationlink = $protocol . '://' . $host . $port . $script . '?action=resetpwd&resetcode=' . $activationcode;

					$replace_arr = array(
						'SALUTATION' => getCorrectUserSalutation($user),
						'USERNAME' => $loginname,
						'LINK' => $activationlink
					);

					$def_language = ($user['def_language'] != '') ? $user['def_language'] : Settings::Get('panel.standardlanguage');
					$result_stmt = Database::prepare('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '`
						WHERE `adminid`= :adminid
						AND `language`= :lang
						AND `templategroup`=\'mails\'
						AND `varname`=\'password_reset_subject\''
					);
					Database::pexecute($result_stmt, array("adminid" => $user['adminid'], "lang" => $def_language));
					$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
					$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['password_reset']['subject']), $replace_arr));

					$result_stmt = Database::prepare('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '`
						WHERE `adminid`= :adminid
						AND `language`= :lang
						AND `templategroup`=\'mails\'
						AND `varname`=\'password_reset_mailbody\''
					);
					Database::pexecute($result_stmt, array("adminid" => $user['adminid'], "lang" => $def_language));
					$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
					$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['password_reset']['mailbody']), $replace_arr));

					$_mailerror = false;
					try {
						$mail->Subject = $mail_subject;
						$mail->AltBody = $mail_body;
						$mail->MsgHTML(str_replace("\n", "<br />", $mail_body));
						$mail->AddAddress($user['email'], getCorrectUserSalutation($user));
						$mail->Send();
					} catch(phpmailerException $e) {
						$mailerr_msg = $e->errorMessage();
						$_mailerror = true;
					} catch (Exception $e) {
						$mailerr_msg = $e->getMessage();
						$_mailerror = true;
					}

					if ($_mailerror) {
						$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'));
						$rstlog->logAction(ADM_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
						redirectTo('index.php', array('showmessage' => '4', 'customermail' => $user['email']));
						exit;
					}

					$mail->ClearAddresses();
					redirectTo('index.php', array('showmessage' => '1'));
					exit;
				} else {
					$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'));
					$rstlog->logAction(USR_ACTION, LOG_WARNING, "User '" . $loginname . "' requested to set a new password, but was not found in database!");
					$message = $lng['login']['combination_not_found'];
				}

				unset($user);
			}
		} else {
			$message = $lng['login']['usernotfound'];
		}
	}

	if ($adminchecked) {
		if (Settings::Get('panel.allow_preset_admin') != '1') {
			$message = $lng['pwdreminder']['notallowed'];
			unset ($adminchecked);
		}
	} else {
		if (Settings::Get('panel.allow_preset') != '1') {
			$message = $lng['pwdreminder']['notallowed'];
		}
	}

	eval("echo \"" . getTemplate('fpwd') . "\";");
}

if ($action == 'resetpwd') {
	$message = '';

	// Remove old activation codes
	$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_ACTIVATION . "`
		WHERE creation < :oldest"
	);
	Database::pexecute($stmt, array("oldest" => time() - 86400));

	if (isset($_GET['resetcode']) && strlen($_GET['resetcode']) == 50) {
		// Check if activation code is valid
		$activationcode = $_GET['resetcode'];
		$timestamp = substr($activationcode, 15, 10);
		$third = substr($activationcode, 25, 15);
		$check = substr($activationcode, 40, 10);

		if (substr(md5($third . $timestamp), 0, 10) == $check && $timestamp >= time() - 86400) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				$stmt = Database::prepare("SELECT `userid`, `admin` FROM `" . TABLE_PANEL_ACTIVATION . "`
					WHERE `activationcode` = :activationcode"
				);
				$result = Database::pexecute_first($stmt, array("activationcode" => $activationcode));

				if ($result !== false) {
					if ($result['admin'] == 1) {
						$new_password = validate($_POST['new_password'], 'new password');
						$new_password_confirm = validate($_POST['new_password_confirm'], 'new password confirm');
					} else {
						$new_password = validatePassword($_POST['new_password'], 'new password');
						$new_password_confirm = validatePassword($_POST['new_password_confirm'], 'new password confirm');
					}

					if ($new_password == '') {
						$message = $new_password;
					} elseif ($new_password_confirm == '') {
						$message = $new_password_confirm;
					} elseif ($new_password != $new_password_confirm) {
						$message = $new_password . " != " . $new_password_confirm;
					} else {
						// Update user password
						if ($result['admin'] == 1) {
							$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_ADMINS . "`
								SET `password` = :newpassword
								WHERE `adminid` = :userid"
							);
						} else {
							$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
								SET `password` = :newpassword
								WHERE `customerid` = :userid"
							);
						}
						Database::pexecute($stmt, array("newpassword" => makeCryptPassword($new_password), "userid" => $result['userid']));

						$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'));
						$rstlog->logAction(USR_ACTION, LOG_NOTICE, "changed password using password reset.");

						// Remove activation code from DB
						$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_ACTIVATION . "`
							WHERE `activationcode` = :activationcode
							AND `userid` = :userid"
						);
						Database::pexecute($stmt, array("activationcode" => $activationcode, "userid" => $result['userid']));
						redirectTo('index.php', array("showmessage" => '6'));
					}
				} else {
					redirectTo('index.php', array("showmessage" => '7'));
				}
			}

			eval("echo \"" . getTemplate('rpwd') . "\";");

		} else {
			redirectTo('index.php', array("showmessage" => '7'));
		}

	} else {
		redirectTo('index.php');
	}
}
