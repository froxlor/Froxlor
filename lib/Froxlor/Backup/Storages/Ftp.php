<?php

namespace Froxlor\Backup\Storages;

use Exception;
use Froxlor\FileDir;

class Ftp extends Storage
{
	private $ftp_conn = null;

	/**
	 * @return bool
	 * @throws Exception
	 */
	public function init(): bool
	{
		$hostname = $this->sData['storage']['hostname'] ?? '';
		$username = $this->sData['storage']['username'] ?? '';
		$password = $this->sData['storage']['password'] ?? '';
		if (!empty($hostname) && !empty($username) && !empty($password)) {
			$tmp = explode(":", $hostname);
			$hostname = $tmp[0];
			$port = $tmp[1] ?? 21;
			$this->ftp_conn = ftp_connect($hostname, $port);
			if ($this->ftp_conn === false) {
				throw new Exception('Unable to connect to ftp-server "' . $hostname . ':' . $port . '"');
			}
			if (!ftp_login($this->ftp_conn, $username, $password)) {
				throw new Exception('Unable to login to ftp-server "' . $hostname . ':' . $port . '"');
			}
			return $this->changeToCorrectDirectory();
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
		if (file_exists($source) && ftp_size($this->ftp_conn, $filename) == -1) {
			if (ftp_put($this->ftp_conn, $filename, $source, FTP_BINARY)) {
				return FileDir::makeCorrectFile($this->getDestinationDirectory() . '/' . $filename);
			}
		}
		return "";
	}

	/**
	 * @param string $filename
	 * @return bool
	 * @throws Exception
	 */
	protected function rmFile(string $filename): bool
	{
		$target = basename($filename);
		if (ftp_size($this->ftp_conn, $target) >= 0) {
			return ftp_delete($this->ftp_conn, $target);
		}
		return true;
	}

	/**
	 * @return bool
	 */
	public function shutdown(): bool
	{
		return ftp_close($this->ftp_conn);
	}

	/**
	 * @return bool
	 * @throws Exception
	 */
	private function changeToCorrectDirectory(): bool
	{
		$dirs = explode("/", $this->getDestinationDirectory());
		array_shift($dirs);
		if (count($dirs) > 0 && !empty($dirs[0])) {
			foreach ($dirs as $dir) {
				if (empty($dir)) {
					continue;
				}
				if (!@ftp_chdir($this->ftp_conn, $dir)) {
					ftp_mkdir($this->ftp_conn, $dir);
					ftp_chmod($this->ftp_conn, 0700, $dir);
					ftp_chdir($this->ftp_conn, $dir);
				}
			}
			return true;
		}
		return ftp_chdir($this->ftp_conn, "/");
	}
}
