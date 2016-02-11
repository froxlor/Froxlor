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

function array_merge_prefix($array1, $key_prefix, $array2)
{
	if(is_array($array1) && is_array($array2))
	{
		if($key_prefix != '')
		{
			foreach($array2 as $key => $value)
			{
				$array1[$key_prefix . '_' . $key] = $value;
				unset($array2[$key]);
			}
			unset($array2);
			return $array1;
		}
		else
		{
			return array_merge($array1, $array2);
		}
	}
	else
	{
		return $array1;
	}
}
