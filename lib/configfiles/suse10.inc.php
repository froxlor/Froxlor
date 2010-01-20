<?php
return Array(
	'suse_linux_10_0' => Array(
		'label' => 'SUSE Linux 10.0',
		'services' => Array(
			'http' => Array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => Array(
					'apache' => Array(
						'label' => 'Apache',
						'commands' => Array(
							$configcommand['vhost'],
							$configcommand['diroptions'],
							$configcommand['include'],
							'mkdir -p ' . $settings['system']['documentroot_prefix'],
							'mkdir -p ' . $settings['system']['logfiles_directory']
						),
						'restart' => Array(
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
							'echo "include \"' . $settings['system']['bindconf_directory'] . 'syscp_bind.conf\";" >> /etc/named.conf',
							'touch ' . $settings['system']['bindconf_directory'] . 'syscp_bind.conf'
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
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql-virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql-virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql-virtual_mailbox_maps.cf',
							'usr_lib_sasl2_smtpd.conf' => '/usr/lib/sasl2/smtpd.conf'
						),
						'commands' => Array(
							'mkdir -p /var/spool/postfix/etc/pam.d',
							'groupadd -g ' . $settings['system']['vmail_gid'] . ' vmail',
							'useradd -u ' . $settings['system']['vmail_uid'] . ' -g vmail vmail',
							'mkdir -p ' . $settings['system']['vmail_homedir'],
							'chown -R vmail:vmail ' . $settings['system']['vmail_homedir'],
							'touch /etc/postfix/mysql-virtual_alias_maps.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'touch /usr/lib/sasl2/smtpd.conf',
							'chmod 660 /etc/postfix/mysql-virtual_alias_maps.cf',
							'chmod 660 /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'chmod 660 /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'chmod 660 /usr/lib/sasl2/smtpd.conf',
							'chgrp postfix /etc/postfix/mysql-virtual_alias_maps.cf',
							'chgrp postfix /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'chgrp postfix /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'chgrp postfix /usr/lib/sasl2/smtpd.conf'
						),
						'restart' => Array(
							'/etc/init.d/postfix restart'
						)
					)
				)
			),
			'mail' => Array(
				'label' => $lng['admin']['configfiles']['mail'],
				'daemons' => Array(
					'courier' => Array(
						'label' => 'Courier',
						'files' => Array(
							'etc_authlib_authdaemonrc' => '/etc/authlib/authdaemonrc',
							'etc_authlib_authmysqlrc' => '/etc/authlib/authmysqlrc'
						),
						'restart' => Array(
							'/etc/init.d/courier-authdaemon restart',
							'/etc/init.d/courier-pop restart'
						)
					),
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
				)
			),
			'etc' => Array(
				'label' => $lng['admin']['configfiles']['etc'],
				'daemons' => Array(
					'cron' => Array(
						'label' => 'Crond (cronscript)',
						'files' => Array(
							'etc_cron.d_syscp' => '/etc/cron.d/syscp'
						),
						'restart' => Array(
							'/etc/init.d/cron restart'
						)
					),
					'awstats' => Array(
						'label' => 'Awstats',
						'files' => Array(
							($settings['system']['mod_log_sql'] == 1 ? 'etc_awstats_awstats.model_log_sql.conf.syscp' : 'etc_awstats_awstats.model.conf.syscp') => '/etc/awstats/awstats.model.conf.syscp',
							($settings['system']['mod_log_sql'] == 1 ? 'etc_cron.d_awstats_log_sql' : 'etc_cron.d_awstats') => '/etc/cron.d/awstats',
							($settings['system']['webserver'] == 'lighttpd' ? 'etc_lighttpd_syscp-awstats.conf' : 'etc_apache_vhosts_05_awstats.conf') => ($settings['system']['webserver'] == 'lighttpd' ? '/etc/lighttpd/syscp-awstats.conf' : '/etc/apache2/sites-enabled/05_awstats.conf')
						),
						'commands' => Array(
							($settings['system']['webserver'] == 'lighttpd' ? 'echo "include \"syscp-awstats.conf\"" >> /etc/lighttpd/lighttpd.conf' : '')
						),
						'restart' => Array(
							($settings['system']['webserver'] == 'lighttpd' ? '/etc/init.d/lighttpd restart' : '/etc/init.d/apache2 restart')
						)
					)
				)
			)
		)
	)
);

?>
