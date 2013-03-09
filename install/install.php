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
 * @package    Install
 *
 */

/**
 * Most elements are taken from the phpBB (www.phpbb.com)
 * installer, (c) 1999 - 2004 phpBB Group.
 */

// ensure that default timezone is set
if(function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get"))
{
	@date_default_timezone_set(@date_default_timezone_get());
}

if(file_exists('../lib/userdata.inc.php'))
{
	/**
	 * Includes the Usersettings eg. MySQL-Username/Passwort etc. to test if Froxlor is already installed
	 */

	require ('../lib/userdata.inc.php');

	if(isset($sql)
	   && is_array($sql)
	) {
		$installed_hint = file_get_contents('../templates/Froxlor/misc/alreadyinstalledhint.tpl');
		die($installed_hint);
	}
}

/**
 * Include the functions
 */

require ('../lib/functions.php');

/**
 * Include the MySQL-Table-Definitions
 */

require ('../lib/tables.inc.php');

/**
 * Language Managament
 */

$languages = Array(
	'german' => 'Deutsch',
	'english' => 'English',
	'french' => 'Francais'
);
$standardlanguage = 'english';

if(isset($_GET['language'])
   && isset($languages[$_GET['language']]))
{
	$language = $_GET['language'];
}
elseif(isset($_POST['language'])
       && isset($languages[$_POST['language']]))
{
	$language = $_POST['language'];
}
else
{
	$language = $standardlanguage;
}

if(file_exists('./lng/' . $language . '.lng.php'))
{
	/**
	 * Includes file /lng/$language.lng.php if it exists
	 */

	require ('./lng/' . $language . '.lng.php');
}

/**
 * BEGIN FUNCTIONS -----------------------------------------------
 */

function page_header() {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Default-Style" content="text/css" />
	<link rel="stylesheet" href="../templates/Froxlor/assets/css/main.css"  />
	<!--[if IE]><link rel="stylesheet" href="../templates/Froxlor/assets/css/main_ie.css"  /><![endif]-->
	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../templates/Froxlor/assets/js/main.js"></script>
	<link href="../templates/Froxlor/assets/img/favicon.ico" rel="icon" type="image/x-icon" />
	<title>Froxlor Server Management Panel - Installation</title>
	<style>
	body {
        font-family: Verdana, Geneva, sans-serif;
	}
	input {
		background: #dae7ee url('../templates/Froxlor/assets/img/icons/text_align_left.png') no-repeat 5px 4px;
	}
	input[type="password"] {
		background: #dae7ee url('../templates/Froxlor/assets/img/icons/password.png') no-repeat 4px 4px;
	}
	input[type="submit"] {
		background: #ccc url('../templates/Froxlor/assets/img/icons/button_ok.png') no-repeat 4px 8px;
	}
	</style>
</head>
<body>
<div class="loginpage">
<?php
}

function page_footer() {
?>
</div>
<footer>
	<span>
		Froxlor &copy; 2009-<?php echo date('Y', time()); ?> by <a href="http://www.froxlor.org/" rel="external">the Froxlor Team</a>
	</span>
</footer>
</body>
</html>
<?php
}

function status_message($case, $text)
{
	if($case == 'begin')
	{
		echo '<tr><td>'.$text;
	}
	else
	{
		echo '</td><td class="installstatus">
			<span style="color:'.$case.';">'.$text.'</span>
		</td></tr>';
	}
}

function requirement_checks() {

	global $lng, $theme;
	page_header();

?>
	<article class="install bradius">
		<header class="dark">
			<img src="../templates/Froxlor/assets/img/logo.png" alt="Froxlor Server Management Panel" />
		</header>

		<section class="installsec">
			<h2>Requirements</h2>
			<table class="noborder">
<?php
	$_die = false;
	
	// check for correct php version
	status_message('begin', $lng['install']['phpversion']);

	if(version_compare("5.2.0", PHP_VERSION, ">="))
	{
		status_message('red', $lng['install']['notinstalled']);
		$_die = true;
	}
	else
	{
		status_message('green', 'OK');
	}

	// Check if magic_quotes_runtime is active
	status_message('begin', $lng['install']['phpmagic_quotes_runtime']);	 
	if(get_magic_quotes_runtime())
	{
	    // Deactivate
	    set_magic_quotes_runtime(false);
	    status_message('orange', $lng['install']['active'] . '<br />' . $lng['install']['phpmagic_quotes_runtime_description']);
	}
	else
	{
		status_message('green', 'OK');
	}

	// check for mysql-extension
	status_message('begin', $lng['install']['phpmysql']);

	if(!extension_loaded('mysql') && !extension_loaded('mysqlnd'))
	{
		status_message('red', $lng['install']['notinstalled']);
		$_die = true;
	}
	else
	{
		status_message('green', 'OK');
	}

	// check for xml-extension
	status_message('begin', $lng['install']['phpxml']);
	
	if(!extension_loaded('xml'))
	{
		status_message('red', $lng['install']['notinstalled']);
		$_die = true;
	}
	else
	{
		status_message('green', 'OK');
	}

	// check for filter-extension
	status_message('begin', $lng['install']['phpfilter']);

	if(!extension_loaded('filter'))
	{
		status_message('red', $lng['install']['notinstalled']);
		$_die = true;
	}
	else
	{
		status_message('green', 'OK');
	}

	// check for posix-extension
	status_message('begin', $lng['install']['phpposix']);	

	if(!extension_loaded('posix'))
	{
		status_message('red', $lng['install']['notinstalled']);
		$_die = true;
	}
	else
	{
		status_message('green', 'OK');
	}

	// check for bcmath extension
	status_message('begin', $lng['install']['phpbcmath']);

	if(!extension_loaded('bcmath'))
	{
		status_message('orange', $lng['install']['notinstalled'] . '<br />' . $lng['install']['bcmathdescription']);
	}
	else
	{
		status_message('green', 'OK');
	}

	// check for open_basedir
	status_message('begin', $lng['install']['openbasedir']);
	$php_ob = @ini_get("open_basedir");

	if(!empty($php_ob)
	   && $php_ob != '')
	{
		status_message('orange', $lng['install']['openbasedirenabled']);
	}
	else
	{
		status_message('green', 'OK');
	}

?>
		</table>
<?php
	if($_die)
	{
?>
		<p style="padding-left:15px;">
			<strong><?php echo $lng['install']['diedbecauseofrequirements']; ?></strong>
		</p>
		<p class="submit">
			<a href="install.php"><?php echo $lng['install']['click_here_to_refresh']; ?></a>
		</p>
<?php 
	} else {
?>
		<p style="padding-left:15px;">
			<strong><?php echo $lng['install']['froxlor_succ_checks']; ?></strong>
		</p>
		<p class="submit">
			<a href="install.php?check=1"><?php echo $lng['install']['click_here_to_continue']; ?></a>
		</p>
<?php
	}
?>
		</section>
	</article>
<?php 
	page_footer();
}

/**
 * END FUNCTIONS ---------------------------------------------------
 */

/**
 * BEGIN VARIABLES ---------------------------------------------------
 */

//guess Servername

if(!empty($_POST['servername']))
{
	$servername = $_POST['servername'];
}
else
{
	if(!empty($_SERVER['SERVER_NAME']))
	{
		if(preg_match('/^[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}$/', $_SERVER['SERVER_NAME']) == false)
		{
			$servername = $_SERVER['SERVER_NAME'];
		}
		else
		{
			$servername = '';
		}
	}
	else
	{
		$servername = '';
	}
}

//guess serverip

if(!empty($_POST['serverip']))
{
	$serverip = $_POST['serverip'];
}
else
{
	if(!empty($_SERVER['SERVER_ADDR']))
	{
		$serverip = $_SERVER['SERVER_ADDR'];
	}
	else
	{
		$serverip = '';
	}
}

if(!empty($_POST['mysql_host']))
{
	$mysql_host = $_POST['mysql_host'];
}
else
{
	$mysql_host = '127.0.0.1';
}

if(!empty($_POST['mysql_database']))
{
	$mysql_database = $_POST['mysql_database'];
}
else
{
	$mysql_database = 'froxlor';
}

if(!empty($_POST['mysql_unpriv_user']))
{
	$mysql_unpriv_user = $_POST['mysql_unpriv_user'];
}
else
{
	$mysql_unpriv_user = 'froxlor';
}

if(!empty($_POST['mysql_unpriv_pass']))
{
	$mysql_unpriv_pass = $_POST['mysql_unpriv_pass'];
}
else
{
	$mysql_unpriv_pass = '';
}

if(!empty($_POST['mysql_root_user']))
{
	$mysql_root_user = $_POST['mysql_root_user'];
}
else
{
	$mysql_root_user = 'root';
}

if(!empty($_POST['mysql_root_pass']))
{
	$mysql_root_pass = $_POST['mysql_root_pass'];
}
else
{
	$mysql_root_pass = '';
}

if(!empty($_POST['admin_user']))
{
	$admin_user = $_POST['admin_user'];
}
else
{
	$admin_user = 'admin';
}

if(!empty($_POST['admin_pass1']))
{
	$admin_pass1 = $_POST['admin_pass1'];
}
else
{
	$admin_pass1 = '';
}

if(!empty($_POST['admin_pass2']))
{
	$admin_pass2 = $_POST['admin_pass2'];
}
else
{
	$admin_pass2 = '';
}

if($mysql_host == 'localhost'
   || $mysql_host == '127.0.0.1')
{
	$mysql_access_host = $mysql_host;
}
else
{
	$mysql_access_host = $serverip;
}

// gues http software

if(!empty($_POST['webserver']))
{
	$webserver = $_POST['webserver'];
}
else
{
	if(strtoupper(@php_sapi_name()) == "APACHE2HANDLER"
	   || stristr($_SERVER['SERVER_SOFTWARE'], "apache/2"))
	{
		$webserver = 'apache2';
	}
	elseif(substr(strtoupper(@php_sapi_name()), 0, 8) == "LIGHTTPD"
	       || stristr($_SERVER['SERVER_SOFTWARE'], "lighttpd"))
	{
		$webserver = 'lighttpd';
	}
    elseif(substr(strtoupper(@php_sapi_name()), 0, 8) == "NGINX"
	       || stristr($_SERVER['SERVER_SOFTWARE'], "nginx"))
	{
		$webserver = 'nginx';
	}
	else
	{
		// we don't need to bail out, since unknown does not affect any critical installation routines

		$webserver = 'unknown';
	}
}

if(!empty($_POST['httpuser']))
{
	$httpuser = $_POST['httpuser'];
}
else
{
	$httpuser = '';
}

if(!empty($_POST['httpgroup']))
{
	$httpgroup = $_POST['httpgroup'];
}
else
{
	$httpgroup = '';
}

/**
 * END VARIABLES ---------------------------------------------------
 */

/**
 * BEGIN INSTALL ---------------------------------------------------
 */

if(isset($_POST['installstep'])
   && $_POST['installstep'] == '1'
   && $admin_pass1 == $admin_pass2
   && $admin_pass1 != ''
   && $admin_pass2 != ''
   && $mysql_unpriv_pass != ''
   && $mysql_root_pass != ''
   && $servername != ''
   && $serverip != ''
   && $httpuser != ''
   && $httpgroup != ''
   && $mysql_unpriv_user != $mysql_root_user)
{
	page_header();

?>
	<article class="install bradius">
		<header class="dark">
			<img src="../templates/Froxlor/assets/img/logo.png" alt="Froxlor Server Management Panel" />
		</header>

		<section class="installsec">
			<h2>Installation</h2>
			<table class="noborder">
<?php

	//first test if we can access the database server with the given root user and password

	status_message('begin', $lng['install']['testing_mysql']);
	$db_root = new db($mysql_host, $mysql_root_user, $mysql_root_pass, '');

	//ok, if we are here, the database class is build up (otherwise it would have already die'd this script)

	status_message('green', 'OK');

	//first we make a backup of the old DB if it exists

	status_message('begin', $lng['install']['backup_old_db']);
	$tables_exist = false;

	$sql = "SHOW TABLES FROM $mysql_database";
	$result = mysql_query($sql);

	// check the first row
	if($result !== false)
	{
		$row = mysql_num_rows($result);
	
		if($row > 0)
		{
			$tables_exist = true;
		}
	}

	if($tables_exist)
	{
		$filename = "/tmp/froxlor_backup_" . date('YmdHi') . ".sql";

		if(is_file("/usr/bin/mysqldump"))
		{
			$do_backup = true;
			$mysql_dump = '/usr/bin/mysqldump';
		}
		elseif(is_file("/usr/local/bin/mysqldump"))
		{
			$do_backup = true;
			$mysql_dump = '/usr/local/bin/mysqldump';
		}
		else
		{
			$do_backup = false;
			status_message('red', $lng['install']['backing_up_binary_missing']);
		}
		
		if($do_backup) {
			
			$command = $mysql_dump . " " . $mysql_database . " -u " . $mysql_root_user . " --password='" . $mysql_root_pass . "' --result-file=" . $filename;
			$output = exec($command);

			if(stristr($output, "error"))
			{
				status_message('red', $lng['install']['backing_up_failed']);
			}
			else
			{
				status_message('green', 'OK');
			}

		}
	}

	//so first we have to delete the database and the user given for the unpriv-user if they exit

	status_message('begin', $lng['install']['erasing_old_db']);
	$db_root->query("DELETE FROM `mysql`.`user` WHERE `User` = '" . $db_root->escape($mysql_unpriv_user) . "' AND `Host` = '" . $db_root->escape($mysql_access_host) . "'");
	$db_root->query("DELETE FROM `mysql`.`db` WHERE `User` = '" . $db_root->escape($mysql_unpriv_user) . "' AND `Host` = '" . $db_root->escape($mysql_access_host) . "'");
	$db_root->query("DELETE FROM `mysql`.`tables_priv` WHERE `User` = '" . $db_root->escape($mysql_unpriv_user) . "' AND `Host` = '" . $db_root->escape($mysql_access_host) . "'");
	$db_root->query("DELETE FROM `mysql`.`columns_priv` WHERE `User` = '" . $db_root->escape($mysql_unpriv_user) . "' AND `Host` = '" . $db_root->escape($mysql_access_host) . "'");
	$db_root->query("DROP DATABASE IF EXISTS `" . $db_root->escape(str_replace('`', '', $mysql_database)) . "` ;");
	$db_root->query("FLUSH PRIVILEGES;");
	status_message('green', 'OK');

	//then we have to create a new user and database for the froxlor unprivileged mysql access

	status_message('begin', $lng['install']['create_mysqluser_and_db']);
	$db_root->query("CREATE DATABASE `" . $db_root->escape(str_replace('`', '', $mysql_database)) . "`");
	$mysql_access_host_array = array_map('trim', explode(',', $mysql_access_host));

	if(in_array('127.0.0.1', $mysql_access_host_array)
	   && !in_array('localhost', $mysql_access_host_array))
	{
		$mysql_access_host_array[] = 'localhost';
	}

	if(!in_array('127.0.0.1', $mysql_access_host_array)
	   && in_array('localhost', $mysql_access_host_array))
	{
		$mysql_access_host_array[] = '127.0.0.1';
	}

	$mysql_access_host_array[] = $serverip;
	foreach($mysql_access_host_array as $mysql_access_host)
	{
		$db_root->query("GRANT ALL PRIVILEGES ON `" . $db_root->escape(str_replace('`', '', $mysql_database)) . "`.* TO '" . $db_root->escape($mysql_unpriv_user) . "'@'" . $db_root->escape($mysql_access_host) . "' IDENTIFIED BY 'password'");
		$db_root->query("SET PASSWORD FOR '" . $db_root->escape($mysql_unpriv_user) . "'@'" . $db_root->escape($mysql_access_host) . "' = PASSWORD('" . $db_root->escape($mysql_unpriv_pass) . "')");
	}

	$db_root->query("FLUSH PRIVILEGES;");
	$mysql_access_host = implode(',', $mysql_access_host_array);
	status_message('green', 'OK');

	//now a new database and the new froxlor-unprivileged-mysql-account have been created and we can fill it now with the data.

	status_message('begin', $lng['install']['testing_new_db']);
	$db = new db($mysql_host, $mysql_unpriv_user, $mysql_unpriv_pass, $mysql_database);
	status_message('green', 'OK');
	status_message('begin', $lng['install']['importing_data']);
	$db_schema = './froxlor.sql';
	$sql_query = @file_get_contents($db_schema, 'r');
	$sql_query = remove_remarks($sql_query);
	$sql_query = split_sql_file($sql_query, ';');
	for ($i = 0;$i < sizeof($sql_query);$i++)
	{
		if(trim($sql_query[$i]) != '')
		{
			$result = $db->query($sql_query[$i]);
		}
	}

	status_message('green', 'OK');
	status_message('begin', 'System Servername...');

	if(validate_ip($_SERVER['SERVER_NAME'], true) !== false)
	{
		status_message('red', $lng['install']['servername_should_be_fqdn']);
	}
	else
	{
		status_message('green', 'OK');
	}

	//now let's change the settings in our settings-table

	status_message('begin', $lng['install']['changing_data']);
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = 'admin@" . $db->escape($servername) . "' WHERE `settinggroup` = 'panel' AND `varname` = 'adminmail'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . $db->escape($serverip) . "' WHERE `settinggroup` = 'system' AND `varname` = 'ipaddress'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . $db->escape($servername) . "' WHERE `settinggroup` = 'system' AND `varname` = 'hostname'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . $db->escape($version) . "' WHERE `settinggroup` = 'panel' AND `varname` = 'version'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . $db->escape($languages[$language]) . "' WHERE `settinggroup` = 'panel' AND `varname` = 'standardlanguage'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . $db->escape($mysql_access_host) . "' WHERE `settinggroup` = 'system' AND `varname` = 'mysql_access_host'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . $db->escape($webserver) . "' WHERE `settinggroup` = 'system' AND `varname` = 'webserver'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . $db->escape($httpuser) . "' WHERE `settinggroup` = 'system' AND `varname` = 'httpuser'");
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . $db->escape($httpgroup) . "' WHERE `settinggroup` = 'system' AND `varname` = 'httpgroup'");

	if($webserver == "apache2")
	{
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/apache2/sites-enabled/' WHERE `settinggroup` = 'system' AND `varname` = 'apacheconf_vhost'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/apache2/sites-enabled/' WHERE `settinggroup` = 'system' AND `varname` = 'apacheconf_diroptions'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/apache2/froxlor-htpasswd/' WHERE `settinggroup` = 'system' AND `varname` = 'apacheconf_htpasswddir'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/init.d/apache2 reload' WHERE `settinggroup` = 'system' AND `varname` = 'apachereload_command'");
	}
	elseif($webserver == "lighttpd")
	{
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/lighttpd/conf-enabled/' WHERE `settinggroup` = 'system' AND `varname` = 'apacheconf_vhost'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/lighttpd/froxlor-diroptions/' WHERE `settinggroup` = 'system' AND `varname` = 'apacheconf_diroptions'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/lighttpd/froxlor-htpasswd/' WHERE `settinggroup` = 'system' AND `varname` = 'apacheconf_htpasswddir'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/init.d/lighttpd reload' WHERE `settinggroup` = 'system' AND `varname` = 'apachereload_command'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/lighttpd/lighttpd.pem' WHERE `settinggroup` = 'system' AND `varname` = 'ssl_cert_file'");
	}
	elseif($webserver == "nginx")
	{
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/nginx/sites-enabled/' WHERE `settinggroup` = 'system' AND `varname` = 'apacheconf_vhost'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/nginx/sites-enabled/' WHERE `settinggroup` = 'system' AND `varname` = 'apacheconf_diroptions'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/nginx/froxlor-htpasswd/' WHERE `settinggroup` = 'system' AND `varname` = 'apacheconf_htpasswddir'");
		$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '/etc/init.d/nginx reload' WHERE `settinggroup` = 'system' AND `varname` = 'apachereload_command'");
	}

	// insert the lastcronrun to be the installation date
	$query = 'UPDATE `%s` SET `value` = UNIX_TIMESTAMP() WHERE `settinggroup` = \'system\'  AND `varname` = \'lastcronrun\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);

	// set specific times for some crons (traffic only at night, etc.)
	$ts = mktime(0, 0, 0, date('m', time()), date('d', time()), date('Y', time()));
	$db->query("UPDATE `".TABLE_PANEL_CRONRUNS."` SET `lastrun` = '".$ts."' WHERE `cronfile` ='cron_traffic.php';");
	$ts = mktime(1, 0, 0, date('m', time()), date('d', time()), date('Y', time()));
	$db->query("UPDATE `".TABLE_PANEL_CRONRUNS."` SET `lastrun` = '".$ts."' WHERE `cronfile` ='cron_used_tickets_reset.php';");
	$db->query("UPDATE `".TABLE_PANEL_CRONRUNS."` SET `lastrun` = '".$ts."' WHERE `cronfile` ='cron_ticketarchive.php';");

	// and lets insert the default ip and port
	$query = "INSERT INTO `".TABLE_PANEL_IPSANDPORTS."` 
			 SET `ip`= '".$db->escape($serverip)."', 
			 `port` = '80',
			 `namevirtualhost_statement` = '1',
			 `vhostcontainer` = '1', 
			 `vhostcontainer_servername_statement` = '1'";
	$db->query($query);
	$defaultip = $db->insert_id();

	// insert the defaultip
	$query = 'UPDATE `%s` SET `value` = \'%s\' WHERE `settinggroup` = \'system\'  AND `varname` = \'defaultip\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS, $db->escape($defaultip));
	$db->query($query);
	status_message('green', 'OK');

	//last but not least create the main admin
	status_message('begin', $lng['install']['adding_admin_user']);
	$db->query("INSERT INTO `" . TABLE_PANEL_ADMINS . "` SET
		`loginname` = '" . $db->escape($admin_user) . "',
		`password` = '" . md5($admin_pass1) . "',
		`name` = 'Siteadmin',
		`email` = 'admin@" . $db->escape($servername) . "',
		`def_language` = '". $db->escape($languages[$language]) . "',
		`customers` = -1,
		`customers_used` = 0,
		`customers_see_all` = 1,
		`caneditphpsettings` = 1,
		`domains` = -1,
		`domains_used` = 0,
		`domains_see_all` = 1,
		`change_serversettings` = 1,
		`diskspace` = -1024,
		`diskspace_used` = 0,
		`mysqls` = -1,
		`mysqls_used` = 0,
		`emails` = -1,
		`emails_used` = 0,
		`email_accounts` = -1,
		`email_accounts_used` = 0,
		`email_forwarders` = -1,
		`email_forwarders_used` = 0,
		`email_quota` = -1,
		`email_quota_used` = 0,
		`ftps` = -1,
		`ftps_used` = 0,
		`tickets` = -1,
		`tickets_used` = 0,
		`tickets_see_all` = 1,
		`subdomains` = -1,
		`subdomains_used` = 0,
		`traffic` = -1048576,
		`traffic_used` = 0,
		`deactivated` = 0,
		`aps_packages` = -1,
		`aps_packages_used` = 0,
		`email_autoresponder` = -1,
		`email_autoresponder_used` = 0");
	status_message('green', 'OK');

	//now we create the userdata.inc.php with the mysql-accounts
	status_message('begin', $lng['install']['creating_configfile']);
	$userdata = "<?php\n";
	$userdata.= "//automatically generated userdata.inc.php for Froxlor\n";
	$userdata.= "\$sql['host']='" . addcslashes($mysql_host, "'\\") . "';\n";
	$userdata.= "\$sql['user']='" . addcslashes($mysql_unpriv_user, "'\\") . "';\n";
	$userdata.= "\$sql['password']='" . addcslashes($mysql_unpriv_pass, "'\\") . "';\n";
	$userdata.= "\$sql['db']='" . addcslashes($mysql_database, "'\\") . "';\n";
	$userdata.= "\$sql_root[0]['caption']='Default';\n";
	$userdata.= "\$sql_root[0]['host']='" . addcslashes($mysql_host, "'\\") . "';\n";
	$userdata.= "\$sql_root[0]['user']='" . addcslashes($mysql_root_user, "'\\") . "';\n";
	$userdata.= "\$sql_root[0]['password']='" . addcslashes($mysql_root_pass, "'\\") . "';\n";
	$userdata.= "?>";

	//we test now if we can store the userdata.inc.php in ../lib
	if($fp = @fopen('../lib/userdata.inc.php', 'w'))
	{
		$result = @fputs($fp, $userdata, strlen($userdata));
		@fclose($fp);
		status_message('green', $lng['install']['creating_configfile_succ']);
		chmod('../lib/userdata.inc.php', 0440);
	}
	elseif($fp = @fopen('/tmp/userdata.inc.php', 'w'))
	{
		$result = @fputs($fp, $userdata, strlen($userdata));
		@fclose($fp);
		status_message('orange', $lng['install']['creating_configfile_temp']);
		chmod('/tmp/userdata.inc.php', 0440);
	}
	else
	{
		status_message('red', $lng['install']['creating_configfile_failed']);
		echo "\t\t<tr>\n\t\t\t<td class=\"main_field_name\"><p>" . nl2br(htmlspecialchars($userdata)) . "</p></td>\n\t\t</tr>\n";
	}

?>
		</table>
		<p style="padding-left: 15px;">
			<strong><?php echo $lng['install']['froxlor_succ_installed']; ?></strong>
		</p>
		<p class="submit">
			<a href="../index.php"><?php echo $lng['install']['click_here_to_login']; ?></a>
		</p>
	</section>
</article>
<?php
	page_footer();
}
else
{
	
	if((isset($_GET['check'])
		&& $_GET['check'] == '1')
		|| (isset($_POST['installstep']) 
		&& $_POST['installstep'] == '1')
	) {
	page_header();

?>
	<article class="install bradius">
		<header class="dark">
			<img src="../templates/Froxlor/assets/img/logo.png" alt="Froxlor Server Management Panel" />
		</header>
		<section class="installsec">
			<h2><?php echo $lng['install']['language']; ?></h2>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
				<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;Install</legend>
				<p>
					<label for="language"><?php echo $lng['install']['language']; ?>:</label>&nbsp;
					<select name="language" id="language">
					<?php
						$language_options = '';
						while(list($language_file, $language_name) = each($languages)) {
							$language_options.= makeoption($language_name, $language_file, $language, true, true);
						}
						echo $language_options;
					?>
					</select>
				</p>
				<p class="submit">
					<input type="hidden" name="check" value="1" />
					<input type="submit" name="chooselang" value="Go" />
				</p>
				</fieldset>
			</form>
			<aside>&nbsp;</aside>
		</section>
		<section class="installsec">
			<h2><?php echo $lng['install']['installdata']; ?></h2>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
				<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;Install</legend>
				<p>
					<strong><?php echo $lng['install']['database']; ?></strong>
				</p>
				<p>
					<label for="mysql_host"><?php echo $lng['install']['mysql_hostname']; ?>:</label>&nbsp;
					<input type="text" name="mysql_host" id="mysql_host" value="<?php echo htmlspecialchars($mysql_host); ?>" required/>
				</p>
				<p>
					<label for="mysql_database"><?php echo $lng['install']['mysql_database']; ?>:</label>&nbsp;
					<input type="text" name="mysql_database" id="mysql_database" value="<?php echo htmlspecialchars($mysql_database); ?>" required/>
				</p>
				<p>
					<label for="mysql_unpriv_user"<?php echo (($mysql_unpriv_user == $mysql_root_user) ? ' style="color:blue;"' : ''); ?>><?php echo $lng['install']['mysql_unpriv_user']; ?>:</label>&nbsp;
					<input type="text" name="mysql_unpriv_user" id="mysql_unpriv_user" value="<?php echo htmlspecialchars($mysql_unpriv_user); ?>" required/>
				</p>
				<p>
					<label for="mysql_unpriv_pass"<?php echo ((!empty($_POST['installstep']) && $mysql_unpriv_pass == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['mysql_unpriv_pass']; ?>:</label>&nbsp;
					<input type="password" name="mysql_unpriv_pass" id="mysql_unpriv_pass" value="<?php echo htmlspecialchars($mysql_unpriv_pass); ?>" required/>
				</p>
				<p>
					<label for="mysql_root_user"<?php echo (($mysql_unpriv_user == $mysql_root_user) ? ' style="color:blue;"' : ''); ?>><?php echo $lng['install']['mysql_root_user']; ?>:</label>&nbsp;
					<input type="text" name="mysql_root_user" id="mysql_root_user" value="<?php echo htmlspecialchars($mysql_root_user); ?>" required/>
				</p>
				<p>
					<label for="mysql_root_pass"<?php echo ((!empty($_POST['installstep']) && $mysql_root_pass == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['mysql_root_pass']; ?>:</label>&nbsp;
					<input type="password" name="mysql_root_pass" id="mysql_root_pass" value="<?php echo htmlspecialchars($mysql_root_pass); ?>" required/>
				</p>
				<p>
					<strong><?php echo $lng['install']['admin_account']; ?></strong>
				</p>
				<p>
					<label for="admin_user"><?php echo $lng['install']['admin_user']; ?>:</label>&nbsp;
					<input type="text" name="admin_user" id="admin_user" value="<?php echo htmlspecialchars($admin_user); ?>" required/>
				</p>
				<p>
					<label for="admin_pass1"<?php echo ((!empty($_POST['installstep']) && ($admin_pass1 == '' || $admin_pass1 != $admin_pass2)) ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['admin_pass']; ?>:</label>&nbsp;
					<input type="password" name="admin_pass1" id="admin_pass1" value="<?php echo htmlspecialchars($admin_pass1); ?>" required/>
				</p>
				<p>
					<label for="admin_pass2"<?php echo ((!empty($_POST['installstep']) && ($admin_pass2 == '' || $admin_pass1 != $admin_pass2)) ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['admin_pass_confirm']; ?>:</label>&nbsp;
					<input type="password" name="admin_pass2" id="admin_pass2" value="<?php echo htmlspecialchars($admin_pass2); ?>" required/>
				</p>
				<p>
					<strong><?php echo $lng['install']['serversettings']; ?></strong>
				</p>
				<p>
					<label for="servername"<?php echo ((!empty($_POST['installstep']) && $servername == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['servername']; ?>:</label>&nbsp;
					<input type="text" name="servername" id="servername" value="<?php echo htmlspecialchars($servername); ?>" required/>
				</p>
				<p>
					<label for="serverip"<?php echo ((!empty($_POST['installstep']) && $serverip == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['serverip']; ?>:</label>&nbsp;
					<input type="text" name="serverip" id="serverip" value="<?php echo htmlspecialchars($serverip); ?>" required/>
				</p>
				<p>
					<label for="apache"<?php echo ((!empty($_POST['installstep']) && $webserver == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['webserver']; ?> Apache:</label>&nbsp;
					<input type="radio" name="webserver" id="apache" value="apache2" <?php echo $webserver == "apache2" ? 'checked="checked"' : "" ?>/>Apache2
				</p>
				<p>
					<label for="lighty"<?php echo ((!empty($_POST['installstep']) && $webserver == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['webserver']; ?> LigHTTPd:</label>&nbsp;
					<input type="radio" name="webserver" id="lighty" value="lighttpd" <?php echo $webserver == "lighttpd" ? 'checked="checked"' : "" ?>/>LigHTTPd
				</p>
				<p>
					<label for="nginx"<?php echo ((!empty($_POST['installstep']) && $webserver == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['webserver']; ?> Nginx:</label>&nbsp;
					<input type="radio" name="webserver" id="nginx" value="nginx" <?php echo $webserver == "nginx" ? 'checked="checked"' : "" ?>/>Nginx
				</p>
				<p>
					<label for="httpuser"<?php echo ((!empty($_POST['installstep']) && $httpuser == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['httpuser']; ?>:</label>&nbsp;
					<input type="text" name="httpuser" id="httpuser" value="<?php $posixusername = posix_getpwuid(posix_getuid()); echo $posixusername['name']; ?>" required/>
				</p>
				<p>
					<label for="httpgroup"<?php echo ((!empty($_POST['installstep']) && $httpgroup == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['httpgroup']; ?>:</label>&nbsp;
					<input type="text" name="httpgroup" id="httpgroup" value="<?php $posixgroup = posix_getgrgid(posix_getgid()); echo $posixgroup['name']; ?>" required/>
				</p>
				<p class="submit">
					<input type="hidden" name="check" value="1" />
					<input type="hidden" name="language" value="<?php echo htmlspecialchars($language); ?>"/>
					<input type="hidden" name="installstep" value="1"/>
					<input class="bottom" type="submit" name="submitbutton" value="<?php echo $lng['install']['next']; ?>"/>
				</p>
			</fieldset>
		</form>
		<aside>&nbsp;</aside>
	</section>
</article>
<?php
	page_footer();
	}
	else
	{
		requirement_checks();
	}		
}

/**
 * END INSTALL ---------------------------------------------------
 */
