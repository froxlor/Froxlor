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
 *
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
	protected function composePhpOptions($domain)
	{
		$php_options_text = '';

		if($domain['phpenabled'] == '1')
		{
			$php = new phpinterface($this->getDB(), $this->settings, $domain);
			$phpconfig = $php->getPhpConfig((int)$domain['phpsettingid']);

			// vhost data for php-fpm
			if((int)$this->settings['phpfpm']['enabled'] == 1)
			{
				$php_options_text = '  fastcgi.server = ( '."\n";
				$php_options_text.=	"\t".'".php" => ('."\n";
				$php_options_text.=	"\t\t".'"localhost" => ('."\n";
				$php_options_text.=	"\t\t".'"socket" => "'.$php->getInterface()->getSocketFile().'",'."\n";
				$php_options_text.=	"\t\t".'"check-local" => "enable",'."\n";
				$php_options_text.=	"\t\t".'"disable-time" => 1'."\n";
				$php_options_text.=	"\t".')'."\n";
				$php_options_text.=	"\t".')'."\n";
				$php_options_text.=	'  )'."\n";				
			}
			// vhost data for fcgid
			elseif((int)$this->settings['system']['mod_fcgid'] == 1)
			{
				$php_options_text = '  fastcgi.server = ( '."\n";
				$file_extensions = explode(' ', $phpconfig['file_extensions']);
				foreach($file_extensions as $f_extension)
				{
					$php_options_text.=	"\t".'".'.$f_extension.'" => ('."\n";
					$php_options_text.=	"\t\t".'"localhost" => ('."\n";
					$php_options_text.=	"\t\t".'"socket" => "/var/run/lighttpd/'.$domain['loginname'].'-'.$domain['domain'].'-php.socket",'."\n";
					$php_options_text.=	"\t\t".'"bin-path" => "'.$phpconfig['binary'].' -c '.$php->getInterface()->getIniFile().'",'."\n";
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
		if ($this->settings['phpfpm']['enabled'] == '1'
			&& $this->settings['phpfpm']['enabled_ownvhost'] == '1'
		) {
			$mypath = makeCorrectDir(dirname(dirname(dirname(__FILE__)))); // /var/www/froxlor, needed for chown

			$user = $this->settings['phpfpm']['vhost_httpuser'];
			$group = $this->settings['phpfpm']['vhost_httpgroup'];	

			$domain = array(
				'id' => 'none',
				'domain' => $this->settings['system']['hostname'],
				'adminid' => 1, /* first admin-user (superadmin) */
				'mod_fcgid_starter' => -1,
				'mod_fcgid_maxrequests' => -1,
				'guid' => $user,
				'openbasedir' => 0,
				'safemode' => '0',
				'email' => $this->settings['panel']['adminmail'],
				'loginname' => 'froxlor.panel',
				'documentroot' => $mypath
			);

			// all the files and folders have to belong to the local user
			// now because we also use fcgid for our own vhost
			safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($mypath));
						
			// get php.ini for our own vhost
			$php = new phpinterface($this->getDB(), $this->settings, $domain);

			// @FIXME don't use fcgid settings, but we don't have anything else atm
			$phpconfig = $php->getPhpConfig($this->settings['system']['mod_fcgid_defaultini_ownvhost']);

			// create starter-file | config-file
			$php->getInterface()->createConfig($phpconfig);
			
			// create php.ini 
			// @TODO make php-fpm support this
			$php->getInterface()->createIniFile($phpconfig);
		}
	}
}
