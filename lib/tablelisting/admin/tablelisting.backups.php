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
	'backups_list' => [
		'title' => lng('admin.backups.backups'),
		'icon' => 'fa-solid fa-file-archive',
		'self_overview' => ['section' => 'admins', 'page' => 'admins'],
		'default_sorting' => ['loginname' => 'asc'],
		'columns' => [
			'id' => [
				'label' => 'ID',
				'field' => 'id',
				'sortable' => true,
			],
			'customerid' => [
				'label' => lng('customerid'),
				'field' => 'customerid',
				'sortable' => true,
			],
			'loginname' => [
				'label' => lng('login.username'),
				'field' => 'loginname',
				'callback' => [Impersonate::class, 'customer'],
				'sortable' => true,
			],
			'adminid' => [
				'label' => lng('adminid'),
				'field' => 'adminid',
				'sortable' => true,
			],
			'adminname' => [
				'label' => lng('admin.admin'),
				'field' => 'adminname',
				'callback' => [Impersonate::class, 'admin'],
				'sortable' => true,
			],
			'size' => [
				'label' => lng('backup.size'),
				'field' => 'size',
				'sortable' => true,
			],
			'created_at' => [
				'label' => lng('backup.created_at'),
				'field' => 'created_at',
				'sortable' => true,
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('admin_list', [
			'id',
			'adminname',
			'loginname',
			'size',
			'created_at',
		]),
		'actions' => [
			'show' => [
				'icon' => 'fa-solid fa-eye',
				'title' => lng('usersettings.custom_notes.title'),
				'modal' => [Text::class, 'customerNoteDetailModal'],
				'visible' => [Customer::class, 'hasNote']
			],
			'edit' => [
				'icon' => 'fa-solid fa-edit',
				'title' => lng('panel.edit'),
				'href' => [
					'section' => 'backups',
					'page' => 'backups',
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
					'page' => 'backups',
					'action' => 'delete',
					'id' => ':id'
				],
				'visible' => [Admin::class, 'isNotMe']
			],
		],
		'format_callback' => [
			[Style::class, 'deactivated'],
			[Style::class, 'diskspaceWarning'],
			[Style::class, 'trafficWarning']
		]
	]
];
