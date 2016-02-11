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
 * Returns if an emailaddress is in correct format or not
 *
 * @param string The email address to check
 * @return bool Correct or not
 * @author Florian Lippert <flo@syscp.org>
 *
 * @changes Backported regex from SysCP 1.3 (lib/classes/Syscp/Handler/Validation.class.php)
 */

function validateEmail($email)
{
	$email = strtolower($email);
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}
