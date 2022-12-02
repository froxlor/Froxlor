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

use Froxlor\Froxlor;
use Froxlor\FileDir;
use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\Install\Update;
use Froxlor\System\Cronjob;
use Froxlor\System\IPTools;

if (!defined('_CRON_UPDATE')) {
	if (!defined('AREA') || (defined('AREA') && AREA != 'admin') || !isset($userinfo['loginname']) || (isset($userinfo['loginname']) && $userinfo['loginname'] == '')) {
		header('Location: ../../../../index.php');
		exit();
	}
}

if (Froxlor::isFroxlorVersion('0.9.40.1')) {
	Update::showUpdateStep("Updating from 0.9.40.1 to 0.10.0-rc1", false);

	Update::showUpdateStep("Adding new api keys table");
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
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adding new api settings");
	Settings::AddNew('api.enabled', 0);
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adding new default-ssl-ip setting");
	Settings::AddNew('system.defaultsslip', '');
	Update::lastStepStatus(0);

	Update::showUpdateStep("Altering admin ip's field to allow multiple ip addresses");
	// get all admins for updating the new field
	$sel_stmt = Database::prepare("SELECT adminid, ip FROM `panel_admins`");
	Database::pexecute($sel_stmt);
	$all_admins = $sel_stmt->fetchAll(PDO::FETCH_ASSOC);
	Database::query("ALTER TABLE `panel_admins` MODIFY `ip` varchar(500) NOT NULL default '-1';");
	$upd_stmt = Database::prepare("UPDATE `panel_admins` SET `ip` = :ip WHERE `adminid` = :adminid");
	foreach ($all_admins as $adm) {
		if ($adm['ip'] != '-1') {
			Database::pexecute($upd_stmt, array(
				'ip' => json_encode($adm['ip']),
				'adminid' => $adm['adminid']
			));
		}
	}
	Update::lastStepStatus(0);

	Froxlor::updateToVersion('0.10.0-rc1');
}

if (Froxlor::isDatabaseVersion('201809280')) {

	Update::showUpdateStep("Adding dhparams-file setting");
	Settings::AddNew("system.dhparams_file", '');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201811180');
}

if (Froxlor::isDatabaseVersion('201811180')) {

	Update::showUpdateStep("Adding new settings for 2FA");
	Settings::AddNew('2fa.enabled', '1');
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adding new fields to admin-table for 2FA");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `type_2fa` tinyint(1) NOT NULL default '0';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `data_2fa` varchar(500) NOT NULL default '' AFTER `type_2fa`;");
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adding new fields to customer-table for 2FA");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `type_2fa` tinyint(1) NOT NULL default '0';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `data_2fa` varchar(500) NOT NULL default '' AFTER `type_2fa`;");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201811300');
}

if (Froxlor::isDatabaseVersion('201811300')) {

	Update::showUpdateStep("Adding new logview-flag to customers");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `logviewenabled` tinyint(1) NOT NULL default '0';");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201812010');
}

if (Froxlor::isDatabaseVersion('201812010')) {

	Update::showUpdateStep("Adding new is_configured-flag");
	// updated systems are already configured (most likely :P)
	Settings::AddNew('panel.is_configured', '1');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201812100');
}

if (Froxlor::isDatabaseVersion('201812100')) {

	Update::showUpdateStep("Adding fields writeaccesslog and writeerrorlog for domains");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `writeaccesslog` tinyint(1) NOT NULL default '1';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `writeerrorlog` tinyint(1) NOT NULL default '1';");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201812180');
}

if (Froxlor::isDatabaseVersion('201812180')) {

	Update::showUpdateStep("Updating cronjob table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CRONRUNS . "` ADD `cronclass` varchar(500) NOT NULL AFTER `cronfile`");
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `cronclass`  = :cc WHERE `cronfile` = :cf");
	Database::pexecute($upd_stmt, array(
		'cc' => '\\Froxlor\\Cron\\System\\TasksCron',
		'cf' => 'tasks'
	));
	Database::pexecute($upd_stmt, array(
		'cc' => '\\Froxlor\\Cron\\Traffic\\TrafficCron',
		'cf' => 'traffic'
	));
	Database::pexecute($upd_stmt, array(
		'cc' => '\\Froxlor\\Cron\\Traffic\\ReportsCron',
		'cf' => 'usage_report'
	));
	Database::pexecute($upd_stmt, array(
		'cc' => '\\Froxlor\\Cron\\System\\MailboxsizeCron',
		'cf' => 'mailboxsize'
	));
	Database::pexecute($upd_stmt, array(
		'cc' => '\\Froxlor\\Cron\\Http\\LetsEncrypt\\LetsEncrypt',
		'cf' => 'letsencrypt'
	));
	Database::pexecute($upd_stmt, array(
		'cc' => '\\Froxlor\\Cron\\System\\BackupCron',
		'cf' => 'backup'
	));
	Database::query("DELETE FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `module` = 'froxlor/ticket'");
	Update::lastStepStatus(0);

	Update::showUpdateStep("Removing ticketsystem");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `tickets`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `tickets_used`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `tickets_see_all`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `tickets`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `tickets_used`");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'ticket'");

	define('TABLE_PANEL_TICKETS', 'panel_tickets');
	define('TABLE_PANEL_TICKET_CATS', 'panel_ticket_categories');
	Database::query("DROP TABLE IF EXISTS `" . TABLE_PANEL_TICKETS . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_PANEL_TICKET_CATS . "`;");
	Update::lastStepStatus(0);

	Update::showUpdateStep("Updating nameserver settings");
	$dns_target = 'Bind';
	if (Settings::Get('system.dns_server') != 'bind') {
		$dns_target = 'PowerDNS';
	}
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`  = :v WHERE `settinggroup` = 'system' AND `varname` = 'dns_server'");
	Database::pexecute($upd_stmt, array(
		'v' => $dns_target
	));
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201812190');
}

if (Froxlor::isDatabaseVersion('201812190')) {

	Update::showUpdateStep("Adding new webserver error-log-level setting");
	Settings::AddNew('system.errorlog_level', (\Froxlor\Settings::Get('system.webserver') == 'nginx' ? 'error' : 'warn'));
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201902120');
}

if (Froxlor::isDatabaseVersion('201902120')) {

	Update::showUpdateStep("Adding new ECC / ECDSA setting for Let's Encrypt");
	Settings::AddNew('system.leecc', '0');
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `cronclass`  = :cc WHERE `cronfile` = :cf");
	Database::pexecute($upd_stmt, array(
		'cc' => '\\Froxlor\\Cron\\Http\\LetsEncrypt\\AcmeSh',
		'cf' => 'letsencrypt'
	));
	Settings::Set('system.letsencryptkeysize', '4096', true);
	Update::lastStepStatus(0);

	Update::showUpdateStep("Removing current Let's Encrypt certificates due to new implementation of acme.sh");
	$sel_result = Database::query("SELECT id FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `letsencrypt` = '1'");
	$domain_ids = $sel_result->fetchAll(\PDO::FETCH_ASSOC);
	if (count($domain_ids) > 0) {
		$domain_in = "";
		foreach ($domain_ids as $domain_id) {
			$domain_in .= "'" . $domain_id['id'] . "',";
		}
		$domain_in = substr($domain_in, 0, -1);
		Database::query("DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` IN (" . $domain_in . ")");
	}
	// check for froxlor domain using let's encrypt
	if (Settings::Get('system.le_froxlor_enabled') == 1) {
		Database::query("DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` = '0'");
	}
	Update::lastStepStatus(0);

	Update::showUpdateStep("Inserting job to regenerate configfiles");
	Cronjob::inserttask('1');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201902170');
}

if (Froxlor::isDatabaseVersion('201902170')) {

	Update::showUpdateStep("Adding new froxlor vhost domain alias setting");
	Settings::AddNew('system.froxloraliases', "");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201902210');
}

if (Froxlor::isDatabaseVersion('201902210')) {

	// set correct version for people that have tested 0.10.0 before
	Froxlor::updateToVersion('0.10.0-rc1');
	Froxlor::updateToDbVersion('201904100');
}

if (Froxlor::isDatabaseVersion('201904100')) {

	Update::showUpdateStep("Converting all MyISAM tables to InnoDB");
	Database::needRoot(true);
	Database::needSqlData();
	$sql_data = Database::getSqlData();
	$result = Database::query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . $sql_data['db'] . "' AND ENGINE = 'MyISAM'");
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		Database::query("ALTER TABLE `" . $row['TABLE_NAME'] . "` ENGINE=INNODB");
	}
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201904250');
}

if (Froxlor::isFroxlorVersion('0.10.0-rc1')) {
	Update::showUpdateStep("Updating from 0.10.0-rc1 to 0.10.0-rc2", false);
	Froxlor::updateToVersion('0.10.0-rc2');
}

if (Froxlor::isDatabaseVersion('201904250')) {

	Update::showUpdateStep("Adding new settings for CAA");
	Settings::AddNew('caa.caa_entry', '');
	Settings::AddNew('system.dns_createcaaentry', 1);
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201907270');
}

if (Froxlor::isDatabaseVersion('201907270')) {

	Update::showUpdateStep("Cleaning up old files");
	$to_clean = array(
		"actions/admin/settings/000.version.php",
		"actions/admin/settings/190.ticket.php",
		"admin_tickets.php",
		"customer_tickets.php",
		"install/scripts/language-check.php",
		"install/updates/froxlor/upgrade_syscp.inc.php",
		"lib/classes",
		"lib/configfiles/precise.xml",
		"lib/cron_init.php",
		"lib/cron_shutdown.php",
		"lib/formfields/admin/tickets",
		"lib/formfields/customer/tickets",
		"lib/functions.php",
		"lib/functions",
		"lib/navigation/10.tickets.php",
		"scripts/classes",
		"scripts/jobs",
		"templates/Sparkle/admin/tickets",
		"templates/Sparkle/customer/tickets"
	);
	$disabled = explode(',', ini_get('disable_functions'));
	$exec_allowed = !in_array('exec', $disabled);
	$del_list = "";
	foreach ($to_clean as $filedir) {
		$complete_filedir = Froxlor::getInstallDir() . $filedir;
		if (file_exists($complete_filedir)) {
			if ($exec_allowed) {
				FileDir::safe_exec("rm -rf " . escapeshellarg($complete_filedir));
			} else {
				$del_list .= "rm -rf " . escapeshellarg($complete_filedir) . PHP_EOL;
			}
		}
	}
	if ($exec_allowed) {
		Update::lastStepStatus(0);
	} else {
		if (empty($del_list)) {
			// none of the files existed
			Update::lastStepStatus(0);
		} else {
			Update::lastStepStatus(1, 'manual commands needed', 'Please run the following commands manually:<br><pre>' . $del_list . '</pre>');
		}
	}

	Froxlor::updateToDbVersion('201909150');
}

if (Froxlor::isFroxlorVersion('0.10.0-rc2')) {
	Update::showUpdateStep("Updating from 0.10.0-rc2 to 0.10.0 final", false);
	Froxlor::updateToVersion('0.10.0');
}

if (Froxlor::isDatabaseVersion('201909150')) {

	Update::showUpdateStep("Adding TLSv1.3-cipherlist setting");
	Settings::AddNew("system.tlsv13_cipher_list", '');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201910030');
}

if (Froxlor::isDatabaseVersion('201910030')) {

	Update::showUpdateStep("Adding field api_allowed to admins and customers");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `api_allowed` tinyint(1) NOT NULL default '1';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `api_allowed` tinyint(1) NOT NULL default '1';");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201910090');
}

if (Froxlor::isFroxlorVersion('0.10.0')) {
	Update::showUpdateStep("Updating from 0.10.0 to 0.10.1 final", false);
	Froxlor::updateToVersion('0.10.1');
}

if (Froxlor::isDatabaseVersion('201910090')) {

	Update::showUpdateStep("Adjusting Let's Encrypt API setting");
	Settings::Set("system.leapiversion", '2');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201910110');
}

if (Froxlor::isDatabaseVersion('201910110')) {

	Update::showUpdateStep("Adding new settings for ssl-vhost default content");
	Settings::AddNew("system.default_sslvhostconf", '');
	Settings::AddNew("system.include_default_vhostconf", '0');
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adding new fields to ips and ports-table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `ssl_specialsettings` text AFTER `docroot`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `include_specialsettings` tinyint(1) NOT NULL default '0' AFTER `ssl_specialsettings`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `ssl_default_vhostconf_domain` text AFTER `include_specialsettings`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `include_default_vhostconf_domain` tinyint(1) NOT NULL default '0' AFTER `ssl_default_vhostconf_domain`;");
	Update::lastStepStatus(0);

	Update::showUpdateStep("Adding new fields to domains-table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_specialsettings` text AFTER `specialsettings`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `include_specialsettings` tinyint(1) NOT NULL default '0' AFTER `ssl_specialsettings`;");
	Update::lastStepStatus(0);

	// select all ips/ports with specialsettings and SSL enabled to include the specialsettings in the ssl-vhost
	// because the former implementation included it and users might rely on that, see https://github.com/Froxlor/Froxlor/issues/727
	$sel_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `specialsettings` <> '' AND `ssl` = '1'");
	Database::pexecute($sel_stmt);
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_IPSANDPORTS . "` SET `include_specialsettings` = '1' WHERE `id` = :id");
	if ($sel_stmt->columnCount() > 0) {
		Update::showUpdateStep("Adjusting IP/port settings for downward compatibility");
		while ($row = $sel_stmt->fetch(PDO::FETCH_ASSOC)) {
			Database::pexecute($upd_stmt, [
				'id' => $row['id']
			]);
		}
		Update::lastStepStatus(0);
	}

	// select all domains with an ssl IP connected and specialsettings content to include these in the ssl-vhost
	// to maintain former behavior
	$sel_stmt = Database::prepare("
		SELECT d.id FROM `" . TABLE_PANEL_DOMAINS . "` d
		LEFT JOIN `" . TABLE_DOMAINTOIP . "` d2i ON d2i.id_domain = d.id
		LEFT JOIN `" . TABLE_PANEL_IPSANDPORTS . "` i ON i.id = d2i.id_ipandports
		WHERE d.specialsettings <> '' AND i.ssl = '1'
	");
	Database::pexecute($sel_stmt);
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `include_specialsettings` = '1' WHERE `id` = :id");
	if ($sel_stmt->columnCount() > 0) {
		Update::showUpdateStep("Adjusting domain settings for downward compatibility");
		while ($row = $sel_stmt->fetch(PDO::FETCH_ASSOC)) {
			Database::pexecute($upd_stmt, [
				'id' => $row['id']
			]);
		}
		Update::lastStepStatus(0);
	}

	Froxlor::updateToDbVersion('201910120');
}

if (Froxlor::isFroxlorVersion('0.10.1')) {
	Update::showUpdateStep("Updating from 0.10.1 to 0.10.2", false);
	Froxlor::updateToVersion('0.10.2');
}

if (Froxlor::isDatabaseVersion('201910120')) {

	Update::showUpdateStep("Adding new TLS options to domains-table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `override_tls` tinyint(1) DEFAULT '0' AFTER `writeerrorlog`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_protocols` text AFTER `override_tls`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_cipher_list` text AFTER `ssl_protocols`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `tlsv13_cipher_list` text AFTER `ssl_cipher_list`;");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201910200');
}

if (Froxlor::isFroxlorVersion('0.10.2')) {
	Update::showUpdateStep("Updating from 0.10.2 to 0.10.3", false);
	Froxlor::updateToVersion('0.10.3');
}

if (Froxlor::isFroxlorVersion('0.10.3')) {
	Update::showUpdateStep("Updating from 0.10.3 to 0.10.4", false);
	Froxlor::updateToVersion('0.10.4');
}

if (Froxlor::isFroxlorVersion('0.10.4')) {
	Update::showUpdateStep("Updating from 0.10.4 to 0.10.5", false);
	Froxlor::updateToVersion('0.10.5');
}

if (Froxlor::isDatabaseVersion('201910200')) {

	Update::showUpdateStep("Optimizing customer and admin table for size");
	// ALTER TABLE `panel_customers` CHANGE `name` `name` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `zipcode` `zipcode` varchar(25) NOT NULL default '';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `phone` `phone` varchar(50) NOT NULL default '';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `fax` `fax` varchar(50) NOT NULL default '';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `def_language` `def_language` varchar(100) NOT NULL default '';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `theme` `theme` varchar(50) NOT NULL default 'Sparkle';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `data_2fa` `data_2fa` varchar(25) NOT NULL default '';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `def_language` `def_language` varchar(100) NOT NULL default '';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `leaccount`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` CHANGE `def_language` `def_language` varchar(100) NOT NULL default '';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` CHANGE `theme` `theme` varchar(50) NOT NULL default 'Sparkle';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` CHANGE `data_2fa` `data_2fa` varchar(25) NOT NULL default '';");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('201911130');
}

if (Froxlor::isFroxlorVersion('0.10.5')) {
	Update::showUpdateStep("Updating from 0.10.5 to 0.10.6", false);
	Froxlor::updateToVersion('0.10.6');
}

if (Froxlor::isDatabaseVersion('201911130')) {
	Update::showUpdateStep("Adding new settings for domain edit form default values");
	Settings::AddNew("system.apply_specialsettings_default", '1');
	Settings::AddNew("system.apply_phpconfigs_default", '1');
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('201911220');
}

if (Froxlor::isFroxlorVersion('0.10.6')) {
	Update::showUpdateStep("Updating from 0.10.6 to 0.10.7", false);
	Froxlor::updateToVersion('0.10.7');
}

if (Froxlor::isFroxlorVersion('0.10.7')) {
	Update::showUpdateStep("Updating from 0.10.7 to 0.10.8", false);
	Froxlor::updateToVersion('0.10.8');
}

if (Froxlor::isFroxlorVersion('0.10.8')) {
	Update::showUpdateStep("Updating from 0.10.8 to 0.10.9", false);
	Froxlor::updateToVersion('0.10.9');
}

if (Froxlor::isDatabaseVersion('201911220')) {
	Update::showUpdateStep("Adding enhanced SSL control over domains");
	// customer domains
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_enabled` tinyint(1) DEFAULT '1';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_honorcipherorder` tinyint(1) DEFAULT '0' AFTER `ssl_enabled`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_sessiontickets` tinyint(1) DEFAULT '1' AFTER `ssl_honorcipherorder`;");
	// as setting for froxlor vhost
	Settings::AddNew("system.honorcipherorder", '0');
	Settings::AddNew("system.sessiontickets", '1');
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('201912100');
}

if (Froxlor::isFroxlorVersion('0.10.9')) {
	Update::showUpdateStep("Updating from 0.10.9 to 0.10.10", false);
	Froxlor::updateToVersion('0.10.10');
}

if (Froxlor::isDatabaseVersion('201912100')) {
	Update::showUpdateStep("Adding option to disable SSL sessiontickets for older systems");
	Settings::AddNew("system.sessionticketsenabled", '1');
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('201912310');
}

if (Froxlor::isDatabaseVersion('201912310')) {
	Update::showUpdateStep("Adding custom phpfpm pool configuration field");
	Database::query("ALTER TABLE `" . TABLE_PANEL_FPMDAEMONS . "` ADD `custom_config` text AFTER `limit_extensions`;");
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('201912311');
}

if (Froxlor::isFroxlorVersion('0.10.10')) {
	Update::showUpdateStep("Updating from 0.10.10 to 0.10.11", false);
	Froxlor::updateToVersion('0.10.11');
}

if (Froxlor::isDatabaseVersion('201912311')) {
	Update::showUpdateStep("Migrate logfiles_format setting");
	$current_format = Settings::Set('system.logfiles_format');
	if (!empty($current_format)) {
		Settings::Set('system.logfiles_format', '"' . Settings::Get('system.logfiles_format') . '"');
		Update::lastStepStatus(0);
	} else {
		Update::lastStepStatus(0, 'not needed');
	}
	Froxlor::updateToDbVersion('201912312');
}

if (Froxlor::isDatabaseVersion('201912312')) {
	Update::showUpdateStep("Adding option change awstats LogFormat");
	Settings::AddNew("system.awstats_logformat", '1');
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('201912313');
}

if (Froxlor::isFroxlorVersion('0.10.11')) {
	Update::showUpdateStep("Updating from 0.10.11 to 0.10.12", false);
	Froxlor::updateToVersion('0.10.12');
}

if (Froxlor::isFroxlorVersion('0.10.12')) {
	Update::showUpdateStep("Updating from 0.10.12 to 0.10.13", false);
	Froxlor::updateToVersion('0.10.13');
}

if (Froxlor::isDatabaseVersion('201912313')) {
	Update::showUpdateStep("Adding new field to domains table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `domain_ace` varchar(255) NOT NULL default '' AFTER `domain`;");
	Update::lastStepStatus(0);

	Update::showUpdateStep("Updating domain entries");
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `domain_ace` = :ace WHERE `id` = :domainid");
	$sel_stmt = Database::prepare("SELECT id, domain FROM `" . TABLE_PANEL_DOMAINS . "` ORDER BY id ASC");
	Database::pexecute($sel_stmt);
	$idna_convert = new \Froxlor\Idna\IdnaWrapper();
	while ($domain = $sel_stmt->fetch(\PDO::FETCH_ASSOC)) {
		Database::pexecute($upd_stmt, [
			'ace' => $idna_convert->decode($domain['domain']),
			'domainid' => $domain['id']
		]);
	}
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202002290');
}

if (Froxlor::isFroxlorVersion('0.10.13')) {
	Update::showUpdateStep("Updating from 0.10.13 to 0.10.14", false);
	Froxlor::updateToVersion('0.10.14');
}

if (Froxlor::isFroxlorVersion('0.10.14')) {
	Update::showUpdateStep("Updating from 0.10.14 to 0.10.15", false);
	Froxlor::updateToVersion('0.10.15');
}

if (Froxlor::isDatabaseVersion('202002290')) {
	Update::showUpdateStep("Adding new setting to validate DNS when using Let's Encrypt");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'disable_le_selfcheck'");
	$le_domain_dnscheck = isset($_POST['system_le_domain_dnscheck']) ? (int) $_POST['system_le_domain_dnscheck'] : '1';
	Settings::AddNew("system.le_domain_dnscheck", $le_domain_dnscheck);
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202004140');
}

if (Froxlor::isFroxlorVersion('0.10.15')) {
	Update::showUpdateStep("Updating from 0.10.15 to 0.10.16", false);
	Froxlor::updateToVersion('0.10.16');
}

if (Froxlor::isDatabaseVersion('202004140')) {

	Update::showUpdateStep("Adding unique key on domainid field in domain ssl table");
	// check for duplicate entries prior to set a unique key to avoid errors on update
	Database::query("
		DELETE a.* FROM domain_ssl_settings AS a
		LEFT JOIN domain_ssl_settings AS b ON
		((b.`domainid`=a.`domainid` AND UNIX_TIMESTAMP(b.`expirationdate`) > UNIX_TIMESTAMP(a.`expirationdate`))
		OR (UNIX_TIMESTAMP(b.`expirationdate`) = UNIX_TIMESTAMP(a.`expirationdate`) AND b.`id`>a.`id`))
		WHERE b.`id` IS NOT NULL
	");
	Database::query("ALTER TABLE `domain_ssl_settings` ADD UNIQUE(`domainid`)");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202005150');
}

if (Froxlor::isFroxlorVersion('0.10.16')) {
	Update::showUpdateStep("Updating from 0.10.16 to 0.10.17", false);
	Froxlor::updateToVersion('0.10.17');
}

if (Froxlor::isFroxlorVersion('0.10.17')) {
	Update::showUpdateStep("Updating from 0.10.17 to 0.10.18", false);
	Froxlor::updateToVersion('0.10.18');
}

if (Froxlor::isFroxlorVersion('0.10.18')) {
	Update::showUpdateStep("Updating from 0.10.18 to 0.10.19", false);
	Froxlor::updateToVersion('0.10.19');
}

if (Froxlor::isDatabaseVersion('202005150')) {

	Update::showUpdateStep("Add new performance indexes", true);
	Database::query("ALTER TABLE panel_customers ADD INDEX guid (guid);");
	Database::query("ALTER TABLE panel_tasks ADD INDEX type (type);");
	Database::query("ALTER TABLE mail_users ADD INDEX username (username);");
	Database::query("ALTER TABLE mail_users ADD INDEX imap (imap);");
	Database::query("ALTER TABLE mail_users ADD INDEX pop3 (pop3);");
	Database::query("ALTER TABLE ftp_groups ADD INDEX gid (gid);");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202007240');
}

if (Froxlor::isFroxlorVersion('0.10.19')) {
	Update::showUpdateStep("Updating from 0.10.19 to 0.10.20", false);
	Froxlor::updateToVersion('0.10.20');
}

if (Froxlor::isDatabaseVersion('202007240')) {

	Update::showUpdateStep("Removing old unused table", true);
	Database::query("DROP TABLE IF EXISTS `panel_diskspace_admins`;");
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202009070');
}

if (Froxlor::isFroxlorVersion('0.10.20')) {
	Update::showUpdateStep("Updating from 0.10.20 to 0.10.21", false);
	Froxlor::updateToVersion('0.10.21');
}

if (Froxlor::isFroxlorVersion('0.10.21')) {

	Update::showUpdateStep("Adding settings for ssl-vhost default content if not updated from db-version 201910110", true);
	Settings::AddNew("system.default_sslvhostconf", '');
	Update::lastStepStatus(0);

	Update::showUpdateStep("Updating from 0.10.21 to 0.10.22", false);
	Froxlor::updateToVersion('0.10.22');
}

if (Froxlor::isFroxlorVersion('0.10.22')) {
	Update::showUpdateStep("Updating from 0.10.22 to 0.10.23", false);
	Froxlor::updateToVersion('0.10.23');
}

if (Froxlor::isFroxlorVersion('0.10.23')) {
	Update::showUpdateStep("Updating from 0.10.23 to 0.10.23.1", false);
	Froxlor::updateToVersion('0.10.23.1');
}

if (Froxlor::isDatabaseVersion('202009070')) {

	Update::showUpdateStep("Adding setting to hide incompatible settings", true);
	Settings::AddNew("system.hide_incompatible_settings", '0');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202012300');
}

if (Froxlor::isDatabaseVersion('202012300')) {

	Update::showUpdateStep("Adding setting for DKIM private key extension/suffix", true);
	Settings::AddNew("dkim.privkeysuffix", '.priv');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202101200');
}

if (Froxlor::isFroxlorVersion('0.10.23.1')) {
	Update::showUpdateStep("Updating from 0.10.23.1 to 0.10.24", false);
	Froxlor::updateToVersion('0.10.24');
}

if (Froxlor::isDatabaseVersion('202101200')) {

	Update::showUpdateStep("Adding setting for mail address used in SOA records", true);
	Settings::AddNew("system.soaemail", '');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202102200');
}

if (Froxlor::isFroxlorVersion('0.10.24')) {
	Update::showUpdateStep("Updating from 0.10.24 to 0.10.25", false);
	Froxlor::updateToVersion('0.10.25');
}

if (Froxlor::isDatabaseVersion('202102200') || Froxlor::isDatabaseVersion('202103030')) {

	Update::showUpdateStep("Refactoring columns from large tables", true);
	Database::query("ALTER TABLE panel_domains CHANGE `ssl_protocols` `ssl_protocols` varchar(255) NOT NULL DEFAULT '';");
	Database::query("ALTER TABLE panel_domains CHANGE `ssl_cipher_list` `ssl_cipher_list` varchar(500) NOT NULL DEFAULT '';");
	Database::query("ALTER TABLE panel_domains CHANGE `tlsv13_cipher_list` `tlsv13_cipher_list` varchar(500) NOT NULL DEFAULT '';");
	Update::lastStepStatus(0);

	Update::showUpdateStep("Add new description fields to mail and domain table", true);
	$result = Database::query("DESCRIBE `panel_domains`");
	$columnfound = 0;
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		if ($row['Field'] == 'description') {
			$columnfound = 1;
		}
	}
	if (!$columnfound) {
		Database::query("ALTER TABLE panel_domains ADD `description` varchar(255) NOT NULL DEFAULT '' AFTER `ssl_sessiontickets`;");
	}
	$result = Database::query("DESCRIBE `mail_virtual`");
	$columnfound = 0;
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		if ($row['Field'] == 'description') {
			$columnfound = 1;
		}
	}
	if (!$columnfound) {
		Database::query("ALTER TABLE mail_virtual ADD `description` varchar(255) NOT NULL DEFAULT '' AFTER `iscatchall`");
	}
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202103110');
}

if (Froxlor::isDatabaseVersion('202103110')) {

	Update::showUpdateStep("Adding settings for imprint, terms of use and privacy policy URLs", true);
	Settings::AddNew("panel.imprint_url", '');
	Settings::AddNew("panel.terms_url", '');
	Settings::AddNew("panel.privacy_url", '');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202103240');
}

if (Froxlor::isFroxlorVersion('0.10.25')) {
	Update::showUpdateStep("Updating from 0.10.25 to 0.10.26", false);
	Froxlor::updateToVersion('0.10.26');
}

if (Froxlor::isDatabaseVersion('202103240')) {

	Update::showUpdateStep("Adding setting for default serveralias value for new domains", true);
	Settings::AddNew("system.domaindefaultalias", '0');
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202106160');
}

if (Froxlor::isDatabaseVersion('202106160')) {

	Update::showUpdateStep("Adjusting Let's Encrypt endpoint configuration to support ZeroSSL", true);
	if (Settings::Get('system.letsencryptca') == 'testing') {
		Settings::Set("system.letsencryptca", 'letsencrypt_test');
	} else {
		Settings::Set("system.letsencryptca", 'letsencrypt');
	}
	Update::lastStepStatus(0);

	Froxlor::updateToDbVersion('202106270');
}

if (Froxlor::isDatabaseVersion('202106270')) {
	Update::showUpdateStep("Adding custom logo image settings", true);
	Settings::AddNew("panel.logo_image_header", '');
	Settings::AddNew("panel.logo_image_login", '');
	Update::lastStepStatus(0);

	// Migrating old custom logo over, if exists
	$custom_logo_file_old = Froxlor::getInstallDir() . '/templates/Sparkle/assets/img/logo_custom.png';
	if (file_exists($custom_logo_file_old)) {
		Update::showUpdateStep("Migrating existing custom logo to new settings", true);

		$path = Froxlor::getInstallDir() . '/img/';
		if (!is_dir($path) && !mkdir($path, 0775)) {
			throw new \Exception("img directory does not exist and cannot be created");
		}
		if (!is_writable($path)) {
			if (!chmod($path, 0775)) {
				throw new \Exception("Cannot write to img directory");
			}
		}

		// Save as new custom logo header
		$save_to = 'logo_header.png';
		copy($custom_logo_file_old, $path . $save_to);
		Settings::Set("panel.logo_image_header", "img/{$save_to}?v=" . time());

		// Save as new custom logo login
		$save_to = 'logo_login.png';
		copy($custom_logo_file_old, $path . $save_to);
		Settings::Set("panel.logo_image_login", "img/{$save_to}?v=" . time());

		Update::lastStepStatus(0);
	}

	Froxlor::updateToDbVersion('202107070');
}

if (Froxlor::isFroxlorVersion('0.10.26')) {
	Update::showUpdateStep("Updating from 0.10.26 to 0.10.27", false);
	Froxlor::updateToVersion('0.10.27');
}

if (Froxlor::isDatabaseVersion('202107070')) {
	Update::showUpdateStep("Adding settings to overwrite theme- or custom theme-logo with the new logo settings", true);
	Settings::AddNew("panel.logo_overridetheme", '0');
	Settings::AddNew("panel.logo_overridecustom", '0');
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('202107200');
}

if (Froxlor::isDatabaseVersion('202107200')) {
	Update::showUpdateStep("Adding settings to define default value of 'create std-subdomain' when creating a customer", true);
	Settings::AddNew("system.createstdsubdom_default", '1');
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('202107210');
}

if (Froxlor::isDatabaseVersion('202107210')) {
	Update::showUpdateStep("Normalizing ipv6 for correct comparison", true);
	$result_stmt = Database::prepare(
		"
		SELECT `id`, `ip` FROM `" . TABLE_PANEL_IPSANDPORTS . "`"
	);
	Database::pexecute($result_stmt);
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_IPSANDPORTS . "` SET `ip` = :ip WHERE `id` = :id");
	while ($iprow = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
		if (IPTools::is_ipv6($iprow['ip'])) {
			$ip = inet_ntop(inet_pton($iprow['ip']));
			Database::pexecute($upd_stmt, [
				'ip' => $ip,
				'id' => $iprow['id']
			]);
		}
	}
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('202107260');
}

if (Froxlor::isDatabaseVersion('202107260')) {
	Update::showUpdateStep("Removing setting for search-engine allow yes/no", true);
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'panel' AND `varname` = 'no_robots'");
	Update::lastStepStatus(0);
	Update::showUpdateStep("Adding setting to have all froxlor customers in a local group", true);
	Settings::AddNew("system.froxlorusergroup", '');
	Settings::AddNew("system.froxlorusergroup_gid", '');
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('202107300');
}

if (Froxlor::isDatabaseVersion('202107300')) {
	Update::showUpdateStep("Adds the possibility to select the PowerDNS Operation Mode", true);
	Settings::AddNew("system.powerdns_mode", 'Native');
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('202108180');
}

if (Froxlor::isFroxlorVersion('0.10.27')) {
	Update::showUpdateStep("Updating from 0.10.27 to 0.10.28", false);
	Froxlor::updateToVersion('0.10.28');
}

if (Froxlor::isDatabaseVersion('202108180')) {
	Update::showUpdateStep("Adding czech language file", true);
	Database::query("INSERT INTO `panel_languages` SET `language` = '&#268;esk&aacute; republika', `iso` = 'cs', `file` = 'lng/czech.lng.php'");
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('202109040');
}

if (Froxlor::isFroxlorVersion('0.10.28')) {
	Update::showUpdateStep("Updating from 0.10.28 to 0.10.29", false);
	Froxlor::updateToVersion('0.10.29');
}

if (Froxlor::isFroxlorVersion('0.10.29')) {
	Update::showUpdateStep("Updating from 0.10.29 to 0.10.29.1", false);
	Froxlor::updateToVersion('0.10.29.1');
}

if (Froxlor::isFroxlorVersion('0.10.29.1')) {
	Update::showUpdateStep("Updating from 0.10.29.1 to 0.10.30", false);
	Froxlor::updateToVersion('0.10.30');
}

if (Froxlor::isFroxlorVersion('0.10.30')) {
	Update::showUpdateStep("Updating from 0.10.30 to 0.10.31", false);
	Froxlor::updateToVersion('0.10.31');
}

if (Froxlor::isDatabaseVersion('202109040')) {
	Update::showUpdateStep("Add setting for acme.sh install location", true);
	Settings::AddNew("system.acmeshpath", '/root/.acme.sh/acme.sh');
	Update::lastStepStatus(0);
	Froxlor::updateToDbVersion('202112310');
}

if (Froxlor::isFroxlorVersion('0.10.31')) {
	Update::showUpdateStep("Updating from 0.10.31 to 0.10.32", false);
	Froxlor::updateToVersion('0.10.32');
}

if (Froxlor::isFroxlorVersion('0.10.32')) {
	Update::showUpdateStep("Updating from 0.10.32 to 0.10.33", false);
	Froxlor::updateToVersion('0.10.33');
}

if (Froxlor::isFroxlorVersion('0.10.33')) {
	Update::showUpdateStep("Updating from 0.10.33 to 0.10.34", false);
	Froxlor::updateToVersion('0.10.34');
}

if (Froxlor::isFroxlorVersion('0.10.34')) {
	Update::showUpdateStep("Updating from 0.10.34 to 0.10.34.1", false);
	Froxlor::updateToVersion('0.10.34.1');
}

if (Froxlor::isFroxlorVersion('0.10.34.1')) {
	Update::showUpdateStep("Updating from 0.10.34.1 to 0.10.35", false);
	Froxlor::updateToVersion('0.10.35');
}

if (Froxlor::isFroxlorVersion('0.10.35')) {
	Update::showUpdateStep("Updating from 0.10.35 to 0.10.35.1", false);
	Froxlor::updateToVersion('0.10.35.1');
}

if (Froxlor::isFroxlorVersion('0.10.35.1')) {
	Update::showUpdateStep("Updating from 0.10.35.1 to 0.10.36", false);
	Froxlor::updateToVersion('0.10.36');
}

if (Froxlor::isFroxlorVersion('0.10.36')) {
	Update::showUpdateStep("Updating from 0.10.36 to 0.10.37", false);
	Froxlor::updateToVersion('0.10.37');
}

if (Froxlor::isFroxlorVersion('0.10.37')) {
	Update::showUpdateStep("Updating from 0.10.37 to 0.10.38", false);
	Froxlor::updateToVersion('0.10.38');
}

if (Froxlor::isFroxlorVersion('0.10.38')) {
	Update::showUpdateStep("Updating from 0.10.38 to 0.10.38.1", false);
	Froxlor::updateToVersion('0.10.38.1');
}

if (Froxlor::isFroxlorVersion('0.10.38.1')) {
	Update::showUpdateStep("Updating from 0.10.38.1 to 0.10.38.2", false);
	Froxlor::updateToVersion('0.10.38.2');
}

if (Froxlor::isFroxlorVersion('0.10.38.2')) {
	Update::showUpdateStep("Updating from 0.10.38.2 to 0.10.38.3", false);
	Froxlor::updateToVersion('0.10.38.3');
}
