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
 * Function getNextCronjobs
 *
 * checks which cronjobs have to be executed 
 *
 * @return	array	array of cron-files which are to be executed
 */
function getNextCronjobs()
{
	global $db;
	
	$query = "SELECT `id`, `cronfile` FROM `".TABLE_PANEL_CRONRUNS."` WHERE `interval` <> '0' AND `isactive` = '1' AND (";

	$intervals = getIntervalOptions();
	
	$x = 0;
	foreach($intervals as $name => $ival)
	{
		if($name == '0') continue;

		if($x == 0) {
			$query.= 'DATE_ADD(FROM_UNIXTIME(`lastrun`), INTERVAL '.$ival.') <= UTC_TIMESTAMP()';
		} else {	
			$query.= ' OR DATE_ADD(UNIX_TIMESTAMP(`lastrun`), INTERVAL '.$ival.') <= UTC_TIMESTAMP()';
		}
		$x++;
	}
	
	$query.= ');';
	
	$result = $db->query($query);
	
	$cron_files = array();
	while($row = $db->fetch_array($result))
	{
		$cron_files[] = $row['cronfile'];
		$db->query("UPDATE `".TABLE_PANEL_CRONRUNS."` SET `lastrun` = UNIX_TIMESTAMP() WHERE `id` ='".(int)$row['id']."';");
	}
	
	return $cron_files;
}
