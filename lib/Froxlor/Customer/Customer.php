<?php
namespace Froxlor\Customer;

use Froxlor\Database\Database;

class Customer
{

	public static function getCustomerDetail($customerid, $varname)
	{
		$customer_stmt = Database::prepare("
			SELECT `" . $varname . "` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid` = :customerid
		");
		$customer = Database::pexecute_first($customer_stmt, array(
			'customerid' => $customerid
		));

		if (isset($customer[$varname])) {
			return $customer[$varname];
		} else {
			return false;
		}
	}

	/**
	 * returns the loginname of a customer by given uid
	 *
	 * @param int $uid
	 *        	uid of customer
	 *        	
	 * @return string customers loginname
	 */
	public function getLoginNameByUid($uid = null)
	{
		$result_stmt = Database::prepare("
			SELECT `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `guid` = :guid
		");
		$result = Database::pexecute_first($result_stmt, array(
			'guid' => $uid
		));

		if (is_array($result) && isset($result['loginname'])) {
			return $result['loginname'];
		}
		return false;
	}

	/**
	 * Function customerHasPerlEnabled
	 *
	 * returns true or false whether perl is
	 * enabled for the given customer
	 *
	 * @param
	 *        	int customer-id
	 *        	
	 * @return boolean
	 */
	public static function customerHasPerlEnabled($cid = 0)
	{
		if ($cid > 0) {
			$result_stmt = Database::prepare("
				SELECT `perlenabled` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid` = :cid");
			Database::pexecute($result_stmt, array(
				'cid' => $cid
			));
			$result = $result_stmt->fetch(\PDO::FETCH_ASSOC);

			if (is_array($result) && isset($result['perlenabled'])) {
				return ($result['perlenabled'] == '1') ? true : false;
			}
		}
		return false;
	}
}
