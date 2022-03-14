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
use Froxlor\UI\Listing;

return [
	'domain_list' => [
		'title' => $lng['admin']['domains'],
		'icon' => 'fa-solid fa-globe',
		'columns' => [
			'd.domain_ace' => [
				'label' => $lng['domains']['domainname'],
				'field' => 'domain_ace',
			],
			'd.documentroot' => [
				'label' => $lng['panel']['path'],
				'field' => 'documentroot',
				'callback' => [Domain::class, 'domainTarget'],
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('domain_list', [
			'd.domain_ace',
			'd.documentroot'
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
				'visible' => [Domain::class, 'canEdit']
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
				'visible' => [Domain::class, 'canEditDNS']
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
			'haslias' => [
				'icon' => 'fa fa-arrow-up-right-from-square',
				'title' => $lng['domains']['hasaliasdomains'],
				'href' => [
					'section' => 'domains',
					'page' => 'domains',
					'searchfield' => 'd.aliasdomain',
					'searchtext' => ':domainaliasid'
				],
				'visible' => [Domain::class, 'canEditAlias']
			],
			'isassigned' => [
				'icon' => 'fa-check-to-slot',
				'title' => $lng['domains']['isassigneddomain'],
				'visible' => [Domain::class, 'isAssigned']
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
				'visible' => [Domain::class, 'canDelete']
			]
		]
	]
];
