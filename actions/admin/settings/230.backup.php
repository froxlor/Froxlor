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
	'groups' => [
		'backup' => [
			'title' => lng('backup'),
			'icon' => 'fa-solid fa-sliders',
			'advanced_mode' => true,
			'fields' => [
				'system_backup_enabled' => [
					'label' => lng('serversettings.backup_enabled'),
					'settinggroup' => 'system',
					'varname' => 'diskquota_enabled',
					'type' => 'checkbox',
					'default' => false,
					'save_method' => 'storeSettingField',
					'overview_option' => true
				],
				'system_backup_type' => [
					'label' => lng('serversettings.backup_type'),
					'settinggroup' => 'system',
					'varname' => 'backup_type',
					'type' => 'select',
					'default' => 'S3',
					'select_var' => [
						'Local' => lng('serversettings.local'),
						'SFTP' => lng('serversettings.sftp'),
						'FTPS' => lng('serversettings.ftps'),
						'S3' => lng('serversettings.s3'),
					],
					'save_method' => 'storeSettingField',
					'overview_option' => true,
				],
				'system_backup_region' => [
					'label' => lng('serversettings.backup_region'),
					'settinggroup' => 'system',
					'varname' => 'backup_region',
					'type' => 'text',
					'default' => 'eu-central-1',
					'save_method' => 'storeSettingField',
				],
				'system_backup_bucket' => [
					'label' => lng('serversettings.backup_bucket'),
					'settinggroup' => 'system',
					'varname' => 'backup_bucket',
					'type' => 'text',
					'default' => '',
					'save_method' => 'storeSettingField',
				],
				'system_backup_destination_path' => [
					'label' => lng('serversettings.backup_destination_path'),
					'settinggroup' => 'system',
					'varname' => 'backup_destination_path',
					'type' => 'text',
					'default' => 'backups',
					'save_method' => 'storeSettingField',
				],
				'system_backup_hostname' => [
					'label' => lng('serversettings.backup_hostname'),
					'settinggroup' => 'system',
					'varname' => 'backup_hostname',
					'type' => 'text',
					'default' => '',
					'save_method' => 'storeSettingField',
				],
				'system_backup_username' => [
					'label' => lng('serversettings.backup_username'),
					'settinggroup' => 'system',
					'varname' => 'backup_username',
					'type' => 'text',
					'default' => '',
					'save_method' => 'storeSettingField',
				],
				'system_backup_password' => [
					'label' => lng('serversettings.backup_password'),
					'settinggroup' => 'system',
					'varname' => 'backup_password',
					'type' => 'password',
					'default' => '',
					'save_method' => 'storeSettingField',
				],
				'system_backup_pgp_public_key' => [
					'label' => lng('serversettings.backup_pgp_public_key'),
					'settinggroup' => 'system',
					'varname' => 'backup_pgp_public_key',
					'type' => 'textarea',
					'default' => '',
					'save_method' => 'storeSettingField',
				],
				'system_backup_retention' => [
					'label' => lng('serversettings.backup_retention'),
					'settinggroup' => 'system',
					'varname' => 'backup_retention',
					'type' => 'number',
					'default' => 3,
					'save_method' => 'storeSettingField',
				],
			]
		]
	]
];
