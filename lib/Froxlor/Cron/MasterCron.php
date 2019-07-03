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

	private static $debugHandler = null;

	public static function setArguments($argv = null)
	{
		self::$argv = $argv;
	}

	public static function run()
	{
		self::init();

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

		self::$cronlog->setCronDebugFlag(defined('CRON_DEBUG_FLAG'));

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
					\Froxlor\Cron\System\Extrausers::generateFiles(self::$cronlog);
				}

				// clear NSCD cache if using fcgid or fpm, #1570 - not needed for nss-extrausers
				if ((\Froxlor\Settings::Get('system.mod_fcgid') == 1 || (int) \Froxlor\Settings::Get('phpfpm.enabled') == 1) && \Froxlor\Settings::Get('system.nssextrausers') == 0) {
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
		self::$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Checking system\'s last guid');
		\Froxlor\System\Cronjob::checkLastGuid();

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
			for ($x = 1; $x < count(self::$argv); $x ++) {
				if (substr(strtolower(self::$argv[$x]), 0, 2) == '--' && strlen(self::$argv[$x]) > 3) {
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
		fwrite(self::$debugHandler, 'Setting Froxlor installation path to ' . \Froxlor\Froxlor::getInstallDir() . "\n");

		if (! file_exists(\Froxlor\Froxlor::getInstallDir() . '/lib/userdata.inc.php')) {
			die("Froxlor does not seem to be installed yet - skipping cronjob");
		}

		$sql = array();
		$sql_root = array();
		// Includes the Usersettings eg. MySQL-Username/Passwort etc.
		require \Froxlor\Froxlor::getInstallDir() . '/lib/userdata.inc.php';
		fwrite(self::$debugHandler, 'Userdatas included' . "\n");

		// Legacy sql-root-information
		if (isset($sql['root_user']) && isset($sql['root_password']) && (! isset($sql_root) || ! is_array($sql_root))) {
			$sql_root = array(
				0 => array(
					'caption' => 'Default',
					'host' => $sql['host'],
					'user' => $sql['root_user'],
					'password' => $sql['root_password']
				)
			);
			unset($sql['root_user']);
			unset($sql['root_password']);
		}

		// Includes the MySQL-Tabledefinitions etc.
		require \Froxlor\Froxlor::getInstallDir() . '/lib/tables.inc.php';
		fwrite(self::$debugHandler, 'Table definitions included' . "\n");

		// try database connection, it will throw
		// and exception itself if failed
		try {
			\Froxlor\Database\Database::query("SELECT 1");
		} catch (\Exception $e) {
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
					\Froxlor\System\Cronjob::dieWithMail('Last cron jailed out with an exception. Exiting...' . "\n" . 'Take a look into the contents of ' . $lockdir . $fName . '* for more information!' . "\n");
				}

				// Check if cron is running or has died.
				$check_pid = substr(strrchr($fName, "-"), 1);
				$check_pid_return = null;
				system("kill -CHLD " . (int) $check_pid . " 1> /dev/null 2> /dev/null", $check_pid_return);

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
					\Froxlor\System\Cronjob::dieWithMail('There is already a Cronjob for ' . $crontype . ' in progress. Exiting...' . "\n" . 'Take a look into the contents of ' . $lockdir . $lockFilename . '* for more information!' . "\n");
				}
			}
		}

		/**
		 * if using fcgid or fpm for froxlor-vhost itself, we have to check
		 * whether the permission of the files are still correct
		 */
		fwrite(self::$debugHandler, 'Checking froxlor file permissions' . "\n");
		$_mypath = \Froxlor\FileDir::makeCorrectDir(\Froxlor\Froxlor::getInstallDir());

		if (((int) \Froxlor\Settings::Get('system.mod_fcgid') == 1 && (int) \Froxlor\Settings::Get('system.mod_fcgid_ownvhost') == 1) || ((int) \Froxlor\Settings::Get('phpfpm.enabled') == 1 && (int) \Froxlor\Settings::Get('phpfpm.enabled_ownvhost') == 1)) {
			$user = \Froxlor\Settings::Get('system.mod_fcgid_httpuser');
			$group = \Froxlor\Settings::Get('system.mod_fcgid_httpgroup');

			if (\Froxlor\Settings::Get('phpfpm.enabled') == 1) {
				$user = \Froxlor\Settings::Get('phpfpm.vhost_httpuser');
				$group = \Froxlor\Settings::Get('phpfpm.vhost_httpgroup');
			}
			// all the files and folders have to belong to the local user
			// now because we also use fcgid for our own vhost
			\Froxlor\FileDir::safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($_mypath));
		} else {
			// back to webserver permission
			$user = \Froxlor\Settings::Get('system.httpuser');
			$group = \Froxlor\Settings::Get('system.httpgroup');
			\Froxlor\FileDir::safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($_mypath));
		}

		// Initialize logging
		self::$cronlog = \Froxlor\FroxlorLogger::getInstanceOf(array(
			'loginname' => 'cronjob'
		));
		fwrite(self::$debugHandler, 'Logger has been included' . "\n");

		if (\Froxlor\Froxlor::hasUpdates() || \Froxlor\Froxlor::hasDbUpdates()) {
			if (\Froxlor\Settings::Get('system.cron_allowautoupdate') == null || \Froxlor\Settings::Get('system.cron_allowautoupdate') == 0) {
				/**
				 * Do not proceed further if the Database version is not the same as the script version
				 */
				fclose(self::$debugHandler);
				unlink($lockfile);
				$errormessage = "Version of file doesn't match version of database. Exiting...\n\n";
				$errormessage .= "Possible reason: Froxlor update\n";
				$errormessage .= "Information: Current version in database: " . \Froxlor\Settings::Get('panel.version') . (! empty(\Froxlor\Froxlor::BRANDING) ? "-" . \Froxlor\Froxlor::BRANDING : "") . " (DB: " . \Froxlor\Settings::Get('panel.db_version') . ") - version of Froxlor files: " . \Froxlor\Froxlor::getVersionString() . ")\n";
				$errormessage .= "Solution: Please visit your Foxlor admin interface for further information.\n";
				\Froxlor\System\Cronjob::dieWithMail($errormessage);
			}

			if (\Froxlor\Settings::Get('system.cron_allowautoupdate') == 1) {
				/**
				 * let's walk the walk - do the dangerous shit
				 */
				self::$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_WARNING, 'Automatic update is activated and we are going to proceed without any notices');
				self::$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_WARNING, 'all new settings etc. will be stored with the default value, that might not always be right for your system!');
				self::$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_WARNING, "If you don't want this to happen in the future consider removing the --allow-autoupdate flag from the cronjob");
				fwrite(self::$debugHandler, '*** WARNING *** - Automatic update is activated and we are going to proceed without any notices' . "\n");
				fwrite(self::$debugHandler, '*** WARNING *** - all new settings etc. will be stored with the default value, that might not always be right for your system!' . "\n");
				fwrite(self::$debugHandler, "*** WARNING *** - If you don't want this to happen in the future consider removing the --allow-autoupdate flag from the cronjob\n");
				// including update procedures
				define('_CRON_UPDATE', 1);
				include_once \Froxlor\Froxlor::getInstallDir() . '/install/updatesql.php';
				// pew - everything went better than expected
				self::$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_WARNING, 'Automatic update done - you should check your settings to be sure everything is fine');
				fwrite(self::$debugHandler, '*** WARNING *** - Automatic update done - you should check your settings to be sure everything is fine' . "\n");
			}
		}

		fwrite(self::$debugHandler, 'Froxlor version and database version are correct' . "\n");
	}

	private static function shutdown()
	{
		// check for cron.d-generation task and create it if necessary
		\Froxlor\Cron\CronConfig::checkCrondConfigurationFile();

		if (\Froxlor\Settings::Get('logger.log_cron') == '1') {
			\Froxlor\FroxlorLogger::getInstanceOf()->setCronLog(0);
			fwrite(self::$debugHandler, 'Logging for cron has been shutdown' . "\n");
		}

		fclose(self::$debugHandler);

		if (\Froxlor\Settings::Get('system.debug_cron') != '1') {
			unlink(self::getLockfile());
		}
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
		self::$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, "Requested cronjob '" . $cronname . "' could not be found.");
		return false;
	}
}
