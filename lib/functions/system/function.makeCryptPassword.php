<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michal Wojcik <m.wojcik@sonet3.pl>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Make crypted password from clear text password
 * @param string Password to be crypted
 * @param int Type of algorithm
 * @return string encrypted password
 *
 * @author Michal Wojcik <m.wojcik@sonet3.pl>
 *
 * 0 - default crypt (depenend on system configuration)
 * 1 - MD5 $1$
 * 2 - BLOWFISH $2a$
 * 3 - SHA-256 $5$
 * 4 - SHA-512 $6$
 */

function makeCryptPassword ($password, $type = 0)
{
        switch($type)
        {
                case 0:
			$cryptPassword = crypt($password);
                        break;
                case 1:
			$cryptPassword = crypt($password, '$1$' . generatePassword().  generatePassword());
                        break;
                case 2:
			$cryptPassword = crypt($password, '$2a$' . generatePassword().  generatePassword());
                        break;
                case 3:
			$cryptPassword = crypt($password, '$5$' . generatePassword().  generatePassword());
                        break;
                case 4:
			$cryptPassword = crypt($password, '$6$' . generatePassword().  generatePassword());
                        break;
                default:
			$cryptPassword = crypt($password);
                        break;
        }

	return ($cryptPassword);
}
