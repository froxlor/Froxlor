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
					'mysql_host' => [
						'label' => lng('mysql_host'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('mysql_host', 'localhost', 'installation')
					],
					'mysql_root_user' => [
						'label' => lng('mysql_root_user'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('mysql_root_user', 'froxroot', 'installation'),
						'next_to' => [
							'mysql_root_pass' => [
								'label' => lng('mysql_root_pass'),
								'type' => 'password',
								'mandatory' => true,
								'value' => old('mysql_root_pass', null, 'installation'),
							],
						]
					],
					'mysql_unprivileged_user' => [
						'label' => lng('mysql_unprivileged_user'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('mysql_unprivileged_user', 'froxlor', 'installation'),
						'next_to' => [
							'mysql_unprivileged_pass' => [
								'label' => lng('mysql_unprivileged_pass'),
								'type' => 'password',
								'mandatory' => true,
								'value' => old('mysql_unprivileged_pass', null, 'installation'),
							],
						]
					],
					'mysql_database' => [
						'label' => lng('mysql_database'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('mysql_database', 'froxlor', 'installation'),
					],
					'mysql_force_create' => [
						'label' => lng('mysql_force_create'),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => old('mysql_force_create', '0', 'installation')
					],
					'mysql_access_host' => [
						'label' => lng('mysql_access_host'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('mysql_access_host', '127.0.0.1,localhost', 'installation'),
					],
				]
			],
			'step2' => [
				'title' => lng('install.admin.title'),
				'fields' => [
					'admin_name' => [
						'label' => lng('admin_name'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('admin_name', 'Administrator', 'installation'),
					],
					'admin_user' => [
						'label' => lng('admin_user'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('admin_user', 'admin', 'installation'),
					],
					'admin_pass' => [
						'label' => lng('admin_pass'),
						'type' => 'password',
						'mandatory' => true,
						'value' => old('admin_pass', null, 'installation'),
					],
					'admin_email' => [
						'label' => lng('admin_email'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('admin_email', null, 'installation'),
					],
				]
			],
			'step3' => [
				'title' => lng('install.system.title'),
				'fields' => [
					'distribution' => [
						'label' => lng('distribution'),
						'type' => 'select',
						'mandatory' => true,
						'select_var' => $this->supportedOS,
					],
					'serverip' => [
						'label' => lng('serverip'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('serverip', null, 'installation'),
					],
					'servername' => [
						'label' => lng('servername'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('servername', null, 'installation'),
					],
					'use_ssl' => [
						'label' => lng('use_ssl'),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => old('use_ssl', '1', 'installation'),
					],
					'webserver' => [
						'label' => lng('webserver'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('webserver', 'apache24', 'installation'),
					],
					'webserver_backend' => [
						'label' => lng('webserver_backend'),
						'type' => 'select',
						'mandatory' => true,
						'select_var' => $this->webserverBackend,
					],
					'httpuser' => [
						'label' => lng('httpuser'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('httpuser', 'www-data', 'installation'),
					],
					'httpgroup' => [
						'label' => lng('httpgroup'),
						'type' => 'text',
						'mandatory' => true,
						'value' => old('httpgroup', 'www-data', 'installation'),
					],
					'activate_newsfeed' => [
						'label' => lng('activate_newsfeed'),
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
