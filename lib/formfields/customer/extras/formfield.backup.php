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
		'image' => 'icons/backup_big.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['extras']['backup'],
				'image' => 'icons/backup_big.png',
				'fields' => array(
					'path' => array(
						'label' => $lng['panel']['backuppath']['title'],
						'desc' => $lng['panel']['backuppath']['description'].'<br>'.(Settings::Get('panel.pathedit') != 'Dropdown' ? $lng['panel']['pathDescription'] : null).(isset($pathSelect['note']) ? '<br />'.$pathSelect['value'] : ''),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['value'],
						'value' => $pathSelect['value']
					),
					'path_protection_info' => array(
						'label' => $lng['extras']['path_protection_label'],
						'type' => 'label',
						'value' => $lng['extras']['path_protection_info']
					),
					'backup_web' => array(
						'label' => $lng['extras']['backup_web'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array('1')
					),
					'backup_mail' => array(
						'label' => $lng['extras']['backup_mail'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array('1')
					),
					'backup_dbs' => array(
						'label' => $lng['extras']['backup_dbs'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => $lng['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array('1')
					)
				)
			)
		)
	)
);
