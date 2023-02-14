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

namespace Froxlor\Cron\System;

use Froxlor\Cron\FroxlorCron;
use Froxlor\Database\Database;
use Froxlor\FileDir;
use Froxlor\FroxlorLogger;
use Froxlor\Settings;

class BackupCron extends FroxlorCron
{

	public static function run()
	{
		// Check Traffic-Lock
		if (function_exists('pcntl_fork')) {
			$BackupLock = FileDir::makeCorrectFile(dirname(self::getLockfile()) . "/froxlor_cron_backup.lock");
			if (file_exists($BackupLock) && is_numeric($BackupPid = file_get_contents($BackupLock))) {
				if (function_exists('posix_kill')) {
					$BackupPidStatus = @posix_kill($BackupPid, 0);
				} else {
					system("kill -CHLD " . $BackupPid . " 1> /dev/null 2> /dev/null", $BackupPidStatus);
					$BackupPidStatus = !$BackupPidStatus;
				}
				if ($BackupPidStatus) {
					FroxlorLogger::getInstanceOf()->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'Backup run already in progress');
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
			} elseif ($BackupPid == 0) {
				// Child
				posix_setsid();
				// re-create db
				Database::needRoot(false);
			} else {
				// Fork failed
				return 1;
			}
		} else {
			if (extension_loaded('pcntl')) {
				$msg = "PHP compiled with pcntl but pcntl_fork function is not available.";
			} else {
				$msg = "PHP compiled without pcntl.";
			}
			FroxlorLogger::getInstanceOf()->logAction(FroxlorLogger::CRON_ACTION, LOG_WARNING, $msg . " Not forking backup-cron, this may take a long time!");
		}

		FroxlorLogger::getInstanceOf()->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'BackupCron: started - creating customer backup');

		$result_tasks_stmt = Database::query("
			SELECT * FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = '20' ORDER BY `id` ASC
		");

		$del_stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_TASKS . "` WHERE `id` = :id");

		$cronlog = FroxlorLogger::getInstanceOf();
		$all_jobs = $result_tasks_stmt->fetchAll();
		foreach ($all_jobs as $row) {
			if ($row['data'] != '') {
				$row['data'] = json_decode($row['data'], true);
			}

			if (is_array($row['data'])) {
				if (isset($row['data']['customerid']) && isset($row['data']['loginname']) && isset($row['data']['destdir'])) {
					$row['data']['destdir'] = FileDir::makeCorrectDir($row['data']['destdir']);
					$customerdocroot = FileDir::makeCorrectDir(Settings::Get('system.documentroot_prefix') . '/' . $row['data']['loginname'] . '/');

					// create folder if not exists
					if (!file_exists($row['data']['destdir']) && $row['data']['destdir'] != '/' && $row['data']['destdir'] != Settings::Get('system.documentroot_prefix') && $row['data']['destdir'] != $customerdocroot) {
						FroxlorLogger::getInstanceOf()->logAction(FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Creating backup-destination path for customer: ' . escapeshellarg($row['data']['destdir']));
						FileDir::safe_exec('mkdir -p ' . escapeshellarg($row['data']['destdir']));
					}

					self::createCustomerBackup($row['data'], $customerdocroot, $cronlog);
				}
			}

			// remove entry
			Database::pexecute($del_stmt, [
				'id' => $row['id']
			]);
		}

		if (function_exists('pcntl_fork')) {
			@unlink($BackupLock);
			die();
		}
	}

	/**
	 * depending on the give choice, the customers web-data, email-data and databases are being backup'ed
	 *
	 * @param array $data
	 *
	 * @return void
	 *
	 */
	private static function createCustomerBackup($data = null, $customerdocroot = null, &$cronlog = null)
	{
		$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'Creating Backup for user "' . $data['loginname'] . '"');

		// create tmp folder
		$tmpdir = FileDir::makeCorrectDir($data['destdir'] . '/.tmp/');
		$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Creating tmp-folder "' . $tmpdir . '"');
		$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> mkdir -p ' . escapeshellarg($tmpdir));
		FileDir::safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
		$create_backup_tar_data = "";

		// MySQL databases
		if ($data['backup_dbs'] == 1) {
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Creating mysql-folder "' . FileDir::makeCorrectDir($tmpdir . '/mysql') . '"');
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> mkdir -p ' . escapeshellarg(FileDir::makeCorrectDir($tmpdir . '/mysql')));
			FileDir::safe_exec('mkdir -p ' . escapeshellarg(FileDir::makeCorrectDir($tmpdir . '/mysql')));

			// get all customer database-names
			$sel_stmt = Database::prepare("SELECT `databasename`, `dbserver` FROM `" . TABLE_PANEL_DATABASES . "` WHERE `customerid` = :cid ORDER BY `dbserver`");
			Database::pexecute($sel_stmt, [
				'cid' => $data['customerid']
			]);

			$has_dbs = false;
			$current_dbserver = null;
			while ($row = $sel_stmt->fetch()) {
				// Get sql_root data for the specific database-server the database resides on
				if ($current_dbserver != $row['dbserver']) {
					Database::needRoot(true, $row['dbserver']);
					Database::needSqlData();
					$sql_root = Database::getSqlData();
					Database::needRoot(false);
					// create temporary mysql-defaults file for the connection-credentials/details
					$mysqlcnf_file = tempnam("/tmp", "frx");
					$mysqlcnf = "[mysqldump]\npassword=" . $sql_root['passwd'] . "\nhost=" . $sql_root['host'] . "\n";
					if (!empty($sql_root['port'])) {
						$mysqlcnf .= "port=" . $sql_root['port'] . "\n";
					} elseif (!empty($sql_root['socket'])) {
						$mysqlcnf .= "socket=" . $sql_root['socket'] . "\n";
					}
					file_put_contents($mysqlcnf_file, $mysqlcnf);
				}
				$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> mysqldump -u ' . escapeshellarg($sql_root['user']) . ' -pXXXXX ' . $row['databasename'] . ' > ' . FileDir::makeCorrectFile($tmpdir . '/mysql/' . $row['databasename'] . '_' . date('YmdHi', time()) . '.sql'));
				$bool_false = false;
				FileDir::safe_exec('mysqldump --defaults-file=' . escapeshellarg($mysqlcnf_file) . ' -u ' . escapeshellarg($sql_root['user']) . ' ' . $row['databasename'] . ' > ' . FileDir::makeCorrectFile($tmpdir . '/mysql/' . $row['databasename'] . '_' . date('YmdHi', time()) . '.sql'), $bool_false, [
					'>'
				]);
				$has_dbs = true;
				$current_dbserver = $row['dbserver'];
			}

			if ($has_dbs) {
				$create_backup_tar_data .= './mysql ';
			}

			unlink($mysqlcnf_file);

			unset($sql_root);
		}

		// E-mail data
		if ($data['backup_mail'] == 1) {
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Creating mail-folder "' . FileDir::makeCorrectDir($tmpdir . '/mail') . '"');
			FileDir::safe_exec('mkdir -p ' . escapeshellarg(FileDir::makeCorrectDir($tmpdir . '/mail')));

			// get all customer mail-accounts
			$sel_stmt = Database::prepare("SELECT `homedir`, `maildir` FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid` = :cid");
			Database::pexecute($sel_stmt, [
				'cid' => $data['customerid']
			]);

			$tar_file_list = "";
			$mail_homedir = "";
			while ($row = $sel_stmt->fetch()) {
				$tar_file_list .= escapeshellarg("./" . $row['maildir']) . " ";
				$mail_homedir = $row['homedir'];
			}

			if (!empty($tar_file_list)) {
				$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> tar cfvz ' . escapeshellarg(FileDir::makeCorrectFile($tmpdir . '/mail/' . $data['loginname'] . '-mail.tar.gz')) . ' -C ' . escapeshellarg($mail_homedir) . ' ' . trim($tar_file_list));
				FileDir::safe_exec('tar cfz ' . escapeshellarg(FileDir::makeCorrectFile($tmpdir . '/mail/' . $data['loginname'] . '-mail.tar.gz')) . ' -C ' . escapeshellarg($mail_homedir) . ' ' . trim($tar_file_list));
				$create_backup_tar_data .= './mail ';
			}
		}

		// Web data
		if ($data['backup_web'] == 1) {
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Creating web-folder "' . FileDir::makeCorrectDir($tmpdir . '/web') . '"');
			FileDir::safe_exec('mkdir -p ' . escapeshellarg(FileDir::makeCorrectDir($tmpdir . '/web')));
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> tar cfz ' . escapeshellarg(FileDir::makeCorrectFile($tmpdir . '/web/' . $data['loginname'] . '-web.tar.gz')) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", FileDir::makeCorrectFile($tmpdir . '/*'))) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", substr(FileDir::makeCorrectDir($tmpdir), 0, -1))) . ' -C ' . escapeshellarg($customerdocroot) . ' .');
			FileDir::safe_exec('tar cfz ' . escapeshellarg(FileDir::makeCorrectFile($tmpdir . '/web/' . $data['loginname'] . '-web.tar.gz')) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", FileDir::makeCorrectFile($tmpdir . '/*'))) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", substr(FileDir::makeCorrectFile($tmpdir), 0, -1))) . ' -C ' . escapeshellarg($customerdocroot) . ' .');
			$create_backup_tar_data .= './web ';
		}

		if (!empty($create_backup_tar_data)) {
			$backup_file = FileDir::makeCorrectFile($tmpdir . '/' . $data['loginname'] . '-backup_' . date('YmdHi', time()) . '.tar.gz');
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'Creating backup-file "' . $backup_file . '"');
			// pack all archives in tmp-dir to one
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> tar cfz ' . escapeshellarg($backup_file) . ' -C ' . escapeshellarg($tmpdir) . ' ' . trim($create_backup_tar_data));
			FileDir::safe_exec('tar cfz ' . escapeshellarg($backup_file) . ' -C ' . escapeshellarg($tmpdir) . ' ' . trim($create_backup_tar_data));
			// move to destination directory
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> mv ' . escapeshellarg($backup_file) . ' ' . escapeshellarg($data['destdir']));
			FileDir::safe_exec('mv ' . escapeshellarg($backup_file) . ' ' . escapeshellarg($data['destdir']));
			// remove tmp-files
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> rm -rf ' . escapeshellarg($tmpdir));
			FileDir::safe_exec('rm -rf ' . escapeshellarg($tmpdir));
			// set owner to customer
			$cronlog->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> chown -R ' . (int)$data['uid'] . ':' . (int)$data['gid'] . ' ' . escapeshellarg($data['destdir']));
			FileDir::safe_exec('chown -R ' . (int)$data['uid'] . ':' . (int)$data['gid'] . ' ' . escapeshellarg($data['destdir']));
		}
	}
}
