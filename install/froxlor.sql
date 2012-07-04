# $Id$
# --------------------------------------------------------

#
# Table structure for table `ftp_groups`
#

DROP TABLE IF EXISTS `ftp_groups`;
CREATE TABLE `ftp_groups` (
  `id` int(20) NOT NULL auto_increment,
  `groupname` varchar(60) NOT NULL default '',
  `gid` int(5) NOT NULL default '0',
  `members` longtext NOT NULL,
  `customerid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `groupname` (`groupname`),
  KEY `customerid` (`customerid`)
) ENGINE=MyISAM ;

#
# Dumping data for table `ftp_groups`
#


# --------------------------------------------------------

#
# Table structure for table `ftp_users`
#

DROP TABLE IF EXISTS `ftp_users`;
CREATE TABLE `ftp_users` (
  `id` int(20) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `uid` int(5) NOT NULL default '0',
  `gid` int(5) NOT NULL default '0',
  `password` varchar(20) NOT NULL default '',
  `homedir` varchar(255) NOT NULL default '',
  `shell` varchar(255) NOT NULL default '/bin/false',
  `login_enabled` enum('N','Y') NOT NULL default 'N',
  `login_count` int(15) NOT NULL default '0',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `up_count` int(15) NOT NULL default '0',
  `up_bytes` bigint(30) NOT NULL default '0',
  `down_count` int(15) NOT NULL default '0',
  `down_bytes` bigint(30) NOT NULL default '0',
  `customerid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `customerid` (`customerid`)
) ENGINE=MyISAM ;

#
# Dumping data for table `ftp_users`
#

# --------------------------------------------------------


#
# Table structure for table `mail_users`
#

DROP TABLE IF EXISTS `mail_users`;
CREATE TABLE `mail_users` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `username` varchar(255) NOT NULL default '',
  `password` varchar(128) NOT NULL default '',
  `password_enc` varchar(128) NOT NULL default '',
  `uid` int(11) NOT NULL default '0',
  `gid` int(11) NOT NULL default '0',
  `homedir` varchar(255) NOT NULL default '',
  `maildir` varchar(255) NOT NULL default '',
  `postfix` enum('Y','N') NOT NULL default 'Y',
  `domainid` int(11) NOT NULL default '0',
  `customerid` int(11) NOT NULL default '0',
  `quota` bigint(13) NOT NULL default '0',
  `pop3` tinyint(1) NOT NULL default '1',
  `imap` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM ;

#
# Dumping data for table `mail_users`
#


# --------------------------------------------------------

#
# Table structure for table `mail_virtual`
#

DROP TABLE IF EXISTS `mail_virtual`;
CREATE TABLE `mail_virtual` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `email_full` varchar(255) NOT NULL default '',
  `destination` text NOT NULL,
  `domainid` int(11) NOT NULL default '0',
  `customerid` int(11) NOT NULL default '0',
  `popaccountid` int(11) NOT NULL default '0',
  `iscatchall` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `email` (`email`)
) ENGINE=MyISAM ;

#
# Dumping data for table `mail_virtual`
#

# --------------------------------------------------------


#
# Table structure for table `panel_admins`
#

DROP TABLE IF EXISTS `panel_admins`;
CREATE TABLE `panel_admins` (
  `adminid` int(11) unsigned NOT NULL auto_increment,
  `loginname` varchar(50) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `def_language` varchar(255) NOT NULL default '',
  `ip` tinyint(4) NOT NULL default '-1',
  `customers` int(15) NOT NULL default '0',
  `customers_used` int(15) NOT NULL default '0',
  `customers_see_all` tinyint(1) NOT NULL default '0',
  `domains` int(15) NOT NULL default '0',
  `domains_used` int(15) NOT NULL default '0',
  `domains_see_all` tinyint(1) NOT NULL default '0',
  `caneditphpsettings` tinyint(1) NOT NULL default '0',
  `change_serversettings` tinyint(1) NOT NULL default '0',
  `edit_billingdata` tinyint(1) NOT NULL DEFAULT '0',
  `diskspace` int(15) NOT NULL default '0',
  `diskspace_used` int(15) NOT NULL default '0',
  `mysqls` int(15) NOT NULL default '0',
  `mysqls_used` int(15) NOT NULL default '0',
  `emails` int(15) NOT NULL default '0',
  `emails_used` int(15) NOT NULL default '0',
  `email_accounts` int(15) NOT NULL default '0',
  `email_accounts_used` int(15) NOT NULL default '0',
  `email_forwarders` int(15) NOT NULL default '0',
  `email_forwarders_used` int(15) NOT NULL default '0',
  `email_quota` bigint(13) NOT NULL default '0',
  `email_quota_used` bigint(13) NOT NULL default '0',
  `ftps` int(15) NOT NULL default '0',
  `ftps_used` int(15) NOT NULL default '0',
  `tickets` int(15) NOT NULL default '-1',
  `tickets_used` int(15) NOT NULL default '0',
  `subdomains` int(15) NOT NULL default '0',
  `subdomains_used` int(15) NOT NULL default '0',
  `traffic` bigint(30) NOT NULL default '0',
  `traffic_used` bigint(30) NOT NULL default '0',
  `deactivated` tinyint(1) NOT NULL default '0',
  `lastlogin_succ` int(11) unsigned NOT NULL default '0',
  `lastlogin_fail` int(11) unsigned NOT NULL default '0',
  `loginfail_count` int(11) unsigned NOT NULL default '0',
  `reportsent` tinyint(4) unsigned NOT NULL default '0',
  `can_manage_aps_packages` tinyint(1) NOT NULL default '1',
  `aps_packages` int(5) NOT NULL default '0',
  `aps_packages_used` int(5) NOT NULL default '0',
  `email_autoresponder` int(5) NOT NULL default '0',
  `email_autoresponder_used` int(5) NOT NULL default '0',
  `theme` varchar(255) NOT NULL default 'Froxlor',
   PRIMARY KEY  (`adminid`),
   UNIQUE KEY `loginname` (`loginname`)
) ENGINE=MyISAM ;


# --------------------------------------------------------

#
# Table structure for table `panel_customers`
#

DROP TABLE IF EXISTS `panel_customers`;
CREATE TABLE `panel_customers` (
  `customerid` int(11) unsigned NOT NULL auto_increment,
  `loginname` varchar(50) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `adminid` int(11) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `firstname` varchar(255) NOT NULL default '',
  `gender` int(1) NOT NULL DEFAULT '0',
  `company` varchar(255) NOT NULL default '',
  `street` varchar(255) NOT NULL default '',
  `zipcode` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `fax` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `customernumber` varchar(255) NOT NULL default '',
  `def_language` varchar(255) NOT NULL default '',
  `diskspace` bigint(30) NOT NULL default '0',
  `diskspace_used` bigint(30) NOT NULL default '0',
  `mysqls` int(15) NOT NULL default '0',
  `mysqls_used` int(15) NOT NULL default '0',
  `emails` int(15) NOT NULL default '0',
  `emails_used` int(15) NOT NULL default '0',
  `email_accounts` int(15) NOT NULL default '0',
  `email_accounts_used` int(15) NOT NULL default '0',
  `email_forwarders` int(15) NOT NULL default '0',
  `email_forwarders_used` int(15) NOT NULL default '0',
  `email_quota` bigint(13) NOT NULL default '0',
  `email_quota_used` bigint(13) NOT NULL default '0',
  `ftps` int(15) NOT NULL default '0',
  `ftps_used` int(15) NOT NULL default '0',
  `tickets` int(15) NOT NULL default '0',
  `tickets_used` int(15) NOT NULL default '0',
  `subdomains` int(15) NOT NULL default '0',
  `subdomains_used` int(15) NOT NULL default '0',
  `traffic` bigint(30) NOT NULL default '0',
  `traffic_used` bigint(30) NOT NULL default '0',
  `documentroot` varchar(255) NOT NULL default '',
  `standardsubdomain` int(11) NOT NULL default '0',
  `guid` int(5) NOT NULL default '0',
  `ftp_lastaccountnumber` int(11) NOT NULL default '0',
  `mysql_lastaccountnumber` int(11) NOT NULL default '0',
  `deactivated` tinyint(1) NOT NULL default '0',
  `phpenabled` tinyint(1) NOT NULL default '1',
  `lastlogin_succ` int(11) unsigned NOT NULL default '0',
  `lastlogin_fail` int(11) unsigned NOT NULL default '0',
  `loginfail_count` int(11) unsigned NOT NULL default '0',
  `reportsent` tinyint(4) unsigned NOT NULL default '0',
  `pop3` tinyint(1) NOT NULL default '1',
  `imap` tinyint(1) NOT NULL default '1',
  `aps_packages` int(5) NOT NULL default '0',
  `aps_packages_used` int(5) NOT NULL default '0',
  `perlenabled` tinyint(1) NOT NULL default '0',
  `email_autoresponder` int(5) NOT NULL default '0',
  `email_autoresponder_used` int(5) NOT NULL default '0',
  `theme` varchar(255) NOT NULL default 'Froxlor',
  `backup_allowed` TINYINT( 1 ) NOT NULL DEFAULT '1',
  `backup_enabled` TINYINT( 1 ) NOT NULL DEFAULT '0',
   PRIMARY KEY  (`customerid`),
   UNIQUE KEY `loginname` (`loginname`)
) ENGINE=MyISAM ;
#
# Dumping data for table `panel_customers`
#


# --------------------------------------------------------

#
# Table structure for table `panel_databases`
#

DROP TABLE IF EXISTS `panel_databases`;
CREATE TABLE `panel_databases` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `customerid` int(11) NOT NULL default '0',
  `databasename` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `dbserver` int(11) unsigned NOT NULL default '0',
  `apsdb` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `customerid` (`customerid`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_databases`
#


# --------------------------------------------------------

#
# Table structure for table `panel_domains`
#
DROP TABLE IF EXISTS `panel_domains`;
CREATE TABLE `panel_domains` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `domain` varchar(255) NOT NULL default '',
  `adminid` int(11) unsigned NOT NULL default '0',
  `customerid` int(11) unsigned NOT NULL default '0',
  `aliasdomain` int(11) unsigned NULL,
  `documentroot` varchar(255) NOT NULL default '',
  `ipandport` int(11) unsigned NOT NULL default '1',
  `isbinddomain` tinyint(1) NOT NULL default '0',
  `isemaildomain` tinyint(1) NOT NULL default '0',
  `email_only` tinyint(1) NOT NULL default '0',
  `iswildcarddomain` tinyint(1) NOT NULL default '1',
  `subcanemaildomain` tinyint(1) NOT NULL default '0',
  `caneditdomain` tinyint(1) NOT NULL default '1',
  `zonefile` varchar(255) NOT NULL default '',
  `dkim` tinyint(1) NOT NULL default '0',
  `dkim_id` int(11) unsigned NOT NULL,
  `dkim_privkey` text NOT NULL,
  `dkim_pubkey` text NOT NULL,
  `wwwserveralias` tinyint(1) NOT NULL default '1',
  `parentdomainid` int(11) unsigned NOT NULL default '0',
  `openbasedir` tinyint(1) NOT NULL default '0',
  `openbasedir_path` tinyint(1) NOT NULL default '0',
  `safemode` tinyint(1) NOT NULL default '0',
  `speciallogfile` tinyint(1) NOT NULL default '0',
  `ssl` tinyint(4) NOT NULL default '0',
  `ssl_redirect` tinyint(4) NOT NULL default '0',
  `ssl_ipandport` tinyint(4) NOT NULL default '0',
  `specialsettings` text NOT NULL,
  `deactivated` tinyint(1) NOT NULL default '0',
  `bindserial` varchar(10) NOT NULL default '2000010100',
  `add_date` int( 11 ) NOT NULL default '0',
  `registration_date` date NOT NULL,
  `phpsettingid` INT( 11 ) UNSIGNED NOT NULL DEFAULT '1',
  `mod_fcgid_starter` int(4) default '-1',
  `mod_fcgid_maxrequests` int(4) default '-1',
  `ismainbutsubto` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `customerid` (`customerid`),
  KEY `parentdomain` (`parentdomainid`),
  KEY `domain` (`domain`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_domains`
#


# --------------------------------------------------------

#
# Table structure for table `panel_ipsandports`
#
DROP TABLE IF EXISTS `panel_ipsandports`;
CREATE TABLE `panel_ipsandports` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `ip` varchar(39) NOT NULL default '',
  `port` int(5) NOT NULL default '80',
  `listen_statement` tinyint(1) NOT NULL default '0',
  `namevirtualhost_statement` tinyint(1) NOT NULL default '0',
  `vhostcontainer` tinyint(1) NOT NULL default '0',
  `vhostcontainer_servername_statement` tinyint(1) NOT NULL default '0',
  `specialsettings` text NOT NULL,
  `ssl` tinyint(4) NOT NULL default '0',
  `ssl_cert_file` varchar(255) NOT NULL,
  `ssl_key_file` varchar(255) NOT NULL,
  `ssl_ca_file` varchar(255) NOT NULL,
  `default_vhostconf_domain` text NOT NULL,
  `ssl_cert_chainfile` varchar(255) NOT NULL,
  `docroot` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_ipsandports`
#



# --------------------------------------------------------

#
# Table structure for table `panel_htaccess`
#

DROP TABLE IF EXISTS `panel_htaccess`;
CREATE TABLE `panel_htaccess` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `customerid` int(11) unsigned NOT NULL default '0',
  `path` varchar(255) NOT NULL default '',
  `options_indexes` tinyint(1) NOT NULL default '0',
  `error404path` varchar(255) NOT NULL default '',
  `error403path` varchar(255) NOT NULL default '',
  `error500path` varchar(255) NOT NULL default '',
  `error401path` varchar(255) NOT NULL default '',
  `options_cgi` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_htaccess`
#


# --------------------------------------------------------

#
# Table structure for table `panel_htpasswds`
#

DROP TABLE IF EXISTS `panel_htpasswds`;
CREATE TABLE `panel_htpasswds` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `customerid` int(11) unsigned NOT NULL default '0',
  `path` varchar(255) NOT NULL default '',
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `authname` varchar(255) NOT NULL default 'Restricted Area',
  PRIMARY KEY  (`id`),
  KEY `customerid` (`customerid`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_htpasswds`
#


# --------------------------------------------------------

#
# Table structure for table `panel_sessions`
#

DROP TABLE IF EXISTS `panel_sessions`;
CREATE TABLE `panel_sessions` (
  `hash` varchar(32) NOT NULL default '',
  `userid` int(11) unsigned NOT NULL default '0',
  `ipaddress` varchar(255) NOT NULL default '',
  `useragent` varchar(255) NOT NULL default '',
  `lastactivity` int(11) unsigned NOT NULL default '0',
  `lastpaging` varchar(255) NOT NULL default '',
  `formtoken` char(32) NOT NULL default '',
  `language` varchar(64) NOT NULL default '',
  `adminsession` tinyint(1) unsigned NOT NULL default '0',
  `theme` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`hash`),
  KEY `userid` (`userid`)
) ENGINE=HEAP;

#
# Dumping data for table `panel_sessions`
#


# --------------------------------------------------------

#
# Table structure for table `panel_settings`
#

DROP TABLE IF EXISTS `panel_settings`;
CREATE TABLE `panel_settings` (
  `settingid` int(11) unsigned NOT NULL auto_increment,
  `settinggroup` varchar(255) NOT NULL default '',
  `varname` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`settingid`)
) ENGINE=MyISAM ;


# --------------------------------------------------------

#
# Dumping data for table `panel_settings`
#

INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('session', 'sessiontimeout', '600');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'adminmail', 'admin@SERVERNAME');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'phpmyadmin_url', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('customer', 'accountprefix', 'web');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('customer', 'ftpprefix', 'ftp');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('customer', 'mysqlprefix', 'sql');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'lastaccountnumber', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'lastguid', '9999');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'documentroot_prefix', '/var/customers/webs/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'logfiles_directory', '/var/customers/logs/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'ipaddress', 'SERVERIP');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'apachereload_command', '/etc/init.d/apache reload');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'last_traffic_run', '000000');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'vmail_uid', '2000');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'vmail_gid', '2000');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'vmail_homedir', '/var/customers/mail/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'bind_enable', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'bindconf_directory', '/etc/bind/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'bindreload_command', '/etc/init.d/bind9 reload');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'version', '0.9.28-svn2');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'hostname', 'SERVERNAME');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('login', 'maxloginattempts', '3');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('login', 'deactivatetime', '900');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'webmail_url', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'webftp_url', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'standardlanguage', 'English');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mysql_access_host', 'localhost');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'pathedit', 'Manual');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'lastcronrun', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'paging', '20');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'defaultip', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'phpappendopenbasedir', '/tmp/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'natsorting', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'deactivateddocroot', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mailpwcleartext', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'last_tasks_run', '000000');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('customer', 'ftpatdomain', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'nameservers', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mxservers', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_log_sql', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'sendalternativemail', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'apacheconf_vhost', '/etc/apache/vhosts.conf');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'apacheconf_diroptions', '/etc/apache/diroptions.conf');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'apacheconf_htpasswddir', '/etc/apache/htpasswd/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'webalizer_quiet', '2');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'noreply_email', 'NO-REPLY@SERVERNAME');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'worktime_all', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'worktime_begin', '00:00');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'worktime_end', '23:59');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'worktime_sat', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'worktime_sun', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'archiving_days', '5');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'last_archive_run', '000000');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'enabled', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'concurrently_open', '5');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'noreply_name', 'Froxlor Support');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_configdir', '/var/www/php-fcgi-scripts');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_tmpdir', '/var/customers/tmp');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'reset_cycle', '2');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'no_robots', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('logger', 'enabled', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('logger', 'log_cron', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('logger', 'logfile', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('logger', 'logtypes', 'syslog,mysql');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('logger', 'severity', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'ssl_cert_file', '/etc/apache2/apache2.pem');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'use_ssl', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'openssl_cnf', '[ req ]\r\ndefault_bits = 1024\r\ndistinguished_name = req_distinguished_name\r\nattributes = req_attributes\r\nprompt = no\r\noutput_password =\r\ninput_password =\r\n[ req_distinguished_name ]\r\nC = DE\r\nST = froxlor\r\nL = froxlor    \r\nO = Testcertificate\r\nOU = froxlor        \r\nCN = @@domain_name@@\r\nemailAddress = @@email@@    \r\n[ req_attributes ]\r\nchallengePassword =\r\n');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'default_vhostconf', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mail_quota_enabled', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mail_quota', '100');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'decimal_places', '4');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'use_dkim', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'webalizer_enabled', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_enabled', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_prefix', '/etc/postfix/dkim/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_domains', 'domains');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_dkimkeys', 'dkim-keys.conf');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkimrestart_command', '/etc/init.d/dkim-filter restart');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'unix_names', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'allow_preset', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'allow_preset_admin', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'httpuser', 'www-data');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'httpgroup', 'www-data');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'webserver', 'apache2');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('autoresponder', 'autoresponder_active', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('autoresponder', 'last_autoresponder_run', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('admin', 'show_version_login', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('admin', 'show_version_footer', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_wrapper', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_starter', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_peardir', '/usr/share/php/:/usr/share/php5/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'index_file_extension', 'html');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'items_per_page', '20');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'upload_fields', '5');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'aps_active', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'php-extension', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'php-configuration', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'webserver-htaccess', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'php-function', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('aps', 'webserver-module', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('session', 'allow_multiple_login', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'allow_domain_change_admin', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'allow_domain_change_customer', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_maxrequests', '250');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system','ssl_key_file','/etc/apache2/apache2.key');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system','ssl_ca_file', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'frontend', 'froxlor');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('spf', 'use_spf', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('spf', 'spf_entry', '@	IN	TXT	"v=spf1 a mx -all"');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'debug_cron', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'password_min_length', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'store_index_file_subs', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'adminmail_defname', 'Froxlor Administrator');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'adminmail_return', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_algorithm', 'all');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_add_adsp', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_keylength', '1024');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_servicetype', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_add_adsppolicy', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('dkim', 'dkim_notes', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'stdsubdomain', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_path', '/usr/bin/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_conf', '/etc/awstats/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'defaultttl', '604800');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'enabled', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err401', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err403', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err404', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('defaultwebsrverrhandler', 'err500', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('ticket', 'default_priority', '2');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_defaultini', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'ftpserver', 'proftpd');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('customredirect', 'enabled', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('customredirect', 'default', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'dns_createmailentry', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'froxlordirectlyviahostname', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'password_regex', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'perl_path', '/usr/bin/perl');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_ownvhost', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_httpuser', 'froxlorlocal');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_httpgroup', 'froxlorlocal');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('perl', 'suexecworkaround', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('perl', 'suexecpath', '/var/www/cgi-bin/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_awstatspath', '/usr/bin/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_defaultini_ownvhost', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'awstats_icons', '/usr/share/awstats/icon/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'ssl_cert_chainfile', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('login', 'domain_login', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'nginx_php_backend', '127.0.0.1:8888');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'perl_server', 'unix:/var/run/nginx/cgiwrap-dispatch.sock');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'phpreload_command', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'enabled', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'configdir', '/etc/php-fpm.d/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'reload', '/etc/init.d/php-fpm restart');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'pm', 'static');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'max_children', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'start_servers', '20');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'min_spare_servers', '5');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'max_spare_servers', '35');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'max_requests', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'tmpdir', '/var/customers/tmp/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'peardir', '/usr/share/php/:/usr/share/php5/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'enabled_ownvhost', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'vhost_httpuser', 'froxlorlocal');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'vhost_httpgroup', 'froxlorlocal');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'idle_timeout', '30');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('phpfpm', 'aliasconfigdir', '/var/www/php-fpm/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'report_enable', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'report_webmax', '90');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'report_trafficmax', '90');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('panel', 'default_theme', 'Froxlor');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'validate_domain', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_enabled', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_dir', '/var/customers/backups/');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_mysqldump_path', '/usr/bin/mysqldump');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_count', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_bigfile', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_enabled', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_server', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_user', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_pass', '');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'backup_ftp_passive', '1');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'diskquota_enabled', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'diskquota_repquota_path', '/usr/sbin/repquota');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'diskquota_quotatool_path', '/usr/bin/quotatool');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'diskquota_customer_partition', '/dev/root');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'logrotate_enabled', '0');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'logrotate_binary', '/usr/sbin/logrotate');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'logrotate_interval', 'weekly');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'logrotate_keep', '4');
INSERT INTO `panel_settings` (`settinggroup`, `varname`, `value`) VALUES ('system', 'mod_fcgid_idle_timeout', '30');
# --------------------------------------------------------

#
# Table structure for table `panel_tasks`
#

DROP TABLE IF EXISTS `panel_tasks`;
CREATE TABLE `panel_tasks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type` int(11) NOT NULL default '0',
  `data` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_tasks`
#


# --------------------------------------------------------

#
# Table structure for table `panel_templates`
#

DROP TABLE IF EXISTS `panel_templates`;
CREATE TABLE `panel_templates` (
  `id` int(11) NOT NULL auto_increment,
  `adminid` int(11) NOT NULL default '0',
  `language` varchar(255) NOT NULL default '',
  `templategroup` varchar(255) NOT NULL default '',
  `varname` varchar(255) NOT NULL default '',
  `value` longtext NOT NULL,
  PRIMARY KEY  (id),
  KEY adminid (adminid)
) ENGINE=MyISAM;

#
# Dumping data for table `panel_templates`
#


# --------------------------------------------------------

#
# Table structure for table `panel_traffic`
#

DROP TABLE IF EXISTS `panel_traffic`;
CREATE TABLE `panel_traffic` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `customerid` int(11) unsigned NOT NULL default '0',
  `year` int(4) unsigned zerofill NOT NULL default '0000',
  `month` int(2) unsigned zerofill NOT NULL default '00',
  `day` int(2) unsigned zerofill NOT NULL default '00',
  `stamp` int(11) unsigned NOT NULL default '0',
  `http` bigint(30) unsigned NOT NULL default '0',
  `ftp_up` bigint(30) unsigned NOT NULL default '0',
  `ftp_down` bigint(30) unsigned NOT NULL default '0',
  `mail` bigint(30) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `customerid` (`customerid`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_traffic`
#


# --------------------------------------------------------

#
# Table structure for table `panel_traffic_admins`
#

DROP TABLE IF EXISTS `panel_traffic_admins`;
CREATE TABLE `panel_traffic_admins` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `adminid` int(11) unsigned NOT NULL default '0',
  `year` int(4) unsigned zerofill NOT NULL default '0000',
  `month` int(2) unsigned zerofill NOT NULL default '00',
  `day` int(2) unsigned zerofill NOT NULL default '00',
  `stamp` int(11) unsigned NOT NULL default '0',
  `http` bigint(30) unsigned NOT NULL default '0',
  `ftp_up` bigint(30) unsigned NOT NULL default '0',
  `ftp_down` bigint(30) unsigned NOT NULL default '0',
  `mail` bigint(30) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `adminid` (`adminid`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_traffic_admins`
#



# --------------------------------------------------------

#
# Table structure for table `panel_diskspace`
#

CREATE TABLE `panel_diskspace` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `customerid` int(11) unsigned NOT NULL default '0',
  `year` int(4) unsigned zerofill NOT NULL default '0000',
  `month` int(2) unsigned zerofill NOT NULL default '00',
  `day` int(2) unsigned zerofill NOT NULL default '00',
  `stamp` int(11) unsigned NOT NULL default '0',
  `webspace` bigint(30) unsigned NOT NULL default '0',
  `mail` bigint(30) unsigned NOT NULL default '0',
  `mysql` bigint(30) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `customerid` (`customerid`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_diskspace`
#


# --------------------------------------------------------

#
# Table structure for table `panel_diskspace_admins`
#

CREATE TABLE `panel_diskspace_admins` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `adminid` int(11) unsigned NOT NULL default '0',
  `year` int(4) unsigned zerofill NOT NULL default '0000',
  `month` int(2) unsigned zerofill NOT NULL default '00',
  `day` int(2) unsigned zerofill NOT NULL default '00',
  `stamp` int(11) unsigned NOT NULL default '0',
  `webspace` bigint(30) unsigned NOT NULL default '0',
  `mail` bigint(30) unsigned NOT NULL default '0',
  `mysql` bigint(30) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `adminid` (`adminid`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_diskspace_admins`
#

# --------------------------------------------------------

#
# Table structure for table `panel_languages`
#

DROP TABLE IF EXISTS `panel_languages`;
CREATE TABLE `panel_languages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language` varchar(30) NOT NULL DEFAULT '',
  `iso` char(3) NOT NULL DEFAULT 'foo',
  `file` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM ;

#
# Dumping data for table `panel_languages`
#

INSERT INTO `panel_languages` (`id`, `language`, `iso`, `file`) VALUES
    (1, 'Deutsch', 'de', 'lng/german.lng.php'),
    (2, 'English', 'en', 'lng/english.lng.php'),
    (3, 'Fran&ccedil;ais', 'fr', 'lng/french.lng.php'),
    (4, 'Chinese', 'zh', 'lng/zh-cn.lng.php'),
    (5, 'Catalan', 'ca', 'lng/catalan.lng.php'),
    (6, 'Espa&ntilde;ol', 'es', 'lng/spanish.lng.php'),
    (7, 'Portugu&ecirc;s', 'pt', 'lng/portugues.lng.php'),
    (8, 'Russian', 'ru', 'lng/russian.lng.php'),
    (9, 'Danish', 'da', 'lng/danish.lng.php'),
    (10, 'Italian', 'it', 'lng/italian.lng.php'),
    (11, 'Bulgarian', 'bg', 'lng/bulgarian.lng.php'),
    (12, 'Slovak', 'sk', 'lng/slovak.lng.php'),
    (13, 'Dutch', 'nl', 'lng/dutch.lng.php'),
    (14, 'Hungarian', 'hu', 'lng/hungarian.lng.php'),
    (15, 'Swedish', 'sv', 'lng/swedish.lng.php'),
    (16, 'Czech', 'cz', 'lng/czech.lng.php'),
    (17, 'Polski', 'pl', 'lng/polish.lng.php');

# --------------------------------------------------------

#
# Table structure for table `panel_tickets`
#

DROP TABLE IF EXISTS `panel_tickets`;
CREATE TABLE `panel_tickets` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `customerid` int(11) NOT NULL,
  `adminid` int(11) NOT NULL,
  `category` smallint(5) unsigned NOT NULL default '1',
  `priority` enum('1','2','3') NOT NULL default '3',
  `subject` varchar(70) NOT NULL,
  `message` text NOT NULL,
  `dt` int(15) NOT NULL,
  `lastchange` int(15) NOT NULL,
  `ip` varchar(39) NOT NULL default '',
  `status` enum('0','1','2','3') NOT NULL default '1',
  `lastreplier` enum('0','1') NOT NULL default '0',
  `answerto` int(11) unsigned NOT NULL,
  `by` enum('0','1') NOT NULL default '0',
  `archived` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `customerid` (`customerid`)
) ENGINE=MyISAM;


# --------------------------------------------------------

#
# Table structure for table `panel_ticket_categories`
#

DROP TABLE IF EXISTS `panel_ticket_categories`;
CREATE TABLE `panel_ticket_categories` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL,
  `adminid` int(11) NOT NULL,
  `logicalorder` int(3) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

#
# Dumping data for table `panel_ticket_categories`
#


# --------------------------------------------------------

#
# Table structure for table `panel_syslog`
#

DROP TABLE IF EXISTS `panel_syslog`;
CREATE TABLE IF NOT EXISTS `panel_syslog` (
  `logid` bigint(20) NOT NULL auto_increment,
  `action` int(5) NOT NULL default '10',
  `type` int(5) NOT NULL default '0',
  `date` int(15) NOT NULL,
  `user` varchar(50) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`logid`)
) ENGINE=MyISAM;

#
# Dumping data for table `panel_syslog`
#


# --------------------------------------------------------

#
# Table structure for table `mail_autoresponder`
#

DROP TABLE IF EXISTS `mail_autoresponder`;
CREATE TABLE `mail_autoresponder` (
  `email` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `enabled` tinyint(1) NOT NULL default '0',
  `date_from` int(15) NOT NULL default '-1',
  `date_until` int(15) NOT NULL default '-1',
  `subject` varchar(255) NOT NULL default '',
  `customerid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`email`),
  KEY `customerid` (`customerid`),
  FULLTEXT KEY `message` (`message`)
) ENGINE=MyISAM;

#
# Dumping data for table `mail_autoresponder`
#


# --------------------------------------------------------

#
# Table structure for table `panel_phpconfigs`
#

DROP TABLE IF EXISTS `panel_phpconfigs`;
CREATE TABLE `panel_phpconfigs` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `description` varchar(50) NOT NULL,
  `binary` varchar(255) NOT NULL,
  `file_extensions` varchar(255) NOT NULL,
  `mod_fcgid_starter` int(4) NOT NULL DEFAULT '-1',
  `mod_fcgid_maxrequests` int(4) NOT NULL DEFAULT '-1',
  `phpsettings` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

#
# Dumping data for table `panel_phpconfigs`
#

INSERT INTO `panel_phpconfigs` (`id`, `description`, `binary`, `file_extensions`, `mod_fcgid_starter`, `mod_fcgid_maxrequests`, `phpsettings`) VALUES(1, 'Default Config', '/usr/bin/php-cgi', 'php', '-1', '-1', 'allow_call_time_pass_reference = Off\r\nallow_url_fopen = Off\r\nasp_tags = Off\r\ndisable_classes =\r\ndisable_functions = curl_exec,curl_multi_exec,exec,parse_ini_file,passthru,popen,proc_close,proc_get_status,proc_nice,proc_open,proc_terminate,shell_exec,show_source,system\r\ndisplay_errors = Off\r\ndisplay_startup_errors = Off\r\nenable_dl = Off\r\nerror_reporting = E_ALL & ~E_NOTICE\r\nexpose_php = Off\r\nfile_uploads = On\r\ncgi.force_redirect = 1\r\ngpc_order = "GPC"\r\nhtml_errors = Off\r\nignore_repeated_errors = Off\r\nignore_repeated_source = Off\r\ninclude_path = ".:{PEAR_DIR}"\r\nlog_errors = On\r\nlog_errors_max_len = 1024\r\nmagic_quotes_gpc = Off\r\nmagic_quotes_runtime = Off\r\nmagic_quotes_sybase = Off\r\nmax_execution_time = 30\r\nmax_input_time = 60\r\nmemory_limit = 16M\r\n{OPEN_BASEDIR_C}open_basedir = "{OPEN_BASEDIR}"\r\noutput_buffering = 4096\r\npost_max_size = 16M\r\nprecision = 14\r\nregister_argc_argv = Off\r\nregister_globals = Off\r\nreport_memleaks = On\r\nsafe_mode = {SAFE_MODE}\r\nsafe_mode_allowed_env_vars = PHP_\r\nsafe_mode_gid = Off\r\nsafe_mode_include_dir = "{PEAR_DIR}"\r\nsafe_mode_protected_env_vars = LD_LIBRARY_PATH\r\nsendmail_path = "/usr/sbin/sendmail -t -f {CUSTOMER_EMAIL}"\r\nsession.auto_start = 0\r\nsession.bug_compat_42 = 0\r\nsession.bug_compat_warn = 1\r\nsession.cache_expire = 180\r\nsession.cache_limiter = nocache\r\nsession.cookie_domain =\r\nsession.cookie_lifetime = 0\r\nsession.cookie_path = /\r\nsession.entropy_file = /dev/urandom\r\nsession.entropy_length = 16\r\nsession.gc_divisor = 1000\r\nsession.gc_maxlifetime = 1440\r\nsession.gc_probability = 1\r\nsession.name = PHPSESSID\r\nsession.referer_check =\r\nsession.save_handler = files\r\nsession.save_path = "{TMP_DIR}"\r\nsession.serialize_handler = php\r\nsession.use_cookies = 1\r\nsession.use_trans_sid = 0\r\nshort_open_tag = On\r\nsuhosin.mail.protect = 1\r\nsuhosin.simulation = Off\r\ntrack_errors = Off\r\nupload_max_filesize = 32M\r\nupload_tmp_dir = "{TMP_DIR}"\r\nvariables_order = "GPCS"\r\n');
# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `aps_instances`
#

DROP TABLE IF EXISTS `aps_instances`;
CREATE TABLE IF NOT EXISTS `aps_instances` (
  `ID` int(4) NOT NULL auto_increment,
  `CustomerID` int(4) NOT NULL,
  `PackageID` int(4) NOT NULL,
  `Status` int(4) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `aps_packages`
#

DROP TABLE IF EXISTS `aps_packages`;
CREATE TABLE IF NOT EXISTS `aps_packages` (
  `ID` int(4) NOT NULL auto_increment,
  `Path` varchar(500) NOT NULL,
  `Name` varchar(500) NOT NULL,
  `Version` varchar(20) NOT NULL,
  `Release` int(4) NOT NULL,
  `Status` int(1) NOT NULL default '1',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `aps_settings`
#

DROP TABLE IF EXISTS `aps_settings`;
CREATE TABLE IF NOT EXISTS `aps_settings` (
  `ID` int(4) NOT NULL auto_increment,
  `InstanceID` int(4) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Value` varchar(250) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `aps_tasks`
#

DROP TABLE IF EXISTS `aps_tasks`;
CREATE TABLE IF NOT EXISTS `aps_tasks` (
  `ID` int(4) NOT NULL auto_increment,
  `InstanceID` int(4) NOT NULL,
  `Task` int(4) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `aps_temp_settings`
#

DROP TABLE IF EXISTS `aps_temp_settings`;
CREATE TABLE IF NOT EXISTS `aps_temp_settings` (
  `ID` int(4) NOT NULL auto_increment,
  `PackageID` int(4) NOT NULL,
  `CustomerID` int(4) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Value` varchar(250) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `cronjobs_run`
#

DROP TABLE IF EXISTS `cronjobs_run`;
CREATE TABLE IF NOT EXISTS `cronjobs_run` (
  `id` bigint(20) NOT NULL auto_increment,
  `module` varchar(250) NOT NULL,
  `cronfile` varchar(250) NOT NULL,
  `lastrun` int(15) NOT NULL DEFAULT '0',
  `interval` varchar(100) NOT NULL DEFAULT '5 MINUTE',
  `isactive` tinyint(1) DEFAULT '1',
  `desc_lng_key` varchar(100) NOT NULL DEFAULT 'cron_unknown_desc',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

#
# Dumping data for table `panel_phpconfigs`
#

INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (1, 'froxlor/core', 'cron_tasks.php', '5 MINUTE', '1', 'cron_tasks');
INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (2, 'froxlor/aps', 'cron_apsinstaller.php', '5 MINUTE', '0', 'cron_apsinstaller');
INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (3, 'froxlor/autoresponder', 'cron_autoresponder.php', '5 MINUTE', '0', 'cron_autoresponder');
INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (4, 'froxlor/aps', 'cron_apsupdater.php', '1 HOUR', '0', 'cron_apsupdater');
INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (5, 'froxlor/core', 'cron_traffic.php', '1 DAY', '1', 'cron_traffic');
INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (6, 'froxlor/ticket', 'cron_used_tickets_reset.php', '1 DAY', '1', 'cron_ticketsreset');
INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (7, 'froxlor/ticket', 'cron_ticketarchive.php', '1 MONTH', '1', 'cron_ticketarchive');
INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (8, 'froxlor/reports', 'cron_usage_report.php', '1 DAY', '1', 'cron_usage_report');
INSERT INTO `cronjobs_run` (`id`, `module`, `cronfile`, `interval`, `isactive`, `desc_lng_key`) VALUES (9, 'froxlor/backup', 'cron_backup.php', '1 Day', '1', 'cron_backup');
# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `ftp_quotalimits`
#

DROP TABLE IF EXISTS `ftp_quotalimits`;
CREATE TABLE IF NOT EXISTS `ftp_quotalimits` (
  `name` varchar(30) default NULL,
  `quota_type` enum('user','group','class','all') NOT NULL default 'user',
  `per_session` enum('false','true') NOT NULL default 'false',
  `limit_type` enum('soft','hard') NOT NULL default 'hard',
  `bytes_in_avail` float NOT NULL,
  `bytes_out_avail` float NOT NULL,
  `bytes_xfer_avail` float NOT NULL,
  `files_in_avail` int(10) unsigned NOT NULL,
  `files_out_avail` int(10) unsigned NOT NULL,
  `files_xfer_avail` int(10) unsigned NOT NULL
) ENGINE=MyISAM;

#
# Dumping data for table `ftp_quotalimits`
#

INSERT INTO `ftp_quotalimits` (`name`, `quota_type`, `per_session`, `limit_type`, `bytes_in_avail`, `bytes_out_avail`, `bytes_xfer_avail`, `files_in_avail`, `files_out_avail`, `files_xfer_avail`) VALUES ('froxlor', 'user', 'false', 'hard', 0, 0, 0, 0, 0, 0);

# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `ftp_quotatallies`
#

DROP TABLE IF EXISTS `ftp_quotatallies`;
CREATE TABLE IF NOT EXISTS `ftp_quotatallies` (
  `name` varchar(30) NOT NULL,
  `quota_type` enum('user','group','class','all') NOT NULL,
  `bytes_in_used` float NOT NULL,
  `bytes_out_used` float NOT NULL,
  `bytes_xfer_used` float NOT NULL,
  `files_in_used` int(10) unsigned NOT NULL,
  `files_out_used` int(10) unsigned NOT NULL,
  `files_xfer_used` int(10) unsigned NOT NULL
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `redirect_codes`
#

DROP TABLE IF EXISTS `redirect_codes`;
CREATE TABLE IF NOT EXISTS `redirect_codes` (
  `id` int(5) NOT NULL auto_increment,
  `code` varchar(3) NOT NULL,
  `desc` varchar(200) NOT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

#
# Dumping data for table `redirect_codes`
#

INSERT INTO `redirect_codes` (`id`, `code`, `desc`, `enabled`) VALUES (1, '---', 'rc_default', 1);
INSERT INTO `redirect_codes` (`id`, `code`, `desc`, `enabled`) VALUES (2, '301', 'rc_movedperm', 1);
INSERT INTO `redirect_codes` (`id`, `code`, `desc`, `enabled`) VALUES (3, '302', 'rc_found', 1);
INSERT INTO `redirect_codes` (`id`, `code`, `desc`, `enabled`) VALUES (4, '303', 'rc_seeother', 1);
INSERT INTO `redirect_codes` (`id`, `code`, `desc`, `enabled`) VALUES (5, '307', 'rc_tempred', 1);

# --------------------------------------------------------

#
# Tabellenstruktur fuer Tabelle `domain_redirect_codes`
#

DROP TABLE IF EXISTS `domain_redirect_codes`;
CREATE TABLE IF NOT EXISTS `domain_redirect_codes` (
  `rid` int(5) NOT NULL,
  `did` int(11) unsigned NOT NULL,
  UNIQUE KEY `rc` (`rid`, `did`)
) ENGINE=MyISAM;


#
# Tabellenstruktur fuer Tabelle `ipsandports_docrootsettings`
#

DROP TABLE IF EXISTS `ipsandports_docrootsettings`;
CREATE TABLE IF NOT EXISTS `ipsandports_docrootsettings` (
  `id` int(5) NOT NULL auto_increment,
  `fid` int(11) NOT NULL,
  `docrootsettings` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;


#
# Tabellenstruktur fuer Tabelle `domain_docrootsettings`
#

DROP TABLE IF EXISTS `domain_docrootsettings`;
CREATE TABLE IF NOT EXISTS `domain_docrootsettings` (
  `id` int(5) NOT NULL auto_increment,
  `fid` int(11) NOT NULL,
  `docrootsettings` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

