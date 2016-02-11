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
 * @package    Functions
 *
 */

/**
 * returns an array of existing php-configurations
 * in our database for the settings-array
 *
 * @return array
 */
function getPhpConfigs() {

	$configs_array = array();

	// check if table exists because this is used in a preconfig
	// where the tables possibly does not exist yet
	$results = Database::query("SHOW TABLES LIKE '".TABLE_PANEL_PHPCONFIGS."'");
	if (!$results) {
		$configs_array[1] = 'Default php.ini';
	} else {
		// get all configs
		$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "`");
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (!isset($configs_array[$row['id']])
					&& !in_array($row['id'], $configs_array)
			) {
				$configs_array[$row['id']] = html_entity_decode($row['description']);
			}
		}
	}
	return $configs_array;
}
