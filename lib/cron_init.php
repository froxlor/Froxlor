<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2009-2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <d00p@froxlor.org>
 * @author     Florian Aders <eleras@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    System
 * @version    $Id: $
 */

if(@php_sapi_name() != 'cli'
   && @php_sapi_name() != 'cgi'
   && @php_sapi_name() != 'cgi-fcgi')
{
	die('This script will only work in the shell.');
}

$lockdir = '/var/run/';
$lockFilename = 'froxlor_' . basename($_SERVER['PHP_SELF'], '.php') . '.lock-';
$lockfName = $lockFilename . getmypid();
$lockfile = $lockdir . $lockfName;

// guess the froxlor installation path
// normally you should not need to modify this script anymore, if your
// froxlor installation isn't in /var/www/froxlor

$pathtophpfiles = dirname(dirname(__FILE__));

// should the froxlor installation guessing not work correctly,
// uncomment the following line, and put your path in there!
//$pathtophpfiles = '/var/www/froxlor/';
// create and open the lockfile!

$keepLockFile = false;
$debugHandler = fopen($lockfile, 'w');
fwrite($debugHandler, 'Setting Lockfile to ' . $lockfile . "\n");
fwrite($debugHandler, 'Setting Froxlor installation path to ' . $pathtophpfiles . "\n");

// open the lockfile directory and scan for existing lockfiles

$lockDirHandle = opendir($lockdir);

while($fName = readdir($lockDirHandle))
{
	if($lockFilename == substr($fName, 0, strlen($lockFilename))
	   && $lockfName != $fName)
	{
		// Check if last run jailed out with an exception

		$croncontent = file($lockdir . $fName);
		$lastline = $croncontent[(count($croncontent) - 1)];

		if($lastline == '=== Keep lockfile because of exception ===')
		{
			fclose($debugHandler);
			unlink($lockfile);
			die('Last cron jailed out with an exception. Exiting...' . "\n" . 'Take a look into the contents of ' . $lockdir . $fName . '* for more information!' . "\n");
		}

		// Check if cron is running or has died.

		$check_pid = substr(strstr($fName, "-"), 1);
		system("kill -CHLD " . $check_pid . " 1> /dev/null 2> /dev/null", $check_pid_return);

		if($check_pid_return == 1)
		{
			// Result:      Existing lockfile/pid isnt running
			//              Most likely it has died
			//
			// Action:      Remove it and continue
			//

			fwrite($debugHandler, 'Previous cronjob didn\'t exit clean. PID: ' . $check_pid . "\n");
			fwrite($debugHandler, 'Removing lockfile: ' . $lockdir . $fName . "\n");
			unlink($lockdir . $fName);
		}
		else
		{
			// Result:      A Cronscript with this pid
			//              is still running
			// Action:      remove my own Lock and die
			//
			// close the current lockfile

			fclose($debugHandler);

			// ... and delete it

			unlink($lockfile);
			die('There is already a Cronjob in progress. Exiting...' . "\n" . 'Take a look into the contents of ' . $lockdir . $lockFilename . '* for more information!' . "\n");
		}
	}
}

/**
 * Includes the Usersettings eg. MySQL-Username/Passwort etc.
 */

require ($pathtophpfiles . '/lib/userdata.inc.php');
fwrite($debugHandler, 'Userdatas included' . "\n");

// Legacy sql-root-information
if(isset($sql['root_user']) && isset($sql['root_password']) && (!isset($sql_root) || !is_array($sql_root)))
{
	$sql_root = array(0 => array('caption' => 'Default', 'host' => $sql['host'], 'user' => $sql['root_user'], 'password' => $sql['root_password']));
	unset($sql['root_user']);
	unset($sql['root_password']);
}

/**
 * Includes the Functions
 */

require ($pathtophpfiles . '/lib/functions.php');

/**
 * Includes the MySQL-Tabledefinitions etc.
 */

require ($pathtophpfiles . '/lib/tables.inc.php');
fwrite($debugHandler, 'Table definitions included' . "\n");

/**
 * Includes the MySQL-Connection-Class
 */

fwrite($debugHandler, 'Database Class has been loaded' . "\n");
$db = new db($sql['host'], $sql['user'], $sql['password'], $sql['db']);

// If one cronscript needs root, it should say $needrootdb = true before the include
/*
if(isset($needrootdb)
   && $needrootdb === true)
{
	$db_root = new db($sql['host'], $sql['root_user'], $sql['root_password'], '');

	if($db_root->link_id == 0)
	{
		/**
		 * Do not proceed further if no database connection could be established
		 *

		fclose($debugHandler);
		unlink($lockfile);
		die('root can\'t connect to mysqlserver. Please check userdata.inc.php! Exiting...');
	}

	unset($db_root->password);
	fwrite($debugHandler, 'Database-rootconnection established' . "\n");
}*/

if($db->link_id == 0)
{
	/**
	 * Do not proceed further if no database connection could be established
	 */

	fclose($debugHandler);
	unlink($lockfile);
	die('Froxlor can\'t connect to mysqlserver. Please check userdata.inc.php! Exiting...');
}

fwrite($debugHandler, 'Database-connection established' . "\n");
unset($sql);
unset($db->password);
$result = $db->query("SELECT `settingid`, `settinggroup`, `varname`, `value` FROM `" . TABLE_PANEL_SETTINGS . "`");

while($row = $db->fetch_array($result))
{
	$settings[$row['settinggroup']][$row['varname']] = $row['value'];
}

unset($row);
unset($result);
fwrite($debugHandler, 'Froxlor Settings has been loaded from the database' . "\n");

if(!isset($settings['panel']['version'])
   || $settings['panel']['version'] != $version)
{
	/**
	 * Do not proceed further if the Database version is not the same as the script version
	 */

	fclose($debugHandler);
	unlink($lockfile);
	die('Version of File doesnt match Version of Database. Exiting...');
}

fwrite($debugHandler, 'Froxlor Version and Database Version are correct' . "\n");

$cronscriptDebug = ($settings['system']['debug_cron'] == '1') ? true : false;

$cronbasedir = makeCorrectDir($pathtophpfiles . '/scripts/');
$crondir = new DirectoryIterator($cronbasedir);
$cronfilename = basename($_SERVER['PHP_SELF'], '.php');
$cronscriptFullName = makeCorrectFile($cronbasedir . basename($_SERVER['PHP_SELF']));
$inc_crons = array();
foreach($crondir as $file)
{
	if(!$file->isDot()
	   && !$file->isDir()
	   && preg_match("/^" . $cronfilename . "\.inc\.(.*)\.php$/D", $file->getFilename()))
	{
		if(fileowner($cronscriptFullName) == $file->getOwner()
		   && filegroup($cronscriptFullName) == $file->getGroup()
		   && $file->isReadable())
		{
			$inc_crons[] = $file->getPathname();
		}
		else
		{
			fwrite($debugHandler, 'WARNING! uid and/or gid of "' . $cronscriptFullName . '" and "' . $file->getPathname() . '" don\'t match! Execution aborted!' . "\n");
			fclose($debugHandler);
			die('WARNING! uid and/or gid of "' . $cronscriptFullName . '" and "' . $file->getPathname() . '" don\'t match! Execution aborted!');
		}
	}
}

if(isset($inc_crons[0]))
{
	natsort($inc_crons);
	foreach($inc_crons as $cfile)
	{
		fwrite($debugHandler, 'Including ...' . $cfile . "\n");
		include_once ($cfile);
	}
}

unset($file, $crondir, $cronname, $cronscriptFullName, $cronfilename, $cronbasedir);
fwrite($debugHandler, 'Functions have been included' . "\n");

/**
 * Create a new idna converter
 */

$idna_convert = new idna_convert_wrapper();

/**
 * Initialize logging
 */

$cronlog = FroxlorLogger::getInstanceOf(array('loginname' => 'cronjob'), $db, $settings);
fwrite($debugHandler, 'Logger has been included' . "\n");

?>
