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
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Make crypted password from clear text password
 *
 * @author Michal Wojcik <m.wojcik@sonet3.pl>
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 * @author Froxlor team <team@froxlor.org> (2010-)
 *
 * 0 - default crypt (depenend on system configuration)
 * 1 - MD5 $1$
 * 2 - BLOWFISH $2a$ | $2y$07$ (on php 5.3.7+)
 * 3 - SHA-256 $5$ (default)
 * 4 - SHA-512 $6$
 *
 * @param string $password Password to be crypted
 *
 * @return string encrypted password
 */
function makeCryptPassword ($password) {

	$type = Settings::Get('system.passwordcryptfunc') !== null ? (int)Settings::Get('system.passwordcryptfunc') : 3;

	switch ($type) {
		case 0:
			$cryptPassword = crypt($password);
			break;
		case 1:
			$cryptPassword = crypt($password, '$1$' . generatePassword(true).  generatePassword(true));
			break;
		case 2:
			if (version_compare(phpversion(), '5.3.7', '<')) {
				$cryptPassword = crypt($password, '$2a$' . generatePassword(true).  generatePassword(true));
			} else {
				// Blowfish hashing with a salt as follows: "$2a$", "$2x$" or "$2y$",
				// a two digit cost parameter, "$", and 22 characters from the alphabet "./0-9A-Za-z"
				$cryptPassword = crypt(
					$password,
					'$2y$07$' . substr(generatePassword(true).generatePassword(true).generatePassword(true), 0, 22)
				);
			}
			break;
		case 3:
			$cryptPassword = crypt($password, '$5$' . generatePassword(true).  generatePassword(true));
			break;
		case 4:
			$cryptPassword = crypt($password, '$6$' . generatePassword(true).  generatePassword(true));
			break;
		default:
			$cryptPassword = crypt($password);
			break;
	}
	return $cryptPassword;
}
