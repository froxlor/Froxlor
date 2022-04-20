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
 * @package    Formfields
 *
 */
return array(
	'phpconfig_add' => array(
		'title' => $lng['admin']['phpsettings']['addsettings'],
		'image' => 'fa-solid fa-plus',
		'self_overview' => ['section' => 'phpsettings', 'page' => 'overview'],
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['phpsettings']['addsettings'],
				'image' => 'icons/phpsettings_add.png',
				'fields' => array(
					'description' => array(
						'label' => $lng['admin']['phpsettings']['description'],
						'type' => 'text',
						'maxlength' => 50
					),
					'binary' => array(
						'visible' => \Froxlor\Settings::Get('system.mod_fcgid') == 1,
						'label' => $lng['admin']['phpsettings']['binary'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => '/usr/bin/php-cgi'
					),
					'fpmconfig' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['admin']['phpsettings']['fpmdesc'],
						'type' => 'select',
						'select_var' => $fpmconfigs,
						'selected' => 1
					),
					'file_extensions' => array(
						'visible' => \Froxlor\Settings::Get('system.mod_fcgid') == 1,
						'label' => $lng['admin']['phpsettings']['file_extensions'],
						'desc' => $lng['admin']['phpsettings']['file_extensions_note'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => 'php'
					),
					'mod_fcgid_starter' => array(
						'visible' => \Froxlor\Settings::Get('system.mod_fcgid') == 1,
						'label' => $lng['admin']['mod_fcgid_starter']['title'],
						'type' => 'number'
					),
					'mod_fcgid_maxrequests' => array(
						'visible' => \Froxlor\Settings::Get('system.mod_fcgid') == 1,
						'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'number'
					),
					'mod_fcgid_umask' => array(
						'visible' => \Froxlor\Settings::Get('system.mod_fcgid') == 1,
						'label' => $lng['admin']['mod_fcgid_umask']['title'],
						'type' => 'text',
						'maxlength' => 3,
						'value' => '022'
					),
					'phpfpm_enable_slowlog' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['admin']['phpsettings']['enable_slowlog'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'phpfpm_reqtermtimeout' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['admin']['phpsettings']['request_terminate_timeout'],
						'type' => 'text',
						'maxlength' => 10,
						'value' => '60s'
					),
					'phpfpm_reqslowtimeout' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['admin']['phpsettings']['request_slowlog_timeout'],
						'type' => 'text',
						'maxlength' => 10,
						'value' => '5s'
					),
					'phpfpm_pass_authorizationheader' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['admin']['phpsettings']['pass_authorizationheader'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'override_fpmconfig' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['serversettings']['phpfpm_settings']['override_fpmconfig'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					),
					'pm' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['serversettings']['phpfpm_settings']['pm'],
						'desc' => $lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'select',
						'select_var' => [
							'static' => 'static',
							'dynamic' => 'dynamic',
							'ondemand' => 'ondemand'
						]
					),
					'max_children' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['serversettings']['phpfpm_settings']['max_children']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_children']['description'] . $lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'number',
						'value' => 1
					),
					'start_servers' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['serversettings']['phpfpm_settings']['start_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['start_servers']['description'] . $lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'number',
						'value' => 20
					),
					'min_spare_servers' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'] . $lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'number',
						'value' => 5
					),
					'max_spare_servers' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'] . $lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'number',
						'value' => 35
					),
					'max_requests' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['serversettings']['phpfpm_settings']['max_requests']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_requests']['description'] . $lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'number',
						'value' => 0
					),
					'idle_timeout' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['description'] . $lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'number',
						'value' => 10
					),
					'limit_extensions' => array(
						'visible' => \Froxlor\Settings::Get('phpfpm.enabled') == 1,
						'label' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['description'] . $lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'text',
						'value' => '.php'
					),
					'phpsettings' => array(
						'label' => $lng['admin']['phpsettings']['phpinisettings'],
						'type' => 'textarea',
						'cols' => 80,
						'rows' => 20,
						'value' => $result['phpsettings']
					),
					'allow_all_customers' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['allow_all_customers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['allow_all_customers']['description'],
						'type' => 'checkbox',
						'value' => '1',
						'checked' => false
					)
				)
			)
		)
	)
);
