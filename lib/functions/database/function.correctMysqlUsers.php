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
 * @package    Functions
 *
 */

function correctMysqlUsers($mysql_access_host_array)
{
	global $db, $settings, $sql, $sql_root, $theme;
	
	foreach($sql_root as $mysql_server => $mysql_server_details)
	{
		$db_root = new db($mysql_server_details['host'], $mysql_server_details['user'], $mysql_server_details['password'], '');
		unset($mysql_server_details['password']);

		$users = array();
		$users_result = $db_root->query('SELECT * FROM `mysql`.`user`');

		while($users_row = $db_root->fetch_array($users_result))
		{
			if(!isset($users[$users_row['User']])
			   || !is_array($users[$users_row['User']]))
			{
				$users[$users_row['User']] = array(
					'password' => $users_row['Password'],
					'hosts' => array()
				);
			}

			$users[$users_row['User']]['hosts'][] = $users_row['Host'];
		}

		$databases = array(
			$sql['db']
		);
		$databases_result = $db->query('SELECT * FROM `' . TABLE_PANEL_DATABASES . '` WHERE `dbserver` = \'' . $mysql_server . '\'');

		while($databases_row = $db->fetch_array($databases_result))
		{
			$databases[] = $databases_row['databasename'];
		}

		foreach($databases as $username)
		{
			if(isset($users[$username])
			   && is_array($users[$username])
			   && isset($users[$username]['hosts'])
			   && is_array($users[$username]['hosts']))
			{
				$password = $users[$username]['password'];
				foreach($mysql_access_host_array as $mysql_access_host)
				{
					$mysql_access_host = trim($mysql_access_host);

					if(!in_array($mysql_access_host, $users[$username]['hosts']))
					{
						$db_root->query('GRANT ALL PRIVILEGES ON `' . str_replace('_', '\_', $db_root->escape($username)) . '`.* TO `' . $db_root->escape($username) . '`@`' . $db_root->escape($mysql_access_host) . '` IDENTIFIED BY \'password\'');
						$db_root->query('SET PASSWORD FOR `' . $db_root->escape($username) . '`@`' . $db_root->escape($mysql_access_host) . '` = \'' . $db_root->escape($password) . '\'');
					}
				}

				foreach($users[$username]['hosts'] as $mysql_access_host)
				{
					if(!in_array($mysql_access_host, $mysql_access_host_array))
					{
						$db_root->query('REVOKE ALL PRIVILEGES ON * . * FROM `' . $db_root->escape($username) . '`@`' . $db_root->escape($mysql_access_host) . '`');
						$db_root->query('REVOKE ALL PRIVILEGES ON `' . str_replace('_', '\_', $db_root->escape($username)) . '` . * FROM `' . $db_root->escape($username) . '`@`' . $db_root->escape($mysql_access_host) . '`');
						$db_root->query('DELETE FROM `mysql`.`user` WHERE `User` = "' . $db_root->escape($username) . '" AND `Host` = "' . $db_root->escape($mysql_access_host) . '"');
					}
				}
			}
		}

		$db_root->query('FLUSH PRIVILEGES');
		$db_root->close();
		unset($db_root);
	}
}
