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

use Froxlor\UI\Callbacks\Impersonate;
use Froxlor\UI\Callbacks\Style;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'emaildomain_list' => [
		'title' => lng('menue.email.emailsoverview'),
		'icon' => 'fa-solid fa-envelope',
		'self_overview' => ['section' => 'email', 'page' => 'overview'],
		'default_sorting' => ['d.domain' => 'asc'],
		'columns' => [
			'd.domain' => [
				'label' => 'Domain',
				'field' => 'domain',
			],
			'addresses' => [
				'label' => '# ' . lng('emails.emails'),
				'field' => 'addresses',
				'searchable' => false,
			],
			'accounts' => [
				'label' => '# ' . lng('emails.accounts'),
				'field' => 'accounts',
				'searchable' => false,
			],
			'forwarder' => [
				'label' => '# ' . lng('emails.forwarders'),
				'field' => 'forwarder',
				'searchable' => false,
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('emaildomain_list', [
			'd.domain',
			'addresses',
			'accounts',
			'forwarder',
		]),
		'actions' => [
			'show' => [
				'icon' => 'fa-solid fa-eye',
				'title' => lng('apikeys.clicktoview'),
				'href' => [
					'section' => 'email',
					'page' => 'email_domain',
					'domainid' => ':domainid'
				],
			],
		],
	]
];
