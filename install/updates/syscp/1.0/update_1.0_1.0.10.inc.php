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

define('TABLE_POSTFIX_TRANSPORT', 'postfix_transport');
define('TABLE_POSTFIX_USERS', 'postfix_users');
define('TABLE_POSTFIX_VIRTUAL', 'postfix_virtual');
define('TABLE_PROFTPD_GROUPS', 'proftpd_groups');
define('TABLE_PROFTPD_USERS', 'proftpd_users');

if(!isset($settings['panel']['version']))
{
	$settings['panel']['version'] = '1.0.0';
}

if($settings['panel']['version'] == '1.0.0')
{
	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (22, 'panel', 'version', '1.0.1')");
	$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `openbasedir` TINYINT( 1 ) NOT NULL , ADD `safemode` TINYINT( 1 ) NOT NULL");
	$db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `openbasedir`='1', `safemode`='1'");
	$settings['panel']['version'] = '1.0.1';
}

if($settings['panel']['version'] == '1.0.1')
{
	$db->query("ALTER TABLE `" . TABLE_POSTFIX_USERS . "` ADD `domainid` INT( 11 ) NOT NULL AFTER `postfix`");
	$db->query("ALTER TABLE `" . TABLE_POSTFIX_VIRTUAL . "` ADD `domainid` INT( 11 ) NOT NULL AFTER `destination`");
	$result = $db->query("SELECT `id`, `domain` FROM `" . TABLE_PANEL_DOMAINS . "`");

	while($row = $db->fetch_array($result))
	{
		$db->query("UPDATE `" . TABLE_POSTFIX_USERS . "` SET `domainid`='" . (int)$row['id'] . "' WHERE `email` LIKE '%@" . $db->escape($row['domain']) . "'");
		$db->query("UPDATE `" . TABLE_POSTFIX_VIRTUAL . "` SET `domainid`='" . (int)$row['id'] . "' WHERE `email` LIKE '%@" . $db->escape($row['domain']) . "'");
	}

	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `createstdsubdomain` TINYINT( 1 ) NOT NULL AFTER `documentroot`");
	inserttask('1');
	inserttask('4');
	$hostname = explode('@', $settings['panel']['adminmail']);
	$hostname = $hostname[1];
	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settingid`, `settinggroup`, `varname`, `value`) VALUES (23, 'system', 'hostname', '" . $db->escape($hostname) . "')");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.0.2' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.0.2';
}

if($settings['panel']['version'] == '1.0.2')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_SESSIONS . "` ADD `language` VARCHAR( 64 ) NOT NULL AFTER `lastactivity` ;");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.0.3' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.0.3';
}

if($settings['panel']['version'] == '1.0.3')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.0.4' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.0.4';
}

if($settings['panel']['version'] == '1.0.4')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.0.5' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.0.5';
}

if($settings['panel']['version'] == '1.0.5')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_CUSTOMERS . "` ADD `deactivated` TINYINT( 1 ) NOT NULL ;");
	$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `deactivated` TINYINT( 1 ) NOT NULL ;");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.0.6' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.0.6';
}

if($settings['panel']['version'] == '1.0.6')
{
	$db->query("ALTER TABLE `" . TABLE_POSTFIX_VIRTUAL . "` ADD `popaccountid` INT( 11 ) NOT NULL ;");
	$result = $db->query("SELECT `id`, `email` FROM `" . TABLE_POSTFIX_USERS . "`");

	while($row = $db->fetch_array($result))
	{
		$db->query("UPDATE `" . TABLE_POSTFIX_VIRTUAL . "` SET `popaccountid`='" . (int)$row['id'] . "' WHERE `email` = '" . $db->escape(str_replace($settings['email']['catchallkeyword'], '', $row['email'])) . "' AND `destination` = '" . $db->escape($row['email']) . "'");
	}

	$result = $db->query("SELECT `id`, `email`, `destination` FROM `" . TABLE_POSTFIX_VIRTUAL . "` WHERE `popaccountid` = '0'");

	while($row = $db->fetch_array($result))
	{
		if(str_replace($settings['email']['catchallkeyword'], '', $row['email']) != $row['email'])
		{
			$db->query("UPDATE `" . TABLE_POSTFIX_VIRTUAL . "` SET `email` = '" . $db->escape(str_replace($settings['email']['catchallkeyword'], '', $row['email'])) . "' WHERE `id` = '" . (int)$row['id'] . "'");
		}
	}

	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.0.7' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.0.7';
}

if($settings['panel']['version'] == '1.0.7')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.0.8' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.0.8';
}

if($settings['panel']['version'] == '1.0.8')
{
	$db->query("ALTER TABLE `" . TABLE_PANEL_DATABASES . "` DROP `password` ;");
	$db->query("ALTER TABLE `" . TABLE_PANEL_DOMAINS . "` ADD `specialsettings` TEXT NOT NULL AFTER `safemode` ;");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.0.9' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.0.9';
}

if($settings['panel']['version'] == '1.0.9')
{
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value`='1.0.10' WHERE `settinggroup`='panel' AND `varname`='version'");
	$settings['panel']['version'] = '1.0.10';
}

?>