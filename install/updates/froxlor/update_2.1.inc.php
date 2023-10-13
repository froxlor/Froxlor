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
use Froxlor\FileDir;
use Froxlor\Froxlor;
use Froxlor\Install\Update;
use Froxlor\Settings;

if (!defined('_CRON_UPDATE')) {
	if (!defined('AREA') || (defined('AREA') && AREA != 'admin') || !isset($userinfo['loginname']) || (isset($userinfo['loginname']) && $userinfo['loginname'] == '')) {
		header('Location: ../../../../index.php');
		exit();
	}
}

if (Froxlor::isFroxlorVersion('2.0.24')) {
	Update::showUpdateStep("Cleaning domains table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` DROP COLUMN `ismainbutsubto`;");
	Update::lastStepStatus(0);

	Update::showUpdateStep("Creating new tables and fields");
	Database::query("DROP TABLE IF EXISTS `panel_loginlinks`;");
	$sql = "CREATE TABLE `panel_loginlinks` (
	  `hash` varchar(500) NOT NULL,
	  `loginname` varchar(50) NOT NULL,
	  `valid_until` int(15) NOT NULL,
	  `allowed_from` text NOT NULL,
	  UNIQUE KEY `loginname` (`loginname`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
	Database::query($sql);
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adding new settings");
	Settings::AddNew('panel.menu_collapsed', 1);
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adjusting setting for deactivated webroot");
	$current_deactivated_webroot = Settings::Get('system.deactivateddocroot');
	if (empty($current_deactivated_webroot)) {
		Settings::Set('system.deactivateddocroot', FileDir::makeCorrectDir(Froxlor::getInstallDir() . '/templates/misc/deactivated/'));
		Update::lastStepStatus(0);
	} else {
		Update::lastStepStatus(1, 'Customized setting, not changing');
	}

	Update::showUpdateStep("Adjusting cronjobs");
	Database::query("
        UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET
        `module`= 'froxlor/export',
        `cronfile` = 'export',
        `cronclass` = '\\Froxlor\\Cron\\System\\ExportCron',
        `interval` = '1 HOUR',
        `desc_lng_key` = 'cron_export'
        WHERE `module` = 'froxlor/backup'
    ");
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adjusting system for data-export function");
	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "`SET `varname` = 'exportenabled' WHERE `settinggroup`= 'system' AND `varname`= 'backupenabled'");
	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "`SET `value` = REPLACE(`value`, 'extras.backup', 'extras.export') WHERE `settinggroup` = 'panel' AND `varname` = 'customer_hide_options'");
	Database::query("DELETE FROM `" . TABLE_PANEL_USERCOLUMNS . "` WHERE `section` = 'backup_list'");
	Database::query("DELETE FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = '20'");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202305240');
	Froxlor::updateToVersion('2.1.0-dev1');
}

if (Froxlor::isFroxlorVersion('2.1.0-dev1')) {
	Update::showUpdateStep("Updating from 2.1.0-dev1 to 2.1.0-beta1", false);
	Froxlor::updateToVersion('2.1.0-beta1');
}
