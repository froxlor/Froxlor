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
		'statistics' => array(
			'title' => $lng['admin']['statisticsettings'],
			'fields' => array(
				'system_webalizer_quiet' => array(
					'label' => $lng['serversettings']['webalizer_quiet'],
					'settinggroup' => 'system',
					'varname' => 'webalizer_quiet',
					'type' => 'option',
					'default' => 2,
					'option_mode' => 'one',
					'option_options' => array(0 => $lng['admin']['webalizer']['normal'], 1 => $lng['admin']['webalizer']['quiet'], 2 => $lng['admin']['webalizer']['veryquiet']),
					'save_method' => 'storeSettingField',
					),
				'system_awstats_enabled' => array(
					'label' => $lng['serversettings']['awstats_enabled'],
					'settinggroup' => 'system',
					'varname' => 'awstats_enabled',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'system_awstats_path' => array(
					'label' => $lng['serversettings']['awstats_path'],
					'settinggroup' => 'system',
					'varname' => 'awstats_path',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/usr/bin/',
					'save_method' => 'storeSettingField',
					),
				'system_awstats_awstatspath' => array(
					'label' => $lng['serversettings']['awstats_awstatspath'],
					'settinggroup' => 'system',
					'varname' => 'awstats_awstatspath',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/usr/bin/',
					'save_method' => 'storeSettingField',
					),
				'system_awstats_conf' => array(
					'label' => $lng['serversettings']['awstats_conf'],
					'settinggroup' => 'system',
					'varname' => 'awstats_conf',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/etc/awstats/',
					'save_method' => 'storeSettingField',
					),
				'system_awstats_icons' => array(
					'label' => $lng['serversettings']['awstats_icons'],
					'settinggroup' => 'system',
					'varname' => 'awstats_icons',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/usr/share/awstats/icon/',
					'save_method' => 'storeSettingField',
					)
				)
			)
		)
	);

?>