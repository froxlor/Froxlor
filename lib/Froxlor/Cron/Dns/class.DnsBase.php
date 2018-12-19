<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2016-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 */

/**
 * Class DnsBase
 *
 * Base class for all DNS server configs
 */
abstract class DnsBase
{

	protected $_logger = false;

	protected $_ns = array();

	protected $_mx = array();

	protected $_axfr = array();

	abstract public function writeConfigs();

	public function __construct($logger)
	{
		$this->_logger = $logger;

		if (Settings::Get('system.nameservers') != '') {
			$nameservers = explode(',', Settings::Get('system.nameservers'));
			foreach ($nameservers as $nameserver) {
				$nameserver = trim($nameserver);
				// DNS servers might be multi homed; allow transfer from all ip
				// addresses of the DNS server
				$nameserver_ips = gethostbynamel6($nameserver);
				// append dot to hostname
				if (substr($nameserver, - 1, 1) != '.') {
					$nameserver .= '.';
				}
				// ignore invalid responses
				if (! is_array($nameserver_ips)) {
					// act like gethostbynamel6() and return unmodified hostname on error
					$nameserver_ips = array(
						$nameserver
					);
				}
				$this->_ns[] = array(
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
				$this->_mx[] = $mxserver;
			}
		}

		// AXFR server #100
		if (Settings::Get('system.axfrservers') != '') {
			$axfrservers = explode(',', Settings::Get('system.axfrservers'));
			foreach ($axfrservers as $axfrserver) {
				$this->_axfr[] = trim($axfrserver);
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
		while ($domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
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
					$this->_logger->logAction(CRON_ACTION, LOG_ERR, 'Database inconsistency: domain ' . $domain['domain'] . ' (ID #' . $key . ') is set to to be subdomain to non-existent domain ID #' . $domains[$key]['ismainbutsubto'] . '. No DNS record(s) will be created for this domain.');
				}
			}
		}

		$this->_logger->logAction(CRON_ACTION, LOG_DEBUG, str_pad('domId', 9, ' ') . str_pad('domain', 40, ' ') . 'ismainbutsubto ' . str_pad('parent domain', 40, ' ') . "list of child domain ids");
		foreach ($domains as $domain) {
			$logLine = str_pad($domain['id'], 9, ' ') . str_pad($domain['domain'], 40, ' ') . str_pad($domain['ismainbutsubto'], 15, ' ') . str_pad(((isset($domains[$domain['ismainbutsubto']])) ? $domains[$domain['ismainbutsubto']]['domain'] : '-'), 40, ' ') . join(', ', $domain['children']);
			$this->_logger->logAction(CRON_ACTION, LOG_DEBUG, $logLine);
		}

		return $domains;
	}

	public function reloadDaemon()
	{
		// reload DNS daemon
		$cmd = Settings::Get('system.bindreload_command');
		$cmdStatus = 1;
		safe_exec(escapeshellcmd($cmd), $cmdStatus);
		if ($cmdStatus === 0) {
			$this->_logger->logAction(CRON_ACTION, LOG_INFO, Settings::Get('system.dns_server') . ' daemon reloaded');
		} else {
			$this->_logger->logAction(CRON_ACTION, LOG_ERR, 'Error while running `' . $cmd . '`: exit code (' . $cmdStatus . ') - please check your system logs');
		}
	}

	public function writeDKIMconfigs()
	{
		if (Settings::Get('dkim.use_dkim') == '1') {
			if (! file_exists(makeCorrectDir(Settings::Get('dkim.dkim_prefix')))) {
				$this->_logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir -p ' . escapeshellarg(makeCorrectDir(Settings::Get('dkim.dkim_prefix'))));
				safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir(Settings::Get('dkim.dkim_prefix'))));
			}

			$dkimdomains = '';
			$dkimkeys = '';
			$result_domains_stmt = Database::query("
				SELECT `id`, `domain`, `dkim`, `dkim_id`, `dkim_pubkey`, `dkim_privkey`
				FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `dkim` = '1' ORDER BY `id` ASC
			");

			while ($domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {

				$privkey_filename = makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim_' . $domain['dkim_id']);
				$pubkey_filename = makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim_' . $domain['dkim_id'] . '.public');

				if ($domain['dkim_privkey'] == '' || $domain['dkim_pubkey'] == '') {
					$max_dkim_id_stmt = Database::query("SELECT MAX(`dkim_id`) as `max_dkim_id` FROM `" . TABLE_PANEL_DOMAINS . "`");
					$max_dkim_id = $max_dkim_id_stmt->fetch(PDO::FETCH_ASSOC);
					$domain['dkim_id'] = (int) $max_dkim_id['max_dkim_id'] + 1;
					$privkey_filename = makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim_' . $domain['dkim_id']);
					safe_exec('openssl genrsa -out ' . escapeshellarg($privkey_filename) . ' ' . Settings::Get('dkim.dkim_keylength'));
					$domain['dkim_privkey'] = file_get_contents($privkey_filename);
					safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));
					$pubkey_filename = makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/dkim_' . $domain['dkim_id'] . '.public');
					safe_exec('openssl rsa -in ' . escapeshellarg($privkey_filename) . ' -pubout -outform pem -out ' . escapeshellarg($pubkey_filename));
					$domain['dkim_pubkey'] = file_get_contents($pubkey_filename);
					safe_exec("chmod 0664 " . escapeshellarg($pubkey_filename));
					$upd_stmt = Database::prepare("
						UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
						`dkim_id` = :dkimid,
						`dkim_privkey` = :privkey,
						`dkim_pubkey` = :pubkey
						WHERE `id` = :id
					");
					$upd_data = array(
						'dkimid' => $domain['dkim_id'],
						'privkey' => $domain['dkim_privkey'],
						'pubkey' => $domain['dkim_pubkey'],
						'id' => $domain['id']
					);
					Database::pexecute($upd_stmt, $upd_data);
				}

				if (! file_exists($privkey_filename) && $domain['dkim_privkey'] != '') {
					$privkey_file_handler = fopen($privkey_filename, "w");
					fwrite($privkey_file_handler, $domain['dkim_privkey']);
					fclose($privkey_file_handler);
					safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));
				}

				if (! file_exists($pubkey_filename) && $domain['dkim_pubkey'] != '') {
					$pubkey_file_handler = fopen($pubkey_filename, "w");
					fwrite($pubkey_file_handler, $domain['dkim_pubkey']);
					fclose($pubkey_file_handler);
					safe_exec("chmod 0644 " . escapeshellarg($pubkey_filename));
				}

				$dkimdomains .= $domain['domain'] . "\n";
				$dkimkeys .= "*@" . $domain['domain'] . ":" . $domain['domain'] . ":" . $privkey_filename . "\n";
			}

			$dkimdomains_filename = makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . Settings::Get('dkim.dkim_domains'));
			$dkimdomains_file_handler = fopen($dkimdomains_filename, "w");
			fwrite($dkimdomains_file_handler, $dkimdomains);
			fclose($dkimdomains_file_handler);
			$dkimkeys_filename = makeCorrectFile(Settings::Get('dkim.dkim_prefix') . '/' . Settings::Get('dkim.dkim_dkimkeys'));
			$dkimkeys_file_handler = fopen($dkimkeys_filename, "w");
			fwrite($dkimkeys_file_handler, $dkimkeys);
			fclose($dkimkeys_file_handler);

			safe_exec(escapeshellcmd(Settings::Get('dkim.dkimrestart_command')));
			$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Dkim-milter reloaded');
		}
	}
}
