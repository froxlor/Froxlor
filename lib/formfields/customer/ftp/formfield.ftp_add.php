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
	'ftp_add' => array(
		'title' => $lng['ftp']['account_add'],
		'image' => 'icons/user_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['ftp']['account_add'],
				'image' => 'icons/user_add.png',
				'fields' => array(
					'ftp_username' => array(
						'visible' => \Froxlor\Settings::Get('customer.ftpatdomain') == '1',
						'label' => $lng['login']['username'],
						'type' => 'text',
						'next_to' => (\Froxlor\Settings::Get('customer.ftpatdomain') == '1' && count($domainlist) > 0 ? [
							'ftp_domain' => array(
								'next_to_prefix' => '@',
								'label' => $lng['domains']['domainname'],
								'type' => 'select',
								'select_var' => $domainlist
							),
						]
						: [])
					),
					'ftp_description' => array(
						'label' => $lng['panel']['ftpdesc'],
						'type' => 'text'
					),
					'path' => array(
						'label' => $lng['panel']['path'],
						'desc' => (\Froxlor\Settings::Get('panel.pathedit') != 'Dropdown' ? $lng['panel']['pathDescription'] : null),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['select_var'] ?? '',
						'value' => $pathSelect['value'],
						'note' => $pathSelect['note'] ?? '',
					),
					'ftp_password' => array(
						'label' => $lng['login']['password'],
						'type' => 'password',
						'autocomplete' => 'off'
					),
					'ftp_password_suggestion' => array(
						'label' => $lng['customer']['generated_pwd'],
						'type' => 'text',
						'visible' => (\Froxlor\Settings::Get('panel.password_regex') == ''),
						'value' => \Froxlor\System\Crypt::generatePassword()
					),
					'sendinfomail' => array(
						'label' => $lng['customer']['sendinfomail'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'shell' => array(
						'visible' => \Froxlor\Settings::Get('system.allow_customer_shell') == '1',
						'label' => $lng['panel']['shell'],
						'type' => 'select',
						'select_var' => $shells_avail,
						'selected' => '/bin/false'
					)
				)
			)
		)
	)
);
