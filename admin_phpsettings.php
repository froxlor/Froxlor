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
		$result = Database::query("
			SELECT c.*, fd.description as fpmdesc
			FROM `" . TABLE_PANEL_PHPCONFIGS . "` c
			LEFT JOIN `" . TABLE_PANEL_FPMDAEMONS . "` fd ON fd.id = c.fpmsettingid
			ORDER BY c.description ASC
		");
		
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			
			$domainresult = false;
			$query_params = array(
				'id' => $row['id']
			);
			
			$query = "SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `phpsettingid` = :id
					AND `parentdomainid` = '0'";
			
			if ((int) $userinfo['domains_see_all'] == 0) {
				$query .= " AND `adminid` = :adminid";
				$query_params['adminid'] = $userinfo['adminid'];
			}
			
			if ((int) Settings::Get('panel.phpconfigs_hidestdsubdomain') == 1) {
				$ssdids_res = Database::query("
					SELECT DISTINCT `standardsubdomain` FROM `" . TABLE_PANEL_CUSTOMERS . "`
					WHERE `standardsubdomain` > 0 ORDER BY `standardsubdomain` ASC;");
				$ssdids = array();
				while ($ssd = $ssdids_res->fetch(PDO::FETCH_ASSOC)) {
					$ssdids[] = $ssd['standardsubdomain'];
				}
				if (count($ssdids) > 0) {
					$query .= " AND `id` NOT IN (" . implode(', ', $ssdids) . ")";
				}
			}
			
			$domainresult_stmt = Database::prepare($query);
			Database::pexecute($domainresult_stmt, $query_params);
			
			$domains = '';
			if (Database::num_rows() > 0) {
				while ($row2 = $domainresult_stmt->fetch(PDO::FETCH_ASSOC)) {
					$domains .= $row2['domain'] . '<br/>';
				}
			}
			
			// check whether we use that config as froxor-vhost config
			if (Settings::Get('system.mod_fcgid_defaultini_ownvhost') == $row['id'] || Settings::Get('phpfpm.vhost_defaultini') == $row['id']) {
				$domains .= Settings::Get('system.hostname');
			}
			
			if ($domains == '') {
				$domains = $lng['admin']['phpsettings']['notused'];
			}
			
			// check whether this is our default config
			if ((Settings::Get('system.mod_fcgid') == '1' && Settings::Get('system.mod_fcgid_defaultini') == $row['id']) || (Settings::Get('phpfpm.enabled') == '1' && Settings::Get('phpfpm.defaultini') == $row['id'])) {
				$row['description'] = '<b>' . $row['description'] . '</b>';
			}
			
			$count ++;
			eval("\$tablecontent.=\"" . getTemplate("phpconfig/overview_overview") . "\";");
		}
		
		$log->logAction(ADM_ACTION, LOG_INFO, "php.ini setting overview has been viewed by '" . $userinfo['loginname'] . "'");
		eval("echo \"" . getTemplate("phpconfig/overview") . "\";");
	}
	
	if ($action == 'add') {
		
		if ((int) $userinfo['change_serversettings'] == 1) {
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				$description = validate($_POST['description'], 'description');
				$phpsettings = validate(str_replace("\r\n", "\n", $_POST['phpsettings']), 'phpsettings', '/^[^\0]*$/');
				
				if (Settings::Get('system.mod_fcgid') == 1) {
					$binary = makeCorrectFile(validate($_POST['binary'], 'binary'));
					$file_extensions = validate($_POST['file_extensions'], 'file_extensions', '/^[a-zA-Z0-9\s]*$/');
					$mod_fcgid_starter = validate($_POST['mod_fcgid_starter'], 'mod_fcgid_starter', '/^[0-9]*$/', '', array(
						'-1',
						''
					));
					$mod_fcgid_maxrequests = validate($_POST['mod_fcgid_maxrequests'], 'mod_fcgid_maxrequests', '/^[0-9]*$/', '', array(
						'-1',
						''
					));
					$mod_fcgid_umask = validate($_POST['mod_fcgid_umask'], 'mod_fcgid_umask', '/^[0-9]*$/');
					// disable fpm stuff
					$fpm_config_id = 1;
					$fpm_enableslowlog = 0;
					$fpm_reqtermtimeout = 0;
					$fpm_reqslowtimeout = 0;
					$fpm_pass_authorizationheader = 0;
					$override_fpmconfig = 0;
					$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` WHERE `id` = :id");
					$def_fpmconfig = Database::pexecute_first($stmt, array(
						'id' => $fpm_config_id
					));
					$pm = $def_fpmconfig['pm'];
					$max_children = $def_fpmconfig['max_children'];
					$start_servers = $def_fpmconfig['start_servers'];
					$min_spare_servers = $def_fpmconfig['min_spare_servers'];
					$max_spare_servers = $def_fpmconfig['max_spare_servers'];
					$max_requests = $def_fpmconfig['max_requests'];
					$idle_timeout = $def_fpmconfig['idle_timeout'];
					$limit_extensions = $def_fpmconfig['limit_extensions'];

				} elseif (Settings::Get('phpfpm.enabled') == 1) {
					$fpm_config_id = intval($_POST['fpmconfig']);
					$fpm_enableslowlog = isset($_POST['phpfpm_enable_slowlog']) ? (int) $_POST['phpfpm_enable_slowlog'] : 0;
					$fpm_reqtermtimeout = validate($_POST['phpfpm_reqtermtimeout'], 'phpfpm_reqtermtimeout', '/^([0-9]+)(|s|m|h|d)$/');
					$fpm_reqslowtimeout = validate($_POST['phpfpm_reqslowtimeout'], 'phpfpm_reqslowtimeout', '/^([0-9]+)(|s|m|h|d)$/');
					$fpm_pass_authorizationheader = isset($_POST['phpfpm_pass_authorizationheader']) ? (int) $_POST['phpfpm_pass_authorizationheader'] : 0;
					$override_fpmconfig = isset($_POST['override_fpmconfig']) ? (int) $_POST['override_fpmconfig'] : 0;
					$pm = $_POST['pm'];
					$max_children = isset($_POST['max_children']) ? (int) $_POST['max_children'] : 0;
					$start_servers = isset($_POST['start_servers']) ? (int) $_POST['start_servers'] : 0;
					$min_spare_servers = isset($_POST['min_spare_servers']) ? (int) $_POST['min_spare_servers'] : 0;
					$max_spare_servers = isset($_POST['max_spare_servers']) ? (int) $_POST['max_spare_servers'] : 0;
					$max_requests = isset($_POST['max_requests']) ? (int) $_POST['max_requests'] : 0;
					$idle_timeout = isset($_POST['idle_timeout']) ? (int) $_POST['idle_timeout'] : 0;
					$limit_extensions = validate($_POST['limit_extensions'], 'limit_extensions', '/^(\.[a-z]([a-z0-9]+)\ ?)+$/');
					// disable fcgid stuff
					$binary = '/usr/bin/php-cgi';
					$file_extensions = 'php';
					$mod_fcgid_starter = 0;
					$mod_fcgid_maxrequests = 0;
					$mod_fcgid_umask = "022";
				}
				
				if (strlen($description) == 0 || strlen($description) > 50) {
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
						`phpsettings` = :phpsettings,
						`fpmsettingid` = :fpmsettingid,
						`pass_authorizationheader` = :fpmpassauth,
						`override_fpmconfig` = :ofc,
						`pm` = :pm,
						`max_children` = :max_children,
						`start_servers` = :start_servers,
						`min_spare_servers` = :min_spare_servers,
						`max_spare_servers` = :max_spare_servers,
						`max_requests` = :max_requests,
						`idle_timeout` = :idle_timeout,
						`limit_extensions` = :limit_extensions");
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
					'phpsettings' => $phpsettings,
					'fpmsettingid' => $fpm_config_id,
					'fpmpassauth' => $fpm_pass_authorizationheader,
					'ofc' => $override_fpmconfig,
					'pm' => $pm,
					'max_children' => $max_children,
					'start_servers' => $start_servers,
					'min_spare_servers' => $min_spare_servers,
					'max_spare_servers' => $max_spare_servers,
					'max_requests' => $max_requests,
					'idle_timeout' => $idle_timeout,
					'limit_extensions' => $limit_extensions
				);
				Database::pexecute($ins_stmt, $ins_data);
				
				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "php.ini setting with description '" . $description . "' has been created by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				
				$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = 1");
				$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
				
				$fpmconfigs = '';
				$configs = Database::query("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` ORDER BY `description` ASC");
				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					$fpmconfigs .= makeoption($row['description'], $row['id'], 1, true, true);
				}
				
				$pm_select = makeoption('static', 'static', 'static', true, true);
				$pm_select.= makeoption('dynamic', 'dynamic', 'static', true, true);
				$pm_select.= makeoption('ondemand', 'ondemand', 'static', true, true);
				
				$phpconfig_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.phpconfig_add.php';
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
			SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = :id");
		$result = Database::pexecute_first($result_stmt, array(
			'id' => $id
		));
		
		if ((Settings::Get('system.mod_fcgid') == '1' && Settings::Get('system.mod_fcgid_defaultini_ownvhost') == $id) || (Settings::Get('phpfpm.enabled') == '1' && Settings::Get('phpfpm.vhost_defaultini') == $id)) {
			standard_error('cannotdeletehostnamephpconfig');
		}
		
		if ((Settings::Get('system.mod_fcgid') == '1' && Settings::Get('system.mod_fcgid_defaultini') == $id) || (Settings::Get('phpfpm.enabled') == '1' && Settings::Get('phpfpm.defaultini') == $id)) {
			standard_error('cannotdeletedefaultphpconfig');
		}
		
		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1 && $id != 1) // cannot delete the default php.config
		{
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				// set php-config to default for all domains using the
				// config that is to be deleted
				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
					`phpsettingid` = '1' WHERE `phpsettingid` = :id");
				Database::pexecute($upd_stmt, array(
					'id' => $id
				));
				
				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = :id");
				Database::pexecute($del_stmt, array(
					'id' => $id
				));
				
				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "php.ini setting with id #" . (int) $id . " has been deleted by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				ask_yesno('phpsetting_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['description']);
			}
		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}
	
	if ($action == 'edit') {
		
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = :id");
		$result = Database::pexecute_first($result_stmt, array(
			'id' => $id
		));
		
		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1) {
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				$description = validate($_POST['description'], 'description');
				$phpsettings = validate(str_replace("\r\n", "\n", $_POST['phpsettings']), 'phpsettings', '/^[^\0]*$/');
				
				if (Settings::Get('system.mod_fcgid') == 1) {
					$binary = makeCorrectFile(validate($_POST['binary'], 'binary'));
					$file_extensions = validate($_POST['file_extensions'], 'file_extensions', '/^[a-zA-Z0-9\s]*$/');
					$mod_fcgid_starter = validate($_POST['mod_fcgid_starter'], 'mod_fcgid_starter', '/^[0-9]*$/', '', array(
						'-1',
						''
					));
					$mod_fcgid_maxrequests = validate($_POST['mod_fcgid_maxrequests'], 'mod_fcgid_maxrequests', '/^[0-9]*$/', '', array(
						'-1',
						''
					));
					$mod_fcgid_umask = validate($_POST['mod_fcgid_umask'], 'mod_fcgid_umask', '/^[0-9]*$/');
					// disable fpm stuff
					$fpm_config_id = 1;
					$fpm_enableslowlog = 0;
					$fpm_reqtermtimeout = 0;
					$fpm_reqslowtimeout = 0;
					$fpm_pass_authorizationheader = 0;
					$override_fpmconfig = 0;
					$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` WHERE `id` = :id");
					$def_fpmconfig = Database::pexecute_first($stmt, array(
						'id' => $fpm_config_id
					));
					$pm = $def_fpmconfig['pm'];
					$max_children = $def_fpmconfig['max_children'];
					$start_servers = $def_fpmconfig['start_servers'];
					$min_spare_servers = $def_fpmconfig['min_spare_servers'];
					$max_spare_servers = $def_fpmconfig['max_spare_servers'];
					$max_requests = $def_fpmconfig['max_requests'];
					$idle_timeout = $def_fpmconfig['idle_timeout'];
					$limit_extensions = $def_fpmconfig['limit_extensions'];

				} elseif (Settings::Get('phpfpm.enabled') == 1) {
					$fpm_config_id = intval($_POST['fpmconfig']);
					$fpm_enableslowlog = isset($_POST['phpfpm_enable_slowlog']) ? (int) $_POST['phpfpm_enable_slowlog'] : 0;
					$fpm_reqtermtimeout = validate($_POST['phpfpm_reqtermtimeout'], 'phpfpm_reqtermtimeout', '/^([0-9]+)(|s|m|h|d)$/');
					$fpm_reqslowtimeout = validate($_POST['phpfpm_reqslowtimeout'], 'phpfpm_reqslowtimeout', '/^([0-9]+)(|s|m|h|d)$/');
					$fpm_pass_authorizationheader = isset($_POST['phpfpm_pass_authorizationheader']) ? (int) $_POST['phpfpm_pass_authorizationheader'] : 0;
					$override_fpmconfig = isset($_POST['override_fpmconfig']) ? (int) $_POST['override_fpmconfig'] : $result['override_fpmconfig'];
					$pm = $_POST['pm'];
					$max_children = isset($_POST['max_children']) ? (int) $_POST['max_children'] : $result['max_children'];
					$start_servers = isset($_POST['start_servers']) ? (int) $_POST['start_servers'] : $result['start_servers'];
					$min_spare_servers = isset($_POST['min_spare_servers']) ? (int) $_POST['min_spare_servers'] : $result['min_spare_servers'];
					$max_spare_servers = isset($_POST['max_spare_servers']) ? (int) $_POST['max_spare_servers'] : $result['max_spare_servers'];
					$max_requests = isset($_POST['max_requests']) ? (int) $_POST['max_requests'] : $result['max_requests'];
					$idle_timeout = isset($_POST['idle_timeout']) ? (int) $_POST['idle_timeout'] : $result['idle_timeout'];
					$limit_extensions = validate($_POST['limit_extensions'], 'limit_extensions', '/^(\.[a-z]([a-z0-9]+)\ ?)+$/');
					// disable fcgid stuff
					$binary = '/usr/bin/php-cgi';
					$file_extensions = 'php';
					$mod_fcgid_starter = 0;
					$mod_fcgid_maxrequests = 0;
					$mod_fcgid_umask = "022";
				}
				
				if (strlen($description) == 0 || strlen($description) > 50) {
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
						`phpsettings` = :phpsettings,
						`fpmsettingid` = :fpmsettingid,
						`pass_authorizationheader` = :fpmpassauth,
						`override_fpmconfig` = :ofc,
						`pm` = :pm,
						`max_children` = :max_children,
						`start_servers` = :start_servers,
						`min_spare_servers` = :min_spare_servers,
						`max_spare_servers` = :max_spare_servers,
						`max_requests` = :max_requests,
						`idle_timeout` = :idle_timeout,
						`limit_extensions` = :limit_extensions
					WHERE `id` = :id");
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
					'fpmsettingid' => $fpm_config_id,
					'fpmpassauth' => $fpm_pass_authorizationheader,
					'ofc' => $override_fpmconfig,
					'pm' => $pm,
					'max_children' => $max_children,
					'start_servers' => $start_servers,
					'min_spare_servers' => $min_spare_servers,
					'max_spare_servers' => $max_spare_servers,
					'max_requests' => $max_requests,
					'idle_timeout' => $idle_timeout,
					'limit_extensions' => $limit_extensions,
					'id' => $id
				);
				Database::pexecute($upd_stmt, $upd_data);
				
				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "php.ini setting with description '" . $description . "' has been changed by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				$fpmconfigs = '';
				$configs = Database::query("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` ORDER BY `description` ASC");
				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					$fpmconfigs .= makeoption($row['description'], $row['id'], $result['fpmsettingid'], true, true);
				}
				
				$pm_select = makeoption('static', 'static', $result['pm'], true, true);
				$pm_select.= makeoption('dynamic', 'dynamic', $result['pm'], true, true);
				$pm_select.= makeoption('ondemand', 'ondemand', $result['pm'], true, true);

				$phpconfig_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.phpconfig_edit.php';
				$phpconfig_edit_form = htmlform::genHTMLForm($phpconfig_edit_data);

				$title = $phpconfig_edit_data['phpconfig_edit']['title'];
				$image = $phpconfig_edit_data['phpconfig_edit']['image'];
				
				eval("echo \"" . getTemplate("phpconfig/overview_edit") . "\";");
			}
		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}
} elseif ($page == 'fpmdaemons') {
	
	if ($action == '') {
		
		$tablecontent = '';
		$count = 0;
		$result = Database::query("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` ORDER BY `description` ASC");
		
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

			$query_params = array(
				'id' => $row['id']
			);
			
			$query = "SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `fpmsettingid` = :id";
			
			$configresult_stmt = Database::prepare($query);
			Database::pexecute($configresult_stmt, $query_params);
			
			$configs = '';
			if (Database::num_rows() > 0) {
				while ($row2 = $configresult_stmt->fetch(PDO::FETCH_ASSOC)) {
					$configs .= $row2['description'] . '<br/>';
				}
			}
			
			if ($configs == '') {
				$configs = $lng['admin']['phpsettings']['notused'];
			}
			
			$count ++;
			eval("\$tablecontent.=\"" . getTemplate("phpconfig/fpmdaemons_overview") . "\";");
		}
		
		$log->logAction(ADM_ACTION, LOG_INFO, "fpm daemons setting overview has been viewed by '" . $userinfo['loginname'] . "'");
		eval("echo \"" . getTemplate("phpconfig/fpmdaemons") . "\";");
	}
	
	if ($action == 'add') {
		
		if ((int) $userinfo['change_serversettings'] == 1) {
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				$description = validate($_POST['description'], 'description');
				$reload_cmd = validate($_POST['reload_cmd'], 'reload_cmd');
				$config_dir = validate($_POST['config_dir'], 'config_dir');
				$pm = $_POST['pm'];
				$max_children = isset($_POST['max_children']) ? (int) $_POST['max_children'] : 0;
				$start_servers = isset($_POST['start_servers']) ? (int) $_POST['start_servers'] : 0;
				$min_spare_servers = isset($_POST['min_spare_servers']) ? (int) $_POST['min_spare_servers'] : 0;
				$max_spare_servers = isset($_POST['max_spare_servers']) ? (int) $_POST['max_spare_servers'] : 0;
				$max_requests = isset($_POST['max_requests']) ? (int) $_POST['max_requests'] : 0;
				$idle_timeout = isset($_POST['idle_timeout']) ? (int) $_POST['idle_timeout'] : 0;
				$limit_extensions = validate($_POST['limit_extensions'], 'limit_extensions', '/^(\.[a-z]([a-z0-9]+)\ ?)+$/');
				
				if (strlen($description) == 0 || strlen($description) > 50) {
					standard_error('descriptioninvalid');
				}
				
				$ins_stmt = Database::prepare("
					INSERT INTO `" . TABLE_PANEL_FPMDAEMONS . "` SET
					`description` = :desc,
					`reload_cmd` = :reload_cmd,
					`config_dir` = :config_dir,
					`pm` = :pm,
					`max_children` = :max_children,
					`start_servers` = :start_servers,
					`min_spare_servers` = :min_spare_servers,
					`max_spare_servers` = :max_spare_servers,
					`max_requests` = :max_requests,
					`idle_timeout` = :idle_timeout,
					`limit_extensions` = :limit_extensions
				");
				$ins_data = array(
					'desc' => $description,
					'reload_cmd' => $reload_cmd,
					'config_dir' => makeCorrectDir($config_dir),
					'pm' => $pm,
					'max_children' => $max_children,
					'start_servers' => $start_servers,
					'min_spare_servers' => $min_spare_servers,
					'max_spare_servers' => $max_spare_servers,
					'max_requests' => $max_requests,
					'idle_timeout' => $idle_timeout,
					'limit_extensions' => $limit_extensions
				);
				Database::pexecute($ins_stmt, $ins_data);
				
				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "fpm-daemon setting with description '" . $description . "' has been created by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				
				$pm_select = makeoption('static', 'static', 'static', true, true);
				$pm_select.= makeoption('dynamic', 'dynamic', 'static', true, true);
				$pm_select.= makeoption('ondemand', 'ondemand', 'static', true, true);

				$fpmconfig_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.fpmconfig_add.php';
				$fpmconfig_add_form = htmlform::genHTMLForm($fpmconfig_add_data);
				
				$title = $fpmconfig_add_data['fpmconfig_add']['title'];
				$image = $fpmconfig_add_data['fpmconfig_add']['image'];
				
				eval("echo \"" . getTemplate("phpconfig/fpmconfig_add") . "\";");
			}
		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}
	
	if ($action == 'delete') {
		
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` WHERE `id` = :id");
		$result = Database::pexecute_first($result_stmt, array(
			'id' => $id
		));

		if ($id == 1) {
			standard_error('cannotdeletedefaultphpconfig');
		}

		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1 && $id != 1) // cannot delete the default php.config
		{
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				// set default fpm daemon config for all php-config that use this config that is to be deleted
				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_PHPCONFIGS . "` SET
					`fpmsettingid` = '1' WHERE `fpmsettingid` = :id");
				Database::pexecute($upd_stmt, array(
					'id' => $id
				));
				
				$del_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_FPMDAEMONS . "` WHERE `id` = :id");
				Database::pexecute($del_stmt, array(
					'id' => $id
				));
				
				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "fpm-daemon setting with id #" . (int) $id . " has been deleted by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				ask_yesno('fpmsetting_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['description']);
			}
		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}
	
	if ($action == 'edit') {
		
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` WHERE `id` = :id");
		$result = Database::pexecute_first($result_stmt, array(
			'id' => $id
		));
		
		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1) {
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				$description = validate($_POST['description'], 'description');
				$reload_cmd = validate($_POST['reload_cmd'], 'reload_cmd');
				$config_dir = validate($_POST['config_dir'], 'config_dir');
				$pm = $_POST['pm'];
				$max_children = isset($_POST['max_children']) ? (int) $_POST['max_children'] : $result['max_children'];
				$start_servers = isset($_POST['start_servers']) ? (int) $_POST['start_servers'] : $result['start_servers'];
				$min_spare_servers = isset($_POST['min_spare_servers']) ? (int) $_POST['min_spare_servers'] : $result['min_spare_servers'];
				$max_spare_servers = isset($_POST['max_spare_servers']) ? (int) $_POST['max_spare_servers'] : $result['max_spare_servers'];
				$max_requests = isset($_POST['max_requests']) ? (int) $_POST['max_requests'] : $result['max_requests'];
				$idle_timeout = isset($_POST['idle_timeout']) ? (int) $_POST['idle_timeout'] : $result['idle_timeout'];
				$limit_extensions = validate($_POST['limit_extensions'], 'limit_extensions', '/^(\.[a-z]([a-z0-9]+)\ ?)+$/');
				
				if (strlen($description) == 0 || strlen($description) > 50) {
					standard_error('descriptioninvalid');
				}
				
				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_FPMDAEMONS . "` SET
					`description` = :desc,
					`reload_cmd` = :reload_cmd,
					`config_dir` = :config_dir,
					`pm` = :pm,
					`max_children` = :max_children,
					`start_servers` = :start_servers,
					`min_spare_servers` = :min_spare_servers,
					`max_spare_servers` = :max_spare_servers,
					`max_requests` = :max_requests,
					`idle_timeout` = :idle_timeout,
					`limit_extensions` = :limit_extensions
					WHERE `id` = :id
				");
				$upd_data = array(
					'desc' => $description,
					'reload_cmd' => $reload_cmd,
					'config_dir' => makeCorrectDir($config_dir),
					'pm' => $pm,
					'max_children' => $max_children,
					'start_servers' => $start_servers,
					'min_spare_servers' => $min_spare_servers,
					'max_spare_servers' => $max_spare_servers,
					'max_requests' => $max_requests,
					'idle_timeout' => $idle_timeout,
					'limit_extensions' => $limit_extensions,
					'id' => $id
				);
				Database::pexecute($upd_stmt, $upd_data);
				
				inserttask('1');
				$log->logAction(ADM_ACTION, LOG_INFO, "fpm-daemon setting with description '" . $description . "' has been changed by '" . $userinfo['loginname'] . "'");
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				
				$pm_select = makeoption('static', 'static', $result['pm'], true, true);
				$pm_select.= makeoption('dynamic', 'dynamic', $result['pm'], true, true);
				$pm_select.= makeoption('ondemand', 'ondemand', $result['pm'], true, true);

				$fpmconfig_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.fpmconfig_edit.php';
				$fpmconfig_edit_form = htmlform::genHTMLForm($fpmconfig_edit_data);
				
				$title = $fpmconfig_edit_data['fpmconfig_edit']['title'];
				$image = $fpmconfig_edit_data['fpmconfig_edit']['image'];
				
				eval("echo \"" . getTemplate("phpconfig/fpmconfig_edit") . "\";");
			}
		} else {
			standard_error('nopermissionsorinvalidid');
		}
	}
}
