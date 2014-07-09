<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2014- the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Aders <eleras@froxlor.org>
 * @author     Froxlor team <team@froxlor.org> (2014-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Integrity
 *
 * IntegrityCheck - class 
 */

class IntegrityCheck {

	// Store all available checks
	public $available = array();

	/**
	 * Constructor
	 * Parses all available checks into $this->available 
	 */
	public function __construct() {
		$this->available = get_class_methods($this);
		unset($this->available[array_search('__construct', $this->available)]);
		unset($this->available[array_search('checkAll', $this->available)]);
		unset($this->available[array_search('fixAll', $this->available)]);
		sort($this->available);
		
	}

	/**
	 * Check all occuring integrity problems at once
	 */
	public function checkAll() {
		$integrityok = true;
		foreach ($this->available as $check) {
			$integrityok = $this->$check() ? $integrityok : false;
		}
		return $integrityok;
	}

	/**
	 * Fix all occuring integrity problems at once with default settings
	 */
	public function fixAll() {
		$integrityok = true;
		foreach ($this->available as $check) {
			$integrityok = $this->$check(true) ? $integrityok : false;
		}
		return $integrityok;
	}

	/**
	 * Check the integrity of the domain to ip/port - association
	 * @param $fix Fix everything found directly
	 */
	public function DomainIpTable($fix = false) {
		$ips = array();
		$domains = array();
		$ipstodomains = array();
		$admips = array();

		if ($fix) {
			// Prepare insert / delete statement for the fixes
			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_DOMAINTOIP . "`
				WHERE `id_domain` = :domainid AND `id_ipandports` = :ipandportid "
			);
			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_DOMAINTOIP . "`
				SET `id_domain` = :domainid, `id_ipandports` = :ipandportid "
			);

			// Cache all IPs the admins have assigned
			$adm_stmt = Database::prepare("SELECT `adminid`, `ip` FROM `" . TABLE_PANEL_ADMINS . "` ORDER BY `adminid` ASC");
			Database::pexecute($adm_stmt);
			while ($row = $adm_stmt->fetch(PDO::FETCH_ASSOC)) {
				if ($row['ip'] < 0 || is_null($row['ip']) || empty($row['ip'])) {
					// Admin uses default-IP
					$admips[$row['adminid']] = Settings::Get('system.defaultip');
				} else {
					$admips[$row['adminid']] = $row['ip'];
				}
			}
		}

		// Cache all available ip/port - combinations
		$result_stmt = Database::prepare("SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `id` ASC");
		Database::pexecute($result_stmt);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$ips[$row['id']] = $row['ip'] . ':' . $row['port'];
		}
		
		// Cache all configured domains
		$result_stmt = Database::prepare("SELECT `id`, `adminid` FROM `" . TABLE_PANEL_DOMAINS . "` ORDER BY `id` ASC");
		Database::pexecute($result_stmt);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$domains[$row['id']] = $row['adminid'];
		}
		
		// Check if every domain to ip/port - association is valid in TABLE_DOMAINTOIP
		$result_stmt = Database::prepare("SELECT `id_domain`, `id_ipandports` FROM `" . TABLE_DOMAINTOIP . "`");
		Database::pexecute($result_stmt);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (!array_key_exists($row['id_ipandports'], $ips)) { 
				if ($fix) {
					Database::pexecute($del_stmt, array('domainid' => $row['id_domain'], 'ipandportid' => $row['id_ipandports']));
				} else {
					return false;
				}
			}
			if (!array_key_exists($row['id_domain'], $domains)) {
				if ($fix) {
					Database::pexecute($del_stmt, array('domainid' => $row['id_domain'], 'ipandportid' => $row['id_ipandports']));
				} else {
					return false; 
				}
			}
			// Save one IP/Port combination per domain, so we know, if one domain is missing an IP
			$ipstodomains[$row['id_domain']] = $row['id_ipandports'];
		}
		
		// Check that all domains have at least one IP/Port combination
		foreach ($domains as $domainid => $adminid) {
			if (!array_key_exists($domainid, $ipstodomains)) {
				if ($fix) {
					Database::pexecute($ins_stmt, array('domainid' => $domainid, 'ipandportid' => $admips[$adminid]));
				} else {
					return false;
				}
			}
		}

		if ($fix) {
			return $this->DomainIpTable();
		} else {
			return true;
		}
	}

	/**
	 * Check if all subdomain have ssl-redirect = 0 if domain has no ssl-port
	 * @param $fix Fix everything found directly
	 */
	public function SubdomainSslRedirect($fix = false) {
		$ips = array();
		$parentdomains = array();
		$subdomains = array();

		if ($fix) {
			// Prepare update statement for the fixes
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_DOMAINS . "`
				SET `ssl_redirect` = 0 WHERE `parentdomainid` = :domainid"
			);
		}

		// Cache all ssl ip/port - combinations
		$result_stmt = Database::prepare("SELECT `id`, `ip`, `port` FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `ssl` = 1 ORDER BY `id` ASC");
		Database::pexecute($result_stmt);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$ips[$row['id']] = $row['ip'] . ':' . $row['port'];
		}
		
		// Cache all configured domains
		$result_stmt = Database::prepare("SELECT `id`, `parentdomainid`, `ssl_redirect` FROM `" . TABLE_PANEL_DOMAINS . "` ORDER BY `id` ASC");
		$ip_stmt = Database::prepare("SELECT `id_domain`, `id_ipandports` FROM `" . TABLE_DOMAINTOIP . "` WHERE `id_domain` = :domainid");
		Database::pexecute($result_stmt);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($row['parentdomainid'] == 0) {
				// All parentdomains by default have no ssl - ip/port
				$parentdomains[$row['id']] = false;
				Database::pexecute($ip_stmt, array('domainid' => $row['id']));
				while ($iprow = $ip_stmt->fetch(PDO::FETCH_ASSOC)) {
					// If the parentdomain has an ip/port assigned which we know is SSL enabled, set the parentdomain to "true"
					if (array_key_exists($iprow['id_ipandports'], $ips)) { $parentdomains[$row['id']] = true; } 
				}
			} elseif ($row['ssl_redirect'] == 1)  {
				// All subdomains with enabled ssl_redirect enabled are stored
				if (!isset($subdomains[$row['parentdomainid']])) { $subdomains[$row['parentdomainid']] = array(); }
				$subdomains[$row['parentdomainid']][] = $row['id'];
			}
		}
		
		// Check if every parentdomain with enabled ssl_redirect as SSL enabled
		foreach ($parentdomains as $id => $sslavailable) {
			// This parentdomain has no subdomains
			if (!isset($subdomains[$id])) { continue; }
			// This parentdomain has SSL enabled, doesn't matter what status the subdomains have
			if ($sslavailable) { continue; }
			
			// At this point only parentdomains reside which have ssl_redirect enabled subdomains
			if ($fix) {
				// We make a blanket update to all subdomains of this parentdomain, doesn't matter which one is wrong, all have to be disabled
				Database::pexecute($upd_stmt, array('domainid' => $id));
			} else {
				// It's just the check, let the function fail
				return false;
			}
		}
		
		if ($fix) {
			return $this->SubdomainSslRedirect();
		} else {
			return true;
		}
	}
}
