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
		'mail' => array(
			'title' => $lng['admin']['mailserversettings'],
			'icon' => 'fa-solid fa-envelope',
			'fields' => array(
				'system_vmail_uid' => array(
					'label' => $lng['serversettings']['vmail_uid'],
					'settinggroup' => 'system',
					'varname' => 'vmail_uid',
					'type' => 'number',
					'default' => 2000,
					'min' => 2,
					'max' => 65535,
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'system_vmail_gid' => array(
					'label' => $lng['serversettings']['vmail_gid'],
					'settinggroup' => 'system',
					'varname' => 'vmail_gid',
					'type' => 'number',
					'default' => 2000,
					'min' => 2,
					'max' => 65535,
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'system_vmail_homedir' => array(
					'label' => $lng['serversettings']['vmail_homedir'],
					'settinggroup' => 'system',
					'varname' => 'vmail_homedir',
					'type' => 'text',
					'string_type' => 'dir',
					'default' => '/var/customers/mail/',
					'save_method' => 'storeSettingField'
				),
				'system_vmail_maildirname' => array(
					'label' => $lng['serversettings']['vmail_maildirname'],
					'settinggroup' => 'system',
					'varname' => 'vmail_maildirname',
					'type' => 'text',
					'string_type' => 'dir',
					'default' => 'Maildir',
					'string_emptyallowed' => true,
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'panel_sendalternativemail' => array(
					'label' => $lng['serversettings']['sendalternativemail'],
					'settinggroup' => 'panel',
					'varname' => 'sendalternativemail',
					'type' => 'checkbox',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'system_mail_quota_enabled' => array(
					'label' => $lng['serversettings']['mail_quota_enabled'],
					'settinggroup' => 'system',
					'varname' => 'mail_quota_enabled',
					'type' => 'checkbox',
					'default' => false,
					'save_method' => 'storeSettingField'
				),
				'system_mail_quota' => array(
					'label' => $lng['serversettings']['mail_quota'],
					'settinggroup' => 'system',
					'varname' => 'mail_quota',
					'type' => 'number',
					'default' => 100,
					'save_method' => 'storeSettingField'
				),
				'system_catchall_enabled' => array(
					'label' => $lng['serversettings']['catchall_enabled'],
					'settinggroup' => 'catchall',
					'varname' => 'catchall_enabled',
					'type' => 'checkbox',
					'default' => true,
					'save_method' => 'storeSettingResetCatchall'
				),
				'system_mailtraffic_enabled' => array(
					'label' => $lng['serversettings']['mailtraffic_enabled'],
					'settinggroup' => 'system',
					'varname' => 'mailtraffic_enabled',
					'type' => 'checkbox',
					'default' => true,
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'system_mdaserver' => array(
					'label' => $lng['serversettings']['mdaserver'],
					'settinggroup' => 'system',
					'varname' => 'mdaserver',
					'type' => 'select',
					'default' => 'dovecot',
					'select_var' => array(
						'courier' => 'Courier',
						'dovecot' => 'Dovecot'
					),
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'system_mdalog' => array(
					'label' => $lng['serversettings']['mdalog'],
					'settinggroup' => 'system',
					'varname' => 'mdalog',
					'type' => 'text',
					'string_type' => 'file',
					'default' => '/var/log/mail.log',
					'string_emptyallowed' => true,
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'system_mtaserver' => array(
					'label' => $lng['serversettings']['mtaserver'],
					'settinggroup' => 'system',
					'varname' => 'mtaserver',
					'type' => 'select',
					'default' => 'postfix',
					'select_var' => array(
						'exim4' => 'Exim4',
						'postfix' => 'Postfix'
					),
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				),
				'system_mtalog' => array(
					'label' => $lng['serversettings']['mtalog'],
					'settinggroup' => 'system',
					'varname' => 'mtalog',
					'type' => 'text',
					'string_type' => 'file',
					'default' => '/var/log/mail.log',
					'string_emptyallowed' => true,
					'save_method' => 'storeSettingField',
					'advanced_mode' => true
				)
			)
		)
	)
);
