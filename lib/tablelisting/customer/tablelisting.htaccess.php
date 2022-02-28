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
use Froxlor\UI\Callbacks\Text;
use Froxlor\UI\Listing;

return [
	'htaccess_list' => [
		'title' => $lng['menue']['extras']['pathoptions'],
		'icon' => 'fa-solid fa-folder',
		'columns' => [
			'path' => [
				'label' => $lng['panel']['path'],
				'field' => 'path',
				'callback' => [Ftp::class, 'pathRelative']
			],
			'option_indexes' => [
				'label' => $lng['extras']['view_directory'],
				'field' => 'option_indexes',
				'callback' => [Text::class, 'boolean']
			],
			'error404path' => [
				'label' => $lng['extras']['error404path'],
				'field' => 'error404path'
			],
			'error403path' => [
				'label' => $lng['extras']['error403path'],
				'field' => 'error403path'
			],
			'error500path' => [
				'label' => $lng['extras']['error500path'],
				'field' => 'error500path'
			],
			'options_cgi' => [
				'label' => $lng['extras']['execute_perl'],
				'field' => 'options_cgi',
				'callback' => [Text::class, 'boolean'],
				'visible' => $cperlenabled
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('htaccess_list', [
			'path',
			'option_indexes',
			'error404path',
			'error403path',
			'error500path',
			'options_cgi'
		]),
		'actions' => [
			'edit' => [
				'icon' => 'fa fa-edit',
				'title' => $lng['panel']['edit'],
				'href' => [
					'section' => 'extras',
					'page' => 'htaccess',
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
					'page' => 'htaccess',
					'action' => 'delete',
					'id' => ':id'
				],
			]
		]
	]
];
