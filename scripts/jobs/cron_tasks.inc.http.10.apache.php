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
		fwrite($this->debugHandler, '   apache::reload: reloading apache' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading apache');
		safe_exec($this->settings['system']['apachereload_command']);
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
			$vhosts_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/10_syscp_ipandport_' . trim(str_replace(':', '.', $row_ipsandports['ip']), '.') . '.' . $row_ipsandports['port'] . '.conf');

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
				$this->virtualhosts_data[$vhosts_filename].= 'NameVirtualHost ' . $ipport . "\n";
				$this->logger->logAction(CRON_ACTION, LOG_DEBUG, $ipport . ' :: inserted namevirtualhost-statement');
			}

			if($row_ipsandports['vhostcontainer'] == '1')
			{
				$this->virtualhosts_data[$vhosts_filename].= '<VirtualHost ' . $ipport . '>' . "\n";

				if($row_ipsandports['vhostcontainer_servername_statement'] == '1')
				{
					$this->virtualhosts_data[$vhosts_filename].= ' ServerName ' . $this->settings['system']['hostname'] . "\n";
				}

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
					}
				}

				$this->virtualhosts_data[$vhosts_filename].= '</VirtualHost>' . "\n";
				$this->logger->logAction(CRON_ACTION, LOG_DEBUG, $ipport . ' :: inserted vhostcontainer');
			}

			unset($vhosts_filename);
		}
	}

	/*
	*	We put together the needed php options in the virtualhost entries
	*/

	protected function composePhpOptions($domain)
	{
		$php_options_text = '';

		if($domain['phpenabled'] == '1')
		{
			// This vHost has PHP enabled and we are using the regular mod_php

			if($domain['openbasedir'] == '1')
			{
				if($this->settings['system']['phpappendopenbasedir'] != '')
				{
					$_phpappendopenbasedir = ':' . $this->settings['system']['phpappendopenbasedir'];
				}
				else
				{
					$_phpappendopenbasedir = '';
				}

				if($domain['openbasedir_path'] == '1')
				{
					$php_options_text.= '  php_admin_value open_basedir "' . $domain['customerroot'] . $_phpappendopenbasedir . "\"\n";
				}
				else
				{
					$php_options_text.= '  php_admin_value open_basedir "' . $domain['documentroot'] . $_phpappendopenbasedir . "\"\n";
				}
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

		$alias_domains = $this->db->query('SELECT `domain`, `iswildcarddomain`, `wwwserveralias` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `aliasdomain`=\'' . $domain['id'] . '\'');

		while(($alias_domain = $this->db->fetch_array($alias_domains)) !== false)
		{
			$server_alias.= ' ' . $alias_domain['domain'];

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
		}

		if(trim($server_alias) != '')
		{
			$servernames_text.= '  ServerAlias ' . $server_alias . "\n";
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
			$webroot_text.= '  DocumentRoot "' . $this->settings['system']['deactivateddocroot'] . "\"\n";
		}
		else
		{
			$webroot_text.= '  DocumentRoot "' . $domain['documentroot'] . "\"\n";
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
				$stats_text.= '  Alias /webalizer "' . makeCorrectFile($domain['customerroot'] . '/webalizer/' . $domain['domain']) . '"' . "\n";

				if($this->settings['system']['awstats_enabled'] == '1')
				{
					$stats_text.= createAWStatsVhost($domain['domain'], $this->settings);
				}
			}
			else
			{
				$stats_text.= '  Alias /webalizer "' . makeCorrectFile($domain['customerroot'] . '/webalizer/' . $domain['parentdomain']) . '"' . "\n";

				if($this->settings['system']['awstats_enabled'] == '1')
				{
					$stats_text.= createAWStatsVhost($domain['parentdomain'], $this->settings);
				}
			}
		}
		else
		{
			if($domain['customerroot'] != $domain['documentroot'])
			{
				$stats_text.= '  Alias /webalizer "' . makeCorrectFile($domain['customerroot'] . '/webalizer') . '"' . "\n";
			}

			if($this->settings['system']['awstats_enabled'] == '1')
			{
				$stats_text.= createAWStatsVhost($domain['domain'], $this->settings);
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
			chown($error_log, $this->settings['system']['httpuser']);
			chgrp($error_log, $this->settings['system']['httpgroup']);
			
			$access_log = makeCorrectFile($this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-access.log');
			chown($access_log, $this->settings['system']['httpuser']);
			chgrp($access_log, $this->settings['system']['httpgroup']);
					
			$logfiles_text.= '  ErrorLog "' . $error_log . "\"\n";
			$logfiles_text.= '  CustomLog "' . $access_log .'" combined' . "\n";

		}

		if($this->settings['system']['awstats_enabled'] == '1')
		{
			// prepare the aliases for stats config files

			$server_alias = '';
			$alias_domains = $this->db->query('SELECT `domain`, `iswildcarddomain`, `wwwserveralias` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `aliasdomain`=\'' . $domain['id'] . '\'');

			while(($alias_domain = $this->db->fetch_array($alias_domains)) !== false)
			{
				$server_alias.= ' ' . $alias_domain['domain'] . ' ';

				if($alias_domain['iswildcarddomain'] == '1')
				{
					$server_alias.= '*.' . $domain['domain'];
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

			// After inserting the AWStats information, be sure to build the awstats conf file as well

			createAWStatsConf($this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-access.log', $domain['domain'], $alias . $server_alias);
		}

		return $logfiles_text;
	}

	/*
	*	Get the filename for the virtualhost
	*/

	protected function getVhostFilename($domain, $ssl_vhost = false)
	{
		if($ssl_vhost === true)
		{
			$vhost_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/20_syscp_ssl_vhost_' . $domain['domain'] . '.conf');
		}
		else
		{
			$vhost_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/20_syscp_normal_vhost_' . $domain['domain'] . '.conf');
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

		if(preg_match('/^https?\:\/\//', $domain['documentroot']))
		{
			$vhost_content.= '  Redirect 301 / ' . $this->idnaConvert->encode($domain['documentroot']) . "\n";
		}
		else
		{
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
				}
			}

			mkDirWithCorrectOwnership($domain['customerroot'], $domain['documentroot'], $domain['guid'], $domain['guid']);
			$vhost_content.= $this->getWebroot($domain);
			$vhost_content.= $this->composePhpOptions($domain);
			$vhost_content.= $this->getStats($domain);
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
		$result_domains = $this->db->query("SELECT `d`.`id`, `d`.`domain`, `d`.`customerid`, `d`.`documentroot`, `d`.`ssl`, `d`.`parentdomainid`, `d`.`ipandport`, `d`.`ssl_ipandport`, `d`.`ssl_redirect`, `d`.`isemaildomain`, `d`.`iswildcarddomain`, `d`.`wwwserveralias`, `d`.`openbasedir`, `d`.`openbasedir_path`, `d`.`safemode`, `d`.`speciallogfile`, `d`.`specialsettings`, `pd`.`domain` AS `parentdomain`, `c`.`loginname`, `d`.`phpsettingid`, `c`.`adminid`, `c`.`guid`, `c`.`email`, `c`.`documentroot` AS `customerroot`, `c`.`deactivated`, `c`.`phpenabled` AS `phpenabled`, `d`.`mod_fcgid_starter`, `d`.`mod_fcgid_maxrequests` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`) " . "LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `pd` ON (`pd`.`id` = `d`.`parentdomainid`) " . "WHERE `d`.`aliasdomain` IS NULL ORDER BY `d`.`iswildcarddomain`, `d`.`domain` ASC");

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
			$diroptions_filename = makeCorrectFile($this->settings['system']['apacheconf_diroptions'] . '/40_syscp_diroption_' . md5($row_diroptions['path']) . '.conf');

			if(!isset($this->diroptions_data[$diroptions_filename]))
			{
				$this->diroptions_data[$diroptions_filename] = '';
			}

			if(is_dir($row_diroptions['path']))
			{
				$this->diroptions_data[$diroptions_filename].= '<Directory "' . $row_diroptions['path'] . '">' . "\n";

				if(isset($row_diroptions['options_indexes'])
				   && $row_diroptions['options_indexes'] == '1')
				{
					$this->diroptions_data[$diroptions_filename].= '  Options +Indexes' . "\n";
					fwrite($this->debugHandler, '  cron_tasks: Task3 - Setting Options +Indexes' . "\n");
				}

				if(isset($row_diroptions['options_indexes'])
				   && $row_diroptions['options_indexes'] == '0')
				{
					$this->diroptions_data[$diroptions_filename].= '  Options -Indexes' . "\n";
					fwrite($this->debugHandler, '  cron_tasks: Task3 - Setting Options -Indexes' . "\n");
				}

				if(isset($row_diroptions['error404path'])
				   && $row_diroptions['error404path'] != '')
				{
					$this->diroptions_data[$diroptions_filename].= '  ErrorDocument 404 ' . $row_diroptions['error404path'] . "\n";
				}

				if(isset($row_diroptions['error403path'])
				   && $row_diroptions['error403path'] != '')
				{
					$this->diroptions_data[$diroptions_filename].= '  ErrorDocument 403 ' . $row_diroptions['error403path'] . "\n";
				}

				if(isset($row_diroptions['error500path'])
				   && $row_diroptions['error500path'] != '')
				{
					$this->diroptions_data[$diroptions_filename].= '  ErrorDocument 500 ' . $row_diroptions['error500path'] . "\n";
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
					$this->diroptions_data[$diroptions_filename].= '  AuthName "Restricted Area"' . "\n";
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
			elseif(!is_dir($this->settings['system']['apacheconf_htpasswddir']))
			{
				fwrite($this->debugHandler, '  cron_tasks: WARNING!!! ' . $this->settings['system']['apacheconf_htpasswddir'] . ' is not a directory. htpasswd directory protection is disabled!!!' . "\n");
				echo 'WARNING!!! ' . $this->settings['system']['apacheconf_htpasswddir'] . ' is not a directory. htpasswd directory protection is disabled!!!';
				$this->logger->logAction(CRON_ACTION, LOG_WARNING, 'WARNING!!! ' . $this->settings['system']['apacheconf_htpasswddir'] . ' is not a directory. htpasswd directory protection is disabled!!!');
			}

			if(is_dir($this->settings['system']['apacheconf_htpasswddir']))
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

		if(isConfigDir($this->settings['system']['apacheconf_vhost'])
		   && file_exists($this->settings['system']['apacheconf_vhost'])
		   && is_dir($this->settings['system']['apacheconf_vhost']))
		{
			$vhost_file_dirhandle = opendir($this->settings['system']['apacheconf_vhost']);

			while(false !== ($vhost_filename = readdir($vhost_file_dirhandle)))
			{
				if($vhost_filename != '.'
				   && $vhost_filename != '..'
				   && !in_array($vhost_filename, $this->known_vhostfilenames)
				   && preg_match('/^(10|20|30)_syscp_(ipandport|normal_vhost|wildcard_vhost|ssl_vhost)_(.+)\.conf$/', $vhost_filename)
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

		if(isConfigDir($this->settings['system']['apacheconf_diroptions'])
		   && file_exists($this->settings['system']['apacheconf_diroptions'])
		   && is_dir($this->settings['system']['apacheconf_diroptions']))
		{
			$diroptions_file_dirhandle = opendir($this->settings['system']['apacheconf_diroptions']);

			while(false !== ($diroptions_filename = readdir($diroptions_file_dirhandle)))
			{
				if($diroptions_filename != '.'
				   && $diroptions_filename != '..'
				   && !in_array($diroptions_filename, $this->known_diroptionsfilenames)
				   && preg_match('/^40_syscp_diroption_(.+)\.conf$/', $diroptions_filename)
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

		if(isConfigDir($this->settings['system']['apacheconf_htpasswddir'])
		   && file_exists($this->settings['system']['apacheconf_htpasswddir'])
		   && is_dir($this->settings['system']['apacheconf_htpasswddir']))
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

?>
