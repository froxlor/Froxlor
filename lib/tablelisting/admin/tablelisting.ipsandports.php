<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @author     Maurice Preuß <hello@envoyr.com>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Tabellisting
 *
 */

use Froxlor\Settings;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'ipsandports_list' => [
		'title' => $lng['admin']['ipsandports']['ipsandports'],
		'icon' => 'fa-solid fa-ethernet',
		'columns' => [
			'ip' => [
				'label' => $lng['admin']['ipsandports']['ip'],
				'field' => 'ip',
			],
			'port' => [
				'label' => $lng['admin']['ipsandports']['port'],
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
			'listen',
			'namevirtualhost',
			'vhostcontainer',
			'specialsettings',
			'servername',
			'ssl'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'ipsandports',
					'page' => 'ipsandports',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'text-danger',
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
