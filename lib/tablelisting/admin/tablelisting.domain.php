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
            ],
            'c.firstname' => [
                'label' => $lng['customer']['firstname'],
                'column' => 'customer.firstname',
            ],
            'c.company' => [
                'label' => $lng['customer']['company'],
                'column' => 'customer.company',
            ],
            'c.loginname' => [
                'label' => $lng['login']['username'],
                'column' => 'customer.loginname',
            ],
            'd.aliasdomain' => [
                'label' => $lng['domains']['aliasdomain'],
                'column' => 'aliasdomain',
            ],
        ],
        'visible_columns' => \Froxlor\UI\Listing::getVisibleColumnsForListing('domain_list', [
            'd.domain_ace',
            'c.name',
            'c.firstname',
            'c.company',
            'c.loginname',
            'd.aliasdomain',
        ]),
        'actions' => [
            'delete' => [
                'icon' => 'fa fa-trash',
                'href' => [
                    'section' => 'domains',
                    'page' => 'domains',
                    'action' => 'delete',
                    'id' => ':id'
                ],
            ],
            'edit' => [
                'text' => 'Edit',
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
            ]
        ]
    ]
];
