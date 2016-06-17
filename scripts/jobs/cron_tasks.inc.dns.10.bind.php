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
class bind extends DnsBase
{

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

		$domains = $this->getDomainList();

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
			$zone = createDomainZone(($domain['id'] == 'none') ? $domain : $domain['id'], $isFroxlorHostname);
			$zonefile = (string)$zone;
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
