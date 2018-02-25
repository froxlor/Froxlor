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
		$username = trim($this->getParam('username', $un_optional, ''));

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

	public function list()
	{}

	public function delete()
	{}
}
