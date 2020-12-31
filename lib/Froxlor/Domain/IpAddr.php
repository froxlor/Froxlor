<?php
namespace Froxlor\Domain;

use Froxlor\Database\Database;

class IpAddr
{

	public static function getIpAddresses()
	{
		$result_stmt = Database::query("
			SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `ip` ASC, `port` ASC
		");

		$system_ipaddress_array = array();

		while ($row = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {

			if (! isset($system_ipaddress_array[$row['ip']]) && ! in_array($row['ip'], $system_ipaddress_array)) {
				if (filter_var($row['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
					$row['ip'] = '[' . $row['ip'] . ']';
				}
				$system_ipaddress_array[$row['ip']] = $row['ip'];
			}
		}

		return $system_ipaddress_array;
	}

	public static function getIpPortCombinations($ssl = false)
	{
		global $userinfo;

		$additional_conditions_params = array();
		$additional_conditions_array = array();

		if ($userinfo['ip'] != '-1') {
			$admin_ip_stmt = Database::prepare("
				SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `id` = IN (:ipid)
			");
			$myips = implode(",", json_decode($userinfo['ip'], true));
			Database::pexecute($admin_ip_stmt, array(
				'ipid' => $myips
			));
			$additional_conditions_array[] = "`ip` IN (:adminips)";
			$additional_conditions_params['adminips'] = $myips;
		}

		if ($ssl !== null) {
			$additional_conditions_array[] = "`ssl` = :ssl";
			$additional_conditions_params['ssl'] = ($ssl === true ? '1' : '0');
		}

		$additional_conditions = '';
		if (count($additional_conditions_array) > 0) {
			$additional_conditions = " WHERE " . implode(" AND ", $additional_conditions_array) . " ";
		}

		$result_stmt = Database::prepare("
			SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` " . $additional_conditions . " ORDER BY `ip` ASC, `port` ASC
		");

		Database::pexecute($result_stmt, $additional_conditions_params);
		$system_ipaddress_array = array();

		while ($row = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
			if (filter_var($row['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$row['ip'] = '[' . $row['ip'] . ']';
			}
			$system_ipaddress_array[$row['id']] = $row['ip'] . ':' . $row['port'];
		}

		return $system_ipaddress_array;
	}

	public static function getSslIpPortCombinations()
	{
		global $lng;
		return array(
			'' => $lng['panel']['none_value']
		) + self::getIpPortCombinations(true);
	}
}
