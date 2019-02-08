<?php
namespace Froxlor\Cron\Dns;

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
class PowerDNS extends DnsBase
{

	public function writeConfigs()
	{
		// tell the world what we are doing
		$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'Task4 started - Refreshing DNS database');

		$domains = $this->getDomainList();

		// clean up
		$this->clearZoneTables($domains);

		if (empty($domains)) {
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'No domains found for nameserver-config, skipping...');
			return;
		}

		foreach ($domains as $domain) {
			if ($domain['ismainbutsubto'] > 0) {
				// domains with ismainbutsubto>0 are handled by recursion within walkDomainList()
				continue;
			}
			$this->walkDomainList($domain, $domains);
		}

		$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'PowerDNS database updated');
		$this->reloadDaemon();
		$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'Task4 finished');
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
				$zoneContent = \Froxlor\Dns\Dns::createDomainZone(($domain['id'] == 'none') ? $domain : $domain['id'], $isFroxlorHostname);
				if (count($subzones)) {
					foreach ($subzones as $subzone) {
						$zoneContent->records[] = $subzone;
					}
				}
				$pdnsDomId = $this->insertZone($zoneContent->origin, $zoneContent->serial);
				$this->insertRecords($pdnsDomId, $zoneContent->records, $zoneContent->origin);
				$this->insertAllowedTransfers($pdnsDomId);
				$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'DB entries stored for zone `' . $domain['domain'] . '`');
			} else {
				return \Froxlor\Dns\Dns::createDomainZone(($domain['id'] == 'none') ? $domain : $domain['id'], $isFroxlorHostname, true);
			}
		} else {
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, 'Custom zonefiles are NOT supported when PowerDNS is selected as DNS daemon (triggered by: ' . $domain['domain'] . ')');
		}
	}

	private function clearZoneTables($domains = null)
	{
		$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, 'Cleaning dns zone entries from database');

		$pdns_domains_stmt = \Froxlor\Dns\PowerDNS::getDB()->prepare("SELECT `id`, `name` FROM `domains` WHERE `name` = :domain");

		$del_rec_stmt = \Froxlor\Dns\PowerDNS::getDB()->prepare("DELETE FROM `records` WHERE `domain_id` = :did");
		$del_meta_stmt = \Froxlor\Dns\PowerDNS::getDB()->prepare("DELETE FROM `domainmetadata` WHERE `domain_id` = :did");
		$del_dom_stmt = \Froxlor\Dns\PowerDNS::getDB()->prepare("DELETE FROM `domains` WHERE `id` = :did");

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

	private function insertZone($domainname, $serial = 0)
	{
		$ins_stmt = PowerDNS::getDB()->prepare("
			INSERT INTO domains set `name` = :domainname, `notified_serial` = :serial, `type` = 'NATIVE'
		");
		$ins_stmt->execute(array(
			'domainname' => $domainname,
			'serial' => $serial
		));
		$lastid = \Froxlor\Dns\PowerDNS::getDB()->lastInsertId();
		return $lastid;
	}

	private function insertRecords($domainid = 0, $records = array(), $origin = "")
	{
		$ins_stmt = PowerDNS::getDB()->prepare("
			INSERT INTO records set
			`domain_id` = :did,
			`name` = :rec,
			`type` = :type,
			`content` = :content,
			`ttl` = :ttl,
			`prio` = :prio,
			`disabled` = '0'
		");

		foreach ($records as $record) {
			if ($record instanceof \Froxlor\Dns\DnsZone) {
				$this->insertRecords($domainid, $record->records, $record->origin);
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
				'prio' => $record->priority
			);
			$ins_stmt->execute($ins_data);
		}
	}

	private function insertAllowedTransfers($domainid)
	{
		$ins_stmt = PowerDNS::getDB()->prepare("
			INSERT INTO domainmetadata set `domain_id` = :did, `kind` = 'ALLOW-AXFR-FROM', `content` = :value
		");

		$ins_data = array(
			'did' => $domainid
		);

		if (count($this->ns) > 0 || count($this->axfr) > 0) {
			// put nameservers in allow-transfer
			if (count($this->ns) > 0) {
				foreach ($this->ns as $ns) {
					foreach ($ns["ips"] as $ip) {
						$ins_data['value'] = $ip;
						$ins_stmt->execute($ins_data);
					}
				}
			}
			// AXFR server #100
			if (count($this->axfr) > 0) {
				foreach ($this->axfr as $axfrserver) {
					$ins_data['value'] = $axfrserver;
					$ins_stmt->execute($ins_data);
				}
			}
		}
	}
}
