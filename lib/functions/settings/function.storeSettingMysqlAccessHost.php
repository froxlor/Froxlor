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

?>
