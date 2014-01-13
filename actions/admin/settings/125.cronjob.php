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
					'default' => '/etc/cron.d/froxlor-services',
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
