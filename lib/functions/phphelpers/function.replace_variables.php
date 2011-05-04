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
 * Replaces all occurences of variables defined in the second argument
 * in the first argument with their values.
 *
 * @param string The string that should be searched for variables
 * @param array The array containing the variables with their values
 * @return string The submitted string with the variables replaced.
 * @author Michael Duergner
 */

function replace_variables($text, $vars)
{
	$pattern = "/\{([a-zA-Z0-9\-_]+)\}/";

	// --- martin @ 08.08.2005 -------------------------------------------------------
	// fixing usage of uninitialised variable

	$matches = array();

	// -------------------------------------------------------------------------------

	if(count($vars) > 0
	   && preg_match_all($pattern, $text, $matches))
	{
		for ($i = 0;$i < count($matches[1]);$i++)
		{
			$current = $matches[1][$i];

			if(isset($vars[$current]))
			{
				$var = $vars[$current];
				$text = str_replace("{" . $current . "}", $var, $text);
			}
		}
	}

	$text = str_replace('\n', "\n", $text);
	return $text;
}
