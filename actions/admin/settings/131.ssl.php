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
			'ssl' => array(
					'title' => $lng['admin']['sslsettings'],
					'fields' => array(
							'system_ssl_enabled' => array(
									'label' => $lng['serversettings']['ssl']['use_ssl'],
									'settinggroup' => 'system',
									'varname' => 'use_ssl',
									'type' => 'bool',
									'default' => false,
									'save_method' => 'storeSettingField',
									'overview_option' => true
							),
							'system_ssl_cert_file' => array(
									'label' => $lng['serversettings']['ssl']['ssl_cert_file'],
									'settinggroup' => 'system',
									'varname' => 'ssl_cert_file',
									'type' => 'string',
									'string_type' => 'file',
									'string_emptyallowed' => true,
									'default' => '/etc/apache2/apache2.pem',
									'save_method' => 'storeSettingField',
							),
							'system_ssl_key_file' => array(
									'label' => $lng['serversettings']['ssl']['ssl_key_file'],
									'settinggroup' => 'system',
									'varname' => 'ssl_key_file',
									'type' => 'string',
									'string_type' => 'file',
									'string_emptyallowed' => true,
									'default' => '/etc/apache2/apache2.key',
									'save_method' => 'storeSettingField',
							),
							'system_ssl_ca_file' => array(
									'label' => $lng['serversettings']['ssl']['ssl_ca_file'],
									'settinggroup' => 'system',
									'varname' => 'ssl_ca_file',
									'type' => 'string',
									'string_type' => 'file',
									'string_emptyallowed' => true,
									'default' => '',
									'save_method' => 'storeSettingField',
							),
							'system_ssl_cert_chainfile' => array(
									'label' => $lng['admin']['ipsandports']['ssl_cert_chainfile'],
									'settinggroup' => 'system',
									'varname' => 'ssl_cert_chainfile',
									'type' => 'string',
									'string_type' => 'file',
									'string_emptyallowed' => true,
									'default' => '',
									'save_method' => 'storeSettingField',
							)
					)
			)
		)
	);
