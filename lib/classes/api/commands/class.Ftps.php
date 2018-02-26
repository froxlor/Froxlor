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
class Ftps extends ApiCommand implements ResourceEntity
{

	public function add()
	{}

	/**
	 * return a ftp-user entry by either id or username
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
		$id = $this->getParam('id', true, 0);
		$un_optional = ($id <= 0 ? false : true);
		$username = $this->getParam('username', $un_optional, '');
		
		$params = array();
		if ($this->isAdmin()) {
			if ($this->getUserDetail('customers_see_all') == false) {
				// if it's a reseller or an admin who cannot see all customers, we need to check
				// whether the database belongs to one of his customers
				$json_result = Customers::getLocal($this->getUserData())->list();
				$custom_list_result = json_decode($json_result, true)['data']['list'];
				$customer_ids = array();
				foreach ($custom_list_result as $customer) {
					$customer_ids[] = $customer['customerid'];
				}
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_FTP_USERS . "`
					WHERE `customerid` IN (:customerid)
					AND (`id` = :idun OR `username` = :idun)
				");
				$params['customerid'] = implode(", ", $customer_ids);
			} else {
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_FTP_USERS . "`
					WHERE (`id` = :idun OR `username` = :idun)
				");
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'ftp')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_FTP_USERS . "`
				WHERE `customerid` = :customerid
				AND (`id` = :idun OR `username` = :idun)
			");
			$params['customerid'] = $this->getUserDetail('customerid');
		}
		$params['idun'] = ($id <= 0 ? $username : $id);
		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] get ftp-user '" . $result['username'] . "'");
			return $this->response(200, "successfull", $result);
		}
		$key = ($id > 0 ? "id #" . $id : "username '" . $username . "'");
		throw new Exception("FTP user with " . $key . " could not be found", 404);
	}

	public function update()
	{}

	/**
	 * list all ftp-users, if called from an admin, list all ftp-users of all customers you are allowed to view, or specify id or loginname for one specific customer
	 *
	 * @param int $customerid
	 *        	optional, admin-only, select ftp-users of a specific customer by id
	 * @param string $loginname
	 *        	optional, admin-only, select ftp-users of a specific customer by loginname
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array count|list
	 */
	public function list()
	{
		if ($this->isAdmin()) {
			// if we're an admin, list all ftp-users of all the admins customers
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
			if (Settings::IsInList('panel.customer_hide_options', 'ftp')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$customer_ids = array(
				$this->getUserDetail('customerid')
			);
		}
		$result = array();
		$params['customerid'] = implode(", ", $customer_ids);
		$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_FTP_USERS . "`
			WHERE `customerid` IN (:customerid)
		");
		Database::pexecute($result_stmt, $params);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] list ftp-users");
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * delete a ftp-user by either id or username
	 *
	 * @param int $id
	 *        	optional, the ftp-user-id
	 * @param string $username
	 *        	optional, the username
	 * @param bool $delete_userfiles
	 *        	optional, default false
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
		$id = $this->getParam('id', true, 0);
		$un_optional = ($id <= 0 ? false : true);
		$username = $this->getParam('username', $un_optional, '');
		$delete_userfiles = $this->getParam('delete_userfiles', true, 0);
		
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'ftp')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		// get ftp-user
		$json_result = Ftps::getLocal($this->getUserData(), array(
			'id' => $id,
			'username' => $username
		))->get();
		$result = json_decode($json_result, true)['data'];
		$id = $result['id'];
		
		if ($this->isAdmin()) {
			// get customer-data
			$json_result = Customers::getLocal($this->getUserData(), array(
				'id' => $result['customerid']
			))->get();
			$customer_data = json_decode($json_result, true)['data'];
		} else {
			$customer_data = $this->getUserData();
		}
		
		// add usage of this ftp-user to main-ftp user of customer if different
		if ($result['username'] != $customer_data['loginname']) {
			$stmt = Database::prepare("UPDATE `" . TABLE_FTP_USERS . "`
				SET `up_count` = `up_count` + :up_count,
				`up_bytes` = `up_bytes` + :up_bytes,
				`down_count` = `down_count` + :down_count,
				`down_bytes` = `down_bytes` + :down_bytes
				WHERE `username` = :username
			");
			$params = array(
				"up_count" => $result['up_count'],
				"up_bytes" => $result['up_bytes'],
				"down_count" => $result['down_count'],
				"down_bytes" => $result['down_bytes'],
				"username" => $customer_data['loginname']
			);
			Database::pexecute($stmt, $params, true, true);
		}
		
		// remove all quotatallies
		$stmt = Database::prepare("DELETE FROM `" . TABLE_FTP_QUOTATALLIES . "` WHERE `name` = :name");
		Database::pexecute($stmt, array(
			"name" => $result['username']
		), true, tue);
		
		// remove user itself
		$stmt = Database::prepare("
			DELETE FROM `" . TABLE_FTP_USERS . "` WHERE `customerid` = :customerid AND `id` = :id
		");
		Database::pexecute($stmt, array(
			"customerid" => $customer_data['customerid'],
			"id" => $id
		), true, true);
		
		// update ftp-groups
		$stmt = Database::prepare("
			UPDATE `" . TABLE_FTP_GROUPS . "` SET
			`members` = REPLACE(`members`, :username,'')
			WHERE `customerid` = :customerid
		");
		Database::pexecute($stmt, array(
			"username" => "," . $result['username'],
			"customerid" => $customer_data['customerid']
		), true, true);
		
		$log->logAction(USR_ACTION, LOG_INFO, "deleted ftp-account '" . $result['username'] . "'");
		
		// refs #293
		if ($delete_userfiles == 1) {
			inserttask('8', $customer_data['loginname'], $result['homedir']);
		} else {
			if (Settings::Get('system.nssextrausers') == 1) {
				// this is used so that the libnss-extrausers cron is fired
				inserttask(5);
			}
		}
		
		// decrease ftp-user usage for customer
		$resetaccnumber = ($customer_data['ftps_used'] == '1') ? " , `ftp_lastaccountnumber`='0'" : '';
		$stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
			SET `ftps_used` = `ftps_used` - 1 $resetaccnumber
			WHERE `customerid` = :customerid");
		Database::pexecute($stmt, array(
			"customerid" => $customer_data['customerid']
		), true, true);
		// update admin usage
		$stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_ADMINS . "`
			SET `mysqls_used` = `mysqls_used` - 1
			WHERE `adminid` = :adminid
		");
		Database::pexecute($stmt, array(
			"adminid" => ($this->isAdmin() ? $customer_data['adminid'] : $this->getUserDetail('adminid'))
		), true, true);
		
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] deleted ftp-user '" . $result['username'] . "'");
		return $this->response(200, "successfull", $result);
	}
}
