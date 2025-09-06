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
	'domain_duplicate' => [
		'title' => lng('admin.domain_duplicate'),
		'image' => 'fa-solid fa-globe',
		'self_overview' => ['section' => 'domains', 'page' => 'domains'],
		'id' => 'domain_add',
		'sections' => [
			'section_a' => [
				'title' => lng('domains.domainsettings'),
				'fields' => [
					'domain' => [
						'label' => 'Domain',
						'type' => 'text',
						'mandatory' => true
					],
					'customerid' => [
						'label' => lng('admin.customer'),
						'type' => 'select',
						'select_var' => $customers,
						'selected' => $result['customerid'],
						'mandatory' => true
					],
				]
			]
		],
		'buttons' => [
			[
				'label' => lng('admin.domain_duplicate')
			]
		]
	]
];
