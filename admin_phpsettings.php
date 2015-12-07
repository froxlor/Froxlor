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
		$result = Database::query("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "`");

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

			$domainresult = false;
			$query_params = array('id' => $row['id']);

			$query = "SELECT * FROM `".TABLE_PANEL_DOMAINS."`
					WHERE `phpsettingid` = :id
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

			$domainresult_stmt = Database::prepare($query);
			Database::pexecute($domainresult_stmt, $query_params);

			$domains = '';
			if (Database::num_rows() > 0) {
				while ($row2 = $domainresult_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains.= $row2['domain'] . '<br/>';
				}
			}

			// check whether we use that config as froxor-vhost config
			if (Settings::Get('system.mod_fcgid_defaultini_ownvhost') == $row['id']
				|| Settings::Get('phpfpm.vhost_defaultini') == $row['id']
			) {
				$domains .= Settings::Get('system.hostname');
			}

			if ($domains == '') {
				$domains = $lng['admin']['phpsettings']['notused'];
			}

			// check whether this is our default config
			if ((Settings::Get('system.mod_fcgid') == '1'
				&& Settings::Get('system.mod_fcgid_defaultini') == $row['id'])
				|| (Settings::Get('phpfpm.enabled') == '1'
				&& Settings::Get('phpfpm.defaultini') == $row['id'])
			) {
				$row['description'] = '<b>'.$row['description'].'</b>';
			}

			$count ++;
			eval("\$tablecontent.=\"" . getTemplate("phpconfig/overview_overview") . "\";");
		}

		$log->logAction(ADM_ACTION, LOG_INFO, "php.ini setting overview has been viewed by '" . $userinfo['loginname'] . "'");
		eval("echo \"" . getTemplate("phpconfig/overview") . "\";");
	}

	if ($action == 'add') {

		if ((int)$userinfo['change_serversettings'] == 1) {

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				$description = validate($_POST['description'], 'description');
				$phpsettings = validate(str_replace("\r\n", "\n", $_POST['phpsettings']), 'phpsettings', '/^[^\0]*$/');

				if (Settings::Get('system.mod_fcgid') == 1) {
					$binary = makeCorrectFile(validate($_POST['binary'], 'binary'));
					$file_extensions = validate($_POST['file_extensions'], 'file_extensions', '/^[a-zA-Z0-9\s]*$/');
					$mod_fcgid_starter = validate($_POST['mod_fcgid_starter'], 'mod_fcgid_starter', '/^[0-9]*$/', '', array('-1', ''));
					$mod_fcgid_maxrequests = validate($_POST['mod_fcgid_maxrequests'], 'mod_fcgid_maxrequests', '/^[0-9]*$/', '', array('-1', ''));
					$mod_fcgid_umask = validate($_POST['mod_fcgid_umask'], 'mod_fcgid_umask', '/^[0-9]*$/');
					// disable fpm stuff
					$fpm_enableslowlog = 0;
					$fpm_reqtermtimeout = 0;
					$fpm_reqslowtimeout = 0;
				}
				elseif (Settings::Get('phpfpm.enabled') == 1) {
					$fpm_enableslowlog = isset($_POST['phpfpm_enable_slowlog']) ? (int)$_POST['phpfpm_enable_slowlog'] : 0;
					$fpm_reqtermtimeout = validate($_POST['phpfpm_reqtermtimeout'], 'phpfpm_reqtermtimeout', '/^([0-9]+)(|s|m|h|d)$/');
					$fpm_reqslowtimeout = validate($_POST['phpfpm_reqslowtimeout'], 'phpfpm_reqslowtimeout', '/^([0-9]+)(|s|m|h|d)$/');
					// disable fcgid stuff
					$binary = '/usr/bin/php-cgi';
					$file_extensions = 'php';
					$mod_fcgid_starter = 0;
					$mod_fcgid_maxrequests = 0;
					$mod_fcgid_umask = "022";
				}

				if (strlen($description) == 0
					|| strlen($description) > 50
				) {
					standard_error('descriptioninvalid');
				}

				$ins_stmt = Database::prepare("
					INSERT INTO `" . TABLE_PANEL_PHPCONFIGS . "` SET
						`description` = :desc,
						`binary` = :binary,
						`file_extensions` = :fext,
						`mod_fcgid_starter` = :starter,
						`mod_fcgid_maxrequests` = :mreq,
						`mod_fcgid_umask` = :umask,
						`fpm_slowlog` = :fpmslow,
						`fpm_reqterm` = :fpmreqterm,
						`fpm_reqslow` = :fpmreqslow,
						`phpsettings` = :phpsettings"
				);
				$ins_data = array(
					'desc' => $description,
					'binary' => $binary,
					'fext' => $file_extensions,
					'starter' => $mod_fcgid_starter,
					'mreq' => $mod_fcgid_maxrequests,
					'umask' => $mod_fcgid_umask,
					'fpmslow' => $fpm_enableslowlog,
					'fpmreqterm' => $fpm_reqtermtimeout,
					'fpmreqslow' => $fpm_reqslowtimeout,
					'phpsettings' => $phpsettings
				);
				Database::pexecute($ins_stmt, $ins_data);

				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "php.ini setting with description '" . $description . "' has been created by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {

				$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = 1");
				$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

				$phpconfig_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/phpconfig/formfield.phpconfig_add.php';
				$phpconfig_add_form = htmlform::genHTMLForm($phpconfig_add_data);

				$title = $phpconfig_add_data['phpconfig_add']['title'];
				$image = $phpconfig_add_data['phpconfig_add']['image'];

				eval("echo \"" . getTemplate("phpconfig/overview_add") . "\";");
			}

		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}

	if ($action == 'delete') {

		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = :id"
		);
		$result = Database::pexecute_first($result_stmt, array('id' => $id));

		if ((Settings::Get('system.mod_fcgid') == '1'
			&& Settings::Get('system.mod_fcgid_defaultini_ownvhost') == $id)
			|| (Settings::Get('phpfpm.enabled') == '1'
			&& Settings::Get('phpfpm.vhost_defaultini') == $id)
		) {
			standard_error('cannotdeletehostnamephpconfig');
		}

		if ((Settings::Get('system.mod_fcgid') == '1'
			&& Settings::Get('system.mod_fcgid_defaultini') == $id)
			|| (Settings::Get('phpfpm.enabled') == '1'
			&& Settings::Get('phpfpm.defaultini') == $id)
		) {
			standard_error('cannotdeletedefaultphpconfig');
		}

		if ($result['id'] != 0
			&& $result['id'] == $id
			&& (int)$userinfo['change_serversettings'] == 1
			&& $id != 1 // cannot delete the default php.config
		) {

			if (isset($_POST['send'])
				&& $_POST['send'] == 'send'
			) {
				// set php-config to default for all domains using the
				// config that is to be deleted
				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
					`phpsettingid` = '1' WHERE `phpsettingid` = :id"
				);
				Database::pexecute($upd_stmt, array('id' => $id));

				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = :id"
				);
				Database::pexecute($del_stmt, array('id' => $id));

				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "php.ini setting with id #" . (int)$id . " has been deleted by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {
				ask_yesno('phpsetting_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['description']);
			}
		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}

	if ($action == 'edit') {

		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = :id"
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
				$phpsettings = validate(str_replace("\r\n", "\n", $_POST['phpsettings']), 'phpsettings', '/^[^\0]*$/');

				if (Settings::Get('system.mod_fcgid') == 1) {
					$binary = makeCorrectFile(validate($_POST['binary'], 'binary'));
					$file_extensions = validate($_POST['file_extensions'], 'file_extensions', '/^[a-zA-Z0-9\s]*$/');
					$mod_fcgid_starter = validate($_POST['mod_fcgid_starter'], 'mod_fcgid_starter', '/^[0-9]*$/', '', array('-1', ''));
					$mod_fcgid_maxrequests = validate($_POST['mod_fcgid_maxrequests'], 'mod_fcgid_maxrequests', '/^[0-9]*$/', '', array('-1', ''));
					$mod_fcgid_umask = validate($_POST['mod_fcgid_umask'], 'mod_fcgid_umask', '/^[0-9]*$/');
					// disable fpm stuff
					$fpm_enableslowlog = 0;
					$fpm_reqtermtimeout = 0;
					$fpm_reqslowtimeout = 0;
				}
				elseif (Settings::Get('phpfpm.enabled') == 1) {
					$fpm_enableslowlog = isset($_POST['phpfpm_enable_slowlog']) ? (int)$_POST['phpfpm_enable_slowlog'] : 0;
					$fpm_reqtermtimeout = validate($_POST['phpfpm_reqtermtimeout'], 'phpfpm_reqtermtimeout', '/^([0-9]+)(|s|m|h|d)$/');
					$fpm_reqslowtimeout = validate($_POST['phpfpm_reqslowtimeout'], 'phpfpm_reqslowtimeout', '/^([0-9]+)(|s|m|h|d)$/');
					// disable fcgid stuff
					$binary = '/usr/bin/php-cgi';
					$file_extensions = 'php';
					$mod_fcgid_starter = 0;
					$mod_fcgid_maxrequests = 0;
					$mod_fcgid_umask = "022";
				}

				if (strlen($description) == 0
					|| strlen($description) > 50
				) {
					standard_error('descriptioninvalid');
				}

				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_PHPCONFIGS . "` SET
						`description` = :desc,
						`binary` = :binary,
						`file_extensions` = :fext,
						`mod_fcgid_starter` = :starter,
						`mod_fcgid_maxrequests` = :mreq,
						`mod_fcgid_umask` = :umask,
						`fpm_slowlog` = :fpmslow,
						`fpm_reqterm` = :fpmreqterm,
						`fpm_reqslow` = :fpmreqslow,
						`phpsettings` = :phpsettings
					WHERE `id` = :id"
				);
				$upd_data = array(
						'desc' => $description,
						'binary' => $binary,
						'fext' => $file_extensions,
						'starter' => $mod_fcgid_starter,
						'mreq' => $mod_fcgid_maxrequests,
						'umask' => $mod_fcgid_umask,
						'fpmslow' => $fpm_enableslowlog,
						'fpmreqterm' => $fpm_reqtermtimeout,
						'fpmreqslow' => $fpm_reqslowtimeout,
						'phpsettings' => $phpsettings,
						'id' => $id
				);
				Database::pexecute($upd_stmt, $upd_data);

				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "php.ini setting with description '" . $description . "' has been changed by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array('page' => $page, 's' => $s));

			} else {

				$phpconfig_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/phpconfig/formfield.phpconfig_edit.php';
				$phpconfig_edit_form = htmlform::genHTMLForm($phpconfig_edit_data);

				$title = $phpconfig_edit_data['phpconfig_edit']['title'];
				$image = $phpconfig_edit_data['phpconfig_edit']['image'];

				eval("echo \"" . getTemplate("phpconfig/overview_edit") . "\";");
			}

		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}
}
