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

use Froxlor\UI\Callbacks\Ftp;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'backup_list' => [
		'title' => lng('error.customerhasongoingbackupjob'),
		'icon' => 'fa-solid fa-server',
		'self_overview' => ['section' => 'extras', 'page' => 'backup'],
		'default_sorting' => ['destdir' => 'asc'],
		'columns' => [
			'destdir' => [
				'label' => lng('panel.path'),
				'field' => 'data.destdir',
				'callback' => [Ftp::class, 'pathRelative']
			],
			'backup_web' => [
				'label' => lng('extras.backup_web'),
				'field' => 'data.backup_web',
				'callback' => [Text::class, 'boolean'],
			],
			'backup_mail' => [
				'label' => lng('extras.backup_mail'),
				'field' => 'data.backup_mail',
				'callback' => [Text::class, 'boolean'],
			],
			'backup_dbs' => [
				'label' => lng('extras.backup_dbs'),
				'field' => 'data.backup_dbs',
				'callback' => [Text::class, 'boolean'],
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('backup_list', [
			'destdir',
			'backup_web',
			'backup_mail',
			'backup_dbs'
		]),
		'actions' => [
			'delete' => [
				'icon' => 'fa-solid fa-trash',
				'title' => lng('panel.abort'),
				'class' => 'btn-warning',
				'href' => [
					'section' => 'extras',
					'page' => 'backup',
					'action' => 'abort',
					'id' => ':id'
				],
			]
		]
	]
];
