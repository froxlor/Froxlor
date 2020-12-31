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
 * @since 0.10.0
 *       
 */
class Cronjobs extends \Froxlor\Api\ApiCommand implements \Froxlor\Api\ResourceEntity
{

	/**
	 * You cannot add new cronjobs yet.
	 */
	public function add()
	{
		throw new \Exception('You cannot add new cronjobs yet.', 303);
	}

	/**
	 * return a cronjob entry by id
	 *
	 * @param int $id
	 *        	cronjob-id
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function get()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');

			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_CRONRUNS . "` WHERE `id` = :id
			");
			$result = Database::pexecute_first($result_stmt, array(
				'id' => $id
			), true, true);
			if ($result) {
				return $this->response(200, "successful", $result);
			}
			throw new \Exception("cronjob with id #" . $id . " could not be found", 404);
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * update a cronjob entry by given id
	 *
	 * @param int $id
	 * @param bool $isactive
	 *        	optional whether the cronjob is active or not
	 * @param int $interval_value
	 *        	optional number of seconds/minutes/hours/etc. for the interval
	 * @param string $interval_interval
	 *        	optional interval for the cronjob (MINUTE, HOUR, DAY, WEEK or MONTH)
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function update()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {

			// required parameter
			$id = $this->getParam('id');

			$result = $this->apiCall('Cronjobs.get', array(
				'id' => $id
			));

			// split interval
			$cur_int = explode(" ", $result['interval']);

			// parameter
			$isactive = $this->getBoolParam('isactive', true, $result['isactive']);
			$interval_value = $this->getParam('interval_value', true, $cur_int[0]);
			$interval_interval = $this->getParam('interval_interval', true, $cur_int[1]);

			// validation
			if ($isactive != 1) {
				$isactive = 0;
			}
			$interval_value = \Froxlor\Validate\Validate::validate($interval_value, 'interval_value', '/^([0-9]+)$/Di', 'stringisempty', array(), true);
			$interval_interval = \Froxlor\Validate\Validate::validate($interval_interval, 'interval_interval', '', '', array(), true);

			// put together interval value
			$interval = $interval_value . ' ' . strtoupper($interval_interval);

			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_CRONRUNS . "`
				SET `isactive` = :isactive, `interval` = :int
				WHERE `id` = :id
			");
			Database::pexecute($upd_stmt, array(
				'isactive' => $isactive,
				'int' => $interval,
				'id' => $id
			), true, true);

			// insert task to re-generate the cron.d-file
			\Froxlor\System\Cronjob::inserttask('99');
			$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "[API] cronjob with description '" . $result['module'] . '/' . $result['cronfile'] . "' has been updated by '" . $this->getUserDetail('loginname') . "'");
			$result = $this->apiCall('Cronjobs.get', array(
				'id' => $id
			));
			return $this->response(200, "successful", $result);
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * lists all cronjob entries
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
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array count|list
	 */
	public function listing()
	{
		if ($this->isAdmin()) {
			$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "[API] list cronjobs");
			$query_fields = array();
			$result_stmt = Database::prepare("
				SELECT `c`.* FROM `" . TABLE_PANEL_CRONRUNS . "` `c` " . $this->getSearchWhere($query_fields) . $this->getOrderBy() . $this->getLimit());
			Database::pexecute($result_stmt, $query_fields, true, true);
			$result = array();
			while ($row = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $this->response(200, "successful", array(
				'count' => count($result),
				'list' => $result
			));
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * returns the total number of cronjobs
	 *
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function listingCount()
	{
		if ($this->isAdmin()) {
			$result_stmt = Database::prepare("
				SELECT COUNT(*) as num_crons FROM `" . TABLE_PANEL_CRONRUNS . "` `c`
			");
			$result = Database::pexecute_first($result_stmt, null, true, true);
			if ($result) {
				return $this->response(200, "successful", $result['num_crons']);
			}
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * You cannot delete system cronjobs.
	 */
	public function delete()
	{
		throw new \Exception('You cannot delete system cronjobs.', 303);
	}
}
