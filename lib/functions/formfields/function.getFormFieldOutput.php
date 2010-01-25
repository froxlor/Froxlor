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

function getFormFieldOutput($fieldname, $fielddata)
{
	$returnvalue = '';
	if(is_array($fielddata) && isset($fielddata['type']) && $fielddata['type'] != '' && function_exists('getFormFieldOutput' . ucfirst($fielddata['type'])))
	{
		if(isset($fielddata['label']) && is_array($fielddata['label']))
		{
			if(isset($fielddata['label']['title']) && isset($fielddata['label']['description']))
			{
				$fielddata['label'] = '<b>' . $fielddata['label']['title'] . '</b><br />' . $fielddata['label']['description'];
			}
			else
			{
				$fielddata['label'] = implode(' ', $fielddata['label']);
			}
		}
		if(!isset($fielddata['value']))
		{
			if(isset($fielddata['default']))
			{
				$fielddata['value'] = $fielddata['default'];
			}
			else
			{
				$fielddata['value'] = null;
			}
		}
		$returnvalue = call_user_func('getFormFieldOutput' . ucfirst($fielddata['type']), $fieldname, $fielddata);
	}
	return $returnvalue;
}
