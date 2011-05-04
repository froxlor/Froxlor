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
	'ticket_new' => array(
		'title' => $lng['ticket']['ticket_new'],
		'image' => 'icons/ticket_new.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['ticket']['ticket_new'],
				'image' => 'icons/ticket_new.png',
				'fields' => array(
					'customer' => array(
						'label' => $lng['ticket']['customer'],
						'type' => 'select',
						'select_var' => $customers
					),
					'subject' => array(
						'label' => $lng['ticket']['subject'],
						'type' => 'text',
						'maxlength' => 70
					),
					'priority' => array(
						'label' => $lng['ticket']['priority'],
						'type' => 'select',
						'select_var' => $priorities
					),
					'category' => array(
						'label' => $lng['ticket']['category'],
						'type' => 'select',
						'select_var' => $categories
					),
					'message' => array(
						'style' => 'vertical-align:top;',
						'label' => $lng['ticket']['message'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					)
				)
			)
		)
	)
);
