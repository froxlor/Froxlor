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

use Froxlor\UI\Callbacks\Ftp;
use Froxlor\UI\Listing;

return [
	'htpasswd_list' => [
		'title' => $lng['menue']['extras']['directoryprotection'],
		'icon' => 'fa-solid fa-lock',
		'columns' => [
			'username' => [
				'label' => $lng['login']['username'],
				'field' => 'username'
			],
			'path' => [
				'label' => $lng['panel']['path'],
				'field' => 'path',
				'callback' => [Ftp::class, 'pathRelative']
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('htpasswd_list', [
			'username',
			'path'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'extras',
					'page' => 'htpasswds',
					'action' => 'edit',
					'id' => ':id'
				],
			],
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['delete'],
				'class' => 'text-danger',
				'href' => [
					'section' => 'extras',
					'page' => 'htpasswds',
					'action' => 'delete',
					'id' => ':id'
				],
			]
		]
	]
];
