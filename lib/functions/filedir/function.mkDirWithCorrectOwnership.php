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
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id: function.mkDirWithCorrectOwnership.php 2724 2009-06-07 14:18:02Z flo $
 */

/**
 * Creates a directory below a users homedir and sets all directories,
 * which had to be created below with correct Owner/Group
 * (Copied from cron_tasks.php:rev1189 as we'll need this more often in future)
 *
 * @param  string The homedir of the user
 * @param  string The dir which should be created
 * @param  int    The uid of the user
 * @param  int    The gid of the user
 * @return bool   true if everything went okay, false if something went wrong
 *
 * @author Florian Lippert <flo@syscp.org>
 * @author Martin Burchert <martin.burchert@syscp.org>
 */

function mkDirWithCorrectOwnership($homeDir, $dirToCreate, $uid, $gid)
{
	$returncode = true;

	if($homeDir != ''
	   && $dirToCreate != '')
	{
		$homeDir = makeCorrectDir($homeDir);
		$dirToCreate = makeCorrectDir($dirToCreate);

		if(substr($dirToCreate, 0, strlen($homeDir)) == $homeDir)
		{
			$subdir = substr($dirToCreate, strlen($homeDir));
		}
		else
		{
			$subdir = $dirToCreate;
		}

		$subdir = makeCorrectDir($subdir);
		$subdirlen = strlen($subdir);
		$subdirs = array();
		array_push($subdirs, $dirToCreate);
		$offset = 0;

		while($offset < $subdirlen)
		{
			$offset = strpos($subdir, '/', $offset);
			$subdirelem = substr($subdir, 0, $offset);
			$offset++;
			array_push($subdirs, makeCorrectDir($homeDir . $subdirelem));
		}

		$subdirs = array_unique($subdirs);
		sort($subdirs);
		foreach($subdirs as $sdir)
		{
			if(!is_dir($sdir))
			{
				$sdir = makeCorrectDir($sdir);
				safe_exec('mkdir -p ' . escapeshellarg($sdir));
				safe_exec('chown -R ' . (int)$uid . ':' . (int)$gid . ' ' . escapeshellarg($sdir));
			}
		}
	}
	else
	{
		$returncode = false;
	}

	return $returncode;
}
