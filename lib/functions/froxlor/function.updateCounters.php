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

function updateCounters($returndebuginfo = false)
{
	global $db, $theme;
	$returnval = array();

	if($returndebuginfo === true)
	{
		$returnval = array(
			'admins' => array(),
			'customers' => array()
		);
	}

	$admin_resources = array();

	// Customers

	$customers = $db->query('SELECT * FROM `' . TABLE_PANEL_CUSTOMERS . '` ORDER BY `customerid`');

	while($customer = $db->fetch_array($customers))
	{
		if(!isset($admin_resources[$customer['adminid']]))
		{
			$admin_resources[$customer['adminid']] = Array();
		}

		if(!isset($admin_resources[$customer['adminid']]['diskspace_used']))
		{
			$admin_resources[$customer['adminid']]['diskspace_used'] = 0;
		}

		if(($customer['diskspace'] / 1024) != '-1')
		{
			$admin_resources[$customer['adminid']]['diskspace_used']+= intval_ressource($customer['diskspace']);
		}

		if(!isset($admin_resources[$customer['adminid']]['traffic_used']))
		{
			$admin_resources[$customer['adminid']]['traffic_used'] = 0;
		}

		$admin_resources[$customer['adminid']]['traffic_used']+= $customer['traffic_used'];

		if(!isset($admin_resources[$customer['adminid']]['mysqls_used']))
		{
			$admin_resources[$customer['adminid']]['mysqls_used'] = 0;
		}

		if($customer['mysqls'] != '-1')
		{
			$admin_resources[$customer['adminid']]['mysqls_used']+= intval_ressource($customer['mysqls']);
		}

		if(!isset($admin_resources[$customer['adminid']]['ftps_used']))
		{
			$admin_resources[$customer['adminid']]['ftps_used'] = 0;
		}

		if($customer['ftps'] != '-1')
		{
			$admin_resources[$customer['adminid']]['ftps_used']+= intval_ressource($customer['ftps']);
		}

		if(!isset($admin_resources[$customer['adminid']]['tickets_used']))
		{
			$admin_resources[$customer['adminid']]['tickets_used'] = 0;
		}

		if($customer['tickets'] != '-1')
		{
			$admin_resources[$customer['adminid']]['tickets_used']+= intval_ressource($customer['tickets']);
		}

		if(!isset($admin_resources[$customer['adminid']]['emails_used']))
		{
			$admin_resources[$customer['adminid']]['emails_used'] = 0;
		}

		if($customer['emails'] != '-1')
		{
			$admin_resources[$customer['adminid']]['emails_used']+= intval_ressource($customer['emails']);
		}

		if(!isset($admin_resources[$customer['adminid']]['email_accounts_used']))
		{
			$admin_resources[$customer['adminid']]['email_accounts_used'] = 0;
		}

		if($customer['email_accounts'] != '-1')
		{
			$admin_resources[$customer['adminid']]['email_accounts_used']+= intval_ressource($customer['email_accounts']);
		}

		if(!isset($admin_resources[$customer['adminid']]['email_forwarders_used']))
		{
			$admin_resources[$customer['adminid']]['email_forwarders_used'] = 0;
		}

		if($customer['email_forwarders'] != '-1')
		{
			$admin_resources[$customer['adminid']]['email_forwarders_used']+= intval_ressource($customer['email_forwarders']);
		}

		if(!isset($admin_resources[$customer['adminid']]['email_quota_used']))
		{
			$admin_resources[$customer['adminid']]['email_quota_used'] = 0;
		}

		if($customer['email_quota'] != '-1')
		{
			$admin_resources[$customer['adminid']]['email_quota_used']+= intval_ressource($customer['email_quota']);
		}

		if(!isset($admin_resources[$customer['adminid']]['email_autoresponder_used']))
		{
			$admin_resources[$customer['adminid']]['email_autoresponder_used'] = 0;
		}

		if($customer['email_autoresponder'] != '-1')
		{
			$admin_resources[$customer['adminid']]['email_autoresponder_used']+= intval_ressource($customer['email_autoresponder']);
		}

		if(!isset($admin_resources[$customer['adminid']]['subdomains_used']))
		{
			$admin_resources[$customer['adminid']]['subdomains_used'] = 0;
		}

		if($customer['subdomains'] != '-1')
		{
			$admin_resources[$customer['adminid']]['subdomains_used']+= intval_ressource($customer['subdomains']);
		}

		if(!isset($admin_resources[$customer['adminid']]['aps_packages_used']))
		{
			$admin_resources[$customer['adminid']]['aps_packages_used'] = 0;
		}

		if($customer['aps_packages'] != '-1')
		{
			$admin_resources[$customer['adminid']]['aps_packages_used']+= intval_ressource($customer['aps_packages']);
		}

		$customer_mysqls = $db->query_first('SELECT COUNT(*) AS `number_mysqls` FROM `' . TABLE_PANEL_DATABASES . '` WHERE `customerid` = "' . (int)$customer['customerid'] . '"');
		$customer['mysqls_used_new'] = (int)$customer_mysqls['number_mysqls'];
		$customer_emails = $db->query_first('SELECT COUNT(*) AS `number_emails` FROM `' . TABLE_MAIL_VIRTUAL . '` WHERE `customerid` = "' . (int)$customer['customerid'] . '"');
		$customer['emails_used_new'] = (int)$customer_emails['number_emails'];
		$customer_emails_result = $db->query('SELECT `email`, `email_full`, `destination`, `popaccountid` AS `number_email_forwarders` FROM `' . TABLE_MAIL_VIRTUAL . '` WHERE `customerid` = "' . (int)$customer['customerid'] . '" ');
		$customer_email_forwarders = 0;
		$customer_email_accounts = 0;

		while($customer_emails_row = $db->fetch_array($customer_emails_result))
		{
			if($customer_emails_row['destination'] != '')
			{
				$customer_emails_row['destination'] = explode(' ', makeCorrectDestination($customer_emails_row['destination']));
				$customer_email_forwarders+= count($customer_emails_row['destination']);

				if(in_array($customer_emails_row['email_full'], $customer_emails_row['destination']))
				{
					$customer_email_forwarders-= 1;
					$customer_email_accounts++;
				}
			}
		}

		$customer['email_accounts_used_new'] = $customer_email_accounts;
		$customer['email_forwarders_used_new'] = $customer_email_forwarders;
		$customer_ftps = $db->query_first('SELECT COUNT(*) AS `number_ftps` FROM `' . TABLE_FTP_USERS . '` WHERE `customerid` = "' . (int)$customer['customerid'] . '"');
		$customer['ftps_used_new'] = ((int)$customer_ftps['number_ftps'] - 1);
		$customer_tickets = $db->query_first('SELECT COUNT(*) AS `number_tickets` FROM `' . TABLE_PANEL_TICKETS . '` WHERE `answerto` = "0" AND `customerid` = "' . (int)$customer['customerid'] . '"');
		$customer['tickets_used_new'] = (int)$customer_tickets['number_tickets'];
		$customer_subdomains = $db->query_first('SELECT COUNT(*) AS `number_subdomains` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `customerid` = "' . (int)$customer['customerid'] . '" AND `parentdomainid` <> "0"');
		$customer['subdomains_used_new'] = (int)$customer_subdomains['number_subdomains'];
		$customer_email_quota = $db->query_first('SELECT SUM(`quota`) AS `email_quota` FROM `' . TABLE_MAIL_USERS . '` WHERE `customerid` = "' . (int)$customer['customerid'] . '"');
		$customer['email_quota_used_new'] = (int)$customer_email_quota['email_quota'];
		
		$customer_email_autoresponder = $db->query_first('SELECT COUNT(*) AS `number_autoresponder` FROM `' . TABLE_MAIL_AUTORESPONDER . '` WHERE `customerid` = "' . (int)$customer['customerid'] . '"');
		$customer['email_autoresponder_used_new'] = (int)$customer_email_autoresponder['number_autoresponder'];
		$customer_aps_packages = $db->query_first('SELECT COUNT(*) AS `number_apspackages` FROM `' . TABLE_APS_INSTANCES . '` WHERE `CustomerID` = "' . (int)$customer['customerid'] . '"');
		$customer['aps_packages_used_new'] = (int)$customer_aps_packages['number_apspackages'];

		$db->query('UPDATE 
		`' . TABLE_PANEL_CUSTOMERS . '` 
		SET 
			`mysqls_used` = "' . (int)$customer['mysqls_used_new'] . '",
			`emails_used` = "' . (int)$customer['emails_used_new'] . '",
			`email_accounts_used` = "' . (int)$customer['email_accounts_used_new'] . '",
			`email_forwarders_used` = "' . (int)$customer['email_forwarders_used_new'] . '",
			`email_quota_used` = "' . (int)$customer['email_quota_used_new'] . '",
			`email_autoresponder_used` = "' . (int)$customer['email_autoresponder_used_new'] . '",
			`ftps_used` = "' . (int)$customer['ftps_used_new'] . '", 
			`tickets_used` = "' . (int)$customer['tickets_used_new'] . '",
			`subdomains_used` = "' . (int)$customer['subdomains_used_new'] . '",
			`aps_packages_used` = "' . (int)$customer['aps_packages_used_new'] . '"
		WHERE 
			`customerid` = "' . (int)$customer['customerid'] . '"
		');

		if($returndebuginfo === true)
		{
			$returnval['customers'][$customer['customerid']] = $customer;
		}
	}

	// Admins

	$admins = $db->query('SELECT * FROM `' . TABLE_PANEL_ADMINS . '` ORDER BY `adminid`');

	while($admin = $db->fetch_array($admins))
	{
		$admin_customers = $db->query_first('SELECT COUNT(*) AS `number_customers` FROM `' . TABLE_PANEL_CUSTOMERS . '` WHERE `adminid` = "' . (int)$admin['adminid'] . '"');
		$admin['customers_used_new'] = $admin_customers['number_customers'];
		$admin_domains = $db->query_first('SELECT COUNT(*) AS `number_domains` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `adminid` = "' . (int)$admin['adminid'] . '" AND `isemaildomain` = "1"');
		$admin['domains_used_new'] = $admin_domains['number_domains'];

		if(!isset($admin_resources[$admin['adminid']]))
		{
			$admin_resources[$admin['adminid']] = Array();
		}

		if(!isset($admin_resources[$admin['adminid']]['diskspace_used']))
		{
			$admin_resources[$admin['adminid']]['diskspace_used'] = 0;
		}

		$admin['diskspace_used_new'] = $admin_resources[$admin['adminid']]['diskspace_used'];

		if(!isset($admin_resources[$admin['adminid']]['traffic_used']))
		{
			$admin_resources[$admin['adminid']]['traffic_used'] = 0;
		}

		$admin['traffic_used_new'] = $admin_resources[$admin['adminid']]['traffic_used'];

		if(!isset($admin_resources[$admin['adminid']]['mysqls_used']))
		{
			$admin_resources[$admin['adminid']]['mysqls_used'] = 0;
		}

		$admin['mysqls_used_new'] = $admin_resources[$admin['adminid']]['mysqls_used'];

		if(!isset($admin_resources[$admin['adminid']]['ftps_used']))
		{
			$admin_resources[$admin['adminid']]['ftps_used'] = 0;
		}

		$admin['ftps_used_new'] = $admin_resources[$admin['adminid']]['ftps_used'];

		if(!isset($admin_resources[$admin['adminid']]['emails_used']))
		{
			$admin_resources[$admin['adminid']]['emails_used'] = 0;
		}

		$admin['emails_used_new'] = $admin_resources[$admin['adminid']]['emails_used'];

		if(!isset($admin_resources[$admin['adminid']]['email_accounts_used']))
		{
			$admin_resources[$admin['adminid']]['email_accounts_used'] = 0;
		}

		$admin['email_accounts_used_new'] = $admin_resources[$admin['adminid']]['email_accounts_used'];

		if(!isset($admin_resources[$admin['adminid']]['tickets_used']))
		{
			$admin_resources[$admin['adminid']]['tickets_used'] = 0;
		}

		$admin['tickets_used_new'] = $admin_resources[$admin['adminid']]['tickets_used'];

		if(!isset($admin_resources[$admin['adminid']]['email_forwarders_used']))
		{
			$admin_resources[$admin['adminid']]['email_forwarders_used'] = 0;
		}

		$admin['email_forwarders_used_new'] = $admin_resources[$admin['adminid']]['email_forwarders_used'];

		if(!isset($admin_resources[$admin['adminid']]['email_quota_used']))
		{
			$admin_resources[$admin['adminid']]['email_quota_used'] = 0;
		}

		$admin['email_quota_used_new'] = $admin_resources[$admin['adminid']]['email_quota_used'];

		if(!isset($admin_resources[$admin['adminid']]['email_autoresponder_used']))
		{
			$admin_resources[$admin['adminid']]['email_autoresponder_used'] = 0;
		}

                if(!isset($admin_resources[$admin['adminid']]['email_autoresponder_used']))
                {
                        $admin_resources[$admin['adminid']]['email_autoresponder_used'] = 0;
                }

		$admin['email_autoresponder_used_new'] = $admin_resources[$admin['adminid']]['email_autoresponder_used'];

		if(!isset($admin_resources[$admin['adminid']]['subdomains_used']))
		{
			$admin_resources[$admin['adminid']]['subdomains_used'] = 0;
		}

		if(!isset($admin_resources[$admin['adminid']]['aps_packages_used']))
		{
			$admin_resources[$admin['adminid']]['aps_packages_used'] = 0;
		}

		$admin['subdomains_used_new'] = $admin_resources[$admin['adminid']]['subdomains_used'];

		if(!isset($admin_resources[$admin['adminid']]['aps_packages_used']))
		{
			$admin_resources[$admin['adminid']]['aps_packages_used'] = 0;
		}

		$admin['aps_packages_used_new'] = $admin_resources[$admin['adminid']]['aps_packages_used'];

		$db->query('UPDATE 
			`' . TABLE_PANEL_ADMINS . '` 
			SET 
				`customers_used` = "' . (int)$admin['customers_used_new'] . '",
				`domains_used` = "' . (int)$admin['domains_used_new'] . '",
				`diskspace_used` = "' . (int)$admin['diskspace_used_new'] . '",
				`mysqls_used` = "' . (int)$admin['mysqls_used_new'] . '",
				`emails_used` = "' . (int)$admin['emails_used_new'] . '",
				`email_accounts_used` = "' . (int)$admin['email_accounts_used_new'] . '",
				`email_forwarders_used` = "' . (int)$admin['email_forwarders_used_new'] . '",
				`email_quota_used` = "' . (int)$admin['email_quota_used_new'] . '",
				`email_autoresponder_used` = "' . (int)$admin['email_autoresponder_used_new'] . '",
				`ftps_used` = "' . (int)$admin['ftps_used_new'] . '", 
				`tickets_used` = "' . (int)$admin['tickets_used_new'] . '",
				`subdomains_used` = "' . (int)$admin['subdomains_used_new'] . '",
				`traffic_used` = "' . (int)$admin['traffic_used_new'] . '",
				`aps_packages_used` = "' . (int)$admin['aps_packages_used_new'] . '"
			WHERE 
				`adminid` = "' . (int)$admin['adminid'] . '"
			');

		if($returndebuginfo === true)
		{
			$returnval['admins'][$admin['adminid']] = $admin;
		}
	}

	return $returnval;
}
