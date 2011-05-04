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

function storeSettingApsWebserverModules($fieldname, $fielddata, $newfieldvalue)
{
	if(is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'aps' && isset($fielddata['varname']) && $fielddata['varname'] == 'webserver-module')
	{
		$newfieldvalue_array = explode(',', $newfieldvalue);

		if(in_array('mod_rewrite', $newfieldvalue_array))
		{
			// Don't have to guess if we have to remove the leading comma as mod_rewrite is set anyways when we're here...
			$newfieldvalue .= ',mod_rewrite.c';
		}
		
		if(in_array('htaccess', $newfieldvalue_array))
		{
			$htaccess = 'htaccess';
		}
		else
		{
			$htaccess = '';
		}
		
		if($htaccess != getSetting('aps', 'webserver-htaccess'))
		{
			saveSetting('aps', 'webserver-htaccess', $htaccess);
		}
	}

	return storeSettingField($fieldname, $fielddata, $newfieldvalue);
}
