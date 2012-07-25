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
$vmail_user=posix_getpwuid($settings['system']['vmail_uid']);
$vmail_group=posix_getgrgid($settings['system']['vmail_gid']);

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

return Array(
	'ubuntu_lucid' => Array(
		'label' => 'Ubuntu 10.04 (Lucid)',
		'services' => Array(
			'http' => Array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => Array(
					'apache2' => Array(
						'label' => 'Apache 2',
						'commands' => Array(
							'mkdir -p ' . $settings['system']['documentroot_prefix'],
							'mkdir -p ' . $settings['system']['logfiles_directory'],
							($settings['system']['deactivateddocroot'] != '') ? 'mkdir -p ' . $settings['system']['deactivateddocroot'] : '',
							'mkdir -p ' . $settings['system']['mod_fcgid_tmpdir'],
							'chmod 1777 ' . $settings['system']['mod_fcgid_tmpdir'],
							'a2dismod userdir'
						),
						'files' => ((int)$settings['phpfpm']['enabled'] == 1) ?
							Array(
								'etc_apache2_mods-enabled_fastcgi.conf' => '/etc/apache2/mods-enabled/fastcgi.conf'
							)
							:
							null,
						'restart' => Array(
							'/etc/init.d/apache2 restart'
						),
					),
					'lighttpd' => Array(
						'label' => 'Lighttpd Webserver',
						'commands_1' => Array(
							'apt-get install lighttpd',
						),
						'files' => Array(
							'etc_lighttpd.conf' => '/etc/lighttpd/lighttpd.conf',
						),
						'commands_2' => Array(
							$configcommand['vhost'],
							$configcommand['diroptions'],
							$configcommand['v_inclighty'],
							$configcommand['d_inclighty'],
							'lighty-disable-mod cgi',
							'lighty-disable-mod fastcgi',
							'mkdir -p ' . $settings['system']['documentroot_prefix'],
							'mkdir -p ' . $settings['system']['logfiles_directory'],
							($settings['system']['deactivateddocroot'] != '') ? 'mkdir -p ' . $settings['system']['deactivateddocroot'] : '',
							'mkdir -p ' . $settings['system']['mod_fcgid_tmpdir'],
							'chmod 1777 ' . $settings['system']['mod_fcgid_tmpdir']
						),
						'restart' => Array(
							'/etc/init.d/lighttpd restart'
						),
					),
					'nginx' => Array(
						'label' => 'Nginx Webserver',
						'commands_1' => Array(
							'apt-get install nginx php5-cgi',
						),
						'files' => Array(
							'etc_nginx_nginx.conf' => '/etc/nginx/nginx.conf',
							'etc_init.d_php-fcgi' => '/etc/init.d/php-fcgi'
						),
						'commands_2' => Array(
							'rm /etc/nginx/sites-enabled/default',
							'mkdir -p ' . $settings['system']['documentroot_prefix'],
							'mkdir -p ' . $settings['system']['logfiles_directory'],
							'mkdir -p ' . $settings['system']['deactivateddocroot'],
							'mkdir -p ' . $settings['system']['mod_fcgid_tmpdir'],
							'chmod 1777 ' . $settings['system']['mod_fcgid_tmpdir'],
							'chmod u+x /etc/init.d/php-fcgi'
						),
						'restart' => Array(
							'/etc/init.d/php-fcgi start',
							'/etc/init.d/nginx restart'
						)
					),
				),
			),
			'dns' => Array(
				'label' => $lng['admin']['configfiles']['dns'],
				'daemons' => Array(
					'bind' => Array(
						'label' => 'Bind9',
						'commands' => Array(
							'apt-get install bind9',
							'echo "include \"' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf\";" >> /etc/bind/named.conf',
							'touch ' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf',
							'chown root:bind ' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf',
							'chmod 0644 ' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf'
						),
						'restart' => Array(
							'/etc/init.d/bind9 restart'
						)
					),
					'powerdns' => Array(
						'label' => 'PowerDNS',
						'files' => Array(
							'etc_powerdns_pdns.conf' => '/etc/powerdns/pdns.conf',
							'etc_powerdns_pdns-froxlor.conf' => '/etc/powerdns/pdns_froxlor.conf',
						),
						'restart' => Array(
							'/etc/init.d/pdns restart'
						)
					),
				)
			),
			'smtp' => Array(
				'label' => $lng['admin']['configfiles']['smtp'],
				'daemons' => Array(
					'postfix_courier' => Array(
						'label' => 'Postfix/Courier',
						'commands' => Array(
							($vmail_group === false) ? 'groupadd -g ' . $settings['system']['vmail_gid'] . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . $settings['system']['vmail_uid'] . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'mkdir -p ' . $settings['system']['vmail_homedir'],
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . $settings['system']['vmail_homedir'],
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
						'files' => Array(
							'etc_postfix_main.cf' => '/etc/postfix/main.cf',
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql-virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql-virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql-virtual_mailbox_maps.cf',
							'etc_postfix_mysql-virtual_sender_permissions.cf' => '/etc/postfix/mysql-virtual_sender_permissions.cf',
							'etc_postfix_sasl_smtpd.conf' => '/etc/postfix/sasl/smtpd.conf'
						),
						'restart' => Array(
							'newaliases',
							'/etc/init.d/postfix restart'
						)
					),
					'dkim' => Array(
						'label' => 'DomainKey filter',
						'commands_1' => Array(
							'apt-get install dkim-filter',
							'mkdir -p /etc/postfix/dkim'
						),
						'files' => Array(
							'dkim-filter.conf' => '/etc/dkim-filter.conf'
						),
						'commands_2' => Array(
							'echo "milter_default_action = accept" >> /etc/postfix/main.cf',
							'echo "milter_protocol = 2" >> /etc/postfix/main.cf',
							'echo "smtpd_milters = inet:localhost:8891" >> /etc/postfix/main.cf',
							'echo "non_smtpd_milters = inet:localhost:8891" >> /etc/postfix/main.cf'
						),
						'restart' => Array(
							'/etc/init.d/dkim-filter restart',
							'/etc/init.d/postfix restart'
						)
					),
					'postfix_dovecot' => Array(
						'label' => 'Postfix/Dovecot',
						'commands' => Array(
							($vmail_group === false) ? 'groupadd -g ' . $settings['system']['vmail_gid'] . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . $settings['system']['vmail_uid'] . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'mkdir -p ' . $settings['system']['vmail_homedir'],
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . $settings['system']['vmail_homedir'],
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
						'files' => Array(
							'etc_postfix_main.cf' => '/etc/postfix/main.cf',
							'etc_postfix_master.cf' => '/etc/postfix/master.cf',
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql-virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql-virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql-virtual_mailbox_maps.cf',
							'etc_postfix_mysql-virtual_sender_permissions.cf' => '/etc/postfix/mysql-virtual_sender_permissions.cf'
						),
						'restart' => Array(
							'/etc/init.d/postfix restart',
							'newaliases'
						)
					),
					'postfix_mxaccess' => Array(
						'label' => 'Postfix MX-Access (anti spam)',
						'files' => Array(
							'etc_postfix_mx_access' => '/etc/postfix/mx_access',
							'etc_postfix_main.cf' => '/etc/postfix/main.cf'
						),
						'commands_1' => Array(
							'postmap /etc/postfix/mx_access'
						),
						'restart' => Array(
							'/etc/init.d/postfix restart'
						)
					),
					'exim4' => Array(
						'label' => 'Exim4',
						'commands_1' => Array(
							'dpkg-reconfigure exim4-config',
							'# choose "no configuration at this time" and "splitted configuration files" in the dialog'
						),
						'files' => Array(
							'etc_exim4_conf.d_acl_30_exim4-config_check_rcpt.rul' => '/etc/exim4/conf.d/acl/30_exim4-config_check_rcpt.rul',
							'etc_exim4_conf.d_auth_30_froxlor-config' => '/etc/exim4/conf.d/auth/30_froxlor-config',
							'etc_exim4_conf.d_main_10_froxlor-config_options' => '/etc/exim4/conf.d/main/10_froxlor-config_options',
							'etc_exim4_conf.d_router_180_froxlor-config' => '/etc/exim4/conf.d/router/180_froxlor-config',
							'etc_exim4_conf.d_transport_30_froxlor-config' => '/etc/exim4/conf.d/transport/30_froxlor-config'
						),
						'commands_2' => Array(
							'chmod o-rx /var/lib/exim4',
							'chmod o-rx /etc/exim4/conf.d/main/10_froxlor-config_options'
						),
						'restart' => Array(
							'/etc/init.d/exim4 restart'
						)
					)
				)
			),
			'mail' => Array(
				'label' => $lng['admin']['configfiles']['mail'],
				'daemons' => Array(
					'courier' => Array(
						'label' => 'Courier',
						'commands' => Array(
							'apt-get install courier-pop courier-imap courier-authlib-mysql'
						),
						'files' => Array(
							'etc_courier_authdaemonrc' => '/etc/courier/authdaemonrc',
							'etc_courier_authmysqlrc' => '/etc/courier/authmysqlrc'
						),
						'restart' => Array(
							'/etc/init.d/courier-authdaemon restart',
							'/etc/init.d/courier-pop restart'
						)
					),
					'dovecot' => Array(
						'label' => 'Dovecot',
						'commands_1' => Array(
							'apt-get install dovecot-imapd dovecot-pop3d dovecot-postfix'
						),
						'files' => Array(
							'etc_dovecot_auth.d_01-dovecot-postfix.auth' => '/etc/dovecot/auth.d/01-dovecot-postfix.auth',
							'etc_dovecot_conf.d_01-dovecot-postfix.conf' => '/etc/dovecot/conf.d/01-dovecot-postfix.conf',
							'etc_dovecot_dovecot-sql.conf' => '/etc/dovecot/dovecot-sql.conf'
						),
						'commands_2' => Array(
							'chmod 0640 /etc/dovecot/dovecot-sql.conf'
						),
						'restart' => Array(
							'/etc/init.d/dovecot restart'
						)
					)
				)
			),
			'ftp' => Array(
				'label' => $lng['admin']['configfiles']['ftp'],
				'daemons' => Array(
					'proftpd' => Array(
						'label' => 'ProFTPd',
						'commands' => Array(
							'apt-get install proftpd-basic proftpd-mod-mysql'
						),
						'files' => Array(
							'etc_proftpd_sql.conf' => '/etc/proftpd/sql.conf',
							'etc_proftpd_modules.conf' => '/etc/proftpd/modules.conf',
							'etc_proftpd_proftpd.conf' => '/etc/proftpd/proftpd.conf'
						),
						'restart' => Array(
							'/etc/init.d/proftpd restart'
						)
					),
					'pure-ftpd' => Array(
						'label' => 'Pure FTPd',
						'commands_1' => Array(
							'apt-get install pure-ftpd-common pure-ftpd-mysql'
						),
						'files' => Array(
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
						'commands_2' => Array(
							'chmod 0640 /etc/pure-ftpd/db/mysql.conf'
						),
						'restart' => Array(
							'/etc/init.d/pure-ftpd-mysql restart'
						)
					),
				)
			),
			'etc' => Array(
				'label' => $lng['admin']['configfiles']['etc'],
				'daemons' => Array(
					'cron' => Array(
						'label' => 'Crond (cronscript)',
						'files' => Array(
							'etc_cron.d_froxlor' => '/etc/cron.d/froxlor'
						),
						'restart' => Array(
							'/etc/init.d/cron restart'
						)
					),
					'awstats' => Array(
						'label' => 'Awstats',
						'commands' => Array(
							'apt-get install awstats',
							'cp /usr/share/doc/awstats/examples/awstats_buildstaticpages.pl '.makeCorrectDir($settings['system']['awstats_path']),
							'mv '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.conf').' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
							'sed -i.bak \'s/^DirData/# DirData/\' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf')
						),
					),
					'libnss' => Array(
						'label' => 'libnss (system login with mysql)',
						'commands' => Array(
							'apt-get install libnss-mysql nscd',
							'chmod 600 /etc/nss-mysql.conf /etc/nss-mysql-root.conf'
						),
						'files' => Array(
							'etc_nss-mysql.conf' => '/etc/nss-mysql.conf',
							'etc_nss-mysql-root.conf' => '/etc/nss-mysql-root.conf',
							'etc_nsswitch.conf' => '/etc/nsswitch.conf',
						),
						'restart' => Array(
							'/etc/init.d/nscd restart'
						)
					)
				)
			)
		)
	)
);

?>
