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
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'ipsandports_list' => [
		'title' => lng('admin.ipsandports.ipsandports'),
		'icon' => 'fa-solid fa-ethernet',
		'self_overview' => ['section' => 'ipsandports', 'page' => 'ipsandports'],
		'columns' => [
			'ip' => [
				'label' => lng('admin.ipsandports.ip'),
				'field' => 'ip',
			],
			'port' => [
				'label' => lng('admin.ipsandports.port'),
				'field' => 'port',
				'class' => 'text-center',
			],
			'listen' => [
				'label' => 'Listen',
				'field' => 'listen_statement',
				'class' => 'text-center',
				'callback' => [Text::class, 'boolean'],
				'visible' => Settings::Get('system.webserver') != 'nginx'
			],
			'namevirtualhost' => [
				'label' => 'NameVirtualHost',
				'field' => 'namevirtualhost_statement',
				'class' => 'text-center',
				'callback' => [Text::class, 'boolean'],
				'visible' => Settings::Get('system.webserver') == 'apache2' && (int)Settings::Get('system.apache24') == 0
			],
			'vhostcontainer' => [
				'label' => 'vHost-Container',
				'field' => 'vhostcontainer',
				'class' => 'text-center',
				'callback' => [Text::class, 'boolean']
			],
			'specialsettings' => [
				'label' => 'Specialsettings',
				'field' => 'specialsettings',
				'class' => 'text-center',
				'callback' => [Text::class, 'boolean']
			],
			'servername' => [
				'label' => 'ServerName',
				'field' => 'vhostcontainer_servername_statement',
				'class' => 'text-center',
				'callback' => [Text::class, 'boolean'],
				'visible' => Settings::Get('system.webserver') == 'apache2'
			],
			'ssl' => [
				'label' => 'SSL',
				'field' => 'ssl',
				'class' => 'text-center',
				'callback' => [Text::class, 'boolean']
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('ipsandports_list', [
			'ip',
			'port',
			'vhostcontainer',
			'specialsettings',
			'servername',
			'ssl'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => lng('panel.edit'),
				'href' => [
					'section' => 'ipsandports',
					'page' => 'ipsandports',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => lng('panel.delete'),
				'class' => 'btn-danger',
				'href' => [
					'section' => 'ipsandports',
					'page' => 'ipsandports',
					'action' => 'delete',
					'id' => ':id'
				],
			],
		]
	]
];
