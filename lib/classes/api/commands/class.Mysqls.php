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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    API
 * @since      0.10.0
 *
 */
class Mysqls extends ApiCommand implements ResourceEntity
{

	/**
	 * add a new mysql-database
	 *
	 * @param string $mysql_password
	 *        	password for the created database and database-user
	 * @param int $mysql_server
	 *        	optional, default is 0
	 * @param string $description
	 *        	optional, description for database
	 * @param bool $sendinfomail
	 *        	optional, send created resource-information to customer, default: false
	 * @param int $customer_id
	 *        	required when called as admin, not needed when called as customer
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function add()
	{
		if ($this->getUserDetail('mysqls_used') < $this->getUserDetail('mysqls') || $this->getUserDetail('mysqls') == '-1') {
			
			// required paramters
			$password = $this->getParam('mysql_password');
			
			// parameters
			$dbserver = $this->getParam('mysql_server', true, 0);
			$databasedescription = $this->getParam('description', true, '');
			$sendinfomail = $this->getBoolParam('sendinfomail', true, 0);
			
			// validation
			$password = validate($password, 'password', '', '', array(), true);
			$password = validatePassword($password, true);
			$databasedescription = validate(trim($databasedescription), 'description', '', '', array(), true);
			
			// validate whether the dbserver exists
			$dbserver = validate($dbserver, html_entity_decode($this->lng['mysql']['mysql_server']), '', '', 0, true);
			Database::needRoot(true, $dbserver);
			Database::needSqlData();
			$sql_root = Database::getSqlData();
			Database::needRoot(false);
			if (! isset($sql_root) || ! is_array($sql_root)) {
				throw new ErrorException("Database server with index #" . $dbserver . " is unknown", 404);
			}
			
			if ($sendinfomail != 1) {
				$sendinfomail = 0;
			}
			
			// get needed customer info to reduce the mysql-usage-counter by one
			$customer = $this->getCustomerData('mysqls');
			
			$newdb_params = array(
				'loginname' => ($this->isAdmin() ? $customer['loginname'] : $this->getUserDetail('loginname')),
				'mysql_lastaccountnumber' => ($this->isAdmin() ? $customer['mysql_lastaccountnumber'] : $this->getUserDetail('mysql_lastaccountnumber'))
			);
			// create database, user, set permissions, etc.pp.
			$dbm = new DbManager($this->logger());
			$username = $dbm->createDatabase($newdb_params['loginname'], $password, $newdb_params['mysql_lastaccountnumber']);
			
			// we've checked against the password in dbm->createDatabase
			if ($username == false) {
				standard_error('passwordshouldnotbeusername', '', true);
			}
			
			// add database info to froxlor
			$stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_DATABASES . "`
				SET
				`customerid` = :customerid,
				`databasename` = :databasename,
				`description` = :description,
				`dbserver` = :dbserver
			");
			$params = array(
				"customerid" => $customer['customerid'],
				"databasename" => $username,
				"description" => $databasedescription,
				"dbserver" => $dbserver
			);
			Database::pexecute($stmt, $params, true, true);
			$databaseid = Database::lastInsertId();
			$params['id'] = $databaseid;
			
			// update customer usage
			Customers::increaseUsage($customer['customerid'], 'mysqls_used');
			Customers::increaseUsage($customer['customerid'], 'mysql_lastaccountnumber');
			
			// update admin usage
			Admins::increaseUsage($this->getUserDetail('adminid'), 'mysqls_used');
			
			// send info-mail?
			if ($sendinfomail == 1) {
				$pma = $this->lng['admin']['notgiven'];
				if (Settings::Get('panel.phpmyadmin_url') != '') {
					$pma = Settings::Get('panel.phpmyadmin_url');
				}
				
				Database::needRoot(true, $dbserver);
				Database::needSqlData();
				$sql_root = Database::getSqlData();
				Database::needRoot(false);
				$userinfo = $customer;
				
				$replace_arr = array(
					'SALUTATION' => getCorrectUserSalutation($userinfo),
					'CUST_NAME' => getCorrectUserSalutation($userinfo), // < keep this for compatibility
					'DB_NAME' => $username,
					'DB_PASS' => $password,
					'DB_DESC' => $databasedescription,
					'DB_SRV' => $sql_root['host'],
					'PMA_URI' => $pma
				);

				// get template for mail subject
				$mail_subject = $this->getMailTemplate($userinfo, 'mails', 'new_database_by_customer_subject', $replace_arr, $this->lng['mails']['new_database_by_customer']['subject']);
				// get template for mail body
				$mail_body = $this->getMailTemplate($userinfo, 'mails', 'new_database_by_customer_mailbody', $replace_arr, $this->lng['mails']['new_database_by_customer']['mailbody']);

				$_mailerror = false;
				$mailerr_msg = "";
				try {
					$this->mailer()->Subject = $mail_subject;
					$this->mailer()->AltBody = $mail_body;
					$this->mailer()->msgHTML(str_replace("\n", "<br />", $mail_body));
					$this->mailer()->addAddress($userinfo['email'], getCorrectUserSalutation($userinfo));
					$this->mailer()->send();
				} catch (phpmailerException $e) {
					$mailerr_msg = $e->errorMessage();
					$_mailerror = true;
				} catch (Exception $e) {
					$mailerr_msg = $e->getMessage();
					$_mailerror = true;
				}
				
				if ($_mailerror) {
					$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_ERR, "[API] Error sending mail: " . $mailerr_msg);
					standard_error('errorsendingmail', $userinfo['email'], true);
				}
				
				$this->mailer()->clearAddresses();
			}
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] added mysql-database '" . $username . "'");
			
			$result = $this->apiCall('Mysqls.get', array(
				'dbname' => $username
			));
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("No more resources available", 406);
	}

	/**
	 * return a mysql database entry by either id or dbname
	 *
	 * @param int $id
	 *        	optional, the database-id
	 * @param string $dbname
	 *        	optional, the databasename
	 * @param int $mysql_server
	 *        	optional, specify database-server, default is none
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$dbname = $this->getParam('dbname', $dn_optional, '');
		$dbserver = $this->getParam('mysql_server', true, - 1);
		
		if ($this->isAdmin()) {
			if ($this->getUserDetail('customers_see_all') != 1) {
				// if it's a reseller or an admin who cannot see all customers, we need to check
				// whether the database belongs to one of his customers
				$_custom_list_result = $this->apiCall('Customers.listing');
				$custom_list_result = $_custom_list_result['list'];
				$customer_ids = array();
				foreach ($custom_list_result as $customer) {
					$customer_ids[] = $customer['customerid'];
				}
				if (count($customer_ids) > 0) {
					$result_stmt = Database::prepare("
						SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
						WHERE " . ($id > 0 ? "`id` = :iddn" : "`databasename` = :iddn") . ($dbserver >= 0 ? " AND `dbserver` = :dbserver" : "") . " AND `customerid` IN (".implode(", ", $customer_ids).")
					");
					$params = array(
						'iddn' => ($id <= 0 ? $dbname : $id)
					);
					if ($dbserver >= 0) {
						$params['dbserver'] = $dbserver;
					}
				} else {
					throw new Exception("You do not have any customers yet", 406);
				}
			} else {
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
					WHERE " . ($id > 0 ? "`id` = :iddn" : "`databasename` = :iddn") . ($dbserver >= 0 ? " AND `dbserver` = :dbserver" : ""));
				$params = array(
					'iddn' => ($id <= 0 ? $dbname : $id)
				);
				if ($dbserver >= 0) {
					$params['dbserver'] = $dbserver;
				}
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'mysql')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
				WHERE `customerid`= :customerid AND " . ($id > 0 ? "`id` = :iddn" : "`databasename` = :iddn") . ($dbserver >= 0 ? " AND `dbserver` = :dbserver" : ""));
			$params = array(
				'customerid' => $this->getUserDetail('customerid'),
				'iddn' => ($id <= 0 ? $dbname : $id)
			);
			if ($dbserver >= 0) {
				$params['dbserver'] = $dbserver;
			}
		}
		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			Database::needRoot(true, $result['dbserver']);
			$mbdata_stmt = Database::prepare("
				SELECT SUM(data_length + index_length) as MB FROM information_schema.TABLES
				WHERE table_schema = :table_schema
				GROUP BY table_schema
			");
			Database::pexecute($mbdata_stmt, array(
				"table_schema" => $result['databasename']
			), true, true);
			$mbdata = $mbdata_stmt->fetch(PDO::FETCH_ASSOC);
			Database::needRoot(false);
			$result['size'] = $mbdata['MB'];
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] get database '" . $result['databasename'] . "'");
			return $this->response(200, "successfull", $result);
		}
		$key = ($id > 0 ? "id #" . $id : "dbname '" . $dbname . "'");
		throw new Exception("MySQL database with " . $key . " could not be found", 404);
	}

	/**
	 * update a mysql database entry by either id or dbname
	 *
	 * @param int $id
	 *        	optional, the database-id
	 * @param string $dbname
	 *        	optional, the databasename
	 * @param int $mysql_server
	 *        	optional, specify database-server, default is none
	 * @param string $mysql_password
	 *        	optional, update password for the database
	 * @param string $description
	 *        	optional, description for database
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function update()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$dbname = $this->getParam('dbname', $dn_optional, '');
		$dbserver = $this->getParam('mysql_server', true, - 1);
		
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'mysql')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		$result = $this->apiCall('Mysqls.get', array(
			'id' => $id,
			'dbname' => $dbname,
			'mysql_server' => $dbserver
		));
		$id = $result['id'];
		
		// paramters
		$password = $this->getParam('mysql_password', true, '');
		$databasedescription = $this->getParam('description', true, '');
		
		// validation
		$password = validate($password, 'password', '', '', array(), true);
		$databasedescription = validate(trim($databasedescription), 'description', '', '', array(), true);

		// get needed customer info to reduce the mysql-usage-counter by one
		$customer = $this->getCustomerData();
		
		if ($password != '') {
			// validate password
			$password = validatePassword($password, true);
			
			if ($password == $result['databasename']) {
				standard_error('passwordshouldnotbeusername', '', true);
			}
			
			// Begin root-session
			Database::needRoot(true, $result['dbserver']);
			foreach (array_map('trim', explode(',', Settings::Get('system.mysql_access_host'))) as $mysql_access_host) {
				$stmt = Database::prepare("SET PASSWORD FOR :dbname@:host = PASSWORD(:password)");
				$params = array(
					"dbname" => $result['databasename'],
					"host" => $mysql_access_host,
					"password" => $password
				);
				Database::pexecute($stmt, $params, true, true);
			}
			
			$stmt = Database::prepare("FLUSH PRIVILEGES");
			Database::pexecute($stmt, null, true, true);
			Database::needRoot(false);
			// End root-session
		}
		$stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_DATABASES . "`
			SET `description` = :desc
			WHERE `customerid` = :customerid
			AND `id` = :id
		");
		$params = array(
			"desc" => $databasedescription,
			"customerid" => $customer['customerid'],
			"id" => $id
		);
		Database::pexecute($stmt, $params, true, true);
		
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] updated mysql-database '" . $result['databasename'] . "'");
		$result = $this->apiCall('Mysqls.get', array(
			'dbname' => $result['databasename']
		));
		return $this->response(200, "successfull", $result);
	}

	/**
	 * list all databases, if called from an admin, list all databases of all customers you are allowed to view, or specify id or loginname for one specific customer
	 *
	 * @param int $mysql_server
	 *        	optional, specify dbserver to select from, else use all available
	 * @param int $customerid
	 *        	optional, admin-only, select dbs of a specific customer by id
	 * @param string $loginname
	 *        	optional, admin-only, select dbs of a specific customer by loginname
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array count|list
	 */
	public function listing()
	{
		$result = array();
		$dbserver = $this->getParam('mysql_server', true, - 1);
		$customer_ids = $this->getAllowedCustomerIds('mysql');
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
			WHERE `customerid`= :customerid AND `dbserver` = :dbserver
		");
		if ($dbserver < 0) {
			// use all dbservers
			$dbservers_stmt = Database::query("SELECT DISTINCT `dbserver` FROM `" . TABLE_PANEL_DATABASES . "`");
			$dbservers = $dbservers_stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			// use specific dbserver
			$dbservers = array(
				array(
					'dbserver' => $dbserver
				)
			);
		}
		
		foreach ($customer_ids as $customer_id) {
			foreach ($dbservers as $_dbserver) {
				Database::pexecute($result_stmt, array(
					'customerid' => $customer_id,
					'dbserver' => $_dbserver['dbserver']
				), true, true);
				// Begin root-session
				Database::needRoot(true, $_dbserver['dbserver']);
				while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
					$mbdata_stmt = Database::prepare("
						SELECT SUM(data_length + index_length) as MB FROM information_schema.TABLES
						WHERE table_schema = :table_schema
						GROUP BY table_schema
					");
					Database::pexecute($mbdata_stmt, array(
						"table_schema" => $row['databasename']
					), true, true);
					$mbdata = $mbdata_stmt->fetch(PDO::FETCH_ASSOC);
					$row['size'] = $mbdata['MB'];
					$result[] = $row;
				}
				Database::needRoot(false);
			}
		}
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * delete a mysql database by either id or dbname
	 *
	 * @param int $id
	 *        	optional, the database-id
	 * @param string $dbname
	 *        	optional, the databasename
	 * @param int $mysql_server
	 *        	optional, specify database-server, default is none
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$dbname = $this->getParam('dbname', $dn_optional, '');
		$dbserver = $this->getParam('mysql_server', true, - 1);
		
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'mysql')) {
			throw new Exception("You cannot access this resource", 405);
		}

		$result = $this->apiCall('Mysqls.get', array(
			'id' => $id,
			'dbname' => $dbname,
			'mysql_server' => $dbserver
		));
		$id = $result['id'];
		
		// Begin root-session
		Database::needRoot(true, $result['dbserver']);
		$dbm = new DbManager($this->logger());
		$dbm->getManager()->deleteDatabase($result['databasename']);
		Database::needRoot(false);
		// End root-session
		
		// delete from table
		$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DATABASES . "` WHERE `id` = :id");
		Database::pexecute($stmt, array(
			"id" => $id
		), true, true);
		
		// get needed customer info to reduce the mysql-usage-counter by one
		$customer = $this->getCustomerData();
		$mysql_used = $customer['mysqls_used'];

		// reduce mysql-usage-counter
		$resetaccnumber = ($mysql_used == '1') ? " , `mysql_lastaccountnumber` = '0' " : '';
		Customers::decreaseUsage($customer['customerid'], 'mysqls_used', $resetaccnumber);
		// update admin usage
		Admins::decreaseUsage(($this->isAdmin() ? $customer['adminid'] : $this->getUserDetail('adminid')), 'mysqls_used');

		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] deleted database '" . $result['databasename'] . "'");
		return $this->response(200, "successfull", $result);
	}
}
