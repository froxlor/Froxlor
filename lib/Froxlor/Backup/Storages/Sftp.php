<?php

namespace Froxlor\Backup\Storages;

use Exception;
use Froxlor\FileDir;
use phpseclib3\Net\SFTP as secSFTP;

class Sftp extends Storage
{
	private secSFTP $sftp_client;

	/**
	 * @return bool
	 */
	public function init(): bool
	{
		$hostname = $this->sData['storage']['hostname'] ?? '';
		$username = $this->sData['storage']['username'] ?? '';
		$password = $this->sData['storage']['password'] ?? '';
		if (!empty($hostname) && !empty($username) && !empty($password)) {
			$tmp = explode(":", $hostname);
			$hostname = $tmp[0];
			$port = $tmp[1] ?? 22;
			$this->sftp_client = new secSFTP($hostname, $port);
			if ($this->sftp_client->isConnected()) {
				// @todo login by either user/passwd or user/ssh-key
				return true;
			}
			return false;
		}
		throw new Exception('Empty hostname for FTP backup storage');
	}

	/**
	 * Move/Upload file from tmp-source-directory. The file should be moved or deleted afterward.
	 * Must return the (relative) path including filename to the backup.
	 *
	 * @param string $filename
	 * @param string $tmp_source_directory
	 * @return string
	 * @throws Exception
	 */
	protected function putFile(string $filename, string $tmp_source_directory): string
	{
		$source = FileDir::makeCorrectFile($tmp_source_directory . "/" . $filename);
		$target = FileDir::makeCorrectFile($this->getDestinationDirectory() . "/" . $filename);
		$this->sftp_client->put($target, $source, secSFTP::SOURCE_LOCAL_FILE);
	}

	/**
	 * @param string $filename
	 * @return bool
	 * @throws Exception
	 */
	protected function rmFile(string $filename): bool
	{
		$target = FileDir::makeCorrectFile($this->getDestinationDirectory() . "/" . $filename);
		if ($this->sftp_client->file_exists($target)) {
			return $this->sftp_client->delete($target);
		}
		return false;
	}

	/**
	 * @return bool
	 */
	public function shutdown(): bool
	{
		$this->sftp_client->disconnect();
		return true;
	}
}
