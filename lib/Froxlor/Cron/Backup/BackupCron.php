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

class BackupCron extends FroxlorCron
{
	use Forkable;

	public static function run()
	{
		$users = ['web1', 'web2', 'web3', 'web4', 'web5', 'web6', 'web7', 'web8', 'web9', 'web10'];

		self::runFork([self::class, 'handle'], [
			[
				'user' => '1',
				'data' => 'value1',
			],
			[
				'user' => '2',
				'data' => 'value2',
			]
		]);
	}

	private static function handle($user, $data)
	{
		echo "BackupCron: started - creating customer backup for user $user\n";

		echo $data . "\n";

		sleep(rand(1, 3));

		echo "BackupCron: finished - creating customer backup for user $user\n";
	}
}
