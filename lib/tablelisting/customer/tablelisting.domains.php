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

use Froxlor\UI\Callbacks\Style;
use Froxlor\UI\Callbacks\Domain;
use Froxlor\UI\Listing;

return [
	'domain_list' => [
		'title' => lng('admin.domains'),
		'icon' => 'fa-solid fa-globe',
		'self_overview' => ['section' => 'domains', 'page' => 'domains'],
		'columns' => [
			'ad.id' => [
				'field' => 'aliasdomainid'
			],
			'd.domain_ace' => [
				'label' => lng('domains.domainname'),
				'field' => 'domain_ace',
				'callback' => [Domain::class, 'domainExternalLinkInfo'],
			],
			'd.documentroot' => [
				'label' => lng('panel.path'),
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
				'title' => lng('panel.edit'),
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
				'title' => lng('panel.viewlogs'),
				'href' => [
					'section' => 'domains',
					'page' => 'logfiles',
					'domain_id' => ':id'
				],
				'visible' => [Domain::class, 'canViewLogs']
			],
			'domaindnseditor' => [
				'icon' => 'fa fa-globe',
				'title' => lng('dnseditor.edit'),
				'href' => [
					'section' => 'domains',
					'page' => 'domaindnseditor',
					'domain_id' => ':id'
				],
				'visible' => [Domain::class, 'canEditDNS']
			],
			'domainssleditor' => [
				'icon' => 'fa fa-shield',
				'title' => lng('panel.ssleditor'), // @todo different certificate types by $row['domain_hascert']
				'href' => [
					'section' => 'domains',
					'page' => 'domainssleditor',
					'action' => 'view',
					'id' => ':id'
				],
				'visible' => [Domain::class, 'canEditSSL']
			],
			'letsencrypt' => [
				'icon' => 'fa fa-shield',
				'title' => lng('panel.letsencrypt'),
				'visible' => [Domain::class, 'hasLetsEncryptActivated']
			],
			'haslias' => [
				'icon' => 'fa fa-arrow-up-right-from-square',
				'title' => lng('domains.hasaliasdomains'),
				'href' => [
					'section' => 'domains',
					'page' => 'domains',
					'searchfield' => 'ad.id',
					'searchtext' => ':id'
				],
				'visible' => [Domain::class, 'canEditAlias']
			],
			'isassigned' => [
				'icon' => 'fa-check-to-slot',
				'title' => lng('domains.isassigneddomain'),
				'visible' => [Domain::class, 'isAssigned']
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => lng('panel.delete'),
				'class' => 'btn-danger',
				'href' => [
					'section' => 'domains',
					'page' => 'domains',
					'action' => 'delete',
					'id' => ':id'
				],
				'visible' => [Domain::class, 'canDelete']
			]
		],
		'format_callback' => [
			[Style::class, 'resultDomainTerminatedOrDeactivated']
		]
	]
];
