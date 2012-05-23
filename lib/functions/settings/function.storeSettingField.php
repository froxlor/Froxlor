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

function storeSettingField($fieldname, $fielddata, $newfieldvalue)
{
	if(is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] != '' && isset($fielddata['varname']) && $fielddata['varname'] != '')
	{

		if(saveSetting($fielddata['settinggroup'], $fielddata['varname'], $newfieldvalue) != false)
		{
			/*
			 * when fielddata[cronmodule] is set, this means enable/disable a cronjob
			 */
			if(isset($fielddata['cronmodule']) && $fielddata['cronmodule'] != '')
			{
				toggleCronStatus($fielddata['cronmodule'], $newfieldvalue);
			}

			/*
			 * satisfy dependencies
			 */
			if(isset($fielddata['dependency']) && is_array($fielddata['dependency']))
			{
				if((int)$fielddata['dependency']['onlyif'] == (int)$newfieldvalue)
				{
					storeSettingField($fielddata['dependency']['fieldname'], $fielddata['dependency']['fielddata'], $newfieldvalue);
				}
			}

			return array($fielddata['settinggroup'] . '.' . $fielddata['varname'] => $newfieldvalue);
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function storeSettingFieldInsertBindTask($fieldname, $fielddata, $newfieldvalue)
{
	if(is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] != '' && isset($fielddata['varname']) && $fielddata['varname'] != '')
	{
		if(saveSetting($fielddata['settinggroup'], $fielddata['varname'], $newfieldvalue) != false)
		{
			return array($fielddata['settinggroup'] . '.' . $fielddata['varname'] => $newfieldvalue);
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

?>
