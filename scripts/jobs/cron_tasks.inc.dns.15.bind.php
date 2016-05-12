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
class bind2
{

	private $_logger = false;

	private $_ns = array();

	private $_mx = array();

	private $_axfr = array();

	public function __construct($logger)
	{
		$this->_logger = $logger;

		if (Settings::Get('system.nameservers') != '') {
			$nameservers = explode(',', Settings::Get('system.nameservers'));
			foreach ($nameservers as $nameserver) {
				$nameserver = trim($nameserver);
				// DNS servers might be multi homed; allow transfer from all ip
				// addresses of the DNS server
				$nameserver_ips = gethostbynamel($nameserver);
				// append dot to hostname
				if (substr($nameserver, - 1, 1) != '.') {
					$nameserver .= '.';
				}
				// ignore invalid responses
				if (! is_array($nameserver_ips)) {
					// act like gethostbyname() and return unmodified hostname on error
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

	public function writeConfigs()
	{
		// tell the world what we are doing
		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Task4 started - Rebuilding froxlor_bind.conf');

		// clean up
		$this->_cleanZonefiles();

		// check for subfolder in bind-config-directory
		if (! file_exists(makeCorrectDir(Settings::Get('system.bindconf_directory') . '/domains/'))) {
			$this->_logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.bindconf_directory') . '/domains/')));
			safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir(Settings::Get('system.bindconf_directory') . '/domains/')));
		}

		// get all Domains
		$result_domains_stmt = Database::query("
			SELECT `d`.`id`, `d`.`domain`, `d`.`customerid`, `d`.`zonefile`, `c`.`loginname`, `c`.`guid`
			FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`)
			WHERE `d`.`isbinddomain` = '1' ORDER BY `d`.`domain` ASC
		");

		$domains = $result_domains_stmt->fetchAll(PDO::FETCH_ASSOC);

		// frolxor-hostname (#1090)
		if (Settings::get('system.dns_createhostnameentry') == 1) {
			$hostname_arr = array(
				'id' => 'none',
				'domain' => Settings::Get('system.hostname'),
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
			$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'No domains found for nameserver-config, skipping...');
			return;
		}

		$bindconf_file = '# ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf' . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n\n";

		foreach ($domains as $domain) {
			// check for system-hostname
			$isFroxlorHostname = false;
			if (isset($domain['froxlorhost']) && $domain['froxlorhost'] == 1) {
				$isFroxlorHostname = true;
			}
			// create zone-file
			$this->_logger->logAction(CRON_ACTION, LOG_DEBUG, 'Generating dns zone for ' . $domain['domain']);
			$zonefile = createDomainZone($domain['id'], $isFroxlorHostname);
			$domain['zonefile'] = 'domains/' . $domain['domain'] . '.zone';
			$zonefile_name = makeCorrectFile(Settings::Get('system.bindconf_directory') . '/' . $domain['zonefile']);
			$zonefile_handler = fopen($zonefile_name, 'w');
			fwrite($zonefile_handler, $zonefile);
			fclose($zonefile_handler);
			$this->_logger->logAction(CRON_ACTION, LOG_INFO, '`' . $zonefile_name . '` zone written');

			// generate config
			$bindconf_file .= $this->_generateDomainConfig($domain);
		}

		// write config
		$bindconf_file_handler = fopen(makeCorrectFile(Settings::Get('system.bindconf_directory') . '/froxlor_bind.conf'), 'w');
		fwrite($bindconf_file_handler, $bindconf_file);
		fclose($bindconf_file_handler);
		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'froxlor_bind.conf written');

		// reload Bind
		safe_exec(escapeshellcmd(Settings::Get('system.bindreload_command')));
		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Bind9 reloaded');
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
					safe_exec("chmod 0664 " . escapeshellarg($pubkey_filename));
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

	private function _generateDomainConfig($domain = array())
	{
		$this->_logger->logAction(CRON_ACTION, LOG_DEBUG, 'Generating dns config for ' . $domain['domain']);

		$bindconf_file = '# Domain ID: ' . $domain['id'] . ' - CustomerID: ' . $domain['customerid'] . ' - CustomerLogin: ' . $domain['loginname'] . "\n";
		$bindconf_file .= 'zone "' . $domain['domain'] . '" in {' . "\n";
		$bindconf_file .= '	type master;' . "\n";
		$bindconf_file .= '	file "' . makeCorrectFile(Settings::Get('system.bindconf_directory') . '/' . $domain['zonefile']) . '";' . "\n";
		$bindconf_file .= '	allow-query { any; };' . "\n";

		if (count($this->_ns) > 0 || count($this->_axfr) > 0) {
			// open allow-transfer
			$bindconf_file .= '	allow-transfer {' . "\n";
			// put nameservers in allow-transfer
			if (count($this->_ns) > 0) {
				foreach ($this->_ns as $ns) {
					foreach ($ns["ips"] as $ip) {
						$bindconf_file .= '		' . $ip . ";\n";
					}
				}
			}
			// AXFR server #100
			if (count($this->_axfr) > 0) {
				foreach ($this->_axfr as $axfrserver) {
					if (validate_ip($axfrserver, true) !== false) {
						$bindconf_file .= '		' . $axfrserver . ';' . "\n";
					}
				}
			}
			// close allow-transfer
			$bindconf_file .= '	};' . "\n";
		}

		$bindconf_file .= '};' . "\n";
		$bindconf_file .= "\n";

		return $bindconf_file;
	}

	private function _cleanZonefiles()
	{
		$config_dir = makeCorrectFile(Settings::Get('system.bindconf_directory') . '/domains/');

		$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'Cleaning dns zone files from ' . $config_dir);

		// check directory
		if (@is_dir($config_dir)) {

			// create directory iterator
			$its = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($config_dir));

			// iterate through all subdirs, look for zone files and delete them
			foreach ($its as $it) {
				if ($it->isFile()) {
					// remove file
					safe_exec('rm -f ' . escapeshellarg(makeCorrectFile($its->getPathname())));
				}
			}
		}
	}
}
