<?php

namespace Froxlor\Cron;


class TaskId {
	/**
	 * TYPE=1 MEANS TO REBUILD APACHE VHOSTS.CONF
	 */
	const REBUILD_VHOST = 1;

	/**
	 * TYPE=2 MEANS TO CREATE A NEW HOME AND CHOWN
	 */
	const CREATE_HOME = 2;

	/**
	 * TYPE=4 MEANS THAT SOMETHING IN THE DNS CONFIG HAS CHANGED.
	 * REBUILD froxlor_bind.conf IF BIND IS ENABLED, UPDATE DKIM KEYS
	 */
	const REBUILD_DNS = 4;

	/**
	 * TYPE=5 MEANS THAT A NEW FTP-ACCOUNT HAS BEEN CREATED, CREATE THE DIRECTORY
	 */
	const CREATE_FTP = 5;

	/**
	 * TYPE=6 MEANS THAT A CUSTOMER HAS BEEN DELETED AND THAT WE HAVE TO REMOVE ITS FILES
	 */
	const DELETE_CUSTOMER_FILES = 6;

	/**
	 * TYPE=7 Customer deleted an email account and wants the data to be deleted on the filesystem
	 */
	const DELETE_EMAIL_DATA = 7;

	/**
	 * TYPE=8 Customer deleted a ftp account and wants the homedir to be deleted on the filesystem
	 * refs #293
	 */
	const DELETE_FTP_DATA = 8;

	/**
	 * TYPE=10 Set the filesystem - quota
	 */
	const CREATE_QUOTA = 10;

	/**
	 * TYPE=11 domain has been deleted, remove from pdns database if used
	 */
	const DELETE_DOMAIN_PDNS = 11;

	/**
	* TYPE=12 domain has been deleted, remove from acme.sh/let's encrypt directory if used
	 */
	const DELETE_DOMAIN_SSL = 12;

	/**
	* TYPE=20 COSTUMERBACKUP
	 */
	const CREATE_CUSTOMER_BACKUP = 20;

	/**
	* TYPE=99 REGENERATE CRON
	 */
	const REBUILD_CRON = 99;

	/**
	 * Return if a cron task id is valid
	 * @param int|string $id cron task id (legacy string support)
	 * @return boolean
	 */
	public static function isValid($id) {
		static $reflContants;
		if (!is_numeric($id)) {
			return false;
		}
		$numericid = (int)$id;
		if (!is_array($reflContants)) {
			$reflClass = new \ReflectionClass(get_called_class());
			$reflContants = $reflClass->getConstants();
		}
		return in_array($numericid, $reflContants, true);
	}

	/**
	 * Get constant name by id
	 * @param int|string $id cron task id (legacy string support)
	 * @return string|false constant name or false if not found
	 */
	public static function convertToConstant($id) {
		static $reflContants;
		if (!is_numeric($id)) {
			return false;
		}
		$numericid = (int)$id;
		if (!is_array($reflContants)) {
			$reflClass = new \ReflectionClass(get_called_class());
			$reflContants = $reflClass->getConstants();
		}
		return array_search($numericid, $reflContants, true);
	}
}

