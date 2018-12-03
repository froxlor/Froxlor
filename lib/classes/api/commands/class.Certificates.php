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
class Certificates extends ApiCommand implements ResourceEntity
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
	 * @throws Exception
	 * @return array
	 */
	public function add()
	{
		$domainid = $this->getParam('domainid', true, 0);
		$dn_optional = ($domainid <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'domains')) {
			throw new Exception("You cannot access this resource", 405);
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
		$result = $this->apiCall('Certificates.get', array(
			'id' => $domainid
		));
		if (empty($result)) {
			$this->addOrUpdateCertificate($domain['id'], $ssl_cert_file, $ssl_key_file, $ssl_ca_file, $ssl_cert_chainfile, true);
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] added ssl-certificate for '" . $domain['domain'] . "'");
			$result = $this->apiCall('Certificates.get', array(
				'id' => $domain['id']
			));
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("Domain '" . $domain['domain'] . "' already has a certificate. Did you mean to call update?", 406);
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
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'domains')) {
			throw new Exception("You cannot access this resource", 405);
		}

		$domain = $this->apiCall('SubDomains.get', array(
			'id' => $id,
			'domainname' => $domainname
		));
		$domainid = $domain['id'];

		$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE `domainid`= :domainid");
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] get ssl-certificate for '" . $domain['domain'] . "'");
		$result = Database::pexecute_first($stmt, array(
			"domainid" => $domainid
		));
		return $this->response(200, "successfull", $result);
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
	 * @throws Exception
	 * @return array
	 */
	public function update()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');

		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'domains')) {
			throw new Exception("You cannot access this resource", 405);
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
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] updated ssl-certificate for '" . $domain['domain'] . "'");
		$result = $this->apiCall('Certificates.get', array(
			'id' => $domain['id']
		));
		return $this->response(200, "successfull", $result);
	}

	/**
	 * lists all certificate entries
	 *
	 * @access admin, customer
	 * @throws Exception
	 * @return array count|list
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
		Database::pexecute($certs_stmt, $qry_params, true, true);
		$result = array();
		while ($cert = $certs_stmt->fetch(PDO::FETCH_ASSOC)) {
			// respect froxlor-hostname
			if ($cert['domainid'] == 0) {
				$cert['domain'] = Settings::Get('system.hostname');
				$cert['letsencrypt'] = Settings::Get('system.le_froxlor_enabled');
				$cert['loginname'] = 'froxlor.panel';
			}
			$result[] = $cert;
		}
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * delete certificates entry by id
	 *
	 * @param int $id
	 *
	 * @return array
	 * @throws Exception
	 */
	public function delete()
	{
		$id = $this->getParam('id');

		$chk = ($this->isAdmin() && $this->getUserDetail('customers_see_all') == '1') ? true : false;
		if ($this->isAdmin() == false) {
			$chk_stmt = Database::prepare("
				SELECT d.domain FROM `" . TABLE_PANEL_DOMAINS . "` d
				LEFT JOIN `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` s ON s.domainid = d.id
				WHERE s.`id` = :id AND d.`customerid` = :cid
			");
			$chk = Database::pexecute_first($chk_stmt, array(
				'id' => $id,
				'cid' => $this->getUserDetail('customerid')
			));
		} elseif ($this->isAdmin() && $this->getUserDetail('customers_see_all') == '0') {
			$chk_stmt = Database::prepare("
				SELECT d.domain FROM `" . TABLE_PANEL_DOMAINS . "` d
				LEFT JOIN `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` s ON s.domainid = d.id
				WHERE s.`id` = :id AND d.`adminid` = :aid
			");
			$chk = Database::pexecute_first($chk_stmt, array(
				'id' => $id,
				'aid' => $this->getUserDetail('adminid')
			));
		}
		if ($chk !== false) {
			// additional access check by trying to get the certificate
			$result = $this->apiCall('Certificates.get', array(
				'domainname' => $chk['domain']
			));
			$del_stmt = Database::prepare("DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "` WHERE id = :id");
			Database::pexecute($del_stmt, array(
				'id' => $id
			));
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] removed ssl-certificate for '" . $chk['domain'] . "'");
			return $this->response(200, "successfull", $result);
		}
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
	 * @throws Exception
	 */
	private function addOrUpdateCertificate($domainid = 0, $ssl_cert_file = '', $ssl_key_file = '', $ssl_ca_file = '', $ssl_cert_chainfile = '', $do_insert = false)
	{
		if ($ssl_cert_file != '' && $ssl_key_file == '') {
			standard_error('sslcertificateismissingprivatekey', '', true);
		}

		$do_verify = true;
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
					standard_error('sslcertificateinvalidcertkeypair', '', true);
				}

				// check optional stuff
				if ($ssl_ca_file != '') {
					$ca_content = openssl_x509_parse($ssl_ca_file);
					if (! is_array($ca_content)) {
						// invalid
						standard_error('sslcertificateinvalidca', '', true);
					}
				}
				if ($ssl_cert_chainfile != '') {
					$chain_content = openssl_x509_parse($ssl_cert_chainfile);
					if (! is_array($chain_content)) {
						// invalid
						standard_error('sslcertificateinvalidchain', '', true);
					}
				}
			} else {
				standard_error('sslcertificateinvalidcert', '', true);
			}
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
			`ssl_cert_chainfile` = :ssl_cert_chainfile
			" . $qrywhere . " `domainid`= :domainid
		");
		$params = array(
			"ssl_cert_file" => $ssl_cert_file,
			"ssl_key_file" => $ssl_key_file,
			"ssl_ca_file" => $ssl_ca_file,
			"ssl_cert_chainfile" => $ssl_cert_chainfile,
			"domainid" => $domainid
		);
		Database::pexecute($stmt, $params, true, true);
		// insert task to re-generate webserver-configs (#1260)
		inserttask('1');
		return true;
	}
}
