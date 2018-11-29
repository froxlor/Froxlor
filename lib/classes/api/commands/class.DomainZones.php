<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    API
 * @since      0.10.0
 *
 */
class DomainZones extends ApiCommand implements ResourceEntity
{

	/**
	 * add a new dns zone for a given domain by id or domainname
	 *
	 * @param int $id
	 *        	optional domain id
	 * @param string $domainname
	 *        	optional domain name
	 * @param string $record
	 *        	optional, default empty
	 * @param string $type
	 *        	optional, zone-entry type (A, AAAA, TXT, etc.), default 'A'
	 * @param int $prio
	 *        	optional, priority, default empty
	 * @param string $content
	 *        	optional, default empty
	 * @param int $ttl
	 *        	optional, default 18000
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function add()
	{
		if (Settings::Get('system.dnsenabled') != '1') {
			throw new Exception("DNS server not enabled on this system", 405);
		}

		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		// get requested domain
		$result = $this->apiCall('SubDomains.get', array(
			'id' => $id,
			'domainname' => $domainname
		));
		$id = $result['id'];

		// parameters
		$record = $this->getParam('record', true, null);
		$type = $this->getParam('type', true, 'A');
		$prio = $this->getParam('prio', true, null);
		$content = $this->getParam('content', true, null);
		$ttl = $this->getParam('ttl', true, 18000);

		if ($result['parentdomainid'] != '0') {
			throw new Exception("DNS zones can only be generated for the main domain, not for subdomains", 406);
		}

		if ($result['subisbinddomain'] != '1') {
			standard_error('dns_domain_nodns', '', true);
		}

		$idna_convert = new idna_convert_wrapper();
		$domain = $idna_convert->encode($result['domain']);

		// select all entries
		$sel_stmt = Database::prepare("SELECT * FROM `" . TABLE_DOMAIN_DNS . "` WHERE domain_id = :did");
		Database::pexecute($sel_stmt, array(
			'did' => $id
		), true, true);
		$dom_entries = $sel_stmt->fetchAll(PDO::FETCH_ASSOC);

		// validation
		$errors = array();
		if (empty($record)) {
			$record = "@";
		}

		$record = trim(strtolower($record));

		if ($record != '@' && $record != '*') {
			// validate record
			if (strpos($record, '--') !== false) {
				$errors[] = $this->lng['error']['domain_nopunycode'];
			} else {
				// check for wildcard-record
				$add_wildcard_again = false;
				if (substr($record, 0, 2) == '*.') {
					$record = substr($record, 2);
					$add_wildcard_again = true;
				}
				// convert entry
				$record = $idna_convert->encode($record);

				if ($add_wildcard_again) {
					$record = '*.' . $record;
				}

				if (strlen($record) > 63) {
					$errors[] = $this->lng['error']['dns_record_toolong'];
				}
			}
		}

		// TODO regex validate content for invalid characters

		if ($ttl <= 0) {
			$ttl = 18000;
		}

		$content = trim($content);
		if (empty($content)) {
			$errors[] = $this->lng['error']['dns_content_empty'];
		}

		// types
		if ($type == 'A' && filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
			$errors[] = $this->lng['error']['dns_arec_noipv4'];
		} elseif ($type == 'AAAA' && filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
			$errors[] = $this->lng['error']['dns_aaaarec_noipv6'];
		} elseif ($type == 'MX') {
			if ($prio === null || $prio < 0) {
				$errors[] = $this->lng['error']['dns_mx_prioempty'];
			}
			// check for trailing dot
			if (substr($content, - 1) == '.') {
				// remove it for checks
				$content = substr($content, 0, - 1);
			}
			if (! validateDomain($content)) {
				$errors[] = $this->lng['error']['dns_mx_needdom'];
			} else {
				// check whether there is a CNAME-record for the same resource
				foreach ($dom_entries as $existing_entries) {
					$fqdn = $existing_entries['record'] . '.' . $domain;
					if ($existing_entries['type'] == 'CNAME' && $fqdn == $content) {
						$errors[] = $this->lng['error']['dns_mx_noalias'];
						break;
					}
				}
			}
			// append trailing dot (again)
			$content .= '.';
		} elseif ($type == 'CNAME') {
			// check for trailing dot
			if (substr($content, - 1) == '.') {
				// remove it for checks
				$content = substr($content, 0, - 1);
			} else {
				// add domain name
				$content .= '.' . $domain;
			}
			if (! validateDomain($content)) {
				$errors[] = $this->lng['error']['dns_cname_invaliddom'];
			} else {
				// check whether there are RR-records for the same resource
				foreach ($dom_entries as $existing_entries) {
					if (($existing_entries['type'] == 'A' || $existing_entries['type'] == 'AAAA' || $existing_entries['type'] == 'MX' || $existing_entries['type'] == 'NS') && $existing_entries['record'] == $record) {
						$errors[] = $this->lng['error']['dns_cname_nomorerr'];
						break;
					}
				}
			}
			// append trailing dot (again)
			$content .= '.';
		} elseif ($type == 'NS') {
			// check for trailing dot
			if (substr($content, - 1) == '.') {
				// remove it for checks
				$content = substr($content, 0, - 1);
			}
			if (! validateDomain($content)) {
				$errors[] = $this->lng['error']['dns_ns_invaliddom'];
			}
			// append trailing dot (again)
			$content .= '.';
		} elseif ($type == 'TXT' && ! empty($content)) {
			// check that TXT content is enclosed in " "
			$content = encloseTXTContent($content);
		} elseif ($type == 'SRV') {
			if ($prio === null || $prio < 0) {
				$errors[] = $this->lng['error']['dns_srv_prioempty'];
			}
			// check only last part of content, as it can look like:
			// _service._proto.name. TTL class SRV priority weight port target.
			$_split_content = explode(" ", $content);
			// SRV content must be [weight] [port] [target]
			if (count($_split_content) != 3) {
				$errors[] = $this->lng['error']['dns_srv_invalidcontent'];
			}
			$target = trim($_split_content[count($_split_content) - 1]);
			if ($target != '.') {
				// check for trailing dot
				if (substr($target, - 1) == '.') {
					// remove it for checks
					$target = substr($target, 0, - 1);
				}
			}
			if ($target != '.' && ! validateDomain($target)) {
				$errors[] = $this->lng['error']['dns_srv_needdom'];
			} else {
				// check whether there is a CNAME-record for the same resource
				foreach ($dom_entries as $existing_entries) {
					$fqdn = $existing_entries['record'] . '.' . $domain;
					if ($existing_entries['type'] == 'CNAME' && $fqdn == $target) {
						$errors[] = $this->lng['error']['dns_srv_noalias'];
						break;
					}
				}
			}
			// append trailing dot if there's none
			if (substr($content, - 1) != '.') {
				$content .= '.';
			}
		}

		$new_entry = array(
			'record' => $record,
			'type' => $type,
			'prio' => (int) $prio,
			'content' => $content,
			'ttl' => (int) $ttl,
			'domain_id' => (int) $id
		);
		ksort($new_entry);

		// check for duplicate
		foreach ($dom_entries as $existing_entry) {
			// compare json-encoded string of array
			$check_entry = $existing_entry;
			// new entry has no ID yet
			unset($check_entry['id']);
			// sort by key
			ksort($check_entry);
			// format integer fields to real integer (as they are read as string from the DB)
			$check_entry['prio'] = (int) $check_entry['prio'];
			$check_entry['ttl'] = (int) $check_entry['ttl'];
			$check_entry['domain_id'] = (int) $check_entry['domain_id'];
			// encode both
			$check_entry = json_encode($check_entry);
			$new = json_encode($new_entry);
			// compare
			if ($check_entry === $new) {
				$errors[] = $this->lng['error']['dns_duplicate_entry'];
				unset($check_entry);
				break;
			}
		}

		if (empty($errors)) {
			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_DOMAIN_DNS . "` SET
				`record` = :record,
				`type` = :type,
				`prio` = :prio,
				`content` = :content,
				`ttl` = :ttl,
				`domain_id` = :domain_id
			");
			Database::pexecute($ins_stmt, $new_entry, true, true);
			$new_entry_id = Database::lastInsertId();

			// add temporary to the entries-array (no reread of DB necessary)
			$new_entry['id'] = $new_entry_id;
			$dom_entries[] = $new_entry;

			// re-generate bind configs
			inserttask('4');

			$result = $this->apiCall('DomainZones.get', array(
				'id' => $id
			));
			return $this->response(200, "successfull", $result);
		}
		// return $errors
		throw new Exception(implode("\n", $errors));
	}

	/**
	 * return a domain-dns entry by either id or domainname
	 *
	 * @param int $id
	 *        	optional, the domain id
	 * @param string $domainname
	 *        	optional, the domain name
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		if (Settings::Get('system.dnsenabled') != '1') {
			throw new Exception("DNS server not enabled on this system", 405);
		}

		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		// get requested domain
		$result = $this->apiCall('SubDomains.get', array(
			'id' => $id,
			'domainname' => $domainname
		));
		$id = $result['id'];

		if ($result['parentdomainid'] != '0') {
			throw new Exception("DNS zones can only be generated for the main domain, not for subdomains", 406);
		}

		if ($result['subisbinddomain'] != '1') {
			standard_error('dns_domain_nodns', '', true);
		}

		$zone = createDomainZone($id);
		$zonefile = (string) $zone;

		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] get dns-zone for '" . $result['domain'] . "'");
		return $this->response(200, "successfull", explode("\n", $zonefile));
	}

	/**
	 * You cannot update a dns zone entry.
	 * You need to delete it and re-add it.
	 */
	public function update()
	{
		throw new Exception('You cannot update a dns zone entry. You need to delete it and re-add it.', 303);
	}

	/**
	 * You cannot list dns zones.
	 * To get all domains use Domains.listing() or SubDomains.listing()
	 */
	public function listing()
	{
		throw new Exception('You cannot list dns zones. To get all domains use Domains.listing() or SubDomains.listing()', 303);
	}

	/**
	 * deletes a domain-dns entry by id
	 *
	 * @param int $entry_id
	 * @param int $id
	 *        	optional, the domain id
	 * @param string $domainname
	 *        	optional, the domain name
	 *        	
	 * @access admin, customer
	 * @throws Exception
	 * @return bool
	 */
	public function delete()
	{
		if (Settings::Get('system.dnsenabled') != '1') {
			throw new Exception("DNS server not enabled on this system", 405);
		}

		$entry_id = $this->getParam('entry_id');
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		// get requested domain
		$result = $this->apiCall('SubDomains.get', array(
			'id' => $id,
			'domainname' => $domainname
		));
		$id = $result['id'];

		$del_stmt = Database::prepare("DELETE FROM `" . TABLE_DOMAIN_DNS . "` WHERE `id` = :id AND `domain_id` = :did");
		Database::pexecute($del_stmt, array(
			'id' => $entry_id,
			'did' => $id
		), true, true);
		if ($del_stmt->rowCount() > 0) {
			// re-generate bind configs
			inserttask('4');
			return $this->response(200, "successfull", true);
		}
		return $this->response(304, "successfull", true);
	}
}
