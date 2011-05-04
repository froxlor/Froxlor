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
	'autoresponder_add' => array(
		'title' => $lng['autoresponder']['autoresponder_new'],
		'image' => 'icons/autoresponder_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['autoresponder']['autoresponder_new'],
				'image' => 'icons/autoresponder_add.png',
				'fields' => array(
					'account' => array(
						'label' => $lng['autoresponder']['account'],
						'type' => 'select',
						'select_var' => $accounts,
					),
					'active' => array(
						'label' => $lng['autoresponder']['active'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array('1')
					),
					'date_from' => array(
						'label' => $lng['autoresponder']['date_from'] . " (dd-mm-yyyy)",
						'type' => 'textul',
						'maxlength' => 10,
						'ul_field' => $date_from_off,
					),
					'date_until' => array(
						'label' => $lng['autoresponder']['date_until'] . " (dd-mm-yyyy)",
						'type' => 'textul',
						'maxlength' => 10,
						'ul_field' => $date_until_off,
					),
					'subject' => array(
						'label' => $lng['autoresponder']['subject'],
						'type' => 'text',
					),
					'message' => array(
						'style' => 'vertical-align:top;',
						'label' => $lng['autoresponder']['message'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12
					)
				)
			)
		)
	)
);
