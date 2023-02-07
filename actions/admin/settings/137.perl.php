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
		'perl' => [
			'title' => lng('admin.perl_settings'),
			'icon' => 'fa-solid fa-code',
			'fields' => [
				'system_perl_path' => [
					'label' => lng('serversettings.perl_path'),
					'settinggroup' => 'system',
					'varname' => 'perl_path',
					'type' => 'text',
					'default' => '/usr/bin/perl',
					'save_method' => 'storeSettingField',
					'websrv_avail' => [
						'lighttpd'
					]
				],
				'perl_suexecworkaround' => [
					'label' => lng('serversettings.perl.suexecworkaround'),
					'settinggroup' => 'perl',
					'varname' => 'suexecworkaround',
					'type' => 'checkbox',
					'default' => false,
					'save_method' => 'storeSettingField',
					'websrv_avail' => [
						'apache2'
					]
				],
				'perl_suexecpath' => [
					'label' => lng('serversettings.perl.suexeccgipath'),
					'settinggroup' => 'perl',
					'varname' => 'suexecpath',
					'type' => 'text',
					'string_type' => 'dir',
					'default' => '/var/www/cgi-bin/',
					'save_method' => 'storeSettingField',
					'websrv_avail' => [
						'apache2'
					]
				],
				'serversettings_perl_server' => [
					'label' => lng('serversettings.perl_server'),
					'settinggroup' => 'serversettings',
					'varname' => 'perl_server',
					'type' => 'text',
					'default' => 'unix:/var/run/nginx/cgiwrap-dispatch.sock',
					'save_method' => 'storeSettingField',
					'websrv_avail' => [
						'nginx'
					]
				]
			]
		]
	]
];
