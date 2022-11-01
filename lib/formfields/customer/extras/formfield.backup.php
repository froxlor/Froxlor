<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author         Froxlor team <team@froxlor.org> (2010-)
 * @license        GPLv2 https://files.froxlor.org/misc/COPYING.txt
 * @package        Formfields
 *
 */

use Froxlor\Settings;

return [
	'backup' => [
		'title' => lng('extras.backup'),
		'image' => 'fa-solid fa-server',
		'sections' => [
			'section_a' => [
				'title' => lng('extras.backup'),
				'image' => 'icons/backup_big.png',
				'fields' => [
					'path' => [
						'label' => lng('panel.backuppath.title'),
						'desc' => lng('panel.backuppath.description') . '<br>' . (Settings::Get('panel.pathedit') != 'Dropdown' ? lng('panel.pathDescription') : null),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['select_var'] ?? '',
						'selected' => $pathSelect['value'],
						'value' => $pathSelect['value'],
						'note' => $pathSelect['note'] ?? '',
					],
					'path_protection_info' => [
						'label' => lng('extras.path_protection_label'),
						'type' => 'infotext',
						'value' => lng('extras.path_protection_info'),
						'classes' => 'fw-bold text-danger'
					],
					'backup_web' => [
						'label' => lng('extras.backup_web'),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					],
					'backup_mail' => [
						'label' => lng('extras.backup_mail'),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					],
					'backup_dbs' => [
						'label' => lng('extras.backup_dbs'),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					]
				]
			]
		]
	]
];
