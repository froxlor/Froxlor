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
 * Wrapper around htmlentities to handle arrays, with the advantage that you
 * can select which fields should be handled by htmlentities
 *
 * @param array The subject array
 * @param string The fields which should be checked for, separated by spaces
 * @param int See php documentation about this
 * @param string See php documentation about this
 * @return array The array with htmlentitie'd strings
 * @author Florian Lippert <flo@syscp.org>
 */

function htmlentities_array($subject, $fields = '', $quote_style = ENT_QUOTES, $charset = 'UTF-8')
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

				$subject[$field] = htmlentities_array($subject[$field], $fields, $quote_style, $charset);
			}
		}
	}
	else
	{
		$subject = htmlentities($subject, $quote_style, $charset);
	}

	return $subject;
}
