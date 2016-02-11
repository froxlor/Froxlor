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
 * @package    Functions
 *
 */

function storeSettingHostname($fieldname, $fielddata, $newfieldvalue) {

	global $idna_convert;

	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if ($returnvalue !== false
		&& is_array($fielddata)
		&& isset($fielddata['settinggroup'])
		&& $fielddata['settinggroup'] == 'system'
		&& isset($fielddata['varname'])
		&& $fielddata['varname'] == 'hostname'
	) {
		$newfieldvalue = $idna_convert->encode($newfieldvalue);

		$customerstddomains_result_stmt = Database::prepare("
			SELECT `standardsubdomain` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `standardsubdomain` <> '0'
		");
		Database::pexecute($customerstddomains_result_stmt);

		$ids = array();

		while ($customerstddomains_row = $customerstddomains_result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$ids[] = (int)$customerstddomains_row['standardsubdomain'];
		}

		if (count($ids) > 0) {
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
				`domain` = REPLACE(`domain`, :host, :newval)
				WHERE `id` IN ('" . implode(', ', $ids) . "')
			");
			Database::pexecute($upd_stmt, array('host' => Settings::Get('system.hostname'), 'newval' => $newfieldvalue));
		}
	}

	return $returnvalue;
}
