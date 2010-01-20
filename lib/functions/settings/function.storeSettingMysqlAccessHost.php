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
 * @version    $Id: function.storeSettingMysqlAccessHost.php 2724 2009-06-07 14:18:02Z flo $
 */

function storeSettingMysqlAccessHost($fieldname, $fielddata, $newfieldvalue)
{
	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && $fielddata['varname'] == 'mysql_access_host')
	{
		$mysql_access_host_array = array_map('trim', explode(',', $newfieldvalue));

		if(in_array('127.0.0.1', $mysql_access_host_array)
		   && !in_array('localhost', $mysql_access_host_array))
		{
			$mysql_access_host_array[] = 'localhost';
		}

		if(!in_array('127.0.0.1', $mysql_access_host_array)
		   && in_array('localhost', $mysql_access_host_array))
		{
			$mysql_access_host_array[] = '127.0.0.1';
		}

		$mysql_access_host_array = array_unique(array_trim($mysql_access_host_array));
		$newfieldvalue = implode(',', $mysql_access_host_array);
		correctMysqlUsers($mysql_access_host_array);
	}
	
	return $returnvalue;
}
