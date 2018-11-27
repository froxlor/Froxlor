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
if (!defined('_CRON_UPDATE')) {
	if (! defined('AREA') || (defined('AREA') && AREA != 'admin') || ! isset($userinfo['loginname']) || (isset($userinfo['loginname']) && $userinfo['loginname'] == '')) {
		header('Location: ../../../../index.php');
		exit();
	}
}

if (isFroxlorVersion('0.9-r0')) {

	showUpdateStep("Updating from 0.9-r0 to 0.9-r1", false);
	showUpdateStep("Performing database updates");

	// add missing database-updates if necessary (old: update/update_database.php)
	if (Settings::Get('system.dbversion') !== null && (int) Settings::Get('system.dbversion') < 1) {
		Database::query("
			ALTER TABLE `panel_databases` ADD `dbserver` INT( 11 ) UNSIGNED NOT NULL default '0';");
	}
	if (Settings::Get('system.dbversion') !== null && (int) Settings::Get('system.dbversion') < 2) {
		Database::query("ALTER TABLE `panel_ipsandports` CHANGE `ssl_cert` `ssl_cert_file` VARCHAR( 255 ) NOT NULL,
				ADD `ssl_key_file` VARCHAR( 255 ) NOT NULL,
				ADD `ssl_ca_file` VARCHAR( 255 ) NOT NULL,
				ADD `default_vhostconf_domain` TEXT NOT NULL;");

		Database::query("INSERT INTO `panel_settings` SET `settinggroup` = 'system', `varname` = 'ssl_key_file', `value` = '';");
		Database::query("INSERT INTO `panel_settings` SET `settinggroup` = 'system', `varname` = 'ssl_ca_file', `value` = '';");
	}
	// eof(lostuff)

	// remove billing tables in database
	define('TABLE_BILLING_INVOICES', 'billing_invoices');
	define('TABLE_BILLING_INVOICES_ADMINS', 'billing_invoices_admins');
	define('TABLE_BILLING_INVOICE_CHANGES', 'billing_invoice_changes');
	define('TABLE_BILLING_INVOICE_CHANGES_ADMINS', 'billing_invoice_changes_admins');
	define('TABLE_BILLING_SERVICE_CATEGORIES', 'billing_service_categories');
	define('TABLE_BILLING_SERVICE_CATEGORIES_ADMINS', 'billing_service_categories_admins');
	define('TABLE_BILLING_SERVICE_DOMAINS_TEMPLATES', 'billing_service_domains_templates');
	define('TABLE_BILLING_SERVICE_OTHER', 'billing_service_other');
	define('TABLE_BILLING_SERVICE_OTHER_TEMPLATES', 'billing_service_other_templates');
	define('TABLE_BILLING_TAXCLASSES', 'billing_taxclasses');
	define('TABLE_BILLING_TAXRATES', 'billing_taxrates');

	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_SERVICE_CATEGORIES . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_SERVICE_CATEGORIES_ADMINS . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_SERVICE_DOMAINS_TEMPLATES . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_SERVICE_OTHER . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_SERVICE_OTHER_TEMPLATES . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_TAXCLASSES . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_TAXRATES . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_INVOICES . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_INVOICES_ADMINS . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_INVOICE_CHANGES . "`;");
	Database::query("DROP TABLE IF EXISTS `" . TABLE_BILLING_INVOICE_CHANGES_ADMINS . "`;");

	// update panel_domains, panel_customers, panel_admins
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "`
			DROP `firstname`,
			DROP `title`,
			DROP `company`,
			DROP `street`,
			DROP `zipcode`,
			DROP `city`,
			DROP `country`,
			DROP `phone`,
			DROP `fax`,
			DROP `taxid`,
			DROP `contract_date`,
			DROP `contract_number`,
			DROP `contract_details`,
			DROP `included_domains_qty`,
			DROP `included_domains_tld`,
			DROP `additional_traffic_fee`,
			DROP `additional_traffic_unit`,
			DROP `additional_diskspace_fee`,
			DROP `additional_diskspace_unit`,
			DROP `taxclass`,
			DROP `setup_fee`,
			DROP `interval_fee`,
			DROP `interval_length`,
			DROP `interval_type`,
			DROP `interval_payment`,
			DROP `calc_tax`,
			DROP `term_of_payment`,
			DROP `payment_every`,
			DROP `payment_method`,
			DROP `bankaccount_holder`,
			DROP `bankaccount_number`,
			DROP `bankaccount_blz`,
			DROP `bankaccount_bank`,
			DROP `service_active`,
			DROP `servicestart_date`,
			DROP `serviceend_date`,
			DROP `lastinvoiced_date`,
			DROP `lastinvoiced_date_traffic`,
			DROP `lastinvoiced_date_diskspace`,
			DROP `customer_categories_once`,
			DROP `customer_categories_period`,
			DROP `invoice_fee`,
			DROP `invoice_fee_hosting`,
			DROP `invoice_fee_hosting_customers`,
			DROP `invoice_fee_domains`,
			DROP `invoice_fee_traffic`,
			DROP `invoice_fee_diskspace`,
			DROP `invoice_fee_other`,
			DROP `edit_billingdata`;");

	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "`
			DROP `taxid`,
			DROP `title`,
			DROP `country`,
			DROP `additional_service_description`,
			DROP `contract_date`,
			DROP `contract_number`,
			DROP `contract_details`,
			DROP `included_domains_qty`,
			DROP `included_domains_tld`,
			DROP `additional_traffic_fee`,
			DROP `additional_traffic_unit`,
			DROP `additional_diskspace_fee`,
			DROP `additional_diskspace_unit`,
			DROP `taxclass`,
			DROP `setup_fee`,
			DROP `interval_fee`,
			DROP `interval_length`,
			DROP `interval_type`,
			DROP `interval_payment`,
			DROP `calc_tax`,
			DROP `term_of_payment`,
			DROP `payment_every`,
			DROP `payment_method`,
			DROP `bankaccount_holder`,
			DROP `bankaccount_number`,
			DROP `bankaccount_blz`,
			DROP `bankaccount_bank`,
			DROP `service_active`,
			DROP `servicestart_date`,
			DROP `serviceend_date`,
			DROP `lastinvoiced_date`,
			DROP `lastinvoiced_date_traffic`,
			DROP `lastinvoiced_date_diskspace`,
			DROP `invoice_fee`,
			DROP `invoice_fee_hosting`,
			DROP `invoice_fee_domains`,
			DROP `invoice_fee_traffic`,
			DROP `invoice_fee_diskspace`,
			DROP `invoice_fee_other`;");
	Database::query("ALTER TABLE `panel_domains`
			DROP `taxclass`,
			DROP `setup_fee`,
			DROP `interval_fee`,
			DROP `interval_length`,
			DROP `interval_type`,
			DROP `interval_payment`,
			DROP `service_active`,
			DROP `servicestart_date`,
			DROP `serviceend_date`,
			DROP `lastinvoiced_date`;");

	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "`
			WHERE `settinggroup` = 'billing';");

	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "`
			MODIFY `traffic` BIGINT(30),
			MODIFY `traffic_used` BIGINT(30)");

	lastStepStatus(0);

	updateToVersion('0.9-r1');
}

if (isFroxlorVersion('0.9-r1')) {
	showUpdateStep("Updating from 0.9-r1 to 0.9-r2", false);

	showUpdateStep("Updating settings table");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('spf', 'use_spf', '0');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('spf', 'spf_entry', '@	IN	TXT	\"v=spf1 a mx -all\"');");
	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `varname` = 'froxlor_graphic' WHERE `varname` = 'syscp_graphic'");

	if (Settings::Get('admin.syscp_graphic') !== null && Settings::Get('admin.syscp_graphic') != '') {
		Settings::Set('admin.froxlor_graphic', Settings::Get('admin.syscp_graphic'));
	} else {
		Settings::Set('admin.froxlor_graphic', 'images/header.gif');
	}
	lastStepStatus(0);

	updateToVersion('0.9-r2');
}

if (isFroxlorVersion('0.9-r2')) {

	showUpdateStep("Updating from 0.9-r2 to 0.9-r3", false);
	showUpdateStep("Updating tables");

	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'debug_cron', '0');");
	Database::query("ALTER TABLE `" . TABLE_MAIL_AUTORESPONDER . "` ADD `date_from` int(15) NOT NULL default '-1' AFTER `enabled`");
	Database::query("ALTER TABLE `" . TABLE_MAIL_AUTORESPONDER . "` ADD `date_until` int(15) NOT NULL default '-1' AFTER `date_from`");

	lastStepStatus(0);

	updateToVersion('0.9-r3');
}

if (isFroxlorVersion('0.9-r3')) {
	showUpdateStep("Updating from 0.9-r3 to 0.9-r4", false);
	showUpdateStep("Creating new table 'cronjobs_run'");

	Database::query("CREATE TABLE IF NOT EXISTS `cronjobs_run` (
			`id` bigint(20) NOT NULL auto_increment,
			`module` varchar(250) NOT NULL,
			`cronfile` varchar(250) NOT NULL,
			`lastrun` int(15) NOT NULL DEFAULT '0',
			`interval` varchar(100) NOT NULL DEFAULT '5 MINUTE',
			`isactive` tinyint(1) DEFAULT '1',
			`desc_lng_key` varchar(100) NOT NULL DEFAULT 'cron_unknown_desc',
			PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;");

	lastStepStatus(0);
	showUpdateStep("Inserting new values into table");

	// checking for active ticket-module
	$ticket_active = 0;
	if ((int) Settings::Get('ticket.enabled') == 1) {
		$ticket_active = 1;
	}

	// checking for active aps-module
	$aps_active = 0;
	if ((int) Settings::Get('aps.aps_active') == 1) {
		$aps_active = 1;
	}

	// checking for active autoresponder-module
	$ar_active = 0;
	if ((int) Settings::Get('autoresponder.autoresponder_active') == 1) {
		$ar_active = 1;
	}

	Database::query("INSERT INTO `cronjobs_run` (`module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES ('froxlor/core', 'cron_tasks.php', '5 MINUTE', '1', 'cron_tasks');");
	Database::query("INSERT INTO `cronjobs_run` (`module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES ('froxlor/core', 'cron_legacy.php', '5 MINUTE', '1', 'cron_legacy');");
	Database::query("INSERT INTO `cronjobs_run` (`module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES ('froxlor/aps', 'cron_apsinstaller.php', '5 MINUTE', " . $aps_active . ", 'cron_apsinstaller');");
	Database::query("INSERT INTO `cronjobs_run` (`module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES ('froxlor/autoresponder', 'cron_autoresponder.php', '5 MINUTE', " . $ar_active . ", 'cron_autoresponder');");
	Database::query("INSERT INTO `cronjobs_run` (`module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES ('froxlor/aps', 'cron_apsupdater.php', '1 HOUR', " . $aps_active . ", 'cron_apsupdater');");
	Database::query("INSERT INTO `cronjobs_run` (`module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES ('froxlor/core', 'cron_traffic.php', '1 DAY', '1', 'cron_traffic');");
	Database::query("INSERT INTO `cronjobs_run` (`module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES ('froxlor/ticket', 'cron_used_tickets_reset.php', '1 MONTH', '" . $ticket_active . "', 'cron_ticketsreset');");
	Database::query("INSERT INTO `cronjobs_run` (`module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES ('froxlor/ticket', 'cron_ticketarchive.php', '1 MONTH', '" . $ticket_active . "', 'cron_ticketarchive');");

	lastStepStatus(0);
	showUpdateStep("Updating old settings values");

	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = 'Froxlor Support' WHERE `settinggroup`='ticket' AND `varname`='noreply_name' AND `value`='SysCP Support'");

	lastStepStatus(0);
	updateToVersion('0.9-r4');
}

if (isFroxlorVersion('0.9-r4')) {
	showUpdateStep("Updating from 0.9-r4 to 0.9 final");
	lastStepStatus(0);
	updateToVersion('0.9');
}

if (isFroxlorVersion('0.9')) {

	showUpdateStep("Updating from 0.9 to 0.9.1", false);

	showUpdateStep("Updating settings values");
	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = 'images/header.gif' WHERE `varname` = 'froxlor_graphic' AND `value` = 'images/header.png'");

	lastStepStatus(0);
	updateToVersion('0.9.1');
}

if (isFroxlorVersion('0.9.1')) {

	showUpdateStep("Updating from 0.9.1 to 0.9.2", false);

	showUpdateStep("Checking whether last-system-guid is sane");
	$result_stmt = Database::query("SELECT MAX(`guid`) as `latestguid` FROM `" . TABLE_PANEL_CUSTOMERS . "`");
	$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

	if (isset($result['latestguid']) && (int) $result['latestguid'] > 0 && $result['latestguid'] != Settings::Get('system.lastguid')) {
		checkLastGuid();
		lastStepStatus(1, 'fixed');
	} else {
		lastStepStatus(0);
	}
	updateToVersion('0.9.2');
}

if (isFroxlorVersion('0.9.2')) {
	showUpdateStep("Updating from 0.9.2 to 0.9.3");
	lastStepStatus(0);
	updateToVersion('0.9.3');
}

if (isFroxlorVersion('0.9.3')) {

	showUpdateStep("Updating from 0.9.3 to 0.9.3-svn1", false);

	showUpdateStep("Updating tables");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'password_min_length', '0');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'store_index_file_subs', '1');");
	lastStepStatus(0);

	updateToVersion('0.9.3-svn1');
}

if (isFroxlorVersion('0.9.3-svn1')) {

	showUpdateStep("Updating from 0.9.3-svn1 to 0.9.3-svn2", false);

	showUpdateStep("Updating tables");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'adminmail_defname', 'Froxlor Administrator');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'adminmail_return', '');");
	lastStepStatus(0);

	updateToVersion('0.9.3-svn2');
}

if (isFroxlorVersion('0.9.3-svn2')) {

	showUpdateStep("Updating from 0.9.3-svn2 to 0.9.3-svn3", false);

	showUpdateStep("Correcting cron start-times");
	// set specific times for some crons (traffic only at night, etc.)
	$ts = mktime(0, 0, 0, date('m', time()), date('d', time()), date('Y', time()));
	Database::query("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `lastrun` = '" . $ts . "' WHERE `cronfile` ='cron_traffic.php';");
	$ts = mktime(1, 0, 0, date('m', time()), date('d', time()), date('Y', time()));
	Database::query("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `lastrun` = '" . $ts . "' WHERE `cronfile` ='cron_used_tickets_reset.php';");
	Database::query("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `lastrun` = '" . $ts . "' WHERE `cronfile` ='cron_ticketarchive.php';");
	lastStepStatus(0);

	showUpdateStep("Adding new language: Polish");
	Database::query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` SET `language` = 'Polski', `file` = 'lng/polish.lng.php'");
	lastStepStatus(0);

	updateToVersion('0.9.3-svn3');
}

if (isFroxlorVersion('0.9.3-svn3')) {

	showUpdateStep("Updating from 0.9.3-svn3 to 0.9.3-svn4", false);

	showUpdateStep("Adding new DKIM settings");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_algorithm', 'all');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_add_adsp', '1');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_keylength', '1024');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_servicetype', '0');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_add_adsppolicy', '1');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_notes', '');");
	lastStepStatus(0);

	updateToVersion('0.9.3-svn4');
}

if (isFroxlorVersion('0.9.3-svn4')) {

	showUpdateStep("Updating from 0.9.3-svn4 to 0.9.3-svn5", false);

	showUpdateStep("Adding new settings");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'stdsubdomain', '');");
	lastStepStatus(0);

	updateToVersion('0.9.3-svn5');
}

if (isFroxlorVersion('0.9.3-svn5')) {
	showUpdateStep("Updating from 0.9.3-svn5 to 0.9.4 final");
	lastStepStatus(0);
	updateToVersion('0.9.4');
}

if (isFroxlorVersion('0.9.4')) {

	showUpdateStep("Updating from 0.9.4 to 0.9.4-svn1", false);

	/**
	 * some users might still have the setting in their database
	 * because we already had this back in older versions.
	 * To not confuse Froxlor, we just update old settings.
	 */
	if (Settings::Get('system.awstats_path') !== null && Settings::Get('system.awstats_path') != '') {
		showUpdateStep("Updating awstats path setting");
		Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/usr/bin/' WHERE `settinggroup` = 'system' AND `varname` = 'awstats_path';");
		lastStepStatus(0);
	} elseif (Settings::Get('system.awstats_path') == null) {
		showUpdateStep("Adding new awstats path setting");
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_path', '/usr/bin/');");
		lastStepStatus(0);
	}

	if (Settings::Get('system.awstats_domain_file') !== null && Settings::Get('system.awstats_domain_file') != '') {
		showUpdateStep("Updating awstats configuration path setting");
		Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `varname` = 'awstats_conf' WHERE `varname` = 'awstats_domain_file';");
	} else {
		showUpdateStep("Adding awstats configuration path settings");
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_conf', '/etc/awstats/');");
	}
	lastStepStatus(0);

	updateToVersion('0.9.4-svn1');
}

if (isFroxlorVersion('0.9.4-svn1')) {

	showUpdateStep("Updating from 0.9.4-svn1 to 0.9.4-svn2", false);

	$update_domains = isset($_POST['update_domainwildcardentry']) ? intval($_POST['update_domainwildcardentry']) : 0;

	if ($update_domains != 1) {
		$update_domains = 0;
	}

	if ($update_domains == 1) {
		showUpdateStep("Updating domains with iswildcarddomain=yes");
		$query = "SELECT `d`.`id` FROM `" . TABLE_PANEL_DOMAINS . "` `d`, `" . TABLE_PANEL_CUSTOMERS . "` `c` ";
		$query .= "WHERE `parentdomainid`='0' AND `email_only` = '0' AND `d`.`customerid` = `c`.`customerid` AND `d`.`id` <> `c`.`standardsubdomain`";
		$result = Database::query($query);
		$updated_domains = 0;
		while ($domain = $result->fetch(PDO::FETCH_ASSOC)) {
			Database::query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `iswildcarddomain` = '1' WHERE `id` ='" . (int) $domain['id'] . "'");
			$updated_domains ++;
		}
		lastStepStatus(0, 'Updated ' . $updated_domains . ' domain(s)');
	} else {
		showUpdateStep("Won't update domains with iswildcarddomain=yes as requested");
		lastStepStatus(1);
	}

	showUpdateStep("Updating database table definition for panel_domains");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` MODIFY `iswildcarddomain` tinyint(1) NOT NULL default '1';");
	lastStepStatus(0);

	updateToVersion('0.9.4-svn2');
}

if (isFroxlorVersion('0.9.4-svn2')) {
	showUpdateStep("Updating from 0.9.4-svn2 to 0.9.5 final");
	lastStepStatus(0);
	updateToVersion('0.9.5');
}

if (isFroxlorVersion('0.9.5')) {

	showUpdateStep("Updating from 0.9.5 to 0.9.6-svn1", false);

	showUpdateStep("Adding time-to-live configuration setting");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'defaultttl', '604800');");
	lastStepStatus(0);

	showUpdateStep("Updating database table structure for panel_ticket_categories");
	Database::query("ALTER TABLE `" . TABLE_PANEL_TICKET_CATS . "` ADD `logicalorder` int(3) NOT NULL default '1' AFTER `adminid`;");
	lastStepStatus(0);

	updateToVersion('0.9.6-svn1');
}

if (isFroxlorVersion('0.9.6-svn1')) {

	showUpdateStep("Updating from 0.9.6-svn1 to 0.9.6-svn2", false);

	$update_adminmail = isset($_POST['update_adminmail']) ? validate($_POST['update_adminmail'], 'update_adminmail') : false;
	$do_update = true;

	if ($update_adminmail !== false) {
		showUpdateStep("Checking newly entered admin-mail");
		if (! PHPMailer::ValidateAddress($update_adminmail)) {
			$do_update = false;
			lastStepStatus(2, 'E-Mail still not valid, go back and try again');
		} else {
			$stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = :adminmail
				WHERE `settinggroup` = 'panel' AND `varname` = 'adminmail';");
			Database::pexecute($stmt, array(
				'adminmail' => $update_adminmail
			));
			lastStepStatus(0);
		}
	}

	if ($do_update) {
		updateToVersion('0.9.6-svn2');
	}
}

if (isFroxlorVersion('0.9.6-svn2')) {

	showUpdateStep("Updating from 0.9.6-svn2 to 0.9.6-svn3", false);

	$update_deferr_enable = isset($_POST['update_deferr_enable']) ? true : false;

	$err500 = false;
	$err401 = false;
	$err403 = false;
	$err404 = false;

	showUpdateStep("Adding new webserver configurations to database");
	if ($update_deferr_enable == true) {
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'enabled', '1');");

		$stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
				`settinggroup` = 'defaultwebsrverrhandler',
				`varname` = :varname,
				`value` = :err");

		if (isset($_POST['update_deferr_500']) && trim($_POST['update_deferr_500']) != '') {
			Database::pexecute($stmt, array(
				'varname' => 'err500',
				'err' => $_POST['update_deferr_500']
			));
			$err500 = true;
		}

		if (isset($_POST['update_deferr_401']) && trim($_POST['update_deferr_401']) != '') {
			Database::pexecute($stmt, array(
				'varname' => 'err401',
				'err' => $_POST['update_deferr_401']
			));
			$err401 = true;
		}

		if (isset($_POST['update_deferr_403']) && trim($_POST['update_deferr_403']) != '') {
			Database::pexecute($stmt, array(
				'varname' => 'err403',
				'err' => $_POST['update_deferr_403']
			));
			$err403 = true;
		}

		if (isset($_POST['update_deferr_404']) && trim($_POST['update_deferr_404']) != '') {
			Database::pexecute($stmt, array(
				'varname' => 'err404',
				'err' => $_POST['update_deferr_404']
			));
			$err404 = true;
		}
	}

	if (! $update_deferr_enable) {
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'enabled', '0');");
	}
	if (! $err401) {
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err401', '');");
	}
	if (! $err403) {
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err403', '');");
	}
	if (! $err404) {
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err404', '');");
	}
	if (! $err500) {
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err500', '');");
	}

	lastStepStatus(0);

	updateToVersion('0.9.6-svn3');
}

if (isFroxlorVersion('0.9.6-svn3')) {

	showUpdateStep("Updating from 0.9.6-svn3 to 0.9.6-svn4", false);

	$update_deftic_priority = isset($_POST['update_deftic_priority']) ? intval($_POST['update_deftic_priority']) : 2;

	showUpdateStep("Setting default support-ticket priority");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'default_priority', '" . (int) $update_deftic_priority . "');");
	lastStepStatus(0);

	updateToVersion('0.9.6-svn4');
}

if (isFroxlorVersion('0.9.6-svn4')) {

	showUpdateStep("Updating from 0.9.6-svn4 to 0.9.6-svn5", false);

	$update_defsys_phpconfig = isset($_POST['update_defsys_phpconfig']) ? intval($_POST['update_defsys_phpconfig']) : 1;

	if ($update_defsys_phpconfig != 1) {
		showUpdateStep("Setting default php-configuration to user defined config #" . $update_defsys_phpconfig);
	} else {
		showUpdateStep("Adding default php-configuration setting to the database");
	}

	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_defaultini', '" . (int) $update_defsys_phpconfig . "');");
	lastStepStatus(0);

	updateToVersion('0.9.6-svn5');
}

if (isFroxlorVersion('0.9.6-svn5')) {

	showUpdateStep("Updating from 0.9.6-svn5 to 0.9.6-svn6", false);

	showUpdateStep("Adding new FTP-quota settings");
	$update_defsys_ftpserver = isset($_POST['update_defsys_ftpserver']) ? intval($_POST['update_defsys_ftpserver']) : 'proftpd';

	// add ftp server setting
	$stmt = Database::prepare("INSERT INTO `panel_settings` SET `settinggroup` = 'system', `varname` = 'ftpserver', `value` = :value;");
	Database::pexecute($stmt, array(
		'value' => $update_defsys_ftpserver
	));

	// add proftpd quota
	Database::query("CREATE TABLE `ftp_quotalimits` (`name` varchar(30) default NULL, `quota_type` enum('user','group','class','all') NOT NULL default 'user', `per_session` enum('false','true') NOT NULL default 'false', `limit_type` enum('soft','hard') NOT NULL default 'hard', `bytes_in_avail` float NOT NULL, `bytes_out_avail` float NOT NULL, `bytes_xfer_avail` float NOT NULL, `files_in_avail` int(10) unsigned NOT NULL, `files_out_avail` int(10) unsigned NOT NULL, `files_xfer_avail` int(10) unsigned NOT NULL) ENGINE=MyISAM;");
	Database::query("INSERT INTO `ftp_quotalimits` (`name`, `quota_type`, `per_session`, `limit_type`, `bytes_in_avail`, `bytes_out_avail`, `bytes_xfer_avail`, `files_in_avail`, `files_out_avail`, `files_xfer_avail`) VALUES ('froxlor', 'user', 'false', 'hard', 0, 0, 0, 0, 0, 0);");
	Database::query("CREATE TABLE `ftp_quotatallies` (`name` varchar(30) NOT NULL, `quota_type` enum('user','group','class','all') NOT NULL, `bytes_in_used` float NOT NULL, `bytes_out_used` float NOT NULL, `bytes_xfer_used` float NOT NULL, `files_in_used` int(10) unsigned NOT NULL, `files_out_used` int(10) unsigned NOT NULL, `files_xfer_used` int(10) unsigned NOT NULL ) ENGINE=MyISAM;");

	// fill quota tallies
	$result_ftp_users_stmt = Database::query("SELECT username FROM `" . TABLE_FTP_USERS . "` WHERE 1;");

	while ($row_ftp_users = $result_ftp_users_stmt->fetch(PDO::FETCH_ASSOC)) {
		$result_ftp_quota_stmt = Database::query("
			SELECT diskspace_used FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE loginname = SUBSTRING_INDEX('" . $row_ftp_users['username'] . "', '" . Settings::Get('customer.ftpprefix') . "', 1);");
		$row_ftp_quota = $result_ftp_quota_stmt->fetch(PDO::FETCH_ASSOC);
		Database::query("INSERT INTO `ftp_quotatallies` (`name`, `quota_type`, `bytes_in_used`, `bytes_out_used`, `bytes_xfer_used`, `files_in_used`, `files_out_used`, `files_xfer_used`) VALUES ('" . $row_ftp_users['username'] . "', 'user', '" . $row_ftp_quota['diskspace_used'] . "'*1024, '0', '0', '0', '0', '0');");
	}

	lastStepStatus(0);

	updateToVersion('0.9.6-svn6');
}

if (isFroxlorVersion('0.9.6-svn6')) {
	showUpdateStep("Updating from 0.9.6-svn6 to 0.9.6 final");
	lastStepStatus(0);
	updateToVersion('0.9.6');
}

if (isFroxlorVersion('0.9.6')) {
	showUpdateStep("Updating from 0.9.6 to 0.9.7-svn1", false);

	$update_customredirect_enable = isset($_POST['update_customredirect_enable']) ? 1 : 0;
	$update_customredirect_default = isset($_POST['update_customredirect_default']) ? (int) $_POST['update_customredirect_default'] : 1;

	showUpdateStep("Adding new tables to database");
	Database::query("CREATE TABLE IF NOT EXISTS `redirect_codes` (
			`id` int(5) NOT NULL auto_increment,
			`code` varchar(3) NOT NULL,
			`enabled` tinyint(1) DEFAULT '1',
			PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;");

	Database::query("CREATE TABLE IF NOT EXISTS `domain_redirect_codes` (
			`rid` int(5) NOT NULL,
			`did` int(11) unsigned NOT NULL,
			UNIQUE KEY `rc` (`rid`, `did`)
	) ENGINE=MyISAM;");
	lastStepStatus(0);

	showUpdateStep("Filling new tables with default data");
	Database::query("INSERT INTO `redirect_codes` (`id`, `code`, `enabled`) VALUES (1, '---', 1);");
	Database::query("INSERT INTO `redirect_codes` (`id`, `code`, `enabled`) VALUES (2, '301', 1);");
	Database::query("INSERT INTO `redirect_codes` (`id`, `code`, `enabled`) VALUES (3, '302', 1);");
	Database::query("INSERT INTO `redirect_codes` (`id`, `code`, `enabled`) VALUES (4, '303', 1);");
	Database::query("INSERT INTO `redirect_codes` (`id`, `code`, `enabled`) VALUES (5, '307', 1);");
	lastStepStatus(0);

	showUpdateStep("Updating domains");
	$res = Database::query("SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` ORDER BY `id` ASC");
	$updated_domains = 0;
	while ($d = $res->fetch(PDO::FETCH_ASSOC)) {
		Database::query("INSERT INTO `domain_redirect_codes` (`rid`, `did`) VALUES ('" . (int) $update_customredirect_default . "', '" . (int) $d['id'] . "');");
		$updated_domains ++;
	}
	lastStepStatus(0, 'Updated ' . $updated_domains . ' domain(s)');

	showUpdateStep("Adding new settings");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('customredirect', 'enabled', '" . (int) $update_customredirect_enable . "');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('customredirect', 'default', '" . (int) $update_customredirect_default . "');");
	lastStepStatus(0);

	// need to fix default-error-copy-and-paste-shizzle
	showUpdateStep("Checking if anything is ok with the default-error-handler");
	if (Settings::Get('defaultwebsrverrhandler.err404') == null) {
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err404', '');");
	}
	if (Settings::Get('defaultwebsrverrhandler.err403') == null) {
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err403', '');");
	}
	if (Settings::Get('defaultwebsrverrhandler.err401') == null) {
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err401', '');");
	}
	lastStepStatus(0);

	updateToVersion('0.9.7-svn1');
}

if (isFroxlorVersion('0.9.7-svn1')) {

	showUpdateStep("Updating from 0.9.7-svn1 to 0.9.7-svn2", false);

	showUpdateStep("Updating open_basedir due to security - issue");
	$result = Database::query("SELECT `id` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `documentroot` LIKE '%:%' AND `documentroot` NOT LIKE 'http://%' AND `openbasedir_path` = '0' AND `openbasedir` = '1'");
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		Database::query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `openbasedir_path` = '1' WHERE `id` = '" . (int) $row['id'] . "'");
	}
	lastStepStatus(0);

	updateToVersion('0.9.7-svn2');
}

if (isFroxlorVersion('0.9.7-svn2')) {

	showUpdateStep("Updating from 0.9.7-svn2 to 0.9.7-svn3", false);

	showUpdateStep("Updating database tables");
	Database::query("ALTER TABLE `redirect_codes` ADD `desc` varchar(200) NOT NULL AFTER `code`;");
	lastStepStatus(0);

	showUpdateStep("Updating field-values");
	Database::query("UPDATE `redirect_codes` SET `desc` = 'rc_default' WHERE `code` = '---';");
	Database::query("UPDATE `redirect_codes` SET `desc` = 'rc_movedperm' WHERE `code` = '301';");
	Database::query("UPDATE `redirect_codes` SET `desc` = 'rc_found' WHERE `code` = '302';");
	Database::query("UPDATE `redirect_codes` SET `desc` = 'rc_seeother' WHERE `code` = '303';");
	Database::query("UPDATE `redirect_codes` SET `desc` = 'rc_tempred' WHERE `code` = '307';");
	lastStepStatus(0);

	updateToVersion('0.9.7-svn3');
}

if (isFroxlorVersion('0.9.7-svn3')) {
	showUpdateStep("Updating from 0.9.7-svn3 to 0.9.7 final");
	lastStepStatus(0);
	updateToVersion('0.9.7');
}

if (isFroxlorVersion('0.9.7')) {
	showUpdateStep("Updating from 0.9.7 to 0.9.8 final");
	lastStepStatus(0);
	updateToVersion('0.9.8');
}

if (isFroxlorVersion('0.9.8')) {

	showUpdateStep("Updating from 0.9.8 to 0.9.9-svn1", false);

	$update_defdns_mailentry = isset($_POST['update_defdns_mailentry']) ? '1' : '0';
	showUpdateStep("Adding new settings");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'dns_createmailentry', '" . (int) $update_defdns_mailentry . "');");
	lastStepStatus(0);

	updateToVersion('0.9.9-svn1');
}

if (isFroxlorVersion('0.9.9-svn1')) {
	showUpdateStep("Updating from 0.9.9-svn1 to 0.9.9 final");
	lastStepStatus(0);
	updateToVersion('0.9.9');
}

if (isFroxlorVersion('0.9.9')) {

	showUpdateStep("Updating from 0.9.9 to 0.9.10-svn1", false);

	showUpdateStep("Checking whether you are missing any settings", false);
	$nonefound = true;

	$update_httpuser = isset($_POST['update_httpuser']) ? $_POST['update_httpuser'] : false;
	$update_httpgroup = isset($_POST['update_httpgroup']) ? $_POST['update_httpgroup'] : false;

	if ($update_httpuser !== false) {
		$nonefound = false;
		showUpdateStep("Adding missing setting 'httpuser'");
		$stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
			`settinggroup` = 'system',
			`varname` = 'httpuser',
			`value` = :user");
		Database::pexecute($stmt, array(
			':user' => $update_httpuser
		));
		lastStepStatus(0);
		Settings::Set('system.httpuser', $update_httpuser);
	}

	if ($update_httpgroup !== false) {
		$nonefound = false;
		showUpdateStep("Adding missing setting 'httpgroup'");
		$stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
			`settinggroup` = 'system',
			`varname` = 'httpgroup',
			`value` = :grp");
		Database::pexecute($stmt, array(
			':grp' => $update_httpgroup
		));
		lastStepStatus(0);
		Settings::Set('system.httpgroup', $update_httpgroup);
	}

	$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'debug_cron'");
	$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

	if (! isset($result) || ! isset($result['value'])) {
		$nonefound = false;
		showUpdateStep("Adding missing setting 'debug_cron'");
		Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'debug_cron', '0');");
		lastStepStatus(0);
	}

	if ($nonefound) {
		showUpdateStep("No missing settings found");
		lastStepStatus(0);
	}

	updateToVersion('0.9.10-svn1');
}

if (isFroxlorVersion('0.9.10-svn1')) {

	showUpdateStep("Updating from 0.9.10-svn1 to 0.9.10-svn2", false);

	showUpdateStep("Updating database table definition for panel_databases");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DATABASES . "` ADD `apsdb` tinyint(1) NOT NULL default '0' AFTER `dbserver`;");
	lastStepStatus(0);

	showUpdateStep("Adding APS databases to customers overview");
	$count_dbupdates = 0;
	Database::needRoot(true);
	$result = Database::query("SHOW DATABASES;");
	Database::needRoot(false);

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

		if (preg_match('/^web([0-9]+)aps([0-9]+)$/', $row['Database'], $matches)) {
			$cid = $matches[1];
			$databasedescription = 'APS DB';
			$result = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_DATABASES . "` SET
					`customerid` = :cid,
					`databasename` = :dbname,
					`description` = :dbdesc,
					`dbserver` = '0',
					`apsdb` = '1'");
			Database::pexecute($result, array(
				'cid' => $cid,
				'dbname' => $row['Database'],
				'dbdesc' => $databasedescription
			));
			Database::query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `mysqls_used`=`mysqls_used`+1 WHERE `customerid`="' . (int) $cid . '"');
			$count_dbupdates ++;
		}
	}

	if ($count_dbupdates > 0) {
		lastStepStatus(0, "Found " . $count_dbupdates . " customer APS databases");
	} else {
		lastStepStatus(0, "None found");
	}

	updateToVersion('0.9.10-svn2');
}

if (isFroxlorVersion('0.9.10-svn2')) {

	showUpdateStep("Updating from 0.9.10-svn2 to 0.9.10", false);

	$update_directlyviahostname = isset($_POST['update_directlyviahostname']) ? (int) $_POST['update_directlyviahostname'] : '0';

	showUpdateStep("Adding new settings");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'froxlordirectlyviahostname', '" . (int) $update_directlyviahostname . "');");
	lastStepStatus(0);

	updateToVersion('0.9.10');
}

if (isFroxlorVersion('0.9.10')) {
	showUpdateStep("Updating from 0.9.10 to 0.9.11-svn1", false);

	$update_pwdregex = isset($_POST['update_pwdregex']) ? $_POST['update_pwdregex'] : '';

	showUpdateStep("Adding new settings");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'panel',
		`varname` = 'password_regex',
		`value` = :regex");
	Database::pexecute($stmt, array(
		'regex' => $update_pwdregex
	));
	lastStepStatus(0);

	updateToVersion('0.9.11-svn1');
}

if (isFroxlorVersion('0.9.11-svn1')) {
	showUpdateStep("Updating from 0.9.11-svn1 to 0.9.11-svn2", false);

	showUpdateStep("Adding perl/CGI directory fields");
	Database::query("ALTER TABLE `" . TABLE_PANEL_HTACCESS . "` ADD `options_cgi` tinyint(1) NOT NULL default '0' AFTER `error401path`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `perlenabled` tinyint(1) NOT NULL default '0' AFTER `aps_packages_used`;");
	lastStepStatus(0);

	updateToVersion('0.9.11-svn2');
}

if (isFroxlorVersion('0.9.11-svn2')) {
	showUpdateStep("Updating from 0.9.11-svn2 to 0.9.11-svn3", false);

	$update_perlpath = isset($_POST['update_perlpath']) ? $_POST['update_perlpath'] : '/usr/bin/perl';

	showUpdateStep("Adding new settings");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = 'perl_path',
		`value` = :path");
	Database::pexecute($stmt, array(
		'path' => $update_perlpath
	));
	lastStepStatus(0);

	updateToVersion('0.9.11-svn3');
}

if (isFroxlorVersion('0.9.11-svn3')) {
	showUpdateStep("Updating from 0.9.11-svn3 to 0.9.11 final");
	lastStepStatus(0);
	updateToVersion('0.9.11');
}

if (isFroxlorVersion('0.9.11')) {
	showUpdateStep("Updating from 0.9.11 to 0.9.12-svn1", false);

	$update_fcgid_ownvhost = isset($_POST['update_fcgid_ownvhost']) ? (int) $_POST['update_fcgid_ownvhost'] : '0';
	$update_fcgid_httpuser = isset($_POST['update_fcgid_httpuser']) ? $_POST['update_fcgid_httpuser'] : 'froxlorlocal';
	$update_fcgid_httpgroup = isset($_POST['update_fcgid_httpgroup']) ? $_POST['update_fcgid_httpgroup'] : 'froxlorlocal';

	if ($update_fcgid_httpuser == '') {
		$update_fcgid_httpuser = 'froxlorlocal';
	}
	if ($update_fcgid_httpgroup == '') {
		$update_fcgid_httpgroup = 'froxlorlocal';
	}

	showUpdateStep("Adding new settings");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = :varname,
		`value` = :value");
	Database::pexecute($stmt, array(
		'varname' => 'mod_fcgid_ownvhost',
		'value' => $update_fcgid_ownvhost
	));
	Database::pexecute($stmt, array(
		'varname' => 'mod_fcgid_httpuser',
		'value' => $update_fcgid_httpuser
	));
	Database::pexecute($stmt, array(
		'varname' => 'mod_fcgid_httpgroup',
		'value' => $update_fcgid_httpgroup
	));
	lastStepStatus(0);

	updateToVersion('0.9.12-svn1');
}

if (isFroxlorVersion('0.9.12-svn1')) {

	showUpdateStep("Updating from 0.9.12-svn1 to 0.9.12-svn2", false);

	$update_perl_suexecworkaround = isset($_POST['update_perl_suexecworkaround']) ? (int) $_POST['update_perl_suexecworkaround'] : '0';
	$update_perl_suexecpath = isset($_POST['update_perl_suexecpath']) ? makeCorrectDir($_POST['update_perl_suexecpath']) : '/var/www/cgi-bin/';

	if ($update_perl_suexecpath == '') {
		$update_perl_suexecpath = '/var/www/cgi-bin/';
	}

	showUpdateStep("Adding new settings for perl/CGI");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'perl',
		`varname` = :varname,
		`value` = :value");
	Database::pexecute($stmt, array(
		'varname' => 'suexecworkaround',
		'value' => $update_perl_suexecworkaround
	));
	Database::pexecute($stmt, array(
		'varname' => 'suexecpath',
		'value' => $update_perl_suexecpath
	));
	lastStepStatus(0);

	updateToVersion('0.9.12-svn2');
}

if (isFroxlorVersion('0.9.12-svn2')) {

	showUpdateStep("Updating from 0.9.12-svn2 to 0.9.12-svn3", false);

	showUpdateStep("Adding new field to domain table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ismainbutsubto` int(11) unsigned NOT NULL default '0' AFTER `mod_fcgid_maxrequests`;");
	lastStepStatus(0);

	updateToVersion('0.9.12-svn3');
}

if (isFroxlorVersion('0.9.12-svn3')) {

	showUpdateStep("Updating from 0.9.12-svn3 to 0.9.12-svn4", false);

	$update_awstats_awstatspath = isset($_POST['update_awstats_awstatspath']) ? makeCorrectDir($_POST['update_awstats_awstatspath']) : Settings::Get('system.awstats_path');

	showUpdateStep("Adding new settings for awstats");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = 'awstats_awstatspath',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $update_awstats_awstatspath
	));
	lastStepStatus(0);

	updateToVersion('0.9.12-svn4');
}

if (isFroxlorVersion('0.9.12-svn4')) {

	showUpdateStep("Updating from 0.9.12-svn4 to 0.9.12-svn5", false);

	showUpdateStep("Setting ticket-usage-reset cronjob interval to 1 day");
	Database::query("UPDATE `cronjobs_run` SET `interval`='1 DAY' WHERE `cronfile`='cron_used_tickets_reset.php';");
	lastStepStatus(0);

	updateToVersion('0.9.12-svn5');
}

if (isFroxlorVersion('0.9.12-svn5')) {

	showUpdateStep("Updating from 0.9.12-svn5 to 0.9.12-svn6", false);

	showUpdateStep("Adding new field to table 'panel_htpasswds'");
	Database::query("ALTER TABLE `" . TABLE_PANEL_HTPASSWDS . "` ADD `authname` varchar(255) NOT NULL default 'Restricted Area' AFTER `password`;");
	lastStepStatus(0);

	updateToVersion('0.9.12-svn6');
}

if (isFroxlorVersion('0.9.12-svn6')) {
	showUpdateStep("Updating from 0.9.12-svn6 to 0.9.12 final");
	lastStepStatus(0);
	updateToVersion('0.9.12');
}

if (isFroxlorVersion('0.9.12')) {

	showUpdateStep("Updating from 0.9.12 to 0.9.13-svn1", false);

	showUpdateStep("Adding new fields to admin-table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `email_autoresponder` int(5) NOT NULL default '0' AFTER `aps_packages_used`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `email_autoresponder_used` int(5) NOT NULL default '0' AFTER `email_autoresponder`;");
	lastStepStatus(0);

	showUpdateStep("Adding new fields to customer-table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `email_autoresponder` int(5) NOT NULL default '0' AFTER `perlenabled`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `email_autoresponder_used` int(5) NOT NULL default '0' AFTER `email_autoresponder`;");
	lastStepStatus(0);

	if ((int) Settings::Get('autoresponder.autoresponder_active') == 1) {
		$update_autoresponder_default = isset($_POST['update_autoresponder_default']) ? intval_ressource($_POST['update_autoresponder_default']) : 0;
		if (isset($_POST['update_autoresponder_default_ul'])) {
			$update_autoresponder_default = - 1;
		}
	} else {
		$update_autoresponder_default = 0;
	}

	showUpdateStep("Setting default amount of autoresponders");
	// admin gets unlimited
	Database::query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `email_autoresponder`='-1' WHERE `adminid` = '" . (int) $userinfo['adminid'] . "'");
	// customers
	Database::query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `email_autoresponder`='" . (int) $update_autoresponder_default . "' WHERE `deactivated` = '0'");
	lastStepStatus(0);

	updateToVersion('0.9.13-svn1');
}

if (isFroxlorVersion('0.9.13-svn1')) {
	showUpdateStep("Updating from 0.9.13-svn1 to 0.9.13 final");
	lastStepStatus(0);
	updateToVersion('0.9.13');
}

if (isFroxlorVersion('0.9.13')) {
	showUpdateStep("Updating from 0.9.13 to 0.9.13.1 final", false);

	$update_defaultini_ownvhost = isset($_POST['update_defaultini_ownvhost']) ? (int) $_POST['update_defaultini_ownvhost'] : 1;

	showUpdateStep("Adding settings for Froxlor-vhost's PHP-configuration");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = 'mod_fcgid_defaultini_ownvhost',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $update_defaultini_ownvhost
	));
	lastStepStatus(0);

	updateToVersion('0.9.13.1');
}

/**
 * be compatible with the few who already use 0.9.14-svn1
 */
if (isFroxlorVersion('0.9.14-svn1')) {
	showUpdateStep("Resetting version 0.9.14-svn1 to 0.9.13.1");
	lastStepStatus(0);
	updateToVersion('0.9.13.1');
}

if (isFroxlorVersion('0.9.13.1')) {
	showUpdateStep("Updating from 0.9.13.1 to 0.9.14-svn2", false);

	if (Settings::Get('ticket.enabled') == '1') {
		showUpdateStep("Setting INTERVAL for used-tickets cronjob");
		setCycleOfCronjob(null, null, Settings::Get('ticket.reset_cycle'), null);
		lastStepStatus(0);
	}
	updateToVersion('0.9.14-svn2');
}

if (isFroxlorVersion('0.9.14-svn2')) {
	showUpdateStep("Updating from 0.9.14-svn2 to 0.9.14-svn3", false);

	$update_awstats_icons = isset($_POST['update_awstats_icons']) ? makeCorrectDir($_POST['update_awstats_icons']) : Settings::Get('system.awstats_icons');

	showUpdateStep("Adding AWStats icons path to the settings");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = 'awstats_icons',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $update_awstats_icons
	));
	lastStepStatus(0);

	updateToVersion('0.9.14-svn3');
}

if (isFroxlorVersion('0.9.14-svn3')) {

	showUpdateStep("Updating from 0.9.14-svn3 to 0.9.14-svn4", false);

	$update_ssl_cert_chainfile = isset($_POST['update_ssl_cert_chainfile']) ? $_POST['update_ssl_cert_chainfile'] : '';

	if ($update_ssl_cert_chainfile != '') {
		$update_ssl_cert_chainfile = makeCorrectFile($update_ssl_cert_chainfile);
	}

	showUpdateStep("Adding SSLCertificateChainFile to the settings");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = 'ssl_cert_chainfile',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $update_ssl_cert_chainfile
	));
	lastStepStatus(0);

	showUpdateStep("Adding new field to IPs and ports for SSLCertificateChainFile");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `ssl_cert_chainfile` varchar(255) NOT NULL AFTER `default_vhostconf_domain`;");
	lastStepStatus(0);

	updateToVersion('0.9.14-svn4');
}

if (isFroxlorVersion('0.9.14-svn4')) {
	showUpdateStep("Updating from 0.9.14-svn4 to 0.9.14-svn5", false);

	showUpdateStep("Adding docroot-field to IPs and ports for custom-docroot settings");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `docroot` varchar(255) NOT NULL default '' AFTER `ssl_cert_chainfile`;");
	lastStepStatus(0);

	updateToVersion('0.9.14-svn5');
}

if (isFroxlorVersion('0.9.14-svn5')) {

	showUpdateStep("Updating from 0.9.14-svn5 to 0.9.14-svn6", false);

	$update_allow_domain_login = isset($_POST['update_allow_domain_login']) ? (int) $_POST['update_allow_domain_login'] : '0';

	showUpdateStep("Adding domain-login switch to the settings");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'login',
		`varname` = 'domain_login',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $update_allow_domain_login
	));
	lastStepStatus(0);

	updateToVersion('0.9.14-svn6');
}

if (isFroxlorVersion('0.9.14-svn6')) {
	showUpdateStep("Updating from 0.9.14-svn6 to 0.9.14-svn10", false);

	// remove deprecated realtime-feature
	showUpdateStep("Removing realtime-feature (deprecated)");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'realtime_port';");
	lastStepStatus(0);

	// remove deprecated panel_navigation
	showUpdateStep("Removing table `panel_navigation` (deprecated)");
	Database::query("DROP TABLE IF EXISTS `panel_navigation`;");
	lastStepStatus(0);

	// remove deprecated panel_cronscript
	showUpdateStep("Removing table `panel_cronscript` (deprecated)");
	Database::query("DROP TABLE IF EXISTS `panel_cronscript`;");
	lastStepStatus(0);

	// make ticket-system ipv6 compatible
	showUpdateStep("Altering IP field in panel_tickets (IPv6 compatibility)");
	Database::query("ALTER TABLE `" . TABLE_PANEL_TICKETS . "` MODIFY `ip` varchar(39) NOT NULL default '';");
	lastStepStatus(0);

	showUpdateStep("Removing deprecated legacy-cronjob from database");
	Database::query("DELETE FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `cronfile` ='cron_legacy.php';");
	lastStepStatus(0);

	updateToVersion('0.9.14-svn10');
}

/*
 * revert database changes we did for multiserver-support
 * before branching - sorry guys :/
 */
if (isFroxlorVersion('0.9.14-svn9')) {
	showUpdateStep("Reverting multiserver-patches (svn)", false);

	$update_allow_domain_login = isset($_POST['update_allow_domain_login']) ? (int) $_POST['update_allow_domain_login'] : '0';

	showUpdateStep("Reverting database table-changes");
	Database::query("ALTER TABLE `" . TABLE_PANEL_SETTINGS . "` DROP `sid`;");

	showUpdateStep(".");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `sid`;");

	showUpdateStep(".");
	Database::query("ALTER TABLE `" . TABLE_MAIL_VIRTUAL . "` DROP `sid`;");

	showUpdateStep(".");
	Database::query("ALTER TABLE `" . TABLE_FTP_USERS . "` DROP `sid`;");

	showUpdateStep(".");
	Database::query("ALTER TABLE `" . TABLE_PANEL_TASKS . "` DROP `sid`;");

	showUpdateStep(".");
	Database::query("ALTER TABLE `" . TABLE_APS_TASKS . "` DROP `sid`;");

	showUpdateStep(".");
	Database::query("ALTER TABLE `" . TABLE_PANEL_LOG . "` DROP `sid`;");

	showUpdateStep(".");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` DROP `sid`;");
	lastStepStatus(0);

	showUpdateStep("Removing froxlor-clients table");
	Database::query("DROP TABLE IF EXISTS `froxlor_clients`");
	lastStepStatus(0);

	updateToVersion('0.9.14-svn10');
}

if (isFroxlorVersion('0.9.14-svn10')) {
	showUpdateStep("Updating from 0.9.14-svn10 to 0.9.14 final");
	lastStepStatus(0);
	updateToVersion('0.9.14');
}

if (isFroxlorVersion('0.9.14')) {
	showUpdateStep("Updating from 0.9.14 to 0.9.15-svn1", false);

	showUpdateStep("Adding new settings for Nginx support");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = :varname,
		`value` = :value");
	Database::pexecute($stmt, array(
		'varname' => 'nginx_php_backend',
		'value' => '127.0.0.1:8888'
	));
	Database::pexecute($stmt, array(
		'varname' => 'perl_server',
		'value' => 'unix:/var/run/nginx/cgiwrap-dispatch.sock'
	));
	Database::pexecute($stmt, array(
		'varname' => 'phpreload_command',
		'value' => ''
	));
	lastStepStatus(0);

	updateToVersion('0.9.15-svn1');
}

if (isFroxlorVersion('0.9.15-svn1')) {
	showUpdateStep("Updating from 0.9.15-svn1 to 0.9.15 final");
	lastStepStatus(0);
	updateToVersion('0.9.15');
}

if (isFroxlorVersion('0.9.15')) {
	showUpdateStep("Updating from 0.9.15 to 0.9.16-svn1", false);

	$update_phpfpm_enabled = isset($_POST['update_phpfpm_enabled']) ? (int) $_POST['update_phpfpm_enabled'] : '0';
	$update_phpfpm_configdir = isset($_POST['update_phpfpm_configdir']) ? makeCorrectDir($_POST['update_phpfpm_configdir']) : '/etc/php-fpm.d/';
	$update_phpfpm_tmpdir = isset($_POST['update_phpfpm_tmpdir']) ? makeCorrectDir($_POST['update_phpfpm_tmpdir']) : '/var/customers/tmp';
	$update_phpfpm_peardir = isset($_POST['update_phpfpm_peardir']) ? makeCorrectDir($_POST['update_phpfpm_peardir']) : '/usr/share/php/:/usr/share/php5/';
	$update_phpfpm_reload = isset($_POST['update_phpfpm_reload']) ? $_POST['update_phpfpm_reload'] : '/etc/init.d/php-fpm restart';

	$update_phpfpm_pm = isset($_POST['update_phpfpm_pm']) ? $_POST['update_phpfpm_pm'] : 'static';
	$update_phpfpm_max_children = isset($_POST['update_phpfpm_max_children']) ? (int) $_POST['update_phpfpm_max_children'] : '1';
	$update_phpfpm_max_requests = isset($_POST['update_phpfpm_max_requests']) ? (int) $_POST['update_phpfpm_max_requests'] : '0';

	if ($update_phpfpm_pm == 'dynamic') {
		$update_phpfpm_start_servers = isset($_POST['update_phpfpm_start_servers']) ? (int) $_POST['update_phpfpm_start_servers'] : '20';
		$update_phpfpm_min_spare_servers = isset($_POST['update_phpfpm_min_spare_servers']) ? (int) $_POST['update_phpfpm_min_spare_servers'] : '5';
		$update_phpfpm_max_spare_servers = isset($_POST['update_phpfpm_max_spare_servers']) ? (int) $_POST['update_phpfpm_max_spare_servers'] : '35';
	} else {
		$update_phpfpm_start_servers = 20;
		$update_phpfpm_min_spare_servers = 5;
		$update_phpfpm_max_spare_servers = 35;
	}

	if ($update_phpfpm_configdir == '') {
		$update_phpfpm_configdir = '/etc/php-fpm.d/';
	}
	if ($update_phpfpm_reload == '') {
		$update_phpfpm_reload = '/etc/init.d/php-fpm restart';
	}

	showUpdateStep("Adding new settings for PHP-FPM #1");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'phpfpm',
		`varname` = :varname,
		`value` = :value");
	Database::pexecute($stmt, array(
		'varname' => 'enabled',
		'value' => $update_phpfpm_enabled
	));
	Database::pexecute($stmt, array(
		'varname' => 'configdir',
		'value' => $update_phpfpm_configdir
	));
	Database::pexecute($stmt, array(
		'varname' => 'reload',
		'value' => $update_phpfpm_reload
	));
	Database::pexecute($stmt, array(
		'varname' => 'pm',
		'value' => $update_phpfpm_pm
	));
	Database::pexecute($stmt, array(
		'varname' => 'max_children',
		'value' => $update_phpfpm_max_children
	));
	Database::pexecute($stmt, array(
		'varname' => 'max_requests',
		'value' => $update_phpfpm_max_requests
	));
	Database::pexecute($stmt, array(
		'varname' => 'start_servers',
		'value' => $update_phpfpm_start_servers
	));
	Database::pexecute($stmt, array(
		'varname' => 'min_spare_servers',
		'value' => $update_phpfpm_min_spare_servers
	));
	Database::pexecute($stmt, array(
		'varname' => 'max_spare_servers',
		'value' => $update_phpfpm_max_spare_servers
	));
	Database::pexecute($stmt, array(
		'varname' => 'tmpdir',
		'value' => $update_phpfpm_tmpdir
	));
	Database::pexecute($stmt, array(
		'varname' => 'peardir',
		'value' => $update_phpfpm_peardir
	));
	lastStepStatus(0);

	updateToVersion('0.9.16-svn1');
}

if (isFroxlorVersion('0.9.16-svn1')) {
	showUpdateStep("Updating from 0.9.16-svn1 to 0.9.16-svn2", false);

	$update_phpfpm_enabled_ownvhost = isset($_POST['update_phpfpm_enabled_ownvhost']) ? (int) $_POST['update_phpfpm_enabled_ownvhost'] : '0';
	$update_phpfpm_httpuser = isset($_POST['update_phpfpm_httpuser']) ? $_POST['update_phpfpm_httpuser'] : 'froxlorlocal';
	$update_phpfpm_httpgroup = isset($_POST['update_phpfpm_httpgroup']) ? $_POST['update_phpfpm_httpgroup'] : 'froxlorlocal';

	if ($update_phpfpm_httpuser == '') {
		$update_phpfpm_httpuser = 'froxlorlocal';
	}
	if ($update_phpfpm_httpgroup == '') {
		$update_phpfpm_httpgroup = 'froxlorlocal';
	}

	showUpdateStep("Adding new settings for PHP-FPM #2");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'phpfpm',
		`varname` = :varname,
		`value` = :value");
	Database::pexecute($stmt, array(
		'varname' => 'enabled_ownvhost',
		'value' => $update_phpfpm_enabled_ownvhost
	));
	Database::pexecute($stmt, array(
		'varname' => 'vhost_httpuser',
		'value' => $update_phpfpm_httpuser
	));
	Database::pexecute($stmt, array(
		'varname' => 'vhost_httpgroup',
		'value' => $update_phpfpm_httpgroup
	));
	lastStepStatus(0);

	updateToVersion('0.9.16-svn2');
}

if (isFroxlorVersion('0.9.16-svn2')) {
	showUpdateStep("Updating from 0.9.16-svn2 to 0.9.16 final");
	lastStepStatus(0);
	updateToVersion('0.9.16');
}

if (isFroxlorVersion('0.9.16')) {

	showUpdateStep("Updating from 0.9.16 to 0.9.17-svn1", false);

	$update_system_report_enable = isset($_POST['update_system_report_enable']) ? (int) $_POST['update_system_report_enable'] : '1';
	$update_system_report_webmax = isset($_POST['update_system_report_webmax']) ? (int) $_POST['update_system_report_webmax'] : '90';
	$update_system_report_trafficmax = isset($_POST['update_system_report_trafficmax']) ? (int) $_POST['update_system_report_trafficmax'] : '90';

	showUpdateStep("Adding new settings for web- and traffic-reporting");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = :varname,
		`value` = :value");
	Database::pexecute($stmt, array(
		'varname' => 'report_enable',
		'value' => $update_system_report_enable
	));
	Database::pexecute($stmt, array(
		'varname' => 'report_webmax',
		'value' => $update_system_report_webmax
	));
	Database::pexecute($stmt, array(
		'varname' => 'report_trafficmax',
		'value' => $update_system_report_trafficmax
	));
	lastStepStatus(0);

	showUpdateStep("Adding new cron-module for web- and traffic-reporting");
	$clastrun = mktime(6, 0, 0, date('m'), date('d') - 1, date('Y'));
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_CRONRUNS . "` SET
		`module` = 'froxlor/reports',
		`cronfile` = 'cron_usage_report.php',
		`interval` = '1 DAY',
		`desc_lng_key` = 'cron_usage_report',
		`lastrun` = :lastrun,
		`isactive` = :isactive");
	Database::pexecute($stmt, array(
		'lastrun' => $clastrun,
		'isactive' => $update_system_report_enable
	));
	lastStepStatus(0);

	showUpdateStep("Updating various database-fields");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'last_traffic_report_run';");

	$check_stmt = Database::query("
		SELECT `varname` FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `varname` = 'trafficninetypercent_subject';");
	Database::pexecute($check_stmt);
	$check = $check_stmt->fetch(PDO::FETCH_ASSOC);

	if (isset($check['varname']) && $check['varname'] == 'trafficninetypercent_subject') {
		Database::query("UPDATE `" . TABLE_PANEL_TEMPLATES . "` SET `varname` = 'trafficmaxpercent_subject' WHERE `varname` = 'trafficninetypercent_subject';");
	}

	$check_stmt = Database::query("
		SELECT `varname` FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `varname` = 'trafficninetypercent_mailbody';");
	Database::pexecute($check_stmt);
	$check = $check_stmt->fetch(PDO::FETCH_ASSOC);

	if (isset($check['varname']) && $check['varname'] == 'trafficninetypercent_mailbody') {
		Database::query("UPDATE `" . TABLE_PANEL_TEMPLATES . "` SET `varname` = 'trafficmaxpercent_mailbody' WHERE `varname` = 'trafficninetypercent_mailbody';");
	}
	lastStepStatus(0);

	updateToVersion('0.9.17-svn1');
}

if (isFroxlorVersion('0.9.17-svn1')) {

	showUpdateStep("Updating from 0.9.17-svn1 to 0.9.17-svn2", false);

	showUpdateStep("Adding new tables to database");
	Database::query("CREATE TABLE IF NOT EXISTS `ipsandports_docrootsettings` (
			`id` int(5) NOT NULL auto_increment,
			`fid` int(11) NOT NULL,
			`docrootsettings` text NOT NULL,
			PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;");
	Database::query("CREATE TABLE IF NOT EXISTS `domain_docrootsettings` (
			`id` int(5) NOT NULL auto_increment,
			`fid` int(11) NOT NULL,
			`docrootsettings` text NOT NULL,
			PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;");
	lastStepStatus(0);

	updateToVersion('0.9.17-svn2');
}

if (isFroxlorVersion('0.9.17-svn2')) {
	showUpdateStep("Updating from 0.9.17-svn2 to 0.9.17 final");
	lastStepStatus(0);
	updateToVersion('0.9.17');
}

if (isFroxlorVersion('0.9.17')) {

	showUpdateStep("Updating from 0.9.17 to 0.9.18-svn1", false);

	showUpdateStep("Checking whether you are missing any settings", false);
	$nonefound = true;

	$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'httpgroup'");
	$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

	if (! isset($result) || ! isset($result['value'])) {
		$nonefound = false;
		showUpdateStep("Adding missing setting 'httpgroup'");
		$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
			`settinggroup` = 'system',
			`varname` = 'httpgroup',
			`value` = :value");
		Database::pexecute($stmt, array(
			'value' => Settings::Get('system.httpuser')
		));
		lastStepStatus(0);
	}

	if ($nonefound) {
		showUpdateStep("No missing settings found ;-)");
		lastStepStatus(0);
	}

	updateToVersion('0.9.18-svn1');
}

if (isFroxlorVersion('0.9.18-svn1')) {

	showUpdateStep("Updating from 0.9.18-svn1 to 0.9.18-svn2", false);

	$update_default_theme = isset($_POST['update_default_theme']) ? $_POST['update_default_theme'] : 'Froxlor';

	showUpdateStep("Adding new settings for themes");
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
			`settinggroup` = 'panel',
			`varname` = 'default_theme',
			`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $update_default_theme
	));
	lastStepStatus(0);

	showUpdateStep("Delete old setting for header-graphic");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup`='admin' AND `varname` = 'froxlor_graphic';");
	lastStepStatus(0);

	showUpdateStep("Updating table layouts");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `theme` varchar(255) NOT NULL default 'Froxlor' AFTER `email_autoresponder_used`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `theme` varchar(255) NOT NULL default 'Froxlor' AFTER `email_autoresponder_used`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_SESSIONS . "` ADD `theme` varchar(255) NOT NULL default '' AFTER `adminsession`;");
	lastStepStatus(0);

	updateToVersion('0.9.18-svn2');
}

if (isFroxlorVersion('0.9.18-svn2')) {
	showUpdateStep("Updating from 0.9.18-svn2 to 0.9.18 final");
	lastStepStatus(0);
	updateToVersion('0.9.18');
}

if (isFroxlorVersion('0.9.18')) {
	showUpdateStep("Updating from 0.9.18 to 0.9.18.1");
	lastStepStatus(0);
	updateToVersion('0.9.18.1');
}

if (isFroxlorVersion('0.9.18.1')) {
	showUpdateStep("Updating from 0.9.18.1 to 0.9.19");
	lastStepStatus(0);
	updateToVersion('0.9.19');
}

if (isFroxlorVersion('0.9.19')) {
	showUpdateStep("Updating from 0.9.19 to 0.9.20-svn1");
	lastStepStatus(0);

	showUpdateStep("Adding new setting for domain validation");
	Database::query("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
			`settinggroup` = 'system',
			`varname` = 'validate_domain',
			`value` = '1'");
	lastStepStatus(0);

	updateToVersion('0.9.20-svn1');
}

if (isFroxlorVersion('0.9.20-svn1')) {

	showUpdateStep("Updating from 0.9.20-svn1 to 0.9.20-svn2");

	// adding backup stuff
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `backup_allowed` TINYINT( 1 ) NOT NULL DEFAULT '1'");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `backup_enabled` TINYINT( 1 ) NOT NULL DEFAULT '0'");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_enabled', '0')");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_dir', '#froxlor_backup')");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_mysqldump_path', '/usr/bin/mysqldump')");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_count', '1')");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_bigfile', '1')");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_enabled', '0')");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_server', '')");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_user', '')");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_pass', '')");
	Database::query("INSERT INTO `" . TABLE_PANEL_CRONRUNS . "` (`module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES ('froxlor/backup', 'cron_backup.php', '1 DAY', '1', 'cron_backup');");
	lastStepStatus(0);

	updateToVersion('0.9.20-svn2');
}

if (isFroxlorVersion('0.9.20-svn2')) {
	showUpdateStep("Updating from 0.9.20-svn2 to 0.9.20");
	lastStepStatus(0);
	updateToVersion('0.9.20');
}

if (isFroxlorVersion('0.9.20')) {
	showUpdateStep("Updating from 0.9.20 to 0.9.20.1");
	lastStepStatus(0);
	updateToVersion('0.9.20.1');
}

if (isFroxlorVersion('0.9.20.1')) {

	showUpdateStep("Updating from 0.9.20.1 to 0.9.20.1-svn1");
	lastStepStatus(0);

	showUpdateStep("Fixing possible broken tables");

	// The customer-table may miss the columns, if installed a fresh 0.9.20 or 0.9.20.1 - add them
	$result = Database::query("DESCRIBE `" . TABLE_PANEL_CUSTOMERS . "`");
	$columnfound = 0;
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		if ($row['Field'] == 'backup_allowed') {
			$columnfound = 1;
		}
	}
	if (! $columnfound) {
		Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `backup_allowed` TINYINT( 1 ) NOT NULL DEFAULT '1'");
		Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `backup_enabled` TINYINT( 1 ) NOT NULL DEFAULT '0'");
	}

	// The admin-table may have the columns, if installed a fresh 0.9.20.1 - remove them
	$result = Database::query("DESCRIBE `" . TABLE_PANEL_ADMINS . "`");
	$columnfound = 0;
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		if ($row['Field'] == 'backup_allowed') {
			$columnfound = 1;
		}
	}
	if ($columnfound) {
		Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `backup_allowed`;");
		Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `backup_enabled`;");
	}
	lastStepStatus(0);

	updateToVersion('0.9.20.1-svn1');
}

if (isFroxlorVersion('0.9.20.1-svn1') || isFroxlorVersion('0.9.20.2-svn1')) {

	showUpdateStep("Updating from 0.9.20.1-svn1 to 0.9.21-svn1");
	lastStepStatus(0);

	// add table column for gender
	showUpdateStep("Add column for gender to customers");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `gender` INT( 1 ) NOT NULL DEFAULT '0' AFTER `firstname`");
	lastStepStatus(0);

	updateToVersion('0.9.21-svn1');
}

if (isFroxlorVersion('0.9.21-svn1')) {

	showUpdateStep("Updating from 0.9.21-svn1 to 0.9.21-svn2");
	lastStepStatus(0);

	/* add new setting: backup FTP mode */
	showUpdateStep("Add new settings for backup ftp-mode");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_passive', '1')");
	lastStepStatus(0);

	updateToVersion('0.9.21-svn2');
}

if (isFroxlorVersion('0.9.21-svn2')) {
	showUpdateStep("Updating from 0.9.21-svn2 to 0.9.21");
	lastStepStatus(0);
	updateToVersion('0.9.21');
}

if (isFroxlorVersion('0.9.21')) {

	showUpdateStep("Updating from 0.9.21 to 0.9.22-svn1");
	lastStepStatus(0);

	/* add new settings for diskspacequota - support */
	showUpdateStep("Add new settings for diskspacequota support");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'diskquota_enabled', '0');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'diskquota_repquota_path', '/usr/sbin/repquota');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'diskquota_quotatool_path', '/usr/bin/quotatool');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'diskquota_customer_partition', '/dev/root');");
	lastStepStatus(0);

	updateToVersion('0.9.22-svn1');
}

if (isFroxlorVersion('0.9.22-svn1')) {

	showUpdateStep("Updating from 0.9.22-svn1 to 0.9.22-svn2");
	lastStepStatus(0);

	/* fix backup_dir for #186 */
	Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/var/customers/backups/' WHERE `varname` = 'backup_dir';");

	updateToVersion('0.9.22-svn2');
}

if (isFroxlorVersion('0.9.22-svn2')) {
	showUpdateStep("Updating from 0.9.22-svn2 to 0.9.22-rc1");
	lastStepStatus(0);
	updateToVersion('0.9.22-rc1');
}

if (isFroxlorVersion('0.9.22-rc1')) {
	showUpdateStep("Updating from 0.9.22-rc1 to 0.9.22");
	lastStepStatus(0);
	updateToVersion('0.9.22');
}

if (isFroxlorVersion('0.9.22')) {
	showUpdateStep("Updating from 0.9.22 to 0.9.23-rc1");
	lastStepStatus(0);
	updateToVersion('0.9.23-rc1');
}

if (isFroxlorVersion('0.9.23-rc1')) {
	showUpdateStep("Updating from 0.9.23-rc1 to 0.9.23");
	lastStepStatus(0);
	updateToVersion('0.9.23');
}

if (isFroxlorVersion('0.9.23')) {

	showUpdateStep("Updating from 0.9.23 to 0.9.24-svn1");
	lastStepStatus(0);

	/* add new settings for logrotate - support */
	showUpdateStep("Add new settings for logrotate support");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'logrotate_enabled', '0');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'logrotate_binary', '/usr/sbin/logrotate');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'logrotate_interval', 'weekly');");
	Database::query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'logrotate_keep', '4');");
	lastStepStatus(0);

	updateToVersion('0.9.24-svn1');
}

if (isFroxlorVersion('0.9.24-svn1')) {
	showUpdateStep("Updating from 0.9.24-svn1 to 0.9.24-rc1");
	lastStepStatus(0);
	updateToVersion('0.9.24-rc1');
}

if (isFroxlorVersion('0.9.24-rc1')) {
	showUpdateStep("Updating from 0.9.24-rc1 to 0.9.24");
	lastStepStatus(0);
	updateToVersion('0.9.24');
}

if (isFroxlorVersion('0.9.24')) {
	showUpdateStep("Updating from 0.9.24 to 0.9.25-rc1");
	lastStepStatus(0);
	updateToVersion('0.9.25-rc1');
}

if (isFroxlorVersion('0.9.25-rc1')) {
	showUpdateStep("Updating from 0.9.25-rc1 to 0.9.25");
	lastStepStatus(0);
	updateToVersion('0.9.25');
}

if (isFroxlorVersion('0.9.25')) {
	showUpdateStep("Updating from 0.9.25 to 0.9.26-svn1");
	lastStepStatus(0);
	// enable bind by default
	Database::query("INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'bind_enable', '1')");
	updateToVersion('0.9.26-svn1');
}

if (isFroxlorVersion('0.9.26-svn1')) {
	showUpdateStep("Updating from 0.9.26-svn1 to 0.9.26-rc1");
	lastStepStatus(0);
	updateToVersion('0.9.26-rc1');
}

if (isFroxlorVersion('0.9.26-rc1')) {
	showUpdateStep("Updating from 0.9.26-rc1 to 0.9.26");
	lastStepStatus(0);
	updateToVersion('0.9.26');
}

if (isFroxlorVersion('0.9.26')) {

	showUpdateStep("Updating from 0.9.26 to 0.9.27-svn1");
	lastStepStatus(0);

	// check for multiple backup_ftp_enabled entries
	$handle = Database::query("SELECT `value` FROM `panel_settings` WHERE `varname` = 'backup_ftp_enabled';");

	// if there are more than one entries try to fix it
	if (Database::num_rows() > 1) {
		$rows = $handle->fetch(PDO::FETCH_ASSOC);
		$state = false;

		// iterate through all found entries
		// and try to guess what value it should be
		foreach ($rows as $row) {
			$state = $state | $row['value'];
		}

		// now delete all entries
		Database::query("DELETE FROM `panel_settings` WHERE `varname` = 'backup_ftp_enabled';");

		// and re-add it
		$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
			`settinggroup` = 'system',
			`varname` = 'backup_ftp_enabled',
			`value` = :value");
		Database::pexecute($stmt, array(
			'value' => $state
		));
	}

	updateToVersion('0.9.27-svn1');
}

if (isFroxlorVersion('0.9.27-svn1')) {

	showUpdateStep("Updating from 0.9.27-svn1 to 0.9.27-svn2");
	lastStepStatus(0);

	// Get FastCGI timeout setting if available
	$handle = Database::query("SELECT `value` FROM `panel_settings` WHERE `settinggroup` = 'system' AND `varname` = 'mod_fcgid_idle_timeout';");

	// If timeout is set then skip
	if (Database::num_rows() < 1) {
		Database::query("INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_idle_timeout', '30');");
	}

	// Get FastCGI timeout setting if available
	$handle = Database::query("SELECT `value` FROM `panel_settings` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'idle_timeout';");

	// If timeout is set then skip
	if (Database::num_rows() < 1) {
		Database::query("INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'idle_timeout', '30');");
	}

	updateToVersion('0.9.27-svn2');
}

if (isFroxlorVersion('0.9.27-svn2')) {
	showUpdateStep("Updating from 0.9.27-svn2 to 0.9.27-rc1");
	lastStepStatus(0);
	updateToVersion('0.9.27-rc1');
}

if (isFroxlorVersion('0.9.27-rc1')) {
	showUpdateStep("Updating from 0.9.27-rc1 to 0.9.27");
	lastStepStatus(0);
	updateToVersion('0.9.27');
}

if (isFroxlorVersion('0.9.27')) {

	showUpdateStep("Updating from 0.9.27 to 0.9.28-svn1");
	lastStepStatus(0);

	// Get AliasconfigDir setting if available
	$handle = Database::query("SELECT `value` FROM `panel_settings` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'aliasconfigdir';");

	// If AliasconfigDir is set then skip
	if (Database::num_rows() < 1) {
		Database::query("INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'aliasconfigdir', '/var/www/php-fpm/');");
	}

	updateToVersion('0.9.28-svn1');
}

if (isFroxlorVersion('0.9.28-svn1')) {

	showUpdateStep("Updating from 0.9.28-svn1 to 0.9.28-svn2");
	lastStepStatus(0);

	// Insert ISO-Codes into database. Default value is foo, which is not a valid language code.
	Database::query("ALTER TABLE  `panel_languages` ADD  `iso` CHAR( 3 ) NOT NULL DEFAULT  'foo' AFTER  `language`");

	$handle = Database::query("SELECT `language` FROM `panel_languages` WHERE `iso`='foo'");

	while ($language = $handle->fetch(PDO::FETCH_ASSOC)) {
		switch ($language) {
			case "Deutsch":
				Database::query("UPDATE `panel_languages` SET `iso`='de' WHERE `language` = 'Deutsch'");
				break;
			case "English":
				Database::query("UPDATE `panel_languages` SET `iso`='en' WHERE `language` = 'English'");
				break;
			case "Fran&ccedil;ais":
				Database::query("UPDATE `panel_languages` SET `iso`='fr' WHERE `language` = 'Fran&ccedil;ais'");
				break;
			case "Chinese":
				Database::query("UPDATE `panel_languages` SET `iso`='zh' WHERE `language` = 'Chinese'");
				break;
			case "Catalan":
				Database::query("UPDATE `panel_languages` SET `iso`='ca' WHERE `language` = 'Catalan'");
				break;
			case "Espa&ntilde;ol":
				Database::query("UPDATE `panel_languages` SET `iso`='es' WHERE `language` = 'Espa&ntilde;ol'");
				break;
			case "Portugu&ecirc;s":
				Database::query("UPDATE `panel_languages` SET `iso`='pt' WHERE `language` = 'Portugu&ecirc;s'");
				break;
			case "Danish":
				Database::query("UPDATE `panel_languages` SET `iso`='da' WHERE `language` = 'Danish'");
				break;
			case "Italian":
				Database::query("UPDATE `panel_languages` SET `iso`='it' WHERE `language` = 'Italian'");
				break;
			case "Bulgarian":
				Database::query("UPDATE `panel_languages` SET `iso`='bg' WHERE `language` = 'Bulgarian'");
				break;
			case "Slovak":
				Database::query("UPDATE `panel_languages` SET `iso`='sk' WHERE `language` = 'Slovak'");
				break;
			case "Dutch":
				Database::query("UPDATE `panel_languages` SET `iso`='nl' WHERE `language` = 'Dutch'");
				break;
			case "Russian":
				Database::query("UPDATE `panel_languages` SET `iso`='ru' WHERE `language` = 'Russian'");
				break;
			case "Hungarian":
				Database::query("UPDATE `panel_languages` SET `iso`='hu' WHERE `language` = 'Hungarian'");
				break;
			case "Swedish":
				Database::query("UPDATE `panel_languages` SET `iso`='sv' WHERE `language` = 'Swedish'");
				break;
			case "Czech":
				Database::query("UPDATE `panel_languages` SET `iso`='cz' WHERE `language` = 'Czech'");
				break;
			case "Polski":
				Database::query("UPDATE `panel_languages` SET `iso`='pl' WHERE `language` = 'Polski'");
				break;
			default:
				showUpdateStep("Sorry, but I don't know the ISO-639 language code for " . $language . ". Please update the entry in `panel_languages` manually.\n");
		}
	}

	updateToVersion('0.9.28-svn2');
}

if (isFroxlorVersion('0.9.28-svn2')) {

	showUpdateStep("Updating from 0.9.28-svn2 to 0.9.28-svn3");
	lastStepStatus(0);

	// change length of passwd column
	Database::query("ALTER TABLE `" . TABLE_FTP_USERS . "` MODIFY `password` varchar(128) NOT NULL default ''");

	// Add default setting for vmail_maildirname if not already in place
	$handle = Database::query("SELECT `value` FROM `panel_settings` WHERE `settinggroup` = 'system' AND `varname` = 'vmail_maildirname';");
	if (Database::num_rows() < 1) {
		showUpdateStep("Adding default Maildir value into Mailserver settings.");
		Database::query("INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'vmail_maildirname', 'Maildir');");
	}

	updateToVersion('0.9.28-svn3');
}

if (isFroxlorVersion('0.9.28-svn3')) {

	showUpdateStep("Updating from 0.9.28-svn3 to 0.9.28-svn4", true);
	lastStepStatus(0);

	if (isset($_POST['classic_theme_replacement']) && $_POST['classic_theme_replacement'] != '') {
		$classic_theme_replacement = $_POST['classic_theme_replacement'];
	} else {
		$classic_theme_replacement = 'Froxlor';
	}
	showUpdateStep('Setting replacement for the discontinued and removed Classic theme (if active)', true);

	// Updating default theme setting
	if (Settings::Get('panel.default_theme') == 'Classic') {
		$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_SETTINGS . "` SET
				`value` = :theme
			WHERE `varname` = 'default_theme';");
		Database::pexecute($upd_stmt, array(
			'theme' => $classic_theme_replacement
		));
	}

	// Updating admin's theme setting
	$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_ADMINS . "` SET
				`theme` = :theme
			WHERE `theme` = 'Classic';");
	Database::pexecute($upd_stmt, array(
		'theme' => $classic_theme_replacement
	));

	// Updating customer's theme setting
	$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET
				`theme` = :theme
			WHERE `theme` = 'Classic';");
	Database::pexecute($upd_stmt, array(
		'theme' => $classic_theme_replacement
	));

	// Updating theme setting of active sessions
	$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_SESSIONS . "` SET
				`theme` = :theme
			WHERE `theme` = 'Classic';");
	Database::pexecute($upd_stmt, array(
		'theme' => $classic_theme_replacement
	));

	lastStepStatus(0);

	showUpdateStep('Altering Froxlor database and tables to use UTF-8. This may take a while..', true);

	Database::query('ALTER DATABASE `' . Database::getDbName() . '` CHARACTER SET utf8 COLLATE utf8_general_ci');

	$handle = Database::query('SHOW TABLES');
	while ($row = $handle->fetch(PDO::FETCH_ASSOC)) {
		foreach ($row as $table) {
			Database::query('ALTER TABLE `' . $table . '` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');
		}
	}

	lastStepStatus(0);

	updateToVersion('0.9.28-svn4');
}

if (isFroxlorVersion('0.9.28-svn4')) {

	showUpdateStep("Updating from 0.9.28-svn4 to 0.9.28-svn5");

	// Catchall functionality (enabled by default) see #1114
	showUpdateStep('Enabling catchall by default');
	Database::query("INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('catchall', 'catchall_enabled', '1');");
	lastStepStatus(0);

	updateToVersion('0.9.28-svn5');
}

if (isFroxlorVersion('0.9.28-svn5')) {

	showUpdateStep("Updating from 0.9.28-svn5 to 0.9.28-svn6", true);
	lastStepStatus(0);

	$update_system_apache24 = isset($_POST['update_system_apache24']) ? (int) $_POST['update_system_apache24'] : '0';
	showUpdateStep('Setting value for apache-2.4 modification', true);
	// support for Apache-2.4
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = 'apache24',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $update_system_apache24
	));
	lastStepStatus(0);

	showUpdateStep("Inserting new tickets-see-all field to panel_admins", true);
	Database::query("ALTER TABLE `panel_admins` ADD `tickets_see_all` tinyint(1) NOT NULL default '0' AFTER `tickets_used`");
	lastStepStatus(0);

	showUpdateStep("Updating main admin entry", true);
	$stmt = Database::prepare("
		UPDATE `" . TABLE_PANEL_ADMINS . "` SET
		`tickets_see_all` = '1'
		WHERE `adminid` = :adminid");
	Database::pexecute($stmt, array(
		'adminid' => $userinfo['adminid']
	));
	lastStepStatus(0);

	showUpdateStep("Inserting new panel webfont-settings (default: off)", true);
	Database::query("INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'use_webfonts', '0');");
	Database::query("INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'webfont', 'Numans');");
	lastStepStatus(0);

	showUpdateStep("Inserting settings for nginx fastcgi-params file", true);
	$fastcgiparams = '/etc/nginx/fastcgi_params';
	if (isset($_POST['nginx_fastcgi_params']) && $_POST['nginx_fastcgi_params'] != '') {
		$fastcgiparams = makeCorrectFile($_POST['nginx_fastcgi_params']);
	}
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'nginx',
		`varname` = 'fastcgiparams',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $fastcgiparams
	));
	lastStepStatus(0);

	updateToVersion('0.9.28-svn6');
}

if (isFroxlorVersion('0.9.28-svn6')) {
	showUpdateStep("Updating from 0.9.28-svn6 to 0.9.28 release candidate 1");
	lastStepStatus(0);
	updateToVersion('0.9.28-rc1');
}

if (isFroxlorVersion('0.9.28-rc1')) {

	showUpdateStep("Updating from 0.9.28-rc1 to 0.9.28-rc2", true);
	lastStepStatus(0);

	$update_system_documentroot_use_default_value = isset($_POST['update_system_documentroot_use_default_value']) ? (int) $_POST['update_system_documentroot_use_default_value'] : '0';
	showUpdateStep("Adding new settings for using domain name as default value for DocumentRoot path", true);
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = 'documentroot_use_default_value',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $update_system_documentroot_use_default_value
	));
	lastStepStatus(0);

	updateToVersion('0.9.28-rc2');
}

if (isFroxlorVersion('0.9.28-rc2')) {
	showUpdateStep("Updating from 0.9.28-rc2 to 0.9.28 final", true);
	Database::query("DELETE FROM `panel_settings` WHERE `settinggroup`='system' AND `varname`='mod_log_sql'");
	Database::query("DELETE FROM `panel_settings` WHERE `settinggroup`='system' AND `varname`='openssl_cnf'");
	Database::query("ALTER TABLE `panel_domains` DROP `safemode`");
	lastStepStatus(0);

	updateToVersion('0.9.28');
}

if (isFroxlorVersion('0.9.28')) {
	showUpdateStep("Updating from 0.9.28 final to 0.9.28.1");
	lastStepStatus(0);
	updateToVersion('0.9.28.1');
}

if (isFroxlorVersion('0.9.28.1')) {

	showUpdateStep("Updating from 0.9.28.1 to 0.9.29-dev1", true);
	lastStepStatus(0);

	$hide_stdsubdomains = isset($_POST['hide_stdsubdomains']) ? (int) $_POST['hide_stdsubdomains'] : '0';
	showUpdateStep('Setting value for "hide standard subdomains"', true);
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'panel',
		`varname` = 'phpconfigs_hidestdsubdomain',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $hide_stdsubdomains
	));
	lastStepStatus(0);

	// don't advertise security questions - just set a default silently
	Database::query("INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'passwordcryptfunc', '1');");

	$fastcgiparams = Settings::Get('nginx.fastcgiparams');
	// check the faulty value explicitly
	if ($fastcgiparams == '/etc/nginx/fastcgi_params/') {
		$fastcgiparams = makeCorrectFile(substr($fastcgiparams, 0, - 1));
		$stmt = Database::prepare("
		UPDATE `" . TABLE_PANEL_SETTINGS . "` SET
			`value` = :value
		WHERE `varname` = 'fastcgiparams'");
		Database::pexecute($stmt, array(
			'value' => $fastcgiparams
		));
	}
	updateToVersion('0.9.29-dev1');
}

if (isFroxlorVersion('0.9.29-dev1')) {

	showUpdateStep("Updating from 0.9.29-dev1 to 0.9.29-dev2", true);
	lastStepStatus(0);

	$allow_themechange_c = isset($_POST['allow_themechange_c']) ? (int) $_POST['allow_themechange_c'] : '1';
	$allow_themechange_a = isset($_POST['allow_themechange_a']) ? (int) $_POST['allow_themechange_a'] : '1';
	showUpdateStep("Inserting new setting to allow/disallow theme changes (default: on)", true);
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'panel',
		`varname` = :varname,
		`value` = :value");
	Database::pexecute($stmt, array(
		'varname' => 'allow_theme_change_admin',
		'value' => $allow_themechange_a
	));
	Database::pexecute($stmt, array(
		'varname' => 'allow_theme_change_customer',
		'value' => $allow_themechange_c
	));
	lastStepStatus(0);

	updateToVersion('0.9.29-dev2');
}

if (isFroxlorVersion('0.9.29-dev2')) {

	showUpdateStep("Updating from 0.9.29-dev2 to 0.9.29-dev3", true);
	lastStepStatus(0);

	$system_axfrservers = isset($_POST['system_afxrservers']) ? trim($_POST['system_afxrservers']) : '';
	if ($system_axfrservers != '') {
		$axfrservers = explode(',', $system_axfrservers);
		$newaxfrserver = array();
		foreach ($axfrservers as $index => $axfrserver) {
			if (validate_ip($axfrserver, true) !== false) {
				$newaxfrserver[] = $axfrserver;
			}
		}
		$system_axfrservers = implode(", ", $newaxfrserver);
	}
	showUpdateStep("Inserting new setting for AXFR server", true);
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = 'axfrservers',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $system_axfrservers
	));
	lastStepStatus(0);

	updateToVersion('0.9.29-dev3');
}

if (isFroxlorVersion('0.9.29-dev3')) {

	showUpdateStep("Updating from 0.9.29-dev3 to 0.9.29-dev4", true);
	lastStepStatus(0);

	showUpdateStep("Adding new tables to database", true);
	Database::query("CREATE TABLE IF NOT EXISTS `domain_ssl_settings` (
			`id` int(5) NOT NULL auto_increment,
			`domainid` int(11) NOT NULL,
			`ssl_cert_file` text NOT NULL,
			`ssl_key_file` text NOT NULL,
			`ssl_ca_file` text NOT NULL,
			`ssl_cert_chainfile` text NOT NULL,
			PRIMARY KEY  (`id`)
	) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;");
	lastStepStatus(0);

	$system_customersslpath = isset($_POST['system_customersslpath']) ? makeCorrectDir($_POST['system_customersslpath']) : '/etc/ssl/froxlor-custom/';
	if (trim($system_customersslpath) == '/') {
		// prevent users from specifying nonsense here
		$system_customersslpath = '/etc/ssl/froxlor-custom/';
	}
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'system',
		`varname` = 'customer_ssl_path',
		`value` = :value");
	Database::pexecute($stmt, array(
		'value' => $system_customersslpath
	));
	updateToVersion('0.9.29-dev4');
}

if (isFroxlorVersion('0.9.29-dev4')) {

	showUpdateStep("Updating from 0.9.29-dev4 to 0.9.29-rc1", true);
	lastStepStatus(0);

	// check for wrong vmail_maildirname database-field-name (bug #1242)
	showUpdateStep("correcting Maildir setting database-field-name (if needed).", true);
	Database::query("UPDATE `panel_settings` SET `varname` = 'vmail_maildirname' WHERE `settinggroup` = 'system' AND `varname` = 'vmail_maildir'");
	lastStepStatus(0);

	showUpdateStep("setting default php-configuration for php-fpm", true);
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET
		`settinggroup` = 'phpfpm',
		`varname` = :varname,
		`value` = :value");
	$dval = (Settings::Get('system.mod_fcgid_defaultini') !== null ? Settings::Get('system.mod_fcgid_defaultini') : '1');
	Database::pexecute($stmt, array(
		'varname' => 'defaultini',
		'value' => $dval
	));
	$dval = (Settings::Get('system.mod_fcgid_ownvhost') !== null ? Settings::Get('system.mod_fcgid_ownvhost') : '1');
	Database::pexecute($stmt, array(
		'varname' => 'vhost_defaultini',
		'value' => $dval
	));
	lastStepStatus(0);

	updateToVersion('0.9.29-rc1');
}

if (isFroxlorVersion('0.9.29-rc1')) {
	showUpdateStep("Updating from 0.9.29-rc1 to 0.9.29 final", true);
	lastStepStatus(0);
	updateToVersion('0.9.29');
}

if (isFroxlorVersion('0.9.29')) {

	showUpdateStep("Updating from 0.9.29 to 0.9.29.1-dev1", true);
	lastStepStatus(0);

	showUpdateStep("Adding new ip to domain - mapping-table");
	Database::query("DROP TABLE IF EXISTS `panel_domaintoip`;");
	$sql = "CREATE TABLE `" . TABLE_DOMAINTOIP . "` (
			`id_domain` int(11) unsigned NOT NULL,
			`id_ipandports` int(11) unsigned NOT NULL,
			PRIMARY KEY (`id_domain`, `id_ipandports`)
			) ENGINE=MyISAM ;";
	Database::query($sql);
	lastStepStatus(0);

	showUpdateStep("Convert old domain to ip - mappings");
	$result = Database::query("SELECT `id`, `ipandport`, `ssl_ipandport`, `ssl_redirect`, `parentdomainid` FROM `" . TABLE_PANEL_DOMAINS . "`;");

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

		if ((int) $row['ipandport'] != 0) {
			Database::query("INSERT INTO `" . TABLE_DOMAINTOIP . "` SET
					`id_domain` = " . (int) $row['id'] . ",
					`id_ipandports` = " . (int) $row['ipandport']);
		}
		if ((int) $row['ssl_ipandport'] != 0) {
			Database::query("INSERT INTO `" . TABLE_DOMAINTOIP . "` SET
					`id_domain` = " . (int) $row['id'] . ",
					`id_ipandports` = " . (int) $row['ssl_ipandport']);
		}		// Subdomains also have ssl ports if the parent has
		elseif ((int) $row['ssl_ipandport'] == 0 && (int) $row['ssl_redirect'] != 0 && (int) $row['parentdomainid'] != 0) {
			Database::query("INSERT INTO `" . TABLE_DOMAINTOIP . "` SET
					`id_domain` = " . (int) $row['id'] . ",
					`id_ipandports` = (
					SELECT `ssl_ipandport` FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `id` = '" . (int) $row['parentdomainid'] . "');");
		}
	}
	lastStepStatus(0);

	showUpdateStep("Updating table layouts");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` DROP `ipandport`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` DROP `ssl`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` DROP `ssl_ipandport`;");
	lastStepStatus(0);

	updateToVersion('0.9.29.1-dev1');
}

if (isFroxlorVersion('0.9.29.1-dev1')) {

	showUpdateStep("Updating from 0.9.29.1-dev1 to 0.9.29.1-dev2", true);
	lastStepStatus(0);

	showUpdateStep("Updating table layouts and contents");
	Database::query("ALTER TABLE `" . TABLE_MAIL_USERS . "` ADD `mboxsize` bigint(30) NOT NULL default '0' AFTER `imap`;");
	Database::query("INSERT INTO `cronjobs_run` SET `module` = 'froxlor/core', `cronfile` = 'cron_mailboxsize.php', `interval` = '6 HOUR', `isactive` = '1', `desc_lng_key` = 'cron_mailboxsize';");
	lastStepStatus(0);

	updateToVersion('0.9.29.1-dev2');
}

if (isFroxlorVersion('0.9.29.1-dev2')) {

	showUpdateStep("Updating from 0.9.29.1-dev2 to 0.9.29.1-dev3", true);
	lastStepStatus(0);

	showUpdateStep("Removing old logrotate settings");
	Database::query("DELETE FROM `panel_settings` WHERE `varname` = 'logrotate_enabled';");
	Database::query("DELETE FROM `panel_settings` WHERE `varname` = 'logrotate_binary';");
	Database::query("DELETE FROM `panel_settings` WHERE `varname` = 'logrotate_interval';");
	Database::query("DELETE FROM `panel_settings` WHERE `varname` = 'logrotate_keep';");
	lastStepStatus(0);

	updateToVersion('0.9.29.1-dev3');
}

if (isFroxlorVersion('0.9.29.1-dev3')) {

	showUpdateStep("Updating from 0.9.29.1-dev3 to 0.9.29.1-dev4", true);
	lastStepStatus(0);

	// If you upgraded from SysCP the edit_billingdata field has been
	// removed in one of the first upgrades to froxlor. Sadly, one field
	// remained in the install.sql so we remove it now if it exists
	$bd_exists = Database::query("SHOW COLUMNS FROM `" . TABLE_PANEL_ADMINS . "` LIKE 'edit_billingdata';");
	if (Database::num_rows() > 0) {
		showUpdateStep("Removing old billing-field from admin-users");
		Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `edit_billingdata`");
		lastStepStatus(0);
	}

	updateToVersion('0.9.29.1-dev4');
}

if (isFroxlorVersion('0.9.29.1-dev4')) {
	showUpdateStep("Updating from 0.9.29.1-dev4 to 0.9.30-dev1", true);
	lastStepStatus(0);
	updateToVersion('0.9.30-dev1');
}

if (isFroxlorVersion('0.9.30-dev1')) {
	showUpdateStep("Updating from 0.9.30-dev1 to 0.9.30-rc1", true);
	lastStepStatus(0);
	updateToVersion('0.9.30-rc1');
}

if (isFroxlorVersion('0.9.30-rc1')) {

	showUpdateStep("Updating from 0.9.30-rc1 to 0.9.30 final", true);
	lastStepStatus(0);

	showUpdateStep("Adding ssl-cipher-list setting");
	Database::query("INSERT INTO `panel_settings` SET `settinggroup` = 'system', `varname` = 'ssl_cipher_list', `value` = 'ECDHE-RSA-AES128-SHA256:AES128-GCM-SHA256:RC4:HIGH:!MD5:!aNULL:!EDH'");
	lastStepStatus(0);

	updateToVersion('0.9.30');
}

if (isFroxlorVersion('0.9.30')) {

	showUpdateStep("Updating from 0.9.30 to 0.9.31-dev1", true);
	lastStepStatus(0);

	showUpdateStep("Removing unsused tables");
	Database::query("DROP TABLE IF EXISTS `ipsandports_docrootsettings`;");
	Database::query("DROP TABLE IF EXISTS `domain_docrootsettings`;");
	lastStepStatus(0);

	updateToVersion('0.9.31-dev1');
}

if (isFroxlorVersion('0.9.31-dev1')) {

	showUpdateStep("Updating from 0.9.31-dev1 to 0.9.31-dev2", true);
	lastStepStatus(0);

	showUpdateStep("Adding new phpfpm-ipcdir setting");
	$ins_stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET `settinggroup` = 'phpfpm', `varname` = 'fastcgi_ipcdir', `value` = :value
	");
	$params = array();
	// set default for apache (which will suite in most cases)
	$params['value'] = '/var/lib/apache2/fastcgi/';
	if (Settings::Get('system.webserver') == 'lighttpd') {
		$params['value'] = '/var/run/lighttpd/';
	} elseif (Settings::Get('system.webserver') == 'nginx') {
		$params['value'] = '/var/run/nginx/';
	}
	Database::pexecute($ins_stmt, $params);
	lastStepStatus(0);

	updateToVersion('0.9.31-dev2');
}

if (isFroxlorVersion('0.9.31-dev2')) {
	showUpdateStep("Updating from 0.9.31-dev2 to 0.9.31-dev3", true);
	lastStepStatus(0);
	updateToVersion('0.9.31-dev3');
}

if (isFroxlorVersion('0.9.31-dev3')) {
	showUpdateStep("Updating from 0.9.31-dev3 to 0.9.31-dev4", true);
	lastStepStatus(0);

	showUpdateStep("Adding new panel_activation table");
	Database::query("DROP TABLE IF EXISTS `panel_activation`;");
	$sql = "CREATE TABLE `" . TABLE_PANEL_ACTIVATION . "` (
		id int(11) unsigned NOT NULL AUTO_INCREMENT,
		userid int(11) unsigned NOT NULL DEFAULT '0',
		admin tinyint(1) unsigned NOT NULL DEFAULT '0',
		creation int(11) unsigned NOT NULL DEFAULT '0',
		activationcode varchar(50) DEFAULT NULL,
		PRIMARY KEY (id)
		) ENGINE=MyISAM;";
	Database::query($sql);
	lastStepStatus(0);

	updateToVersion('0.9.31-dev4');
}

if (isFroxlorVersion('0.9.31-dev4')) {

	showUpdateStep("Updating from 0.9.31-dev4 to 0.9.31-dev5", true);
	lastStepStatus(0);

	$update_error_report_admin = isset($_POST['update_error_report_admin']) ? (int) $_POST['update_error_report_admin'] : '1';
	$update_error_report_customer = isset($_POST['update_error_report_customer']) ? (int) $_POST['update_error_report_customer'] : '0';

	showUpdateStep("Adding new error-reporting options");
	$ins_stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET `settinggroup` = 'system', `varname` = :varname, `value` = :value
	");
	$params = array();
	// admins
	$params['varname'] = 'allow_error_report_admin';
	$params['value'] = $update_error_report_admin;
	Database::pexecute($ins_stmt, $params);
	// customer
	$params['varname'] = 'allow_error_report_customer';
	$params['value'] = $update_error_report_customer;
	Database::pexecute($ins_stmt, $params);

	lastStepStatus(0);

	updateToVersion('0.9.31-dev5');
}

if (isFroxlorVersion('0.9.31-dev5')) {

	showUpdateStep("Updating from 0.9.31-dev5 to 0.9.31-dev6", true);
	lastStepStatus(0);

	showUpdateStep("Adding new fpm-configuration options (slowlog)");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `fpm_slowlog` tinyint(1) NOT NULL default '0' AFTER `mod_fcgid_maxrequests`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `fpm_reqterm` varchar(15) NOT NULL default '60s' AFTER `fpm_slowlog`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `fpm_reqslow` varchar(15) NOT NULL default '5s' AFTER `fpm_reqterm`;");
	lastStepStatus(0);

	updateToVersion('0.9.31-dev6');
}

if (isFroxlorVersion('0.9.31-dev6')) {
	showUpdateStep("Updating from 0.9.31-dev6 to 0.9.31-rc1");
	lastStepStatus(0);
	updateToVersion('0.9.31-rc1');
}

if (isFroxlorVersion('0.9.31-rc1')) {
	showUpdateStep("Updating from 0.9.31-rc1 to 0.9.31-rc2");
	lastStepStatus(0);

	$update_admin_news_feed = isset($_POST['update_admin_news_feed']) ? (int) $_POST['update_admin_news_feed'] : '1';
	showUpdateStep("Adding new news-feed option");
	$ins_stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET `settinggroup` = 'admin', `varname` = 'show_news_feed', `value` = :value
	");
	Database::pexecute($ins_stmt, array(
		'value' => $update_admin_news_feed
	));
	lastStepStatus(0);

	updateToVersion('0.9.31-rc2');
}

if (isFroxlorVersion('0.9.31-rc2')) {
	showUpdateStep("Updating from 0.9.31-rc2 to 0.9.31-rc3");
	lastStepStatus(0);

	showUpdateStep("Adding new php-config for froxlor-vhost");
	Database::query("
		INSERT INTO `panel_phpconfigs` SET
			`description` = 'Froxlor Vhost Config', `binary` = '/usr/bin/php-cgi',
			`file_extensions` = 'php', `mod_fcgid_starter` = '-1', `mod_fcgid_maxrequests` = '-1',
			`phpsettings` = 'allow_call_time_pass_reference = Off\r\nallow_url_fopen = On\r\nasp_tags = Off\r\ndisable_classes =\r\ndisable_functions = curl_multi_exec,exec,parse_ini_file,passthru,popen,proc_close,proc_get_status,proc_nice,proc_open,proc_terminate,shell_exec,show_source,system\r\ndisplay_errors = Off\r\ndisplay_startup_errors = Off\r\nenable_dl = Off\r\nerror_reporting = E_ALL & ~E_NOTICE\r\nexpose_php = Off\r\nfile_uploads = On\r\ncgi.force_redirect = 1\r\ngpc_order = \"GPC\"\r\nhtml_errors = Off\r\nignore_repeated_errors = Off\r\nignore_repeated_source = Off\r\ninclude_path = \".:{PEAR_DIR}\"\r\nlog_errors = On\r\nlog_errors_max_len = 1024\r\nmagic_quotes_gpc = Off\r\nmagic_quotes_runtime = Off\r\nmagic_quotes_sybase = Off\r\nmax_execution_time = 60\r\nmax_input_time = 60\r\nmemory_limit = 16M\r\nnoutput_buffering = 4096\r\npost_max_size = 16M\r\nprecision = 14\r\nregister_argc_argv = Off\r\nregister_globals = Off\r\nreport_memleaks = On\r\nsendmail_path = \"/usr/sbin/sendmail -t -i -f {CUSTOMER_EMAIL}\"\r\nsession.auto_start = 0\r\nsession.bug_compat_42 = 0\r\nsession.bug_compat_warn = 1\r\nsession.cache_expire = 180\r\nsession.cache_limiter = nocache\r\nsession.cookie_domain =\r\nsession.cookie_lifetime = 0\r\nsession.cookie_path = /\r\nsession.entropy_file = /dev/urandom\r\nsession.entropy_length = 16\r\nsession.gc_divisor = 1000\r\nsession.gc_maxlifetime = 1440\r\nsession.gc_probability = 1\r\nsession.name = PHPSESSID\r\nsession.referer_check =\r\nsession.save_handler = files\r\nsession.save_path = \"{TMP_DIR}\"\r\nsession.serialize_handler = php\r\nsession.use_cookies = 1\r\nsession.use_trans_sid = 0\r\nshort_open_tag = On\r\nsuhosin.mail.protect = 1\r\nsuhosin.simulation = Off\r\ntrack_errors = Off\r\nupload_max_filesize = 32M\r\nupload_tmp_dir = \"{TMP_DIR}\"\r\nvariables_order = \"GPCS\"\r\n'
	");
	$frxvhostconfid = Database::lastInsertId();
	// update default vhosts-config for froxlor if they are on the system-default
	if (Settings::Get('system.mod_fcgid_defaultini_ownvhost') == '1') {
		$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = :value WHERE `settinggroup` = 'system' AND `varname` = 'mod_fcgid_defaultini_ownvhost'
		");
		Database::pexecute($upd_stmt, array(
			'value' => $frxvhostconfid
		));
	}
	if (Settings::Get('phpfpm.vhost_defaultini') == '1') {
		$upd_stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = :value WHERE `settinggroup` = 'phpfpm' AND `varname` = 'vhost_defaultini'
		");
		Database::pexecute($upd_stmt, array(
			'value' => $frxvhostconfid
		));
	}
	lastStepStatus(0);

	updateToVersion('0.9.31-rc3');
}

if (isFroxlorVersion('0.9.31-rc3')) {
	showUpdateStep("Updating from 0.9.31-rc3 to 0.9.31 final", true);
	lastStepStatus(0);
	updateToVersion('0.9.31');
}

if (isFroxlorVersion('0.9.31')) {
	showUpdateStep("Updating from 0.9.31 to 0.9.31.1 final", true);
	lastStepStatus(0);
	updateToVersion('0.9.31.1');
}

if (isFroxlorVersion('0.9.31.1')) {
	showUpdateStep("Updating from 0.9.31.1 to 0.9.31.2 final", true);
	lastStepStatus(0);
	updateToVersion('0.9.31.2');
}

if (isFroxlorVersion('0.9.31.2')) {

	showUpdateStep("Updating from 0.9.31.2 to 0.9.32-dev1");
	lastStepStatus(0);

	showUpdateStep("Removing APS-module (deprecated)");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'aps';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `can_manage_aps_packages`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `aps_packages`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `aps_packages_used`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `aps_packages`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `aps_packages_used`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DATABASES . "` DROP `apsdb`;");
	Database::query("DROP TABLE IF EXISTS `aps_packages`;");
	Database::query("DROP TABLE IF EXISTS `aps_instances`;");
	Database::query("DROP TABLE IF EXISTS `aps_settings`;");
	Database::query("DROP TABLE IF EXISTS `aps_tasks`;");
	Database::query("DROP TABLE IF EXISTS `aps_temp_settings`;");
	Database::query("DELETE FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `module` = 'froxlor/aps';");
	lastStepStatus(0);

	showUpdateStep("Removing backup-module (deprecated)");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_enabled';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_dir';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_mysqldump_path';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_count';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_bigfile';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_ftp_enabled';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_ftp_server';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_ftp_user';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_ftp_pass';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'backup_ftp_passive';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `backup_allowed`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `backup_enabled`;");
	Database::query("DELETE FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `module` = 'froxlor/backup';");
	lastStepStatus(0);

	showUpdateStep("Removing autoresponder-module (deprecated)");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'autoresponder';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `email_autoresponder`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` DROP `email_autoresponder_used`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `email_autoresponder`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` DROP `email_autoresponder_used`;");
	Database::query("DROP TABLE IF EXISTS `mail_autoresponder`;");
	lastStepStatus(0);

	showUpdateStep("Updating ftp-groups entries");
	Database::query("UPDATE `" . TABLE_FTP_GROUPS . "` SET `members` = CONCAT(`members`, '," . Settings::Get('system.httpuser') . "');");
	lastStepStatus(0);

	updateToVersion('0.9.32-dev1');
}

if (isFroxlorVersion('0.9.32-dev1')) {

	showUpdateStep("Updating from 0.9.32-dev1 to 0.9.32-dev2");
	lastStepStatus(0);

	showUpdateStep("Adding mailserver - settings for traffic analysis");
	$ins_stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_SETTINGS . "` SET `settinggroup` = 'system', `varname` = :varname, `value` = :value
	");

	Database::pexecute($ins_stmt, array(
		'varname' => 'mailtraffic_enabled',
		'value' => isset($_POST['mailtraffic_enabled']) ? (int) $_POST['mailtraffic_enabled'] : '1'
	));
	Database::pexecute($ins_stmt, array(
		'varname' => 'mdalog',
		'value' => isset($_POST['mdalog']) ? $_POST['mdalog'] : '/var/log/mail.log'
	));
	Database::pexecute($ins_stmt, array(
		'varname' => 'mtalog',
		'value' => isset($_POST['mtalog']) ? $_POST['mtalog'] : '/var/log/mail.log'
	));
	Database::pexecute($ins_stmt, array(
		'varname' => 'mdaserver',
		'value' => isset($_POST['mdaserver']) ? $_POST['mdaserver'] : 'dovecot'
	));
	Database::pexecute($ins_stmt, array(
		'varname' => 'mtaserver',
		'value' => isset($_POST['mtaserver']) ? $_POST['mtaserver'] : 'postfix'
	));
	lastStepStatus(0);

	updateToVersion('0.9.32-dev2');
}

if (isFroxlorVersion('0.9.32-dev2')) {

	showUpdateStep("Updating from 0.9.32-dev2 to 0.9.32-dev3");
	lastStepStatus(0);

	showUpdateStep("Updating froxlor - theme");
	Database::query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `theme` = 'Sparkle_froxlor' WHERE `theme` = 'Froxlor';");
	Database::query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `theme` = 'Sparkle_froxlor' WHERE `theme` = 'Froxlor';");
	Database::query("UPDATE `" . TABLE_PANEL_SESSIONS . "` SET `theme` = 'Sparkle_froxlor' WHERE `theme` = 'Froxlor';");
	if (Settings::Get('panel.default_theme') == 'Froxlor') {
		Settings::Set('panel.default_theme', 'Sparkle_froxlor');
	}
	lastStepStatus(0);

	updateToVersion('0.9.32-dev3');
}

if (isFroxlorVersion('0.9.32-dev3')) {

	showUpdateStep("Updating from 0.9.32-dev3 to 0.9.32-dev4");
	lastStepStatus(0);

	showUpdateStep("Adding new FTP-description field");
	Database::query("ALTER TABLE `" . TABLE_FTP_USERS . "` ADD `description` varchar(255) NOT NULL DEFAULT '' AFTER `customerid`;");
	lastStepStatus(0);

	updateToVersion('0.9.32-dev4');
}

if (isFroxlorVersion('0.9.32-dev4')) {

	showUpdateStep("Updating from 0.9.32-dev4 to 0.9.32-dev5");
	lastStepStatus(0);

	showUpdateStep("Updating cronjob table");
	Database::query("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `cronfile` = REPLACE( REPLACE(`cronfile`, 'cron_', ''), '.php', '')");
	lastStepStatus(0);

	showUpdateStep("Adding new settings for cron");
	// get user-chosen value
	$crondfile = isset($_POST['crondfile']) ? $_POST['crondfile'] : "/etc/cron.d/froxlor";
	$crondfile = makeCorrectFile($crondfile);
	Settings::AddNew("system.cronconfig", $crondfile);
	// add task to generate cron.d-file
	inserttask('99');
	lastStepStatus(0);

	updateToVersion('0.9.32-dev5');
}

if (isFroxlorVersion('0.9.32-dev5')) {

	showUpdateStep("Updating from 0.9.32-dev5 to 0.9.32-dev6", false);

	showUpdateStep("Adding new settings for cron-daemon reload command");
	// get user-chosen value
	$crondreload = isset($_POST['crondreload']) ? $_POST['crondreload'] : "/etc/init.d/cron reload";
	Settings::AddNew("system.crondreload", $crondreload);
	// add task to generate cron.d-file
	inserttask('99');
	lastStepStatus(0);

	updateToVersion('0.9.32-dev6');
}

if (isFroxlorVersion('0.9.32-dev6')) {

	showUpdateStep("Updating from 0.9.32-dev6 to 0.9.32-rc1", false);

	showUpdateStep("Enhancing tasks-table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_TASKS . "` MODIFY `data` text NOT NULL default ''");
	lastStepStatus(0);

	updateToVersion('0.9.32-rc1');
}

if (isFroxlorVersion('0.9.32-rc1')) {

	showUpdateStep("Updating from 0.9.32-rc1 to 0.9.32-rc2", false);

	showUpdateStep("Removing autoresponder-cronjob (deprecated)");
	Database::query("DELETE FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `module` = 'froxlor/autoresponder';");
	lastStepStatus(0);

	showUpdateStep("Adding new settings for cron");
	// get user-chosen value
	$croncmdline = isset($_POST['croncmdline']) ? $_POST['croncmdline'] : "/usr/bin/nice -n 5 /usr/bin/php5 -q";
	Settings::AddNew("system.croncmdline", $croncmdline);
	// add task to generate cron.d-file
	inserttask('99');
	// silenty add the auto-update setting - we do not want everybody to know and use this
	// as it is a very dangerous setting
	Settings::AddNew("system.cron_allowautoupdate", 0);
	lastStepStatus(0);

	showUpdateStep("Removing backup-module ftp-users (deprecated)");
	Database::query("DELETE FROM `" . TABLE_FTP_USERS . "` WHERE `username` LIKE '%_backup';");
	lastStepStatus(0);

	updateToVersion('0.9.32-rc2');
}

if (isFroxlorVersion('0.9.32-rc2')) {
	showUpdateStep("Updating from 0.9.32-rc2 to 0.9.32-rc3", false);

	showUpdateStep("Removing outdated languages");
	Database::query("DELETE FROM `" . TABLE_PANEL_LANGUAGE . "` WHERE `iso` REGEXP '(bg|ca|cz|da|hu|pl|ru|sk|es|zh)';");
	Database::query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `def_language` = 'English' WHERE `def_language` NOT REGEXP '(Dutch|English|Français|Deutsch|Italian|Portugu\&ecirc;s|Swedish)';");
	Database::query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `def_language` = 'English' WHERE `def_language` NOT REGEXP '(Dutch|English|Français|Deutsch|Italian|Portugu&ecirc;s|Swedish)';");
	lastStepStatus(0);

	updateToVersion('0.9.32-rc3');
}

if (isFroxlorVersion('0.9.32-rc3')) {
	showUpdateStep("Updating from 0.9.32-rc3 to 0.9.32 final", false);
	updateToVersion('0.9.32');
}

if (isFroxlorVersion('0.9.32')) {
	showUpdateStep("Updating from 0.9.32 to 0.9.33-dev1", false);

	showUpdateStep("Adding settings for custom newsfeed on customer-dashboard");
	Settings::AddNew("customer.show_news_feed", isset($_POST['customer_show_news_feed']) ? (int) $_POST['customer_show_news_feed'] : '0');
	Settings::AddNew("customer.news_feed_url", isset($_POST['customer_news_feed_url']) ? $_POST['customer_news_feed_url'] : '');
	lastStepStatus(0);

	updateToVersion('0.9.33-dev1');
}

if (isFroxlorVersion('0.9.33-dev1')) {
	showUpdateStep("Updating from 0.9.33-dev1 to 0.9.33-dev2", false);

	showUpdateStep("Adding settings for hostname-dns-entry");
	Settings::AddNew("system.dns_createhostnameentry", isset($_POST['dns_createhostnameentry']) ? (int) $_POST['dns_createhostnameentry'] : '0');
	lastStepStatus(0);

	updateToVersion('0.9.33-dev2');
}

if (isFroxlorVersion('0.9.33-dev2')) {
	showUpdateStep("Updating from 0.9.33-dev2 to 0.9.33-dev3", false);

	showUpdateStep("Adding settings for password-generation options");
	Settings::AddNew("panel.password_alpha_lower", '1');
	Settings::AddNew("panel.password_alpha_upper", '1');
	Settings::AddNew("panel.password_numeric", '0');
	Settings::AddNew("panel.password_special_char_required", '0');
	Settings::AddNew("panel.password_special_char", '!?<>§$%&+#=@');
	lastStepStatus(0);

	showUpdateStep("Adding settings for fpm-apache2.4-mod_proxy integration");
	Settings::AddNew("phpfpm.use_mod_proxy", '0');
	lastStepStatus(0);

	updateToVersion('0.9.33-dev3');
}

if (isFroxlorVersion('0.9.33-dev3')) {
	showUpdateStep("Updating from 0.9.33-dev3 to 0.9.33-rc1", false);

	showUpdateStep("Updating database-scheme");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` MODIFY `dkim_privkey` text");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` MODIFY `dkim_pubkey` text");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` MODIFY `specialsettings` text");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` MODIFY `specialsettings` text");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` MODIFY `default_vhostconf_domain` text");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` MODIFY `ssl_ca_file` text");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` MODIFY `ssl_cert_chainfile` text");
	lastStepStatus(0);

	showUpdateStep("Removing old settings");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup`='panel' AND `varname` = 'use_webfonts';");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup`='panel' AND `varname` = 'webfont';");
	lastStepStatus(0);

	showUpdateStep("Adding local froxlor group to customer groups");
	if ((int) Settings::Get('system.mod_fcgid_ownvhost') == 1 || (int) Settings::Get('phpfpm.enabled_ownvhost') == 1) {
		if ((int) Settings::Get('system.mod_fcgid') == 1) {
			$local_user = Settings::Get('system.mod_fcgid_httpuser');
		} else {
			$local_user = Settings::Get('phpfpm.vhost_httpuser');
		}
		Database::query("UPDATE `" . TABLE_FTP_GROUPS . "` SET `members` = CONCAT(`members`, '," . $local_user . "');");
		lastStepStatus(0);
	} else {
		lastStepStatus(1, "not needed");
	}

	updateToVersion('0.9.33-rc1');
}

if (isFroxlorVersion('0.9.33-rc1')) {
	showUpdateStep("Updating from 0.9.33-rc1 to 0.9.33-rc2", false);

	showUpdateStep("Add new setting for sending cron-errors via mail");
	$sendcronerrors = isset($_POST['system_send_cron_errors']) ? (int) $_POST['system_send_cron_errors'] : "0";
	Settings::addNew('system.send_cron_errors', $sendcronerrors);
	lastStepStatus(0);

	showUpdateStep("Add new custom-notes field for admins and customer");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `custom_notes` text AFTER `theme`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `custom_notes_show` tinyint(1) NOT NULL default '0' AFTER `custom_notes`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `custom_notes` text AFTER `theme`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `custom_notes_show` tinyint(1) NOT NULL default '0' AFTER `custom_notes`");
	lastStepStatus(0);

	// go from varchar(50) to varchar(255) because of some hashes that are longer than that
	showUpdateStep("Updating table structure of admins and customers");
	Database::query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` MODIFY `password` varchar(255) NOT NULL default ''");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` MODIFY `password` varchar(255) NOT NULL default ''");
	lastStepStatus(0);

	updateToVersion('0.9.33-rc2');
}

if (isFroxlorVersion('0.9.33-rc2')) {

	showUpdateStep("Updating from 0.9.33-rc2 to 0.9.33-rc3");
	lastStepStatus(0);
	updateToVersion('0.9.33-rc3');
}

if (isFroxlorVersion('0.9.33-rc3')) {

	showUpdateStep("Updating from 0.9.33-rc3 to 0.9.33 final");
	lastStepStatus(0);
	updateToVersion('0.9.33');
}

if (isFroxlorVersion('0.9.33')) {

	showUpdateStep("Updating from 0.9.33 to 0.9.33.1");
	lastStepStatus(0);
	updateToVersion('0.9.33.1');
}

if (isFroxlorVersion('0.9.33.1')) {

	showUpdateStep("Updating from 0.9.33.1 to 0.9.33.2");
	lastStepStatus(0);
	updateToVersion('0.9.33.2');
}

if (isFroxlorVersion('0.9.33.2')) {

	showUpdateStep("Updating from 0.9.33.2 to 0.9.34-dev1", false);

	showUpdateStep("Updating table structure of domains");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` MODIFY `parentdomainid` int(11) NOT NULL default '0'");
	lastStepStatus(0);

	showUpdateStep("Updating stored email-templates");
	$chk_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `templategroup` = 'mails'");
	Database::pexecute($chk_stmt);
	// do we have any?
	if ($chk_stmt->rowCount() > 0) {
		// prepare update-statement
		$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_TEMPLATES . "` SET `language` = :lang WHERE `id` = :id");
		// get each row
		while ($row = $chk_stmt->fetch()) {
			// let htmlentities run over the language name and update the entry
			Database::pexecute($upd_stmt, array(
				'lang' => htmlentities($row['language'])
			), false);
		}
		lastStepStatus(0);
	} else {
		lastStepStatus(1, "not needed");
	}

	showUpdateStep("Updating language descriptions to be in the native language");
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_LANGUAGE . "` SET `language` = :lang WHERE `iso` = :iso");
	Database::pexecute($upd_stmt, array(
		'lang' => 'Fran&ccedil;ais',
		'iso' => 'fr'
	), false);
	Database::pexecute($upd_stmt, array(
		'lang' => 'Portugu&ecirc;s',
		'iso' => 'pt'
	), false);
	Database::pexecute($upd_stmt, array(
		'lang' => 'Italiano',
		'iso' => 'it'
	), false);
	Database::pexecute($upd_stmt, array(
		'lang' => 'Nederlands',
		'iso' => 'nl'
	), false);
	Database::pexecute($upd_stmt, array(
		'lang' => 'Svenska',
		'iso' => 'sv'
	), false);
	lastStepStatus(0);

	updateToVersion('0.9.34-dev1');
}

if (isFroxlorVersion('0.9.34-dev1')) {

	showUpdateStep("Updating from 0.9.34-dev1 to 0.9.34-dev2", false);

	showUpdateStep("Adding new settings for apache-itk-mpm");
	Settings::AddNew("system.apacheitksupport", '0');
	lastStepStatus(0);

	showUpdateStep("Increase text-field size of domain-ssl table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` MODIFY `ssl_cert_file` mediumtext NOT NULL");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` MODIFY `ssl_key_file` mediumtext NOT NULL");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` MODIFY `ssl_ca_file` mediumtext NOT NULL");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` MODIFY `ssl_cert_chainfile` mediumtext NOT NULL");
	lastStepStatus(0);

	updateToVersion('0.9.34-dev2');
}

if (isFroxlorVersion('0.9.34-dev2')) {

	showUpdateStep("Updating from 0.9.34-dev2 to 0.9.34-dev3", false);

	$do_update = true;
	showUpdateStep("Checking for required PHP mbstring-extension");
	if (! extension_loaded('mbstring')) {
		$do_update = false;
		lastStepStatus(2, 'not installed');
	} else {
		lastStepStatus(0);
	}

	if ($do_update) {
		updateToVersion('0.9.34-dev3');
	}
}

if (isFroxlorVersion('0.9.34-dev3')) {

	showUpdateStep("Updating from 0.9.34-dev3 to 0.9.34-dev4", false);

	showUpdateStep("Adding field umask to phpconfig table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `mod_fcgid_umask` varchar(15) NOT NULL DEFAULT '022' AFTER `mod_fcgid_maxrequests`");
	lastStepStatus(0);

	updateToVersion('0.9.34-dev4');
}

if (isFroxlorVersion('0.9.34-dev4')) {

	showUpdateStep("Updating from 0.9.34-dev4 to 0.9.34 final");
	lastStepStatus(0);

	updateToVersion('0.9.34');
}

if (isFroxlorVersion('0.9.34')) {

	showUpdateStep("Updating from 0.9.34 to 0.9.34.1");
	lastStepStatus(0);

	updateToVersion('0.9.34.1');
}

if (isFroxlorVersion('0.9.34.1')) {

	showUpdateStep("Updating from 0.9.34.1 to 0.9.34.2");
	lastStepStatus(0);

	updateToVersion('0.9.34.2');
}

if (isFroxlorVersion('0.9.34.2')) {

	showUpdateStep("Updating from 0.9.34.2 to 0.9.35-dev1", false);

	showUpdateStep("Adding Let's Encrypt - certificate fields");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` ADD `expirationdate` DATETIME NULL AFTER `ssl_cert_chainfile`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `lepublickey` MEDIUMTEXT DEFAULT NULL AFTER `custom_notes_show`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `leprivatekey` MEDIUMTEXT DEFAULT NULL AFTER `lepublickey`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `letsencrypt` TINYINT(1) NOT NULL DEFAULT '0' AFTER `ismainbutsubto`;");
	Settings::AddNew("system.leprivatekey", 'unset');
	Settings::AddNew("system.lepublickey", 'unset');
	showUpdateStep("Adding new cron-module for Let's encrypt");
	$stmt = Database::prepare("
        INSERT INTO `" . TABLE_PANEL_CRONRUNS . "` SET
        `module` = 'froxlor/letsencrypt',
        `cronfile` = 'letsencrypt',
        `interval` = '5 MINUTE',
        `desc_lng_key` = 'cron_letsencrypt',
        `lastrun` = UNIX_TIMESTAMP(),
        `isactive` = 0");
	Database::pexecute($stmt);
	lastStepStatus(0);

	updateToVersion('0.9.35-dev1');
}

if (isFroxlorVersion('0.9.35-dev1')) {

	showUpdateStep("Updating from 0.9.35-dev1 to 0.9.35-dev2", false);

	showUpdateStep("Adding Let's Encrypt - settings");
	Settings::AddNew("system.letsencryptca", 'production');
	Settings::AddNew("system.letsencryptcountrycode", 'DE');
	Settings::AddNew("system.letsencryptstate", 'Germany');
	lastStepStatus(0);

	updateToVersion('0.9.35-dev2');
}

if (isFroxlorVersion('0.9.35-dev2')) {

	showUpdateStep("Updating from 0.9.35-dev2 to 0.9.35-dev3", false);

	showUpdateStep("Adding new domain fields for Let's Encrypt");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `termination_date` date NOT NULL AFTER `registration_date`");
	lastStepStatus(0);

	updateToVersion('0.9.35-dev3');
}

if (isFroxlorVersion('0.9.35-dev3')) {

	showUpdateStep("Updating from 0.9.35-dev3 to 0.9.35-dev4", false);

	// remove unused setting
	showUpdateStep("Removing unused setting &quot;Send cron-errors to froxlor-admin via e-mail&quot;");
	Database::query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'send_cron_errors';");
	lastStepStatus(0);

	updateToVersion('0.9.35-dev4');
}

if (isFroxlorVersion('0.9.35-dev4')) {

	showUpdateStep("Updating from 0.9.35-dev4 to 0.9.35-dev5", false);

	showUpdateStep("Adding more Let's Encrypt settings");
	Settings::AddNew("system.letsencryptchallengepath", FROXLOR_INSTALL_DIR);
	Settings::AddNew("system.letsencryptkeysize", '4096');
	Settings::AddNew("system.letsencryptreuseold", 0);
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` ADD `ssl_csr_file` MEDIUMTEXT AFTER `ssl_cert_chainfile`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `hsts` VARCHAR(10) NOT NULL DEFAULT '0' AFTER `letsencrypt`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `hsts_sub` TINYINT(1) NOT NULL DEFAULT '0' AFTER `hsts`");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `hsts_preload` TINYINT(1) NOT NULL DEFAULT '1' AFTER `hsts_sub`");
	lastStepStatus(0);

	updateToVersion('0.9.35-dev5');
}

if (isFroxlorVersion('0.9.35-dev5')) {

	showUpdateStep("Updating from 0.9.35-dev5 to 0.9.35-dev6", false);

	showUpdateStep("Adding new panel_vhostconfigs table");
	Database::query("DROP TABLE IF EXISTS `panel_vhostconfigs`;");
	$sql = "CREATE TABLE `panel_vhostconfigs` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`description` varchar(50) NOT NULL,
			`vhostsettings` text NOT NULL,
			PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
	Database::query($sql);
	lastStepStatus(0);

	showUpdateStep("Adding new fields to panel_domains table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `vhost_usedefaultlocation` tinyint(1) NOT NULL default '1' AFTER `ssl_redirect`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `vhostsettingid` tinyint(11) NOT NULL default '0' AFTER `vhost_usedefaultlocation`;");
	lastStepStatus(0);

	updateToVersion('0.9.35-dev6');
}

if (isFroxlorVersion('0.9.35-dev6')) {

	showUpdateStep("Updating from 0.9.35-dev6 to 0.9.35-dev7", false);

	showUpdateStep("Adding a new field to the panel_vhostconfigs table");
	$webserver = Settings::Get('system.webserver');
	Database::query("ALTER TABLE `panel_vhostconfigs` ADD `webserver` VARCHAR(255) NOT NULL DEFAULT '" . $webserver . "' AFTER `vhostsettings`;");
	lastStepStatus(0);

	updateToVersion('0.9.35-dev7');
}

if (isFroxlorVersion('0.9.35-dev7')) {

	showUpdateStep("Updating from 0.9.35-dev7 to 0.9.35-rc1");
	lastStepStatus(0);

	updateToVersion('0.9.35-rc1');
}

if (isFroxlorVersion('0.9.35-rc1') && isDatabaseVersion(null)) {

	Settings::AddNew("panel.db_version", "201603070");

	showUpdateStep("Removing unused table and fields from database");
	Database::query("DROP TABLE IF EXISTS `panel_vhostconfigs`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` DROP `vhost_usedefaultlocation`;");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` DROP `vhostsettingid`;");
	lastStepStatus(0);

	showUpdateStep("Adding new setting to enable/disable Let's Encrypt");
	$enable_letsencrypt = isset($_POST['enable_letsencrypt']) ? (int) $_POST['enable_letsencrypt'] : "1";
	Settings::AddNew("system.leenabled", $enable_letsencrypt);
	Database::query("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `isactive` = '" . $enable_letsencrypt . "' WHERE `cronfile` = 'letsencrypt'");
	lastStepStatus(0);
}

if (isDatabaseVersion('201603070')) {

	showUpdateStep("Adding new php.ini directive to php-configurations: opcache.restrict_api");
	Database::query("UPDATE `" . TABLE_PANEL_PHPCONFIGS . "` SET `phpsettings` = CONCAT(`phpsettings`, '\r\nopcache.restrict_api = \"{DOCUMENT_ROOT}\"\r\n');");
	lastStepStatus(0);

	updateToDbVersion('201603150');
}

if (isFroxlorVersion('0.9.35-rc1')) {

	showUpdateStep("Updating from 0.9.35-rc1 to 0.9.35 final");
	lastStepStatus(0);

	updateToVersion('0.9.35');
}

if (isFroxlorVersion('0.9.35')) {

	showUpdateStep("Updating from 0.9.35 to 0.9.35.1");
	lastStepStatus(0);

	updateToVersion('0.9.35.1');
}

if (isFroxlorVersion('0.9.35.1') && isDatabaseVersion('201603150')) {

	showUpdateStep("Adding new backup settings and cron");
	$enable_backup = isset($_POST['enable_backup']) ? (int) $_POST['enable_backup'] : "0";
	Settings::AddNew("system.backupenabled", $enable_backup);
	$stmt = Database::prepare("
		INSERT INTO `" . TABLE_PANEL_CRONRUNS . "` SET
		`module` = 'froxlor/backup',
		`cronfile` = 'backup',
		`interval` = '1 DAY',
		`desc_lng_key` = 'cron_backup',
		`lastrun` = 0,
		`isactive` = :isactive"
	);
	Database::pexecute($stmt, array('isactive' => $enable_backup));
	lastStepStatus(0);

	updateToDbVersion('201604270');
}

if (isFroxlorVersion('0.9.35.1')) {

	showUpdateStep("Updating from 0.9.35.1 to 0.9.36 final");
	lastStepStatus(0);

	updateToVersion('0.9.36');
}

if (isDatabaseVersion('201604270')) {

	showUpdateStep("Adding new dns related tables and settings");
	$enable_dns = isset($_POST['enable_dns']) ? (int) $_POST['enable_dns'] : "0";
	Settings::AddNew("system.dnsenabled", $enable_dns);

	Database::query("DROP TABLE IF EXISTS `domain_dns_entries`;");
	$sql = "CREATE TABLE `domain_dns_entries` (
		`id` int(20) NOT NULL auto_increment,
		`domain_id` int(15) NOT NULL,
		`record` varchar(255) NOT NULL,
		`type` varchar(10) NOT NULL DEFAULT 'A',
		`content` text NOT NULL,
		`ttl` int(11) NOT NULL DEFAULT '18000',
		`prio` int(11) DEFAULT NULL,
		PRIMARY KEY (`id`)
		) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
	Database::query($sql);
	lastStepStatus(0);

	updateToDbVersion('201605090');
}

if (isDatabaseVersion('201605090')) {

	showUpdateStep("Adjusting SPF record setting");
	$current_spf = Settings::Get('spf.spf_entry');
	// @	IN	TXT	"v=spf1 a mx -all"
	$new_spf = substr($current_spf, strpos($current_spf, '"'));
	Settings::Set('spf.spf_entry', $new_spf, true);
	lastStepStatus(0);

	updateToDbVersion('201605120');
}

if (isDatabaseVersion('201605120')) {

	showUpdateStep("Adding new dns-server setting");
	$new_dns_daemon = isset($_POST['new_dns_daemon']) ? $_POST['new_dns_daemon'] : "bind";
	Settings::AddNew("system.dns_server", $new_dns_daemon);
	lastStepStatus(0);

	updateToDbVersion('201605170');
}

if (isDatabaseVersion('201605170')) {

	showUpdateStep("Adding new dns-editor setting for customers");
	Database::query("ALTER TABLE `".TABLE_PANEL_CUSTOMERS."` ADD `dnsenabled` tinyint(1) NOT NULL default '0' AFTER `perlenabled`;");
	lastStepStatus(0);

	updateToDbVersion('201605180');
}

if (isDatabaseVersion('201605180')) {

	showUpdateStep("Changing tables to be more mysql strict-mode compatible");
	Database::query("ALTER TABLE `".TABLE_FTP_USERS."` CHANGE `last_login` `last_login` DATETIME NULL DEFAULT NULL;");
	Database::query("ALTER TABLE `".TABLE_PANEL_IPSANDPORTS."` CHANGE `specialsettings` `specialsettings` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;");
	Database::query("ALTER TABLE `".TABLE_PANEL_TASKS."` CHANGE `data` `data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;");
	lastStepStatus(0);

	updateToDbVersion('201606190');
}

if (isDatabaseVersion('201606190')) {

	showUpdateStep("Adding new setting for mod_php users to specify content of the global directory options file");
	Settings::AddNew("system.apacheglobaldiropt", "");
	lastStepStatus(0);

	updateToDbVersion('201607140');
}

if (isFroxlorVersion('0.9.36')) {

	showUpdateStep("Updating from 0.9.36 to 0.9.37-rc1", false);
	updateToVersion('0.9.37-rc1');
}

if (isDatabaseVersion('201607140')) {

	showUpdateStep("Adding new setting to hide certain options in customer panel");
	Settings::AddNew("panel.customer_hide_options", "");
	lastStepStatus(0);

	updateToDbVersion('201607210');
}

if (isFroxlorVersion('0.9.37-rc1')) {

	showUpdateStep("Updating from 0.9.37-rc1 to 0.9.37 final", false);
	updateToVersion('0.9.37');
}

if (isDatabaseVersion('201607210')) {

	showUpdateStep("Adding new settings for customer shell option");
	Settings::AddNew("system.allow_customer_shell", "0");
	Settings::AddNew("system.available_shells", "");
	lastStepStatus(0);

	updateToDbVersion('201608260');
}

if (isDatabaseVersion('201608260')) {

	showUpdateStep("Adding new settings to use Let's Encrypt for froxlor");
	Settings::AddNew("system.le_froxlor_enabled", "0");
	Settings::AddNew("system.le_froxlor_redirect", "0");
	lastStepStatus(0);

	updateToDbVersion('201609050');
}

if (isDatabaseVersion('201609050')) {

	showUpdateStep("Adding new settings for acme.conf (Let's Encrypt)");
	// get user-chosen value
	$websrv_default = "/etc/apache2/conf-enabled/acme.conf";
	if (Settings::Get('system.webserver') == 'nginx') {
		$websrv_default = "/etc/nginx/acme.conf";
	}
	$acmeconffile = isset($_POST['acmeconffile']) ? $_POST['acmeconffile'] : $websrv_default;
	$acmeconffile = makeCorrectFile($acmeconffile);
	Settings::AddNew("system.letsencryptacmeconf", $acmeconffile);
	lastStepStatus(0);

	updateToDbVersion('201609120');
}

if (isDatabaseVersion('201609120')) {

	showUpdateStep("Adding new SMTP settings for emails sent by froxlor");
	// get user-chosen value
	$smtp_enable = isset($_POST['smtp_enable']) ? (int) $_POST['smtp_enable'] : 0;
	$smtp_host = isset($_POST['smtp_host']) ? $_POST['smtp_host'] : "localhost";
	$smtp_port = isset($_POST['smtp_port']) ? (int)$_POST['smtp_port'] : 25;
	$smtp_usetls = isset($_POST['smtp_usetls']) ? (int) $_POST['smtp_usetls'] : 1;
	$smtp_useauth = isset($_POST['smtp_auth']) ? (int) $_POST['smtp_auth'] : 1;
	$smtp_user = isset($_POST['smtp_user']) ? $_POST['smtp_user'] : "";
	$smtp_passwd = isset($_POST['smtp_passwd']) ? $_POST['smtp_passwd'] : "";

	Settings::AddNew("system.mail_use_smtp", $smtp_enable);
	Settings::AddNew("system.mail_smtp_host", $smtp_host);
	Settings::AddNew("system.mail_smtp_port", $smtp_port);
	Settings::AddNew("system.mail_smtp_usetls", $smtp_usetls);
	Settings::AddNew("system.mail_smtp_auth", $smtp_useauth);
	Settings::AddNew("system.mail_smtp_user", $smtp_user);
	Settings::AddNew("system.mail_smtp_passwd", $smtp_passwd);
	lastStepStatus(0);

	updateToDbVersion('201609200');
}

if (isDatabaseVersion('201609200')) {

	showUpdateStep("Changing tables to be more mysql strict-mode compatible");
	Database::query("ALTER TABLE `".TABLE_MAIL_VIRTUAL."` CHANGE `destination` `destination` TEXT NOT NULL DEFAULT '';");
	Database::query("ALTER TABLE `".TABLE_PANEL_DOMAINS."` CHANGE `registration_date` `registration_date` DATE NULL DEFAULT NULL;");
	Database::query("ALTER TABLE `".TABLE_PANEL_DOMAINS."` CHANGE `termination_date` `termination_date` DATE NULL DEFAULT NULL;");
	lastStepStatus(0);

	updateToDbVersion('201609240');
}

if (isDatabaseVersion('201609240')) {

	showUpdateStep("Add HSTS settings for froxlor-vhost");
	Settings::AddNew("system.hsts_maxage", 0);
	Settings::AddNew("system.hsts_incsub", 0);
	Settings::AddNew("system.hsts_preload", 0);
	lastStepStatus(0);

	showUpdateStep("Settings HSTS default values for all domains (deactivated)");
	Database::query("UPDATE `".TABLE_PANEL_DOMAINS."` SET `hsts_sub` = '0', `hsts_preload` = '0';");
	lastStepStatus(0);

	updateToDbVersion('201610070');
}

if (isFroxlorVersion('0.9.37')) {

	showUpdateStep("Updating from 0.9.37 to 0.9.38-rc1", false);
	updateToVersion('0.9.38-rc1');
}

if (isFroxlorVersion('0.9.38-rc1')) {

	showUpdateStep("Updating from 0.9.38-rc1 to 0.9.38-rc2", false);
	updateToVersion('0.9.38-rc2');
}

if (isFroxlorVersion('0.9.38-rc2')) {

	showUpdateStep("Updating from 0.9.38-rc2 to 0.9.38 final", false);
	updateToVersion('0.9.38');
}

if (isDatabaseVersion('201610070')) {

	showUpdateStep("Add Nginx http2 setting");
	Settings::AddNew("system.nginx_http2_support", 0);
	lastStepStatus(0);

	updateToDbVersion('201611180');
}

if (isFroxlorVersion('0.9.38')) {

	showUpdateStep("Updating from 0.9.38 to 0.9.38.1", false);
	updateToVersion('0.9.38.1');
}

if (isFroxlorVersion('0.9.38.1')) {

	showUpdateStep("Updating from 0.9.38.1 to 0.9.38.2", false);
	updateToVersion('0.9.38.2');
}

if (isFroxlorVersion('0.9.38.2')) {

	showUpdateStep("Updating from 0.9.38.2 to 0.9.38.3", false);
	updateToVersion('0.9.38.3');
}

if (isFroxlorVersion('0.9.38.3')) {

	showUpdateStep("Updating from 0.9.38.3 to 0.9.38.4", false);
	updateToVersion('0.9.38.4');
}

if (isDatabaseVersion('201611180')) {

	showUpdateStep("Updating database table definition for panel_domains");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `phpenabled` tinyint(1) NOT NULL default '1' AFTER `parentdomainid`;");
	lastStepStatus(0);

	showUpdateStep("Adding field for let's-encrypt registration status");
	Database::query("ALTER TABLE `".TABLE_PANEL_CUSTOMERS."` add `leregistered` TINYINT(1) NOT NULL DEFAULT 0;");
	lastStepStatus(0);

	showUpdateStep("Adding system setting for let's-encrypt registration status");
	Settings::AddNew('system.leregistered', '0');
	lastStepStatus(0);

  showUpdateStep("Adding unique key to ipsandports table");
	Database::query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD UNIQUE KEY `ip_port` (`ip`,`port`)");
	lastStepStatus(0);

	updateToDbVersion('201612110');
}

if (isFroxlorVersion('0.9.38.4')) {

	showUpdateStep("Updating from 0.9.38.4 to 0.9.38.5", false);
	updateToVersion('0.9.38.5');
}

if (isFroxlorVersion('0.9.38.5')) {

	showUpdateStep("Updating from 0.9.38.5 to 0.9.38.6", false);
	updateToVersion('0.9.38.6');
}

if (isFroxlorVersion('0.9.38.6')) {

	showUpdateStep("Updating from 0.9.38.6 to 0.9.38.7", false);
	updateToVersion('0.9.38.7');
}

if (isDatabaseVersion('201612110')) {

	showUpdateStep("Adding field for OCSP stapling");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS .
		"` ADD `ocsp_stapling` TINYINT(1) NOT NULL DEFAULT '0';");
	lastStepStatus(0);

	showUpdateStep("Adding default setting for Apache 2.4 OCSP cache path");
	Settings::AddNew('system.apache24_ocsp_cache_path', 'shmcb:/var/run/apache2/ocsp-stapling.cache(131072)');
	lastStepStatus(0);

	updateToDbVersion('201704100');
}

if (isDatabaseVersion('201704100')) {

	showUpdateStep("Adding new setting for libnss-extrausers");
	$system_nssextrausers= isset($_POST['system_nssextrausers']) ? (int) $_POST['system_nssextrausers'] : 0;
	Settings::AddNew('system.nssextrausers', $system_nssextrausers);
	lastStepStatus(0);

	updateToDbVersion('201705050');
}

if (isDatabaseVersion('201705050')) {

	showUpdateStep("Updating HTTP2 setting");
	if (Settings::Get('system.nginx_http2_support') != null) {
		Database::query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `varname` = 'http2_support' WHERE `varname` = 'nginx_http2_support';");
	} else {
		Settings::AddNew('system.http2_support', 0);
	}
	lastStepStatus(0);
	showUpdateStep("Adding domain field for HTTP2 stapling");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `http2` TINYINT(1) NOT NULL DEFAULT '0';");
	lastStepStatus(0);

	updateToDbVersion('201708240');
}

if (isDatabaseVersion('201708240')) {
	
	showUpdateStep("Adding new 'disable LE self-check' setting");
	$system_disable_le_selfcheck = isset($_POST['system_disable_le_selfcheck']) ? (int) $_POST['system_disable_le_selfcheck'] : 0;
	Settings::AddNew('system.disable_le_selfcheck', $system_disable_le_selfcheck);
	lastStepStatus(0);

	updateToDbVersion('201712310');

	showUpdateStep("Updating from 0.9.38.7 to 0.9.38.8", false);
	updateToVersion('0.9.38.8');
}

if (isDatabaseVersion('201712310')) {

	showUpdateStep("Adding field for fpm-daemon configs");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `fpmsettingid` int(11) NOT NULL DEFAULT '1';");
	lastStepStatus(0);

	showUpdateStep("Adding new fpm-daemons table");
	Database::query("DROP TABLE IF EXISTS `panel_fpmdaemons`;");
	$sql = "CREATE TABLE `panel_fpmdaemons` (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `description` varchar(50) NOT NULL,
	  `reload_cmd` varchar(255) NOT NULL,
	  `config_dir` varchar(255) NOT NULL,
	  `pm` varchar(15) NOT NULL DEFAULT 'static',
	  `max_children` int(4) NOT NULL DEFAULT '1',
	  `start_servers` int(4) NOT NULL DEFAULT '20',
	  `min_spare_servers` int(4) NOT NULL DEFAULT '5',
	  `max_spare_servers` int(4) NOT NULL DEFAULT '35',
	  `max_requests` int(4) NOT NULL DEFAULT '0',
	  `idle_timeout` int(4) NOT NULL DEFAULT '30',
	  PRIMARY KEY  (`id`),
	  UNIQUE KEY `reload` (`reload_cmd`),
	  UNIQUE KEY `config` (`config_dir`)
	) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;";
	Database::query($sql);
	lastStepStatus(0);

	showUpdateStep("Converting php-fpm settings to new layout");
	$ins_stmt = Database::prepare("
		INSERT INTO `panel_fpmdaemons` SET
		`id` = 1,
		`description` = 'System default',
		`reload_cmd` = :reloadcmd,
		`config_dir` = :confdir,
		`pm` = :pm,
		`max_children` = :maxc,
		`start_servers` = :starts,
		`min_spare_servers` = :minss,
		`max_spare_servers` = :maxss,
		`max_requests` = :maxr,
		`idle_timeout` = :it
	");
	Database::pexecute($ins_stmt, array(
		'reloadcmd' => Settings::Get('phpfpm.reload'),
		'confdir' => Settings::Get('phpfpm.configdir'),
		'pm' => Settings::Get('phpfpm.pm'),
		'maxc' => Settings::Get('phpfpm.max_children'),
		'starts' => Settings::Get('phpfpm.start_servers'),
		'minss' => Settings::Get('phpfpm.min_spare_servers'),
		'maxss' => Settings::Get('phpfpm.max_spare_servers'),
		'maxr' => Settings::Get('phpfpm.max_requests'),
		'it' => Settings::Get('phpfpm.idle_timeout')
	));
	lastStepStatus(0);

	showUpdateStep("Deleting unneeded settings");
	Database::query("DELETE FROM `".TABLE_PANEL_SETTINGS."` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'reload'");
	Database::query("DELETE FROM `".TABLE_PANEL_SETTINGS."` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'configdir'");
	Database::query("DELETE FROM `".TABLE_PANEL_SETTINGS."` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'pm'");
	Database::query("DELETE FROM `".TABLE_PANEL_SETTINGS."` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'max_children'");
	Database::query("DELETE FROM `".TABLE_PANEL_SETTINGS."` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'start_servers'");
	Database::query("DELETE FROM `".TABLE_PANEL_SETTINGS."` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'min_spare_servers'");
	Database::query("DELETE FROM `".TABLE_PANEL_SETTINGS."` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'max_spare_servers'");
	Database::query("DELETE FROM `".TABLE_PANEL_SETTINGS."` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'max_requests'");
	Database::query("DELETE FROM `".TABLE_PANEL_SETTINGS."` WHERE `settinggroup` = 'phpfpm' AND `varname` = 'idle_timeout'");
	lastStepStatus(0);

	updateToDbVersion('201801070');
}

if (isDatabaseVersion('201801070')) {

	showUpdateStep("Adding field allowed_phpconfigs for customers");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `allowed_phpconfigs` varchar(500) NOT NULL default '';");
	lastStepStatus(0);

	updateToDbVersion('201801080');
}

if (isDatabaseVersion('201801080')) {

	showUpdateStep("Adding new setting for Let's Encrypt ACME version");
	Settings::AddNew('system.leapiversion', '1');
	lastStepStatus(0);

	updateToDbVersion('201801090');
}

if (isDatabaseVersion('201801090')) {

	showUpdateStep("Adding field pass_authorizationheader for php-configs");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `pass_authorizationheader` tinyint(1) NOT NULL default '0';");
	lastStepStatus(0);

	updateToDbVersion('201801091');
}

if (isDatabaseVersion('201801091')) {

	showUpdateStep("Adding new setting for SSL protocols");
	Settings::AddNew('system.ssl_protocols', 'TLSv1,TLSv1.2');
	lastStepStatus(0);

	updateToDbVersion('201801100');
}

if (isDatabaseVersion('201801100')) {

	showUpdateStep("Adding field for security.limit_extensions fpm-setting");
	Database::query("ALTER TABLE `" . TABLE_PANEL_FPMDAEMONS . "` ADD `limit_extensions` varchar(255) NOT NULL default '.php';");
	lastStepStatus(0);

	updateToDbVersion('201801101');
}

if (isDatabaseVersion('201801101')) {

	showUpdateStep("Adding dynamic php-fpm php.ini settings");
	Settings::AddNew('phpfpm.ini_flags', 'asp_tags
display_errors
display_startup_errors
html_errors
log_errors
magic_quotes_gpc
magic_quotes_runtime
magic_quotes_sybase
mail.add_x_header
session.cookie_secure
session.use_cookies
short_open_tag
track_errors
xmlrpc_errors
suhosin.simulation
suhosin.session.encrypt
suhosin.session.cryptua
suhosin.session.cryptdocroot
suhosin.cookie.encrypt
suhosin.cookie.cryptua
suhosin.cookie.cryptdocroot
suhosin.executor.disable_eval
mbstring.func_overload');
	Settings::AddNew('phpfpm.ini_values', 'auto_append_file
auto_prepend_file
date.timezone
default_charset
error_reporting
include_path
log_errors_max_len
mail.log
max_execution_time
session.cookie_domain
session.cookie_lifetime
session.cookie_path
session.name
session.serialize_handler
upload_max_filesize
xmlrpc_error_number
session.auto_start
always_populate_raw_post_data
suhosin.session.cryptkey
suhosin.session.cryptraddr
suhosin.session.checkraddr
suhosin.cookie.cryptkey
suhosin.cookie.plainlist
suhosin.cookie.cryptraddr
suhosin.cookie.checkraddr
suhosin.executor.func.blacklist
suhosin.executor.eval.whitelist');
	Settings::AddNew('phpfpm.ini_admin_flags', 'allow_call_time_pass_reference
allow_url_fopen
allow_url_include
auto_detect_line_endings
cgi.fix_pathinfo
cgi.force_redirect
enable_dl
expose_php
file_uploads
ignore_repeated_errors
ignore_repeated_source
log_errors
register_argc_argv
report_memleaks
opcache.enable
opcache.consistency_checks
opcache.dups_fix
opcache.load_comments
opcache.revalidate_path
opcache.save_comments
opcache.use_cwd
opcache.validate_timestamps
opcache.fast_shutdown');
	Settings::AddNew('phpfpm.ini_admin_values', 'cgi.redirect_status_env
date.timezone
disable_classes
disable_functions
error_log
gpc_order
max_input_time
max_input_vars
memory_limit
open_basedir
output_buffering
post_max_size
precision
sendmail_path
session.gc_divisor
session.gc_probability
variables_order
opcache.log_verbosity_level
opcache.restrict_api
opcache.revalidate_freq
opcache.max_accelerated_files
opcache.memory_consumption
opcache.interned_strings_buffer');
	lastStepStatus(0);

	updateToDbVersion('201801110');
}

if (isDatabaseVersion('201801110')) {

	showUpdateStep("Adding php-fpm php PATH setting for envrironment");
	Settings::AddNew("phpfpm.envpath",  '/usr/local/bin:/usr/bin:/bin');
	lastStepStatus(0);

	updateToDbVersion('201801260');
}

if (isFroxlorVersion('0.9.38.8')) {

	showUpdateStep("Updating from 0.9.38.8 to 0.9.39 final", false);
	updateToVersion('0.9.39');
}

if (isFroxlorVersion('0.9.39')) {

	showUpdateStep("Updating from 0.9.39 to 0.9.39.1", false);
	updateToVersion('0.9.39.1');
}

if (isFroxlorVersion('0.9.39.1')) {

	showUpdateStep("Updating from 0.9.39.1 to 0.9.39.2", false);
	updateToVersion('0.9.39.2');
}

if (isDatabaseVersion('201801260')) {

	showUpdateStep("Adding new plans table");
	Database::query("DROP TABLE IF EXISTS `panel_plans`;");
	$sql = "CREATE TABLE `panel_plans` (
	  `id` int(11) NOT NULL auto_increment,
	  `adminid` int(11) NOT NULL default '0',
	  `name` varchar(255) NOT NULL default '',
	  `description` text NOT NULL,
	  `value` longtext NOT NULL,
	  `ts` int(15) NOT NULL default '0',
	  PRIMARY KEY  (id),
	  KEY adminid (adminid)
	) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_general_ci;";
	Database::query($sql);
	lastStepStatus(0);

	updateToDbVersion('201802120');
}

if (isDatabaseVersion('201802120')) {

	showUpdateStep("Adding domain field for try_files flag");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `notryfiles` tinyint(1) DEFAULT '0';");
	lastStepStatus(0);

	updateToDbVersion('201802130');
}

if (isFroxlorVersion('0.9.39.2')) {

	showUpdateStep("Updating from 0.9.39.2 to 0.9.39.3", false);
	updateToVersion('0.9.39.3');
}

if (isFroxlorVersion('0.9.39.3')) {

	showUpdateStep("Updating from 0.9.39.3 to 0.9.39.4", false);
	updateToVersion('0.9.39.4');
}

if (isFroxlorVersion('0.9.39.4')) {

	showUpdateStep("Updating from 0.9.39.4 to 0.9.39.5", false);
	updateToVersion('0.9.39.5');
}

if (isDatabaseVersion('201802130')) {

	showUpdateStep("Adding fullchain field to ssl certificates");
	Database::query("ALTER TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` ADD `ssl_fullchain_file` mediumtext AFTER `ssl_csr_file`;");
	lastStepStatus(0);

	updateToDbVersion('201802250');
}

if (isDatabaseVersion('201802250')) {

	showUpdateStep("Adding webserver logfile settings");
	Settings::AddNew("system.logfiles_format",  '');
	Settings::AddNew("system.logfiles_type",  '1');
	Settings::AddNew("system.logfiles_piped",  '0');
	lastStepStatus(0);

	updateToDbVersion('201805240');
}

if (isDatabaseVersion('201805240')) {

	showUpdateStep("Adding webserver logfile-script settings");
	Settings::AddNew("system.logfiles_script",  '');
	lastStepStatus(0);

	updateToDbVersion('201805241');
}

if (isDatabaseVersion('201805241')) {

	$do_update = true;
	showUpdateStep("Checking for required PHP json-extension");
	if (! extension_loaded('json')) {
		$do_update = false;
		lastStepStatus(2, 'not installed');
	} else {
		lastStepStatus(0);

		showUpdateStep("Checking for current cronjobs that need converting");
		$result_tasks_stmt = Database::query("
			SELECT * FROM `" . TABLE_PANEL_TASKS . "` ORDER BY `id` ASC
		");
		$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_TASKS . "` SET `data` = :data WHERE `id` = :taskid");
		while ($row = $result_tasks_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (! empty($row['data'])) {
				$data = unserialize($row['data']);
				Database::pexecute($upd_stmt, array(
					'data' => json_encode($data),
					'taskid' => $row['id']
				));
			}
		}
		lastStepStatus(0);

		updateToDbVersion('201805290');
	}
}

if (isDatabaseVersion('201805290')) {

	showUpdateStep("Adding leaccount field to panel customers");
	Database::query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD COLUMN `leaccount` varchar(255) default '' AFTER `leregistered`;");
	lastStepStatus(0);

	showUpdateStep("Adding system setting for let's-encrypt account");
	Settings::AddNew('system.leaccount', "");
	lastStepStatus(0);

	updateToDbVersion('201809180');
}

if (isDatabaseVersion('201809180')) {
	
	showUpdateStep("Adding new fields for php configs");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `override_fpmconfig` tinyint(1) NOT NULL DEFAULT '0';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `pm` varchar(15) NOT NULL DEFAULT 'static';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `max_children` int(4) NOT NULL DEFAULT '1';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `start_servers` int(4) NOT NULL DEFAULT '20';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `min_spare_servers` int(4) NOT NULL DEFAULT '5';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `max_spare_servers` int(4) NOT NULL DEFAULT '35';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `max_requests` int(4) NOT NULL DEFAULT '0';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `idle_timeout` int(4) NOT NULL DEFAULT '30';");
	Database::query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `limit_extensions` varchar(255) NOT NULL default '.php';");
	lastStepStatus(0);
	
	showUpdateStep("Synchronize fpm-daemon process manager settings with php-configs");
	// get all fpm-daemons
	$sel_stmt = Database::prepare("SELECT * FROM `panel_fpmdaemons`;");
	Database::pexecute($sel_stmt);
	$fpm_daemons = $sel_stmt->fetchAll(PDO::FETCH_ASSOC);
	$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_PHPCONFIGS . "` SET
		`pm` = :pm,
		`max_children` = :maxc,
		`start_servers` = :starts,
		`min_spare_servers` = :minss,
		`max_spare_servers` = :maxss,
		`max_requests` = :maxr,
		`idle_timeout` = :it,
		`limit_extensions` = :le
		WHERE `fpmsettingid` = :fpmid
	");
	// update all php-configs with the pm data from the fpm-daemon
	foreach ($fpm_daemons as $fpm_daemon) {
		Database::pexecute($upd_stmt, array(
			'pm' => $fpm_daemon['pm'],
			'maxc' => $fpm_daemon['max_children'],
			'starts' => $fpm_daemon['start_servers'],
			'minss' => $fpm_daemon['min_spare_servers'],
			'maxss' => $fpm_daemon['max_spare_servers'],
			'maxr' => $fpm_daemon['max_requests'],
			'it' => $fpm_daemon['idle_timeout'],
			'le' => $fpm_daemon['limit_extensions'],
			'fpmid' => $fpm_daemon['id']
		));
	}
	lastStepStatus(0);
	
	updateToDbVersion('201809280');
}

if (isFroxlorVersion('0.9.39.5')) {
	showUpdateStep("Updating from 0.9.39.5 to 0.9.40", false);
	updateToVersion('0.9.40');
}

if (isFroxlorVersion('0.9.40')) {

	showUpdateStep("Updating from 0.9.40 to 0.9.40.1", false);
	updateToVersion('0.9.40.1');
}
