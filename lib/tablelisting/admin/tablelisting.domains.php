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

use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Callbacks\Impersonate;
use Froxlor\UI\Listing;

return [
	'domain_list' => [
		'title' => $lng['admin']['domains'],
		'icon' => 'fa-solid fa-user',
		'columns' => [
			'd.domain_ace' => [
				'label' => $lng['domains']['domainname'],
				'column' => 'domain_ace',
			],
			'c.name' => [
				'label' => $lng['customer']['name'],
				'column' => 'customer.name',
				'format_callback' => [Text::class, 'customerfullname'],
			],
			'c.loginname' => [
				'label' => $lng['login']['username'],
				'column' => 'customer.loginname',
				'format_callback' => [Impersonate::class, 'customer'],
			],
			'd.aliasdomain' => [
				'label' => $lng['domains']['aliasdomain'],
				'column' => 'aliasdomain',
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('domain_list', [
			'd.domain_ace',
			'c.name',
			'c.loginname',
			'd.aliasdomain',
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'href' => [
					'section' => 'domains',
					'page' => 'domains',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'logfiles' => [
				'icon' => 'fa fa-file',
				'href' => [
					'section' => 'domains',
					'page' => 'logfiles',
					'domain_id' => ':id'
				],
			],
			'domaindnseditor' => [
				'icon' => 'fa fa-globe',
				'href' => [
					'section' => 'domains',
					'page' => 'domaindnseditor',
					'domain_id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'class' => 'text-danger',
				'href' => [
					'section' => 'domains',
					'page' => 'domains',
					'action' => 'delete',
					'id' => ':id'
				],
			]
		]
	]
];
