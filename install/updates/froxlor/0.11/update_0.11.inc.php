<?php

use Froxlor\Database\Database;
use Froxlor\Settings;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Install
 *
 */
if (!defined('_CRON_UPDATE')) {
	if (!defined('AREA') || (defined('AREA') && AREA != 'admin') || !isset($userinfo['loginname']) || (isset($userinfo['loginname']) && $userinfo['loginname'] == '')) {
		header('Location: ../../../../index.php');
		exit();
	}
}

// last 0.10.x release
if (\Froxlor\Froxlor::isFroxlorVersion('0.10.99')) {
	showUpdateStep("Updating from 0.10.99 to 0.11.0-rc1", false);

	showUpdateStep("Removing unused table");
	Database::query("DROP TABLE IF EXISTS `panel_sessions`;");
	lastStepStatus(0);

	showUpdateStep("Updating froxlor - theme");
	Database::query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `theme` = 'Froxlor' WHERE `theme` <> 'Froxlor';");
	Database::query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `theme` = 'Froxlor' WHERE `theme` <> 'Froxlor';");
	Settings::Set('panel.default_theme', 'Froxlor');
	lastStepStatus(0);

	showUpdateStep("Cleaning up old files");
	$to_clean = array(
		"templates/Sparkle",
	);
	$disabled = explode(',', ini_get('disable_functions'));
	$exec_allowed = ! in_array('exec', $disabled);
	$del_list = "";
	foreach ($to_clean as $filedir) {
		$complete_filedir = \Froxlor\Froxlor::getInstallDir() . $filedir;
		if (file_exists($complete_filedir)) {
			if ($exec_allowed) {
				Froxlor\FileDir::safe_exec("rm -rf " . escapeshellarg($complete_filedir));
			} else {
				$del_list .= "rm -rf " . escapeshellarg($complete_filedir) . PHP_EOL;
			}
		}
	}
	if ($exec_allowed) {
		lastStepStatus(0);
	} else {
		if (empty($del_list)) {
			// none of the files existed
			lastStepStatus(0);
		} else {
			lastStepStatus(1, 'manual commands needed');
			echo '<span class="update-step update-step-err">Please run the following commands manually:</span><br><pre>' . $del_list . '</pre><br>';
		}
	}
}
