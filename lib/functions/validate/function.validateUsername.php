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
 * Returns if an username is in correct format or not.
 *
 * @param string The username to check
 * @return bool Correct or not
 * @author Michael Duergner <michael@duergner.com>
 *
 * @changes Backported regex from SysCP 1.3 (lib/classes/Syscp/Handler/Validation.class.php)
 */

function validateUsername($username, $unix_names = 1, $mysql_max = '')
{
	if($unix_names == 0)
	{
		if(strpos($username, '--') === false)
		{
			return (preg_match('/^[a-z][a-z0-9\-_]{1,' . (int)($mysql_max - 1) . '}[a-z0-9]{1}$/Di', $username) != false);
		}
		else
		{
			return false;
		}
	}
	else
	{
		return (preg_match('/^[a-z][a-z0-9]{1,' . $mysql_max . '}$/Di', $username) != false);
	}
}
