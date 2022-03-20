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
use Froxlor\UI\Callbacks\PHPConf;
use Froxlor\UI\Listing;

return [
	'fpmconf_list' => [
		'title' => $lng['menue']['phpsettings']['fpmdaemons'],
		'icon' => 'fa-brands fa-php',
		'columns' => [
			'description' => [
				'label' => $lng['admin']['phpsettings']['description'],
				'field' => 'description',
			],
			'configs' => [
				'label' => $lng['admin']['phpsettings']['activephpconfigs'],
				'callback' => [PHPConf::class, 'configsList']
			],
			'reload_cmd' => [
				'label' => $lng['serversettings']['phpfpm_settings']['reload'],
				'field' => 'reload_cmd'
			],
			'config_dir' => [
				'label' => $lng['serversettings']['phpfpm_settings']['configdir'],
				'field' => 'config_dir'
			],
			'pm' => [
				'label' => $lng['serversettings']['phpfpm_settings']['configdir'],
				'field' => 'pm',
			],
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('fpmconf_list', [
			'description',
			'configs',
			'reload_cmd',
			'config_dir',
			'pm'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'phpsettings',
					'page' => 'fpmdaemons',
					'action' => 'edit',
					'id' => ':id'
				],
				'visible' => [Admin::class, 'canChangeServerSettings']
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'btn-danger',
				'href' => [
					'section' => 'phpsettings',
					'page' => 'fpmdaemons',
					'action' => 'delete',
					'id' => ':id'
				],
				'visible' => [PHPConf::class, 'isNotDefault']
			]
		]
	]
];
