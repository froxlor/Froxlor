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
 * @version    $Id: function.checkMysqlAccessHost.php 2724 2009-06-07 14:18:02Z flo $
 */

function checkMysqlAccessHost($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
{
	$mysql_access_host_array = array_map('trim', explode(',', $newfieldvalue));

	foreach($mysql_access_host_array as $host_entry)
	{
		if(validate_ip($host_entry, true) == false
		   && validateDomain($host_entry) == false
		   && $host_entry != '%')
		{
			return array(FORMFIELDS_PLAUSIBILITY_CHECK_ERROR, 'invalidmysqlhost', $host_entry);
		}
	}
	
	return array(FORMFIELDS_PLAUSIBILITY_CHECK_OK);
}
