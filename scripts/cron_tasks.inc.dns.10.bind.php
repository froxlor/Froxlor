<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @author     Martin Burchert <eremit@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    System
 * @version    $Id: cron_tasks.inc.dns.10.bind.php 2692 2009-03-27 18:04:47Z flo $
 */

/*
 * This script creates the php.ini's used by mod_suPHP+php-cgi
 */

if(@php_sapi_name() != 'cli'
   && @php_sapi_name() != 'cgi'
   && @php_sapi_name() != 'cgi-fcgi')
{
	die('This script only works in the shell.');
}

class bind
{
	public $db = false;
	public $logger = false;
	public $debugHandler = false;
	public $settings = array();
	public $nameservers = array();
	public $mxservers = array();

	public function __construct($db, $logger, $debugHandler, $settings)
	{
		$this->db = $db;
		$this->logger = $logger;
		$this->debugHandler = $debugHandler;
		$this->settings = $settings;

		if($this->settings['system']['nameservers'] != '')
		{
			$nameservers = explode(',', $this->settings['system']['nameservers']);
			foreach($nameservers as $nameserver)
			{
				$nameserver_ip = gethostbyname(trim($nameserver));

				if(substr($nameserver, -1, 1) != '.')
				{
					$nameserver.= '.';
				}

				$this->nameservers[] = array(
					'hostname' => trim($nameserver),
					'ip' => trim($nameserver_ip)
				);
			}
		}

		if($this->settings['system']['mxservers'] != '')
		{
			$mxservers = explode(',', $this->settings['system']['mxservers']);
			foreach($mxservers as $mxserver)
			{
				if(substr($mxserver, -1, 1) != '.')
				{
					$mxserver.= '.';
				}

				$this->mxservers[] = $mxserver;
			}
		}
	}

	public function writeConfigs()
	{
		fwrite($this->debugHandler, '  cron_tasks: Task4 started - Rebuilding syscp_bind.conf' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'Task4 started - Rebuilding syscp_bind.conf');

		if(!file_exists(makeCorrectDir($this->settings['system']['bindconf_directory'] . '/domains/')))
		{
			$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['bindconf_directory'] . '/domains/')));
			safe_exec('mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['bindconf_directory'] . '/domains/')));
		}

		$known_filenames = array();

		$bindconf_file = '# ' . $this->settings['system']['bindconf_directory'] . 'syscp_bind.conf' . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n";
		$result_domains = $this->db->query("SELECT `d`.`id`, `d`.`domain`, `d`.`iswildcarddomain`, `d`.`customerid`, `d`.`zonefile`, `d`.`bindserial`, `d`.`dkim`, `d`.`dkim_id`, `d`.`dkim_pubkey`, `ip`.`ip`, `c`.`loginname`, `c`.`guid` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`) LEFT JOIN `" . TABLE_PANEL_IPSANDPORTS . "` AS `ip` ON(`d`.`ipandport`=`ip`.`id`) WHERE `d`.`isbinddomain` = '1' ORDER BY `d`.`domain` ASC");

		while($domain = $this->db->fetch_array($result_domains))
		{
			fwrite($this->debugHandler, '  cron_tasks: Task4 - Writing ' . $domain['id'] . '::' . $domain['domain'] . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'Writing ' . $domain['id'] . '::' . $domain['domain']);

			if($domain['zonefile'] == '')
			{
				$zonefile = $this->generateZone($domain);
				$domain['zonefile'] = 'domains/' . $domain['domain'] . '.zone';
				$zonefile_name = makeCorrectFile($this->settings['system']['bindconf_directory'] . '/' . $domain['zonefile']);
				$known_filenames[] = basename($zonefile_name);
				$zonefile_handler = fopen($zonefile_name, 'w');
				fwrite($zonefile_handler, $zonefile);
				fclose($zonefile_handler);
				fwrite($this->debugHandler, '  cron_tasks: Task4 - `' . $zonefile_name . '` zone written' . "\n");
			}

			$bindconf_file.= '# Domain ID: ' . $domain['id'] . ' - CustomerID: ' . $domain['customerid'] . ' - CustomerLogin: ' . $domain['loginname'] . "\n";
			$bindconf_file.= 'zone "' . $domain['domain'] . '" in {' . "\n";
			$bindconf_file.= '	type master;' . "\n";
			$bindconf_file.= '	file "' . makeCorrectFile($this->settings['system']['bindconf_directory'] . '/' . $domain['zonefile']) . '";' . "\n";
			$bindconf_file.= '	allow-query { any; };' . "\n";

			if(count($this->nameservers) > 0)
			{
				$bindconf_file.= '	allow-transfer {' . "\n";
				for ($i = 0;$i < count($this->nameservers);$i++)
				{
					$bindconf_file.= '		' . $this->nameservers[$i]['ip'] . ';' . "\n";
				}

				$bindconf_file.= '	};' . "\n";
			}

			$bindconf_file.= '};' . "\n";
			$bindconf_file.= "\n";
		}

		$bindconf_file_handler = fopen(makeCorrectFile($this->settings['system']['bindconf_directory'] . '/syscp_bind.conf'), 'w');
		fwrite($bindconf_file_handler, $bindconf_file);
		fclose($bindconf_file_handler);
		fwrite($this->debugHandler, '  cron_tasks: Task4 - syscp_bind.conf written' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'syscp_bind.conf written');
		safe_exec($this->settings['system']['bindreload_command']);
		fwrite($this->debugHandler, '  cron_tasks: Task4 - Bind9 reloaded' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'Bind9 reloaded');
		$domains_dir = makeCorrectDir($this->settings['system']['bindconf_directory'] . '/domains/');

		if(file_exists($domains_dir)
		   && is_dir($domains_dir))
		{
			$domain_file_dirhandle = opendir($domains_dir);

			while(false !== ($domain_filename = readdir($domain_file_dirhandle)))
			{
				if($domain_filename != '.'
				   && $domain_filename != '..'
				   && !in_array($domain_filename, $known_filenames)
				   && file_exists(makeCorrectFile($domains_dir . '/' . $domain_filename)))
				{
					fwrite($this->debugHandler, '  cron_tasks: Task4 - unlinking ' . $domain_filename . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_WARNING, 'Deleting ' . $domain_filename);
					unlink(makeCorrectFile($domains_dir . '/' . $domain_filename));
				}
			}
		}
	}

	protected function generateZone($domain)
	{
		if(filter_var($domain['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
		{
			$ip_a_record = 'A	' . $domain['ip'];
		}
		elseif(filter_var($domain['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
		{
			$ip_a_record = 'AAAA	' . $domain['ip'];
		}
		else
		{
			return '';
		}

		$date = date('Ymd');
		$bindserial = (preg_match('/^' . $date . '/', $domain['bindserial']) ? $domain['bindserial'] + 1 : $date . '00');
		$this->db->query('UPDATE `' . TABLE_PANEL_DOMAINS . '` SET `bindserial`=\'' . $bindserial . '\' WHERE `id`=\'' . $domain['id'] . '\'');
		$zonefile = '$TTL 1W' . "\n";

		if(count($this->nameservers) == 0)
		{
			$zonefile.= '@ IN SOA ns ' . str_replace('@', '.', $this->settings['panel']['adminmail']) . '. (' . "\n";
		}
		else
		{
			$zonefile.= '@ IN SOA ' . $this->nameservers[0]['hostname'] . ' ' . str_replace('@', '.', $this->settings['panel']['adminmail']) . '. (' . "\n";
		}

		$zonefile.= '	' . $bindserial . ' ; serial' . "\n" . '	8H ; refresh' . "\n" . '	2H ; retry' . "\n" . '	1W ; expiry' . "\n" . '	11h) ; minimum' . "\n";

		if(count($this->nameservers) == 0)
		{
			$zonefile.= '@	IN	NS	ns' . "\n" . 'ns	IN	' . $ip_a_record . "\n";
		}
		else
		{
			foreach($this->nameservers as $nameserver)
			{
				$zonefile.= '@	IN	NS	' . trim($nameserver['hostname']) . "\n";
			}
		}

		if(count($this->mxservers) == 0)
		{
			$zonefile.= '@	IN	MX	10 mail' . "\n" . 'mail	IN	' . $ip_a_record . "\n";
		}
		else
		{
			foreach($this->mxservers as $mxserver)
			{
				$zonefile.= '@	IN	MX	' . trim($mxserver) . "\n";
			}
		}

		$zonefile.= '@	IN	TXT	"v=spf1 a mx -all"' . "\n";

		if($this->settings['dkim']['use_dkim'] == '1'
		   && $domain['dkim'] == '1'
		   && $domain['dkim_pubkey'] != '')
		{
			$zonefile.= 'dkim_' . $domain['dkim_id'] . '._domainkey	IN	TXT	"v=DKIM1; k=rsa; p=' . trim(preg_replace('/-----BEGIN PUBLIC KEY-----(.+)-----END PUBLIC KEY-----/s', '$1', str_replace("\n", '', $domain['dkim_pubkey']))) . '"' . "\n";
		}

		$nssubdomains = $this->db->query('SELECT `domain` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `isbinddomain`=\'1\' AND `domain` LIKE \'%.' . $domain['domain'] . '\'');

		while($nssubdomain = $this->db->fetch_array($nssubdomains))
		{
			if(preg_match('/^[^\.]+\.' . preg_quote($domain['domain'], '/') . '/', $nssubdomain['domain']))
			{
				$nssubdomain = str_replace('.' . $domain['domain'], '', $nssubdomain['domain']);

				if(count($this->nameservers) == 0)
				{
					$zonefile.= $nssubdomain . '	IN	NS	ns.' . $nssubdomain . "\n";
				}
				else
				{
					foreach($this->nameservers as $nameserver)
					{
						$zonefile.= $nssubdomain . '	IN	NS	' . trim($nameserver['hostname']) . "\n";
					}
				}
			}
		}

		$zonefile.= '@	IN	' . $ip_a_record . "\n";
		$zonefile.= 'www	IN	' . $ip_a_record . "\n";

		if($domain['iswildcarddomain'] == '1')
		{
			$zonefile.= '*	IN  ' . $ip_a_record . "\n";
		}

		$subdomains = $this->db->query('SELECT `d`.`domain`, `ip`.`ip` AS `ip` FROM `' . TABLE_PANEL_DOMAINS . '` `d`, `' . TABLE_PANEL_IPSANDPORTS . '` `ip` WHERE `parentdomainid`=\'' . $domain['id'] . '\' AND `d`.`ipandport`=`ip`.`id`');

		while($subdomain = $this->db->fetch_array($subdomains))
		{
			$zonefile.= str_replace('.' . $domain['domain'], '', $subdomain['domain']) . '	IN	A	' . $subdomain['ip'] . "\n";
		}

		return $zonefile;
	}

	public function writeDKIMconfigs()
	{
		if($this->settings['dkim']['use_dkim'] == '1')
		{
			if(!file_exists(makeCorrectDir($this->settings['dkim']['dkim_prefix'])))
			{
				$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir -p ' . escapeshellarg(makeCorrectDir($this->settings['dkim']['dkim_prefix'])));
				safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir($this->settings['dkim']['dkim_prefix'])));
			}

			$dkimdomains = '';
			$dkimkeys = '';
			$result_domains = $this->db->query("SELECT `id`, `domain`, `dkim`, `dkim_id`, `dkim_pubkey`, `dkim_privkey` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `dkim` = '1' ORDER BY `id` ASC");

			while($domain = $this->db->fetch_array($result_domains))
			{
				$privkey_filename = makeCorrectFile($this->settings['dkim']['dkim_prefix'] . '/dkim_' . $domain['dkim_id'] . '.private');
				$pubkey_filename = makeCorrectFile($this->settings['dkim']['dkim_prefix'] . '/dkim_' . $domain['dkim_id'] . '.public');

				if($domain['dkim_privkey'] == ''
				   || $domain['dkim_pubkey'] == '')
				{
					$max_dkim_id = $this->db->query_first("SELECT MAX(`dkim_id`) as `max_dkim_id` FROM `" . TABLE_PANEL_DOMAINS . "`");
					$domain['dkim_id'] = (int)$max_dkim_id['max_dkim_id'] + 1;
					$privkey_filename = makeCorrectFile($this->settings['dkim']['dkim_prefix'] . '/dkim_' . $domain['dkim_id'] . '.private');
					safe_exec('openssl genrsa -out ' . escapeshellcmd($privkey_filename) . ' 1024');
					$domain['dkim_privkey'] = file_get_contents($privkey_filename);
					safe_exec("chmod 0640 " . escapeshellcmd($privkey_filename));
					$pubkey_filename = makeCorrectFile($this->settings['dkim']['dkim_prefix'] . '/dkim_' . $domain['dkim_id'] . '.public');
					safe_exec('openssl rsa -in ' . escapeshellcmd($privkey_filename) . ' -pubout -outform pem -out ' . escapeshellcmd($pubkey_filename));
					$domain['dkim_pubkey'] = file_get_contents($pubkey_filename);
					safe_exec("chmod 0664 " . escapeshellcmd($pubkey_filename));
					$this->db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `dkim_id` = '" . $domain['dkim_id'] . "', `dkim_privkey` = '" . $domain['dkim_privkey'] . "', `dkim_pubkey` = '" . $domain['dkim_pubkey'] . "' WHERE `id` = '" . $domain['id'] . "'");
				}

				if(!file_exists($privkey_filename)
				   && $domain['dkim_privkey'] != '')
				{
					$privkey_file_handler = fopen($privkey_filename, "w");
					fwrite($privkey_file_handler, $domain['dkim_privkey']);
					fclose($privkey_file_handler);
					safe_exec("chmod 0640 " . escapeshellcmd($privkey_filename));
				}

				if(!file_exists($pubkey_filename)
				   && $domain['dkim_pubkey'] != '')
				{
					$pubkey_file_handler = fopen($pubkey_filename, "w");
					fwrite($pubkey_file_handler, $domain['dkim_pubkey']);
					fclose($pubkey_file_handler);
					safe_exec("chmod 0664 " . escapeshellcmd($pubkey_filename));
				}

				$dkimdomains.= $domain['domain'] . "\n";
				$dkimkeys.= "*@" . $domain['domain'] . ":" . $domain['domain'] . ":" . $privkey_filename . "\n";
			}

			$dkimdomains_filename = makeCorrectFile($this->settings['dkim']['dkim_prefix'] . '/' . $this->settings['dkim']['dkim_domains']);
			$dkimdomains_file_handler = fopen($dkimdomains_filename, "w");
			fwrite($dkimdomains_file_handler, $dkimdomains);
			fclose($dkimdomains_file_handler);
			$dkimkeys_filename = makeCorrectFile($this->settings['dkim']['dkim_prefix'] . '/' . $this->settings['dkim']['dkim_dkimkeys']);
			$dkimkeys_file_handler = fopen($dkimkeys_filename, "w");
			fwrite($dkimkeys_file_handler, $dkimkeys);
			fclose($dkimkeys_file_handler);
		}
	}
}

?>