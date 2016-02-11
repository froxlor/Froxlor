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
	'emails_add' => array(
		'title' => $lng['emails']['emails_add'],
		'image' => 'icons/email_add.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['emails']['emails_add'],
				'image' => 'icons/email_add.png',
				'fields' => array(
					'email_part' => array(
						'label' => $lng['emails']['emailaddress'],
						'type' => 'textul',
						'ul_field' => '',
						'has_nextto' => true
					),
					'domain' => array(
						'next_to' => 'email_part',
						'next_to_prefix' => '&nbsp;@&nbsp;',
						'type' => 'select',
						'select_var' => $domains
					),
					'iscatchall' => array(
						'label' => $lng['emails']['iscatchall'],
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
