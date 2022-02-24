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
    'customer_list' => [
        'title' => $lng['admin']['customers'],
        'icon' => 'fa-solid fa-user',
        'columns' => [
            'c.loginname' => [
                'label' => $lng['login']['username'],
                'column' => 'loginname',
            ],
            'a.loginname' => [
                'label' => $lng['admin']['admin'],
                'column' => 'admin.loginname',
            ],
            'c.name' => [
                'label' => $lng['customer']['name'],
                'column' => 'name',
            ],
            'c.email' => [
                'label' => $lng['customer']['email'],
                'column' => 'email',
            ],
            'c.firstname' => [
                'label' => $lng['customer']['firstname'],
                'column' => 'firstname',
            ],
            'c.company' => [
                'label' => $lng['customer']['company'],
                'column' => 'company',
            ],
            'c.diskspace' => [
                'label' => $lng['customer']['diskspace'],
                'column' => 'diskspace',
                'format_callback' => [\Froxlor\UI\Callbacks\ProgressBar::class, 'diskspace'],
            ],
            'c.traffic' => [
                'label' => $lng['customer']['traffic'],
                'column' => 'traffic',
                'format_callback' => [\Froxlor\UI\Callbacks\ProgressBar::class, 'traffic'],
            ],
        ],
        'visible_columns' => \Froxlor\UI\Listing::getVisibleColumnsForListing('customer_list', [
            'c.loginname',
            'a.loginname',
            'c.email',
            'c.firstname',
            'c.company',
            'c.diskspace',
            'c.traffic',
        ]),
        'actions' => [
            'delete' => [
                'icon' => 'fa fa-trash',
                'href' => [
                    'section' => 'customers',
                    'page' => 'customers',
                    'action' => 'delete',
                    'id' => ':customerid'
                ],
            ],
            'edit' => [
                'text' => 'Edit',
                'href' => [
                    'section' => 'customers',
                    'page' => 'customers',
                    'action' => 'edit',
                    'id' => ':customerid'
                ],
            ]
        ],
    ]
];
