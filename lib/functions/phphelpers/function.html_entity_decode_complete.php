<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id$
 */

/**
 * Calls html_entity_decode in a loop until the result doesn't differ from original anymore
 *
 * @param string The string in which the html entities should be eliminated.
 * @return string The cleaned string
 * @author Florian Lippert <flo@syscp.org>
 */

function html_entity_decode_complete($string)
{
	while($string != html_entity_decode($string))
	{
		$string = html_entity_decode($string);
	}

	return $string;
}
