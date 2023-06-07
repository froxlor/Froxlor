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

return [
	'backup_storage_edit' => [
		'title' => lng('backups.backup_storage_edit'),
		'image' => 'fa-solid fa-file-archive',
		'self_overview' => ['section' => 'backups', 'page' => 'storages'],
		'sections' => [
			'section_a' => [
				'title' => lng('backup.backup_storage_edit'),
				'fields' => [
					'description' => [
						'label' => lng('backup.backup_storage.description'),
						'type' => 'text',
						'value' => $result['description']
					],
					'type' => [
						'label' => lng('backup.backup_storage.type'),
						'type' => 'select',
						'selected' => $result['type'],
						'select_var' => [
							'local' => lng('backup.backup_storage.type_local'),
							'ftp' => lng('backup.backup_storage.type_ftp'),
							'sftp' => lng('backup.backup_storage.type_sftp'),
							'rsync' => lng('backup.backup_storage.type_rsync'),
							's3' => lng('backup.backup_storage.type_s3'),
						]
					],
					'region' => [
						'label' => lng('backup.backup_storage.region'),
						'type' => 'text',
						'value' => $result['region']
					],
					'bucket' => [
						'label' => lng('backup.backup_storage.bucket'),
						'type' => 'text',
						'value' => $result['bucket']
					],
					'destination_path' => [
						'label' => lng('backup.backup_storage.destination_path'),
						'type' => 'text',
						'value' => $result['destination_path']
					],
					'hostname' => [
						'label' => lng('backup.backup_storage.hostname'),
						'type' => 'text',
						'value' => $result['hostname']
					],
					'username' => [
						'label' => lng('backup.backup_storage.username'),
						'type' => 'text',
						'value' => $result['username']
					],
					'password' => [
						'label' => lng('backup.backup_storage.password'),
						'type' => 'password',
						'autocomplete' => 'off'
					],
					'pgp_public_key' => [
						'label' => lng('backup.backup_storage.pgp_public_key'),
						'type' => 'textarea',
						'value' => $result['pgp_public_key']
					],
					'retention' => [
						'label' => lng('backup.backup_storage.retention'),
						'type' => 'number',
						'min' => 0,
						'value' => $result['retention']
					]
				]
			]
		]
	],
];
