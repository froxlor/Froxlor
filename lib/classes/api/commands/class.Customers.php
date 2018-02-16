<?php

class Customers extends ApiCommand
{

	public function list()
	{
		if ($this->isAdmin()) {
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] list customers");
			$result_stmt = Database::prepare("
			SELECT `c`.*, `a`.`loginname` AS `adminname`
			FROM `" . TABLE_PANEL_CUSTOMERS . "` `c`, `" . TABLE_PANEL_ADMINS . "` `a`
			WHERE " . ($this->getUserDetail('customers_see_all') ? '' : " `c`.`adminid` = :adminid AND ") . "
			`c`.`adminid` = `a`.`adminid`
			");
			$params = array();
			if ($this->getUserDetail('customers_see_all') == '0') {
				$params = array(
					'adminid' => $this->getUserDetail('adminid')
				);
			}
			Database::pexecute($result_stmt, $params, true, true);
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

	public function get()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');
			$this->logger()->logAction(ADM_ACTION, LOG_NOTICE, "[API] get customer #" . $id);
			$result_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `customerid` = :id" . ($this->getUserDetail('customers_see_all') ? '' : " AND `adminid` = :adminid"));
			$params = array(
				'id' => $id
			);
			if ($this->getUserDetail('customers_see_all') == '0') {
				$params['adminid'] = $this->getUserDetail('adminid');
			}
			$result = Database::pexecute_first($result_stmt, $params, true, true);
			if ($result) {
				return $this->response(200, "successfull", $result);
			}
			throw new Exception("Customer with id #" . $id . " could not be found");
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function add()
	{
		if ($this->isAdmin()) {
			$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] added customer '" . $loginname . "'");
			return $this->response(200, "successfull", $ins_data);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function update()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');
			
			$json_result = Customers::getLocal($this->getUserData(), array(
				'id' => $id
			))->get();
			$result = json_decode($json_result, true)['data'];
			
			$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] changed customer '" . $result['loginname'] . "'");
			return $this->response(200, "successfull", $upd_data);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}

	public function delete()
	{
		if ($this->isAdmin()) {
			$id = $this->getParam('id');
			
			$json_result = Customers::getLocal($this->getUserData(), array(
				'id' => $id
			))->get();
			$result = json_decode($json_result, true)['data'];

			$this->logger()->logAction(ADM_ACTION, LOG_WARNING, "[API] deleted customer '" . $result['loginname'] . "'");
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("Not allowed to execute given command.", 403);
	}
}
