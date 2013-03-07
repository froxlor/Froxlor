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
					'plausibility_check_method' => 'checkFcgidPhpFpm',
					'overview_option' => true
					),
				'system_phpfpm_enabled_ownvhost' => array(
					'label' => $lng['phpfpm']['ownvhost'],
					'settinggroup' => 'phpfpm',
					'varname' => 'enabled_ownvhost',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
					),
				'system_phpfpm_httpuser' => array(
					'label' => $lng['phpfpm']['vhost_httpuser'],
					'settinggroup' => 'phpfpm',
					'varname' => 'vhost_httpuser',
					'type' => 'string',
					'default' => 'froxlorlocal',
					'save_method' => 'storeSettingField'
					),
				'system_phpfpm_httpgroup' => array(
					'label' => $lng['phpfpm']['vhost_httpgroup'],
					'settinggroup' => 'phpfpm',
					'varname' => 'vhost_httpgroup',
					'type' => 'string',
					'default' => 'froxlorlocal',
					'save_method' => 'storeSettingField'
					),
				/*
				 * @TODO implement if phpfpm knows custom php.ini files
				 *
				'system_phpfpm_defaultini_ownvhost' => array(
					'label' => $lng['serversettings']['mod_fcgid']['defaultini_ownvhost'],
					'settinggroup' => 'phpfpm',
					'varname' => 'vhost_defaultini',
					'type' => 'option',
					'default' => '1',
					'option_mode' => 'one',
					'option_options_method' => 'getPhpConfigs',
					'save_method' => 'storeSettingField',
					),
				*/
				'system_phpfpm_configdir' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['configdir'],
					'settinggroup' => 'phpfpm',
					'varname' => 'configdir',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/etc/php-fpm.d/',
					'save_method' => 'storeSettingField',
					),
        'system_phpfpm_aliasconfigdir' => array(
          'label' => $lng['serversettings']['phpfpm_settings']['aliasconfigdir'],
          'settinggroup' => 'phpfpm',
          'varname' => 'aliasconfigdir',
          'type' => 'string',
          'string_type' => 'dir',
          'default' => '/var/www/php-fpm/',
          'save_method' => 'storeSettingField',
        ),
				'system_phpfpm_tmpdir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['tmpdir'],
					'settinggroup' => 'phpfpm',
					'varname' => 'tmpdir',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/var/customers/tmp/',
					'save_method' => 'storeSettingField',
					),
				'system_phpfpm_peardir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['peardir'],
					'settinggroup' => 'phpfpm',
					'varname' => 'peardir',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/usr/share/php/:/usr/share/php5/',
					'save_method' => 'storeSettingField',
					),
				'system_phpfpm_reload' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['reload'],
					'settinggroup' => 'phpfpm',
					'varname' => 'reload',
					'type' => 'string',
					'default' => '/etc/init.d/php-fpm restart',
					'save_method' => 'storeSettingField',
					),
				'system_phpfpm_pm' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['pm'],
					'settinggroup' => 'phpfpm',
					'varname' => 'pm',
					'type' => 'option',
					'default' => 'static',
					'option_mode' => 'one',
					'option_options' => array('static' => 'static', 'dynamic' => 'dynamic', 'ondemand' => 'ondemand'),
					'save_method' => 'storeSettingField',
					),
				'system_phpfpm_max_children' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['max_children'],
					'settinggroup' => 'phpfpm',
					'varname' => 'max_children',
					'type' => 'int',
					'default' => 1,
					'save_method' => 'storeSettingField',
					),
				'system_phpfpm_start_servers' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['start_servers'],
					'settinggroup' => 'phpfpm',
					'varname' => 'start_servers',
					'type' => 'int',
					'default' => 20,
					'save_method' => 'storeSettingField',
					),
				'system_phpfpm_min_spare_servers' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['min_spare_servers'],
					'settinggroup' => 'phpfpm',
					'varname' => 'min_spare_servers',
					'type' => 'int',
					'default' => 5,
					'save_method' => 'storeSettingField',
					),
				'system_phpfpm_max_spare_servers' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['max_spare_servers'],
					'settinggroup' => 'phpfpm',
					'varname' => 'max_spare_servers',
					'type' => 'int',
					'default' => 35,
					'save_method' => 'storeSettingField',
					),
				'system_phpfpm_max_requests' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['max_requests'],
					'settinggroup' => 'phpfpm',
					'varname' => 'max_requests',
					'type' => 'int',
					'default' => 0,
					'save_method' => 'storeSettingField',
					),
				'system_phpfpm_idle_timeout' => array(
					'label' => $lng['serversettings']['phpfpm_settings']['idle_timeout'],
					'settinggroup' => 'phpfpm',
					'varname' => 'idle_timeout',
					'type' => 'int',
					'default' => 30,
					'save_method' => 'storeSettingField'
					),
				),
			),
		),
	);

?>
