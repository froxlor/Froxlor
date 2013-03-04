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
 * @package    Language
 *
 */

/**
 * Begin
 */

$lng['install']['language'] = 'Installation - Language';
$lng['install']['welcome'] = 'Welcome to Froxlor Installation';
$lng['install']['welcometext'] = 'Thank you for choosing Froxlor. Please fill out the following fields with the required information to start the installation.<br /><b>Attention:</b> If the database you chose for Froxlor already exists on your System, it will be erased with all containing data!';
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
$lng['install']['installdata'] = 'Installation - Data';

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
$lng['install']['froxlor_succ_installed'] = 'Froxlor was installed successfully.';
$lng['install']['click_here_to_login'] = 'Click here to login.';
$lng['install']['phpmysql'] = 'Testing if PHP MySQL-extension is installed...';
$lng['install']['phpfilter'] = 'Testing if PHP filter-extension is installed...';
$lng['install']['diedbecauseofrequirements'] = 'Cannot install Froxlor without these requirements! Aborting...';
$lng['install']['notinstalled'] = 'not installed!';
$lng['install']['phpbcmath'] = 'Testing if PHP bcmath-extension is installed...';
$lng['install']['bcmathdescription'] = 'Traffic-calculation related functions will not work correctly!';
$lng['install']['openbasedir'] = 'Testing if open_basedir is enabled...';
$lng['install']['openbasedirenabled'] = 'enabled. Froxlor will not work properly with open_basedir enabled. Please disable open_basedir for Froxlor';

/**
 * ADDED IN 1.2.19-svn7
 */

$lng['install']['servername_should_be_fqdn'] = 'The servername should be a FQDN and not an IP address';

/**
 * Renamed in 1.2.19-svn40
 */

$lng['install']['webserver'] = 'Webserver';

/*
 * Added in Froxlor 0.9
 */
$lng['install']['phpversion'] = 'Checking for PHP version >= 5.2';
$lng['install']['phpposix'] = 'Testing if PHP posix-extension is installed...';

/*
 * Added in Froxlor 0.9.4
 */
$lng['install']['click_here_to_refresh'] = 'Re-check';
$lng['install']['click_here_to_continue'] = 'Continue installation';
$lng['install']['froxlor_succ_checks'] = 'All requirements are satisfied';

/*
 * Added in Froxlor 0.9.13
 */
$lng['install']['phpmagic_quotes_runtime'] = 'Checking whether magic_quotes_runtime is off';
$lng['install']['active'] = 'no';
$lng['install']['phpmagic_quotes_runtime_description'] = 'PHP setting "magic_quotes_runtime" must be set to "Off" in order to avoid strange behavior of Froxlor. Disabling it for now (this is only temporary, please fix our php.ini).';
$lng['install']['phpxml'] = 'Testing if PHP XML-extension is installed...';
?>
