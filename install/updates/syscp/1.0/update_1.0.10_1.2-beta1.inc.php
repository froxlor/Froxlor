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

/**
 * We need those defines, because the tables.inc.php doesn't have them.
 */

define('TABLE_POSTFIX_TRANSPORT', 'postfix_transport');
define('TABLE_POSTFIX_USERS', 'postfix_users');
define('TABLE_POSTFIX_VIRTUAL', 'postfix_virtual');
define('TABLE_PROFTPD_GROUPS', 'proftpd_groups');
define('TABLE_PROFTPD_USERS', 'proftpd_users');

if($settings['panel']['version'] == '1.0.10')
{
	// Drop/Rename postfix_ tables

	$db->query("DROP TABLE IF EXISTS `" . TABLE_POSTFIX_TRANSPORT . "`");
	$db->query("ALTER TABLE `" . TABLE_POSTFIX_USERS . "` RENAME `" . TABLE_MAIL_USERS . "` ");
	$db->query("ALTER TABLE `" . TABLE_POSTFIX_VIRTUAL . "` RENAME `" . TABLE_MAIL_VIRTUAL . "` ");

	// Rename proftpd_ tables

	$db->query("ALTER TABLE `" . TABLE_PROFTPD_USERS . "` RENAME `" . TABLE_FTP_USERS . "` ");
	$db->query("ALTER TABLE `" . TABLE_PROFTPD_GROUPS . "` RENAME `" . TABLE_FTP_GROUPS . "` ");

	// Adding tables

	$db->query("DROP TABLE IF EXISTS `" . TABLE_PANEL_HTACCESS . "`;");
	$db->query("CREATE TABLE `" . TABLE_PANEL_HTACCESS . "` (" . "  `id` int(11) unsigned NOT NULL auto_increment," . "  `customerid` int(11) unsigned NOT NULL default '0'," . "  `path` varchar(255) NOT NULL default ''," . "  `options_indexes` tinyint(1) NOT NULL default '0'," . "  PRIMARY KEY  (`id`)" . ") ENGINE=MyISAM ;");
	$db->query("DROP TABLE IF EXISTS `" . TABLE_PANEL_ADMINS . "`;");
	$db->query("CREATE TABLE `" . TABLE_PANEL_ADMINS . "` (" . "  `adminid` int(11) unsigned NOT NULL auto_increment," . "  `loginname` varchar(50) NOT NULL default ''," . "  `password` varchar(50) NOT NULL default ''," . "  `name` varchar(255) NOT NULL default ''," . "  `email` varchar(255) NOT NULL default ''," . "  `customers` int(15) NOT NULL default '0'," . "  `customers_used` int(15) NOT NULL default '0'," . "  `customers_see_all` tinyint(1) NOT NULL default '0'," . "  `domains` int(15) NOT NULL default '0'," . "  `domains_used` int(15) NOT NULL default '0'," . "  `domains_see_all` tinyint(1) NOT NULL default '0'," . "  `change_serversettings` tinyint(1) NOT NULL default '0'," . "  `diskspace` int(15) NOT NULL default '0'," . "  `diskspace_used` int(15) NOT NULL default '0'," . "  `mysqls` int(15) NOT NULL default '0'," . "  `mysqls_used` int(15) NOT NULL default '0'," . "  `emails` int(15) NOT NULL default '0'," . "  `emails_used` int(15) NOT NULL default '0'," . "  `email_forwarders` int(15) NOT NULL default '0'," . "  `email_forwarders_used` int(15) NOT NULL default '0'," . "  `ftps` int(15) NOT NULL default '0'," . "  `ftps_used` int(15) NOT NULL default '0'," . "  `subdomains` int(15) NOT NULL default '0'," . "  `subdomains_used` int(15) NOT NULL default '0'," . "  `traffic` int(15) NOT NULL default '0'," . "  `traffic_used` int(15) NOT NULL default '0'," . "  `deactivated` tinyint(1) NOT NULL default '0'," . "  `lastlogin_succ` int(11) unsigned NOT NULL default '0'," . "  `lastlogin_fail` int(11) unsigned NOT NULL default '0'," . "  `loginfail_count` int(11) unsigned NOT NULL default '0'," . "   PRIMARY KEY  (`adminid`)" . ") ENGINE=MyISAM ;");

	// Insert Admin user

	if(!isset($adminusername)
	   || $adminusername == '')
	{
		$adminusername = 'admin';
		$adminpassword = 'admin';
	}

	$db->query("INSERT INTO `" . TABLE_PANEL_ADMINS . "` (`loginname`, `password`, `name`, `email`, `customers`, `customers_used`, `customers_see_all`, `domains`, `domains_used`, `domains_see_all`, `change_serversettings`, `diskspace`, `diskspace_used`, `mysqls`, `mysqls_used`, `emails`, `emails_used`, `email_forwarders`, `email_forwarders_used`, `ftps`, `ftps_used`, `subdomains`, `subdomains_used`, `traffic`, `traffic_used`, `deactivated`) VALUES ('" . $db->escape($adminusername) . "', '" . md5($adminpassword) . "', 'Siteadmin', 'admin@servername', -1, 0, 1, -1, 0, 1, 1, -1024, 0, -1, 0, -1, 0, -1, 0, -1, 0, -1, 0, -1048576, 0, 0);");

	// Alter Tables

	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `adminid` INT( 11 ) UNSIGNED NOT NULL ," . "ADD `lastlogin_succ` INT( 11 ) UNSIGNED NOT NULL ," . "ADD `lastlogin_fail` INT( 11 ) UNSIGNED NOT NULL ," . "ADD `loginfail_count` INT( 11 ) UNSIGNED NOT NULL ;");
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD INDEX ( `adminid` ) ;");
	$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `adminid` = '1'");
	$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `adminid` INT( 11 ) UNSIGNED NOT NULL ," . "ADD `iswildcarddomain` TINYINT( 1 ) NOT NULL ," . "ADD `speciallogfile` TINYINT( 1 ) NOT NULL ;");
	$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD INDEX ( `adminid` ) ;");
	$db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `adminid` = '1'");
	$db->query("ALTER TABLE `" . TABLE_PANEL_SESSIONS . "` CHANGE `customerid` `userid` INT( 11 ) UNSIGNED DEFAULT '0' NOT NULL ");
	$db->query("ALTER TABLE `" . TABLE_MAIL_USERS . "` CHANGE `password` `password_enc` VARCHAR( 128 ) NOT NULL ");
	$db->query("ALTER TABLE `" . TABLE_MAIL_USERS . "` ADD `password` VARCHAR( 128 ) NOT NULL AFTER `email` ;");
	$db->query("INSERT INTO `panel_settings` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (24, 'login', 'maxloginattempts', '3');");
	$db->query("INSERT INTO `panel_settings` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (25, 'login', 'deactivatetime', '900');");
	$db->query("INSERT INTO `panel_settings` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (26, 'panel', 'webmail_url', '');");
	$db->query("INSERT INTO `panel_settings` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (27, 'panel', 'webftp_url', '');");
	$db->query("INSERT INTO `panel_settings` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (28, 'panel', 'standardlanguage', 'german');");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `varname`='ipaddress' WHERE `settinggroup`='system' AND `varname`='ipadress'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.0' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.0';
}

?>
