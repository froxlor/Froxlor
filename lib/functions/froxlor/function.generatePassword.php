<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2011- the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2011-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Generates a random password
 */
function generatePassword() {
	return substr(
		base64_encode(sha1(md5(uniqid(microtime(), 1))).md5(uniqid(microtime(), 1)).sha1(md5(uniqid(microtime(), 1)))),
		rand(5, 50), (Settings::Get('panel.password_min_length') > 0 ? Settings::Get('panel.password_min_length') : 10)
	);
}
