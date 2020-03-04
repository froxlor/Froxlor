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
$lng['requirements']['title'] = 'Checking system requirements...';
$lng['requirements']['installed'] = 'installed';
$lng['requirements']['not_true'] = 'no';
$lng['requirements']['notfound'] = 'not found';
$lng['requirements']['notinstalled'] = 'not installed';
$lng['requirements']['activated'] = 'enabled';
$lng['requirements']['phpversion'] = 'PHP version >= 7.0';
$lng['requirements']['newerphpprefered'] = 'Good, but php-7.1 is prefered.';
$lng['requirements']['phppdo'] = 'PHP PDO extension and PDO-MySQL driver...';
$lng['requirements']['phpsession'] = 'PHP session-extension...';
$lng['requirements']['phpctype'] = 'PHP ctype-extension...';
$lng['requirements']['phpsimplexml'] = 'PHP SimpleXML-extension...';
$lng['requirements']['phpxml'] = 'PHP XML-extension...';
$lng['requirements']['phpfilter'] = 'PHP filter-extension...';
$lng['requirements']['phpposix'] = 'PHP posix-extension...';
$lng['requirements']['phpbcmath'] = 'PHP bcmath-extension...';
$lng['requirements']['phpcurl'] = 'PHP curl-extension...';
$lng['requirements']['phpmbstring'] = 'PHP mbstring-extension...';
$lng['requirements']['phpzip'] = 'PHP zip-extension...';
$lng['requirements']['phpjson'] = 'PHP json-extension...';
$lng['requirements']['bcmathdescription'] = 'Traffic-calculation related functions will not work correctly!';
$lng['requirements']['zipdescription'] = 'The auto-update feature requires the zip extension.';
$lng['requirements']['openbasedir'] = 'open_basedir...';
$lng['requirements']['openbasedirenabled'] = 'Froxlor will not work properly with open_basedir enabled. Please disable open_basedir for Froxlor in the coresponding php.ini';
$lng['requirements']['mysqldump'] = 'MySQL dump tool';
$lng['requirements']['mysqldumpmissing'] = 'Automatic backup of possible existing database is not possible. Please install mysql-client tools';
$lng['requirements']['diedbecauseofrequirements'] = 'Cannot install Froxlor without these requirements! Try to fix them and retry.';
$lng['requirements']['froxlor_succ_checks'] = 'All requirements are satisfied';

$lng['install']['lngtitle'] = 'Froxlor install - choose language';
$lng['install']['language'] = 'Installation language';
$lng['install']['lngbtn_go'] = 'Change language';
$lng['install']['title'] = 'Froxlor install - setup';
$lng['install']['welcometext'] = 'Thank you for choosing Froxlor. Please fill out the following fields with the required information to start the installation.<br /><b>Attention:</b> If the database you chose for Froxlor already exists on your System, it will be erased with all containing data!';
$lng['install']['database'] = 'Database connection';
$lng['install']['mysql_host'] = 'MySQL-Hostname';
$lng['install']['mysql_database'] = 'Database name';
$lng['install']['mysql_unpriv_user'] = 'Username for the unprivileged MySQL-account';
$lng['install']['mysql_unpriv_pass'] = 'Password for the unprivileged MySQL-account';
$lng['install']['mysql_root_user'] = 'Username for the MySQL-root-account';
$lng['install']['mysql_root_pass'] = 'Password for the MySQL-root-account';
$lng['install']['admin_account'] = 'Administrator Account';
$lng['install']['admin_user'] = 'Administrator Username';
$lng['install']['admin_pass1'] = 'Administrator Password';
$lng['install']['admin_pass2'] = 'Administrator-Password (confirm)';
$lng['install']['activate_newsfeed'] = 'Enable the official newsfeed<br><small>(https://inside.froxlor.org/news/)</small>';
$lng['install']['serversettings'] = 'Server settings';
$lng['install']['servername'] = 'Server name (FQDN, no ip-address)';
$lng['install']['serverip'] = 'Server IP';
$lng['install']['webserver'] = 'Webserver';
$lng['install']['apache2'] = 'Apache 2.2';
$lng['install']['apache24'] = 'Apache 2.4';
$lng['install']['lighttpd'] = 'LigHTTPd';
$lng['install']['nginx'] = 'NGINX';
$lng['install']['httpuser'] = 'HTTP username';
$lng['install']['httpgroup'] = 'HTTP groupname';

$lng['install']['testing_mysql'] = 'Checking MySQL-root access...';
$lng['install']['testing_mysql_fail'] = 'There seems to be a problem with the database-connection. Cannot continue. Please go back and check your credentials.';
$lng['install']['backup_old_db'] = 'Creating backup of old database...';
$lng['install']['backup_binary_missing'] = 'Could not find mysqldump';
$lng['install']['backup_failed'] = 'Could not backup database';
$lng['install']['prepare_db'] = 'Preparing database...';
$lng['install']['create_mysqluser_and_db'] = 'Creating database and username...';
$lng['install']['testing_new_db'] = 'Testing if database and user have been created correctly...';
$lng['install']['importing_data'] = 'Importing data...';
$lng['install']['changing_data'] = 'Adjusting settings...';
$lng['install']['creating_entries'] = 'Inserting new values...';
$lng['install']['adding_admin_user'] = 'Creating admin-account...';
$lng['install']['creating_configfile'] = 'Creating configfile...';
$lng['install']['creating_configfile_temp'] = 'File was saved in %s, please move to ' . dirname(dirname(__DIR__)) . '/lib/userdata.inc.php';
$lng['install']['creating_configfile_failed'] = 'Could not create ' . dirname(dirname(__DIR__)) . '/lib/userdata.inc.php, please create it manually with the following content:';
$lng['install']['froxlor_succ_installed'] = 'Froxlor was installed successfully.';

$lng['click_here_to_refresh'] = 'Click here to check again';
$lng['click_here_to_goback'] = 'Click here to go back';
$lng['click_here_to_continue'] = 'Click here to continue';
$lng['click_here_to_login'] = 'Click here to login.';
