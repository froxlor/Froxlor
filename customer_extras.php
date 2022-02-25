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
			$list = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\DirProtections::class, $userinfo))
				->withPagination($htpasswd_list_data['htpasswd_list']['columns'])
				->getList();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::twigBuffer('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($list, $htpasswd_list_data['htpasswd_list']),
			'actions_links' => [[
				'href' => $linker->getLink(['section' => 'extras', 'page' => 'htpasswds', 'action' => 'add']),
				'label' => $lng['extras']['directoryprotection_add']
			]],
			'entity_info' => $lng['extras']['description']
		]);
		UI::twigOutputBuffer();
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
					'page' => $page,
					's' => $s
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
				'page' => $page,
				's' => $s
			));
		} else {
			$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);

			$htpasswd_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htpasswd_add.php';

			UI::twigBuffer('user/form.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'extras')),
				'formdata' => $htpasswd_add_data['htpasswd_add']
			]);
			UI::twigOutputBuffer();
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
					'page' => $page,
					's' => $s
				));
			} else {
				if (strpos($result['path'], $userinfo['documentroot']) === 0) {
					$result['path'] = str_replace($userinfo['documentroot'], "/", $result['path']);
				}
				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$htpasswd_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htpasswd_edit.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'extras', 'id' => $id)),
					'formdata' => $htpasswd_edit_data['htpasswd_edit']
				]);
				UI::twigOutputBuffer();
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
			$list = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\DirOptions::class, $userinfo))
				->withPagination($htaccess_list_data['htaccess_list']['columns'])
				->getList();
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}

		UI::twigBuffer('user/table.html.twig', [
			'listing' => \Froxlor\UI\Listing::format($list, $htaccess_list_data['htaccess_list']),
			'add_link' => [
				'href' => $linker->getLink(['section' => 'extras', 'page' => 'htaccess', 'action' => 'add']),
				'label' => $lng['extras']['pathoptions_add']
			],
			'entity_info' => $lng['extras']['description']
		]);
		UI::twigOutputBuffer();
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
					'page' => $page,
					's' => $s
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
				'page' => $page,
				's' => $s
			));
		} else {
			$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);
			$cperlenabled = \Froxlor\Customer\Customer::customerHasPerlEnabled($userinfo['customerid']);

			$htaccess_add_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htaccess_add.php';

			UI::twigBuffer('user/form.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'extras')),
				'formdata' => $htaccess_add_data['htaccess_add']
			]);
			UI::twigOutputBuffer();
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
					'page' => $page,
					's' => $s
				));
			} else {
				if (strpos($result['path'], $userinfo['documentroot']) === 0) {
					$result['path'] = str_replace($userinfo['documentroot'], "/", $result['path']);
				}
				$cperlenabled = \Froxlor\Customer\Customer::customerHasPerlEnabled($userinfo['customerid']);

				$result = \Froxlor\PhpHelper::htmlentitiesArray($result);

				$htaccess_edit_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.htaccess_edit.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'extras', 'id' => $id)),
					'formdata' => $htaccess_edit_data['htaccess_edit']
				]);
				UI::twigOutputBuffer();
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
				'action' => '',
				's' => $s
			));
		}
		if ($action == '') {
			$log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "viewed customer_extras::backup");

			// check whether there is a backup-job for this customer
			try {
				$json_result = CustomerBackups::getLocal($userinfo)->listing();
			} catch (Exception $e) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
			$result = json_decode($json_result, true)['data'];
			$existing_backupJob = null;
			if ($result['count'] > 0) {
				$existing_backupJob = array_shift($result['list']);
			}

			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					CustomerBackups::getLocal($userinfo, $_POST)->add();
				} catch (Exception $e) {
					\Froxlor\UI\Response::dynamic_error($e->getMessage());
				}
				\Froxlor\UI\Response::standard_success('backupscheduled');
			} else {

				if (!empty($existing_backupJob)) {
					$action = "abort";
					$row = $existing_backupJob['data'];

					$row['path'] = \Froxlor\FileDir::makeCorrectDir(str_replace($userinfo['documentroot'], "/", $row['destdir']));
					$row['backup_web'] = ($row['backup_web'] == '1') ? $lng['panel']['yes'] : $lng['panel']['no'];
					$row['backup_mail'] = ($row['backup_mail'] == '1') ? $lng['panel']['yes'] : $lng['panel']['no'];
					$row['backup_dbs'] = ($row['backup_dbs'] == '1') ? $lng['panel']['yes'] : $lng['panel']['no'];

					// overwrite backup_form after we took everything from it we needed
					eval("\$backup_form = \"" . \Froxlor\UI\Template::getTemplate("extras/backup_listexisting") . "\";");
				}

				$pathSelect = \Froxlor\FileDir::makePathfield($userinfo['documentroot'], $userinfo['guid'], $userinfo['guid']);
				$backup_data = include_once dirname(__FILE__) . '/lib/formfields/customer/extras/formfield.backup.php';

				UI::twigBuffer('user/form.html.twig', [
					'formaction' => $linker->getLink(array('section' => 'extras')),
					'formdata' => $backup_data['backup']
				]);
				UI::twigOutputBuffer();
			}
		}
	} else {
		\Froxlor\UI\Response::standard_error('backupfunctionnotenabled');
	}
}
