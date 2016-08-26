<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Settings
 *
 */

return array(
	'groups' => array(
		'security' => array(
			'title' => $lng['admin']['security_settings'],
			'fields' => array(
				'panel_unix_names' => array(
					'label' => $lng['serversettings']['unix_names'],
					'settinggroup' => 'panel',
					'varname' => 'unix_names',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField',
					),
				'system_mailpwcleartext' => array(
					'label' => $lng['serversettings']['mailpwcleartext'],
					'settinggroup' => 'system',
					'varname' => 'mailpwcleartext',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField',
					),
				'system_passwordcryptfunc' => array(
					'label' => $lng['serversettings']['passwordcryptfunc'],
					'settinggroup' => 'system',
					'varname' => 'passwordcryptfunc',
					'type' => 'option',
					'default' => 0,
					'option_mode' => 'one',
					'option_options_method' => 'getAvailablePasswordHashes',
					'save_method' => 'storeSettingField',
					),
				'system_allow_error_report_admin' => array(
					'label' => $lng['serversettings']['allow_error_report_admin'],
					'settinggroup' => 'system',
					'varname' => 'allow_error_report_admin',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'system_allow_error_report_customer' => array(
					'label' => $lng['serversettings']['allow_error_report_customer'],
					'settinggroup' => 'system',
					'varname' => 'allow_error_report_customer',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'system_allow_customer_shell' => array(
					'label' => $lng['serversettings']['allow_allow_customer_shell'],
					'settinggroup' => 'system',
					'varname' => 'allow_customer_shell',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'system_available_shells' => array(
					'label' => $lng['serversettings']['available_shells'],
					'settinggroup' => 'system',
					'varname' => 'available_shells',
					'type' => 'string',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField',
					)
				)
			)
		)
	);
