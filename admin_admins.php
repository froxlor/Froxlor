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

require ("./lib/init.php");

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

if($page == 'admins'
   && $userinfo['change_serversettings'] == '1')
{
	if($action == '')
	{
		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_admins");
		$fields = array(
			'loginname' => $lng['login']['username'],
			'name' => $lng['customer']['name'],
			'diskspace' => $lng['customer']['diskspace'],
			'diskspace_used' => $lng['customer']['diskspace'] . ' (' . $lng['panel']['used'] . ')',
			'traffic' => $lng['customer']['traffic'],
			'traffic_used' => $lng['customer']['traffic'] . ' (' . $lng['panel']['used'] . ')',
/*
			'mysqls' => $lng['customer']['mysqls'],
			'mysqls_used' => $lng['customer']['mysqls'] . ' (' . $lng['panel']['used'] . ')',
			'ftps' => $lng['customer']['ftps'],
			'ftps_used' => $lng['customer']['ftps'] . ' (' . $lng['panel']['used'] . ')',
			'tickets' => $lng['customer']['tickets'],
			'tickets_used' => $lng['customer']['tickets'] . ' (' . $lng['panel']['used'] . ')',
			'subdomains' => $lng['customer']['subdomains'],
			'subdomains_used' => $lng['customer']['subdomains'] . ' (' . $lng['panel']['used'] . ')',
			'emails' => $lng['customer']['emails'],
			'emails_used' => $lng['customer']['emails'] . ' (' . $lng['panel']['used'] . ')',
			'email_accounts' => $lng['customer']['accounts'],
			'email_accounts_used' => $lng['customer']['accounts'] . ' (' . $lng['panel']['used'] . ')',
			'email_forwarders' => $lng['customer']['forwarders'],
			'email_forwarders_used' => $lng['customer']['forwarders'] . ' (' . $lng['panel']['used'] . ')',
			'email_quota' => $lng['customer']['email_quota'],
			'email_quota_used' => $lng['customer']['email_quota'] . ' (' . $lng['panel']['used'] . ')',
			'email_autoresponder' => $lng['customer']['autoresponder'],
			'email_autoresponder_used' => $lng['customer']['autoresponder'] . ' (' . $lng['panel']['used'] . ')',
*/
			'deactivated' => $lng['admin']['deactivated']
		);
		$paging = new paging($userinfo, $db, TABLE_PANEL_ADMINS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$admins = '';
		$result = $db->query("SELECT * FROM `" . TABLE_PANEL_ADMINS . "` " . $paging->getSqlWhere(false) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
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
				$row['traffic_used'] = round($row['traffic_used'] / (1024 * 1024), $settings['panel']['decimal_places']);
				$row['traffic'] = round($row['traffic'] / (1024 * 1024), $settings['panel']['decimal_places']);
				$row['diskspace_used'] = round($row['diskspace_used'] / 1024, $settings['panel']['decimal_places']);
				$row['diskspace'] = round($row['diskspace'] / 1024, $settings['panel']['decimal_places']);

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

				//For Traffic usage
                                if ($row['traffic'] > 0) {
                                        $traffic_percent = round(($row['traffic_used']*100)/$row['traffic'], 2);
                                        $traffic_doublepercent = round($traffic_percent*2, 2);
                                } else {
                                        $traffic_percent = 0;
                                        $traffic_doublepercent = 0;
                                }
				/* */

				$row = str_replace_array('-1', 'UL', $row, 'customers domains diskspace traffic mysqls emails email_accounts email_forwarders email_quota email_autoresponder ftps subdomains tickets');
				$row = htmlentities_array($row);
				eval("\$admins.=\"" . getTemplate("admins/admins_admin") . "\";");
				$count++;
			}

			$i++;
		}

		$admincount = $db->num_rows($result);
		eval("echo \"" . getTemplate("admins/admins") . "\";");
	}
	elseif($action == 'su')
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid` = '" . (int)$id . "'");
		$destination_admin = $result['loginname'];

		if($destination_admin != ''
		   && $result['adminid'] != $userinfo['userid'])
		{
			$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid`='" . (int)$userinfo['userid'] . "'");
			$s = md5(uniqid(microtime(), 1));
			$db->query("INSERT INTO `" . TABLE_PANEL_SESSIONS . "` (`hash`, `userid`, `ipaddress`, `useragent`, `lastactivity`, `language`, `adminsession`) VALUES ('" . $db->escape($s) . "', '" . (int)$id . "', '" . $db->escape($result['ipaddress']) . "', '" . $db->escape($result['useragent']) . "', '" . time() . "', '" . $db->escape($result['language']) . "', '1')");
			$log->logAction(ADM_ACTION, LOG_INFO, "switched adminuser and is now '" . $destination_admin . "'");
			redirectTo('admin_index.php', Array('s' => $s));
		}
		else
		{
			redirectTo('index.php', Array('action' => 'login'));
		}
	}
	elseif($action == 'delete'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid`='" . (int)$id . "'");

		if($result['loginname'] != '')
		{
			if($result['adminid'] == $userinfo['userid'])
			{
				standard_error('youcantdeleteyourself');
				exit;
			}

			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$db->query("DELETE FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid`='" . (int)$id . "'");
				$db->query("DELETE FROM `" . TABLE_PANEL_TRAFFIC_ADMINS . "` WHERE `adminid`='" . (int)$id . "'");
				$db->query("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `adminid` = '" . (int)$userinfo['userid'] . "' WHERE `adminid` = '" . (int)$id . "'");
				$db->query("UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `adminid` = '" . (int)$userinfo['userid'] . "' WHERE `adminid` = '" . (int)$id . "'");
				$log->logAction(ADM_ACTION, LOG_INFO, "deleted admin '" . $result['loginname'] . "'");
				updateCounters();
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				ask_yesno('admin_admin_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $result['loginname']);
			}
		}
	}
	elseif($action == 'add')
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$name = validate($_POST['name'], 'name');
			$email = $idna_convert->encode(validate($_POST['email'], 'email'));

			$loginname = validate($_POST['loginname'], 'loginname');
			$password = validate($_POST['admin_password'], 'password');
			$password = validatePassword($password);
			$def_language = validate($_POST['def_language'], 'default language');
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

			$ftps = intval_ressource($_POST['ftps']);

			if(isset($_POST['ftps_ul']))
			{
				$ftps = - 1;
			}

			if($settings['ticket']['enabled'] == 1)
			{
				$tickets = intval_ressource($_POST['tickets']);

				if(isset($_POST['tickets_ul']))
				{
					$tickets = - 1;
				}
			}
			else
			{
				$tickets = 0;
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

				$can_manage_aps_packages = isset($_POST['can_manage_aps_packages']) ? 1 : 0;
			}
			else
			{
				$number_of_aps_packages = 0;
				$can_manage_aps_packages = 0;
			}

			$customers_see_all = 0;
			if(isset($_POST['customers_see_all']))
				$customers_see_all = intval($_POST['customers_see_all']);
			
			$domains_see_all = 0;
			if(isset($_POST['domains_see_all']))
				$domains_see_all = intval($_POST['domains_see_all']);
			
			$caneditphpsettings = 0;
			if(isset($_POST['caneditphpsettings']))
				$caneditphpsettings = intval($_POST['caneditphpsettings']);
			
			$change_serversettings = 0;
			if(isset($_POST['change_serversettings']))
				$change_serversettings = intval($_POST['change_serversettings']);

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

			$tickets_see_all = 0;
			if(isset($_POST['tickets_see_all']))
				$tickets_see_all = intval($_POST['tickets_see_all']);

			$diskspace = $diskspace * 1024;
			$traffic = $traffic * 1024 * 1024;
			$ipaddress = intval_ressource($_POST['ipaddress']);

			// Check if the account already exists

			$loginname_check = $db->query_first("SELECT `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `loginname` = '" . $db->escape($loginname) . "'");
			$loginname_check_admin = $db->query_first("SELECT `loginname` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `loginname` = '" . $db->escape($loginname) . "'");

			if($loginname == '')
			{
				standard_error(array('stringisempty', 'myloginname'));
			}
			elseif(strtolower($loginname_check['loginname']) == strtolower($loginname)
			       || strtolower($loginname_check_admin['loginname']) == strtolower($loginname))
			{
				standard_error('loginnameexists', $loginname);
			}

			// Accounts which match systemaccounts are not allowed, filtering them

			elseif (preg_match('/^' . preg_quote($settings['customer']['accountprefix'], '/') . '([0-9]+)/', $loginname))
			{
				standard_error('loginnameissystemaccount', $settings['customer']['accountprefix']);
			}
			elseif(!validateUsername($loginname))
			{
				standard_error('loginnameiswrong', $loginname);
			}
			elseif($name == '')
			{
				standard_error(array('stringisempty', 'myname'));
			}
			elseif($email == '')
			{
				standard_error(array('stringisempty', 'emailadd'));
			}
			elseif($password == '')
			{
				standard_error(array('stringisempty', 'mypassword'));
			}
			elseif(!validateEmail($email))
			{
				standard_error('emailiswrong', $email);
			}
			else
			{
				if($customers_see_all != '1')
				{
					$customers_see_all = '0';
				}

				if($domains_see_all != '1')
				{
					$domains_see_all = '0';
				}

				if($caneditphpsettings != '1')
				{
					$caneditphpsettings = '0';
				}

				if($change_serversettings != '1')
				{
					$change_serversettings = '0';
				}

				if ($tickets_see_all != '1') {
					$tickets_see_all  = '0';
				}

				$_theme = $settings['panel']['default_theme'];

				$result = $db->query("INSERT INTO 
					`" . TABLE_PANEL_ADMINS . "`
				SET 
					`loginname` = '" . $db->escape($loginname) . "', 
					`password` = '" . md5($password) . "', 
					`name` = '" . $db->escape($name) . "', 
					`email` = '" . $db->escape($email) . "', 
					`def_language` = '" . $db->escape($def_language) . "', 
					`change_serversettings` = '" . $db->escape($change_serversettings) . "', 
					`customers` = '" . $db->escape($customers) . "', 
					`customers_see_all` = '" . $db->escape($customers_see_all) . "', 
					`domains` = '" . $db->escape($domains) . "', 
					`domains_see_all` = '" . $db->escape($domains_see_all) . "', 
					`caneditphpsettings` = '" . (int)$caneditphpsettings . "', 
					`diskspace` = '" . $db->escape($diskspace) . "', 
					`traffic` = '" . $db->escape($traffic) . "', 
					`subdomains` = '" . $db->escape($subdomains) . "', 
					`emails` = '" . $db->escape($emails) . "', 
					`email_accounts` = '" . $db->escape($email_accounts) . "', 
					`email_forwarders` = '" . $db->escape($email_forwarders) . "', 
					`email_quota` = '" . $db->escape($email_quota) . "', 
					`ftps` = '" . $db->escape($ftps) . "', 
					`tickets` = '" . $db->escape($tickets) . "', 
					`tickets_see_all` = '" . $db->escape($tickets_see_all) . "',
					`mysqls` = '" . $db->escape($mysqls) . "', 
					`ip` = '" . (int)$ipaddress . "', 
					`can_manage_aps_packages` = '" . (int)$can_manage_aps_packages . "', 
					`aps_packages` = '" . (int)$number_of_aps_packages . "', 
					`email_autoresponder` = '" . $db->escape($email_autoresponder) . "',
					`theme` = '".$db->escape($_theme)."';
				");
				$adminid = $db->insert_id();
				$log->logAction(ADM_ACTION, LOG_INFO, "added admin '" . $loginname . "'");
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
		}
		else
		{
			$language_options = '';

			while(list($language_file, $language_name) = each($languages))
			{
				$language_options.= makeoption($language_name, $language_file, $userinfo['language'], true);
			}

			$ipaddress = makeoption($lng['admin']['allips'], "-1");
			$ips = array();
			$ipsandports = $db->query('SELECT `id`, `ip` FROM `' . TABLE_PANEL_IPSANDPORTS . '` ORDER BY `ip`, `port` ASC');

			while($row = $db->fetch_array($ipsandports))
			{
				if(filter_var($row['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
				{
					$row['ip'] = '[' . $row['ip'] . ']';
				}

				if(!in_array($row['ip'], $ips))
				{
					$ipaddress.= makeoption($row['ip'], $row['id']);
					$ips[] = $row['ip'];
				}
			}

			$customers_ul = makecheckbox('customers_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$diskspace_ul = makecheckbox('diskspace_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$traffic_ul = makecheckbox('traffic_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$domains_ul = makecheckbox('domains_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$subdomains_ul = makecheckbox('subdomains_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$emails_ul = makecheckbox('emails_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_accounts_ul = makecheckbox('email_accounts_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_forwarders_ul = makecheckbox('email_forwarders_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_quota_ul = makecheckbox('email_quota_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$email_autoresponder_ul = makecheckbox('email_autoresponder_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$ftps_ul = makecheckbox('ftps_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$tickets_ul = makecheckbox('tickets_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			$mysqls_ul = makecheckbox('mysqls_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);
			/*
			$change_serversettings = makeyesno('change_serversettings', '1', '0', '0');
			$customers_see_all = makeyesno('customers_see_all', '1', '0', '0');
			$domains_see_all = makeyesno('domains_see_all', '1', '0', '0');
			$caneditphpsettings = makeyesno('caneditphpsettings', '1', '0', '0');
			$can_manage_aps_packages = makeyesno('can_manage_aps_packages', '1', '0', '0');
			*/
			$number_of_aps_packages_ul = makecheckbox('number_of_aps_packages_ul', $lng['customer']['unlimited'], '-1', false, '0', true, true);

			$admin_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/admin/formfield.admin_add.php';
			$admin_add_form = htmlform::genHTMLForm($admin_add_data);

			$title = $admin_add_data['admin_add']['title'];
			$image = $admin_add_data['admin_add']['image'];

			eval("echo \"" . getTemplate("admins/admins_add") . "\";");
		}
	}
	elseif($action == 'edit'
	       && $id != 0)
	{
		$result = $db->query_first("SELECT * FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid`='" . (int)$id . "'");

		if($result['loginname'] != '')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$name = validate($_POST['name'], 'name');
				$email = $idna_convert->encode(validate($_POST['email'], 'email'));

				if($result['adminid'] == $userinfo['userid'])
				{
					$password = '';
					$def_language = $result['def_language'];
					$deactivated = $result['deactivated'];
					$customers = $result['customers'];
					$domains = $result['domains'];
					$subdomains = $result['subdomains'];
					$emails = $result['emails'];
					$email_accounts = $result['email_accounts'];
					$email_forwarders = $result['email_forwarders'];
					$email_quota = $result['email_quota'];
					$email_autoresponder = $result['email_autoresponder'];
					$ftps = $result['ftps'];
					$tickets = $result['tickets'];
					$mysqls = $result['mysqls'];
					$tickets_see_all = $result['tickets_see_all'];
					$customers_see_all = $result['customers_see_all'];
					$domains_see_all = $result['domains_see_all'];
					$caneditphpsettings = $result['caneditphpsettings'];
					$change_serversettings = $result['change_serversettings'];
					$diskspace = $result['diskspace'];
					$traffic = $result['traffic'];
					$ipaddress = $result['ip'];
					$can_manage_aps_packages = $result['can_manage_aps_packages'];
					$number_of_aps_packages = $result['aps_packages'];
				}
				else
				{
					$password = validate($_POST['admin_password'], 'new password');
					$def_language = validate($_POST['def_language'], 'default language');
					$deactivated = isset($_POST['deactivated']) ? 1 : 0;
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

					$ftps = intval_ressource($_POST['ftps']);

					if(isset($_POST['ftps_ul']))
					{
						$ftps = - 1;
					}
					
					if($settings['ticket']['enabled'] == 1)
					{
						$tickets = intval_ressource($_POST['tickets']);

						if(isset($_POST['tickets_ul']))
						{
							$tickets = - 1;
						}
					}
					else
					{
						$tickets = 0;
					}

					$mysqls = intval_ressource($_POST['mysqls']);

					if(isset($_POST['mysqls_ul']))
					{
						$mysqls = - 1;
					}

					$number_of_aps_packages = intval_ressource($_POST['number_of_aps_packages']);

					if(isset($_POST['number_of_aps_packages_ul']))
					{
						$number_of_aps_packages = - 1;
					}

					$can_manage_aps_packages = isset($_POST['can_manage_aps_packages']) ? 1 : 0;

					$customers_see_all = 0;
					if(isset($_POST['customers_see_all']))
						$customers_see_all = intval($_POST['customers_see_all']);
					
					$domains_see_all = 0;
					if(isset($_POST['domains_see_all']))
						$domains_see_all = intval($_POST['domains_see_all']);
					
					$caneditphpsettings = 0;
					if(isset($_POST['caneditphpsettings']))
						$caneditphpsettings = intval($_POST['caneditphpsettings']);
					
					$change_serversettings = 0;
					if(isset($_POST['change_serversettings']))
						$change_serversettings = isset($_POST['change_serversettings']) ? 1 : 0;
					
					$diskspace = intval($_POST['diskspace']);

					$tickets_see_all = 0;
					if (isset($_POST['tickets_see_all']))
						$tickets_see_all = intval($_POST['tickets_see_all']);

					if(isset($_POST['diskspace_ul']))
					{
						$diskspace = - 1;
					}

					$traffic = doubleval_ressource($_POST['traffic']);

					if(isset($_POST['traffic_ul']))
					{
						$traffic = - 1;
					}

					$diskspace = $diskspace * 1024;
					$traffic = $traffic * 1024 * 1024;
					$ipaddress = intval_ressource($_POST['ipaddress']);
				}

				if($name == '')
				{
					standard_error(array('stringisempty', 'myname'));
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

					if($deactivated != '1')
					{
						$deactivated = '0';
					}

					if($customers_see_all != '1')
					{
						$customers_see_all = '0';
					}

					if($domains_see_all != '1')
					{
						$domains_see_all = '0';
					}

					if($caneditphpsettings != '1')
					{
						$caneditphpsettings = '0';
					}

					if($change_serversettings != '1')
					{
						$change_serversettings = '0';
					}

					if ($tickets_see_all != '1') {
						$tickets_see_all = '0';
					}

					$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `name`='" . $db->escape($name) . "', `email`='" . $db->escape($email) . "', `def_language`='" . $db->escape($def_language) . "', `change_serversettings` = '" . $db->escape($change_serversettings) . "', `customers` = '" . $db->escape($customers) . "', `customers_see_all` = '" . $db->escape($customers_see_all) . "', `domains` = '" . $db->escape($domains) . "', `domains_see_all` = '" . $db->escape($domains_see_all) . "', `caneditphpsettings` = '" . (int)$caneditphpsettings . "', `password` = '" . $password . "', `diskspace`='" . $db->escape($diskspace) . "', `traffic`='" . $db->escape($traffic) . "', `subdomains`='" . $db->escape($subdomains) . "', `emails`='" . $db->escape($emails) . "', `email_accounts` = '" . $db->escape($email_accounts) . "', `email_forwarders`='" . $db->escape($email_forwarders) . "', `email_quota`='" . $db->escape($email_quota) . "', `email_autoresponder`='" . $db->escape($email_autoresponder) . "', `ftps`='" . $db->escape($ftps) . "', `tickets`='" . $db->escape($tickets) . "', `tickets_see_all`='".$db->escape($tickets_see_all) . "', `mysqls`='" . $db->escape($mysqls) . "', `ip`='" . (int)$ipaddress . "', `deactivated`='" . $db->escape($deactivated) . "', `can_manage_aps_packages`=" . (int)$can_manage_aps_packages . ", `aps_packages`=" . (int)$number_of_aps_packages . " WHERE `adminid`='" . $db->escape($id) . "'");
					$log->logAction(ADM_ACTION, LOG_INFO, "edited admin '#" . $id . "'");
					$redirect_props = Array(
						'page' => $page,
						's' => $s
					);

					redirectTo($filename, $redirect_props);
				}
			}
			else
			{
				$result['traffic'] = round($result['traffic'] / (1024 * 1024), $settings['panel']['decimal_places']);
				$result['diskspace'] = round($result['diskspace'] / 1024, $settings['panel']['decimal_places']);
				$result['email'] = $idna_convert->decode($result['email']);
				$customers_ul = makecheckbox('customers_ul', $lng['customer']['unlimited'], '-1', false, $result['customers'], true, true);

				if($result['customers'] == '-1')
				{
					$result['customers'] = '';
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

				$domains_ul = makecheckbox('domains_ul', $lng['customer']['unlimited'], '-1', false, $result['domains'], true, true);

				if($result['domains'] == '-1')
				{
					$result['domains'] = '';
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

				$language_options = '';

				while(list($language_file, $language_name) = each($languages))
				{
					$language_options.= makeoption($language_name, $language_file, $result['def_language'], true);
				}

				$ipaddress = makeoption($lng['admin']['allips'], "-1", $result['ip']);
				$ips = array();
				$ipsandports = $db->query('SELECT `id`, `ip` FROM `' . TABLE_PANEL_IPSANDPORTS . '` ORDER BY `ip`, `port` ASC');

				while($row = $db->fetch_array($ipsandports))
				{
					if(filter_var($row['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
					{
						$row['ip'] = '[' . $row['ip'] . ']';
					}

					if(!in_array($row['ip'], $ips))
					{
						$ipaddress.= makeoption($row['ip'], $row['id'], $result['ip']);
						$ips[] = $row['ip'];
					}
				}

				/*
				$change_serversettings = makeyesno('change_serversettings', '1', '0', $result['change_serversettings']);
				$customers_see_all = makeyesno('customers_see_all', '1', '0', $result['customers_see_all']);
				$domains_see_all = makeyesno('domains_see_all', '1', '0', $result['domains_see_all']);
				$caneditphpsettings = makeyesno('caneditphpsettings', '1', '0', $result['caneditphpsettings']);
				$deactivated = makeyesno('deactivated', '1', '0', $result['deactivated']);
				$can_manage_aps_packages = makeyesno('can_manage_aps_packages', '1', '0', $result['can_manage_aps_packages']);
				*/
				$result = htmlentities_array($result);

				$admin_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/admin/formfield.admin_edit.php';
				$admin_edit_form = htmlform::genHTMLForm($admin_edit_data);

				$title = $admin_edit_data['admin_edit']['title'];
				$image = $admin_edit_data['admin_edit']['image'];

				eval("echo \"" . getTemplate("admins/admins_edit") . "\";");
			}
		}
	}
}

?>
