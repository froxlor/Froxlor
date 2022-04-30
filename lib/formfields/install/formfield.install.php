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
	'install' => [
		'title' => lng('admin.admin_add'),
		'image' => 'fa-solid fa-user-plus',
		'self_overview' => ['section' => 'admins', 'page' => 'admins'],
		'sections' => [
			'step1' => [
				'title' => lng('install.database.title'),
				'fields' => [
					'sql_hostname' => [
						'label' => lng('sql_hostname'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('sql_hostname', 'localhost', 'installation')
					],
					'sql_root_username' => [
						'label' => lng('sql_root_username'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('sql_root_username', 'froxroot', 'installation'),
						'next_to' => [
							'sql_root_password' => [
								'label' => lng('sql_root_password'),
								'type' => 'password',
								'mandatory' => true,
								'value' => old('sql_root_password', null, 'installation'),
							],
						]
					],
					'sql_username' => [
						'label' => lng('sql_username'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('sql_username', 'froxlor', 'installation'),
						'next_to' => [
							'sql_password' => [
								'label' => lng('sql_password'),
								'type' => 'password',
								'mandatory' => true,
								'value' => old('sql_password', null, 'installation'),
							],
						]
					],
					'sql_database' => [
						'label' => lng('sql_database'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('sql_database', 'froxlor', 'installation'),
					],
					'sql_override_database' => [
						'label' => lng('sql_override_database'),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => old('sql_override_database', '0', 'installation')
					],
				]
			],
			'step2' => [
				'title' => lng('install.admin.title'),
				'fields' => [
					'name' => [
						'label' => lng('name'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('name', 'Administrator', 'installation'),
					],
					'username' => [
						'label' => lng('username'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('username', 'admin', 'installation'),
					],
					'password' => [
						'label' => lng('password'),
						'type' => 'password',
						'mandatory' => true,
						'value' => old('password', null, 'installation'),
					],
					'email' => [
						'label' => lng('email'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('email', null, 'installation'),
					],
				]
			],
			'step3' => [
				'title' => lng('install.system.title'),
				'fields' => [
					'system' => [
						'label' => lng('install.system.system'),
						'type' => 'select',
						'select_var' => $this->supportedOS,
					],
					'test' => [
						'label' => lng('install.system.test'),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					],
				]
			],
			'step4' => [
				'title' => lng('install.system.title'),
				'fields' => [
					'system' => [
						'label' => lng('install.system.system'),
						'type' => 'textarea',
						'value' => '/var/www/html/froxlor/bin/froxlor-cli cron --force',
						'readonly' => true,
						'rows' => 1
					],
				]
			]
		]
	]
];
