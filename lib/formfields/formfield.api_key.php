<?php

use Froxlor\UI\Panel\UI;

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
 * @package    Formfields
 *
 */
return [
	'apikey' => [
		'title' => UI::getLng('menue.main.apikeys'),
		'sections' => [
			'section_a' => [
				'fields' => [
					'loginname' => [
						'label' => UI::getLng('login.username'),
						'type' => 'label',
						'value' => $result['loginname'] ?? $result['adminname']
					],
					'apikey' => [
						'label' => 'API key',
						'type' => 'text',
						'readonly' => true,
						'value' => $result['apikey']
					],
					'secret' => [
						'label' => 'Secret',
						'type' => 'text',
						'readonly' => true,
						'value' => $result['secret']
					],
					'allowed_from' => [
						'label' => UI::getLng('apikeys.allowed_from'),
						'type' => 'text',
						'value' => $result['allowed_from'],
					],
					'valid_until' => [
						'label' => UI::getLng('apikeys.valid_until'),
						'type' => 'text',
						'value' => $result['valid_until'],
						'format_callback' => [Text::class, 'timestampUntil'],
					]
				]
			]
		]
	]
];
