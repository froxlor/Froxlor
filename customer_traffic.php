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
$intrafficpage = 1;
require './lib/init.php';
$traffic = '';
$month = null;
$year = null;

if (isset($_POST['month']) && isset($_POST['year'])) {
	$month = intval($_POST['month']);
	$year = intval($_POST['year']);
} elseif (isset($_GET['month']) && isset($_GET['year'])) {
	$month = intval($_GET['month']);
	$year = intval($_GET['year']);
}
//BAM! $_GET???
elseif (isset($_GET['page']) && $_GET['page'] == 'current') {
	if (date('d') != '01') {
		$month = date('m');
		$year = date('Y');
	} else {
		if (date('m') == '01') {
			$month = 12;
			$year = date('Y') - 1;
		} else {
			$month = date('m') - 1;
			$year = date('Y');
		}
	}
}

if (!is_null($month) && !is_null($year)) {
	$traf['byte'] = 0;
	$result_stmt = Database::prepare("SELECT SUM(`http`) as 'http', SUM(`ftp_up`) AS 'ftp_up', SUM(`ftp_down`) as 'ftp_down', SUM(`mail`) as 'mail', `day`, `month`, `year`
		FROM `" . TABLE_PANEL_TRAFFIC . "`
		WHERE `customerid`= :customerid
		AND `month` = :month
		AND `year` = :year
		GROUP BY `day`
		ORDER BY `day` DESC"
	);
	$params = array(
		"customerid" => $userinfo['customerid'],
		"month" => $month,
		"year" => $year
	);
	Database::pexecute($result_stmt, $params);
	$traffic_complete['http'] = 0;
	$traffic_complete['ftp'] = 0;
	$traffic_complete['mail'] = 0;
	$show = '';

	while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		$http = $row['http'];
		$ftp = $row['ftp_up'] + $row['ftp_down'];
		$mail = $row['mail'];
		$traf['byte'] = $http + $ftp + $mail;
		$traffic_complete['http'] += $http;
		$traffic_complete['ftp'] += $ftp;
		$traffic_complete['mail'] += $mail;
		$traf['day'] = $row['day'] . '.';

		if (extension_loaded('bcmath')) {
			$traf['ftptext'] = bcdiv($row['ftp_up'], 1024, Settings::Get('panel.decimal_places')) . " MiB up/ " . bcdiv($row['ftp_down'], 1024, Settings::Get('panel.decimal_places')) . " MiB down (FTP)";
			$traf['httptext'] = bcdiv($http, 1024, Settings::Get('panel.decimal_places')) . " MiB (HTTP)";
			$traf['mailtext'] = bcdiv($mail, 1024, Settings::Get('panel.decimal_places')) . " MiB (Mail)";
			$traf['ftp'] = bcdiv($ftp, 1024, Settings::Get('panel.decimal_places'));
			$traf['http'] = bcdiv($http, 1024, Settings::Get('panel.decimal_places'));
			$traf['mail'] = bcdiv($mail, 1024, Settings::Get('panel.decimal_places'));
			$traf['byte'] = bcdiv($traf['byte'], 1024, Settings::Get('panel.decimal_places'));
		} else {
			$traf['ftptext'] = round($row['ftp_up'] / 1024, Settings::Get('panel.decimal_places')) . " MiB up/ " . round($row['ftp_down'] / 1024, Settings::Get('panel.decimal_places')) . " MiB down (FTP)";
			$traf['httptext'] = round($http / 1024, Settings::Get('panel.decimal_places')) . " MiB (HTTP)";
			$traf['mailtext'] = round($mail / 1024, Settings::Get('panel.decimal_places')) . " MiB (Mail)";
			$traf['http'] = round($http, Settings::Get('panel.decimal_places'));
			$traf['ftp'] = round($ftp, Settings::Get('panel.decimal_places'));
			$traf['mail'] = round($mail, Settings::Get('panel.decimal_places'));
			$traf['byte'] = round($traf['byte'] / 1024, Settings::Get('panel.decimal_places'));
		}

		eval("\$traffic.=\"" . getTemplate('traffic/traffic_month') . "\";");
		$show = $lng['traffic']['months'][intval($row['month'])] . ' ' . $row['year'];
	}

	$traffic_complete['http'] = size_readable($traffic_complete['http'] * 1024, 'GiB', 'bi', '%01.'.(int)Settings::Get('panel.decimal_places').'f %s');
	$traffic_complete['ftp'] = size_readable($traffic_complete['ftp'] * 1024, 'GiB', 'bi', '%01.'.(int)Settings::Get('panel.decimal_places').'f %s');
	$traffic_complete['mail'] = size_readable($traffic_complete['mail'] * 1024, 'GiB', 'bi', '%01.'.(int)Settings::Get('panel.decimal_places').'f %s');

	eval("echo \"" . getTemplate('traffic/traffic_details') . "\";");
} else {
	$result_stmt = Database::prepare("SELECT `month`, `year`, SUM(`http`) AS http, SUM(`ftp_up`) AS ftp_up, SUM(`ftp_down`) AS ftp_down, SUM(`mail`) AS mail
		FROM `" . TABLE_PANEL_TRAFFIC . "`
		WHERE `customerid` = :customerid
		GROUP BY CONCAT(`year`,`month`)
		ORDER BY CONCAT(`year`,`month`) DESC
		LIMIT 12"
	);
	Database::pexecute($result_stmt, array("customerid" => $userinfo['customerid']));
	$traffic_complete['http'] = 0;
	$traffic_complete['ftp'] = 0;
	$traffic_complete['mail'] = 0;

	while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		$http = $row['http'];
		$ftp_up = $row['ftp_up'];
		$ftp_down = $row['ftp_down'];
		$mail = $row['mail'];
		$traffic_complete['http'] += $http;
		$traffic_complete['ftp'] += $ftp_up + $ftp_down;
		$traffic_complete['mail'] += $mail;
		$traf['month'] = $row['month'];
		$traf['year'] = $row['year'];
		$traf['monthname'] = $lng['traffic']['months'][intval($row['month'])] . " " . $row['year'];
		$traf['byte'] = $http + $ftp_up + $ftp_down + $mail;

		if (extension_loaded('bcmath')) {
			$traf['ftptext'] = bcdiv($ftp_up, 1024, Settings::Get('panel.decimal_places')) . " MiB up/ " . bcdiv($ftp_down, 1024, Settings::Get('panel.decimal_places')) . " MiB down (FTP)";
			$traf['httptext'] = bcdiv($http, 1024, Settings::Get('panel.decimal_places')) . " MiB (HTTP)";
			$traf['mailtext'] = bcdiv($mail, 1024, Settings::Get('panel.decimal_places')) . " MiB (Mail)";
			$traf['ftp'] = bcdiv(($ftp_up + $ftp_down), 1024, Settings::Get('panel.decimal_places'));
			$traf['http'] = bcdiv($http, 1024, Settings::Get('panel.decimal_places'));
			$traf['mail'] = bcdiv($mail, 1024, Settings::Get('panel.decimal_places'));
			$traf['byte'] = bcdiv($traf['byte'], 1024 * 1024, Settings::Get('panel.decimal_places'));
		} else {
			$traf['ftptext'] = round($ftp_up / 1024, Settings::Get('panel.decimal_places')) . " MiB up/ " . round($ftp_down / 1024, Settings::Get('panel.decimal_places')) . " MiB down (FTP)";
			$traf['httptext'] = round($http / 1024, Settings::Get('panel.decimal_places')) . " MiB (HTTP)";
			$traf['mailtext'] = round($mail / 1024, Settings::Get('panel.decimal_places')) . " MiB (Mail)";
			$traf['ftp'] = round(($ftp_up + $ftp_down) / 1024, Settings::Get('panel.decimal_places'));
			$traf['http'] = round($http / 1024, Settings::Get('panel.decimal_places'));
			$traf['mail'] = round($mail / 1024, Settings::Get('panel.decimal_places'));
			$traf['byte'] = round($traf['byte'] / (1024 * 1024), Settings::Get('panel.decimal_places'));
		}

		eval("\$traffic.=\"" . getTemplate('traffic/traffic_traffic') . "\";");
	}

	$traffic_complete['http'] = size_readable($traffic_complete['http'] * 1024, 'GiB', 'bi', '%01.'.(int)Settings::Get('panel.decimal_places').'f %s');
	$traffic_complete['ftp'] = size_readable($traffic_complete['ftp'] * 1024, 'GiB', 'bi', '%01.'.(int)Settings::Get('panel.decimal_places').'f %s');
	$traffic_complete['mail'] = size_readable($traffic_complete['mail'] * 1024, 'GiB', 'bi', '%01.'.(int)Settings::Get('panel.decimal_places').'f %s');

	eval("echo \"" . getTemplate('traffic/traffic') . "\";");
}
