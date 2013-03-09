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

include_once(dirname(__FILE__) . '/../lib/cron_init.php');

$jobs_to_run = includeCronjobs($debugHandler, $pathtophpfiles);

/**
 * check for --force to include cron_tasks 
 * even if it's not its turn
 */
if(isset($argv[1]) && strtolower($argv[1]) == '--force')
{
	$crontasks = makeCorrectFile($pathtophpfiles.'/scripts/jobs/cron_tasks.php');
	// really force re-generating of config-files by
	// inserting task 1
	inserttask('1');
	if (!in_array($crontasks, $jobs_to_run)) {
		array_unshift($jobs_to_run, $crontasks);
	}
}

foreach($jobs_to_run as $cron)
{
	require_once($cron);
}

fwrite($debugHandler, 'Cronfiles have been included' . "\n");

/*
 * we have to check the system's last guid with every cron run
 * in case the admin installed new software which added a new user
 * so users in the database don't conflict with system users
 */
$cronlog->logAction(CRON_ACTION, LOG_NOTICE, 'Checking system\'s last guid');
checkLastGuid();

/*
 * shutdown cron
 */
include_once($pathtophpfiles . '/lib/cron_shutdown.php');

?>
