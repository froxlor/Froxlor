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
	'autoresponder_edit' => array(
		'title' => $lng['autoresponder']['autoresponder_edit'],
		'image' => 'icons/autoresponder_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['autoresponder']['autoresponder_edit'],
				'image' => 'icons/autoresponder_edit.png',
				'fields' => array(
					'account' => array(
						'label' => $lng['autoresponder']['account'],
						'type' => 'label',
						'value' => $email,
					),
					'active' => array(
						'label' => $lng['autoresponder']['active'],
						'type' => 'checkbox',
						'values' => array(
										array ('label' => $lng['panel']['yes'], 'value' => '1')
									),
						'value' => array($row['enabled'])
					),
					'date_from' => array(
						'label' => $lng['autoresponder']['date_from'] . " (dd-mm-yyyy)",
						'type' => 'textul',
						'maxlength' => 10,
						'ul_field' => $date_from_off,
						'value' => $date_from,
					),
					'date_until' => array(
						'label' => $lng['autoresponder']['date_until'] . " (dd-mm-yyyy)",
						'type' => 'textul',
						'maxlength' => 10,
						'ul_field' => $date_until_off,
						'value' => $date_until,
					),
					'subject' => array(
						'label' => $lng['autoresponder']['subject'],
						'type' => 'text',
						'value' => $subject
					),
					'message' => array(
						'style' => 'vertical-align:top;',
						'label' => $lng['autoresponder']['message'],
						'type' => 'textarea',
						'cols' => 60,
						'rows' => 12,
						'value' => $message,
					)
				)
			)
		)
	)
);
