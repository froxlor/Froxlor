<?php

namespace Froxlor;

use Froxlor\Database\Database;

/**
 * Class to manage the current user / session
 */
class CurrentUser
{

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
	 * returns whether there is an active session
	 * 
	 * @return bool
	 */
	public static function hasSession(): bool
	{
		return !empty($_SESSION) && isset($_SESSION['userinfo']) && !empty($_SESSION['userinfo']);
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
		return isset($_SESSION['userinfo'][$index]) ? $_SESSION['userinfo'][$index] : "";
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
	 * Return userinfo array
	 * 
	 * @return array
	 */
	public static function getData(): array
	{
		return $_SESSION['userinfo'] ?? [];
	}

	/**
	 * re-read in the user data if a valid session exists
	 *
	 * @return boolean
	 */
	public static function reReadUserData()
	{
		$table = self::isAdmin() ? TABLE_PANEL_ADMINS : TABLE_PANEL_CUSTOMERS;
		$userinfo_stmt = Database::prepare("
			SELECT * FROM `" . $table . "` WHERE `loginname`= :loginname AND `deactivated` = '0'
		");
		$userinfo = Database::pexecute_first($userinfo_stmt, [
			"loginname" => self::getField('loginname')
		]);
		if ($userinfo) {
			// dont just set the data, we need to merge with current data
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
}
