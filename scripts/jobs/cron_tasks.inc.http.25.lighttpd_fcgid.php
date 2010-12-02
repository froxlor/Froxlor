<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 * @version    $Id$
 */

/*
 * This script creates the php.ini's used by mod_suPHP+php-cgi
 */

if(@php_sapi_name() != 'cli'
&& @php_sapi_name() != 'cgi'
&& @php_sapi_name() != 'cgi-fcgi')
{
	die('This script only works in the shell.');
}

class lighttpd_fcgid extends lighttpd
{
	private $php_configs_cache = array();
	private $admin_cache = array();

	protected function composePhpOptions($domain)
	{
		$php_options_text = '';

		if($domain['phpenabled'] == '1')
		{
			if((int)$this->settings['phpfpm']['enabled'] == 1)
			{
				$php_options_text = $this->_createFpmPart($domain);
			}
			else
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
	
				$php_options_text = '  fastcgi.server = ( '."\n";
				$file_extensions = explode(' ', $phpconfig['file_extensions']);
				foreach($file_extensions as $f_extension)
				{
					$php_options_text.=	"\t".'".'.$f_extension.'" => ('."\n";
					$php_options_text.=	"\t\t".'"localhost" => ('."\n";
					$php_options_text.=	"\t\t".'"socket" => "/var/run/lighttpd/'.$domain['loginname'].'-'.$domain['domain'].'-php.socket",'."\n";
					$php_options_text.=	"\t\t".'"bin-path" => "'.$phpconfig['binary'].' -c '.$phpini_filename.'",'."\n";
					$php_options_text.=	"\t\t".'"bin-environment" => ('."\n";
					if((int)$domain['mod_fcgid_starter'] != - 1)
					{
						$php_options_text.=	"\t\t\t".'"PHP_FCGI_CHILDREN" => "' . (int)$domain['mod_fcgid_starter'] . '",'."\n";
					}
					else
					{
						if((int)$phpconfig['mod_fcgid_starter'] != - 1)
						{
							$php_options_text.=	"\t\t\t".'"PHP_FCGI_CHILDREN" => "' . (int)$phpconfig['mod_fcgid_starter'] . '",'."\n";
						}
						else
						{
							$php_options_text.=	"\t\t\t".'"PHP_FCGI_CHILDREN" => "' . (int)$this->settings['system']['mod_fcgid_starter'] . '",'."\n";
						}
					}
	
					if((int)$domain['mod_fcgid_maxrequests'] != - 1)
					{
						$php_options_text.=	"\t\t\t".'"PHP_FCGI_MAX_REQUESTS" => "' . (int)$domain['mod_fcgid_maxrequests'] . '"'."\n";
					}
					else
					{
						if((int)$phpconfig['mod_fcgid_maxrequests'] != - 1)
						{
							$php_options_text.=	"\t\t\t".'"PHP_FCGI_MAX_REQUESTS" => "' . (int)$phpconfig['mod_fcgid_maxrequests'] . '"'."\n";
						}
						else
						{
							$php_options_text.=	"\t\t\t".'"PHP_FCGI_MAX_REQUESTS" => "' . (int)$this->settings['system']['mod_fcgid_maxrequests'] . '"'."\n";
						}
					}
	
					$php_options_text.=	"\t\t".')'."\n";
					$php_options_text.=	"\t".')'."\n";
					$php_options_text.=	"\t".')'."\n";
	
				} // foreach extension
				$php_options_text.=	'  )'."\n";
	
				// create starter
	
				$starter_file = "#!/bin/sh\n\n";
				$starter_file.= "#\n";
				$starter_file.= "# starter created/changed on " . date("Y.m.d H:i:s") . " for domain '" . $domain['domain'] . "' with id #" . $domain['id'] . " from php template '" . $phpconfig['description'] . "' with id #" . $phpconfig['id'] . "\n";
				$starter_file.= "# Do not change anything in this file, it will be overwritten by the Froxlor Cronjob!\n";
				$starter_file.= "#\n\n";
				$starter_file.= "umask 022\n";
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
					removeImmutable($starter_filename);
				}
	
				$starter_file_handler = fopen($starter_filename, 'w');
				fwrite($starter_file_handler, $starter_file);
				fclose($starter_file_handler);
				safe_exec('chmod 750 ' . escapeshellarg($starter_filename));
				safe_exec('chown ' . $domain['guid'] . ':' . $domain['guid'] . ' ' . escapeshellarg($starter_filename));
				setImmutable($starter_filename);
	
				// define the php.ini
	
				$openbasedir = '';
				$openbasedirc = ';';
	
				if($domain['openbasedir'] == '1')
				{
					$openbasedirc = '';
					$_phpappendopenbasedir = '';
	
					$_custom_openbasedir = explode(':', $this->settings['system']['mod_fcgid_peardir']);
					foreach($_custom_openbasedir as $cobd)
					{
						$_phpappendopenbasedir .= appendOpenBasedirPath($cobd);
					}
	
					$_custom_openbasedir = explode(':', $this->settings['system']['phpappendopenbasedir']);
					foreach($_custom_openbasedir as $cobd)
					{
						$_phpappendopenbasedir .= appendOpenBasedirPath($cobd);
					}
	
					if($domain['openbasedir_path'] == '0' && strstr($domain['documentroot'], ":") === false)
					{
						$openbasedir = appendOpenBasedirPath($domain['documentroot'], true);
					}
					else
					{
						$openbasedir = appendOpenBasedirPath($domain['customerroot'], true);
					}
	
					$openbasedir .= appendOpenBasedirPath($tmpdir);
					$openbasedir .= $_phpappendopenbasedir;
	
					$openbasedir = explode(':', $openbasedir);
					$clean_openbasedir = array();
					foreach($openbasedir as $number => $path)
					{
						if(trim($path) != '/')
						{
							$clean_openbasedir[] = makeCorrectDir($path);
						}
					}
					$openbasedir = implode(':', $clean_openbasedir);
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

	private function _createFpmPart($domain)
	{
		$php_options_text = '';
		
		$socket = makeCorrectFile('/var/run/lighttpd/'.$domain['loginname'].'-'.$domain['domain'].'-php-fpm.socket');
		$tmpfile = makeCorrectFile($this->settings['phpfpm']['configdir'].'/'.$domain['domain'].'.conf');
		
		$fh = @fopen($tmpfile, 'w');
		if($fh)
		{
			$fpm_pm = $this->settings['phpfpm']['pm'];
			$fpm_children = (int)$this->settings['phpfpm']['max_children'];
			$fpm_start_servers = (int)$this->settings['phpfpm']['start_servers'];
			$fpm_min_spare_servers = (int)$this->settings['phpfpm']['min_spare_servers'];
			$fpm_max_spare_servers = (int)$this->settings['phpfpm']['max_spare_servers'];
			$fpm_requests = (int)$this->settings['phpfpm']['max_requests'];

			if($fpm_children == 0) {
				$fpm_children = 1;
			}

			$tmpdir = makeCorrectDir($this->settings['phpfpm']['tmpdir'] . '/' . $domain['loginname'] . '/');
			//$slowlog = makeCorrectFile($this->settings['system']['logfiles_directory'] . $domain['loginname'] . '/php-fpm_slow.log');

			$fpm_config = ';PHP-FPM configuration for "'.$domain['domain'].'" created on ' . date("Y.m.d H:i:s") . "\n\n";
			$fpm_config.= '['.$domain['domain'].']'."\n";
			$fpm_config.= 'listen = '.$socket."\n";
			$fpm_config.= 'listen.owner = '.$domain['loginname']."\n";
			$fpm_config.= 'listen.group = '.$domain['loginname']."\n";
			$fpm_config.= 'listen.mode = 0666'."\n\n";

			$fpm_config.= 'user = '.$domain['loginname']."\n";
			$fpm_config.= 'group = '.$domain['loginname']."\n\n";

			$fpm_config.= 'pm = '.$fpm_pm."\n";
			$fpm_config.= 'pm.max_children = '.$fpm_children."\n";
			if($fpm_pm == 'dynamic') {
				$fpm_config.= 'pm.start_servers = '.$fpm_start_servers."\n";
				$fpm_config.= 'pm.min_spare_servers = '.$fpm_min_spare_servers."\n";
				$fpm_config.= 'pm.max_spare_servers = '.$fpm_max_spare_servers."\n";
			}
			$fpm_config.= 'pm.max_requests = '.$fpm_requests."\n\n";

			$fpm_config.= ';chroot = '.makeCorrectDir($domain['documentroot'])."\n\n";

			$fpm_config.= 'env[TMP] = '.$tmpdir."\n";
			$fpm_config.= 'env[TMPDIR] = '.$tmpdir."\n";
			$fpm_config.= 'env[TEMP] = '.$tmpdir."\n\n";

			$fpm_config.= 'php_admin_value[sendmail_path] = /usr/sbin/sendmail -t -i -f '.$domain['email']."\n\n";
			$fpm_config.= 'php_admin_value[open_basedir] = ' . $this->settings['system']['documentroot_prefix'] . $domain['loginname'] . '/:' . $this->settings['phpfpm']['tmpdir'] . '/' . $domain['loginname'] . '/:' . $this->settings['phpfpm']['peardir'] . "\n";
			$fpm_config.= 'php_admin_value[session.save_path] = ' . $this->settings['phpfpm']['tmpdir'] . '/' . $domain['loginname'] . '/' . "\n";
			$fpm_config.= 'php_admin_value[upload_tmp_dir] = ' . $this->settings['phpfpm']['tmpdir'] . '/' . $domain['loginname'] . '/' . "\n\n";
			
			fwrite($fh, $fpm_config, strlen($fpm_config));
			fclose($fh);
			
			$php_options_text = '  fastcgi.server = ( '."\n";
			$php_options_text.=	"\t".'".php" => ('."\n";
			$php_options_text.=	"\t\t".'"localhost" => ('."\n";
			$php_options_text.=	"\t\t".'"socket" => "'.$socket.'",'."\n";
			$php_options_text.=	"\t\t".'"check-local" => "enable",'."\n";
			$php_options_text.=	"\t\t".'"disable-time" => 1'."\n";
			$php_options_text.=	"\t".')'."\n";
			$php_options_text.=	"\t".')'."\n";
			$php_options_text.=	'  )'."\n";
		}
		else
		{
			$php_options_text = '   # could not create php-fpm configuration for '.$domain['domain']. "\n";
		}
		return $php_options_text;
	}
}
