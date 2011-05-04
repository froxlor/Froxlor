<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Install
 *
 */

if($settings['panel']['version'] == '1.2.19')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'system\', \'mod_fcgid_configdir\', \'/var/www/php-fcgi-scripts\')');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'system\', \'mod_fcgid_tmpdir\', \'/var/kunden/tmp\')');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.19-svn1';
}

if($settings['panel']['version'] == '1.2.19-svn1')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_LANGUAGE . '` (`language`, `file`) VALUES (\'Swedish\', \'lng/swedish.lng.php\');');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.19-svn2';
}

if($settings['panel']['version'] == '1.2.19-svn2')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'ticket\', \'reset_cycle\', \'2\')');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn3\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.19-svn3';
}

if($settings['panel']['version'] == '1.2.19-svn3')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn4\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.19-svn4';
}

if($settings['panel']['version'] == '1.2.19-svn4')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'panel\', \'no_robots\', \'1\')');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn4.5\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.19-svn4.5';
}

if($settings['panel']['version'] == '1.2.19-svn4.5')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'logger\', \'enabled\', \'1\');');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'logger\', \'log_cron\', \'0\');');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'logger\', \'logfile\', \'\');');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'logger\', \'logtypes\', \'syslog\');');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'logger\', \'severity\', \'2\');');
	$db->query('CREATE TABLE IF NOT EXISTS `panel_syslog` (
	  `logid` bigint(20) NOT NULL auto_increment,
	  `action` int(5) NOT NULL default \'10\',
	  `type` int(5) NOT NULL default \'0\',
	  `date` int(15) NOT NULL,
	  `user` varchar(50) NOT NULL,
	  `text` text NOT NULL,
	  PRIMARY KEY  (`logid`)
	  ) ENGINE=MyISAM;');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn6\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.19-svn6';
}

// ok, from this version on, we need the php filter-extension!

if(!extension_loaded('filter'))
{
	$updatelog->logAction(ADM_ACTION, LOG_ERR, "You need to install the php filter-extension! Update to 1.2.19-svn6 aborted");

	// skipping the update will not work, this ends up in an endless redirection from index.php to updatesql.php and back to index.php

	die("You need to install the php filter-extension! Update to 1.2.19-svn6 aborted");
}
else
{
	if(!extension_loaded('bcmath'))
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "The php extension 'bcmath' is not installed - SysCP will work without it but might not return exact traffic/space-usage values!");
	}

	$php_ob = @ini_get("open_basedir");

	if(!empty($php_ob)
	   && $php_ob != '')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Detected enabled 'open_basedir', please disable open_basedir to make SysCP work properly!");
	}

	if($settings['panel']['version'] == '1.2.19-svn6')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn6 to 1.2.19-svn7");
		$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl` tinyint(4) NOT NULL default '0'");
		$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_redirect` tinyint(4) NOT NULL default '0'");
		$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `ssl_ipandport` tinyint(4) NOT NULL default '0'");
		$db->query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `ssl` tinyint(4) NOT NULL default '0'");
		$db->query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` ADD `ssl_cert` tinytext AFTER `ssl`");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system','ssl_cert_file','/etc/apache2/apache2.pem')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system','use_ssl','1')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system','openssl_cnf','[ req ]\r\ndefault_bits = 1024\r\ndistinguished_name = req_distinguished_name\r\nattributes = req_attributes\r\nprompt = no\r\noutput_password =\r\ninput_password =\r\n[ req_distinguished_name ]\r\nC = DE\r\nST = syscp\r\nL = syscp    \r\nO = Testcertificate\r\nOU = syscp        \r\nCN = @@domain_name@@\r\nemailAddress = @@email@@    \r\n[ req_attributes ]\r\nchallengePassword =\r\n')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system','default_vhostconf', '')");
		$db->query("ALTER TABLE `" . TABLE_MAIL_USERS . "` ADD `quota` BIGINT( 13 ) NOT NULL DEFAULT '0' AFTER `customerid`, ADD `pop3` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `quota` , ADD `imap` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `pop3`");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mail_quota_enabled', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mail_quota', '104857600')");
		$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `email_quota` BIGINT( 13 ) NOT NULL DEFAULT '0' AFTER `email_forwarders_used` , ADD `email_quota_used` BIGINT( 13 ) NOT NULL DEFAULT '0' AFTER `email_quota`, ADD `imap` TINYINT( 1 ) NOT NULL DEFAULT '1', ADD `pop3` TINYINT( 1 ) NOT NULL DEFAULT '1'");
		$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `email_quota` BIGINT( 13 ) NOT NULL DEFAULT '0' AFTER `email_forwarders_used` , ADD `email_quota_used` BIGINT( 13 ) NOT NULL DEFAULT '0' AFTER `email_quota`");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'decimal_places', '4')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn7\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn7';
	}

	if($settings['panel']['version'] == '1.2.19-svn7')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn7 to 1.2.19-svn8");
		$db->query("
				CREATE TABLE `mail_dkim` (
					`id` int(11) NOT NULL auto_increment,
					`domain_id` int(11) NOT NULL default '0',
					`publickey` text NOT NULL,
					PRIMARY KEY  (`id`)
				) ENGINE=MyISAM
			");
		$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `dkim` tinyint(1) NOT NULL default '0' AFTER `zonefile`");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_prefix', '/etc/postfix/dkim/')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_domains', 'domains')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_dkimkeys', 'dkim-keys.conf')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkimrestart_command', '/etc/init.d/dkim-filter restart')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn8\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn8';
	}

	if($settings['panel']['version'] == '1.2.19-svn8')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn8 to 1.2.19-svn9");
		$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `caneditphpsettings` tinyint(1) NOT NULL default '0' AFTER `domains_see_all`");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn9\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn9';
	}

	if($settings['panel']['version'] == '1.2.19-svn9')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn9 to 1.2.19-svn10");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn10\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn10';
	}

	if($settings['panel']['version'] == '1.2.19-svn10')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn10 to 1.2.19-svn11");
		$db->query("ALTER TABLE `" . TABLE_PANEL_IPSANDPORTS . "` CHANGE `ip` `ip` VARCHAR(39) NOT NULL default ''");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn11\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn11';
	}

	if($settings['panel']['version'] == '1.2.19-svn11')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn11 to 1.2.19-svn12");
		$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `ip` tinyint(4) NOT NULL default '-1' AFTER `def_language`");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn12\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn12';
	}

	if($settings['panel']['version'] == '1.2.19-svn12')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn12 to 1.2.19-svn13");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'use_dkim', '0')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn13\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn13';
	}

	if($settings['panel']['version'] == '1.2.19-svn13')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn13 to 1.2.19-svn14");
		$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `email_only` tinyint(1) NOT NULL default '0' AFTER `isemaildomain`");
		$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `wwwserveralias` tinyint(1) NOT NULL default '1' AFTER `dkim`");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn14\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn14';
	}

	if($settings['panel']['version'] == '1.2.19-svn14')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn14 to 1.2.19-svn15");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'webalizer_enabled', '1')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_enabled', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_domain_file', '/etc/awstats/')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_model_file', '/etc/awstats/awstats.model.conf.syscp')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn15\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn15';
	}

	if($settings['panel']['version'] == '1.2.19-svn15')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn15 to 1.2.19-svn16");
		$db->query("
			CREATE TABLE `panel_dns` (
			  `dnsid` bigint(15) NOT NULL auto_increment,
			  `domainid` int(11) NOT NULL,
			  `customerid` int(11) NOT NULL,
			  `adminid` int(11) NOT NULL,
			  `ipv4` varchar(15) NOT NULL,
			  `ipv6` varchar(39) NOT NULL,
			  `cname` varchar(255) NOT NULL,
			  `mx10` varchar(255) NOT NULL,
			  `mx20` varchar(255) NOT NULL,
			  `txt` text NOT NULL,
			  PRIMARY KEY  (`dnsid`),
			  UNIQUE KEY `domainid` (`domainid`)
			) ENGINE=MyISAM;
			");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'userdns', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'customerdns', '0')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn16\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn16';
	}

	if($settings['panel']['version'] == '1.2.19-svn16')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn16 to 1.2.19-svn17");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'unix_names', '1')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn17\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn17';
	}

	if($settings['panel']['version'] == '1.2.19-svn17')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn17 to 1.2.19-svn18");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'allow_preset', '1')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn18\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn18';
	}

	if($settings['panel']['version'] == '1.2.19-svn18')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn18 to 1.2.19-svn19");

		// Update all email-admins and give'em unlimited email_quota resources

		$sql = "SELECT `adminid` FROM `" . TABLE_PANEL_ADMINS . "`
			WHERE `emails` = '-1'
			AND `email_accounts` = '-1'
			AND `email_forwarders` = '-1'";
		$admins = $db->query($sql);

		while($admin = $db->fetch_array($admins))
		{
			$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `email_quota` = '-1' WHERE `adminid` = '" . $admin['adminid'] . "'");
		}

		if($settings['system']['apacheversion'] == 'lighttpd'
		   && $settings['system']['apachereload_command'] == '/etc/init.d/lighttpd force-reload')
		{
			$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/init.d/lighttpd reload' WHERE `settinggroup` = 'system' AND `varname` = 'apachereload_command'");
		}

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn19\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn19';
	}

	if($settings['panel']['version'] == '1.2.19-svn19')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn19 to 1.2.19-svn20");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_path', '/usr/share/awstats/VERSION/webroot/cgi-bin/')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_updateall_command', '/usr/bin/awstats_updateall.pl')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn20\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn20';
	}

	if($settings['panel']['version'] == '1.2.19-svn20')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn20 to 1.2.19-svn21");

		// ADDING BILLING

		$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "`
		  ADD `firstname` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `title` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `company` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `street` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `zipcode` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `city` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `country` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `phone` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `fax` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `taxid` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `contract_date` DATE NOT NULL,
		  ADD `contract_number` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `contract_details` TEXT NOT NULL DEFAULT '',
		  ADD `included_domains_qty` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `included_domains_tld` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `additional_traffic_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `additional_traffic_unit` BIGINT( 30 ) NOT NULL DEFAULT '0',
		  ADD `additional_diskspace_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `additional_diskspace_unit` BIGINT( 30 ) NOT NULL DEFAULT '0',
		  ADD `taxclass` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `setup_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `interval_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `interval_length` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `interval_type` VARCHAR( 1 ) NOT NULL DEFAULT 'm',
		  ADD `interval_payment` TINYINT( 1 ) NOT NULL DEFAULT '0',
		  ADD `calc_tax` TINYINT( 1 ) NOT NULL DEFAULT '1',
		  ADD `term_of_payment` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `payment_every` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `payment_method` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `bankaccount_holder` TEXT NOT NULL DEFAULT '',
		  ADD `bankaccount_number` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `bankaccount_blz` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `bankaccount_bank` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `service_active` TINYINT( 1 ) NOT NULL DEFAULT '0',
		  ADD `servicestart_date` DATE NOT NULL,
		  ADD `serviceend_date` DATE NOT NULL,
		  ADD `lastinvoiced_date` DATE NOT NULL,
		  ADD `lastinvoiced_date_traffic` DATE NOT NULL,
		  ADD `lastinvoiced_date_diskspace` DATE NOT NULL,
		  ADD `customer_categories_once` TEXT NOT NULL DEFAULT '',
		  ADD `customer_categories_period` TEXT NOT NULL DEFAULT '',
		  ADD `invoice_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_hosting` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_hosting_customers` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_domains` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_traffic` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_diskspace` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_other` DECIMAL( 10,2 ) NOT NULL DEFAULT '0';");
		$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "`
		  ADD `taxid` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `title` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `country` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `additional_service_description` TEXT NOT NULL DEFAULT '',
		  ADD `contract_date` DATE NOT NULL,
		  ADD `contract_number` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `contract_details` TEXT NOT NULL DEFAULT '',
		  ADD `included_domains_qty` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `included_domains_tld` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `additional_traffic_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `additional_traffic_unit` BIGINT( 30 ) NOT NULL DEFAULT '0',
		  ADD `additional_diskspace_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `additional_diskspace_unit` BIGINT( 30 ) NOT NULL DEFAULT '0',
		  ADD `taxclass` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `setup_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `interval_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `interval_length` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `interval_type` VARCHAR( 1 ) NOT NULL DEFAULT 'm',
		  ADD `interval_payment` TINYINT( 1 ) NOT NULL DEFAULT '0',
		  ADD `calc_tax` TINYINT( 1 ) NOT NULL DEFAULT '1',
		  ADD `term_of_payment` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `payment_every` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `payment_method` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `bankaccount_holder` TEXT NOT NULL DEFAULT '',
		  ADD `bankaccount_number` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `bankaccount_blz` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `bankaccount_bank` VARCHAR( 255 ) NOT NULL DEFAULT '',
		  ADD `service_active` TINYINT( 1 ) NOT NULL DEFAULT '0',
		  ADD `servicestart_date` DATE NOT NULL,
		  ADD `serviceend_date` DATE NOT NULL,
		  ADD `lastinvoiced_date` DATE NOT NULL,
		  ADD `lastinvoiced_date_traffic` DATE NOT NULL,
		  ADD `lastinvoiced_date_diskspace` DATE NOT NULL,
		  ADD `invoice_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_hosting` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_domains` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_traffic` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_diskspace` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `invoice_fee_other` DECIMAL( 10,2 ) NOT NULL DEFAULT '0';");
		$db->query("ALTER TABLE `panel_domains`
		  ADD `add_date` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `registration_date` DATE NOT NULL,
		  ADD `taxclass` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `setup_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `interval_fee` DECIMAL( 10,2 ) NOT NULL DEFAULT '0',
		  ADD `interval_length` INT( 11 ) NOT NULL DEFAULT '0',
		  ADD `interval_type` VARCHAR( 1 ) NOT NULL DEFAULT 'y',
		  ADD `interval_payment` TINYINT( 1 ) NOT NULL DEFAULT '0',
		  ADD `service_active` TINYINT( 1 ) NOT NULL DEFAULT '0',
		  ADD `servicestart_date` DATE NOT NULL,
		  ADD `serviceend_date` DATE NOT NULL,
		  ADD `lastinvoiced_date` DATE NOT NULL;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_SERVICE_CATEGORIES . "` (
		 `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `category_name` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_order` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `category_classname` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_classfile` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_cachefield` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_caption` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_rowcaption_setup` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_rowcaption_interval` VARCHAR( 255 ) NOT NULL DEFAULT ''
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_SERVICE_CATEGORIES_ADMINS . "` (
		 `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `category_name` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_order` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `category_mode` TINYINT( 1 ) NOT NULL DEFAULT '0',
		 `category_classname` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_classfile` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_cachefield` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_caption` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_rowcaption_setup` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `category_rowcaption_interval` VARCHAR( 255 ) NOT NULL DEFAULT ''
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_SERVICE_DOMAINS_TEMPLATES . "` (
		 `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `tld` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `valid_from` DATE NOT NULL,
		 `valid_to` DATE NOT NULL,
		 `taxclass` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `setup_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `interval_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `interval_length` INT( 11 ) NOT NULL DEFAULT '0',
		 `interval_type` VARCHAR( 1 ) NOT NULL DEFAULT 'y',
		 `interval_payment` TINYINT( 1 ) NOT NULL DEFAULT '0'
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_SERVICE_OTHER . "` (
		 `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `customerid` INT( 11 ) NOT NULL DEFAULT '0',
		 `templateid` INT( 11 ) NOT NULL DEFAULT '0',
		 `service_type` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `caption_setup` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `caption_interval` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `taxclass` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `quantity` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `setup_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `interval_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `interval_length` INT( 11 ) NOT NULL DEFAULT '0',
		 `interval_type` VARCHAR( 1 ) NOT NULL DEFAULT 'm',
		 `interval_payment` TINYINT( 1 ) NOT NULL DEFAULT '0',
		 `service_active` TINYINT( 1 ) NOT NULL DEFAULT '0',
		 `servicestart_date` DATE NOT NULL,
		 `serviceend_date` DATE NOT NULL,
		 `lastinvoiced_date` DATE NOT NULL
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_SERVICE_OTHER_TEMPLATES . "` (
		 `templateid` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `valid_from` DATE NOT NULL,
		 `valid_to` DATE NOT NULL,
		 `service_type` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `caption_setup` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `caption_interval` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `taxclass` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `setup_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `interval_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `interval_length` INT( 11 ) NOT NULL DEFAULT '0',
		 `interval_type` VARCHAR( 1 ) NOT NULL DEFAULT 'm',
		 `interval_payment` TINYINT( 1 ) NOT NULL DEFAULT '0'
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_TAXCLASSES . "` (
		 `classid` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `classname` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `default` TINYINT( 1 ) NOT NULL DEFAULT '0'
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_TAXRATES . "` (
		 `taxid` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `taxclass` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `taxrate` DECIMAL( 4, 4 ) NOT NULL ,
		 `valid_from` DATE NOT NULL
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_INVOICES . "` (
		 `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `customerid` INT( 11 ) NOT NULL DEFAULT '0',
		 `xml` LONGTEXT NOT NULL DEFAULT '',
		 `invoice_date` DATE NOT NULL,
		 `state` TINYINT( 1 ) NOT NULL DEFAULT '0',
		 `state_change` INT( 11 ) NOT NULL DEFAULT '0',
		 `invoice_number` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `total_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `total_fee_taxed` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00'
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_INVOICES_ADMINS . "` (
		 `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `adminid` INT( 11 ) NOT NULL DEFAULT '0',
		 `xml` LONGTEXT NOT NULL DEFAULT '',
		 `invoice_date` DATE NOT NULL,
		 `state` TINYINT( 1 ) NOT NULL DEFAULT '0',
		 `state_change` INT( 11 ) NOT NULL DEFAULT '0',
		 `invoice_number` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `total_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `total_fee_taxed` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00'
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_INVOICE_CHANGES . "` (
		 `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `customerid` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `userid` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `timestamp` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `key` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `action` TINYINT( 1 ) NOT NULL DEFAULT '0',
		 `caption` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `interval` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `quantity` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `total_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `taxrate` DECIMAL( 4, 4 ) NOT NULL
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE  `" . TABLE_BILLING_INVOICE_CHANGES_ADMINS . "` (
		 `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		 `adminid` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `userid` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `timestamp` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `key` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `action` TINYINT( 1 ) NOT NULL DEFAULT '0',
		 `caption` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `interval` VARCHAR( 255 ) NOT NULL DEFAULT '',
		 `quantity` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
		 `total_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
		 `taxrate` DECIMAL( 4, 4 ) NOT NULL
		) TYPE = MYISAM ;");
		$db->query("CREATE TABLE `" . TABLE_PANEL_DISKSPACE . "` (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `customerid` int(11) unsigned NOT NULL default '0',
		  `year` int(4) unsigned zerofill NOT NULL default '0000',
		  `month` int(2) unsigned zerofill NOT NULL default '00',
		  `day` int(2) unsigned zerofill NOT NULL default '00',
		  `stamp` int(11) unsigned NOT NULL default '0',
		  `webspace` bigint(30) unsigned NOT NULL default '0',
		  `mail` bigint(30) unsigned NOT NULL default '0',
		  `mysql` bigint(30) unsigned NOT NULL default '0',
		  PRIMARY KEY  (`id`),
		  KEY `customerid` (`customerid`)
		) ENGINE=MyISAM ;");
		$db->query("CREATE TABLE `" . TABLE_PANEL_DISKSPACE_ADMINS . "` (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `adminid` int(11) unsigned NOT NULL default '0',
		  `year` int(4) unsigned zerofill NOT NULL default '0000',
		  `month` int(2) unsigned zerofill NOT NULL default '00',
		  `day` int(2) unsigned zerofill NOT NULL default '00',
		  `stamp` int(11) unsigned NOT NULL default '0',
		  `webspace` bigint(30) unsigned NOT NULL default '0',
		  `mail` bigint(30) unsigned NOT NULL default '0',
		  `mysql` bigint(30) unsigned NOT NULL default '0',
		  PRIMARY KEY  (`id`),
		  KEY `adminid` (`adminid`)
		) ENGINE=MyISAM ;");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES . "` (`id`, `category_name`, `category_order`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (1, 'hosting', 10, 'hosting', 'lib/billing_class_hosting.php', 'invoice_fee_hosting', 'hosting_caption', 'hosting_rowcaption_setup', 'hosting_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES . "` (`id`, `category_name`, `category_order`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (2, 'domains', 20, 'domains', 'lib/billing_class_domains.php', 'invoice_fee_domains', 'domains_caption', 'domains_rowcaption_setup', 'domains_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES . "` (`id`, `category_name`, `category_order`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (3, 'traffic', 30, 'traffic', 'lib/billing_class_traffic.php', 'invoice_fee_traffic', 'traffic_caption', 'traffic_rowcaption_setup', 'traffic_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES . "` (`id`, `category_name`, `category_order`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (4, 'diskspace', 40, 'diskspace', 'lib/billing_class_diskspace.php', 'invoice_fee_diskspace', 'diskspace_caption', 'diskspace_rowcaption_setup', 'diskspace_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES . "` (`id`, `category_name`, `category_order`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (5, 'other', 50, 'other', 'lib/billing_class_other.php', 'invoice_fee_other', 'other_caption', 'other_rowcaption_setup', 'other_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES_ADMINS . "` (`id`, `category_name`, `category_order`, `category_mode`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (1, 'hosting', 10, 0, 'hosting', 'lib/billing_class_hosting.php', 'invoice_fee_hosting', 'hosting_caption', 'hosting_rowcaption_setup', 'hosting_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES_ADMINS . "` (`id`, `category_name`, `category_order`, `category_mode`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (2, 'hosting_customers', 20, 1, 'hosting', 'lib/billing_class_hosting.php', 'invoice_fee_hosting_customers', 'hosting_caption', 'hosting_rowcaption_setup_withloginname', 'hosting_rowcaption_interval_withloginname');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES_ADMINS . "` (`id`, `category_name`, `category_order`, `category_mode`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (3, 'domains', 30, 1, 'domains', 'lib/billing_class_domains.php', 'invoice_fee_domains', 'domains_caption', 'domains_rowcaption_setup', 'domains_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES_ADMINS . "` (`id`, `category_name`, `category_order`, `category_mode`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (4, 'traffic', 40, 0, 'traffic', 'lib/billing_class_traffic.php', 'invoice_fee_traffic', 'traffic_caption', 'traffic_rowcaption_setup', 'traffic_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES_ADMINS . "` (`id`, `category_name`, `category_order`, `category_mode`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (5, 'diskspace', 50, 0, 'diskspace', 'lib/billing_class_diskspace.php', 'invoice_fee_diskspace', 'diskspace_caption', 'diskspace_rowcaption_setup', 'diskspace_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_SERVICE_CATEGORIES_ADMINS . "` (`id`, `category_name`, `category_order`, `category_mode`, `category_classname`, `category_classfile`, `category_cachefield`, `category_caption`, `category_rowcaption_setup`, `category_rowcaption_interval`) VALUES (6, 'other', 60, 1, 'other', 'lib/billing_class_other.php', 'invoice_fee_other', 'other_caption', 'other_rowcaption_setup', 'other_rowcaption_interval');");
		$db->query("INSERT INTO `" . TABLE_BILLING_TAXCLASSES . "` (`classid`, `classname`, `default`) VALUES ( NULL, 'MwSt Deutschland', '1' );");
		$db->query("INSERT INTO `" . TABLE_BILLING_TAXCLASSES . "` (`classid`, `classname`, `default`) VALUES ( NULL, 'MwSt Deutschland (reduziert)', '0' );");
		$db->query("INSERT INTO `" . TABLE_BILLING_TAXRATES . "` (`taxid`, `taxclass`, `taxrate`, `valid_from`) VALUES ( NULL, 1, 0.1600, '0' );");
		$db->query("INSERT INTO `" . TABLE_BILLING_TAXRATES . "` (`taxid`, `taxclass`, `taxrate`, `valid_from`) VALUES ( NULL, 1, 0.1900, '2007-01-01' );");
		$db->query("INSERT INTO `" . TABLE_BILLING_TAXRATES . "` (`taxid`, `taxclass`, `taxrate`, `valid_from`) VALUES ( NULL, 2, 0.0700, '0' );");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (NULL, 'billing', 'invoicenumber_count', '0');");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn21\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn21';
	}

	if($settings['panel']['version'] == '1.2.19-svn21')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn21 to 1.2.19-svn22");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'allow_preset_admin', '0')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn22\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn22';
	}

	if($settings['panel']['version'] == '1.2.19-svn22')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn22 to 1.2.19-svn23");
		$db->query("ALTER TABLE  `" . TABLE_PANEL_ADMINS . "` ADD  `edit_billingdata` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER  `change_serversettings`");
		$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `edit_billingdata` = '1' WHERE `customers_see_all` = '1'");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn23\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn23';
	}

	if($settings['panel']['version'] == '1.2.19-svn23')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn23 to 1.2.19-svn24");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('billing', 'activate_billing', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('billing', 'highlight_inactive', '0')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn24\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn24';
	}

	if($settings['panel']['version'] == '1.2.19-svn24')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn24 to 1.2.19-svn25");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn25\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn25';
	}

	if($settings['panel']['version'] == '1.2.19-svn25')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn25 to 1.2.19-svn26");
		$db->query("INSERT INTO " . TABLE_PANEL_LANGUAGE . " SET `language` = 'Swedish', `file` = 'lng/swedish.lng.php';");
		$db->query("INSERT INTO " . TABLE_PANEL_LANGUAGE . " SET `language` = 'Czech', `file` = 'lng/czech.lng.php';");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn26\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn26';
	}

	if($settings['panel']['version'] == '1.2.19-svn26')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn26 to 1.2.19-svn27");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'webserver', 'apache2')");
		$db->query("CREATE TABLE `" . TABLE_MAIL_AUTORESPONDER . "` (
  			`email` varchar(255) NOT NULL default '',
  			`message` text NOT NULL,
  			`enabled` tinyint(1) NOT NULL default '0',
  			`subject` varchar(255) NOT NULL default '',
  			`customerid` int(11) NOT NULL default '0',
  			PRIMARY KEY  (`email`),
  			KEY `customerid` (`customerid`),
  			FULLTEXT KEY `message` (`message`)
			) ENGINE=MyISAM");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('autoresponder', 'autoresponder_active', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('autoresponder', 'last_autoresponder_run', '0')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn27\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn27';
	}

	if($settings['panel']['version'] == '1.2.19-svn27')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn27 to 1.2.19-svn28");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('admin', 'show_version_login', '0')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn28\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn28';
	}

	if($settings['panel']['version'] == '1.2.19-svn28')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn28 to 1.2.19-svn29");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('admin', 'show_version_footer', '0')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn29\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn29';
	}

	if($settings['panel']['version'] == '1.2.19-svn29')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn29 to 1.2.19-svn30");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('admin', 'syscp_graphic', 'images/header.gif')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn30\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn30';
	}

	if($settings['panel']['version'] == '1.2.19-svn30')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn30 to 1.2.19-svn31");

		//fcgid improvements

		$db->query("CREATE TABLE `" . TABLE_PANEL_PHPCONFIGS . "` (
  					`id` int(11) unsigned NOT NULL auto_increment,
					`phpsettings` text NOT NULL,
					`description` varchar(50) NOT NULL,
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM");
		$db->query("INSERT INTO `" . TABLE_PANEL_PHPCONFIGS . "` (`id`, `phpsettings`, `description`) VALUES(1, 'short_open_tag = On\r\nasp_tags = Off\r\nprecision = 14\r\noutput_buffering = 4096\r\nallow_call_time_pass_reference = Off\r\nsafe_mode = {SAFE_MODE}\r\nsafe_mode_gid = Off\r\nsafe_mode_include_dir = \"{PEAR_DIR}\"\r\nsafe_mode_allowed_env_vars = PHP_\r\nsafe_mode_protected_env_vars = LD_LIBRARY_PATH\r\n{OPEN_BASEDIR_C}open_basedir = \"{OPEN_BASEDIR}\"\r\ndisable_functions = exec,passthru,shell_exec,system,proc_close,proc_get_status,proc_nice,proc_open,proc_terminate\r\ndisable_classes =\r\nexpose_php = Off\r\nmax_execution_time = 30\r\nmax_input_time = 60\r\nmemory_limit = 16M\r\npost_max_size = 16M\r\nerror_reporting = E_ALL & ~E_NOTICE\r\ndisplay_errors = On\r\ndisplay_startup_errors = Off\r\nlog_errors = On\r\nlog_errors_max_len = 1024\r\nignore_repeated_errors = Off\r\nignore_repeated_source = Off\r\nreport_memleaks = On\r\ntrack_errors = Off\r\nhtml_errors = Off\r\nvariables_order = \"GPCS\"\r\nregister_globals = Off\r\nregister_argc_argv = Off\r\ngpc_order = \"GPC\"\r\nmagic_quotes_gpc = Off\r\nmagic_quotes_runtime = Off\r\nmagic_quotes_sybase = Off\r\ninclude_path = \".:{PEAR_DIR}\"\r\nenable_dl = Off\r\nfile_uploads = On\r\nupload_tmp_dir = \"{TMP_DIR}\"\r\nupload_max_filesize = 32M\r\nallow_url_fopen = Off\r\nsendmail_path = \"/usr/sbin/sendmail -t -f {CUSTOMER_EMAIL}\"\r\nsession.save_handler = files\r\nsession.save_path = \"{TMP_DIR}\"\r\nsession.use_cookies = 1\r\nsession.name = PHPSESSID\r\nsession.auto_start = 0\r\nsession.cookie_lifetime = 0\r\nsession.cookie_path = /\r\nsession.cookie_domain =\r\nsession.serialize_handler = php\r\nsession.gc_probability = 1\r\nsession.gc_divisor = 1000\r\nsession.gc_maxlifetime = 1440\r\nsession.bug_compat_42 = 0\r\nsession.bug_compat_warn = 1\r\nsession.referer_check =\r\nsession.entropy_length = 16\r\nsession.entropy_file = /dev/urandom\r\nsession.cache_limiter = nocache\r\nsession.cache_expire = 180\r\nsession.use_trans_sid = 0\r\nsuhosin.simulation = Off\r\nsuhosin.mail.protect = 1\r\n', 'Default Config')");
		$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `phpsettingid` INT( 11 ) UNSIGNED NOT NULL DEFAULT '1'");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES('system', 'mod_fcgid_wrapper', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES('system', 'mod_fcgid_starter', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES('system', 'mod_fcgid_peardir', '/usr/share/php/:/usr/share/php5/')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn31\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn31';
	}

	if($settings['panel']['version'] == '1.2.19-svn31')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn31 to 1.2.19-svn32");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES('system', 'index_file_extension', 'html');");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn32\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn32';
	}

	if($settings['panel']['version'] == '1.2.19-svn32')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn32 to 1.2.19-svn33");
		$db->query("ALTER TABLE  `" . TABLE_PANEL_DOMAINS . "` ADD  `dkim_id` INT( 11 ) UNSIGNED NOT NULL AFTER  `dkim`, ADD  `dkim_privkey` TEXT NOT NULL AFTER  `dkim_id`, ADD  `dkim_pubkey` TEXT NOT NULL AFTER  `dkim_privkey`");
		$db->query("DROP TABLE IF EXISTS `mail_dkim`");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn33\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn33';
	}

	if($settings['panel']['version'] == '1.2.19-svn33')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn33 to 1.2.19-svn34");
		$db->query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'userdns'");
		$db->query("DELETE FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `settinggroup` = 'system' AND `varname` = 'customerdns'");
		$db->query("DROP TABLE IF EXISTS `panel_dns`");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn34\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn34';
	}

	if($settings['panel']['version'] == '1.2.19-svn34')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn34 to 1.2.19-svn35");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'items_per_page', '20')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'upload_fields', '5')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'aps_active', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'php-extension', '')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'php-configuration', '')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'webserver-htaccess', '')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'php-function', '')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'webserver-module', '')");
		$db->query("CREATE TABLE IF NOT EXISTS `" . TABLE_APS_INSTANCES . "` (
					`ID` int(4) NOT NULL auto_increment,
					`CustomerID` int(4) NOT NULL,
					`PackageID` int(4) NOT NULL,
					`Status` int(4) NOT NULL,
					PRIMARY KEY  (`ID`)
					) ENGINE=MyISAM");
		$db->query("CREATE TABLE IF NOT EXISTS `" . TABLE_APS_PACKAGES . "` (
					`ID` int(4) NOT NULL auto_increment,
					`Path` varchar(500) NOT NULL,
					`Name` varchar(500) NOT NULL,
					`Version` varchar(20) NOT NULL,
					`Release` int(4) NOT NULL,
					`Status` int(1) NOT NULL default '1',
					PRIMARY KEY  (`ID`)
					) ENGINE=MyISAM");
		$db->query("CREATE TABLE IF NOT EXISTS `" . TABLE_APS_SETTINGS . "` (
					`ID` int(4) NOT NULL auto_increment,
					`InstanceID` int(4) NOT NULL,
					`Name` varchar(250) NOT NULL,
					`Value` varchar(250) NOT NULL,
					PRIMARY KEY  (`ID`)
					) ENGINE=MyISAM");
		$db->query("CREATE TABLE IF NOT EXISTS `" . TABLE_APS_TASKS . "` (
					`ID` int(4) NOT NULL auto_increment,
					`InstanceID` int(4) NOT NULL,
					`Task` int(4) NOT NULL,
					PRIMARY KEY  (`ID`)
					) ENGINE=MyISAM");
		$db->query("CREATE TABLE IF NOT EXISTS `" . TABLE_APS_TEMP_SETTINGS . "` (
					`ID` int(4) NOT NULL auto_increment,
					`PackageID` int(4) NOT NULL,
					`CustomerID` int(4) NOT NULL,
					`Name` varchar(250) NOT NULL,
					`Value` varchar(250) NOT NULL,
					PRIMARY KEY  (`ID`)
					) ENGINE=MyISAM");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn35\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn35';
	}

	if($settings['panel']['version'] == '1.2.19-svn35')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn35 to 1.2.19-svn36");
		$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `mod_fcgid_starter` INT( 4 ) NULL DEFAULT '-1'");
		$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `can_manage_aps_packages` TINYINT( 1 ) NOT NULL DEFAULT '1'");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn36\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn36';
	}

	if($settings['panel']['version'] == '1.2.19-svn36')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn36 to 1.2.19-svn37");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'realtime_port', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('session', 'allow_multiple_login', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'allow_domain_change_admin', '0')");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'allow_domain_change_customer', '0')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn37\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn37';
	}

	if($settings['panel']['version'] == '1.2.19-svn37')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn37 to 1.2.19-svn38");
		$db->query("ALTER TABLE `" . TABLE_PANEL_PHPCONFIGS . "` ADD `binary` VARCHAR( 255 ) NOT NULL, ADD `file_extensions` VARCHAR( 255 ) NOT NULL, ADD `mod_fcgid_starter` int(4) NOT NULL DEFAULT '-1', ADD `mod_fcgid_maxrequests` int(4) NOT NULL DEFAULT '-1'");
		$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `mod_fcgid_maxrequests` INT( 4 ) NULL DEFAULT '-1'");
		$db->query("UPDATE `" . TABLE_PANEL_PHPCONFIGS . "` SET `binary` = '/usr/bin/php-cgi', `file_extensions` = 'php'");
		$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES('system', 'mod_fcgid_maxrequests', '250')");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn38\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn38';
	}

	if($settings['panel']['version'] == '1.2.19-svn38')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn38 to 1.2.19-svn39");
		$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `aps_packages` INT( 5 ) NOT NULL DEFAULT '0', ADD `aps_packages_used` INT( 5 ) NOT NULL DEFAULT '0'");
		$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `aps_packages` INT( 5 ) NOT NULL DEFAULT '0', ADD `aps_packages_used` INT( 5 ) NOT NULL DEFAULT '0'");

		//give admins which can see all customers and domains plus change serversettings the ability to have unlimited aps instances

		$admins = $db->query("SELECT `adminid` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `customers_see_all` = 1 AND `domains_see_all` = 1 AND `change_serversettings` = 1");

		while($admin = $db->fetch_array($admins))
		{
			$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `aps_packages` = -1 WHERE `adminid` = '" . $admin['adminid'] . "'");
		}

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn39\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn39';
	}

	if($settings['panel']['version'] == '1.2.19-svn39')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn39 to 1.2.19-svn40");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `varname` = 'webserver' WHERE `settinggroup` = 'system' AND `varname` = 'apacheversion'");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn40\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn40';
	}

	if($settings['panel']['version'] == '1.2.19-svn40')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn40 to 1.2.19-svn41");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn41\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn41';
	}

	if($settings['panel']['version'] == '1.2.19-svn41')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn41 to 1.2.19-svn42");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '100' WHERE `settinggroup` = 'system' AND `varname` = 'mail_quota' AND `value` = '104857600'");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn42\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn42';
	}

	if($settings['panel']['version'] == '1.2.19-svn42')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn42 to 1.2.19-svn43");

		// Going to fix double slashes in the database

		$result = $db->query("SELECT * FROM `" . TABLE_PANEL_HTACCESS . "` WHERE `path` LIKE '%//%';");

		while($row = $db->fetch_array($result))
		{
			$row['path'] = makeCorrectDir($row['path']);
			$db->query("UPDATE `" . TABLE_PANEL_HTACCESS . "` SET `path` = '" . $db->escape($row['path']) . "' WHERE `id` = '" . $row['id'] . "';");
		}

		$result = $db->query("SELECT * FROM `" . TABLE_PANEL_HTPASSWDS . "` WHERE `path` LIKE '%//%';");

		while($row = $db->fetch_array($result))
		{
			$row['path'] = makeCorrectDir($row['path']);
			$db->query("UPDATE `" . TABLE_PANEL_HTPASSWDS . "` SET `path` = '" . $db->escape($row['path']) . "' WHERE `id` = '" . $row['id'] . "';");
		}

		$result = $db->query("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `documentroot` LIKE '%//%';");

		while($row = $db->fetch_array($result))
		{
			if(!preg_match("#^https?://#i", $row['documentroot']))
			{
				$row['documentroot'] = makeCorrectDir($row['documentroot']);
				$db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `documentroot` = '" . $db->escape($row['documentroot']) . "' WHERE `id` = '" . $row['id'] . "';");
			}
		}

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.2.19-svn43\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.2.19-svn43';
	}

	if($settings['panel']['version'] == '1.2.19-svn43')
	{
		$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.2.19-svn43 to 1.4");

		// set new version

		$query = 'UPDATE `%s` SET `value` = \'1.4\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
		$query = sprintf($query, TABLE_PANEL_SETTINGS);
		$db->query($query);
		$settings['panel']['version'] = '1.4';
	}
}

// php filter-extension check



?>
