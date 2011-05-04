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
 * Wrapper around stripslashes to handle arrays, with the advantage that you
 * can select which fields should be handled by htmlentities and with advantage,
 * that you can eliminate all slashes by setting complete=true
 *
 * @param array The subject array
 * @param int See php documentation about this
 * @param string See php documentation about this
 * @param string The fields which should be checked for, separated by spaces
 * @param bool Select true to use stripslashes_complete instead of stripslashes
 * @return array The array with stripslashe'd strings
 * @author Florian Lippert <flo@syscp.org>
 */

function stripslashes_array($subject, $fields = '', $complete = false)
{
	if(is_array($subject))
	{
		if(!is_array($fields))
		{
			$fields = array_trim(explode(' ', $fields));
		}

		foreach($subject as $field => $value)
		{
			if((!is_array($fields) || empty($fields))
			   || (is_array($fields) && !empty($fields) && in_array($field, $fields)))
			{
				/**
				 * Just call ourselve to manage multi-dimensional arrays
				 */

				$subject[$field] = stripslashes_array($subject[$field], $fields, $complete);
			}
		}
	}
	else
	{
		if($complete == true)
		{
			$subject = stripslashes_complete($subject);
		}
		else
		{
			$subject = stripslashes($subject);
		}
	}

	return $subject;
}
