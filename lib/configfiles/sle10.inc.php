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
	'sle_10' => Array(
		'label' => 'SUSE Linux Enterprise 10',
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
							'mkdir -p ' . $settings['system']['logfiles_directory'],
							($settings['system']['deactivateddocroot'] != '') ? 'mkdir -p ' . $settings['system']['deactivateddocroot'] : ''
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
							'echo "include \"' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf\";" >> /etc/named.conf',
							'touch ' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf',
							'chown named:0 ' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf',
							'chmod 0600 ' . $settings['system']['bindconf_directory'] . 'froxlor_bind.conf'
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
							'etc_postfix_mysql-virtual_sender_permissions.cf' => '/etc/postfix/mysql-virtual_sender_permissions.cf',
							'usr_lib_sasl2_smtpd.conf' => '/usr/lib/sasl2/smtpd.conf'
						),
						'commands' => Array(
							($vmail_group === false) ? 'groupadd -g ' . $settings['system']['vmail_gid'] . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . $settings['system']['vmail_uid'] . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'mkdir -p ' . $settings['system']['vmail_homedir'],
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . $settings['system']['vmail_homedir'],
							'mkdir -p /var/spool/postfix/etc/pam.d',
							'touch /etc/postfix/mysql-virtual_alias_maps.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'touch /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'touch /etc/postfix/mysql-virtual_sender_permissions.cf',
							'touch /usr/lib/sasl2/smtpd.conf',
							'chmod 660 /etc/postfix/mysql-virtual_alias_maps.cf',
							'chmod 660 /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'chmod 660 /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'chmod 660 /etc/postfix/mysql-virtual_sender_permissions.cf',
							'chmod 660 /usr/lib/sasl2/smtpd.conf',
							'chgrp postfix /etc/postfix/mysql-virtual_alias_maps.cf',
							'chgrp postfix /etc/postfix/mysql-virtual_mailbox_domains.cf',
							'chgrp postfix /etc/postfix/mysql-virtual_mailbox_maps.cf',
							'chgrp postfix /etc/postfix/mysql-virtual_sender_permissions.cf',
							'chgrp postfix /usr/lib/sasl2/smtpd.conf'
						),
						'restart' => Array(
							'newaliases',
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
							'etc_cron.d_froxlor' => '/etc/cron.d/froxlor'
						),
						'restart' => Array(
							'/etc/init.d/cron restart'
						)
					),
					'awstats' => Array(
						'label' => 'Awstats',
						'commands' => Array(
							'awstats_configure.pl',
							makeCorrectFile($settings['system']['awstats_conf'].'/awstats.conf').' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf'),
							'sed -i.bak \'s/^DirData/# DirData/\' '.makeCorrectFile($settings['system']['awstats_conf'].'/awstats.model.conf')
						)
					)
				)
			)
		)
	)
);

?>
