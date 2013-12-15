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
 * @package    Panel
 *
 */

define('AREA', 'admin');
require './lib/init.php';

if ($page == 'overview') {
	$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_updates");

	/**
	 * this is a dirty hack but syscp 1.4.2.1 does not
	 * have any version/dbversion in the database (don't know why)
	 * so we have to set them both to run a correct upgrade
	 */
	if (!isFroxlor()) {
		if (Settings::Get('panel.version') == null
			|| Settings::Get('panel.version') == ''
		) {
			Settings::Set('panel.version', '1.4.2.1');
		}
		if (Settings::Get('system.dbversion') == null
			|| Settings::Get('system.dbversion') == ''
		) {
			/**
			 * for syscp-stable (1.4.2.1) this value has to be 0
			 * so the required table-fields are added correctly
			 * and the svn-version has its value in the database
			 * -> bug #54
			 */
			$result_stmt = Database::query("
				SELECT `value` FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'dbversion'"
			);
			$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

			if (isset($result['value'])) {
				Settings::Set('system.dbversion', (int)$result['value'], false);
			} else {
				Settings::Set('system.dbversion', 0, false);
			}
		}
	}

	if (hasUpdates($version)) {
		$successful_update = false;
		$message = '';

		if (isset($_POST['send'])
			&& $_POST['send'] == 'send'
		) {
			if ((isset($_POST['update_preconfig'])
				&& isset($_POST['update_changesagreed'])
				&& intval($_POST['update_changesagreed']) != 0)
				|| !isset($_POST['update_preconfig'])
			) {
				eval("echo \"" . getTemplate('update/update_start') . "\";");
	
				include_once './install/updatesql.php';
	
				$redirect_url = 'admin_index.php?s=' . $s;
				eval("echo \"" . getTemplate('update/update_end') . "\";");
	
				updateCounters();
				inserttask('1');
				@chmod('./lib/userdata.inc.php', 0440);
				
				$successful_update = true;
			} else {
				$message = '<br /><strong style="color: red">You have to agree that you have read the update notifications.</strong>';
			}
		}

		if (!$successful_update) {
			$current_version = Settings::Get('panel.version');
			$new_version = $version;

			$ui_text = $lng['update']['update_information']['part_a'];
			$ui_text = str_replace('%curversion', $current_version, $ui_text);
			$ui_text = str_replace('%newversion', $new_version, $ui_text);
			$update_information = $ui_text;

			include_once './install/updates/preconfig.php';
			$preconfig = getPreConfig($current_version);
			if ($preconfig != '') {
				$update_information .= '<br />' . $preconfig . $message;
			}

			$update_information .= $lng['update']['update_information']['part_b'];

			eval("echo \"" . getTemplate('update/index') . "\";");
		}
	} else {
		$success_message = $lng['update']['noupdatesavail'];
		$redirect_url = 'admin_index.php?s=' . $s;
		eval("echo \"" . getTemplate('update/noupdatesavail') . "\";");
	}
}
