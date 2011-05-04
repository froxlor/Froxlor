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

$need_db_sql_data = true;
require ("./lib/init.php");
require ("./lib/configfiles_index.inc.php");
$distribution = '';
$distributions_select = '';
$service = '';
$services_select = '';
$daemon = '';
$daemons_select = '';

if($userinfo['change_serversettings'] == '1')
{
	if(isset($_GET['distribution'])
	   && $_GET['distribution'] != ''
	   && isset($configfiles[$_GET['distribution']])
	   && is_array($configfiles[$_GET['distribution']]))
	{
		$distribution = $_GET['distribution'];

		if(isset($_GET['service'])
		   && $_GET['service'] != ''
		   && isset($configfiles[$distribution]['services'][$_GET['service']])
		   && is_array($configfiles[$distribution]['services'][$_GET['service']]))
		{
			$service = $_GET['service'];

			if(isset($_GET['daemon'])
			   && $_GET['daemon'] != ''
			   && isset($configfiles[$distribution]['services'][$service]['daemons'][$_GET['daemon']])
			   && is_array($configfiles[$distribution]['services'][$service]['daemons'][$_GET['daemon']]))
			{
				$daemon = $_GET['daemon'];
			}
			else
			{
				foreach($configfiles[$distribution]['services'][$service]['daemons'] as $daemon_name => $daemon_details)
				{
					$daemons_select.= makeoption($daemon_details['label'], $daemon_name);
				}
			}
		}
		else
		{
			foreach($configfiles[$distribution]['services'] as $service_name => $service_details)
			{
				$services_select.= makeoption($service_details['label'], $service_name);
			}
		}
	}
	else
	{
		foreach($configfiles as $distribution_name => $distribution_details)
		{
			$distributions_select.= makeoption($distribution_details['label'], $distribution_name);
		}
	}

	if($distribution != ''
	   && $service != ''
	   && $daemon != '')
	{
		$replace_arr = Array(
			'<SQL_UNPRIVILEGED_USER>' => $sql['user'],
			'<SQL_UNPRIVILEGED_PASSWORD>' => 'MYSQL_PASSWORD',
			'<SQL_DB>' => $sql['db'],
			'<SQL_HOST>' => $sql['host'],
			'<SERVERNAME>' => $settings['system']['hostname'],
			'<SERVERIP>' => $settings['system']['ipaddress'],
			'<NAMESERVERS>' => $settings['system']['nameservers'],
			'<VIRTUAL_MAILBOX_BASE>' => $settings['system']['vmail_homedir'],
			'<VIRTUAL_UID_MAPS>' => $settings['system']['vmail_uid'],
			'<VIRTUAL_GID_MAPS>' => $settings['system']['vmail_gid'],
			'<SSLPROTOCOLS>' => ($settings['system']['use_ssl'] == '1') ? 'imaps pop3s' : '',
			'<CUSTOMER_TMP>' => ($settings['system']['mod_fcgid_tmpdir'] != '') ? makeCorrectDir($settings['system']['mod_fcgid_tmpdir']) : '/tmp/',
			'<BASE_PATH>' => makeCorrectDir(dirname(__FILE__)),
			'<BIND_CONFIG_PATH>' => makeCorrectDir($settings['system']['bindconf_directory'])
		);
		$files = '';
		$configpage = '';
		foreach($configfiles[$distribution]['services'][$service]['daemons'][$daemon] as $action => $value)
		{
			if(substr($action, 0, 8) == 'commands')
			{
				$commands = '';

				if(is_array($value))
				{
					$commands = implode("\n", $value);
					$commands = str_replace("\n\n", "\n", $commands);

					if($commands != '')
					{
						eval("\$configpage.=\"" . getTemplate("configfiles/configfiles_commands") . "\";");
					}
				}
			}
			elseif(substr($action, 0, 5) == 'files')
			{
				$files = '';

				if(is_array($value))
				{
					while(list($filename, $realname) = each($value))
					{
						$file_content = file_get_contents('./templates/misc/configfiles/' . $distribution . '/' . $daemon . '/' . $filename);
						$file_content = strtr($file_content, $replace_arr);
						$file_content = htmlspecialchars($file_content);
						$numbrows = count(explode("\n", $file_content));
						eval("\$files.=\"" . getTemplate("configfiles/configfiles_file") . "\";");
					}

					eval("\$configpage.=\"" . getTemplate("configfiles/configfiles_files") . "\";");
				}
			}
		}

		if(isset($configfiles[$distribution]['services'][$service]['daemons'][$daemon]['restart'])
		   && is_array($configfiles[$distribution]['services'][$service]['daemons'][$daemon]['restart']))
		{
			$restart = implode("\n", $configfiles[$distribution]['services'][$service]['daemons'][$daemon]['restart']);
		}
		else
		{
			$restart = '';
		}

		eval("echo \"" . getTemplate("configfiles/configfiles") . "\";");
	}
	elseif($page == 'overview')
	{
		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_configfiles");
		$distributions = '';
		foreach($configfiles as $distribution_name => $distribution_details)
		{
			$services = '';
			foreach($distribution_details['services'] as $service_name => $service_details)
			{
				$daemons = '';
				foreach($service_details['daemons'] as $daemon_name => $daemon_details)
				{
					eval("\$daemons.=\"" . getTemplate("configfiles/choose_daemon") . "\";");
				}

				eval("\$services.=\"" . getTemplate("configfiles/choose_service") . "\";");
			}

			eval("\$distributions.=\"" . getTemplate("configfiles/choose_distribution") . "\";");
		}

		eval("echo \"" . getTemplate("configfiles/choose") . "\";");
	}
	else
	{
		eval("echo \"" . getTemplate("configfiles/wizard") . "\";");
	}
}

?>
