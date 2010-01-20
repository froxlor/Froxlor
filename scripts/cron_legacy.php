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
 * @author     Martin Burchert <eremit@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    System
 * @version    $Id: cron_legacy.php 2692 2009-03-27 18:04:47Z flo $
 */

/**
 * STARTING REDUNDANT CODE, WHICH IS SOME KINDA HEADER FOR EVERY CRON SCRIPT.
 * When using this "header" you have to change $lockFilename for your needs.
 * Don't forget to also copy the footer which closes database connections
 * and the lockfile! (Note: This "header" also establishes a mysql-root-
 * connection, if you don't need it, see for the header in cron_tasks.php)
 */

$needrootdb = true;
include (dirname(__FILE__) . '/../lib/cron_init.php');

/**
 * END REDUNDANT CODE (CRONSCRIPT "HEADER")
 */

/**
 * Check if table exists, otherwise create it
 */

$tables = getTables($db);

if(!isset($tables[TABLE_PANEL_CRONSCRIPT])
   || !is_array($tables[TABLE_PANEL_CRONSCRIPT]))
{
	$db->query('CREATE TABLE `' . TABLE_PANEL_CRONSCRIPT . '` (  `id` int(11) unsigned NOT NULL auto_increment,  `file` varchar(255) NOT NULL default \'\',  PRIMARY KEY  (`id`) ) TYPE=MyISAM ; ');
}

/**
 * Backend Wrapper
 */

$query = 'SELECT * FROM `' . TABLE_PANEL_CRONSCRIPT . '` ';
$cronFileIncludeResult = $db->query($query);

while($cronFileIncludeRow = $db->fetch_array($cronFileIncludeResult))
{
	$cronFileIncludeFullPath = makeSecurePath($pathtophpfiles . '/scripts/' . $cronFileIncludeRow['file']);

	if(fileowner($cronFileIncludeFullPath) == fileowner($pathtophpfiles . '/scripts/' . $filename)
	   && filegroup($cronFileIncludeFullPath) == filegroup($pathtophpfiles . '/scripts/' . $filename))
	{
		fwrite($debugHandler, 'Processing ...' . $cronFileIncludeFullPath . "\n");
		include_once $cronFileIncludeFullPath;
		fwrite($debugHandler, 'Processing done!' . "\n");
	}
	else
	{
		fwrite($debugHandler, 'WARNING! uid and/or gid of "' . $cronFileIncludeFullPath . '" and "' . $pathtophpfiles . '/scripts/' . $filename . '" don\'t match! Execution aborted!' . "\n");
		$keepLockFile = true;
	}
}

/**
 * STARTING CRONSCRIPT FOOTER
 */

include ($pathtophpfiles . '/lib/cron_shutdown.php');

/**
 * END CRONSCRIPT FOOTER
 */

?>