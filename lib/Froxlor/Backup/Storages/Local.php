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
	 * @param string $filename
	 * @param string $tmp_source_directory
	 * @return bool
	 * @throws Exception
	 */
	protected function putFile(string $filename, string $tmp_source_directory): bool
	{
		$source = FileDir::makeCorrectFile($tmp_source_directory . "/" . $filename);
		$target = FileDir::makeCorrectFile($this->getDestinationDirectory() . "/" . $filename);
		if (file_exists($source) && !file_exists($target)) {
			return rename($source, $target);
		}
		return false;
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
