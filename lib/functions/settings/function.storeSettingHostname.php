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

function storeSettingHostname($fieldname, $fielddata, $newfieldvalue)
{
	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && $fielddata['varname'] == 'hostname')
	{
		global $db, $idna_convert, $theme;
		$newfieldvalue = $idna_convert->encode($newfieldvalue);
		
		$customerstddomains_result = $db->query('SELECT `standardsubdomain` FROM `' . TABLE_PANEL_CUSTOMERS . '` WHERE `standardsubdomain` <> \'0\'');
		$ids = array();

		while($customerstddomains_row = $db->fetch_array($customerstddomains_result))
		{
			$ids[] = (int)$customerstddomains_row['standardsubdomain'];
		}

		if(count($ids) > 0)
		{
			$db->query('UPDATE `' . TABLE_PANEL_DOMAINS . '` SET `domain` = REPLACE(`domain`, \'' . $db->escape(getSetting('system', 'hostname')) . '\', \'' . $db->escape($newfieldvalue) . '\') WHERE `id` IN (\'' . implode('\',\'', $ids) . '\')');
		}
	}
	
	return $returnvalue;
}

?>
