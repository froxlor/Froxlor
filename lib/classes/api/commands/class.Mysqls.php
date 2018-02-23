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

	public function add()
	{}

	/**
	 * return a mysql database entry by either id or dbname
	 *
	 * @param int $id
	 *        	optional, the database-id
	 * @param string $dbname
	 *        	optional, the databasename
	 * @param int $dbserver
	 *        	optional, specify database-server, default is none
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$dbname = $this->getParam('dbname', $dn_optional, '');
		$dbserver = $this->getParam('dbserver', true, - 1);
		
		if ($id <= 0 && empty($dbname)) {
			throw new Exception("Either 'id' or 'dbname' parameter must be given", 406);
		}
		
		if ($this->isAdmin()) {
			if ($this->getUserDetail('customers_see_all') != 1) {
				// if it's a reseller or an admin who cannot see all customers, we need to check
				// whether the database belongs to one of his customers
				$json_result = Customers::getLocal($this->getUserData())->list();
				$custom_list_result = json_decode($json_result, true)['data']['list'];
				$customer_ids = array();
				foreach ($custom_list_result as $customer) {
					$customer_ids[] = $customer['customerid'];
				}
				if (count($customer_ids) > 0) {
					$result_stmt = Database::prepare("
						SELECT * FROM `" . TABLE_PANEL_DATABASES . "`
						WHERE " . ($id > 0 ? "`id` = :iddn" : "`databasename` = :iddn") . ($dbserver >= 0 ? " AND `dbserver` = :dbserver" : "") . " AND `customerid` IN (:customerids)
					");
					$params = array(
						'iddn' => ($id <= 0 ? $dbname : $id),
						'customerids' => implode(", ", $customer_ids)
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
			if ($id != $this->getUserDetail('customerid')) {
				throw new Exception("You cannot access data of other customers", 401);
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

	public function update()
	{}

	/**
	 * list all databases, if called from an admin, list all databases of all customers you are allowed to view, or specify id or loginname for one specific customer
	 *
	 * @param int $dbserver
	 *        	optional, specify dbserver to select from, else use all available
	 * @param int $customerid
	 *        	optional, admin-only, select dbs of a specific customer by id
	 * @param string $loginname
	 *        	optional, admin-only, select dbs of a specific customer by loginname
	 *        	
	 * @return array count|list
	 */
	public function list()
	{
		$result = array();
		$dbserver = $this->getParam('dbserver', true, - 1);
		if ($this->isAdmin()) {
			// if we're an admin, list all databases of all the admins customers
			// or optionally for one specific customer identified by id or loginname
			$customerid = $this->getParam('customerid', true, 0);
			$loginname = $this->getParam('loginname', true, '');
			
			if (! empty($customer_id) || ! empty($loginname)) {
				$json_result = Customers::getLocal($this->getUserData(), array(
					'id' => $customerid,
					'loginname' => $loginname
				))->get();
				$custom_list_result = array(
					json_decode($json_result, true)['data']
				);
			} else {
				$json_result = Customers::getLocal($this->getUserData())->list();
				$custom_list_result = json_decode($json_result, true)['data']['list'];
			}
			$customer_ids = array();
			foreach ($custom_list_result as $customer) {
				$customer_ids[] = $customer['customerid'];
			}
		} else {
			$customer_ids = array(
				$this->getUserDetail('customerid')
			);
		}
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
	 * @param int $dbserver
	 *        	optional, specify database-server, default is none
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$dbname = $this->getParam('dbname', $dn_optional, '');
		$dbserver = $this->getParam('dbserver', true, - 1);
		
		if ($id <= 0 && empty($dbname)) {
			throw new Exception("Either 'id' or 'dbname' parameter must be given", 406);
		}
		
		$json_result = Mysqls::getLocal($this->getUserData(), array(
			'id' => $id,
			'dbname' => $dbname,
			'dbserver' => $dbserver
		))->get();
		$result = json_decode($json_result, true)['data'];
		$id = $result['id'];
		
		// Begin root-session
		Database::needRoot(true, $result['dbserver']);
		$dbm = new DbManager($this->logger());
		$dbm->getManager()->deleteDatabase($result['databasename']);
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] deleted database '" . $result['databasename'] . "'");
		Database::needRoot(false);
		// End root-session
		
		// delete from table
		$stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DATABASES . "` WHERE `id` = :id");
		Database::pexecute($stmt, array(
			"id" => $id
		), true, true);
		
		// get needed customer info to reduce the mysql-usage-counter by one
		if ($this->isAdmin()) {
			$json_result = Customers::getLocal($this->getUserData(), array(
				'id' => $result['customerid']
			))->get();
			$customer = json_decode($json_result, true)['data'];
			$mysql_used = $customer['mysqls_used'];
			$customer_id = $customer['customer_id'];
		} else {
			$mysql_used = $this->getUserDetail('mysqls_used');
			$customer_id = $this->getUserDetail('customer_id');
		}
		// reduce mysql-usage-counter
		$resetaccnumber = ($mysql_used == '1') ? " , `mysql_lastaccountnumber` = '0' " : '';
		$stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
			SET `mysqls_used` = `mysqls_used` - 1 " . $resetaccnumber . "
			WHERE `customerid` = :customerid
		");
		Database::pexecute($stmt, array(
			"customerid" => $customer_id
		), true, true);
		return $this->response(200, "successfull", $result);
	}
}
