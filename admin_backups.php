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
use Froxlor\FroxlorLogger;
use Froxlor\UI\Collection;
use Froxlor\UI\Listing;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;
use Froxlor\UI\Response;

$id = (int)Request::any('id');

if (($page == 'admins' || $page == 'overview') && $userinfo['change_serversettings'] == '1') {
	if ($action == '') {
		$log->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_backups");

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
					'href' => $linker->getLink(['section' => 'backups', 'page' => $page, 'action' => 'add']),
					'label' => lng('admin.backups_add')
				],
				[
					'href' => $linker->getLink(['section' => 'backups', 'page' => $page, 'action' => 'restore']),
					'label' => lng('admin.backups_restore'),
					'icon' => 'fa-solid fa-file-import',
					'class' => 'btn-outline-secondary'
				]
			]
		]);
	} elseif ($action == 'delete' && $id != 0) {

	} elseif ($action == 'add') {

	} elseif ($action == 'edit' && $id != 0) {

	} elseif ($action == 'restore') {

	}
}
