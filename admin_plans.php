<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2012 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2012-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */

define('AREA', 'admin');

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

if($page == 'show')
{
	$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_PLANS . "` WHERE `planid`='" . (int)$id . "' AND `adminid` = '" . (int)$userinfo['adminid'] . "' ");

	if($result['planid'] != '')
	{
		$result['traffic'] = round($result['traffic'] / (1024 * 1024), $settings['panel']['decimal_places']);
		$result['diskspace'] = round($result['diskspace'] / 1024, $settings['panel']['decimal_places']);

		$result['diskspace_ul'] = $result['traffic_ul'] = $result['subdomains_ul'] = $result['emails_ul'] = $result['email_accounts_ul'] =
		$result['email_forwarders_ul'] = $result['email_autoresponder_ul'] = $result['ftps_ul'] = $result['mysqls_ul'] = $result['customers_ul'] =
		$result['email_quota_ul'] = $result['tickets_ul'] = $result['number_of_aps_packages_ul'] = $result['domains_ul'] = false;
	
		$result['customers_see_all'] = ($result['customers_see_all']=='1') ? true : false;
		$result['domains_see_all'] = ($result['domains_see_all']=='1') ? true : false;
		$result['caneditphpsettings'] = ($result['caneditphpsettings']=='1') ? true : false;
		$result['change_serversettings'] = ($result['change_serversettings']=='1') ? true : false;
		$result['can_manage_aps_packages'] = ($result['can_manage_aps_packages']=='1') ? true : false;
		$result['phpenabled'] = ($result['phpenabled']=='1') ? true : false;
		$result['perlenabled'] = ($result['perlenabled']=='1') ? true : false;
		$result['email_imap'] = ($result['imap']=='1') ? true : false;
		$result['email_pop3'] = ($result['pop3']=='1') ? true : false;
		$result['number_of_aps_packages'] = $result['aps_packages'];
		
		if($result['domains'] == '-1')
		{
			$result['domains'] = '';
			$result['domains_ul'] = true;
		}
		
		if($result['customers'] == '-1')
		{
			$result['customers'] = '';
			$result['customers_ul'] = true;
		}

		if($result['diskspace'] == '-1')
		{
			$result['diskspace'] = '';
			$result['diskspace_ul'] = true;
		}

		if($result['traffic'] == '-1')
		{
			$result['traffic'] = '';
			$result['traffic_ul'] = true;
		}

		if($result['subdomains'] == '-1')
		{
			$result['subdomains'] = '';
			$result['subdomains_ul'] = true;
		}

		if($result['emails'] == '-1')
		{
			$result['emails'] = '';
			$result['emails_ul'] = true;
		}

		if($result['email_accounts'] == '-1')
		{
			$result['email_accounts'] = '';
			$result['email_accounts_ul'] = true;
		}

		if($result['email_forwarders'] == '-1')
		{
			$result['email_forwarders'] = '';
			$result['email_forwarders_ul'] = true;
		}

		if($result['email_quota'] == '-1')
		{
			$result['email_quota'] = '';
			$result['email_quota_ul'] = true;
		}

		if($result['email_autoresponder'] == '-1')
		{
			$result['email_autoresponder'] = '';
			$result['email_autoresponder_ul'] = true;
		}

		if($result['ftps'] == '-1')
		{
			$result['ftps'] = '';
			$result['ftps_ul'] = true;
		}

		if($result['tickets'] == '-1')
		{
			$result['tickets'] = '';
			$result['tickets_ul'] = true;
		}

		if($result['mysqls'] == '-1')
		{
			$result['mysqls'] = '';
			$result['mysqls_ul'] = true;
		}

		if($result['aps_packages'] == '-1')
		{
			$result['number_of_aps_packages'] = '';
			$result['number_of_aps_packages_ul'] = true; 
		}
		
		unset($result['plan_name']);
		unset($result['adminid']);
		unset($result['planid']);
		echo json_encode($result);
	}
}

if($page == 'plan')
{
	if($action == '')
	{
		// clear request data
		unset($_SESSION['requestData']);

		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_plans");
		$fields = array(
			'plan_name' => $lng['customer']['name'],
			'plan_type' => $lng['admin']['plans']['plan_group'],
			'diskspace' => $lng['customer']['diskspace'],
			'traffic' => $lng['customer']['traffic']
		);

		if($_REQUEST['searchfield']=='diskspace' || $_REQUEST['searchfield']=='traffic')
		{
			$_REQUEST['searchtext'] *= 1024;
		}
		
		if($_REQUEST['searchfield']=='plan_type' && strtolower($_REQUEST['searchtext'])==strtolower($lng['admin']['admins']))
		{
			$_REQUEST['searchtext'] = '0';
		}
		elseif($_REQUEST['searchfield']=='plan_type' && strtolower($_REQUEST['searchtext'])==strtolower($lng['admin']['customers']))
		{
			$_REQUEST['searchtext'] = '1';
		}

		$paging = new paging($userinfo, $db, TABLE_PANEL_PLANS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$plan = '';
		$result = $db->query("SELECT * FROM `" . TABLE_PANEL_PLANS . "` WHERE `adminid` = '" . (int)$userinfo['adminid'] . "' " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy($settings['panel']['natsorting']) . " " . $paging->getSqlLimit());
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
				$row['traffic'] = round($row['traffic'] / (1024 * 1024), $settings['panel']['decimal_places']);
				$row['diskspace'] = round($row['diskspace'] / 1024, $settings['panel']['decimal_places']);
				$column_style = '';
				$plan_types = array($lng['admin']['admins'], $lng['admin']['customers']);
				$row['plan_type'] = $plan_types[$row['plan_type']];
				$row = htmlentities_array($row);
				eval("\$plan.=\"" . getTemplate("plans/plans_plan") . "\";");
				$count++;
			}
			$i++;
		}

		$plancount = $db->num_rows($result);
		eval("echo \"" . getTemplate("plans/plans") . "\";");
	}
	elseif($action == 'delete'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_PLANS . "` WHERE `planid`='" . (int)$id . "' AND `adminid` = '" . (int)$userinfo['adminid'] . "' ");

		if($result['planid'] != '')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$db->query("DELETE FROM `" . TABLE_PANEL_PLANS . "` WHERE `planid`='" . (int)$id . "'");
				$log->logAction(ADM_ACTION, LOG_INFO, "deleted plan '" . $result['plan_name'] . "'");
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				ask_yesno('admin_template_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['plan_name']);
			}
		}
	}
	elseif($action == 'add')
	{
		if($userinfo['customers_used'] < $userinfo['customers']
		   || $userinfo['customers'] == '-1')
		{
			if(isset($_POST['prepare'])
			   && $_POST['prepare'] == 'prepare')
			{
				$plan_type = intval($_POST['plan_type']);
				if($plan_type!=1)
				{
					$customers_ul = makecheckbox('customers_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
					$domains_ul = makecheckbox('domains_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
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
				$backup_allowed = makeyesno('backup_allowed', '1', '0', '0');

				$plan_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/plans/formfield.plan_add.php';
				$plan_add_form = htmlform::genHTMLForm($plan_add_data);

				$title = $plan_add_data['plan_add']['title'];
				$image = $plan_add_data['plan_add']['image'];

				eval("echo \"" . getTemplate("plans/plans_add_2") . "\";");
			}
			elseif(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$plan_name = validate($_POST['plan_name'], 'plan_name');
				$plan_type = intval($_POST['plan_type']);
				$customers = intval_ressource($_POST['customers']);
				
				if(isset($_POST['customers_ul']))
				{
					$customers = - 1;
				}
				
				$domains = intval_ressource($_POST['domains']);
				
				if(isset($_POST['domains_ul']))
				{
					$domains = - 1;
				}
				
				$diskspace = intval_ressource($_POST['diskspace']);

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
					$can_manage_aps_packages = (isset($_POST['can_manage_aps_packages'])) ? true : false;
					$number_of_aps_packages = intval_ressource($_POST['number_of_aps_packages']);

					if(isset($_POST['number_of_aps_packages_ul']))
					{
						$number_of_aps_packages = - 1;
					}
				}
				else
				{
					$can_manage_aps_packages = 0;
					$number_of_aps_packages = 0;
				}

				$backup_allowed = 0;
				if(isset($_POST['backup_allowed']))
					$backup_allowed = intval($_POST['backup_allowed']);

				if ($backup_allowed != 0)
				{
					$backup_allowed = 1;
				}
				
				$customers_see_all = (isset($_POST['customers_see_all'])) ? true : false;
				$domains_see_all = (isset($_POST['domains_see_all'])) ? true : false;
				$caneditphpsettings = (isset($_POST['caneditphpsettings'])) ? true : false;
				$change_serversettings = (isset($_POST['change_serversettings'])) ? true : false;

				$phpenabled = 0;
				if(isset($_POST['phpenabled']))
					$phpenabled = intval($_POST['phpenabled']);

				$perlenabled = 0;
				if(isset($_POST['perlenabled']))
					$perlenabled = intval($_POST['perlenabled']);

				$diskspace = $diskspace * 1024;
				$traffic = $traffic * 1024 * 1024;

				if((($diskspace > $userinfo['diskspace']) && ($userinfo['diskspace'] / 1024) != '-1')
				   || (($mysqls > $userinfo['mysqls']) && $userinfo['mysqls'] != '-1')
				   || (($emails > $userinfo['emails']) && $userinfo['emails'] != '-1')
				   || (($email_accounts > $userinfo['email_accounts']) && $userinfo['email_accounts'] != '-1')
				   || (($email_forwarders > $userinfo['email_forwarders']) && $userinfo['email_forwarders'] != '-1')
				   || (($email_quota > $userinfo['email_quota']) && $userinfo['email_quota'] != '-1' && $settings['system']['mail_quota_enabled'] == '1')
				   || (($email_autoresponder > $userinfo['email_autoresponder']) && $userinfo['email_autoresponder'] != '-1' && $settings['autoresponder']['autoresponder_active'] == '1')
				   || (($ftps > $userinfo['ftps']) && $userinfo['ftps'] != '-1')
				   || (($tickets > $userinfo['tickets']) && $userinfo['tickets'] != '-1')
				   || (($subdomains > $userinfo['subdomains']) && $userinfo['subdomains'] != '-1')
				   || (($number_of_aps_packages > $userinfo['aps_packages']) && $userinfo['aps_packages'] != '-1' && $settings['aps']['aps_active'] == '1')
				   || (($diskspace / 1024) == '-1' && ($userinfo['diskspace'] / 1024) != '-1')
				   || (($customers > $userinfo['customers']) && $userinfo['customers'] != '-1')
				   || (($domains > $userinfo['domains']) && $userinfo['domains'] != '-1')
				   || ($mysqls == '-1' && $userinfo['mysqls'] != '-1')
				   || ($emails == '-1' && $userinfo['emails'] != '-1')
				   || ($email_accounts == '-1' && $userinfo['email_accounts'] != '-1')
				   || ($email_forwarders == '-1' && $userinfo['email_forwarders'] != '-1')
				   || ($email_quota == '-1' && $userinfo['email_quota'] != '-1' && $settings['system']['mail_quota_enabled'] == '1')
				   || ($email_autoresponder == '-1' && $userinfo['email_autoresponder'] != '-1' && $settings['autoresponder']['autoresponder_active'] == '1')
				   || ($ftps == '-1' && $userinfo['ftps'] != '-1')
				   || ($tickets == '-1' && $userinfo['tickets'] != '-1')
				   || ($subdomains == '-1' && $userinfo['subdomains'] != '-1')
				   || ($customers == '-1' && $userinfo['customers'] != '-1')
				   || ($domains == '-1' && $userinfo['domains'] != '-1')
				   || ($number_of_aps_packages == '-1' && $userinfo['aps_packages'] != '-1'))
				{
					standard_error('youcantallocatemorethanyouhave');
					exit;
				}
				else
				{
					// Check if the plan already exists
					$name_check = $db->query_first("SELECT `plan_name` FROM `" . TABLE_PANEL_PLANS . "` WHERE `plan_name` = '" . $db->escape($name) . "' AND `adminid` = '" . (int)$userinfo['adminid'] . "'");

					if(strtolower($name_check['plan_name']) == strtolower($plan_name))
					{
						standard_error('nameexists', $plan_name);
					}

					if($phpenabled != '0')
					{
						$phpenabled = '1';
					}

					if($perlenabled != '0')
					{
						$perlenabled = '1';
					}

					$result = $db->query(
						"INSERT INTO `" . TABLE_PANEL_PLANS . "` SET
							`adminid` = '" . (int)$userinfo['adminid'] . "',
							`plan_name` = '" . $db->escape($plan_name) . "',
							`plan_type` = '" . $db->escape($plan_type) . "',
							`customers` = '" . $db->escape($customers) . "',
							`customers_see_all` = '" . $db->escape($customers_see_all) . "',
							`domains` = '" . $db->escape($domains) . "',
							`domains_see_all` = '" . $db->escape($domains_see_all) . "',
							`caneditphpsettings` = '" . $db->escape($caneditphpsettings) . "',
							`change_serversettings` = '" . $db->escape($change_serversettings) . "',
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
							`phpenabled` = '" . $db->escape($phpenabled) . "',
							`imap` = '" . $db->escape($email_imap) . "',
							`pop3` = '" . $db->escape($email_pop3) . "',
							`can_manage_aps_packages` = '" . $db->escape($can_manage_aps_packages) . "',
							`aps_packages` = '" . (int)$number_of_aps_packages . "',
							`perlenabled` = '" . $db->escape($perlenabled) . "',
							`email_autoresponder` = '" . $db->escape($email_autoresponder) . "',
							`backup_allowed` = '" . $db->escape($backup_allowed) . "'"
					);
					$planid = $db->insert_id();
					$log->logAction(ADM_ACTION, LOG_INFO, "added plan '" . $plan_name . "'");
					redirectTo($filename, Array('page' => $page, 's' => $s));
				}
			}
			else
			{
				$plan_options = makeoption($lng['admin']['customers'], '1', NULL, true);
				if($userinfo['change_serversettings'] == '1')
				{
					$plan_options.= makeoption($lng['admin']['admins'], '0', NULL, true);
				}

				eval("echo \"" . getTemplate("plans/plans_add_1") . "\";");
			}
		}
	}
	elseif($action == 'edit'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_PLANS . "` WHERE `planid`='" . (int)$id . "' AND `adminid` = '" . (int)$userinfo['adminid'] . "' ");

		if($result['planid'] != '')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$plan_name = validate($_POST['plan_name'], 'plan_name');
				$customers = intval_ressource($_POST['customers']);
				
				if(isset($_POST['customers_ul']))
				{
					$customers = - 1;
				}
				
				$domains = intval_ressource($_POST['domains']);
				
				if(isset($_POST['domains_ul']))
				{
					$domains = - 1;
				}
				
				$diskspace = intval_ressource($_POST['diskspace']);

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
				
				$customers_see_all = (isset($_POST['customers_see_all'])) ? true : false;
				$domains_see_all = (isset($_POST['domains_see_all'])) ? true : false;
				$caneditphpsettings = (isset($_POST['caneditphpsettings'])) ? true : false;
				$change_serversettings = (isset($_POST['change_serversettings'])) ? true : false;

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
					$can_manage_aps_packages = (isset($_POST['can_manage_aps_packages'])) ? true : false;

					if(isset($_POST['number_of_aps_packages_ul']))
					{
						$number_of_aps_packages = - 1;
					}
				}
				else
				{
					$number_of_aps_packages = 0;
					$can_manage_aps_packages = 0;
				}

				$phpenabled = 0;
				if(isset($_POST['phpenabled']))
					$phpenabled = intval($_POST['phpenabled']);

				$perlenabled = 0;
				if(isset($_POST['perlenabled']))
					$perlenabled = intval($_POST['perlenabled']);
				$diskspace = $diskspace * 1024;
				$traffic = $traffic * 1024 * 1024;

				if((($diskspace > $userinfo['diskspace']) && ($userinfo['diskspace'] / 1024) != '-1')
				   || (($mysqls > $userinfo['mysqls']) && $userinfo['mysqls'] != '-1')
				   || (($emails > $userinfo['emails']) && $userinfo['emails'] != '-1')
				   || (($email_accounts > $userinfo['email_accounts']) && $userinfo['email_accounts'] != '-1')
				   || (($email_forwarders > $userinfo['email_forwarders']) && $userinfo['email_forwarders'] != '-1')
				   || (($email_quota > $userinfo['email_quota']) && $userinfo['email_quota'] != '-1' && $settings['system']['mail_quota_enabled'] == '1')
				   || (($email_autoresponder > $userinfo['email_autoresponder']) && $userinfo['email_autoresponder'] != '-1' && $settings['autoresponder']['autoresponder_active'] == '1')
				   || (($ftps > $userinfo['ftps']) && $userinfo['ftps'] != '-1')
				   || (($tickets > $userinfo['tickets']) && $userinfo['tickets'] != '-1')
				   || (($subdomains > $userinfo['subdomains']) && $userinfo['subdomains'] != '-1')
				   || (($diskspace / 1024) == '-1' && ($userinfo['diskspace'] / 1024) != '-1')
				   || (($number_of_aps_packages > $userinfo['aps_packages']) && $userinfo['aps_packages'] != '-1' && $settings['aps']['aps_active'] == '1')
				   || (($customers > $userinfo['customers']) && $userinfo['customers'] != '-1')
				   || (($domains > $userinfo['domains']) && $userinfo['domains'] != '-1')
				   || ($mysqls == '-1' && $userinfo['mysqls'] != '-1')
				   || ($emails == '-1' && $userinfo['emails'] != '-1')
				   || ($email_accounts == '-1' && $userinfo['email_accounts'] != '-1')
				   || ($email_forwarders == '-1' && $userinfo['email_forwarders'] != '-1')
				   || ($email_quota == '-1' && $userinfo['email_quota'] != '-1' && $settings['system']['mail_quota_enabled'] == '1')
				   || ($email_autoresponder == '-1' && $userinfo['email_autoresponder'] != '-1' && $settings['autoresponder']['autoresponder_active'] == '1')
				   || ($ftps == '-1' && $userinfo['ftps'] != '-1')
				   || ($tickets == '-1' && $userinfo['tickets'] != '-1')
				   || ($subdomains == '-1' && $userinfo['subdomains'] != '-1')
				   || ($customers == '-1' && $userinfo['customers'] != '-1')
				   || ($domains == '-1' && $userinfo['domains'] != '-1')
				   || ($number_of_aps_packages == '-1' && $userinfo['aps_packages'] != '-1'))
				{
					standard_error('youcantallocatemorethanyouhave');
					exit;
				}
				else
				{
					if($phpenabled != '0')
					{
						$phpenabled = '1';
					}

					if($perlenabled != '0')
					{
						$perlenabled = '1';
					}

					$db->query(
						"UPDATE `" . TABLE_PANEL_PLANS . "` SET 
							`plan_name` = '" . $db->escape($plan_name) . "', 
							`customers` = '" . $db->escape($customers) . "',
							`customers_see_all` = '" . $db->escape($customers_see_all) . "',
							`domains` = '" . $db->escape($domains) . "',
							`domains_see_all` = '" . $db->escape($domains_see_all) . "',
							`caneditphpsettings` = '" . $db->escape($caneditphpsettings) . "',
							`change_serversettings` = '" . $db->escape($change_serversettings) . "',
							`diskspace` = '" . $db->escape($diskspace) . "', 
							`traffic` = '" . $db->escape($traffic) . "', 
							`subdomains` = '" . $db->escape($subdomains) . "', 
							`emails` = '" . $db->escape($emails) . "', 
							`email_accounts` = '" . $db->escape($email_accounts) . "', 
							`email_forwarders` = '" . $db->escape($email_forwarders) . "', 
							`ftps` = '" . $db->escape($ftps) . "', 
							`tickets` = '" . $db->escape($tickets) . "', 
							`mysqls` = '" . $db->escape($mysqls) . "', 
							`phpenabled` = '" . $db->escape($phpenabled) . "', 
							`email_quota` = '" . $db->escape($email_quota) . "', 
							`imap` = '" . $db->escape($email_imap) . "', 
							`pop3` = '" . $db->escape($email_pop3) . "', 
							`can_manage_aps_packages` = '" . $db->escape($can_manage_aps_packages) . "',
							`aps_packages` = '" . (int)$number_of_aps_packages . "', 
							`perlenabled` = '" . $db->escape($perlenabled) . "', 
							`email_autoresponder` = '" . $db->escape($email_autoresponder) . "', 
							`backup_allowed` = '" . $db->escape($backup_allowed) . "' 
						WHERE `planid` = '" . (int)$id . "'");

					$log->logAction(ADM_ACTION, LOG_INFO, "edited plan '" . $result['plan_name'] . "'");
					$redirect_props = Array(
						'page' => $page,
						's' => $s
					);

					redirectTo($filename, $redirect_props);
				}
			}
			else
			{
				$plan_type = $result['plan_type'];
				$result['traffic'] = round($result['traffic'] / (1024 * 1024), $settings['panel']['decimal_places']);
				$result['diskspace'] = round($result['diskspace'] / 1024, $settings['panel']['decimal_places']);
				$customers_ul = makecheckbox('customers_ul', $lng['customer']['unlimited'], '-1', false, $result['customers'], true, true);

				if($result['customers'] == '-1')
				{
					$result['customers'] = '';
				}
				
				$domains_ul = makecheckbox('domains_ul', $lng['customer']['unlimited'], '-1', false, $result['domains'], true, true);

				if($result['domains'] == '-1')
				{
					$result['domains'] = '';
				}
				
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

				$backup_allowed = makeyesno('backup_allowed', '1', '0', $result['backup_allowed']);
				$result = htmlentities_array($result);

				$plan_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/plans/formfield.plan_edit.php';
				$plan_edit_form = htmlform::genHTMLForm($plan_edit_data);

				$title = $plan_edit_data['plan_edit']['title'];
				$image = $plan_edit_data['plan_edit']['image'];

				eval("echo \"" . getTemplate("plans/plans_edit") . "\";");
			}
		}
	}
}

?>
