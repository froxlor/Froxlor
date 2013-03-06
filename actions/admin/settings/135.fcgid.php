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
			'websrv_avail' => array('apache2', 'lighttpd'),
			'fields' => array(
				'system_mod_fcgid_enabled' => array(
					'label' => $lng['serversettings']['mod_fcgid'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'plausibility_check_method' => 'checkFcgidPhpFpm',
					'overview_option' => true
					),
				'system_mod_fcgid_configdir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['configdir'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_configdir',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/var/www/php-fcgi-scripts/',
					'plausibility_check_method' => 'checkPathConflicts',
					'save_method' => 'storeSettingField',
					),
				'system_mod_fcgid_tmpdir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['tmpdir'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_tmpdir',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/var/customers/tmp/',
					'save_method' => 'storeSettingField',
					),
				'system_mod_fcgid_peardir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['peardir'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_peardir',
					'type' => 'string',
					'string_type' => 'dir',
					'string_delimiter' => ':',
					'string_emptyallowed' => true,
					'default' => '/usr/share/php/:/usr/share/php5/',
					'save_method' => 'storeSettingField',
					),
				'system_mod_fcgid_wrapper' => array(
					'label' => $lng['serversettings']['mod_fcgid']['wrapper'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_wrapper',
					'type' => 'option',
					'option_options' => array(0 => 'ScriptAlias', 1=> 'FcgidWrapper'),
					'default' => 1,
					'save_method' => 'storeSettingField',
					'websrv_avail' => array('apache2')
					),
				'system_mod_fcgid_starter' => array(
					'label' => $lng['serversettings']['mod_fcgid']['starter'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_starter',
					'type' => 'int',
					'default' => 0,
					'save_method' => 'storeSettingField',
					),
				'system_mod_fcgid_maxrequests' => array(
					'label' => $lng['serversettings']['mod_fcgid']['maxrequests'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_maxrequests',
					'type' => 'int',
					'default' => 250,
					'save_method' => 'storeSettingField',
					),
				'system_mod_fcgid_defaultini' => array(
					'label' => $lng['serversettings']['mod_fcgid']['defaultini'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_defaultini',
					'type' => 'option',
					'default' => '1',
					'option_mode' => 'one',
					'option_options_method' => 'getPhpConfigs',
					'save_method' => 'storeSettingField',
					),
				'system_mod_fcgid_enabled_ownvhost' => array(
					'label' => $lng['serversettings']['mod_fcgid_ownvhost'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_ownvhost',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'websrv_avail' => array('apache2')
					),
				'system_mod_fcgid_httpuser' => array(
					'label' => $lng['admin']['mod_fcgid_user'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_httpuser',
					'type' => 'string',
					'default' => 'froxlorlocal',
					'save_method' => 'storeSettingField',
					'websrv_avail' => array('apache2')
					),
				'system_mod_fcgid_httpgroup' => array(
					'label' => $lng['admin']['mod_fcgid_group'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_httpgroup',
					'type' => 'string',
					'default' => 'froxlorlocal',
					'save_method' => 'storeSettingField',
					'websrv_avail' => array('apache2')
					),
				'system_mod_fcgid_defaultini_ownvhost' => array(
					'label' => $lng['serversettings']['mod_fcgid']['defaultini_ownvhost'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_defaultini_ownvhost',
					'type' => 'option',
					'default' => '1',
					'option_mode' => 'one',
					'option_options_method' => 'getPhpConfigs',
					'save_method' => 'storeSettingField',
					'websrv_avail' => array('apache2')
					),
				'system_mod_fcgid_idle_timeout' => array(
					'label' => $lng['serversettings']['mod_fcgid']['idle_timeout'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_idle_timeout',
					'type' => 'int',
					'default' => 30,
					'save_method' => 'storeSettingField'
					),
				)
			)
		)
	);

?>
