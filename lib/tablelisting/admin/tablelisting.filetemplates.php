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

use Froxlor\UI\Listing;

return [
	'filetpl_list' => [
		'title' => $lng['admin']['templates']['filetemplates'],
		'icon' => 'fa-solid fa-file-lines',
		'columns' => [
			'template' => [
				'label' => $lng['admin']['templates']['action'],
				'field' => 'template'
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('filetpl_list', [
			'template'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'templates',
					'page' => $page,
					'action' => 'editf',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'text-danger',
				'href' => [
					'section' => 'templates',
					'page' => $page,
					'action' => 'deletef',
					'id' => ':id'
				],
			],
		],
	]
];
