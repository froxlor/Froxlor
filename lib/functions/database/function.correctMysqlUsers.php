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

function correctMysqlUsers($mysql_access_host_array) {

	global $settings;

	// get sql-root access data
	Database::needRoot(true);
	Database::needSqlData();
	$sql_root = Database::getSqlData();
	Database::needRoot(false);

	foreach ($sql_root as $mysql_server => $mysql_server_details) {

		Database::needRoot(true);

		$users = array();
		$users_result_stmt = Database::query("SELECT * FROM `mysql`.`user`");

		while ($users_row = $users_result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (!isset($users[$users_row['User']])
					|| !is_array($users[$users_row['User']])
			) {
				$users[$users_row['User']] = array(
						'password' => $users_row['Password'],
						'hosts' => array()
				);
			}
			$users[$users_row['User']]['hosts'][] = $users_row['Host'];
		}

		$databases = array(
				$sql_root['db']
		);
		$databases_result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
			WHERE `dbserver` = :mysqlserver
		");
		Database::pexecute($databases_result_stmt, array('mysqlserver' => $mysql_server));

		while ($databases_row = $databases_result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$databases[] = $databases_row['databasename'];
		}

		foreach ($databases as $username) {

			if (isset($users[$username])
					&& is_array($users[$username])
					&& isset($users[$username]['hosts'])
					&& is_array($users[$username]['hosts'])
			) {

				$password = $users[$username]['password'];

				foreach ($mysql_access_host_array as $mysql_access_host) {

					$mysql_access_host = trim($mysql_access_host);

					if (!in_array($mysql_access_host, $users[$username]['hosts'])) {
						$stmt = Database::prepare("GRANT ALL PRIVILEGES ON `" . $username . "`.*
							TO :username@:host
							IDENTIFIED BY 'password'"
						);
						Database::pexecute($stmt, array("username" => $username, "host" => $mysql_access_host));
						$stmt = Database::prepare("SET PASSWORD FOR :username@:host = :password");
						Database::pexecute($stmt, array("username" => $username, "host" => $mysql_access_host, "password" => $password));
					}
				}

				foreach ($users[$username]['hosts'] as $mysql_access_host) {

					if (!in_array($mysql_access_host, $mysql_access_host_array)) {

						if (Database::getAttribute(PDO::ATTR_SERVER_VERSION) < '5.0.2') {
							// Revoke privileges (only required for MySQL 4.1.2 - 5.0.1)
							$stmt = Database::prepare("REVOKE ALL PRIVILEGES ON * . * FROM `". $username . "`@`".$mysql_access_host."`");
							Database::pexecute($stmt);
						}
						// as of MySQL 5.0.2 this also revokes privileges. (requires MySQL 4.1.2+)
						$stmt = Database::prepare("DROP USER :username@:host");
						Database::pexecute($stmt, array("username" => $username, "host" => $mysql_access_host));
					}
				}
			}
		}

		Database::query('FLUSH PRIVILEGES');
		Database::needRoot(false);
	}
}
