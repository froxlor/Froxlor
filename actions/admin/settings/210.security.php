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
 * @version    $Id$
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
				'system_mod_fcgid_enabled' => array(
					'label' => $lng['serversettings']['mod_fcgid'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'system_mod_fcgid_configdir' => array(
					'label' => $lng['serversettings']['mod_fcgid']['configdir'],
					'settinggroup' => 'system',
					'varname' => 'mod_fcgid_configdir',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/var/www/php-fcgi-scripts/',
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
					'option_options' => array(0 => 'ScriptAlias', 1=> 'FCGIWrapper'),
					'default' => 0,
					'save_method' => 'storeSettingField',
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
				),
			),
		),
	);

?>