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
		'ticket' => array(
			'title' => $lng['admin']['ticketsettings'],
			'fields' => array(
				'ticket_enabled' => array(
					'label' => $lng['serversettings']['ticket']['enable'],
					'settinggroup' => 'ticket',
					'varname' => 'enabled',
					'type' => 'bool',
					'default' => false,
					'cronmodule' => 'froxlor/ticket',
					'save_method' => 'storeSettingField',
					'overview_option' => true
					),
				'ticket_noreply_email' => array(
					'label' => $lng['serversettings']['ticket']['noreply_email'],
					'settinggroup' => 'ticket',
					'varname' => 'noreply_email',
					'type' => 'string',
					'string_type' => 'mail',
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'ticket_noreply_name' => array(
					'label' => $lng['serversettings']['ticket']['noreply_name'],
					'settinggroup' => 'ticket',
					'varname' => 'noreply_name',
					'type' => 'string',
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'ticket_reset_cycle' => array(
					'label' => $lng['serversettings']['ticket']['reset_cycle'],
					'settinggroup' => 'ticket',
					'varname' => 'reset_cycle',
					'type' => 'option',
					'default' => 1,
					'option_mode' => 'one',
					'option_options' => array(0 => html_entity_decode($lng['admin']['tickets']['daily']), 1 => html_entity_decode($lng['admin']['tickets']['weekly']), 2 => html_entity_decode($lng['admin']['tickets']['monthly']), 3 => html_entity_decode($lng['admin']['tickets']['yearly'])),
					'save_method' => 'storeSettingField',
					'plausibility_check_method' => 'setCycleOfCronjob',
					),
				'ticket_concurrently_open' => array(
					'label' => $lng['serversettings']['ticket']['concurrentlyopen'],
					'settinggroup' => 'ticket',
					'varname' => 'concurrently_open',
					'type' => 'int',
					'default' => 5,
					'save_method' => 'storeSettingField',
					),
				'ticket_archiving_days' => array(
					'label' => $lng['serversettings']['ticket']['archiving_days'],
					'settinggroup' => 'ticket',
					'varname' => 'archiving_days',
					'type' => 'int',
					'int_min' => 1,
					'int_max' => 99,
					'default' => 5,
					'save_method' => 'storeSettingField',
					),
				'ticket_worktime_all' => array(
					'label' => $lng['serversettings']['ticket']['worktime_all'],
					'settinggroup' => 'ticket',
					'varname' => 'worktime_all',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'ticket_worktime_begin' => array(
					'label' => $lng['serversettings']['ticket']['worktime_begin'],
					'settinggroup' => 'ticket',
					'varname' => 'worktime_begin',
					'type' => 'string',
					'string_regexp' => '/^[012][0-9]:[0-6][0-9]$/',
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'ticket_worktime_end' => array(
					'label' => $lng['serversettings']['ticket']['worktime_end'],
					'settinggroup' => 'ticket',
					'varname' => 'worktime_end',
					'type' => 'string',
					'string_regexp' => '/^[012][0-9]:[0-6][0-9]$/',
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				'ticket_worktime_sat' => array(
					'label' => $lng['serversettings']['ticket']['worktime_sat'],
					'settinggroup' => 'ticket',
					'varname' => 'worktime_sat',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'ticket_worktime_sun' => array(
					'label' => $lng['serversettings']['ticket']['worktime_sun'],
					'settinggroup' => 'ticket',
					'varname' => 'worktime_sun',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'system_last_archive_run' => array(
					'settinggroup' => 'system',
					'varname' => 'last_archive_run',
					'type' => 'hidden',
					'default' => '',
					),
				'ticket_default_priority' => array(
					'label' => $lng['serversettings']['ticket']['default_priority'],
					'settinggroup' => 'ticket',
					'varname' => 'default_priority',
					'type' => 'option',
					'default' => 2,
					'option_mode' => 'one',
					'option_options' => array(1 => $lng['ticket']['high'], 2 => $lng['ticket']['normal'], 3 => $lng['ticket']['low']),
					'save_method' => 'storeSettingField', 
					),
				),
			),
		)
	);

?>
