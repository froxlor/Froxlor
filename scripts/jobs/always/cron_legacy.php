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
 * @package    Cron
 * @version    $Id$
 */

openRootDB($debugHandler, $lockfile);

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

?>