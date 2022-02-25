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

use Froxlor\UI\Callbacks\Ftp;
use Froxlor\UI\Listing;

return [
	'ftp_list' => [
		'title' => $lng['menue']['ftp']['accounts'],
		'icon' => 'fa-solid fa-users',
		'columns' => [
			'username' => [
				'label' => $lng['login']['username'],
				'column' => 'username',
			],
			'description' => [
				'label' => $lng['panel']['ftpdesc'],
				'column' => 'description'
			],
			'homedir' => [
				'label' => $lng['panel']['path'],
				'column' => 'homedir',
				'format_callback' => [Ftp::class, 'pathRelative']
			],
			'shell' => [
				'label' => $lng['panel']['shell'],
				'column' => 'shell',
				'visible' => \Froxlor\Settings::Get('system.allow_customer_shell') == '1'
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('ftp_list', [
			'username',
			'description',
			'homedir',
			'shell'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'href' => [
					'section' => 'ftp',
					'page' => 'ftps',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'class' => 'text-danger',
				'href' => [
					'section' => 'ftp',
					'page' => 'ftps',
					'action' => 'delete',
					'id' => ':id'
				],
			]
		]
	]
];
