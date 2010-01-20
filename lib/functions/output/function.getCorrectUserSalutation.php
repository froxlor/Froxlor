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
 * @version    $Id: function.getCorrectUserSalutation.php 2724 2009-06-07 14:18:02Z flo $
 */

/**
 * Returns correct user salutation, either "Firstname Name" or "Company"
 *
 * @param  array  An array with keys firstname, name and company
 * @return string The correct salutation
 *
 * @author Florian Lippert <flo@syscp.org>
 */

function getCorrectUserSalutation($userinfo)
{
	$returnval = '';
	
	if(isset($userinfo['firstname']) && isset($userinfo['name']) && isset($userinfo['company']))
	{
		// Always prefer firstname name

		if($userinfo['company'] != '' && $userinfo['name'] == '' && $userinfo['firstname'] == '')
		{
			$returnval = $userinfo['company'];
		}
		else
		{
			$returnval = $userinfo['firstname'] . ' ' . $userinfo['name'];
		}
	}

	return $returnval;
}
