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

use Froxlor\UI\Callbacks\Dns;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'dns_list' => [
		'title' => 'DNS Entries',
		'icon' => 'fa-solid fa-globe',
		'columns' => [
			'record' => [
				'label' => 'Record',
				'field' => 'record'
			],
			'type' => [
				'label' => 'Type',
				'field' => 'type'
			],
			'prio' => [
				'label' => 'Priority',
				'field' => 'prio',
				'callback' => [Dns::class, 'prio'],
			],
			'content' => [
				'label' => 'Content',
				'field' => 'content',
				'callback' => [Text::class, 'wordwrap'],
			],
			'ttl' => [
				'label' => 'TTL',
				'field' => 'ttl'
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('dns_list', [
			'record',
			'type',
			'prio',
			'content',
			'ttl'
		]),
		'actions' => [
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'text-danger',
				'href' => [
					'section' => 'domains',
					'page' => 'domaindnseditor',
					'action' => 'delete',
					'domain_id' => $domain_id,
					'id' => ':id'
				],
			],
		]
	]
];
