<?php

namespace Froxlor\Backup\Storages;

use Exception;
use Froxlor\FileDir;

class Local extends Storage
{

	/**
	 * @throws Exception
	 */
	public function init(): bool
	{
		// create destination_path
		if (!file_exists($this->getDestinationDirectory())) {
			return mkdir($this->getDestinationDirectory(), 0700, true);
		}
		return true;
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
		if (file_exists($source) && !file_exists($target)) {
			rename($source, $target);
			return $target;
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
		$target = FileDir::makeCorrectFile($this->getDestinationDirectory() . "/" . $filename);
		if (file_exists($target)) {
			return @unlink($target);
		}
		return true;
	}

	/**
	 * @return bool
	 */
	public function shutdown(): bool
	{
		return true;
	}
}
