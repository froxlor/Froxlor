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

use Froxlor\UI\Callbacks\Ftp;
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'backup_list' => [
		'title' => $lng['error']['customerhasongoingbackupjob'],
		'icon' => 'fa-solid fa-server',
		'columns' => [
			'destdir' => [
				'label' => $lng['panel']['path'],
				'field' => 'data.destdir',
				'callback' => [Ftp::class, 'pathRelative']
			],
			'backup_web' => [
				'label' => $lng['extras']['backup_web'],
				'field' => 'data.backup_web',
				'callback' => [Text::class, 'boolean'],
			],
			'backup_mail' => [
				'label' => $lng['extras']['backup_mail'],
				'field' => 'data.backup_mail',
				'callback' => [Text::class, 'boolean'],
			],
			'backup_dbs' => [
				'label' => $lng['extras']['backup_dbs'],
				'field' => 'data.backup_dbs',
				'callback' => [Text::class, 'boolean'],
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('backup_list', [
			'destdir',
			'backup_web',
			'backup_mail',
			'backup_dbs'
		]),
		'actions' => [
			'delete' => [
				'icon' => 'fa fa-trash',
				'title' => $lng['panel']['abort'],
				'class' => 'btn-warning',
				'href' => [
					'section' => 'extras',
					'page' => 'backup',
					'action' => 'abort',
					'id' => ':id'
				],
			]
		]
	]
];
