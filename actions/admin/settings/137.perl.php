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
 * @package    Settings
 *
 */

return array(
	'groups' => array(
		'perl' => array(
			'title' => $lng['admin']['perl_settings'],
			'fields' => array(
				'perl_path' => array(
					'label' => $lng['serversettings']['perl_path'],
					'settinggroup' => 'system',
					'varname' => 'perl_path',
					'type' => 'string',
					'default' => '/usr/bin/perl',
					'save_method' => 'storeSettingField',
					'websrv_avail' => array('lighttpd')
					),	
				'system_perl_suexecworkaround' => array(
					'label' => $lng['serversettings']['perl']['suexecworkaround'],
					'settinggroup' => 'perl',
					'varname' => 'suexecworkaround',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'websrv_avail' => array('apache2')
					),
				'system_perl_suexeccgipath' => array(
					'label' => $lng['serversettings']['perl']['suexeccgipath'],
					'settinggroup' => 'perl',
					'varname' => 'suexecpath',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/var/www/cgi-bin/',
					'save_method' => 'storeSettingField',
					'websrv_avail' => array('apache2')
					),
				'perl_server' => array(
					'label' => $lng['serversettings']['perl_server'],
					'settinggroup' => 'serversettings',
					'varname' => 'perl_server',
					'type' => 'string',
					'default' => 'unix:/var/run/nginx/cgiwrap-dispatch.sock',
					'save_method' => 'storeSettingField',
					'websrv_avail' => array('nginx')
					),
				),
			),
		),
	);

?>
