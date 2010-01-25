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

function storeSettingDefaultIp($fieldname, $fielddata, $newfieldvalue)
{
	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && $fielddata['varname'] == 'defaultip')
	{
		global $db;
		
		$customerstddomains_result = $db->query('SELECT `standardsubdomain` FROM `' . TABLE_PANEL_CUSTOMERS . '` WHERE `standardsubdomain` <> \'0\'');
		$ids = array();

		while($customerstddomains_row = $db->fetch_array($customerstddomains_result))
		{
			$ids[] = (int)$customerstddomains_row['standardsubdomain'];
		}

		if(count($ids) > 0)
		{
			$db->query('UPDATE `' . TABLE_PANEL_DOMAINS . '` SET `ipandport`=\'' . (int)$newfieldvalue . '\' WHERE `id` IN (\'' . implode('\',\'', $ids) . '\') AND `ipandport` = \'' . $db->escape(getSetting('system', 'defaultip')) . '\'');
		}

		inserttask('1');
	}
	
	return $returnvalue;
}

?>
