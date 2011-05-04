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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

function validateSqlInterval($interval = null)
{
	if(!$interval === null || $interval != '')
	{
		if(strstr($interval, ' ') !== false)
		{
			/*
			 * [0] = ([0-9]+)
			 * [1] = valid SQL-Interval expression 
			 */
			$valid_expr = array(
								'SECOND',
								'MINUTE',
								'HOUR',
								'DAY',
								'WEEK',
								'MONTH',
								'YEAR'
						);
			
			$interval_parts = explode(' ', $interval);
			
			if(is_array($interval_parts)
			&& isset($interval_parts[0])
			&& isset($interval_parts[1]))
			{
				if(preg_match('/([0-9]+)/i', $interval_parts[0]))
				{
					if(in_array(strtoupper($interval_parts[1]), $valid_expr))
					{
						return true;
					}
				}
			}
		}
	}
	return false;
}
