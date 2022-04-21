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
const AREA = 'customer';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\CustomerBackups as CustomerBackups;
use Froxlor\Api\Commands\DirOptions as DirOptions;
use Froxlor\Api\Commands\DirProtections as DirProtections;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

// redirect if this customer page is hidden via settings
if (Settings::IsInList('panel.customer_hide_options', 'extras')) {
	\Froxlor\UI\Response::redirectTo('customer_index.php');
}

$id = (int) Request::get('id');

if ($page == 'overview' || $page == 'htpasswds') {

	// redirect if this customer sub-page is hidden via settings
	if (Settings::IsInList('panel.customer_hide_options', 'extras.directoryprotection')) {
		\Froxlor\UI\Response::redirectTo('customer_index.php');
	}

	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_extras::htpasswds");
		$fields = array(
			'username' => $lng['login']['username'],
			'path' => $lng['panel']['path']
		);
		try {
			$htpasswd_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/customer/tablelisting.htpasswd.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\DirProtections::class, $userinfo))
				->withPagination($htpasswd_list_data['htpasswd_list']['columns']);
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::view('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $htpasswd_list_data['htpasswd_list']),
			'actions_links' => [[
				'href' => $linker->getLink(['section' => 'extras', 'page' => 'htpasswds', 'action' => 'add']),
				'label' => $lng['extras']['directoryprotection_add']
			]],
			'entity_info' => $lng['extras']['description']
		]);
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = DirProtections::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['username']) && $result['username'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					DirProtections::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page
				));
			} else {
				if (strpos($result['path'], $userinfo['documentroot']) === 0) {
					$result['path'] = str_replace($userinfo['documentroot'], "/", $result['path']);
				}

				\Froxlor\UI\HTML::askYesNo('extras_reallydelete', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), $result['username'] . ' (' . $result['path'] . ')');
			}
		}
	} elseif ($action == 'add') {
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				DirProtections::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		} else {
			$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);

			$htpasswd_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htpasswd_add.php';

			UI::view('user/form.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'extras')),
				'formdata' => $htpasswd_add_data['htpasswd_add']
			]);
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = DirProtections::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['username']) && $result['username'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					DirProtections::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page
				));
			} else {
				if (strpos($result['path'], $userinfo['documentroot']) === 0) {
					$result['path'] = str_replace($userinfo['documentroot'], "/", $result['path']);
				}
				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$htpasswd_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htpasswd_edit.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'extras', 'id' => $id)),
					'formdata' => $htpasswd_edit_data['htpasswd_edit'],
					'editid' => $id
				]);
			}
		}
	}
} elseif ($page == 'htaccess') {

	// redirect if this customer sub-page is hidden via settings
	if (Settings::IsInList('panel.customer_hide_options', 'extras.pathoptions')) {
		\Froxlor\UI\Response::redirectTo('customer_index.php');
	}

	if ($action == '') {
		$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_extras::htaccess");

		$cperlenabled = \Froxlor\Customer\Customer::customerHasPerlEnabled($userinfo['customerid']);

		try {
			$htaccess_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/customer/tablelisting.htaccess.php';
			$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\DirOptions::class, $userinfo))
				->withPagination($htaccess_list_data['htaccess_list']['columns']);
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::view('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($collection, $htaccess_list_data['htaccess_list']),
			'actions_links' => [[
				'href' => $linker->getLink(['section' => 'extras', 'page' => 'htaccess', 'action' => 'add']),
				'label' => $lng['extras']['pathoptions_add']
			]],
			'entity_info' => $lng['extras']['description']
		]);
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = DirOptions::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if (isset($result['customerid']) && $result['customerid'] != '' && $result['customerid'] == $userinfo['customerid']) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					DirOptions::getLocal($userinfo, $_POST)->delete();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page
				));
			} else {
				\Froxlor\UI\HTML::askYesNo('extras_reallydelete_pathoptions', $filename, array(
					'id' => $id,
					'page' => $page,
					'action' => $action
				), str_replace($userinfo['documentroot'], '/', $result['path']));
			}
		}
	} elseif ($action == 'add') {
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				DirOptions::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		} else {
			$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);
			$cperlenabled = \Froxlor\Customer\Customer::customerHasPerlEnabled($userinfo['customerid']);

			$htaccess_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htaccess_add.php';

			UI::view('user/form.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'extras')),
				'formdata' => $htaccess_add_data['htaccess_add']
			]);
		}
	} elseif (($action == 'edit') && ($id != 0)) {
		try {
			$json_result = DirOptions::getLocal($userinfo, array(
				'id' => $id
			))->get();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ((isset($result['customerid'])) && ($result['customerid'] != '') && ($result['customerid'] == $userinfo['customerid'])) {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					DirOptions::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::redirectTo($filename, array(
					'page' => $page
				));
			} else {
				if (strpos($result['path'], $userinfo['documentroot']) === 0) {
					$result['path'] = str_replace($userinfo['documentroot'], "/", $result['path']);
				}
				$cperlenabled = \Froxlor\Customer\Customer::customerHasPerlEnabled($userinfo['customerid']);

				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$htaccess_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htaccess_edit.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'extras', 'id' => $id)),
					'formdata' => $htaccess_edit_data['htaccess_edit'],
					'editid' => $id
				]);
			}
		}
	}
} elseif ($page == 'backup') {

	// redirect if this customer sub-page is hidden via settings
	if (Settings::IsInList('panel.customer_hide_options', 'extras.backup')) {
		\Froxlor\UI\Response::redirectTo('customer_index.php');
	}

	if (Settings::Get('system.backupenabled') == 1) {
		if ($action == 'abort' && isset($_POST['send']) && $_POST['send'] == 'send') {
			$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "customer_extras::backup - aborted scheduled backupjob");
			try {
				CustomerBackups::getLocal($userinfo, $_POST)->delete();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			\Froxlor\UI\Response::standard_success('backupaborted');
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page,
				'action' => ''
			));
		}
		if ($action == '') {
			$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_extras::backup");

			// check whether there is a backup-job for this customer
			try {
				$backup_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/customer/tablelisting.backups.php';
				$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\CustomerBackups::class, $userinfo));
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					CustomerBackups::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::standard_success('backupscheduled');
			} else {
				$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);
				$backup_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.backup.php';

				UI::view('user/form-datatable.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'extras')),
					'formdata' => $backup_data['backup'],
					'tabledata' => \Froxlor\UI\Listing::format($collection, $backup_list_data['backup_list']),
				]);
			}
		}
	} else {
		\Froxlor\UI\Response::standard_error('backupfunctionnotenabled');
	}
}
