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

function getIpAddresses()
{
	global $db, $theme;
	
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
