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
 *
 */

return array(
	'section_a' => array(
		'fields' => array(
			'description' => array(
				'label' => $lng['mysql']['databasedescription'],
				'type' => 'text',
			),
			'mysql_server' => array(
				'label' => $lng['mysql']['mysql_server'],
				'type' => (isset($result)) ? 'select' : 'text',
				'visible' => (1 < $count_mysqlservers ? true : false),
		
			),
			'mysql_password' => array(
				'label' => $lng['login']['password'],
				'type' => 'password',
				'attributes' => array(
					'autocomplete' => 'off'
				)
			),
			'mysql_password_suggestion' => array(
				'label' => $lng['customer']['generated_pwd'],
				'type' => 'text',
				'visible' => (Settings::Get('panel.password_regex') == ''),
				'value' => generatePassword(),
				'attributes' => array(
					'readonly' => true
				)
			),
			'sendinfomail' => array(
				'label' => $lng['customer']['sendinfomail'],
				'type' => 'checkbox',
				'visible' => 'new',
				'attributes' => array(
					'checked' => true
				)
			)
		)
	)
);