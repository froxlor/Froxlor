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
 * Wrapper around the exec command.
 *
 * @param string $exec_string command to be executed
 * @param string $return_value referenced variable where the output is stored
 * @param array $allowedChars optional array of allowed characters in path/command
 * 
 * @return string result of exec()
 */
function safe_exec($exec_string, &$return_value = false, $allowedChars = null) {

	$disallowed = array(';', '|', '&', '>', '<', '`', '$', '~', '?');

	$acheck = false;
	if ($allowedChars != null && is_array($allowedChars) && count($allowedChars) > 0) {
		$acheck = true;
	}

	foreach ($disallowed as $dc) {
		if ($acheck && in_array($dc, $allowedChars)) continue;
		// check for bad signs in execute command
		if (stristr($exec_string, $dc)) {
			die("SECURITY CHECK FAILED!\nThe execute string '" . $exec_string . "' is a possible security risk!\nPlease check your whole server for security problems by hand!\n");
		}
	}

	// execute the command and return output
	$return = '';

	// -------------------------------------------------------------------------------
	if ($return_value == false) {
		exec($exec_string, $return);
	} else {
		exec($exec_string, $return, $return_value);
	}

	return $return;
}
