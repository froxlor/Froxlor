<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2014 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2014-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * check if the system is FreeBSD (if exact)
 * or BSD-based (NetBSD, OpenBSD, etc. if exact = false [default])
 *
 * @param boolean $exact whether to check explicitly for FreeBSD or *BSD
 *
 * @return boolean
 */
function isFreeBSD($exact = false) {
	if (($exact && PHP_OS == 'FreeBSD')
			|| (!$exact && stristr(PHP_OS, 'BSD'))
	) {
		return true;
	}
	return false;
}
