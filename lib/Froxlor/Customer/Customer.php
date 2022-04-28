<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Customer;

use Froxlor\Database\Database;
use PDO;

class Customer
{

	public static function getCustomerDetail($customerid, $varname)
	{
		$customer_stmt = Database::prepare("
			SELECT `" . $varname . "` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid` = :customerid
		");
		$customer = Database::pexecute_first($customer_stmt, [
			'customerid' => $customerid
		]);

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
	 *            uid of customer
	 *
	 * @return string customers loginname
	 */
	public static function getLoginNameByUid($uid = null)
	{
		$result_stmt = Database::prepare("
			SELECT `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `guid` = :guid
		");
		$result = Database::pexecute_first($result_stmt, [
			'guid' => $uid
		]);

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
	 *            int customer-id
	 *
	 * @return boolean
	 */
	public static function customerHasPerlEnabled($cid = 0)
	{
		if ($cid > 0) {
			$result_stmt = Database::prepare("
				SELECT `perlenabled` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid` = :cid");
			Database::pexecute($result_stmt, [
				'cid' => $cid
			]);
			$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

			if (is_array($result) && isset($result['perlenabled'])) {
				return $result['perlenabled'] == '1';
			}
		}
		return false;
	}
}
