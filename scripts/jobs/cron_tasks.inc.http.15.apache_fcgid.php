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
 * @package    Cron
 * @version    $Id$
 */

if(@php_sapi_name() != 'cli'
   && @php_sapi_name() != 'cgi'
   && @php_sapi_name() != 'cgi-fcgi')
{
	die('This script only works in the shell.');
}

class apache_fcgid extends apache
{
	protected function composePhpOptions($domain)
	{
		$php_options_text = '';

		if($domain['phpenabled'] == '1')
		{
			$php = new phpinterface($this->getDB(), $this->settings, $domain);
			$phpconfig = $php->getPhpConfig((int)$domain['phpsettingid']);

			if((int)$this->settings['phpfpm']['enabled'] == 1)
			{
				$php_options_text.= '  SuexecUserGroup "' . $domain['loginname'] . '" "' . $domain['loginname'] . '"' . "\n";
				$php_options_text.= '  FastCgiExternalServer ' . makeCorrectDir($domain['documentroot']) . 'fpm.external -socket ' . $php->getInterface()->getSocketFile() . ' -user ' . $domain['loginname'] . ' -group ' . $domain['loginname'] . "\n";
				$php_options_text.= '  <Directory "' . makeCorrectDir($domain['documentroot']) . '">' . "\n";
				$php_options_text.= '    AddHandler php5-fastcgi .php'. "\n";
				$php_options_text.= '    Action php5-fastcgi /fastcgiphp' . "\n";
				$php_options_text.= '    Options +ExecCGI' . "\n";
				$php_options_text.= '    Order allow,deny' . "\n";
				$php_options_text.= '    allow from all' . "\n";
				$php_options_text.= '  </Directory>' . "\n";
				$php_options_text.= '  Alias /fastcgiphp ' . makeCorrectDir($domain['documentroot']) . 'fpm.external' . "\n";
			}
			else
			{
				if((int)$this->settings['system']['mod_fcgid_wrapper'] == 0)
				{
					$php_options_text.= '  SuexecUserGroup "' . $domain['loginname'] . '" "' . $domain['loginname'] . '"' . "\n";
					$php_options_text.= '  ScriptAlias /php/ ' . $php->getInterface()->getConfigDir() . "\n";
				}
				else
				{
					$php_options_text.= '  SuexecUserGroup "' . $domain['loginname'] . '" "' . $domain['loginname'] . '"' . "\n";
					$php_options_text.= '  <Directory "' . $domain['documentroot'] . '">' . "\n";
					$file_extensions = explode(' ', $phpconfig['file_extensions']);
					$php_options_text.= '    AddHandler fcgid-script .' . implode(' .', $file_extensions) . "\n";
					foreach($file_extensions as $file_extension)
					{
						$php_options_text.= '    FCGIWrapper ' . $php->getInterface()->getStarterFile() . ' .' . $file_extension . "\n";
					}
					$php_options_text.= '    Options +ExecCGI' . "\n";
					$php_options_text.= '    Order allow,deny' . "\n";
					$php_options_text.= '    allow from all' . "\n";
					$php_options_text.= '  </Directory>' . "\n";
				}
			}

			// create starter-file | config-file
			$php->getInterface()->createConfig($phpconfig);
			
			// create php.ini 
			// @TODO make php-fpm support this
			$php->getInterface()->createIniFile($phpconfig);
		}
		else
		{
			$php_options_text.= '  # PHP is disabled for this vHost' . "\n";
		}

		return $php_options_text;
	}

	public function createOwnVhostStarter()
	{
		if ($this->settings['system']['mod_fcgid_ownvhost'] == '1')
		{
			$mypath = makeCorrectDir(dirname(dirname(dirname(__FILE__)))); // /var/www/froxlor, needed for chown
			$configdir = makeCorrectDir($this->settings['system']['mod_fcgid_configdir'] . '/froxlor.panel/');
			$starter_filename = makeCorrectFile($configdir . '/php-fcgi-starter');
			$phpini_filename = makeCorrectFile($configdir . '/php.ini');
			$tmpdir = makeCorrectDir($this->settings['system']['mod_fcgid_tmpdir'] . '/froxlor.panel/');
			
			$user = $this->settings['system']['mod_fcgid_httpuser'];
			$group = $this->settings['system']['mod_fcgid_httpgroup'];

			// all the files and folders have to belong to the local user
			// now because we also use fcgid for our own vhost
			safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($mypath));
			
			// create config dir if necessary
			if(!is_dir($configdir))
			{
				safe_exec('mkdir -p ' . escapeshellarg($configdir));
				safe_exec('chown ' . $user . ':' . $group . ' ' . escapeshellarg($configdir));
			}

			// create tmp dir if necessary
			if(!is_dir($tmpdir))
			{
				safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
				safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($tmpdir));
				safe_exec('chmod 0750 ' . escapeshellarg($tmpdir));
			}
			
			// get php.ini for our own vhost
			$php = new phpinterface($this->getDB(), $this->settings, null);
			$phpconfig = $php->getPhpConfig($this->settings['system']['mod_fcgid_defaultini_ownvhost']);

			// create starter
			$starter_file = "#!/bin/sh\n\n";
			$starter_file.= "#\n";
			$starter_file.= "# starter created/changed on " . date("Y.m.d H:i:s") . " for the Froxlor vhost\n";
			$starter_file.= "# Do not change anything in this file, it will be overwritten by the Froxlor Cronjob!\n";
			$starter_file.= "#\n\n";
			$starter_file.= "umask 022\n";
			$starter_file.= "PHPRC=" . escapeshellarg($configdir) . "\n";
			$starter_file.= "export PHPRC\n";
			if((int)$phpconfig['mod_fcgid_starter'] != - 1)
			{
				$starter_file.= "PHP_FCGI_CHILDREN=" . (int)$phpconfig['mod_fcgid_starter'] . "\n";
			}
			else
			{
				$starter_file.= "PHP_FCGI_CHILDREN=" . (int)$this->settings['system']['mod_fcgid_starter'] . "\n";
			}
			$starter_file.= "export PHP_FCGI_CHILDREN\n";
			if((int)$phpconfig['mod_fcgid_maxrequests'] != - 1)
			{
				$starter_file.= "PHP_FCGI_MAX_REQUESTS=" . (int)$phpconfig['mod_fcgid_maxrequests'] . "\n";
			}
			else
			{
				$starter_file.= "PHP_FCGI_MAX_REQUESTS=" . (int)$this->settings['system']['mod_fcgid_maxrequests'] . "\n";
			}
			$starter_file.= "export PHP_FCGI_MAX_REQUESTS\n";

			// Set Binary
			$starter_file.= "exec " . $phpconfig['binary'] . " -c " . escapeshellarg($configdir) . "\n";

			//remove +i attibute, so starter can be overwritten
			if(file_exists($starter_filename))
			{
				removeImmutable($starter_filename);
			}

			$starter_file_handler = fopen($starter_filename, 'w');
			fwrite($starter_file_handler, $starter_file);
			fclose($starter_file_handler);
			safe_exec('chmod 750 ' . escapeshellarg($starter_filename));
			safe_exec('chown ' . $user . ':' . $group . ' ' . escapeshellarg($starter_filename));
			setImmutable($starter_filename);

			// define the php.ini

			$php_ini_variables = array(
				'SAFE_MODE' => 'Off',
				'PEAR_DIR' => $this->settings['system']['mod_fcgid_peardir'],
				'OPEN_BASEDIR' => 'none',
				'OPEN_BASEDIR_C' => ';',
				'OPEN_BASEDIR_GLOBAL' => '',
				'TMP_DIR' => $tmpdir,
				'CUSTOMER_EMAIL' => $this->settings['panel']['adminmail'],
				'ADMIN_EMAIL' => $this->settings['panel']['adminmail'],
				'DOMAIN' => $this->settings['system']['hostname'],
				'CUSTOMER' => $user,
				'ADMIN' => $user
			);

			//insert a small header for the file

			$phpini_file = ";\n";
			$phpini_file.= "; php.ini created/changed on " . date("Y.m.d H:i:s") . " for Froxlor-vhost from php template '" . $phpconfig['description'] . "' with id #" . $phpconfig['id'] . "\n";
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
	}
}
