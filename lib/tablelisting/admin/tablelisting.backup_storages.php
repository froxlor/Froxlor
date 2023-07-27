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

use Froxlor\UI\Callbacks\Admin;
use Froxlor\UI\Callbacks\Customer;
use Froxlor\UI\Callbacks\Impersonate;
use Froxlor\UI\Callbacks\ProgressBar;
use Froxlor\UI\Callbacks\Style;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'backup_storages_list' => [
		'title' => lng('backup.backup_storages.list'),
		'icon' => 'fa-solid fa-file-archive',
		'self_overview' => ['section' => 'backups', 'page' => 'storages'],
		'default_sorting' => ['description' => 'asc'],
		'columns' => [
			'id' => [
				'label' => 'ID',
				'field' => 'id',
				'sortable' => true,
			],
			'description' => [
				'label' => lng('description'),
				'field' => 'description',
				'sortable' => true,
			],
			'type' => [
				'label' => lng('type'),
				'field' => 'type',
				'sortable' => true,
			],
			'region' => [
				'label' => lng('region'),
				'field' => 'region',
				'sortable' => true,
			],
			'bucket' => [
				'label' => lng('bucket'),
				'field' => 'bucket',
				'sortable' => true,
			],
			'destination_path' => [
				'label' => lng('destination_path'),
				'field' => 'destination_path',
				'sortable' => true,
			],
			'hostname' => [
				'label' => lng('hostname'),
				'field' => 'hostname',
				'sortable' => true,
			],
			'username' => [
				'label' => lng('username'),
				'field' => 'username',
				'sortable' => true,
			],
			'retention' => [
				'label' => lng('retention'),
				'field' => 'retention',
				'sortable' => true,
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('backup_storages_list', [
			'id',
			'description',
			'type',
			'retention',
		]),
		'actions' => [
			'show' => [
				'icon' => 'fa-solid fa-eye',
				'title' => lng('usersettings.custom_notes.title'),
			],
			'edit' => [
				'icon' => 'fa-solid fa-edit',
				'title' => lng('panel.edit'),
				'href' => [
					'section' => 'backups',
					'page' => 'storages',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa-solid fa-trash',
				'title' => lng('panel.delete'),
				'class' => 'btn-danger',
				'href' => [
					'section' => 'backups',
					'page' => 'storages',
					'action' => 'delete',
					'id' => ':id'
				],
			],
		],
	]
];
