<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author         Froxlor team <team@froxlor.org> (2010-)
 * @license        GPLv2 https://files.froxlor.org/misc/COPYING.txt
 * @package        Formfields
 */

use Froxlor\Settings;
use Froxlor\System\Crypt;

return [
	'ftp_add' => [
		'title' => lng('ftp.account_add'),
		'image' => 'icons/user_add.png',
		'self_overview' => ['section' => 'ftp', 'page' => 'accounts'],
		'sections' => [
			'section_a' => [
				'title' => lng('ftp.account_add'),
				'image' => 'icons/user_add.png',
				'fields' => [
					'ftp_username' => [
						'visible' => Settings::Get('customer.ftpatdomain') == '1',
						'label' => lng('login.username'),
						'type' => 'text',
						'next_to' => (Settings::Get('customer.ftpatdomain') == '1' && count($domainlist) > 0 ? [
							'ftp_domain' => [
								'next_to_prefix' => '@',
								'label' => lng('domains.domainname'),
								'type' => 'select',
								'select_var' => $domainlist
							],
						]
							: [])
					],
					'ftp_description' => [
						'label' => lng('panel.ftpdesc'),
						'type' => 'text'
					],
					'path' => [
						'label' => lng('panel.path'),
						'desc' => (Settings::Get('panel.pathedit') != 'Dropdown' ? lng('panel.pathDescription') : null),
						'type' => $pathSelect['type'],
						'select_var' => $pathSelect['select_var'] ?? '',
						'selected' => $pathSelect['value'],
						'value' => $pathSelect['value'],
						'note' => $pathSelect['note'] ?? '',
						'mandatory' => true
					],
					'ftp_password' => [
						'label' => lng('login.password'),
						'type' => 'password',
						'autocomplete' => 'off',
						'mandatory' => true
					],
					'ftp_password_suggestion' => [
						'label' => lng('customer.generated_pwd'),
						'type' => 'text',
						'visible' => (Settings::Get('panel.password_regex') == ''),
						'value' => Crypt::generatePassword()
					],
					'sendinfomail' => [
						'label' => lng('customer.sendinfomail'),
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					],
					'shell' => [
						'visible' => Settings::Get('system.allow_customer_shell') == '1',
						'label' => lng('panel.shell'),
						'type' => 'select',
						'select_var' => $shells,
						'selected' => '/bin/false'
					]
				]
			]
		]
	]
];
