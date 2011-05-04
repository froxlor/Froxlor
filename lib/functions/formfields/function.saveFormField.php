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

function saveFormField($fieldname, $fielddata, $newfieldvalue)
{
	$returnvalue = '';
	if(is_array($fielddata) && isset($fielddata['save_method']) && $fielddata['save_method'] != '' && function_exists($fielddata['save_method']))
	{
		$returnvalue = call_user_func($fielddata['save_method'], $fieldname, $fielddata, $newfieldvalue);
	}
	elseif(is_array($fielddata) && !isset($fielddata['save_method']))
	{
		$returnvalue = array();
	}
	else
	{
		$returnvalue = false;
	}
	return $returnvalue;
}
