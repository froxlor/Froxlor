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

if($settings['panel']['version'] == '1.2-beta1'
   || $settings['panel']['version'] == '1.2-rc1')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.0' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.0';
}

if($settings['panel']['version'] == '1.2.0')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.1';
}

if($settings['panel']['version'] == '1.2.1')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_SESSIONS . "` CHANGE `useragent` `useragent` VARCHAR( 255 ) NOT NULL");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.2';
}

if($settings['panel']['version'] == '1.2.2')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.2-cvs1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.2-cvs1';
}

if($settings['panel']['version'] == '1.2.2-cvs1')
{
	$db->query("
			CREATE TABLE `" . TABLE_PANEL_LANGUAGE . "` (
  				`id`       int(11)      unsigned NOT NULL auto_increment,
  				`language` varchar(30)           NOT NULL default '',
  				`file`     varchar(255)          NOT NULL default '',
  			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM
		");
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`id`, `language`, `file`) VALUES (1, 'Deutsch', 'lng/german.lng.php');");
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`id`, `language`, `file`) VALUES (2, 'English', 'lng/english.lng.php');");
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`id`, `language`, `file`) VALUES (3, 'Francais', 'lng/french.lng.php');");
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`id`, `language`, `file`) VALUES (4, 'Chinese', 'lng/zh-cn.lng.php');");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.2-cvs2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.2-cvs2';
}

if($settings['panel']['version'] == '1.2.2-cvs2')
{
	if($settings['panel']['standardlanguage'] == 'german')
	{
		$standardlanguage_new = 'Deutsch';
	}
	elseif($settings['panel']['standardlanguage'] == 'french')
	{
		$standardlanguage_new = 'Francais';
	}
	else
	{
		$standardlanguage_new = 'English';
	}

	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='" . $db->escape($standardlanguage_new) . "' WHERE `settinggroup`='panel' AND `varname`='standardlanguage'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.2-cvs3' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.2-cvs3';
}

if($settings['panel']['version'] == '1.2.2-cvs3')
{
	$db->query("
			CREATE TABLE `" . TABLE_PANEL_CRONSCRIPT . "` (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `file` varchar(255) NOT NULL default '',
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM
		");
	$db->query("INSERT INTO `" . TABLE_PANEL_CRONSCRIPT . "` (`id`, `file`) VALUES (1, 'cron_traffic.php');");
	$db->query("INSERT INTO `" . TABLE_PANEL_CRONSCRIPT . "` (`id`, `file`) VALUES (2, 'cron_tasks.php');");
	$settings['panel']['version'] = '1.2.2-cvs4';
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.2-cvs4' WHERE `settinggroup`='panel' AND `varname`='version'");
}

if($settings['panel']['version'] == '1.2.2-cvs4')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.3' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.3';
}

if($settings['panel']['version'] == '1.2.3')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.3-cvs1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.3-cvs1';
}

if($settings['panel']['version'] == '1.2.3-cvs1')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_DATABASES . '` ADD `description` VARCHAR( 255 ) NOT NULL');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.3-cvs2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.3-cvs2';
}

if($settings['panel']['version'] == '1.2.3-cvs2')
{
	$db->query("ALTER TABLE `" . TABLE_MAIL_USERS . "` ADD `username` VARCHAR( 128 ) NOT NULL");
	$db->query("UPDATE `" . TABLE_MAIL_USERS . "` SET `username`=`email`");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.3-cvs3' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.3-cvs3';
}

if($settings['panel']['version'] == '1.2.3-cvs3')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.3-cvs4' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.3-cvs4';
}

if($settings['panel']['version'] == '1.2.3-cvs4')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_TRAFFIC . "` ADD UNIQUE `date` ( `customerid` , `year` , `month` , `day` )");
	$db->query("
			CREATE TABLE `" . TABLE_PANEL_TRAFFIC_ADMINS . "` (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `adminid` int(11) unsigned NOT NULL default '0',
			  `year` int(4) unsigned zerofill NOT NULL default '0000',
			  `month` int(2) unsigned zerofill NOT NULL default '00',
			  `day` int(2) unsigned zerofill NOT NULL default '00',
			  `http` bigint(30) unsigned NOT NULL default '0',
			  `ftp_up` bigint(30) unsigned NOT NULL default '0',
			  `ftp_down` bigint(30) unsigned NOT NULL default '0',
			  `mail` bigint(30) unsigned NOT NULL default '0',
			  PRIMARY KEY  (`id`),
			  KEY `adminid` (`adminid`),
			  UNIQUE `date` (`adminid` , `year` , `month` , `day`)
			) ENGINE=MyISAM
		");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.3-cvs5' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.3-cvs5';
}

if($settings['panel']['version'] == '1.2.3-cvs5')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.4' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.4';
}

if($settings['panel']['version'] == '1.2.4')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.4-2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.4-2';
}

if($settings['panel']['version'] == '1.2.4-2')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_HTACCESS . '` ADD `error404path` VARCHAR( 255 ) NOT NULL ,
				ADD `error403path` VARCHAR( 255 ) NOT NULL ,
				ADD `error500path` VARCHAR( 255 ) NOT NULL ,
				ADD `error401path` VARCHAR( 255 ) NOT NULL
		');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.4-2cvs1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.4-2cvs1';
}

if($settings['panel']['version'] == '1.2.4-2cvs1')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_CUSTOMERS . '`
				ADD `email_accounts` INT( 15 ) NOT NULL AFTER `emails_used` ,
				ADD `email_accounts_used` INT( 15 ) NOT NULL AFTER `email_accounts`
		');
	$db->query('ALTER TABLE `' . TABLE_PANEL_ADMINS . '`
				ADD `email_accounts` INT( 15 ) NOT NULL AFTER `emails_used` ,
				ADD `email_accounts_used` INT( 15 ) NOT NULL AFTER `email_accounts`
		');
	$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `email_accounts` = `emails` ');
	$db->query('UPDATE `' . TABLE_PANEL_ADMINS . '` SET `email_accounts` = `emails` ');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.4-2cvs2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.4-2cvs2';
}

if($settings['panel']['version'] == '1.2.4-2cvs2')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.5' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.5';
}

if($settings['panel']['version'] == '1.2.5')
{
	$db->query("UPDATE `" . TABLE_FTP_USERS . "` SET `password`=ENCRYPT(`password`)");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.5-cvs1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.5-cvs1';
}

if($settings['panel']['version'] == '1.2.5-cvs1')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.5-cvs2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.5-cvs2';
}

if($settings['panel']['version'] == '1.2.5-cvs2')
{
	$db->query('ALTER TABLE `' . TABLE_MAIL_VIRTUAL . '`
				ADD `email_full` VARCHAR( 50 ) NOT NULL AFTER `email` ,
				ADD `iscatchall` TINYINT( 1 ) UNSIGNED NOT NULL AFTER `popaccountid`
		');
	$db->query('UPDATE `' . TABLE_MAIL_VIRTUAL . '` SET `email_full` = `email`');
	$email_virtual_result = $db->query('SELECT `id`, `email` FROM `' . TABLE_MAIL_VIRTUAL . '`');

	while($email_virtual_row = $db->fetch_array($email_virtual_result))
	{
		if($email_virtual_row['email']
		{
			0
		} == '@')
		{
			$email_full = $settings['email']['catchallkeyword'] . $email_virtual_row['email'];
			$db->query('UPDATE `' . TABLE_MAIL_VIRTUAL . '` SET `email_full` = "' . $db->escape($email_full) . '", `iscatchall` = "1" WHERE `id` = "' . (int)$email_virtual_row['id'] . '"');
		}
	}

	$db->query(' DELETE FROM `' . TABLE_PANEL_SETTINGS . '` WHERE `settinggroup` = "email" AND `varname` = "catchallkeyword" ');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.5-cvs3' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.5-cvs3';
}

if($settings['panel']['version'] == '1.2.5-cvs3')
{
	$db->query('UPDATE `' . TABLE_PANEL_HTACCESS . '` SET `error404path` = "",  `error403path` = "",  `error401path` = "",  `error500path` = "" ');
	inserttask('1');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.5-cvs4' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.5-cvs4';
}

if($settings['panel']['version'] == '1.2.5-cvs4')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.6' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.6';
}

if($settings['panel']['version'] == '1.2.6')
{
	$result = $db->query_first('SELECT `value` FROM `' . TABLE_PANEL_SETTINGS . '` WHERE `settinggroup` = \'panel\' AND `varname` = \'standardlanguage\'');
	$def_language = $result['value'];
	$db->query('ALTER TABLE `' . TABLE_PANEL_ADMINS . '` ADD `def_language` VARCHAR( 255 ) NOT NULL AFTER `email`');
	$db->query('UPDATE `' . TABLE_PANEL_ADMINS . '` SET `def_language` = \'' . $db->escape($def_language) . '\'');
	$db->query('ALTER TABLE `' . TABLE_PANEL_CUSTOMERS . '` ADD `def_language` VARCHAR( 255 ) NOT NULL AFTER `customernumber`');
	$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `def_language` = \'' . $db->escape($def_language) . '\'');
	$db->query('CREATE TABLE `' . TABLE_PANEL_TEMPLATES . '` (
  			`id` int(11) NOT NULL auto_increment,
  			`adminid` int(11) NOT NULL default \'0\',
  			`language` varchar(255) NOT NULL default \'\',
  			`templategroup` varchar(255) NOT NULL default \'\',
  			`varname` varchar(255) NOT NULL default \'\',
  			`value` longtext NOT NULL,
  			PRIMARY KEY  (`id`),
  			KEY `adminid` (`adminid`)
			) ENGINE=MyISAM
		');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.6-cvs1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.6-cvs1';
}

if($settings['panel']['version'] == '1.2.6-cvs1')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.6-cvs2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.6-cvs2';
}

if($settings['panel']['version'] == '1.2.6-cvs2')
{
	if($sql['host'] == 'localhost')
	{
		$mysql_access_host = 'localhost';
	}
	else
	{
		$mysql_access_host = $serverip;
	}

	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`,`varname`,`value`) VALUES ('system','mysql_access_host','" . $db->escape($mysql_access_host) . "')");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.6-cvs3' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.6-cvs3';
}

if($settings['panel']['version'] == '1.2.6-cvs3')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `surname` `firstname` VARCHAR( 255 ) NOT NULL ");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.6-cvs4' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.6-cvs4';
}

if($settings['panel']['version'] == '1.2.6-cvs4')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.7' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.7';
}

if($settings['panel']['version'] == '1.2.7')
{
	inserttask('1');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.7-cvs1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.7-cvs1';
}

if($settings['panel']['version'] == '1.2.7-cvs1')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `createstdsubdomain` `standardsubdomain` INT( 11 ) NOT NULL ");
	$result = $db->query('SELECT * FROM `' . TABLE_PANEL_CUSTOMERS . '` WHERE `standardsubdomain`=\'1\'');

	while($row = $db->fetch_array($result))
	{
		$db->query("INSERT INTO `" . TABLE_PANEL_DOMAINS . "` " . "(`domain`, `customerid`, `adminid`, `documentroot`, `zonefile`, `isemaildomain`, `openbasedir`, `safemode`, `speciallogfile`, `specialsettings`) " . "VALUES ('" . $db->escape($row['loginname']) . '.' . $db->escape($settings['system']['hostname']) . "', '" . (int)$row['customerid'] . "', '" . (int)$row['adminid'] . "', '" . $db->escape($row['documentroot']) . "', '', '0', '1', '1', '0', '')");
		$domainid = $db->insert_id();
		$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `standardsubdomain`=\'' . (int)$domainid . '\' WHERE `customerid`=\'' . (int)$row['customerid'] . '\'');
	}

	inserttask('1');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.7-cvs2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.7-cvs2';
}

if($settings['panel']['version'] == '1.2.7-cvs2')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `isbinddomain` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `documentroot`");
	$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `subcanemaildomain` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `iswildcarddomain`");
	$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `caneditdomain` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `subcanemaildomain`");
	$db->query('UPDATE `' . TABLE_PANEL_DOMAINS . '` SET `isbinddomain`=\'1\' WHERE `isemaildomain`=\'1\'');
	$standardsubdomainids = Array();
	$result = $db->query('SELECT * FROM `' . TABLE_PANEL_CUSTOMERS . '` WHERE `standardsubdomain`<>\'0\'');

	while($row = $db->fetch_array($result))
	{
		$standardsubdomainids[] = "'" . (int)$row['standardsubdomain'] . "'";
	}

	$standardsubdomainids = implode(',', $standardsubdomainids);

	if($standardsubdomainids != '')
	{
		$db->query('UPDATE `' . TABLE_PANEL_DOMAINS . '` SET `caneditdomain`=\'0\' WHERE `id` IN(' . $standardsubdomainids . ')');
	}

	inserttask('1');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.7-cvs3' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.7-cvs3';
}

if($settings['panel']['version'] == '1.2.7-cvs3')
{
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Catalan', 'lng/catalan.lng.php');");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.7-cvs4' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.7-cvs4';
}

if($settings['panel']['version'] == '1.2.7-cvs4')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.8' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.8';
}

if($settings['panel']['version'] == '1.2.8'
   || $settings['panel']['version'] == '1.2.8-cvs1')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.9' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.9';
}

if($settings['panel']['version'] == '1.2.9')
{
	$db->query("UPDATE `" . TABLE_PANEL_LANGUAGE . "` SET `language`='Fran&ccedil;ais' WHERE `language`='Francais'");
	$db->query("UPDATE `" . TABLE_PANEL_TEMPLATES . "` SET `language`='Fran&ccedil;ais' WHERE `language`='Francais'");
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Espa&ntilde;ol', 'lng/spanish.lng.php');");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.9-cvs1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.9-cvs1';
}

if($settings['panel']['version'] == '1.2.9-cvs1')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.10' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.10';
}

if($settings['panel']['version'] == '1.2.10')
{
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Portugu&ecirc;s', 'lng/portugues.lng.php');");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.10-cvs1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.10-cvs1';
}

if($settings['panel']['version'] == '1.2.10-cvs1')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.11' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.11';
}

if($settings['panel']['version'] == '1.2.11')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `aliasdomain` INT( 11 ) UNSIGNED NULL AFTER `customerid`");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.11-cvs1' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.11-cvs1';
}

if($settings['panel']['version'] == '1.2.11-cvs1')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settingid` = \'\' , `settinggroup`  = \'panel\', `varname`       = \'pathedit\', `value`         = \'Manual\'');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.11-cvs2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.11-cvs2';
}

if($settings['panel']['version'] == '1.2.11-cvs2')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.11-cvs3' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.11-cvs3';
}

if($settings['panel']['version'] == '1.2.11-cvs3')
{
	$db->query('ALTER TABLE `' . TABLE_MAIL_USERS . '` CHANGE  `email`    `email`    VARCHAR( 255 ) NOT NULL , CHANGE  `username` `username` VARCHAR( 255 ) NOT NULL , CHANGE  `homedir`  `homedir`  VARCHAR( 255 ) NOT NULL , CHANGE  `maildir`  `maildir`  VARCHAR( 255 ) NOT NULL ');
	$db->query('ALTER TABLE `' . TABLE_MAIL_VIRTUAL . '` CHANGE  `email`      `email`      VARCHAR( 255 ) NOT NULL , CHANGE  `email_full` `email_full` VARCHAR( 255 ) NOT NULL ');
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.11-cvs4' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.11-cvs4';
}

if($settings['panel']['version'] == '1.2.11-cvs4')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.2.12' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.2.12';
}

if($settings['panel']['version'] == '1.2.12')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\',  `varname`      = \'apacheconf_filename\',  `value`        = \'vhosts.conf\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\',  `varname`      = \'lastcronrun\',  `value`        = \'\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'panel\',  `varname`      = \'paging\',  `value`        = \'20\' ');
	$db->query('UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `value` = \'1.2.12-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'');
	$settings['panel']['version'] = '1.2.12-svn1';
}

if($settings['panel']['version'] == '1.2.12-svn1')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_DOMAINS . '` ADD `ipandport` int(11) unsigned NOT NULL default \'1\' AFTER `documentroot`');
	$db->query('CREATE TABLE `' . TABLE_PANEL_IPSANDPORTS . '` (
			`id` int(11) unsigned NOT NULL auto_increment,
			`ip` varchar(15) NOT NULL default \'\',
			`port` int(5) NOT NULL default \'80\',
			`default` int(1) NOT NULL default \'0\',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM');
	$db->query('INSERT INTO `' . TABLE_PANEL_IPSANDPORTS . '` (`ip`, `port`, `default`) VALUES (\'' . $settings['system']['ipaddress'] . '\', \'80\', \'1\')');
	$db->query('UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `value` = \'1.2.12-svn2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'');
	$settings['panel']['version'] = '1.2.12-svn2';
}

if($settings['panel']['version'] == '1.2.12-svn2')
{
	$db->query('UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `value` = \'1.2.13-rc1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'');
	$settings['panel']['version'] = '1.2.13-rc1';
}

if($settings['panel']['version'] == '1.2.13-rc1')
{
	$db->query('UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `value` = \'1.2.13-rc2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'');
	$settings['panel']['version'] = '1.2.13-rc2';
}

if($settings['panel']['version'] == '1.2.13-rc2')
{
	$db->query('UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `value` = \'1.2.13-rc3\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'');
	$settings['panel']['version'] = '1.2.13-rc3';
}

if($settings['panel']['version'] == '1.2.13-rc3')
{
	// update lastcronrun to current date

	$query = 'UPDATE `%s` SET `value` = UNIX_TIMESTAMP() WHERE `settinggroup` = \'system\' AND `varname` = \'lastcronrun\' ';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.13-rc4\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.13-rc4';
}

if($settings['panel']['version'] == '1.2.13-rc4')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.13\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.13';
}

if($settings['panel']['version'] == '1.2.13')
{
	//get highest accountnumber

	$query = 'SELECT `loginname`	 FROM `' . TABLE_PANEL_CUSTOMERS . '` WHERE `loginname` LIKE \'' . $db->escape($settings['customer']['accountprefix']) . '%\';';
	$result = $db->query($query);
	$lastaccountnumber = 0;

	while($row = $db->fetch_array($result))
	{
		$tmpnumber = intval(substr($row['loginname'], strlen($settings['customer']['accountprefix'])));

		if($tmpnumber > $lastaccountnumber)
		{
			$lastaccountnumber = $tmpnumber;
		}
	}

	//update the lastaccountnumber to refer to the highest account availible + 1

	$query = 'UPDATE `%s` SET `value` = \'' . (int)$lastaccountnumber . '\' WHERE `settinggroup` = \'system\' AND `varname` = \'lastaccountnumber\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['system']['lastaccountnumber'] = $lastaccountnumber;

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.13-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.13-svn1';
}

if($settings['panel']['version'] == '1.2.13-svn1')
{
	$query = 'ALTER TABLE `%s` ADD `openbasedir_path` TINYINT( 1 ) UNSIGNED NOT NULL AFTER `openbasedir` ';
	$query = sprintf($query, TABLE_PANEL_DOMAINS);
	$db->query($query);

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.13-svn2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.13-svn2';
}

if($settings['panel']['version'] == '1.2.13-svn2')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.13-svn3\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.13-svn3';
}

if($settings['panel']['version'] == '1.2.13-svn3')
{
	$result = $db->query_first('SELECT `id` FROM `' . TABLE_PANEL_IPSANDPORTS . '` WHERE `default` = \'1\' ');
	$defaultip = $result['id'];
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\',  `varname`      = \'defaultip\',  `value`        = \'' . (int)$defaultip . '\' ');
	$db->query('ALTER TABLE `' . TABLE_PANEL_IPSANDPORTS . '` DROP `default` ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.13-svn4\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.13-svn4';
}

if($settings['panel']['version'] == '1.2.13-svn4')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_SESSIONS . '`  ADD `lastpaging` VARCHAR( 255 ) NOT NULL AFTER `lastactivity` ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.13-svn5\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.13-svn5';
}

if($settings['panel']['version'] == '1.2.13-svn5')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-rc1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-rc1';
}

if($settings['panel']['version'] == '1.2.14-rc1')
{
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Russian', 'lng/russian.lng.php');");

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-rc1-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-rc1-svn1';
}

if($settings['panel']['version'] == '1.2.14-rc1-svn1')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-rc2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-rc2';
}

if($settings['panel']['version'] == '1.2.14-rc2')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-rc3\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-rc3';
}

if($settings['panel']['version'] == '1.2.14-rc3')
{
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Danish', 'lng/danish.lng.php');");

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-rc3-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-rc3-svn1';
}

if($settings['panel']['version'] == '1.2.14-rc3-svn1')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` CHANGE `diskspace` `diskspace` BIGINT( 30 ) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` CHANGE `diskspace_used` `diskspace_used` BIGINT( 30 ) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` CHANGE `traffic` `traffic` BIGINT( 30 ) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` CHANGE `traffic_used` `traffic_used` BIGINT( 30 ) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `diskspace` `diskspace` BIGINT( 30 ) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `diskspace_used` `diskspace_used` BIGINT( 30 ) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `traffic` `traffic` BIGINT( 30 ) NOT NULL DEFAULT '0';");
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` CHANGE `traffic_used` `traffic_used` BIGINT( 30 ) NOT NULL DEFAULT '0';");
	$query = 'SELECT * FROM `' . TABLE_PANEL_LANGUAGE . '` WHERE `language` = \'Russian\';';
	$result = $db->query($query);

	if($db->num_rows($result) == 0)
	{
		$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Russian', 'lng/russian.lng.php');");
	}

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-rc3-svn2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-rc3-svn2';
}

if($settings['panel']['version'] == '1.2.14-rc3-svn2')
{
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Italian', 'lng/italian.lng.php');");

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-rc3-svn3\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-rc3-svn3';
}

if($settings['panel']['version'] == '1.2.14-rc3-svn3')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-rc4\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-rc4';
}

if($settings['panel']['version'] == '1.2.14-rc4')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14';
}

if($settings['panel']['version'] == '1.2.14')
{
	// insert apacheversion (guess)

	if(strtoupper(@php_sapi_name()) == "APACHE2HANDLER")
	{
		$apacheversion = 'apache2';
	}
	else
	{
		$apacheversion = 'apache1';
	}

	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\',  `varname`      = \'apacheversion\',  `value`        = \'' . $apacheversion . '\' ');
	$settings['system']['apacheversion'] = $apacheversion;

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-svn1';
}

if($settings['panel']['version'] == '1.2.14-svn1')
{
	$tables = getTables($db);

	if(isset($tables[TABLE_PANEL_CUSTOMERS])
	   && is_array($tables[TABLE_PANEL_CUSTOMERS])
	   && isset($tables[TABLE_PANEL_CUSTOMERS]['loginname']))
	{
		$db->query('ALTER TABLE `' . TABLE_PANEL_CUSTOMERS . '` DROP INDEX  `loginname` ');
	}

	$db->query('ALTER TABLE `' . TABLE_PANEL_ADMINS . '` ADD UNIQUE ( `loginname` )');
	$db->query('ALTER TABLE `' . TABLE_PANEL_CUSTOMERS . '` ADD UNIQUE ( `loginname` )');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-svn2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-svn2';
}

if($settings['panel']['version'] == '1.2.14-svn2')
{
	$db->query('ALTER TABLE `' . TABLE_MAIL_VIRTUAL . '` ADD INDEX (  `email` ) ');
	$db->query('ALTER TABLE `' . TABLE_PANEL_DOMAINS . '` ADD INDEX (  `domain` ) ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-svn3\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-svn3';
}

if($settings['panel']['version'] == '1.2.14-svn3')
{
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Bulgarian', 'lng/bulgarian.lng.php');");

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-svn4\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-svn4';
}

if($settings['panel']['version'] == '1.2.14-svn4')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\',  `varname`      = \'phpappendopenbasedir\',  `value`        = \'/tmp/\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.14-svn5\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.14-svn5';
}

if($settings['panel']['version'] == '1.2.14-svn5')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.15\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.15';
}

if($settings['panel']['version'] == '1.2.15')
{
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Slovak', 'lng/slovak.lng.php');");
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Dutch', 'lng/dutch.lng.php');");
	$db->query("INSERT INTO `" . TABLE_PANEL_LANGUAGE . "` (`language`, `file`) VALUES ('Hungarian', 'lng/hungarian.lng.php');");

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.15-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.15-svn1';
}

if($settings['panel']['version'] == '1.2.15-svn1')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16';
}

if($settings['panel']['version'] == '1.2.16')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'panel\',  `varname`      = \'natsorting\',  `value`        = \'1\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn1';
}

if($settings['panel']['version'] == '1.2.16-svn1')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\',  `varname`      = \'deactivateddocroot\',  `value`        = \'\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn2';
}

if($settings['panel']['version'] == '1.2.16-svn2')
{
	$tables = getTables($db);

	if(isset($tables[TABLE_PANEL_CRONSCRIPT])
	   && is_array($tables[TABLE_PANEL_CRONSCRIPT]))
	{
		$deletecronscriptstable = true;
		$cronscripts_result = $db->query('SELECT * FROM `' . TABLE_PANEL_CRONSCRIPT . '`');

		while($cronscripts_row = $db->fetch_array($cronscripts_result))
		{
			if($cronscripts_row['file'] != 'cron_tasks.php'
			   && $cronscripts_row['file'] != 'cron_traffic.php')
			{
				$deletecronscriptstable = false;
			}
		}

		if($deletecronscriptstable === true)
		{
			$db->query('DROP TABLE IF EXISTS `' . TABLE_PANEL_CRONSCRIPT . '` ');
		}
		else
		{
			$db->query('DELETE FROM `' . TABLE_PANEL_CRONSCRIPT . '` WHERE `file` IN( "cron_tasks.php", "cron_traffic.php" ) ');
		}
	}

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn3\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn3';
}

if($settings['panel']['version'] == '1.2.16-svn3')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn4\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn4';
}

if($settings['panel']['version'] == '1.2.16-svn4')
{
	$tables = getTables($db);
	$db->query('ALTER TABLE `' . TABLE_PANEL_TRAFFIC . '` ADD `stamp` INT( 11 ) unsigned NOT NULL DEFAULT \'0\' AFTER `day` ');

	if(isset($tables[TABLE_PANEL_TRAFFIC])
	   && is_array($tables[TABLE_PANEL_TRAFFIC])
	   && isset($tables[TABLE_PANEL_TRAFFIC]['date']))
	{
		$db->query('ALTER TABLE `' . TABLE_PANEL_TRAFFIC . '` DROP INDEX  `date` ');
	}

	$tables = getTables($db);
	$db->query('ALTER TABLE `' . TABLE_PANEL_TRAFFIC_ADMINS . '` ADD `stamp` INT( 11 ) unsigned NOT NULL DEFAULT \'0\' AFTER `day` ');

	if(isset($tables[TABLE_PANEL_TRAFFIC_ADMINS])
	   && is_array($tables[TABLE_PANEL_TRAFFIC_ADMINS])
	   && isset($tables[TABLE_PANEL_TRAFFIC_ADMINS]['date']))
	{
		$db->query('ALTER TABLE `' . TABLE_PANEL_TRAFFIC_ADMINS . '` DROP INDEX  `date` ');
	}

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn5\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn5';
}

if($settings['panel']['version'] == '1.2.16-svn5')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_CUSTOMERS . '` ADD `reportsent` TINYINT( 4 ) unsigned NOT NULL DEFAULT \'0\' AFTER `loginfail_count` ');
	$db->query('ALTER TABLE `' . TABLE_PANEL_ADMINS . '` ADD `reportsent` TINYINT( 4 ) unsigned NOT NULL DEFAULT \'0\' AFTER `loginfail_count` ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\',  `varname`      = \'last_traffic_report_run\',  `value`        = \'\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn6\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn6';
}

if($settings['panel']['version'] == '1.2.16-svn6')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_IPSANDPORTS . '` ADD `vhostcontainer` TINYINT( 1 ) NOT NULL DEFAULT \'0\', ADD `specialsettings` TEXT NOT NULL ');
	$db->query('UPDATE `' . TABLE_PANEL_IPSANDPORTS . '` SET `vhostcontainer` = \'1\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn7\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn7';
}

if($settings['panel']['version'] == '1.2.16-svn7')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_SESSIONS . "` CHANGE `ipaddress` `ipaddress` VARCHAR( 255 ) NOT NULL");
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\',  `varname`      = \'mailpwcleartext\',  `value`        = \'1\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn8\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn8';
}

if($settings['panel']['version'] == '1.2.16-svn8')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\',  `varname`      = \'last_tasks_run\',  `value`        = \'0\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn9\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn9';
}

if($settings['panel']['version'] == '1.2.16-svn9')
{
	$db->query("ALTER TABLE `" . TABLE_FTP_USERS . "` CHANGE `username` `username` VARCHAR( 255 ) NOT NULL");
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'customer\',  `varname`      = \'ftpatdomain\',  `value`        = \'0\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn10\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn10';
}

if($settings['panel']['version'] == '1.2.16-svn10')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_DOMAINS . '` ADD `bindserial` VARCHAR( 10 ) NOT NULL DEFAULT \'2000010100\'');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'system\', \'nameservers\', \'\')');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'system\', \'mxservers\', \'\')');
	$db->query('DELETE FROM `' . TABLE_PANEL_SETTINGS . '` WHERE `settinggroup`=\'system\' AND `varname`=\'binddefaultzone\'');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn11\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn11';
}

if($settings['panel']['version'] == '1.2.16-svn11')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `phpenabled` TINYINT( 1 ) unsigned NOT NULL DEFAULT '1' AFTER `deactivated`");
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\', `varname` = \'mod_log_sql\', `value` = \'0\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\', `varname` = \'mod_fcgid\', `value` = \'0\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn12\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn12';
}

if($settings['panel']['version'] == '1.2.16-svn12')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'panel\', `varname` = \'sendalternativemail\', `value` = \'0\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn13\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn13';
}

if($settings['panel']['version'] == '1.2.16-svn13')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\', `varname` = \'apacheconf_vhost\', `value` = \'' . makeCorrectFile($settings['system']['apacheconf_directory'] . '/' . $settings['system']['apacheconf_filename']) . '\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\', `varname` = \'apacheconf_diroptions\', `value` = \'' . makeCorrectFile($settings['system']['apacheconf_directory'] . '/diroptions.conf') . '\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\', `varname` = \'apacheconf_htpasswddir\', `value` = \'' . makeCorrectDir($settings['system']['apacheconf_directory'] . '/htpasswd/') . '\' ');
	$db->query('DELETE FROM `' . TABLE_PANEL_SETTINGS . '` WHERE `settinggroup` = \'system\' AND `varname` = \'apacheconf_directory\' ');
	$db->query('DELETE FROM `' . TABLE_PANEL_SETTINGS . '` WHERE `settinggroup` = \'system\' AND `varname` = \'apacheconf_filename\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn14\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn14';
}

if($settings['panel']['version'] == '1.2.16-svn14')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_SESSIONS . '`  ADD `formtoken` CHAR( 32 ) NOT NULL AFTER `lastpaging` ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.16-svn15\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.16-svn15';
}

if($settings['panel']['version'] == '1.2.16-svn15')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.17\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.17';
}

if($settings['panel']['version'] == '1.2.17')
{
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.18\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.18';
}

if($settings['panel']['version'] == '1.2.18')
{
	$db->query('ALTER TABLE `' . TABLE_PANEL_IPSANDPORTS . '` ADD `listen_statement` TINYINT( 1 ) NOT NULL DEFAULT \'0\', ADD `namevirtualhost_statement` TINYINT( 1 ) NOT NULL DEFAULT \'0\', ADD `vhostcontainer_servername_statement` TINYINT( 1 ) NOT NULL DEFAULT \'0\' ');
	$db->query('UPDATE `' . TABLE_PANEL_IPSANDPORTS . '` SET `listen_statement` = 0, `namevirtualhost_statement` = 1, `vhostcontainer_servername_statement` = 1 ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.18-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.18-svn1';
}

if($settings['panel']['version'] == '1.2.18-svn1')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\', `varname` = \'webalizer_quiet\', `value` = \'2\' ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.18-svn2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.18-svn2';
}

if($settings['panel']['version'] == '1.2.18-svn2')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'ticket\', `varname` = \'noreply_email\', `value` = \'NO-REPLY@SERVERNAME\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'ticket\', `varname` = \'admin_email\', `value` = \'admin@SERVERNAME\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'ticket\', `varname` = \'worktime_all\', `value` = \'1\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'ticket\', `varname` = \'worktime_begin\', `value` = \'00:00\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'ticket\', `varname` = \'worktime_end\', `value` = \'23:59\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'ticket\', `varname` = \'worktime_sat\', `value` = \'0\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'ticket\', `varname` = \'worktime_sun\', `value` = \'0\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'ticket\', `varname` = \'archiving_days\', `value` = \'5\' ');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'ticket\', `varname` = \'last_archive_run\', `value` = \'0\' ');
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `tickets` INT( 15 ) NOT NULL DEFAULT '0' AFTER `ftps_used`");
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `tickets_used` INT( 15 ) NOT NULL DEFAULT '0' AFTER `tickets`");
	$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `tickets` INT( 15 ) NOT NULL DEFAULT '-1' AFTER `ftps_used`");
	$db->query("ALTER TABLE `" . TABLE_PANEL_ADMINS . "` ADD `tickets_used` INT( 15 ) NOT NULL DEFAULT '0' AFTER `tickets`");
	$db->query("CREATE TABLE `" . TABLE_PANEL_TICKETS . "` (
					`id` int(11) unsigned NOT NULL auto_increment,
					`customerid` int(11) NOT NULL,
					`category` smallint(5) unsigned NOT NULL default '1',
					`priority` enum('1','2','3') NOT NULL default '3',
					`subject` varchar(70) NOT NULL,
					`message` text NOT NULL,
					`dt` int(15) NOT NULL,
					`lastchange` int(15) NOT NULL,
					`ip` varchar(20) NOT NULL,
					`status` enum('0','1','2','3') NOT NULL default '1',
					`lastreplier` enum('0','1') NOT NULL default '0',
					`answerto` int(11) unsigned NOT NULL,
					`by` enum('0','1') NOT NULL default '0',
					`archived` enum('0','1') NOT NULL default '0',
				PRIMARY KEY  (`id`),
				KEY `customerid` (`customerid`)) ENGINE=MyISAM;");
	$db->query("CREATE TABLE `" . TABLE_PANEL_TICKET_CATS . "` (
					`id` smallint(5) unsigned NOT NULL auto_increment,
					`name` varchar(60) NOT NULL,
					PRIMARY KEY  (`id`)) ENGINE=MyISAM;");

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.18-svn3\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.18-svn3';
}

if($settings['panel']['version'] == '1.2.18-svn3')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'ticket\', \'enabled\', \'1\');');
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'ticket\', \'concurrently_open\', \'5\');');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.18-svn4\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.18-svn4';
}

if($settings['panel']['version'] == '1.2.18-svn4')
{
	$db->query('INSERT INTO `' . TABLE_PANEL_SETTINGS . '` (`settinggroup`, `varname`, `value`) VALUES (\'ticket\', \'noreply_name\', \'SysCP Support\')');
	$db->query('DELETE FROM `' . TABLE_PANEL_SETTINGS . '` WHERE `settinggroup` = \'ticket\' AND `varname`=\'admin_email\'');
	$db->query('ALTER TABLE `' . TABLE_PANEL_TICKETS . '` ADD `adminid` INT( 11 ) NOT NULL DEFAULT \'1\' AFTER `customerid` ');
	$db->query('ALTER TABLE `' . TABLE_PANEL_TICKET_CATS . '` ADD `adminid` INT( 11 ) NOT NULL DEFAULT \'1\' AFTER `name` ');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.18-svn5\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.18-svn5';
}

if($settings['panel']['version'] == '1.2.18-svn5')
{
	$db->query('UPDATE `' . TABLE_PANEL_SETTINGS . '` SET `settinggroup` = \'system\' WHERE `settinggroup` = \'ticket\' AND `varname` = \'last_archive_run\'');

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.2.19\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.2.19';
}

?>
