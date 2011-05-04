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
 * @author     Morton Jonuschat <m.jonuschat@chrome-it.de>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Panel
 *
 */

define('AREA', 'admin');

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if($action == 'logout')
{
	$db->query("DELETE FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid` = '" . (int)$userinfo['adminid'] . "' AND `adminsession` = '1'");
	redirectTo('index.php');
	exit;
}

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

$months = array(
	'0' => 'empty',
	'1' => 'jan',
	'2' => 'feb',
	'3' => 'mar',
	'4' => 'apr',
	'5' => 'may',
	'6' => 'jun',
	'7' => 'jul',
	'8' => 'aug',
	'9' => 'sep',
	'10' => 'oct',
	'11' => 'nov',
	'12' => 'dec',
);

if($page == 'overview' || $page == 'customers') 
{
	if($action == 'su' && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid`='" . (int)$id . "' " . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = '" . (int)$userinfo['adminid'] . "' "));

		if($result['loginname'] != '')
		{
			$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid`='" . (int)$userinfo['userid'] . "'");
			$s = md5(uniqid(microtime(), 1));
			$db->query("INSERT INTO `" . TABLE_PANEL_SESSIONS . "` (`hash`, `userid`, `ipaddress`, `useragent`, `lastactivity`, `language`, `adminsession`) VALUES ('" . $db->escape($s) . "', '" . (int)$id . "', '" . $db->escape($result['ipaddress']) . "', '" . $db->escape($result['useragent']) . "', '" . time() . "', '" . $db->escape($result['language']) . "', '0')");
			redirectTo('customer_traffic.php', Array(
				's' => $s
			));
		}
		else
		{
			redirectTo('index.php', Array(
				'action' => 'login'
			));
		}
	}
	$customerview = 1;
	$stats_tables = '';
	$minyear = $db->query_first("SELECT `year` FROM `". TABLE_PANEL_TRAFFIC . "` ORDER BY `year` ASC LIMIT 1");
	if (!isset($minyear['year']) || $minyear['year'] == 0)
	{
		$maxyears = 0;
	}
	else
	{
		$maxyears = date("Y") - $minyear['year'];
	}
	for($years = 0; $years<=$maxyears; $years++) {
		$overview['year'] = date("Y")-$years;
		$overview['type'] = $lng['traffic']['customer'];
		$domain_list = '';
		$customer_name_list = $db->query("SELECT `customerid`,`company`,`name`,`firstname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `deactivated`='0'" . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = '" . (int)$userinfo['adminid'] . "' ") . " ORDER BY name");
		$totals = array(
			'jan' => 0,
			'feb' => 0,
			'mar' => 0,
			'apr' => 0,
			'may' => 0,
			'jun' => 0,
			'jul' => 0,
			'aug' => 0,
			'sep' => 0,
			'oct' => 0,
			'nov' => 0,
			'dec' => 0,
		);
		while($customer_name = $db->fetch_array($customer_name_list)) {
			$virtual_host = array(
				'name' => ($customer_name['company'] == '' ? $customer_name['name'] . ", " . $customer_name['firstname'] : $customer_name['company']),
				'customerid' => $customer_name['customerid'],
				'jan' => '-',
				'feb' => '-',
				'mar' => '-',
				'apr' => '-',
				'may' => '-',
				'jun' => '-',
				'jul' => '-',
				'aug' => '-',
				'sep' => '-',
				'oct' => '-',
				'nov' => '-',
				'dec' => '-',
			);
			
			$traffic_list = $db->query("SELECT month, SUM(http+ftp_up+ftp_down+mail)*1024 AS traffic FROM `" . TABLE_PANEL_TRAFFIC . "` WHERE year = " . (date("Y")-$years) . " AND `customerid` = '" . $customer_name['customerid'] . "' GROUP BY month ORDER BY month");
			while($traffic_month = $db->fetch_array($traffic_list)) {
				$virtual_host[$months[(int)$traffic_month['month']]] = size_readable($traffic_month['traffic'], 'GiB', 'bi', '%01.3f %s');
				$totals[$months[(int)$traffic_month['month']]] += $traffic_month['traffic'];
			}
			eval("\$domain_list .= sprintf(\"%s\", \"" . getTemplate("traffic/index_table_row") . "\");");
		}
		// sum up totals
		$virtual_host = array(
			'name' => $lng['traffic']['months']['total'],
		);
		foreach($totals as $month => $bytes) {
			$virtual_host[$month] = ($bytes == 0 ? '-' : size_readable($bytes, 'GiB', 'bi', '%01.3f %s'));
		}
		$customerview = 0;
		eval("\$total_list = sprintf(\"%s\", \"" . getTemplate("traffic/index_table_row") . "\");");
		eval("\$stats_tables .= sprintf(\"%s\", \"" . getTemplate("traffic/index_table") . "\");");
	}
	eval("echo \"" . getTemplate("traffic/index") . "\";");
}
