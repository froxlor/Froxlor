<?php

namespace Froxlor\Backup\Storages;

class StorageFactory
{
	public static function fromType(string $type, array $storage_data): Storage
	{
		$type = "\\Froxlor\\Backup\\Storages\\" . ucfirst($type);
		return new $type($storage_data);
	}
}
