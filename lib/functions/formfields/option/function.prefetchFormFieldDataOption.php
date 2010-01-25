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

function prefetchFormFieldDataOption($fieldname, $fielddata)
{
	$returnvalue = array();
	
	if((!isset($fielddata['option_options']) || !is_array($fielddata['option_options']) || empty($fielddata['option_options'])) && (isset($fielddata['option_options_method']) && function_exists($fielddata['option_options_method'])))
	{
		$returnvalue['options'] = call_user_func($fielddata['option_options_method']);
	}
	
	return $returnvalue;
}
