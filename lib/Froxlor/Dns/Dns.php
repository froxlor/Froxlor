<?php
namespace Froxlor\Dns;

use Froxlor\Database\Database;
use Froxlor\Settings;

class Dns
{

	public static function getAllowedDomainEntry($domain_id, $area = 'customer', $userinfo = array())
	{
		$dom_data = array(
			'did' => $domain_id
		);

		$where_clause = '';
		if ($area == 'admin') {
			if ($userinfo['domains_see_all'] != '1') {
				$where_clause = '`adminid` = :uid AND ';
				$dom_data['uid'] = $userinfo['userid'];
			}
		} else {
			$where_clause = '`customerid` = :uid AND ';
			$dom_data['uid'] = $userinfo['userid'];
		}

		$dom_stmt = Database::prepare("
			SELECT domain, isbinddomain
			FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE " . $where_clause . " id = :did
		");
		$domain = Database::pexecute_first($dom_stmt, $dom_data);

		if ($domain) {
			if ($domain['isbinddomain'] != '1') {
				\Froxlor\UI\Response::standard_error('dns_domain_nodns');
			}
			$idna_convert = new \Froxlor\Idna\IdnaWrapper();
			return $idna_convert->decode($domain['domain']);
		}
		\Froxlor\UI\Response::standard_error('dns_notfoundorallowed');
	}

	public static function createDomainZone($domain_id, $froxlorhostname = false, $isMainButSubTo = false)
	{
		if (! $froxlorhostname) {
			// get domain-name
			$dom_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "` WHERE id = :did");
			$domain = Database::pexecute_first($dom_stmt, array(
				'did' => $domain_id
			));
		} else {
			$domain = $domain_id;
		}

		if ($domain['isbinddomain'] != '1') {
			return;
		}

		$dom_entries = array();
		if (! $froxlorhostname) {
			// select all entries
			$sel_stmt = Database::prepare("SELECT * FROM `" . TABLE_DOMAIN_DNS . "` WHERE domain_id = :did ORDER BY id ASC");
			Database::pexecute($sel_stmt, array(
				'did' => $domain_id
			));
			$dom_entries = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		// check for required records
		$required_entries = array();

		self::addRequiredEntry('@', 'A', $required_entries);
		self::addRequiredEntry('@', 'AAAA', $required_entries);
		if (! $isMainButSubTo) {
			self::addRequiredEntry('@', 'NS', $required_entries);
		}
		if ($domain['isemaildomain'] === '1') {
			self::addRequiredEntry('@', 'MX', $required_entries);
			if (Settings::Get('system.dns_createmailentry')) {
				foreach (array(
					'imap',
					'pop3',
					'mail',
					'smtp'
				) as $record) {
					foreach (array(
						'AAAA',
						'A'
					) as $type) {
						self::addRequiredEntry($record, $type, $required_entries);
					}
				}
			}
		}

		// additional required records by setting
		if ($domain['iswildcarddomain'] == '1') {
			self::addRequiredEntry('*', 'A', $required_entries);
			self::addRequiredEntry('*', 'AAAA', $required_entries);
		} elseif ($domain['wwwserveralias'] == '1') {
			self::addRequiredEntry('www', 'A', $required_entries);
			self::addRequiredEntry('www', 'AAAA', $required_entries);
		}

		if (! $froxlorhostname) {
			// additional required records for subdomains
			$subdomains_stmt = Database::prepare("
			SELECT `domain`, `iswildcarddomain`, `wwwserveralias` FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE `parentdomainid` = :domainid
		");
			Database::pexecute($subdomains_stmt, array(
				'domainid' => $domain_id
			));

			while ($subdomain = $subdomains_stmt->fetch(\PDO::FETCH_ASSOC)) {
				// Listing domains is enough as there currently is no support for choosing
				// different ips for a subdomain => use same IPs as toplevel
				self::addRequiredEntry(str_replace('.' . $domain['domain'], '', $subdomain['domain']), 'A', $required_entries);
				self::addRequiredEntry(str_replace('.' . $domain['domain'], '', $subdomain['domain']), 'AAAA', $required_entries);

				// Check whether to add a www.-prefix
				if ($subdomain['iswildcarddomain'] == '1') {
					self::addRequiredEntry('*.' . str_replace('.' . $domain['domain'], '', $subdomain['domain']), 'A', $required_entries);
					self::addRequiredEntry('*.' . str_replace('.' . $domain['domain'], '', $subdomain['domain']), 'AAAA', $required_entries);
				} elseif ($subdomain['wwwserveralias'] == '1') {
					self::addRequiredEntry('www.' . str_replace('.' . $domain['domain'], '', $subdomain['domain']), 'A', $required_entries);
					self::addRequiredEntry('www.' . str_replace('.' . $domain['domain'], '', $subdomain['domain']), 'AAAA', $required_entries);
				}
			}
		}

		// additional required records for CAA if activated
		if (Settings::Get('system.dns_createcaaentry') && Settings::Get('system.use_ssl') == "1" && !empty($domain['p_ssl_ipandports'])) {
			// check for CAA content later
			self::addRequiredEntry('@CAA@', 'CAA', $required_entries);
		}

		// additional required records for SPF and DKIM if activated
		if ($domain['isemaildomain'] == '1') {
			if (Settings::Get('spf.use_spf') == '1') {
				// check for SPF content later
				self::addRequiredEntry('@SPF@', 'TXT', $required_entries);
			}
			if (Settings::Get('dkim.use_dkim') == '1') {
				// check for DKIM content later
				self::addRequiredEntry('dkim' . $domain['dkim_id'] . '._domainkey', 'TXT', $required_entries);
			}
		}

		$primary_ns = null;
		$zonerecords = array();

		// now generate all records and unset the required entries we have
		foreach ($dom_entries as $entry) {
			if (array_key_exists($entry['type'], $required_entries) && array_key_exists(md5($entry['record']), $required_entries[$entry['type']])) {
				unset($required_entries[$entry['type']][md5($entry['record'])]);
			}
			if (Settings::Get('system.dns_createcaaentry') == '1' && $entry['type'] == 'CAA' && strtolower(substr($entry['content'], 0, 7)) == '"v=caa1') {
				// unset special CAA required-entry
				unset($required_entries[$entry['type']][md5("@CAA@")]);
			}
			if (Settings::Get('spf.use_spf') == '1' && $entry['type'] == 'TXT' && $entry['record'] == '@' && (strtolower(substr($entry['content'], 0, 7)) == '"v=spf1' || strtolower(substr($entry['content'], 0, 6)) == 'v=spf1') ) {
				// unset special spf required-entry
				unset($required_entries[$entry['type']][md5("@SPF@")]);
			}
			if (empty($primary_ns) && $entry['type'] == 'NS') {
				// use the first NS entry as primary ns
				$primary_ns = $entry['content'];
			}
			// check for CNAME on @, www- or wildcard-Alias and remove A/AAAA record accordingly
			foreach (['@', 'www', '*'] as $crceord) {
				if ($entry['type'] == 'CNAME' && $entry['record'] == '@' && (array_key_exists(md5($crceord), $required_entries['A']) || array_key_exists(md5($crceord), $required_entries['AAAA']))) {
					unset($required_entries['A'][md5($crceord)]);
					unset($required_entries['AAAA'][md5($crceord)]);
				}
			}
			$zonerecords[] = new DnsEntry($entry['record'], $entry['type'], $entry['content'], $entry['prio'], $entry['ttl']);
		}

		// add missing required entries
		if (! empty($required_entries)) {

			// A / AAAA records
			if (array_key_exists("A", $required_entries) || array_key_exists("AAAA", $required_entries)) {
				if ($froxlorhostname) {
					// use all available IP's for the froxlor-hostname
					$result_ip_stmt = Database::prepare("
					SELECT `ip` FROM `" . TABLE_PANEL_IPSANDPORTS . "` GROUP BY `ip`
				");
					Database::pexecute($result_ip_stmt);
				} else {
					$result_ip_stmt = Database::prepare("
					SELECT `p`.`ip` AS `ip`
					FROM `" . TABLE_PANEL_IPSANDPORTS . "` `p`, `" . TABLE_DOMAINTOIP . "` `di`
					WHERE `di`.`id_domain` = :domainid AND `p`.`id` = `di`.`id_ipandports`
					GROUP BY `p`.`ip`;
				");
					Database::pexecute($result_ip_stmt, array(
						'domainid' => $domain_id
					));
				}
				$all_ips = $result_ip_stmt->fetchAll(\PDO::FETCH_ASSOC);

				foreach ($all_ips as $ip) {
					foreach ($required_entries as $type => $records) {
						foreach ($records as $record) {
							if ($type == 'A' && filter_var($ip['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
								$zonerecords[] = new DnsEntry($record, 'A', $ip['ip']);
							} elseif ($type == 'AAAA' && filter_var($ip['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
								$zonerecords[] = new DnsEntry($record, 'AAAA', $ip['ip']);
							}
						}
					}
				}
				unset($required_entries['A']);
				unset($required_entries['AAAA']);
			}

			// NS records
			if (array_key_exists("NS", $required_entries)) {
				if (Settings::Get('system.nameservers') != '') {
					$nameservers = explode(',', Settings::Get('system.nameservers'));
					foreach ($nameservers as $nameserver) {
						$nameserver = trim($nameserver);
						// append dot to hostname
						if (substr($nameserver, - 1, 1) != '.') {
							$nameserver .= '.';
						}
						foreach ($required_entries as $type => $records) {
							if ($type == 'NS') {
								foreach ($records as $record) {
									if (empty($primary_ns)) {
										// use the first NS entry as primary ns
										$primary_ns = $nameserver;
									}
									$zonerecords[] = new DnsEntry($record, 'NS', $nameserver);
								}
							}
						}
					}
					unset($required_entries['NS']);
				}
			}

			// MX records
			if (array_key_exists("MX", $required_entries)) {
				if (Settings::Get('system.mxservers') != '') {
					$mxservers = explode(',', Settings::Get('system.mxservers'));
					foreach ($mxservers as $mxserver) {
						$mxserver = trim($mxserver);
						if (substr($mxserver, - 1, 1) != '.') {
							$mxserver .= '.';
						}
						// split in prio and server
						$mx_details = explode(" ", $mxserver);
						if (count($mx_details) == 1) {
							$mx_details[1] = $mx_details[0];
							$mx_details[0] = 10;
						}
						foreach ($required_entries as $type => $records) {
							if ($type == 'MX') {
								foreach ($records as $record) {
									$zonerecords[] = new DnsEntry($record, 'MX', $mx_details[1], $mx_details[0]);
								}
							}
						}
					}
					unset($required_entries['MX']);
				}
			}

			// TXT (SPF and DKIM)
			if (array_key_exists("TXT", $required_entries)) {

				if (Settings::Get('dkim.use_dkim') == '1') {
					$dkim_entries = self::generateDkimEntries($domain);
				}

				foreach ($required_entries as $type => $records) {
					if ($type == 'TXT') {
						foreach ($records as $record) {
							if ($record == '@SPF@') {
								$txt_content = Settings::Get('spf.spf_entry');
								$zonerecords[] = new DnsEntry('@', 'TXT', self::encloseTXTContent($txt_content));
							} elseif ($record == 'dkim' . $domain['dkim_id'] . '._domainkey' && ! empty($dkim_entries)) {
								// check for multiline entry
								$multiline = false;
								if (substr($dkim_entries[0], 0, 1) == '(') {
									$multiline = true;
								}
								$zonerecords[] = new DnsEntry($record, 'TXT', self::encloseTXTContent($dkim_entries[0], $multiline));
							}
						}
					}
				}
			}

			// CAA
			if (array_key_exists("CAA", $required_entries)) {
				foreach ($required_entries as $type => $records) {
					if ($type == 'CAA') {
						foreach ($records as $record) {
							if ($record == '@CAA@') {
								$caa_entries = explode(PHP_EOL, Settings::Get('caa.caa_entry'));
								if ($domain['letsencrypt'] == 1) {
									$le_entry = $domain['iswildcarddomain'] == '1' ? '0 issuewild "letsencrypt.org"' : '0 issue "letsencrypt.org"';
									array_push($caa_entries, $le_entry);
								}

								foreach ($caa_entries as $entry) {
									$zonerecords[] = new DnsEntry('@', 'CAA', $entry);
									// additional required records by subdomain setting
									if ($domain['wwwserveralias'] == '1') {
										$zonerecords[] = new DnsEntry('www', 'CAA', $entry);
									}
								}
							}
						}
					}
				}
			}
		}

		if (empty($primary_ns)) {
			// TODO log error: no NS given, use system-hostname
			$primary_ns = Settings::Get('system.hostname');
		}

		if (! $isMainButSubTo) {
			$date = date('Ymd');
			$domain['bindserial'] = (preg_match('/^' . $date . '/', $domain['bindserial']) ? $domain['bindserial'] + 1 : $date . '00');
			if (! $froxlorhostname) {
				$upd_stmt = Database::prepare("
					UPDATE `" . TABLE_PANEL_DOMAINS . "` SET
					`bindserial` = :serial
					 WHERE `id` = :id
				");
				Database::pexecute($upd_stmt, array(
					'serial' => $domain['bindserial'],
					'id' => $domain['id']
				));
			}

			// PowerDNS does not like multi-line-format
			$soa_content = $primary_ns . " " . self::escapeSoaAdminMail(Settings::Get('panel.adminmail')) . " ";
			$soa_content .= $domain['bindserial'] . " ";
			// TODO for now, dummy time-periods
			$soa_content .= "3600 900 604800 " . (int) Settings::Get('system.defaultttl');

			$soa_record = new DnsEntry('@', 'SOA', $soa_content);
			array_unshift($zonerecords, $soa_record);
		}

		$zone = new DnsZone((int) Settings::Get('system.defaultttl'), $domain['domain'], $domain['bindserial'], $zonerecords);

		return $zone;
	}

	private static function addRequiredEntry($record = '@', $type = 'A', &$required = array())
	{
		if (! isset($required[$type])) {
			$required[$type] = array();
		}
		$required[$type][md5($record)] = $record;
	}

	public static function encloseTXTContent($txt_content, $isMultiLine = false)
	{
		// check that TXT content is enclosed in " "
		if ($isMultiLine == false && Settings::Get('system.dns_server') != 'PowerDNS') {
			if (substr($txt_content, 0, 1) != '"') {
				$txt_content = '"' . $txt_content;
			}
			if (substr($txt_content, - 1) != '"') {
				$txt_content .= '"';
			}
		}
		if (Settings::Get('system.dns_server') == 'PowerDNS') {
			// no quotation for PowerDNS
			if (substr($txt_content, 0, 1) == '"') {
				$txt_content = substr($txt_content, 1);
			}
			if (substr($txt_content, - 1) == '"') {
				$txt_content = substr($txt_content, 0, - 1);
			}
		}
		return $txt_content;
	}

	private static function escapeSoaAdminMail($email)
	{
		$mail_parts = explode("@", $email);
		$escpd_mail = str_replace(".", "\.", $mail_parts[0]) . "." . $mail_parts[1] . ".";
		return $escpd_mail;
	}

	private static function generateDkimEntries($domain)
	{
		$zone_dkim = array();

		if (Settings::Get('dkim.use_dkim') == '1' && $domain['dkim'] == '1' && $domain['dkim_pubkey'] != '') {
			// start
			$dkim_txt = 'v=DKIM1;';

			// algorithm
			$algorithm = explode(',', Settings::Get('dkim.dkim_algorithm'));
			$alg = '';
			foreach ($algorithm as $a) {
				if ($a == 'all') {
					break;
				} else {
					$alg .= $a . ':';
				}
			}

			if ($alg != '') {
				$alg = substr($alg, 0, - 1);
				$dkim_txt .= 'h=' . $alg . ';';
			}

			// notes
			if (trim(Settings::Get('dkim.dkim_notes') != '')) {
				$dkim_txt .= 'n=' . trim(Settings::Get('dkim.dkim_notes')) . ';';
			}

			// key
			$dkim_txt .= 'k=rsa;p=' . trim(preg_replace('/-----BEGIN PUBLIC KEY-----(.+)-----END PUBLIC KEY-----/s', '$1', str_replace("\n", '', $domain['dkim_pubkey']))) . ';';

			// service-type
			if (Settings::Get('dkim.dkim_servicetype') == '1') {
				$dkim_txt .= 's=email;';
			}

			// end-part
			$dkim_txt .= 't=s';

			// dkim-entry
			$zone_dkim[] = $dkim_txt;
		}

		return $zone_dkim;
	}
}
