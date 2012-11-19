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

/*
 * Function openRootDB
 *
 * creates a mysql-connection as root-user
 * and stores it in the global variable $db_root
 *
 * @param	int		debugHandler (file-object)
 * @param	int		lockfile (file-object)
 *
 * @return	null
 */
function openRootDB($debugHandler = false, $lockfile = false)
{
	global $db_root, $theme;

	require dirname(dirname(dirname(__FILE__))).'/userdata.inc.php';
	
	// Legacy sql-root-information
	if(isset($sql['root_user']) && isset($sql['root_password']) && (!isset($sql_root) || !is_array($sql_root)))
	{
		$sql_root = array(0 => array('caption' => 'Default', 'host' => $sql['host'], 'user' => $sql['root_user'], 'password' => $sql['root_password']));
		unset($sql['root_user']);
		unset($sql['root_password']);
	}

	$db_root = new db($sql_root[0]['host'], $sql_root[0]['user'], $sql_root[0]['password'], '');

	if($db_root->link_id == 0)
	{
		/**
		 * Do not proceed further if no database connection could be established
		 */
		if(isset($debugHandler) && $debugHandler !== false)
		{
			fclose($debugHandler);
		}
		if(isset($lockfile) && $lockfile !== false) 
		{
			unlink($lockfile);	
		}
		die('root can\'t connect to mysqlserver. Please check userdata.inc.php! Exiting...');
	}

	if(isset($debugHandler) && $debugHandler !== false)
	{
		fwrite($debugHandler, 'Database-rootconnection established' . "\n");
	}
	
	unset($sql);
}

function closeRootDB()
{
	global $db_root, $theme;
	if(isset($db_root)) unset($db_root);
}
