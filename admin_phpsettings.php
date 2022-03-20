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

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\FpmDaemons;
use Froxlor\Api\Commands\PhpSettings;
use Froxlor\Database\Database;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

$id = (int) Request::get('id');

if ($page == 'overview') {

	if ($action == '') {

		try {
			$phpconf_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.phpconfigs.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\PhpSettings::class, $userinfo, ['with_subdomains' => true]))
				->withPagination($phpconf_list_data['phpconf_list']['columns']);
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::view('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $phpconf_list_data['phpconf_list']),
			'actions_links' => (bool)$userinfo['change_serversettings'] ? [[
				'href' => $linker->getLink(['section' => 'phpsettings', 'page' => $page, 'action' => 'add']),
				'label' => $lng['admin']['phpsettings']['addnew']
			]] : []
		]);
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
					'page' => $page
				));
			} else {

				if (file_exists(\Froxlor\Froxlor::getInstallDir() . '/templates/misc/php/default.ini.php')) {
					include \Froxlor\Froxlor::getInstallDir() . '/templates/misc/php/default.ini.php';
					$result = [
						'phpsettings' => $phpini
					];
				} else {
					// use first php-config as fallback
					$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = 1");
					$result = $result_stmt->fetch(PDO::FETCH_ASSOC);
				}

				$fpmconfigs = [];
				$configs = Database::query("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` ORDER BY `description` ASC");
				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					$fpmconfigs[$row['id']] = $row['description'];;
				}

				$phpconfig_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.phpconfig_add.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'phpsettings')),
					'formdata' => $phpconfig_add_data['phpconfig_add']
				]);
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
					'page' => $page
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
					'page' => $page
				));
			} else {

				$fpmconfigs = [];
				$configs = Database::query("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` ORDER BY `description` ASC");
				while ($row = $configs->fetch(PDO::FETCH_ASSOC)) {
					$fpmconfigs[$row['id']] = $row['description'];
				}

				$phpconfig_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.phpconfig_edit.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'phpsettings', 'id' => $id)),
					'formdata' => $phpconfig_edit_data['phpconfig_edit'],
					'editid' => $id
				]);
			}
		} else {
			\Froxlor\UI\Response::standard_error('nopermissionsorinvalidid');
		}
	}
} elseif ($page == 'fpmdaemons') {

	if ($action == '') {

		try {
			$fpmconf_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.fpmconfigs.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\FpmDaemons::class, $userinfo))
				->withPagination($fpmconf_list_data['fpmconf_list']['columns']);
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::view('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $fpmconf_list_data['fpmconf_list']),
			'actions_links' => (bool)$userinfo['change_serversettings'] ? [[
				'href' => $linker->getLink(['section' => 'phpsettings', 'page' => $page, 'action' => 'add']),
				'label' => $lng['admin']['fpmsettings']['addnew']
			]] : []
		]);
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
					'page' => $page
				));
			} else {

				$fpmconfig_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.fpmconfig_add.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'phpsettings', 'page' => 'fpmdaemons')),
					'formdata' => $fpmconfig_add_data['fpmconfig_add']
				]);
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
					'page' => $page
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
					'page' => $page
				));
			} else {

				$fpmconfig_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/phpconfig/formfield.fpmconfig_edit.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'phpsettings', 'page' => 'fpmdaemons', 'id' => $id)),
					'formdata' => $fpmconfig_edit_data['fpmconfig_edit'],
					'editid' => $id
				]);
			}
		} else {
			\Froxlor\UI\Response::standard_error('nopermissionsorinvalidid');
		}
	}
}
