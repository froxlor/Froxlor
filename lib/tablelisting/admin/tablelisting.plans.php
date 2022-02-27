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
use Froxlor\UI\Listing;

return [
	'plan_list' => [
		'title' => $lng['admin']['plans']['plans'],
		'icon' => 'fa-solid fa-user',
		'columns' => [
			'p.name' => [
				'label' => $lng['admin']['plans']['name'],
				'field' => 'name',
			],
			'p.description' => [
				'label' => $lng['admin']['plans']['description'],
				'field' => 'description',
			],
			'p.adminname' => [
				'label' => $lng['admin']['admin'],
				'field' => 'adminname',
			],
			'p.ts' => [
				'label' => $lng['admin']['plans']['last_update'],
				'field' => 'ts',
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('sslcertificates_list', [
			'p.name',
			'p.description',
			'p.adminname',
			'p.ts',
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'href' => [
					'section' => 'plans',
					'page' => 'overview',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'class' => 'text-danger',
				'href' => [
					'section' => 'plans',
					'page' => 'overview',
					'action' => 'delete',
					'id' => ':id'
				],
			],
		]
	]
];
