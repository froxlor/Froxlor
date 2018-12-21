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
		'accounts' => array(
			'title' => \Froxlor\I18N\Lang::getAll()['admin']['accountsettings'],
			'fields' => array(
				'session_sessiontimeout' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['session_timeout'],
					'settinggroup' => 'session',
					'varname' => 'sessiontimeout',
					'type' => 'int',
					'default' => 600,
					'save_method' => 'storeSettingField'
				),
				'session_allow_multiple_login' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['session_allow_multiple_login'],
					'settinggroup' => 'session',
					'varname' => 'allow_multiple_login',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'login_domain_login' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['login_domain_login'],
					'settinggroup' => 'login',
					'varname' => 'domain_login',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'login_maxloginattempts' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['maxloginattempts'],
					'settinggroup' => 'login',
					'varname' => 'maxloginattempts',
					'type' => 'int',
					'default' => 3,
					'save_method' => 'storeSettingField'
				),
				'login_deactivatetime' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['deactivatetime'],
					'settinggroup' => 'login',
					'varname' => 'deactivatetime',
					'type' => 'int',
					'default' => 900,
					'save_method' => 'storeSettingField'
				),
				'2fa_enabled' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['2fa']['2fa_enabled'],
					'settinggroup' => '2fa',
					'varname' => 'enabled',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField'
				),
				'panel_password_min_length' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_password_min_length'],
					'settinggroup' => 'panel',
					'varname' => 'password_min_length',
					'type' => 'int',
					'default' => 0,
					'save_method' => 'storeSettingField'
				),
				'panel_password_alpha_lower' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_password_alpha_lower'],
					'settinggroup' => 'panel',
					'varname' => 'password_alpha_lower',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField'
				),
				'panel_password_alpha_upper' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_password_alpha_upper'],
					'settinggroup' => 'panel',
					'varname' => 'password_alpha_upper',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField'
				),
				'panel_password_numeric' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_password_numeric'],
					'settinggroup' => 'panel',
					'varname' => 'password_numeric',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'panel_password_special_char_required' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_password_special_char_required'],
					'settinggroup' => 'panel',
					'varname' => 'password_special_char_required',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'panel_password_special_char' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_password_special_char'],
					'settinggroup' => 'panel',
					'varname' => 'password_special_char',
					'type' => 'string',
					'default' => '!?<>§$%+#=@',
					'save_method' => 'storeSettingField'
				),
				'panel_password_regex' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_password_regex'],
					'settinggroup' => 'panel',
					'varname' => 'password_regex',
					'type' => 'string',
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'customer_accountprefix' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['accountprefix'],
					'settinggroup' => 'customer',
					'varname' => 'accountprefix',
					'type' => 'string',
					'default' => '',
					'plausibility_check_method' => array(
						'\\Froxlor\\Validate\\Check',
						'checkUsername'
					),
					'save_method' => 'storeSettingField'
				),
				'customer_mysqlprefix' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['mysqlprefix'],
					'settinggroup' => 'customer',
					'varname' => 'mysqlprefix',
					'type' => 'string',
					'default' => '',
					'plausibility_check_method' => array(
						'\\Froxlor\\Validate\\Check',
						'checkUsername'
					),
					'save_method' => 'storeSettingField'
				),
				'customer_ftpprefix' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['ftpprefix'],
					'settinggroup' => 'customer',
					'varname' => 'ftpprefix',
					'type' => 'string',
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'customer_ftpatdomain' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['ftpdomain'],
					'settinggroup' => 'customer',
					'varname' => 'ftpatdomain',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'panel_allow_preset' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['allow_password_reset'],
					'settinggroup' => 'panel',
					'varname' => 'allow_preset',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'dependency' => array(
						'fieldname' => 'panel_allow_preset_admin',
						'fielddata' => array(
							'settinggroup' => 'panel',
							'varname' => 'allow_preset_admin'
						),
						'onlyif' => 0
					)
				),
				'panel_allow_preset_admin' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['allow_password_reset_admin'],
					'settinggroup' => 'panel',
					'varname' => 'allow_preset_admin',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'dependency' => array(
						'fieldname' => 'panel_allow_preset',
						'fielddata' => array(
							'settinggroup' => 'panel',
							'varname' => 'allow_preset'
						),
						'onlyif' => 1
					)
				),
				'system_backupenabled' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['backupenabled'],
					'settinggroup' => 'system',
					'varname' => 'backupenabled',
					'type' => 'bool',
					'default' => false,
					'cronmodule' => 'froxlor/backup',
					'save_method' => 'storeSettingField'
				)
			)
		)
	)
);

