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
const AREA = 'customer';
require __DIR__ . '/lib/init.php';

use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\Api\Commands\Customers as Customers;
use Froxlor\UI\Panel\UI;

if ($action == 'logout') {
	$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, 'logged out');

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
	$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_index");

	$domain_stmt = Database::prepare("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
		WHERE `customerid` = :customerid
		AND `parentdomainid` = '0'
		AND `id` <> :standardsubdomain
	");
	Database::pexecute($domain_stmt, array(
		"customerid" => $userinfo['customerid'],
		"standardsubdomain" => $userinfo['standardsubdomain']
	));

	$domainArray = array();
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
		$std_domain = Database::pexecute_first($std_domain_stmt, array(
			"customerid" => $userinfo['customerid'],
			"standardsubdomain" => $userinfo['standardsubdomain']
		));
		$stdsubdomain = $std_domain['domain'];
	}

	$userinfo['email'] = $idna_convert->decode($userinfo['email']);
	$yesterday = time() - (60 * 60 * 24);
	$month = date('M Y', $yesterday);

	// get disk-space usages for web, mysql and mail
	$usages_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DISKSPACE . "` WHERE `customerid` = :cid ORDER BY `stamp` DESC LIMIT 1");
	$usages = Database::pexecute_first($usages_stmt, array(
		'cid' => $userinfo['customerid']
	));

	// get everything in bytes for the percentage calculation on the dashboard
	$userinfo['diskspace_bytes'] = ($userinfo['diskspace'] > -1) ? $userinfo['diskspace'] * 1024 : -1;
	$userinfo['traffic_bytes'] = ($userinfo['traffic'] > -1) ? $userinfo['traffic'] * 1024 : -1;
	$userinfo['traffic_bytes_used'] = $userinfo['traffic_used'] * 1024;

	if ($usages) {
		$userinfo['diskspace_bytes_used'] = $usages['webspace'] * 1024;
		$userinfo['total_bytes_used'] = ($usages['webspace'] + $usages['mail'] + $usages['mysql']) * 1024;
	} else {
		$userinfo['diskspace_bytes_used'] = 0;
		$userinfo['total_bytes_used'] = 0;
	}

	UI::twig()->addGlobal('userinfo', $userinfo);
	UI::view('user/index.html.twig', [
		'domains' => $domainArray,
		'stdsubdomain' => $stdsubdomain
	]);
} elseif ($page == 'change_password') {

	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$old_password = \Froxlor\Validate\Validate::validate($_POST['old_password'], 'old password');

		if (!\Froxlor\System\Crypt::validatePasswordLogin($userinfo, $old_password, TABLE_PANEL_CUSTOMERS, 'customerid')) {
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
			// Update user password
			try {
				Customers::getLocal($userinfo, array(
					'id' => $userinfo['customerid'],
					'new_customer_password' => $new_password
				))->update();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, 'changed password');

			// Update ftp password
			if (isset($_POST['change_main_ftp']) && $_POST['change_main_ftp'] == 'true') {
				$cryptPassword = \Froxlor\System\Crypt::makeCryptPassword($new_password);
				$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
					SET `password` = :password
					WHERE `customerid` = :customerid
					AND `username` = :username");
				$params = array(
					"password" => $cryptPassword,
					"customerid" => $userinfo['customerid'],
					"username" => $userinfo['loginname']
				);
				Database::pexecute($stmt, $params);
				$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, 'changed main ftp password');
			}

			// Update statistics password
			if (isset($_POST['change_stats']) && $_POST['change_stats'] == 'true') {
				$new_stats_password = \Froxlor\System\Crypt::makeCryptPassword($new_password, true);

				$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_HTPASSWDS . "`
					SET `password` = :password
					WHERE `customerid` = :customerid
					AND `username` = :username");
				$params = array(
					"password" => $new_stats_password,
					"customerid" => $userinfo['customerid'],
					"username" => $userinfo['loginname']
				);
				Database::pexecute($stmt, $params);
			}

			\Froxlor\UI\Response::redirectTo($filename);
		}
	} else {
		UI::view('user/change_password.html.twig');
	}
} elseif ($page == 'change_language') {
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		$def_language = \Froxlor\Validate\Validate::validate($_POST['def_language'], 'default language');
		if (isset($languages[$def_language])) {
			try {
				Customers::getLocal($userinfo, array(
					'id' => $userinfo['customerid'],
					'def_language' => $def_language
				))->update();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
		}
		$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "changed default language to '" . $def_language . "'");
		\Froxlor\UI\Response::redirectTo($filename);
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
		$theme = \Froxlor\Validate\Validate::validate($_POST['theme'], 'theme');
		try {
			Customers::getLocal($userinfo, array(
				'id' => $userinfo['customerid'],
				'theme' => $theme
			))->update();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "changed default theme to '" . $theme . "'");
		\Froxlor\UI\Response::redirectTo($filename);
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
