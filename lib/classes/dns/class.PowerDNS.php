<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *
 */
class PowerDNS
{

	private static $pdns_db = null;

	private static function connectToPdnsDb()
	{
		// get froxlor pdns config
		$cf = Settings::Get('system.bindconf_directory') . '/froxlor/pdns_froxlor.conf';
		$config = makeCorrectFile($cf);

		if (! file_exists($config)) {
			die('PowerDNS configuration file (' . $config . ') not found. Did you go through the configuration templates?' . PHP_EOL);
		}
		$lines = file($config);
		$mysql_data = array();
		foreach ($lines as $line) {
			$line = trim($line);
			if (strtolower(substr($line, 0, 6)) == 'gmysql') {
				$namevalue = explode("=", $line);
				$mysql_data[$namevalue[0]] = $namevalue[1];
			}
		}

		// build up connection string
		$driver = 'mysql';
		$dsn = $driver . ":";
		$options = array(
			'PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET names utf8'
		);
		$attributes = array(
			'ATTR_ERRMODE' => 'ERRMODE_EXCEPTION'
		);
		$dbconf = array();

		$dbconf["dsn"] = array(
			'dbname' => $mysql_data["gmysql-dbname"],
			'charset' => 'utf8'
		);

		if (isset($mysql_data['gmysql-socket']) && ! empty($mysql_data['gmysql-socket'])) {
			$dbconf["dsn"]['unix_socket'] = makeCorrectFile($mysql_data['gmysql-socket']);
		} else {
			$dbconf["dsn"]['host'] = $mysql_data['gmysql-host'];
			$dbconf["dsn"]['port'] = $mysql_data['gmysql-port'];
		}

		// add options to dsn-string
		foreach ($dbconf["dsn"] as $k => $v) {
			$dsn .= $k . "=" . $v . ";";
		}

		// clean up
		unset($dbconf);

		// try to connect
		try {
			self::$pdns_db = new PDO($dsn, $mysql_data['gmysql-user'], $mysql_data['gmysql-password'], $options);
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		// set attributes
		foreach ($attributes as $k => $v) {
			self::$pdns_db->setAttribute(constant("PDO::" . $k), constant("PDO::" . $v));
		}

		$version_server = self::$pdns_db->getAttribute(PDO::ATTR_SERVER_VERSION);
		$sql_mode = 'NO_ENGINE_SUBSTITUTION';
		if (version_compare($version_server, '8.0.11', '<')) {
			$sql_mode .= ',NO_AUTO_CREATE_USER';
		}
		self::$pdns_db->exec('SET sql_mode = "'.$sql_mode.'"');
	}

	/**
	 * get pdo database connection to powerdns database
	 *
	 * @return PDO
	 */
	public static function getDB()
	{
		if (! isset(self::$pdns_db) || (self::$pdns_db instanceof PDO) == false) {
			self::connectToPdnsDb();
		}
		return self::$pdns_db;
	}

	/**
	 * remove all records and entries of a given domain
	 *
	 * @param array $domain
	 */
	public static function cleanDomainZone($domain = null)
	{
		if (is_array($domain) && isset($domain['domain'])) {
			$pdns_domains_stmt = self::getDB()->prepare("SELECT `id`, `name` FROM `domains` WHERE `name` = :domain");
			$del_rec_stmt = self::getDB()->prepare("DELETE FROM `records` WHERE `domain_id` = :did");
			$del_meta_stmt = self::getDB()->prepare("DELETE FROM `domainmetadata` WHERE `domain_id` = :did");
			$del_dom_stmt = self::getDB()->prepare("DELETE FROM `domains` WHERE `id` = :did");

			$pdns_domains_stmt->execute(array(
				'domain' => $domain['domain']
			));
			$pdns_domain = $pdns_domains_stmt->fetch(\PDO::FETCH_ASSOC);

			$del_rec_stmt->execute(array(
				'did' => $pdns_domain['id']
			));
			$del_meta_stmt->execute(array(
				'did' => $pdns_domain['id']
			));
			$del_dom_stmt->execute(array(
				'did' => $pdns_domain['id']
			));
		}
	}
}