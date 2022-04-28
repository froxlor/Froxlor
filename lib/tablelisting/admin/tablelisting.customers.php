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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    http://files.froxlor.org/misc/COPYING.txt GPLv2
 */

use Froxlor\UI\Callbacks\Customer;
use Froxlor\UI\Callbacks\Impersonate;
use Froxlor\UI\Callbacks\ProgressBar;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'customer_list' => [
		'title' => lng('admin.customers'),
		'description' => 'Manage your customers',
		'icon' => 'fa-solid fa-user',
		'self_overview' => ['section' => 'customers', 'page' => 'customers'],
		'columns' => [
			'c.customerid' => [
				'label' => 'ID',
				'field' => 'customerid',
				'sortable' => true,
			],
			'c.name' => [
				'label' => lng('customer.name'),
				'field' => 'name',
				'callback' => [Text::class, 'customerfullname'],
			],
			'c.loginname' => [
				'label' => lng('login.username'),
				'field' => 'loginname',
				'callback' => [Impersonate::class, 'customer'],
			],
			'a.loginname' => [
				'label' => lng('admin.admin'),
				'field' => 'adminname',
				'callback' => [Impersonate::class, 'admin'],
			],
			'c.email' => [
				'label' => lng('customer.email'),
				'field' => 'email',
			],
			'c.diskspace' => [
				'label' => lng('customer.diskspace'),
				'field' => 'diskspace',
				'callback' => [ProgressBar::class, 'diskspace'],
			],
			'c.traffic' => [
				'label' => lng('customer.traffic'),
				'field' => 'traffic',
				'callback' => [ProgressBar::class, 'traffic'],
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('customer_list', [
			'c.name',
			'c.loginname',
			'a.loginname',
			'c.email',
			'c.diskspace',
			'c.traffic',
		]),
		'actions' => [
			'unlock' => [
				'icon' => 'fa fa-unlock',
				'title' => lng('panel.unlock'),
				'class' => 'text-warning',
				'href' => [
					'section' => 'customers',
					'page' => 'customers',
					'action' => 'unlock',
					'id' => ':customerid'
				],
				'visible' => [Customer::class, 'isLocked']
			],
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => lng('panel.edit'),
				'href' => [
					'section' => 'customers',
					'page' => 'customers',
					'action' => 'edit',
					'id' => ':customerid'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => lng('panel.delete'),
				'class' => 'btn-danger',
				'href' => [
					'section' => 'customers',
					'page' => 'customers',
					'action' => 'delete',
					'id' => ':customerid'
				],
			],
		],
	]
];
