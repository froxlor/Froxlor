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
use Froxlor\UI\Callbacks\Style;
use Froxlor\UI\Listing;

return [
	'integrity_list' => [
		'title' => $lng['admin']['integritycheck'],
		'icon' => 'fa-solid fa-circle-check',
		'columns' => [
			'displayid' => [
				'label' => $lng['admin']['integrityid'],
				'field' => 'displayid'
			],
			'checkdesc' => [
				'label' => $lng['admin']['integrityname'],
				'field' => 'checkdesc'
			],
			'result' => [
				'label' => $lng['admin']['integrityresult'],
				'field' => 'result',
				'callback' => [Text::class, 'boolean']
			]
		],
		'visible_columns' => Listing::getVisibleColumnsForListing('integrity_list', [
			'displayid',
			'checkdesc',
			'result'
		]),
		'format_callback' => [
			[Style::class, 'resultIntegrityBad']
		]
	]
];
