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

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;

if ($page == 'overview') {
	$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_updates");

	/**
	 * this is a dirty hack but syscp 1.4.2.1 does not
	 * have any version/dbversion in the database (don't know why)
	 * so we have to set them both to run a correct upgrade
	 */
	if (!\Froxlor\Froxlor::isFroxlor()) {
		if (Settings::Get('panel.version') == null || Settings::Get('panel.version') == '') {
			Settings::Set('panel.version', '1.4.2.1');
		}
		if (Settings::Get('system.dbversion') == null || Settings::Get('system.dbversion') == '') {
			/**
			 * for syscp-stable (1.4.2.1) this value has to be 0
			 * so the required table-fields are added correctly
			 * and the svn-version has its value in the database
			 * -> bug #54
			 */
			$result_stmt = Database::query("
				SELECT `value` FROM `" . TABLE_PANEL_SETTINGS . "` WHERE `varname` = 'dbversion'");
			$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

			if (isset($result['value'])) {
				Settings::Set('system.dbversion', (int) $result['value'], false);
			} else {
				Settings::Set('system.dbversion', 0, false);
			}
		}
	}

	if (\Froxlor\Froxlor::hasDbUpdates() || \Froxlor\Froxlor::hasUpdates()) {
		$successful_update = false;
		$message = '';

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			if ((isset($_POST['update_preconfig']) && isset($_POST['update_changesagreed']) && intval($_POST['update_changesagreed']) != 0) || !isset($_POST['update_preconfig'])) {

				include_once \Froxlor\Froxlor::getInstallDir() . 'install/updatesql.php';

				\Froxlor\User::updateCounters();
				\Froxlor\System\Cronjob::inserttask(\Froxlor\Cron\TaskId::REBUILD_VHOST);
				@chmod(\Froxlor\Froxlor::getInstallDir() . '/lib/userdata.inc.php', 0400);

				UI::view('install/update.html.twig', [
					'checks' => $update_tasks
				]);
				exit;
			} else {
				$message = '<br><br><strong>You have to agree that you have read the update notifications.</strong>';
			}
		}

		$current_version = Settings::Get('panel.version');
		$current_db_version = Settings::Get('panel.db_version');
		if (empty($current_db_version)) {
			$current_db_version = "0";
		}
		$new_version = \Froxlor\Froxlor::VERSION;
		$new_db_version = \Froxlor\Froxlor::DBVERSION;

		$ui_text = $lng['update']['update_information']['part_a'];
		if (\Froxlor\Froxlor::VERSION != $current_version) {
			$ui_text = str_replace('%curversion', $current_version, $ui_text);
			$ui_text = str_replace('%newversion', $new_version, $ui_text);
		} else {
			// show db version
			$ui_text = str_replace('%curversion', $current_db_version, $ui_text);
			$ui_text = str_replace('%newversion', $new_db_version, $ui_text);
		}
		$ui_text .= $lng['update']['update_information']['part_b'];

		$upd_formfield = [
			'updates' => [
				'title' => $lng['update']['update'],
				'image' => 'fa-solid fa-download',
				'description' => $lng['update']['description'],
				'sections' => [],
				'buttons' => [
					[
						'label' => $lng['update']['proceed']
					]
				]
			]
		];

		include_once \Froxlor\Froxlor::getInstallDir() . '/install/updates/preconfig.php';
		$preconfig = getPreConfig($current_version, $current_db_version);
		if (!empty($preconfig)) {
			$upd_formfield['updates']['sections'] = $preconfig;
		}

		UI::view('user/form-note.html.twig', [
			'formaction' => $linker->getLink(array('section' => 'updates')),
			'formdata' => $upd_formfield['updates'],
			// alert
			'type' => !empty($message) ? 'danger' : 'info',
			'alert_msg' => $ui_text . $message
		]);
	} else {
		\Froxlor\UI\Response::standard_success('noupdatesavail');
	}
}
