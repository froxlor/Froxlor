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

	global $log;

	// get sql-root access data
	Database::needRoot(true);
	Database::needSqlData();
	$sql_root = Database::getSqlData();
	Database::needRoot(false);

	$dbservers_stmt = Database::query("SELECT DISTINCT `dbserver` FROM `".TABLE_PANEL_DATABASES."`");
	$mysql_servers = '';

	while ($dbserver = $dbservers_stmt->fetch(PDO::FETCH_ASSOC)) {

		Database::needRoot(true, $dbserver['dbserver']);
		Database::needSqlData();
		$sql_root = Database::getSqlData();

		$dbm = new DbManager($log);
		$users = $dbm->getManager()->getAllSqlUsers(false);

		$databases = array(
				$sql_root['db']
		);
		$databases_result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
			WHERE `dbserver` = :mysqlserver
		");
		Database::pexecute($databases_result_stmt, array('mysqlserver' => $dbserver['dbserver']));

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
						$dbm->getManager()->grantPrivilegesTo($username, $password, $mysql_access_host, true);
					}
				}

				foreach ($users[$username]['hosts'] as $mysql_access_host) {

					if (!in_array($mysql_access_host, $mysql_access_host_array)) {
						$dbm->getManager()->deleteUser($username, $mysql_access_host);
					}
				}
			}
		}

		$dbm->getManager()->flushPrivileges();
		Database::needRoot(false);
	}
}
