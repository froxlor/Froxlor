<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2016-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Settings
 *
 */
return array(
	'groups' => array(
		'froxlorvhost' => array(
			'title' => $lng['admin']['froxlorvhost'],
			'fields' => array(
				/**
				 * Webserver-Vhost
				 */
				'system_froxlordirectlyviahostname' => array(
					'label' => $lng['serversettings']['froxlordirectlyviahostname'],
					'settinggroup' => 'system',
					'varname' => 'froxlordirectlyviahostname',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				/**
				 * SSL / Let's Encrypt
				 */
				'system_le_froxlor_enabled' => array(
					'label' => $lng['serversettings']['le_froxlor_enabled'],
					'settinggroup' => 'system',
					'varname' => 'le_froxlor_enabled',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingClearCertificates',
					'visible' => Settings::Get('system.leenabled')
				),
				'system_le_froxlor_redirect' => array(
					'label' => $lng['serversettings']['le_froxlor_redirect'],
					'settinggroup' => 'system',
					'varname' => 'le_froxlor_redirect',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'visible' => Settings::Get('system.use_ssl')
				),
				'system_hsts_maxage' => array(
					'label' => $lng['admin']['domain_hsts_maxage'],
					'settinggroup' => 'system',
					'varname' => 'hsts_maxage',
					'type' => 'int',
					'int_min' => 0,
					'int_max' => 94608000, // 3-years
					'default' => 0,
					'save_method' => 'storeSettingField',
					'visible' => Settings::Get('system.use_ssl')
				),
				'system_hsts_incsub' => array(
					'label' => $lng['admin']['domain_hsts_incsub'],
					'settinggroup' => 'system',
					'varname' => 'hsts_incsub',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'visible' => Settings::Get('system.use_ssl')
				),
				'system_hsts_preload' => array(
					'label' => $lng['admin']['domain_hsts_preload'],
					'settinggroup' => 'system',
					'varname' => 'hsts_preload',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'visible' => Settings::Get('system.use_ssl')
				),
				/**
				 * FCGID
				 */
				'system_mod_fcgid_enabled_ownvhost' => array(
					'label' => $lng['serversettings']['mod_fcgid_ownvhost'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_ownvhost',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField',
					'websrv_avail' => array(
						'apache2'
					),
					'visible' => Settings::Get('system.mod_fcgid')
				),
				'system_mod_fcgid_httpuser' => array(
					'label' => $lng['admin']['mod_fcgid_user'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_httpuser',
					'type' => 'string',
					'default' => 'froxlorlocal',
					'save_method' => 'storeSettingWebserverFcgidFpmUser',
					'websrv_avail' => array(
						'apache2'
					),
					'visible' => Settings::Get('system.mod_fcgid')
				),
				'system_mod_fcgid_httpgroup' => array(
					'label' => $lng['admin']['mod_fcgid_group'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_httpgroup',
					'type' => 'string',
					'default' => 'froxlorlocal',
					'save_method' => 'storeSettingField',
					'websrv_avail' => array(
						'apache2'
					),
					'visible' => Settings::Get('system.mod_fcgid')
				),
				'system_mod_fcgid_defaultini_ownvhost' => array(
					'label' => $lng['serversettings']['mod_fcgid']['defaultini_ownvhost'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_defaultini_ownvhost',
					'type' => 'option',
					'default' => '2',
					'option_mode' => 'one',
					'option_options_method' => 'getPhpConfigs',
					'save_method' => 'storeSettingField',
					'websrv_avail' => array(
						'apache2'
					),
					'visible' => Settings::Get('system.mod_fcgid')
				),
				/**
				 * php-fpm
				 */
				'system_phpfpm_enabled_ownvhost' => array(
					'label' => $lng['phpfpm']['ownvhost'],
					'settinggroup' => 'phpfpm',
					'varname' => 'enabled_ownvhost',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField',
					'visible' => Settings::Get('phpfpm.enabled')
				),
				'system_phpfpm_httpuser' => array(
					'label' => $lng['phpfpm']['vhost_httpuser'],
					'settinggroup' => 'phpfpm',
					'varname' => 'vhost_httpuser',
					'type' => 'string',
					'default' => 'froxlorlocal',
					'save_method' => 'storeSettingWebserverFcgidFpmUser',
					'visible' => Settings::Get('phpfpm.enabled')
				),
				'system_phpfpm_httpgroup' => array(
					'label' => $lng['phpfpm']['vhost_httpgroup'],
					'settinggroup' => 'phpfpm',
					'varname' => 'vhost_httpgroup',
					'type' => 'string',
					'default' => 'froxlorlocal',
					'save_method' => 'storeSettingField',
					'visible' => Settings::Get('phpfpm.enabled')
				),
				'system_phpfpm_defaultini_ownvhost' => array(
					'label' => $lng['serversettings']['mod_fcgid']['defaultini_ownvhost'],
					'settinggroup' => 'phpfpm',
					'varname' => 'vhost_defaultini',
					'type' => 'option',
					'default' => '2',
					'option_mode' => 'one',
					'option_options_method' => 'getPhpConfigs',
					'save_method' => 'storeSettingField',
					'visible' => Settings::Get('phpfpm.enabled')
				),
				/**
				 * DNS
				 */
				'system_dns_createhostnameentry' => array(
					'label' => $lng['serversettings']['dns_createhostnameentry'],
					'settinggroup' => 'system',
					'varname' => 'dns_createhostnameentry',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'visible' => Settings::Get('system.bind_enable')
				)
			)
		)
	)
);
