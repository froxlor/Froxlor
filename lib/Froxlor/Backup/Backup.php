<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Backup;

use Froxlor\Database\Database;
use PDO;

class Backup
{
	/**
	 * returns an array of existing backup-storages
	 * in our database for the settings-array
	 *
	 * @return array
	 */
	public static function getBackupStorages(): array
	{
		$storages_array = [
			0 => lng('backup.storage_none')
		];
		// get all storages
		$result_stmt = Database::query("SELECT id, type, description FROM `" . TABLE_PANEL_BACKUP_STORAGES . "` ORDER BY type, description");
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (!isset($storages_array[$row['id']]) && !in_array($row['id'], $storages_array)) {
				$storages_array[$row['id']] = "[" . $row['type'] . "] " . html_entity_decode($row['description']);
			}
		}
		return $storages_array;
	}
}
