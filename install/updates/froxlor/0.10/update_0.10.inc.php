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
if (! defined('_CRON_UPDATE')) {
	if (! defined('AREA') || (defined('AREA') && AREA != 'admin') || ! isset($userinfo['loginname']) || (isset($userinfo['loginname']) && $userinfo['loginname'] == '')) {
		header('Location: ../../../../index.php');
		exit();
	}
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.9.40.1')) {
	showUpdateStep("Updating from 0.9.40.1 to 0.10.0-rc1", false);

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
		if ($adm['ip'] != '-1') {
			Database::pexecute($upd_stmt, array(
				'ip' => json_encode($adm['ip']),
				'adminid' => $adm['adminid']
			));
		}
	}
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToVersion('0.10.0-rc1');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201809280')) {

	showUpdateStep("Adding dhparams-file setting");
	Settings::AddNew("system.dhparams_file", '');
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201811180');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201811180')) {

	showUpdateStep("Adding new settings for 2FA");
	Settings::AddNew('2fa.enabled', '1', true);
	lastStepStatus(0);

	showUpdateStep("Adding new fields to admin-table for 2FA");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `type_2fa` tinyint(1) NOT NULL default '0';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `data_2fa` varchar(500) NOT NULL default '' AFTER `type_2fa`;");
	lastStepStatus(0);

	showUpdateStep("Adding new fields to customer-table for 2FA");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `type_2fa` tinyint(1) NOT NULL default '0';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `data_2fa` varchar(500) NOT NULL default '' AFTER `type_2fa`;");
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201811300');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201811300')) {

	showUpdateStep("Adding new logview-flag to customers");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `logviewenabled` tinyint(1) NOT NULL default '0';");
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201812010');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201812010')) {

	showUpdateStep("Adding new is_configured-flag");
	// updated systems are already configured (most likely :P)
	Settings::AddNew('panel.is_configured', '1', true);
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201812100');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201812100')) {

	showUpdateStep("Adding fields writeaccesslog and writeerrorlog for domains");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `writeaccesslog` tinyint(1) NOT NULL default '1';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `writeerrorlog` tinyint(1) NOT NULL default '1';");
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201812180');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201812180')) {

	showUpdateStep("Updating cronjob table");
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
	lastStepStatus(0);

	showUpdateStep("Removing ticketsystem");
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
	lastStepStatus(0);

	showUpdateStep("Updating nameserver settings");
	$dns_target = 'Bind';
	if (Settings::Get('system.dns_server') != 'bind') {
		$dns_target = 'PowerDNS';
	}
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`  = :v WHERE `settinggroup` = 'system' AND `varname` = 'dns_server'");
	Database::pexecute($upd_stmt, array(
		'v' => $dns_target
	));
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201812190');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201812190')) {

	showUpdateStep("Adding new webserver error-log-level setting");
	Settings::AddNew('system.errorlog_level', (\Froxlor\Settings::Get('system.webserver') == 'nginx' ? 'error' : 'warn'));
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201902120');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201902120')) {

	showUpdateStep("Adding new ECC / ECDSA setting for Let's Encrypt");
	Settings::AddNew('system.leecc', '0');
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `cronclass`  = :cc WHERE `cronfile` = :cf");
	Database::pexecute($upd_stmt, array(
		'cc' => '\\Froxlor\\Cron\\Http\\LetsEncrypt\\AcmeSh',
		'cf' => 'letsencrypt'
	));
	Settings::Set('system.letsencryptkeysize', '4096', true);
	lastStepStatus(0);

	showUpdateStep("Removing current Let's Encrypt certificates due to new implementation of acme.sh");
	$sel_result = Database::query("SELECT id FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `letsencrypt` = '1'");
	$domain_ids = $sel_result->fetchAll(\PDO::FETCH_ASSOC);
	if (count($domain_ids) > 0) {
		$domain_in = "";
		foreach ($domain_ids as $domain_id) {
			$domain_in .= "'" . $domain_id['id'] . "',";
		}
		$domain_in = substr($domain_in, 0, - 1);
		Database::query("DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` IN (" . $domain_in . ")");
	}
	// check for froxlor domain using let's encrypt
	if (Settings::Get('system.le_froxlor_enabled') == 1) {
		Database::query("DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid` = '0'");
	}
	lastStepStatus(0);

	showUpdateStep("Inserting job to regenerate configfiles");
	\Froxlor\System\Cronjob::inserttask('1');
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201902170');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201902170')) {

	showUpdateStep("Adding new froxlor vhost domain alias setting");
	Settings::AddNew('system.froxloraliases', "");
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201902210');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201902210')) {

	// set correct version for people that have tested 0.10.0 before
	\Froxlor\Froxlor::updateToVersion('0.10.0-rc1');
	\Froxlor\Froxlor::updateToDbVersion('201904100');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201904100')) {

	showUpdateStep("Converting all MyISAM tables to InnoDB");
	Database::needRoot(true);
	Database::needSqlData();
	$sql_data = Database::getSqlData();
	$result = Database::query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . $sql_data['db'] . "' AND ENGINE = 'MyISAM'");
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		Database::query("ALTER TABLE `" . $row['TABLE_NAME'] . "` ENGINE=INNODB");
	}
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201904250');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.0-rc1')) {
	showUpdateStep("Updating from 0.10.0-rc1 to 0.10.0-rc2", false);
	\Froxlor\Froxlor::updateToVersion('0.10.0-rc2');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201904250')) {

	showUpdateStep("Adding new settings for CAA");
	Settings::AddNew('caa.caa_entry', '', true);
	Settings::AddNew('system.dns_createcaaentry', 1, true);
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201907270');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201907270')) {

	showUpdateStep("Cleaning up old files");
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

	\Froxlor\Froxlor::updateToDbVersion('201909150');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.0-rc2')) {
	showUpdateStep("Updating from 0.10.0-rc2 to 0.10.0 final", false);
	\Froxlor\Froxlor::updateToVersion('0.10.0');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201909150')) {

	showUpdateStep("Adding TLSv1.3-cipherlist setting");
	Settings::AddNew("system.tlsv13_cipher_list", '');
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201910030');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201910030')) {

	showUpdateStep("Adding field api_allowed to admins and customers");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `api_allowed` tinyint(1) NOT NULL default '1';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `api_allowed` tinyint(1) NOT NULL default '1';");
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201910090');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.0')) {
	showUpdateStep("Updating from 0.10.0 to 0.10.1 final", false);
	\Froxlor\Froxlor::updateToVersion('0.10.1');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201910090')) {

	showUpdateStep("Adjusting Let's Encrypt API setting");
	Settings::Set("system.leapiversion", '2');
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201910110');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201910110')) {

	showUpdateStep("Adding new settings for ssl-vhost default content");
	Settings::AddNew("system.default_sslvhostconf", '');
	Settings::AddNew("system.include_default_vhostconf", '0');
	lastStepStatus(0);

	showUpdateStep("Adding new fields to ips and ports-table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `ssl_specialsettings` text AFTER `docroot`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `include_specialsettings` tinyint(1) NOT NULL default '0' AFTER `ssl_specialsettings`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `ssl_default_vhostconf_domain` text AFTER `include_specialsettings`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `include_default_vhostconf_domain` tinyint(1) NOT NULL default '0' AFTER `ssl_default_vhostconf_domain`;");
	lastStepStatus(0);

	showUpdateStep("Adding new fields to domains-table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_specialsettings` text AFTER `specialsettings`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `include_specialsettings` tinyint(1) NOT NULL default '0' AFTER `ssl_specialsettings`;");
	lastStepStatus(0);

	// select all ips/ports with specialsettings and SSL enabled to include the specialsettings in the ssl-vhost
	// because the former implementation included it and users might rely on that, see https://github.com/Froxlor/Froxlor/issues/727
	$sel_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `specialsettings` <> '' AND `ssl` = '1'");
	Database::pexecute($sel_stmt);
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_IPSANDPORTS . "` SET `include_specialsettings` = '1' WHERE `id` = :id");
	if ($sel_stmt->columnCount() > 0) {
		showUpdateStep("Adjusting IP/port settings for downward compatibility");
		while ($row = $sel_stmt->fetch(PDO::FETCH_ASSOC)) {
			Database::pexecute($upd_stmt, [
				'id' => $row['id']
			]);
		}
		lastStepStatus(0);
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
		showUpdateStep("Adjusting domain settings for downward compatibility");
		while ($row = $sel_stmt->fetch(PDO::FETCH_ASSOC)) {
			Database::pexecute($upd_stmt, [
				'id' => $row['id']
			]);
		}
		lastStepStatus(0);
	}

	\Froxlor\Froxlor::updateToDbVersion('201910120');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.1')) {
	showUpdateStep("Updating from 0.10.1 to 0.10.2", false);
	\Froxlor\Froxlor::updateToVersion('0.10.2');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201910120')) {

	showUpdateStep("Adding new TLS options to domains-table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `override_tls` tinyint(1) DEFAULT '0' AFTER `writeerrorlog`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_protocols` text AFTER `override_tls`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_cipher_list` text AFTER `ssl_protocols`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `tlsv13_cipher_list` text AFTER `ssl_cipher_list`;");
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201910200');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.2')) {
	showUpdateStep("Updating from 0.10.2 to 0.10.3", false);
	\Froxlor\Froxlor::updateToVersion('0.10.3');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.3')) {
	showUpdateStep("Updating from 0.10.3 to 0.10.4", false);
	\Froxlor\Froxlor::updateToVersion('0.10.4');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.4')) {
	showUpdateStep("Updating from 0.10.4 to 0.10.5", false);
	\Froxlor\Froxlor::updateToVersion('0.10.5');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201910200')) {

	showUpdateStep("Optimizing customer and admin table for size");
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
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('201911130');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.5')) {
	showUpdateStep("Updating from 0.10.5 to 0.10.6", false);
	\Froxlor\Froxlor::updateToVersion('0.10.6');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201911130')) {
	showUpdateStep("Adding new settings for domain edit form default values");
	Settings::AddNew("system.apply_specialsettings_default", '1');
	Settings::AddNew("system.apply_phpconfigs_default", '1');
	lastStepStatus(0);
	\Froxlor\Froxlor::updateToDbVersion('201911220');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.6')) {
	showUpdateStep("Updating from 0.10.6 to 0.10.7", false);
	\Froxlor\Froxlor::updateToVersion('0.10.7');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.7')) {
	showUpdateStep("Updating from 0.10.7 to 0.10.8", false);
	\Froxlor\Froxlor::updateToVersion('0.10.8');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.8')) {
	showUpdateStep("Updating from 0.10.8 to 0.10.9", false);
	\Froxlor\Froxlor::updateToVersion('0.10.9');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201911220')) {
	showUpdateStep("Adding enhanced SSL control over domains");
	// customer domains
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_enabled` tinyint(1) DEFAULT '1';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_honorcipherorder` tinyint(1) DEFAULT '0' AFTER `ssl_enabled`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_sessiontickets` tinyint(1) DEFAULT '1' AFTER `ssl_honorcipherorder`;");
	// as setting for froxlor vhost
	Settings::AddNew("system.honorcipherorder", '0');
	Settings::AddNew("system.sessiontickets", '1');
	lastStepStatus(0);
	\Froxlor\Froxlor::updateToDbVersion('201912100');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.9')) {
	showUpdateStep("Updating from 0.10.9 to 0.10.10", false);
	\Froxlor\Froxlor::updateToVersion('0.10.10');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201912100')) {
	showUpdateStep("Adding option to disable SSL sessiontickets for older systems");
	Settings::AddNew("system.sessionticketsenabled", '1');
	lastStepStatus(0);
	\Froxlor\Froxlor::updateToDbVersion('201912310');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201912310')) {
	showUpdateStep("Adding custom phpfpm pool configuration field");
	Database::query("ALTER TABLE `" . TABLE_PANEL_FPMDAEMONS . "` ADD `custom_config` text AFTER `limit_extensions`;");
	lastStepStatus(0);
	\Froxlor\Froxlor::updateToDbVersion('201912311');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.10')) {
	showUpdateStep("Updating from 0.10.10 to 0.10.11", false);
	\Froxlor\Froxlor::updateToVersion('0.10.11');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201912311')) {
	showUpdateStep("Migrate logfiles_format setting");
	$current_format = Settings::Set('system.logfiles_format');
	if (! empty($current_format)) {
		Settings::Set('system.logfiles_format', '"' . Settings::Get('system.logfiles_format') . '"');
		lastStepStatus(0);
	} else {
		lastStepStatus(0, 'not needed');
	}
	\Froxlor\Froxlor::updateToDbVersion('201912312');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201912312')) {
	showUpdateStep("Adding option change awstats LogFormat");
	Settings::AddNew("system.awstats_logformat", '1');
	lastStepStatus(0);
	\Froxlor\Froxlor::updateToDbVersion('201912313');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.11')) {
	showUpdateStep("Updating from 0.10.11 to 0.10.12", false);
	\Froxlor\Froxlor::updateToVersion('0.10.12');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.12')) {
	showUpdateStep("Updating from 0.10.12 to 0.10.13", false);
	\Froxlor\Froxlor::updateToVersion('0.10.13');
}

if (\Froxlor\Froxlor::isDatabaseVersion('201912313')) {
	showUpdateStep("Adding new field to domains table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `domain_ace` varchar(255) NOT NULL default '' AFTER `domain`;");
	lastStepStatus(0);

	showUpdateStep("Updating domain entries");
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
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('202002290');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.13')) {
	showUpdateStep("Updating from 0.10.13 to 0.10.14", false);
	\Froxlor\Froxlor::updateToVersion('0.10.14');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.14')) {
	showUpdateStep("Updating from 0.10.14 to 0.10.15", false);
	\Froxlor\Froxlor::updateToVersion('0.10.15');
}

if (\Froxlor\Froxlor::isDatabaseVersion('202002290')) {
	showUpdateStep("Adding new setting to validate DNS when using Let's Encrypt");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'disable_le_selfcheck'");
	$le_domain_dnscheck = isset($_POST['system_le_domain_dnscheck']) ? (int) $_POST['system_le_domain_dnscheck'] : '1';
	Settings::AddNew("system.le_domain_dnscheck", $le_domain_dnscheck);
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('202004140');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.15')) {
	showUpdateStep("Updating from 0.10.15 to 0.10.16", false);
	\Froxlor\Froxlor::updateToVersion('0.10.16');
}

if (\Froxlor\Froxlor::isDatabaseVersion('202004140')) {

	showUpdateStep("Adding unique key on domainid field in domain ssl table");
	// check for duplicate entries prior to set a unique key to avoid errors on update
	Database::query("
		DELETE a.* FROM domain_ssl_settings AS a
		LEFT JOIN domain_ssl_settings AS b ON
		((b.`domainid`=a.`domainid` AND UNIX_TIMESTAMP(b.`expirationdate`) > UNIX_TIMESTAMP(a.`expirationdate`))
		OR (UNIX_TIMESTAMP(b.`expirationdate`) = UNIX_TIMESTAMP(a.`expirationdate`) AND b.`id`>a.`id`))
		WHERE b.`id` IS NOT NULL
	");
	Database::query("ALTER TABLE `domain_ssl_settings` ADD UNIQUE(`domainid`)");
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('202005150');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.16')) {
	showUpdateStep("Updating from 0.10.16 to 0.10.17", false);
	\Froxlor\Froxlor::updateToVersion('0.10.17');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.17')) {
	showUpdateStep("Updating from 0.10.17 to 0.10.18", false);
	\Froxlor\Froxlor::updateToVersion('0.10.18');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.18')) {
	showUpdateStep("Updating from 0.10.18 to 0.10.19", false);
	\Froxlor\Froxlor::updateToVersion('0.10.19');
}

if (\Froxlor\Froxlor::isDatabaseVersion('202005150')) {

	showUpdateStep("Add new performance indexes", true);
	Database::query("ALTER TABLE panel_customers ADD INDEX guid (guid);");
	Database::query("ALTER TABLE panel_tasks ADD INDEX type (type);");
	Database::query("ALTER TABLE mail_users ADD INDEX username (username);");
	Database::query("ALTER TABLE mail_users ADD INDEX imap (imap);");
	Database::query("ALTER TABLE mail_users ADD INDEX pop3 (pop3);");
	Database::query("ALTER TABLE ftp_groups ADD INDEX gid (gid);");
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('202007240');
}

if (\Froxlor\Froxlor::isFroxlorVersion('0.10.19')) {
	showUpdateStep("Updating from 0.10.19 to 0.10.20", false);
	\Froxlor\Froxlor::updateToVersion('0.10.20');
}

if (\Froxlor\Froxlor::isDatabaseVersion('202007240')) {

	showUpdateStep("Removing old unused table", true);
	Database::query("DROP TABLE IF EXISTS `panel_diskspace_admins`;");
	lastStepStatus(0);

	\Froxlor\Froxlor::updateToDbVersion('202009070');
}
