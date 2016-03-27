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
	'emails_accountchangename' => array(
		'title' => $lng['menue']['main']['changepassword'],
		'image' => 'icons/email_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['menue']['main']['changepassword'],
				'image' => 'icons/email_edit.png',
				'fields' => array(
					'email_full' => array(
						'label' => $lng['emails']['emailaddress'],
						'type' => 'label',
						'value' => $result['email_full']
					),
					'owner_lastname' => array(
						'label' => $lng['customer']['name'],
						'type'  => 'text',
						'value' => $result['lastname'],
					),
					'owner_firstname' => array(
						'label' => $lng['customer']['firstname'], 
						'type' => 'text',
						'value' => $result['firstname'],
					),
				)
			)
		)
	)
);
