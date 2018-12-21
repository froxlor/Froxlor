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
			'title' => \Froxlor\I18N\Lang::getAll()['admin']['panelsettings'],
			'fields' => array(
				'panel_standardlanguage' => array(
					'label' => array(
						'title' => \Froxlor\I18N\Lang::getAll()['login']['language'],
						'description' => \Froxlor\I18N\Lang::getAll()['serversettings']['language']['description']
					),
					'settinggroup' => 'panel',
					'varname' => 'standardlanguage',
					'type' => 'option',
					'default' => 'English',
					'option_mode' => 'one',
					'option_options_method' => array('\\Froxlor\\User', 'getLanguages'),
					'save_method' => 'storeSettingField'
				),
				'panel_default_theme' => array(
					'label' => array(
						'title' => \Froxlor\I18N\Lang::getAll()['panel']['theme'],
						'description' => \Froxlor\I18N\Lang::getAll()['serversettings']['default_theme']
					),
					'settinggroup' => 'panel',
					'varname' => 'default_theme',
					'type' => 'option',
					'default' => 'Froxlor',
					'option_mode' => 'one',
					'option_options_method' => 'getThemes',
					'save_method' => 'storeSettingDefaultTheme'
				),
				'panel_allow_theme_change_customer' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_allow_theme_change_customer'],
					'settinggroup' => 'panel',
					'varname' => 'allow_theme_change_customer',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField'
				),
				'panel_allow_theme_change_admin' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_allow_theme_change_admin'],
					'settinggroup' => 'panel',
					'varname' => 'allow_theme_change_admin',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField'
				),
				'panel_natsorting' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['natsorting'],
					'settinggroup' => 'panel',
					'varname' => 'natsorting',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'panel_no_robots' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['no_robots'],
					'settinggroup' => 'panel',
					'varname' => 'no_robots',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField'
				),
				'panel_paging' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['paging'],
					'settinggroup' => 'panel',
					'varname' => 'paging',
					'type' => 'int',
					'int_min' => 0,
					'default' => 0,
					'save_method' => 'storeSettingField'
				),
				'panel_pathedit' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['pathedit'],
					'settinggroup' => 'panel',
					'varname' => 'pathedit',
					'type' => 'option',
					'default' => 'Manual',
					'option_mode' => 'one',
					'option_options' => array(
						'Manual' => \Froxlor\I18N\Lang::getAll()['serversettings']['manual'],
						'Dropdown' => \Froxlor\I18N\Lang::getAll()['serversettings']['dropdown']
					),
					'save_method' => 'storeSettingField'
				),
				'panel_adminmail' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['adminmail'],
					'settinggroup' => 'panel',
					'varname' => 'adminmail',
					'type' => 'string',
					'string_type' => 'mail',
					'string_emptyallowed' => false,
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'panel_adminmail_defname' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['adminmail_defname'],
					'settinggroup' => 'panel',
					'varname' => 'adminmail_defname',
					'type' => 'string',
					'default' => 'Froxlor Administrator',
					'save_method' => 'storeSettingField'
				),
				'panel_adminmail_return' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['adminmail_return'],
					'settinggroup' => 'panel',
					'varname' => 'adminmail_return',
					'type' => 'string',
					'string_type' => 'mail',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'panel_decimal_places' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['decimal_places'],
					'settinggroup' => 'panel',
					'varname' => 'decimal_places',
					'type' => 'int',
					'int_min' => 0,
					'int_max' => 15,
					'default' => 4,
					'save_method' => 'storeSettingField'
				),
				'panel_phpmyadmin_url' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['phpmyadmin_url'],
					'settinggroup' => 'panel',
					'varname' => 'phpmyadmin_url',
					'type' => 'string',
					'string_type' => 'url',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'panel_webmail_url' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['webmail_url'],
					'settinggroup' => 'panel',
					'varname' => 'webmail_url',
					'type' => 'string',
					'string_type' => 'url',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'panel_webftp_url' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['webftp_url'],
					'settinggroup' => 'panel',
					'varname' => 'webftp_url',
					'type' => 'string',
					'string_type' => 'url',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'admin_show_version_login' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['show_version_login'],
					'settinggroup' => 'admin',
					'varname' => 'show_version_login',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'admin_show_version_footer' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['show_version_footer'],
					'settinggroup' => 'admin',
					'varname' => 'show_version_footer',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'admin_show_news_feed' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['show_news_feed'],
					'settinggroup' => 'admin',
					'varname' => 'show_news_feed',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'customer_show_news_feed' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['customer_show_news_feed'],
					'settinggroup' => 'customer',
					'varname' => 'show_news_feed',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'customer_news_feed_url' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['admin']['customer_news_feed_url'],
					'settinggroup' => 'customer',
					'varname' => 'news_feed_url',
					'type' => 'string',
					'string_type' => 'url',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField'
				),
				'panel_allow_domain_change_admin' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_allow_domain_change_admin'],
					'settinggroup' => 'panel',
					'varname' => 'allow_domain_change_admin',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'panel_allow_domain_change_customer' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_allow_domain_change_customer'],
					'settinggroup' => 'panel',
					'varname' => 'allow_domain_change_customer',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'panel_phpconfigs_hidestdsubdomain' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_phpconfigs_hidestdsubdomain'],
					'settinggroup' => 'panel',
					'varname' => 'phpconfigs_hidestdsubdomain',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'panel_customer_hide_options' => array(
					'label' => \Froxlor\I18N\Lang::getAll()['serversettings']['panel_customer_hide_options'],
					'settinggroup' => 'panel',
					'varname' => 'customer_hide_options',
					'type' => 'option',
					'default' => '',
					'option_mode' => 'multiple',
					'option_emptyallowed' => true,
					'option_options' => array(
						'email' => \Froxlor\I18N\Lang::getAll()['menue']['email']['email'],
						'mysql' => \Froxlor\I18N\Lang::getAll()['menue']['mysql']['mysql'],
						'domains' => \Froxlor\I18N\Lang::getAll()['menue']['domains']['domains'],
						'ftp' => \Froxlor\I18N\Lang::getAll()['menue']['ftp']['ftp'],
						'extras' => \Froxlor\I18N\Lang::getAll()['menue']['extras']['extras'],
						'extras.directoryprotection' => \Froxlor\I18N\Lang::getAll()['menue']['extras']['extras'] . " / " . \Froxlor\I18N\Lang::getAll()['menue']['extras']['directoryprotection'],
						'extras.pathoptions' => \Froxlor\I18N\Lang::getAll()['menue']['extras']['extras'] . " / " . \Froxlor\I18N\Lang::getAll()['menue']['extras']['pathoptions'],
						'extras.logger' => \Froxlor\I18N\Lang::getAll()['menue']['extras']['extras'] . " / " . \Froxlor\I18N\Lang::getAll()['menue']['logger']['logger'],
						'extras.backup' => \Froxlor\I18N\Lang::getAll()['menue']['extras']['extras'] . " / " . \Froxlor\I18N\Lang::getAll()['menue']['extras']['backup'],
						'traffic' => \Froxlor\I18N\Lang::getAll()['menue']['traffic']['traffic'],
						'traffic.http' => \Froxlor\I18N\Lang::getAll()['menue']['traffic']['traffic'] . " / HTTP",
						'traffic.ftp' => \Froxlor\I18N\Lang::getAll()['menue']['traffic']['traffic'] . " / FTP",
						'traffic.mail' => \Froxlor\I18N\Lang::getAll()['menue']['traffic']['traffic'] . " / Mail"
					),
					'save_method' => 'storeSettingField'
				)
			)
		)
	)
);

?>
