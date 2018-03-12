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
class DirProtections extends ApiCommand implements ResourceEntity
{

	public function add()
	{}

	/**
	 * return a directory-protection entry by either id or username
	 *
	 * @param int $id
	 *        	optional, the customer-id
	 * @param string $username
	 *        	optional, the username
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		$id = $this->getParam('id', true, 0);
		$un_optional = ($id <= 0 ? false : true);
		$username = $this->getParam('username', $un_optional, '');
		
		$params = array();
		if ($this->isAdmin()) {
			if ($this->getUserDetail('customers_see_all') == false) {
				// if it's a reseller or an admin who cannot see all customers, we need to check
				// whether the database belongs to one of his customers
				$_custom_list_result = $this->apiCall('Customers.listing');
				$custom_list_result = $_custom_list_result['list'];
				$customer_ids = array();
				foreach ($custom_list_result as $customer) {
					$customer_ids[] = $customer['customerid'];
				}
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_HTPASSWDS . "`
					WHERE `customerid` IN (:customerid)
					AND (`id` = :idun OR `username` = :idun)
				");
				$params['customerid'] = implode(", ", $customer_ids);
			} else {
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_HTPASSWDS . "`
					WHERE (`id` = :idun OR `username` = :idun)
				");
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'extras.directoryprotection')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_HTPASSWDS . "`
				WHERE `customerid` = :customerid
				AND (`id` = :idun OR `username` = :idun)
			");
			$params['customerid'] = $this->getUserDetail('customerid');
		}
		$params['idun'] = ($id <= 0 ? $username : $id);
		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] get directory protection for '" . $result['path'] . "'");
			return $this->response(200, "successfull", $result);
		}
		$key = ($id > 0 ? "id #" . $id : "username '" . $username . "'");
		throw new Exception("Directory protection with " . $key . " could not be found", 404);
	}

	public function update()
	{}

	/**
	 * list all directory-protections, if called from an admin, list all directory-protections of all customers you are allowed to view, or specify id or loginname for one specific customer
	 *
	 * @param int $customerid
	 *        	optional, admin-only, select directory-protections of a specific customer by id
	 * @param string $loginname
	 *        	optional, admin-only, select directory-protections of a specific customer by loginname
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array count|list
	 */
	public function listing()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras')) {
			throw new Exception("You cannot access this resource", 405);
		}
		$customer_ids = $this->getAllowedCustomerIds('extras.directoryprotection');
		
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_HTPASSWDS . "`
			WHERE `customerid` IN (:customerids)
		");
		Database::pexecute($result_stmt, array(
			"customerids" => $customer_ids
		), true, true);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] list directory-protections");
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * delete a directory-protection by either id or username
	 *
	 * @param int $id
	 *        	optional, the ftp-user-id
	 * @param string $username
	 *        	optional, the username
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		$id = $this->getParam('id', true, 0);
		$un_optional = ($id <= 0 ? false : true);
		$username = $this->getParam('username', $un_optional, '');
		
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'extras.directoryprotection')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		// get ftp-user
		$result = $this->apiCall('DirProtections.get', array(
			'id' => $id,
			'username' => $username
		));
		$id = $result['id'];
		
		if ($this->isAdmin()) {
			// get customer-data
			$customer_data = $this->apiCall('Customers.get', array(
				'id' => $result['customerid']
			));
		} else {
			$customer_data = $this->getUserData();
		}
		
		$stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_HTPASSWDS . "` WHERE `customerid`= :customerid	AND `id`= :id
		");
		Database::pexecute($stmt, array(
			"customerid" => $customer_data['customerid'],
			"id" => $id
		));
		
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] deleted htpasswd for '" . $result['username'] . " (" . $result['path'] . ")'");
		inserttask('1');
		return $this->response(200, "successfull", $result);
	}
}
