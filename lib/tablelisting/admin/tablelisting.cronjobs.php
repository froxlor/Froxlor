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
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Tabellisting
 *
 */

use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'cron_list' => [
		'title' => $lng['admin']['cron']['cronsettings'],
		'icon' => 'fa-solid fa-clock-rotate-left',
		'columns' => [
			'c.description' => [
				'label' => $lng['cron']['description'],
				'field' => 'desc_lng_key',
				'callback' => [Text::class, 'crondesc']
			],
			'c.lastrun' => [
				'label' => $lng['cron']['lastrun'],
				'field' => 'lastrun',
				'callback' => [Text::class, 'timestamp']
			],
			'c.interval' => [
				'label' => $lng['cron']['interval'],
				'field' => 'interval'
			],
			'c.isactive' => [
				'label' => $lng['cron']['isactive'],
				'field' => 'isactive',
				'callback' => [Text::class, 'boolean']
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('cron_list', [
			'c.description',
			'c.lastrun',
			'c.interval',
			'c.isactive',
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'cronjobs',
					'page' => 'overview',
					'action' => 'edit',
					'id' => ':id'
				],
			]
		]
	]
];
