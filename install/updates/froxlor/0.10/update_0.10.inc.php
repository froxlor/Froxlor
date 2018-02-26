<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Install
 *
 */
if (! defined('_CRON_UPDATE')) {
	if (! defined('AREA') || (defined('AREA') && AREA != 'admin') || ! isset($userinfo['loginname']) || (isset($userinfo['loginname']) && $userinfo['loginname'] == '')) {
		header('Location: ../../../../index.php');
		exit();
	}
}

if (isFroxlorVersion('0.9.39.5')) {
	showUpdateStep("Updating from 0.9.39.5 to 0.10.0", false);
	updateToVersion('0.10.0');
}

if (isFroxlorVersion('0.10.0')) {
	showUpdateStep("Adding new api keys table");
	Database::query("DROP TABLE IF EXISTS `api_keys`;");
	$sql = "CREATE TABLE `api_keys` (
	  `id` int(11) NOT NULL auto_increment,
	  `adminid` int(11) NOT NULL default '0',
	  `customerid` int(11) NOT NULL default '0',
	  `apikey` varchar(500) NOT NULL default '',
	  `secret` varchar(500) NOT NULL default '',
	  `allowed_from` text NOT NULL,
	  `valid_until` int(15) NOT NULL default '0',
	  PRIMARY KEY  (id),
	  KEY adminid (adminid),
	  KEY customerid (customerid)
	) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;";
	Database::query($sql);
	lastStepStatus(0);

	showUpdateStep("Adding new api settings");
	Settings::AddNew('api.enabled', 0);
	lastStepStatus(0);

	showUpdateStep("Adding new default-ssl-ip setting");
	Settings::AddNew('system.defaultsslip', '');
	lastStepStatus(0);

	showUpdateStep("Altering admin ip's field to allow multiple ip addresses");
	// get all admins for updating the new field
	$sel_stmt = Database::prepare("SELECT adminid, ip FROM `panel_admins`");
	Database::pexecute($sel_stmt);
	$all_admins = $sel_stmt->fetchAll(PDO::FETCH_ASSOC);
	Database::query("ALTER TABLE `panel_admins` MODIFY `ip` varchar(500) NOT NULL default '-1';");
	$upd_stmt = Database::prepare("UPDATE `panel_admins` SET `ip` = :ip WHERE `adminid` = :adminid");
	foreach ($all_admins as $adm) {
		if ($admin['ip'] != -1) {
			Database::pexecute($upd_stmt, array('ip' => json_encode($adm['ip']), 'adminid' => $adm['adminid']));
		}
	}
	lastStepStatus(0);
}
