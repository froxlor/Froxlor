<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    System
 * @version    $Id: install_configs.php 2698 2009-04-13 20:25:59Z flo $
 */

/**
 * STARTING REDUNDANT CODE, WHICH IS SOME KINDA HEADER FOR EVERY CRON SCRIPT.
 * When using this "header" you have to change $lockFilename for your needs.
 * Don't forget to also copy the footer which closes database connections
 * and the lockfile!
 */

include (dirname(__FILE__) . '/../lib/cron_init.php');

/**
 * END REDUNDANT CODE (CRONSCRIPT "HEADER")
 */

require ($pathtophpfiles . '/lib/configfiles_index.inc.php');
require ($pathtophpfiles . '/lib/userdata.inc.php');

$replace_arr = Array(
	'<SQL_UNPRIVILEGED_USER>' => $sql['user'],
	'<SQL_UNPRIVILEGED_PASSWORD>' => $sql['password'],
	'<SQL_DB>' => $sql['db'],
	'<SQL_HOST>' => $sql['host'],
	'<SERVERNAME>' => $settings['system']['hostname'],
	'<SERVERIP>' => $settings['system']['ipaddress'],
	'<NAMESERVERS>' => $settings['system']['nameservers'],
	'<VIRTUAL_MAILBOX_BASE>' => $settings['system']['vmail_homedir'],
	'<VIRTUAL_UID_MAPS>' => $settings['system']['vmail_uid'],
	'<VIRTUAL_GID_MAPS>' => $settings['system']['vmail_gid'],
	'<AWSTATS_PATH>' => $settings['system']['awstats_path'],
	'<SSLPROTOCOLS>' => ($settings['system']['use_ssl'] == '1') ? 'imaps pop3s' : ''
);

$cli_params = $_SERVER['argv'];
unset($cli_params[0]);

if(isset($cli_params[1]) && $cli_params[1] != '' && isset($configfiles[$cli_params[1]]))
{
	$distribution = $cli_params[1];
	unset($cli_params[1]);
}
else
{
	echo 'No valid distribution specified!' . "\n";
}

foreach($cli_params as $cli_param)
{
	list($service, $daemon) = explode('=', $cli_param);
	echo $service . ' ' . $daemon;
	if(isset($configfiles[$distribution]['services'][$service]) && isset($configfiles[$distribution]['services'][$service]['daemons'][$daemon]))
	{
		foreach($configfiles[$distribution]['services'][$service]['daemons'][$daemon] as $action => $value)
		{
			if(substr($action, 0, 8) == 'commands')
			{
				if(is_array($value))
				{
					echo '=== COMMANDS BEGIN ===' . "\n";
					foreach($value as $command)
					{
						echo '-- running ' . $command . "\n";
						if(in_array('reallydoit', $cli_params))
						{
							passthru($command);
						}
					}
					echo '==== COMMANDS END ====' . "\n";
				}
			}
			elseif(substr($action, 0, 5) == 'files')
			{
				if(is_array($value))
				{
					echo '=== FILES BEGIN ===' . "\n";
					while(list($filename, $realname) = each($value))
					{
						$file_content = file_get_contents('./templates/misc/configfiles/' . $distribution . '/' . $daemon . '/' . $filename);
						$file_content = strtr($file_content, $replace_arr);
						echo '-- filename: ' . $realname . "\n";
						echo '-- filecontent:' . "\n" . '---' . "\n";
						echo $file_content;
						echo '---' . "\n";
						if(in_array('reallydoit', $cli_params))
						{
							if(file_exists($realname))
							{
								exec('mv ' . escapeshellarg($realname) . ' ' . escapeshellarg($realname) . '.orig');
							}
							file_put_contents($realname, $file_content);
						}
					}
					echo '==== FILES END ====' . "\n";
				}
			}
		}

		if(isset($configfiles[$distribution]['services'][$service]['daemons'][$daemon]['restart'])
		   && is_array($configfiles[$distribution]['services'][$service]['daemons'][$daemon]['restart']))
		{
			echo '=== RESTART BEGIN ===' . "\n";
			foreach($configfiles[$distribution]['services'][$service]['daemons'][$daemon]['restart'] as $command)
			{
				echo '-- running ' . $command . "\n";
				if(in_array('reallydoit', $cli_params))
				{
					passthru($command);
				}
			}
			echo '==== RESTART END ====' . "\n";
		}
	}
}

/**
 * STARTING CRONSCRIPT FOOTER
 */

include ($pathtophpfiles . '/lib/cron_shutdown.php');

/**
 * END CRONSCRIPT FOOTER
 */

?>