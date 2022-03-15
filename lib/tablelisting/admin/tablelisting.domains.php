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

use Froxlor\UI\Callbacks\Domain;
use Froxlor\UI\Callbacks\Impersonate;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'domain_list' => [
		'title' => $lng['admin']['domains'],
		'icon' => 'fa-solid fa-globe',
		'empty_msg' => $lng['admin']['domain_nocustomeraddingavailable'],
		'columns' => [
			'd.domain_ace' => [
				'label' => $lng['domains']['domainname'],
				'field' => 'domain_ace',
			],
			'c.name' => [
				'label' => $lng['customer']['name'],
				'field' => 'customer.name',
				'callback' => [Text::class, 'customerfullname'],
			],
			'c.loginname' => [
				'label' => $lng['login']['username'],
				'field' => 'customer.loginname',
				'callback' => [Impersonate::class, 'customer'],
			],
			'd.aliasdomain' => [
				'label' => $lng['domains']['aliasdomain'],
				'field' => 'aliasdomain',
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
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'domains',
					'page' => 'domains',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'logfiles' => [
				'icon' => 'fa fa-file',
				'title' => $lng['panel']['viewlogs'],
				'href' => [
					'section' => 'domains',
					'page' => 'logfiles',
					'domain_id' => ':id'
				],
				'visible' => [Domain::class, 'canViewLogs']
			],
			'domaindnseditor' => [
				'icon' => 'fa fa-globe',
				'title' => $lng['dnseditor']['edit'],
				'href' => [
					'section' => 'domains',
					'page' => 'domaindnseditor',
					'domain_id' => ':id'
				],
				'visible' => [Domain::class, 'adminCanEditDNS']
			],
			'domainssleditor' => [
				'icon' => 'fa fa-shield',
				'title' => $lng['panel']['ssleditor'], // @todo different certificate types by $row['domain_hascert']
				'href' => [
					'section' => 'domains',
					'page' => 'domainssleditor',
					'action' => 'view',
					'id' => ':id'
				],
				'visible' => [Domain::class, 'adminCanEditDNS']
			],
			'letsencrypt' => [
				'icon' => 'fa fa-shield',
				'title' => $lng['panel']['letsencrypt'],
				'visible' => [Domain::class, 'hasLetsEncryptActivated']
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'btn-danger',
				'href' => [
					'section' => 'domains',
					'page' => 'domains',
					'action' => 'delete',
					'id' => ':id'
				],
				'visible' => [Domain::class, 'adminCanDelete']
			]
		]
	]
];
