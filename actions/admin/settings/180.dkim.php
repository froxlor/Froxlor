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
 * @version    $Id$
 */

return array(
	'groups' => array(
		'dkim' => array(
			'title' => $lng['admin']['dkimsettings'],
			'fields' => array(
				'dkim_enabled' => array(
					'label' => $lng['dkim']['use_dkim'],
					'settinggroup' => 'dkim',
					'varname' => 'use_dkim',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					),
				'dkim_prefix' => array(
					'label' => $lng['dkim']['dkim_prefix'],
					'settinggroup' => 'dkim',
					'varname' => 'dkim_prefix',
					'type' => 'string',
					'default' => '/etc/postfix/dkim/',
					'save_method' => 'storeSettingField',
					),
				'dkim_domains' => array(
					'label' => $lng['dkim']['dkim_domains'],
					'settinggroup' => 'dkim',
					'varname' => 'dkim_domains',
					'type' => 'string',
					'string_regexp' => '/^[a-z0-9\._]+$/i',
					'default' => 'domains',
					'save_method' => 'storeSettingField',
					),
				'dkim_dkimkeys' => array(
					'label' => $lng['dkim']['dkim_dkimkeys'],
					'settinggroup' => 'dkim',
					'varname' => 'dkim_dkimkeys',
					'type' => 'string',
					'string_regexp' => '/^[a-z0-9\._]+$/i',
					'default' => 'dkim-keys.conf',
					'save_method' => 'storeSettingField',
					),
				'dkimrestart_command' => array(
					'label' => $lng['dkim']['dkimrestart_command'],
					'settinggroup' => 'dkim',
					'varname' => 'dkimrestart_command',
					'type' => 'string',
					'default' => '/etc/init.d/dkim-filter restart',
					'save_method' => 'storeSettingField',
					),
				),
			),
		),
	);

?>