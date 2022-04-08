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
 * @package    Settings
 *
 */
return array(
	'groups' => array(
		'fcgid' => array(
			'title' => $lng['admin']['fcgid_settings'],
			'icon' => 'fa-brands fa-php',
			'websrv_avail' => array(
				'apache2',
				'lighttpd'
			),
			'fields' => array(
				'system_mod_fcgid_enabled' => array(
					'label' => $lng['serversettings']['mod_fcgid'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid',
					'type' => 'checkbox',
					'default' => false,
					'save_method' => 'storeSettingField',
					'plausibility_check_method' => array(
						'\\Froxlor\\Validate\\Check',
						'checkFcgidPhpFpm'
					),
					'overview_option' => true
				),
				'system_mod_fcgid_configdir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['configdir'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_configdir',
					'type' => 'text',
					'string_type' => 'confdir',
					'default' => '/var/www/php-fcgi-scripts/',
					'plausibility_check_method' => array(
						'\\Froxlor\\Validate\\Check',
						'checkPathConflicts'
					),
					'save_method' => 'storeSettingField'
				),
				'system_mod_fcgid_tmpdir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['tmpdir'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_tmpdir',
					'type' => 'text',
					'string_type' => 'dir',
					'default' => '/var/customers/tmp/',
					'save_method' => 'storeSettingField'
				),
				'system_mod_fcgid_peardir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['peardir'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_peardir',
					'type' => 'text',
					'string_type' => 'dir',
					'string_delimiter' => ':',
					'string_emptyallowed' => true,
					'default' => '/usr/share/php/:/usr/share/php5/',
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'system_mod_fcgid_wrapper' => array(
					'label' => $lng['serversettings']['mod_fcgid']['wrapper'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_wrapper',
					'type' => 'select',
					'select_var' => array(
						0 => 'ScriptAlias',
						1 => 'FcgidWrapper'
					),
					'default' => 1,
					'save_method' => 'storeSettingField',
					'websrv_avail' => array(
						'apache2'
					),
					'advanced_mode' => true
				),
				'system_mod_fcgid_starter' => array(
					'label' => $lng['serversettings']['mod_fcgid']['starter'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_starter',
					'type' => 'number',
					'min' => 0,
					'default' => 0,
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'system_mod_fcgid_maxrequests' => array(
					'label' => $lng['serversettings']['mod_fcgid']['maxrequests'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_maxrequests',
					'type' => 'number',
					'default' => 250,
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'system_mod_fcgid_defaultini' => array(
					'label' => $lng['serversettings']['mod_fcgid']['defaultini'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_defaultini',
					'type' => 'select',
					'default' => '1',
					'option_options_method' => array(
						'\\Froxlor\\Http\\PhpConfig',
						'getPhpConfigs'),
					'save_method' => 'storeSettingField'
				),
				'system_mod_fcgid_idle_timeout' => array(
					'label' => $lng['serversettings']['mod_fcgid']['idle_timeout'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_idle_timeout',
					'type' => 'number',
					'default' => 30,
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				)
			)
		)
	)
);
