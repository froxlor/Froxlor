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
 * @version    $Id$
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
function openRootDB($debugHandler, $lockfile)
{
	global $db_root;

	// If one cronscript needs root, it should say $needrootdb = true before the include
	if(isset($needrootdb)
	&& $needrootdb === true)
	{
		$db_root = new db($sql_root[0]['host'], $sql_root[0]['user'], $sql_root[0]['password'], '');

		if($db_root->link_id == 0)
		{
			/**
			 * Do not proceed further if no database connection could be established
			 */

			fclose($debugHandler);
			unlink($lockfile);
			die('root can\'t connect to mysqlserver. Please check userdata.inc.php! Exiting...');
		}

		unset($db_root->password);
		fwrite($debugHandler, 'Database-rootconnection established' . "\n");
	}
}

function closeRootDB()
{
	global $db_root;
	if(isset($db_root)) unset($db_root);
}
