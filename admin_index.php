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

if($action == 'logout')
{
	$log->logAction(ADM_ACTION, LOG_NOTICE, "logged out");

	if($settings['session']['allow_multiple_login'] == '1')
	{
		$db->query("DELETE FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid` = '" . (int)$userinfo['adminid'] . "' AND `adminsession` = '1' AND `hash` = '" . $s . "'");
	}
	else
	{
		$db->query("DELETE FROM `" . TABLE_PANEL_SESSIONS . "` WHERE `userid` = '" . (int)$userinfo['adminid'] . "' AND `adminsession` = '1'");
	}

	redirectTo('index.php');
	exit;
}

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

if($page == 'overview')
{
	$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_index");
	$overview = $db->query_first("SELECT COUNT(*) AS `number_customers`,
				SUM(`diskspace_used`) AS `diskspace_used`,
				SUM(`mysqls_used`) AS `mysqls_used`,
				SUM(`emails_used`) AS `emails_used`,
				SUM(`email_accounts_used`) AS `email_accounts_used`,
				SUM(`email_forwarders_used`) AS `email_forwarders_used`,
				SUM(`email_quota_used`) AS `email_quota_used`,
				SUM(`email_autoresponder_used`) AS `email_autoresponder_used`,
				SUM(`ftps_used`) AS `ftps_used`,
				SUM(`tickets_used`) AS `tickets_used`,
				SUM(`subdomains_used`) AS `subdomains_used`,
				SUM(`traffic_used`) AS `traffic_used`,
				SUM(`aps_packages_used`) AS `aps_packages_used`
				FROM `" . TABLE_PANEL_CUSTOMERS . "`" . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = '" . (int)$userinfo['adminid'] . "' "));
	$overview['traffic_used'] = round($overview['traffic_used'] / (1024 * 1024), $settings['panel']['decimal_places']);
	$overview['diskspace_used'] = round($overview['diskspace_used'] / 1024, $settings['panel']['decimal_places']);
	$number_domains = $db->query_first("SELECT COUNT(*) AS `number_domains` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `parentdomainid`='0'" . ($userinfo['customers_see_all'] ? '' : " AND `adminid` = '" . (int)$userinfo['adminid'] . "' "));
	$overview['number_domains'] = $number_domains['number_domains'];
	$phpversion = phpversion();
	$phpmemorylimit = @ini_get("memory_limit");

	if($phpmemorylimit == "")
	{
		$phpmemorylimit = $lng['admin']['memorylimitdisabled'];
	}

	$mysqlserverversion = mysql_get_server_info();
	$mysqlclientversion = mysql_get_client_info();
	$webserverinterface = strtoupper(@php_sapi_name());

	if((isset($_GET['lookfornewversion']) && $_GET['lookfornewversion'] == 'yes')
	|| (isset($lookfornewversion) && $lookfornewversion == 'yes'))
	{
		$update_check_uri = 'http://version.froxlor.org/Froxlor/legacy/' . $version;

		if(ini_get('allow_url_fopen'))
		{
			$latestversion = @file($update_check_uri);

			if (isset($latestversion[0]))
			{
				$latestversion = explode('|', $latestversion[0]);

				if(is_array($latestversion)
				&& count($latestversion) >= 1)
				{
					$_version = $latestversion[0];
					$_message = isset($latestversion[1]) ? $latestversion[1] : '';
					$_link = isset($latestversion[2]) ? $latestversion[2] : htmlspecialchars($filename . '?s=' . urlencode($s) . '&page=' . urlencode($page) . '&lookfornewversion=yes');

					$lookfornewversion_lable = $_version;
					$lookfornewversion_link = $_link;
					$lookfornewversion_addinfo = $_message;

					if (version_compare($version, $_version) == -1) {
						$isnewerversion = 1;
					} else {
						$isnewerversion = 0;
					}
				}
				else
				{
					redirectTo($update_check_uri.'/pretty', NULL);
				}
			}
			else
			{
				redirectTo($update_check_uri.'/pretty', NULL);
			}
		}
		else
		{
			redirectTo($update_check_uri.'/pretty', NULL);
		}
	}
	else
	{
		$lookfornewversion_lable = $lng['admin']['lookfornewversion']['clickhere'];
		$lookfornewversion_link = htmlspecialchars($filename . '?s=' . urlencode($s) . '&page=' . urlencode($page) . '&lookfornewversion=yes');
		$lookfornewversion_addinfo = '';
		$isnewerversion = 0;
	}

	$userinfo['diskspace'] = round($userinfo['diskspace'] / 1024, $settings['panel']['decimal_places']);
	$userinfo['diskspace_used'] = round($userinfo['diskspace_used'] / 1024, $settings['panel']['decimal_places']);
	$userinfo['traffic'] = round($userinfo['traffic'] / (1024 * 1024), $settings['panel']['decimal_places']);
	$userinfo['traffic_used'] = round($userinfo['traffic_used'] / (1024 * 1024), $settings['panel']['decimal_places']);
	$userinfo = str_replace_array('-1', $lng['customer']['unlimited'], $userinfo, 'customers domains diskspace traffic mysqls emails email_accounts email_forwarders email_quota email_autoresponder ftps tickets subdomains aps_packages');

	$cron_last_runs = getCronjobsLastRun();
	$outstanding_tasks = getOutstandingTasks();

	$opentickets = 0;
	$opentickets = $db->query_first('SELECT COUNT(`id`) as `count` FROM `' . TABLE_PANEL_TICKETS . '`
                                   WHERE `answerto` = "0" AND (`status` = "0" OR `status` = "1")
                                   AND `lastreplier`="0" AND `adminid` = "' . $userinfo['adminid'] . '"');
	$awaitingtickets = $opentickets['count'];
	$awaitingtickets_text = '';

	if($opentickets > 0)
	{
		$awaitingtickets_text = strtr($lng['ticket']['awaitingticketreply'], array('%s' => '<a href="admin_tickets.php?page=tickets&amp;s=' . $s . '">' . $opentickets['count'] . '</a>'));
	}

	if(function_exists('sys_getloadavg'))
	{
		$loadArray = sys_getloadavg();
		$load = number_format($loadArray[0], 2, '.', '') . " / " . number_format($loadArray[1], 2, '.', '') . " / " . number_format($loadArray[2], 2, '.', '');
	}
	else
	{
		$load = @file_get_contents('/proc/loadavg');

		if(!$load)
		{
			$load = $lng['admin']['noloadavailable'];
		}
	}

	if(function_exists('posix_uname'))
	{
		$showkernel = 1;
		$kernel_nfo = posix_uname();
		$kernel = $kernel_nfo['release'] . ' (' . $kernel_nfo['machine'] . ')';
	}
	else
	{
		$showkernel = 0;
		$kernel = '';
	}

	// Try to get the uptime
	// First: With exec (let's hope it's enabled for the Froxlor - vHost)

	$uptime_array = explode(" ", @file_get_contents("/proc/uptime"));

	if(is_array($uptime_array)
	&& isset($uptime_array[0])
	&& is_numeric($uptime_array[0]))
	{
		// Some calculatioon to get a nicly formatted display

		$seconds = round($uptime_array[0], 0);
		$minutes = $seconds / 60;
		$hours = $minutes / 60;
		$days = floor($hours / 24);
		$hours = floor($hours - ($days * 24));
		$minutes = floor($minutes - ($days * 24 * 60) - ($hours * 60));
		$seconds = floor($seconds - ($days * 24 * 60 * 60) - ($hours * 60 * 60) - ($minutes * 60));
		$uptime = "{$days}d, {$hours}h, {$minutes}m, {$seconds}s";

		// Just cleanup

		unset($uptime_array, $seconds, $minutes, $hours, $days);
	}
	else
	{
		// Nothing of the above worked, show an error :/

		$uptime = '';
	}

	eval("echo \"" . getTemplate("index/index") . "\";");
}
elseif($page == 'change_password')
{
	if(isset($_POST['send'])
	&& $_POST['send'] == 'send')
	{
		$old_password = validate($_POST['old_password'], 'old password');

		if(md5($old_password) != $userinfo['password'])
		{
			standard_error('oldpasswordnotcorrect');
			exit;
		}

		$new_password = validate($_POST['new_password'], 'new password');
		$new_password_confirm = validate($_POST['new_password_confirm'], 'new password confirm');

		if($old_password == '')
		{
			standard_error(array('stringisempty', 'oldpassword'));
		}
		elseif($new_password == '')
		{
			standard_error(array('stringisempty', 'newpassword'));
		}
		elseif($new_password_confirm == '')
		{
			standard_error(array('stringisempty', 'newpasswordconfirm'));
		}
		elseif($new_password != $new_password_confirm)
		{
			standard_error('newpasswordconfirmerror');
		}
		else
		{
			$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `password`='" . md5($new_password) . "' WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `password`='" . md5($old_password) . "'");
			$log->logAction(ADM_ACTION, LOG_NOTICE, 'changed password');
			redirectTo($filename, Array('s' => $s));
		}
	}
	else
	{
		eval("echo \"" . getTemplate("index/change_password") . "\";");
	}
}
elseif($page == 'change_language')
{
	if(isset($_POST['send'])
	&& $_POST['send'] == 'send')
	{
		$def_language = validate($_POST['def_language'], 'default language');

		if(isset($languages[$def_language]))
		{
			$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `def_language`='" . $db->escape($def_language) . "' WHERE `adminid`='" . (int)$userinfo['adminid'] . "'");
			$db->query("UPDATE `" . TABLE_PANEL_SESSIONS . "` SET `language`='" . $db->escape($def_language) . "' WHERE `hash`='" . $db->escape($s) . "'");
		}

		$log->logAction(ADM_ACTION, LOG_NOTICE, "changed his/her default language to '" . $def_language . "'");
		redirectTo($filename, Array('s' => $s));
	}
	else
	{
		$language_options = '';

		$default_lang = $settings['panel']['standardlanguage'];
		if($userinfo['def_language'] != '') {
			$default_lang = $userinfo['def_language'];
		}

		while(list($language_file, $language_name) = each($languages))
		{
			$language_options.= makeoption($language_name, $language_file, $default_lang, true);
		}

		eval("echo \"" . getTemplate("index/change_language") . "\";");
	}
}
elseif($page == 'change_theme')
{
	if(isset($_POST['send'])
		&& $_POST['send'] == 'send'
	) {
		$theme = validate($_POST['theme'], 'theme');

		$db->query("UPDATE `" . TABLE_PANEL_ADMINS . "` SET `theme`='" . $db->escape($theme) . "' WHERE `adminid`='" . (int)$userinfo['adminid'] . "'");
		$db->query("UPDATE `" . TABLE_PANEL_SESSIONS . "` SET `theme`='" . $db->escape($theme) . "' WHERE `hash`='" . $db->escape($s) . "'");

		$log->logAction(ADM_ACTION, LOG_NOTICE, "changed his/her theme to '" . $theme . "'");
		redirectTo($filename, Array('s' => $s));
	}
	else
	{
		$theme_options = '';

		$default_theme = $settings['panel']['default_theme'];
		if($userinfo['theme'] != '') {
			$default_theme = $userinfo['theme'];
		}

		$themes_avail = getThemes();
		foreach($themes_avail as $t)
		{
			$theme_options.= makeoption($t, $t, $default_theme, true);
		}

		eval("echo \"" . getTemplate("index/change_theme") . "\";");
	}
}
