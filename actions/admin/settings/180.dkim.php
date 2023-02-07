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
	'groups' => [
		'dkim' => [
			'title' => lng('admin.dkimsettings'),
			'icon' => 'fa-solid fa-fingerprint',
			'fields' => [
				'dkim_use_dkim' => [
					'label' => lng('dkim.use_dkim'),
					'settinggroup' => 'dkim',
					'varname' => 'use_dkim',
					'type' => 'checkbox',
					'default' => false,
					'save_method' => 'storeSettingFieldInsertBindTask',
					'overview_option' => true
				],
				'dkim_dkim_prefix' => [
					'label' => lng('dkim.dkim_prefix'),
					'settinggroup' => 'dkim',
					'varname' => 'dkim_prefix',
					'type' => 'text',
					'string_type' => 'dir',
					'default' => '/etc/postfix/dkim/',
					'save_method' => 'storeSettingField'
				],
				'dkim_privkeysuffix' => [
					'label' => lng('dkim.privkeysuffix'),
					'settinggroup' => 'dkim',
					'varname' => 'privkeysuffix',
					'type' => 'text',
					'string_regexp' => '/^[a-z0-9\._]+$/i',
					'default' => '.priv',
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				],
				'dkim_dkim_domains' => [
					'label' => lng('dkim.dkim_domains'),
					'settinggroup' => 'dkim',
					'varname' => 'dkim_domains',
					'type' => 'text',
					'string_regexp' => '/^[a-z0-9\._]+$/i',
					'default' => 'domains',
					'save_method' => 'storeSettingField'
				],
				'dkim_dkim_dkimkeys' => [
					'label' => lng('dkim.dkim_dkimkeys'),
					'settinggroup' => 'dkim',
					'varname' => 'dkim_dkimkeys',
					'type' => 'text',
					'string_regexp' => '/^[a-z0-9\._]+$/i',
					'default' => 'dkim-keys.conf',
					'save_method' => 'storeSettingField'
				],
				'dkim_dkim_algorithm' => [
					'label' => lng('dkim.dkim_algorithm'),
					'settinggroup' => 'dkim',
					'varname' => 'dkim_algorithm',
					'type' => 'select',
					'default' => 'all',
					'select_mode' => 'multiple',
					'select_var' => [
						'all' => 'All',
						'sha1' => 'SHA1',
						'sha256' => 'SHA256'
					],
					'save_method' => 'storeSettingFieldInsertBindTask',
					'advanced_mode' => true
				],
				'dkim_dkim_servicetype' => [
					'label' => lng('dkim.dkim_servicetype'),
					'settinggroup' => 'dkim',
					'varname' => 'dkim_servicetype',
					'type' => 'select',
					'default' => '0',
					'select_var' => [
						'0' => 'All',
						'1' => 'E-Mail'
					],
					'save_method' => 'storeSettingFieldInsertBindTask',
					'advanced_mode' => true
				],
				'dkim_dkim_keylength' => [
					'label' => [
						'title' => lng('dkim.dkim_keylength.title'),
						'description' => lng('dkim.dkim_keylength.description', [Settings::Get('dkim.dkim_prefix')])
					],
					'settinggroup' => 'dkim',
					'varname' => 'dkim_keylength',
					'type' => 'select',
					'default' => '1024',
					'select_var' => [
						'1024' => '1024 Bit',
						'2048' => '2048 Bit'
					],
					'save_method' => 'storeSettingFieldInsertBindTask'
				],
				'dkim_dkim_notes' => [
					'label' => lng('dkim.dkim_notes'),
					'settinggroup' => 'dkim',
					'varname' => 'dkim_notes',
					'type' => 'text',
					'string_regexp' => '/^[a-z0-9\._]+$/i',
					'default' => '',
					'save_method' => 'storeSettingFieldInsertBindTask',
					'advanced_mode' => true
				],
				'dkim_dkimrestart_command' => [
					'label' => lng('dkim.dkimrestart_command'),
					'settinggroup' => 'dkim',
					'varname' => 'dkimrestart_command',
					'type' => 'text',
					'string_regexp' => '/^[a-z0-9\/\._\- ]+$/i',
					'default' => '/etc/init.d/dkim-filter restart',
					'save_method' => 'storeSettingField'
				]
			]
		]
	]
];
