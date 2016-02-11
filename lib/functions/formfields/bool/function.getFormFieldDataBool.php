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

function getFormFieldDataBool($fieldname, $fielddata, &$input)
{
	if(isset($input[$fieldname]) && ($input[$fieldname] === '1' || $input[$fieldname] === 1 || $input[$fieldname] === true || strtolower($input[$fieldname]) === 'yes' || strtolower($input[$fieldname]) === 'ja'))
	{
		$newfieldvalue = '1';
	}
	else
	{
		$newfieldvalue = '0';
	}

	return $newfieldvalue;
}
