<?php

/***
 * Class DnsBase
 *
 * Base class for all DNS server configs
 *
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

	protected function getDomainList()
	{
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
			$this->_logger->logAction(CRON_ACTION, LOG_INFO, 'No domains found for nameserver-config, skipping...');
			return null;
		}

		return $domains;
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
}
