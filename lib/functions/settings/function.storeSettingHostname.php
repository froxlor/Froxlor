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
 * @version    $Id$
 */

function storeSettingHostname($fieldname, $fielddata, $newfieldvalue, $server_id = 0)
{
	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue, $server_id );

	if($returnvalue !== false && is_array($fielddata) && isset($fielddata['settinggroup']) && $fielddata['settinggroup'] == 'system' && isset($fielddata['varname']) && $fielddata['varname'] == 'hostname')
	{
		global $db, $idna_convert;
		$newfieldvalue = $idna_convert->encode($newfieldvalue);
		
		$customerstddomains_result = $db->query('SELECT `standardsubdomain` FROM `' . TABLE_PANEL_CUSTOMERS . '` WHERE `standardsubdomain` <> \'0\' and `sid` = "'.$server_id.'"');
		$ids = array();

		while($customerstddomains_row = $db->fetch_array($customerstddomains_result))
		{
			$ids[] = (int)$customerstddomains_row['standardsubdomain'];
		}

		if(count($ids) > 0)
		{
			if($server_id > 0)
			{
				$client = froxlorclient::getInstance(null, $db, $server_id);
				$syshostname = $client->getSetting('system', 'hostname');
			} else {
				$syshostname = getSetting('system', 'hostname');
			}
			$db->query('UPDATE `' . TABLE_PANEL_DOMAINS . '` SET `domain` = REPLACE(`domain`, \'' . $db->escape($syshostname) . '\', \'' . $db->escape($newfieldvalue) . '\') WHERE `id` IN (\'' . implode('\',\'', $ids) . '\') AND `sid` = "'.$server_id.'"');
			inserttask('1', $server_id);
		}
	}
	
	return $returnvalue;
}

?>
