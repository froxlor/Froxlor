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
 * @param string exec_string String to be executed
 * 
 * @return string The result of the exec()
 */
function safe_exec($exec_string, &$return_value = false) {

	// check for bad signs in execute command
	if ((stristr($exec_string, ';'))
	   || (stristr($exec_string, '|'))
	   || (stristr($exec_string, '&'))
	   || (stristr($exec_string, '>'))
	   || (stristr($exec_string, '<'))
	   || (stristr($exec_string, '`'))
	   || (stristr($exec_string, '$'))
	   || (stristr($exec_string, '~'))
	   || (stristr($exec_string, '?'))
	) {
		die('SECURITY CHECK FAILED!' . "\n" . 'The execute string "' . htmlspecialchars($exec_string) . '" is a possible security risk!' . "\n" . 'Please check your whole server for security problems by hand!' . "\n");
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
