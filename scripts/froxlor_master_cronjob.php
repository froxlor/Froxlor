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
 * @package    Cron
 *
 */

define('MASTER_CRONJOB', 1);

include_once dirname(dirname(__FILE__)) . '/lib/cron_init.php';

$jobs_to_run = array();

/**
 * check for --help
 */
if (count($argv) < 2 || (isset($argv[1]) && strtolower($argv[1]) == '--help')) {
	echo "\n*** Froxlor Master Cronjob ***\n\n";
	echo "Below are possible parameters for this file\n\n";
	echo "--[cronname]\t\tincludes the given cron-file\n";
	echo "--force\t\t\tforces re-generating of config-files (webserver, nameserver, etc.)\n";
	echo "--debug\t\t\toutput debug information about what is going on to STDOUT.\n";
	echo "--no-fork\t\t\tdo not fork to backkground (traffic cron only).\n\n";
}

/**
 * check for parameters
 *
 * --[cronname] include [cronname]
 * --force to include cron_tasks even if it's not its turn
 * --debug to output debug information
 */
for ($x = 1; $x < count($argv); $x++) {
	// check argument
	if (isset($argv[$x])) {
		// --force
		if (strtolower($argv[$x]) == '--force') {
			// really force re-generating of config-files by
			// inserting task 1
			inserttask('1');
			// bind (if enabled, inserttask() checks this)
			inserttask('4');
			// also regenerate cron.d-file
			inserttask('99');
			addToQueue($jobs_to_run, 'tasks');
		}
		elseif (strtolower($argv[$x]) == '--debug') {
		    define('CRON_DEBUG_FLAG', 1);
		}
		elseif (strtolower($argv[$x]) == '--no-fork') {
			define('CRON_NOFORK_FLAG', 1);
		}
		// --[cronname]
		elseif (substr(strtolower($argv[$x]), 0, 2) == '--') {
			if (strlen($argv[$x]) > 3) {
				$cronname = substr(strtolower($argv[$x]), 2);
				addToQueue($jobs_to_run, $cronname);
			}
		}
	}
}

$cronlog->setCronDebugFlag(defined('CRON_DEBUG_FLAG'));

$tasks_cnt_stmt = Database::query("SELECT COUNT(*) as jobcnt FROM `panel_tasks`");
$tasks_cnt = $tasks_cnt_stmt->fetch(PDO::FETCH_ASSOC);

// do we have anything to include?
if (count($jobs_to_run) > 0) {
	// include all jobs we want to execute
	foreach ($jobs_to_run as $cron) {
		updateLastRunOfCron($cron);
		$cronfile = getCronFile($cron);
		require_once $cronfile;
	}

	if ($tasks_cnt['jobcnt'] > 0)
	{
		if (Settings::Get('system.nssextrausers') == 1)
		{
			include_once makeCorrectFile(FROXLOR_INSTALL_DIR.'/scripts/classes/class.Extrausers.php');
			Extrausers::generateFiles($cronlog);
		}

		// clear NSCD cache if using fcgid or fpm, #1570
		if (Settings::Get('system.mod_fcgid') == 1 || (int)Settings::Get('phpfpm.enabled') == 1) {
			$false_val = false;
			safe_exec('nscd -i passwd 1> /dev/null', $false_val, array('>'));
			safe_exec('nscd -i group 1> /dev/null', $false_val, array('>'));
		}
	}
}

fwrite($debugHandler, 'Cronfiles have been included' . "\n");

/**
 * we have to check the system's last guid with every cron run
 * in case the admin installed new software which added a new user
 * so users in the database don't conflict with system users
 */
$cronlog->logAction(CRON_ACTION, LOG_NOTICE, 'Checking system\'s last guid');
checkLastGuid();

// shutdown cron
include_once FROXLOR_INSTALL_DIR . '/lib/cron_shutdown.php';

// -- helper function
function getCronFile($cronname) {
	return makeCorrectFile(FROXLOR_INSTALL_DIR.'/scripts/jobs/cron_'.$cronname.'.php');
}

function addToQueue(&$jobs_to_run, $cronname) {
	if (!in_array($cronname, $jobs_to_run)) {
		$cronfile = getCronFile($cronname);
		if (file_exists($cronfile)) {
			array_unshift($jobs_to_run, $cronname);
		}
	}
}

function updateLastRunOfCron($cronname) {
	$upd_stmt = Database::prepare("
		UPDATE `".TABLE_PANEL_CRONRUNS."` SET `lastrun` = UNIX_TIMESTAMP() WHERE `cronfile` = :cron;
	");
	Database::pexecute($upd_stmt, array('cron' => $cronname));
}
