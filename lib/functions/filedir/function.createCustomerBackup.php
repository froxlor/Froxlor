<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
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
 * depending on the give choice, the customers web-data, email-data and databases are being backup'ed
 *
 * @param array $data
 *
 * @return void
 *
 */
function createCustomerBackup($data = null, $customerdocroot = null, &$cronlog)
{
	$cronlog->logAction(CRON_ACTION, LOG_INFO, 'Creating Backup for user "'.$data['loginname'].'"');

	// create tmp folder
	$tmpdir = makeCorrectDir($data['destdir'] . '/.tmp/');
	$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'Creating tmp-folder "'.$tmpdir.'"');
	$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'shell> mkdir -p ' . escapeshellarg($tmpdir));
	safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
	$create_backup_tar_data = "";

	// MySQL databases
	if ($data['backup_dbs'] == 1) {

		$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'Creating mysql-folder "'.makeCorrectDir($tmpdir . '/mysql').'"');
		$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'shell> mkdir -p ' . escapeshellarg(makeCorrectDir($tmpdir . '/mysql')));
		safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir($tmpdir . '/mysql')));

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
			$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'shell> mysqldump -u ' . escapeshellarg($sql_root['user']) . ' -pXXXXX ' . $row['databasename'] . ' > ' . makeCorrectFile($tmpdir . '/mysql/' . $row['databasename'] . '_' . date('YmdHi', time()) . '.sql'));
			$bool_false = false;
			safe_exec('mysqldump -u ' . escapeshellarg($sql_root['user']) . ' -p' . $sql_root['passwd'] . ' ' . $row['databasename'] . ' > ' . makeCorrectFile($tmpdir . '/mysql/' . $row['databasename'] . '_' . date('YmdHi', time()) . '.sql'), $bool_false, array('>'));
			$has_dbs = true;
		}

		if ($has_dbs) {
			$create_backup_tar_data .= './mysql ';
		}

		unset($sql_root);
	}

	// E-mail data
	if ($data['backup_mail'] == 1) {

		$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'Creating mail-folder "'.makeCorrectDir($tmpdir . '/mail').'"');
		safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir($tmpdir . '/mail')));

		// get all customer mail-accounts
		$sel_stmt = Database::prepare("SELECT `homedir`, `maildir` FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid` = :cid");
		Database::pexecute($sel_stmt, array(
			'cid' => $data['customerid']
		));

		$tar_file_list = "";
		$mail_homedir = "";
		while ($row = $sel_stmt->fetch()) {
			$tar_file_list .= escapeshellarg("./".$row['maildir']) . " ";
			$mail_homedir = $row['homedir'];
		}

		if (! empty($tar_file_list)) {
			$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'shell> tar cfvz ' . escapeshellarg(makeCorrectFile($tmpdir . '/mail/' . $data['loginname'] . '-mail.tar.gz')) . ' -C '.escapeshellarg($mail_homedir) . ' ' . trim($tar_file_list));
			safe_exec('tar cfz ' . escapeshellarg(makeCorrectFile($tmpdir . '/mail/' . $data['loginname'] . '-mail.tar.gz')) . ' -C '.escapeshellarg($mail_homedir) . ' ' . trim($tar_file_list));
			$create_backup_tar_data .= './mail ';
		}
	}

	// Web data
	if ($data['backup_web'] == 1) {

		$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'Creating web-folder "'.makeCorrectDir($tmpdir . '/web').'"');
		safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir($tmpdir . '/web')));
		$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'shell> tar cfz ' . escapeshellarg(makeCorrectFile($tmpdir . '/web/' . $data['loginname'] . '-web.tar.gz')) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", makeCorrectFile($tmpdir.'/*'))) .' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", substr(makeCorrectDir($tmpdir), 0, -1))) .' -C '.escapeshellarg($customerdocroot). ' .');
		safe_exec('tar cfz ' . escapeshellarg(makeCorrectFile($tmpdir . '/web/' . $data['loginname'] . '-web.tar.gz')) . ' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", makeCorrectFile($tmpdir.'/*'))) .' --exclude=' . escapeshellarg(str_replace($customerdocroot, "./", substr(makeCorrectFile($tmpdir), 0, -1))) .' -C '.escapeshellarg($customerdocroot).' .');
		$create_backup_tar_data .= './web ';
	}

	if (!empty($create_backup_tar_data))
	{
		$backup_file = makeCorrectFile($tmpdir . '/' . $data['loginname'] . '-backup_' . date('YmdHi', time()) . '.tar.gz');
		$cronlog->logAction(CRON_ACTION, LOG_INFO, 'Creating backup-file "'.$backup_file.'"');
		// pack all archives in tmp-dir to one
		$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'shell> tar cfz ' . escapeshellarg($backup_file) . ' -C '.escapeshellarg($tmpdir).' '.trim($create_backup_tar_data));
		safe_exec('tar cfz ' . escapeshellarg($backup_file) . ' -C '.escapeshellarg($tmpdir).' '.trim($create_backup_tar_data));
		// move to destination directory
		$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'shell> mv ' . escapeshellarg($backup_file) . ' ' . escapeshellarg($data['destdir']));
		safe_exec('mv ' . escapeshellarg($backup_file) . ' ' . escapeshellarg($data['destdir']));
		// remove tmp-files
		$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'shell> rm -rf '.escapeshellarg($tmpdir));
		safe_exec('rm -rf '.escapeshellarg($tmpdir));
		// set owner to customer
		$cronlog->logAction(CRON_ACTION, LOG_DEBUG, 'shell> chown -R ' . (int)$data['uid'] . ':' . (int)$data['gid'] . ' ' . escapeshellarg($data['destdir']));
		safe_exec('chown -R ' . (int)$data['uid'] . ':' . (int)$data['gid'] . ' ' . escapeshellarg($data['destdir']));
	}
}
