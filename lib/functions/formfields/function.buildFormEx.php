<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Settings
 *
 */

function buildFormEx($form, $part = '')
{
	global $settings, $theme;
	$fields = '';

	if(validateFormDefinition($form))
	{
		foreach($form['groups'] as $groupname => $groupdetails)
		{
			// show overview
			if($part == '')
			{
				if(isset($groupdetails['title']) && $groupdetails['title'] != '')
				{
					$fields .= getFormOverviewGroupOutput($groupname, $groupdetails);
				}
			}
			// only show one section
			elseif($part != '' && ($groupname == $part || $part == 'all'))
			{
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
					if(isset($groupdetails['title']) && $groupdetails['title'] != '')
					{
						$fields .= getFormGroupOutput($groupname, $groupdetails);
					}
					
					if(validateFieldDefinition($groupdetails))
					{
						// Prefetch form fields
						foreach($groupdetails['fields'] as $fieldname => $fielddetails)
						{
							$groupdetails['fields'][$fieldname] = array_merge_prefix($fielddetails, $fielddetails['type'], prefetchFormFieldData($fieldname, $fielddetails));
							$form['groups'][$groupname]['fields'][$fieldname] = $groupdetails['fields'][$fieldname];
						}
		
						// Collect form field output
						foreach($groupdetails['fields'] as $fieldname => $fielddetails)
						{
							$fields .= getFormFieldOutput($fieldname, $fielddetails);
						}
					}
				}
			}
		}
	}

	return $fields;
}
