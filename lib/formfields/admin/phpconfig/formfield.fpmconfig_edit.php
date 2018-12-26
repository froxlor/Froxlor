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
	'fpmconfig_edit' => array(
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
					'reload_cmd' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['reload'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => $result['reload_cmd']
					),
					'config_dir' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['configdir'],
						'type' => 'text',
						'maxlength' => 255,
						'value' => $result['config_dir']
					),
					'pm' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['pm'],
						'type' => 'select',
						'select_var' => $pm_select
					),
					'max_children' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['max_children']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_children']['description'],
						'type' => 'int',
						'value' => $result['max_children']
					),
					'start_servers' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['start_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['start_servers']['description'],
						'type' => 'int',
						'value' => $result['start_servers']
					),
					'min_spare_servers' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['min_spare_servers']['description'],
						'type' => 'int',
						'value' => $result['min_spare_servers']
					),
					'max_spare_servers' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_spare_servers']['description'],
						'type' => 'int',
						'value' => $result['max_spare_servers']
					),
					'max_requests' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['max_requests']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['max_requests']['description'],
						'type' => 'int',
						'value' => $result['max_requests']
					),
					'idle_timeout' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['idle_timeout']['description'],
						'type' => 'int',
						'value' => $result['idle_timeout']
					),
					'limit_extensions' => array(
						'label' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['title'],
						'desc' => $lng['serversettings']['phpfpm_settings']['limit_extensions']['description'],
						'type' => 'text',
						'value' => $result['limit_extensions']
					)
				)
			)
		)
	)
);
