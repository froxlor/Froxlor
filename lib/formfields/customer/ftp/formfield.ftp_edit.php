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
 * @package    Formfields
 */

return array(
	'ftp_edit' => array(
		'title' => $lng['ftp']['account_edit'],
		'image' => 'icons/user_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['ftp']['account_edit'],
				'image' => 'icons/user_edit.png',
				'fields' => array(
					'username' => array(
						'label' => $lng['login']['username'],
						'type' => 'label',
						'value' => $result['username'],
					),
					'path' => array(
						'label' => $lng['panel']['path'],
						'desc' => ($settings['panel']['pathedit'] != 'Dropdown' ? $lng['panel']['pathDescription'] : null).(isset($pathSelect['note']) ? '<br />'.$pathSelect['value'] : ''),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['value'],
						'value' => $pathSelect['value']
					),
					'ftp_password' => array(
						'label' => $lng['login']['password'],
						'desc' => $lng['ftp']['editpassdescription'],
						'type' => 'password',
						'autocomplete' => 'off'
					),
					'ftp_password_suggestion' => array(
						'label' => $lng['customer']['generated_pwd'],
						'type' => 'text',
						'value' => generatePassword(),
					)
				)
			)
		)
	)
);
