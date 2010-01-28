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
 * @version    $Id$
 */

if(isFroxlorVersion('0.9-r0'))
{
	showUpdateStep("Updating from 0.9-r0 to 0.9-r1", false);
	showUpdateStep("Performing database updates");
	/*
	 * add missing database-updates if necessary (old: update/update_database.php
	 */
	if(!isset($settings['system']['dbversion']) || $settings['system']['dbversion'] < '1')
	{
		$db->query("ALTER TABLE `panel_databases` ADD `dbserver` INT( 11 ) UNSIGNED NOT NULL default '0';");
	}
	if(!isset($settings['system']['dbversion']) || $settings['system']['dbversion'] < '2')
	{
		$db->query("ALTER TABLE `panel_ipsandports` CHANGE `ssl_cert` `ssl_cert_file` VARCHAR( 255 ) NOT NULL,
						ADD `ssl_key_file` VARCHAR( 255 ) NOT NULL, 
						ADD `ssl_ca_file` VARCHAR( 255 ) NOT NULL, 
						ADD `default_vhostconf_domain` TEXT NOT NULL;");

		$db->query("INSERT INTO `panel_settings` SET `settinggroup` = 'system', `varname` = 'ssl_key_file', `value` = '';");
		$db->query("INSERT INTO `panel_settings` SET `settinggroup` = 'system', `varname` = 'ssl_ca_file', `value` = '';");
	}
	// eof(lostuff)

	/*
	 * remove billing tables in database
	 */
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

	$db->query("DROP TABLE  `" . TABLE_BILLING_SERVICE_CATEGORIES . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_SERVICE_CATEGORIES_ADMINS . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_SERVICE_DOMAINS_TEMPLATES . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_SERVICE_OTHER . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_SERVICE_OTHER_TEMPLATES . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_TAXCLASSES . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_TAXRATES . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_INVOICES . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_INVOICES_ADMINS . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_INVOICE_CHANGES . "`;");
	$db->query("DROP TABLE  `" . TABLE_BILLING_INVOICE_CHANGES_ADMINS . "`;");

	/*
	 * update panel_domains, panel_customers, panel_admins
	 */
	$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "`
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

	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "`
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
	$db->query("ALTER TABLE `panel_domains`
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

	$db->query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "`
		WHERE `settinggroup` = 'billing';");

	$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "`
		  MODIFY `traffic` BIGINT(30),
		  MODIFY `traffic_used` BIGINT(30)");
	
	lastStepStatus(0);
	
	updateToVersion('0.9-r1');
}

if(isFroxlorVersion('0.9-r1'))
{
	showUpdateStep("Updating from 0.9-r1 to 0.9-r2", false);
	showUpdateStep("Updating settings table");
	
	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('spf', 'use_spf', '0');");
	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('spf', 'spf_entry', '@	IN	TXT	\"v=spf1 a mx -all\"');");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `varname` = 'froxlor_graphic' WHERE `varname` = 'syscp_graphic'");

	lastStepStatus(0);
	
	showUpdateStep("Converting database tables to UTF-8");

	// Convert all data to UTF-8 to have a sane standard across all data
	$result = $db->query("SHOW TABLES");
	while($table = $db->fetch_array($result, 'num'))
	{
		$db->query("ALTER TABLE " . $table[0] . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
		$db->query("ALTER TABLE " . $table[0] . " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

		$affected_columns = array();

		$primarykey = "";
		$columns = $db->query("SHOW COLUMNS FROM ".$table[0]);
		while ($column = $db->fetch_array($columns))
		{
			if (!(strpos($column['Type'], "char") === false) || !(strpos($column['Type'], "text") === false))
			{
				$affected_columns[] = $column['Field'];
			}

			if ($column['Key'] == 'PRI') {
				$primarykey = $column['Field'];
			}
		}

		$count_cols = count($affected_columns);
		if ($count_cols > 0)
		{
			$load = "";
			foreach($affected_columns as $col)
			{
				$load .= ", `" . $col . "`";
			}

			$rows = $db->query("SELECT $primarykey" . $load . " FROM `" . $table[0] . "`");
			while ($row = $db->fetch_array($rows))
			{
				$changes = "";
				for ($i = 0; $i < $count_cols; $i++)
				{
					$base = "`" . $affected_columns[$i] . "` = '" . convertUtf8($row[$affected_columns[$i]]) . "'";
					$changes .= ($i == ($count_cols-1)) ? $base : $base . ", ";
				}

				$db->query("UPDATE `" . $table[0] . "` SET " . $changes . " WHERE `$primarykey` = " . $db->escape($row[$primarykey]) . ";");
			}
		}
	}
	
	lastStepStatus(0);

	updateToVersion('0.9-r2');
}

if(isFroxlorVersion('0.9-r2'))
{
	showUpdateStep("Updating from 0.9-r2 to 0.9-r3", false);
	showUpdateStep("Updating tables");	

	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'debug_cron', '0');");
	$db->query("ALTER TABLE `" . TABLE_MAIL_AUTORESPONDER . "` ADD `date_from` int(15) NOT NULL default '-1' AFTER `enabled`");
	$db->query("ALTER TABLE `" . TABLE_MAIL_AUTORESPONDER . "` ADD `date_until` int(15) NOT NULL default '-1' AFTER `date_from`");

	lastStepStatus(0);

	updateToVersion('0.9-r3');
}

if(isFroxlorVersion('0.9-r3'))
{
	showUpdateStep("Updating from 0.9-r3 to 0.9-r4", false);
	showUpdateStep("Creating new table 'cronjobs_run'");		

	$db->query("CREATE TABLE IF NOT EXISTS `cronjobs_run` (
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
	if((int)$settings['ticket']['enabled'] == 1)
	{
		$ticket_active = 1;
	}
	
	// checking for active aps-module
	$aps_active = 0;
	if((int)$settings['aps']['aps_active'] == 1)
	{
		$aps_active = 1;
	}	
	
	// checking for active autoresponder-module
	$ar_active = 0;
	if((int)$settings['autoresponder']['autoresponder_active'] == 1)
	{
		$ar_active = 1;
	}
	
	$db->query("INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (1, 'froxlor/core', 'cron_tasks.php', '5 MINUTE', '1', cron_tasks');");
	$db->query("INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (2, 'froxlor/core', 'cron_legacy.php', '5 MINUTE', '1', 'cron_legacy');");
	$db->query("INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (3, 'froxlor/aps', 'cron_apsinstaller.php', '5 MINUTE', ".$aps_active.", 'cron_apsinstaller');");
	$db->query("INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (4, 'froxlor/autoresponder', 'cron_autoresponder.php', '5 MINUTE', ".$ar_active.", 'cron_autoresponder');");
	$db->query("INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (5, 'froxlor/aps', 'cron_apsupdater.php', '1 HOUR', ".$aps_active.", 'cron_apsupdater');");
	$db->query("INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (6, 'froxlor/core', 'cron_traffic.php', '1 DAY', '1', 'cron_traffic');");
	$db->query("INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (7, 'froxlor/ticket', 'cron_used_tickets_reset.php', '1 MONTH', '".$ticket_active."', 'cron_ticketsreset');");
	$db->query("INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (8, 'froxlor/ticket', 'cron_ticketarchive.php', '1 MONTH', '".$ticket_active."', 'cron_ticketarchive');");
	
	lastStepStatus(0);
	showUpdateStep("Updating old settings values");
	
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = 'Froxlor Support' WHERE `settinggroup`='ticket' AND `varname`='noreply_name' AND `value`='SysCP Support'");

	lastStepStatus(0);	
	updateToVersion('0.9-r4');
}
?>
