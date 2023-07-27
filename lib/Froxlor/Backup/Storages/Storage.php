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

	public function __construct(array $storage_data)
	{
		$this->sData = $storage_data;
		$this->tmpDirectory = sys_get_temp_dir();
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
	 */
	public function prepareFiles(): void
	{
		$this->filesToStore = [];

		// create archive of web, mail and database data

		// create json-info-file
	}

	/**
	 * @param string $filename
	 * @param string $tmp_source_directory
	 * @return bool
	 */
	abstract protected function putFile(string $filename, string $tmp_source_directory): bool;

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

		$filename = FileDir::makeCorrectFile("/backup-" . $this->sData['loginname'] . "-" . date('c') . ".tar.gz");

		// @todo create archive $filename from $filesToStore

		// determine filesize (use stat locally here b/c files are possibly large and php's filesize() can't handle them)
		$sizeCheckFile = FileDir::makeCorrectFile($this->tmpDirectory . "/" . $filename);
		$fileSizeOutput = FileDir::safe_exec('/usr/bin/stat -c "%s" ' . escapeshellarg($sizeCheckFile));
		$fileSize = (int)array_shift($fileSizeOutput);

		// add entry to database and upload/store file
		$this->addEntry($filename, $fileSize);
		return $this->putFile($filename, $this->tmpDirectory);
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
