<?php
namespace Froxlor\Api\Commands;

use Froxlor\Database\Database;
use Froxlor\Settings;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package API
 * @since 0.10.0
 *       
 */
class Certificates extends \Froxlor\Api\ApiCommand implements \Froxlor\Api\ResourceEntity
{

	/**
	 * add new ssl-certificate entry for given domain by either id or domainname
	 *
	 * @param int $id
	 *        	optional, the domain-id
	 * @param string $domainname
	 *        	optional, the domainname
	 * @param string $ssl_cert_file
	 * @param string $ssl_key_file
	 * @param string $ssl_ca_file
	 *        	optional
	 * @param string $ssl_cert_chainfile
	 *        	optional
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function add()
	{
		$domainid = $this->getParam('domainid', true, 0);
		$dn_optional = ($domainid <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'domains')) {
			throw new \Exception("You cannot access this resource", 405);
		}

		$domain = $this->apiCall('SubDomains.get', array(
			'id' => $domainid,
			'domainname' => $domainname
		));
		$domainid = $domain['id'];

		// parameters
		$ssl_cert_file = $this->getParam('ssl_cert_file');
		$ssl_key_file = $this->getParam('ssl_key_file');
		$ssl_ca_file = $this->getParam('ssl_ca_file', true, '');
		$ssl_cert_chainfile = $this->getParam('ssl_cert_chainfile', true, '');

		// validate whether the domain does not already have an entry
		$has_cert = true;
		try {
			$this->apiCall('Certificates.get', array(
				'id' => $domainid
			));
		} catch (\Exception $e) {
			if ($e->getCode() == 412) {
				$has_cert = false;
			} else {
				throw $e;
			}
		}
		if (! $has_cert) {
			$this->addOrUpdateCertificate($domain['id'], $ssl_cert_file, $ssl_key_file, $ssl_ca_file, $ssl_cert_chainfile, true);
			$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_INFO, "[API] added ssl-certificate for '" . $domain['domain'] . "'");
			$result = $this->apiCall('Certificates.get', array(
				'id' => $domain['id']
			));
			return $this->response(200, "successful", $result);
		}
		throw new \Exception("Domain '" . $domain['domain'] . "' already has a certificate. Did you mean to call update?", 406);
	}

	/**
	 * return ssl-certificate entry for given domain by either id or domainname
	 *
	 * @param int $id
	 *        	optional, the domain-id
	 * @param string $domainname
	 *        	optional, the domainname
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'domains')) {
			throw new \Exception("You cannot access this resource", 405);
		}

		$domain = $this->apiCall('SubDomains.get', array(
			'id' => $id,
			'domainname' => $domainname
		));
		$domainid = $domain['id'];

		$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid`= :domainid");
		$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_INFO, "[API] get ssl-certificate for '" . $domain['domain'] . "'");
		$result = Database::pexecute_first($stmt, array(
			"domainid" => $domainid
		));
		if (! $result) {
			throw new \Exception("Domain '" . $domain['domain'] . "' does not have a certificate.", 412);
		}
		return $this->response(200, "successful", $result);
	}

	/**
	 * update ssl-certificate entry for given domain by either id or domainname
	 *
	 * @param int $id
	 *        	optional, the domain-id
	 * @param string $domainname
	 *        	optional, the domainname
	 * @param string $ssl_cert_file
	 * @param string $ssl_key_file
	 * @param string $ssl_ca_file
	 *        	optional
	 * @param string $ssl_cert_chainfile
	 *        	optional
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function update()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'domains')) {
			throw new \Exception("You cannot access this resource", 405);
		}

		$domain = $this->apiCall('SubDomains.get', array(
			'id' => $id,
			'domainname' => $domainname
		));

		// parameters
		$ssl_cert_file = $this->getParam('ssl_cert_file');
		$ssl_key_file = $this->getParam('ssl_key_file');
		$ssl_ca_file = $this->getParam('ssl_ca_file', true, '');
		$ssl_cert_chainfile = $this->getParam('ssl_cert_chainfile', true, '');
		$this->addOrUpdateCertificate($domain['id'], $ssl_cert_file, $ssl_key_file, $ssl_ca_file, $ssl_cert_chainfile, false);
		$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_INFO, "[API] updated ssl-certificate for '" . $domain['domain'] . "'");
		$result = $this->apiCall('Certificates.get', array(
			'id' => $domain['id']
		));
		return $this->response(200, "successful", $result);
	}

	/**
	 * lists all certificate entries
	 *
	 * @param array $sql_search
	 *        	optional array with index = fieldname, and value = array with 'op' => operator (one of <, > or =), LIKE is used if left empty and 'value' => searchvalue
	 * @param int $sql_limit
	 *        	optional specify number of results to be returned
	 * @param int $sql_offset
	 *        	optional specify offset for resultset
	 * @param array $sql_orderby
	 *        	optional array with index = fieldname and value = ASC|DESC to order the resultset by one or more fields
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array count|list
	 */
	public function listing()
	{
		// select all my (accessable) certificates
		$certs_stmt_query = "SELECT s.*, d.domain, d.letsencrypt, c.customerid, c.loginname
			FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` s
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` d ON `d`.`id` = `s`.`domainid`
			LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` c ON `c`.`customerid` = `d`.`customerid`
			WHERE ";

		$qry_params = array();
		$query_fields = array();
		if ($this->isAdmin() && $this->getUserDetail('customers_see_all') == '0') {
			// admin with only customer-specific permissions
			$certs_stmt_query .= "d.adminid = :adminid ";
			$qry_params['adminid'] = $this->getUserDetail('adminid');
		} elseif ($this->isAdmin() == false) {
			// customer-area
			$certs_stmt_query .= "d.customerid = :cid ";
			$qry_params['cid'] = $this->getUserDetail('customerid');
		} else {
			$certs_stmt_query .= "1 ";
		}
		$certs_stmt = Database::prepare($certs_stmt_query . $this->getSearchWhere($query_fields, true) . $this->getOrderBy() . $this->getLimit());
		$qry_params = array_merge($qry_params, $query_fields);
		Database::pexecute($certs_stmt, $qry_params, true, true);
		$result = array();
		while ($cert = $certs_stmt->fetch(\PDO::FETCH_ASSOC)) {
			// respect froxlor-hostname
			if ($cert['domainid'] == 0) {
				$cert['domain'] = Settings::Get('system.hostname');
				$cert['letsencrypt'] = Settings::Get('system.le_froxlor_enabled');
				$cert['loginname'] = 'froxlor.panel';
			}
			$result[] = $cert;
		}
		return $this->response(200, "successful", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * returns the total number of certificates for the given user
	 *
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function listingCount()
	{
		// select all my (accessable) certificates
		$certs_stmt_query = "SELECT COUNT(*) as num_certs
			FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` s
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` d ON `d`.`id` = `s`.`domainid`
			LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` c ON `c`.`customerid` = `d`.`customerid`
			WHERE ";
		$qry_params = array();
		if ($this->isAdmin() && $this->getUserDetail('customers_see_all') == '0') {
			// admin with only customer-specific permissions
			$certs_stmt_query .= "d.adminid = :adminid ";
			$qry_params['adminid'] = $this->getUserDetail('adminid');
		} elseif ($this->isAdmin() == false) {
			// customer-area
			$certs_stmt_query .= "d.customerid = :cid ";
			$qry_params['cid'] = $this->getUserDetail('customerid');
		} else {
			$certs_stmt_query .= "1 ";
		}
		$certs_stmt = Database::prepare($certs_stmt_query);
		$result = Database::pexecute_first($certs_stmt, $qry_params, true, true);
		if ($result) {
			return $this->response(200, "successful", $result['num_certs']);
		}
	}

	/**
	 * delete certificates entry by id
	 *
	 * @param int $id
	 *
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function delete()
	{
		$id = $this->getParam('id');

		if ($this->isAdmin() == false) {
			$chk_stmt = Database::prepare("
				SELECT d.domain, d.letsencrypt FROM `" . TABLE_PANEL_DOMAINS . "` d
				LEFT JOIN `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` s ON s.domainid = d.id
				WHERE s.`id` = :id AND d.`customerid` = :cid
			");
			$chk = Database::pexecute_first($chk_stmt, array(
				'id' => $id,
				'cid' => $this->getUserDetail('customerid')
			));
		} elseif ($this->isAdmin()) {
			$chk_stmt = Database::prepare("
				SELECT d.domain, d.letsencrypt FROM `" . TABLE_PANEL_DOMAINS . "` d
				LEFT JOIN `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` s ON s.domainid = d.id
				WHERE s.`id` = :id" . ($this->getUserDetail('customers_see_all') == '0' ? " AND d.`adminid` = :aid" : ""));
			$params = array(
				'id' => $id
			);
			if ($this->getUserDetail('customers_see_all') == '0') {
				$params['aid'] = $this->getUserDetail('adminid');
			}
			$chk = Database::pexecute_first($chk_stmt, $params);
			if ($chk == false && $this->getUserDetail('change_serversettings')) {
				// check whether it might be the froxlor-vhost certificate
				$chk_stmt = Database::prepare("
				SELECT \"" . Settings::Get('system.hostname') . "\" as domain, \"" . Settings::Get('system.le_froxlor_enabled') . "\" as letsencrypt FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
				WHERE `id` = :id AND `domainid` = '0'");
				$params = array(
					'id' => $id
				);
				$chk = Database::pexecute_first($chk_stmt, $params);
				$chk['isFroxlorVhost'] = true;
			}
		}
		if ($chk !== false) {
			// additional access check by trying to get the certificate
			if (isset($chk['isFroxlorVhost']) && $chk['isFroxlorVhost'] == true) {
				$result = $chk;
			} else {
				$result = $this->apiCall('Certificates.get', array(
					'domainname' => $chk['domain']
				));
			}
			$del_stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE id = :id");
			Database::pexecute($del_stmt, array(
				'id' => $id
			));
			// trigger removing of certificate from acme.sh if let's encrypt
			if ($chk['letsencrypt'] == '1') {
				\Froxlor\System\Cronjob::inserttask('12', $chk['domain']);
			}
			$this->logger()->logAction($this->isAdmin() ? \Froxlor\FroxlorLogger::ADM_ACTION : \Froxlor\FroxlorLogger::USR_ACTION, LOG_INFO, "[API] removed ssl-certificate for '" . $chk['domain'] . "'");
			return $this->response(200, "successful", $result);
		}
		throw new \Exception("Unable to determine SSL certificate. Maybe no access?", 406);
	}

	/**
	 * insert or update certificates entry
	 *
	 * @param int $domainid
	 * @param string $ssl_cert_file
	 * @param string $ssl_key_file
	 * @param string $ssl_ca_file
	 * @param string $ssl_cert_chainfile
	 * @param boolean $do_insert
	 *        	optional default false
	 *        	
	 * @return boolean
	 * @throws \Exception
	 */
	private function addOrUpdateCertificate($domainid = 0, $ssl_cert_file = '', $ssl_key_file = '', $ssl_ca_file = '', $ssl_cert_chainfile = '', $do_insert = false)
	{
		if ($ssl_cert_file != '' && $ssl_key_file == '') {
			\Froxlor\UI\Response::standard_error('sslcertificateismissingprivatekey', '', true);
		}

		$do_verify = true;
		$expirationdate = null;
		// no cert-file given -> forget everything
		if ($ssl_cert_file == '') {
			$ssl_key_file = '';
			$ssl_ca_file = '';
			$ssl_cert_chainfile = '';
			$do_verify = false;
		}

		// verify certificate content
		if ($do_verify) {
			// array openssl_x509_parse ( mixed $x509cert [, bool $shortnames = true ] )
			// openssl_x509_parse() returns information about the supplied x509cert, including fields such as
			// subject name, issuer name, purposes, valid from and valid to dates etc.
			$cert_content = openssl_x509_parse($ssl_cert_file);

			if (is_array($cert_content) && isset($cert_content['subject']) && isset($cert_content['subject']['CN'])) {
				// bool openssl_x509_check_private_key ( mixed $cert , mixed $key )
				// Checks whether the given key is the private key that corresponds to cert.
				if (openssl_x509_check_private_key($ssl_cert_file, $ssl_key_file) === false) {
					\Froxlor\UI\Response::standard_error('sslcertificateinvalidcertkeypair', '', true);
				}

				// check optional stuff
				if ($ssl_ca_file != '') {
					$ca_content = openssl_x509_parse($ssl_ca_file);
					if (! is_array($ca_content)) {
						// invalid
						\Froxlor\UI\Response::standard_error('sslcertificateinvalidca', '', true);
					}
				}
				if ($ssl_cert_chainfile != '') {
					$chain_content = openssl_x509_parse($ssl_cert_chainfile);
					if (! is_array($chain_content)) {
						// invalid
						\Froxlor\UI\Response::standard_error('sslcertificateinvalidchain', '', true);
					}
				}
			} else {
				\Froxlor\UI\Response::standard_error('sslcertificateinvalidcert', '', true);
			}
			$expirationdate = empty($cert_content['validTo_time_t']) ? null : date("Y-m-d H:i:s", $cert_content['validTo_time_t']);
		}

		// Add/Update database entry
		$qrystart = "UPDATE ";
		$qrywhere = "WHERE ";
		if ($do_insert) {
			$qrystart = "INSERT INTO ";
			$qrywhere = ", ";
		}
		$stmt = Database::prepare($qrystart . " `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` SET
			`ssl_cert_file` = :ssl_cert_file,
			`ssl_key_file` = :ssl_key_file,
			`ssl_ca_file` = :ssl_ca_file,
			`ssl_cert_chainfile` = :ssl_cert_chainfile,
			`expirationdate` = :expirationdate
			" . $qrywhere . " `domainid`= :domainid
		");
		$params = array(
			"ssl_cert_file" => $ssl_cert_file,
			"ssl_key_file" => $ssl_key_file,
			"ssl_ca_file" => $ssl_ca_file,
			"ssl_cert_chainfile" => $ssl_cert_chainfile,
			"expirationdate" => $expirationdate,
			"domainid" => $domainid
		);
		Database::pexecute($stmt, $params, true, true);
		// insert task to re-generate webserver-configs (#1260)
		\Froxlor\System\Cronjob::inserttask('1');
		return true;
	}
}
