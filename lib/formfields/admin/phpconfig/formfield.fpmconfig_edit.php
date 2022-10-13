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
	'fpmconfig_edit' => [
		'title' => lng('admin.fpmsettings.edit'),
		'image' => 'fa-solid fa-pen',
		'self_overview' => ['section' => 'phpsettings', 'page' => 'fpmdaemons'],
		'sections' => [
			'section_a' => [
				'title' => lng('admin.fpmsettings.edit'),
				'image' => 'icons/phpsettings_edit.png',
				'fields' => [
					'description' => [
						'label' => lng('admin.phpsettings.description'),
						'type' => 'text',
						'maxlength' => 50,
						'value' => $result['description'],
						'mandatory' => true
					],
					'reload_cmd' => [
						'label' => lng('serversettings.phpfpm_settings.reload'),
						'type' => 'text',
						'maxlength' => 255,
						'value' => $result['reload_cmd'],
						'mandatory' => true
					],
					'config_dir' => [
						'label' => lng('serversettings.phpfpm_settings.configdir'),
						'type' => 'text',
						'maxlength' => 255,
						'value' => $result['config_dir'],
						'mandatory' => true
					],
					'pm' => [
						'label' => lng('serversettings.phpfpm_settings.pm'),
						'type' => 'select',
						'select_var' => [
							'static' => 'static',
							'dynamic' => 'dynamic',
							'ondemand' => 'ondemand'
						],
						'selected' => $result['pm']
					],
					'max_children' => [
						'label' => lng('serversettings.phpfpm_settings.max_children.title'),
						'desc' => lng('serversettings.phpfpm_settings.max_children.description'),
						'type' => 'number',
						'value' => $result['max_children'],
						'min' => 1
					],
					'start_servers' => [
						'label' => lng('serversettings.phpfpm_settings.start_servers.title'),
						'desc' => lng('serversettings.phpfpm_settings.start_servers.description'),
						'type' => 'number',
						'value' => $result['start_servers'],
						'min' => 1
					],
					'min_spare_servers' => [
						'label' => lng('serversettings.phpfpm_settings.min_spare_servers.title'),
						'desc' => lng('serversettings.phpfpm_settings.min_spare_servers.description'),
						'type' => 'number',
						'value' => $result['min_spare_servers']
					],
					'max_spare_servers' => [
						'label' => lng('serversettings.phpfpm_settings.max_spare_servers.title'),
						'desc' => lng('serversettings.phpfpm_settings.max_spare_servers.description'),
						'type' => 'number',
						'value' => $result['max_spare_servers']
					],
					'max_requests' => [
						'label' => lng('serversettings.phpfpm_settings.max_requests.title'),
						'desc' => lng('serversettings.phpfpm_settings.max_requests.description'),
						'type' => 'number',
						'value' => $result['max_requests']
					],
					'idle_timeout' => [
						'label' => lng('serversettings.phpfpm_settings.idle_timeout.title'),
						'desc' => lng('serversettings.phpfpm_settings.idle_timeout.description'),
						'type' => 'number',
						'value' => $result['idle_timeout']
					],
					'limit_extensions' => [
						'label' => lng('serversettings.phpfpm_settings.limit_extensions.title'),
						'desc' => lng('serversettings.phpfpm_settings.limit_extensions.description'),
						'type' => 'text',
						'value' => $result['limit_extensions']
					],
					'custom_config' => [
						'label' => lng('serversettings.phpfpm_settings.custom_config.title'),
						'desc' => lng('serversettings.phpfpm_settings.custom_config.description'),
						'type' => 'textarea',
						'cols' => 50,
						'rows' => 7,
						'value' => $result['custom_config']
					]
				]
			]
		]
	]
];
