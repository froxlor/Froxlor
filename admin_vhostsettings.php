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
 * @package    Panel
 *
 */

define('AREA', 'admin');
require './lib/init.php';

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {

	if ($action == '') {

		$tablecontent = '';
		$count = 0;
		$result = Database::query("SELECT * FROM `" . TABLE_PANEL_VHOSTCONFIGS . "`");

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$count ++;
			eval("\$tablecontent.=\"" . getTemplate("vhostconfig/overview_overview") . "\";");
		}

		$log->logAction(ADM_ACTION, LOG_INFO, "vhost config setting overview has been viewed by '" . $userinfo['loginname'] . "'");
		eval("echo \"" . getTemplate("vhostconfig/overview") . "\";");
	}

	if ($action == 'add') {

		if ((int)$userinfo['change_serversettings'] == 1) {

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				$description = validate($_POST['description'], 'description');
				$vhostsettings = validate(str_replace("\r\n", "\n", $_POST['vhostsettings']), 'vhostsettings', '/^[^\0]*$/');

				if (strlen($description) == 0
					|| strlen($description) > 50
				) {
					standard_error('descriptioninvalid');
				}

				$ins_stmt = Database::prepare("
					INSERT INTO `" . TABLE_PANEL_VHOSTCONFIGS . "` SET
						`description` = :desc,
						`vhostsettings` = :vhostsettings"
				);
				$ins_data = array(
					'desc' => $description,
					'vhostsettings' => $vhostsettings
				);
				Database::pexecute($ins_stmt, $ins_data);

				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "vhost config setting with description '" . $description . "' has been created by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {

				$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_VHOSTCONFIGS . "` WHERE `id` = 1");
				$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

				$vhostconfig_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/vhostconfig/formfield.vhostconfig_add.php';
				$vhostconfig_add_form = htmlform::genHTMLForm($vhostconfig_add_data);

				$title = $vhostconfig_add_data['vhostconfig_add']['title'];
				$image = $vhostconfig_add_data['vhostconfig_add']['image'];

				eval("echo \"" . getTemplate("vhostconfig/overview_add") . "\";");
			}

		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}

	if ($action == 'delete') {

		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_VHOSTCONFIGS . "` WHERE `id` = :id"
		);
		$result = Database::pexecute_first($result_stmt, array('id' => $id));

		if ($result['id'] != 0
			&& $result['id'] == $id
			&& (int)$userinfo['change_serversettings'] == 1
		) {

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_VHOSTCONFIGS . "` WHERE `id` = :id"
				);
				Database::pexecute($del_stmt, array('id' => $id));

				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "vhost config setting with id #" . (int)$id . " has been deleted by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {
				ask_yesno('vhostsetting_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['description']);
			}
		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}

	if ($action == 'edit') {

		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_VHOSTCONFIGS . "` WHERE `id` = :id"
		);
		$result = Database::pexecute_first($result_stmt, array('id' => $id));

		if ($result['id'] != 0
			&& $result['id'] == $id
			&& (int)$userinfo['change_serversettings'] == 1
		) {

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				$description = validate($_POST['description'], 'description');
				$vhostsettings = validate(str_replace("\r\n", "\n", $_POST['vhostsettings']), 'vhostsettings', '/^[^\0]*$/');

				if (strlen($description) == 0
					|| strlen($description) > 50
				) {
					standard_error('descriptioninvalid');
				}

				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_VHOSTCONFIGS . "` SET
						`description` = :desc,
						`vhostsettings` = :vhostsettings
					WHERE `id` = :id"
				);
				$upd_data = array(
						'desc' => $description,
						'vhostsettings' => $vhostsettings,
						'id' => $id
				);
				Database::pexecute($upd_stmt, $upd_data);

				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "vhost setting with description '" . $description . "' has been changed by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {

				$vhostconfig_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/vhostconfig/formfield.vhostconfig_edit.php';
				$vhostconfig_edit_form = htmlform::genHTMLForm($vhostconfig_edit_data);

				$title = $vhostconfig_edit_data['vhostconfig_edit']['title'];
				$image = $vhostconfig_edit_data['vhostconfig_edit']['image'];

				eval("echo \"" . getTemplate("vhostconfig/overview_edit") . "\";");
			}

		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}
}
