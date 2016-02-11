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
 * Returns an integer of the given value which isn't negative.
 * Returns -1 if the given value was -1.
 *
 * @param any The value
 * @return int The positive value
 * @author Florian Lippert <flo@syscp.org>
 */

function intval_ressource($the_value)
{
	$the_value = intval($the_value);

	if($the_value < 0
	   && $the_value != '-1')
	{
		$the_value*= - 1;
	}

	return $the_value;
}
