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
$intrafficpage = 1;
require __DIR__ . '/lib/init.php';

use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;
use Froxlor\UI\Response;

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options', 'traffic')) {
	Response::redirectTo('customer_index.php');
}

$traffic = '';
$month = null;
$year = null;

if (Request::exist('month') && Request::exist('year')) {
	$month = (int)Request::get('month');
	$year = (int)Request::get('year');
} elseif (isset($_GET['page']) && $_GET['page'] == 'current') {
	if (date('d') != '01') {
		$month = date('m');
		$year = date('Y');
	} elseif (date('m') == '01') {
		$month = 12;
		$year = date('Y') - 1;
	} else {
		$month = date('m') - 1;
		$year = date('Y');
	}
}

if (!is_null($month) && !is_null($year)) {
	$result_stmt = Database::prepare("SELECT SUM(`http`) as 'http', SUM(`ftp_up`) AS 'ftp_up', SUM(`ftp_down`) as 'ftp_down', SUM(`mail`) as 'mail', `day`, `month`, `year`
		FROM `" . TABLE_PANEL_TRAFFIC . "`
		WHERE `customerid`= :customerid
		AND `month` = :month
		AND `year` = :year
		GROUP BY `day`
		ORDER BY `day` DESC");
	$params = [
		"customerid" => $userinfo['customerid'],
		"month" => $month,
		"year" => $year
	];
	Database::pexecute($result_stmt, $params);
	$traf['byte'] = 0;
	$traffic_complete['http'] = 0;
	$traffic_complete['ftp'] = 0;
	$traffic_complete['mail'] = 0;
	$traf['days'] = [];
	$traf['http_data'] = [];
	$traf['ftp_data'] = [];
	$traf['mail_data'] = [];

	while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		$http = $row['http'];
		$traf['http_data'][] = (float)$http;
		$ftp = $row['ftp_up'] + $row['ftp_down'];
		$traf['ftp_data'][] = (float)$ftp;
		$mail = $row['mail'];
		$traf['mail_data'][] = (float)$mail;
		$traf['byte'] = $http + $ftp + $mail;
		$traffic_complete['http'] += $http;
		$traffic_complete['ftp'] += $ftp;
		$traffic_complete['mail'] += $mail;
		$traf['days'][] = $row['day'];
	}

	UI::view('user/traffic.html.twig', [
		'traffic_complete_http' => $traffic_complete['http'],
		'traffic_complete_ftp' => $traffic_complete['ftp'],
		'traffic_complete_mail' => $traffic_complete['mail'],
		'traffic_complete_total' => $traf['byte'],
		'labels' => $traf['days'],
		'http_data' => $traf['http_data'],
		'ftp_data' => $traf['ftp_data'],
		'mail_data' => $traf['mail_data'],
	]);
} else {
	$result_stmt = Database::prepare("
		SELECT `month`, `year`, SUM(`http`) AS http, SUM(`ftp_up`) AS ftp_up, SUM(`ftp_down`) AS ftp_down, SUM(`mail`) AS mail
		FROM `" . TABLE_PANEL_TRAFFIC . "`
		WHERE `customerid` = :customerid
		GROUP BY `year`, `month`
		ORDER BY `year` DESC, `month` DESC
		LIMIT 12
	");
	Database::pexecute($result_stmt, [
		"customerid" => $userinfo['customerid']
	]);
	$traffic_complete['http'] = 0;
	$traffic_complete['ftp'] = 0;
	$traffic_complete['mail'] = 0;
	$traf['days'] = [];
	$traf['http_data'] = [];
	$traf['ftp_data'] = [];
	$traf['mail_data'] = [];

	while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		$http = $row['http'];
		$traf['http_data'][] = (int)$http / 1024 / 1024;
		$ftp_up = $row['ftp_up'];
		$ftp_down = $row['ftp_down'];
		$traf['ftp_data'][] = (int)($ftp_up + $ftp_down) / 1024 / 1024;
		$mail = $row['mail'];
		$traf['mail_data'][] = (int)$mail / 1024 / 1024;
		$traffic_complete['http'] += $http;
		$traffic_complete['ftp'] += $ftp_up + $ftp_down;
		$traffic_complete['mail'] += $mail;
		$traf['month'] = $row['month'];
		$traf['year'] = $row['year'];
		$traf['monthname'] = lng('traffic.months.' . intval($row['month'])) . " " . $row['year'];
		$traf['byte'] = $http + $ftp_up + $ftp_down + $mail;
		$traf['byte_total'] = $traf['byte_total'] + $http + $ftp_up + $ftp_down + $mail;
		$traf['days'][] = $traf['monthname'];
	}

	UI::view('user/traffic.html.twig', [
		'traffic_complete_http' => $traffic_complete['http'],
		'traffic_complete_ftp' => $traffic_complete['ftp'],
		'traffic_complete_mail' => $traffic_complete['mail'],
		'traffic_complete_total' => $traf['byte_total'],
		'labels' => $traf['days'],
		'http_data' => $traf['http_data'],
		'ftp_data' => $traf['ftp_data'],
		'mail_data' => $traf['mail_data'],
	]);
}

function getReadableTraffic(&$traf, $index, $value, $divisor, $desc = "")
{
	if (extension_loaded('bcmath')) {
		$traf[$index] = bcdiv($value, $divisor, Settings::Get('panel.decimal_places')) . (!empty($desc) ? " " . $desc : "");
	} else {
		$traf[$index] = round($value / $divisor, Settings::Get('panel.decimal_places')) . (!empty($desc) ? " " . $desc : "");
	}
}
