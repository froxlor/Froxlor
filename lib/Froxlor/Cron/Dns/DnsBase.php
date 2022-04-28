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

namespace Froxlor\Cron\Dns;

use Froxlor\Database\Database;
use Froxlor\FileDir;
use Froxlor\FroxlorLogger;
use Froxlor\PhpHelper;
use Froxlor\Settings;
use PDO;

/**
 * Class DnsBase
 *
 * Base class for all DNS server configs
 */
abstract class DnsBase
{

	protected $logger = false;

	protected $ns = [];

	protected $mx = [];

	protected $axfr = [];

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
				$nameserver_ips = PhpHelper::gethostbynamel6($nameserver);
				// append dot to hostname
				if (substr($nameserver, -1, 1) != '.') {
					$nameserver .= '.';
				}
				// ignore invalid responses
				if (!is_array($nameserver_ips)) {
					// act like \Froxlor\PhpHelper::gethostbynamel6() and return unmodified hostname on error
					$nameserver_ips = [
						$nameserver
					];
				} else {
					$known_ns_ips = array_merge($known_ns_ips, $nameserver_ips);
				}
				$this->ns[] = [
					'hostname' => $nameserver,
					'ips' => $nameserver_ips
				];
			}
		}

		if (Settings::Get('system.mxservers') != '') {
			$mxservers = explode(',', Settings::Get('system.mxservers'));
			foreach ($mxservers as $mxserver) {
				if (substr($mxserver, -1, 1) != '.') {
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

	abstract public function writeConfigs();

	public function reloadDaemon()
	{
		// reload DNS daemon
		$cmd = Settings::Get('system.bindreload_command');
		$cmdStatus = 1;
		FileDir::safe_exec(escapeshellcmd($cmd), $cmdStatus);
		if ($cmdStatus === 0) {
			$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, Settings::Get('system.dns_server') . ' daemon reloaded');
		} else {
			$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_ERR, 'Error while running `' . $cmd . '`: exit code (' . $cmdStatus . ') - please check your system logs');
		}
	}

	public function writeDKIMconfigs()
	{
		if (Settings::Get('dkim.use_dkim') == '1') {
			if (!file_exists(FileDir::makeCorrectDir(Settings::Get('dkim.dkim_prefix')))) {
				$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_NOTICE, 'mkdir -p ' . escapeshellarg(FileDir::makeCorrectDir(Settings::Get('dkim.dkim_prefix'))));
				FileDir::safe_exec('mkdir -p ' . escapeshellarg(FileDir::makeCorrectDir(Settings::Get('dkim.dkim_prefix'))));
			}

			$dkimdomains = '';
			$dkimkeys = '';
			$result_domains_stmt = Database::query("
				SELECT `id`, `domain`, `dkim`, `dkim_id`, `dkim_pubkey`, `dkim_privkey`
				FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `dkim` = '1' ORDER BY `id` ASC
			");

			while ($domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
				$privkey_filename = FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim' . $domain['dkim_id'] . Settings::Get('dkim.privkeysuffix'));
				$pubkey_filename = FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim' . $domain['dkim_id'] . '.public');

				if ($domain['dkim_privkey'] == '' || $domain['dkim_pubkey'] == '') {
					$max_dkim_id_stmt = Database::query("SELECT MAX(`dkim_id`) as `max_dkim_id` FROM `" . TABLE_PANEL_DOMAINS . "`");
					$max_dkim_id = $max_dkim_id_stmt->fetch(PDO::FETCH_ASSOC);
					$domain['dkim_id'] = (int)$max_dkim_id['max_dkim_id'] + 1;
					$privkey_filename = FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim' . $domain['dkim_id'] . Settings::Get('dkim.privkeysuffix'));
					FileDir::safe_exec('openssl genrsa -out ' . escapeshellarg($privkey_filename) . ' ' . Settings::Get('dkim.dkim_keylength'));
					$domain['dkim_privkey'] = file_get_contents($privkey_filename);
					FileDir::safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));
					$pubkey_filename = FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim' . $domain['dkim_id'] . '.public');
					FileDir::safe_exec('openssl rsa -in ' . escapeshellarg($privkey_filename) . ' -pubout -outform pem -out ' . escapeshellarg($pubkey_filename));
					$domain['dkim_pubkey'] = file_get_contents($pubkey_filename);
					FileDir::safe_exec("chmod 0664 " . escapeshellarg($pubkey_filename));
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
						`dkim_id` = :dkimid,
						`dkim_privkey` = :privkey,
						`dkim_pubkey` = :pubkey
						WHERE `id` = :id
					");
					$upd_data = [
						'dkimid' => $domain['dkim_id'],
						'privkey' => $domain['dkim_privkey'],
						'pubkey' => $domain['dkim_pubkey'],
						'id' => $domain['id']
					];
					Database::pexecute($upd_stmt, $upd_data);
				}

				if (!file_exists($privkey_filename) && $domain['dkim_privkey'] != '') {
					$privkey_file_handler = fopen($privkey_filename, "w");
					fwrite($privkey_file_handler, $domain['dkim_privkey']);
					fclose($privkey_file_handler);
					FileDir::safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));
				}

				if (!file_exists($pubkey_filename) && $domain['dkim_pubkey'] != '') {
					$pubkey_file_handler = fopen($pubkey_filename, "w");
					fwrite($pubkey_file_handler, $domain['dkim_pubkey']);
					fclose($pubkey_file_handler);
					FileDir::safe_exec("chmod 0644 " . escapeshellarg($pubkey_filename));
				}

				$dkimdomains .= $domain['domain'] . "\n";
				$dkimkeys .= "*@" . $domain['domain'] . ":" . $domain['domain'] . ":" . $privkey_filename . "\n";
			}

			$dkimdomains_filename = FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . Settings::Get('dkim.dkim_domains'));
			$dkimdomains_file_handler = fopen($dkimdomains_filename, "w");
			fwrite($dkimdomains_file_handler, $dkimdomains);
			fclose($dkimdomains_file_handler);
			$dkimkeys_filename = FileDir::makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . Settings::Get('dkim.dkim_dkimkeys'));
			$dkimkeys_file_handler = fopen($dkimkeys_filename, "w");
			fwrite($dkimkeys_file_handler, $dkimkeys);
			fclose($dkimkeys_file_handler);

			FileDir::safe_exec(escapeshellcmd(Settings::Get('dkim.dkimrestart_command')));
			$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'Dkim-milter reloaded');
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

		$domains = [];
		// don't use fetchall() to be able to set the first column to the domain id and use it later on to set the rows'
		// array of direct children without having to search the outer array
		while ($domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
			$domains[$domain["id"]] = $domain;
		}

		// frolxor-hostname (#1090)
		if (Settings::get('system.dns_createhostnameentry') == 1) {
			$hostname_arr = [
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
			];
			$domains['none'] = $hostname_arr;
		}

		if (empty($domains)) {
			return null;
		}

		// collect domain IDs of direct child domains as arrays in ['children'] column
		foreach (array_keys($domains) as $key) {
			if (!isset($domains[$key]['children'])) {
				$domains[$key]['children'] = [];
			}
			if ($domains[$key]['ismainbutsubto'] > 0) {
				if (isset($domains[$domains[$key]['ismainbutsubto']])) {
					$domains[$domains[$key]['ismainbutsubto']]['children'][] = $domains[$key]['id'];
				} else {
					$domains[$key]['ismainbutsubto'] = 0;
				}
			}
		}

		$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, str_pad('domId', 9, ' ') . str_pad('domain', 40, ' ') . 'ismainbutsubto ' . str_pad('parent domain', 40, ' ') . "list of child domain ids");
		foreach ($domains as $domain) {
			$logLine = str_pad($domain['id'], 9, ' ') . str_pad($domain['domain'], 40, ' ') . str_pad($domain['ismainbutsubto'], 15, ' ') . str_pad(((isset($domains[$domain['ismainbutsubto']])) ? $domains[$domain['ismainbutsubto']]['domain'] : '-'), 40, ' ') . join(', ', $domain['children']);
			$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, $logLine);
		}

		return $domains;
	}
}
