<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 * @since      0.9.31
 *
 */

/**
 * Class DbManager
 *
 * Wrapper-class for database-management like creating
 * and removing databases, users and permissions
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 */
class DbManager {

	/**
	 * FroxlorLogger object
	 * @var object
	 */
	private $_log = null;

	/**
	 * Manager object
	 * @var object
	 */
	private $_manager = null;

	/**
	 * main constructor
	 *
	 * @param FroxlorLogger $log
	 */
	public function __construct($log = null) {
		$this->_log = $log;
		$this->_setManager();
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
	public function createDatabase($loginname = null, $password = null, $last_accnumber = 0) {

		Database::needRoot(true);

		// check whether we shall create a random username
		if (strtoupper(Settings::Get('customer.mysqlprefix')) == 'RANDOM') {
			// get all usernames from db-manager
			$allsqlusers = $this->getManager()->getAllSqlUsers();
			// generate random username
			$username = $loginname . '-' . substr(md5(uniqid(microtime(), 1)), 20, 3);
			// check whether it exists on the DBMS
			while (in_array($username , $allsqlusers)) {
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
		$this->_log->logAction(USR_ACTION, LOG_INFO, "created database '" . $username . "'");

		// and give permission to the user on every access-host we have
		foreach (array_map('trim', explode(',', Settings::Get('system.mysql_access_host'))) as $mysql_access_host) {
			$this->getManager()->grantPrivilegesTo($username, $password, $mysql_access_host);
			$this->_log->logAction(USR_ACTION, LOG_NOTICE, "grant all privileges for '" . $username . "'@'" . $mysql_access_host . "'");
		}

		$this->getManager()->flushPrivileges();

		Database::needRoot(false);

		return $username;
	}

	/**
	 * returns the manager-object
	 * from where we can control it
	 */
	public function getManager() {
		return $this->_manager;
	}

	/**
	 * set manager-object by type of
	 * dbms: mysql only for now
	 *
	 * sets private $_manager variable
	 */
	private function _setManager() {
		// TODO read different dbms from settings later
		$this->_manager = new DbManagerMySQL($this->_log);
	}
}
