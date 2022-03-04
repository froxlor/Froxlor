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
use Froxlor\UI\Callbacks\SysLog;
use Froxlor\UI\Listing;

return [
	'syslog_list' => [
		'title' => $lng['menue']['logger']['logger'],
		'icon' => 'fa-solid fa-file-lines',
		'columns' => [
			'date' => [
				'label' => $lng['logger']['date'],
				'field' => 'date',
				'callback' => [Text::class, 'timestamp'],
			],
			'type' => [
				'label' => $lng['logger']['type'],
				'field' => 'type',
				'callback' => [SysLog::class, 'typeDescription'],
			],
			'user' => [
				'label' => $lng['logger']['user'],
				'field' => 'user',
			],
			'text' => [
				'label' => $lng['logger']['action'],
				'field' => 'text',
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('syslog_list', [
			'date',
			'type',
			'user',
			'text'
		])
	]
];
