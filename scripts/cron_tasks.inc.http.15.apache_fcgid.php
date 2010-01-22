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
 * @author     Florian Aders <eleras@syscp.org>
 * @author     Luca Longinotti <chtekk@syscp.org>
 * @author     Michael Kaufmann <mk@syscp-help.org>
 * @author     Sven Skrabal <info@nexpa.de>
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    System
 * @version    $Id: cron_tasks.inc.http.15.apache_fcgid.php 2714 2009-04-17 10:02:03Z flo $
 */

if(@php_sapi_name() != 'cli'
   && @php_sapi_name() != 'cgi'
   && @php_sapi_name() != 'cgi-fcgi')
{
	die('This script only works in the shell.');
}

class apache_fcgid extends apache
{
	private $php_configs_cache = array();
	private $admin_cache = array();

	/*
	*	We put together the needed php options in the virtualhost entries
	*/

	protected function composePhpOptions($domain)
	{
		$php_options_text = '';

		if($domain['phpenabled'] == '1')
		{
			// This vHost has PHP enabled and we are using mod_fcgid
			//create basic variables for config

			$configdir = makeCorrectDir($this->settings['system']['mod_fcgid_configdir'] . '/' . $domain['loginname'] . '/' . $domain['domain'] . '/');
			$starter_filename = makeCorrectFile($configdir . '/php-fcgi-starter');
			$phpini_filename = makeCorrectFile($configdir . '/php.ini');
			$tmpdir = makeCorrectDir($this->settings['system']['mod_fcgid_tmpdir'] . '/' . $domain['loginname'] . '/');

			// create config dir if necessary

			if(!is_dir($configdir))
			{
				safe_exec('mkdir -p ' . escapeshellarg($configdir));
				safe_exec('chown ' . $domain['guid'] . ':' . $domain['guid'] . ' ' . escapeshellarg($configdir));
			}

			// create tmp dir if necessary

			if(!is_dir($tmpdir))
			{
				safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
				safe_exec('chown -R ' . $domain['guid'] . ':' . $domain['guid'] . ' ' . escapeshellarg($tmpdir));
				safe_exec('chmod 0750 ' . escapeshellarg($tmpdir));
			}

			// Load php config

			$phpconfig = $this->getPhpConfig((int)$domain['phpsettingid']);

			if((int)$this->settings['system']['mod_fcgid_wrapper'] == 0)
			{
				$php_options_text.= '  SuexecUserGroup "' . $domain['loginname'] . '" "' . $domain['loginname'] . '"' . "\n";
				$php_options_text.= '  ScriptAlias /php/ ' . $configdir . "\n";
			}
			else
			{
				$php_options_text.= '  SuexecUserGroup "' . $domain['loginname'] . '" "' . $domain['loginname'] . '"' . "\n";
				$php_options_text.= '  <Directory "' . $domain['documentroot'] . '">' . "\n";
				$file_extensions = explode(' ', $phpconfig['file_extensions']);
				$php_options_text.= '    AddHandler fcgid-script .' . implode(' .', $file_extensions) . "\n";
				foreach($file_extensions as $file_extension)
				{
					$php_options_text.= '    FCGIWrapper ' . $starter_filename . ' .' . $file_extension . "\n";
				}

				$php_options_text.= '    Options +ExecCGI' . "\n";
				$php_options_text.= '    Order allow,deny' . "\n";
				$php_options_text.= '    allow from all' . "\n";
				$php_options_text.= '  </Directory>' . "\n";
			}

			// create starter

			$starter_file = "#!/bin/sh\n\n";
			$starter_file.= "#\n";
			$starter_file.= "# starter created/changed on " . date("Y.m.d H:i:s") . " for domain '" . $domain['domain'] . "' with id #" . $domain['id'] . " from php template '" . $phpconfig['description'] . "' with id #" . $phpconfig['id'] . "\n";
			$starter_file.= "# Do not change anything in this file, it will be overwritten by the Froxlor Cronjob!\n";
			$starter_file.= "#\n\n";
			$starter_file.= "PHPRC=" . escapeshellarg($configdir) . "\n";
			$starter_file.= "export PHPRC\n";

			// set number of processes for one domain

			if((int)$domain['mod_fcgid_starter'] != - 1)
			{
				$starter_file.= "PHP_FCGI_CHILDREN=" . (int)$domain['mod_fcgid_starter'] . "\n";
			}
			else
			{
				if((int)$phpconfig['mod_fcgid_starter'] != - 1)
				{
					$starter_file.= "PHP_FCGI_CHILDREN=" . (int)$phpconfig['mod_fcgid_starter'] . "\n";
				}
				else
				{
					$starter_file.= "PHP_FCGI_CHILDREN=" . (int)$this->settings['system']['mod_fcgid_starter'] . "\n";
				}
			}

			$starter_file.= "export PHP_FCGI_CHILDREN\n";

			// set number of maximum requests for one domain

			if((int)$domain['mod_fcgid_maxrequests'] != - 1)
			{
				$starter_file.= "PHP_FCGI_MAX_REQUESTS=" . (int)$domain['mod_fcgid_maxrequests'] . "\n";
			}
			else
			{
				if((int)$phpconfig['mod_fcgid_maxrequests'] != - 1)
				{
					$starter_file.= "PHP_FCGI_MAX_REQUESTS=" . (int)$phpconfig['mod_fcgid_maxrequests'] . "\n";
				}
				else
				{
					$starter_file.= "PHP_FCGI_MAX_REQUESTS=" . (int)$this->settings['system']['mod_fcgid_maxrequests'] . "\n";
				}
			}

			$starter_file.= "export PHP_FCGI_MAX_REQUESTS\n";

			// Set Binary

			$starter_file.= "exec " . $phpconfig['binary'] . " -c " . escapeshellarg($configdir) . "\n";

			//remove +i attibute, so starter can be overwritten

			if(file_exists($starter_filename))
			{
				safe_exec('chattr -i ' . escapeshellarg($starter_filename));
			}

			$starter_file_handler = fopen($starter_filename, 'w');
			fwrite($starter_file_handler, $starter_file);
			fclose($starter_file_handler);
			safe_exec('chmod 750 ' . escapeshellarg($starter_filename));
			safe_exec('chown ' . $domain['guid'] . ':' . $domain['guid'] . ' ' . escapeshellarg($starter_filename));
			safe_exec('chattr +i ' . escapeshellarg($starter_filename));

			// define the php.ini

			$openbasedir = '';
			$openbasedirc = ';';

			if($domain['openbasedir'] == '1')
			{
				$openbasedirc = '';
				if($domain['openbasedir_path'] == '0')
				{
					$openbasedir = $domain['documentroot'] . ':' . $tmpdir . ':' . $this->settings['system']['mod_fcgid_peardir'] . ':' . $this->settings['system']['phpappendopenbasedir'];
				}
				else
				{
					$openbasedir = $domain['customerroot'] . ':' . $tmpdir . ':' . $this->settings['system']['mod_fcgid_peardir'] . ':' . $this->settings['system']['phpappendopenbasedir'];
				}

				$openbasedir = explode(':', $openbasedir);
				foreach($openbasedir as $number => $path)
				{
					$openbasedir[$number] = makeCorrectDir($path);
				}

				$openbasedir = implode(':', $openbasedir);
			}
			else
			{
				$openbasedir = 'none';
				$openbasedirc = ';';
			}

			$admin = $this->getAdminData($domain['adminid']);
			$php_ini_variables = array(
				'SAFE_MODE' => ($domain['safemode'] == '0' ? 'Off' : 'On'),
				'PEAR_DIR' => $this->settings['system']['mod_fcgid_peardir'],
				'OPEN_BASEDIR' => $openbasedir,
				'OPEN_BASEDIR_C' => $openbasedirc,
				'OPEN_BASEDIR_GLOBAL' => $this->settings['system']['phpappendopenbasedir'],
				'TMP_DIR' => $tmpdir,
				'CUSTOMER_EMAIL' => $domain['email'],
				'ADMIN_EMAIL' => $admin['email'],
				'DOMAIN' => $domain['domain'],
				'CUSTOMER' => $domain['loginname'],
				'ADMIN' => $admin['loginname']
			);

			//insert a small header for the file

			$phpini_file = ";\n";
			$phpini_file.= "; php.ini created/changed on " . date("Y.m.d H:i:s") . " for domain '" . $domain['domain'] . "' with id #" . $domain['id'] . " from php template '" . $phpconfig['description'] . "' with id #" . $phpconfig['id'] . "\n";
			$phpini_file.= "; Do not change anything in this file, it will be overwritten by the Froxlor Cronjob!\n";
			$phpini_file.= ";\n\n";
			$phpini_file.= replace_variables($phpconfig['phpsettings'], $php_ini_variables);
			$phpini_file = str_replace('"none"', 'none', $phpini_file);
			$phpini_file = preg_replace('/\"+/', '"', $phpini_file);
			$phpini_file_handler = fopen($phpini_filename, 'w');
			fwrite($phpini_file_handler, $phpini_file);
			fclose($phpini_file_handler);
			safe_exec('chown root:0 ' . escapeshellarg($phpini_filename));
			safe_exec('chmod 0644 ' . escapeshellarg($phpini_filename));
		}
		else
		{
			$php_options_text.= '  # PHP is disabled for this vHost' . "\n";
		}

		return $php_options_text;
	}

	private function getPhpConfig($php_config_id)
	{
		$php_config_id = intval($php_config_id);

		// If domain has no config, we will use the default one.

		if($php_config_id == 0)
		{
			$php_config_id = 1;
		}

		if(!isset($this->php_configs_cache[$php_config_id]))
		{
			$this->php_configs_cache[$php_config_id] = $this->getDB()->query_first("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = " . (int)$php_config_id);
		}

		return $this->php_configs_cache[$php_config_id];
	}

	private function getAdminData($adminid)
	{
		$adminid = intval($adminid);

		if(!isset($this->admin_cache[$adminid]))
		{
			$this->admin_cache[$adminid] = $this->getDB()->query_first("SELECT `email`, `loginname` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid` = " . (int)$adminid);
		}

		return $this->admin_cache[$adminid];
	}
}

?>
