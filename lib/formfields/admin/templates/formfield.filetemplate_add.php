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
	'filetemplate_add' => array(
		'title' => $lng['admin']['templates']['template_add'],
		'image' => 'fa-solid fa-plus',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['templates']['template_add'],
				'image' => 'icons/templates_add.png',
				'fields' => array(
					'template' => array(
						'label' => $lng['admin']['templates']['action'],
						'type' => 'select',
						'select_var' => $free_templates
					),
					'filecontent' => array(
						'label' => $lng['admin']['templates']['filecontent'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					),
					'filesend' => array(
						'type' => 'hidden',
						'value' => 'filesend'
					)
				)
			)
		)
	),
	'filetemplate_replacers' => [
		'replacers' => [
			[
				'var' => 'SERVERNAME',
				'description' => $lng['admin']['templates']['SERVERNAME']
			],
			[
				'var' => 'CUSTOMER',
				'description' => $lng['admin']['templates']['CUSTOMER']
			],
			[
				'var' => 'ADMIN',
				'description' => $lng['admin']['templates']['ADMIN']
			],
			[
				'var' => 'CUSTOMER_EMAIL',
				'description' => $lng['admin']['templates']['CUSTOMER_EMAIL']
			],
			[
				'var' => 'ADMIN_EMAIL',
				'description' => $lng['admin']['templates']['ADMIN_EMAIL']
			]
		]
	]
);
