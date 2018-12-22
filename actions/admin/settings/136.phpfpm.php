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
 * @package    \Froxlor\Settings
 *
 */
return array(
	'groups' => array(
		'phpfpm' => array(
			'title' => $lng['admin']['phpfpm_settings'],
			'fields' => array(
				'system_phpfpm_enabled' => array(
					'label' => $lng['serversettings']['phpfpm'],
					'settinggroup' => 'phpfpm',
					'varname' => 'enabled',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'plausibility_check_method' => array(
						'\\Froxlor\\Validate\\Check',
						'checkFcgidPhpFpm'
					),
					'overview_option' => true
				),
				'system_phpfpm_defaultini' => array(
					'label' => $lng['serversettings']['mod_fcgid']['defaultini'],
					'settinggroup' => 'phpfpm',
					'varname' => 'defaultini',
					'type' => 'option',
					'default' => '1',
					'option_mode' => 'one',
					'option_options_method' => array(
						'\\Froxlor\\Http\\PhpConfig',
						'getPhpConfigs'
					),
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_aliasconfigdir' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['aliasconfigdir'],
					'settinggroup' => 'phpfpm',
					'varname' => 'aliasconfigdir',
					'type' => 'string',
					'string_type' => 'confdir',
					'default' => '/var/www/php-fpm/',
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_tmpdir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['tmpdir'],
					'settinggroup' => 'phpfpm',
					'varname' => 'tmpdir',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/var/customers/tmp/',
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_peardir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['peardir'],
					'settinggroup' => 'phpfpm',
					'varname' => 'peardir',
					'type' => 'string',
					'string_type' => 'dir',
					'string_delimiter' => ':',
					'string_emptyallowed' => true,
					'default' => '/usr/share/php/:/usr/share/php5/',
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_envpath' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['envpath'],
					'settinggroup' => 'phpfpm',
					'varname' => 'envpath',
					'type' => 'string',
					'string_type' => 'dir',
					'string_delimiter' => ':',
					'string_emptyallowed' => true,
					'default' => '/usr/local/bin:/usr/bin:/bin',
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_fastcgi_ipcdir' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['ipcdir'],
					'settinggroup' => 'phpfpm',
					'varname' => 'fastcgi_ipcdir',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/var/lib/apache2/fastcgi/',
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_use_mod_proxy' => array(
					'label' => $lng['phpfpm']['use_mod_proxy'],
					'settinggroup' => 'phpfpm',
					'varname' => 'use_mod_proxy',
					'type' => 'bool',
					'default' => false,
					'visible' => \Froxlor\Settings::Get('system.apache24'),
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_ini_flags' => array(
					'label' => $lng['phpfpm']['ini_flags'],
					'settinggroup' => 'phpfpm',
					'varname' => 'ini_flags',
					'type' => 'text',
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_ini_values' => array(
					'label' => $lng['phpfpm']['ini_values'],
					'settinggroup' => 'phpfpm',
					'varname' => 'ini_values',
					'type' => 'text',
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_ini_admin_flags' => array(
					'label' => $lng['phpfpm']['ini_admin_flags'],
					'settinggroup' => 'phpfpm',
					'varname' => 'ini_admin_flags',
					'type' => 'text',
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'system_phpfpm_ini_admin_values' => array(
					'label' => $lng['phpfpm']['ini_admin_values'],
					'settinggroup' => 'phpfpm',
					'varname' => 'ini_admin_values',
					'type' => 'text',
					'default' => '',
					'save_method' => 'storeSettingField'
				)
			)
		)
	)
);
