<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2009-2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <d00p@froxlor.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    System
 * @version    $Id: $
 */


$updateto = '0.9';
$frontend = 'froxlor';

$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Upgrading SysCP ".$settings['panel']['version']." to Froxlor ". $updateto);

// set new version
$query = 'UPDATE `%s` SET `value` = \'' . $updateto . '\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
$query = sprintf($query, TABLE_PANEL_SETTINGS);
$db->query($query);
$settings['panel']['version'] = $updateto;
// add field frontend
$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system','frontend','froxlor')");
$settings['panel']['frontend'] = 'froxlor';

/*
 * this is the main upgrade
 */
if($settings['panel']['frontend'] == 'froxlor'
&& $settings['panel']['version'] == '0.9')
{

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
	$db->query("DROP TABLE `" . TABLE_PANEL_DISKSPACE . "`;");
	$db->query("DROP TABLE `" . TABLE_PANEL_DISKSPACE_ADMINS . "`;");

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
	
	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (119, 'spf', 'use_spf', '0');");
	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (120, 'spf', 'spf_entry', '@	IN	TXT	\"v=spf1 a mx -all\"');");	
}

?>
