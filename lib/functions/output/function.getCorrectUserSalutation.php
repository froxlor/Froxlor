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
