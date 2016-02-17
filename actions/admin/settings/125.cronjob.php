<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2014 the Froxlor Team (see authors).
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
		'crond' => array(
			'title' => $lng['admin']['cronsettings'],
			'fields' => array(
				'system_cronconfig' => array(
					'label' => $lng['serversettings']['system_cronconfig'],
					'settinggroup' => 'system',
					'varname' => 'cronconfig',
					'type' => 'string',
					'string_type' => 'file',
					'default' => '/etc/cron.d/froxlor',
					'save_method' => 'storeSettingField',
					),
				'system_croncmdline' => array(
					'label' => $lng['serversettings']['system_croncmdline'],
					'settinggroup' => 'system',
					'varname' => 'croncmdline',
					'type' => 'string',
					'default' => '/usr/bin/nice -n 5 /usr/bin/php5 -q',
					'save_method' => 'storeSettingField',
					),
				'system_crondreload' => array(
					'label' => $lng['serversettings']['system_crondreload'],
					'settinggroup' => 'system',
					'varname' => 'crondreload',
					'type' => 'string',
					'default' => '/etc/init.d/cron reload',
					'save_method' => 'storeSettingField',
					),
				'system_cron_allowautoupdate' => array(
					'label' => $lng['serversettings']['system_cron_allowautoupdate'],
					'settinggroup' => 'system',
					'varname' => 'cron_allowautoupdate',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'system_debug_cron' => array(
					'label' => $lng['serversettings']['cron']['debug'],
					'settinggroup' => 'system',
					'varname' => 'debug_cron',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					)
			)
		)
	)
);
