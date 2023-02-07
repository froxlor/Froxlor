<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Database\Manager;

use Froxlor\Database\Database;
use Froxlor\FroxlorLogger;
use PDO;

/**
 * Class DbManagerMySQL
 *
 * Explicit class for database-management like creating
 * and removing databases, users and permissions for MySQL
 */
class DbManagerMySQL
{

	/**
	 * FroxlorLogger object
	 *
	 * @var object
	 */
	private $log = null;

	/**
	 * main constructor
	 *
	 * @param FroxlorLogger|null $log
	 */
	public function __construct(&$log = null)
	{
		$this->log = $log;
	}

	/**
	 * creates a database
	 *
	 * @param string|null $dbname
	 */
	public function createDatabase(string $dbname = null)
	{
		Database::query("CREATE DATABASE `" . $dbname . "`");
	}

	/**
	 * grants access privileges on a database with the same
	 * username and sets the password for that user the given access_host
	 *
	 * @param string $username
	 * @param string|array $password
	 * @param ?string $access_host
	 * @param bool $p_encrypted
	 *            optional, whether the password is encrypted or not, default false
	 * @param bool $update
	 *            optional, whether to update the password only (not create user)
	 * @throws \Exception
	 */
	public function grantPrivilegesTo(string $username, $password, string $access_host = null, bool $p_encrypted = false, bool $update = false)
	{
		$pwd_plugin = 'mysql_native_password';
		if (is_array($password) && count($password) == 2) {
			$pwd_plugin = $password['plugin'];
			$password = $password['password'];
		}

		if (!$update) {
			// create user
			if ($p_encrypted) {
				if (version_compare(Database::getAttribute(\PDO::ATTR_SERVER_VERSION), '5.7.0', '<') || version_compare(Database::getAttribute(\PDO::ATTR_SERVER_VERSION), '10.0.0', '>=')) {
					$stmt = Database::prepare("
						CREATE USER '" . $username . "'@'" . $access_host . "' IDENTIFIED BY PASSWORD :password
					");
				} else {
					$stmt = Database::prepare("
						CREATE USER '" . $username . "'@'" . $access_host . "' IDENTIFIED WITH " . $pwd_plugin . " AS :password
					");
				}
			} else {
				$stmt = Database::prepare("
					CREATE USER '" . $username . "'@'" . $access_host . "' IDENTIFIED BY :password
				");
			}
			Database::pexecute($stmt, [
				"password" => $password
			]);
			// grant privileges
			$stmt = Database::prepare("
				GRANT ALL ON `" . $username . "`.* TO :username@:host
			");
			Database::pexecute($stmt, [
				"username" => $username,
				"host" => $access_host
			]);
		} else {
			// set password
			if (version_compare(Database::getAttribute(\PDO::ATTR_SERVER_VERSION), '5.7.6', '<') || version_compare(Database::getAttribute(\PDO::ATTR_SERVER_VERSION), '10.0.0', '>=')) {
				if ($p_encrypted) {
					$stmt = Database::prepare("SET PASSWORD FOR :username@:host = :password");
				} else {
					$stmt = Database::prepare("SET PASSWORD FOR :username@:host = PASSWORD(:password)");
				}
			} else {
				if ($p_encrypted) {
					$stmt = Database::prepare("ALTER USER :username@:host IDENTIFIED WITH " . $pwd_plugin . " AS :password");
				} else {
					$stmt = Database::prepare("ALTER USER :username@:host IDENTIFIED BY :password");
				}
			}
			Database::pexecute($stmt, [
				"username" => $username,
				"host" => $access_host,
				"password" => $password
			]);
		}
	}

	/**
	 * removes the given database from the dbms and also
	 * takes away any privileges from a user to that db
	 *
	 * @param string $dbname
	 * @throws \Exception
	 */
	public function deleteDatabase(string $dbname)
	{
		if (version_compare(Database::getAttribute(PDO::ATTR_SERVER_VERSION), '5.0.2', '<')) {
			// failsafe if user has been deleted manually (requires MySQL 4.1.2+)
			$stmt = Database::prepare("REVOKE ALL PRIVILEGES, GRANT OPTION FROM `" . $dbname . "`");
			Database::pexecute($stmt, [], false);
		}

		$host_res_stmt = Database::prepare("
			SELECT `Host` FROM `mysql`.`user` WHERE `User` = :dbname");
		Database::pexecute($host_res_stmt, [
			'dbname' => $dbname
		]);

		// as of MySQL 5.0.2 this also revokes privileges. (requires MySQL 4.1.2+)
		if (version_compare(Database::getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.0', '<')) {
			$drop_stmt = Database::prepare("DROP USER :dbname@:host");
		} else {
			$drop_stmt = Database::prepare("DROP USER IF EXISTS :dbname@:host");
		}
		while ($host = $host_res_stmt->fetch(PDO::FETCH_ASSOC)) {
			Database::pexecute($drop_stmt, [
				'dbname' => $dbname,
				'host' => $host['Host']
			], false);
		}

		$drop_stmt = Database::prepare("DROP DATABASE IF EXISTS `" . $dbname . "`");
		Database::pexecute($drop_stmt);
	}

	/**
	 * removes a user from the dbms and revokes all privileges
	 *
	 * @param string $username
	 * @param string $host
	 * @throws \Exception
	 */
	public function deleteUser(string $username, string $host)
	{
		if (Database::getAttribute(PDO::ATTR_SERVER_VERSION) < '5.0.2') {
			// Revoke privileges (only required for MySQL 4.1.2 - 5.0.1)
			$stmt = Database::prepare("REVOKE ALL PRIVILEGES ON * . * FROM `" . $username . "`@`" . $host . "`");
			Database::pexecute($stmt);
		}
		// as of MySQL 5.0.2 this also revokes privileges. (requires MySQL 4.1.2+)
		if (version_compare(Database::getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.0', '<')) {
			$stmt = Database::prepare("DROP USER :username@:host");
		} else {
			$stmt = Database::prepare("DROP USER IF EXISTS :username@:host");
		}
		Database::pexecute($stmt, [
			"username" => $username,
			"host" => $host
		]);
	}

	/**
	 * removes permissions from a user
	 *
	 * @param string $username
	 * @param string $host
	 * @throws \Exception
	 */
	public function disableUser(string $username, string $host)
	{
		$stmt = Database::prepare('REVOKE ALL PRIVILEGES, GRANT OPTION FROM `' . $username . '`@`' . $host . '`');
		Database::pexecute($stmt, [], false);
	}

	/**
	 * re-grant permissions to a user
	 *
	 * @param string $username
	 * @param string $host
	 * @throws \Exception
	 */
	public function enableUser(string $username, string $host)
	{
		// check whether user exists to avoid errors
		$exist_check_stmt = Database::prepare("SELECT EXISTS(SELECT 1 FROM mysql.user WHERE user = '" . $username . "' AND host = '" . $host . "')");
		$exist_check = Database::pexecute_first($exist_check_stmt);
		if ($exist_check && array_pop($exist_check) == '1') {
			Database::query('GRANT ALL PRIVILEGES ON `' . $username . '`.* TO `' . $username . '`@`' . $host . '`');
			Database::query('GRANT ALL PRIVILEGES ON `' . str_replace('_', '\_', $username) . '` . * TO `' . $username . '`@`' . $host . '`');
		}
	}

	/**
	 * flushes the privileges...pretty obvious eh?
	 */
	public function flushPrivileges()
	{
		Database::query("FLUSH PRIVILEGES");
	}

	/**
	 * return an array of all usernames used in that DBMS
	 *
	 * @param bool $user_only if false, will be selected from mysql.user and slightly different array will be generated
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getAllSqlUsers(bool $user_only = true): array
	{
		if (!$user_only) {
			$result_stmt = Database::prepare('SELECT * FROM mysql.user');
		} else {
			$result_stmt = Database::prepare('SELECT `User` FROM mysql.user');
		}
		Database::pexecute($result_stmt);
		$allsqlusers = [];
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($user_only == false) {
				if (!isset($allsqlusers[$row['User']]) || !is_array($allsqlusers[$row['User']])) {
					$allsqlusers[$row['User']] = [
						'password' => $row['Password'] ?? $row['authentication_string'],
						'plugin' => $row['plugin'] ?? 'mysql_native_password',
						'hosts' => []
					];
				}
				$allsqlusers[$row['User']]['hosts'][] = $row['Host'];
			} else {
				$allsqlusers[] = $row['User'];
			}
		}
		return $allsqlusers;
	}
}
