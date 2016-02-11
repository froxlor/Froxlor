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
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 * @since      0.9.29.1
 *
 */

/**
 * updates the setting for the default panel-theme
 * and also the user themes (customers and admins) if
 * the changing of themes is disallowed for them
 *
 * @param string $fieldname
 * @param array $fielddata
 * @param mixed $newfieldvalue
 *
 * @return boolean|array
 */
function storeSettingDefaultTheme($fieldname, $fielddata, $newfieldvalue) {

	// first save the setting itself
	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if ($returnvalue !== false
		&& is_array($fielddata)
		&& isset($fielddata['settinggroup'])
		&& $fielddata['settinggroup'] == 'panel'
		&& isset($fielddata['varname'])
		&& $fielddata['varname'] == 'default_theme'
	) {
		// now, if changing themes is disabled we recursivly set
		// the new theme (customers and admin, depending on settings)
		if (Settings::Get('panel.allow_theme_change_customer') == '0') {
			$upd_stmt = Database::prepare("
				UPDATE `".TABLE_PANEL_CUSTOMERS."` SET `theme` = :theme
			");
			Database::pexecute($upd_stmt, array('theme' => $newfieldvalue));
		}
		if (Settings::Get('panel.allow_theme_change_admin') == '0') {
			$upd_stmt = Database::prepare("
				UPDATE `".TABLE_PANEL_ADMINS."` SET `theme` = :theme
			");
			Database::pexecute($upd_stmt, array('theme' => $newfieldvalue));
		}
	}

	return $returnvalue;
}
