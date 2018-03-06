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
class Emails extends ApiCommand implements ResourceEntity
{
	
	/**
	 * add a new email address
	 *
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function add()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'email')) {
			throw new Exception("You cannot access this resource", 405);
		}

		if ($this->getUserDetail('emails_used') < $this->getUserDetail('emails') || $this->getUserDetail('emails') == '-1') {
			
			// required parameters
			$email_part = $this->getParam('email_part');
			$domain = $this->getParam('domain');
			
			// parameters
			$iscatchall = $this->getParam('iscatchall', true, 0);

			// validation
			if (substr($domain, 0, 4) != 'xn--') {
				$idna_convert = new idna_convert_wrapper();
				$domain = $idna_convert->encode(validate($domain, 'domain', '', '', array(), true));
			}

			// check domain and whether it's an email-enabled domain
			$domain_check = $this->apiCall('SubDomains.get', array(
				'domainname' => $domain
			));
			if ($domain_check['isemaildomain'] == 0) {
				standard_error('maindomainnonexist', $domain, true);
			}

			// check for catchall-flag
			if ($iscatchall) {
				$iscatchall = '1';
				$email = '@' . $domain;
			} else {
				$iscatchall = '0';
				$email = $email_part . '@' . $domain;
			}

			// full email value
			$email_full = $email_part . '@' . $domain;

			// validate it
			if (!validateEmail($email_full)) {
				standard_error('emailiswrong', $email_full, true);
			}

			// get needed customer info to reduce the email-address-counter by one
			if ($this->isAdmin()) {
				// get customer id
				$customer_id = $this->getParam('customer_id');
				$customer = $this->apiCall('Customers.get', array(
					'id' => $customer_id
				));
				// check whether the customer has enough resources to get the ftp-user added
				if ($customer['emails_used'] >= $customer['emails'] && $customer['emails'] != '-1') {
					throw new Exception("Customer has no more resources available", 406);
				}
			} else {
				$customer_id = $this->getUserDetail('customerid');
				$customer = $this->getUserData();
			}

			// duplicate check
			$stmt = Database::prepare("
				SELECT `id`, `email`, `email_full`, `iscatchall`, `destination`, `customerid` FROM `" . TABLE_MAIL_VIRTUAL . "`
				WHERE (`email` = :email OR `email_full` = :emailfull )
				AND `customerid`= :cid
			");
			$params = array(
				"email" => $email,
				"emailfull" => $email_full,
				"cid" => $customer['customerid']
			);
			$email_check = Database::pexecute_first($stmt, $params, true, true);

			if (strtolower($email_check['email_full']) == strtolower($email_full)) {
				standard_error('emailexistalready', $email_full, true);
			} elseif ($email_check['email'] == $email) {
				standard_error('youhavealreadyacatchallforthisdomain', '', true);
			}

			$stmt = Database::prepare("
				INSERT INTO `" . TABLE_MAIL_VIRTUAL . "` SET
				`customerid` = :cid,
				`email` = :email,
				`email_full` = :email_full,
				`iscatchall` = :iscatchall,
				`domainid` = :domainid
			");
			$params = array(
				"cid" => $customer['customerid'],
				"email" => $email,
				"email_full" => $email_full,
				"iscatchall" => $iscatchall,
				"domainid" => $domain_check['id']
			);
			Database::pexecute($stmt, $params, true, true);
			$address_id = Database::lastInsertId();

			// update customer usage
			Customers::increaseUsage($customer_id, 'emails_used');

			// update admin usage
			Admins::increaseUsage($customer['adminid'], 'emails_used');

			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_INFO, "[API] added email address '" . $email_full . "'");

			$result = $this->apiCall('Emails.get', array(
				'emailaddr' => $email_full
			));
			return $this->response(200, "successfull", $result);
		}
		throw new Exception("No more resources available", 406);
	}
	
	/**
	 * return a email-address entry by either id or email-address
	 *
	 * @param int $id
	 *        	optional, the customer-id
	 * @param string $emailaddr
	 *        	optional, the email-address
	 *
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$ea_optional = ($id <= 0 ? false : true);
		$emailaddr = $this->getParam('emailaddr', $ea_optional, '');
		
		$params = array();
		$customer_ids = $this->getAllowedCustomerIds('email');
		$params['customerid'] = implode(", ", $customer_ids);
		$params['idea'] = ($id <= 0 ? $emailaddr : $id);
		
		$result_stmt = Database::prepare("SELECT v.`id`, v.`email`, v.`email_full`, v.`iscatchall`, v.`destination`, v.`customerid`, v.`popaccountid`, u.`quota`
			FROM `" . TABLE_MAIL_VIRTUAL . "` v
			LEFT JOIN `" . TABLE_MAIL_USERS . "` u ON v.`popaccountid` = u.`id`
			WHERE v.`customerid` IN (:customerid)
			AND (v.`id`= :idea OR (v.`email` = :idea OR v.`email_full` = :idea))
		");
		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] get email address '" . $result['email_full'] . "'");
			return $this->response(200, "successfull", $result);
		}
		$key = ($id > 0 ? "id #" . $id : "emailaddr '" . $emailaddr . "'");
		throw new Exception("Email address with " . $key . " could not be found", 404);
	}
	
	public function update()
	{
	}
	
	/**
	 * list all email addresses, if called from an admin, list all email addresses of all customers you are allowed to view, or specify id or loginname for one specific customer
	 *
	 * @param int $customerid
	 *        	optional, admin-only, select ftp-users of a specific customer by id
	 * @param string $loginname
	 *        	optional, admin-only, select ftp-users of a specific customer by loginname
	 *
	 * @access admin, customer
	 * @throws Exception
	 * @return array count|list
	 */
	public function listing()
	{
		$customer_ids = $this->getAllowedCustomerIds('email');
		$result = array();
		$params['customerid'] = implode(", ", $customer_ids);
		$result_stmt = Database::prepare("
			SELECT m.`id`, m.`domainid`, m.`email`, m.`email_full`, m.`iscatchall`, u.`quota`, m.`destination`, m.`popaccountid`, d.`domain`, u.`mboxsize`
			FROM `" . TABLE_MAIL_VIRTUAL . "` m
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` d ON (m.`domainid` = d.`id`)
			LEFT JOIN `" . TABLE_MAIL_USERS . "` u ON (m.`popaccountid` = u.`id`)
			WHERE m.`customerid` IN (:customerid)
		");
		Database::pexecute($result_stmt, $params, true, true);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		$this->logger()->logAction($this->isAdmin() ? ADM_ACTION : USR_ACTION, LOG_NOTICE, "[API] list email-addresses");
		return $this->response(200, "successfull", array(
			'count' => count($result),
			'list' => $result
		));
	}
	
	/**
	 * delete an email address by either id or username
	 *
	 * @access admin, customer
	 * @throws Exception
	 * @return array
	 */
	public function delete()
	{
	}
}
