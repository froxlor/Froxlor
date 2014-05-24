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
	'sle_10' => array(
		'label' => 'SUSE Linux Enterprise 10 (deprecated)',
		'services' => array(
			'http' => array(
				'label' => $lng['admin']['configfiles']['http'],
				'daemons' => array(
					'apache' => array(
						'label' => 'Apache',
						'commands' => array(
							$configcommand['vhost'],
							$configcommand['diroptions'],
							$configcommand['include'],
							'mkdir -p ' . Settings::Get('system.documentroot_prefix'),
							'mkdir -p ' . Settings::Get('system.logfiles_directory'),
							(Settings::Get('system.deactivateddocroot') != '') ? 'mkdir -p ' . Settings::Get('system.deactivateddocroot') : ''
						),
						'restart' => array(
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
							'echo "include \"' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf\";" >> /etc/named.conf',
							'touch ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf',
							'chown named:0 ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf',
							'chmod 0600 ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf'
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
							'etc_postfix_mysql-virtual_alias_maps.cf' => '/etc/postfix/mysql-virtual_alias_maps.cf',
							'etc_postfix_mysql-virtual_mailbox_domains.cf' => '/etc/postfix/mysql-virtual_mailbox_domains.cf',
							'etc_postfix_mysql-virtual_mailbox_maps.cf' => '/etc/postfix/mysql-virtual_mailbox_maps.cf',
							'etc_postfix_mysql-virtual_sender_permissions.cf' => '/etc/postfix/mysql-virtual_sender_permissions.cf',
							'usr_lib_sasl2_smtpd.conf' => '/usr/lib/sasl2/smtpd.conf'
						),
						'commands' => array(
							($vmail_group === false) ? 'groupadd -g ' . Settings::Get('system.vmail_gid') . ' ' . $vmail_groupname : '',
							($vmail_user === false) ? 'useradd -u ' . Settings::Get('system.vmail_uid') . ' -g ' . $vmail_groupname . ' ' . $vmail_username : '',
							'mkdir -p ' . Settings::Get('system.vmail_homedir'),
							'chown -R '.$vmail_username.':'.$vmail_groupname.' ' . Settings::Get('system.vmail_homedir'),
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
						'restart' => array(
							'newaliases',
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
					)
				)
			),
			'mail' => array(
				'label' => $lng['admin']['configfiles']['mail'],
				'daemons' => array(
					'courier' => array(
						'label' => 'Courier',
						'files' => array(
							'etc_authlib_authdaemonrc' => '/etc/authlib/authdaemonrc',
							'etc_authlib_authmysqlrc' => '/etc/authlib/authmysqlrc'
						),
						'restart' => array(
							'/etc/init.d/courier-authdaemon restart',
							'/etc/init.d/courier-pop restart'
						)
					),
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
							'mv '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.conf').' '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.model.conf'),
							'sed -i.bak \'s/^DirData/# DirData/\' '.makeCorrectFile(Settings::Get('system.awstats_conf').'/awstats.model.conf'),
							'# Please make sure you deactivate awstats own cronjob as Froxlor handles that itself'
						)
					)
				)
			)
		)
	)
);

?>
