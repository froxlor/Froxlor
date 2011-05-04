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

function loadSettings(&$settings_data, $db)
{
	$settings = array();

	if(is_array($settings_data) && isset($settings_data['groups']) && is_array($settings_data['groups']))
	{
		foreach($settings_data['groups'] as $settings_part => $settings_part_details)
		{
			if(is_array($settings_part_details) && isset($settings_part_details['fields']) && is_array($settings_part_details['fields']))
			{
				foreach($settings_part_details['fields'] as $field_name => $field_details)
				{
					if(isset($field_details['settinggroup']) && isset($field_details['varname']) && isset($field_details['default']))
					{
						$row = $db->query_first('SELECT `settinggroup`, `varname`, `value` FROM `' . TABLE_PANEL_SETTINGS . '` WHERE `settinggroup` = \'' . $db->escape($field_details['settinggroup']) . '\' AND `varname` = \'' . $db->escape($field_details['varname']) . '\' ');
						if(!empty($row))
						{
							$varvalue = $row['value'];
						}
						else
						{
							$varvalue = $field_details['default'];
						}

						$settings[$field_details['settinggroup']][$field_details['varname']] = $varvalue;
					}
					else
					{
						$varvalue = false;
					}

					$settings_data['groups'][$settings_part]['fields'][$field_name]['value'] = $varvalue;
				}
			}
		}
	}

	return $settings;
}

?>
