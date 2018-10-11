<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 * @since      0.9.35.1
 *
 */

// Check Traffic-Lock
if (function_exists('pcntl_fork')) {
	$BackupLock = makeCorrectFile(dirname($lockfile)."/froxlor_cron_backup.lock");
	if (file_exists($BackupLock)
		&& is_numeric($BackupPid=file_get_contents($BackupLock))
		) {
			if (function_exists('posix_kill')) {
				$BackupPidStatus = @posix_kill($BackupPid,0);
			} else {
				system("kill -CHLD " . $BackupPid . " 1> /dev/null 2> /dev/null", $BackupPidStatus);
				$BackupPidStatus = $BackupPidStatus ? false : true;
			}
			if ($BackupPidStatus) {
				$cronlog->logAction(CRON_ACTION, LOG_INFO, 'Backup run already in progress');
				return 1;
			}
		}
		// Create Backup Log and Fork
		// We close the database - connection before we fork, so we don't share resources with the child
		Database::needRoot(false); // this forces the connection to be set to null
		$BackupPid = pcntl_fork();
		// Parent
		if ($BackupPid) {
			file_put_contents($BackupLock, $BackupPid);
			// unnecessary to recreate database connection here
			return 0;

		}
		//Child
		elseif ($BackupPid == 0) {
			posix_setsid();
			fclose($debugHandler);
			// re-create db
			Database::needRoot(false);
		}
		//Fork failed
		else {
			return 1;
		}

} else {
	if (extension_loaded('pcntl')) {
		$msg = "PHP compiled with pcntl but pcntl_fork function is not available.";
	} else {
		$msg = "PHP compiled without pcntl.";
	}
	$cronlog->logAction(CRON_ACTION, LOG_WARNING, $msg." Not forking backup-cron, this may take a long time!");
}

$cronlog->logAction(CRON_ACTION, LOG_INFO, 'cron_backup: started - creating customer backup');

$result_tasks_stmt = Database::query("
	SELECT * FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = '20' ORDER BY `id` ASC
");

$del_stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_TASKS . "` WHERE `id` = :id");

$all_jobs = $result_tasks_stmt->fetchAll();
foreach ($all_jobs as $row) {

	if ($row['data'] != '') {
		$row['data'] = json_decode($row['data'], true);
	}

	if (is_array($row['data'])) {

		if (isset($row['data']['customerid'])
			&& isset($row['data']['loginname'])
			&& isset($row['data']['destdir'])
			) {
				$row['data']['destdir'] = makeCorrectDir($row['data']['destdir']);
				$customerdocroot = makeCorrectDir(Settings::Get('system.documentroot_prefix').'/'.$row['data']['loginname'].'/');

				// create folder if not exists
				if (!file_exists($row['data']['destdir'])
					&& $row['data']['destdir'] != '/'
					&& $row['data']['destdir'] != Settings::Get('system.documentroot_prefix')
					&& $row['data']['destdir'] != $customerdocroot
					) {
						$cronlog->logAction(CRON_ACTION, LOG_NOTICE, 'Creating backup-destination path for customer: ' . escapeshellarg($row['data']['destdir']));
						safe_exec('mkdir -p '.escapeshellarg($row['data']['destdir']));
					}

					createCustomerBackup($row['data'], $customerdocroot, $cronlog);
			}
	}

	// remove entry
	Database::pexecute($del_stmt, array('id' => $row['id']));
}

if (function_exists('pcntl_fork')) {
	@unlink($BackupLock);
	die();
}
