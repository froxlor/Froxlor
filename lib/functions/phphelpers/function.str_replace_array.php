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
 * @version    $Id: function.str_replace_array.php 2724 2009-06-07 14:18:02Z flo $
 */

/**
 * Replaces Strings in an array, with the advantage that you
 * can select which fields should be str_replace'd
 *
 * @param mixed String or array of strings to search for
 * @param mixed String or array to replace with
 * @param array The subject array
 * @param string The fields which should be checked for, separated by spaces
 * @return array The str_replace'd array
 * @author Florian Lippert <flo@syscp.org>
 */

function str_replace_array($search, $replace, $subject, $fields = '')
{
	if(is_array($subject))
	{
		$fields = array_trim(explode(' ', $fields));
		foreach($subject as $field => $value)
		{
			if((!is_array($fields) || empty($fields))
			   || (is_array($fields) && !empty($fields) && in_array($field, $fields)))
			{
				$subject[$field] = str_replace($search, $replace, $subject[$field]);
			}
		}
	}
	else
	{
		$subject = str_replace($search, $replace, $subject);
	}

	return $subject;
}
