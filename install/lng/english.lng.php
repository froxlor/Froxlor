<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2007 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Language
 * @version    $Id: english.lng.php 2452 2008-11-30 13:12:36Z flo $
 */

/**
 * Begin
 */

$lng['install']['language'] = 'Installation - Language';
$lng['install']['welcome'] = 'Welcome to SysCP Installation';
$lng['install']['welcometext'] = 'Thank you for choosing SysCP. Please fill out the following fields with the required information to start the installation.<br /><b>Attention:</b> If the database you chose for SysCP already exists on your System, it will be erased with all containing data!';
$lng['install']['database'] = 'Database';
$lng['install']['mysql_hostname'] = 'MySQL-Hostname';
$lng['install']['mysql_database'] = 'MySQL-Database';
$lng['install']['mysql_unpriv_user'] = 'Username for the unprivileged MySQL-account';
$lng['install']['mysql_unpriv_pass'] = 'Password for the unprivileged MySQL-account';
$lng['install']['mysql_root_user'] = 'Username for the MySQL-root-account';
$lng['install']['mysql_root_pass'] = 'Password for the MySQL-root-account';
$lng['install']['admin_account'] = 'Administrator Account';
$lng['install']['admin_user'] = 'Administrator Username';
$lng['install']['admin_pass'] = 'Administrator Password';
$lng['install']['admin_pass_confirm'] = 'Administrator-Password (confirm)';
$lng['install']['serversettings'] = 'Server settings';
$lng['install']['servername'] = 'Server name (FQDN)';
$lng['install']['serverip'] = 'Server IP';
$lng['install']['httpuser'] = 'HTTP username';
$lng['install']['httpgroup'] = 'HTTP groupname';
$lng['install']['apacheversion'] = 'Apacheversion';
$lng['install']['next'] = 'Next';

/**
 * Progress
 */

$lng['install']['testing_mysql'] = 'Testing if MySQL-root-username and password are correct...';
$lng['install']['erasing_old_db'] = 'Erasing old Database...';
$lng['install']['backup_old_db'] = 'Create backup of the old Database...';
$lng['install']['backing_up'] = 'Backing up';
$lng['install']['backing_up_binary_missing'] = '/usr/bin/mysqldump is missing';
$lng['install']['create_mysqluser_and_db'] = 'Creating MySQL-database and username...';
$lng['install']['testing_new_db'] = 'Testing if MySQL-database and username have been created correctly...';
$lng['install']['importing_data'] = 'Importing data into MySQL-database...';
$lng['install']['changing_data'] = 'Changing imported data...';
$lng['install']['adding_admin_user'] = 'Adding Administrator Account...';
$lng['install']['creating_configfile'] = 'Creating configfile...';
$lng['install']['creating_configfile_succ'] = 'OK, userdata.inc.php was saved in lib/.';
$lng['install']['creating_configfile_temp'] = 'File was saved in /tmp/userdata.inc.php, please move to lib/.';
$lng['install']['creating_configfile_failed'] = 'Cannot create lib/userdata.inc.php, please create it manually with the following data:';
$lng['install']['syscp_succ_installed'] = 'SysCP was installed successfully.';
$lng['install']['click_here_to_login'] = 'Click here to login.';
$lng['install']['phpmysql'] = 'Testing if PHP MySQL-extension is installed...';
$lng['install']['phpfilter'] = 'Testing if PHP filter-extension is installed...';
$lng['install']['diedbecauseofrequirements'] = 'Cannot install SysCP without these requirements! Aborting...';
$lng['install']['notinstalled'] = 'not installed!';
$lng['install']['phpbcmath'] = 'Testing if PHP bcmath-extension is installed...';
$lng['install']['bcmathdescription'] = 'Traffic-calculation related functions will not work correctly!';
$lng['install']['openbasedir'] = 'Testing if open_basedir is enabled...';
$lng['install']['openbasedirenabled'] = 'enabled. SysCP will not work properly with open_basedir enabled. Please disable open_basedir for syscp';

/**
 * Renamed in 1.2.19-svn40
 */

$lng['install']['webserver'] = 'Webserver';

/*
 * Added in Froxlor 0.9
 */
$lng['install']['phpversion'] = 'Checking for PHP version >= 5.2';
$lng['install']['phpposix'] = 'Testing if PHP posix-extension is installed...';

?>
