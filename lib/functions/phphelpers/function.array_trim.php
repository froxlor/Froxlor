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
 * Returns Array, whose elements have been checked whether thay are empty or not
 *
 * @param array The array to trim
 * @return array The trim'med array
 * @author Florian Lippert <flo@syscp.org>
 */

function array_trim($source)
{
	$returnval = array();

	if(is_array($source))
	{
		while(list($var, $val) = each($source))
		{
			if($val != ' '
			   && $val != '')$returnval[$var] = $val;
		}
	}
	else
	{
		$returnval = $source;
	}

	return $returnval;
}
