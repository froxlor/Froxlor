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

	public function writeConfigs()
	{
		// tell the world what we are doing
		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Task4 started - Refreshing DNS database');

		$domains = $this->getDomainList();

		// clean up
		$this->_clearZoneTables($domains);

		if (empty($domains)) {
			$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'No domains found for nameserver-config, skipping...');
			return;
		}

		foreach ($domains as $domain) {
			if ($domain['ismainbutsubto'] > 0) {
				// domains with ismainbutsubto>0 are handled by recursion within walkDomainList()
				continue;
			}
			$this->walkDomainList($domain, $domains);
		}

		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'PowerDNS database updated');
		$this->reloadDaemon();
		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Task4 finished');
	}

	private function walkDomainList($domain, $domains)
	{
		$zoneContent = '';
		$subzones = array();

		foreach ($domain['children'] as $child_domain_id) {
			$subzones[] = $this->walkDomainList($domains[$child_domain_id], $domains);
		}

		if ($domain['zonefile'] == '') {
			// check for system-hostname
			$isFroxlorHostname = false;
			if (isset($domain['froxlorhost']) && $domain['froxlorhost'] == 1) {
				$isFroxlorHostname = true;
			}

			if ($domain['ismainbutsubto'] == 0) {
				$zoneContent = createDomainZone(($domain['id'] == 'none') ? $domain : $domain['id'], $isFroxlorHostname);
				if (count($subzones)) {
					foreach ($subzones as $subzone) {
						$zoneContent->records[] = $subzone;
					}
				}
				$pdnsDomId = $this->_insertZone($zoneContent->origin, $zoneContent->serial);
				$this->_insertRecords($pdnsDomId, $zoneContent->records, $zoneContent->origin);
				$this->_insertAllowedTransfers($pdnsDomId);
				$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'DB entries stored for zone `' . $domain['domain'] . '`');
			} else {
				return createDomainZone(($domain['id'] == 'none') ? $domain : $domain['id'], $isFroxlorHostname, true);
			}
		} else {
			$this->_logger->logAction(CRON_ACTION, LOG_ERROR, 'Custom zonefiles are NOT supported when PowerDNS is selected as DNS daemon (triggered by: ' . $domain['domain'] . ')');
		}
	}

	private function _clearZoneTables($domains = null)
	{
		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Cleaning dns zone entries from database');

		$pdns_domains_stmt = PowerDNS::getDB()->prepare("SELECT `id`, `name` FROM `domains` WHERE `name` = :domain");

		$del_rec_stmt = PowerDNS::getDB()->prepare("DELETE FROM `records` WHERE `domain_id` = :did");
		$del_meta_stmt = PowerDNS::getDB()->prepare("DELETE FROM `domainmetadata` WHERE `domain_id` = :did");
		$del_dom_stmt = PowerDNS::getDB()->prepare("DELETE FROM `domains` WHERE `id` = :did");

		foreach ($domains as $domain) {
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

	private function _insertZone($domainname, $serial = 0)
	{
		$ins_stmt = PowerDNS::getDB()->prepare("
			INSERT INTO domains set `name` = :domainname, `notified_serial` = :serial, `type` = 'NATIVE'
		");
		$ins_stmt->execute(array(
			'domainname' => $domainname,
			'serial' => $serial
		));
		$lastid = PowerDNS::getDB()->lastInsertId();
		return $lastid;
	}

	private function _insertRecords($domainid = 0, $records, $origin)
	{
		$changedate = date('Ymds', time());

		$ins_stmt = PowerDNS::getDB()->prepare("
			INSERT INTO records set
			`domain_id` = :did,
			`name` = :rec,
			`type` = :type,
			`content` = :content,
			`ttl` = :ttl,
			`prio` = :prio,
			`disabled` = '0',
			`change_date` = :changedate
		");

		foreach ($records as $record) {
			if ($record instanceof DnsZone) {
				$this->_insertRecords($domainid, $record->records, $record->origin);
				continue;
			}

			if ($record->record == '@') {
				$_record = $origin;
			} else {
				$_record = $record->record . "." . $origin;
			}

			$ins_data = array(
				'did' => $domainid,
				'rec' => $_record,
				'type' => $record->type,
				'content' => $record->content,
				'ttl' => $record->ttl,
				'prio' => $record->priority,
				'changedate' => $changedate
			);
			$ins_stmt->execute($ins_data);
		}
	}

	private function _insertAllowedTransfers($domainid)
	{
		$ins_stmt = PowerDNS::getDB()->prepare("
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
					$ins_data['value'] = $axfrserver;
					$ins_stmt->execute($ins_data);
				}
			}
		}
	}
}
