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

function buildForm($form)
{
	$fields = '';

	if(validateFormDefinition($form))
	{
		foreach($form['groups'] as $groupname => $groupdetails)
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

	return $fields;
}
