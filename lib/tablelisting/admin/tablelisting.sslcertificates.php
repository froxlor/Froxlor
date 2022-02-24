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
	'sslcertificates_list' => [
		'title' => $lng['domains']['ssl_certificates'],
		'icon' => 'fa-solid fa-user',
		'columns' => [
            'd.domain' => [
                'label' => $lng['domains']['domainname'],
                'column' => 'domain',
            ],
            'c.domain' => [
                'label' => $lng['ssl_certificates']['certificate_for'],
                'column' => 'domain',
                'format_callback' => [Text::class, 'domainWithSan'],
            ],
            'c.issuer' => [
                'label' => $lng['ssl_certificates']['issuer'],
                'column' => 'issuer',
            ],
            'c.validfromdate' => [
                'label' => $lng['ssl_certificates']['valid_from'],
                'column' => 'validfromdate',
            ],
            'c.validtodate' => [
                'label' => $lng['ssl_certificates']['valid_until'],
                'column' => 'validtodate',
            ],
            'c.letsencrypt' => [
                'label' => $lng['panel']['letsencrypt'],
                'column' => 'letsencrypt',
                'class' => 'text-center',
                'format_callback' => [Text::class, 'boolean'],
                'visible' => Settings::Get('system.le_froxlor_enabled'),
            ],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('sslcertificates_list', [
			'd.domain',
			'c.domain',
            'c.issuer',
            'c.validfromdate',
			'c.validtodate',
			'c.letsencrypt',
		]),
        'actions' => [
            'delete' => [
                'icon' => 'fa fa-trash',
                'class' => 'text-danger',
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
