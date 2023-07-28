<?php

namespace Froxlor\Backup\Storages;

use Exception;
use Froxlor\Database\Database;
use Froxlor\FileDir;

abstract class Storage
{
	private string $tmpDirectory;
	protected array $sData;

	protected array $filesToStore;

	/**
	 * @throws Exception
	 */
	public function __construct(array $storage_data)
	{
		$this->sData = $storage_data;
		$this->tmpDirectory = FileDir::makeCorrectDir(sys_get_temp_dir() . '/backup-' . $this->sData['loginname']);
	}

	/**
	 * Validate sData, open connection to target storage, etc.
	 *
	 * @return bool
	 */
	abstract public function init(): bool;

	/**
	 * Disconnect / clean up connection if needed
	 *
	 * @return bool
	 */
	abstract public function shutdown(): bool;

	/**
	 * prepare files to back up (e.g. create archive or similar) and fill $filesToStore
	 *
	 * @return void
	 * @throws Exception
	 */
	public function prepareFiles(): void
	{
		$this->filesToStore = [];

		$tmpdir = FileDir::makeCorrectDir($this->tmpDirectory . '/.tmp/');
		FileDir::safe_exec('mkdir -p ' . escapeshellarg($tmpdir));

		// create archive of web, mail and database data
		$this->prepareWebData();
		$this->prepareDatabaseData();
		$this->prepareMailData();

		// create json-info-file
	}

	/**
	 * @throws Exception
	 */
	private function prepareWebData(): void
	{
		$tmpdir = FileDir::makeCorrectDir($this->tmpDirectory . '/.tmp/web');
		FileDir::safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
		FileDir::safe_exec('tar cfz ' . escapeshellarg(FileDir::makeCorrectFile($tmpdir . '/' . $this->sData['loginname'] . '-web.tar.gz')) . ' -C ' . escapeshellarg($this->sData['documentroot']) . ' .');
		$this->filesToStore[] = FileDir::makeCorrectFile($tmpdir . '/' . $this->sData['loginname'] . '-web.tar.gz');
	}

	/**
	 * @throws Exception
	 */
	private function prepareDatabaseData(): void
	{
		$tmpdir = FileDir::makeCorrectDir($this->tmpDirectory . '/.tmp/mysql');
		FileDir::safe_exec('mkdir -p ' . escapeshellarg($tmpdir));

		// get all customer database-names
		$sel_stmt = Database::prepare("
			SELECT `databasename`, `dbserver` FROM `" . TABLE_PANEL_DATABASES . "`
			WHERE `customerid` = :cid ORDER BY `dbserver`
		");
		Database::pexecute($sel_stmt, [
			'cid' => $this->sData['customerid']
		]);

		$has_dbs = false;
		$current_dbserver = -1;
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
			$bool_false = false;
			FileDir::safe_exec('mysqldump --defaults-file=' . escapeshellarg($mysqlcnf_file) . ' -u ' . escapeshellarg($sql_root['user']) . ' ' . $row['databasename'] . ' > ' . FileDir::makeCorrectFile($tmpdir . '/' . $row['databasename'] . '_' . date('YmdHi', time()) . '.sql'), $bool_false, [
				'>'
			]);
			$has_dbs = true;
			$current_dbserver = $row['dbserver'];
		}

		if ($has_dbs) {
			$this->filesToStore[] = $tmpdir;
		}

		if (@file_exists($mysqlcnf_file)) {
			@unlink($mysqlcnf_file);
		}
	}

	private function prepareMailData(): void
	{
		$tmpdir = FileDir::makeCorrectDir($this->tmpDirectory . '/.tmp/mail');
		FileDir::safe_exec('mkdir -p ' . escapeshellarg($tmpdir));

		// get all customer mail-accounts
		$sel_stmt = Database::prepare("
			SELECT `homedir`, `maildir` FROM `" . TABLE_MAIL_USERS . "`
			WHERE `customerid` = :cid
		");
		Database::pexecute($sel_stmt, [
			'cid' => $this->sData['customerid']
		]);

		$tar_file_list = "";
		$mail_homedir = "";
		while ($row = $sel_stmt->fetch()) {
			$tar_file_list .= escapeshellarg("./" . $row['maildir']) . " ";
			if (empty($mail_homedir)) {
				// this should be equal for all entries
				$mail_homedir = $row['homedir'];
			}
		}

		if (!empty($tar_file_list)) {
			FileDir::safe_exec('tar cfz ' . escapeshellarg(FileDir::makeCorrectFile($tmpdir . '/' . $this->sData['loginname'] . '-mail.tar.gz')) . ' -C ' . escapeshellarg($mail_homedir) . ' ' . trim($tar_file_list));
			$this->filesToStore[] = FileDir::makeCorrectFile($tmpdir . '/' . $this->sData['loginname'] . '-mail.tar.gz');
		}
	}

	/**
	 * Move/Upload file from tmp-source-directory. The file should be moved or deleted afterward.
	 * Must return the (relative) path including filename to the backup.
	 *
	 * @param string $filename
	 * @param string $tmp_source_directory
	 * @return string
	 */
	abstract protected function putFile(string $filename, string $tmp_source_directory): string;

	/**
	 * @param string $filename
	 * @return bool
	 */
	abstract protected function rmFile(string $filename): bool;

	/**
	 * @return bool
	 * @throws Exception
	 */
	public function removeOld(): bool
	{
		// retention in days
		$retention = $this->sData['storage']['retention'] ?? 3;
		// keep date
		$keepDate = new \DateTime();
		$keepDate->setTime(0, 0, 0, 1);
		// subtract retention days
		$keepDate->sub(new \DateInterval('P' . $retention . 'D'));
		// select target backups to remove for this storage-id and customer
		$sel_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_BACKUPS . "`
			WHERE `created_at` < :keepdate
			AND `storage_id` = :sid
			AND `customerid` = :cid
		");
		Database::pexecute($sel_stmt, [
			'keepdate' => $keepDate->format('U'),
			'sid' => $this->sData['backup'],
			'cid' => $this->sData['customerid']
		]);
		while ($oldBackup = $sel_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$this->rmFile($oldBackup['filename']);
		}
	}

	/**
	 * Returns the storage configured destination path for all backups
	 *
	 * @return string
	 * @throws Exception
	 */
	public function getDestinationDirectory(): string
	{
		return FileDir::makeCorrectDir($this->sData['storage']['destination_path'] ?? "/");
	}

	/**
	 * Create backup-archive/file from $filesToStore and call putFile()
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function createFromFiles(): bool
	{
		if (empty($this->filesToStore)) {
			return false;
		}

		$filename = FileDir::makeCorrectFile($this->tmpDirectory . "/backup-" . $this->sData['loginname'] . "-" . date('c') . ".tar.gz");
		$tmpdir = FileDir::makeCorrectDir($this->tmpDirectory . '/.tmp/');
		$create_export_tar_data = implode(" ", $this->filesToStore);
		FileDir::safe_exec('chown -R ' . (int)$this->sData['guid'] . ':' . (int)$this->sData['guid'] . ' ' . escapeshellarg($tmpdir));

		if (!empty($data['pgp_public_key'])) {
			// pack all archives in tmp-dir to one archive and encrypt it with gpg
			$recipient_file = FileDir::makeCorrectFile($this->tmpDirectory . '/' . $this->sData['loginname'] . '-recipients.gpg');
			file_put_contents($recipient_file, $data['pgp_public_key']);
			$return_value = [];
			FileDir::safe_exec('tar cfz - -C ' . escapeshellarg($tmpdir) . ' ' . trim($create_export_tar_data) . ' | gpg --encrypt --recipient-file ' . escapeshellarg($recipient_file) . ' --output ' . escapeshellarg($filename) . ' --trust-model always --batch --yes', $return_value, ['|']);
		} else {
			// pack all archives in tmp-dir to one archive
			FileDir::safe_exec('tar cfz ' . escapeshellarg($filename) . ' -C ' . escapeshellarg($tmpdir) . ' ' . trim($create_export_tar_data));
		}

		// determine filesize (use stat locally here b/c files are possibly large and php's filesize() can't handle them)
		$fileSizeOutput = FileDir::safe_exec('/usr/bin/stat -c "%s" ' . escapeshellarg($filename));
		$fileSize = (int)array_shift($fileSizeOutput);

		// add entry to database and upload/store file

		FileDir::safe_exec('rm -rf ' . escapeshellarg($tmpdir));
		$fileDest = $this->putFile(basename($filename), $this->tmpDirectory);
		if (!empty($fileDest)) {
			$this->addEntry($fileDest, $fileSize);
			return true;
		}
		return false;
	}

	/**
	 * @param string $filename
	 * @param int $fileSize
	 * @return void
	 * @throws Exception
	 */
	private function addEntry(string $filename, int $fileSize): void
	{
		$ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_BACKUPS . "` SET
			`adminid` = :adminid,
			`customerid` = :customerid,
			`loginname` = :loginname,
			`size` = :size,
			`storage_id` = :sid,
			`filename` = :filename,
			`created_at` = UNIX_TIMESTAMP()
		");
		Database::pexecute($ins_stmt, [
			'adminid' => $this->sData['adminid'],
			'customerid' => $this->sData['customerid'],
			'loginname' => $this->sData['loginname'],
			'size' => $fileSize,
			'sid' => $this->sData['backup'],
			'filename' => $filename
		]);
	}
}
