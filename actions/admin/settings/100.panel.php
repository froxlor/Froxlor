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
 * @package    Language
 *
 */

return array(
	'groups' => array(
		'panel' => array(
			'title' => $lng['admin']['panelsettings'],
			'fields' => array(
				'panel_standardlanguage' => array(
					'label' => array('title' => $lng['login']['language'], 'description' => $lng['serversettings']['language']['description']),
					'settinggroup' => 'panel',
					'varname' => 'standardlanguage',
					'type' => 'option',
					'default' => 'English',
					'option_mode' => 'one',
					'option_options_method' => 'getLanguages',
					'save_method' => 'storeSettingField',
					),
				'panel_default_theme' => array(
					'label' => $lng['serversettings']['default_theme'],
					'settinggroup' => 'panel',
					'varname' => 'default_theme',
					'type' => 'option',
					'default' => 'Froxlor',
					'option_mode' => 'one',
					'option_options_method' => 'getThemes',
					'save_method' => 'storeSettingField',
					),
				'panel_natsorting' => array(
					'label' => $lng['serversettings']['natsorting'],
					'settinggroup' => 'panel',
					'varname' => 'natsorting',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'panel_no_robots' => array(
					'label' => $lng['serversettings']['no_robots'],
					'settinggroup' => 'panel',
					'varname' => 'no_robots',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'panel_paging' => array(
					'label' => $lng['serversettings']['paging'],
					'settinggroup' => 'panel',
					'varname' => 'paging',
					'type' => 'int',
					'int_min' => 0,
					'default' => 0,
					'save_method' => 'storeSettingField',
					),
				'panel_pathedit' => array(
					'label' => $lng['serversettings']['pathedit'],
					'settinggroup' => 'panel',
					'varname' => 'pathedit',
					'type' => 'option',
					'default' => 'Manual',
					'option_mode' => 'one',
					'option_options' => array('Manual' => $lng['serversettings']['manual'], 'Dropdown' => $lng['serversettings']['dropdown']),
					'save_method' => 'storeSettingField',
					),
				'use_webfonts' => array(
					'label' => $lng['serversettings']['enablewebfonts'],
					'settinggroup' => 'panel',
					'varname' => 'use_webfonts',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField',
					),
				'webfont' => array(
					'label' => $lng['serversettings']['definewebfont']['title'],
					'settinggroup' => 'panel',
					'varname' => 'webfont',
					'type' => 'string',
					'default' => 'Numans',
					'string_emptyallowed' => false,
					'save_method' => 'storeSettingField',
					),
				'panel_adminmail' => array(
					'label' => $lng['serversettings']['adminmail'],
					'settinggroup' => 'panel',
					'varname' => 'adminmail',
					'type' => 'string',
					'string_type' => 'mail',
					'string_emptyallowed' => false,
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'panel_adminmail_defname' => array(
					'label' => $lng['serversettings']['adminmail_defname'],
					'settinggroup' => 'panel',
					'varname' => 'adminmail_defname',
					'type' => 'string',
					'default' => 'Froxlor Administrator',
					'save_method' => 'storeSettingField',
					),
				'panel_adminmail_return' => array(
					'label' => $lng['serversettings']['adminmail_return'],
					'settinggroup' => 'panel',
					'varname' => 'adminmail_return',
					'type' => 'string',
					'string_type' => 'mail',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'panel_decimal_places' => array(
					'label' => $lng['serversettings']['decimal_places'],
					'settinggroup' => 'panel',
					'varname' => 'decimal_places',
					'type' => 'int',
					'int_min' => 0,
					'int_max' => 15,
					'default' => 4,
					'save_method' => 'storeSettingField',
					),
				'panel_phpmyadmin_url' => array(
					'label' => $lng['serversettings']['phpmyadmin_url'],
					'settinggroup' => 'panel',
					'varname' => 'phpmyadmin_url',
					'type' => 'string',
					'string_type' => 'url',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'panel_webmail_url' => array(
					'label' => $lng['serversettings']['webmail_url'],
					'settinggroup' => 'panel',
					'varname' => 'webmail_url',
					'type' => 'string',
					'string_type' => 'url',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'panel_webftp_url' => array(
					'label' => $lng['serversettings']['webftp_url'],
					'settinggroup' => 'panel',
					'varname' => 'webftp_url',
					'type' => 'string',
					'string_type' => 'url',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'admin_show_version_login' => array(
					'label' => $lng['admin']['show_version_login'],
					'settinggroup' => 'admin',
					'varname' => 'show_version_login',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'admin_show_version_footer' => array(
					'label' => $lng['admin']['show_version_footer'],
					'settinggroup' => 'admin',
					'varname' => 'show_version_footer',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'panel_allow_domain_change_admin' => array(
					'label' => $lng['serversettings']['panel_allow_domain_change_admin'],
					'settinggroup' => 'panel',
					'varname' => 'allow_domain_change_admin',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'panel_allow_domain_change_customer' => array(
					'label' => $lng['serversettings']['panel_allow_domain_change_customer'],
					'settinggroup' => 'panel',
					'varname' => 'allow_domain_change_customer',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				),
			),
		),
	);

?>
