<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\Admins as Admins;
use Froxlor\Api\Commands\Froxlor as Froxlor;
use Froxlor\CurrentUser;
use Froxlor\Database\Database;
use Froxlor\FroxlorLogger;
use Froxlor\Settings;
use Froxlor\System\Cronjob;
use Froxlor\System\Crypt;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;
use Froxlor\UI\Response;
use Froxlor\Validate\Validate;
use Froxlor\Language;

$id = (int)Request::any('id');

if ($action == 'logout') {
	$log->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "logged out");
	unset($_SESSION['userinfo']);
	CurrentUser::setData();
	session_destroy();

	Response::redirectTo('index.php');
} elseif ($action == 'suback') {
	if (is_array(CurrentUser::getField('switched_user'))) {
		$result = CurrentUser::getData();
		$result = $result['switched_user'];
		session_regenerate_id(true);
		CurrentUser::setData($result);
		$target = (isset($_GET['target']) ? $_GET['target'] : 'index');
		$redirect = "admin_" . $target . ".php";
		if (!file_exists(\Froxlor\Froxlor::getInstallDir() . "/" . $redirect)) {
			$redirect = "admin_index.php";
		}
		Response::redirectTo($redirect, null, true);
	} else {
		Response::dynamicError("Cannot change back - You've never switched to another user :-)");
	}
}

if ($page == 'overview') {
	$log->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_index");
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
			Response::dynamicError($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		$lookfornewversion_lable = $result['version'];
		$lookfornewversion_link = $result['link'];
		$lookfornewversion_message = $result['message'];
		$lookfornewversion_addinfo = $result['additional_info'];
		$isnewerversion = $result['isnewerversion'];
	} else {
		$lookfornewversion_lable = lng('admin.lookfornewversion.clickhere');
		$lookfornewversion_link = htmlspecialchars($filename . '?page=' . urlencode($page) . '&lookfornewversion=yes');
		$lookfornewversion_message = '';
		$lookfornewversion_addinfo = '';
		$isnewerversion = 0;
	}

	$cron_last_runs = Cronjob::getCronjobsLastRun();
	$outstanding_tasks = Cronjob::getOutstandingTasks();

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
			$load = lng('admin.noloadavailable');
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
	UI::view('user/index.html.twig', [
		'sysinfo' => $sysinfo,
		'overview' => $overview,
		'outstanding_tasks' => $outstanding_tasks,
		'cron_last_runs' => $cron_last_runs
	]);
} elseif ($page == 'change_password') {
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$old_password = Validate::validate($_POST['old_password'], 'old password');

		if (!Crypt::validatePasswordLogin($userinfo, $old_password, TABLE_PANEL_ADMINS, 'adminid')) {
			Response::standardError('oldpasswordnotcorrect');
		}

		try {
			$new_password = Crypt::validatePassword($_POST['new_password'], 'new password');
			$new_password_confirm = Crypt::validatePassword($_POST['new_password_confirm'], 'new password confirm');
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}

		if ($old_password == '') {
			Response::standardError([
				'stringisempty',
				'changepassword.old_password'
			]);
		} elseif ($new_password == '') {
			Response::standardError([
				'stringisempty',
				'changepassword.new_password'
			]);
		} elseif ($new_password_confirm == '') {
			Response::standardError([
				'stringisempty',
				'changepassword.new_password_confirm'
			]);
		} elseif ($new_password != $new_password_confirm) {
			Response::standardError('newpasswordconfirmerror');
		} else {
			try {
				Admins::getLocal($userinfo, [
					'id' => $userinfo['adminid'],
					'admin_password' => $new_password
				])->update();
			} catch (Exception $e) {
				Response::dynamicError($e->getMessage());
			}
			$log->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, 'changed password');
			Response::redirectTo($filename);
		}
	} else {
		UI::view('user/change_password.html.twig');
	}
} elseif ($page == 'change_language') {
	$languages = Language::getLanguages();
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$def_language = Validate::validate($_POST['def_language'], 'default language');

		if (isset($languages[$def_language])) {
			try {
				Admins::getLocal($userinfo, [
					'id' => $userinfo['adminid'],
					'def_language' => $def_language
				])->update();
				CurrentUser::setField('language', $def_language);
			} catch (Exception $e) {
				Response::dynamicError($e->getMessage());
			}
		}
		$log->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "changed his/her default language to '" . $def_language . "'");
		Response::redirectTo($filename);
	} else {
		$default_lang = Settings::Get('panel.standardlanguage');
		if ($userinfo['def_language'] != '') {
			$default_lang = $userinfo['def_language'];
		}

		UI::view('user/change_language.html.twig', [
			'languages' => $languages,
			'default_lang' => $default_lang
		]);
	}
} elseif ($page == 'change_theme') {
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$theme = Validate::validate($_POST['theme'], 'theme');
		try {
			Admins::getLocal($userinfo, [
				'id' => $userinfo['adminid'],
				'theme' => $theme
			])->update();
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}

		$log->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "changed his/her theme to '" . $theme . "'");
		Response::redirectTo($filename);
	} else {
		$default_theme = Settings::Get('panel.default_theme');
		if ($userinfo['theme'] != '') {
			$default_theme = $userinfo['theme'];
		}

		$themes_avail = UI::getThemes();

		UI::view('user/change_theme.html.twig', [
			'themes' => $themes_avail,
			'default_theme' => $default_theme
		]);
	}
} elseif ($page == 'send_error_report' && Settings::Get('system.allow_error_report_admin') == '1') {
	require_once __DIR__ . '/error_report.php';
} elseif ($page == 'apikeys' && Settings::Get('api.enabled') == 1) {
	require_once __DIR__ . '/api_keys.php';
} elseif ($page == '2fa' && Settings::Get('2fa.enabled') == 1) {
	require_once __DIR__ . '/2fa.php';
}
