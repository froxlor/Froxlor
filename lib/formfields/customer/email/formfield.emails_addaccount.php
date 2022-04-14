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
	'emails_addaccount' => array(
		'title' => $lng['emails']['account_add'],
		'image' => 'fa-solid fa-plus',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['emails']['account_add'],
				'image' => 'icons/email_add.png',
				'fields' => array(
					'emailaddr' => array(
						'label' => $lng['emails']['emailaddress'],
						'type' => 'label',
						'value' => $result['email_full']
					),
					'email_password' => array(
						'label' => $lng['login']['password'],
						'type' => 'password',
						'autocomplete' => 'off',
						'next_to' => [
							'admin_password_suggestion' => array(
								'next_to_prefix' => $lng['customer']['generated_pwd'].':',
								'type' => 'text',
								'visible' => (\Froxlor\Settings::Get('panel.password_regex') == ''),
								'value' => \Froxlor\System\Crypt::generatePassword(),
								'readonly' => true
							)
						]
					),
					'email_quota' => array(
						'visible' => \Froxlor\Settings::Get('system.mail_quota_enabled') == '1',
						'label' => $lng['emails']['quota'],
						'desc' => "MiB",
						'type' => 'number',
						'value' => $quota
					),
					'alternative_email' => array(
						'visible' => \Froxlor\Settings::Get('panel.sendalternativemail') == '1',
						'label' => $lng['emails']['alternative_emailaddress'],
						'type' => 'text'
					)
				)
			)
		)
	)
);
