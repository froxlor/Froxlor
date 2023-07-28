<?php

namespace Froxlor\Backup\Storages;

class Rsync extends Storage
{

	/**
	 * @return bool
	 */
	public function init(): bool
	{
		// TODO: Implement init() method.
	}

	/**
	 * Move/Upload file from tmp-source-directory. The file should be moved or deleted afterward.
	 * Must return the (relative) path including filename to the backup.
	 *
	 * @param string $filename
	 * @param string $tmp_source_directory
	 * @return string
	 */
	protected function putFile(string $filename, string $tmp_source_directory): string
	{
		return "";
	}

	/**
	 * @param string $filename
	 * @return bool
	 */
	protected function rmFile(string $filename): bool
	{
		// TODO: Implement removeOld() method.
	}

	/**
	 * @return bool
	 */
	public function shutdown(): bool
	{
		return true;
	}
}
