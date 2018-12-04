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
class Traffic extends ApiCommand implements ResourceEntity
{

	/**
	 * You cannot add traffic data
	 *
	 * @throws Exception
	 */
	public function add()
	{
		throw new Exception('You cannot add traffic data', 303);
	}

	/**
	 * to get specific traffic details use year, month and/or day parameter for Traffic.listing()
	 *
	 * @throws Exception
	 */
	public function get()
	{
		throw new Exception('To get specific traffic details use year, month and/or day parameter for Traffic.listing()', 303);
	}

	/**
	 * You cannot update traffic data
	 *
	 * @throws Exception
	 */
	public function update()
	{
		throw new Exception('You cannot update traffic data', 303);
	}

	/**
	 * list traffic information
	 *
	 * @param int $year
	 *        	optional, default empty
	 * @param int $month
	 *        	optional, default empty
	 * @param int $day
	 *        	optional, default empty
	 * @param bool $customer_traffic
	 *        	optional, admin-only, whether to output ones own traffic or all of ones customers, default is 0 (false)
	 * @param int $customerid
	 *        	optional, admin-only, select traffic of a specific customer by id
	 * @param string $loginname
	 *        	optional, admin-only, select traffic of a specific customer by loginname
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array count|list
	 */
	public function listing()
	{
		$year = $this->getParam('year', true, "");
		$month = $this->getParam('month', true, "");
		$day = $this->getParam('day', true, "");
		$customer_traffic = $this->getBoolParam('customer_traffic', true, 0);
		$customer_ids = $this->getAllowedCustomerIds();
		$result = array();
		$params = array();
		// check for year/month/day
		$where_str = "";
		if (! empty($year) && is_numeric($year)) {
			$where_str .= " AND `year` = :year";
			$params['year'] = $year;
		}
		if (! empty($month) && is_numeric($month)) {
			$where_str .= " AND `month` = :month";
			$params['month'] = $month;
		}
		if (! empty($day) && is_numeric($day)) {
			$where_str .= " AND `day` = :day";
			$params['day'] = $day;
		}

		if (! $this->isAdmin() || ($this->isAdmin() && $customer_traffic)) {
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_TRAFFIC . "`
				WHERE `customerid` IN (".implode(", ", $customer_ids).")" . $where_str);
		} else {
			$params['adminid'] = $this->getUserDetail('adminid');
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_TRAFFIC_ADMINS . "`
				WHERE `adminid` = :adminid" . $where_str);
		}
		Database::pexecute($result_stmt, $params, true, true);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] list traffic");
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * You cannot delete traffic data
	 *
	 * @throws Exception
	 */
	public function delete()
	{
		throw new Exception('You cannot delete traffic data', 303);
	}
}
