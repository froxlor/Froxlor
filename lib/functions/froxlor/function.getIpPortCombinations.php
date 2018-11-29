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
 * @package    Functions
 *
 */

function getIpPortCombinations($ssl = false) {

	global $userinfo;

	$additional_conditions_params = array();
	$additional_conditions_array = array();

	if ($userinfo['ip'] != '-1') {
		$admin_ip_stmt = Database::prepare("
			SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = IN (:ipid)
		");
		$myips = implode(",", json_decode($userinfo['ip'], true));
		Database::pexecute($admin_ip_stmt, array('ipid' => $myips));
		$additional_conditions_array[] = "`ip` IN (:adminips)";
		$additional_conditions_params['adminips'] = $myips;
	}

	if ($ssl !== null) {
		$additional_conditions_array[] = "`ssl` = :ssl";
		$additional_conditions_params['ssl'] = ($ssl === true ? '1' : '0' );
	}

	$additional_conditions = '';
	if (count($additional_conditions_array) > 0) {
		$additional_conditions = " WHERE " . implode(" AND ", $additional_conditions_array) . " ";
	}

	$result_stmt = Database::prepare("
		SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` " .
		$additional_conditions . " ORDER BY `ip` ASC, `port` ASC
	");

	Database::pexecute($result_stmt, $additional_conditions_params);
	$system_ipaddress_array = array();

	while($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		if (filter_var($row['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			$row['ip'] = '[' . $row['ip'] . ']';
		}
		$system_ipaddress_array[$row['id']] = $row['ip'] . ':' . $row['port'];
	}

	return $system_ipaddress_array;
}

function getSslIpPortCombinations() {
	global $lng;
	return array('' => $lng['panel']['none_value']) + getIpPortCombinations(true);
}
