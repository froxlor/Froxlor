<?php
namespace Froxlor\Cron\Dns;

use Froxlor\Database\Database;
use Froxlor\Settings;

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

/**
 * Class DnsBase
 *
 * Base class for all DNS server configs
 */
abstract class DnsBase
{

	protected $logger = false;

	protected $ns = array();

	protected $mx = array();

	protected $axfr = array();

	abstract public function writeConfigs();

	public function __construct($logger)
	{
		$this->logger = $logger;

		$known_ns_ips = [];
		if (Settings::Get('system.nameservers') != '') {
			$nameservers = explode(',', Settings::Get('system.nameservers'));
			foreach ($nameservers as $nameserver) {
				$nameserver = trim($nameserver);
				// DNS servers might be multi homed; allow transfer from all ip
				// addresses of the DNS server
				$nameserver_ips = \Froxlor\PhpHelper::gethostbynamel6($nameserver);
				// append dot to hostname
				if (substr($nameserver, - 1, 1) != '.') {
					$nameserver .= '.';
				}
				// ignore invalid responses
				if (! is_array($nameserver_ips)) {
					// act like \Froxlor\PhpHelper::gethostbynamel6() and return unmodified hostname on error
					$nameserver_ips = array(
						$nameserver
					);
				} else {
					$known_ns_ips = array_merge($known_ns_ips, $nameserver_ips);
				}
				$this->ns[] = array(
					'hostname' => $nameserver,
					'ips' => $nameserver_ips
				);
			}
		}

		if (Settings::Get('system.mxservers') != '') {
			$mxservers = explode(',', Settings::Get('system.mxservers'));
			foreach ($mxservers as $mxserver) {
				if (substr($mxserver, - 1, 1) != '.') {
					$mxserver .= '.';
				}
				$this->mx[] = $mxserver;
			}
		}

		// AXFR server #100
		if (Settings::Get('system.axfrservers') != '') {
			$axfrservers = explode(',', Settings::Get('system.axfrservers'));
			foreach ($axfrservers as $axfrserver) {
				if (!in_array(trim($axfrserver), $known_ns_ips)) {
					$this->axfr[] = trim($axfrserver);
				}
			}
		}
	}

	protected function getDomainList()
	{
		$result_domains_stmt = Database::query("
			SELECT
				`d`.`id`,
				`d`.`domain`,
				`d`.`isemaildomain`,
				`d`.`iswildcarddomain`,
				`d`.`wwwserveralias`,
				`d`.`customerid`,
				`d`.`zonefile`,
				`d`.`bindserial`,
				`d`.`dkim`,
				`d`.`dkim_id`,
				`d`.`dkim_pubkey`,
				`d`.`ismainbutsubto`,
				`c`.`loginname`,
				`c`.`guid`
			FROM
				`" . TABLE_PANEL_DOMAINS . "` `d`
			LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`)
			WHERE
				`d`.`isbinddomain` = '1'
			ORDER BY
				`d`.`domain` ASC
		");

		$domains = array();
		// don't use fetchall() to be able to set the first column to the domain id and use it later on to set the rows'
		// array of direct children without having to search the outer array
		while ($domain = $result_domains_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$domains[$domain["id"]] = $domain;
		}

		// frolxor-hostname (#1090)
		if (Settings::get('system.dns_createhostnameentry') == 1) {
			$hostname_arr = array(
				'id' => 'none',
				'domain' => Settings::Get('system.hostname'),
				'isbinddomain' => '1',
				'isemaildomain' => Settings::Get('system.dns_createmailentry'),
				'customerid' => 'none',
				'loginname' => 'froxlor.panel',
				'bindserial' => date('Ymd') . '00',
				'dkim' => '0',
				'iswildcarddomain' => '1',
				'ismainbutsubto' => '0',
				'zonefile' => '',
				'froxlorhost' => '1'
			);
			$domains['none'] = $hostname_arr;
		}

		if (empty($domains)) {
			return null;
		}

		// collect domain IDs of direct child domains as arrays in ['children'] column
		foreach (array_keys($domains) as $key) {
			if (! isset($domains[$key]['children'])) {
				$domains[$key]['children'] = array();
			}
			if ($domains[$key]['ismainbutsubto'] > 0) {
				if (isset($domains[$domains[$key]['ismainbutsubto']])) {
					$domains[$domains[$key]['ismainbutsubto']]['children'][] = $domains[$key]['id'];
				} else {
					$domains[$key]['ismainbutsubto'] = 0;
				}
			}
		}

		$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, str_pad('domId', 9, ' ') . str_pad('domain', 40, ' ') . 'ismainbutsubto ' . str_pad('parent domain', 40, ' ') . "list of child domain ids");
		foreach ($domains as $domain) {
			$logLine = str_pad($domain['id'], 9, ' ') . str_pad($domain['domain'], 40, ' ') . str_pad($domain['ismainbutsubto'], 15, ' ') . str_pad(((isset($domains[$domain['ismainbutsubto']])) ? $domains[$domain['ismainbutsubto']]['domain'] : '-'), 40, ' ') . join(', ', $domain['children']);
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_DEBUG, $logLine);
		}

		return $domains;
	}

	public function reloadDaemon()
	{
		// reload DNS daemon
		$cmd = Settings::Get('system.bindreload_command');
		$cmdStatus = 1;
		\Froxlor\FileDir::safe_exec(escapeshellcmd($cmd), $cmdStatus);
		if ($cmdStatus === 0) {
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_INFO, Settings::Get('system.dns_server') . ' daemon reloaded');
		} else {
			$this->logger->logAction(\Froxlor\FroxlorLogger::CRON_ACTION, LOG_ERR, 'Error while running `' . $cmd . '`: exit code (' . $cmdStatus . ') - please check your system logs');
		}
	}
}
