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

function loadSettings(&$settings_data, $db, $server_id = 0)
{
	global $version;

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
						$sql_query = 'SELECT 
							`settinggroup`, `varname`, `value` 
						FROM 
							`' . TABLE_PANEL_SETTINGS . '` 
						WHERE 
							`settinggroup` = \'' . $db->escape($field_details['settinggroup']) . '\' 
						AND 
							`varname` = \'' . $db->escape($field_details['varname']) . '\' ';
						
						// since 0.9.14-svn7 we have $server_id for multi-server-support
						// but versions before 0.9.14-svn7 don't have the `sid` field
						// in panel_settings, so only append the condition if we're on
						// 0.9.14-svn7 or higher
						if(compareFroxlorVersion('0.9.14-svn7', $version))
						{
							$sql_query_sid = 'AND `sid` = \''. (int)$server_id . '\' ';
						} else {
							$sql_query_sid = '';
						}

						$row = $db->query_first($sql_query.$sql_query_sid);
						if(!empty($row))
						{
							$varvalue = $row['value'];
						}
						elseif($server_id > 0)
						{
							// if we're a client (server_id > 0)
							// and a setting is not found or not
							// needed for clients, we get it from 
							// the master (server_id = 0)
							$sql_query_sid = 'AND `sid` = \'0\' ';
							$row = $db->query_first($sql_query.$sql_query_sid);
							if(!empty($row))
							{
								$varvalue = $row['value'];
							}
							else
							{
								// default to array-default-value
								$varvalue = $field_details['default'];
							}
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
