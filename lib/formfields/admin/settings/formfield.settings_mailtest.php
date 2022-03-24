<?php

use Froxlor\Settings;

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
	'mailtest' => array(
		'title' => $lng['admin']['testmail'],
		'image' => 'fa-solid fa-paper-plane',
		'sections' => array(
			'section_a' => array(
				'fields' => array(
					'smtp_user' => array(
						'label' => $lng['serversettings']['mail_smtp_user'],
						'type' => 'label',
						'value' => (empty(Settings::Get('system.mail_smtp_user')) ? $lng['panel']['unspecified'] : Settings::Get('system.mail_smtp_user'))
					),
					'smtp_host' => array(
						'label' => $lng['serversettings']['mail_smtp_host'],
						'type' => 'label',
						'value' => (empty(Settings::Get('system.mail_smtp_host')) ? $lng['panel']['unspecified'] : Settings::Get('system.mail_smtp_host'))
					),
					'smtp_port' => array(
						'label' => $lng['serversettings']['mail_smtp_port'],
						'type' => 'label',
						'value' => (empty(Settings::Get('system.mail_smtp_port')) ? $lng['panel']['unspecified'] : Settings::Get('system.mail_smtp_port'))
					),
					'smtp_auth' => array(
						'label' => $lng['serversettings']['mail_smtp_auth'],
						'type' => 'checkbox',
						'value' => 1,
						'checked' => (bool) Settings::Get('system.mail_use_smtp'),
						'disabled' => true
					),
					'smtp_tls' => array(
						'label' => $lng['serversettings']['mail_smtp_usetls'],
						'type' => 'checkbox',
						'value' => 1,
						'checked' => (bool) Settings::Get('system.mail_smtp_usetls'),
						'disabled' => true
					),
					'test_addr' => array(
						'label' => $lng['admin']['smtptestaddr'],
						'type' => 'email',
						'mandatory' => true
					)
				)
			)
		)
	)
);
