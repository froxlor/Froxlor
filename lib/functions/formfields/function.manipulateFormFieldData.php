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
 * @version    $Id: function.manipulateFormFieldData.php 2735 2009-11-06 09:52:59Z flo $
 */

function manipulateFormFieldData($fieldname, $fielddata, $newfieldvalue)
{
	if(is_array($fielddata) && isset($fielddata['type']) && $fielddata['type'] != '' && function_exists('manipulateFormFieldData' . ucfirst($fielddata['type'])))
	{
		$newfieldvalue = call_user_func('manipulateFormFieldData' . ucfirst($fielddata['type']), $fieldname, $fielddata, $newfieldvalue);
	}

	return $newfieldvalue;
}
