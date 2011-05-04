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

if($settings['panel']['version'] == '1.4')
{
	$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.4 to 1.4-svn1");

	// Going to fix the stuff the update 1.2.19-svn42 to 1.2.19-svn43 broke

	$result = $db->query("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `documentroot` LIKE 'http%';");

	while($row = $db->fetch_array($result))
	{
		if(preg_match("#(https?)://?(.*)#i", $row['documentroot'], $matches))
		{
			$row['documentroot'] = $matches[1] . "://" . $matches[2];
			$db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `documentroot` = '" . $db->escape($row['documentroot']) . "' WHERE `id` = '" . $row['id'] . "';");
		}
	}

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.4-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.4-svn1';
}

if($settings['panel']['version'] == '1.4-svn1')
{
	$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.4-svn1 to 1.4.1");

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.4.1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.4.1';
}

if($settings['panel']['version'] == '1.4.1')
{
	$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 1.4.1 to 1.4.1-svn1");

	// give at least ONE admin the permission to edit phpsettings, bug #1031

	$cntCanEditPHP = $db->query_first("SELECT COUNT(`caneditphpsettings`) as `cnt` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `caneditphpsettings` = '1'");

	if($cntCanEditPHP['cnt'] <= 0)
	{
		// none of the admins can edit php-settings,
		//so we give those who can edit serversettings the right to edit php-settings

		$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `caneditphpsettings` = '1' WHERE `change_serversettings` = '1'");
	}

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'1.4.1-svn1\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '1.4.1-svn1';
}

if($settings['panel']['version'] == '1.4.1-svn1')
{
	$updateto = '1.4.1-svn2';
	$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from " . $settings['panel']['version'] . " to " . $updateto);

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'' . $updateto . '\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = $updateto;
}

if($settings['panel']['version'] == '1.4.1-svn2')
{
	$updateto = '1.4.1-svn3';
	$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from " . $settings['panel']['version'] . " to " . $updateto);

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'' . $updateto . '\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = $updateto;
}

if($settings['panel']['version'] == '1.4.1-svn3')
{
	$updateto = '1.4.2';
	$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from " . $settings['panel']['version'] . " to " . $updateto);

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'' . $updateto . '\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = $updateto;
}

?>