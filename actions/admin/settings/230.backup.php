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
				'backup_enabled' => [
					'label' => lng('serversettings.backup_enabled'),
					'settinggroup' => 'backup',
					'varname' => 'enabled',
					'type' => 'checkbox',
					'default' => false,
					'save_method' => 'storeSettingField',
					'overview_option' => true,
					'cronmodule' => 'froxlor/backup'
				],
				'backup_default_storage' => [
					'label' => lng('serversettings.backup_default_storage'),
					'settinggroup' => 'backup',
					'varname' => 'default_storage',
					'type' => 'select',
					'default' => '1',
					'option_options_method' => [
						'\\Froxlor\\Backup\\Backup',
						'getBackupStorages'
					],
					'save_method' => 'storeSettingField'
				],
				'backup_default_retention' => [
					'label' => lng('serversettings.backup_default_retention'),
					'settinggroup' => 'backup',
					'varname' => 'default_retention',
					'type' => 'number',
					'default' => 3,
					'min' => 0,
					'save_method' => 'storeSettingField',
				],
				'backup_default_customer_access' => [
					'label' => lng('serversettings.backup_default_customer_access'),
					'settinggroup' => 'backup',
					'varname' => 'default_customer_access',
					'type' => 'checkbox',
					'default' => true,
					'save_method' => 'storeSettingField',
				],
				'backup_default_pgp_public_key' => [
					'label' => lng('serversettings.backup_default_pgp_public_key'),
					'settinggroup' => 'backup',
					'varname' => 'default_pgp_public_key',
					'type' => 'textarea',
					'default' => '',
					'save_method' => 'storeSettingField',
					'plausibility_check_method' => [
						'\\Froxlor\\Validate\\Check',
						'checkPgpPublicKeySetting'
					],
				],
			]
		]
	]
];
