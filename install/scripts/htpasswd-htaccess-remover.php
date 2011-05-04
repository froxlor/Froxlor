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
 * @author     Michael Duergner <michael@duergner.com>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    System
 *
 */

if(@php_sapi_name() != 'cli'
   && @php_sapi_name() != 'cgi'
   && @php_sapi_name() != 'cgi-fcgi')
{
	die('This script will only work in the shell.');
}

$pathtophpfiles = '/var/www/syscp';
$filename = 'htpasswd-htaccess-remover.php';

/**
 * Includes the Usersettings eg. MySQL-Username/Passwort etc.
 */

require ("$pathtophpfiles/lib/userdata.inc.php");

/**
 * Includes the MySQL-Tabledefinitions etc.
 */

require ("$pathtophpfiles/lib/tables.inc.php");

/**
 * Includes the MySQL-Connection-Class
 */

require ("$pathtophpfiles/lib/class_mysqldb.php");
$debugMsg[] = 'Database Class has been loaded';
$db = new db($sql['host'], $sql['user'], $sql['password'], $sql['db']);
$db_root = new db($sql['host'], $sql['root_user'], $sql['root_password'], '');

if($db->link_id == 0
   || $db_root->link_id == 0)
{
	/**
	 * Do not proceed further if no database connection could be established (either normal or root)
	 */

	die('Cant connect to mysqlserver. Please check userdata.inc.php! Exiting...');
}

unset($sql['password']);
unset($db->password);
$result = $db->query("SELECT `settingid`, `settinggroup`, `varname`, `value` FROM `" . TABLE_PANEL_SETTINGS . "`");

while($row = $db->fetch_array($result))
{
	$settings["$row[settinggroup]"]["$row[varname]"] = $row['value'];
}

unset($row);
unset($result);

if(!isset($settings['panel']['version'])
   || $settings['panel']['version'] != $version)
{
	/**
	 * Do not proceed further if the Database version is not the same as the script version
	 */

	die('Version of File doesnt match Version of Database. Exiting...');
}

/**
 * Includes the Functions
 */

require ("$pathtophpfiles/lib/functions.php");
$result = $db->query('SELECT * FROM `' . TABLE_PANEL_HTACCESS . '` ');

while($row = $db->fetch_array($result))
{
	if(file_exists($row['path'] . '.htaccess'))
	{
		unlink($row['path'] . '.htaccess');
	}
}

$result = $db->query('SELECT * FROM `' . TABLE_PANEL_HTPASSWDS . '` ');

while($row = $db->fetch_array($result))
{
	if(file_exists($row['path'] . '.htpasswd'))
	{
		unlink($row['path'] . '.htpasswd');
	}
}

?>
