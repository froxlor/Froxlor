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

use Froxlor\UI\Callbacks\Admin;
use Froxlor\UI\Callbacks\ProgressBar;
use Froxlor\UI\Callbacks\Style;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Callbacks\Impersonate;
use Froxlor\UI\Listing;

return [
	'admin_list' => [
		'title' => $lng['admin']['admin'],
		'icon' => 'fa-solid fa-user',
		'columns' => [
			'adminid' => [
				'label' => '#',
				'field' => 'adminid',
				'sortable' => true,
			],
			'loginname' => [
				'label' => $lng['login']['username'],
				'field' => 'loginname',
				'callback' => [Impersonate::class, 'admin'],
				'sortable' => true,
			],
			'name' => [
				'label' => $lng['customer']['name'],
				'field' => 'name',
			],
			'customers_used' => [
				'label' => $lng['admin']['customers'],
				'field' => 'customers_used',
				'class' => 'text-center',
			],
			'diskspace' => [
				'label' => $lng['customer']['diskspace'],
				'field' => 'diskspace',
				'callback' => [ProgressBar::class, 'diskspace'],
			],
			'traffic' => [
				'label' => $lng['customer']['traffic'],
				'field' => 'traffic',
				'callback' => [ProgressBar::class, 'traffic'],
			],
			'deactivated' => [
				'label' => $lng['admin']['deactivated'],
				'field' => 'deactivated',
				'class' => 'text-center',
				'callback' => [Text::class, 'boolean'],
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
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'admins',
					'page' => 'admins',
					'action' => 'edit',
					'id' => ':adminid'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'btn-danger',
				'href' => [
					'section' => 'admins',
					'page' => 'admins',
					'action' => 'delete',
					'id' => ':adminid'
				],
				'visible' => [Admin::class, 'isNotMe']
			],
		],
		'format_callback' => [
			[Style::class, 'deactivated'],
			[Style::class, 'diskspaceWarning'],
			[Style::class, 'trafficWarning']
		]
	]
];
