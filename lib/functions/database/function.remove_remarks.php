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

//
// remove_remarks will strip the sql comment lines out of an uploaded sql file
// The whole function has been taken from the phpbb installer, copyright by the phpbb team, phpbb in summer 2004.
//

function remove_remarks($sql)
{
	$lines = explode("\n", $sql);

	// try to keep mem. use down

	$sql = "";
	$linecount = count($lines);
	$output = "";
	for ($i = 0;$i < $linecount;$i++)
	{
		if(($i != ($linecount - 1))
		   || (strlen($lines[$i]) > 0))
		{
			if(substr($lines[$i], 0, 1) != "#")
			{
				$output.= $lines[$i] . "\n";
			}
			else
			{
				$output.= "\n";
			}

			// Trading a bit of speed for lower mem. use here.

			$lines[$i] = "";
		}
	}

	return $output;
}
