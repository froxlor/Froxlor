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
    'admin_list' => [
        'title' => $lng['admin']['admin'],
        'icon' => 'fa-solid fa-user',
        'columns' => [
            'adminid' => [
                'label' => '#',
                'column' => 'adminid',
                'sortable' => true,
            ],
            'loginname' => [
                'label' => $lng['login']['username'],
                'column' => 'loginname',
                'sortable' => true,
            ],
            'name' => [
                'label' => $lng['customer']['name'],
                'column' => 'name',
            ],
            'diskspace' => [
                'label' => $lng['customer']['diskspace'],
                'column' => 'diskspace',
                'format_callback' => [\Froxlor\UI\Callbacks\Number::class, 'diskspace'],
            ],
            'diskspace_used' => [
                'label' => $lng['customer']['diskspace'] . ' (' . $lng['panel']['used'] . ')',
                'column' => 'diskspace_used',
                'format_callback' => [\Froxlor\UI\Callbacks\ProgressBar::class, 'diskspace'],
            ],
            'traffic' => [
                'label' => $lng['customer']['traffic'],
                'column' => 'traffic',
                'format_callback' => [\Froxlor\UI\Callbacks\Number::class, 'traffic'],
            ],
            'traffic_used' => [
                'label' => $lng['customer']['traffic'] . ' (' . $lng['panel']['used'] . ')',
                'column' => 'traffic_used',
                'format_callback' => [\Froxlor\UI\Callbacks\ProgressBar::class, 'traffic'],
            ],
            'deactivated' => [
                'label' => $lng['admin']['deactivated'],
                'column' => 'deactivated',
                'format_callback' => [\Froxlor\UI\Callbacks\Text::class, 'boolean'],
            ],
        ],
        'visible_columns' => \Froxlor\UI\Listing::getVisibleColumnsForListing('admin_list', [
            'loginname',
            'name',
            'diskspace',
            'diskspace_used',
            'traffic',
            'traffic_used',
            'deactivated',
        ]),
        'actions' => [
            'delete' => [
                'icon' => 'fa fa-trash',
                'href' => '#',
            ],
            'show' => [
                'text' => 'Show',
                'href' => '#',
            ]
        ],
        'contextual_class' => [
            'deactivated' => [
                'value' => true,
                'return' => 'bg-secondary'
            ],
            'diskspace_used' => [
                'column' => 'diskspace',
                'operator' => '>=',
                'return' => 'bg-danger'
            ],
            'traffic_used' => [
                'column' => 'traffic',
                'operator' => '>=',
                'return' => 'bg-danger'
            ],
        ]
    ]
];
