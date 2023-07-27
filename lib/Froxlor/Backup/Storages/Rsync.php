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
	 * @param string $filename
	 * @param string $tmp_source_directory
	 * @return bool
	 */
	protected function putFile(string $filename, string $tmp_source_directory): bool
	{
		// TODO: Implement putFiles() method.
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
