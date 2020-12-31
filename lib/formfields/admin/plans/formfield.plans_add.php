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
	'plans_add' => array(
		'title' => $lng['admin']['plans']['add'],
		'image' => 'icons/templates_add_big.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['plans']['plan_details'],
				'image' => 'icons/templates_add_big.png',
				'fields' => array(
					'name' => array(
						'label' => $lng['admin']['plans']['name'],
						'type' => 'text'
					),
					'description' => array(
						'label' => $lng['admin']['plans']['description'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					)
				)
			)
		)
	)
);
