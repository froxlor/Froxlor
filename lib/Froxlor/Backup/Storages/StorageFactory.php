<?php

namespace Froxlor\Backup\Storages;

use Exception;
use Froxlor\Database\Database;

class StorageFactory
{
	public static function fromType(string $type, array $storage_data): Storage
	{
		$type = "\\Froxlor\\Backup\\Storages\\" . ucfirst($type);
		return new $type($storage_data);
	}

	/**
	 * @throws Exception
	 */
	public static function fromStorageId(int $storage_id, array $user_data): Storage
	{
		$storage = self::readStorageData($storage_id);
		$storage_data = $user_data;
		$storage_data['storage'] = $storage;
		return self::fromType($storage['type'], $storage_data);
	}

	/**
	 * @throws Exception
	 */
	private static function readStorageData(int $storage_id): array
	{
		$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_BACKUP_STORAGES . "` WHERE `id` = :bid");
		$storage = Database::pexecute_first($stmt, ['bid' => $storage_id]);
		if (empty($storage)) {
			throw new Exception("Invalid/empty backup-storage. Unable to continue");
		}
		return $storage;
	}
}
