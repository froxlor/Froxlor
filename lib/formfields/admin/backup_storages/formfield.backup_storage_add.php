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

use Froxlor\Settings;

return [
	'backup_storage_add' => [
		'title' => lng('backups.backup_storage_add'),
		'image' => 'fa-solid fa-file-archive',
		'self_overview' => ['section' => 'backups', 'page' => 'storages'],
		'sections' => [
			'section_a' => [
				'title' => lng('backup.backup_storage_create'),
				'fields' => [
					'description' => [
						'label' => lng('backup.backup_storage.description'),
						'type' => 'text',
						'maxlength' => 200,
						'mandatory' => true,
					],
					'type' => [
						'label' => lng('backup.backup_storage.type'),
						'type' => 'select',
						'selected' => 'local',
						'select_var' => [
							'local' => lng('backup.backup_storage.type_local'),
							'ftp' => lng('backup.backup_storage.type_ftp'),
							'sftp' => lng('backup.backup_storage.type_sftp'),
							'rsync' => lng('backup.backup_storage.type_rsync'),
							's3' => lng('backup.backup_storage.type_s3'),
						],
						'mandatory' => true,
					],
					'region' => [
						'label' => lng('backup.backup_storage.region'),
						'type' => 'text'
					],
					'bucket' => [
						'label' => lng('backup.backup_storage.bucket'),
						'type' => 'text'
					],
					'destination_path' => [
						'label' => lng('backup.backup_storage.destination_path'),
						'type' => 'text'
					],
					'hostname' => [
						'label' => lng('backup.backup_storage.hostname'),
						'type' => 'text'
					],
					'username' => [
						'label' => lng('backup.backup_storage.username'),
						'type' => 'text'
					],
					'password' => [
						'label' => lng('backup.backup_storage.password'),
						'type' => 'password',
						'autocomplete' => 'off',
					],
					'pgp_public_key' => [
						'label' => lng('backup.backup_storage.pgp_public_key'),
						'type' => 'textarea',
						'value' => Settings::Get('backup.default_pgp_public_key')
					],
					'retention' => [
						'label' => lng('backup.backup_storage.retention'),
						'type' => 'number',
						'min' => 0,
					]
				]
			]
		]
	],
];
