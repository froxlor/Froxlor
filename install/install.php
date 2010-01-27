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
 * @version    $Id$
 */

/**
 * Most elements are taken from the phpBB (www.phpbb.com)
 * installer, (c) 1999 - 2004 phpBB Group.
 */

if(file_exists('../lib/userdata.inc.php'))
{
	/**
	 * Includes the Usersettings eg. MySQL-Username/Passwort etc. to test if Froxlor is already installed
	 */

	require ('../lib/userdata.inc.php');

	if(isset($sql)
	   && is_array($sql))
	{
		die('Sorry, Froxlor is already configured...');
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

function page_header()
{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" />
	<link rel="stylesheet" href="../templates/main.css" type="text/css" />
	<title>Froxlor</title>
</head>
	<body style="margin: 0; padding: 0;" onload="document.loginform.loginname.focus()">
		<!--
			We request you retain the full copyright notice below including the link to www.froxlor.org.
			This not only gives respect to the large amount of time given freely by the developers
			but also helps build interest, traffic and use of Froxlor. If you refuse
			to include even this then support on our forums may be affected.
			The Froxlor Team : 2009-2010
		// -->
		<!--
			Templates based on work by Luca Piona (info@havanastudio.ch) and Luca Longinotti (chtekk@gentoo.org)
		// -->
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td width="800"><img src="../images/header.gif" width="800" height="90" alt="" /></td>
				<td class="header">&nbsp;</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td valign="top" bgcolor="#FFFFFF">
				<br />
				<br />
<?php
}

function page_footer()
{

?>
				</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td width="100%" class="footer">
					<br />Froxlor &copy; 2009-2010 by <a href="http://www.froxlor.org/" target="_blank">the Froxlor Team</a>
					<br /><br/>
				</td>
			</tr>
		</table>
	</body>
</html>
<?php
}

function status_message($case, $text)
{
	if($case == 'begin')
	{
		echo "\t\t<tr>\n\t\t\t<td class=\"main_field_name\">$text";
	}
	else
	{
		echo " <span style=\"color:$case;\">$text</span></td>\n\t\t</tr>\n";
	}
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
		if(validate_ip($_SERVER['SERVER_NAME'], true) == false)
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
	   || stristr($_SERVER[SERVER_SOFTWARE], "apache/2"))
	{
		$webserver = 'apache2';
	}
	elseif(substr(strtoupper(@php_sapi_name()), 0, 8) == "LIGHTTPD"
	       || stristr($_SERVER[SERVER_SOFTWARE], "lighttpd"))
	{
		$webserver = 'lighttpd';
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
	<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable">
		<tr>
			<td class="maintitle"><b><img src="../images/title.gif" alt="" />&nbsp;Froxlor Installation</b></td>
		</tr>
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


	status_message('begin', $lng['install']['phpmysql']);

	if(!extension_loaded('mysql'))
	{
		status_message('red', $lng['install']['notinstalled']);
		$_die = true;
	}
	else
	{
		status_message('green', 'OK');
	}

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
	
	status_message('begin', $lng['install']['phpbcmath']);

	if(!extension_loaded('bcmath'))
	{
		status_message('orange', $lng['install']['notinstalled'] . '<br />' . $lng['install']['bcmathdescription']);
		$_die = false;
	}
	else
	{
		status_message('green', 'OK');
	}

	status_message('begin', $lng['install']['openbasedir']);
	$php_ob = @ini_get("open_basedir");

	if(!empty($php_ob)
	   && $php_ob != '')
	{
		status_message('orange', $lng['install']['openbasedirenabled']);
		$_die = false;
	}
	else
	{
		status_message('green', 'OK');
	}

	if($_die)
	{
		status_message('begin', $lng['install']['diedbecauseofrequirements']);
		die();
	}

	//first test if we can access the database server with the given root user and password

	status_message('begin', $lng['install']['testing_mysql']);
	$db_root = new db($mysql_host, $mysql_root_user, $mysql_root_pass, '');

	//ok, if we are here, the database class is build up (otherwise it would have already die'd this script)

	status_message('green', 'OK');

	//first we make a backup of the old DB if it exists

	status_message('begin', $lng['install']['backup_old_db']);
	$result = mysql_list_tables($mysql_database);

	if($result)
	{
		$filename = "/tmp/froxlor_backup_" . date(YmdHi) . ".sql";

		if(is_file("/usr/bin/mysqldump"))
		{
			$command = "/usr/bin/mysqldump " . $mysql_database . " -u " . $mysql_root_user . " --password='" . $mysql_root_pass . "' --result-file=" . $filename;
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
		else
		{
			status_message('red', $lng['install']['backing_up_binary_missing']);
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
	$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` SET `value` = '" . $db->escape($webserver) . "' WHERE `settinggroup` = 'system' AND `varname` = 'webserver'");

	//FIXME

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

	// insert the lastcronrun to be the installation date

	$query = 'UPDATE `%s` SET `value` = UNIX_TIMESTAMP() WHERE `settinggroup` = \'system\'  AND `varname` = \'lastcronrun\'';
	$query = sprintf($query, TABLE_PANEL_SETTINGS);
	$db->query($query);

	// and lets insert the default ip and port

	$query = 'INSERT INTO `%s`  SET `ip`   = \'%s\',  `port` = \'80\' ';
	$query = sprintf($query, TABLE_PANEL_IPSANDPORTS, $db->escape($serverip));
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
		`subdomains` = -1,
		`subdomains_used` = 0,
		`traffic` = -1048576,
		`traffic_used` = 0,
		`deactivated` = 0,
		`aps_packages` = -1");
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
		<tr>
			<td class="main_field_display" align="center">
				<?php echo $lng['install']['froxlor_succ_installed']; ?><br />
				<a href="../index.php"><?php echo $lng['install']['click_here_to_login']; ?></a>
			</td>
		</tr>
	</table>
	<br />
	<br />
<?php
	page_footer();
}
else
{
	page_header();

?>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_40">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="../images/title.gif" alt="" />&nbsp;<?php echo $lng['install']['welcome']; ?></b></td>
			</tr>
			<tr>
				<td class="main_field_name" colspan="2"><?php echo $lng['install']['welcometext']; ?></td>
			</tr>
			<tr>
				<td class="main_field_name"><?php echo $lng['install']['language']; ?>: </td>
				<td class="main_field_display" nowrap="nowrap">
					<select name="language" class="dropdown_noborder"><?php
	$language_options = '';

	while(list($language_file, $language_name) = each($languages))
	{
		$language_options.= "\n\t\t\t\t\t\t" . makeoption($language_name, $language_file, $language, true, true);
	}

	echo $language_options;

?>

					</select>
				</td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2">
					<input class="bottom" type="submit" name="chooselang" value="Go" />
				</td>
			</tr>
		</table>
	</form>
	<br />
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_40">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="../images/title.gif" alt="" />&nbsp;<?php echo $lng['install']['database']; ?></b></td>
			</tr>
			<tr>
				<td class="main_field_name"><?php echo $lng['install']['mysql_hostname']; ?>:</td>
				<td class="main_field_display"><input type="text" name="mysql_host" value="<?php echo htmlspecialchars($mysql_host); ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"><?php echo $lng['install']['mysql_database']; ?>:</td>
				<td class="main_field_display"><input type="text" name="mysql_database" value="<?php echo htmlspecialchars($mysql_database); ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo (($mysql_unpriv_user == $mysql_root_user) ? ' style="color:blue;"' : ''); ?>><?php echo $lng['install']['mysql_unpriv_user']; ?>:</td>
				<td class="main_field_display"><input type="text" name="mysql_unpriv_user" value="<?php echo htmlspecialchars($mysql_unpriv_user); ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo ((!empty($_POST['installstep']) && $mysql_unpriv_pass == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['mysql_unpriv_pass']; ?>:</td>
				<td class="main_field_display"><input type="password" name="mysql_unpriv_pass" value="<?php echo htmlspecialchars($mysql_unpriv_pass); ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo (($mysql_unpriv_user == $mysql_root_user) ? ' style="color:blue;"' : ''); ?>><?php echo $lng['install']['mysql_root_user']; ?>:</td>
				<td class="main_field_display"><input type="text" name="mysql_root_user" value="<?php echo htmlspecialchars($mysql_root_user); ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo ((!empty($_POST['installstep']) && $mysql_root_pass == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['mysql_root_pass']; ?>:</td>
				<td class="main_field_display"><input type="password" name="mysql_root_pass" value="<?php echo htmlspecialchars($mysql_root_pass); ?>"/></td>
			</tr>
			<tr>
				<td class="maintitle" colspan="2"><b><img src="../images/title.gif" alt="" />&nbsp;<?php echo $lng['install']['admin_account']; ?></b></td>
			</tr>
			<tr>
				<td class="main_field_name"><?php echo $lng['install']['admin_user']; ?>:</td>
				<td class="main_field_display"><input type="text" name="admin_user" value="<?php echo htmlspecialchars($admin_user); ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo ((!empty($_POST['installstep']) && ($admin_pass1 == '' || $admin_pass1 != $admin_pass2)) ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['admin_pass']; ?>:</td>
				<td class="main_field_display"><input type="password" name="admin_pass1" value="<?php echo htmlspecialchars($admin_pass1); ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo ((!empty($_POST['installstep']) && ($admin_pass2 == '' || $admin_pass1 != $admin_pass2)) ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['admin_pass_confirm']; ?>:</td>
				<td class="main_field_display"><input type="password" name="admin_pass2" value="<?php echo htmlspecialchars($admin_pass2); ?>"/></td>
			</tr>
			<tr>
				<td class="maintitle" colspan="2"><b><img src="../images/title.gif" alt="" />&nbsp;<?php echo $lng['install']['serversettings']; ?></b></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo ((!empty($_POST['installstep']) && $servername == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['servername']; ?>:</td>
				<td class="main_field_display"><input type="text" name="servername" value="<?php echo htmlspecialchars($servername); ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo ((!empty($_POST['installstep']) && $serverip == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['serverip']; ?>:</td>
				<td class="main_field_display"><input type="text" name="serverip" value="<?php echo htmlspecialchars($serverip); ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo ((!empty($_POST['installstep']) && $webserver == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['webserver']; ?>:</td>
				<td class="main_field_display"><input type="radio" name="webserver" value="apache2" <?php echo $webserver == "apache2" ? 'checked="checked"' : "" ?>/>Apache2&nbsp;<br /><input type="radio" name="webserver" value="lighttpd" <?php echo $webserver == "lighttpd" ? 'checked="checked"' : "" ?>/>Lighttpd</td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo ((!empty($_POST['installstep']) && $serverip == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['httpuser']; ?>:</td>
				<td class="main_field_display"><input type="text" name="httpuser" value="<?php $posixusername = posix_getpwuid(posix_getuid()); echo $posixusername['name']; ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_name"<?php echo ((!empty($_POST['installstep']) && $serverip == '') ? ' style="color:red;"' : ''); ?>><?php echo $lng['install']['httpgroup']; ?>:</td>
				<td class="main_field_display"><input type="text" name="httpgroup" value="<?php $posixgroup = posix_getgrgid(posix_getgid()); echo $posixgroup['name']; ?>"/></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input type="hidden" name="language" value="<?php echo htmlspecialchars($language); ?>"/><input type="hidden" name="installstep" value="1"/><input class="bottom" type="submit" name="submitbutton" value="<?php echo $lng['install']['next']; ?>"/></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
<?php
	page_footer();
}

/**
 * END INSTALL ---------------------------------------------------
 */

?>
