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

use Froxlor\Database\Database;
use Froxlor\Database\DbManager;
use Froxlor\Froxlor;
use Froxlor\FroxlorLogger;
use Froxlor\Install\Update;
use Froxlor\Settings;

if (!defined('_CRON_UPDATE')) {
	if (!defined('AREA') || (defined('AREA') && AREA != 'admin') || !isset($userinfo['loginname']) || (isset($userinfo['loginname']) && $userinfo['loginname'] == '')) {
		header('Location: ../../../../index.php');
		exit();
	}
}

if (Froxlor::isDatabaseVersion('202412030')) {
	Update::showUpdateStep("Enhancing customer table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `shell_allowed` tinyint(1) NOT NULL DEFAULT 0;");
	Update::lastStepStatus(0);

	if (Settings::Get('system.allow_customer_shell') == '1') {
		Update::showUpdateStep("Allowing shell-usage to current customers as setting is globally enabled");
		Database::query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `shell_allowed` = '1';");
		Update::lastStepStatus(0);
	}

	Froxlor::updateToDbVersion('202508310');

	Update::showUpdateStep("Updating from 2.2.8 to 2.3.0-dev1", false);
	Froxlor::updateToVersion('2.3.0-dev1');
}
