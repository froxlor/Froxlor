<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id: function.getIpAddresses.php 2724 2009-06-07 14:18:02Z flo $
 */

function getIpAddresses()
{
	global $db;
	
	$query = 'SELECT `id`, `ip`, `port` FROM `' . TABLE_PANEL_IPSANDPORTS . '` ORDER BY `ip` ASC, `port` ASC';
	$result = $db->query($query);
	$system_ipaddress_array = array();

	while($row = $db->fetch_array($result))
	{
		if(!isset($system_ipaddress_array[$row['ip']])
		   && !in_array($row['ip'], $system_ipaddress_array))
		{
			if(filter_var($row['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
			{
				$row['ip'] = '[' . $row['ip'] . ']';
			}

			$system_ipaddress_array[$row['ip']] = $row['ip'];
		}
	}

	return $system_ipaddress_array;
}
