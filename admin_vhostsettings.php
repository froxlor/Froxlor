<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
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
 * @since      0.9.35
 *
 */

define('AREA', 'admin');
require './lib/init.php';

$id = 0;
if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {
	$supported_webservers = [ 'apache2' => 'Apache 2', 'lighttpd' => 'ligHTTPd', 'nginx' => 'Nginx' ];

	if ($action == '') {
		$tablecontent = '';
		$count = 0;
		$result = Database::query("SELECT * FROM `" . TABLE_PANEL_VHOSTCONFIGS . "` ORDER BY description ASC");

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$query_params = array('id' => $row['id']);

			$query = "SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `vhostsettingid` = :id
					AND `parentdomainid` = '0'";

			if ((int)$userinfo['domains_see_all'] == 0) {
				$query .= " AND `adminid` = :adminid";
				$query_params['adminid'] = $userinfo['adminid'];
			}

			if ((int)Settings::Get('panel.phpconfigs_hidestdsubdomain') == 1) {
				$ssdids_res = Database::query("
					SELECT DISTINCT `standardsubdomain` FROM `".TABLE_PANEL_CUSTOMERS."`
					WHERE `standardsubdomain` > 0 ORDER BY `standardsubdomain` ASC;"
				);
				$ssdids = array();
				while ($ssd = $ssdids_res->fetch(PDO::FETCH_ASSOC)) {
					$ssdids[] = $ssd['standardsubdomain'];
				}
				if (count($ssdids) > 0) {
					$query .= " AND `id` NOT IN (".implode(', ', $ssdids).")";
				}
			}

			$query .= " ORDER BY domain ASC";
			$domainresult_stmt = Database::prepare($query);
			Database::pexecute($domainresult_stmt, $query_params);

			$domains = '';
			if (Database::num_rows() > 0) {
				while ($row2 = $domainresult_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains.= $row2['domain'] . '<br/>';
				}
			}

			if ($domains == '') {
				$domains = $lng['admin']['phpsettings']['notused'];
			}

			$webserver = str_replace(array_keys($supported_webservers), array_values($supported_webservers), $row['webserver']);

			$count++;
			eval("\$tablecontent.=\"" . getTemplate("vhostconfig/overview_overview") . "\";");
		}

		eval("echo \"" . getTemplate("vhostconfig/overview") . "\";");

	} else if ($action == 'add') {

		if ((int)$userinfo['change_serversettings'] != 1) {
			standard_error('nopermissionsorinvalidid');
		}

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			$description = validate($_POST['description'], 'description');
			$vhostsettings = validate(trim(str_replace("\r\n", "\n", $_POST['vhostsettings'])), 'vhostsettings', '/^[^\0]*$/');
			$webserver = validate($_POST['webserver'], 'webserver', '/^(' . implode("|", array_keys($supported_webservers)) . ')$/');

			if (strlen($description) == 0 || strlen($description) > 50) {
				standard_error('descriptioninvalid');
			}

			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_VHOSTCONFIGS . "` SET
					`description` = :description,
					`vhostsettings` = :vhostsettings,
					`webserver` = :webserver
			");
			$ins_data = array('description' => $description, 'vhostsettings' => $vhostsettings, 'webserver' => $webserver);
			Database::pexecute($ins_stmt, $ins_data);

			inserttask('1');
			$log->logAction(ADM_ACTION, LOG_INFO, "vhost config setting with description '" . $description . "' has been created by '" . $userinfo['loginname'] . "'");
			redirectTo($filename, array('page' => $page, 's' => $s));

		} else {
			$webserver_options = '';
			while (list($webserver, $webserver_friendlyName) = each($supported_webservers)) {
				$webserver_options .= makeoption($webserver_friendlyName, $webserver, Settings::Get('system.webserver'), true);
			}

			$vhostconfig_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/vhostconfig/formfield.vhostconfig_add.php';
			$vhostconfig_add_form = htmlform::genHTMLForm($vhostconfig_add_data);

			$title = $vhostconfig_add_data['vhostconfig_add']['title'];
			$image = $vhostconfig_add_data['vhostconfig_add']['image'];

			eval("echo \"" . getTemplate("vhostconfig/overview_add") . "\";");
		}
	} else if ($action == 'delete') {

		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_VHOSTCONFIGS . "` WHERE `id` = :id"
		);
		$result = Database::pexecute_first($result_stmt, array('id' => $id));

		if ($result['id'] != 0 && $result['id'] == $id && (int)$userinfo['change_serversettings'] == 1) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				// Remove a reference to this template from all domains using it
				$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
					`vhostsettingid` = 0 WHERE `vhostsettingid` = :id"
				);
				Database::pexecute($upd_stmt, array('id' => $id));

				$del_stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_VHOSTCONFIGS . "` WHERE `id` = :id");
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
	} else if ($action == 'edit') {

		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_VHOSTCONFIGS . "` WHERE `id` = :id"
		);
		$result = Database::pexecute_first($result_stmt, array('id' => $id));

		if ($result['id'] != 0 && $result['id'] == $id && (int)$userinfo['change_serversettings'] == 1) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				$description = validate($_POST['description'], 'description');
				$vhostsettings = validate(trim(str_replace("\r\n", "\n", $_POST['vhostsettings'])), 'vhostsettings', '/^[^\0]*$/');
				$webserver = validate($_POST['webserver'], 'webserver', '/^(' . implode("|", array_keys($supported_webservers)) . ')$/');

				if (strlen($description) == 0 || strlen($description) > 50) {
					standard_error('descriptioninvalid');
				}

				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_VHOSTCONFIGS . "` SET
						`description` = :description,
						`vhostsettings` = :vhostsettings,
						`webserver` = :webserver
					WHERE `id` = :id"
				);
				$upd_data = array('description' => $description, 'vhostsettings' => $vhostsettings, 'webserver' => $webserver, 'id' => $id);
				Database::pexecute($upd_stmt, $upd_data);

				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "vhost setting with description '" . $description . "' has been changed by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {
				$webserver_options = '';
				while (list($webserver, $webserver_friendlyName) = each($supported_webservers)) {
					$webserver_options .= makeoption($webserver_friendlyName, $webserver, $result['webserver'], true);
				}

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
