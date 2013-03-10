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
 *
 */

if(@php_sapi_name() != 'cli'
   && @php_sapi_name() != 'cgi'
   && @php_sapi_name() != 'cgi-fcgi')
{
	die('This script only works in the shell.');
}

class apache_fcgid extends apache
{
	protected function composePhpOptions($domain, $ssl_vhost = false)
	{
		$php_options_text = '';

		if($domain['phpenabled'] == '1')
		{
			$php = new phpinterface($this->getDB(), $this->settings, $domain);
			$phpconfig = $php->getPhpConfig((int)$domain['phpsettingid']);

			if((int)$this->settings['phpfpm']['enabled'] == 1)
			{
				$php_options_text.= '  SuexecUserGroup "' . $domain['loginname'] . '" "' . $domain['loginname'] . '"' . "\n";
				$srvName = 'fpm.external';
				if ($domain['ssl'] == 1 && $ssl_vhost) {
					$srvName = 'ssl-fpm.external';
				}
				$php_options_text.= '  FastCgiExternalServer ' . $php->getInterface()->getAliasConfigDir() . $srvName . ' -socket ' . $php->getInterface()->getSocketFile() . ' -user ' . $domain['loginname'] . ' -group ' . $domain['loginname'] . " -idle-timeout " . $this->settings['phpfpm']['idle_timeout'] . "\n";
				$php_options_text.= '  <Directory "' . makeCorrectDir($domain['documentroot']) . '">' . "\n";
				$php_options_text.= '    <FilesMatch "\.php$">' . "\n";
				$php_options_text.= '      SetHandler php5-fastcgi'. "\n";
				$php_options_text.= '      Action php5-fastcgi /fastcgiphp' . "\n";
				$php_options_text.= '      Options +ExecCGI' . "\n";
				$php_options_text.= '    </FilesMatch>' . "\n";
				// >=apache-2.4 enabled?
				if ($this->settings['system']['apache24'] == '1') {
					$php_options_text.= '    Require all granted' . "\n";
				} else {
					$php_options_text.= '    Order allow,deny' . "\n";
					$php_options_text.= '    allow from all' . "\n";
				}
				$php_options_text.= '  </Directory>' . "\n";
				$php_options_text.= '  Alias /fastcgiphp ' . $php->getInterface()->getAliasConfigDir() . $srvName . "\n";
			}
			else
			{
				$php_options_text.= '  FcgidIdleTimeout ' . $this->settings['system']['mod_fcgid_idle_timeout'] . "\n";
				if((int)$this->settings['system']['mod_fcgid_wrapper'] == 0)
				{
					$php_options_text.= '  SuexecUserGroup "' . $domain['loginname'] . '" "' . $domain['loginname'] . '"' . "\n";
					$php_options_text.= '  ScriptAlias /php/ ' . $php->getInterface()->getConfigDir() . "\n";
				}
				else
				{
					$php_options_text.= '  SuexecUserGroup "' . $domain['loginname'] . '" "' . $domain['loginname'] . '"' . "\n";
					$php_options_text.= '  <Directory "' . makeCorrectDir($domain['documentroot']) . '">' . "\n";
					$file_extensions = explode(' ', $phpconfig['file_extensions']);
					$php_options_text.= '    <FilesMatch "\.(' . implode('|', $file_extensions) . ')$">' . "\n";
					$php_options_text.= '      SetHandler fcgid-script' . "\n";
					foreach($file_extensions as $file_extension)
					{
						$php_options_text.= '      FcgidWrapper ' . $php->getInterface()->getStarterFile() . ' .' . $file_extension . "\n";
					}
					$php_options_text.= '      Options +ExecCGI' . "\n";
					$php_options_text.= '    </FilesMatch>' . "\n";
					// >=apache-2.4 enabled?
					if ($this->settings['system']['apache24'] == '1') {
						$php_options_text.= '    Require all granted' . "\n";
					} else {
						$php_options_text.= '    Order allow,deny' . "\n";
						$php_options_text.= '    allow from all' . "\n";
					}
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
		if ($this->settings['system']['mod_fcgid_ownvhost'] == '1'
			|| ($this->settings['phpfpm']['enabled'] == '1'
				&& $this->settings['phpfpm']['enabled_ownvhost'] == '1')
		) {
			$mypath = makeCorrectDir(dirname(dirname(dirname(__FILE__)))); // /var/www/froxlor, needed for chown

			if ($this->settings['system']['mod_fcgid_ownvhost'] == '1')
			{
				$user = $this->settings['system']['mod_fcgid_httpuser'];
				$group = $this->settings['system']['mod_fcgid_httpgroup'];
			}
			elseif($this->settings['phpfpm']['enabled'] == '1'
				&& $this->settings['phpfpm']['enabled_ownvhost'] == '1'
			) {
				$user = $this->settings['phpfpm']['vhost_httpuser'];
				$group = $this->settings['phpfpm']['vhost_httpgroup'];
			}

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

			// @FIXME don't use fcgid settings if not fcgid in use, but we don't have anything else atm
			$phpconfig = $php->getPhpConfig($this->settings['system']['mod_fcgid_defaultini_ownvhost']);

			// create starter-file | config-file
			$php->getInterface()->createConfig($phpconfig);

			// create php.ini
			// @TODO make php-fpm support this
			$php->getInterface()->createIniFile($phpconfig);
		}
	}
}
