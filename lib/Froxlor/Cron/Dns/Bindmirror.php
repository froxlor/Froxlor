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

use Froxlor\Dns\Dns;
use Froxlor\FileDir;
use Froxlor\FroxlorLogger;
use Froxlor\Settings;

class Bindmirror extends DnsBase
{

	private $bindconf_file = "";

	public function writeConfigs()
	{
		// tell the world what we are doing
		$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'Task4 started - Rebuilding froxlor_bind.mirror.conf');

		$domains = $this->getDomainList();

		if (empty($domains)) {
			$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'No domains found for nameserver-config, skipping...');
			return;
		}

		$this->bindconf_file = '# ' . Settings::Get('system.bindmirrorconf_directory') . 'froxlor_bind.mirror.conf' . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n";
		$bindmasterservers = explode(',', Settings::Get('system.bindmasterservers'));
		if (!empty($bindmasterservers)) {
			$this->bindconf_file .= 'masters master { ' . implode('; ', $bindmasterservers) . '; };' . "\n\n";
		}

		foreach ($domains as $domain) {
			if ($domain['ismainbutsubto'] > 0) {
				// domains with ismainbutsubto>0 are handled by recursion within walkDomainList()
				continue;
			}
			$this->walkDomainList($domain, $domains);
		}

		$bindconf_file_handler = fopen(FileDir::makeCorrectFile(Settings::Get('system.bindmirrorconf_directory') . '/froxlor_bind.mirror.conf'), 'w');
		fwrite($bindconf_file_handler, $this->bindconf_file);
		fclose($bindconf_file_handler);
		$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'froxlor_bind.mirror.conf written');
		$this->reloadDaemon();
		$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'Task4 mirror finished');
	}

	private function walkDomainList($domain, $domains)
	{
		$zoneContent = '';
		$subzones = '';

		foreach ($domain['children'] as $child_domain_id) {
			$subzones .= $this->walkDomainList($domains[$child_domain_id], $domains);
		}

		if ($domain['zonefile'] == '') {
			// check for system-hostname
			$isFroxlorHostname = false;
			if (isset($domain['froxlorhost']) && $domain['froxlorhost'] == 1) {
				$isFroxlorHostname = true;
			}

			if ($domain['ismainbutsubto'] == 0) {
				$zoneContent = (string)Dns::createDomainZone(($domain['id'] == 'none') ? $domain : $domain['id'], $isFroxlorHostname);
				$this->bindconf_file .= $this->generateDomainConfig($domain);
			} else {
				return (string)Dns::createDomainZone(($domain['id'] == 'none') ? $domain : $domain['id'], $isFroxlorHostname, true);
			}
		} else {
			$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_INFO, 'Added zonefile ' . $domain['zonefile'] . ' for domain ' . $domain['domain'] . ' - Note that you will also have to handle ALL records for ALL subdomains.');
			$this->bindconf_file .= $this->generateDomainConfig($domain);
		}
	}

	private function generateDomainConfig($domain = [])
	{
		$this->logger->logAction(FroxlorLogger::CRON_ACTION, LOG_DEBUG, 'Generating dns mirror config for ' . $domain['domain']);

		$bindconf_file = '# Domain ID: ' . $domain['id'] . ' - CustomerID: ' . $domain['customerid'] . ' - CustomerLogin: ' . $domain['loginname'] . "\n";
		$bindconf_file .= 'zone "' . $domain['domain'] . '" in {' . "\n";
		$bindconf_file .= '	type slave;' . "\n";
		$bindconf_file .= '	file "' . $domain['domain'] . '.zone"' . ";\n";
		$bindconf_file .= '	masters { master; };' . "\n";
		$bindconf_file .= '};' . "\n";
		$bindconf_file .= "\n";

		return $bindconf_file;
	}
}
