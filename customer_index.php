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
require './lib/init.php';

if ($action == 'logout') {
	$log->logAction(USR_ACTION, LOG_NOTICE, 'logged out');

	$params = array("customerid" => $userinfo['customerid']);
	if (Settings::Get('session.allow_multiple_login') == '1') {
		$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_SESSIONS . "`
			WHERE `userid` = :customerid
			AND `adminsession` = '0'
			AND `hash` = :hash"
		);
		$params["hash"] = $s;
	} else {
		$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_SESSIONS . "`
			WHERE `userid` = :customerid
			AND `adminsession` = '0'"
		);
	}
	Database::pexecute($stmt, $params);

	redirectTo('index.php');
}

if ($page == 'overview') {
	$log->logAction(USR_ACTION, LOG_NOTICE, "viewed customer_index");

	$domain_stmt = Database::prepare("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
		WHERE `customerid` = :customerid
		AND `parentdomainid` = '0'
		AND `id` <> :standardsubdomain
	");
	Database::pexecute($domain_stmt, array("customerid" => $userinfo['customerid'], "standardsubdomain" => $userinfo['standardsubdomain']));

	$domains = '';
	$domainArray = array();

	while ($row = $domain_stmt->fetch(PDO::FETCH_ASSOC)) {
		$domainArray[] = $idna_convert->decode($row['domain']);
	}

	natsort($domainArray);
	$domains = implode(',<br />', $domainArray);

	// standard-subdomain
	$stdsubdomain = '';
	if ($userinfo['standardsubdomain'] != '0') {
		$std_domain_stmt = Database::prepare("
			SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE `customerid` = :customerid
			AND `id` = :standardsubdomain
		");
		$std_domain = Database::pexecute_first($std_domain_stmt, array("customerid" => $userinfo['customerid'], "standardsubdomain" => $userinfo['standardsubdomain']));
		$stdsubdomain = $std_domain['domain'];
	}

	$userinfo['email'] = $idna_convert->decode($userinfo['email']);
	$yesterday = time() - (60 * 60 * 24);
	$month = date('M Y', $yesterday);

	// get disk-space usages for web, mysql and mail
	$usages_stmt = Database::prepare("SELECT * FROM `".TABLE_PANEL_DISKSPACE."` WHERE `customerid` = :cid ORDER BY `stamp` DESC LIMIT 1");
	$usages = Database::pexecute_first($usages_stmt, array('cid' => $userinfo['customerid']));

	$userinfo['diskspace'] = round($userinfo['diskspace'] / 1024, Settings::Get('panel.decimal_places'));
	$userinfo['diskspace_used'] = round($usages['webspace'] / 1024, Settings::Get('panel.decimal_places'));
	$userinfo['mailspace_used'] = round($usages['mail'] / 1024, Settings::Get('panel.decimal_places'));
	$userinfo['dbspace_used'] = round($usages['mysql'] / 1024, Settings::Get('panel.decimal_places'));

	$userinfo['traffic'] = round($userinfo['traffic'] / (1024 * 1024), Settings::Get('panel.decimal_places'));
	$userinfo['traffic_used'] = round($userinfo['traffic_used'] / (1024 * 1024), Settings::Get('panel.decimal_places'));
	$userinfo = str_replace_array('-1', $lng['customer']['unlimited'], $userinfo, 'diskspace traffic mysqls emails email_accounts email_forwarders email_quota ftps tickets subdomains');

	$userinfo['custom_notes'] = ($userinfo['custom_notes'] != '') ? nl2br($userinfo['custom_notes']) : '';

	$services_enabled = "";
	$se = array();
	if ($userinfo['imap'] == '1') $se[] = "IMAP";
	if ($userinfo['pop3'] == '1') $se[] = "POP3";
	if ($userinfo['phpenabled'] == '1') $se[] = "PHP";
	if ($userinfo['perlenabled'] == '1') $se[] = "Perl/CGI";
	$services_enabled = implode(", ", $se);

	eval("echo \"" . getTemplate('index/index') . "\";");
} elseif ($page == 'change_password') {
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$old_password = validate($_POST['old_password'], 'old password');
		if (!validatePasswordLogin($userinfo,$old_password,TABLE_PANEL_CUSTOMERS,'customerid')) {
			standard_error('oldpasswordnotcorrect');
		}

		$new_password = validatePassword($_POST['new_password'], 'new password');
		$new_password_confirm = validatePassword($_POST['new_password_confirm'], 'new password confirm');

		if ($old_password == '') {
			standard_error(array('stringisempty', 'oldpassword'));
		} elseif ($new_password == '') {
			standard_error(array('stringisempty', 'newpassword'));
		} elseif ($new_password_confirm == '') {
			standard_error(array('stringisempty', 'newpasswordconfirm'));
		} elseif ($new_password != $new_password_confirm) {
			standard_error('newpasswordconfirmerror');
		} else {
			// Update user password
			try {
				Customers::getLocal($userinfo, array('id' => $userinfo['customerid'], 'new_customer_password' => $new_password))->update();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}
			$log->logAction(USR_ACTION, LOG_NOTICE, 'changed password');

			// Update ftp password
			if (isset($_POST['change_main_ftp']) && $_POST['change_main_ftp'] == 'true') {
				$cryptPassword = makeCryptPassword($new_password);
				$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
					SET `password` = :password
					WHERE `customerid` = :customerid
					AND `username` = :username"
				);
				$params = array(
					"password" => $cryptPassword,
					"customerid" => $userinfo['customerid'],
					"username" => $userinfo['loginname']
				);
				Database::pexecute($stmt, $params);
				$log->logAction(USR_ACTION, LOG_NOTICE, 'changed main ftp password');
			}

			// Update webalizer password
			if (isset($_POST['change_webalizer']) && $_POST['change_webalizer'] == 'true') {
				if (CRYPT_STD_DES == 1) {
					$saltfordescrypt = substr(md5(uniqid(microtime(), 1)), 4, 2);
					$new_webalizer_password = crypt($new_password, $saltfordescrypt);
				} else {
					$new_webalizer_password = crypt($new_password);
				}

				$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_HTPASSWDS . "`
					SET `password` = :password
					WHERE `customerid` = :customerid
					AND `username` = :username"
				);
				$params = array(
					"password" => $new_webalizer_password,
					"customerid" => $userinfo['customerid'],
					"username" => $userinfo['loginname']
				);
				Database::pexecute($stmt, $params);
			}

			redirectTo($filename, array('s' => $s));
		}
	} else {
		eval("echo \"" . getTemplate('index/change_password') . "\";");
	}
} elseif ($page == 'change_language') {
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$def_language = validate($_POST['def_language'], 'default language');
		if (isset($languages[$def_language])) {
			try {
				Customers::getLocal($userinfo, array('id' => $userinfo['customerid'], 'def_language' => $def_language))->update();
			} catch (Exception $e) {
				dynamic_error($e->getMessage());
			}

			// also update current session
			$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_SESSIONS . "`
				SET `language` = :lang
				WHERE `hash` = :hash"
			);
			Database::pexecute($stmt, array("lang" => $def_language, "hash" => $s));
		}
		$log->logAction(USR_ACTION, LOG_NOTICE, "changed default language to '" . $def_language . "'");
		redirectTo($filename, array('s' => $s));
	} else {
		$default_lang = Settings::Get('panel.standardlanguage');
		if ($userinfo['def_language'] != '') {
			$default_lang = $userinfo['def_language'];
		}

		$language_options = '';
		foreach ($languages as $language_file => $language_name) {
			$language_options .= makeoption($language_name, $language_file, $default_lang, true);
		}

		eval("echo \"" . getTemplate('index/change_language') . "\";");
	}
} elseif ($page == 'change_theme') {
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$theme = validate($_POST['theme'], 'theme');
		try {
			Customers::getLocal($userinfo, array('id' => $userinfo['customerid'], 'theme' => $theme))->update();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}

		// also update current session
		$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_SESSIONS . "`
			SET `theme` = :theme
			WHERE `hash` = :hash"
		);
		Database::pexecute($stmt, array("theme" => $theme, "hash" => $s));

		$log->logAction(USR_ACTION, LOG_NOTICE, "changed default theme to '" . $theme . "'");
		redirectTo($filename, array('s' => $s));
	} else {
		$default_theme = Settings::Get('panel.default_theme');
		if ($userinfo['theme'] != '') {
			$default_theme = $userinfo['theme'];
		}

		$theme_options = '';
		$themes_avail = getThemes();
		foreach ($themes_avail as $t => $d) {
			$theme_options.= makeoption($d, $t, $default_theme, true);
		}

		eval("echo \"" . getTemplate('index/change_theme') . "\";");
	}

} elseif ($page == 'send_error_report' && Settings::Get('system.allow_error_report_customer') == '1') {

	// only show this if we really have an exception to report
	if (isset($_GET['errorid']) && $_GET['errorid'] != '') {

		$errid = $_GET['errorid'];
		// read error file
		$err_dir = makeCorrectDir(FROXLOR_INSTALL_DIR."/logs/");
		$err_file = makeCorrectFile($err_dir."/".$errid."_sql-error.log");

		if (file_exists($err_file)) {

			$error_content = file_get_contents($err_file);
			$error = explode("|", $error_content);

			$_error = array(
				'code' => str_replace("\n", "", substr($error[1], 5)),
				'message' => str_replace("\n", "", substr($error[2], 4)),
				'file' => str_replace("\n", "", substr($error[3], 5 + strlen(FROXLOR_INSTALL_DIR))),
				'line' => str_replace("\n", "", substr($error[4], 5)),
				'trace' => str_replace(FROXLOR_INSTALL_DIR, "", substr($error[5], 6))
			);

			// build mail-content
			$mail_body = "Dear froxlor-team,\n\n";
			$mail_body .= "the following error has been reported by a user:\n\n";
			$mail_body .= "-------------------------------------------------------------\n";
			$mail_body .= $_error['code'].' '.$_error['message']."\n\n";
			$mail_body .= "File: ".$_error['file'].':'.$_error['line']."\n\n";
			$mail_body .= "Trace:\n".trim($_error['trace'])."\n\n";
			$mail_body .= "-------------------------------------------------------------\n\n";
			$mail_body .= "Froxlor-version: ".$version."\n";
			$mail_body .= "DB-version: ".$dbversion."\n\n";
			$mail_body .= "End of report";
			$mail_html = str_replace("\n", "<br />", $mail_body);

			// send actual report to dev-team
			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				// send mail and say thanks
				$_mailerror = false;
				try {
					$mail->Subject = '[Froxlor] Error report by user';
					$mail->AltBody = $mail_body;
					$mail->MsgHTML($mail_html);
					$mail->AddAddress('error-reports@froxlor.org', 'Froxlor Developer Team');
					$mail->Send();
				} catch(phpmailerException $e) {
					$mailerr_msg = $e->errorMessage();
					$_mailerror = true;
				} catch (Exception $e) {
					$mailerr_msg = $e->getMessage();
					$_mailerror = true;
				}

				if ($_mailerror) {
					// error when reporting an error...LOLFUQ
					standard_error('send_report_error', $mailerr_msg);
				}

				// finally remove error from fs
				@unlink($err_file);
				redirectTo($filename, array('s' => $s));
			}
			// show a nice summary of the error-report
			// before actually sending anything
			eval("echo \"" . getTemplate("index/send_error_report") . "\";");

		} else {
			redirectTo($filename, array('s' => $s));
		}
	} else {
		redirectTo($filename, array('s' => $s));
	}
}
elseif ($page == 'apikeys' && Settings::Get('api.enabled') == 1) {
	require_once __DIR__ . '/api_keys.php';
}
elseif ($page == 'apihelp' && Settings::Get('api.enabled') == 1) {
	require_once __DIR__ . '/apihelp.php';
}
