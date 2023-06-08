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

namespace Froxlor\Cron\Backup;

use Froxlor\Cron\Forkable;
use Froxlor\Cron\FroxlorCron;
use Froxlor\Database\Database;
use Froxlor\FroxlorLogger;
use Froxlor\Settings;
use PDO;

class BackupCron extends FroxlorCron
{
	use Forkable;

	public static function run()
	{
		if(!Settings::Get('backup.enabled')) {
			FroxlorLogger::getInstanceOf()->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'BackupCron: disabled - exiting');
			return -1;
		}

		$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_BACKUP_STORAGES . "`");
		Database::pexecute($stmt);

		$storages = [];
		while ($storage = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$storages[$storage['id']] = $storage;
		}

		$stmt = Database::prepare("SELECT
			customerid,
		    loginname,
		    adminid,
		    backup,
		    guid,
		    documentroot
			FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `backup` > 0
		");
		Database::pexecute($stmt);

		$customers = [];
		while ($customer = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$customer['storage'] = $storages[$customer['backup']];
			$customers[] = $customer;
		}

		self::runFork([self::class, 'handle'], $customers);
	}

	private static function handle(array $userdata)
	{
		echo "BackupCron: started - creating customer backup for user " . $userdata['loginname'] . "\n";

		echo json_encode($userdata['storage']) . "\n";

		echo "BackupCron: finished - creating customer backup for user " . $userdata['loginname'] . "\n";
	}
}
