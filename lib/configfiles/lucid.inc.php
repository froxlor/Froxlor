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
	'ubuntu_lucid' => array(
		'label' => 'Ubuntu 10.04 (Lucid) [deprecated]',
		'services' => array(
			'http' => array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => array(
					'apache2' => array(
						'label' => 'Apache 2',
						'commands' => array(
							'mkdir -p ' . Settings::Get('system.documentroot_prefix'),
							'mkdir -p ' . Settings::Get('system.logfiles_directory'),
							(Settings::Get('system.deactivateddocroot') != '') ? 'mkdir -p ' . Settings::Get('system.deactivateddocroot') : '',
							'mkdir -p ' . Settings::Get('system.mod_fcgid_tmpdir'),
							'chmod 1777 ' . Settings::Get('system.mod_fcgid_tmpdir'),
							'a2dismod userdir'
						),
						'files' => ((int)Settings::Get('phpfpm.enabled') == 1) ?
						array(
							'etc_apache2_mods-enabled_fastcgi.conf' => '/etc/apache2/mods-enabled/fastcgi.conf'
						)
						:
						null,
						'restart' => array(
							'/etc/init.d/apache2 restart'
						),
					),
					'lighttpd' => array(
						'label' => 'Lighttpd Webserver',
						'commands_1' => array(
							'apt-get install lighttpd',
						),
						'files' => array(
							'etc_lighttpd.conf' => '/etc/lighttpd/lighttpd.conf',
						),
						'commands_2' => array(
							$configcommand['vhost'],
							$configcommand['diroptions'],
							$configcommand['v_inclighty'],
							$configcommand['d_inclighty'],
							'lighty-disable-mod cgi',
							'lighty-disable-mod fastcgi',
							'mkdir -p ' . Settings::Get('system.documentroot_prefix'),
							'mkdir -p ' . Settings::Get('system.logfiles_directory'),
							(Settings::Get('system.deactivateddocroot') != '') ? 'mkdir -p ' . Settings::Get('system.deactivateddocroot') : '',
							'mkdir -p ' . Settings::Get('system.mod_fcgid_tmpdir'),
							'chmod 1777 ' . Settings::Get('system.mod_fcgid_tmpdir')
						),
						'restart' => array(
							'/etc/init.d/lighttpd restart'
						),
					),
					'nginx' => array(
						'label' => 'Nginx Webserver',
						'commands_1' => array(
							'apt-get install nginx php5-cgi',
						),
						'files' => array(
							'etc_nginx_nginx.conf' => '/etc/nginx/nginx.conf',
							'etc_init.d_php-fcgi' => '/etc/init.d/php-fcgi'
						),
						'commands_2' => array(
							'rm /etc/nginx/sites-enabled/default',
							'mkdir -p ' . Settings::Get('system.documentroot_prefix'),
							'mkdir -p ' . Settings::Get('system.logfiles_directory'),
							(Settings::Get('system.deactivateddocroot') != '') ? 'mkdir -p ' . Settings::Get('system.deactivateddocroot') : '',
							'mkdir -p ' . Settings::Get('system.mod_fcgid_tmpdir'),
							'chmod 1777 ' . Settings::Get('system.mod_fcgid_tmpdir'),
							'chmod u+x /etc/init.d/php-fcgi'
						),
						'restart' => array(
							'/etc/init.d/php-fcgi start',
							'/etc/init.d/nginx restart'
						)
					),
				),
			),
			'dns' => array(
				'label' => $lng['admin']['configfiles']['dns'],
				'daemons' => array(
					'bind' => array(
						'label' => 'Bind9',
						'commands' => array(
							'apt-get install bind9',
							'echo "include \"' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf\";" >> /etc/bind/named.conf',
							'touch ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf',
							'chown root:bind ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf',
							'chmod 0644 ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf'
						),
						'restart' => array(
							'/etc/init.d/bind9 restart'
						)
					),
					'powerdns' => array(
						'label' => 'PowerDNS',
						'files' => array(
							'etc_powerdns_pdns.conf' => '/etc/powerdns/pdns.conf',
							'etc_powerdns_pdns-froxlor.conf' => '/etc/powerdns/pdns_froxlor.conf',
						),
						'restart' => array(
							'/etc/init.d/pdns restart'
						)
					),
				)
			),
			'smtp' => array(
				'label' => $lng['admin']['configfiles']['smtp'],
				'daemons' => array(
					'postfix_courier' => array(
						'label' => 'Postfix/Courier',
						'commands' => array(
							($vmail_group === false) ? 'groupadd -g ' . Settings::Get('system.vmail_gid') . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . Settings::Get('system.vmail_uid') . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'mkdir -p ' . Settings::Get('system.vmail_homedir'),
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . Settings::Get('system.vmail_homedir'),
							'apt-get install postfix postfix-mysql libsasl2-2 libsasl2-modules libsasl2-modules-sql',
							'mkdir -p /var/spool/postfix/etc/pam.d',
							'mkdir -p /var/spool/postfix/var/run/mysqld',
							'touch /etc/postfix/mysql-virtual_alias_maps.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'touch /etc/postfix/mysql-virtual_sender_permissions.cf',
							'touch /etc/postfix/sasl/smtpd.conf',
							'chown root:root /etc/postfix/main.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_alias_maps.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_sender_permissions.cf',
							'chown root:root /etc/postfix/sasl/smtpd.conf',
							'chmod 0644 /etc/postfix/main.cf',
							'chmod 0640 /etc/postfix/mysql-virtual_alias_maps.cf',
							'chmod 0640 /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'chmod 0640 /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'chmod 0640 /etc/postfix/mysql-virtual_sender_permissions.cf',
							'chmod 0600 /etc/postfix/sasl/smtpd.conf',
						),
						'files' => array(
							'etc_postfix_main.cf' => '/etc/postfix/main.cf',
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql-virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql-virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql-virtual_mailbox_maps.cf',
							'etc_postfix_mysql-virtual_sender_permissions.cf' => '/etc/postfix/mysql-virtual_sender_permissions.cf',
							'etc_postfix_sasl_smtpd.conf' => '/etc/postfix/sasl/smtpd.conf'
						),
						'restart' => array(
							'newaliases',
							'/etc/init.d/postfix restart'
						)
					),
					'dkim' => array(
						'label' => 'DomainKey filter',
						'commands_1' => array(
							'apt-get install dkim-filter',
							'mkdir -p /etc/postfix/dkim'
						),
						'files' => array(
							'dkim-filter.conf' => '/etc/dkim-filter.conf'
						),
						'commands_2' => array(
							'echo "milter_default_action = accept" >> /etc/postfix/main.cf',
							'echo "milter_protocol = 2" >> /etc/postfix/main.cf',
							'echo "smtpd_milters = inet:localhost:8891" >> /etc/postfix/main.cf',
							'echo "non_smtpd_milters = inet:localhost:8891" >> /etc/postfix/main.cf'
						),
						'restart' => array(
							'/etc/init.d/dkim-filter restart',
							'/etc/init.d/postfix restart'
						)
					),
					'postfix_dovecot' => array(
						'label' => 'Postfix/Dovecot',
						'commands' => array(
							($vmail_group === false) ? 'groupadd -g ' . Settings::Get('system.vmail_gid') . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . Settings::Get('system.vmail_uid') . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'mkdir -p ' . Settings::Get('system.vmail_homedir'),
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . Settings::Get('system.vmail_homedir'),
							'apt-get install postfix postfix-mysql',
							'mkdir -p /var/spool/postfix/etc/pam.d',
							'mkdir -p /var/spool/postfix/var/run/mysqld',
							'touch /etc/postfix/mysql-virtual_alias_maps.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'touch /etc/postfix/mysql-virtual_sender_permissions.cf',
							'chown root:root /etc/postfix/main.cf',
							'chown root:root /etc/postfix/master.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_alias_maps.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'chown root:postfix /etc/postfix/mysql-virtual_sender_permissions.cf',
							'chmod 0644 /etc/postfix/main.cf',
							'chmod 0644 /etc/postfix/master.cf',
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
					'exim4' => array(
						'label' => 'Exim4',
						'commands_1' => array(
							'dpkg-reconfigure exim4-config',
							'# choose "no configuration at this time" and "splitted configuration files" in the dialog'
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
							'apt-get install courier-pop courier-imap courier-authlib-mysql'
						),
						'files' => array(
							'etc_courier_authdaemonrc' => '/etc/courier/authdaemonrc',
							'etc_courier_authmysqlrc' => '/etc/courier/authmysqlrc'
						),
						'restart' => array(
							'/etc/init.d/courier-authdaemon restart',
							'/etc/init.d/courier-pop restart'
						)
					),
					'dovecot' => array(
						'label' => 'Dovecot',
						'commands_1' => array(
							'apt-get install dovecot-imapd dovecot-pop3d dovecot-postfix'
						),
						'files' => array(
							'etc_dovecot_auth.d_01-dovecot-postfix.auth' => '/etc/dovecot/auth.d/01-dovecot-postfix.auth',
							'etc_dovecot_conf.d_01-dovecot-postfix.conf' => '/etc/dovecot/conf.d/01-dovecot-postfix.conf',
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
						'commands' => array(
							'apt-get install proftpd-basic proftpd-mod-mysql'
						),
						'files' => array(
							'etc_proftpd_sql.conf' => '/etc/proftpd/sql.conf',
							'etc_proftpd_modules.conf' => '/etc/proftpd/modules.conf',
							'etc_proftpd_proftpd.conf' => '/etc/proftpd/proftpd.conf'
						),
						'restart' => array(
							'/etc/init.d/proftpd restart'
						)
					),
					'pure-ftpd' => array(
						'label' => 'Pure FTPd',
						'commands_1' => array(
							'apt-get install pure-ftpd-common pure-ftpd-mysql'
						),
						'files' => array(
							'etc_pure-ftpd_conf_MinUID' => '/etc/pure-ftpd/conf/MinUID',
							'etc_pure-ftpd_conf_MySQLConfigFile' => '/etc/pure-ftpd/conf/MySQLConfigFile',
							'etc_pure-ftpd_conf_NoAnonymous' => '/etc/pure-ftpd/conf/NoAnonymous',
							'etc_pure-ftpd_conf_MaxIdleTime' => '/etc/pure-ftpd/conf/MaxIdleTime',
							'etc_pure-ftpd_conf_ChrootEveryone' => '/etc/pure-ftpd/conf/ChrootEveryone',
							'etc_pure-ftpd_conf_PAMAuthentication' => '/etc/pure-ftpd/conf/PAMAuthentication',
							'etc_pure-ftpd_db_mysql.conf' => '/etc/pure-ftpd/db/mysql.conf',
							'etc_pure-ftpd_conf_CustomerProof' => '/etc/pure-ftpd/conf/CustomerProof',
							'etc_pure-ftpd_conf_Bind' => '/etc/pure-ftpd/conf/Bind',
							'etc_default_pure-ftpd-common' => '/etc/default/pure-ftpd-common'
						),
						'commands_2' => array(
							'chmod 0640 /etc/pure-ftpd/db/mysql.conf'
						),
						'restart' => array(
							'/etc/init.d/pure-ftpd-mysql restart'
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
							'apt-get install awstats',
							'cp /usr/share/doc/awstats/examples/awstats_buildstaticpages.pl '.makeCorrectDir(Settings::Get('system.awstats_path')),
							'mv '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.conf').' '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.model.conf'),
							'sed -i.bak \'s/^DirData/# DirData/\' '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.model.conf'),
							'# Please make sure you deactivate awstats own cronjob as Froxlor handles that itself',
							'rm /etc/cron.d/awstats'
						),
					),
					'libnss' => array(
						'label' => 'libnss (system login with mysql)',
						'commands' => array(
							'apt-get install libnss-mysql nscd',
							'chmod 600 /etc/nss-mysql.conf /etc/nss-mysql-root.conf'
						),
						'files' => array(
							'etc_nss-mysql.conf' => '/etc/nss-mysql.conf',
							'etc_nss-mysql-root.conf' => '/etc/nss-mysql-root.conf',
							'etc_nsswitch.conf' => '/etc/nsswitch.conf',
						),
						'restart' => array(
							'/etc/init.d/nscd restart'
						)
					),
					'logrotate' => array(
						'label' => 'Logrotate',
						'commands_1' => array(
							'apt-get install logrotate',
							'touch /etc/logrotate.d/froxlor',
							'chmod 644 /etc/logrotate.d/froxlor'
						),
						'files' => array(
							'etc_logrotated_froxlor' => '/etc/logrotate.d/froxlor'
						),
						'commands_2' => array(
							'# apt automatically adds a daily cronjob for logrotate',
							'# you do not have to do anything else :)'
						)
					)
				)
			)
		)
	)
);

?>
