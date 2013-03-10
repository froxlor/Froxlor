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
		'backup' => array(
			'title' => $lng['backup'],
			'fields' => array(
				'backup_enabled' => array(
					'label' => $lng['serversettings']['backup_enabled'],
					'settinggroup' => 'system',
					'varname' => 'backup_enabled',
					'type' => 'bool',
					'default' => false,
					'cronmodule' => 'froxlor/backup',
					'save_method' => 'storeSettingField',
					'overview_option' => true
				),
				'backup_dir' => array(
					'label' => $lng['serversettings']['backupdir']['description'],
					'settinggroup' => 'system',
					'varname' => 'backup_dir',
					'type' => 'string',
					'string_type' => 'dir',
					'default' => '/var/customers/backups/',
					'string_regexp' => '#^/.*/$#',
					'save_method' => 'storeSettingField',
				),
				'backup_mysqldump_path' => array(
					'label' => $lng['serversettings']['mysqldump_path']['description'],
					'settinggroup' => 'system',
					'varname' => 'backup_mysqldump_path',
					'type' => 'string',
					'default' => '/usr/bin/mysqldump',
					'save_method' => 'storeSettingField',
				),
				'backup_count' => array(
					'label' => $lng['serversettings']['backup_count'],
					'settinggroup' => 'system',
					'varname' => 'backup_count',
					'type' => 'bool',
					'default' => 'true',
					'save_method' => 'storeSettingField',
					'overview_option' => false
				),				
				'backup_bigfile' => array(
					'label' => $lng['serversettings']['backup_bigfile'],
					'settinggroup' => 'system',
					'varname' => 'backup_bigfile',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'overview_option' => false
				),
				'backup_ftp_enabled_' => array(
					'label' => $lng['serversettings']['backup_ftp_enabled'],
					'settinggroup' => 'system',
					'varname' => 'backup_ftp_enabled',
					'type' => 'bool',
					'default' => false,
					'save_method' => 'storeSettingField',
					'overview_option' => false
				),
				'backup_server' => array(
					'label' => $lng['serversettings']['backup_ftp_server'],
					'settinggroup' => 'system',
					'varname' => 'backup_ftp_server',
					'type' => 'string',
					'default' => '',
					'save_method' => 'storeSettingField',
				),
				'backup_user' => array(
					'label' => $lng['serversettings']['backup_ftp_user'],
					'settinggroup' => 'system',
					'varname' => 'backup_ftp_user',
					'type' => 'string',
					'default' => '',
					'save_method' => 'storeSettingField',
				),
				'backup_pass' => array(
					'label' => $lng['serversettings']['backup_ftp_pass'],
					'settinggroup' => 'system',
					'varname' => 'backup_ftp_pass',
					'type' => 'hiddenstring',
					'default' => '',
					'save_method' => 'storeSettingField',
				),
				'backup_passive_mode' => array(
					'label' => $lng['serversettings']['backup_ftp_passive_mode'],
					'settinggroup' => 'system',
					'varname' => 'backup_ftp_passive',
					'type' => 'bool',
					'default' => true,
					'save_method' => 'storeSettingField',
					'overview_option' => false,
				),
				),
			),
		),
	);

?>
