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

class apache
{
	private $db = false;
	private $logger = false;
	private $debugHandler = false;
	private $idnaConvert = false;

	//	protected

	protected $settings = array();
	protected $known_vhostfilenames = array();
	protected $known_diroptionsfilenames = array();
	protected $known_htpasswdsfilenames = array();
	protected $virtualhosts_data = array();
	protected $diroptions_data = array();
	protected $htpasswds_data = array();

	/**
	 * indicator whether a customer is deactivated or not
	 * if yes, only the webroot will be generated
	 *
	 * @var bool
	 */
	private $_deactivated = false;

	public function __construct($db, $logger, $debugHandler, $idnaConvert, $settings)
	{
		$this->db = $db;
		$this->logger = $logger;
		$this->debugHandler = $debugHandler;
		$this->idnaConvert = $idnaConvert;
		$this->settings = $settings;
	}

	protected function getDB()
	{
		return $this->db;
	}

	public function reload()
	{
		if((int)$this->settings['phpfpm']['enabled'] == 1)
		{
			fwrite($this->debugHandler, '   apache::reload: reloading php-fpm' . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading php-fpm');
			safe_exec(escapeshellcmd($this->settings['phpfpm']['reload']));
		}
		fwrite($this->debugHandler, '   apache::reload: reloading apache' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading apache');
		safe_exec(escapeshellcmd($this->settings['system']['apachereload_command']));
	}

	/**
	 * define a standard <Directory>-statement, bug #32
	 */
	private function _createStandardDirectoryEntry()
	{
		$vhosts_folder = '';
		if(is_dir($this->settings['system']['apacheconf_vhost']))
		{
			$vhosts_folder = makeCorrectDir($this->settings['system']['apacheconf_vhost']);
		} else {
			$vhosts_folder = makeCorrectDir(dirname($this->settings['system']['apacheconf_vhost']));
		}
		$vhosts_filename = makeCorrectFile($vhosts_folder . '/05_froxlor_dirfix_nofcgid.conf');

		if($this->settings['system']['mod_fcgid'] == '1'
			|| $this->settings['phpfpm']['enabled'] == '1'
		) {
			// if we use fcgid or php-fpm we don't need this file
			if(file_exists($vhosts_filename))
			{
				fwrite($this->debugHandler, '  apache::_createStandardDirectoryEntry: unlinking ' . basename($vhosts_filename) . "\n");
				$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'unlinking ' . basename($vhosts_filename));
				unlink(makeCorrectFile($vhosts_filename));
			}
		}
		else
		{
			if(!isset($this->virtualhosts_data[$vhosts_filename]))
			{
				$this->virtualhosts_data[$vhosts_filename] = '';
			}

			$this->virtualhosts_data[$vhosts_filename].= '  <Directory "' . makeCorrectDir($this->settings['system']['documentroot_prefix']) . '">' . "\n";
			// >=apache-2.4 enabled?
			if ($this->settings['system']['apache24'] == '1') {
				$this->virtualhosts_data[$vhosts_filename].= '    Require all granted' . "\n";
			} else {
				$this->virtualhosts_data[$vhosts_filename].= '    Order allow,deny' . "\n";
				$this->virtualhosts_data[$vhosts_filename].= '    allow from all' . "\n";
			}
			$this->virtualhosts_data[$vhosts_filename].= '  </Directory>' . "\n";
		}
	}

	/**
	 * define a default ErrorDocument-statement, bug #unknown-yet
	 */
	private function _createStandardErrorHandler()
	{
		if($this->settings['defaultwebsrverrhandler']['enabled'] == '1'
			&& ($this->settings['defaultwebsrverrhandler']['err401'] != ''
			|| $this->settings['defaultwebsrverrhandler']['err403'] != ''
			|| $this->settings['defaultwebsrverrhandler']['err404'] != ''
			|| $this->settings['defaultwebsrverrhandler']['err500'] != '')
		) {
			$vhosts_folder = '';
			if(is_dir($this->settings['system']['apacheconf_vhost']))
			{
				$vhosts_folder = makeCorrectDir($this->settings['system']['apacheconf_vhost']);
			} else {
				$vhosts_folder = makeCorrectDir(dirname($this->settings['system']['apacheconf_vhost']));
			}

			$vhosts_filename = makeCorrectFile($vhosts_folder . '/05_froxlor_default_errorhandler.conf');

			if(!isset($this->virtualhosts_data[$vhosts_filename]))
			{
				$this->virtualhosts_data[$vhosts_filename] = '';
			}

			if($this->settings['defaultwebsrverrhandler']['err401'] != '')
			{
				$this->virtualhosts_data[$vhosts_filename].= 'ErrorDocument 401 "' . makeCorrectFile($this->settings['defaultwebsrverrhandler']['err401']) . '"'."\n";
			}

			if($this->settings['defaultwebsrverrhandler']['err403'] != '')
			{
				$this->virtualhosts_data[$vhosts_filename].= 'ErrorDocument 403 "' . makeCorrectFile($this->settings['defaultwebsrverrhandler']['err403']) . '"' . "\n";
			}

			if($this->settings['defaultwebsrverrhandler']['err404'] != '')
			{
				$this->virtualhosts_data[$vhosts_filename].= 'ErrorDocument 404 "' . makeCorrectFile($this->settings['defaultwebsrverrhandler']['err404']) . '"' . "\n";
			}

			if($this->settings['defaultwebsrverrhandler']['err500'] != '')
			{
				$this->virtualhosts_data[$vhosts_filename].= 'ErrorDocument 500 "' . makeCorrectFile($this->settings['defaultwebsrverrhandler']['err500']) . '"' . "\n";
			}

		}
	}

	public function createIpPort()
	{
		$result_ipsandports = $this->db->query("SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `ip` ASC, `port` ASC");

		while($row_ipsandports = $this->db->fetch_array($result_ipsandports))
		{
			if(filter_var($row_ipsandports['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
			{
				$ipport = '[' . $row_ipsandports['ip'] . ']:' . $row_ipsandports['port'];
			}
			else
			{
				$ipport = $row_ipsandports['ip'] . ':' . $row_ipsandports['port'];
			}

			fwrite($this->debugHandler, '  apache::createIpPort: creating ip/port settings for  ' . $ipport . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'creating ip/port settings for  ' . $ipport);
			$vhosts_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/10_froxlor_ipandport_' . trim(str_replace(':', '.', $row_ipsandports['ip']), '.') . '.' . $row_ipsandports['port'] . '.conf');

			if(!isset($this->virtualhosts_data[$vhosts_filename]))
			{
				$this->virtualhosts_data[$vhosts_filename] = '';
			}

			if($row_ipsandports['listen_statement'] == '1')
			{
				$this->virtualhosts_data[$vhosts_filename].= 'Listen ' . $ipport . "\n";
				$this->logger->logAction(CRON_ACTION, LOG_DEBUG, $ipport . ' :: inserted listen-statement');
			}

			if($row_ipsandports['namevirtualhost_statement'] == '1')
			{
				// >=apache-2.4 enabled?
				if ($this->settings['system']['apache24'] == '1') {
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, $ipport . ' :: namevirtualhost-statement no longer needed for apache-2.4');
				} else {
					$this->virtualhosts_data[$vhosts_filename].= 'NameVirtualHost ' . $ipport . "\n";
					$this->logger->logAction(CRON_ACTION, LOG_DEBUG, $ipport . ' :: inserted namevirtualhost-statement');
				}
			}

			if($row_ipsandports['vhostcontainer'] == '1')
			{
				$this->virtualhosts_data[$vhosts_filename].= '<VirtualHost ' . $ipport . '>' . "\n";

				if($row_ipsandports['docroot'] == '')
				{
					/**
					 * add 'real'-vhost content here, like doc-root :)
					 */
					if($this->settings['system']['froxlordirectlyviahostname'])
					{
						$mypath = makeCorrectDir(dirname(dirname(dirname(__FILE__))));
					}
					else
					{
						$mypath = makeCorrectDir(dirname(dirname(dirname(dirname(__FILE__)))));
					}
				}
				else
				{
					// user-defined docroot, #417
					$mypath = makeCorrectDir($row_ipsandports['docroot']);
				}

				$this->virtualhosts_data[$vhosts_filename].= 'DocumentRoot "'.$mypath.'"'."\n";

				if($row_ipsandports['vhostcontainer_servername_statement'] == '1')
				{
					$this->virtualhosts_data[$vhosts_filename].= ' ServerName ' . $this->settings['system']['hostname'] . "\n";
				}

				// create fcgid <Directory>-Part (starter is created in apache_fcgid)
				if($this->settings['system']['mod_fcgid_ownvhost'] == '1'
					&& $this->settings['system']['mod_fcgid'] == '1'
				)
				{

					$configdir = makeCorrectDir($this->settings['system']['mod_fcgid_configdir'] . '/froxlor.panel/' . $this->settings['system']['hostname']);
					$this->virtualhosts_data[$vhosts_filename].= '  FcgidIdleTimeout ' . $this->settings['system']['mod_fcgid_idle_timeout'] . "\n";
					if((int)$this->settings['system']['mod_fcgid_wrapper'] == 0)
					{
						$this->virtualhosts_data[$vhosts_filename].= '  SuexecUserGroup "' . $this->settings['system']['mod_fcgid_httpuser'] . '" "' . $this->settings['system']['mod_fcgid_httpgroup'] . '"' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= '  ScriptAlias /php/ ' . $configdir . "\n";
					}
					else
					{
						$starter_filename = makeCorrectFile($configdir . '/php-fcgi-starter');
						$this->virtualhosts_data[$vhosts_filename].= '  SuexecUserGroup "' . $this->settings['system']['mod_fcgid_httpuser'] . '" "' . $this->settings['system']['mod_fcgid_httpgroup'] . '"' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= '  <Directory "' . $mypath . '">' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= '    AddHandler fcgid-script .php' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= '    FcgidWrapper ' . $starter_filename . ' .php' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= '    Options +ExecCGI' . "\n";
						// >=apache-2.4 enabled?
						if ($this->settings['system']['apache24'] == '1') {
							$this->virtualhosts_data[$vhosts_filename].= '    Require all granted' . "\n";
						} else {
							$this->virtualhosts_data[$vhosts_filename].= '    Order allow,deny' . "\n";
							$this->virtualhosts_data[$vhosts_filename].= '    allow from all' . "\n";
						}
						$this->virtualhosts_data[$vhosts_filename].= '  </Directory>' . "\n";
					}
				}
				// create php-fpm <Directory>-Part (config is created in apache_fcgid)
				elseif($this->settings['phpfpm']['enabled'] == '1')
				{
					$domain = array(
						'id' => 'none',
						'domain' => $this->settings['system']['hostname'],
						'adminid' => 1, /* first admin-user (superadmin) */
						'mod_fcgid_starter' => -1,
						'mod_fcgid_maxrequests' => -1,
						'guid' => $this->settings['phpfpm']['vhost_httpuser'],
						'openbasedir' => 0,
						'safemode' => '0',
						'email' => $this->settings['panel']['adminmail'],
						'loginname' => 'froxlor.panel',
						'documentroot' => $mypath,
					);

					$php = new phpinterface($this->getDB(), $this->settings, $domain);
					$this->virtualhosts_data[$vhosts_filename].= '  SuexecUserGroup "' . $this->settings['system']['mod_fcgid_httpuser'] . '" "' . $this->settings['system']['mod_fcgid_httpgroup'] . '"' . "\n";
					$srvName = 'fpm.external';
					if ($row_ipsandports['ssl']) {
						$srvName = 'ssl-fpm.external';
					}
					$this->virtualhosts_data[$vhosts_filename].= '  FastCgiExternalServer ' . $php->getInterface()->getAliasConfigDir() . $srvName .' -socket ' . $php->getInterface()->getSocketFile() . ' -user ' . $this->settings['system']['mod_fcgid_httpuser'] . ' -group ' . $this->settings['system']['mod_fcgid_httpuser'] . " -idle-timeout " . $this->settings['phpfpm']['idle_timeout'] . "\n";
					$this->virtualhosts_data[$vhosts_filename].= '  <Directory "' . $mypath . '">' . "\n";
					$this->virtualhosts_data[$vhosts_filename].= '    AddHandler php5-fastcgi .php'. "\n";
					$this->virtualhosts_data[$vhosts_filename].= '    Action php5-fastcgi /fastcgiphp' . "\n";
					$this->virtualhosts_data[$vhosts_filename].= '    Options +ExecCGI' . "\n";
					// >=apache-2.4 enabled?
					if ($this->settings['system']['apache24'] == '1') {
						$this->virtualhosts_data[$vhosts_filename].= '    Require all granted' . "\n";
					} else {
						$this->virtualhosts_data[$vhosts_filename].= '    Order allow,deny' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= '    allow from all' . "\n";
					}
					$this->virtualhosts_data[$vhosts_filename].= '  </Directory>' . "\n";
					$this->virtualhosts_data[$vhosts_filename].= '  Alias /fastcgiphp ' . $php->getInterface()->getAliasConfigDir() . $srvName . "\n";
				}

				/**
				 * dirprotection, see #72
				 * @TODO deferred until 0.9.5, needs more testing
				$this->virtualhosts_data[$vhosts_filename].= "\t<Directory \"'.$mypath.'(images|packages|templates)\">\n";
				$this->virtualhosts_data[$vhosts_filename].= "\t\tAllow from all\n";
				$this->virtualhosts_data[$vhosts_filename].= "\t\tOptions -Indexes\n";
				$this->virtualhosts_data[$vhosts_filename].= "\t</Directory>\n";

				$this->virtualhosts_data[$vhosts_filename].= "\t<Directory \"'.$mypath.'*\">\n";
				$this->virtualhosts_data[$vhosts_filename].= "\t\tOrder Deny,Allow\n";
				$this->virtualhosts_data[$vhosts_filename].= "\t\tDeny from All\n";
				$this->virtualhosts_data[$vhosts_filename].= "\t</Directory>\n";
				 * end of dirprotection
				 */

				if($row_ipsandports['specialsettings'] != '')
				{
					$this->virtualhosts_data[$vhosts_filename].= $row_ipsandports['specialsettings'] . "\n";
				}

				if($row_ipsandports['ssl'] == '1' && $this->settings['system']['use_ssl'] == '1')
				{
					if($row_ipsandports['ssl_cert_file'] == '')
					{
						$row_ipsandports['ssl_cert_file'] = $this->settings['system']['ssl_cert_file'];
					}

					if($row_ipsandports['ssl_key_file'] == '')
					{
						$row_ipsandports['ssl_key_file'] = $this->settings['system']['ssl_key_file'];
					}

					if($row_ipsandports['ssl_ca_file'] == '')
					{
						$row_ipsandports['ssl_ca_file'] = $this->settings['system']['ssl_ca_file'];
					}

					// #418
					if($row_ipsandports['ssl_cert_chainfile'] == '')
					{
						$row_ipsandports['ssl_cert_chainfile'] = $this->settings['system']['ssl_cert_chainfile'];
					}

					if($row_ipsandports['ssl_cert_file'] != '')
					{
						$this->virtualhosts_data[$vhosts_filename].= ' SSLEngine On' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= ' SSLCertificateFile ' . makeCorrectFile($row_ipsandports['ssl_cert_file']) . "\n";

						if($row_ipsandports['ssl_key_file'] != '')
						{
							$this->virtualhosts_data[$vhosts_filename].= ' SSLCertificateKeyFile ' . makeCorrectFile($row_ipsandports['ssl_key_file']) . "\n";
						}

						if($row_ipsandports['ssl_ca_file'] != '')
						{
							$this->virtualhosts_data[$vhosts_filename].= ' SSLCACertificateFile ' . makeCorrectFile($row_ipsandports['ssl_ca_file']) . "\n";
						}

						// #418
						if($row_ipsandports['ssl_cert_chainfile'] != '')
						{
							$this->virtualhosts_data[$vhosts_filename].= '  SSLCertificateChainFile ' . makeCorrectFile($row_ipsandports['ssl_cert_chainfile']) . "\n";
						}
					}
				}

				$this->virtualhosts_data[$vhosts_filename].= '</VirtualHost>' . "\n";
				$this->logger->logAction(CRON_ACTION, LOG_DEBUG, $ipport . ' :: inserted vhostcontainer');
			}
			unset($vhosts_filename);
		}

		/**
		 * bug #32
		 */
		$this->_createStandardDirectoryEntry();

		/**
		 * bug #unknown-yet
		 */
		$this->_createStandardErrorHandler();
	}

	/*
	*	We put together the needed php options in the virtualhost entries
	*/

	protected function composePhpOptions($domain, $ssl_vhost = false)
	{
		$php_options_text = '';

		if($domain['phpenabled'] == '1')
		{
			// This vHost has PHP enabled and we are using the regular mod_php

			if($domain['openbasedir'] == '1')
			{
				if($domain['openbasedir_path'] == '1' || strstr($domain['documentroot'], ":") !== false)
				{
					$_phpappendopenbasedir = appendOpenBasedirPath($domain['customerroot'], true);
				}
				else
				{
					$_phpappendopenbasedir = appendOpenBasedirPath($domain['documentroot'], true);
				}

				$_custom_openbasedir = explode(':', $this->settings['system']['phpappendopenbasedir']);
				foreach($_custom_openbasedir as $cobd)
				{
					$_phpappendopenbasedir .= appendOpenBasedirPath($cobd);
				}

				$php_options_text.= '  php_admin_value open_basedir "' . $_phpappendopenbasedir . '"'."\n";
			}

			if($domain['safemode'] == '0')
			{
				$php_options_text.= '  php_admin_flag safe_mode Off ' . "\n";
			}
			else
			{
				$php_options_text.= '  php_admin_flag safe_mode On ' . "\n";
			}
		}
		else
		{
			$php_options_text.= '  # PHP is disabled for this vHost' . "\n";
			$php_options_text.= '  php_flag engine off' . "\n";
		}

		return $php_options_text;
	}

	public function createOwnVhostStarter()
	{
	}

	/*
	*	We collect all servernames and Aliases
	*/

	protected function getServerNames($domain)
	{
		$servernames_text = '';
		$servernames_text.= '  ServerName ' . $domain['domain'] . "\n";

		if($domain['iswildcarddomain'] == '1')
		{
			$server_alias = '*.' . $domain['domain'];
		}
		else
		{
			if($domain['wwwserveralias'] == '1')
			{
				$server_alias = 'www.' . $domain['domain'];
			}
			else
			{
				$server_alias = '';
			}
		}

		if(trim($server_alias) != '')
		{
			$servernames_text.= '  ServerAlias ' . $server_alias . "\n";
		}

		$alias_domains = $this->db->query('SELECT `domain`, `iswildcarddomain`, `wwwserveralias` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `aliasdomain`=\'' . $domain['id'] . '\'');

		while(($alias_domain = $this->db->fetch_array($alias_domains)) !== false)
		{
			$server_alias = '  ServerAlias ' . $alias_domain['domain'];

			if($alias_domain['iswildcarddomain'] == '1')
			{
				$server_alias.= ' *.' . $alias_domain['domain'];
			}
			else
			{
				if($alias_domain['wwwserveralias'] == '1')
				{
					$server_alias.= ' www.' . $alias_domain['domain'];
				}
			}

			$servernames_text.= $server_alias . "\n";
		}

		$servernames_text.= '  ServerAdmin ' . $domain['email'] . "\n";
		return $servernames_text;
	}

	/*
	*	Let's get the webroot
	*/

	protected function getWebroot($domain)
	{
		$webroot_text = '';
		$domain['customerroot'] = makeCorrectDir($domain['customerroot']);
		$domain['documentroot'] = makeCorrectDir($domain['documentroot']);

		if($domain['deactivated'] == '1'
		   && $this->settings['system']['deactivateddocroot'] != '')
		{
			$webroot_text.= '  # Using docroot for deactivated users...' . "\n";
			$webroot_text.= '  DocumentRoot "' . makeCorrectDir($this->settings['system']['deactivateddocroot']) . "\"\n";
			$this->_deactivated = true;
		}
		else
		{
			$webroot_text.= '  DocumentRoot "' . $domain['documentroot'] . "\"\n";
			$this->_deactivated = false;
		}

		return $webroot_text;
	}

	/*
	*	Lets set the text part for the stats software
	*/

	protected function getStats($domain)
	{
		$stats_text = '';

		if($domain['speciallogfile'] == '1'
		   && $this->settings['system']['mod_log_sql'] != '1')
		{
			if($domain['parentdomainid'] == '0')
			{
				if($this->settings['system']['awstats_enabled'] == '1')
				{
					$stats_text.= '  Alias /awstats "' . makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['domain']) . '"' . "\n";
					$stats_text.= '  Alias /awstats-icon "' . makeCorrectDir($this->settings['system']['awstats_icons']) . '"' . "\n";
				}
				else
				{
					$stats_text.= '  Alias /webalizer "' . makeCorrectFile($domain['customerroot'] . '/webalizer/' . $domain['domain']) . '"' . "\n";
				}
			}
			else
			{
				if($this->settings['system']['awstats_enabled'] == '1')
				{
					$stats_text.= '  Alias /awstats "' . makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['parentdomain']) . '"' . "\n";
					$stats_text.= '  Alias /awstats-icon "' . makeCorrectDir($this->settings['system']['awstats_icons']) . '"' . "\n";
				}
				else
				{
					$stats_text.= '  Alias /webalizer "' . makeCorrectFile($domain['customerroot'] . '/webalizer/' . $domain['parentdomain']) . '"' . "\n";
				}
			}
		}
		else
		{
			if($domain['customerroot'] != $domain['documentroot'])
			{
				if($this->settings['system']['awstats_enabled'] == '1')
				{
					$stats_text.= '  Alias /awstats "' . makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['domain']) . '"' . "\n";
					$stats_text.= '  Alias /awstats-icon "' . makeCorrectDir($this->settings['system']['awstats_icons']) . '"' . "\n";
				}
				else
				{
					$stats_text.= '  Alias /webalizer "' . makeCorrectFile($domain['customerroot'] . '/webalizer') . '"' . "\n";
				}
			}
			// if the docroots are equal, we still have to set an alias for awstats
			// because the stats are in /awstats/[domain], not just /awstats/
			// also, the awstats-icons are someplace else too!
			// -> webalizer does not need this!
			elseif($this->settings['system']['awstats_enabled'] == '1')
			{
				$stats_text.= '  Alias /awstats "' . makeCorrectFile($domain['documentroot'] . '/awstats/' . $domain['domain']) . '"' . "\n";
				$stats_text.= '  Alias /awstats-icon "' . makeCorrectDir($this->settings['system']['awstats_icons']) . '"' . "\n";
			}
		}

		return $stats_text;
	}

	/*
	*	Lets set the logfiles
	*/

	protected function getLogfiles($domain)
	{
		$logfiles_text = '';

		if($domain['speciallogfile'] == '1'
		   && $this->settings['system']['mod_log_sql'] != '1')
		{
			if($domain['parentdomainid'] == '0')
			{
				$speciallogfile = '-' . $domain['domain'];
			}
			else
			{
				$speciallogfile = '-' . $domain['parentdomain'];
			}
		}
		else
		{
			$speciallogfile = '';
		}

		if($this->settings['system']['mod_log_sql'] == '1')
		{
			// We are using mod_log_sql (http://www.outoforder.cc/projects/apache/mod_log_sql/)
			// TODO: See how we are able emulate the error_log

			$logfiles_text.= '  LogSQLTransferLogTable access_log' . "\n";
		}
		else
		{
			// The normal access/error - logging is enabled
			$error_log = makeCorrectFile($this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-error.log');
			// Create the logfile if it does not exist (fixes #46)
			touch($error_log);
			chown($error_log, $this->settings['system']['httpuser']);
			chgrp($error_log, $this->settings['system']['httpgroup']);

			$access_log = makeCorrectFile($this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-access.log');
			// Create the logfile if it does not exist (fixes #46)
			touch($access_log);
			chown($access_log, $this->settings['system']['httpuser']);
			chgrp($access_log, $this->settings['system']['httpgroup']);

			$logfiles_text.= '  ErrorLog "' . $error_log . "\"\n";
			$logfiles_text.= '  CustomLog "' . $access_log .'" combined' . "\n";

		}

		if($this->settings['system']['awstats_enabled'] == '1')
		{
			if((int)$domain['parentdomainid'] == 0)
			{
				// prepare the aliases and subdomains for stats config files

				$server_alias = '';
				$alias_domains = $this->db->query('SELECT `domain`, `iswildcarddomain`, `wwwserveralias` FROM `' . TABLE_PANEL_DOMAINS . '`
												WHERE `aliasdomain`=\'' . $domain['id'] . '\'
												OR `parentdomainid` =\''. $domain['id']. '\'');

				while(($alias_domain = $this->db->fetch_array($alias_domains)) !== false)
				{
					$server_alias.= ' ' . $alias_domain['domain'] . ' ';

					if($alias_domain['iswildcarddomain'] == '1')
					{
						$server_alias.= '*.' . $alias_domain['domain'];
					}
					else
					{
						if($alias_domain['wwwserveralias'] == '1')
						{
							$server_alias.= 'www.' . $alias_domain['domain'];
						}
						else
						{
							$server_alias.= '';
						}
					}
				}

				if($domain['iswildcarddomain'] == '1')
				{
					$alias = '*.' . $domain['domain'];
				}
				else
				{
					if($domain['wwwserveralias'] == '1')
					{
						$alias = 'www.' . $domain['domain'];
					}
					else
					{
						$alias = '';
					}
				}

				// After inserting the AWStats information,
				// be sure to build the awstats conf file as well
				// and chown it using $awstats_params, #258
				// Bug 960 + Bug 970 : Use full $domain instead of custom $awstats_params as following classes depend on the informations
				createAWStatsConf($this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-access.log', $domain['domain'], $alias . $server_alias, $domain['customerroot'], $domain);
			}
		}

		return $logfiles_text;
	}

	/*
	*	Get the filename for the virtualhost
	*/

	protected function getVhostFilename($domain, $ssl_vhost = false)
	{
		if((int)$domain['parentdomainid'] == 0
			&& isCustomerStdSubdomain((int)$domain['id']) == false
			&& ((int)$domain['ismainbutsubto'] == 0
			|| domainMainToSubExists($domain['ismainbutsubto']) == false)
		) {
			$vhost_no = '22';
		}
		elseif((int)$domain['parentdomainid'] == 0
			&& isCustomerStdSubdomain((int)$domain['id']) == false
			&& (int)$domain['ismainbutsubto'] > 0
		) {
			$vhost_no = '21';
		}
		else
		{
			$vhost_no = '20';
		}

		if($ssl_vhost === true)
		{
			$vhost_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/'.$vhost_no.'_froxlor_ssl_vhost_' . $domain['domain'] . '.conf');
		}
		else
		{
			$vhost_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/'.$vhost_no.'_froxlor_normal_vhost_' . $domain['domain'] . '.conf');
		}

		return $vhost_filename;
	}

	/*
	*	We compose the virtualhost entry for one domain
	*/

	protected function getVhostContent($domain, $ssl_vhost = false)
	{
		if($ssl_vhost === true
		   && $domain['ssl'] != '1')
		{
			return '';
		}

		if($ssl_vhost === true
		   && $domain['ssl'] == '1')
		{
			$query = "SELECT * FROM " . TABLE_PANEL_IPSANDPORTS . " WHERE `id`='" . $domain['ssl_ipandport'] . "'";
		}
		else
		{
			$query = "SELECT * FROM " . TABLE_PANEL_IPSANDPORTS . " WHERE `id`='" . $domain['ipandport'] . "'";
		}

		$ipandport = $this->db->query_first($query);
		$domain['ip'] = $ipandport['ip'];
		$domain['port'] = $ipandport['port'];
		$domain['ssl_cert_file'] = $ipandport['ssl_cert_file'];
		$domain['ssl_key_file'] = $ipandport['ssl_key_file'];
		$domain['ssl_ca_file'] = $ipandport['ssl_ca_file'];
		// #418
		$domain['ssl_cert_chainfile'] = $ipandport['ssl_cert_chainfile'];

		if(filter_var($domain['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
		{
			$ipport = '[' . $domain['ip'] . ']:' . $domain['port'];
		}
		else
		{
			$ipport = $domain['ip'] . ':' . $domain['port'];
		}

		$vhost_content = '<VirtualHost ' . $ipport . '>' . "\n";
		$vhost_content.= $this->getServerNames($domain);

		if($ssl_vhost == false
		   && $domain['ssl'] == '1'
		   && $domain['ssl_redirect'] == '1')
		{
			$domain['documentroot'] = 'https://' . $domain['domain'] . '/';
		}
		
		if($ssl_vhost === true
		   && $domain['ssl'] == '1'
		   && $this->settings['system']['use_ssl'] == '1')
		{
			if($domain['ssl_cert_file'] == '')
			{
				$domain['ssl_cert_file'] = $this->settings['system']['ssl_cert_file'];
			}

			if($domain['ssl_key_file'] == '')
			{
				$domain['ssl_key_file'] = $this->settings['system']['ssl_key_file'];
			}

			if($domain['ssl_ca_file'] == '')
			{
				$domain['ssl_ca_file'] = $this->settings['system']['ssl_ca_file'];
			}

			// #418
			if($domain['ssl_cert_chainfile'] == '')
			{
				$domain['ssl_cert_chainfile'] = $this->settings['system']['ssl_cert_chainfile'];
			}

			if($domain['ssl_cert_file'] != '')
			{
				$vhost_content.= '  SSLEngine On' . "\n";
				$vhost_content.= '  SSLCertificateFile ' . makeCorrectFile($domain['ssl_cert_file']) . "\n";

				if($domain['ssl_key_file'] != '')
				{
					$vhost_content.= '  SSLCertificateKeyFile ' . makeCorrectFile($domain['ssl_key_file']) . "\n";
				}

				if($domain['ssl_ca_file'] != '')
				{
					$vhost_content.= '  SSLCACertificateFile ' . makeCorrectFile($domain['ssl_ca_file']) . "\n";
				}

				// #418
				if($domain['ssl_cert_chainfile'] != '')
				{
					$vhost_content.= '  SSLCertificateChainFile ' . makeCorrectFile($domain['ssl_cert_chainfile']) . "\n";
				}
			}
		}

		if(preg_match('/^https?\:\/\//', $domain['documentroot']))
		{
			$corrected_docroot = $this->idnaConvert->encode($domain['documentroot']);
			if(substr($corrected_docroot, -1) == '/') {
				$corrected_docroot = substr($corrected_docroot, 0, -1);
			}

			/* Get domain's redirect code */
			$code = getDomainRedirectCode($domain['id']);
			$modrew_red = '';
			if ($code != '') {
				$modrew_red = '[R='. $code . ';L]';
			}

			// redirect everything, not only root-directory, #541
			$vhost_content.= '  <IfModule mod_rewrite.c>'."\n";
			$vhost_content.= '    RewriteEngine On' . "\n";
			$vhost_content.= '    RewriteCond %{HTTPS} off' . "\n";
			$vhost_content.= '    RewriteRule (.*) '. $corrected_docroot.'%{REQUEST_URI} ' . $modrew_red . "\n";
			$vhost_content.= '  </IfModule>' . "\n";

			$code = getDomainRedirectCode($domain['id']);
			$vhost_content.= '  Redirect '.$code.' / ' . $this->idnaConvert->encode($domain['documentroot']) . "\n";
		}
		else
		{
			mkDirWithCorrectOwnership($domain['customerroot'], $domain['documentroot'], $domain['guid'], $domain['guid'], true, true);
			$vhost_content.= $this->getWebroot($domain);
			if ($this->_deactivated == false) {
				$vhost_content.= $this->composePhpOptions($domain,$ssl_vhost);
				$vhost_content.= $this->getStats($domain);
			}
			$vhost_content.= $this->getLogfiles($domain);
		}

		if($domain['specialsettings'] != '')
		{
			$vhost_content.= $domain['specialsettings'] . "\n";
		}

		if($ipandport['default_vhostconf_domain'] != '')
		{
			$vhost_content.= $ipandport['default_vhostconf_domain'] . "\n";
		}

		if($this->settings['system']['default_vhostconf'] != '')
		{
			$vhost_content.= $this->settings['system']['default_vhostconf'] . "\n";
		}

		$vhost_content.= '</VirtualHost>' . "\n";
		return $vhost_content;
	}

	/*
	*	We compose the virtualhost entries for the domains
	*/

	public function createVirtualHosts()
	{
		$result_domains = $this->db->query("SELECT `d`.*, `pd`.`domain` AS `parentdomain`, `c`.`loginname`, `d`.`phpsettingid`, `c`.`adminid`, `c`.`guid`, `c`.`email`, `c`.`documentroot` AS `customerroot`, `c`.`deactivated`, `c`.`phpenabled` AS `phpenabled`, `d`.`mod_fcgid_starter`, `d`.`mod_fcgid_maxrequests` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`) " . "LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `pd` ON (`pd`.`id` = `d`.`parentdomainid`) " . "WHERE `d`.`aliasdomain` IS NULL AND `d`.`email_only` <> 1 ORDER BY `d`.`parentdomainid` DESC, `d`.`iswildcarddomain`, `d`.`domain` ASC");

		while($domain = $this->db->fetch_array($result_domains))
		{
			fwrite($this->debugHandler, '  apache::createVirtualHosts: creating vhost container for domain ' . $domain['id'] . ', customer ' . $domain['loginname'] . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'creating vhost container for domain ' . $domain['id'] . ', customer ' . $domain['loginname']);
			$vhosts_filename = $this->getVhostFilename($domain);

			// Apply header

			$this->virtualhosts_data[$vhosts_filename] = '# Domain ID: ' . $domain['id'] . ' - CustomerID: ' . $domain['customerid'] . ' - CustomerLogin: ' . $domain['loginname'] . "\n";

			if($domain['deactivated'] != '1'
			   || $this->settings['system']['deactivateddocroot'] != '')
			{
				$this->virtualhosts_data[$vhosts_filename].= $this->getVhostContent($domain);

				if($domain['ssl'] == '1')
				{
					// Adding ssl stuff if enabled

					$vhosts_filename_ssl = $this->getVhostFilename($domain, true);
					$this->virtualhosts_data[$vhosts_filename_ssl] = '# Domain ID: ' . $domain['id'] . ' (SSL) - CustomerID: ' . $domain['customerid'] . ' - CustomerLogin: ' . $domain['loginname'] . "\n";
					$this->virtualhosts_data[$vhosts_filename_ssl].= $this->getVhostContent($domain, true);
				}
			}
			else
			{
				$this->virtualhosts_data[$vhosts_filename].= '# Customer deactivated and a docroot for deactivated users hasn\'t been set.' . "\n";
			}
		}
	}

	/*
	*	We compose the diroption entries for the paths
	*/

	public function createFileDirOptions()
	{
		$result = $this->db->query('SELECT `htac`.*, `c`.`guid`, `c`.`documentroot` AS `customerroot` FROM `' . TABLE_PANEL_HTACCESS . '` `htac` LEFT JOIN `' . TABLE_PANEL_CUSTOMERS . '` `c` USING (`customerid`) ORDER BY `htac`.`path`');
		$diroptions = array();

		while($row_diroptions = $this->db->fetch_array($result))
		{
			if($row_diroptions['customerid'] != 0
			   && isset($row_diroptions['customerroot'])
			   && $row_diroptions['customerroot'] != '')
			{
				$diroptions[$row_diroptions['path']] = $row_diroptions;
				$diroptions[$row_diroptions['path']]['htpasswds'] = array();
			}
		}

		$result = $this->db->query('SELECT `htpw`.*, `c`.`guid`, `c`.`documentroot` AS `customerroot` FROM `' . TABLE_PANEL_HTPASSWDS . '` `htpw` LEFT JOIN `' . TABLE_PANEL_CUSTOMERS . '` `c` USING (`customerid`) ORDER BY `htpw`.`path`, `htpw`.`username`');

		while($row_htpasswds = $this->db->fetch_array($result))
		{
			if($row_htpasswds['customerid'] != 0
			   && isset($row_htpasswds['customerroot'])
			   && $row_htpasswds['customerroot'] != '')
			{
				if(!isset($diroptions[$row_htpasswds['path']]) || !is_array($diroptions[$row_htpasswds['path']]))
				{
					$diroptions[$row_htpasswds['path']] = array();
				}

				$diroptions[$row_htpasswds['path']]['path'] = $row_htpasswds['path'];
				$diroptions[$row_htpasswds['path']]['guid'] = $row_htpasswds['guid'];
				$diroptions[$row_htpasswds['path']]['customerroot'] = $row_htpasswds['customerroot'];
				$diroptions[$row_htpasswds['path']]['customerid'] = $row_htpasswds['customerid'];
				$diroptions[$row_htpasswds['path']]['htpasswds'][] = $row_htpasswds;
			}
		}

		foreach($diroptions as $row_diroptions)
		{
			$row_diroptions['path'] = makeCorrectDir($row_diroptions['path']);
			mkDirWithCorrectOwnership($row_diroptions['customerroot'], $row_diroptions['path'], $row_diroptions['guid'], $row_diroptions['guid']);
			$diroptions_filename = makeCorrectFile($this->settings['system']['apacheconf_diroptions'] . '/40_froxlor_diroption_' . md5($row_diroptions['path']) . '.conf');

			if(!isset($this->diroptions_data[$diroptions_filename]))
			{
				$this->diroptions_data[$diroptions_filename] = '';
			}

			if(is_dir($row_diroptions['path']))
			{
				$cperlenabled = customerHasPerlEnabled($row_diroptions['customerid']);

				$this->diroptions_data[$diroptions_filename].= '<Directory "' . $row_diroptions['path'] . '">' . "\n";

				if(isset($row_diroptions['options_indexes'])
				   && $row_diroptions['options_indexes'] == '1')
				{
					$this->diroptions_data[$diroptions_filename].= '  Options +Indexes';

					// add perl options if enabled
					if($cperlenabled
						&& isset($row_diroptions['options_cgi'])
						&& $row_diroptions['options_cgi'] == '1')
					{
						$this->diroptions_data[$diroptions_filename].= ' ExecCGI -MultiViews +SymLinksIfOwnerMatch +FollowSymLinks'."\n";
					} else {
						$this->diroptions_data[$diroptions_filename].= "\n";
					}
					fwrite($this->debugHandler, '  cron_tasks: Task3 - Setting Options +Indexes' . "\n");
				}

				if(isset($row_diroptions['options_indexes'])
				   && $row_diroptions['options_indexes'] == '0')
				{
					$this->diroptions_data[$diroptions_filename].= '  Options -Indexes';

					// add perl options if enabled
					if($cperlenabled
						&& isset($row_diroptions['options_cgi'])
						&& $row_diroptions['options_cgi'] == '1')
					{
						$this->diroptions_data[$diroptions_filename].= ' ExecCGI -MultiViews +SymLinksIfOwnerMatch +FollowSymLinks'."\n";
					} else {
						$this->diroptions_data[$diroptions_filename].= "\n";
					}
					fwrite($this->debugHandler, '  cron_tasks: Task3 - Setting Options -Indexes' . "\n");
				}

				if(isset($row_diroptions['error404path'])
				   && $row_diroptions['error404path'] != '')
				{
					$this->diroptions_data[$diroptions_filename].= '  ErrorDocument 404 "' . makeCorrectFile($row_diroptions['error404path']) . '"' . "\n";
				}

				if(isset($row_diroptions['error403path'])
				   && $row_diroptions['error403path'] != '')
				{
					$this->diroptions_data[$diroptions_filename].= '  ErrorDocument 403 "' . makeCorrectFile($row_diroptions['error403path']) . '"' . "\n";
				}

				if(isset($row_diroptions['error500path'])
				   && $row_diroptions['error500path'] != '')
				{
					$this->diroptions_data[$diroptions_filename].= '  ErrorDocument 500 "' . makeCorrectFile($row_diroptions['error500path']) . '"' . "\n";
				}

				if($cperlenabled
					&& isset($row_diroptions['options_cgi'])
					&& $row_diroptions['options_cgi'] == '1')
				{
					$this->diroptions_data[$diroptions_filename].= '  AllowOverride None' . "\n";
					$this->diroptions_data[$diroptions_filename].= '  AddHandler cgi-script .cgi .pl' . "\n";
					// >=apache-2.4 enabled?
					if ($this->settings['system']['apache24'] == '1') {
						$this->diroptions_data[$diroptions_filename].= '  Require all granted' . "\n";
					} else {
						$this->diroptions_data[$diroptions_filename].= '  Order allow,deny' . "\n";
						$this->diroptions_data[$diroptions_filename].= '  Allow from all' . "\n";
					}
					fwrite($this->debugHandler, '  cron_tasks: Task3 - Enabling perl execution' . "\n");

					// check for suexec-workaround, #319
					if((int)$this->settings['perl']['suexecworkaround'] == 1)
					{
						// symlink this directory to suexec-safe-path
						$loginname = getCustomerDetail($row_diroptions['customerid'], 'loginname');
						$suexecpath = makeCorrectDir($this->settings['perl']['suexecpath'].'/'.$loginname.'/'.md5($row_diroptions['path']).'/');

						if(!file_exists($suexecpath))
						{
							safe_exec('mkdir -p '.escapeshellarg($suexecpath));
							safe_exec('chown -R '.escapeshellarg($row_diroptions['guid']).':'.escapeshellarg($row_diroptions['guid']).' '.escapeshellarg($suexecpath));
						}

						// symlink to {$givenpath}/cgi-bin
						// NOTE: symlinks are FILES, so do not append a / here
						$perlsymlink = makeCorrectFile($row_diroptions['path'].'/cgi-bin');
						if(!file_exists($perlsymlink))
						{
							safe_exec('ln -s '.escapeshellarg($suexecpath).' '.escapeshellarg($perlsymlink));
						}
						safe_exec('chown '.escapeshellarg($row_diroptions['guid']).':'.escapeshellarg($row_diroptions['guid']).' '.escapeshellarg($perlsymlink));
					}
				}
				else
				{
					// if no perl-execution is enabled but the workaround is,
					// we have to remove the symlink and folder in suexecpath
					if((int)$this->settings['perl']['suexecworkaround'] == 1)
					{
						$loginname = getCustomerDetail($row_diroptions['customerid'], 'loginname');
						$suexecpath = makeCorrectDir($this->settings['perl']['suexecpath'].'/'.$loginname.'/'.md5($row_diroptions['path']).'/');
						$perlsymlink = makeCorrectFile($row_diroptions['path'].'/cgi-bin');

						// remove symlink
						if(file_exists($perlsymlink))
						{
							safe_exec('rm -f '.escapeshellarg($perlsymlink));
						}
						// remove folder in suexec-path
						if(file_exists($suexecpath))
						{
							safe_exec('rm -rf '.escapeshellarg($suexecpath));
						}
					}
				}

				if(count($row_diroptions['htpasswds']) > 0)
				{
					$htpasswd_filename = makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $row_diroptions['customerid'] . '-' . md5($row_diroptions['path']) . '.htpasswd');

					if(!isset($this->htpasswds_data[$htpasswd_filename]))
					{
						$this->htpasswds_data[$htpasswd_filename] = '';
					}

					foreach($row_diroptions['htpasswds'] as $row_htpasswd)
					{
						$this->htpasswds_data[$htpasswd_filename].= $row_htpasswd['username'] . ':' . $row_htpasswd['password'] . "\n";
					}

					$this->diroptions_data[$diroptions_filename].= '  AuthType Basic' . "\n";
					$this->diroptions_data[$diroptions_filename].= '  AuthName "'.$row_htpasswd['authname'].'"' . "\n";
					$this->diroptions_data[$diroptions_filename].= '  AuthUserFile ' . $htpasswd_filename . "\n";
					$this->diroptions_data[$diroptions_filename].= '  require valid-user' . "\n";
				}

				$this->diroptions_data[$diroptions_filename].= '</Directory>' . "\n";
			}
		}
	}

	/*
	*	We write the configs
	*/

	public function writeConfigs()
	{
		// Write diroptions

		fwrite($this->debugHandler, '  apache::writeConfigs: rebuilding ' . $this->settings['system']['apacheconf_diroptions'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "rebuilding " . $this->settings['system']['apacheconf_diroptions']);

		if(count($this->diroptions_data) > 0)
		{
			if(!isConfigDir($this->settings['system']['apacheconf_diroptions']))
			{
				// Save one big file

				$diroptions_file = '';

				foreach($this->diroptions_data as $diroptions_filename => $diroptions_content)
				{
					$diroptions_file.= $diroptions_content . "\n\n";
				}

				$diroptions_filename = $this->settings['system']['apacheconf_diroptions'];

				// Apply header

				$diroptions_file = '# ' . basename($diroptions_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $diroptions_file;
				$diroptions_file_handler = fopen($diroptions_filename, 'w');
				fwrite($diroptions_file_handler, $diroptions_file);
				fclose($diroptions_file_handler);
			}
			else
			{
				if(!file_exists($this->settings['system']['apacheconf_diroptions']))
				{
					fwrite($this->debugHandler, '  apache::writeConfigs: mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_diroptions'])) . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_diroptions'])));
					safe_exec('mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_diroptions'])));
				}

				// Write a single file for every diroption

				foreach($this->diroptions_data as $diroptions_filename => $diroptions_file)
				{
					$this->known_diroptionsfilenames[] = basename($diroptions_filename);

					// Apply header

					$diroptions_file = '# ' . basename($diroptions_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $diroptions_file;
					$diroptions_file_handler = fopen($diroptions_filename, 'w');
					fwrite($diroptions_file_handler, $diroptions_file);
					fclose($diroptions_file_handler);
				}

				$this->wipeOutOldDiroptionConfigs();
			}
		}
		else
		{
			// no more diroptions, but there might be some file-corpses which have to be removed
			$this->wipeOutOldDiroptionConfigs();
		}

		// Write htpasswds

		fwrite($this->debugHandler, '  apache::writeConfigs: rebuilding ' . $this->settings['system']['apacheconf_htpasswddir'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "rebuilding " . $this->settings['system']['apacheconf_htpasswddir']);

		if(count($this->htpasswds_data) > 0)
		{
			if(!file_exists($this->settings['system']['apacheconf_htpasswddir']))
			{
				$umask = umask();
				umask(0000);
				mkdir($this->settings['system']['apacheconf_htpasswddir'], 0751);
				umask($umask);
			}

			if(isConfigDir($this->settings['system']['apacheconf_htpasswddir'], true))
			{
				foreach($this->htpasswds_data as $htpasswd_filename => $htpasswd_file)
				{
					$this->known_htpasswdsfilenames[] = basename($htpasswd_filename);
					$htpasswd_file_handler = fopen($htpasswd_filename, 'w');
					fwrite($htpasswd_file_handler, $htpasswd_file);
					fclose($htpasswd_file_handler);
				}

				$this->wipeOutOldHtpasswdConfigs();
			}
			else
			{
				fwrite($this->debugHandler, '  cron_tasks: WARNING!!! ' . $this->settings['system']['apacheconf_htpasswddir'] . ' is not a directory. htpasswd directory protection is disabled!!!' . "\n");
				echo 'WARNING!!! ' . $this->settings['system']['apacheconf_htpasswddir'] . ' is not a directory. htpasswd directory protection is disabled!!!';
				$this->logger->logAction(CRON_ACTION, LOG_WARNING, 'WARNING!!! ' . $this->settings['system']['apacheconf_htpasswddir'] . ' is not a directory. htpasswd directory protection is disabled!!!');
			}
		}
		else
		{
			// no more htpasswds, but there might be some file-corpses which have to be removed
			$this->wipeOutOldHtpasswdConfigs();
		}

		// Write virtualhosts

		fwrite($this->debugHandler, '  apache::writeConfigs: rebuilding ' . $this->settings['system']['apacheconf_vhost'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "rebuilding " . $this->settings['system']['apacheconf_vhost']);

		if(count($this->virtualhosts_data) > 0)
		{
			if(!isConfigDir($this->settings['system']['apacheconf_vhost']))
			{
				// Save one big file
				$vhosts_file = '';

				// sort by filename so the order is:
				// 1. subdomains                  20
				// 2. subdomains as main-domains  21
				// 3. main-domains                22
				// #437
				ksort($this->virtualhosts_data);

				foreach($this->virtualhosts_data as $vhosts_filename => $vhost_content)
				{
					$vhosts_file.= $vhost_content . "\n\n";
				}

				// Include diroptions file in case it exists

				if(file_exists($this->settings['system']['apacheconf_diroptions']))
				{
					$vhosts_file.= "\n" . 'Include ' . $this->settings['system']['apacheconf_diroptions'] . "\n\n";
				}

				$vhosts_filename = $this->settings['system']['apacheconf_vhost'];

				// Apply header

				$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;
				$vhosts_file_handler = fopen($vhosts_filename, 'w');
				fwrite($vhosts_file_handler, $vhosts_file);
				fclose($vhosts_file_handler);
			}
			else
			{
				if(!file_exists($this->settings['system']['apacheconf_vhost']))
				{
					fwrite($this->debugHandler, '  apache::writeConfigs: mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])) . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])));
					safe_exec('mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])));
				}

				// Write a single file for every vhost

				foreach($this->virtualhosts_data as $vhosts_filename => $vhosts_file)
				{
					$this->known_vhostfilenames[] = basename($vhosts_filename);

					// Apply header

					$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;
					$vhosts_file_handler = fopen($vhosts_filename, 'w');
					fwrite($vhosts_file_handler, $vhosts_file);
					fclose($vhosts_file_handler);
				}

				$this->wipeOutOldVhostConfigs();
			}
		}
	}

	/*
	*	We remove old vhost config files
	*/

	protected function wipeOutOldVhostConfigs()
	{
		fwrite($this->debugHandler, '  apache::wipeOutOldVhostConfigs: cleaning ' . $this->settings['system']['apacheconf_vhost'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "cleaning " . $this->settings['system']['apacheconf_vhost']);

		if(isConfigDir($this->settings['system']['apacheconf_vhost'], true))
		{
			$vhost_file_dirhandle = opendir($this->settings['system']['apacheconf_vhost']);

			while(false !== ($vhost_filename = readdir($vhost_file_dirhandle)))
			{
				if($vhost_filename != '.'
				   && $vhost_filename != '..'
				   && !in_array($vhost_filename, $this->known_vhostfilenames)
				   && preg_match('/^(05|10|20|21|22|30|50|51)_(froxlor|syscp)_(dirfix|ipandport|normal_vhost|wildcard_vhost|ssl_vhost)_(.+)\.conf$/', $vhost_filename)
				   && file_exists(makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/' . $vhost_filename)))
				{
					fwrite($this->debugHandler, '  apache::wipeOutOldVhostConfigs: unlinking ' . $vhost_filename . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'unlinking ' . $vhost_filename);
					unlink(makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/' . $vhost_filename));
				}
			}
		}
	}

	/*
	*	We remove old diroptions config files
	*/

	protected function wipeOutOldDiroptionConfigs()
	{
		fwrite($this->debugHandler, '  apache::wipeOutOldDiroptionConfigs: cleaning ' . $this->settings['system']['apacheconf_diroptions'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "cleaning " . $this->settings['system']['apacheconf_diroptions']);

		if(isConfigDir($this->settings['system']['apacheconf_diroptions'], true))
		{
			$diroptions_file_dirhandle = opendir($this->settings['system']['apacheconf_diroptions']);

			while(false !== ($diroptions_filename = readdir($diroptions_file_dirhandle)))
			{
				if($diroptions_filename != '.'
				   && $diroptions_filename != '..'
				   && !in_array($diroptions_filename, $this->known_diroptionsfilenames)
				   && preg_match('/^40_(froxlor|syscp)_diroption_(.+)\.conf$/', $diroptions_filename)
				   && file_exists(makeCorrectFile($this->settings['system']['apacheconf_diroptions'] . '/' . $diroptions_filename)))
				{
					fwrite($this->debugHandler, '  apache::wipeOutOldDiroptionConfigs: unlinking ' . $diroptions_filename . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'unlinking ' . $diroptions_filename);
					unlink(makeCorrectFile($this->settings['system']['apacheconf_diroptions'] . '/' . $diroptions_filename));
				}
			}
		}
	}

	/*
	*	We remove old htpasswd config files
	*/

	protected function wipeOutOldHtpasswdConfigs()
	{
		fwrite($this->debugHandler, '  apache::wipeOutOldHtpasswdConfigs: cleaning ' . $this->settings['system']['apacheconf_htpasswddir'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "cleaning " . $this->settings['system']['apacheconf_htpasswddir']);

		if(isConfigDir($this->settings['system']['apacheconf_htpasswddir'], true))
		{
			$htpasswds_file_dirhandle = opendir($this->settings['system']['apacheconf_htpasswddir']);

			while(false !== ($htpasswd_filename = readdir($htpasswds_file_dirhandle)))
			{
				if($htpasswd_filename != '.'
				   && $htpasswd_filename != '..'
				   && !in_array($htpasswd_filename, $this->known_htpasswdsfilenames)
				   && file_exists(makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $htpasswd_filename)))
				{
					fwrite($this->debugHandler, '  apache::wipeOutOldHtpasswdConfigs: unlinking ' . $htpasswd_filename . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'unlinking ' . $htpasswd_filename);
					unlink(makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $htpasswd_filename));
				}
			}
		}
	}
}
