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

function checkUsername($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
{
	global $settings;
	if(!isset($allnewfieldvalues['customer_mysqlprefix']))
	{
		$allnewfieldvalues['customer_mysqlprefix'] = $settings['customer']['mysqlprefix'];
	}
	$returnvalue = array();
	if(validateUsername($newfieldvalue, $settings['panel']['unix_names'], 14 - strlen($allnewfieldvalues['customer_mysqlprefix'])) === true)
	{
		$returnvalue = array(FORMFIELDS_PLAUSIBILITY_CHECK_OK);
	}
	else
	{
		$returnvalue = array(FORMFIELDS_PLAUSIBILITY_CHECK_ERROR, 'accountprefixiswrong');
	}
	return $returnvalue;
}
