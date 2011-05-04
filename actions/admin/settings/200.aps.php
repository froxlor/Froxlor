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
		'aps' => array(
			'title' => $lng['admin']['aps'],
			'fields' => array(
				'aps_enable' => array(
					'label' => $lng['aps']['activate_aps'],
					'settinggroup' => 'aps',
					'varname' => 'aps_active',
					'type' => 'bool',
					'default' => false,
					'cronmodule' => 'froxlor/aps',
					'save_method' => 'storeSettingField',
					'overview_option' => true
					),
				'aps_items_per_page' => array(
					'label' => $lng['aps']['packages_per_page'],
					'settinggroup' => 'aps',
					'varname' => 'items_per_page',
					'type' => 'int',
					'default' => 20,
					'save_method' => 'storeSettingField',
					),
				'aps_upload_fields' => array(
					'label' => $lng['aps']['upload_fields'],
					'settinggroup' => 'aps',
					'varname' => 'upload_fields',
					'type' => 'int',
					'default' => 5,
					'save_method' => 'storeSettingField',
					),
				'aps_exceptions' => array(
					'label' => $lng['aps']['exceptions'],
					'type' => 'label',
					),
				'aps_php-extension' => array(
					'label' => $lng['aps']['settings_php_extensions'],
					'settinggroup' => 'aps',
					'varname' => 'php-extension',
					'type' => 'option',
					'default' => '',
					'option_mode' => 'multiple',
					'option_options' => array('gd' => 'GD Library', 'pcre' => 'PCRE', 'ioncube' => 'ionCube', 'ioncube loader' => 'ionCube Loader', 'curl' => 'curl', 'mcrypt' => 'mcrypt', 'imap' => 'imap', 'json' => 'json', 'ldap' => 'LDAP', 'hash' => 'hash', 'mbstring' => 'mbstring'),
					'save_method' => 'storeSettingApsPhpExtensions',
					),
				'aps_php-function' => array(
					'settinggroup' => 'aps',
					'varname' => 'php-function',
					'type' => 'hidden',
					'default' => '',
					),
				'aps_php-configuration' => array(
					'label' => $lng['aps']['settings_php_configuration'],
					'settinggroup' => 'aps',
					'varname' => 'php-configuration',
					'type' => 'option',
					'default' => '',
					'option_mode' => 'multiple',
					'option_options' => array('short_open_tag' => 'short_open_tag', 'file_uploads' => 'file_uploads', 'magic_quotes_gpc' => 'magic_quotes_gpc', 'register_globals' => 'register_globals', 'allow_url_fopen' => 'allow_url_fopen', 'safe_mode' => 'safe_mode', 'post_max_size' => 'post_max_size', 'memory_limit' => 'memory_limit', 'max_execution_time' => 'max_execution_time'),
					'save_method' => 'storeSettingField',
					),
				'aps_webserver-module' => array(
					'label' => $lng['aps']['settings_webserver_modules'],
					'settinggroup' => 'aps',
					'varname' => 'webserver-module',
					'type' => 'option',
					'default' => '',
					'option_mode' => 'multiple',
					'option_options' => array('mod_perl' => 'mod_perl', 'mod_rewrite' => 'mod_rewrite', 'mod_access' => 'mod_access', 'fcgid-any' => 'FastCGI/mod_fcgid', 'htaccess' => '.htaccess'),
					'save_method' => 'storeSettingApsWebserverModules',
					),
				'aps_webserver-htaccess' => array(
					'settinggroup' => 'aps',
					'varname' => 'webserver-htaccess',
					'type' => 'hidden',
					'default' => '',
					),
				),
			),
		),
	);

?>