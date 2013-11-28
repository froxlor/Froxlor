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

$jobs_to_run = includeCronjobs($debugHandler);

/**
 * check for --help
 */
if (isset($argv[1]) && strtolower($argv[1]) == '--help') {
	echo "\n*** Froxlor Master Cronjob ***\n\n";
	echo "Below are possible parameters for this file\n\n";
	echo "--force\t\t\tforces re-generating of config-files (webserver, etc.)\n";
	echo "--force-[cronname]\tforces the given cron to run, e.g. --force-backup, --force-traffic\n\n";
}

/**
 * check for --force to include cron_tasks
 * even if it's not its turn
 */
for ($x = 1; $x < count($argv); $x++) {
	if (isset($argv[$x]) && strtolower($argv[$x]) == '--force') {
		$crontasks = makeCorrectFile(FROXLOR_INSTALL_DIR.'/scripts/jobs/cron_tasks.php');
		// really force re-generating of config-files by
		// inserting task 1
		inserttask('1');
		if (!in_array($crontasks, $jobs_to_run)) {
			array_unshift($jobs_to_run, $crontasks);
		}
	}
	elseif (isset($argv[$x]) && substr(strtolower($argv[$x]), 0, 8)  == '--force-') {
		$crontasks = makeCorrectFile(FROXLOR_INSTALL_DIR.'/scripts/jobs/cron_'.substr(strtolower($argv[$x]), 8).'.php');
		if (file_exists($crontasks)) {
			if (!in_array($crontasks, $jobs_to_run)) {
				array_unshift($jobs_to_run, $crontasks);
			}
		}
	}
}

foreach ($jobs_to_run as $cron) {
	require_once $cron;
}

fwrite($debugHandler, 'Cronfiles have been included' . "\n");

/*
 * we have to check the system's last guid with every cron run
 * in case the admin installed new software which added a new user
 * so users in the database don't conflict with system users
 */
$cronlog->logAction(CRON_ACTION, LOG_NOTICE, 'Checking system\'s last guid');
checkLastGuid();

// shutdown cron
include_once FROXLOR_INSTALL_DIR . '/lib/cron_shutdown.php';
