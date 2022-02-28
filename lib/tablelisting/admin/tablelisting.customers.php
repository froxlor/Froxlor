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

use Froxlor\UI\Callbacks\Customer;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Callbacks\Impersonate;
use Froxlor\UI\Callbacks\ProgressBar;
use Froxlor\UI\Listing;

return [
	'customer_list' => [
		'title' => $lng['admin']['customers'],
		'icon' => 'fa-solid fa-user',
		'columns' => [
			'c.name' => [
				'label' => $lng['customer']['name'],
				'field' => 'name',
				'format_callback' => [Text::class, 'customerfullname'],
			],
			'c.loginname' => [
				'label' => $lng['login']['username'],
				'field' => 'loginname',
				'format_callback' => [Impersonate::class, 'customer'],
			],
			'a.loginname' => [
				'label' => $lng['admin']['admin'],
				'field' => 'admin.loginname',
				'format_callback' => [Impersonate::class, 'admin'],
			],
			'c.email' => [
				'label' => $lng['customer']['email'],
				'field' => 'email',
			],
			'c.diskspace' => [
				'label' => $lng['customer']['diskspace'],
				'field' => 'diskspace',
				'format_callback' => [ProgressBar::class, 'diskspace'],
			],
			'c.traffic' => [
				'label' => $lng['customer']['traffic'],
				'field' => 'traffic',
				'format_callback' => [ProgressBar::class, 'traffic'],
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('customer_list', [
			'c.name',
			'c.loginname',
			'a.loginname',
			'c.email',
			'c.diskspace',
			'c.traffic',
		]),
		'actions' => [
			'unlock' => [
				'icon' => 'fa fa-unlock',
				'title' => $lng['panel']['unlock'],
				'class' => 'text-warning',
				'href' => [
					'section' => 'customers',
					'page' => 'customers',
					'action' => 'unlock',
					'id' => ':customerid'
				],
				'visible' => [Customer::class, 'isLocked']
			],
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'customers',
					'page' => 'customers',
					'action' => 'edit',
					'id' => ':customerid'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'text-danger',
				'href' => [
					'section' => 'customers',
					'page' => 'customers',
					'action' => 'delete',
					'id' => ':customerid'
				],
			],
		],
	]
];
