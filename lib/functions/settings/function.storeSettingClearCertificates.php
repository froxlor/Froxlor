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
* @author     Froxlor team <team@froxlor.org> (2010-)
* @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
* @package    Functions
*
*/

function storeSettingClearCertificates($fieldname, $fielddata, $newfieldvalue) {

	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if ($returnvalue !== false
		&& is_array($fielddata)
		&& isset($fielddata['settinggroup'])
		&& $fielddata['settinggroup'] == 'system'
		&& isset($fielddata['varname'])
		&& $fielddata['varname'] == 'le_froxlor_enabled'
		&& $newfieldvalue == '0'
		) {
			Database::query("
				DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` = '0'
			");
		}

		return $returnvalue;
}
