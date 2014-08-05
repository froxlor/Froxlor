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
	'gentoo' => array(
		'label' => 'Gentoo',
		'services' => array(
			'http' => array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => array(
					'apache2' => array(
						'label' => 'Apache2 Webserver',
						'commands' => array(
							$configcommand['vhost'],
							'chown root:0 ' . Settings::Get('system.apacheconf_vhost'),
							'chmod 0600 ' . Settings::Get('system.apacheconf_vhost'),
							$configcommand['diroptions'],
							'chown root:0 ' . Settings::Get('system.apacheconf_diroptions'),
							'chmod 0600 ' . Settings::Get('system.apacheconf_diroptions'),
							'mkdir -p ' . Settings::Get('system.documentroot_prefix'),
							(Settings::Get('system.deactivateddocroot') != '') ? 'mkdir -p ' . Settings::Get('system.deactivateddocroot') : '',
							'mkdir -p ' . Settings::Get('system.logfiles_directory'),
							'mkdir -p ' . Settings::Get('system.mod_fcgid_tmpdir'),
							'chmod 1777 ' . Settings::Get('system.mod_fcgid_tmpdir')
						),
						'files' => ((int)Settings::Get('phpfpm.enabled') == 1) ?
						array(
							'etc_apache2_modules.d_70_fastcgi.conf' => '/etc/apache2/modules.d/70_fastcgi.conf'
						)
						:
						null,
						'restart' => array(
							'rc-update add apache2 default',
							'/etc/init.d/apache2 restart'
						)
					),
					'lighttpd' => array(
						'label' => 'Lighttpd Webserver',
						'commands_1' => array(
							'emerge -av lighttpd'
						),
						'files' => array(
							'etc_lighttpd.conf' => '/etc/lighttpd/lighttpd.conf'
						),
						'commands_2' => array(
							$configcommand['vhost'],
							$configcommand['diroptions'],
							$configcommand['v_inclighty'],
							$configcommand['d_inclighty'],
							'mkdir -p ' . Settings::Get('system.documentroot_prefix'),
							'mkdir -p ' . Settings::Get('system.logfiles_directory'),
							(Settings::Get('system.deactivateddocroot') != '') ? 'mkdir -p ' . Settings::Get('system.deactivateddocroot') : '',
							'rc-update add lighttpd default'
						),
						'restart' => array(
							'/etc/init.d/lighttpd restart'
						)
					),
					'nginx' => array(
						'label' => 'Nginx Webserver',
						'commands_1' => array(
							'emerge nginx',
						),
						'files' => array(
							'etc_nginx_nginx.conf' => '/etc/nginx/nginx.conf',
							'etc_init.d_php-fcgi' => '/etc/init.d/php-fcgi'
						),
						'commands_2' => array(
							'mkdir -p ' . Settings::Get('system.documentroot_prefix'),
							'mkdir -p ' . Settings::Get('system.logfiles_directory'),
							(Settings::Get('system.deactivateddocroot') != '') ? 'mkdir -p ' . Settings::Get('system.deactivateddocroot') : '',
							'mkdir -p ' . Settings::Get('system.mod_fcgid_tmpdir'),
							'chmod 1777 ' . Settings::Get('system.mod_fcgid_tmpdir'),
							'chmod u+x /etc/init.d/php-fcgi',
							'rc-update add nginx default'
						),
						'restart' => array(
							'/etc/init.d/nginx restart'
						)
					),
				)
			),
			'dns' => array(
				'label' => $lng['admin']['configfiles']['dns'],
				'daemons' => array(
					'bind' => array(
						'label' => 'Bind9 Nameserver',
						'files' => array(
							'etc_bind_default.zone' => '/etc/bind/default.zone'
						),
						'commands' => array(
							'echo "include \"' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf\";" >> /etc/bind/named.conf',
							'touch ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf',
							'chown named:0 ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf',
							'chmod 0600 ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf',
							'rc-update add named default'
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
					'postfix_courier' => array(
						'label' => 'Postfix/Courier',
						'commands_1' => array(
							($vmail_group === false) ? 'groupadd -g ' . Settings::Get('system.vmail_gid') . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . Settings::Get('system.vmail_uid') . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'echo "mail-mta/postfix -dovecot-sasl sasl" >> /etc/portage/package.use',
							'emerge -av postfix',
							'mkdir -p ' . Settings::Get('system.vmail_homedir'),
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . Settings::Get('system.vmail_homedir'),
							'chmod 0750 ' . Settings::Get('system.vmail_homedir'),
							'mv /etc/postfix/main.cf /etc/postfix/main.cf.gentoo',
							'touch /etc/postfix/main.cf',
							'touch /etc/sasl2/smtpd.conf',
							'chown root:root /etc/postfix/main.cf',
							'chown root:root /etc/sasl2/smtpd.conf',
							'chmod 0644 /etc/postfix/main.cf',
							'chmod 0600 /etc/sasl2/smtpd.conf',
							'for suffix in {alias,mailbox,uid,gid}_maps mailbox_domains sender_permissions; do',
							' touch /etc/postfix/mysql-virtual_${suffix}.cf',
							' chown root:postfix /etc/postfix/mysql-virtual_${suffix}.cf',
							' chmod 0640 /etc/postfix/mysql-virtual_${suffix}.cf',
							'done'
						),
						'files' => array(
							'etc_postfix_main.cf' => '/etc/postfix/main.cf',
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql-virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql-virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql-virtual_mailbox_maps.cf',
							'etc_postfix_mysql-virtual_sender_permissions.cf' => '/etc/postfix/mysql-virtual_sender_permissions.cf',
							'etc_postfix_mysql-virtual_uid_maps.cf' => '/etc/postfix/mysql-virtual_uid_maps.cf',
							'etc_postfix_mysql-virtual_gid_maps.cf' => '/etc/postfix/mysql-virtual_gid_maps.cf',
							'etc_sasl2_smtpd.conf' => '/etc/sasl2/smtpd.conf'
						),
						'commands_2' => array(
							'rc-update add postfix default'
						),
						'restart' => array(
							'/etc/init.d/postfix restart'
						)
					),
					'postfix_dovecot' => array(
						'label' => 'Postfix/Dovecot',
						'commands_1' => array(
							($vmail_group === false) ? 'groupadd -g ' . Settings::Get('system.vmail_gid') . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . Settings::Get('system.vmail_uid') . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'echo "mail-mta/postfix dovecot-sasl -sasl" >> /etc/portage/package.use',
							'emerge -av postfix',
							'mkdir -p ' . Settings::Get('system.vmail_homedir'),
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . Settings::Get('system.vmail_homedir'),
							'chmod 0750 ' . Settings::Get('system.vmail_homedir'),
							'mv /etc/postfix/main.cf /etc/postfix/main.cf.gentoo',
							'touch /etc/postfix/{main,master}.cf',
							'chown root:root /etc/postfix/{main,master}.cf',
							'chmod 0644 /etc/postfix/{main,master}.cf',
							'for suffix in {alias,mailbox,uid,gid}_maps mailbox_domains sender_permissions; do',
							' touch /etc/postfix/mysql-virtual_${suffix}.cf',
							' chown root:postfix /etc/postfix/mysql-virtual_${suffix}.cf',
							' chmod 0640 /etc/postfix/mysql-virtual_${suffix}.cf',
							'done'
						),
						'files' => array(
							'etc_postfix_main.cf' => '/etc/postfix/main.cf',
							'etc_postfix_master.cf' => '/etc/postfix/master.cf',
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql-virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql-virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql-virtual_mailbox_maps.cf',
							'etc_postfix_mysql-virtual_sender_permissions.cf' => '/etc/postfix/mysql-virtual_sender_permissions.cf',
							'etc_postfix_mysql-virtual_uid_maps.cf' => '/etc/postfix/mysql-virtual_uid_maps.cf',
							'etc_postfix_mysql-virtual_gid_maps.cf' => '/etc/postfix/mysql-virtual_gid_maps.cf'
						),
						'commands_2'  => array(
							'rc-update add postfix default'
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
							'newaliases',
							'/etc/init.d/postfix restart'
						)
					),
					'dkim' => array(
						'label' => 'DomainKey filter',
						'commands_1' => array(
							'emerge dkim-milter',
							'emerge --config mail-filter/dkim-milter',
							'mkdir -p /etc/postfix/dkim'
						),
						'files' => array(
							'dkim-filter.conf' => '/etc/mail/dkim-filter/dkim-filter.conf'
						),
						'commands_2' => array(
							'echo "smtpd_milters = inet:localhost:8891
milter_macro_daemon_name = SIGNING
milter_default_action = accept" >> /etc/postfix/main.cf',
							'rc-update add dkim-filter default'
						),
						'restart' => array(
							'/etc/init.d/postfix restart'
						)
					)
				)
			),
			'mail' => array(
				'label' => $lng['admin']['configfiles']['mail'],
				'daemons' => array(
					'courier' => array(
						'label' => 'Courier-IMAP (POP3/IMAP)',
						'commands_1' => array(
							'rm /etc/courier/authlib/authdaemonrc',
							'rm /etc/courier/authlib/authmysqlrc',
							'rm /etc/courier-imap/pop3d',
							'rm /etc/courier-imap/imapd',
							'rm /etc/courier-imap/pop3d-ssl',
							'rm /etc/courier-imap/imapd-ssl',
							'touch /etc/courier/authlib/authdaemonrc',
							'touch /etc/courier/authlib/authmysqlrc',
							'touch /etc/courier-imap/pop3d',
							'touch /etc/courier-imap/imapd',
							'touch /etc/courier-imap/pop3d-ssl',
							'touch /etc/courier-imap/imapd-ssl'
						),
						'files' => array(
							'etc_courier_authlib_authdaemonrc' => '/etc/courier/authlib/authdaemonrc',
							'etc_courier_authlib_authmysqlrc' => '/etc/courier/authlib/authmysqlrc',
							'etc_courier-imap_pop3d' => '/etc/courier-imap/pop3d',
							'etc_courier-imap_imapd' => '/etc/courier-imap/imapd',
							'etc_courier-imap_pop3d-ssl' => '/etc/courier-imap/pop3d-ssl',
							'etc_courier-imap_imapd-ssl' => '/etc/courier-imap/imapd-ssl'
						),
						'commands_2' => array(
							'chown root:0 /etc/courier/authlib/authdaemonrc',
							'chown root:0 /etc/courier/authlib/authmysqlrc',
							'chown root:0 /etc/courier-imap/pop3d',
							'chown root:0 /etc/courier-imap/imapd',
							'chown root:0 /etc/courier-imap/pop3d-ssl',
							'chown root:0 /etc/courier-imap/imapd-ssl',
							'chmod 0600 /etc/courier/authlib/authdaemonrc',
							'chmod 0600 /etc/courier/authlib/authmysqlrc',
							'chmod 0600 /etc/courier-imap/pop3d',
							'chmod 0600 /etc/courier-imap/imapd',
							'chmod 0600 /etc/courier-imap/pop3d-ssl',
							'chmod 0600 /etc/courier-imap/imapd-ssl',
							'rc-update add courier-authlib default',
							'rc-update add courier-pop3d default',
							'rc-update add courier-imapd default'
						),
						'restart' => array(
							'/etc/init.d/courier-authlib restart',
							'/etc/init.d/courier-pop3d restart',
							'/etc/init.d/courier-imapd restart'
						)
					),
					'dovecot' => array(
						'label' => 'Dovecot',
						'commands_1' => array(
							'echo "net-mail/dovecot mysql" >> /etc/portage/package.use',
							'emerge -av dovecot',
							'mv /etc/dovecot/dovecot.conf /etc/dovecot/dovecot.conf.gentoo',
							'mv /etc/dovecot/dovecot-sql.conf /etc/dovecot/dovecot-sql.conf.gentoo',
							'touch /etc/dovecot/dovecot.conf',
							'touch /etc/dovecot/dovecot-sql.conf',
						),
						'files' => array(
							'etc_dovecot_dovecot.conf' => '/etc/dovecot/dovecot.conf',
							'etc_dovecot_dovecot-sql.conf' => '/etc/dovecot/dovecot-sql.conf'
						),
						'commands_2' => array(
							'chmod 0640 /etc/dovecot/dovecot-sql.conf',
							'rc-update add dovecot default'
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
						'commands_1' => array(
							'echo "net-ftp/proftpd mysql" >> /etc/portage/package.use',
							'emerge -av proftpd',
							'touch /etc/proftpd/proftpd.conf'
						),
						'files' => array(
							'etc_proftpd_proftpd.conf' => '/etc/proftpd/proftpd.conf'
						),
						'commands_2' => array(
							'chown root:0 /etc/proftpd/proftpd.conf',
							'chmod 0600 /etc/proftpd/proftpd.conf',
							'rc-update add proftpd default'
						),
						'restart' => array(
							'/etc/init.d/proftpd restart'
						)
					),
					'pureftpd' => array(
						'label' => 'PureFTPD',
						'commands_1' => array(
							'emerge pure-ftpd'
						),
						'files' => array(
							'etc_conf.d_pure-ftpd' => '/etc/conf.d/pure-ftpd',
							'etc_pureftpd-mysql.conf' => '/etc/pureftpd-mysql.conf'
						),
						'commands_2' => array(
							'chown root:0 /etc/conf.d/pure-ftpd',
							'chmod 0644 /etc/conf.d/pure-ftpd',
							'chown root:0 /etc/pureftpd-mysql.conf',
							'chmod 0600 /etc/pureftpd-mysql.conf',
							'rc-update add pure-ftpd default'
						),
						'restart' => array(
							'/etc/init.d/pure-ftpd restart'
						)
					)
				)
			),
			'etc' => array(
				'label' => $lng['admin']['configfiles']['etc'],
				'daemons' => array(
					'cron' => array(
						'label' => 'Crond (cronscript)',
						'commands_1' => array(
							'touch /etc/cron.d/froxlor',
							'chown root:0 /etc/cron.d/froxlor',
							'chmod 0640 /etc/cron.d/froxlor'
						),
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
							'emerge awstats',
							'sed -i.bak \'s/^DirData/# DirData/\' '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.model.conf'),
							'sed -i.bak \'s|^\\(DirIcons=\\).*$|\\1\\"/awstats-icon\\"|\' '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.model.conf'),
							'# Please make sure you deactivate awstats own cronjob as Froxlor handles that itself',
							'rm /etc/cron.d/awstats'
						),
					),
					'libnss' => array(
						'label' => 'libnss (system login with mysql)',
						'commands_1' => array(
							'emerge -av libnss-mysql'
						),
						'files' => array(
							'etc_libnss-mysql.cfg' => '/etc/libnss-mysql.cfg',
							'etc_libnss-mysql-root.cfg' => '/etc/libnss-mysql-root.cfg',
							'etc_nsswitch.conf' => '/etc/nsswitch.conf',
						),
						'commands_2' => array(
							'chmod 600 /etc/libnss-mysql.cfg /etc/libnss-mysql-root.cfg',
							'rc-update add nscd default'
						),
						'restart' => array(
							'/etc/init.d/nscd restart'
						)
					),
					'logrotate' => array(
						'label' => 'Logrotate',
						'commands_1' => array(
							'emerge -av app-admin/logrotate',
							'touch /etc/logrotate.d/froxlor',
							'chmod 644 /etc/logrotate.d/froxlor'
						),
						'files' => array(
							'etc_logrotated_froxlor' => '/etc/logrotate.d/froxlor'
						),
						'commands_2' => array(
							'# emerge automatically adds a daily cronjob for logrotate',
							'# you do not have to do anything else :)'
						)
					)
				)
			)
		)
	)
);

?>
