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
			if ((int)$settings['login']['domain_login'] == 1) {
				$domainname = $idna_convert->encode(preg_replace(Array('/\:(\d)+$/', '/^https?\:\/\//'), '', $loginname));
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
				redirectTo('index.php', Array('showmessage' => '2'), true);
				exit;
			}
		}

		$userinfo_stmt = Database::prepare("SELECT * FROM $table
			WHERE `loginname`= :loginname"
		);
		Database::pexecute($userinfo_stmt, array("loginname" => $loginname));
		$userinfo = $userinfo_stmt->fetch(PDO::FETCH_ASSOC);

		if ($userinfo['loginfail_count'] >= $settings['login']['maxloginattempts'] && $userinfo['lastlogin_fail'] > (time() - $settings['login']['deactivatetime'])) {
			redirectTo('index.php', Array('showmessage' => '3'), true);
			exit;
		} elseif($userinfo['password'] == md5($password)) {
			// login correct
			// reset loginfail_counter, set lastlogin_succ
			$stmt = Database::prepare("UPDATE $table
				SET `lastlogin_succ`= :lastlogin_succ, `loginfail_count`='0'
				WHERE `$uid`= :uid"
			);
			Database::pexecute($stmt, array("lastlogin_succ" => time(), "uid" => $userinfo[$uid]));
			$userinfo['userid'] = $userinfo[$uid];
			$userinfo['adminsession'] = $adminsession;
		} else {
			// login incorrect
			$stmt = Database::prepare("UPDATE $table
				SET `lastlogin_fail`= :lastlogin_fail, `loginfail_count`=`loginfail_count`+1
				WHERE `$uid`= :uid"
			);
			Database::pexecute($stmt, array("lastlogin_fail" => time(), "uid" => $userinfo[$uid]));
			unset($userinfo);
			redirectTo('index.php', Array('showmessage' => '2'), true);
			exit;
		}

		if (isset($userinfo['userid']) && $userinfo['userid'] != '') {
			$s = md5(uniqid(microtime(), 1));

			if (isset($_POST['language'])) {
				$language = validate($_POST['language'], 'language');
				if ($language == 'profile') {
					$language = $userinfo['def_language'];
				} elseif(!isset($languages[$language])) {
					$language = $settings['panel']['standardlanguage'];
				}
			} else {
				$language = $settings['panel']['standardlanguage'];
			}

			if (isset($userinfo['theme']) && $userinfo['theme'] != '') {
				$theme = $userinfo['theme'];
			} else {
				$theme = $settings['panel']['default_theme'];
			}

			if ($settings['session']['allow_multiple_login'] != '1') {
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

			if ($userinfo['adminsession'] == '1') {
				if (hasUpdates($version)) {
					redirectTo('admin_updates.php', Array('s' => $s), true);
				} else {
					redirectTo('admin_index.php', Array('s' => $s), true);
				}
			} else {
				redirectTo('customer_index.php', Array('s' => $s), true);
			}
		} else {
			redirectTo('index.php', Array('showmessage' => '2'), true);
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
				$message = sprintf($lng['error']['login_blocked'],$settings['login']['deactivatetime']);
				break;
			case 4:
				$cmail = isset($_GET['customermail']) ? $_GET['customermail'] : 'unknown';
				$message = str_replace('%s', $cmail, $lng['error']['errorsendingmail']);
				break;
			case 5:
				$message = $lng['error']['user_banned'];
				break;
		}

		$update_in_progress = '';
		if (hasUpdates($version)) {
			$update_in_progress = $lng['update']['updateinprogress_onlyadmincanlogin'];
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
			$result_stmt = Database::prepare("SELECT `adminid`, `name`, `email`, `loginname`, `def_language` FROM `" . TABLE_PANEL_ADMINS . "`
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
				$message = $lng['pwdreminder']['notallowed'];
				redirectTo('index.php', Array('showmessage' => '5'), true);
			}

			if (($adminchecked && $settings['panel']['allow_preset_admin'] == '1') || $adminchecked == false) {
				if ($user !== false) {
					if ($settings['panel']['password_min_length'] <= 6) {
						$password = substr(md5(uniqid(microtime(), 1)), 12, 6);
					} else {
						// make it two times larger than password_min_length
						$rnd = '';
						$minlength = $settings['panel']['password_min_length'];
						while (strlen($rnd) < ($minlength * 2)) {
							$rnd .= md5(uniqid(microtime(), 1));
						}
						$password = substr($rnd, (int)($minlength / 2), $minlength);
					}

					$passwordTable = $adminchecked ? TABLE_PANEL_ADMINS : TABLE_PANEL_CUSTOMERS;
					$stmt = Database::prepare("UPDATE `" . $passwordTable . "` SET `password`= :password
						WHERE `loginname`= :loginname
						AND `email`= :email"
					);
					Database::pexecute($stmt, array("password" => md5($password), "loginname" => $user['loginname'], "email" => $user['email']));

					$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'), $settings);
					$rstlog->logAction(USR_ACTION, LOG_WARNING, "Password for user '" . $user['loginname'] . "' has been reset!");

					$replace_arr = array(
						'SALUTATION' => getCorrectUserSalutation($user),
						'USERNAME' => $user['loginname'],
						'PASSWORD' => $password
					);

					$body = strtr($lng['pwdreminder']['body'], array('%s' => $user['firstname'] . ' ' . $user['name'], '%p' => $password));

					$def_language = ($user['def_language'] != '') ? $user['def_language'] : $settings['panel']['standardlanguage'];
					$result_stmt = Database::prepare('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '`
						WHERE `adminid`= :adminid
						AND `language`= :lang
						AND `templategroup`=\'mails\'
						AND `varname`=\'password_reset_subject\''
					);
					Database::pexecute($result_stmt, array("adminid" => $user['adminid'], "lang" => $def_language));
					$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
					$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['pwdreminder']['subject']), $replace_arr));

					$result_stmt = Database::prepare('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '`
						WHERE `adminid`= :adminid
						AND `language`= :lang
						AND `templategroup`=\'mails\'
						AND `varname`=\'password_reset_mailbody\''
					);
					Database::pexecute($result_stmt, array("adminid" => $user['adminid'], "lang" => $def_language));
					$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
					$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $body), $replace_arr));

					$_mailerror = false;
					try {
						$mail->Subject = $mail_subject;
						$mail->AltBody = $mail_body;
						$mail->MsgHTML(str_replace("\n", "<br />", $mail_body));
						$mail->AddAddress($user['email'], $user['firstname'] . ' ' . $user['name']);
						$mail->Send();
					} catch(phpmailerException $e) {
						$mailerr_msg = $e->errorMessage();
						$_mailerror = true;
					} catch (Exception $e) {
						$mailerr_msg = $e->getMessage();
						$_mailerror = true;
					}

					if ($_mailerror) {
						$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'), $settings);
						$rstlog->logAction(ADM_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
						redirectTo('index.php', Array('showmessage' => '4', 'customermail' => $user['email']), true);
						exit;
					}

					$mail->ClearAddresses();
					redirectTo('index.php', Array('showmessage' => '1'), true);
					exit;
				} else {
					$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'password_reset'), $settings);
					$rstlog->logAction(USR_ACTION, LOG_WARNING, "User '" . $loginname . "' tried to reset pwd but wasn't found in database!");
					$message = $lng['login']['combination_not_found'];
				}

				unset($user);
			}
		} else {
			$message = $lng['login']['usernotfound'];
		}
	}

	if ($adminchecked) {
		if ($settings['panel']['allow_preset_admin'] != '1') {
			$message = $lng['pwdreminder']['notallowed'];
			unset ($adminchecked);
		}
	} else {
		if ($settings['panel']['allow_preset'] != '1') {
			$message = $lng['pwdreminder']['notallowed'];
		}
	}

	eval("echo \"" . getTemplate('fpwd') . "\";");
}
