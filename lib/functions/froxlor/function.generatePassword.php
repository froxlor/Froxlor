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
	$alpha_lower = 'abcdefghijklmnopqrstuvwxyz';
	$alpha_upper = strtoupper($alpha_lower);
	$numeric = '0123456789';
	$special = Settings::Get('panel.password_special_char');
	$length = Settings::Get('panel.password_min_length') > 3 ? Settings::Get('panel.password_min_length') : 10;

	$pw = str_shuffle($alpha_lower);
	$n = floor(($length)/4);

	if (Settings::Get('panel.password_alpha_upper')) {
		$pw .= substr(str_shuffle($alpha_upper), 0, $n);
	}

	if (Settings::Get('panel.password_numeric')) {
		$pw .= substr(str_shuffle($numeric), 0, $n);
	}

	if (Settings::Get('panel.password_special_char_required')) {
		$pw .= substr(str_shuffle($special), 0, $n);
	}

	$pw = substr($pw, -$length);

	return str_shuffle($pw);
}
