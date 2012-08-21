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

function getFormGroupOutput($groupname, $groupdetails)
{
	global $lng, $theme;
	eval("\$group = \"" . getTemplate("settings/settings_group") . "\";");
	return $group;
}

function getFormOverviewGroupOutput($groupname, $groupdetails)
{
	global $lng, $settings, $filename, $s, $theme;
	
	$group = '';
	$title = $groupdetails['title'];
	$part = $groupname;

	$activated = true;
	$option = '';
	if(isset($groupdetails['fields']))
	{
		foreach($groupdetails['fields'] as $fieldname => $fielddetails)
		{
			if(isset($fielddetails['overview_option'])
				&& $fielddetails['overview_option'] == true
			) {
				if($fielddetails['type'] != 'option'
					&& $fielddetails['type'] != 'bool')
				{
					standard_error('overviewsettingoptionisnotavalidfield');
				}

				if($fielddetails['type'] == 'option')
				{
					$options_array = $fielddetails['option_options'];		
					$options = '';
					foreach($options_array as $value => $vtitle)
					{
						$options .= makeoption($vtitle, $value, $settings[$fielddetails['settinggroup']][$fielddetails['varname']]);
					}
					$option.= $fielddetails['label'].':&nbsp;';
					$option.= '<select class="dropdown_noborder" name="'.$fieldname.'">';
					$option.= $options;
					$option.= '</select>';
					$activated = true;
				}
				else
				{
					$option.= $lng['admin']['activated'].':&nbsp;';
					$option.= makeyesno($fieldname, '1', '0', $settings[$fielddetails['settinggroup']][$fielddetails['varname']]);
					$activated = (int)$settings[$fielddetails['settinggroup']][$fielddetails['varname']];
				}
			}
		}
	}

	/**
	 * this part checks for the 'websrv_avail' entry in the settings-array
	 * if found, we check if the current webserver is in the array. If this
	 * is not the case, we change the setting type to "hidden", #502
	 */
	$do_show = true;
	if(isset($groupdetails['websrv_avail']) && is_array($groupdetails['websrv_avail']))
	{
		$websrv = $settings['system']['webserver'];
		if(!in_array($websrv, $groupdetails['websrv_avail']))
		{
			$do_show = false;
		}
	}	

	if($do_show)
	{
		eval("\$group = \"" . getTemplate("settings/settings_overviewgroup") . "\";");
	}
	return $group;
}
