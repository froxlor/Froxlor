<?php
namespace Froxlor\Api\Commands;

use Froxlor\Database\Database;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package API
 * @since 0.10.6
 *       
 */
class SysLog extends \Froxlor\Api\ApiCommand implements \Froxlor\Api\ResourceEntity
{

	/**
	 * list all log-entries
	 *
	 * @param array $sql_search
	 *        	optional array with index = fieldname, and value = array with 'op' => operator (one of <, > or =), LIKE is used if left empty and 'value' => searchvalue
	 * @param int $sql_limit
	 *        	optional specify number of results to be returned
	 * @param int $sql_offset
	 *        	optional specify offset for resultset
	 * @param array $sql_orderby
	 *        	optional array with index = fieldname and value = ASC|DESC to order the resultset by one or more fields
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array count|list
	 */
	public function listing()
	{
		$result = array();
		$query_fields = array();
		if ($this->isAdmin() && $this->getUserDetail('customers_see_all') == '1') {
			$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_LOG . "` " . $this->getSearchWhere($query_fields) . $this->getOrderBy() . $this->getLimit());
		} elseif ($this->isAdmin()) {
			// get all admin customers
			$_custom_list_result = $this->apiCall('Customers.listing');
			$custom_list_result = $_custom_list_result['list'];
			$customer_names = array();
			foreach ($custom_list_result as $customer) {
				$customer_names[] = $customer['loginname'];
			}
			if (count($customer_names) > 0) {
				$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_LOG . "`
				WHERE `user` = :loginname OR `user` IN ('" . implode("', '", $customer_names) . "')" . $this->getSearchWhere($query_fields, true) . $this->getOrderBy() . $this->getLimit());
			} else {
				$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_LOG . "`
				WHERE `user` = :loginname" . $this->getSearchWhere($query_fields, true) . $this->getOrderBy() . $this->getLimit());
			}
			$query_fields['loginname'] = $this->getUserDetail('loginname');
		} else {
			// every one else just sees their logs
			$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_LOG . "`
			WHERE `user` = :loginname AND `action` <> 99 " . $this->getSearchWhere($query_fields, true) . $this->getOrderBy() . $this->getLimit());
			$query_fields['loginname'] = $this->getUserDetail('loginname');
		}
		Database::pexecute($result_stmt, $query_fields, true, true);
		while ($row = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_NOTICE, "[API] list log-entries");
		return $this->response(200, "successful", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * returns the total number of log-entries
	 *
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function listingCount()
	{
		$params = null;
		if ($this->isAdmin() && $this->getUserDetail('customers_see_all') == '1') {
			$result_stmt = Database::prepare("
				SELECT COUNT(*) as num_logs FROM `" . TABLE_PANEL_LOG . "`
			");
		} elseif ($this->isAdmin()) {
			// get all admin customers
			$_custom_list_result = $this->apiCall('Customers.listing');
			$custom_list_result = $_custom_list_result['list'];
			$customer_names = array();
			foreach ($custom_list_result as $customer) {
				$customer_names[] = $customer['loginname'];
			}
			if (count($customer_names) > 0) {
				$result_stmt = Database::prepare("
					SELECT COUNT(*) as num_logs FROM `" . TABLE_PANEL_LOG . "`
					WHERE `user` = :loginname OR `user` IN ('" . implode("', '", $customer_names) . "')
				");
			} else {
				$result_stmt = Database::prepare("
					SELECT COUNT(*) as num_logs FROM `" . TABLE_PANEL_LOG . "`
					WHERE `user` = :loginname
				");
			}
			$params = [
				'loginname' => $this->getUserDetail('loginname')
			];
		} else {
			// every one else just sees their logs
			$result_stmt = Database::prepare("
				SELECT COUNT(*) as num_logs FROM `" . TABLE_PANEL_LOG . "`
				WHERE `user` = :loginname AND `action` <> 99
			");
			$params = [
				'loginname' => $this->getUserDetail('loginname')
			];
		}

		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			return $this->response(200, "successful", $result['num_logs']);
		}
	}

	/**
	 * You cannot get log entries
	 */
	public function get()
	{
		throw new \Exception('You cannot get log entries', 303);
	}

	/**
	 * You cannot add log entries
	 */
	public function add()
	{
		throw new \Exception('You cannot add log entries', 303);
	}

	/**
	 * You cannot update log entries
	 */
	public function update()
	{
		throw new \Exception('You cannot update log entries', 303);
	}

	/**
	 * delete log entries
	 *
	 * @param int $min_to_keep
	 *        	optional minutes to keep, default is 10
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function delete()
	{
		if ($this->isAdmin()) {
			$min_to_keep = self::getParam('min_to_keep', true, 10);
			if ($min_to_keep < 0) {
				$min_to_keep = 0;
			}
			$truncatedate = time() - (60 * $min_to_keep);
			$params = array();
			if ($this->getUserDetail('customers_see_all') == '1') {
				$result_stmt = Database::prepare("
					DELETE FROM `" . TABLE_PANEL_LOG . "` WHERE `date` < :trunc
				");
			} else {
				// get all admin customers
				$_custom_list_result = $this->apiCall('Customers.listing');
				$custom_list_result = $_custom_list_result['list'];
				$customer_names = array();
				foreach ($custom_list_result as $customer) {
					$customer_names[] = $customer['loginname'];
				}
				if (count($customer_names) > 0) {
					$result_stmt = Database::prepare("
						DELETE FROM `" . TABLE_PANEL_LOG . "` WHERE `date` < :trunc AND `user` = :loginname OR `user` IN ('" . implode("', '", $customer_names) . "')
					");
				} else {
					$result_stmt = Database::prepare("
						DELETE FROM `" . TABLE_PANEL_LOG . "` WHERE `date` < :trunc AND `user` = :loginname
					");
				}
				$params = [
					'loginname' => $this->getUserDetail('loginname')
				];
			}
			$params['trunc'] = $truncatedate;
			Database::pexecute($result_stmt, $params, true, true);
			$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_WARNING, "[API] truncated the froxlor syslog");
			return $this->response(200, "successful", true);
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}
}
