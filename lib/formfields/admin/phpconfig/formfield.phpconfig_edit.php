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
	'phpconfig_edit' => array(
		'title' => $lng['admin']['phpsettings']['editsettings'],
		'image' => 'icons/phpsettings_edit.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['admin']['phpsettings']['editsettings'],
				'image' => 'icons/phpsettings_edit.png',
				'fields' => array(
					'description' => array(
						'label' => $lng['admin']['phpsettings']['description'],
						'type' => 'text',
						'maxlength' => 50,
						'value' => $result['description']
					),
					'binary' => array(
						'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['binary'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => $result['binary']
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
						'value' => $result['file_extensions']
					),
					'mod_fcgid_starter' => array(
						'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_starter']['title'],
						'type' => 'text',
						'value' => ((int)$result['mod_fcgid_starter'] != - 1 ? $result['mod_fcgid_starter'] : '')
					),
					'mod_fcgid_maxrequests' => array(
						'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
						'label' => $lng['admin']['mod_fcgid_maxrequests']['title'],
						'type' => 'text',
						'value' => ((int)$result['mod_fcgid_maxrequests'] != - 1 ? $result['mod_fcgid_maxrequests'] : '')
					),
				    'mod_fcgid_umask' => array(
				        'visible' => (Settings::Get('system.mod_fcgid') == 1 ? true : false),
				        'label' => $lng['admin']['mod_fcgid_umask']['title'],
				        'type' => 'text',
				        'maxlength' => 3,
				        'value' => $result['mod_fcgid_umask']
				    ),
					'phpfpm_enable_slowlog' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['enable_slowlog'],
						'type' => 'checkbox',
						'values' => array(
							array ('label' => $lng['panel']['yes'], 'value' => '1')
						),
						'value' => array($result['fpm_slowlog'])
					),
					'phpfpm_reqtermtimeout' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['request_terminate_timeout'],
						'type' => 'text',
						'maxlength' => 10,
						'value' => $result['fpm_reqterm']
					),
					'phpfpm_reqslowtimeout' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['request_slowlog_timeout'],
						'type' => 'text',
						'maxlength' => 10,
						'value' => $result['fpm_reqslow']
					),
					'phpfpm_pass_authorizationheader' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['admin']['phpsettings']['pass_authorizationheader'],
						'type' => 'checkbox',
						'values' => array(
							array ('label' => $lng['panel']['yes'], 'value' => '1')
						),
						'value' => array($result['pass_authorizationheader'])
					),
					'override_fpmconfig' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['override_fpmconfig'],
						'type' => 'checkbox',
						'values' => array(
							array ('label' => $lng['panel']['yes'], 'value' => '1')
						),
						'value' => array($result['override_fpmconfig'])
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
						'value' => $result['max_children']
					),
					'start_servers' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['start_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['start_servers']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => $result['start_servers']
					),
					'min_spare_servers' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => $result['min_spare_servers']
					),
					'max_spare_servers' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => $result['max_spare_servers']
					),
					'max_requests' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['max_requests']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_requests']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => $result['max_requests']
					),
					'idle_timeout' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'int',
						'value' => $result['idle_timeout']
					),
					'limit_extensions' => array(
						'visible' => (Settings::Get('phpfpm.enabled') == 1 ? true : false),
						'label' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['description'].$lng['serversettings']['phpfpm_settings']['override_fpmconfig_addinfo'],
						'type' => 'text',
						'value' => $result['limit_extensions']
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
