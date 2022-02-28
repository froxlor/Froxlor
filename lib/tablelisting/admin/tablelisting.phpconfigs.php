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

use Froxlor\UI\Callbacks\PHPConf;
use Froxlor\UI\Listing;
use Froxlor\Settings;

return [
	'phpconf_list' => [
		'title' => $lng['menue']['phpsettings']['maintitle'],
		'icon' => 'fa-brands fa-php',
		'columns' => [
			'c.description' => [
				'label' => $lng['admin']['phpsettings']['description'],
				'field' => 'description',
			],
			'domains' => [
				'label' => $lng['admin']['phpsettings']['activedomains'],
				'field' => 'domains',
				'callback' => [PHPConf::class, 'domainList']
			],
			'fpmdesc' => [
				'label' => $lng['admin']['phpsettings']['fpmdesc'],
				'field' => 'fpmdesc',
				'visible' => (bool) Settings::Get('phpfpm.enabled'),
				'callback' => [PHPConf::class, 'fpmConfLink']
			],
			'c.binary' => [
				'label' => $lng['admin']['phpsettings']['binary'],
				'field' => 'binary',
				'visible' => !(bool) Settings::Get('phpfpm.enabled')
			],
			'c.file_extensions' => [
				'label' => $lng['admin']['phpsettings']['file_extensions'],
				'field' => 'file_extensions',
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('phpconf_list', [
			'c.description',
			'domains',
			'fpmdesc',
			'c.binary',
			'c.file_extensions'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'phpsettings',
					'page' => 'overview',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'text-danger',
				'href' => [
					'section' => 'phpsettings',
					'page' => 'overview',
					'action' => 'delete',
					'id' => ':id'
				],
				'visible' => [PHPConf::class, 'isNotDefault']
			]
		]
	]
];
