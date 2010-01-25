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

function checkPlausibilityFormField($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
{
	$returnvalue = '';
	if(is_array($fielddata) && isset($fielddata['plausibility_check_method']) && $fielddata['plausibility_check_method'] != '' && function_exists($fielddata['plausibility_check_method']))
	{
		$returnvalue = call_user_func($fielddata['plausibility_check_method'], $fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues);
	}
	else
	{
		$returnvalue = false;
	}
	return $returnvalue;
}
