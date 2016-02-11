<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Function which updates all counters of used ressources in panel_admins and panel_customers
 * @param bool Set to true to get an array with debug information
 * @return array Contains debug information if parameter 'returndebuginfo' is set to true
 *
 * @author Florian Lippert <flo@syscp.org> (2003-2009)
 * @author Froxlor team <team@froxlor.org> (2010-)
 */
function updateCounters($returndebuginfo = false) {

	$returnval = array();

	if($returndebuginfo === true) {
		$returnval = array(
			'admins' => array(),
			'customers' => array()
		);
	}

	// Customers
	$customers_stmt = Database::prepare('SELECT * FROM `' . TABLE_PANEL_CUSTOMERS . '` ORDER BY `customerid`');
	Database::pexecute($customers_stmt);

	$admin_resources = array();
	while ($customer = $customers_stmt->fetch(PDO::FETCH_ASSOC)) {

		$cur_adm = $customer['adminid'];

		// initialize admin-resources array for admin $customer['adminid']
		if (!isset($admin_resources[$cur_adm])) {
			$admin_resources[$cur_adm] = array();
		}

		_addResourceCountEx($admin_resources[$cur_adm], $customer, 'diskspace_used', 'diskspace');
		_addResourceCountEx($admin_resources[$cur_adm], $customer, 'traffic_used', 'traffic_used'); // !!! yes, USED and USED

		foreach (array('mysqls', 'ftps', 'emails', 'email_accounts', 'tickets', 'email_forwarders', 'email_quota', 'subdomains') as $field) {
			_addResourceCount($admin_resources[$cur_adm], $customer, $field.'_used', $field);
		}

		$customer_mysqls_stmt = Database::prepare('SELECT COUNT(*) AS `number_mysqls` FROM `' . TABLE_PANEL_DATABASES . '`
			WHERE `customerid` = :cid'
		);
		$customer_mysqls = Database::pexecute_first($customer_mysqls_stmt, array("cid" => $customer['customerid']));
		$customer['mysqls_used_new'] = (int)$customer_mysqls['number_mysqls'];
		
		$customer_emails_stmt = Database::prepare('SELECT COUNT(*) AS `number_emails` FROM `' . TABLE_MAIL_VIRTUAL . '`
			WHERE `customerid` = :cid'
		);
		$customer_emails = Database::pexecute_first($customer_emails_stmt, array("cid" => $customer['customerid']));
		$customer['emails_used_new'] = (int)$customer_emails['number_emails'];
		
		$customer_emails_result_stmt = Database::prepare('SELECT `email`, `email_full`, `destination`, `popaccountid` AS `number_email_forwarders` FROM `' . TABLE_MAIL_VIRTUAL . '`
			WHERE `customerid` = :cid'
		);
		Database::pexecute($customer_emails_result_stmt, array("cid" => $customer['customerid']));
		$customer_email_forwarders = 0;
		$customer_email_accounts = 0;

		while($customer_emails_row = $customer_emails_result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if($customer_emails_row['destination'] != '') {
				$customer_emails_row['destination'] = explode(' ', makeCorrectDestination($customer_emails_row['destination']));
				$customer_email_forwarders+= count($customer_emails_row['destination']);

				if(in_array($customer_emails_row['email_full'], $customer_emails_row['destination'])) {
					$customer_email_forwarders-= 1;
					$customer_email_accounts++;
				}
			}
		}

		$customer['email_accounts_used_new'] = $customer_email_accounts;
		$customer['email_forwarders_used_new'] = $customer_email_forwarders;
		
		$customer_ftps_stmt = Database::prepare('SELECT COUNT(*) AS `number_ftps` FROM `' . TABLE_FTP_USERS . '` WHERE `customerid` = :cid');
		$customer_ftps = Database::pexecute_first($customer_ftps_stmt, array("cid" => $customer['customerid']));
		$customer['ftps_used_new'] = ((int)$customer_ftps['number_ftps'] - 1);
		
		$customer_tickets_stmt = Database::prepare('SELECT COUNT(*) AS `number_tickets` FROM `' . TABLE_PANEL_TICKETS . '` WHERE `answerto` = "0" AND `customerid` =  :cid');
		$customer_tickets = Database::pexecute_first($customer_tickets_stmt, array("cid" => $customer['customerid']));
		$customer['tickets_used_new'] = (int)$customer_tickets['number_tickets'];
		
		$customer_subdomains_stmt = Database::prepare('SELECT COUNT(*) AS `number_subdomains` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `customerid` = :cid AND `parentdomainid` <> "0"');
		$customer_subdomains = Database::pexecute_first($customer_subdomains_stmt, array("cid" => $customer['customerid']));
		$customer['subdomains_used_new'] = (int)$customer_subdomains['number_subdomains'];
		
		$customer_email_quota_stmt = Database::prepare('SELECT SUM(`quota`) AS `email_quota` FROM `' . TABLE_MAIL_USERS . '` WHERE `customerid` = :cid');
		$customer_email_quota = Database::pexecute_first($customer_email_quota_stmt, array("cid" => $customer['customerid']));
		$customer['email_quota_used_new'] = (int)$customer_email_quota['email_quota'];

		$stmt = Database::prepare('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` 
			SET `mysqls_used` = :mysqls_used,
				`emails_used` = :emails_used,
				`email_accounts_used` = :email_accounts_used,
				`email_forwarders_used` = :email_forwarders_used,
				`email_quota_used` = :email_quota_used,
				`ftps_used` = :ftps_used, 
				`tickets_used` = :tickets_used,
				`subdomains_used` = :subdomains_used
			WHERE `customerid` = :cid'
		);
		$params = array(
			"mysqls_used" => $customer['mysqls_used_new'],
			"emails_used" => $customer['emails_used_new'],
			"email_accounts_used" => $customer['email_accounts_used_new'],
			"email_forwarders_used" => $customer['email_forwarders_used_new'],
			"email_quota_used" => $customer['email_quota_used_new'],
			"ftps_used" => $customer['ftps_used_new'],
			"tickets_used" => $customer['tickets_used_new'],
			"subdomains_used" => $customer['subdomains_used_new'],
			"cid" => $customer['customerid']
		);
		Database::pexecute($stmt, $params);

		if($returndebuginfo === true) {
			$returnval['customers'][$customer['customerid']] = $customer;
		}
	}

	// Admins
	$admins_stmt = Database::prepare('SELECT * FROM `' . TABLE_PANEL_ADMINS . '` ORDER BY `adminid`');
	Database::pexecute($admins_stmt, array());

	while($admin = $admins_stmt->fetch(PDO::FETCH_ASSOC)) {
		$admin_customers_stmt = Database::prepare('SELECT COUNT(*) AS `number_customers` FROM `' . TABLE_PANEL_CUSTOMERS . '` WHERE `adminid` = :aid');
		$admin_customers = Database::pexecute_first($admin_customers_stmt, array("aid" => $admin['adminid']));
		$admin['customers_used_new'] = $admin_customers['number_customers'];
		
		$admin_domains_stmt = Database::prepare('SELECT COUNT(*) AS `number_domains` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `adminid` = :aid AND `isemaildomain` = "1"');
		$admin_domains = Database::pexecute_first($admin_domains_stmt, array("aid" => $admin['adminid']));
		$admin['domains_used_new'] = $admin_domains['number_domains'];

		$cur_adm = $admin['adminid'];

		if (!isset($admin_resources[$cur_adm])) {
			$admin_resources[$cur_adm] = array();
		}

		foreach (array('diskspace_used', 'traffic_used', 'mysqls_used', 'ftps_used', 'emails_used', 'email_accounts_used', 'tickets_used', 'email_forwarders_used', 'email_quota_used', 'subdomains_used') as $field) {
			_initArrField($field, $admin_resources[$cur_adm], 0);
			$admin[$field.'_new'] = $admin_resources[$cur_adm][$field];
		}

		$stmt = Database::prepare('UPDATE `' . TABLE_PANEL_ADMINS . '` 
			SET `customers_used` = :customers_used,
				`domains_used` = :domains_used,
				`diskspace_used` = :diskspace_used,
				`mysqls_used` = :mysqls_used,
				`emails_used` = :emails_used,
				`email_accounts_used` = :email_accounts_used,
				`email_forwarders_used` = :email_forwarders_used,
				`email_quota_used` = :email_quota_used,
				`ftps_used` = :ftps_used, 
				`tickets_used` = :tickets_used,
				`subdomains_used` = :subdomains_used,
				`traffic_used` = :traffic_used
			WHERE `adminid` = :aid'
		);

		$params = array(
			"customers_used" => $admin['customers_used_new'],
			"domains_used" => $admin['domains_used_new'],
			"diskspace_used" => $admin['diskspace_used_new'],
			"mysqls_used" => $admin['mysqls_used_new'],
			"emails_used" => $admin['emails_used_new'],
			"email_accounts_used" => $admin['email_accounts_used_new'],
			"email_forwarders_used" => $admin['email_forwarders_used_new'],
			"email_quota_used" => $admin['email_quota_used_new'],
			"ftps_used" => $admin['ftps_used_new'],
			"tickets_used" => $admin['tickets_used_new'],
			"subdomains_used" => $admin['subdomains_used_new'],
			"traffic_used" => $admin['traffic_used_new'],
			"aid" => $admin['adminid']
		);
		Database::pexecute($stmt, $params);

		if($returndebuginfo === true) {
			$returnval['admins'][$admin['adminid']] = $admin;
		}
	}

	return $returnval;
}

/**
 * initialize a field-value of an array if not yet initialized
 *
 * @param string $field
 * @param array $arr reference
 * @param int $init_value
 *
 * @return void
 */
function _initArrField($field = null, &$arr, $init_value = 0) {
	if (!isset($arr[$field])) {
		$arr[$field] = $init_value;
	}
}

/**
 * if the customer does not have unlimited resources, add the used resources
 * to the admin-resource-counter
 *
 * @param array $arr reference
 * @param array $customer_arr
 * @param string $used_field
 * @param string $field
 *
 * @return void
 */
function _addResourceCount(&$arr, $customer_arr, $used_field = null, $field = null) {
	_initArrField($used_field, $arr, 0);
	if ($customer_arr[$field] != '-1') {
		$arr[$used_field] += intval($customer_arr[$used_field]);
	}
}

/**
 * if the customer does not have unlimited resources, add the used resources
 * to the admin-resource-counter
 * Special function wrapper for diskspace and traffic as they need to
 * be calculated otherwise to get the -1 for unlimited
 *
 * @param array $arr reference
 * @param array $customer_arr
 * @param string $used_field
 * @param string $field
 *
 * @return void
 */
function _addResourceCountEx(&$arr, $customer_arr, $used_field = null, $field = null) {
	_initArrField($used_field, $arr, 0);
	if ($field == 'diskspace' && ($customer_arr[$field] / 1024) != '-1') {
		$arr[$used_field] += intval($customer_arr[$used_field]);
	}
	elseif ($field == 'traffic_used') {
		$arr[$used_field] += intval($customer_arr[$used_field]);
	}
}
