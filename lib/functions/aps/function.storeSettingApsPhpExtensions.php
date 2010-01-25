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
 * @version    $Id$
 */

function storeSettingApsPhpExtensions($fieldname, $fielddata, $newfieldvalue)
{
	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'aps' && isset($fielddata['varname']) && $fielddata['varname'] == 'php-extension')
	{
		$newfieldvalue_array = explode(',', $newfieldvalue);

		if(in_array('mcrypt', $newfieldvalue_array))
		{
			$functions = 'mcrypt_encrypt,mcrypt_decrypt';
		}
		else
		{
			$functions = '';
		}
		
		if($functions != getSetting('aps', 'php-function'))
		{
			saveSetting('aps', 'php-function', $functions);
		}
	}

	return $returnvalue;
}
