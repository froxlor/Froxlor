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

use Froxlor\UI\Callbacks\ProgressBar;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

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
			'customers_used' => [
				'label' => $lng['admin']['customers'],
				'column' => 'customers_used',
				'class' => 'text-center',
			],
			'diskspace' => [
				'label' => $lng['customer']['diskspace'],
				'column' => 'diskspace',
				'format_callback' => [ProgressBar::class, 'diskspace'],
			],
			'traffic' => [
				'label' => $lng['customer']['traffic'],
				'column' => 'traffic',
				'format_callback' => [ProgressBar::class, 'traffic'],
			],
			'deactivated' => [
				'label' => $lng['admin']['deactivated'],
				'column' => 'deactivated',
				'class' => 'text-center',
				'format_callback' => [Text::class, 'boolean'],
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('admin_list', [
			'loginname',
			'name',
			'customers_used',
			'diskspace',
			'traffic',
			'deactivated',
		]),
		'actions' => [
			'edit' => [
                'icon' => 'fa fa-edit',
				'href' => [
                    'section' => 'admins',
                    'page' => 'admins',
                    'action' => 'edit',
                    'id' => ':adminid'
                ],
			],
            'delete' => [
                'icon' => 'fa fa-trash',
                'class' => 'text-danger',
                'href' => [
                    'section' => 'admins',
                    'page' => 'admins',
                    'action' => 'delete',
                    'id' => ':adminid'
                ],
            ],
		],
		'contextual_class' => [
			'deactivated' => [
				'value' => true,
				'return' => 'bg-secondary'
			]
		]
	]
];
