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
	'mysql_edit' => [
		'title' => lng('mysql.database_edit'),
		'image' => 'icons/mysql_edit.png',
		'self_overview' => ['section' => 'mysql', 'page' => 'mysqls'],
		'sections' => [
			'section_a' => [
				'title' => lng('mysql.database_edit'),
				'image' => 'icons/mysql_edit.png',
				'fields' => [
					'databasename' => [
						'label' => lng('mysql.databasename'),
						'type' => 'label',
						'value' => $result['databasename']
					],
					'mysql_server' => [
						'visible' => count($mysql_servers) > 1,
						'type' => 'hidden',
						'value' => $result['dbserver'] ?? 0,
					],
					'mysql_server_info' => [
						'visible' => count($mysql_servers) > 1,
						'label' => lng('mysql.mysql_server'),
						'type' => 'label',
						'disabled' => true,
						'value' => $mysql_servers[$result['dbserver']] ?? 'unknown db server',
					],
					'description' => [
						'label' => lng('mysql.databasedescription'),
						'type' => 'text',
						'value' => $result['description']
					],
					'mysql_password' => [
						'label' => lng('changepassword.new_password_ifnotempty'),
						'type' => 'password',
						'autocomplete' => 'off'
					],
					'mysql_password_suggestion' => [
						'label' => lng('customer.generated_pwd'),
						'type' => 'text',
						'visible' => (Settings::Get('panel.password_regex') == ''),
						'value' => Crypt::generatePassword(),
						'readonly' => true
					]
				]
			]
		]
	]
];
