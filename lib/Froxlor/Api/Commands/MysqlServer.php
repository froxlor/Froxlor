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

namespace Froxlor\Api\Commands;

use Exception;
use PDO;
use PDOException;
use Froxlor\Froxlor;
use Froxlor\Api\ApiCommand;
use Froxlor\Api\ResourceEntity;
use Froxlor\Validate\Validate;

class MysqlServer extends ApiCommand implements ResourceEntity
{

	/**
	 * check whether the user is allowed
	 *
	 * @throws Exception
	 */
	private function validateAccess()
	{
		if ($this->isAdmin() == false || ($this->isAdmin()  && $this->getUserDetail('change_serversettings') == 0)) {
			throw new Exception("You cannot access this resource", 405);
		}
	}

	/**
	 * add a new mysql-server
	 *
	 * @param string $mysql_host
	 *             ip/hostname of mysql-server
	 * @param string $mysql_port
	 *             optional, port to connect to
	 * @param string $mysql_ca
	 *             optional, path to certificate file
	 * @param string $mysql_verifycert
	 *             optional, verify server certificate
	 * @param string $privileged_user
	 *             privileged user on the mysql-server (must have GRANT privileges)
	 * @param string $privileged_password
	 *             password of privileged user
	 * @param string $description
	 *             optional, description for server
	 * @param bool $allow_all_customers
	 *             optional add this configuration to the list of every existing customer's allowed-fpm-config list, default is false (no)
	 *
	 * @access admin
	 * @throws Exception
	 * @return string json-encoded array
	 */
	public function add()
	{
		$this->validateAccess();

		$mysql_host = $this->getParam('mysql_host');
		$mysql_port = $this->getParam('mysql_port', true, 3306);
		$mysql_ca = $this->getParam('mysql_ca', true, '');
		$mysql_verifycert = $this->getBoolParam('mysql_verifycert', true, 0);
		$privileged_user = $this->getParam('privileged_user');
		$privileged_password = $this->getParam('privileged_password');
		$description = $this->getParam('description', true, '');

		// validation
		$mysql_host = Validate::validate_ip2($mysql_host, true, 'invalidip', true, true, false);
		if ($mysql_host === false) {
			$mysql_host = Validate::validateLocalHostname($mysql_host);
			if ($mysql_host === false) {
				$mysql_host = Validate::validateDomain($mysql_host);
				if ($mysql_host === false) {
					throw new Exception("Invalid mysql server ip/hostname", 406);
				}
			}
		}
		$mysql_port = Validate::validate($mysql_port, 'port', Validate::REGEX_PORT, '', [3306], true);
		$privileged_password = Validate::validate($privileged_password, 'password', '', '', [], true);
		$description = Validate::validate(trim($description), 'description', Validate::REGEX_DESC_TEXT, '', [], true);

		// testing connection with given credentials
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET names utf8'
		);
		if (!empty($mysql_ca)) {
			$options[PDO::MYSQL_ATTR_SSL_CA] = $mysql_ca;
			$options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = (bool) $mysql_verifycert;
		}

		$dsn = "mysql:host=" . $mysql_host . ";port=" . $mysql_port . ";";
		try {
			$db_test = new \PDO($dsn, $privileged_user, $privileged_password, $options);
			unset($db_test);
		} catch (PDOException $e) {
			throw new Exception("Connection to given mysql database could not be established. Error-message: " . $e->getMessage(), $e->getCode());
		}

		// get all data from lib/userdata
		require Froxlor::getInstallDir() . "/lib/userdata.inc.php";

		// le format
		if (isset($sql['root_user']) && isset($sql['root_password']) && (!isset($sql_root) || !is_array($sql_root))) {
			$sql_root = array(
				0 => array(
					'caption' => 'Default',
					'host' => $sql['host'],
					'socket' => (isset($sql['socket']) ? $sql['socket'] : null),
					'user' => $sql['root_user'],
					'password' => $sql['root_password']
				)
			);
			unset($sql['root_user']);
			unset($sql['root_password']);
		}

		// add new values to sql_root array
		$sql_root[] = [
			'caption' => $description,
			'host' => $mysql_host,
			'port' => $mysql_port,
			'user' => $privileged_user,
			'password' => $privileged_password,
			'ssl' => [
				'caFile' => $mysql_ca ?? "",
				'verifyServerCertificate' => $mysql_verifycert ?? false
			]
		];

		$this->generateNewUserData($sql, $sql_root);
		return $this->response(['true']);
	}

	/**
	 * remove a mysql-server
	 *
	 * @param int $dbserver number of the mysql server
	 *
	 * @access admin
	 * @throws Exception
	 * @return string json-encoded array
	 */
	public function delete()
	{
		$this->validateAccess();

		$dbserver = (int) $this->getParam('dbserver');

		if ($dbserver == 0) {
			throw new Exception('Cannot delete first/default mysql-server');
		}

		// @todo check whether the server is in use by any customer

		// get all data from lib/userdata
		require Froxlor::getInstallDir() . "/lib/userdata.inc.php";

		if (!isset($sql_root[$dbserver])) {
			throw new Exception('Mysql server not found', 404);
		}

		unset($sql_root[$dbserver]);

		$this->generateNewUserData($sql, $sql_root);
		return $this->response(['true']);
	}

	/**
	 * list available mysql-server
	 *
	 * @access admin, customer
	 * @return string json-encoded array
	 */
	public function listing()
	{
		// get all data from lib/userdata
		require Froxlor::getInstallDir() . "/lib/userdata.inc.php";

		// limit customer to its allowed servers
		$allowed_mysqls = [];
		if ($this->isAdmin() == false) {
			$allowed_mysqls = json_decode($this->getUserDetail('allowed_mysqlserver'), true);
		}

		$result = [];
		foreach ($sql_root as $index => $sqlrootdata) {
			if ($this->isAdmin() == false) {
				if ($allowed_mysqls === false || empty($allowed_mysqls)) {
					break;
				} elseif (!in_array($index, $allowed_mysqls)) {
					continue;
				}
			}
			// passwords will not be returned in any case for security reasons
			unset($sqlrootdata['password']);
			$result[$index] = $sqlrootdata;
		}

		return $this->response(['list' => $result, 'count' => count($result)]);
	}

	/**
	 * returns the total number of mysql servers
	 *
	 * @access admin, customer
	 * @return string json-encoded array
	 */
	public function listingCount()
	{
		if ($this->isAdmin() == false) {
			$allowed_mysqls = json_decode($this->getUserDetail('allowed_mysqlserver'), true);
			if ($allowed_mysqls) {
				return $this->response(count($allowed_mysqls));
			}
			return $this->response(0);
		}
		// get all data from lib/userdata
		require Froxlor::getInstallDir() . "/lib/userdata.inc.php";
		return $this->response(count($sql_root));
	}

	/**
	 * Return info about a specific mysql-server
	 *
	 * @param int $dbserver
	 * 		index of the mysql-server
	 *
	 * @access admin
	 * @throws Exception
	 * @return string json-encoded array
	 */
	public function get()
	{
		$this->validateAccess();

		$dbserver = (int) $this->getParam('dbserver');

		// get all data from lib/userdata
		require Froxlor::getInstallDir() . "/lib/userdata.inc.php";

		if (!isset($sql_root[$dbserver])) {
			throw new Exception('Mysql server not found', 404);
		}

		unset($sql_root[$dbserver]['password']);
		return $this->response($sql_root[$dbserver]);
	}

	/**
	 * @TODO implement me
	 */
	public function update()
	{
		throw new Exception('@TODO Later', 303);
	}

	private function generateNewUserData(array $sql, array $sql_root)
	{
		$content = '<?php' . PHP_EOL;
		$content .= '//automatically generated userdata.inc.php for Froxlor' . PHP_EOL;
		$content .= '$sql[\'host\']=\'' . $sql['host'] . '\';' . PHP_EOL;
		$content .= '$sql[\'user\']=\'' . $sql['user'] . '\';' . PHP_EOL;
		$content .= '$sql[\'password\']=\'' . $sql['password'] . '\';' . PHP_EOL;
		$content .= '$sql[\'db\']=\'' . $sql['db'] . '\';' . PHP_EOL;
		foreach ($sql_root as $index => $sqlroot_data) {
			$content .= '// database server #' . ($index + 1) . PHP_EOL;
			foreach ($sqlroot_data as $field => $value) {
				// ssl-fields
				if (is_array($value)) {
					foreach ($value as $vfield => $vvalue) {
						if ($vfield == 'verifyServerCertificate') {
							$content .= '$sql_root[' . (int)$index . '][\'' . $field . '\'][\'' . $vfield . '\'] = ' . ($vvalue ? 'true' : 'false') . ';' . PHP_EOL;
						} else {
							$content .= '$sql_root[' . (int)$index . '][\'' . $field . '\'][\'' . $vfield . '\'] = \'' . $vvalue . '\';' . PHP_EOL;
						}
					}
				} else {
					if ($field == 'password') {
						$content .= '$sql_root[' . (int)$index . '][\'' . $field . '\'] = <<<EOP
' . $value . '
EOP;' . PHP_EOL;
					} else {
						$content .= '$sql_root[' . (int)$index . '][\'' . $field . '\'] = \'' . $value . '\';' . PHP_EOL;
					}
				}
			}
		}
		$content .= '$sql[\'debug\']=' . ($sql['debug'] ? 'true' : 'false') . ';' . PHP_EOL;
		$content .= '?>' . PHP_EOL;
		file_put_contents(Froxlor::getInstallDir() . "/lib/userdata.inc.php", $content);
	}
}
