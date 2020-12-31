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

use Froxlor\Database\Database;
use Froxlor\Api\Commands\PhpSettings as PhpSettings;
use Froxlor\Api\Commands\FpmDaemons as FpmDaemons;

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

if ($page == 'overview') {

	if ($action == '') {

		try {
			$json_result = PhpSettings::getLocal($userinfo, array(
				'with_subdomains' => true
			))->listing();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
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
				$subdomains_count = count($row['subdomains']);
				foreach ($row['domains'] as $configdomain) {
					$domains .= $idna_convert->decode($configdomain) . "<br>";
				}
				$count ++;
				if ($subdomains_count == 0 && empty($domains)) {
					$domains = $lng['admin']['phpsettings']['notused'];
				}
				eval("\$tablecontent.=\"" . \Froxlor\UI\Template::getTemplate("phpconfig/overview_overview") . "\";");
			}
		}

		eval("echo \"" . \Froxlor\UI\Template::getTemplate("phpconfig/overview") . "\";");
	}

	if ($action == 'add') {

		if ((int) $userinfo['change_serversettings'] == 1) {

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					PhpSettings::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				if (file_exists(\Froxlor\Froxlor::getInstallDir() . '/templates/misc/php/default.ini.php')) {
					require_once \Froxlor\Froxlor::getInstallDir() . '/templates/misc/php/default.ini.php';
					$result = [
						'phpsettings' => DEFAULT_PHPINI
					];
				} else {
					// use first php-config as fallback
					$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = 1");
					$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
				}

				$fpmconfigs = '';
				$configs = Database::query("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` ORDER BY `description` ASC");
				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					$fpmconfigs .= \Froxlor\UI\HTML::makeoption($row['description'], $row['id'], 1, true, true);
				}

				$pm_select = \Froxlor\UI\HTML::makeoption('static', 'static', 'dynamic', true, true);
				$pm_select .= \Froxlor\UI\HTML::makeoption('dynamic', 'dynamic', 'dynamic', true, true);
				$pm_select .= \Froxlor\UI\HTML::makeoption('ondemand', 'ondemand', 'dynamic', true, true);

				$phpconfig_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.phpconfig_add.php';
				$phpconfig_add_form = \Froxlor\UI\HtmlForm::genHTMLForm($phpconfig_add_data);

				$title = $phpconfig_add_data['phpconfig_add']['title'];
				$image = $phpconfig_add_data['phpconfig_add']['image'];

				eval("echo \"" . \Froxlor\UI\Template::getTemplate("phpconfig/overview_add") . "\";");
			}
		} else {
			\Froxlor\UI\Response::standard_error('nopermissionsorinvalidid');
		}
	}

	if ($action == 'delete') {

		try {
			$json_result = PhpSettings::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1 && $id != 1) // cannot delete the default php.config
		{

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					PhpSettings::getLocal($userinfo, array(
						'id' => $id
					))->delete();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				\Froxlor\UI\HTML::askYesNo('phpsetting_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['description']);
			}
		} else {
			\Froxlor\UI\Response::standard_error('nopermissionsorinvalidid');
		}
	}

	if ($action == 'edit') {

		try {
			$json_result = PhpSettings::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1) {

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					PhpSettings::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				$fpmconfigs = '';
				$configs = Database::query("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` ORDER BY `description` ASC");
				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					$fpmconfigs .= \Froxlor\UI\HTML::makeoption($row['description'], $row['id'], $result['fpmsettingid'], true, true);
				}

				$pm_select = \Froxlor\UI\HTML::makeoption('static', 'static', $result['pm'], true, true);
				$pm_select .= \Froxlor\UI\HTML::makeoption('dynamic', 'dynamic', $result['pm'], true, true);
				$pm_select .= \Froxlor\UI\HTML::makeoption('ondemand', 'ondemand', $result['pm'], true, true);

				$phpconfig_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.phpconfig_edit.php';
				$phpconfig_edit_form = \Froxlor\UI\HtmlForm::genHTMLForm($phpconfig_edit_data);

				$title = $phpconfig_edit_data['phpconfig_edit']['title'];
				$image = $phpconfig_edit_data['phpconfig_edit']['image'];

				eval("echo \"" . \Froxlor\UI\Template::getTemplate("phpconfig/overview_edit") . "\";");
			}
		} else {
			\Froxlor\UI\Response::standard_error('nopermissionsorinvalidid');
		}
	}
} elseif ($page == 'fpmdaemons') {

	if ($action == '') {

		try {
			$json_result = FpmDaemons::getLocal($userinfo)->listing();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
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
				$count ++;
				eval("\$tablecontent.=\"" . \Froxlor\UI\Template::getTemplate("phpconfig/fpmdaemons_overview") . "\";");
			}
		}
		eval("echo \"" . \Froxlor\UI\Template::getTemplate("phpconfig/fpmdaemons") . "\";");
	}

	if ($action == 'add') {

		if ((int) $userinfo['change_serversettings'] == 1) {

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					FpmDaemons::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				$pm_select = \Froxlor\UI\HTML::makeoption('static', 'static', 'dynamic', true, true);
				$pm_select .= \Froxlor\UI\HTML::makeoption('dynamic', 'dynamic', 'dynamic', true, true);
				$pm_select .= \Froxlor\UI\HTML::makeoption('ondemand', 'ondemand', 'dynamic', true, true);

				$fpmconfig_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.fpmconfig_add.php';
				$fpmconfig_add_form = \Froxlor\UI\HtmlForm::genHTMLForm($fpmconfig_add_data);

				$title = $fpmconfig_add_data['fpmconfig_add']['title'];
				$image = $fpmconfig_add_data['fpmconfig_add']['image'];

				eval("echo \"" . \Froxlor\UI\Template::getTemplate("phpconfig/fpmconfig_add") . "\";");
			}
		} else {
			\Froxlor\UI\Response::standard_error('nopermissionsorinvalidid');
		}
	}

	if ($action == 'delete') {

		try {
			$json_result = FpmDaemons::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($id == 1) {
			\Froxlor\UI\Response::standard_error('cannotdeletedefaultphpconfig');
		}

		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1 && $id != 1) // cannot delete the default php.config
		{
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					FpmDaemons::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {
				\Froxlor\UI\HTML::askYesNo('fpmsetting_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['description']);
			}
		} else {
			\Froxlor\UI\Response::standard_error('nopermissionsorinvalidid');
		}
	}

	if ($action == 'edit') {

		try {
			$json_result = FpmDaemons::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['id'] != 0 && $result['id'] == $id && (int) $userinfo['change_serversettings'] == 1) {

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					FpmDaemons::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page,
					's' => $s
				));
			} else {

				$pm_select = \Froxlor\UI\HTML::makeoption('static', 'static', $result['pm'], true, true);
				$pm_select .= \Froxlor\UI\HTML::makeoption('dynamic', 'dynamic', $result['pm'], true, true);
				$pm_select .= \Froxlor\UI\HTML::makeoption('ondemand', 'ondemand', $result['pm'], true, true);

				$fpmconfig_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.fpmconfig_edit.php';
				$fpmconfig_edit_form = \Froxlor\UI\HtmlForm::genHTMLForm($fpmconfig_edit_data);

				$title = $fpmconfig_edit_data['fpmconfig_edit']['title'];
				$image = $fpmconfig_edit_data['fpmconfig_edit']['image'];

				eval("echo \"" . \Froxlor\UI\Template::getTemplate("phpconfig/fpmconfig_edit") . "\";");
			}
		} else {
			\Froxlor\UI\Response::standard_error('nopermissionsorinvalidid');
		}
	}
}
