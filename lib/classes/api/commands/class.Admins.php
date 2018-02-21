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
 * @package    Panel
 *
 */
class Admins extends ApiCommand implements ResourceEntity
{

	/**
	 * lists all admin entries
	 *
	 * @return array count|list
	 */
	public function list()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings') == 1) {
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] list admins");
			$result_stmt = Database::prepare("
				SELECT *
				FROM `" . TABLE_PANEL_ADMINS . "`
				ORDER BY `loginname` ASC
			");
			Database::pexecute($result_stmt, null, true, true);
			$result = array();
			while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
			return $this->response(200, "successfull", array(
				'count' => count($result),
				'list' => $result
			));
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * return an admin entry by either id or loginname
	 *
	 * @param int $id
	 *        	optional, the admin-id
	 * @param string $loginname
	 *        	optional, the loginname
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$ln_optional = ($id <= 0 ? false : true);
		$loginname = $this->getParam('loginname', $ln_optional, '');
		
		if ($id <= 0 && empty($loginname)) {
			throw new Exception("Either 'id' or 'loginname' parameter must be given", 406);
		}
		
		if ($this->isAdmin() && ($this->getUserDetail('change_serversettings') == 1 || ($this->getUserDetail('adminid') == $id || $this->getUserDetail('loginname') == $loginname))) {
			$result_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_ADMINS . "`
				WHERE " . ($id > 0 ? "`adminid` = :idln" : "`loginname` = :idln"));
			$params = array(
				'idln' => ($id <= 0 ? $loginname : $id)
			);
			$result = Database::pexecute_first($result_stmt, $params, true, true);
			if ($result) {
				$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] get admin '" . $result['loginname'] . "'");
				return $this->response(200, "successfull", $result);
			}
			$key = ($id > 0 ? "id #" . $id : "loginname '" . $loginname . "'");
			throw new Exception("Admin with " . $key . " could not be found", 404);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function add()
	{
	}

	public function update()
	{
	}

	/**
	 * delete a admin entry by either id or loginname
	 *
	 * @param int $id
	 *        	optional, the customer-id
	 * @param string $loginname
	 *        	optional, the loginname
	 * @param bool $delete_userfiles
	 *        	optional, default false
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
	}

	/**
	 * unlock a locked admin by id
	 *
	 * @param int $id
	 *        	customer-id
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function unlock()
	{
	}
}
