<?php
if (! defined('AREA')) {
	header("Location: index.php");
	exit();
}

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Panel
 *         
 */

// This file is being included in admin_domains and customer_domains
// and therefore does not need to require lib/init.php

// TODO get domain related settings for logfile (speciallogfile)
$domain_id = isset($_GET['domain_id']) ? (int) $_GET['domain_id'] : null;
$last_n = isset($_GET['number_of_lines']) ? (int) $_GET['number_of_lines'] : 100;

// user's with logviewenabled = false
if (AREA != 'admin' && $userinfo['logviewenabled'] != '1') {
	// back to domain overview
	redirectTo($filename, array(
		'page' => 'domains',
		's' => $s
	));
}

if (function_exists('exec')) {

	// get domain-info
	try {
		$json_result = SubDomains::getLocal($userinfo, array(
			'id' => $domain_id
		))->get();
	} catch (Exception $e) {
		dynamic_error($e->getMessage());
	}
	$domain = json_decode($json_result, true)['data'];

	$speciallogfile = '';
	if ($domain['speciallogfile'] == '1') {
		if ($domain['parentdomainid'] == '0') {
			$speciallogfile = '-' . $domain['domain'];
		} else {
			$speciallogfile = '-' . $domain['parentdomain'];
		}
	}
	// The normal access/error - logging is enabled
	$error_log = makeCorrectFile(Settings::Get('system.logfiles_directory') . getCustomerDetail($domain['customerid'], 'loginname') . $speciallogfile . '-error.log');
	$access_log = makeCorrectFile(Settings::Get('system.logfiles_directory') . getCustomerDetail($domain['customerid'], 'loginname') . $speciallogfile . '-access.log');

	// error log
	if (file_exists($error_log)) {
		$result = safe_exec('tail -n ' . $last_n . ' ' . escapeshellarg($error_log));
		$error_log_content = implode("\n", $result) . "</textarea>";
	} else {
		$error_log_content = "Error-Log" . (AREA == 'admin' ? " '" . $error_log . "'" : "") . " does not seem to exist";
	}

	// access log
	if (file_exists($access_log)) {
		$result = safe_exec('tail -n ' . $last_n . ' ' . escapeshellarg($access_log));
		$access_log_content = implode("\n", $result);
	} else {
		$access_log_content = "Access-Log" . (AREA == 'admin' ? " '" . $access_log . "'" : "") . " does not seem to exist";
	}

	eval("echo \"" . getTemplate("logfiles_viewer/index", true) . "\";");
} else {
	if (AREA == 'admin') {
		dynamic_error('You need to allow the exec() function in the froxlor-vhost php-config');
	} else {
		dynamic_error('Required function exec() is not allowed. Pllease contact the system administrator.');
	}
}
