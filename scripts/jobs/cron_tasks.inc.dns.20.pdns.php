<?php
if (! defined('MASTER_CRONJOB'))
	die('You cannot access this file directly!');

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
class pdns extends DnsBase
{

	private $pdns_db = null;

	public function writeConfigs()
	{
		// tell the world what we are doing
		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Task4 started - Refreshing DNS database');

		// connect to db
		$this->_connectToPdnsDb();

		// clean up
		$this->_cleanZonefiles();

		$domains = $this->getDomainList();

		if (empty($domains)) {
			$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'No domains found for nameserver-config, skipping...');
			return;
		}


		foreach ($domains as $domain) {
			// check for system-hostname
			$isFroxlorHostname = false;
			if (isset($domain['froxlorhost']) && $domain['froxlorhost'] == 1) {
				$isFroxlorHostname = true;
			}
			// create zone-file
			$this->_logger->logAction(CRON_ACTION, LOG_DEBUG, 'Generating dns zone for ' . $domain['domain']);
			$zone = createDomainZone(($domain['id'] == 'none') ? $domain : $domain['id'], $isFroxlorHostname);

			$dom_id = $this->_insertZone($zone->origin, $zone->serial);
			$this->_insertRecords($dom_id, $zone->records, $zone->origin);
			$this->_insertAllowedTransfers($dom_id);

			$this->_logger->logAction(CRON_ACTION, LOG_INFO, '`' . $domain['domain'] . '` zone written');
		}

		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Database updated');

		// reload Bind
		safe_exec(escapeshellcmd(Settings::Get('system.bindreload_command')));
		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'pdns reloaded');
	}

	private function _cleanZonefiles()
	{
		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Cleaning dns zone entries from database');

		$this->pdns_db->query("TRUNCATE TABLE `records`");
		$this->pdns_db->query("TRUNCATE TABLE `domains`");
		$this->pdns_db->query("TRUNCATE TABLE `domainmetadata`");
	}

	private function _insertZone($domainname, $serial = 0)
	{
		$ins_stmt = $this->pdns_db->prepare("
			INSERT INTO domains set `name` = :domainname, `notified_serial` = :serial, `type` = 'NATIVE'
		");
		$ins_stmt->execute(array('domainname' => $domainname, 'serial' => $serial));
		$lastid = $this->pdns_db->lastInsertId();
		return $lastid;
	}

	private function _insertRecords($domainid = 0, $records, $origin)
	{
		$ins_stmt = $this->pdns_db->prepare("
			INSERT INTO records set
			`domain_id` = :did,
			`name` = :rec,
			`type` = :type,
			`content` = :content,
			`ttl` = :ttl,
			`prio` = :prio,
			`disabled` = '0',
			`change_date` = UNIX_TIMESTAMP()
		");

		foreach ($records as $record)
		{
			if ($record->record == '@') {
				$_record = $origin;
			}
			else
			{
				$_record = $record->record.".".$origin;
			}

			$ins_data = array(
				'did' => $domainid,
				'rec' => $_record,
				'type' => $record->type,
				'content' => $record->content,
				'ttl' => $record->ttl,
				'prio' => $record->priority
			);
			$ins_stmt->execute($ins_data);
		}
	}

	private function _insertAllowedTransfers($domainid)
	{
		$ins_stmt = $this->pdns_db->prepare("
			INSERT INTO domainmetadata set `domain_id` = :did, `kind` = 'ALLOW-AXFR-FROM', `content` = :value
		");

		$ins_data = array(
			'did' => $domainid
		);

		if (count($this->_ns) > 0 || count($this->_axfr) > 0) {
			// put nameservers in allow-transfer
			if (count($this->_ns) > 0) {
				foreach ($this->_ns as $ns) {
					foreach ($ns["ips"] as $ip) {
						$ins_data['value'] = $ip;
						$ins_stmt->execute($ins_data);
					}
				}
			}
			// AXFR server #100
			if (count($this->_axfr) > 0) {
				foreach ($this->_axfr as $axfrserver) {
					if (validate_ip($axfrserver, true) !== false) {
						$ins_data['value'] = $axfrserver;
						$ins_stmt->execute($ins_data);
					}
				}
			}
		}
	}

	private function _connectToPdnsDb()
	{
		// get froxlor pdns config
		$cf = Settings::Get('system.bindconf_directory').'/froxlor/pdns_froxlor.conf';
		$config = makeCorrectFile($cf);

		if (!file_exists($config))
		{
			$this->_logger->logAction(CRON_ACTION, LOG_ERROR, 'PowerDNS configuration file ('.$config.') not found. Did you go through the configuration templates?');
			die('PowerDNS configuration file ('.$config.') not found. Did you go through the configuration templates?'.PHP_EOL);
		}
		$lines = file($config);
		$mysql_data = array();
		foreach ($lines as $line)
		{
			$line = trim($line);
			if (strtolower(substr($line, 0, 6)) == 'gmysql')
			{
				$namevalue = explode("=", $line);
				$mysql_data[$namevalue[0]] = $namevalue[1];
			}
		}

		// build up connection string
		$driver = 'mysql';
		$dsn = $driver.":";
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8');
		$attributes = array('ATTR_ERRMODE' => 'ERRMODE_EXCEPTION');
		$dbconf = array();

		$dbconf["dsn"] = array(
			'dbname' => $mysql_data["gmysql-dbname"],
			'charset' => 'utf8'
		);

		if (isset($mysql_data['gmysql-socket']) && !empty($mysql_data['gmysql-socket'])) {
			$dbconf["dsn"]['unix_socket'] = makeCorrectFile($mysql_data['gmysql-socket']);
		} else {
			$dbconf["dsn"]['host'] = $mysql_data['gmysql-host'];
			$dbconf["dsn"]['port'] = $mysql_data['gmysql-port'];
		}

		// add options to dsn-string
		foreach ($dbconf["dsn"] as $k => $v) {
			$dsn .= $k."=".$v.";";
		}

		// clean up
		unset($dbconf);

		// try to connect
		try {
			$this->pdns_db = new PDO($dsn, $mysql_data['gmysql-user'], $mysql_data['gmysql-password'], $options);
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		// set attributes
		foreach ($attributes as $k => $v) {
			$this->pdns_db->setAttribute(constant("PDO::".$k), constant("PDO::".$v));
		}
	}
}
