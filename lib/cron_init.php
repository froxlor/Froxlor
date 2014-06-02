<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

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
 *
 */

if (@php_sapi_name() != 'cli'
	&& @php_sapi_name() != 'cgi'
	&& @php_sapi_name() != 'cgi-fcgi'
) {
	die('This script will only work in the shell.');
}

// ensure that default timezone is set
if (function_exists("date_default_timezone_set")
	&& function_exists("date_default_timezone_get")
) {
	@date_default_timezone_set(@date_default_timezone_get());
}

$basename = basename($_SERVER['PHP_SELF'], '.php');
if (isset($argv) && is_array($argv) && count($argv) > 1) {
	for($x=1;$x < count($argv);$x++) {
		if (substr(strtolower($argv[$x]), 0, 2) == '--'
			&& strlen($argv[$x]) > 3
		) {
			$basename .= "-".substr(strtolower($argv[$x]), 2);
			break;
		}
	}
}
$lockdir = '/var/run/';
$lockFilename = 'froxlor_' . $basename . '.lock-';
$lockfName = $lockFilename . getmypid();
$lockfile = $lockdir . $lockfName;

// guess the froxlor installation path
// normally you should not need to modify this script anymore, if your
// froxlor installation isn't in /var/www/froxlor
define('FROXLOR_INSTALL_DIR', dirname(dirname(__FILE__)));

// create and open the lockfile!
$keepLockFile = false;
$debugHandler = fopen($lockfile, 'w');
fwrite($debugHandler, 'Setting Lockfile to ' . $lockfile . "\n");
fwrite($debugHandler, 'Setting Froxlor installation path to ' . FROXLOR_INSTALL_DIR . "\n");

// open the lockfile directory and scan for existing lockfiles
$lockDirHandle = opendir($lockdir);

while ($fName = readdir($lockDirHandle)) {

	if ($lockFilename == substr($fName, 0, strlen($lockFilename))
		&& $lockfName != $fName
	) {
		// Check if last run jailed out with an exception
		$croncontent = file($lockdir . $fName);
		$lastline = $croncontent[(count($croncontent) - 1)];

		if ($lastline == '=== Keep lockfile because of exception ===') {
			fclose($debugHandler);
			unlink($lockfile);
			die('Last cron jailed out with an exception. Exiting...' . "\n" . 'Take a look into the contents of ' . $lockdir . $fName . '* for more information!' . "\n");
		}

		// Check if cron is running or has died.
		$check_pid = substr(strstr($fName, "-"), 1);
		system("kill -CHLD " . (int)$check_pid . " 1> /dev/null 2> /dev/null", $check_pid_return);

		if ($check_pid_return == 1) {
			// Result:      Existing lockfile/pid isnt running
			//              Most likely it has died
			//
			// Action:      Remove it and continue
			//
			fwrite($debugHandler, 'Previous cronjob didn\'t exit clean. PID: ' . $check_pid . "\n");
			fwrite($debugHandler, 'Removing lockfile: ' . $lockdir . $fName . "\n");
			unlink($lockdir . $fName);

		} else {
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

// Includes the Usersettings eg. MySQL-Username/Passwort etc.
require FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php';
fwrite($debugHandler, 'Userdatas included' . "\n");

// Legacy sql-root-information
if (isset($sql['root_user'])
	&& isset($sql['root_password'])
	&& (!isset($sql_root) || !is_array($sql_root))
) {
	$sql_root = array(0 => array('caption' => 'Default', 'host' => $sql['host'], 'user' => $sql['root_user'], 'password' => $sql['root_password']));
	unset($sql['root_user']);
	unset($sql['root_password']);
}

// Includes the Functions
require FROXLOR_INSTALL_DIR . '/lib/functions.php';

//Includes the MySQL-Tabledefinitions etc.
require FROXLOR_INSTALL_DIR . '/lib/tables.inc.php';
fwrite($debugHandler, 'Table definitions included' . "\n");

// try database connection, it will throw
// and exception itself if failed
try {
	Database::query("SELECT 1");
} catch (Exception $e) {
	// Do not proceed further if no database connection could be established
	fclose($debugHandler);
	unlink($lockfile);
	die($e->getMessage());
}

fwrite($debugHandler, 'Database-connection established' . "\n");

/**
 * if using fcgid or fpm for froxlor-vhost itself, we have to check
 * whether the permission of the files are still correct
 */
fwrite($debugHandler, 'Checking froxlor file permissions'."\n");
$_mypath = makeCorrectDir(FROXLOR_INSTALL_DIR);

if (((int)Settings::Get('system.mod_fcgid') == 1 && (int)Settings::Get('system.mod_fcgid_ownvhost') == 1)
		|| ((int)Settings::Get('phpfpm.enabled') == 1 && (int)Settings::Get('phpfpm.enabled_ownvhost') == 1)
) {
	$user = Settings::Get('system.mod_fcgid_httpuser');
	$group = Settings::Get('system.mod_fcgid_httpgroup');

	if (Settings::Get('phpfpm.enabled') == 1) {
		$user = Settings::Get('phpfpm.vhost_httpuser');
		$group = Settings::Get('phpfpm.vhost_httpgroup');
	}
	// all the files and folders have to belong to the local user
	// now because we also use fcgid for our own vhost
	safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($_mypath));
} else {
	// back to webserver permission
	$user = Settings::Get('system.httpuser');
	$group = Settings::Get('system.httpgroup');
	safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($_mypath));
}

// be sure HTMLPurifier's cache folder is writable
safe_exec('chmod -R 0755 '.escapeshellarg(dirname(__FILE__).'/classes/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer'));

// Initialize logging
$cronlog = FroxlorLogger::getInstanceOf(array('loginname' => 'cronjob'));
fwrite($debugHandler, 'Logger has been included' . "\n");

if (Settings::Get('panel.version') == null
	|| Settings::Get('panel.version') != $version
) {
	if (Settings::Get('system.cron_allowautoupdate') == null
		|| Settings::Get('system.cron_allowautoupdate') == 0
	) {
		/**
		 * Do not proceed further if the Database version is not the same as the script version
		 */
		fclose($debugHandler);
		unlink($lockfile);
		$errormessage = "Version of file doesnt match version of database. Exiting...\n\n";
		$errormessage.= "Possible reason: Froxlor update\n";
		$errormessage.= "Information: Current version in database: ".Settings::Get('panel.version')." - version of Froxlor files: ".$version."\n";
		$errormessage.= "Solution: Please visit your Foxlor admin interface for further information.\n";
		die($errormessage);
	}

	if (Settings::Get('system.cron_allowautoupdate') == 1) {
		/**
		 * let's walk the walk - do the dangerous shit
		 */
		$cronlog->logAction(CRON_ACTION, LOG_WARNING, 'Automatic update is activated and we are going to proceed without any notices');
		$cronlog->logAction(CRON_ACTION, LOG_WARNING, 'all new settings etc. will be stored with the default value, that might not always be right for your system!');
		$cronlog->logAction(CRON_ACTION, LOG_WARNING, 'If you dont want this to happen in the future consider removing the --allow-autoupdate flag from the cronjob');
		fwrite($debugHandler, '*** WARNING *** - Automatic update is activated and we are going to proceed without any notices' . "\n");
		fwrite($debugHandler, '*** WARNING *** - all new settings etc. will be stored with the default value, that might not always be right for your system!' . "\n");
		fwrite($debugHandler, '*** WARNING *** - If you dont want this to happen in the future consider removing the --allow-autoupdate flag from the cronjob' . "\n");
		// including update procedures
		include_once FROXLOR_INSTALL_DIR.'/install/updatesql.php';
		// pew - everything went better than expected
		$cronlog->logAction(CRON_ACTION, LOG_WARNING, 'Automatic update done - you should check your settings to be sure everything is fine');
		fwrite($debugHandler, '*** WARNING *** - Automatic update done - you should check your settings to be sure everything is fine' . "\n");
	}
}

fwrite($debugHandler, 'Froxlor version and database version are correct' . "\n");

$cronscriptDebug = (Settings::Get('system.debug_cron') == '1') ? true : false;

// Create a new idna converter
$idna_convert = new idna_convert_wrapper();

// check for cron.d-generation task and create it if necessary
checkCrondConfigurationFile();
