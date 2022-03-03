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
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Tabellisting
 *
 */

use Froxlor\UI\Callbacks\Impersonate;
use Froxlor\UI\Callbacks\Style;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'apikeys_list' => [
		'title' => $lng['menue']['main']['apikeys'],
		'icon' => 'fa-solid fa-key',
		'columns' => [
			'a.loginname' => [
				'label' => $lng['login']['username'],
				'field' => 'loginname',
				'callback' => [Impersonate::class, 'apiAdminCustomerLink']
			],
			'ak.apikey' => [
				'label' => 'API-key',
				'field' => 'apikey',
				'callback' => [Text::class, 'shorten'],
			],
			'ak.secret' => [
				'label' => 'Secret',
				'field' => 'secret',
				'callback' => [Text::class, 'shorten'],
			],
			'ak.allowed_from' => [
				'label' => $lng['apikeys']['allowed_from'],
				'field' => 'allowed_from',
			],
			'ak.valid_until' => [
				'label' => $lng['apikeys']['valid_until'],
				'field' => 'valid_until',
				'callback' => [Text::class, 'timestampUntil'],
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('apikeys_list', [
			'a.loginname',
			'ak.apikey',
			'ak.secret',
			'ak.allowed_from',
			'ak.valid_until'
		]),
		'actions' => [
			'show' => [
				'icon' => 'fa fa-eye',
				'title' => $lng['apikeys']['clicktoview'],
				'href' => [
					'page' => 'apikeys',
					'action' => '#',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'text-danger',
				'href' => [
					'page' => 'apikeys',
					'action' => 'delete',
					'id' => ':id'
				],
			],
		],
		'callback' => [
			[Style::class, 'invalidApiKey']
		]
	]
];
