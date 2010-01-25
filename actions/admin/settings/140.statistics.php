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
 * @version    $Id$
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
				'system_awstats_domain_file' => array(
					'label' => $lng['serversettings']['awstats_domain_file'],
					'settinggroup' => 'system',
					'varname' => 'awstats_domain_file',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/etc/awstats/',
					'save_method' => 'storeSettingField',
					),
				'system_awstats_model_file' => array(
					'label' => $lng['serversettings']['awstats_model_file'],
					'settinggroup' => 'system',
					'varname' => 'awstats_model_file',
					'type' => 'string',
					'string_type' => 'file',
					'default' => '/etc/awstats/awstats.model.conf.syscp',
					'save_method' => 'storeSettingField',
					),
				'system_awstats_path' => array(
					'label' => $lng['serversettings']['awstats_path'],
					'settinggroup' => 'system',
					'varname' => 'awstats_path',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/usr/share/awstats/VERSION/webroot/cgi-bin/',
					'save_method' => 'storeSettingField',
					),
				'system_awstats_updateall_command' => array(
					'label' => $lng['serversettings']['awstats_updateall_command'],
					'settinggroup' => 'system',
					'varname' => 'awstats_updateall_command',
					'type' => 'string',
					'string_type' => 'file',
					'default' => '/usr/bin/awstats_updateall.pl',
					'save_method' => 'storeSettingField',
					),
				),
			),
		),
	);

?>