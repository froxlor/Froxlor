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
	'freebsd' => Array(
		'label' => 'FreeBSD',
		'services' => Array(
			'http' => Array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => Array(

					// Begin: Nginx Config
					'nginx' => array(
					'label' => 'Nginx Webserver',
					'commands_1' => array(
							'cd /usr/ports/www/nginx',
							'make config',
							'set [x] IPv6 protocol (default)',
							'set [x] Enable HTTP module (default)',
							'set [x] Enable http_cache module (default)',
							'set [x] Enable http_gzip_static module',
							'set [x] Enable http_rewrite module (default)',
							'set [x] Enable http_ssl module (default)',
							'set [x] Enable http_stub_status module (default)',
							'make install clean; rehash',
						),
						'commands_2' => array(
							$configcommand['vhost'],
							$configcommand['diroptions'],
							($settings['system']['deactivateddocroot'] != '') ? 'mkdir -p '. $settings['system']['deactivateddocroot'] : null,
							'mkdir -p '. $settings['system']['documentroot_prefix'],
							'mkdir -p '. $settings['system']['mod_fcgid_tmpdir'],
							'mkdir -p '. $settings['system']['logfiles_directory'],
							'echo "nginx_enable=\"YES\"" >> /etc/rc.conf'
						),
						'files' => array(
							'usr_local_etc_nginx_nginx.conf' => '/usr/local/etc/nginx/nginx.conf',
						),
						'restart' => array(
							'/usr/local/etc/rc.d/nginx restart'
						)
					),
					// End: Nginx Config

					'apache2' => Array(
						'label' => 'Apache2 Webserver',
						'commands' => Array(
							'cd /usr/ports/www/apache22',
							'make config',
							'make install',
							$configcommand['vhost'],
							'chown root:0 ' . $settings['system']['apacheconf_vhost'],
							'chmod 0600 ' . $settings['system']['apacheconf_vhost'],
							$configcommand['diroptions'],
							'chown root:0 ' . $settings['system']['apacheconf_diroptions'],
							'chmod 0600 ' . $settings['system']['apacheconf_diroptions'],
							'mkdir -p ' . $settings['system']['documentroot_prefix'],
							'mkdir -p ' . $settings['system']['logfiles_directory'],
							($settings['system']['deactivateddocroot'] != '') ? 'mkdir -p ' . $settings['system']['deactivateddocroot'] : '',
							'mkdir -p ' . $settings['system']['mod_fcgid_tmpdir'],
							'chmod 1777 ' . $settings['system']['mod_fcgid_tmpdir'],
							'echo "accf_http_load=\"YES\"" >> /boot/loader.conf',
							'echo "accf_data_load=\"YES\"" >> /boot/loader.conf',
							'echo "apache22_enable=\"YES\"" >> /etc/rc.conf',
						),
						'restart' => Array(
							'sh /usr/local/etc/rc.d/apache22 restart'
						)
					)
				)
			),
			'dns' => Array(
				'label' => $lng['admin']['configfiles']['dns'],
				'daemons' => Array(

					// Begin: Bind 9.x Config
					'bind9' => array(
					'label' => 'Bind9 Nameserver',
					'commands_1' => array(
							'cd /usr/ports/dns/bind99',
							'make config',
							'set [x] International Domain Names',
							'set [x] IPv6 protocol (default)',
							'set [x] 64-bit file support',
							'set [x] Replace base BIND with this version',
							'set [x] Enable RPZ NSDNAME policy records',
							'set [x] Enable RPZ NSIP trigger rules',
							'set [x] dig/host/nslookup will do DNSSEC validation',
							'set [x] Build with OpenSSL (Required for DNSSEC) (default)',
							'set [x] Threading support (default)',
							'make install clean; rehash',
						),
						'commands_2' => array(
							'echo "named_enable=\"YES\"" >> /etc/rc.conf',
							PHP_EOL,
							(strpos($settings['system']['bindconf_directory'], '/etc/namedb') === false) ? '(TIP: Be sure the path below is "/etc/namedb", if not you have configured the bind-directory in a false way in PANEL->SETTINGS->NAMESERVER SETTINGS!)' : null,
							'echo "include \"'. $settings['system']['bindconf_directory'] .'froxlor_bind.conf\";" >> '. $settings['system']['bindconf_directory'] .'named.conf',
							'echo "include \"'. $settings['system']['bindconf_directory'] .'default-zone\";" >> '. $settings['system']['bindconf_directory'] .'named.conf',
						),
						'files' => array(
							'etc_namedb_named.conf' => $settings['system']['bindconf_directory'] .'named.conf',
							'etc_namedb_master_default.zone' => $settings['system']['bindconf_directory'] .'master/default.zone',
							'etc_namedb_default-zone' => $settings['system']['bindconf_directory'] .'default-zone',
						),
						'restart' => array(
							'/etc/rc.d/named restart'
						)
					),
					// End: Bind 9.x Config

					'powerdns' => Array(
						'label' => 'PowerDNS',
						'commands_1' => Array(
							'cd /usr/ports/dns/powerdns',
							'make config',
							'set MySQL backend',
							'make install',
							'echo "pdns_enable=\"YES\"" >> /etc/rc.conf',
						),
						'files' => Array(
							'usr_local_etc_pdns_pdns.conf' => '/usr/local/etc/pdns/pdns.conf'
						),
						'commands' => Array(
							'touch ' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf',
							'chown root:0 ' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf',
							'chmod 0600 ' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf'
						),
						'restart' => Array(
							'sh /usr/local/etc/rc.d/pdns restart'
						)
					),
				)
			),
			'smtp' => Array(
				'label' => $lng['admin']['configfiles']['smtp'],
				'daemons' => Array(
					'postfix' => Array(
						'label' => 'Postfix',
						'commands_1' => Array(
							'cd /usr/ports/mail/postfix',
							'make config',
							'set Dovecot SASL authentication method',
							'set Enable SSL and TLS support',
							'set MySQL maps (choose version with WITH_MYSQL_VER)',
							'make install'
						),
						'commands_2' => Array(
							($vmail_group === false) ? 'pw groupadd ' . $vmail_groupname . ' -g '.$settings['system']['vmail_gid'] : '',
							($vmail_user === false) ? 'pw useradd ' . $vmail_username . ' -u '.$settings['system']['vmail_uid'].' -g '.$settings['system']['vmail_gid'].' -s/sbin/nologin -d/dev/null' : '',
							'mkdir -p ' . $settings['system']['vmail_homedir'],
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . $settings['system']['vmail_homedir'],
							'chmod 0750 ' . $settings['system']['vmail_homedir']
						),
						'commands_3' => Array(
							'echo "sendmail_enable=\"NO\"" >> /etc/rc.conf',
							'echo "sendmail_submit_enable=\"NO\"" >> /etc/rc.conf',
							'echo "sendmail_outbound_enable=\"NO\"" >> /etc/rc.conf',
							'echo "sendmail_msp_queue_enable=\"NO\"" >> /etc/rc.conf',
							'echo "postfix_enable=\"YES\"" >> /etc/rc.conf'
						),
						'files' => Array(
							'etc_periodic.conf' => '/etc/periodic.conf',
							'usr_local_etc_postfix_main.cf' => '/usr/local/etc/postfix/main.cf',
							'usr_local_etc_postfix_mysql-virtual_alias_maps.cf' => '/usr/local/etc/postfix/mysql-virtual_alias_maps.cf',
							'usr_local_etc_postfix_mysql-virtual_mailbox_domains.cf' => '/usr/local/etc/postfix/mysql-virtual_mailbox_domains.cf',
							'usr_local_etc_postfix_mysql-virtual_mailbox_maps.cf' => '/usr/local/etc/postfix/mysql-virtual_mailbox_maps.cf',
							'usr_local_etc_postfix_mysql-virtual_sender_permissions.cf' => '/usr/local/etc/postfix/mysql-virtual_sender_permissions.cf'
						),
						'restart' => Array(
							'newaliases',
							'mkdir /var/spool/postfix/etc',
							'cp /etc/resolv.conf /var/spool/postfix/etc',
							'sh /usr/local/etc/rc.d/postfix restart'
						)
					),
					'postgrey' => Array(
						'label' => 'Postgrey',
						'commands_1' => Array(
							'cd /usr/ports/mail/postgrey',
							'make install clean'
						),
						'commands_2' => Array(
							'sed -i.bak \'s/# *check_policy_service  *inet:127\.0\.0\.1:10023/    check_policy_service inet:127\.0\.0\.1:10023/\' /usr/local/etc/postfix/main.cf',
							'echo "postgrey_enable=\"YES\"" >> /etc/rc.conf'
						),
						'restart' => Array(
							'/usr/local/etc/rc.d/postgrey restart',
							'/usr/local/etc/rc.d/postfix restart'
						)
					),
					'postfix_mxaccess' => Array(
						'label' => 'Postfix MX-Access (anti spam)',
						'files' => Array(
							'etc_postfix_mx_access' => '/usr/local/etc/postfix/mx_access',
							'etc_postfix_main.cf' => '/usr/local/etc/postfix/main.cf'
						),
						'commands_1' => Array(
							'postmap /usr/local/etc/postfix/mx_access'
						),
						'restart' => Array(
							'/usr/local/etc/rc.d/postfix restart'
						)
					),
					'dkim' => Array(
						'label' => 'DomainKey filter',
						'commands' => Array(
							'cd /usr/ports/mail/dkim-milter/',
							'make install clean',
							'touch /usr/local/etc/mail/dkim-filter.conf'
						),
						'files' => Array(
							'dkim-filter.conf' => '/usr/local/etc/mail/dkim-filter.conf',
							'postfix_dkim_addition.cf' => '/usr/local/etc/postfix/main.cf'
						),
						'restart' => Array(
							'/usr/local/etc/rc.d/milter-dkim restart '
						)
					)
				)
			),
			'mail' => Array(
				'label' => $lng['admin']['configfiles']['mail'],
				'daemons' => Array(
					'dovecot' => Array(
						'label' => 'Dovecot',
						'commands_1' => Array(
							'cd /usr/ports/mail/dovecot',
							'make config',
							'set kqueue(2) support ',
							'set SSL support ',
							'set ManageSieve support (optional)',
							'set MySQL support ',
							'make install',
							'echo "dovecot_enable=\"YES\"" >> /etc/rc.conf'
						),
						'files' => Array(
							'usr_local_etc_dovecot.conf' => '/usr/local/etc/dovecot.conf',
							'usr_local_etc_dovecot-sql.conf' => '/usr/local/etc/dovecot-sql.conf'
						),
						'commands_2' => Array(
							'echo "dovecot unix - n n - - pipe
    flags=DRhu user='.$vmail_username.':'.$vmail_groupname.' argv=/usr/local/libexec/dovecot/deliver -f ${sender} -d ${recipient}" >> /usr/local/etc/postfix/master.cf',
							'chmod 0640 /usr/local/etc/dovecot-sql.conf'
						),
						'restart' => Array(
							'sh /usr/local/etc/rc.d/dovecot restart'
						)
					),

					// Begin: Dovecot 2.x Config
					'dovecot2' => array(
						'label' => 'Dovecot 2.x',
						'commands_1' => array(
							'cd /usr/ports/mail/dovecot2',
							'make config',
							'set [x] kqueue(2) support (default)',
							'set [x] MySQL database',
							'set [x] SSL protocol (default)',
							'make install clean; rehash',
						),
						'commands_2' => array(
							'echo "dovecot_enable=\"YES\"" >> /etc/rc.conf',
							PHP_EOL,
							'pw adduser '. $vmail_username .' -g '. $vmail_groupname .' -u '. $settings['system']['vmail_gid'] .' -d /nonexistent -s /usr/sbin/nologin -c "User for virtual mailtransport used by Postfix and Dovecot"',
							PHP_EOL,
							'chmod 0640 /usr/local/etc/dovecot-sql.conf'
						),
						'files' => array(
							'usr_local_etc_dovecot_dovecot.conf' => '/usr/local/etc/dovecot/dovecot.conf',
							'usr_local_etc_dovecot_dovecot-sql.conf' => '/usr/local/etc/dovecot/dovecot-sql.conf'
						),
						'commands_3' => array(
							'echo "dovecot unix - n n - - pipe'. PHP_EOL .'flags=DRhu user='. $vmail_username .':'. $vmail_groupname .' argv=/usr/lib/dovecot/deliver -f ${sender} -d ${recipient} -a ${recipient}" >> /usr/local/etc/postfix/master.cf',
						),
						'restart' => array(
							'/usr/local/etc/rc.d/dovecot restart'
						)
					)
					// End: Dovecot 2.x Config

				)
			),
			'ftp' => Array(
				'label' => $lng['admin']['configfiles']['ftp'],
				'daemons' => Array(
					'proftpd' => Array(
						'label' => 'ProFTPd',
                                                'commands_1' => Array(
							'cd /usr/ports/ftp/proftpd',
							'make config',
							'set MySQL auth',
							'set Include mod_quota',
							'make install clean'
                                                ),
						'commands_2' => Array(
                                                        'touch /usr/local/etc/proftpd.conf',
                                                        'chown root:0 /usr/local/etc/proftpd.conf',
                                                        'chmod 0600 /usr/local/etc/proftpd.conf',
							'echo "proftpd_enable=\"YES\"" >> /etc/rc.conf'
						),
						'files' => Array(
							'etc_proftpd_proftpd.conf' => '/usr/local/etc/proftpd.conf'
						),
						'restart' => Array(
							'/usr/local/etc/rc.d/proftpd restart'
						)
					)
				)
			),
			'etc' => Array(
				'label' => $lng['admin']['configfiles']['etc'],
				'daemons' => Array(
					'cron' => Array(
						'label' => 'Crond (cronscript)',
						'commands' => Array(
							'echo "*/5 * * * *     root     nice -n 5	/usr/local/bin/php -q '.makeCorrectDir(dirname(dirname(dirname(__FILE__)))).'scripts/froxlor_master_cronjob.php" >> /etc/crontab'
						),
						'restart' => Array(
							'/etc/rc.d/cron restart'
						)
					),
					'awstats' => Array(
						'label' => 'Awstats',
						'commands' => Array(
							'cd /usr/ports/www/awstats/',
							'make install clean',
							'cp /usr/local/www/awstats/cgi-bin/awstats.model.conf '.makeCorrectDir($settings['system']['awstats_conf']),
							'sed -i.bak \'s/^LogFile/# LogFile/\' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
							'sed -i.bak \'s/^LogType/# LogType/\' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
							'sed -i.bak \'s/^LogFormat/# LogFormat/\' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
							'sed -i.bak \'s/^LogSeparator/# LogSeparator/\' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
							'sed -i.bak \'s/^SiteDomain/# SiteDomain/\' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
							'sed -i.bak \'s/^DirData/# DirData/\' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
							'sed -i.bak \'s/^DirIcons=\"\/awstatsicons\"/DirIcons=\"\/awstats-icon\"/\' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
							'# Please make sure you deactivate awstats own cronjob as Froxlor handles that itself'
						)
					),
					'libnss' => Array(
						'label' => 'libnss (system login with mysql)',
						'commands_1' => Array(
							'cd /usr/ports/net/libnss-mysql',
							'make install clean',
							'echo "nscd_enable=\"YES\"" >> /etc/rc.conf'
						),
						'files' => Array(
							'usr_local_etc_libnss-mysql.cfg' => '/usr/local/etc/libnss-mysql.cfg',
							'usr_local_etc_libnss-mysql-root.cfg' => '/usr/local/etc/libnss-mysql-root.cfg',
							'etc_nsswitch.conf' => '/etc/nsswitch.conf'
						),
						'commands_2' => Array(
							'chmod 600 /usr/local/etc/libnss-mysql.cfg /usr/local/etc/libnss-mysql-root.cfg'
						),
						'restart' => Array(
							'sh /etc/rc.d/nscd restart'
						)
					),
					'logrotate' => array(
						'label' => 'Logrotate',
						'commands_1' => array(
							'cd /usr/ports/sysutils/logrotate/',
							'make install clean clean-depends',
							'touch /etc/logrotate.d/froxlor',
							'chmod 644 /etc/logrotate.d/froxlor'
						),
						'files' => array(
							'etc_logrotated_froxlor' => '/etc/logrotate.d/froxlor'
						),
						'commands_2' => array(
							'# create cronjob-entry (daily-recommended)',
							'0 2 * * * /usr/local/sbin/logrotate -f /etc/logrotate.d/froxlor'
						)
					)
				)
			)
		)
	)
);
