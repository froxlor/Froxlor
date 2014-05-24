<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2011- the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Andrej Semen <asemen@suse.de> (2010-2011)
 * @author     Wolfgang Rosenauer <wr@rosenauer.org> (2011)
 * @author     Froxlor team <team@froxlor.org> (2011-)
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
	'sle_11' => array(
		'label' => 'SUSE Linux Enterprise 11',
		'services' => array(
			'http' => array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => array(
					'apache' => array(
						'label' => 'Apache',
						'commands' => array(
							'mkdir -p ' . Settings::Get('system.documentroot_prefix'),
							'mkdir -p ' . Settings::Get('system.logfiles_directory'),
							'Maybe add to /etc/apache2/httpd.conf',
							'Alias /mail /srv/www/htdocs/roundcubemail',
							'Alias /webmail /srv/www/htdocs/squirrelmail',
							(Settings::Get('system.deactivateddocroot') != '') ? 'mkdir -p ' . Settings::Get('system.deactivateddocroot') : ''
						),
						'restart' => array(
							' '.
							'/etc/init.d/apache2 restart'
						)
					),
				)
			),
			'dns' => array(
				'label' => $lng['admin']['configfiles']['dns'],
				'daemons' => array(
					'bind' => array(
						'label' => 'Bind9',
						'commands' => array(
							'Add froxlor_bind.conf to the NAMED_CONF_INCLUDE_FILES in /etc/sysconfig/named'
						),
						'restart' => array(
							'/etc/init.d/named restart'
						)
					),
				)
			),
			'smtp' => array(
				'label' => $lng['admin']['configfiles']['smtp'],
				'daemons' => array(
					'postfix' => array(
						'label' => 'Postfix',
						'files' => array(
							'etc_postfix_main.cf' => '/etc/postfix/main.cf',
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql_virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql_virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql_virtual_mailbox_maps.cf',
							'etc_sasl2_smtpd.conf' => '/etc/sasl2/smtpd.conf'
						),
						'commands' => array(
							($vmail_group === false) ? 'groupadd -g ' . Settings::Get('system.vmail_gid') . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . Settings::Get('system.vmail_uid') . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'mkdir -p ' . Settings::Get('system.vmail_homedir'),
							'chown -R ' . $vmail_username . ':' . $vmail_groupname . ' ' . Settings::Get('system.vmail_homedir'),
							'mkdir -p /var/spool/postfix/etc/pam.d',
							'touch /etc/postfix/mysql-virtual_alias_maps.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'touch /etc/sasl2/smtpd.conf',
							'chmod 660 /etc/postfix/mysql_virtual_alias_maps.cf',
							'chmod 660 /etc/postfix/mysql_virtual_mailbox_domains.cf',
							'chmod 660 /etc/postfix/mysql_virtual_mailbox_maps.cf',
							'chmod 660 /etc/sasl2/smtpd.conf',
							'chgrp postfix /etc/postfix/mysql_virtual_alias_maps.cf',
							'chgrp postfix /etc/postfix/mysql_virtual_mailbox_domains.cf',
							'chgrp postfix /etc/postfix/mysql_virtual_mailbox_maps.cf',
							'chgrp postfix /etc/sasl2/smtpd.conf'
						),
						'restart' => array(
							'/etc/init.d/postfix restart'
						)
					),
					'postfix_mxaccess' => array(
						'label' => 'Postfix MX-Access (anti spam)',
						'files' => array(
							'etc_postfix_mx_access' => '/etc/postfix/mx_access',
							'etc_postfix_main.cf' => '/etc/postfix/main.cf'
						),
						'commands_1' => array(
							'postmap /etc/postfix/mx_access'
						),
						'restart' => array(
							'/etc/init.d/postfix restart'
						)
					),
					'postfix_dovecot' => array(
						'label' => 'Postfix/Dovecot',
						'commands' => array(
							($vmail_group === false) ? 'groupadd -g ' . Settings::Get('system.vmail_gid') . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . Settings::Get('system.vmail_uid') . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'zypper install postfix postfix-mysql',
							'mkdir -p /var/spool/postfix/etc/pam.d',
							'mkdir -p /var/spool/postfix/var/run/mysqld',
							'mkdir -p ' . Settings::Get('system.vmail_homedir'),
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . Settings::Get('system.vmail_homedir'),
							'touch /etc/postfix/mysql-virtual_alias_maps.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'touch /etc/postfix/mysql-virtual_sender_permissions.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_alias_maps.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_sender_permissions.cf',
							'chmod 0640 /etc/postfix/mysql-virtual_alias_maps.cf',
							'chmod 0640 /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'chmod 0640 /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'chmod 0640 /etc/postfix/mysql-virtual_sender_permissions.cf'
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
							'/etc/init.d/postfix restart',
							'newaliases'
						)
					),
					'exim4' => array(
						'label' => 'Exim4',
						'commands_1' => array(
							'zypper install exim'
						),
						'files' => array(
							'etc_exim4_conf.d_acl_30_exim4-config_check_rcpt.rul' => '/etc/exim4/conf.d/acl/30_exim4-config_check_rcpt.rul',
							'etc_exim4_conf.d_auth_30_froxlor-config' => '/etc/exim4/conf.d/auth/30_froxlor-config',
							'etc_exim4_conf.d_main_10_froxlor-config_options' => '/etc/exim4/conf.d/main/10_froxlor-config_options',
							'etc_exim4_conf.d_router_180_froxlor-config' => '/etc/exim4/conf.d/router/180_froxlor-config',
							'etc_exim4_conf.d_transport_30_froxlor-config' => '/etc/exim4/conf.d/transport/30_froxlor-config'
						),
						'commands_2' => array(
							'chmod o-rx /var/lib/exim4',
							'chmod o-rx /etc/exim4/conf.d/main/10_froxlor-config_options'
						),
						'restart' => array(
							'/etc/init.d/exim4 restart'
						)
					)
				)
			),
			'mail' => array(
				'label' => $lng['admin']['configfiles']['mail'],
				'daemons' => array(
					'courier' => array(
						'label' => 'Courier',
						'commands' => array(
							'zypper install courier-imap courier-authlib-mysql'
						),
						'files' => array(
							'etc_authlib_authdaemonrc' => '/etc/authlib/authdaemonrc',
							'etc_authlib_authmysqlrc' => '/etc/authlib/authmysqlrc'
						),
						'restart' => array(
							'/etc/init.d/courier-authdaemon restart',
							'/etc/init.d/courier-pop restart'
						)
					),
					'dovecot' => array(
						'label' => 'Dovecot 1.1',
						'commands_1' => array(
							'zypper install dovecot11'
						),
						'files' => array(
							'etc_dovecot_dovecot.conf' => '/etc/dovecot/dovecot.conf',
							'etc_dovecot_dovecot-sql.conf' => '/etc/dovecot/dovecot-sql.conf'
						),
						'commands_2' => array(
							'chmod 0640 /etc/dovecot/dovecot-sql.conf'

						),
						'restart' => array(
							'/etc/init.d/dovecot restart'
						)
					)
				)
			),
			'ftp' => array(
				'label' => $lng['admin']['configfiles']['ftp'],
				'daemons' => array(
					'proftpd' => array(
						'label' => 'ProFTPd',
						'files' => array(
							'etc_proftpd_modules.conf' => '/etc/proftpd/modules.conf',
							'etc_proftpd_proftpd.conf' => '/etc/proftpd/proftpd.conf'
						),
						'restart' => array(
							'/etc/init.d/proftpd restart'
						)
					),
					'pure-ftpd' => array(
						'label' => 'Pure-FTPd',
						'files' => array(
							'etc_pure-ftpd.conf' => '/etc/pure-ftpd/pure-ftpd.conf',
							'etc_pure-ftpd_mysql.conf' => '/etc/pure-ftpd/pure-ftpd-mysql.conf'
						),
						'restart' => array(
							'/etc/init.d/pure-ftpd restart'
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
							Settings::Get('system.crondreload')
						)
					),
					'awstats' => array(
						'label' => 'Awstats',
						'commands' => array(
							'cp /usr/share/doc/packages/awstats/awstats.model.conf /etc/awstats/',
							'sed -i.bak \'s/^DirData/# DirData/\''.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.model.conf'),
							'# Please make sure you deactivate awstats own cronjob as Froxlor handles that itself'
						)
					)
				)
			)
		)
	)
);

?>
