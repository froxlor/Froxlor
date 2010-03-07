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
							'mkdir -p ' . $settings['system']['deactivateddocroot'],
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
							'echo "add pdns_enable=\"YES\"" >> /etc/rc.conf',
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
							'echo "add dovecot_enable=\"YES\"" >> /etc/rc.conf'
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
							'etc_proftpd_proftpd.conf' => '/etc/proftpd/proftpd.conf'
						),
						'commands' => Array(
							'touch /etc/proftpd/proftpd.conf',
							'chown root:0 /etc/proftpd/proftpd.conf',
							'chmod 0600 /etc/proftpd/proftpd.conf'
						),
						'restart' => Array(
							'/etc/init.d/proftpd restart'
						)
					)
				)
			)
		)
	)
);

?>
