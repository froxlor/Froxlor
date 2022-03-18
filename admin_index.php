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

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\Admins as Admins;
use Froxlor\Api\Commands\Froxlor as Froxlor;
use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

$id = (int) Request::get('id');

if ($action == 'logout') {

	$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "logged out");
	unset($_SESSION['userinfo']);
	\Froxlor\CurrentUser::setData();
	session_destroy();

	\Froxlor\UI\Response::redirectTo('index.php');
} elseif ($action == 'suback') {
	if (is_array(\Froxlor\CurrentUser::getField('switched_user'))) {
		$result = \Froxlor\CurrentUser::getData();
		$result = $result['switched_user'];
		\Froxlor\CurrentUser::setData($result);
		$target = (isset($_GET['target']) ? $_GET['target'] : 'index');
		$redirect = "admin_" . $target . ".php";
		if (!file_exists(\Froxlor\Froxlor::getInstallDir() . "/" . $redirect)) {
			$redirect = "admin_index.php";
		}
		\Froxlor\UI\Response::redirectTo($redirect, null, true);
	} else {
		\Froxlor\UI\Response::dynamic_error("Cannot change back - You've never switched to another user :-)");
	}
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
				SUM(case when `diskspace` > 0 then `diskspace` else 0 end) AS `diskspace_assigned`,
				SUM(`diskspace_used`) AS `diskspace_used`,
				SUM(case when `mysqls` > 0 then `mysqls` else 0 end) AS `mysqls_assigned`,
				SUM(`mysqls_used`) AS `mysqls_used`,
				SUM(case when `emails` > 0 then `emails` else 0 end) AS `emails_assigned`,
				SUM(`emails_used`) AS `emails_used`,
				SUM(case when `email_accounts` > 0 then `email_accounts` else 0 end) AS `email_accounts_assigned`,
				SUM(`email_accounts_used`) AS `email_accounts_used`,
				SUM(case when `email_forwarders` > 0 then `email_forwarders` else 0 end) AS `email_forwarders_assigned`,
				SUM(`email_forwarders_used`) AS `email_forwarders_used`,
				SUM(case when `email_quota` > 0 then `email_quota` else 0 end) AS `email_quota_assigned`,
				SUM(`email_quota_used`) AS `email_quota_used`,
				SUM(case when `ftps` > 0 then `ftps` else 0 end) AS `ftps_assigned`,
				SUM(`ftps_used`) AS `ftps_used`,
				SUM(case when `subdomains` > 0 then `subdomains` else 0 end) AS `subdomains_assigned`,
				SUM(`subdomains_used`) AS `subdomains_used`,
				SUM(case when `traffic` > 0 then `traffic` else 0 end) AS `traffic_assigned`,
				SUM(`traffic_used`) AS `traffic_used`
				FROM `" . TABLE_PANEL_CUSTOMERS . "`" . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = :adminid "));
	$overview = Database::pexecute_first($overview_stmt, $params);

	$userinfo['diskspace_bytes'] = ($userinfo['diskspace'] > -1) ? $userinfo['diskspace'] * 1024 : -1;
	$overview['diskspace_bytes'] = $overview['diskspace_assigned'] * 1024;
	$overview['diskspace_bytes_used'] = $overview['diskspace_used'] * 1024;

	$userinfo['traffic_bytes'] = ($userinfo['traffic'] > -1) ? $userinfo['traffic'] * 1024 : -1;
	$overview['traffic_bytes'] = $overview['traffic_assigned'] * 1024;
	$overview['traffic_bytes_used'] = $overview['traffic_used'] * 1024;

	$number_domains_stmt = Database::prepare("
		SELECT COUNT(*) AS `number_domains` FROM `" . TABLE_PANEL_DOMAINS . "`
		WHERE `parentdomainid`='0'" . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = :adminid"));
	$number_domains = Database::pexecute_first($number_domains_stmt, $params);

	$overview['number_domains'] = $number_domains['number_domains'];

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
		$lookfornewversion_link = htmlspecialchars($filename . '?page=' . urlencode($page) . '&lookfornewversion=yes');
		$lookfornewversion_message = '';
		$lookfornewversion_addinfo = '';
		$isnewerversion = 0;
	}

	$cron_last_runs = \Froxlor\System\Cronjob::getCronjobsLastRun();
	$outstanding_tasks = \Froxlor\System\Cronjob::getOutstandingTasks();

	// additional sys-infos
	$meminfo = explode("\n", @file_get_contents("/proc/meminfo"));
	$memory = "";
	for ($i = 0; $i < count($meminfo); ++$i) {
		if (substr($meminfo[$i], 0, 3) === "Mem") {
			$memory .= $meminfo[$i] . PHP_EOL;
		}
	}

	if (function_exists('sys_getloadavg')) {
		$loadArray = sys_getloadavg();
		$load = number_format($loadArray[0], 2, '.', '') . " / " . number_format($loadArray[1], 2, '.', '') . " / " . number_format($loadArray[2], 2, '.', '');
	} else {
		$load = @file_get_contents('/proc/loadavg');
		if (!$load) {
			$load = $lng['admin']['noloadavailable'];
		}
	}

	$kernel = '';
	if (function_exists('posix_uname')) {
		$kernel_nfo = posix_uname();
		$kernel = $kernel_nfo['release'] . ' (' . $kernel_nfo['machine'] . ')';
	}

	// Try to get the uptime
	// First: With exec (let's hope it's enabled for the Froxlor - vHost)
	$uptime_array = explode(" ", @file_get_contents("/proc/uptime"));
	$uptime = '';
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
	}

	$sysinfo = [
		'webserver' => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
		'phpversion' => phpversion(),
		'mysqlserverversion' => Database::getAttribute(PDO::ATTR_SERVER_VERSION),
		'phpsapi' => strtoupper(@php_sapi_name()),
		'hostname' => gethostname(),
		'memory' => $memory,
		'load' => $load,
		'kernel' => $kernel,
		'uptime' => $uptime
	];

	UI::twig()->addGlobal('userinfo', $userinfo);
	UI::twigBuffer('user/index.html.twig', [
		'sysinfo' => $sysinfo,
		'overview' => $overview,
		'outstanding_tasks' => $outstanding_tasks,
		'cron_last_runs' => $cron_last_runs
	]);
	UI::twigOutputBuffer();
} elseif ($page == 'change_password') {

	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$old_password = \Froxlor\Validate\Validate::validate($_POST['old_password'], 'old password');

		if (!\Froxlor\System\Crypt::validatePasswordLogin($userinfo, $old_password, TABLE_PANEL_ADMINS, 'adminid')) {
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
			\Froxlor\UI\Response::redirectTo($filename);
		}
	} else {
		UI::twigBuffer('user/change_password.html.twig');
		UI::twigOutputBuffer();
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
		}
		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "changed his/her default language to '" . $def_language . "'");
		\Froxlor\UI\Response::redirectTo($filename);
	} else {

		$default_lang = Settings::Get('panel.standardlanguage');
		if ($userinfo['def_language'] != '') {
			$default_lang = $userinfo['def_language'];
		}

		UI::twigBuffer('user/change_language.html.twig', [
			'languages' => $languages,
			'default_lang' => $default_lang
		]);
		UI::twigOutputBuffer();
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

		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "changed his/her theme to '" . $theme . "'");
		\Froxlor\UI\Response::redirectTo($filename);
	} else {

		$default_theme = Settings::Get('panel.default_theme');
		if ($userinfo['theme'] != '') {
			$default_theme = $userinfo['theme'];
		}

		$themes_avail = \Froxlor\UI\Template::getThemes();

		UI::twigBuffer('user/change_theme.html.twig', [
			'themes' => $themes_avail,
			'default_theme' => $default_theme
		]);
		UI::twigOutputBuffer();
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
				\Froxlor\UI\Response::redirectTo($filename);
			}
			// show a nice summary of the error-report
			// before actually sending anything
			eval("echo \"" . \Froxlor\UI\Template::getTemplate("index/send_error_report") . "\";");
		} else {
			\Froxlor\UI\Response::redirectTo($filename);
		}
	} else {
		\Froxlor\UI\Response::redirectTo($filename);
	}
} elseif ($page == 'apikeys' && Settings::Get('api.enabled') == 1) {
	require_once __DIR__ . '/api_keys.php';
} elseif ($page == '2fa' && Settings::Get('2fa.enabled') == 1) {
	require_once __DIR__ . '/2fa.php';
}
