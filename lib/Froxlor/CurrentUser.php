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

namespace Froxlor;

use Froxlor\Api\Commands\Customers;
use Froxlor\Api\Commands\SubDomains;
use Froxlor\Database\Database;
use Froxlor\UI\Collection;

/**
 * Class to manage the current user / session
 */
class CurrentUser
{

	/**
	 * returns whether there is an active session
	 *
	 * @return bool
	 */
	public static function hasSession(): bool
	{
		return !empty($_SESSION) && isset($_SESSION['userinfo']) && !empty($_SESSION['userinfo']);
	}

	/**
	 * set userinfo field in session
	 *
	 * @param string $index
	 * @param mixed $data
	 *
	 * @return boolean
	 */
	public static function setField(string $index, $data): bool
	{
		$_SESSION['userinfo'][$index] = $data;
		return true;
	}

	/**
	 * re-read in the user data if a valid session exists
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public static function reReadUserData(): bool
	{
		$table = self::isAdmin() ? TABLE_PANEL_ADMINS : TABLE_PANEL_CUSTOMERS;
		$userinfo_stmt = Database::prepare("
			SELECT * FROM `" . $table . "` WHERE `loginname`= :loginname AND `deactivated` = '0'
		");
		$userinfo = Database::pexecute_first($userinfo_stmt, [
			"loginname" => self::getField('loginname')
		]);
		if ($userinfo) {
			// don't just set the data, we need to merge with current data
			// array_merge is a right-reduction - value existing in getData() will be overwritten with $userinfo,
			// other than the union-operator (+) which would keep the values already existing from getData()
			$newuserinfo = array_merge(self::getData(), $userinfo);
			self::setData($newuserinfo);
			return true;
		}
		// unset / logout
		unset($_SESSION['userinfo']);
		self::setData([]);
		return false;
	}

	/**
	 * returns whether user has an adminsession
	 *
	 * @return bool
	 */
	public static function isAdmin(): bool
	{
		return (self::getField('adminsession') == 1 && self::getField('adminid') > 0 && empty(self::getField('customerid')));
	}

	/**
	 * return content of a given field from userinfo-array
	 *
	 * @param string $index
	 *
	 * @return string|array
	 */
	public static function getField(string $index)
	{
		return $_SESSION['userinfo'][$index] ?? "";
	}

	/**
	 * Return userinfo array
	 *
	 * @return array
	 */
	public static function getData(): array
	{
		return $_SESSION['userinfo'] ?? [];
	}

	/**
	 * set the userinfo data to the session
	 *
	 * @param array $data
	 */
	public static function setData(array $data = []): void
	{
		$_SESSION['userinfo'] = $data;
	}

	/**
	 * @param string $resource
	 * @return bool
	 * @throws \Exception
	 */
	public static function canAddResource(string $resource): bool
	{
		$addition = true;
		// special cases
		if ($resource == 'emails') {
			$result_stmt = Database::prepare("
				SELECT COUNT(`id`) as emaildomains
				FROM `" . TABLE_PANEL_DOMAINS . "`
				WHERE `customerid`= :cid AND `isemaildomain` = '1'
			");
			$result = Database::pexecute_first($result_stmt, [
				"cid" => $_SESSION['userinfo']['customerid']
			]);
			$addition = $result['emaildomains'] != 0;
		} elseif ($resource == 'subdomains') {
			if (Settings::IsInList('panel.customer_hide_options', 'domains')) {
				$addition = false;
			} else {
				$parentDomainCollection = (new Collection(SubDomains::class, $_SESSION['userinfo'],
					['sql_search' => ['d.parentdomainid' => 0]]));
				$addition = $parentDomainCollection->count() != 0;
			}
		} elseif ($resource == 'domains') {
			$customerCollection = (new Collection(Customers::class, $_SESSION['userinfo']));
			$addition = $customerCollection != 0;
		}

		return ($_SESSION['userinfo'][$resource . '_used'] < $_SESSION['userinfo'][$resource] || $_SESSION['userinfo'][$resource] == '-1') && $addition;
	}

}
