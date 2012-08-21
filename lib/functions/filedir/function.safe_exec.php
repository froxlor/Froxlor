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
 * @author Martin Burchert <eremit@adm1n.de>
 * @version 1.2
 * @param string exec_string String to be executed
 * @return string The result of the exec()
 *
 * History:
 * 1.0 : Initial Version
 * 1.1 : Added |,&,>,<,`,*,$,~,? as security breaks.
 * 1.2 : Removed * as security break
 */

function safe_exec($exec_string, &$return_value = false)
{
	global $settings, $theme;

	//
	// define allowed system commands
	//

	$allowed_commands = array(
		'touch',
		'chown',
		'mkdir',
		'webalizer',
		'cp',
		'du',
		'chmod',
		'chattr',
		'chflags', /* freebsd equivalent to linux' chattr */
		$settings['system']['apachereload_command'],
		$settings['system']['bindreload_command'],
		$settings['dkim']['dkimrestart_command'],
		'openssl',
		'unzip',
		'php',
		'rm',
		'awstats_buildstaticpages.pl',
		'ln'
	);

	//
	// check for ; in execute command
	//

	if((stristr($exec_string, ';'))
	   or (stristr($exec_string, '|'))
	   or (stristr($exec_string, '&'))
	   or (stristr($exec_string, '>'))
	   or (stristr($exec_string, '<'))
	   or (stristr($exec_string, '`'))
	   or (stristr($exec_string, '$'))
	   or (stristr($exec_string, '~'))
	   or (stristr($exec_string, '?')))
	{
		die('SECURITY CHECK FAILED!' . "\n" . 'The execute string "' . htmlspecialchars($exec_string) . '" is a possible security risk!' . "\n" . 'Please check your whole server for security problems by hand!' . "\n");
	}

	/*
	 * This is not needed anymore, we allow all commands and just check for pipes and stuff
	//
	// check if command is allowed here
	//

	$ok = false;
	foreach($allowed_commands as $allowed_command)
	{
		if(strpos($exec_string, $allowed_command) === 0
		   && (strlen($exec_string) === ($allowed_command_pos = strlen($allowed_command)) || substr($exec_string, $allowed_command_pos, 1) === ' '))
		{
			$ok = true;
		}
	}

	if(!$ok)
	{
		die('SECURITY CHECK FAILED!' . "\n" . 'Your command "' . htmlspecialchars($exec_string) . '" is not allowed!' . "\n" . 'Please check your whole server for security problems by hand!' . "\n");
	}
	*/

	//
	// execute the command and return output
	//
	// --- martin @ 08.08.2005 -------------------------------------------------------
	// fixing usage of uninitialised variable

	$return = '';

	// -------------------------------------------------------------------------------

	if($return_value == false)
	{
		exec($exec_string, $return);
	}
	else
	{
		exec($exec_string, $return, $return_value);
	}

	return $return;
}
