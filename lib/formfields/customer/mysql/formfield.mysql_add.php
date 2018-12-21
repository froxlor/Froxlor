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
	'mysql_add' => array(
		'title' => \Froxlor\I18N\Lang::getAll()['mysql']['database_create'],
		'image' => 'icons/mysql_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => \Froxlor\I18N\Lang::getAll()['mysql']['database_create'],
				'image' => 'icons/mysql_add.png',
				'fields' => array(
					'description' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['mysql']['databasedescription'],
						'type' => 'text'
					),
					'mysql_server' => array(
						'visible' => (1 < $count_mysqlservers ? true : false),
						'label' => \Froxlor\I18N\Lang::getAll()['mysql']['mysql_server'],
						'type' => 'select',
						'select_var' => $mysql_servers
					),
					'mysql_password' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['login']['password'],
						'type' => 'password',
						'autocomplete' => 'off'
					),
					'mysql_password_suggestion' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['generated_pwd'],
						'type' => 'text',
						'visible' => (\Froxlor\Settings::Get('panel.password_regex') == ''),
						'value' => \Froxlor\System\Crypt::generatePassword()
					),
					'sendinfomail' => array(
						'label' => \Froxlor\I18N\Lang::getAll()['customer']['sendinfomail'],
						'type' => 'checkbox',
						'values' => array(
							array(
								'label' => \Froxlor\I18N\Lang::getAll()['panel']['yes'],
								'value' => '1'
							)
						),
						'value' => array()
					)
				)
			)
		)
	)
);
