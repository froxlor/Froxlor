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

function getIpPortCombinations($ssl = null)
{
	global $db, $theme;
	
	$additional_conditions = '';
	$additional_conditions_array = array();
	if(getSessionUserDetail('ip') != '-1')
	{
		$admin_ip = $db->query_first('SELECT `id`, `ip`, `port` FROM `' . TABLE_PANEL_IPSANDPORTS . '` WHERE `id` = \'' . (int)getSessionUserDetail('ip') . '\' ORDER BY `ip`, `port` ASC');
		$additional_conditions_array[] = '`ip` = \'' . $admin_ip['ip'] . '\'';
		unset($admin_ip);
	}
	if($ssl !== null)
	{
		$additional_conditions_array[] = '`ssl` = \'' . ( $ssl === true ? '1' : '0' ) . '\'';
	}
	if(!empty($additional_conditions_array))
	{
		$additional_conditions = ' WHERE ' . implode(' AND ', $additional_conditions_array) . ' ';
	}

	$query = 'SELECT `id`, `ip`, `port` FROM `' . TABLE_PANEL_IPSANDPORTS . '` ' . $additional_conditions . ' ORDER BY `ip` ASC, `port` ASC';
	$result = $db->query($query);
	$system_ipaddress_array = array();

	while($row = $db->fetch_array($result))
	{
		if(filter_var($row['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
		{
				$row['ip'] = '[' . $row['ip'] . ']';
		}

		$system_ipaddress_array[$row['id']] = $row['ip'] . ':' . $row['port'];
	}
	
	return $system_ipaddress_array;
}
