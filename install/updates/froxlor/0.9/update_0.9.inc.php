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

if($settings['panel']['frontend'] == 'froxlor'
&& $settings['panel']['version'] == '0.9-r1')
{
	$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 0.9-r1 to 0.9-r2");

	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('spf', 'use_spf', '0');");
	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('spf', 'spf_entry', '@	IN	TXT	\"v=spf1 a mx -all\"');");

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

	$db->query("UPDATE `panel_settings` SET `varname` = 'froxlor_graphic' WHERE `varname` = 'syscp_graphic'");

	// set new version

	$query = 'UPDATE `%s` SET `value` = \'0.9-r2\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '0.9-r2';
}

if($settings['panel']['frontend'] == 'froxlor'
&& $settings['panel']['version'] == '0.9-r2')
{
	$updatelog->logAction(ADM_ACTION, LOG_WARNING, "Updating from 0.9-r2 to 0.9-r3");
	
	$db->query("INSERT INTO `" . TABLE_PANEL_SETTINGS . "` (`settinggroup`, `varname`, `value`) VALUES ('system', 'debug_cron', '0');");
	$db->query("ALTER TABLE `" . TABLE_MAIL_AUTORESPONDER . "` ADD `date_from` int(15) NOT NULL default '-1' AFTER `enabled`");
	$db->query("ALTER TABLE `" . TABLE_MAIL_AUTORESPONDER . "` ADD `date_until` int(15) NOT NULL default '-1' AFTER `date_from`");
	
	// set new version

	$query = 'UPDATE `%s` SET `value` = \'0.9-r3\' WHERE `settinggroup` = \'panel\' AND `varname` = \'version\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);
	$settings['panel']['version'] = '0.9-r3';	
}

?>

