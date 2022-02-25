<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
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
return array(
	'backup' => array(
		'title' => $lng['extras']['backup'],
		'image' => 'fa-solid fa-server',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['extras']['backup'],
				'image' => 'icons/backup_big.png',
				'fields' => array(
					'path' => array(
						'label' => $lng['panel']['backuppath']['title'],
						'desc' => $lng['panel']['backuppath']['description'] . '<br>' . (\Froxlor\Settings::Get('panel.pathedit') != 'Dropdown' ? $lng['panel']['pathDescription'] : null),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['select_var'] ?? '',
						'value' => $pathSelect['value'],
						'note' => $pathSelect['note'] ?? '',
					),
					'path_protection_info' => array(
						'label' => $lng['extras']['path_protection_label'],
						'type' => 'infotext',
						'value' => $lng['extras']['path_protection_info'],
						'classes' => 'fw-bold text-danger'
					),
					'backup_web' => array(
						'label' => $lng['extras']['backup_web'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'backup_mail' => array(
						'label' => $lng['extras']['backup_mail'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					),
					'backup_dbs' => array(
						'label' => $lng['extras']['backup_dbs'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => true
					)
				)
			)
		)
	)
);
