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
use Froxlor\Froxlor;
use Froxlor\Install\Update;
use Froxlor\Settings;

if (!defined('_CRON_UPDATE')) {
	if (!defined('AREA') || (defined('AREA') && AREA != 'admin') || !isset($userinfo['loginname']) || (isset($userinfo['loginname']) && $userinfo['loginname'] == '')) {
		header('Location: ../../../../index.php');
		exit();
	}
}

if (Froxlor::isFroxlorVersion('2.1.9')) {
	Update::showUpdateStep("Enhancing virtual email table");
	Database::query("ALTER TABLE `" . TABLE_MAIL_VIRTUAL . "` ADD `spam_tag_level` float(4,1) NOT NULL DEFAULT 7.0;");
	Database::query("ALTER TABLE `" . TABLE_MAIL_VIRTUAL . "` ADD `spam_kill_level` float(4,1) NOT NULL DEFAULT 14.0;");
	Database::query("ALTER TABLE `" . TABLE_MAIL_VIRTUAL . "` ADD `bypass_spam` tinyint(1) NOT NULL default '0';");
	Database::query("ALTER TABLE `" . TABLE_MAIL_VIRTUAL . "` ADD `policy_greylist` tinyint(1) NOT NULL default '1';");
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adjusting settings");
	$antispam_activated = $_POST['antispam_activated'] ?? 0;
	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `settinggroup` = 'antispam', `varname` = 'activated', `value` = '" . (int)$antispam_activated . "' WHERE `settinggroup` = 'dkim' AND `varname` = 'use_dkim';");
	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `settinggroup` = 'antispam', `varname` = 'reload_command', `value` = 'service rspamd restart' WHERE `settinggroup` = 'dkim' AND `varname` = 'dkimrestart_command';");
	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `settinggroup` = 'antispam', `varname` = 'config_file', `value` = '/etc/rspamd/local.d/froxlor_settings.conf' WHERE `settinggroup` = 'dkim' AND `varname` = 'dkim_prefix';");
	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `settinggroup` = 'antispam' WHERE `settinggroup` = 'dkim' AND `varname` = 'dkim_keylength';");
	Settings::AddNew("dmarc.use_dmarc", "0");
	Settings::AddNew("dmarc.dmarc_entry", "v=DMARC1; p=none;");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'dkim' AND `varname` = 'privkeysuffix';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'dkim' AND `varname` = 'dkim_domains';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'dkim' AND `varname` = 'dkim_algorithm';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'dkim' AND `varname` = 'dkim_notes';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'dkim' AND `varname` = 'dkim_add_adsp';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'dkim' AND `varname` = 'dkim_dkimkeys';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'dkim' AND `varname` = 'dkim_servicetype';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'dkim' AND `varname` = 'dkim_add_adsppolicy';");
	Update::lastStepStatus(0);

	if ($antispam_activated) {
		Update::showUpdateStep("Converting existing domainkeys");
		$sel_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `dkim` = '1' AND `dkim_pubkey` <> ''");
		Database::pexecute($sel_stmt);
		$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `dkim_pubkey` = :pkey WHERE `id` = :did");
		while ($domain = $sel_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$pubkey = trim(preg_replace(
				'/-----BEGIN PUBLIC KEY-----(.+)-----END PUBLIC KEY-----/s',
				'$1',
				str_replace("\n", '', $domain['dkim_pubkey'])
			));
			Database::pexecute($upd_stmt, ['pkey' => $pubkey, 'did' => $domain['id']]);
		}
		Update::lastStepStatus(0);

		Update::showUpdateStep("Configure antispam services");
		$froxlorCliBin = Froxlor::getInstallDir() . '/bin/froxlor-cli';
		$currentDistro = Settings::Get('system.distribution');
		$manual_command = <<<EOC
{$froxlorCliBin} froxlor:config-services -a '{"http":"x","dns":"x","smtp":"x","mail":"x","antispam":"rspamd","ftp":"x","distro":"{$currentDistro}","system":[]}'
EOC;
		Update::lastStepStatus(
			1,
			'manual action needed',
			"Please run the following command manually as root:<br><pre>" . $manual_command . "</pre>"
		);
	} else {
		Update::showUpdateStep("Removing existing domainkeys because antispam is disabled");
		Database::query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `dkim` = '0', `dkim_id` = '0', `dkim_privkey` = '', `dkim_pubkey` = '' WHERE `dkim` = '1';");
		Update::lastStepStatus(1, '!!!');
	}

	Update::showUpdateStep("Enhancing admin and user table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `gui_access` tinyint(1) NOT NULL default '1';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `gui_access` tinyint(1) NOT NULL default '1';");
	Update::lastStepStatus(0);

	$to_clean = [
		'actions/admin/settings/180.dkim.php',
		'actions/admin/settings/185.spf.php',
	];
	Update::cleanOldFiles($to_clean);

	Froxlor::updateToDbVersion('202312230');
	Froxlor::updateToVersion('2.2.0-dev1');
}

if (Froxlor::isDatabaseVersion('202312230')) {

	Update::showUpdateStep("Adding new settings");
	Settings::AddNew("system.le_renew_services", "");
	Settings::AddNew("system.le_renew_hook", "systemctl restart postfix dovecot proftpd");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202401090');
}

if (Froxlor::isFroxlorVersion('2.2.0-dev1')) {
	Update::showUpdateStep("Updating from 2.2.0-dev1 to 2.2.0-rc1", false);
	Froxlor::updateToVersion('2.2.0-rc1');
}

if (Froxlor::isDatabaseVersion('202401090')) {

	Update::showUpdateStep("Adding new table for 2fa tokens");
	Database::query("DROP TABLE IF EXISTS `panel_2fa_tokens`;");
	$sql = "CREATE TABLE `panel_2fa_tokens` (
	  `id` int(11) NOT NULL auto_increment,
	  `selector` varchar(20) NOT NULL,
	  `token` varchar(200) NOT NULL,
	  `userid` int(11) NOT NULL default '0',
	  `valid_until` int(15) NOT NULL,
	  PRIMARY KEY  (id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
	Database::query($sql);
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202407200');
}

if (Froxlor::isFroxlorVersion('2.2.0-rc1')) {
	Update::showUpdateStep("Updating from 2.2.0-rc1 to 2.2.0-rc2", false);
	Froxlor::updateToVersion('2.2.0-rc2');
}
