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
	'opensuse_11_x' => Array(
		'label' => 'openSUSE 11.x',
		'services' => Array(
			'http' => Array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => Array(
					'apache' => Array(
						'label' => 'Apache',
						'commands' => Array(
							'mkdir -p ' . $settings['system']['documentroot_prefix'],
							'mkdir -p ' . $settings['system']['logfiles_directory'],
							'Maybe add to /etc/apache2/httpd.conf',
                                                        'Alias /mail /srv/www/htdocs/roundcubemail',
                                                        'Alias /webmail /srv/www/htdocs/squirrelmail',
							($settings['system']['deactivateddocroot'] != '') ? 'mkdir -p ' . $settings['system']['deactivateddocroot'] : ''
						),
						'restart' => Array(
							' '.
							'/etc/init.d/apache2 restart'
						)
					),
				)
			),
			'dns' => Array(
				'label' => $lng['admin']['configfiles']['dns'],
				'daemons' => Array(
					'bind' => Array(
						'label' => 'Bind9',
						'commands' => Array(
							'Add froxlor_bind.conf to the NAMED_CONF_INCLUDE_FILES in /etc/sysconfig/named'
						),
						'restart' => Array(
							'/etc/init.d/named restart'
						)
					),
				)
			),
			'smtp' => Array(
				'label' => $lng['admin']['configfiles']['smtp'],
				'daemons' => Array(
					'postfix' => Array(
						'label' => 'Postfix',
						'files' => Array(
							'etc_postfix_main.cf' => '/etc/postfix/main.cf',
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql_virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql_virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql_virtual_mailbox_maps.cf',
							'etc_sasl2_smtpd.conf' => '/etc/sasl2/smtpd.conf'
						),
						'commands' => Array(
							($vmail_group === false) ? 'groupadd -g ' . $settings['system']['vmail_gid'] . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . $settings['system']['vmail_uid'] . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'mkdir -p ' . $settings['system']['vmail_homedir'],
							'chown -R ' . $vmail_username . ':' . $vmail_groupname . ' ' . $settings['system']['vmail_homedir'],
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
						'restart' => Array(
							'/etc/init.d/postfix restart'
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
					'postfix_dovecot' => Array(
                                                'label' => 'Postfix/Dovecot',
                                                'commands' => Array(
                                                        ($vmail_group === false) ? 'groupadd -g ' . $settings['system']['vmail_gid'] . ' ' . $vmail_groupname : '',
                                                        ($vmail_user === false) ? 'useradd -u ' . $settings['system']['vmail_uid'] . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
                                                        'zypper install postfix postfix-mysql',
                                                        'mkdir -p /var/spool/postfix/etc/pam.d',
                                                        'mkdir -p /var/spool/postfix/var/run/mysqld',
                                                        'mkdir -p ' . $settings['system']['vmail_homedir'],
                                                        'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . $settings['system']['vmail_homedir'],
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
					'exim4' => Array(
                                                'label' => 'Exim4',
                                                'commands_1' => Array(
                                                        'zypper install exim'
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
							'zypper install courier-imap courier-authlib-mysql'
						),
						'files' => Array(
							'etc_authlib_authdaemonrc' => '/etc/authlib/authdaemonrc',
							'etc_authlib_authmysqlrc' => '/etc/authlib/authmysqlrc'
						),
						'restart' => Array(
							'/etc/init.d/courier-authdaemon restart',
							'/etc/init.d/courier-pop restart'
						)
					),
					'dovecot' => Array(
						'label' => 'Dovecot 1.1',
						'commands_1' => Array(
							'zypper install dovecot11'
						),
						'files' => Array(
							'etc_dovecot_dovecot.conf' => '/etc/dovecot/dovecot.conf',
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
                                                'files' => Array(
                                                        'etc_proftpd_modules.conf' => '/etc/proftpd/modules.conf',
                                                        'etc_proftpd_proftpd.conf' => '/etc/proftpd/proftpd.conf'
                                                ),
                                                'restart' => Array(
                                                        '/etc/init.d/proftpd restart'
                                                )
                                        ),
	                                        'pure-ftpd' => Array(
                                                'label' => 'Pure-FTPd',
                                                'files' => Array(
                                                        'etc_pure-ftpd.conf' => '/etc/pure-ftpd/pure-ftpd.conf',
                                                        'etc_pure-ftpd_mysql.conf' => '/etc/pure-ftpd/pure-ftpd-mysql.conf'
                                                ),
                                                'restart' => Array(
                                                        '/etc/init.d/pure-ftpd restart'
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
							'cp /usr/share/doc/packages/awstats/awstats.model.conf /etc/awstats/',
							/**makeCorrectFile($settings['system']['awstats_conf'].'/awstats.conf').' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),*/
							'sed -i.bak \'s/^DirData/# DirData/\''.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
			                                'cp awstats.model.conf awstats.yourdomain.xx.conf #e.g one.example.com or example.com',
                                                        'edit awstats.yourdomain.xx.conf',
                                                        'change SiteDomain="yourdomain.xx #e.g SiteDomain="example.com" ',
                                                        'change HostAliases="yourdomain.xx www.yourdomain.de 127.0.0.1 localhost" ',
                                                        'Set DirIcons="/awstatsicons" ',
                                                        'run awstats in your favorite browser by http://yourdomain.xx/cgi-bin/awstats.pl'
						)
					)
				)
			)
		)
	)
);

?>
