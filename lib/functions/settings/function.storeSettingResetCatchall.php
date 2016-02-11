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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

function storeSettingResetCatchall($fieldname, $fielddata, $newfieldvalue) {

	$returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);

	if ($returnvalue !== false
		&& is_array($fielddata)
		&& isset($fielddata['settinggroup'])
		&& $fielddata['settinggroup'] == 'catchall'
		&& isset($fielddata['varname'])
		&& $fielddata['varname'] == 'catchall_enabled'
		&& $newfieldvalue == '0'
	) {

		$result_stmt = Database::query("
			SELECT `id`, `email`, `email_full`, `iscatchall`  FROM `" . TABLE_MAIL_VIRTUAL . "`
			WHERE `iscatchall` = '1'
		");

		if (Database::num_rows() > 0) {

			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_MAIL_VIRTUAL . "` SET `email` = :email, `iscatchall` = '0' WHERE `id` = :id
			");

			while ($result_row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
				Database::pexecute($upd_stmt, array('email' => $result_row['email_full'], 'id' => $result_row['id']));
			}
		}
	}

	return $returnvalue;
}
