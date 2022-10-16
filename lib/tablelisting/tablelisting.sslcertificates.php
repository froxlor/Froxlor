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

use Froxlor\UI\Callbacks\Domain;
use Froxlor\UI\Callbacks\SSLCertificate;
use Froxlor\UI\Listing;

return [
	'sslcertificates_list' => [
		'title' => lng('domains.ssl_certificates'),
		'icon' => 'fa-solid fa-shield',
		'self_overview' => ['section' => 'domains', 'page' => 'sslcertificates'],
		'default_sorting' => ['d.domain' => 'asc'],
		'columns' => [
			'd.domain' => [
				'label' => lng('domains.domainname'),
				'field' => 'domain',
				'callback' => [Domain::class, 'domainWithCustomerLink'],
			],
			'c.domain' => [
				'label' => lng('ssl_certificates.certificate_for'),
				'field' => 'domain',
				'callback' => [SSLCertificate::class, 'domainWithSan'],
			],
			'c.issuer' => [
				'label' => lng('ssl_certificates.issuer'),
				'field' => 'issuer',
			],
			'c.validfromdate' => [
				'label' => lng('ssl_certificates.valid_from'),
				'field' => 'validfromdate',
			],
			'c.validtodate' => [
				'label' => lng('ssl_certificates.valid_until'),
				'field' => 'validtodate',
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('sslcertificates_list', [
			'd.domain',
			'c.domain',
			'c.issuer',
			'c.validfromdate',
			'c.validtodate',
		]),
		'actions' => [
			'delete' => [
				'icon' => 'fa-solid fa-trash',
				'title' => lng('panel.delete'),
				'class' => 'btn-danger',
				'href' => [
					'section' => 'domains',
					'page' => 'sslcertificates',
					'action' => 'delete',
					'id' => ':id'
				],
			],
		]
	]
];
