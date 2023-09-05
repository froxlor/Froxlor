<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Api\Commands\Backups;
use Froxlor\Api\Commands\BackupStorages;
use Froxlor\FroxlorLogger;
use Froxlor\UI\Collection;
use Froxlor\UI\HTML;
use Froxlor\UI\Listing;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;
use Froxlor\UI\Response;

$id = (int)Request::any('id');

if (($page == 'backups' || $page == 'overview')) {
	if ($action == '') {
		$log->logAction(FroxlorLogger::ADM_ACTION, LOG_INFO, "viewed admin_backups");

		try {
			$admin_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.backups.php';
			$collection = (new Collection(Backups::class, $userinfo))
				->withPagination($admin_list_data['backups_list']['columns'], $admin_list_data['backups_list']['default_sorting']);
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}

		UI::view('user/table.html.twig', [
			'listing' => Listing::format($collection, $admin_list_data, 'backups_list'),
			'actions_links' => [
				[
					'href' => $linker->getLink(['section' => 'backups', 'page' => $page, 'action' => 'restore']),
					'label' => lng('backup.backups_restore'),
					'icon' => 'fa-solid fa-file-import',
					'class' => 'btn-outline-secondary'
				],
				[
					'href' => $linker->getLink(['section' => 'backups', 'page' => 'storages']),
					'label' => lng('backup.backup_storages'),
					'icon' => 'fa-solid fa-hard-drive',
					'class' => 'btn-outline-secondary',
					'visible' => $userinfo['change_serversettings'] == '1'
				]
			]
		]);
	} elseif ($action == 'delete' && $id != 0) {

	} elseif ($action == 'add') {

	} elseif ($action == 'edit' && $id != 0) {

	} elseif ($action == 'restore') {

	}
} else if ($page == 'storages' && $userinfo['change_serversettings'] == '1') {
	if ($action == '') {
		$log->logAction(FroxlorLogger::ADM_ACTION, LOG_INFO, "list backup storages");

		try {
			$backup_storage_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.backup_storages.php';
			$collection = (new Collection(BackupStorages::class, $userinfo))
				->withPagination($backup_storage_list_data['backup_storages_list']['columns'], $backup_storage_list_data['backup_storages_list']['default_sorting']);
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}

		UI::view('user/table.html.twig', [
			'listing' => Listing::format($collection, $backup_storage_list_data, 'backup_storages_list'),
			'actions_links' => [
				[
					'href' => $linker->getLink(['section' => 'backups', 'page' => 'backups']),
					'label' => lng('backup.backups'),
					'icon' => 'fa-solid fa-reply'
				],
				[
					'href' => $linker->getLink(['section' => 'backups', 'page' => $page, 'action' => 'add']),
					'label' => lng('backup.backup_storage.add')
				]
			]
		]);
	} elseif ($action == 'delete' && $id != 0) {
		try {
			$json_result = BackupStorages::getLocal($userinfo, [
				'id' => $id
			])->get();
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['id'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				BackupStorages::getLocal($userinfo, [
					'id' => $id
				])->delete();
				Response::redirectTo($filename, [
					'page' => $page
				]);
			} else {
				HTML::askYesNo('backup_backup_server_reallydelete', $filename, [
					'id' => $id,
					'page' => $page,
					'action' => $action
				], $result['id']);
			}
		}
	} elseif ($action == 'add') {
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			try {
				BackupStorages::getLocal($userinfo, $_POST)->add();
			} catch (Exception $e) {
				Response::dynamicError($e->getMessage());
			}
			Response::redirectTo($filename, [
				'page' => $page
			]);
		} else {
			$admin_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/backup_storages/formfield.backup_storage_add.php';

			UI::view('user/form.html.twig', [
				'formaction' => $linker->getLink(['section' => 'backups']),
				'formdata' => $admin_add_data['backup_storage_add']
			]);
		}
	} elseif ($action == 'edit' && $id != 0) {
		try {
			$json_result = BackupStorages::getLocal($userinfo, [
				'id' => $id
			])->get();
		} catch (Exception $e) {
			Response::dynamicError($e->getMessage());
		}
		$result = json_decode($json_result, true)['data'];

		if ($result['id'] != '') {
			if (isset($_POST['send']) && $_POST['send'] == 'send') {
				try {
					BackupStorages::getLocal($userinfo, $_POST)->update();
				} catch (Exception $e) {
					Response::dynamicError($e->getMessage());
				}
				Response::redirectTo($filename, [
					'page' => $page
				]);
			} else {
				$backup_storage_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/backup_storages/formfield.backup_storage_edit.php';

				UI::view('user/form.html.twig', [
					'formaction' => $linker->getLink(['section' => 'backups', 'id' => $id]),
					'formdata' => $backup_storage_edit_data['backup_storage_edit'],
					'editid' => $id
				]);
			}
		}
	}
} else {
	Response::dynamicError('403');
}
