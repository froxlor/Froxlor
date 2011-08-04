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
                'title' => $lng['mysql']['database_create'],
                'image' => 'icons/mysql_add.png',
                'sections' => array(
                        'section_a' => array(
                                'title' => $lng['mysql']['database_create'],
                                'image' => 'icons/mysql_add.png',
                                'fields' => array(
					'description' => array(
						'label' => $lng['mysql']['databasedescription'],
						'type' => 'text',
					),
					'mysql_server' => array(
						'visible' => (1 < count($sql_root) ? true : false),
						'label' => $lng['mysql']['mysql_server'],
						'type' => 'select',
						'select_var' => $mysql_servers,
					),
					'mysql_password' => array(
						'label' => $lng['login']['password'],
						'type' => 'password',
						'autocomplete' => 'off'
					),
					'mysql_password_suggestion' => array(
						'label' => $lng['customer']['generated_pwd'],
						'type' => 'text',
						'value' => generatePassword(),
					),
					'sendinfomail' => array(
						'label' => $lng['customer']['sendinfomail'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array()
					)
				)
			)
		)
	)
);
