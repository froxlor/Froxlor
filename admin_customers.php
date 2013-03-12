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
 * @package    Panel
 *
 */

define('AREA', 'admin');

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

$need_root_db_sql_data = true;
require ("./lib/init.php");

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

if($page == 'customers'
   && $userinfo['customers'] != '0')
{
	if($action == '')
	{
		// clear request data
		unset($_SESSION['requestData']);

		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_customers");
		$fields = array(
			'c.loginname' => $lng['login']['username'],
			'a.loginname' => $lng['admin']['admin'],
			'c.name' => $lng['customer']['name'],
			'c.email' => $lng['customer']['email'],
			'c.firstname' => $lng['customer']['firstname'],
			'c.company' => $lng['customer']['company'],
			'c.diskspace' => $lng['customer']['diskspace'],
			'c.diskspace_used' => $lng['customer']['diskspace'] . ' (' . $lng['panel']['used'] . ')',
			'c.traffic' => $lng['customer']['traffic'],
			'c.traffic_used' => $lng['customer']['traffic'] . ' (' . $lng['panel']['used'] . ')'
		);

		if ($settings['system']['backup_enabled'] == '1') {
			$field['c.backup_allowed'] = $lng['backup_allowed'];
		}

		$paging = new paging($userinfo, $db, TABLE_PANEL_CUSTOMERS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$customers = '';
		$result = $db->query("SELECT `c`.*, `a`.`loginname` AS `adminname` " . "FROM `" . TABLE_PANEL_CUSTOMERS . "` `c`, `" . TABLE_PANEL_ADMINS . "` `a` " . "WHERE " . ($userinfo['customers_see_all'] ? '' : " `c`.`adminid` = '" . (int)$userinfo['adminid'] . "' AND ") . "`c`.`adminid`=`a`.`adminid` " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy($settings['panel']['natsorting']) . " " . $paging->getSqlLimit());
		$paging->setEntries($db->num_rows($result));
		$sortcode = $paging->getHtmlSortCode($lng, true);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;

		while($row = $db->fetch_array($result))
		{
			if($paging->checkDisplay($i))
			{
				$domains = $db->query_first("SELECT COUNT(`id`) AS `domains` " . "FROM `" . TABLE_PANEL_DOMAINS . "` " . "WHERE `customerid`='" . (int)$row['customerid'] . "' AND `parentdomainid`='0' AND `id`<> '" . (int)$row['standardsubdomain'] . "'");
				$row['domains'] = intval($domains['domains']);
				$row['traffic_used'] = round($row['traffic_used'] / (1024 * 1024), $settings['panel']['decimal_places']);
				$row['traffic'] = round($row['traffic'] / (1024 * 1024), $settings['panel']['decimal_places']);
				$row['diskspace_used'] = round($row['diskspace_used'] / 1024, $settings['panel']['decimal_places']);
				$row['diskspace'] = round($row['diskspace'] / 1024, $settings['panel']['decimal_places']);
				$last_login = ((int)$row['lastlogin_succ'] == 0) ? $lng['panel']['neverloggedin'] : date('d.m.Y', $row['lastlogin_succ']);

				/**
				 * percent-values for progressbar
				 */
				//For Disk usage
				if ($row['diskspace'] > 0) {
					$disk_percent = round(($row['diskspace_used']*100)/$row['diskspace'], 2);
					$disk_doublepercent = round($disk_percent*2, 2);
				} else {
					$disk_percent = 0;
					$disk_doublepercent = 0;
				}

				if ($row['traffic'] > 0) {
					$traffic_percent = round(($row['traffic_used']*100)/$row['traffic'], 2);
					$traffic_doublepercent = round($traffic_percent*2, 2);
				} else {
					$traffic_percent = 0;
					$traffic_doublepercent = 0;
				}

				$column_style = '';
				$unlock_link = '';
				if($row['loginfail_count'] >= $settings['login']['maxloginattempts']
					&& $row['lastlogin_fail'] > (time() - $settings['login']['deactivatetime'])
				) {
					$column_style = ' style="background-color: #f99122;"';
					$unlock_link = '<a href="'.$filename.'?s='.$s.'&amp;page='.$page.'&amp;action=unlock&amp;id='.$row['customerid'].'">'.$lng['panel']['unlock'].'</a><br />';
				}

				$row = str_replace_array('-1', 'UL', $row, 'diskspace traffic mysqls emails email_accounts email_forwarders ftps tickets subdomains email_autoresponder');
				$row = htmlentities_array($row);
				eval("\$customers.=\"" . getTemplate("customers/customers_customer") . "\";");
				$count++;
			}

			$i++;
		}

		$customercount = $db->num_rows($result);
		eval("echo \"" . getTemplate("customers/customers") . "\";");
	}
	elseif($action == 'su'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid`='" . (int)$id . "' " . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = '" . (int)$userinfo['adminid'] . "' "));
		$destination_user = $result['loginname'];

		if($destination_user != '')
		{
			$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid`='" . (int)$userinfo['userid'] . "' AND `hash`='" . $db->escape($s) . "'");
			$s = md5(uniqid(microtime(), 1));
			$db->query("INSERT INTO `" . TABLE_PANEL_SESSIONS . "` (`hash`, `userid`, `ipaddress`, `useragent`, `lastactivity`, `language`, `adminsession`) VALUES ('" . $db->escape($s) . "', '" . (int)$id . "', '" . $db->escape($result['ipaddress']) . "', '" . $db->escape($result['useragent']) . "', '" . time() . "', '" . $db->escape($result['language']) . "', '0')");
			$log->logAction(ADM_ACTION, LOG_INFO, "switched user and is now '" . $destination_user . "'");
			redirectTo('customer_index.php', Array('s' => $s));
		}
		else
		{
			redirectTo('index.php', Array('action' => 'login'));
		}
	}
	elseif($action == 'unlock'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid`='" . (int)$id . "' " . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = '" . $db->escape($userinfo['adminid']) . "' "));

		if($result['loginname'] != '')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$result = $db->query("UPDATE
					`" . TABLE_PANEL_CUSTOMERS . "`
				SET
					`loginfail_count` = '0'
				WHERE
					`customerid`= '" . (int)$id . "'"
				);
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				ask_yesno('customer_reallyunlock', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['loginname']);
			}
		}
	}
	elseif($action == 'delete'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid`='" . (int)$id . "' " . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = '" . $db->escape($userinfo['adminid']) . "' "));

		if($result['loginname'] != '')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$databases = $db->query("SELECT * FROM " . TABLE_PANEL_DATABASES . " WHERE customerid='" . (int)$id . "' ORDER BY `dbserver`");
				$db_root = new db($sql_root[0]['host'], $sql_root[0]['user'], $sql_root[0]['password'], '');
				$last_dbserver = 0;

				while($row_database = $db->fetch_array($databases))
				{
					if($last_dbserver != $row_database['dbserver'])
					{
						$db_root->query('FLUSH PRIVILEGES;');
						$db_root->close();
						$db_root = new db($sql_root[$row_database['dbserver']]['host'], $sql_root[$row_database['dbserver']]['user'], $sql_root[$row_database['dbserver']]['password'], '');
						$last_dbserver = $row_database['dbserver'];
					}

					if(mysql_get_server_info() < '5.0.2') {
						// failsafe if user has been deleted manually (requires MySQL 4.1.2+)
						$db_root->query('REVOKE ALL PRIVILEGES, GRANT OPTION FROM \'' . $db_root->escape($row_database['databasename']) .'\'',false,true);
					}

					$host_res = $db_root->query("SELECT `Host` FROM `mysql`.`user` WHERE `User`='" . $db_root->escape($row_database['databasename']) . "'");
					while($host = $db_root->fetch_array($host_res))
					{
						// as of MySQL 5.0.2 this also revokes privileges. (requires MySQL 4.1.2+)
						$db_root->query('DROP USER \'' . $db_root->escape($row_database['databasename']). '\'@\'' . $db_root->escape($host['Host']) . '\'', false, true);
						
					}

					$db_root->query('DROP DATABASE IF EXISTS `' . $db_root->escape($row_database['databasename']) . '`');
				}

				$db_root->query('FLUSH PRIVILEGES;');
				$db_root->close();
				$db->query("DELETE FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_PANEL_DATABASES . "` WHERE `customerid`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `customerid`='" . (int)$id . "'");
				$domains_deleted = $db->affected_rows();
				$db->query("DELETE FROM `" . TABLE_PANEL_HTPASSWDS . "` WHERE `customerid`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_PANEL_HTACCESS . "` WHERE `customerid`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid`='" . (int)$id . "' AND `adminsession` = '0'");
				$db->query("DELETE FROM `" . TABLE_PANEL_TRAFFIC . "` WHERE `customerid`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_MAIL_USERS . "` WHERE `customerid`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_MAIL_VIRTUAL . "` WHERE `customerid`='" . (int)$id . "'");
				$result2 = $db->query("SELECT `username` FROM `" . TABLE_FTP_USERS . "` WHERE `customerid`='" . (int)$id . "'");
				while($row = $db->fetch_array($result2))
				{
					$db->query("DELETE FROM `" . TABLE_FTP_QUOTATALLIES . "` WHERE `name`='" . $row['username'] . "'");
				}
				$db->query("DELETE FROM `" . TABLE_FTP_GROUPS . "` WHERE `customerid`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_FTP_USERS . "` WHERE `customerid`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_MAIL_AUTORESPONDER . "` WHERE `customerid`='" . (int)$id . "'");

				// Delete all waiting "create user" -tasks for this user, #276
				// Note: the WHERE selects part of a serialized array, but it should be safe this way
				$db->query("DELETE FROM `" . TABLE_PANEL_TASKS . "` WHERE `type` = '2' AND `data` LIKE '%:\"" . $db->escape($result['loginname']) . "\";%';");

				// remove everything APS-related, #216
				$apsresult = $db->query("SELECT `ID` FROM `".TABLE_APS_INSTANCES."` WHERE `CustomerID`='".(int)$id."'");
				while($apsrow = $db->fetch_array($apsresult))
				{
					// remove all package related settings
					$db->query("DELETE FROM `".TABLE_APS_SETTINGS."` WHERE `InstanceID` = '".(int)$apsrow['ID']."'");
					// maybe some leftovers in the tasks
					$db->query("DELETE FROM `".TABLE_APS_TASKS."` WHERE `InstanceID` = '".(int)$apsrow['ID']."'");
				}
				// now remove all user instances
				$db->query("DELETE FROM `".TABLE_APS_INSTANCES."` WHERE `CustomerID`='".(int)$id."'");
				// eventually some temp-setting-leftovers
				$db->query("DELETE FROM `".TABLE_APS_TEMP_SETTINGS."` WHERE `CustomerID`='".(int)$id."'");
				// eof APS-related removings, #216

				$admin_update_query = "UPDATE `" . TABLE_PANEL_ADMINS . "` SET `customers_used` = `customers_used` - 1 ";
				$admin_update_query.= ", `domains_used` = `domains_used` - 0" . (int)($domains_deleted - $result['subdomains_used']);

				if($result['mysqls'] != '-1')
				{
					$admin_update_query.= ", `mysqls_used` = `mysqls_used` - 0" . (int)$result['mysqls'];
				}

				if($result['emails'] != '-1')
				{
					$admin_update_query.= ", `emails_used` = `emails_used` - 0" . (int)$result['emails'];
				}

				if($result['email_accounts'] != '-1')
				{
					$admin_update_query.= ", `email_accounts_used` = `email_accounts_used` - 0" . (int)$result['email_accounts'];
				}

				if($result['email_forwarders'] != '-1')
				{
					$admin_update_query.= ", `email_forwarders_used` = `email_forwarders_used` - 0" . (int)$result['email_forwarders'];
				}

				if($result['email_quota'] != '-1')
				{
					$admin_update_query.= ", `email_quota_used` = `email_quota_used` - 0" . (int)$result['email_quota'];
				}

				if($result['email_autoresponder'] != '-1')
				{
					$admin_update_query.= ", `email_autoresponder_used` = `email_autoresponder_used` - 0" . (int)$result['email_autoresponder'];
				}

				if($result['subdomains'] != '-1')
				{
					$admin_update_query.= ", `subdomains_used` = `subdomains_used` - 0" . (int)$result['subdomains'];
				}

				if($result['ftps'] != '-1')
				{
					$admin_update_query.= ", `ftps_used` = `ftps_used` - 0" . (int)$result['ftps'];
				}

				if($result['tickets'] != '-1')
				{
					$admin_update_query.= ", `tickets_used` = `tickets_used` - 0" . (int)$result['tickets'];
				}

				if($result['aps_packages'] != '-1')
				{
					$admin_update_query.= ", `aps_packages_used` = `aps_packages_used` - 0" . (int)$result['aps_packages'];
				}

				if(($result['diskspace'] / 1024) != '-1')
				{
					$admin_update_query.= ", `diskspace_used` = `diskspace_used` - 0" . (int)$result['diskspace'];
				}

				$admin_update_query.= " WHERE `adminid` = '" . (int)$result['adminid'] . "'";
				$db->query($admin_update_query);
				$log->logAction(ADM_ACTION, LOG_INFO, "deleted user '" . $result['loginname'] . "'");
				inserttask('1');

				# Using nameserver, insert a task which rebuilds the server config
				if ($settings['system']['bind_enable'])
				{
					inserttask('4');
				}

				if(isset($_POST['delete_userfiles'])
				  && (int)$_POST['delete_userfiles'] == 1)
				{
					inserttask('6', $result['loginname']);
				}

				# Using filesystem - quota, insert a task which cleans the filesystem - quota
				if ($settings['system']['diskquota_enabled'])
				{
					inserttask('10');
				}

				/*
				 * move old tickets to archive
				 */
				$tickets = ticket::customerHasTickets($db, $id);
				if($tickets !== false && isset($tickets[0]))
				{
					foreach($tickets as $ticket)
					{
						$now = time();
						$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$ticket);
						$mainticket->Set('lastchange', $now, true, true);
						$mainticket->Set('lastreplier', '1', true, true);
						$mainticket->Set('status', '3', true, true);
						$mainticket->Update();
						$mainticket->Archive();
						$log->logAction(ADM_ACTION, LOG_NOTICE, "archived ticket '" . $mainticket->Get('subject') . "'");
					}
				}

				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				ask_yesno_withcheckbox('admin_customer_reallydelete', 'admin_customer_alsoremovefiles', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['loginname']);
			}
		}
	}
	elseif($action == 'add')
	{
		if($userinfo['customers_used'] < $userinfo['customers']
		   || $userinfo['customers'] == '-1')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$name = validate($_POST['name'], 'name');
				$firstname = validate($_POST['firstname'], 'first name');
				$company = validate($_POST['company'], 'company');
				$street = validate($_POST['street'], 'street');
				$zipcode = validate($_POST['zipcode'], 'zipcode', '/^[0-9 \-A-Z]*$/');
				$city = validate($_POST['city'], 'city');
				$phone = validate($_POST['phone'], 'phone', '/^[0-9\- \+\(\)\/]*$/');
				$fax = validate($_POST['fax'], 'fax', '/^[0-9\- \+\(\)\/]*$/');
				$email = $idna_convert->encode(validate($_POST['email'], 'email'));
				$customernumber = validate($_POST['customernumber'], 'customer number', '/^[A-Za-z0-9 \-]*$/Di');
				$def_language = validate($_POST['def_language'], 'default language');
				$diskspace = intval_ressource($_POST['diskspace']);
				$gender = intval_ressource($_POST['gender']);

				if(isset($_POST['diskspace_ul']))
				{
					$diskspace = - 1;
				}

				$traffic = doubleval_ressource($_POST['traffic']);

				if(isset($_POST['traffic_ul']))
				{
					$traffic = - 1;
				}

				$subdomains = intval_ressource($_POST['subdomains']);

				if(isset($_POST['subdomains_ul']))
				{
					$subdomains = - 1;
				}

				$emails = intval_ressource($_POST['emails']);

				if(isset($_POST['emails_ul']))
				{
					$emails = - 1;
				}

				$email_accounts = intval_ressource($_POST['email_accounts']);

				if(isset($_POST['email_accounts_ul']))
				{
					$email_accounts = - 1;
				}

				$email_forwarders = intval_ressource($_POST['email_forwarders']);

				if(isset($_POST['email_forwarders_ul']))
				{
					$email_forwarders = - 1;
				}

				if($settings['system']['mail_quota_enabled'] == '1')
				{
					$email_quota = validate($_POST['email_quota'], 'email_quota', '/^\d+$/', 'vmailquotawrong', array('0', ''));

					if(isset($_POST['email_quota_ul']))
					{
						$email_quota = - 1;
					}
				}
				else
				{
					$email_quota = - 1;
				}

				if($settings['autoresponder']['autoresponder_active'] == '1')
				{
					$email_autoresponder = intval_ressource($_POST['email_autoresponder']);

					if(isset($_POST['email_autoresponder_ul']))
					{
						$email_autoresponder = - 1;
					}
				}
				else
				{
					$email_autoresponder = 0;
				}

				$email_imap = 0;
				if(isset($_POST['email_imap']))
					$email_imap = intval_ressource($_POST['email_imap']);

				$email_pop3 = 0;
				if(isset($_POST['email_pop3']))
					$email_pop3 = intval_ressource($_POST['email_pop3']);

				$ftps = 0;
				if(isset($_POST['ftps']))
					$ftps = intval_ressource($_POST['ftps']);

				if(isset($_POST['ftps_ul']))
				{
					$ftps = - 1;
				}

				$tickets = ($settings['ticket']['enabled'] == 1 ? intval_ressource($_POST['tickets']) : 0);

				if(isset($_POST['tickets_ul'])
				   && $settings['ticket']['enabled'] == '1')
				{
					$tickets = - 1;
				}

				$mysqls = intval_ressource($_POST['mysqls']);

				if(isset($_POST['mysqls_ul']))
				{
					$mysqls = - 1;
				}

				if($settings['aps']['aps_active'] == '1')
				{
					$number_of_aps_packages = intval_ressource($_POST['number_of_aps_packages']);

					if(isset($_POST['number_of_aps_packages_ul']))
					{
						$number_of_aps_packages = - 1;
					}
				}
				else
				{
					$number_of_aps_packages = 0;
				}

				$createstdsubdomain = 0;
				if(isset($_POST['createstdsubdomain']))
					$createstdsubdomain = intval($_POST['createstdsubdomain']);
				$password = validate($_POST['new_customer_password'], 'password');
				// only check if not empty,
				// cause empty == generate password automatically
				if($password != '')
				{
					$password = validatePassword($password);
				}

				$backup_allowed = 0;
				if(isset($_POST['backup_allowed']))
					$backup_allowed = intval($_POST['backup_allowed']);

				if ($backup_allowed != 0)
				{
					$backup_allowed = 1;
				}

				// gender out of range? [0,2]
				if ($gender < 0 || $gender > 2) {
					$gender = 0;
				}

				$sendpassword = 0;
				if(isset($_POST['sendpassword']))
					$sendpassword = intval($_POST['sendpassword']);

				$phpenabled = 0;
				if(isset($_POST['phpenabled']))
					$phpenabled = intval($_POST['phpenabled']);

				$perlenabled = 0;
				if(isset($_POST['perlenabled']))
					$perlenabled = intval($_POST['perlenabled']);

				$store_defaultindex = 0;
				if(isset($_POST['store_defaultindex']))
					$store_defaultindex = intval($_POST['store_defaultindex']);

				$diskspace = $diskspace * 1024;
				$traffic = $traffic * 1024 * 1024;

				if(((($userinfo['diskspace_used'] + $diskspace) > $userinfo['diskspace']) && ($userinfo['diskspace'] / 1024) != '-1')
				   || ((($userinfo['mysqls_used'] + $mysqls) > $userinfo['mysqls']) && $userinfo['mysqls'] != '-1')
				   || ((($userinfo['emails_used'] + $emails) > $userinfo['emails']) && $userinfo['emails'] != '-1')
				   || ((($userinfo['email_accounts_used'] + $email_accounts) > $userinfo['email_accounts']) && $userinfo['email_accounts'] != '-1')
				   || ((($userinfo['email_forwarders_used'] + $email_forwarders) > $userinfo['email_forwarders']) && $userinfo['email_forwarders'] != '-1')
				   || ((($userinfo['email_quota_used'] + $email_quota) > $userinfo['email_quota']) && $userinfo['email_quota'] != '-1' && $settings['system']['mail_quota_enabled'] == '1')
				   || ((($userinfo['email_autoresponder_used'] + $email_autoresponder) > $userinfo['email_autoresponder']) && $userinfo['email_autoresponder'] != '-1' && $settings['autoresponder']['autoresponder_active'] == '1')
				   || ((($userinfo['ftps_used'] + $ftps) > $userinfo['ftps']) && $userinfo['ftps'] != '-1')
				   || ((($userinfo['tickets_used'] + $tickets) > $userinfo['tickets']) && $userinfo['tickets'] != '-1')
				   || ((($userinfo['subdomains_used'] + $subdomains) > $userinfo['subdomains']) && $userinfo['subdomains'] != '-1')
				   || ((($userinfo['aps_packages_used'] + $number_of_aps_packages) > $userinfo['aps_packages']) && $userinfo['aps_packages'] != '-1' && $settings['aps']['aps_active'] == '1')
				   || (($diskspace / 1024) == '-1' && ($userinfo['diskspace'] / 1024) != '-1')
				   || ($mysqls == '-1' && $userinfo['mysqls'] != '-1')
				   || ($emails == '-1' && $userinfo['emails'] != '-1')
				   || ($email_accounts == '-1' && $userinfo['email_accounts'] != '-1')
				   || ($email_forwarders == '-1' && $userinfo['email_forwarders'] != '-1')
				   || ($email_quota == '-1' && $userinfo['email_quota'] != '-1' && $settings['system']['mail_quota_enabled'] == '1')
				   || ($email_autoresponder == '-1' && $userinfo['email_autoresponder'] != '-1' && $settings['autoresponder']['autoresponder_active'] == '1')
				   || ($ftps == '-1' && $userinfo['ftps'] != '-1')
				   || ($tickets == '-1' && $userinfo['tickets'] != '-1')
				   || ($subdomains == '-1' && $userinfo['subdomains'] != '-1')
				   || ($number_of_aps_packages == '-1' && $userinfo['aps_packages'] != '-1'))
				{
					standard_error('youcantallocatemorethanyouhave');
					exit;
				}

				// Either $name and $firstname or the $company must be inserted

				if($name == ''
				   && $company == '')
				{
					standard_error(array('stringisempty', 'myname'));
				}
				elseif($firstname == ''
				       && $company == '')
				{
					standard_error(array('stringisempty', 'myfirstname'));
				}
				elseif($email == '')
				{
					standard_error(array('stringisempty', 'emailadd'));
				}
				elseif(!validateEmail($email))
				{
					standard_error('emailiswrong', $email);
				}
				else
				{
					if(isset($_POST['new_loginname'])
					   && $_POST['new_loginname'] != '')
					{
						$accountnumber = intval($settings['system']['lastaccountnumber']);
						$loginname = validate($_POST['new_loginname'], 'loginname', '/^[a-z0-9\-_]+$/i');

						// Accounts which match systemaccounts are not allowed, filtering them

						if(preg_match('/^' . preg_quote($settings['customer']['accountprefix'], '/') . '([0-9]+)/', $loginname))
						{
							standard_error('loginnameissystemaccount', $settings['customer']['accountprefix']);
						}
						
						//Additional filtering for Bug #962
						if(function_exists('posix_getpwnam') && !in_array("posix_getpwnam",explode(",",ini_get('disable_functions'))) && posix_getpwnam($loginname)) {
							standard_error('loginnameissystemaccount', $settings['customer']['accountprefix']);
						}
					}
					else
					{
						$accountnumber = intval($settings['system']['lastaccountnumber']) + 1;
						$loginname = $settings['customer']['accountprefix'] . $accountnumber;
					}

					// Check if the account already exists

					$loginname_check = $db->query_first("SELECT `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `loginname` = '" . $db->escape($loginname) . "'");
					$loginname_check_admin = $db->query_first("SELECT `loginname` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `loginname` = '" . $db->escape($loginname) . "'");

					if(strtolower($loginname_check['loginname']) == strtolower($loginname)
					   || strtolower($loginname_check_admin['loginname']) == strtolower($loginname))
					{
						standard_error('loginnameexists', $loginname);
					}
					elseif(!validateUsername($loginname, $settings['panel']['unix_names'], 14 - strlen($settings['customer']['mysqlprefix'])))
					{
						standard_error('loginnameiswrong', $loginname);
					}

					$guid = intval($settings['system']['lastguid']) + 1;
					$documentroot = makeCorrectDir($settings['system']['documentroot_prefix'] . '/' . $loginname);

					if(file_exists($documentroot))
					{
						standard_error('documentrootexists', $documentroot);
					}

					if($createstdsubdomain != '1')
					{
						$createstdsubdomain = '0';
					}

					if($phpenabled != '0')
					{
						$phpenabled = '1';
					}

					if($perlenabled != '0')
					{
						$perlenabled = '1';
					}

					if($password == '')
					{
						$password = substr(md5(uniqid(microtime(), 1)), 12, 6);
					}

					$_theme = $settings['panel']['default_theme'];

					$result = $db->query(
						"INSERT INTO `" . TABLE_PANEL_CUSTOMERS . "` SET
						`adminid` = '" . (int)$userinfo['adminid'] . "',
						`loginname` = '" . $db->escape($loginname) . "',
						`password` = '" . md5($password) . "',
						`name` = '" . $db->escape($name) . "',
						`firstname` = '" . $db->escape($firstname) . "',
						`gender` = '" . (int)$gender . "',
						`company` = '" . $db->escape($company) . "',
						`street` = '" . $db->escape($street) . "',
						`zipcode` = '" . $db->escape($zipcode) . "',
						`city` = '" . $db->escape($city) . "',
						`phone` = '" . $db->escape($phone) . "',
						`fax` = '" . $db->escape($fax) . "',
						`email` = '" . $db->escape($email) . "',
						`customernumber` = '" . $db->escape($customernumber) . "',
						`def_language` = '" . $db->escape($def_language) . "',
						`documentroot` = '" . $db->escape($documentroot) . "',
						`guid` = '" . $db->escape($guid) . "',
						`diskspace` = '" . $db->escape($diskspace) . "',
						`traffic` = '" . $db->escape($traffic) . "',
						`subdomains` = '" . $db->escape($subdomains) . "',
						`emails` = '" . $db->escape($emails) . "',
						`email_accounts` = '" . $db->escape($email_accounts) . "',
						`email_forwarders` = '" . $db->escape($email_forwarders) . "',
						`email_quota` = '" . $db->escape($email_quota) . "',
						`ftps` = '" . $db->escape($ftps) . "',
						`tickets` = '" . $db->escape($tickets) . "',
						`mysqls` = '" . $db->escape($mysqls) . "',
						`standardsubdomain` = '0',
						`phpenabled` = '" . $db->escape($phpenabled) . "',
						`imap` = '" . $db->escape($email_imap) . "',
						`pop3` = '" . $db->escape($email_pop3) . "',
						`aps_packages` = '" . (int)$number_of_aps_packages . "',
						`perlenabled` = '" . $db->escape($perlenabled) . "',
						`email_autoresponder` = '" . $db->escape($email_autoresponder) . "',
						`backup_allowed` = '" . $db->escape($backup_allowed) . "',
						`theme` = '" . $db->escape($_theme) . "'"
					);
					$customerid = $db->insert_id();
					$admin_update_query = "UPDATE `" . TABLE_PANEL_ADMINS . "` SET `customers_used` = `customers_used` + 1";

					if($mysqls != '-1')
					{
						$admin_update_query.= ", `mysqls_used` = `mysqls_used` + 0" . (int)$mysqls;
					}

					if($emails != '-1')
					{
						$admin_update_query.= ", `emails_used` = `emails_used` + 0" . (int)$emails;
					}

					if($email_accounts != '-1')
					{
						$admin_update_query.= ", `email_accounts_used` = `email_accounts_used` + 0" . (int)$email_accounts;
					}

					if($email_forwarders != '-1')
					{
						$admin_update_query.= ", `email_forwarders_used` = `email_forwarders_used` + 0" . (int)$email_forwarders;
					}

					if($email_quota != '-1')
					{
						$admin_update_query.= ", `email_quota_used` = `email_quota_used` + 0" . (int)$email_quota;
					}

					if($email_autoresponder != '-1'
						&& $settings['autoresponder']['autoresponder_active'] == 1)
					{
						$admin_update_query.= ", `email_autoresponder_used` = `email_autoresponder_used` + 0" . (int)$email_autoresponder;
					}

					if($subdomains != '-1')
					{
						$admin_update_query.= ", `subdomains_used` = `subdomains_used` + 0" . (int)$subdomains;
					}

					if($ftps != '-1')
					{
						$admin_update_query.= ", `ftps_used` = `ftps_used` + 0" . (int)$ftps;
					}

					if($tickets != '-1'
					   && $settings['ticket']['enabled'] == 1)
					{
						$admin_update_query.= ", `tickets_used` = `tickets_used` + 0" . (int)$tickets;
					}

					if(($diskspace / 1024) != '-1')
					{
						$admin_update_query.= ", `diskspace_used` = `diskspace_used` + 0" . (int)$diskspace;
					}

					if($number_of_aps_packages != '-1')
					{
						$admin_update_query.= ", `aps_packages_used` = `aps_packages_used` + 0" . (int)$number_of_aps_packages;
					}

					$admin_update_query.= " WHERE `adminid` = '" . (int)$userinfo['adminid'] . "'";
					$db->query($admin_update_query);
					$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` " . "SET `value`='" . $db->escape($guid) . "' " . "WHERE `settinggroup`='system' AND `varname`='lastguid'");

					if($accountnumber != intval($settings['system']['lastaccountnumber']))
					{
						$db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` " . "SET `value`='" . $db->escape($accountnumber) . "' " . "WHERE `settinggroup`='system' AND `varname`='lastaccountnumber'");
					}

					$log->logAction(ADM_ACTION, LOG_INFO, "added user '" . $loginname . "'");
					inserttask('2', $loginname, $guid, $guid, $store_defaultindex);

					# Using filesystem - quota, insert a task which cleans the filesystem - quota
					if ($settings['system']['diskquota_enabled'])
					{
						inserttask('10');
					}
					// Add htpasswd for the webalizer stats

					if(CRYPT_STD_DES == 1)
					{
						$saltfordescrypt = substr(md5(uniqid(microtime(), 1)), 4, 2);
						$htpasswdPassword = crypt($password, $saltfordescrypt);
					}
					else
					{
						$htpasswdPassword = crypt($password);
					}

					if($settings['system']['awstats_enabled'] == '1')
					{
						$db->query("INSERT INTO `" . TABLE_PANEL_HTPASSWDS . "` " . "(`customerid`, `username`, `password`, `path`) " . "VALUES ('" . (int)$customerid . "', '" . $db->escape($loginname) . "', '" . $db->escape($htpasswdPassword) . "', '" . $db->escape(makeCorrectDir($documentroot . '/awstats/')) . "')");
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added awstats htpasswd for user '" . $loginname . "'");
					}
					else
					{
						$db->query("INSERT INTO `" . TABLE_PANEL_HTPASSWDS . "` " . "(`customerid`, `username`, `password`, `path`) " . "VALUES ('" . (int)$customerid . "', '" . $db->escape($loginname) . "', '" . $db->escape($htpasswdPassword) . "', '" . $db->escape(makeCorrectDir($documentroot . '/webalizer/')) . "')");
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added webalizer htpasswd for user '" . $loginname . "'");
					}

					inserttask('1');
					$cryptPassword = makeCryptPassword($db->escape($password),1);
					$result = $db->query("INSERT INTO `" . TABLE_FTP_USERS . "` " . "(`customerid`, `username`, `password`, `homedir`, `login_enabled`, `uid`, `gid`) " . "VALUES ('" . (int)$customerid . "', '" . $db->escape($loginname) . "', '" . $db->escape($cryptPassword) . "', '" . $db->escape($documentroot) . "', 'y', '" . (int)$guid . "', '" . (int)$guid . "')");
					$result = $db->query("INSERT INTO `" . TABLE_FTP_GROUPS . "` " . "(`customerid`, `groupname`, `gid`, `members`) " . "VALUES ('" . (int)$customerid . "', '" . $db->escape($loginname) . "', '" . $db->escape($guid) . "', '" . $db->escape($loginname) . "')");
					$result = $db->query("INSERT INTO `" . TABLE_FTP_QUOTATALLIES . "` (`name`, `quota_type`, `bytes_in_used`, `bytes_out_used`, `bytes_xfer_used`, `files_in_used`, `files_out_used`, `files_xfer_used`) VALUES ('" . $db->escape($loginname) . "', 'user', '0', '0', '0', '0', '0', '0')");
					$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added ftp-account for user '" . $loginname . "'");

					if($createstdsubdomain == '1')
					{
						if (isset($settings['system']['stdsubdomain'])
							&& $settings['system']['stdsubdomain'] != ''
						) {
							$_stdsubdomain = $loginname . '.' . $settings['system']['stdsubdomain'];
						}
						else
						{
							$_stdsubdomain = $loginname . '.' . $settings['system']['hostname'];
						}

						$db->query("INSERT INTO `" . TABLE_PANEL_DOMAINS . "` SET " .
							"`domain` = '". $db->escape($_stdsubdomain) . "', " .
							"`customerid` = '" . (int)$customerid . "', " .
							"`adminid` = '" . (int)$userinfo['adminid'] . "', " .
							"`parentdomainid` = '-1', " .
							"`ipandport` = '" . $db->escape($settings['system']['defaultip']) . "', " .
							"`documentroot` = '" . $db->escape($documentroot) . "', " .
							"`zonefile` = '', " .
							"`isemaildomain` = '0', " .
							"`caneditdomain` = '0', " .
							"`openbasedir` = '1', " .
							"`safemode` = '1', " .
							"`speciallogfile` = '0', " .
							"`specialsettings` = '', " .
							"`add_date` = '".date('Y-m-d')."'");
						$domainid = $db->insert_id();
						$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `standardsubdomain`=\'' . (int)$domainid . '\' WHERE `customerid`=\'' . (int)$customerid . '\'');
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added standardsubdomain for user '" . $loginname . "'");
						inserttask('1');
					}

					if($sendpassword == '1')
					{
						$replace_arr = array(
							'FIRSTNAME' => $firstname,
							'NAME' => $name,
							'COMPANY' => $company,
							'SALUTATION' => getCorrectUserSalutation(array('firstname' => $firstname, 'name' => $name, 'company' => $company)),
							'USERNAME' => $loginname,
							'PASSWORD' => $password
						);

						// Get mail templates from database; the ones from 'admin' are fetched for fallback

						$result = $db->query_first('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($def_language) . '\' AND `templategroup`=\'mails\' AND `varname`=\'createcustomer_subject\'');
						$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['createcustomer']['subject']), $replace_arr));
						$result = $db->query_first('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($def_language) . '\' AND `templategroup`=\'mails\' AND `varname`=\'createcustomer_mailbody\'');
						$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $lng['mails']['createcustomer']['mailbody']), $replace_arr));

						$_mailerror = false;
						try {
							$mail->Subject = $mail_subject;
							$mail->AltBody = $mail_body;
							$mail->MsgHTML(str_replace("\n", "<br />", $mail_body));
							$mail->AddAddress($email, getCorrectUserSalutation(array('firstname' => $firstname, 'name' => $name, 'company' => $company)));
							$mail->Send();
						} catch(phpmailerException $e) {
							$mailerr_msg = $e->errorMessage();
							$_mailerror = true;
						} catch (Exception $e) {
							$mailerr_msg = $e->getMessage();
							$_mailerror = true;
						}

						if ($_mailerror) {
							$log->logAction(ADM_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
							standard_error('errorsendingmail', $email);
						}

						$mail->ClearAddresses();
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically sent password to user '" . $loginname . "'");
					}

					redirectTo($filename, Array('page' => $page, 's' => $s));
				}
			}
			else
			{
				$language_options = '';

				while(list($language_file, $language_name) = each($languages))
				{
					$language_options.= makeoption($language_name, $language_file, $settings['panel']['standardlanguage'], true);
				}

				$diskspace_ul = makecheckbox('diskspace_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$traffic_ul = makecheckbox('traffic_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$subdomains_ul = makecheckbox('subdomains_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$emails_ul = makecheckbox('emails_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$email_accounts_ul = makecheckbox('email_accounts_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$email_forwarders_ul = makecheckbox('email_forwarders_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$email_quota_ul = makecheckbox('email_quota_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$email_autoresponder_ul = makecheckbox('email_autoresponder_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$ftps_ul = makecheckbox('ftps_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$tickets_ul = makecheckbox('tickets_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$mysqls_ul = makecheckbox('mysqls_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				$number_of_aps_packages_ul = makecheckbox('number_of_aps_packages_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
				/*
				$createstdsubdomain = makeyesno('createstdsubdomain', '1', '0', '1');
				$email_imap = makeyesno('email_imap', '1', '0', '1');
				$email_pop3 = makeyesno('email_pop3', '1', '0', '1');
				$sendpassword = makeyesno('sendpassword', '1', '0', '1');
				$phpenabled = makeyesno('phpenabled', '1', '0', '1');
				$perlenabled = makeyesno('perlenabled', '1', '0', '0');
				$store_defaultindex = makeyesno('store_defaultindex', '1', '0', '1');
				*/
				// why still makeyesno for this one?
				$backup_allowed = makeyesno('backup_allowed', '1', '0', '0');

				$gender_options = makeoption($lng['gender']['undef'], 0, true, true, true);
				$gender_options .= makeoption($lng['gender']['male'], 1, null, true, true);
				$gender_options .= makeoption($lng['gender']['female'], 2, null, true, true);

				$customer_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/customer/formfield.customer_add.php';
				$customer_add_form = htmlform::genHTMLForm($customer_add_data);

				$title = $customer_add_data['customer_add']['title'];
				$image = $customer_add_data['customer_add']['image'];

				eval("echo \"" . getTemplate("customers/customers_add") . "\";");
			}
		}
	}
	elseif($action == 'edit'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid`='" . (int)$id . "' " . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = '" . (int)$userinfo['adminid'] . "' "));

		if($result['loginname'] != '')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$name = validate($_POST['name'], 'name');
				$firstname = validate($_POST['firstname'], 'first name');
				$company = validate($_POST['company'], 'company');
				$street = validate($_POST['street'], 'street');
				$zipcode = validate($_POST['zipcode'], 'zipcode', '/^[0-9 \-A-Z]*$/');
				$city = validate($_POST['city'], 'city');
				$phone = validate($_POST['phone'], 'phone', '/^[0-9\- \+\(\)\/]*$/');
				$fax = validate($_POST['fax'], 'fax', '/^[0-9\- \+\(\)\/]*$/');
				$email = $idna_convert->encode(validate($_POST['email'], 'email'));
				$customernumber = validate($_POST['customernumber'], 'customer number', '/^[A-Za-z0-9 \-]*$/Di');
				$def_language = validate($_POST['def_language'], 'default language');
				$password = validate($_POST['new_customer_password'], 'new password');
				$diskspace = intval_ressource($_POST['diskspace']);
				$gender = intval_ressource($_POST['gender']);

				if(isset($_POST['diskspace_ul']))
				{
					$diskspace = - 1;
				}

				$traffic = doubleval_ressource($_POST['traffic']);

				if(isset($_POST['traffic_ul']))
				{
					$traffic = - 1;
				}

				$subdomains = intval_ressource($_POST['subdomains']);

				if(isset($_POST['subdomains_ul']))
				{
					$subdomains = - 1;
				}

				$emails = intval_ressource($_POST['emails']);

				if(isset($_POST['emails_ul']))
				{
					$emails = - 1;
				}

				$email_accounts = intval_ressource($_POST['email_accounts']);

				if(isset($_POST['email_accounts_ul']))
				{
					$email_accounts = - 1;
				}

				$email_forwarders = intval_ressource($_POST['email_forwarders']);

				if(isset($_POST['email_forwarders_ul']))
				{
					$email_forwarders = - 1;
				}

				if($settings['system']['mail_quota_enabled'] == '1')
				{
					$email_quota = validate($_POST['email_quota'], 'email_quota', '/^\d+$/', 'vmailquotawrong', array('0', ''));

					if(isset($_POST['email_quota_ul']))
					{
						$email_quota = - 1;
					}
				}
				else
				{
					$email_quota = - 1;
				}

				if($settings['autoresponder']['autoresponder_active'] == '1')
				{
					$email_autoresponder = intval_ressource($_POST['email_autoresponder']);

					if(isset($_POST['email_autoresponder_ul']))
					{
						$email_autoresponder = - 1;
					}
				}
				else
				{
					$email_autoresponder = 0;
				}

				$email_imap = 0;
				if(isset($_POST['email_imap']))
					$email_imap = intval_ressource($_POST['email_imap']);

				$email_pop3 = 0;
				if(isset($_POST['email_pop3']))
					$email_pop3 = intval_ressource($_POST['email_pop3']);

				$ftps = 0;
				if(isset($_POST['ftps']))
					$ftps = intval_ressource($_POST['ftps']);

				if(isset($_POST['ftps_ul']))
				{
					$ftps = - 1;
				}

				$tickets = ($settings['ticket']['enabled'] == 1 ? intval_ressource($_POST['tickets']) : 0);

				if(isset($_POST['tickets_ul'])
				   && $settings['ticket']['enabled'] == '1')
				{
					$tickets = - 1;
				}

				$backup_allowed = 0;
				if (isset($_POST['backup_allowed']))
					$backup_allowed = intval($_POST['backup_allowed']);

				if($backup_allowed != '0'){
					$backup_allowed = 1;
				}

				// gender out of range? [0,2]
				if ($gender < 0 || $gender > 2) {
					$gender = 0;
				}

				$mysqls = 0;
				if(isset($_POST['mysqls']))
					$mysqls = intval_ressource($_POST['mysqls']);

				if(isset($_POST['mysqls_ul']))
				{
					$mysqls = - 1;
				}

				if($settings['aps']['aps_active'] == '1')
				{
					$number_of_aps_packages = intval_ressource($_POST['number_of_aps_packages']);

					if(isset($_POST['number_of_aps_packages_ul']))
					{
						$number_of_aps_packages = - 1;
					}
				}
				else
				{
					$number_of_aps_packages = 0;
				}

				$createstdsubdomain = 0;
				if(isset($_POST['createstdsubdomain']))
					$createstdsubdomain = intval($_POST['createstdsubdomain']);

				$deactivated = 0;
				if(isset($_POST['deactivated']))
					$deactivated = intval($_POST['deactivated']);

				$phpenabled = 0;
				if(isset($_POST['phpenabled']))
					$phpenabled = intval($_POST['phpenabled']);

				$perlenabled = 0;
				if(isset($_POST['perlenabled']))
					$perlenabled = intval($_POST['perlenabled']);
				$diskspace = $diskspace * 1024;
				$traffic = $traffic * 1024 * 1024;

				if(((($userinfo['diskspace_used'] + $diskspace - $result['diskspace']) > $userinfo['diskspace']) && ($userinfo['diskspace'] / 1024) != '-1')
				   || ((($userinfo['mysqls_used'] + $mysqls - $result['mysqls']) > $userinfo['mysqls']) && $userinfo['mysqls'] != '-1')
				   || ((($userinfo['emails_used'] + $emails - $result['emails']) > $userinfo['emails']) && $userinfo['emails'] != '-1')
				   || ((($userinfo['email_accounts_used'] + $email_accounts - $result['email_accounts']) > $userinfo['email_accounts']) && $userinfo['email_accounts'] != '-1')
				   || ((($userinfo['email_forwarders_used'] + $email_forwarders - $result['email_forwarders']) > $userinfo['email_forwarders']) && $userinfo['email_forwarders'] != '-1')
				   || ((($userinfo['email_quota_used'] + $email_quota - $result['email_quota']) > $userinfo['email_quota']) && $userinfo['email_quota'] != '-1' && $settings['system']['mail_quota_enabled'] == '1')
				   || ((($userinfo['email_autoresponder_used'] + $email_autoresponder - $result['email_autoresponder']) > $userinfo['email_autoresponder']) && $userinfo['email_autoresponder'] != '-1' && $settings['autoresponder']['autoresponder_active'] == '1')
				   || ((($userinfo['ftps_used'] + $ftps - $result['ftps']) > $userinfo['ftps']) && $userinfo['ftps'] != '-1')
				   || ((($userinfo['tickets_used'] + $tickets - $result['tickets']) > $userinfo['tickets']) && $userinfo['tickets'] != '-1')
				   || ((($userinfo['subdomains_used'] + $subdomains - $result['subdomains']) > $userinfo['subdomains']) && $userinfo['subdomains'] != '-1')
				   || (($diskspace / 1024) == '-1' && ($userinfo['diskspace'] / 1024) != '-1')
				   || ((($userinfo['aps_packages'] + $number_of_aps_packages - $result['aps_packages']) > $userinfo['aps_packages']) && $userinfo['aps_packages'] != '-1' && $settings['aps']['aps_active'] == '1')
				   || ($mysqls == '-1' && $userinfo['mysqls'] != '-1')
				   || ($emails == '-1' && $userinfo['emails'] != '-1')
				   || ($email_accounts == '-1' && $userinfo['email_accounts'] != '-1')
				   || ($email_forwarders == '-1' && $userinfo['email_forwarders'] != '-1')
				   || ($email_quota == '-1' && $userinfo['email_quota'] != '-1' && $settings['system']['mail_quota_enabled'] == '1')
				   || ($email_autoresponder == '-1' && $userinfo['email_autoresponder'] != '-1' && $settings['autoresponder']['autoresponder_active'] == '1')
				   || ($ftps == '-1' && $userinfo['ftps'] != '-1')
				   || ($tickets == '-1' && $userinfo['tickets'] != '-1')
				   || ($subdomains == '-1' && $userinfo['subdomains'] != '-1')
				   || ($number_of_aps_packages == '-1' && $userinfo['aps_packages'] != '-1'))
				{
					standard_error('youcantallocatemorethanyouhave');
					exit;
				}

				// Either $name and $firstname or the $company must be inserted

				if($name == ''
				   && $company == '')
				{
					standard_error(array('stringisempty', 'myname'));
				}
				elseif($firstname == ''
				       && $company == '')
				{
					standard_error(array('stringisempty', 'myfirstname'));
				}
				elseif($email == '')
				{
					standard_error(array('stringisempty', 'emailadd'));
				}
				elseif(!validateEmail($email))
				{
					standard_error('emailiswrong', $email);
				}
				else
				{
					if($password != '')
					{
						$password = validatePassword($password);
						$password = md5($password);
					}
					else
					{
						$password = $result['password'];
					}

					if($createstdsubdomain != '1')
					{
						$createstdsubdomain = '0';
					}

					if($createstdsubdomain == '1'
					   && $result['standardsubdomain'] == '0')
					{
						if (isset($settings['system']['stdsubdomain'])
							&& $settings['system']['stdsubdomain'] != ''
						) {
							$_stdsubdomain = $result['loginname'] . '.' . $settings['system']['stdsubdomain'];
						}
						else
						{
							$_stdsubdomain = $result['loginname'] . '.' . $settings['system']['hostname'];
						}

						$db->query("INSERT INTO `" . TABLE_PANEL_DOMAINS . "` " . "(`domain`, `customerid`, `adminid`, `parentdomainid`, `ipandport`, `documentroot`, `zonefile`, `isemaildomain`, `caneditdomain`, `openbasedir`, `safemode`, `speciallogfile`, `specialsettings`, `add_date`) " . "VALUES ('" . $db->escape($_stdsubdomain) . "', '" . (int)$result['customerid'] . "', '" . (int)$userinfo['adminid'] . "', '-1', '" . $db->escape($settings['system']['defaultip']) . "', '" . $db->escape($result['documentroot']) . "', '', '0', '0', '1', '1', '0', '', '".date('Y-m-d')."')");
						$domainid = $db->insert_id();
						$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `standardsubdomain`=\'' . (int)$domainid . '\' WHERE `customerid`=\'' . (int)$result['customerid'] . '\'');
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically added standardsubdomain for user '" . $result['loginname'] . "'");
						inserttask('1');
					}

					if($createstdsubdomain == '0'
					   && $result['standardsubdomain'] != '0')
					{
						$db->query('DELETE FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `id`=\'' . (int)$result['standardsubdomain'] . '\'');
						$db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `standardsubdomain`=\'0\' WHERE `customerid`=\'' . (int)$result['customerid'] . '\'');
						$log->logAction(ADM_ACTION, LOG_NOTICE, "automatically deleted standardsubdomain for user '" . $result['loginname'] . "'");
						inserttask('1');
					}

					if($deactivated != '1')
					{
						$deactivated = '0';
					}

					if($phpenabled != '0')
					{
						$phpenabled = '1';
					}

					if($perlenabled != '0')
					{
						$perlenabled = '1';
					}

					if($phpenabled != $result['phpenabled']
						|| $perlenabled != $result['perlenabled'])
					{
						inserttask('1');
					}

					if($deactivated != $result['deactivated'])
					{
						$db->query("UPDATE `" . TABLE_MAIL_USERS . "` SET `postfix`='" . (($deactivated) ? 'N' : 'Y') . "', `pop3`='" . (($deactivated) ? '0' : (int)$result['pop3']) . "', `imap`='" . (($deactivated) ? '0' : (int)$result['imap']) . "' WHERE `customerid`='" . (int)$id . "'");
						$db->query("UPDATE `" . TABLE_FTP_USERS . "` SET `login_enabled`='" . (($deactivated) ? 'N' : 'Y') . "' WHERE `customerid`='" . (int)$id . "'");
						$db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `deactivated`='" . (int)$deactivated . "' WHERE `customerid`='" . (int)$id . "'");

						/* Retrieve customer's databases */
						$databases = $db->query("SELECT * FROM " . TABLE_PANEL_DATABASES . " WHERE customerid='" . (int)$id . "' ORDER BY `dbserver`");
						$db_root = new db($sql_root[0]['host'], $sql_root[0]['user'], $sql_root[0]['password'], '');
						$last_dbserver = 0;

						/* For each of them */
						while($row_database = $db->fetch_array($databases))
						{
							if($last_dbserver != $row_database['dbserver'])
							{
								$db_root->query('FLUSH PRIVILEGES;');
								$db_root->close();
								$db_root = new db($sql_root[$row_database['dbserver']]['host'], $sql_root[$row_database['dbserver']]['user'], $sql_root[$row_database['dbserver']]['password'], '');
								$last_dbserver = $row_database['dbserver'];
							}

							foreach(array_unique(explode(',', $settings['system']['mysql_access_host'])) as $mysql_access_host)
							{
								$mysql_access_host = trim($mysql_access_host);

								/* Prevent access, if deactivated */
								if($deactivated)
								{
									// failsafe if user has been deleted manually (requires MySQL 4.1.2+)
									$db_root->query('REVOKE ALL PRIVILEGES, GRANT OPTION FROM \'' . $db_root->escape($row_database['databasename']) .'\'',false,true);
								}
								else /* Otherwise grant access */
								{
									$db_root->query('GRANT ALL PRIVILEGES ON `' . $db_root->escape($row_database['databasename']) .'`.* TO `' . $db_root->escape($row_database['databasename']) . '`@`' . $db_root->escape($mysql_access_host) . '`');
									$db_root->query('GRANT ALL PRIVILEGES ON `' . str_replace('_', '\_', $db_root->escape($row_database['databasename'])) . '` . * TO `' . $db_root->escape($row_database['databasename']) . '`@`' . $db_root->escape($mysql_access_host) . '`');
								}
							}
						}

						/* At last flush the new privileges */
						$db_root->query('FLUSH PRIVILEGES;');
						$db_root->close();

						$log->logAction(ADM_ACTION, LOG_INFO, "deactivated user '" . $result['loginname'] . "'");
						inserttask('1');
					}

					// Disable or enable POP3 Login for customers Mail Accounts

					if($email_pop3 != $result['pop3'])
					{
						$db->query("UPDATE `" . TABLE_MAIL_USERS . "` SET `pop3`='" . (int)$email_pop3 . "' WHERE `customerid`='" . (int)$id . "'");
					}

					// Disable or enable IMAP Login for customers Mail Accounts

					if($email_imap != $result['imap'])
					{
						$db->query("UPDATE `" . TABLE_MAIL_USERS . "` SET `imap`='" . (int)$email_imap . "' WHERE `customerid`='" . (int)$id . "'");
					}

					// $db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `name`='" . $db->escape($name) . "', `firstname`='" . $db->escape($firstname) . "', `company`='" . $db->escape($company) . "', `street`='" . $db->escape($street) . "', `zipcode`='" . $db->escape($zipcode) . "', `city`='" . $db->escape($city) . "', `phone`='" . $db->escape($phone) . "', `fax`='" . $db->escape($fax) . "', `email`='" . $db->escape($email) . "', `customernumber`='" . $db->escape($customernumber) . "', `def_language`='" . $db->escape($def_language) . "', `password` = '" . $password . "', `diskspace`='" . $db->escape($diskspace) . "', `traffic`='" . $db->escape($traffic) . "', `subdomains`='" . $db->escape($subdomains) . "', `emails`='" . $db->escape($emails) . "', `email_accounts` = '" . $db->escape($email_accounts) . "', `email_forwarders`='" . $db->escape($email_forwarders) . "', `ftps`='" . $db->escape($ftps) . "', `tickets`='" . $db->escape($tickets) . "', `mysqls`='" . $db->escape($mysqls) . "', `deactivated`='" . $db->escape($deactivated) . "', `phpenabled`='" . $db->escape($phpenabled) . "', `email_quota`='" . $db->escape($email_quota) . "', `imap`='" . $db->escape($email_imap) . "', `pop3`='" . $db->escape($email_pop3) . "', `aps_packages`='" . (int)$number_of_aps_packages . "', `perlenabled`='" . $db->escape($perlenabled) . "', `email_autoresponder`='" . $db->escape($email_autoresponder) . "' WHERE `customerid`='" . (int)$id . "'");
					$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `name`='" . $db->escape($name) . "', `firstname`='" . $db->escape($firstname) . "', `gender`='" . $db->escape($gender) . "', `company`='" . $db->escape($company) . "', `street`='" . $db->escape($street) . "', `zipcode`='" . $db->escape($zipcode) . "', `city`='" . $db->escape($city) . "', `phone`='" . $db->escape($phone) . "', `fax`='" . $db->escape($fax) . "', `email`='" . $db->escape($email) . "', `customernumber`='" . $db->escape($customernumber) . "', `def_language`='" . $db->escape($def_language) . "', `password` = '" . $password . "', `diskspace`='" . $db->escape($diskspace) . "', `traffic`='" . $db->escape($traffic) . "', `subdomains`='" . $db->escape($subdomains) . "', `emails`='" . $db->escape($emails) . "', `email_accounts` = '" . $db->escape($email_accounts) . "', `email_forwarders`='" . $db->escape($email_forwarders) . "', `ftps`='" . $db->escape($ftps) . "', `tickets`='" . $db->escape($tickets) . "', `mysqls`='" . $db->escape($mysqls) . "', `deactivated`='" . $db->escape($deactivated) . "', `phpenabled`='" . $db->escape($phpenabled) . "', `email_quota`='" . $db->escape($email_quota) . "', `imap`='" . $db->escape($email_imap) . "', `pop3`='" . $db->escape($email_pop3) . "', `aps_packages`='" . (int)$number_of_aps_packages . "', `perlenabled`='" . $db->escape($perlenabled) . "', `email_autoresponder`='" . $db->escape($email_autoresponder) . "', `backup_allowed`='" . $db->escape($backup_allowed) . "' WHERE `customerid`='" . (int)$id . "'");
					$admin_update_query = "UPDATE `" . TABLE_PANEL_ADMINS . "` SET `customers_used` = `customers_used` ";

					# Using filesystem - quota, insert a task which cleans the filesystem - quota
					if ($settings['system']['diskquota_enabled'])
					{
						inserttask('10');
					}

					if($mysqls != '-1'
					   || $result['mysqls'] != '-1')
					{
						$admin_update_query.= ", `mysqls_used` = `mysqls_used` ";

						if($mysqls != '-1')
						{
							$admin_update_query.= " + 0" . (int)$mysqls . " ";
						}

						if($result['mysqls'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['mysqls'] . " ";
						}
					}

					if($emails != '-1'
					   || $result['emails'] != '-1')
					{
						$admin_update_query.= ", `emails_used` = `emails_used` ";

						if($emails != '-1')
						{
							$admin_update_query.= " + 0" . (int)$emails . " ";
						}

						if($result['emails'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['emails'] . " ";
						}
					}

					if($email_accounts != '-1'
					   || $result['email_accounts'] != '-1')
					{
						$admin_update_query.= ", `email_accounts_used` = `email_accounts_used` ";

						if($email_accounts != '-1')
						{
							$admin_update_query.= " + 0" . (int)$email_accounts . " ";
						}

						if($result['email_accounts'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['email_accounts'] . " ";
						}
					}

					if($email_forwarders != '-1'
					   || $result['email_forwarders'] != '-1')
					{
						$admin_update_query.= ", `email_forwarders_used` = `email_forwarders_used` ";

						if($email_forwarders != '-1')
						{
							$admin_update_query.= " + 0" . (int)$email_forwarders . " ";
						}

						if($result['email_forwarders'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['email_forwarders'] . " ";
						}
					}

					if($email_quota != '-1'
					   || $result['email_quota'] != '-1')
					{
						$admin_update_query.= ", `email_quota_used` = `email_quota_used` ";

						if($email_quota != '-1')
						{
							$admin_update_query.= " + 0" . (int)$email_quota . " ";
						}

						if($result['email_quota'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['email_quota'] . " ";
						}
					}

					if($email_autoresponder != '-1'
					   || $result['email_autoresponder'] != '-1')
					{
						$admin_update_query.= ", `email_autoresponder_used` = `email_autoresponder_used` ";

						if($email_autoresponder != '-1')
						{
							$admin_update_query.= " + 0" . (int)$email_autoresponder . " ";
						}

						if($result['email_autoresponder'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['email_autoresponder'] . " ";
						}
					}

					if($subdomains != '-1'
					   || $result['subdomains'] != '-1')
					{
						$admin_update_query.= ", `subdomains_used` = `subdomains_used` ";

						if($subdomains != '-1')
						{
							$admin_update_query.= " + 0" . (int)$subdomains . " ";
						}

						if($result['subdomains'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['subdomains'] . " ";
						}
					}

					if($ftps != '-1'
					   || $result['ftps'] != '-1')
					{
						$admin_update_query.= ", `ftps_used` = `ftps_used` ";

						if($ftps != '-1')
						{
							$admin_update_query.= " + 0" . (int)$ftps . " ";
						}

						if($result['ftps'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['ftps'] . " ";
						}
					}

					if($tickets != '-1'
					   || $result['tickets'] != '-1')
					{
						$admin_update_query.= ", `tickets_used` = `tickets_used` ";

						if($tickets != '-1')
						{
							$admin_update_query.= " + 0" . (int)$tickets . " ";
						}

						if($result['tickets'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['tickets'] . " ";
						}
					}

					if(($diskspace / 1024) != '-1'
					   || ($result['diskspace'] / 1024) != '-1')
					{
						$admin_update_query.= ", `diskspace_used` = `diskspace_used` ";

						if(($diskspace / 1024) != '-1')
						{
							$admin_update_query.= " + 0" . (int)$diskspace . " ";
						}

						if(($result['diskspace'] / 1024) != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['diskspace'] . " ";
						}
					}

					if($number_of_aps_packages != '-1'
					   || $result['aps_packages'] != '-1')
					{
						$admin_update_query.= ", `aps_packages_used` = `aps_packages_used` ";

						if($number_of_aps_packages != '-1')
						{
							$admin_update_query.= " + 0" . (int)$number_of_aps_packages . " ";
						}

						if($result['aps_packages'] != '-1')
						{
							$admin_update_query.= " - 0" . (int)$result['aps_packages'] . " ";
						}
					}

					$admin_update_query.= " WHERE `adminid` = '" . (int)$result['adminid'] . "'";
					$db->query($admin_update_query);
					$log->logAction(ADM_ACTION, LOG_INFO, "edited user '" . $result['loginname'] . "'");
					$redirect_props = Array(
						'page' => $page,
						's' => $s
					);

					redirectTo($filename, $redirect_props);
				}
			}
			else
			{
				$language_options = '';

				while(list($language_file, $language_name) = each($languages))
				{
					$language_options.= makeoption($language_name, $language_file, $result['def_language'], true);
				}

				$result['traffic'] = round($result['traffic'] / (1024 * 1024), $settings['panel']['decimal_places']);
				$result['diskspace'] = round($result['diskspace'] / 1024, $settings['panel']['decimal_places']);
				$result['email'] = $idna_convert->decode($result['email']);
				$diskspace_ul = makecheckbox('diskspace_ul', $lng['customer']['unlimited'], '-1', false, $result['diskspace'], true, true);

				if($result['diskspace'] == '-1')
				{
					$result['diskspace'] = '';
				}

				$traffic_ul = makecheckbox('traffic_ul', $lng['customer']['unlimited'], '-1', false, $result['traffic'], true, true);

				if($result['traffic'] == '-1')
				{
					$result['traffic'] = '';
				}

				$subdomains_ul = makecheckbox('subdomains_ul', $lng['customer']['unlimited'], '-1', false, $result['subdomains'], true, true);

				if($result['subdomains'] == '-1')
				{
					$result['subdomains'] = '';
				}

				$emails_ul = makecheckbox('emails_ul', $lng['customer']['unlimited'], '-1', false, $result['emails'], true, true);

				if($result['emails'] == '-1')
				{
					$result['emails'] = '';
				}

				$email_accounts_ul = makecheckbox('email_accounts_ul', $lng['customer']['unlimited'], '-1', false, $result['email_accounts'], true, true);

				if($result['email_accounts'] == '-1')
				{
					$result['email_accounts'] = '';
				}

				$email_forwarders_ul = makecheckbox('email_forwarders_ul', $lng['customer']['unlimited'], '-1', false, $result['email_forwarders'], true, true);

				if($result['email_forwarders'] == '-1')
				{
					$result['email_forwarders'] = '';
				}

				$email_quota_ul = makecheckbox('email_quota_ul', $lng['customer']['unlimited'], '-1', false, $result['email_quota'], true, true);

				if($result['email_quota'] == '-1')
				{
					$result['email_quota'] = '';
				}

				$email_autoresponder_ul = makecheckbox('email_autoresponder_ul', $lng['customer']['unlimited'], '-1', false, $result['email_autoresponder'], true, true);

				if($result['email_autoresponder'] == '-1')
				{
					$result['email_autoresponder'] = '';
				}

				$ftps_ul = makecheckbox('ftps_ul', $lng['customer']['unlimited'], '-1', false, $result['ftps'], true, true);

				if($result['ftps'] == '-1')
				{
					$result['ftps'] = '';
				}

				$tickets_ul = makecheckbox('tickets_ul', $lng['customer']['unlimited'], '-1', false, $result['tickets'], true, true);

				if($result['tickets'] == '-1')
				{
					$result['tickets'] = '';
				}

				$mysqls_ul = makecheckbox('mysqls_ul', $lng['customer']['unlimited'], '-1', false, $result['mysqls'], true, true);

				if($result['mysqls'] == '-1')
				{
					$result['mysqls'] = '';
				}

				$number_of_aps_packages_ul = makecheckbox('number_of_aps_packages_ul', $lng['customer']['unlimited'], '-1', false, $result['aps_packages'], true, true);

				if($result['aps_packages'] == '-1')
				{
					$result['aps_packages'] = '';
				}

				/*
				$createstdsubdomain = makeyesno('createstdsubdomain', '1', '0', (($result['standardsubdomain'] != '0') ? '1' : '0'));
				$phpenabled = makeyesno('phpenabled', '1', '0', $result['phpenabled']);
				$perlenabled = makeyesno('perlenabled', '1', '0', $result['perlenabled']);
				$deactivated = makeyesno('deactivated', '1', '0', $result['deactivated']);
				$email_imap = makeyesno('email_imap', '1', '0', $result['imap']);
				$email_pop3 = makeyesno('email_pop3', '1', '0', $result['pop3']);
				*/
				$backup_allowed = makeyesno('backup_allowed', '1', '0', $result['backup_allowed']);
				$result = htmlentities_array($result);

				$gender_options = makeoption($lng['gender']['undef'], 0, ($result['gender'] == '0' ? true : false), true, true);
				$gender_options .= makeoption($lng['gender']['male'], 1, ($result['gender'] == '1' ? true : false), true, true);
				$gender_options .= makeoption($lng['gender']['female'], 2, ($result['gender'] == '2' ? true : false), true, true);

				$customer_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/customer/formfield.customer_edit.php';
				$customer_edit_form = htmlform::genHTMLForm($customer_edit_data);

				$title = $customer_edit_data['customer_edit']['title'];
				$image = $customer_edit_data['customer_edit']['image'];

				eval("echo \"" . getTemplate("customers/customers_edit") . "\";");
			}
		}
	}
}

?>
