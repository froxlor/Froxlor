<?php
namespace Froxlor\Database;

use Froxlor\Settings;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Classes
 *         
 * @since 0.9.31
 *       
 */

/**
 * Class DbManager
 *
 * Wrapper-class for database-management like creating
 * and removing databases, users and permissions
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Classes
 */
class DbManager
{

	/**
	 * FroxlorLogger object
	 *
	 * @var object
	 */
	private $log = null;

	/**
	 * Manager object
	 *
	 * @var object
	 */
	private $manager = null;

	/**
	 * main constructor
	 *
	 * @param \Froxlor\FroxlorLogger $log
	 */
	public function __construct($log = null)
	{
		$this->log = $log;
		$this->setManager();
	}

	/**
	 * creates a new database and a user with the
	 * same name with all privileges granted on the db.
	 * DB-name and user-name are being generated and
	 * the password for the user will be set
	 *
	 * @param string $loginname
	 * @param string $password
	 * @param int $last_accnumber
	 *
	 * @return string|bool $username if successful or false of username is equal to the password
	 */
	public function createDatabase($loginname = null, $password = null, $last_accnumber = 0)
	{
		Database::needRoot(true);

		// check whether we shall create a random username
		if (strtoupper(Settings::Get('customer.mysqlprefix')) == 'RANDOM') {
			// get all usernames from db-manager
			$allsqlusers = $this->getManager()->getAllSqlUsers();
			// generate random username
			$username = $loginname . '-' . substr(md5(uniqid(microtime(), 1)), 20, 3);
			// check whether it exists on the DBMS
			while (in_array($username, $allsqlusers)) {
				$username = $loginname . '-' . substr(md5(uniqid(microtime(), 1)), 20, 3);
			}
		} else {
			$username = $loginname . Settings::Get('customer.mysqlprefix') . (intval($last_accnumber) + 1);
		}

		// don't use a password that is the same as the username
		if ($username == $password) {
			return false;
		}

		// now create the database itself
		$this->getManager()->createDatabase($username);
		$this->log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_INFO, "created database '" . $username . "'");

		// and give permission to the user on every access-host we have
		foreach (array_map('trim', explode(',', Settings::Get('system.mysql_access_host'))) as $mysql_access_host) {
			$this->getManager()->grantPrivilegesTo($username, $password, $mysql_access_host);
			$this->log->logAction(\Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "grant all privileges for '" . $username . "'@'" . $mysql_access_host . "'");
		}

		$this->getManager()->flushPrivileges();

		Database::needRoot(false);

		return $username;
	}

	/**
	 * returns the manager-object
	 * from where we can control it
	 */
	public function getManager()
	{
		return $this->manager;
	}

	/**
	 * set manager-object by type of
	 * dbms: mysql only for now
	 *
	 * sets private $_manager variable
	 */
	private function setManager()
	{
		// TODO read different dbms from settings later
		$this->manager = new \Froxlor\Database\Manager\DbManagerMySQL($this->log);
	}

	public static function correctMysqlUsers($mysql_access_host_array)
	{
		// get sql-root access data
		Database::needRoot(true);
		Database::needSqlData();
		$sql_root = Database::getSqlData();
		Database::needRoot(false);

		$dbservers_stmt = Database::query("SELECT DISTINCT `dbserver` FROM `" . TABLE_PANEL_DATABASES . "`");
		while ($dbserver = $dbservers_stmt->fetch(\PDO::FETCH_ASSOC)) {

			Database::needRoot(true, $dbserver['dbserver']);
			Database::needSqlData();
			$sql_root = Database::getSqlData();

			$dbm = new DbManager(\Froxlor\FroxlorLogger::getInstanceOf());
			$users = $dbm->getManager()->getAllSqlUsers(false);

			$databases = array(
				$sql_root['db']
			);
			$databases_result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
				WHERE `dbserver` = :mysqlserver
			");
			Database::pexecute($databases_result_stmt, array(
				'mysqlserver' => $dbserver['dbserver']
			));

			while ($databases_row = $databases_result_stmt->fetch(\PDO::FETCH_ASSOC)) {
				$databases[] = $databases_row['databasename'];
			}

			foreach ($databases as $username) {

				if (isset($users[$username]) && is_array($users[$username]) && isset($users[$username]['hosts']) && is_array($users[$username]['hosts'])) {

					$password = $users[$username]['password'];

					foreach ($mysql_access_host_array as $mysql_access_host) {

						$mysql_access_host = trim($mysql_access_host);

						if (! in_array($mysql_access_host, $users[$username]['hosts'])) {
							$dbm->getManager()->grantPrivilegesTo($username, $password, $mysql_access_host, true);
						}
					}

					foreach ($users[$username]['hosts'] as $mysql_access_host) {

						if (! in_array($mysql_access_host, $mysql_access_host_array)) {
							$dbm->getManager()->deleteUser($username, $mysql_access_host);
						}
					}
				}
			}

			$dbm->getManager()->flushPrivileges();
			Database::needRoot(false);
		}
	}
}
