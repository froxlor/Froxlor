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
 * @version    $Id: function.storeSettingField.php 2724 2009-06-07 14:18:02Z flo $
 */

function storeSettingField($fieldname, $fielddata, $newfieldvalue)
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

function storeSettingFieldInsertBindTask($fieldname, $fielddata, $newfieldvalue)
{
	if(is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] != '' && isset($fielddata['varname']) && $fielddata['varname'] != '')
	{
		if(saveSetting($fielddata['settinggroup'], $fielddata['varname'], $newfieldvalue) != false)
		{
			inserttask('4');
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
