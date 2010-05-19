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
 * @version    $Id$
 */

return Array(
	'freebsd' => Array(
		'label' => 'FreeBSD',
		'services' => Array(
			'http' => Array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => Array(
					'apache2' => Array(
						'label' => 'Apache2 Webserver',
						'commands' => Array(
							'cd /usr/ports/www/apache22',
							'make config',
							'make install',
							'touch ' . $settings['system']['apacheconf_vhost'],
							'chown root:0 ' . $settings['system']['apacheconf_vhost'],
							'chmod 0600 ' . $settings['system']['apacheconf_vhost'],
							'touch ' . $settings['system']['apacheconf_diroptions'],
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
					'powerdns' => Array(
						'label' => 'PowerDNS',
						'commands_1' => Array(
							'cd /usr/ports/dns/powerdns',
							'make config',
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
							'pw groupadd vmail -g 5001 ',
							'pw useradd vmail -u 5001 -g 5001 -s/sbin/nologin -d/dev/null',			
							'mkdir -p ' . $settings['system']['vmail_homedir'],
							'chown -R vmail:vmail ' . $settings['system']['vmail_homedir'],
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
							'usr_local_etc_postfix_mysql-virtual_mailbox_maps.cf' => '/usr/local/etc/postfix/mysql-virtual_mailbox_maps.cf'
						),
						'restart' => Array(
							'sh /usr/local/etc/rc.d/postfix restart'
						)
					),
					'postfix_mxaccess' => Array(
						'label' => 'Postfix MX-Access (anti spam)',
						'files' => Array(
							'etc_postfix_mx_access' => '/usr/local/etc/postfix/mx_access',
							'etc_postfix_main.cf' => '/usr/local/etc/postfix/main.cf'
						),
						'commands_1' => Array(
							'postmap /etc/postfix/mx_access'
						),
						'restart' => Array(
							'/etc/init.d/postfix restart'
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
    flags=DRhu user=vmail:vmail argv=/usr/local/libexec/dovecot/deliver -f ${sender} -d ${recipient}" >> /usr/local/etc/postfix/master.cf'
						),
						'restart' => Array(
							'sh /usr/local/etc/rc.d/dovecot restart'
						)
					)
				)
			),
			'ftp' => Array(
				'label' => $lng['admin']['configfiles']['ftp'],
				'daemons' => Array(
					'proftpd' => Array(
						'label' => 'ProFTPd',
						'files' => Array(
							'etc_proftpd_proftpd.conf' => '/usr/local/etc/proftpd.conf'
						),
						'commands' => Array(
							'touch /usr/local/etc/proftpd.conf',
							'chown root:0 /usr/local/etc/proftpd.conf',
							'chmod 0600 /usr/local/etc/proftpd.conf'
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
					'awstats' => Array(
						'label' => 'Awstats',
						'commands' => Array(
							'cd /usr/ports/www/awstats/',
							'make install clean',
							'cp /usr/local/www/awstats/cgi-bin/awstats.model.conf '.makeCorrectDir($settings['system']['awstats_conf']),
							'sed -i.bak \'s/^LogFile/# LogFile/\''.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.conf'),
							'sed -i.bak \'s/^LogType/# LogType/\''.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.conf'),
							'sed -i.bak \'s/^LogFormat/# LogFormat/\''.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.conf'),
							'sed -i.bak \'s/^LogSeparator/# LogSeparator/\''.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.conf'),
							'sed -i.bak \'s/^SiteDomain/# SiteDomain/\''.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.conf'),
							'sed -i.bak \'s/^DirData/# DirData/\''.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.conf')
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
					)
				)
			)
		)
	)
);

?>
