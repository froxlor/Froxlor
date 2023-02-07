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
		'spf' => [
			'title' => lng('admin.spfsettings'),
			'icon' => 'fa-solid fa-clipboard-check',
			'fields' => [
				'spf_use_spf' => [
					'label' => lng('spf.use_spf'),
					'settinggroup' => 'spf',
					'varname' => 'use_spf',
					'type' => 'checkbox',
					'default' => false,
					'save_method' => 'storeSettingField',
					'overview_option' => true
				],
				'spf_spf_entry' => [
					'label' => lng('spf.spf_entry'),
					'settinggroup' => 'spf',
					'varname' => 'spf_entry',
					'type' => 'text',
					'default' => '"v=spf1 a mx -all"',
					'save_method' => 'storeSettingField'
				]
			]
		]
	]
];
