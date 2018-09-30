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
		'image' => 'icons/phpsettings_add.png',
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
						'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['binary'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => '/usr/bin/php-cgi'
					),
					'fpmconfig' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['fpmdesc'],
						'type' => 'select',
						'select_var' => $fpmconfigs
					),
					'file_extensions' => array(
						'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['file_extensions'],
						'desc' => $lng['admin']['phpsettings']['file_extensions_note'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => 'php'
					),
					'mod_fcgid_starter' => array(
						'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_starter']['title'],
						'type' => 'text'
					),
					'mod_fcgid_maxrequests' => array(
						'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'text'
					),
				    'mod_fcgid_umask' => array(
				        'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
				        'label' => $lng['admin']['mod_fcgid_umask']['title'],
				        'type' => 'text',
				        'maxlength' => 3,
				        'value' => '022'
				    ),
					'phpfpm_enable_slowlog' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['enable_slowlog'],
						'type' => 'checkbox',
						'values' => array(
							array ('label' => $lng['panel']['yes'], 'value' => '1')
						),
						'value' => array()
					),
					'phpfpm_reqtermtimeout' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['request_terminate_timeout'],
						'type' => 'text',
						'maxlength' => 10,
						'value' => '60s'
					),
					'phpfpm_reqslowtimeout' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['request_slowlog_timeout'],
						'type' => 'text',
						'maxlength' => 10,
						'value' => '5s'
					),
					'phpfpm_pass_authorizationheader' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['pass_authorizationheader'],
						'type' => 'checkbox',
						'values' => array(
							array ('label' => $lng['panel']['yes'], 'value' => '1')
						),
						'value' => array()
					),
					'override_fpmconfig' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['override_fpmconfig'],
						'type' => 'checkbox',
						'values' => array(
							array ('label' => $lng['panel']['yes'], 'value' => '1')
						),
						'value' => array()
					),
					'pm' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['pm'],
						'desc' => $lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'select',
						'select_var' => $pm_select
					),
					'max_children' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['max_children']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_children']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => 1
					),
					'start_servers' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['start_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['start_servers']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => 20
					),
					'min_spare_servers' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => 5
					),
					'max_spare_servers' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => 35
					),
					'max_requests' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['max_requests']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_requests']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => 0
					),
					'idle_timeout' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => 30
					),
					'limit_extensions' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'text',
						'value' => '.php'
					),
					'phpsettings' => array(
						'style' => 'align-top',
						'label' => $lng['admin']['phpsettings']['phpinisettings'],
						'type' => 'textarea',
						'cols' => 80,
						'rows' => 20,
						'value' => $result['phpsettings']
					)
				)
			)
		)
	)
);
