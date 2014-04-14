<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2014 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * 1st: check for task of generation
 * 2nd: if task found, generate cron.d-file
 * 3rd: maybe restart cron?
 */
function checkCrondConfigurationFile() {

	// check for task
	$result_tasks_stmt = Database::query("
			SELECT * FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = '99'
			");
	$num_results = Database::num_rows();

	// is there a task for re-generating the cron.d-file?
	if ($num_results > 0) {

		// get all crons and their intervals
		$cronfile = "# automatically generated cron-configuration by froxlor\n";
		$cronfile.= "# do not manually edit this file as it will be re-generated periodically.\n";
		$cronfile.= "PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin\n#\n";

		// get all the crons
		$result_stmt = Database::query("
				SELECT * FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `isactive` = '1'
				");

		$hour_delay = 0;
		$day_delay = 5;
		$month_delay = 7;
		while ($row_cronentry = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			// create cron.d-entry
			if (preg_match("/(\d+) (MINUTE|HOUR|DAY|WEEK|MONTH)/", $row_cronentry['interval'], $matches)) {
				if ($matches[1] == 1) {
					$minvalue = "*";
				} else {
					$minvalue = "*/".$matches[1];
				}
				switch($matches[2]) {
					case "MINUTE":
						$cronfile .= $minvalue . " * * * * ";
						break;
					case "HOUR":
						$cronfile .= $hour_delay." " . $minvalue . " * * * ";
						$hour_delay += 3;
						break;
					case "DAY":
						if ($row_cronentry['cronfile'] == 'traffic') {
							// traffic at exactly 0:00 o'clock
							$cronfile .= "0 0 " . $minvalue . " * * ";
						} else {
							$cronfile .= $day_delay." 0 " . $minvalue . " * * ";
							$day_delay += 5;
						}
						break;
					case "MONTH":
						$cronfile .= $month_delay." 0 1 " . $minvalue . " * ";
						$month_delay += 7;
						break;
					case "WEEK":
						$cronfile .= $day_delay." 0 " . ($matches[1] * 7) . " * * ";
						$day_delay += 5;
						break;
				}

				// create entry-line
				$binpath = Settings::Get("system.croncmdline");
				// fallback as it is important
				if ($binpath === null) {
					$binpath = "/usr/bin/nice -n 5 /usr/bin/php5 -q";
				}

				$cronfile .= "root " . $binpath." " . FROXLOR_INSTALL_DIR . "/scripts/froxlor_master_cronjob.php --" . $row_cronentry['cronfile'] . " 1> /dev/null\n";
			}
		}

		// write the file
		if (file_put_contents(Settings::Get("system.cronconfig"), $cronfile) === false) {
			// oh snap cannot create new crond-file
			die("Oh snap, we cannot create the cron.d file. This should not happen.\nPlease check the path and permissions, the cron will keep trying if you don't stop the cron-service.\n\n");
		}
		// correct permissions
		chmod(Settings::Get("system.cronconfig"), 0640);

		// remove all re-generation tasks
		Database::query("DELETE FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = '99'");

		// run reload command
		safe_exec(escapeshellcmd(Settings::Get('system.crondreload')));
	}
	return true;
}
