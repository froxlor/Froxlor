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
function storeSettingDefaultIp($fieldname, $fielddata, $newfieldvalue) {
	$defaultips_old = Settings::Get('system.defaultip');

	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if ($returnvalue !== false
		&& is_array($fielddata)
		&& isset($fielddata['settinggroup'])
		&& $fielddata['settinggroup'] == 'system'
		&& isset($fielddata['varname'])
		&& $fielddata['varname'] == 'defaultip'
	) {

		$customerstddomains_result_stmt = Database::prepare("
			SELECT `standardsubdomain` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `standardsubdomain` <> '0'
		");
		Database::pexecute($customerstddomains_result_stmt);

		$ids = array();

		while ($customerstddomains_row = $customerstddomains_result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$ids[] = (int)$customerstddomains_row['standardsubdomain'];
		}

		if (count($ids) > 0) {
			$defaultips_new = explode(',', $newfieldvalue);

			// Delete the existing mappings linking to default IPs
			$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_DOMAINTOIP . "`
					WHERE `id_domain` IN (" . implode(', ', $ids) . ")
					AND `id_ipandports` IN (" . $defaultips_old . ", " . $newfieldvalue . ")
			");
			Database::pexecute($del_stmt);

			// Insert the new mappings
			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_DOMAINTOIP . "`
				SET `id_domain` = :domainid, `id_ipandports` = :ipandportid
			");

			foreach ($ids as $id) {
				foreach ($defaultips_new as $defaultip_new) {
					Database::pexecute($ins_stmt, array('domainid' => $id, 'ipandportid' => $defaultip_new));
				}
			}
		}
	}

	return $returnvalue;
}

function storeSettingDefaultSslIp($fieldname, $fielddata, $newfieldvalue) {
	$defaultips_old = Settings::Get('system.defaultsslip');

	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if ($returnvalue !== false
		&& is_array($fielddata)
		&& isset($fielddata['settinggroup'])
		&& $fielddata['settinggroup'] == 'system'
		&& isset($fielddata['varname'])
		&& $fielddata['varname'] == 'defaultsslip'
	) {

		$customerstddomains_result_stmt = Database::prepare("
			SELECT `standardsubdomain` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `standardsubdomain` <> '0'
		");
		Database::pexecute($customerstddomains_result_stmt);

		$ids = array();

		while ($customerstddomains_row = $customerstddomains_result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$ids[] = (int)$customerstddomains_row['standardsubdomain'];
		}

		if (count($ids) > 0) {
			$defaultips_new = explode(',', $newfieldvalue);

			if (!empty($defaultips_old) && !empty($newfieldvalue))
			{
				$in_value = $defaultips_old . ", " . $newfieldvalue;
			} elseif (!empty($defaultips_old) && empty($newfieldvalue))
			{
				$in_value = $defaultips_old;
			} else {
				$in_value = $newfieldvalue;
			}

			// Delete the existing mappings linking to default IPs
			$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_DOMAINTOIP . "`
					WHERE `id_domain` IN (" . implode(', ', $ids) . ")
					AND `id_ipandports` IN (" . $in_value . ")
			");
			Database::pexecute($del_stmt);

			if (count($defaultips_new) > 0) {
				// Insert the new mappings
				$ins_stmt = Database::prepare("
					INSERT INTO `" . TABLE_DOMAINTOIP . "`
					SET `id_domain` = :domainid, `id_ipandports` = :ipandportid
				");

				foreach ($ids as $id) {
					foreach ($defaultips_new as $defaultip_new) {
						Database::pexecute($ins_stmt, array('domainid' => $id, 'ipandportid' => $defaultip_new));
					}
				}
			}
		}
	}

	return $returnvalue;
}
