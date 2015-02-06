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
 * @author     Ante de Baas <mail@debaas.net> (2014-)
 * @author     Froxlor team <team@froxlor.org> (2014-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Configfiles
 *
 */

// Try to guess user/group from settings' email UID/GID
$vmail_user=posix_getpwuid(Settings::Get('system.vmail_uid'));
$vmail_group=posix_getgrgid(Settings::Get('system.vmail_gid'));

/* If one of them are not set, call it 'vmail' and suggest creating user/group
 * in scripts. */
if ($vmail_user === false) {
	$vmail_username="vmail";
} else {
	$vmail_username=$vmail_user['name'];
}
if ($vmail_group === false) {
	$vmail_groupname="vmail";
} else {
	$vmail_groupname=$vmail_group['name'];
}

return array(
	'rhel7' => array(
		'label' => 'RHEL / CentOS 7',
		'services' => array(
			'http' => array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => array(
					'apache' => array(
						'label' => 'Apache 2.4',
						'commands' => array(
							'mkdir -p ' . Settings::Get('system.documentroot_prefix'),
							'mkdir -p ' . Settings::Get('system.logfiles_directory'),
							(Settings::Get('system.deactivateddocroot') != '') ? 'mkdir -p ' . Settings::Get('system.deactivateddocroot') : ''
						),
						'restart' => array(
							'/usr/bin/systemctl reload-or-restart httpd.service'
						)
					),
				),
			),
			'smtp' => array(
				'label' => $lng['admin']['configfiles']['smtp'],
				'daemons' => array(
					'postfix' => array(
						'label' => 'Postfix 2.10',
						'commands_install' => array(
							'yum install postfix',
							'systemctl enable postfix.service',
						),
						'commands' => array(
							($vmail_group === false) ? 'groupadd -g ' . Settings::Get('system.vmail_gid') . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . Settings::Get('system.vmail_uid') . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'mkdir -p ' . Settings::Get('system.vmail_homedir'),
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . Settings::Get('system.vmail_homedir'),
							'touch /etc/postfix/mysql-virtual_alias_maps.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'touch /etc/postfix/mysql-virtual_sender_permissions.cf',
							'chown root:root /etc/postfix/mysql-*.cf',
							'chmod 0644 /etc/postfix/mysql-*.cf',
						),
						'files' => array(
							'etc_postfix_main.cf' => '/etc/postfix/main.cf',
							'etc_postfix_master.cf' => '/etc/postfix/master.cf',
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql-virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql-virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql-virtual_mailbox_maps.cf',
							'etc_postfix_mysql-virtual_sender_permissions.cf' => '/etc/postfix/mysql-virtual_sender_permissions.cf'
						),
						'restart' => array(
							'systemctl reload-or-restart postfix.service',
							'newaliases'
						)
					),
				)
			),
			'mail' => array(
				'label' => $lng['admin']['configfiles']['mail'],
				'daemons' => array(
					'dovecot' => array(
						'label' => 'Dovecot 2.2',
						'commands_install' => array(
							'yum install dovecot dovecot-mysql dovecot-pigeonhole',
							'systemctl enable dovecot.service',
							'touch /etc/dovecot/dovecot-sql.conf.ext',
							'chmod 0600 /etc/dovecot/dovecot-sql.conf.ext',
						),
						'commands' => array(
							'yum install dovecot dovecot-mysql dovecot-pigeonhole',
							'touch /etc/dovecot/dovecot-sql.conf.ext',
							'chmod 0600 /etc/dovecot/dovecot-sql.conf.ext',
						),
						'files' => array(
							'etc_dovecot_dovecot.conf' => '/etc/dovecot/dovecot.conf',
							'etc_dovecot_dovecot-sql.conf.ext' => '/etc/dovecot/dovecot-sql.conf.ext',
							'etc_dovecot_conf.d_10-auth.conf' => '/etc/dovecot/conf.d/10-auth.conf',
							'etc_dovecot_conf.d_10-logging.conf' => '/etc/dovecot/conf.d/10-logging.conf',
							'etc_dovecot_conf.d_10-mail.conf' => '/etc/dovecot/conf.d/10-mail.conf',
							'etc_dovecot_conf.d_10-master.conf' => '/etc/dovecot/conf.d/10-master.conf',
							'etc_dovecot_conf.d_10-ssl.conf' => '/etc/dovecot/conf.d/10-ssl.conf',
							'etc_dovecot_conf.d_15-lda.conf' => '/etc/dovecot/conf.d/15-lda.conf',
							'etc_dovecot_conf.d_15-mailboxes.conf' => '/etc/dovecot/conf.d/15-mailboxes.conf',
							'etc_dovecot_conf.d_20-imap.conf' => '/etc/dovecot/conf.d/20-imap.conf',
							'etc_dovecot_conf.d_20-lmtp.conf' => '/etc/dovecot/conf.d/20-lmtp.conf',
							'etc_dovecot_conf.d_20-managesieve.conf' => '/etc/dovecot/conf.d/20-managesieve.conf',
							'etc_dovecot_conf.d_20-pop3.conf' => '/etc/dovecot/conf.d/20-pop3.conf',
							'etc_dovecot_conf.d_90-sieve.conf' => '/etc/dovecot/conf.d/90-sieve.conf',
						),
						'restart' => array(
							'systemctl reload-or-restart dovecot.service',
						)
					),
				)
			),
			'ftp' => array(
				'label' => $lng['admin']['configfiles']['ftp'],
				'daemons' => array(
					'proftpd' => array(
						'label' => 'ProFTPd 1.3',
						'commands_install' => array(
							'yum install proftpd proftpd-mysql',
							'systemctl enable proftpd.service',
						),
						'files' => array(
							'etc_proftpd_proftpd.conf' => '/etc/proftpd/proftpd.conf'
						),
						'restart' => array(
							'systemctl reload-or-restart proftpd.service'
						)
					),
				)
			),
			'etc' => array(
				'label' => $lng['admin']['configfiles']['etc'],
				'daemons' => array(
					'cron' => array(
						'label' => 'Crond (cronscript)',
						'files' => array(
							'etc_cron.d_froxlor' => '/etc/cron.d/froxlor'
						),
						'restart' => array(
							'systemctl reload-or-restart crond.service'
						)
					),
					'awstats' => array(
						'label' => 'Awstats',
						'commands' => array(
							'sed -i.bak \'s/^DirData/# DirData/\' '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.model.conf'),
							'sed -i.bak \'s|^\\(DirIcons=\\).*$|\\1\\"/awstats-icon\\"|\' '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.model.conf'),
							'# Please make sure you deactivate awstats own cronjob as Froxlor handles that itself'
						)
					)
				)
			)
		)
	)
);
