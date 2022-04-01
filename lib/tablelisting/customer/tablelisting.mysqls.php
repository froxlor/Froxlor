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

use Froxlor\UI\Callbacks\Mysql;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'mysql_list' => [
		'title' => $lng['menue']['mysql']['databases'],
		'icon' => 'fa-solid fa-database',
		'self_overview' => ['section' => 'mysql', 'page' => 'mysqls'],
		'columns' => [
			'databasename' => [
				'label' => $lng['mysql']['databasename'],
				'field' => 'databasename',
			],
			'description' => [
				'label' => $lng['mysql']['databasedescription'],
				'field' => 'description'
			],
			'size' => [
				'label' => $lng['mysql']['size'],
				'field' => 'size',
				'callback' => [Text::class, 'size']
			],
			'dbserver' => [
				'label' => $lng['mysql']['mysql_server'],
				'field' => 'dbserver',
				'callback' => [Mysql::class, 'dbserver'],
				'visible' => $count_mysqlservers > 1
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('mysql_list', [
			'databasename',
			'description',
			'size',
			'dbserver'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'mysql',
					'page' => 'mysqls',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'btn-danger',
				'href' => [
					'section' => 'mysql',
					'page' => 'mysqls',
					'action' => 'delete',
					'id' => ':id'
				],
			]
		]
	]
];
