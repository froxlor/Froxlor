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
 * @author     Florian Aders <eleras@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Convert a string to UTF-8 if needed
 * @param string String to be converted
 * @return string UTF-8 encoded string
 *
 * @author Florian Aders <eleras@froxlor.org>
 */

function convertUtf8 ($string) {
	if (!isUtf8($string))
	{
		$string = utf8_encode($string);
	}
	return addslashes($string);
}