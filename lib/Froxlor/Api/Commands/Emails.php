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

namespace Froxlor\Api\Commands;

use Exception;
use Froxlor\Api\ApiCommand;
use Froxlor\Api\ResourceEntity;
use Froxlor\Database\Database;
use Froxlor\FroxlorLogger;
use Froxlor\Idna\IdnaWrapper;
use Froxlor\Settings;
use Froxlor\UI\Response;
use Froxlor\Validate\Validate;
use PDO;

/**
 * @since 0.10.0
 */
class Emails extends ApiCommand implements ResourceEntity
{

	/**
	 * add a new email address
	 *
	 * @param string $email_part
	 *            name of the address before @
	 * @param string $domain
	 *            domain-name for the email-address
	 * @param boolean $iscatchall
	 *            optional, make this address a catchall address, default: no
	 * @param int $customerid
	 *            optional, required when called as admin (if $loginname is not specified)
	 * @param string $loginname
	 *            optional, required when called as admin (if $customerid is not specified)
	 * @param string $description
	 *            optional custom description (currently not used/shown in the frontend), default empty
	 *
	 * @access admin, customer
	 * @return string json-encoded array
	 * @throws Exception
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
			$iscatchall = $this->getBoolParam('iscatchall', true, 0);
			$description = $this->getParam('description', true, '');

			// validation
			if (substr($domain, 0, 4) != 'xn--') {
				$idna_convert = new IdnaWrapper();
				$domain = $idna_convert->encode(Validate::validate($domain, 'domain', '', '', [], true));
			}

			// check domain and whether it's an email-enabled domain
			// use internal call because the customer might have 'domains' in customer_hide_options
			$domain_check = $this->apiCall('SubDomains.get', [
				'domainname' => $domain
			], true);
			if ($domain_check['isemaildomain'] == 0) {
				Response::standardError('maindomainnonexist', $domain, true);
			}

			if (Settings::Get('catchall.catchall_enabled') != '1') {
				$iscatchall = 0;
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
			if (!Validate::validateEmail($email_full)) {
				Response::standardError('emailiswrong', $email_full, true);
			}

			// get needed customer info to reduce the email-address-counter by one
			$customer = $this->getCustomerData('emails');

			// duplicate check
			$stmt = Database::prepare("
				SELECT `id`, `email`, `email_full`, `iscatchall`, `destination`, `customerid` FROM `" . TABLE_MAIL_VIRTUAL . "`
				WHERE (`email` = :email OR `email_full` = :emailfull )
				AND `customerid`= :cid
			");
			$params = [
				"email" => $email,
				"emailfull" => $email_full,
				"cid" => $customer['customerid']
			];
			$email_check = Database::pexecute_first($stmt, $params, true, true);

			if ($email_check) {
				if (strtolower($email_check['email_full']) == strtolower($email_full)) {
					Response::standardError('emailexistalready', $email_full, true);
				} elseif ($email_check['email'] == $email) {
					Response::standardError('youhavealreadyacatchallforthisdomain', '', true);
				}
			}

			$stmt = Database::prepare("
				INSERT INTO `" . TABLE_MAIL_VIRTUAL . "` SET
				`customerid` = :cid,
				`email` = :email,
				`email_full` = :email_full,
				`iscatchall` = :iscatchall,
				`domainid` = :domainid,
				`description` = :description
			");
			$params = [
				"cid" => $customer['customerid'],
				"email" => $email,
				"email_full" => $email_full,
				"iscatchall" => $iscatchall,
				"domainid" => $domain_check['id'],
				"description" => $description
			];
			Database::pexecute($stmt, $params, true, true);

			// update customer usage
			Customers::increaseUsage($customer['customerid'], 'emails_used');

			$this->logger()->logAction($this->isAdmin() ? FroxlorLogger::ADM_ACTION : FroxlorLogger::USR_ACTION, LOG_NOTICE, "[API] added email address '" . $email_full . "'");

			$result = $this->apiCall('Emails.get', [
				'emailaddr' => $email_full
			]);
			return $this->response($result);
		}
		throw new Exception("No more resources available", 406);
	}

	/**
	 * return a email-address entry by either id or email-address
	 *
	 * @param int $id
	 *            optional, the email-address-id
	 * @param string $emailaddr
	 *            optional, the email-address
	 *
	 * @access admin, customer
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function get()
	{
		$id = $this->getParam('id', true, 0);
		$ea_optional = $id > 0;
		$emailaddr = $this->getParam('emailaddr', $ea_optional, '');

		$params = [];
		$customer_ids = $this->getAllowedCustomerIds('email');
		$params['idea'] = ($id <= 0 ? $emailaddr : $id);

		$result_stmt = Database::prepare("SELECT v.`id`, v.`email`, v.`email_full`, v.`iscatchall`, v.`destination`, v.`customerid`, v.`popaccountid`, v.`domainid`, v.`description`, u.`quota`, u.`imap`, u.`pop3`, u.`postfix`, u.`mboxsize`
			FROM `" . TABLE_MAIL_VIRTUAL . "` v
			LEFT JOIN `" . TABLE_MAIL_USERS . "` u ON v.`popaccountid` = u.`id`
			WHERE v.`customerid` IN (" . implode(", ", $customer_ids) . ")
			AND " . (is_numeric($params['idea']) ? "v.`id`= :idea" : "(v.`email` = :idea OR v.`email_full` = :idea)")
		);
		$result = Database::pexecute_first($result_stmt, $params, true, true);
		if ($result) {
			$this->logger()->logAction($this->isAdmin() ? FroxlorLogger::ADM_ACTION : FroxlorLogger::USR_ACTION, LOG_INFO, "[API] get email address '" . $result['email_full'] . "'");
			return $this->response($result);
		}
		$key = ($id > 0 ? "id #" . $id : "emailaddr '" . $emailaddr . "'");
		throw new Exception("Email address with " . $key . " could not be found", 404);
	}

	/**
	 * toggle catchall flag of given email address either by id or email-address
	 *
	 * @param int $id
	 *            optional, the email-address-id
	 * @param string $emailaddr
	 *            optional, the email-address
	 * @param int $customerid
	 *            optional, required when called as admin (if $loginname is not specified)
	 * @param string $loginname
	 *            optional, required when called as admin (if $customerid is not specified)
	 * @param boolean $iscatchall
	 *            optional
	 * @param string $description
	 *            optional custom description (currently not used/shown in the frontend), default empty
	 *
	 * @access admin, customer
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function update()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'email')) {
			throw new Exception("You cannot access this resource", 405);
		}

		// if enabling catchall is not allowed by settings, we do not need
		// to run update()
		if (Settings::Get('catchall.catchall_enabled') != '1') {
			Response::standardError([
				'operationnotpermitted',
				'featureisdisabled'
			], 'catchall', true);
		}

		$id = $this->getParam('id', true, 0);
		$ea_optional = $id > 0;
		$emailaddr = $this->getParam('emailaddr', $ea_optional, '');

		$result = $this->apiCall('Emails.get', [
			'id' => $id,
			'emailaddr' => $emailaddr
		]);
		$id = $result['id'];

		// parameters
		$iscatchall = $this->getBoolParam('iscatchall', true, $result['iscatchall']);
		$description = $this->getParam('description', true, $result['description']);

		// get needed customer info to reduce the email-address-counter by one
		$customer = $this->getCustomerData();

		// check for catchall-flag
		if ($iscatchall) {
			$iscatchall = '1';
			$email_parts = explode('@', $result['email_full']);
			$email = '@' . $email_parts[1];
			// catchall check
			$stmt = Database::prepare("
				SELECT `email_full` FROM `" . TABLE_MAIL_VIRTUAL . "`
				WHERE `email` = :email AND `customerid` = :cid AND `iscatchall` = '1'
			");
			$params = [
				"email" => $email,
				"cid" => $customer['customerid']
			];
			$email_check = Database::pexecute_first($stmt, $params, true, true);
			if ($email_check) {
				Response::standardError('youhavealreadyacatchallforthisdomain', '', true);
			}
		} else {
			$iscatchall = '0';
			$email = $result['email_full'];
		}

		$stmt = Database::prepare("
			UPDATE `" . TABLE_MAIL_VIRTUAL . "`
			SET `email` = :email , `iscatchall` = :caflag, `description` = :description
			WHERE `customerid`= :cid AND `id`= :id
		");
		$params = [
			"email" => $email,
			"caflag" => $iscatchall,
			"description" => $description,
			"cid" => $customer['customerid'],
			"id" => $id
		];
		Database::pexecute($stmt, $params, true, true);
		$this->logger()->logAction($this->isAdmin() ? FroxlorLogger::ADM_ACTION : FroxlorLogger::USR_ACTION, LOG_NOTICE, "[API] toggled catchall-flag for email address '" . $result['email_full'] . "'");

		$result = $this->apiCall('Emails.get', [
			'emailaddr' => $result['email_full']
		]);
		return $this->response($result);
	}

	/**
	 * list all email addresses, if called from an admin, list all email addresses of all customers you are allowed to
	 * view, or specify id or loginname for one specific customer
	 *
	 * @param int $customerid
	 *            optional, admin-only, select email addresses of a specific customer by id
	 * @param string $loginname
	 *            optional, admin-only, select email addresses of a specific customer by loginname
	 * @param array $sql_search
	 *            optional array with index = fieldname, and value = array with 'op' => operator (one of <, > or =),
	 *            LIKE is used if left empty and 'value' => searchvalue
	 * @param int $sql_limit
	 *            optional specify number of results to be returned
	 * @param int $sql_offset
	 *            optional specify offset for resultset
	 * @param array $sql_orderby
	 *            optional array with index = fieldname and value = ASC|DESC to order the resultset by one or more
	 *            fields
	 *
	 * @access admin, customer
	 * @return string json-encoded array count|list
	 * @throws Exception
	 */
	public function listing()
	{
		$customer_ids = $this->getAllowedCustomerIds('email');
		$result = [];
		$query_fields = [];
		$result_stmt = Database::prepare("
			SELECT m.`id`, m.`domainid`, m.`email`, m.`email_full`, m.`iscatchall`, m.`destination`, m.`popaccountid`, d.`domain`, u.`quota`, u.`imap`, u.`pop3`, u.`postfix`, u.`mboxsize`
			FROM `" . TABLE_MAIL_VIRTUAL . "` m
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` d ON (m.`domainid` = d.`id`)
			LEFT JOIN `" . TABLE_MAIL_USERS . "` u ON (m.`popaccountid` = u.`id`)
			WHERE m.`customerid` IN (" . implode(", ", $customer_ids) . ")" . $this->getSearchWhere($query_fields, true) . $this->getOrderBy() . $this->getLimit());
		Database::pexecute($result_stmt, $query_fields, true, true);
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		$this->logger()->logAction($this->isAdmin() ? FroxlorLogger::ADM_ACTION : FroxlorLogger::USR_ACTION, LOG_INFO, "[API] list email-addresses");
		return $this->response([
			'count' => count($result),
			'list' => $result
		]);
	}

	/**
	 * returns the total number of accessible email addresses
	 *
	 * @param int $customerid
	 *            optional, admin-only, select email addresses of a specific customer by id
	 * @param string $loginname
	 *            optional, admin-only, select email addresses of a specific customer by loginname
	 *
	 * @access admin, customer
	 * @return string json-encoded response message
	 * @throws Exception
	 */
	public function listingCount()
	{
		$customer_ids = $this->getAllowedCustomerIds('email');
		$result_stmt = Database::prepare("
			SELECT COUNT(*) as num_emails
			FROM `" . TABLE_MAIL_VIRTUAL . "` m
			LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` d ON (m.`domainid` = d.`id`)
			LEFT JOIN `" . TABLE_MAIL_USERS . "` u ON (m.`popaccountid` = u.`id`)
			WHERE m.`customerid` IN (" . implode(", ", $customer_ids) . ")
		");
		$result = Database::pexecute_first($result_stmt, null, true, true);
		if ($result) {
			return $this->response($result['num_emails']);
		}
		return $this->response(0);
	}

	/**
	 * delete an email address by either id or username
	 *
	 * @param int $id
	 *            optional, the email-address-id
	 * @param string $emailaddr
	 *            optional, the email-address
	 * @param int $customerid
	 *            optional, required when called as admin (if $loginname is not specified)
	 * @param string $loginname
	 *            optional, required when called as admin (if $customerid is not specified)
	 * @param boolean $delete_userfiles
	 *            optional, delete email data from filesystem, default: 0 (false)
	 *
	 * @access admin, customer
	 * @return string json-encoded array
	 * @throws Exception
	 */
	public function delete()
	{
		if ($this->isAdmin() == false && Settings::IsInList('panel.customer_hide_options', 'email')) {
			throw new Exception("You cannot access this resource", 405);
		}

		$id = $this->getParam('id', true, 0);
		$ea_optional = $id > 0;
		$emailaddr = $this->getParam('emailaddr', $ea_optional, '');

		$result = $this->apiCall('Emails.get', [
			'id' => $id,
			'emailaddr' => $emailaddr
		]);
		$id = $result['id'];

		// parameters
		$delete_userfiles = $this->getBoolParam('delete_userfiles', true, 0);

		// get needed customer info to reduce the email-address-counter by one
		$customer = $this->getCustomerData();

		// check for forwarders
		$number_forwarders = 0;
		if ($result['destination'] != '') {
			$result['destination'] = explode(' ', $result['destination']);
			$number_forwarders = count($result['destination']);
		}
		// check whether this address is an account
		if ($result['popaccountid'] != 0) {
			// use EmailAccounts.delete
			$this->apiCall('EmailAccounts.delete', [
				'id' => $result['id'],
				'customerid' => $customer['customerid'],
				'delete_userfiles' => $delete_userfiles
			]);
			$number_forwarders--;
		}

		// decrease forwarder counter
		Customers::decreaseUsage($customer['customerid'], 'email_forwarders_used', '', $number_forwarders);
		Admins::decreaseUsage($customer['customerid'], 'email_forwarders_used', '', $number_forwarders);

		// delete address
		$stmt = Database::prepare("DELETE FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `customerid`= :customerid AND `id`= :id");
		Database::pexecute($stmt, [
			"customerid" => $customer['customerid'],
			"id" => $id
		], true, true);
		Customers::decreaseUsage($customer['customerid'], 'emails_used');

		$this->logger()->logAction($this->isAdmin() ? FroxlorLogger::ADM_ACTION : FroxlorLogger::USR_ACTION, LOG_WARNING, "[API] deleted email address '" . $result['email_full'] . "'");
		return $this->response($result);
	}
}
