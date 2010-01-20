<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Panel
 * @version    $Id: 160.nameserver.php 2724 2009-06-07 14:18:02Z flo $
 */

return array(
	'groups' => array(
		'nameserver' => array(
			'title' => $lng['admin']['nameserversettings'],
			'fields' => array(
				'system_bindconf_directory' => array(
					'label' => $lng['serversettings']['bindconf_directory'],
					'settinggroup' => 'system',
					'varname' => 'bindconf_directory',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/etc/bind/',
					'save_method' => 'storeSettingField',
					),
				'system_bindreload_command' => array(
					'label' => $lng['serversettings']['bindreload_command'],
					'settinggroup' => 'system',
					'varname' => 'bindreload_command',
					'type' => 'string',
					'default' => '/etc/init.d/bind9 reload',
					'save_method' => 'storeSettingField',
					),
				'system_nameservers' => array(
					'label' => $lng['serversettings']['nameservers'],
					'settinggroup' => 'system',
					'varname' => 'nameservers',
					'type' => 'string',
					'string_regexp' => '/^(([a-z0-9\-\._]+, ?)*[a-z0-9\-\._]+)?$/i',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingFieldInsertBindTask',
					),
				'system_mxservers' => array(
					'label' => $lng['serversettings']['mxservers'],
					'settinggroup' => 'system',
					'varname' => 'mxservers',
					'type' => 'string',
					'string_regexp' => '/^(([0-9]+ [a-z0-9\-\._]+, ?)*[0-9]+ [a-z0-9\-\._]+)?$/i',
					'string_emptyallowed' => true,
					'default' => '',
					'save_method' => 'storeSettingField',
					),
				),
			),
		),
	);

?>