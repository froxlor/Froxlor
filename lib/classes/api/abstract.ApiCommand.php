<?php

abstract class ApiCommand
{

	private $is_admin = false;

	private $user_data = null;

	private $logger = null;

	private $cmd_params = null;

	public function __construct($header = null, $params = null, $userinfo = null)
	{
		$this->cmd_params = $params;
		if (! empty($header)) {
			$this->readUserData($header);
		} elseif (! empty($userinfo)) {
			$this->user_data = $userinfo;
			$this->is_admin = ($userinfo['adminsession'] == 1 && $userinfo['adminid'] > 0) ? true : false;
		} else {
			throw new Exception("Invalid user data", 500);
		}
		$this->logger = FroxlorLogger::getInstanceOf($this->user_data);
	}

	public static function getLocal($userinfo = null, $params = null)
	{
		return new static(null, $params, $userinfo);
	}

	/**
	 * admin flag
	 *
	 * @return boolean
	 */
	protected function isAdmin()
	{
		return $this->is_admin;
	}

	/**
	 * return field from user-table
	 *
	 * @param string $detail
	 *
	 * @return string
	 */
	protected function getUserDetail($detail = null)
	{
		return (isset($this->user_data[$detail]) ? $this->user_data[$detail] : null);
	}

	/**
	 * return user-data array
	 *
	 * @return array
	 */
	protected function getUserData()
	{
		return $this->user_data;
	}

	/**
	 * receive field from parameter-list
	 *
	 * @param string $param
	 * @param mixed $default
	 *        	set if param is not found
	 *        	
	 * @throws Exception
	 * @return mixed
	 */
	protected function getParam($param = null, $default = null)
	{
		if (isset($this->cmd_params[$param])) {
			return $this->cmd_params[$param];
		}
		return $default;
	}

	/**
	 * update value of parameter
	 *
	 * @param string $param
	 * @param mixed $value
	 *
	 * @throws Exception
	 * @return boolean
	 */
	protected function updateParam($param, $value = null)
	{
		if (isset($this->cmd_params[$param])) {
			$this->cmd_params[$param] = $value;
			return true;
		}
		throw new Exception("Unable to update parameter '" . $param . "' as it does not exist", 500);
	}

	/**
	 * return logger instance
	 *
	 * @return FroxlorLogger
	 */
	protected function logger()
	{
		return $this->logger;
	}

	protected function response($status, $status_message, $data = null)
	{
		header("HTTP/1.1 " . $status);
		
		$response['status'] = $status;
		$response['status_message'] = $status_message;
		$response['data'] = $data;
		
		$json_response = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		return $json_response;
	}

	public abstract function list();

	public abstract function get();

	public abstract function add();

	public abstract function update();

	public abstract function delete();

	private function readUserData($header = null)
	{
		$sel_stmt = Database::prepare("SELECT * FROM `api_keys` WHERE `apikey` = :ak AND `secret` = :as");
		$result = Database::pexecute_first($sel_stmt, array(
			'ak' => $header['apikey'],
			'as' => $header['secret']
		), true, true);
		if ($result) {
			// admin or customer?
			if ($result['customerid'] == 0) {
				$this->is_admin = true;
				$table = 'panel_admins';
				$key = "adminid";
			} else {
				$this->is_admin = false;
				$table = 'panel_customers';
				$key = "customerid";
			}
			$sel_stmt = Database::prepare("SELECT * FROM `" . $table . "` WHERE `" . $key . "` = :id");
			$this->user_data = Database::pexecute_first($sel_stmt, array(
				'id' => ($this->is_admin ? $result['adminid'] : $result['customerid'])
			), true, true);
			return true;
		}
		throw new Exception("Invalid API credentials", 400);
	}
}
