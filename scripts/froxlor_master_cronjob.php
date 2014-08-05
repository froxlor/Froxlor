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
$lastrun_update = array();

/**
 * check for --help
 */
if (isset($argv[1]) && strtolower($argv[1]) == '--help') {
	echo "\n*** Froxlor Master Cronjob ***\n\n";
	echo "Below are possible parameters for this file\n\n";
	echo "--[cronname]\t\t\tincludes the given cron-file\n";
	echo "--force\t\t\tforces re-generating of config-files (webserver, nameserver, etc.)\n\n";
}

/**
 * check for parameters
 *
 * --[cronname] include [cronname]
 * --force to include cron_tasks even if it's not its turn
 */
for ($x = 1; $x < count($argv); $x++) {
	// check argument
	if (isset($argv[$x])) {
		// --force
		if (strtolower($argv[$x]) == '--force') {
			$crontasks = makeCorrectFile(FROXLOR_INSTALL_DIR.'/scripts/jobs/cron_tasks.php');
			// really force re-generating of config-files by
			// inserting task 1
			inserttask('1');
			// also regenerate cron.d-file
			inserttask('99');
			addToQueue($jobs_to_run, $crontasks);
			$lastrun_update['tasks'] = $crontasks;
		}
		// --[cronname]
		elseif (substr(strtolower($argv[$x]), 0, 2) == '--') {
			if (strlen($argv[$x]) > 3) {
				$cronfile = makeCorrectFile(FROXLOR_INSTALL_DIR.'/scripts/jobs/cron_'.substr(strtolower($argv[$x]), 2).'.php');
				addToQueue($jobs_to_run, $cronfile);
				$lastrun_update[substr(strtolower($argv[$x]), 2)] = $cronfile;
			}
		}
	}
}

// do we have anything to include?
if (count($jobs_to_run) > 0) {
	// include all jobs we want to execute
	foreach ($jobs_to_run as $cron) {
		updateLastRunOfCron($lastrun_update, $cron);
		require_once $cron;
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
function addToQueue(&$jobs_to_run, $cronfile = null, $checkExists = true) {
	if ($checkExists == false || ($checkExists && file_exists($cronfile))) {
		if (!in_array($cronfile, $jobs_to_run)) {
			array_unshift($jobs_to_run, $cronfile);
		}
	}
}

function updateLastRunOfCron($update_arr, $cronfile) {
	foreach ($update_arr as $cron => $cronf) {
		if ($cronf == $cronfile) {
			$upd_stmt = Database::prepare("
				UPDATE `".TABLE_PANEL_CRONRUNS."` SET `lastrun` = UNIX_TIMESTAMP() WHERE `cronfile` = :cron;
			");
			Database::pexecute($upd_stmt, array('cron' => $cron));
		}
	}
}
