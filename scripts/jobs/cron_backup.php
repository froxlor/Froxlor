<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

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

/**
 * Backup
*/
if ($settings['system']['backup_enabled'] == '1') {

	fwrite($debugHandler, 'backup customers started...' . "\n");

	// get sql-root access data for mysqldump
	Database::needRoot(true);
	Database::needSqlData(true);
	$sql_root = Database::getSqlData();
	Database::needRoot(false);

	$result_stmt = Database::query("
		SELECT customerid, loginname, guid, documentroot, backup_allowed, backup_enabled
		FROM `" . TABLE_PANEL_CUSTOMERS . "` ORDER BY `customerid` ASC;
		");

	while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

		fwrite($debugHandler, 'backup for ' . $row['loginname'] . ' started...' . "\n");

		// backup
		if ($row['backup_allowed'] == '1'
			&& $row['backup_enabled'] == '1'
		) {
			// get uid & gid from ftp table
			$ftp_result_stmt = Database::prepare("
				SELECT uid, gid FROM `" . TABLE_FTP_USERS . "`
				WHERE `username` = :loginname
			");
			$ftp_row = Database::pexecute_first($ftp_result_stmt, array('loginname' => $row['loginname']));

			// create backup dir an set rights
			$_backupdir = makeCorrectDir($settings['system']['backup_dir'] . $row['loginname']);
			if (!file_exists($_backupdir)) {
				safe_exec('install -d ' . escapeshellarg($_backupdir) . ' -o ' . escapeshellarg($ftp_row['uid']) . ' -g ' . escapeshellarg($ftp_row['gid']) . ' -m ' . '0500');
			}

			// create customers html backup
			safe_exec('tar -C ' . escapeshellarg($row['documentroot']) . ' -c -z -f ' . escapeshellarg($_backupdir)  . '/' . escapeshellarg($row['loginname']) . 'html.tar.gz .');

			// get customer dbs
			$dbs_result_stmt = Database::prepare("
				SELECT `databasename` FROM `" . TABLE_PANEL_DATABASES . "`
				WHERE `customerid` = :customerid
			");
			Database::pexecute($dbs_result_stmt, array('customerid' => $row['customerid']));
			
			while ($dbs_row = $dbs_result_stmt->fetch(PDO::FETCH_ASSOC)){
				// create customers sql backup
				safe_exec(escapeshellcmd($settings['system']['backup_mysqldump_path']) . ' --opt --force --allow-keywords -u ' . escapeshellarg($sql_root['user']) . ' -p' . escapeshellarg($sql_root['passwd']) . ' -h ' . $sql_root['host'] . ' -B ' . escapeshellarg($dbs_row['databasename']) . ' -r ' . escapeshellarg($_backupdir) . '/' . escapeshellarg($dbs_row['databasename']) . '.sql'  );
				// compress sql backup
				safe_exec('tar -C ' . escapeshellarg($_backupdir) . ' -c -z -f ' . escapeshellarg($settings['system']['backup_dir']) . $row['loginname'] . '/' . escapeshellarg($dbs_row['databasename']) . '.tar.gz ' . escapeshellarg($dbs_row['databasename']) . '.sql');
				// remove uncompresed sql files
				safe_exec('rm ' . escapeshellarg($_backupdir) . '/' . escapeshellarg($dbs_row['databasename']) . '.sql');
			}

			// create 1 big file with html & db
			if ($settings['system']['backup_bigfile'] == 1) {
				safe_exec('tar -C ' . escapeshellarg($_backupdir) . '/' . ' --exclude=' . escapeshellarg($row['loginname']) . '.tar.gz -c -z -f ' . escapeshellarg($_backupdir) . '/' . escapeshellarg($row['loginname']) . '.tar.gz .');
				// remove separated files
				$tmp_files = scandir($_backupdir);
				foreach ($tmp_files as $tmp_file) {
					if (preg_match('/.*(html|sql|aps).*\.tar\.gz$/', $tmp_file) && !preg_match('/^' . $row['loginname'] . '\.tar\.gz$/', $tmp_file)) {
						safe_exec('rm ' . escapeshellarg($_backupdir) . '/' . escapeshellarg($tmp_file));
					}
				}
			} else {
				//remove big file if separated backups are used
				if (file_exists(makeCorrectFile($_backupdir . '/' . $row['loginname'] . '.tar.gz'))) {
					safe_exec('rm ' . escapeshellarg($_backupdir) . '/' . escapeshellarg($row['loginname']) . '.tar.gz');
				}
			}

			// chown & chmod files to prevent manipulation
			safe_exec('chown ' . escapeshellarg($row['guid']) . ':' . escapeshellarg($row['guid']) . ' ' . escapeshellarg($_backupdir) . '/*');
			safe_exec('chmod 0400 ' . escapeshellarg($_backupdir) . '/*');

			// create ftp backup user
			$user_result_stmt = Database::prepare("
				SELECT username, password FROM `" . TABLE_FTP_USERS . "`
				WHERE `customerid` = :customerid AND `username` = :username;
			");
			$user_row = Database::pexecute_first($user_result_stmt, array('customerid' => $row['customerid'], 'username' => $row['loginname']));

			$ins_stmt = Database::prepare("
				REPLACE INTO `" . TABLE_FTP_USERS . "`
				(`customerid`, `username`, `password`, `homedir`, `login_enabled`, `uid`, `gid`)
				VALUES
				(:customerid, :username, :password, :homedir, 'y', :guid, :guid)
			");
			$ins_data = array(
				'customerid' => $row['customerid'],
				'username' => $row['loginname']."_backup",
				'password' => $user_row['password'],
				'homedir' => makeCorrectDir($settings['system']['backup_dir'].'/'.$row['loginname'].'/'),
				'guid' => $row['guid']
			);
			Database::pexecute($ins_stmt, $ins_data);

			if ($settings['system']['backup_ftp_enabled'] == '1') {
				// upload backup to customers ftp server
				$_ftpdir = makeCorrectDir($settings['system']['backup_dir'].'/'.$row['loginname'].'/');
				$ftp_files = scandir($_ftpdir);

				foreach ($ftp_files as $ftp_file) {
					if (preg_match('/.*\.tar\.gz$/', $ftp_file)) {

						$ftp_con = ftp_connect($settings['system']['backup_ftp_server']);
						$ftp_login = ftp_login($ftp_con, $settings['system']['backup_ftp_user'], $settings['system']['backup_ftp_pass']);

						// Check whether to use passive mode or not
						if ($settings['system']['backup_ftp_passive'] == 1) {
							ftp_pasv($ftp_con, true);
						} else {
							ftp_pasv($ftp_con, false);
						}
						$_file = makeCorrectFile($_ftpdir.'/'.$ftp_file);
						$ftp_upload = ftp_put($ftp_con, $ftp_file, $_file, FTP_BINARY);
					}
				}
			}
			fwrite($debugHandler, 'backup for ' . $row['loginname'] . ' finished...' . "\n");
		}
		// delete old backup data (deletes backup if customer or admin disables backup)
		elseif ($row['backup_allowed'] == '0' || $row['backup_enabled'] == '0') {
			$_ftpdir = makeCorrectDir($settings['system']['backup_dir'].'/'.$row['loginname'].'/');
			if (file_exists($_ftpdir)){
				$files = scandir($_ftpdir);
				foreach ($files as $file) {
					if (preg_match('/.*\.tar\.gz$/', $file)){
						$_file = makeCorrectFile($_ftpdir.'/'.$file);
						safe_exec('rm -f ' . escapeshellarg($_file));
					}
				}
			}
		}
	}
	fwrite($debugHandler, 'backup customers finished...' . "\n");
}
