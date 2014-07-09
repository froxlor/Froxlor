<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 */

class bind {
	public $logger = false;
	public $debugHandler = false;
	public $nameservers = array();
	public $mxservers = array();
	public $axfrservers = array();

	private $_known_filenames = array();

	public function __construct($logger, $debugHandler) {

		$this->logger = $logger;
		$this->debugHandler = $debugHandler;

		if (Settings::Get('system.nameservers') != '') {
			$nameservers = explode(',', Settings::Get('system.nameservers'));
			foreach ($nameservers as $nameserver) {
				$nameserver_ip = gethostbyname(trim($nameserver));
				if (substr($nameserver, -1, 1) != '.') {
					$nameserver.= '.';
				}
				$this->nameservers[] = array(
					'hostname' => trim($nameserver),
					'ip' => trim($nameserver_ip)
				);
			}
		}

		if (Settings::Get('system.mxservers') != '') {
			$mxservers = explode(',', Settings::Get('system.mxservers'));
			foreach ($mxservers as $mxserver) {
				if (substr($mxserver, -1, 1) != '.') {
					$mxserver.= '.';
				}
				$this->mxservers[] = $mxserver;
			}
		}

		// AXFR server #100
		if (Settings::Get('system.axfrservers') != '') {
			$axfrservers = explode(',', Settings::Get('system.axfrservers'));
			foreach ($axfrservers as $axfrserver) {
				$this->axfrservers[] = trim($axfrserver);
			}
		}
	}


	public function writeConfigs() {
		fwrite($this->debugHandler, '  cron_tasks: Task4 started - Rebuilding froxlor_bind.conf' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'Task4 started - Rebuilding froxlor_bind.conf');

		if (!file_exists(makeCorrectDir(Settings::Get('system.bindconf_directory') . '/domains/'))) {
			$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.bindconf_directory') . '/domains/')));
			safe_exec('mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.bindconf_directory') . '/domains/')));
		}

		$this->_known_filenames = array();

		$bindconf_file = '# ' . Settings::Get('system.bindconf_directory') . 'froxlor_bind.conf' . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n";
		$result_domains_stmt = Database::query("
			SELECT `d`.`id`, `d`.`domain`, `d`.`iswildcarddomain`, `d`.`wwwserveralias`, `d`.`customerid`, `d`.`zonefile`, `d`.`bindserial`, `d`.`dkim`, `d`.`dkim_id`, `d`.`dkim_pubkey`, `c`.`loginname`, `c`.`guid`
			FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`)
			WHERE `d`.`isbinddomain` = '1' ORDER BY `d`.`domain` ASC
		");

		// customer-domains
		while ($domain = $result_domains_stmt->fetch(PDO::FETCH_ASSOC)) {
			$bindconf_file .= $this->_generateDomainConfig($domain);
		}

		// frolxor-hostname (#1090)
		if (Settings::get('system.dns_createhostnameentry') == 1) {
			$hostname_arr = array(
				'id' => 'none',
				'domain' => Settings::Get('system.hostname'),
				'customerid' => 'none',
				'loginname' => 'froxlor.panel',
				'bindserial' => date('Ymd').'00',
				'dkim' => '0',
				'iswildcarddomain' => '1',
				'zonefile' => ''
			);
			$bindconf_file .= $this->_generateDomainConfig($hostname_arr, true);
		}

		$bindconf_file_handler = fopen(makeCorrectFile(Settings::Get('system.bindconf_directory') . '/froxlor_bind.conf'), 'w');
		fwrite($bindconf_file_handler, $bindconf_file);
		fclose($bindconf_file_handler);
		fwrite($this->debugHandler, '  cron_tasks: Task4 - froxlor_bind.conf written' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'froxlor_bind.conf written');
		safe_exec(escapeshellcmd(Settings::Get('system.bindreload_command')));
		fwrite($this->debugHandler, '  cron_tasks: Task4 - Bind9 reloaded' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'Bind9 reloaded');
		$domains_dir = makeCorrectDir(Settings::Get('system.bindconf_directory') . '/domains/');

		if (file_exists($domains_dir)
			&& is_dir($domains_dir)) {
			$domain_file_dirhandle = opendir($domains_dir);

			while (false !== ($domain_filename = readdir($domain_file_dirhandle))) {
				$full_filename = makeCorrectFile($domains_dir . '/' . $domain_filename);

				if ($domain_filename != '.'
					&& $domain_filename != '..'
					&& !in_array($domain_filename, $this->_known_filenames)
					&& is_file($full_filename)
					&& file_exists($full_filename)) {
					fwrite($this->debugHandler, '  cron_tasks: Task4 - unlinking ' . $domain_filename . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_WARNING, 'Deleting ' . $domain_filename);
					unlink(makeCorrectFile($domains_dir . '/' . $domain_filename));
				}
			}
		}
	}

	private function _generateDomainConfig($domain = array(), $froxlorhost = false) {

		$bindconf_file = '';

		fwrite($this->debugHandler, '  cron_tasks: Task4 - Writing ' . $domain['id'] . '::' . $domain['domain'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'Writing ' . $domain['id'] . '::' . $domain['domain']);

		if ($domain['zonefile'] == '') {
			$zonefile = $this->generateZone($domain, $froxlorhost);
			$domain['zonefile'] = 'domains/' . $domain['domain'] . '.zone';
			$zonefile_name = makeCorrectFile(Settings::Get('system.bindconf_directory') . '/' . $domain['zonefile']);
			$this->_known_filenames[] = basename($zonefile_name);
			$zonefile_handler = fopen($zonefile_name, 'w');
			fwrite($zonefile_handler, $zonefile);
			fclose($zonefile_handler);
			fwrite($this->debugHandler, '  cron_tasks: Task4 - `' . $zonefile_name . '` zone written' . "\n");
		}

		$bindconf_file.= '# Domain ID: ' . $domain['id'] . ' - CustomerID: ' . $domain['customerid'] . ' - CustomerLogin: ' . $domain['loginname'] . "\n";
		$bindconf_file.= 'zone "' . $domain['domain'] . '" in {' . "\n";
		$bindconf_file.= '	type master;' . "\n";
		$bindconf_file.= '	file "' . makeCorrectFile(Settings::Get('system.bindconf_directory') . '/' . $domain['zonefile']) . '";' . "\n";
		$bindconf_file.= '	allow-query { any; };' . "\n";

		if (count($this->nameservers) > 0
				|| count($this->axfrservers) > 0
		) {
			// open allow-transfer
			$bindconf_file.= '	allow-transfer {' . "\n";
			// put nameservers in allow-transfer
			if (count($this->nameservers) > 0) {
				foreach ($this->nameservers as $ns) {
					$bindconf_file.= '		' . $ns['ip'] . ';' . "\n";
				}
			}
			// AXFR server #100
			if (count($this->axfrservers) > 0) {
				foreach ($this->axfrservers as $axfrserver) {
					if (validate_ip($axfrserver, true) !== false) {
						$bindconf_file.= '		' . $axfrserver . ';' . "\n";
					}
				}
			}
			// close allow-transfer
			$bindconf_file.= '	};' . "\n";
		}

		$bindconf_file.= '};' . "\n";
		$bindconf_file.= "\n";

		return $bindconf_file;
	}

	/**
	 * generate bind zone content. If froxlorhost is true,
	 * we will use ALL available IP addresses
	 *
	 * @param array $domain
	 * @param boolean $froxlorhost
	 *
	 * @return string
	 */
	protected function generateZone($domain, $froxlorhost = false) {
		// Array to save all ips needed in the records (already including IN A/AAAA)
		$ip_a_records = array();
		// Array to save DNS records
		$records = array();

		$domainidquery = '';
		$query_params = array();
		if (!$froxlorhost) {

			$domainidquery = "`di`.`id_domain` = :domainid AND ";
			$query_params['domainid'] = $domain['id'];

			$result_ip_stmt = Database::prepare("
				SELECT `p`.`ip` AS `ip`
				FROM `".TABLE_PANEL_IPSANDPORTS."` `p`, `".TABLE_DOMAINTOIP."` `di`
				WHERE ".$domainidquery."`p`.`id` = `di`.`id_ipandports`
				GROUP BY `p`.`ip`;
			");
		} else {
			// use all available IP's for the froxlor-hostname
			$result_ip_stmt = Database::prepare("
				SELECT `ip` FROM `".TABLE_PANEL_IPSANDPORTS."` GROUP BY `ip`
			");
		}
		Database::pexecute($result_ip_stmt, $query_params);

		while ($ip = $result_ip_stmt->fetch(PDO::FETCH_ASSOC)) {

			if (filter_var($ip['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
				$ip_a_records[] = "A\t\t" . $ip['ip'];
			}
			elseif (filter_var($ip['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$ip_a_records[] = "AAAA\t\t" . $ip['ip'];
			}
			else {
				return ";Error in at least one IP Adress (".$ip['ip']."), could not create zonefile!";
			}
		}

		$date = date('Ymd');
		$bindserial = (preg_match('/^' . $date . '/', $domain['bindserial']) ? $domain['bindserial'] + 1 : $date . '00');

		if (!$froxlorhost) {
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
				`bindserial` = :serial
				 WHERE `id` = :id
			");
			Database::pexecute($upd_stmt, array('serial' => $bindserial, 'id' => $domain['id']));
		}

		$zonefile = '$TTL ' . (int)Settings::Get('system.defaultttl') . "\n";
		if (count($this->nameservers) == 0) {
			$zonefile.= '@ IN SOA ns ' . str_replace('@', '.', Settings::Get('panel.adminmail')) . '. (' . "\n";
		} else {
			$zonefile.= '@ IN SOA ' . $this->nameservers[0]['hostname'] . ' ' . str_replace('@', '.', Settings::Get('panel.adminmail')) . '. (' . "\n";
		}

		$zonefile.= '	' . $bindserial . ' ; serial' . "\n" . '	8H ; refresh' . "\n" . '	2H ; retry' . "\n" . '	1W ; expiry' . "\n" . '	11h) ; minimum' . "\n";

		// no nameservers given, use all if the A/AAAA entries
		if (count($this->nameservers) == 0) {
			$zonefile .= '@    IN    NS    ns' . "\n";
			foreach ($ip_a_records as $ip_a_record) {
				$zonefile .= 'ns    IN    ' . $ip_a_record . "\n";
			}
		} else {
			foreach ($this->nameservers as $nameserver) {
				$zonefile.= '@    IN    NS    ' . trim($nameserver['hostname']) . "\n";
			}
		}

		if (count($this->mxservers) == 0) {
			$zonefile.= '@	IN	MX	10 mail' . "\n";
			$records[] = 'mail';
			if ($domain['iswildcarddomain'] != '1') {
				$records[] = 'imap';
				$records[] = 'smtp';
				$records[] = 'pop3';
			}
		} else {
			foreach ($this->mxservers as $mxserver) {
				$zonefile.= '@    IN    MX    ' . trim($mxserver) . "\n";
			}

			if (Settings::Get('system.dns_createmailentry') == '1') {
				$records[] = 'mail';
				if ($domain['iswildcarddomain'] != '1') {
					$records[] = 'imap';
					$records[] = 'smtp';
					$records[] = 'pop3';
				}
			}
		}

		/*
		 * @TODO domain-based spf-settings
		*/
		if (Settings::Get('spf.use_spf') == '1'
			/*&& $domain['spf'] == '1' */
		) {
			$zonefile.= Settings::Get('spf.spf_entry') . "\n";
			if (in_array('mail', $records)) {
				$zonefile.= str_replace('@', 'mail', Settings::Get('spf.spf_entry')) . "\n";
			}
		}

		/**
		 * generate dkim-zone-entries
		 */
		$zonefile.= $this->generateDkim($domain);

		if (!$froxlorhost) {
			$nssubdomains_stmt = Database::prepare("
				SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "`
				WHERE `isbinddomain` = '1' AND `domain` LIKE :domain
			");
			Database::pexecute($nssubdomains_stmt, array('domain' => '%.' . $domain['domain']));

			while ($nssubdomain = $nssubdomains_stmt->fetch(PDO::FETCH_ASSOC)) {

				if (preg_match('/^[^\.]+\.' . preg_quote($domain['domain'], '/') . '/', $nssubdomain['domain'])) {

					$nssubdomain = str_replace('.' . $domain['domain'], '', $nssubdomain['domain']);

					if (count($this->nameservers) == 0) {
						$zonefile.= $nssubdomain . '	IN	NS	ns.' . $nssubdomain . "\n";
					} else {
						foreach ($this->nameservers as $nameserver) {
							$zonefile.= $nssubdomain . '	IN	NS	' . trim($nameserver['hostname']) . "\n";
						}
					}
				}
			}
		}

		$records[] = '@';
		$records[] = 'www';

		if ($domain['iswildcarddomain'] == '1') {
			$records[] = '*';
		}

		if (!$froxlorhost) {
			$subdomains_stmt = Database::prepare("
				SELECT `domain` FROM `".TABLE_PANEL_DOMAINS."`
				WHERE `parentdomainid` = :domainid
			");
			Database::pexecute($subdomains_stmt, array('domainid' => $domain['id']));

			while ($subdomain = $subdomains_stmt->fetch(PDO::FETCH_ASSOC)) {
				// Listing domains is enough as there currently is no support for choosing
				// different ips for a subdomain => use same IPs as toplevel
				$records[] = str_replace('.' . $domain['domain'], '', $subdomain['domain']);

				// Check whether to add a www.-prefix
				if ($domain['wwwserveralias'] == '1') {
					$records[] = 'www.'.str_replace('.' . $domain['domain'], '', $subdomain['domain']);
				}
			}
		}

		// Create DNS-Records for every name we have saved
		foreach ($records as $record) {
			// we create an entry for every ip we have saved
			foreach ($ip_a_records as $ip_a_record) {
				$zonefile.= $record . "\tIN\t" . $ip_a_record . "\n";
			}
		}

		return $zonefile;
	}


	private function generateDkim($domain) {
		$zone_dkim = '';

		if (Settings::Get('dkim.use_dkim') == '1'
			&& $domain['dkim'] == '1'
			&& $domain['dkim_pubkey'] != '') {
			// start
			$dkim_txt = 'v=DKIM1;';

			// algorithm
			$algorithm = explode(',', Settings::Get('dkim.dkim_algorithm'));
			$alg = '';
			foreach ($algorithm as $a) {
				if ($a == 'all') {
					break;
				} else {
					$alg.=$a.':';
				}
			}

			if ($alg != '') {
				$alg = substr($alg, 0, -1);
				$dkim_txt.= 'h='.$alg.';';
			}

			// notes
			if (trim(Settings::Get('dkim.dkim_notes') != '')) {
				$dkim_txt.= 'n='.trim(Settings::Get('dkim.dkim_notes')).';';
			}

			// key
			$dkim_txt.= 'k=rsa;p='.trim(preg_replace('/-----BEGIN PUBLIC KEY-----(.+)-----END PUBLIC KEY-----/s', '$1', str_replace("\n", '', $domain['dkim_pubkey']))).';';

			// service-type
			if (Settings::Get('dkim.dkim_servicetype') == '1') {
				$dkim_txt.= 's=email;';
			}

			// end-part
			$dkim_txt.='t=s';

			// split if necessary
			$txt_record_split='';
			$lbr=50;
			for ($pos=0; $pos<=strlen($dkim_txt)-1; $pos+=$lbr) {
				$txt_record_split.= (($pos==0) ? '("' : "\t\t\t\t\t \"") . substr($dkim_txt, $pos, $lbr) . (($pos>=strlen($dkim_txt)-$lbr) ? '")' : '"' ) ."\n";
			}

			// dkim-entry
			$zone_dkim .= 'dkim_' . $domain['dkim_id'] . '._domainkey IN TXT ' . $txt_record_split;

			// adsp-entry
			if (Settings::Get('dkim.dkim_add_adsp') == "1") {

				$zone_dkim .= '_adsp._domainkey IN TXT "dkim=';
				switch ((int)Settings::Get('dkim.dkim_add_adsppolicy')) {
				case 0:
					$zone_dkim .= 'unknown"'. "\n";
					break;
				case 1:
					$zone_dkim .= 'all"'. "\n";
					break;
				case 2:
					$zone_dkim .= 'discardable"'. "\n";
					break;
				}
			}
		}

		return $zone_dkim;
	}


	public function writeDKIMconfigs() {
		if (Settings::Get('dkim.use_dkim') == '1') {
			if (!file_exists(makeCorrectDir(Settings::Get('dkim.dkim_prefix')))) {
				$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir -p ' . escapeshellarg(makeCorrectDir(Settings::Get('dkim.dkim_prefix'))));
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

				if ($domain['dkim_privkey'] == ''
					|| $domain['dkim_pubkey'] == '') {
					$max_dkim_id_stmt = Database::query("SELECT MAX(`dkim_id`) as `max_dkim_id` FROM `" . TABLE_PANEL_DOMAINS . "`");
					$max_dkim_id = $max_dkim_id_stmt->fetch(PDO::FETCH_ASSOC);
					$domain['dkim_id'] = (int)$max_dkim_id['max_dkim_id'] + 1;
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

				if (!file_exists($privkey_filename)
					&& $domain['dkim_privkey'] != '') {
					$privkey_file_handler = fopen($privkey_filename, "w");
					fwrite($privkey_file_handler, $domain['dkim_privkey']);
					fclose($privkey_file_handler);
					safe_exec("chmod 0640 " . escapeshellarg($privkey_filename));
				}

				if (!file_exists($pubkey_filename)
					&& $domain['dkim_pubkey'] != '') {
					$pubkey_file_handler = fopen($pubkey_filename, "w");
					fwrite($pubkey_file_handler, $domain['dkim_pubkey']);
					fclose($pubkey_file_handler);
					safe_exec("chmod 0664 " . escapeshellarg($pubkey_filename));
				}

				$dkimdomains.= $domain['domain'] . "\n";
				$dkimkeys.= "*@" . $domain['domain'] . ":" . $domain['domain'] . ":" . $privkey_filename . "\n";
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
			fwrite($this->debugHandler, '  cron_tasks: Task4 - Dkim-milter reloaded' . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'Dkim-milter reloaded');
		}
	}
}
