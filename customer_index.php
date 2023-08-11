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

const AREA = 'customer';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\Customers as Customers;
use Froxlor\CurrentUser;
use Froxlor\Database\Database;
use Froxlor\Froxlor;
use Froxlor\FroxlorLogger;
use Froxlor\Settings;
use Froxlor\System\Crypt;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Response;
use Froxlor\Validate\Validate;
use Froxlor\Language;
use Froxlor\System\Cronjob;
use Froxlor\Cron\TaskId;

if ($action == 'logout') {
	$log->logAction(FroxlorLogger::USR_ACTION, LOG_NOTICE, 'logged out');

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
		if (!file_exists(Froxlor::getInstallDir() . "/" . $redirect)) {
			$redirect = "admin_index.php";
		}
		Response::redirectTo($redirect, null, true);
	} else {
		Response::dynamicError("Cannot change back - You've never switched to another user :-)");
	}
}

if ($page == 'overview') {
	$log->logAction(FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_index");

	$domain_stmt = Database::prepare("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
		WHERE `customerid` = :customerid
		AND `parentdomainid` = '0'
		AND `id` <> :standardsubdomain
	");
	Database::pexecute($domain_stmt, [
		"customerid" => $userinfo['customerid'],
		"standardsubdomain" => $userinfo['standardsubdomain']
	]);

	$domainArray = [];
	while ($row = $domain_stmt->fetch(PDO::FETCH_ASSOC)) {
		$domainArray[] = $idna_convert->decode($row['domain']);
	}
	natsort($domainArray);

	// standard-subdomain
	$stdsubdomain = '';
	if ($userinfo['standardsubdomain'] != '0') {
		$std_domain_stmt = Database::prepare("
			SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE `customerid` = :customerid
			AND `id` = :standardsubdomain
		");
		$std_domain = Database::pexecute_first($std_domain_stmt, [
			"customerid" => $userinfo['customerid'],
			"standardsubdomain" => $userinfo['standardsubdomain']
		]);
		$stdsubdomain = $std_domain['domain'];
	}

	$userinfo['email'] = $idna_convert->decode($userinfo['email']);
	$yesterday = time() - (60 * 60 * 24);
	$month = date('M Y', $yesterday);

	// get disk-space usages for web, mysql and mail
	$usages_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DISKSPACE . "` WHERE `customerid` = :cid ORDER BY `stamp` DESC LIMIT 1");
	$usages = Database::pexecute_first($usages_stmt, [
		'cid' => $userinfo['customerid']
	]);

	// get everything in bytes for the percentage calculation on the dashboard
	$userinfo['diskspace_bytes'] = ($userinfo['diskspace'] > -1) ? $userinfo['diskspace'] * 1024 : -1;
	$userinfo['traffic_bytes'] = ($userinfo['traffic'] > -1) ? $userinfo['traffic'] * 1024 : -1;
	$userinfo['traffic_bytes_used'] = $userinfo['traffic_used'] * 1024;

	if ($usages) {
		$userinfo['diskspace_bytes_used'] = $usages['webspace'] * 1024;
		$userinfo['mailspace_used']  = $usages['mail'] * 1024;
		$userinfo['dbspace_used'] = $usages['mysql'] * 1024;
		$userinfo['total_bytes_used'] = ($usages['webspace'] + $usages['mail'] + $usages['mysql']) * 1024;
	} else {
		$userinfo['diskspace_bytes_used'] = 0;
		$userinfo['total_bytes_used'] = 0;
		$userinfo['mailspace_used']  = 0;
		$userinfo['dbspace_used'] = 0;
	}

	UI::twig()->addGlobal('userinfo', $userinfo);
	UI::view('user/index.html.twig', [
		'domains' => $domainArray,
		'stdsubdomain' => $stdsubdomain
	]);
} elseif ($page == 'change_password') {
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$old_password = Validate::validate($_POST['old_password'], 'old password');

		if (!Crypt::validatePasswordLogin($userinfo, $old_password, TABLE_PANEL_CUSTOMERS, 'customerid')) {
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
			// Update user password
			try {
				Customers::getLocal($userinfo, [
					'id' => $userinfo['customerid'],
					'new_customer_password' => $new_password
				])->update();
			} catch (Exception $e) {
				Response::dynamicError($e->getMessage());
			}
			$log->logAction(FroxlorLogger::USR_ACTION, LOG_NOTICE, 'changed password');

			// Update ftp password
			if (isset($_POST['change_main_ftp']) && $_POST['change_main_ftp'] == 'true') {
				$cryptPassword = Crypt::makeCryptPassword($new_password);
				$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
					SET `password` = :password
					WHERE `customerid` = :customerid
					AND `username` = :username");
				$params = [
					"password" => $cryptPassword,
					"customerid" => $userinfo['customerid'],
					"username" => $userinfo['loginname']
				];
				Database::pexecute($stmt, $params);
				$log->logAction(FroxlorLogger::USR_ACTION, LOG_NOTICE, 'changed main ftp password');
			}

			// Update statistics password
			if (isset($_POST['change_stats']) && $_POST['change_stats'] == 'true') {
				$new_stats_password = Crypt::makeCryptPassword($new_password, true);

				$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_HTPASSWDS . "`
					SET `password` = :password
					WHERE `customerid` = :customerid
					AND `username` = :username");
				$params = [
					"password" => $new_stats_password,
					"customerid" => $userinfo['customerid'],
					"username" => $userinfo['loginname']
				];
				Database::pexecute($stmt, $params);
				Cronjob::inserttask(TaskId::REBUILD_VHOST);
			}

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
				Customers::getLocal($userinfo, [
					'id' => $userinfo['customerid'],
					'def_language' => $def_language
				])->update();
				CurrentUser::setField('language', $def_language);
			} catch (Exception $e) {
				Response::dynamicError($e->getMessage());
			}
		}
		$log->logAction(FroxlorLogger::USR_ACTION, LOG_NOTICE, "changed default language to '" . $def_language . "'");
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
			Customers::getLocal($userinfo, [
				'id' => $userinfo['customerid'],
				'theme' => $theme
			])->update();
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}

		$log->logAction(FroxlorLogger::USR_ACTION, LOG_NOTICE, "changed default theme to '" . $theme . "'");
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
} elseif ($page == 'send_error_report' && Settings::Get('system.allow_error_report_customer') == '1') {
	require_once __DIR__ . '/error_report.php';
} elseif ($page == 'apikeys' && Settings::Get('api.enabled') == 1) {
	require_once __DIR__ . '/api_keys.php';
} elseif ($page == '2fa' && Settings::Get('2fa.enabled') == 1) {
	require_once __DIR__ . '/2fa.php';
}
