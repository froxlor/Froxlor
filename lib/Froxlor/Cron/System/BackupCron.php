<?php
namespace Froxlor\Cron\System;

use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\FroxlorLogger;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 * @since 0.9.35.1
 *       
 */
class BackupCron extends \Froxlor\Cron\FroxlorCron
{

	public static function run()
	{
		// Check Traffic-Lock
		if (function_exists('pcntl_fork')) {
			$BackupLock = \Froxlor\FileDir::makeCorrectFile(dirname(self::getLockfile()) . "/froxlor_cron_backup.lock");
			if (file_exists($BackupLock) && is_numeric($BackupPid = file_get_contents($BackupLock))) {
				if (function_exists('posix_kill')) {
					$BackupPidStatus = @posix_kill($BackupPid, 0);
				} else {
					system("kill -CHLD " . $BackupPid . " 1> /dev/null 2> /dev/null", $BackupPidStatus);
					$BackupPidStatus = $BackupPidStatus ? false : true;
				}
				if ($BackupPidStatus) {
					FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'Backup run already in progress');
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
			FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_WARNING, $msg . " Not forking backup-cron, this may take a long time!");
		}

		FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'BackupCron: started - creating customer backup');

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

				if (isset($row['data']['customerid']) && isset($row['data']['loginname']) && isset($row['data']['destdir'])) {
					$row['data']['destdir'] = \Froxlor\FileDir::makeCorrectDir($row['data']['destdir']);
					$customerdocroot = \Froxlor\FileDir::makeCorrectDir(Settings::Get('system.documentroot_prefix') . '/' . $row['data']['loginname'] . '/');

					// create folder if not exists
					if (! file_exists($row['data']['destdir']) && $row['data']['destdir'] != '/' && $row['data']['destdir'] != Settings::Get('system.documentroot_prefix') && $row['data']['destdir'] != $customerdocroot) {
						FroxlorLogger::getInstanceOf()->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'Creating backup-destination path for customer: ' . escapeshellarg($row['data']['destdir']));
						\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($row['data']['destdir']));
					}

					self::createCustomerBackup($row['data'], $customerdocroot, FroxlorLogger::getInstanceOf());
				}
			}

			// remove entry
			Database::pexecute($del_stmt, array(
				'id' => $row['id']
			));
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
		$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'Creating Backup for user "' . $data['loginname'] . '"');

		// create tmp folder
		$tmpdir = \Froxlor\FileDir::makeCorrectDir($data['destdir'] . '/.tmp/');
		$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Creating tmp-folder "' . $tmpdir . '"');
		$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> mkdir -p ' . escapeshellarg($tmpdir));
		\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
		$create_backup_tar_data = "";

		// MySQL databases
		if ($data['backup_dbs'] == 1) {

			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Creating mysql-folder "' . \Froxlor\FileDir::makeCorrectDir($tmpdir . '/mysql') . '"');
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> mkdir -p ' . escapeshellarg(\Froxlor\FileDir::makeCorrectDir($tmpdir . '/mysql')));
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg(\Froxlor\FileDir::makeCorrectDir($tmpdir . '/mysql')));

			// get all customer database-names
			$sel_stmt = Database::prepare("SELECT `databasename` FROM `" . TABLE_PANEL_DATABASES . "` WHERE `customerid` = :cid");
			Database::pexecute($sel_stmt, array(
				'cid' => $data['customerid']
			));

			Database::needRoot(true);
			Database::needSqlData();
			$sql_root = Database::getSqlData();
			Database::needRoot(false);

			$has_dbs = false;
			while ($row = $sel_stmt->fetch()) {
				$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> mysqldump -u ' . escapeshellarg($sql_root['user']) . ' -pXXXXX ' . $row['databasename'] . ' > ' . \Froxlor\FileDir::makeCorrectFile($tmpdir . '/mysql/' . $row['databasename'] . '_' . date('YmdHi', time()) . '.sql'));
				$bool_false = false;
				\Froxlor\FileDir::safe_exec('mysqldump -u ' . escapeshellarg($sql_root['user']) . ' -p' . $sql_root['passwd'] . ' ' . $row['databasename'] . ' > ' . \Froxlor\FileDir::makeCorrectFile($tmpdir . '/mysql/' . $row['databasename'] . '_' . date('YmdHi', time()) . '.sql'), $bool_false, array(
					'>'
				));
				$has_dbs = true;
			}

			if ($has_dbs) {
				$create_backup_tar_data .= './mysql ';
			}

			unset($sql_root);
		}

		// E-mail data
		if ($data['backup_mail'] == 1) {

			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Creating mail-folder "' . \Froxlor\FileDir::makeCorrectDir($tmpdir . '/mail') . '"');
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg(\Froxlor\FileDir::makeCorrectDir($tmpdir . '/mail')));

			// get all customer mail-accounts
			$sel_stmt = Database::prepare("SELECT `homedir`, `maildir` FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid` = :cid");
			Database::pexecute($sel_stmt, array(
				'cid' => $data['customerid']
			));

			$tar_file_list = "";
			$mail_homedir = "";
			while ($row = $sel_stmt->fetch()) {
				$tar_file_list .= escapeshellarg("./" . $row['maildir']) . " ";
				$mail_homedir = $row['homedir'];
			}

			if (! empty($tar_file_list)) {
				$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> tar cfvz ' . escapeshellarg(\Froxlor\FileDir::makeCorrectFile($tmpdir . '/mail/' . $data['loginname'] . '-mail.tar.gz')) . ' -C ' . escapeshellarg($mail_homedir) . ' ' . trim($tar_file_list));
				\Froxlor\FileDir::safe_exec('tar cfz ' . escapeshellarg(\Froxlor\FileDir::makeCorrectFile($tmpdir . '/mail/' . $data['loginname'] . '-mail.tar.gz')) . ' -C ' . escapeshellarg($mail_homedir) . ' ' . trim($tar_file_list));
				$create_backup_tar_data .= './mail ';
			}
		}

		// Web data
		if ($data['backup_web'] == 1) {

			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Creating web-folder "' . \Froxlor\FileDir::makeCorrectDir($tmpdir . '/web') . '"');
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg(\Froxlor\FileDir::makeCorrectDir($tmpdir . '/web')));
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> tar cfz ' . escapeshellarg(\Froxlor\FileDir::makeCorrectFile($tmpdir . '/web/' . $data['loginname'] . '-web.tar.gz')) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", \Froxlor\FileDir::makeCorrectFile($tmpdir . '/*'))) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", substr(\Froxlor\FileDir::makeCorrectDir($tmpdir), 0, - 1))) . ' -C ' . escapeshellarg($customerdocroot) . ' .');
			\Froxlor\FileDir::safe_exec('tar cfz ' . escapeshellarg(\Froxlor\FileDir::makeCorrectFile($tmpdir . '/web/' . $data['loginname'] . '-web.tar.gz')) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", \Froxlor\FileDir::makeCorrectFile($tmpdir . '/*'))) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", substr(\Froxlor\FileDir::makeCorrectFile($tmpdir), 0, - 1))) . ' -C ' . escapeshellarg($customerdocroot) . ' .');
			$create_backup_tar_data .= './web ';
		}

		if (! empty($create_backup_tar_data)) {
			$backup_file = \Froxlor\FileDir::makeCorrectFile($tmpdir . '/' . $data['loginname'] . '-backup_' . date('YmdHi', time()) . '.tar.gz');
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'Creating backup-file "' . $backup_file . '"');
			// pack all archives in tmp-dir to one
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> tar cfz ' . escapeshellarg($backup_file) . ' -C ' . escapeshellarg($tmpdir) . ' ' . trim($create_backup_tar_data));
			\Froxlor\FileDir::safe_exec('tar cfz ' . escapeshellarg($backup_file) . ' -C ' . escapeshellarg($tmpdir) . ' ' . trim($create_backup_tar_data));
			// move to destination directory
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> mv ' . escapeshellarg($backup_file) . ' ' . escapeshellarg($data['destdir']));
			\Froxlor\FileDir::safe_exec('mv ' . escapeshellarg($backup_file) . ' ' . escapeshellarg($data['destdir']));
			// remove tmp-files
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> rm -rf ' . escapeshellarg($tmpdir));
			\Froxlor\FileDir::safe_exec('rm -rf ' . escapeshellarg($tmpdir));
			// set owner to customer
			$cronlog->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'shell> chown -R ' . (int) $data['uid'] . ':' . (int) $data['gid'] . ' ' . escapeshellarg($data['destdir']));
			\Froxlor\FileDir::safe_exec('chown -R ' . (int) $data['uid'] . ':' . (int) $data['gid'] . ' ' . escapeshellarg($data['destdir']));
		}
	}
}
