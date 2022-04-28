<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Cron;

use Exception;
use Froxlor\Cron\System\Extrausers;
use Froxlor\Database\Database;
use Froxlor\FileDir;
use Froxlor\Froxlor;
use Froxlor\FroxlorLogger;
use Froxlor\Settings;
use Froxlor\System\Cronjob;
use PDO;

class MasterCron extends FroxlorCron
{

	private static $argv = null;

	private static $debugHandler = null;

	private static $noncron_params = [
		'force',
		'debug',
		'no-fork',
		'run-task'
	];

	public static function setArguments($argv = null)
	{
		self::$argv = $argv;
	}

	public static function run()
	{
		self::init();

		$jobs_to_run = [];

		$argv = self::$argv;
		/**
		 * check for --help
		 */
		if (count($argv) < 2 || (isset($argv[1]) && strtolower($argv[1]) == '--help')) {
			echo "\n*** Froxlor Master Cronjob ***\n\n";
			echo "Below are possible parameters for this file\n\n";
			echo "--[cronname]\t\tincludes the given cron-file\n";
			echo "--force\t\t\tforces re-generating of config-files (webserver, nameserver, etc.)\n";
			echo "--run-task\t\trun a specific task [1 = re-generate configs, 4 = re-generate dns zones, 10 = re-set quotas, 99 = re-create cron.d-file]\n";
			echo "--debug\t\t\toutput debug information about what is going on to STDOUT.\n";
			echo "--no-fork\t\tdo not fork to backkground (traffic cron only).\n\n";
			exit();
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
					Cronjob::inserttask(TaskId::REBUILD_VHOST);
					// bind (if enabled, \Froxlor\System\Cronjob::inserttask() checks this)
					Cronjob::inserttask(TaskId::REBUILD_DNS);
					// set quotas (if enabled)
					Cronjob::inserttask(TaskId::CREATE_QUOTA);
					// also regenerate cron.d-file
					Cronjob::inserttask(TaskId::REBUILD_CRON);
					array_push($jobs_to_run, 'tasks');
					define('CRON_IS_FORCED', 1);
				} elseif (strtolower($argv[$x]) == '--debug') {
					define('CRON_DEBUG_FLAG', 1);
				} elseif (strtolower($argv[$x]) == '--no-fork') {
					define('CRON_NOFORK_FLAG', 1);
				} elseif (strtolower($argv[$x]) == '--run-task') {
					if (isset($argv[$x + 1]) && in_array($argv[$x + 1], [1, 4, 10, 99])) {
						Cronjob::inserttask($argv[$x + 1]);
						array_push($jobs_to_run, 'tasks');
					} else {
						echo "Invalid argument for --run-task\n";
						exit;
					}
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

		self::$cronlog->setCronDebugFlag(defined('CRON_DEBUG_FLAG'));

		$tasks_cnt_stmt = Database::query("SELECT COUNT(*) as jobcnt FROM `panel_tasks`");
		$tasks_cnt = $tasks_cnt_stmt->fetch(PDO::FETCH_ASSOC);

		// do we have anything to include?
		if (count($jobs_to_run) > 0) {
			// include all jobs we want to execute
			foreach ($jobs_to_run as $cron) {
				Cronjob::updateLastRunOfCron($cron);
				$cronfile = self::getCronModule($cron);
				if ($cronfile && class_exists($cronfile)) {
					$cronfile::run();
				}
			}
			self::refreshUsers($tasks_cnt['jobcnt']);
		}

		/**
		 * we have to check the system's last guid with every cron run
		 * in case the admin installed new software which added a new user
		 * so users in the database don't conflict with system users
		 */
		self::$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Checking system\'s last guid');
		Cronjob::checkLastGuid();

		// shutdown cron
		self::shutdown();
	}

	private static function init()
	{
		if (@php_sapi_name() != 'cli' && @php_sapi_name() != 'cgi' && @php_sapi_name() != 'cgi-fcgi') {
			die('This script will only work in the shell.');
		}

		// ensure that default timezone is set
		if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get")) {
			@date_default_timezone_set(@date_default_timezone_get());
		}

		$basename = basename($_SERVER['PHP_SELF'], '.php');
		$crontype = "";
		if (isset(self::$argv) && is_array(self::$argv) && count(self::$argv) > 1) {
			for ($x = 1; $x < count(self::$argv); $x++) {
				if (substr(self::$argv[$x], 0, 2) == '--' && strlen(self::$argv[$x]) > 3 && !in_array(substr(strtolower(self::$argv[$x]), 2), self::$noncron_params)) {
					$crontype = substr(strtolower(self::$argv[$x]), 2);
					$basename .= "-" . $crontype;
					break;
				}
			}
		}
		$lockdir = '/var/run/';
		$lockFilename = 'froxlor_' . $basename . '.lock-';
		$lockfName = $lockFilename . getmypid();
		$lockfile = $lockdir . $lockfName;
		self::setLockfile($lockfile);

		// create and open the lockfile!
		self::$debugHandler = fopen($lockfile, 'w');
		fwrite(self::$debugHandler, 'Setting Lockfile to ' . $lockfile . "\n");
		fwrite(self::$debugHandler, 'Setting Froxlor installation path to ' . Froxlor::getInstallDir() . "\n");

		if (!file_exists(Froxlor::getInstallDir() . '/lib/userdata.inc.php')) {
			die("Froxlor does not seem to be installed yet - skipping cronjob");
		}

		$sql = [];
		$sql_root = [];
		// Includes the Usersettings eg. MySQL-Username/Passwort etc.
		require Froxlor::getInstallDir() . '/lib/userdata.inc.php';
		fwrite(self::$debugHandler, 'Userdatas included' . "\n");

		// Legacy sql-root-information
		if (isset($sql['root_user']) && isset($sql['root_password']) && (!isset($sql_root) || !is_array($sql_root))) {
			$sql_root = [
				0 => [
					'caption' => 'Default',
					'host' => $sql['host'],
					'user' => $sql['root_user'],
					'password' => $sql['root_password']
				]
			];
			unset($sql['root_user']);
			unset($sql['root_password']);
		}

		// Includes the MySQL-Tabledefinitions etc.
		require Froxlor::getInstallDir() . '/lib/tables.inc.php';
		fwrite(self::$debugHandler, 'Table definitions included' . "\n");

		// try database connection, it will throw
		// and exception itself if failed
		try {
			Database::query("SELECT 1");
		} catch (Exception $e) {
			// Do not proceed further if no database connection could be established
			fclose(self::$debugHandler);
			unlink($lockfile);
			die($e->getMessage());
		}

		fwrite(self::$debugHandler, 'Database-connection established' . "\n");

		// open the lockfile directory and scan for existing lockfiles
		$lockDirHandle = opendir($lockdir);

		while ($fName = readdir($lockDirHandle)) {
			if ($lockFilename == substr($fName, 0, strlen($lockFilename)) && $lockfName != $fName) {
				// Check if last run jailed out with an exception
				$croncontent = file($lockdir . $fName);
				$lastline = $croncontent[(count($croncontent) - 1)];

				if ($lastline == '=== Keep lockfile because of exception ===') {
					fclose(self::$debugHandler);
					unlink($lockfile);
					Cronjob::dieWithMail('Last cron jailed out with an exception. Exiting...' . "\n" . 'Take a look into the contents of ' . $lockdir . $fName . '* for more information!' . "\n");
				}

				// Check if cron is running or has died.
				$check_pid = substr(strrchr($fName, "-"), 1);
				$check_pid_return = null;
				system("kill -CHLD " . (int)$check_pid . " 1> /dev/null 2> /dev/null", $check_pid_return);

				if ($check_pid_return == 1) {
					// Result: Existing lockfile/pid isn't running
					// Most likely it has died
					//
					// Action: Remove it and continue
					//
					fwrite(self::$debugHandler, 'Previous cronjob didn\'t exit clean. PID: ' . $check_pid . "\n");
					fwrite(self::$debugHandler, 'Removing lockfile: ' . $lockdir . $fName . "\n");
					@unlink($lockdir . $fName);
				} else {
					// Result: A Cronscript with this pid
					// is still running
					// Action: remove my own Lock and die
					//
					// close the current lockfile
					fclose(self::$debugHandler);

					// ... and delete it
					unlink($lockfile);
					Cronjob::dieWithMail('There is already a Cronjob for ' . $crontype . ' in progress. Exiting...' . "\n" . 'Take a look into the contents of ' . $lockdir . $lockFilename . '* for more information!' . "\n");
				}
			}
		}

		/**
		 * if using fcgid or fpm for froxlor-vhost itself, we have to check
		 * whether the permission of the files are still correct
		 */
		fwrite(self::$debugHandler, 'Checking froxlor file permissions' . "\n");
		$_mypath = FileDir::makeCorrectDir(Froxlor::getInstallDir());

		if (((int)Settings::Get('system.mod_fcgid') == 1 && (int)Settings::Get('system.mod_fcgid_ownvhost') == 1) || ((int)Settings::Get('phpfpm.enabled') == 1 && (int)Settings::Get('phpfpm.enabled_ownvhost') == 1)) {
			$user = Settings::Get('system.mod_fcgid_httpuser');
			$group = Settings::Get('system.mod_fcgid_httpgroup');

			if (Settings::Get('phpfpm.enabled') == 1) {
				$user = Settings::Get('phpfpm.vhost_httpuser');
				$group = Settings::Get('phpfpm.vhost_httpgroup');
			}
			// all the files and folders have to belong to the local user
			// now because we also use fcgid for our own vhost
			FileDir::safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($_mypath));
		} else {
			// back to webserver permission
			$user = Settings::Get('system.httpuser');
			$group = Settings::Get('system.httpgroup');
			FileDir::safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($_mypath));
		}

		// Initialize logging
		self::$cronlog = FroxlorLogger::getInstanceOf([
			'loginname' => 'cronjob'
		]);
		fwrite(self::$debugHandler, 'Logger has been included' . "\n");

		if (Froxlor::hasUpdates() || Froxlor::hasDbUpdates()) {
			if (Settings::Get('system.cron_allowautoupdate') == null || Settings::Get('system.cron_allowautoupdate') == 0) {
				/**
				 * Do not proceed further if the Database version is not the same as the script version
				 */
				fclose(self::$debugHandler);
				unlink($lockfile);
				$errormessage = "Version of file doesn't match version of database. Exiting...\n\n";
				$errormessage .= "Possible reason: Froxlor update\n";
				$errormessage .= "Information: Current version in database: " . Settings::Get('panel.version') . (!empty(Froxlor::BRANDING) ? "-" . Froxlor::BRANDING : "") . " (DB: " . Settings::Get('panel.db_version') . ") - version of Froxlor files: " . Froxlor::getVersionString() . ")\n";
				$errormessage .= "Solution: Please visit your Foxlor admin interface for further information.\n";
				Cronjob::dieWithMail($errormessage);
			}

			if (Settings::Get('system.cron_allowautoupdate') == 1) {
				/**
				 * let's walk the walk - do the dangerous shit
				 */
				self::$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_WARNING, 'Automatic update is activated and we are going to proceed without any notices');
				self::$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_WARNING, 'all new settings etc. will be stored with the default value, that might not always be right for your system!');
				self::$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_WARNING, "If you don't want this to happen in the future consider removing the --allow-autoupdate flag from the cronjob");
				fwrite(self::$debugHandler, '*** WARNING *** - Automatic update is activated and we are going to proceed without any notices' . "\n");
				fwrite(self::$debugHandler, '*** WARNING *** - all new settings etc. will be stored with the default value, that might not always be right for your system!' . "\n");
				fwrite(self::$debugHandler, "*** WARNING *** - If you don't want this to happen in the future consider removing the --allow-autoupdate flag from the cronjob\n");
				// including update procedures
				define('_CRON_UPDATE', 1);
				include_once Froxlor::getInstallDir() . '/install/updatesql.php';
				// pew - everything went better than expected
				self::$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_WARNING, 'Automatic update done - you should check your settings to be sure everything is fine');
				fwrite(self::$debugHandler, '*** WARNING *** - Automatic update done - you should check your settings to be sure everything is fine' . "\n");
			}
		}

		fwrite(self::$debugHandler, 'Froxlor version and database version are correct' . "\n");
	}

	private static function getCronModule($cronname)
	{
		$upd_stmt = Database::prepare("
			SELECT `cronclass` FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `cronfile` = :cron;
		");
		$cron = Database::pexecute_first($upd_stmt, [
			'cron' => $cronname
		]);
		if ($cron) {
			return $cron['cronclass'];
		}
		self::$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_ERR, "Requested cronjob '" . $cronname . "' could not be found.");
		return false;
	}

	private static function refreshUsers($jobcount = 0)
	{
		if ($jobcount > 0) {
			if (Settings::Get('system.nssextrausers') == 1) {
				Extrausers::generateFiles(self::$cronlog);
			}

			// clear NSCD cache if using fcgid or fpm, #1570 - not needed for nss-extrausers
			if ((Settings::Get('system.mod_fcgid') == 1 || (int)Settings::Get('phpfpm.enabled') == 1) && Settings::Get('system.nssextrausers') == 0) {
				$false_val = false;
				FileDir::safe_exec('nscd -i passwd 1> /dev/null', $false_val, [
					'>'
				]);
				FileDir::safe_exec('nscd -i group 1> /dev/null', $false_val, [
					'>'
				]);
			}
		}
	}

	private static function shutdown()
	{
		// check for cron.d-generation task and create it if necessary
		CronConfig::checkCrondConfigurationFile();

		if (Settings::Get('logger.log_cron') == '1') {
			FroxlorLogger::getInstanceOf()->setCronLog(0);
			fwrite(self::$debugHandler, 'Logging for cron has been shutdown' . "\n");
		}

		fclose(self::$debugHandler);

		if (Settings::Get('system.debug_cron') != '1') {
			unlink(self::getLockfile());
		}
	}
}
