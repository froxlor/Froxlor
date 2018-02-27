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
class Subdomains extends ApiCommand implements ResourceEntity
{

	public function add()
	{}

	/**
	 * return a subdomain entry by either id or domainname
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
		
		// convert possible idn domain to punycode
		if (substr($domainname, 0, 4) != 'xn--') {
			$idna_convert = new idna_convert_wrapper();
			$domainname = $idna_convert->encode($domainname);
		}
		
		if ($this->isAdmin()) {
			if ($this->getUserDetail('customers_see_all') != 1) {
				// if it's a reseller or an admin who cannot see all customers, we need to check
				// whether the database belongs to one of his customers
				$json_result = Customers::getLocal($this->getUserData())->list();
				$custom_list_result = json_decode($json_result, true)['data']['list'];
				$customer_ids = array();
				foreach ($custom_list_result as $customer) {
					$customer_ids[] = $customer['customerid'];
				}
				if (count($customer_ids) > 0) {
					$result_stmt = Database::prepare("
						SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
						WHERE " . ($id > 0 ? "`id` = :iddn" : "`domain` = :iddn") . " AND `customerid` IN (:customerids)
					");
					$params = array(
						'iddn' => ($id <= 0 ? $domainname : $id),
						'customerids' => implode(", ", $customer_ids)
					);
				} else {
					throw new Exception("You do not have any customers yet", 406);
				}
			} else {
				$result_stmt = Database::prepare("
					SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE " . ($id > 0 ? "`id` = :iddn" : "`databasename` = :iddn"));
				$params = array(
					'iddn' => ($id <= 0 ? $domainname : $id)
				);
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'domains')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$result_stmt = Database::prepare("
				SELECT `id`, `customerid`, `domain`, `documentroot`, `isemaildomain`, `parentdomainid`, `aliasdomain` FROM `" . TABLE_PANEL_DOMAINS . "`
				WHERE `customerid`= :customerid AND " . ($id > 0 ? "`id` = :iddn" : "`databasename` = :iddn"));
			$params = array(
				'customerid' => $this->getUserDetail('customerid'),
				'iddn' => ($id <= 0 ? $domainname : $id)
			);
		}
		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] get subdomain '" . $result['domain'] . "'");
			return $this->response(200, "successfull", $result);
		}
		$key = ($id > 0 ? "id #" . $id : "domainname '" . $domainname . "'");
		throw new Exception("Subdomain with " . $key . " could not be found", 404);
	}

	public function update()
	{}

	public function list()
	{
		if ($this->isAdmin()) {
			// if we're an admin, list all databases of all the admins customers
			// or optionally for one specific customer identified by id or loginname
			$customerid = $this->getParam('customerid', true, 0);
			$loginname = $this->getParam('loginname', true, '');
			
			if (! empty($customer_id) || ! empty($loginname)) {
				$json_result = Customers::getLocal($this->getUserData(), array(
					'id' => $customerid,
					'loginname' => $loginname
				))->get();
				$custom_list_result = array(
					json_decode($json_result, true)['data']
				);
			} else {
				$json_result = Customers::getLocal($this->getUserData())->list();
				$custom_list_result = json_decode($json_result, true)['data']['list'];
			}
			$customer_ids = array();
			$customer_stdsubs = array();
			foreach ($custom_list_result as $customer) {
				$customer_ids[] = $customer['customerid'];
				$customer_stdsubs[$customer['customerid']] = $customer['standardsubdomain'];
			}
		} else {
			if (Settings::IsInList('panel.customer_hide_options', 'domains')) {
				throw new Exception("You cannot access this resource", 405);
			}
			$customer_ids = array(
				$this->getUserDetail('customerid')
			);
			$customer_stdsubs = array(
				$this->getUserDetail('customerid') => $this->getUserDetail('standardsubdomain')
			);
		}
		
		// prepare select statement
		$domains_stmt = Database::prepare("
			SELECT `d`.`id`, `d`.`customerid`, `d`.`domain`, `d`.`documentroot`, `d`.`isbinddomain`, `d`.`isemaildomain`, `d`.`caneditdomain`, `d`.`iswildcarddomain`, `d`.`parentdomainid`, `d`.`letsencrypt`, `d`.`termination_date`, `ad`.`id` AS `aliasdomainid`, `ad`.`domain` AS `aliasdomain`, `da`.`id` AS `domainaliasid`, `da`.`domain` AS `domainalias`
			FROM `" . TABLE_PANEL_DOMAINS . "` `d`
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `ad` ON `d`.`aliasdomain`=`ad`.`id`
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `da` ON `da`.`aliasdomain`=`d`.`id`
			WHERE `d`.`customerid`= :customerid
			AND `d`.`email_only`='0'
			AND `d`.`id` <> :standardsubdomain
		");
		
		$result = array();
		foreach ($customer_ids as $customer_id) {
			Database::pexecute($domains_stmt, array(
				"customerid" => $customer_id,
				"standardsubdomain" => $customer_stdsubs[$customer_id]
			), true, true);
			while ($row = $domains_stmt->fetch(PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
		}
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}

	/**
	 * delete a subdomain by either id or domainname
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
	public function delete()
	{
		$id = $this->getParam('id', true, 0);
		$dn_optional = ($id <= 0 ? false : true);
		$domainname = $this->getParam('domainname', $dn_optional, '');
		
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'domains')) {
			throw new Exception("You cannot access this resource", 405);
		}
		
		$json_result = SubDomains::getLocal($this->getUserData(), array(
			'id' => $id,
			'domainname' => $domainname
		))->get();
		$result = json_decode($json_result, true)['data'];
		$id = $result['id'];
		
		// get needed customer info to reduce the subdomain-usage-counter by one
		if ($this->isAdmin()) {
			$json_result = Customers::getLocal($this->getUserData(), array(
				'id' => $result['customerid']
			))->get();
			$customer = json_decode($json_result, true)['data'];
			$subdomains_used = $customer['subdomains_used'];
			$customer_id = $customer['customer_id'];
		} else {
			if ($result['caneditdomain'] == 0) {
				throw new Exception("You cannot edit this resource", 405);
			}
			$subdomains_used = $this->getUserDetail('subdomains_used');
			$customer_id = $this->getUserDetail('customerid');
		}
		
		if ($result['isemaildomain'] == '1') {
			// check for e-mail addresses
			$emails_stmt = Database::prepare("
				SELECT COUNT(`id`) AS `count` FROM `" . TABLE_MAIL_VIRTUAL . "`
				WHERE `customerid` = :customerid AND `domainid` = :domainid
			");
			$emails = Database::pexecute_first($emails_stmt, array(
				"customerid" => $customer_id,
				"domainid" => $id
			), true, true);
			
			if ($emails['count'] != '0') {
				standard_error('domains_cantdeletedomainwithemail', '', true);
			}
		}
		
		triggerLetsEncryptCSRForAliasDestinationDomain($result['aliasdomain'], $this->logger());
		
		// delete domain from table
		$stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid` = :customerid AND `id` = :id
		");
		Database::pexecute($stmt, array(
			"customerid" => $customer_id,
			"id" => $id
		), true, true);
		
		// remove connections to ips and domainredirects
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_DOMAINTOIP . "`
			WHERE `id_domain` = :domainid
		");
		Database::pexecute($del_stmt, array(
			'domainid' => $id
		), true, true);
		
		// remove redirect-codes
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_DOMAINREDIRECTS . "`
			WHERE `did` = :domainid
		");
		Database::pexecute($del_stmt, array(
			'domainid' => $id
		), true, true);
		
		// remove certificate from domain_ssl_settings, fixes #1596
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
			WHERE `domainid` = :domainid
		");
		Database::pexecute($del_stmt, array(
			'domainid' => $id
		), true, true);
		
		// remove possible existing DNS entries
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_DOMAIN_DNS . "`
			WHERE `domain_id` = :domainid
		");
		Database::pexecute($del_stmt, array(
			'domainid' => $id
		), true, true);
		
		inserttask('1');
		// Using nameserver, insert a task which rebuilds the server config
		inserttask('4');
		
		// reduce subdomain-usage-counter
		$stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_CUSTOMERS . "`
			SET `subdomains_used` = `subdomains_used` - 1
			WHERE `customerid` = :customerid
		");
		Database::pexecute($stmt, array(
			"customerid" => $customer_id
		), true, true);
		// update admin usage
		$stmt = Database::prepare("
			UPDATE `" . TABLE_PANEL_ADMINS . "`
			SET `subdomains_used` = `subdomains_used` - 1
			WHERE `adminid` = :adminid
		");
		Database::pexecute($stmt, array(
			"adminid" => ($this->isAdmin() ? $customer['adminid'] : $this->getUserDetail('adminid'))
		), true, true);
		
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_WARNING, "[API] deleted subdomain '" . $result['domain'] . "'");
		return $this->response(200, "successfull", $result);
	}
}
