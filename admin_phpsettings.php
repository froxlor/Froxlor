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
		
		try {
			$json_result = PhpSettings::getLocal($userinfo)->listing();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		$tablecontent = '';
		$count = 0;
		if (isset($result['count']) && $result['count'] > 0) {
			foreach ($result['list'] as $row) {
				if (isset($row['is_default']) && $row['is_default'] == true) {
					$row['description'] = "<b>" . $row['description'] . "</b>";
				}
				$domains = "";
				foreach ($row['domains'] as $configdomain) {
					$domains .= $configdomain . "<br>";
				}
				$count++;
				eval("\$tablecontent.=\"" . getTemplate("phpconfig/overview_overview") . "\";");
			}
		}
		
		eval("echo \"" . getTemplate("phpconfig/overview") . "\";");
	}
	
	if ($action == 'add') {
		
		if ((int) $userinfo['change_serversettings'] == 1) {
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					PhpSettings::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
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

		try {
			$json_result = PhpSettings::getLocal($userinfo, array('id' => $id))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		
		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1 && $id != 1) // cannot delete the default php.config
		{
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					PhpSettings::getLocal($userinfo, array('id' => $id))->delete();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
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
		
		try {
			$json_result = PhpSettings::getLocal($userinfo, array('id' => $id))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		
		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1) {
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					PhpSettings::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
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

		try {
			$json_result = FpmDaemons::getLocal($userinfo)->listing();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		
		$tablecontent = '';
		$count = 0;
		if (isset($result['count']) && $result['count'] > 0) {
			foreach ($result['list'] as $row) {
				$configs = "";
				foreach ($row['configs'] as $configused) {
					$configs .= $configused . "<br>";
				}
				$count++;
				eval("\$tablecontent.=\"" . getTemplate("phpconfig/fpmdaemons_overview") . "\";");
			}
		}
		eval("echo \"" . getTemplate("phpconfig/fpmdaemons") . "\";");
	}
	
	if ($action == 'add') {
		
		if ((int) $userinfo['change_serversettings'] == 1) {
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					FpmDaemons::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				
				$pm_select = makeoption('static', 'static', 'static', true, true);
				$pm_select .= makeoption('dynamic', 'dynamic', 'static', true, true);
				$pm_select .= makeoption('ondemand', 'ondemand', 'static', true, true);
				
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
		
		try {
			$json_result = FpmDaemons::getLocal($userinfo, array('id' => $id))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		
		if ($id == 1) {
			standard_error('cannotdeletedefaultphpconfig');
		}
		
		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1 && $id != 1) // cannot delete the default php.config
		{
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					FpmDaemons::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
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
		
		try {
			$json_result = FpmDaemons::getLocal($userinfo, array('id' => $id))->get();
		} catch (Exception $e) {
			dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];
		
		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1) {
			
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					FpmDaemons::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					dynamic_error($e->getMessage());
				}
				redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				
				$pm_select = makeoption('static', 'static', $result['pm'], true, true);
				$pm_select .= makeoption('dynamic', 'dynamic', $result['pm'], true, true);
				$pm_select .= makeoption('ondemand', 'ondemand', $result['pm'], true, true);
				
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
