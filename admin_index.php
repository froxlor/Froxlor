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
define('AREA', 'admin');
require './lib/init.php';

use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\Api\Commands\Froxlor as Froxlor;
use Froxlor\Api\Commands\Admins as Admins;

if ($action == 'logout') {

	$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "logged out");

	$params = array(
		'adminid' => (int) $userinfo['adminid']
	);

	if (Settings::Get('session.allow_multiple_login') == '1') {
		$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_SESSIONS . "`
			WHERE `userid` = :adminid
			AND `adminsession` = '1'
			AND `hash` = :hash");
		$params['hash'] = $s;
	} else {
		$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_SESSIONS . "`
			WHERE `userid` = :adminid
			AND `adminsession` = '1'");
	}
	Database::pexecute($stmt, $params);

	\Froxlor\UI\Response::redirectTo('index.php');
}

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {

	$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_index");
	$params = [];
	if ($userinfo['customers_see_all'] == '0') {
		$params = [
			'adminid' => $userinfo['adminid']
		];
	}
	$overview_stmt = Database::prepare("SELECT COUNT(*) AS `number_customers`,
				SUM(`diskspace_used`) AS `diskspace_used`,
				SUM(`mysqls_used`) AS `mysqls_used`,
				SUM(`emails_used`) AS `emails_used`,
				SUM(`email_accounts_used`) AS `email_accounts_used`,
				SUM(`email_forwarders_used`) AS `email_forwarders_used`,
				SUM(`email_quota_used`) AS `email_quota_used`,
				SUM(`ftps_used`) AS `ftps_used`,
				SUM(`subdomains_used`) AS `subdomains_used`,
				SUM(`traffic_used`) AS `traffic_used`
				FROM `" . TABLE_PANEL_CUSTOMERS . "`" . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = :adminid "));
	$overview = Database::pexecute_first($overview_stmt, $params);

	$dec_places = Settings::Get('panel.decimal_places');
	$overview['traffic_bytes_used'] = $overview['traffic_used'] * 1024;
	$overview['traffic_used'] = \Froxlor\PhpHelper::sizeReadable($overview['traffic_used'] * 1024, null, 'bi');
	$overview['diskspace_bytes_used'] = $overview['diskspace_used'] * 1024;
	$overview['diskspace_used'] = \Froxlor\PhpHelper::sizeReadable($overview['diskspace_used'] * 1024, null, 'bi');

	$number_domains_stmt = Database::prepare("
		SELECT COUNT(*) AS `number_domains` FROM `" . TABLE_PANEL_DOMAINS . "`
		WHERE `parentdomainid`='0'" . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid"));
	$number_domains = Database::pexecute_first($number_domains_stmt, $params);

	$overview['number_domains'] = $number_domains['number_domains'];

	$phpversion = phpversion();
	$mysqlserverversion = Database::getAttribute(PDO::ATTR_SERVER_VERSION);
	$webserverinterface = strtoupper(@php_sapi_name());

	if ((isset($_GET['lookfornewversion']) && $_GET['lookfornewversion'] == 'yes') || (isset($lookfornewversion) && $lookfornewversion == 'yes')) {
		try {
			$json_result = Froxlor::getLocal($userinfo)->checkUpdate();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		$lookfornewversion_lable = $result['version'];
		$lookfornewversion_link = $result['link'];
		$lookfornewversion_message = $result['message'];
		$lookfornewversion_addinfo = $result['additional_info'];
		$isnewerversion = $result['isnewerversion'];
	} else {
		$lookfornewversion_lable = $lng['admin']['lookfornewversion']['clickhere'];
		$lookfornewversion_link = htmlspecialchars($filename . '?s=' . urlencode($s) . '&page=' . urlencode($page) . '&lookfornewversion=yes');
		$lookfornewversion_message = '';
		$lookfornewversion_addinfo = '';
		$isnewerversion = 0;
	}

	$dec_places = Settings::Get('panel.decimal_places');
	// get everything in bytes for the percentage calculation on the dashboard
	$userinfo['diskspace_bytes'] = ($userinfo['diskspace'] > -1) ? $userinfo['diskspace'] * 1024 : -1;
	$userinfo['diskspace_bytes_used'] = $userinfo['diskspace_used'] * 1024;
	$userinfo['traffic_bytes'] = ($userinfo['traffic'] > -1) ? $userinfo['traffic'] * 1024 : - 1;
	$userinfo['traffic_bytes_used'] = $userinfo['traffic_used'] * 1024;

	$userinfo['diskspace'] = ($userinfo['diskspace'] > -1) ? \Froxlor\PhpHelper::sizeReadable($userinfo['diskspace'] * 1024, null, 'bi') : - 1;
	$userinfo['diskspace_used'] = \Froxlor\PhpHelper::sizeReadable($userinfo['diskspace_used'] * 1024, null, 'bi');
	$userinfo['traffic'] = ($userinfo['traffic'] > -1) ? \Froxlor\PhpHelper::sizeReadable($userinfo['traffic'] * 1024, null, 'bi') : - 1;
	$userinfo['traffic_used'] = \Froxlor\PhpHelper::sizeReadable($userinfo['traffic_used'] * 1024, null, 'bi');
	$userinfo = \Froxlor\PhpHelper::strReplaceArray('-1', $lng['customer']['unlimited'], $userinfo, 'customers domains diskspace diskspace_bytes traffic traffic_bytes mysqls emails email_accounts email_forwarders email_quota ftps subdomains');

	$userinfo['custom_notes'] = ($userinfo['custom_notes'] != '') ? nl2br($userinfo['custom_notes']) : '';

	$cron_last_runs = \Froxlor\System\Cronjob::getCronjobsLastRun();
	$outstanding_tasks = \Froxlor\System\Cronjob::getOutstandingTasks();

	$system_hostname = gethostname();
	$meminfo = explode("\n", @file_get_contents("/proc/meminfo"));
	$memory = "";
	for ($i = 0; $i < sizeof($meminfo); ++ $i) {
		if (substr($meminfo[$i], 0, 3) === "Mem") {
			$memory .= $meminfo[$i] . PHP_EOL;
		}
	}

	if (function_exists('sys_getloadavg')) {
		$loadArray = sys_getloadavg();
		$load = number_format($loadArray[0], 2, '.', '') . " / " . number_format($loadArray[1], 2, '.', '') . " / " . number_format($loadArray[2], 2, '.', '');
	} else {
		$load = @file_get_contents('/proc/loadavg');

		if (! $load) {
			$load = $lng['admin']['noloadavailable'];
		}
	}

	if (function_exists('posix_uname')) {
		$showkernel = 1;
		$kernel_nfo = posix_uname();
		$kernel = $kernel_nfo['release'] . ' (' . $kernel_nfo['machine'] . ')';
	} else {
		$showkernel = 0;
		$kernel = '';
	}

	// Try to get the uptime
	// First: With exec (let's hope it's enabled for the Froxlor - vHost)
	$uptime_array = explode(" ", @file_get_contents("/proc/uptime"));

	if (is_array($uptime_array) && isset($uptime_array[0]) && is_numeric($uptime_array[0])) {
		// Some calculatioon to get a nicly formatted display
		$seconds = round($uptime_array[0], 0);
		$minutes = $seconds / 60;
		$hours = $minutes / 60;
		$days = floor($hours / 24);
		$hours = floor($hours - ($days * 24));
		$minutes = floor($minutes - ($days * 24 * 60) - ($hours * 60));
		$seconds = floor($seconds - ($days * 24 * 60 * 60) - ($hours * 60 * 60) - ($minutes * 60));
		$uptime = "{$days}d, {$hours}h, {$minutes}m, {$seconds}s";

		// Just cleanup
		unset($uptime_array, $seconds, $minutes, $hours, $days);
	} else {
		// Nothing of the above worked, show an error :/
		$uptime = '';
	}

	eval("echo \"" . \Froxlor\UI\Template::getTemplate("index/index") . "\";");
} elseif ($page == 'change_password') {

	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$old_password = \Froxlor\Validate\Validate::validate($_POST['old_password'], 'old password');

		if (! \Froxlor\System\Crypt::validatePasswordLogin($userinfo, $old_password, TABLE_PANEL_ADMINS, 'adminid')) {
			\Froxlor\UI\Response::standard_error('oldpasswordnotcorrect');
		}

		try {
			$new_password = \Froxlor\System\Crypt::validatePassword($_POST['new_password'], 'new password');
			$new_password_confirm = \Froxlor\System\Crypt::validatePassword($_POST['new_password_confirm'], 'new password confirm');
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		if ($old_password == '') {
			\Froxlor\UI\Response::standard_error(array(
				'stringisempty',
				'oldpassword'
			));
		} elseif ($new_password == '') {
			\Froxlor\UI\Response::standard_error(array(
				'stringisempty',
				'newpassword'
			));
		} elseif ($new_password_confirm == '') {
			\Froxlor\UI\Response::standard_error(array(
				'stringisempty',
				'newpasswordconfirm'
			));
		} elseif ($new_password != $new_password_confirm) {
			\Froxlor\UI\Response::standard_error('newpasswordconfirmerror');
		} else {
			try {
				Admins::getLocal($userinfo, array(
					'id' => $userinfo['adminid'],
					'admin_password' => $new_password
				))->update();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, 'changed password');
			\Froxlor\UI\Response::redirectTo($filename, Array(
				's' => $s
			));
		}
	} else {
		eval("echo \"" . \Froxlor\UI\Template::getTemplate("index/change_password") . "\";");
	}
} elseif ($page == 'change_language') {

	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$def_language = \Froxlor\Validate\Validate::validate($_POST['def_language'], 'default language');

		if (isset($languages[$def_language])) {
			try {
				Admins::getLocal($userinfo, array(
					'id' => $userinfo['adminid'],
					'def_language' => $def_language
				))->update();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}

			// also update current session
			$lng_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_SESSIONS . "`
				SET `language`= :lng
				WHERE `hash`= :hash");
			Database::pexecute($lng_stmt, array(
				'lng' => $def_language,
				'hash' => $s
			));
		}
		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "changed his/her default language to '" . $def_language . "'");
		\Froxlor\UI\Response::redirectTo($filename, array(
			's' => $s
		));
	} else {

		$language_options = '';

		$default_lang = Settings::Get('panel.standardlanguage');
		if ($userinfo['def_language'] != '') {
			$default_lang = $userinfo['def_language'];
		}

		foreach ($languages as $language_file => $language_name) {
			$language_options .= \Froxlor\UI\HTML::makeoption($language_name, $language_file, $default_lang, true);
		}

		eval("echo \"" . \Froxlor\UI\Template::getTemplate("index/change_language") . "\";");
	}
} elseif ($page == 'change_theme') {

	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$theme = \Froxlor\Validate\Validate::validate($_POST['theme'], 'theme');
		try {
			Admins::getLocal($userinfo, array(
				'id' => $userinfo['adminid'],
				'theme' => $theme
			))->update();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		// also update current session
		$theme_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_SESSIONS . "`
				SET `theme`= :theme
				WHERE `hash`= :hash");
		Database::pexecute($theme_stmt, array(
			'theme' => $theme,
			'hash' => $s
		));

		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "changed his/her theme to '" . $theme . "'");
		\Froxlor\UI\Response::redirectTo($filename, array(
			's' => $s
		));
	} else {

		$theme_options = '';

		$default_theme = Settings::Get('panel.default_theme');
		if ($userinfo['theme'] != '') {
			$default_theme = $userinfo['theme'];
		}

		$themes_avail = \Froxlor\UI\Template::getThemes();
		foreach ($themes_avail as $t => $d) {
			$theme_options .= \Froxlor\UI\HTML::makeoption($d, $t, $default_theme, true);
		}

		eval("echo \"" . \Froxlor\UI\Template::getTemplate("index/change_theme") . "\";");
	}
} elseif ($page == 'send_error_report' && Settings::Get('system.allow_error_report_admin') == '1') {

	// only show this if we really have an exception to report
	if (isset($_GET['errorid']) && $_GET['errorid'] != '') {

		$errid = $_GET['errorid'];
		// read error file
		$err_dir = \Froxlor\FileDir::makeCorrectDir(\Froxlor\Froxlor::getInstallDir() . "/logs/");
		$err_file = \Froxlor\FileDir::makeCorrectFile($err_dir . "/" . $errid . "_sql-error.log");

		if (file_exists($err_file)) {

			$error_content = file_get_contents($err_file);
			$error = explode("|", $error_content);

			$_error = array(
				'code' => str_replace("\n", "", substr($error[1], 5)),
				'message' => str_replace("\n", "", substr($error[2], 4)),
				'file' => str_replace("\n", "", substr($error[3], 5 + strlen(\Froxlor\Froxlor::getInstallDir()))),
				'line' => str_replace("\n", "", substr($error[4], 5)),
				'trace' => str_replace(\Froxlor\Froxlor::getInstallDir(), "", substr($error[5], 6))
			);

			// build mail-content
			$mail_body = "Dear froxlor-team,\n\n";
			$mail_body .= "the following error has been reported by a user:\n\n";
			$mail_body .= "-------------------------------------------------------------\n";
			$mail_body .= $_error['code'] . ' ' . $_error['message'] . "\n\n";
			$mail_body .= "File: " . $_error['file'] . ':' . $_error['line'] . "\n\n";
			$mail_body .= "Trace:\n" . trim($_error['trace']) . "\n\n";
			$mail_body .= "-------------------------------------------------------------\n\n";
			$mail_body .= "Froxlor-version: " . $version . "\n";
			$mail_body .= "DB-version: " . $dbversion . "\n\n";
			$mail_body .= "End of report";
			$mail_html = nl2br($mail_body);

			// send actual report to dev-team
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				// send mail and say thanks
				$_mailerror = false;
				try {
					$mail->Subject = '[Froxlor] Error report by user';
					$mail->AltBody = $mail_body;
					$mail->MsgHTML($mail_html);
					$mail->AddAddress('error-reports@froxlor.org', 'Froxlor Developer Team');
					$mail->Send();
				} catch (\PHPMailer\PHPMailer\Exception $e) {
					$mailerr_msg = $e->errorMessage();
					$_mailerror = true;
				} catch (Exception $e) {
					$mailerr_msg = $e->getMessage();
					$_mailerror = true;
				}

				if ($_mailerror) {
					// error when reporting an error...LOLFUQ
					\Froxlor\UI\Response::standard_error('send_report_error', $mailerr_msg);
				}

				// finally remove error from fs
				@unlink($err_file);
				\Froxlor\UI\Response::redirectTo($filename, array(
					's' => $s
				));
			}
			// show a nice summary of the error-report
			// before actually sending anything
			eval("echo \"" . \Froxlor\UI\Template::getTemplate("index/send_error_report") . "\";");
		} else {
			\Froxlor\UI\Response::redirectTo($filename, array(
				's' => $s
			));
		}
	} else {
		\Froxlor\UI\Response::redirectTo($filename, array(
			's' => $s
		));
	}
} elseif ($page == 'apikeys' && Settings::Get('api.enabled') == 1) {
	require_once __DIR__ . '/api_keys.php';
} elseif ($page == '2fa' && Settings::Get('2fa.enabled') == 1) {
	require_once __DIR__ . '/2fa.php';
}
