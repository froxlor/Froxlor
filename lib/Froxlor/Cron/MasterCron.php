<?php
namespace Froxlor\Cron;

use Froxlor\Database\Database;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 */
class MasterCron extends \Froxlor\Cron\FroxlorCron
{

	private static $argv = null;

	public static function setArguments($argv = null)
	{
		self::$argv = $argv;
	}

	public static function run()
	{
		define('MASTER_CRONJOB', 1);

		include_once \Froxlor\Froxlor::getInstallDir() . '/lib/cron_init.php';

		$jobs_to_run = array();

		$argv = self::$argv;
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
		for ($x = 1; $x < count($argv); $x ++) {
			// check argument
			if (isset($argv[$x])) {
				// --force
				if (strtolower($argv[$x]) == '--force') {
					// really force re-generating of config-files by
					// inserting task 1
					\Froxlor\System\Cronjob::inserttask('1');
					// bind (if enabled, \Froxlor\System\Cronjob::inserttask() checks this)
					\Froxlor\System\Cronjob::inserttask('4');
					// set quotas (if enabled)
					\Froxlor\System\Cronjob::inserttask('10');
					// also regenerate cron.d-file
					\Froxlor\System\Cronjob::inserttask('99');
					array_push($jobs_to_run, 'tasks');
				} elseif (strtolower($argv[$x]) == '--debug') {
					define('CRON_DEBUG_FLAG', 1);
				} elseif (strtolower($argv[$x]) == '--no-fork') {
					define('CRON_NOFORK_FLAG', 1);
				} elseif (substr(strtolower($argv[$x]), 0, 2) == '--') {
					// --[cronname]
					if (strlen($argv[$x]) > 3) {
						$cronname = substr(strtolower($argv[$x]), 2);
						array_push($jobs_to_run, $cronname);
					}
				}
			}
		}

		$jobs_to_run = array_unique($jobs_to_run);

		\Froxlor\FroxlorLogger::getInstanceOf()->setCronDebugFlag(defined('CRON_DEBUG_FLAG'));

		$tasks_cnt_stmt = \Froxlor\Database\Database::query("SELECT COUNT(*) as jobcnt FROM `panel_tasks`");
		$tasks_cnt = $tasks_cnt_stmt->fetch(\PDO::FETCH_ASSOC);

		// do we have anything to include?
		if (count($jobs_to_run) > 0) {
			// include all jobs we want to execute
			foreach ($jobs_to_run as $cron) {
				self::updateLastRunOfCron($cron);
				$cronfile = self::getCronModule($cron);
				if ($cronfile && class_exists($cronfile)) {
					$cronfile::run();
				}
			}

			if ($tasks_cnt['jobcnt'] > 0) {
				if (\Froxlor\Settings::Get('system.nssextrausers') == 1) {
					\Froxlor\Cron\System\Extrausers::generateFiles($cronlog);
				}

				// clear NSCD cache if using fcgid or fpm, #1570
				if (\Froxlor\Settings::Get('system.mod_fcgid') == 1 || (int) \Froxlor\Settings::Get('phpfpm.enabled') == 1) {
					$false_val = false;
					\Froxlor\FileDir::safe_exec('nscd -i passwd 1> /dev/null', $false_val, array(
						'>'
					));
					\Froxlor\FileDir::safe_exec('nscd -i group 1> /dev/null', $false_val, array(
						'>'
					));
				}
			}
		}

		/**
		 * we have to check the system's last guid with every cron run
		 * in case the admin installed new software which added a new user
		 * so users in the database don't conflict with system users
		 */
		\Froxlor\FroxlorLogger::getInstanceOf()->logAction(CRON_ACTION, LOG_NOTICE, 'Checking system\'s last guid');
		\Froxlor\System\Cronjob::checkLastGuid();

		// shutdown cron
		include_once \Froxlor\Froxlor::getInstallDir() . '/lib/cron_shutdown.php';
	}

	private static function updateLastRunOfCron($cronname)
	{
		$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `lastrun` = UNIX_TIMESTAMP() WHERE `cronfile` = :cron;
		");
		Database::pexecute($upd_stmt, array(
			'cron' => $cronname
		));
	}

	private static function getCronModule($cronname)
	{
		$upd_stmt = Database::prepare("
			SELECT `cronclass` FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `cronfile` = :cron;
		");
		$cron = Database::pexecute_first($upd_stmt, array(
			'cron' => $cronname
		));
		if ($cron) {
			return $cron['cronclass'];
		}
		\Froxlor\FroxlorLogger::getInstanceOf()->logAction(CRON_ACTION, LOG_ERROR, "Requested cronjob '" . $cronname . "' could not be found.");
		return false;
	}
}
