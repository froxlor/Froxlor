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
		'title' => \Froxlor\I18N\Lang::getAll()['ftp']['account_edit'],
		'image' => 'icons/user_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['ftp']['account_edit'],
				'image' => 'icons/user_edit.png',
				'fields' => array(
					'username' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['login']['username'],
						'type' => 'label',
						'value' => $result['username']
					),
					'ftp_description' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['panel']['ftpdesc'] = 'FTP description',
						'type' => 'text',
						'value' => $result['description']
					),
					'path' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['panel']['path'],
						'desc' => (\Froxlor\Settings::Get('panel.pathedit') != 'Dropdown' ? \Froxlor\I18N\Lang::getAll()['panel']['pathDescription'] : null) . (isset($pathSelect['note']) ? '<br />' . $pathSelect['value'] : ''),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['value'],
						'value' => $pathSelect['value']
					),
					'ftp_password' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['login']['password'],
						'desc' => \Froxlor\I18N\Lang::getAll()['ftp']['editpassdescription'],
						'type' => 'password',
						'autocomplete' => 'off'
					),
					'ftp_password_suggestion' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['generated_pwd'],
						'type' => 'text',
						'visible' => (\Froxlor\Settings::Get('panel.password_regex') == ''),
						'value' => \Froxlor\System\Crypt::generatePassword()
					),
					'shell' => array(
						'visible' => (\Froxlor\Settings::Get('system.allow_customer_shell') == '1' ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['panel']['shell'],
						'type' => 'select',
						'select_var' => (isset($shells) ? $shells : "")
					)
				)
			)
		)
	)
);
