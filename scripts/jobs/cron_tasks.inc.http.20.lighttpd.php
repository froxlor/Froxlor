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

/*
 * This script creates the php.ini's used by mod_suPHP+php-cgi
 */

if(@php_sapi_name() != 'cli'
&& @php_sapi_name() != 'cgi'
&& @php_sapi_name() != 'cgi-fcgi')
{
	die('This script only works in the shell.');
}

class lighttpd
{
	private $db = false;
	private $logger = false;
	private $debugHandler = false;
	private $idnaConvert = false;

	//	protected

	protected $settings = array(); 
	protected $lighttpd_data = array();
	protected $needed_htpasswds = array();
	protected $auth_backend_loaded = false;
	protected $htpasswd_files = array();
	protected $mod_accesslog_loaded = "0";

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
			fwrite($this->debugHandler, '   lighttpd::reload: reloading php-fpm' . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading php-fpm');
			safe_exec(escapeshellcmd($this->settings['phpfpm']['reload']));
		}
		fwrite($this->debugHandler, '   lighttpd::reload: reloading lighttpd' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading lighttpd');
		safe_exec(escapeshellcmd($this->settings['system']['apachereload_command']));
	}

	public function createIpPort()
	{
		$query = "SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `ip` ASC, `port` ASC";
		$result_ipsandports = $this->db->query($query);

		while($row_ipsandports = $this->db->fetch_array($result_ipsandports))
		{
			if(filter_var($row_ipsandports['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
			{
				$ip = '[' . $row_ipsandports['ip'] . ']';
				$port = $row_ipsandports['port'];
				$ipv6 = 'server.use-ipv6 = "enable"'."\n";
			}
			else
			{
				$ip = $row_ipsandports['ip'];
				$port = $row_ipsandports['port'];
				$ipv6 = '';
			}

			fwrite($this->debugHandler, '  lighttpd::createIpPort: creating ip/port settings for  ' . $ip . ":" . $port . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'creating ip/port settings for  ' . $ip . ":" . $port);
			$vhost_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/10_froxlor_ipandport_' . trim(str_replace(':', '.', $row_ipsandports['ip']), '.') . '.' . $row_ipsandports['port'] . '.conf');

			if(!isset($this->lighttpd_data[$vhost_filename]))
			{
				$this->lighttpd_data[$vhost_filename] = '';
			}

			$this->lighttpd_data[$vhost_filename].= '$SERVER["socket"] == "' . $ip . ':' . $port . '" {' . "\n";

			if($row_ipsandports['listen_statement'] == '1')
			{
				$this->lighttpd_data[$vhost_filename].= 'server.port = ' . $port . "\n";
				$this->lighttpd_data[$vhost_filename].= 'server.bind = "' . $ip . '"' . "\n";
				$this->lighttpd_data[$vhost_filename].= $ipv6;
			}
			
			if($row_ipsandports['vhostcontainer'] == '1')
			{
				$myhost = str_replace('.', '\.', $this->settings['system']['hostname']);
				$this->lighttpd_data[$vhost_filename].= '# Froxlor default vhost' . "\n";
				$this->lighttpd_data[$vhost_filename].= '$HTTP["host"] =~ "^(?:www\.|)' . $myhost . '$" {' . "\n";

				if($row_ipsandports['docroot'] == '')
				{
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

				$this->lighttpd_data[$vhost_filename].= '  server.document-root = "'.$mypath.'"'."\n";

				/**
				 * dirprotection, see #72
				 * @TODO use better regex for this, deferred until 0.9.5
				 *
				$this->lighttpd_data[$vhost_filename].= '  $HTTP["url"] =~ "^/(.+)\/(.+)\.php" {' . "\n";
				$this->lighttpd_data[$vhost_filename].= '    url.access-deny = ("")' . "\n";
				$this->lighttpd_data[$vhost_filename].= '  }' . "\n";
				*/

				/**
				 * own php-fpm vhost
				 */
				if((int)$this->settings['phpfpm']['enabled'] == 1)
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
						'documentroot' => $mypath
					);
	
					$php = new phpinterface($this->getDB(), $this->settings, $domain);

					$this->lighttpd_data[$vhost_filename].= '  fastcgi.server = ( '."\n";
					$this->lighttpd_data[$vhost_filename].=	"\t".'".php" => ('."\n";
					$this->lighttpd_data[$vhost_filename].=	"\t\t".'"localhost" => ('."\n";
					$this->lighttpd_data[$vhost_filename].=	"\t\t".'"socket" => "'.$php->getInterface()->getSocketFile().'",'."\n";
					$this->lighttpd_data[$vhost_filename].=	"\t\t".'"check-local" => "enable",'."\n";
					$this->lighttpd_data[$vhost_filename].=	"\t\t".'"disable-time" => 1'."\n";
					$this->lighttpd_data[$vhost_filename].=	"\t".')'."\n";
					$this->lighttpd_data[$vhost_filename].=	"\t".')'."\n";
					$this->lighttpd_data[$vhost_filename].=	'  )'."\n";
				}

				if($row_ipsandports['specialsettings'] != '')
				{
					$this->lighttpd_data[$vhost_filename].= $row_ipsandports['specialsettings'] . "\n";
				}

				$this->lighttpd_data[$vhost_filename].= '}' . "\n";
			}
	
			if($row_ipsandports['ssl'] == '1')
			{
				if($row_ipsandports['ssl_cert_file'] == '')
				{
					$row_ipsandports['ssl_cert_file'] = $this->settings['system']['ssl_cert_file'];
				}

				if($row_ipsandports['ssl_ca_file'] == '')
				{
					$row_ipsandports['ssl_ca_file'] = $this->settings['system']['ssl_ca_file'];
				}
				
				if($row_ipsandports['ssl_cert_file'] != '')
				{
					$this->lighttpd_data[$vhost_filename].= 'ssl.engine = "enable"' . "\n";
					$this->lighttpd_data[$vhost_filename].= 'ssl.pemfile = "' . makeCorrectFile($row_ipsandports['ssl_cert_file']) . '"' . "\n";
					
					if($row_ipsandports['ssl_ca_file'] != '')
					{
						$this->lighttpd_data[$vhost_filename].= 'ssl.ca-file = "' . makeCorrectFile($row_ipsandports['ssl_ca_file']) . '"' . "\n";
					}
				}
			}

			/**
			 * this function will create a new file which will be included
			 * if $this->settings['system']['apacheconf_vhost'] is a folder
			 * refs #70
			 */
			$vhosts = $this->createLighttpdHosts($row_ipsandports['ip'], $row_ipsandports['port'], $row_ipsandports['ssl'], $vhost_filename);
			if($vhosts !== null && is_array($vhosts) && isset($vhosts[0]))
			{
				// sort vhosts by number (subdomains first!)
				sort($vhosts);

				foreach($vhosts as $vhost) {
					$this->lighttpd_data[$vhost_filename].= ' include "'.$vhost.'"'."\n";
				}
			}
			
			$this->lighttpd_data[$vhost_filename].= '}' . "\n";
		}

		/**
		 * bug #unknown-yet
		 */
		$this->_createStandardErrorHandler();
	}

	/**
	 * define a default server.error-handler-404-statement, bug #unknown-yet
	 */
	private function _createStandardErrorHandler()
	{
		if($this->settings['defaultwebsrverrhandler']['enabled'] == '1'
			&& $this->settings['defaultwebsrverrhandler']['err404'] != ''
		) {
			$vhosts_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/05_froxlor_default_errorhandler.conf');

			if(!isset($this->lighttpd_data[$vhost_filename]))
			{
				$this->lighttpd_data[$vhost_filename] = '';
			}

			$this->lighttpd_data[$vhost_filename] = 'server.error-handler-404 = "'.makeCorrectFile($this->settings['defaultwebsrverrhandler']['err404']).'"';
		}
	}

	protected function create_htaccess($domain)
	{
		$needed_htpasswds = array();
		$htpasswd_query = "SELECT * FROM " . TABLE_PANEL_HTPASSWDS . " WHERE `path` LIKE '" . $domain['documentroot'] . "%'";
		$result_htpasswds = $this->db->query($htpasswd_query);

		$htaccess_text = '';
		while($row_htpasswds = $this->db->fetch_array($result_htpasswds))
		{
			$row_htpasswds['path'] = makeCorrectDir($row_htpasswds['path']);
			mkDirWithCorrectOwnership($domain['documentroot'], $row_htpasswds['path'], $domain['guid'], $domain['guid']);
			
			$filename = $row_htpasswds['customerid'] . '-' . md5($row_htpasswds['path']) . '.htpasswd';

			if(!in_array($row_htpasswds['path'], $needed_htpasswds))
			{
				if(!isset($this->needed_htpasswds[$filename])) {
					$this->needed_htpasswds[$filename] = '';
				}

				if(!strstr($this->needed_htpasswds[$filename], $row_htpasswds['username'] . ':' . $row_htpasswds['password']))
				{
					$this->needed_htpasswds[$filename].= $row_htpasswds['username'] . ':' . $row_htpasswds['password'] . "\n";
				}

				$htaccess_path = substr($row_htpasswds['path'], strlen($domain['documentroot']) - 1);
				$htaccess_path = makeCorrectDir($htaccess_path);

				$htaccess_text.= '  $HTTP["url"] =~ "^'.$htaccess_path.'" {' . "\n";
				$htaccess_text.= '    auth.backend = "htpasswd"' . "\n";
				$htaccess_text.= '    auth.backend.htpasswd.userfile = "' . makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $filename) . '"' . "\n";
				$htaccess_text.= '    auth.require = ( ' . "\n";
				$htaccess_text.= '      "' . $htaccess_path . '" =>' . "\n";
				$htaccess_text.= '      (' . "\n";
				$htaccess_text.= '         "method"  => "basic",' . "\n";
				$htaccess_text.= '         "realm"   => "'.$row_htpasswds['authname'].'",' . "\n";
				$htaccess_text.= '         "require" => "valid-user"' . "\n";
				$htaccess_text.= '      )' . "\n";
				$htaccess_text.= '    )' . "\n";
				$htaccess_text.= '  }' . "\n";

				$needed_htpasswds[] = $row_htpasswds['path'];
			}
		}

		return $htaccess_text;
	}

	public function createVirtualHosts()
	{
	}

	public function createFileDirOptions()
	{
	}

	protected function composePhpOptions($domain)
	{
	}

	public function createOwnVhostStarter()
	{
	}

	protected function createLighttpdHosts($ip, $port, $ssl, $vhost_filename)
	{
		$query = "SELECT * FROM " . TABLE_PANEL_IPSANDPORTS . " WHERE `ip`='" . $ip . "' AND `port`='" . $port . "'";
		$ipandport = $this->db->query_first($query);

		if($ssl == '0')
		{
			$query2 = "SELECT `d`.*, `pd`.`domain` AS `parentdomain`, `c`.`loginname`, `c`.`guid`, `c`.`email`, `c`.`documentroot` AS `customerroot`, `c`.`deactivated`, `c`.`phpenabled` AS `phpenabled` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`) LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `pd` ON (`pd`.`id` = `d`.`parentdomainid`) WHERE `d`.`ipandport`='" . $ipandport['id'] . "' AND `d`.`aliasdomain` IS NULL AND `d`.`email_only` <> 1 ORDER BY `d`.`parentdomainid` DESC, `d`.`iswildcarddomain`, `d`.`domain` ASC";
		}
		else
		{
			$query2 = "SELECT `d`.*, `pd`.`domain` AS `parentdomain`, `c`.`loginname`, `c`.`guid`, `c`.`email`, `c`.`documentroot` AS `customerroot`, `c`.`deactivated`, `c`.`phpenabled` AS `phpenabled` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`) LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `pd` ON (`pd`.`id` = `d`.`parentdomainid`) WHERE `d`.`ssl_ipandport`='" . $ipandport['id'] . "' AND `d`.`aliasdomain` IS NULL AND `d`.`email_only` <> 1 ORDER BY `d`.`parentdomainid` DESC, `d`.`iswildcarddomain`, `d`.`domain` ASC";
		}

		$included_vhosts = array();
		$result_domains = $this->db->query($query2);
		while($domain = $this->db->fetch_array($result_domains))
		{
			
			if (is_dir($this->settings['system']['apacheconf_vhost']))
			{
				safe_exec('mkdir -p '.escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'].'/vhosts/')));
				
				// determine correct include-path:
				// e.g. '/etc/lighttpd/conf-enabled/vhosts/ has to become'
				// 'conf-enabled/vhosts/' (damn debian, but luckily works too on other distros)
				$_tmp_path = substr(makeCorrectDir($this->settings['system']['apacheconf_vhost']), 0, -1);
				$_pos = strrpos($_tmp_path, '/');
				$_inc_path = substr($_tmp_path, $_pos+1);

				if((int)$domain['parentdomainid'] == 0 
					&& isCustomerStdSubdomain((int)$domain['id']) == false
					&& ((int)$domain['ismainbutsubto'] == 0
					|| domainMainToSubExists($domain['ismainbutsubto']) == false) 
				) {
					$vhost_no = '52';
					if($ssl == '1')
					{
						$vhost_no = '62';
					}
				}
				elseif((int)$domain['parentdomainid'] == 0 
					&& isCustomerStdSubdomain((int)$domain['id']) == false
					&& (int)$domain['ismainbutsubto'] > 0
				) {
					$vhost_no = '51';
					if($ssl == '1')
					{
						$vhost_no = '61';
					}
				}
				else
				{
					$vhost_no = '50';
					if($ssl == '1')
					{
						$vhost_no = '60';
					}
				}

				$vhost_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'].'/vhosts/'.$vhost_no.'_'.$domain['domain'].'.conf');
				$included_vhosts[] = $_inc_path.'/vhosts/'.$vhost_no.'_'.$domain['domain'].'.conf';
			}
			if(!isset($this->lighttpd_data[$vhost_filename]))
			{
				$this->lighttpd_data[$vhost_filename] = '';
			}

			if((!empty($this->lighttpd_data[$vhost_filename])
				&& !is_dir($this->settings['system']['apacheconf_vhost']))
				|| is_dir($this->settings['system']['apacheconf_vhost'])
			) {
				if($ssl == '1')
				{
					$ssl_vhost = true;
					$ips_and_ports_index = 'ssl_ipandport';
				}
				else
				{
					$ssl_vhost = false;
					$ips_and_ports_index = 'ipandport';
				}

				$this->lighttpd_data[$vhost_filename].= $this->getVhostContent($domain, $ssl_vhost);
				$this->lighttpd_data[$vhost_filename].= isset($this->needed_htpasswds[$domain[$ips_and_ports_index]]) ? $this->needed_htpasswds[$domain[$ips_and_ports_index]] . "\n" : '';
			}
		}
		return $included_vhosts;
	}

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
		$domain['ssl_ca_file'] = $ipandport['ssl_ca_file'];

		if(filter_var($domain['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
		{
			$ipport = '[' . $domain['ip'] . ']:' . $domain['port'];
		}
		else
		{
			$ipport = $domain['ip'] . ':' . $domain['port'];
		}

		$vhost_content = '';
		$vhost_content.= $this->getServerNames($domain) . " {\n";

		// respect ssl_redirect settings, #542
		if($ssl_vhost == false
			&& $domain['ssl'] == '1'
			&& $domain['ssl_redirect'] == '1'
		) {
			$domain['documentroot'] = 'https://' . $domain['domain'] . '/';
		}

		if(preg_match('/^https?\:\/\//', $domain['documentroot']))
		{
			$vhost_content.= '  url.redirect = (' . "\n";
			$vhost_content.= '     "^/(.*)$" => "'. $this->idnaConvert->encode($domain['documentroot']) . '$1"'. "\n";
			$vhost_content.= '  )' . "\n";
		}
		else
		{
			mkDirWithCorrectOwnership($domain['customerroot'], $domain['documentroot'], $domain['guid'], $domain['guid'], true, true);

			$only_webroot = false;
			if($ssl_vhost === false && $domain['ssl_redirect'] == '1')
			{
				$only_webroot = true;
			}
			$vhost_content.= $this->getWebroot($domain, $ssl_vhost);
			if(!$only_webroot)
			{
				if ($this->_deactivated == false) {
					$vhost_content.= $this->create_htaccess($domain);
					$vhost_content.= $this->create_pathOptions($domain);
					$vhost_content.= $this->composePhpOptions($domain);
					$vhost_content.= $this->getStats($domain);
					$vhost_content.= $this->getSslSettings($domain, $ssl_vhost);
				}
				$vhost_content.= $this->getLogFiles($domain);
			}
		}

		if ($domain['specialsettings'] != "") {
			$vhost_content.= $domain['specialsettings'] . "\n";
		}
		$vhost_content.= '}' . "\n";

		return $vhost_content;
	}

	protected function getSslSettings($domain, $ssl_vhost)
	{
		$ssl_settings = '';
		
		if($ssl_vhost === true
			&& $domain['ssl'] == '1'
			&& (int)$this->settings['system']['use_ssl'] == 1
		) {
			if($domain['ssl_cert_file'] == '')
			{
				$domain['ssl_cert_file'] = $this->settings['system']['ssl_cert_file'];
			}

			if($domain['ssl_ca_file'] == '')
			{
				$domain['ssl_ca_file'] = $this->settings['system']['ssl_ca_file'];
			}
			
			if($domain['ssl_cert_file'] != '')
			{
				$ssl_settings.= 'ssl.engine = "enable"' . "\n";
				$ssl_settings.= 'ssl.pemfile = "' . makeCorrectFile($domain['ssl_cert_file']) . '"' . "\n";
				
				if($domain['ssl_ca_file'] != '')
				{
					$ssl_settings.= 'ssl.ca-file = "' . makeCorrectFile($domain['ssl_ca_file']) . '"' . "\n";
				}
			}
		}
		return $ssl_settings;
	}

	protected function getLogFiles($domain)
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

		if($this->settings['system']['mod_log_sql'] == 1)
		{
			// We are using mod_log_sql (http://www.outoforder.cc/projects/apache/mod_log_sql/)
			// TODO: See how we are able emulate the error_log
		}
		else
		{
			// The normal access/error - logging is enabled
			// error log cannot be set conditionally see
			// https://redmine.lighttpd.net/issues/665

			$access_log = makeCorrectFile($this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-access.log');
			// Create the logfile if it does not exist (fixes #46)
			touch($access_log);
			chown($access_log, $this->settings['system']['httpuser']);
			chgrp($access_log, $this->settings['system']['httpgroup']);

			$logfiles_text.= '  accesslog.filename	= "' . $access_log . '"' . "\n";
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
	
				// After inserting the AWStats information, 
				// be sure to build the awstats conf file as well
				// and chown it using $awstats_params, #258
				// Bug 960 + Bug 970 : Use full $domain instead of custom $awstats_params as following classes depend on the informations
				createAWStatsConf($this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-access.log', $domain['domain'], $alias . $server_alias, $domain['customerroot'], $domain);
			}
		}

		return $logfiles_text;
	}

	protected function create_pathOptions($domain)
	{
		$query = "SELECT * FROM " . TABLE_PANEL_HTACCESS . " WHERE `path` LIKE '" . $domain['documentroot'] . "%'";
		$result = $this->db->query($query);

		$path_options = '';
		$error_string = '';

		while($row = $this->db->fetch_array($result))
		{
			if(!empty($row['error404path']))
			{
				$error_string.= '  server.error-handler-404 = "' . makeCorrectFile($domain['documentroot'] . '/' . $row['error404path']) . '"' . "\n\n";
			}

			if($row['options_indexes'] != '0')
			{
				if(!empty($error_string))
				{
					$path_options.= $error_string;
					// reset $error_string here to prevent duplicate entries
					$error_string = '';
				}

				$path = makeCorrectDir(substr($row['path'], strlen($domain['documentroot']) - 1));
				mkDirWithCorrectOwnership($domain['documentroot'], $row['path'], $domain['guid'], $domain['guid']);				

				// We need to remove the last slash, otherwise the regex wouldn't work
				if($row['path'] != $domain['documentroot']) {
					$path = substr($path, 0, -1);
				}
				$path_options.= '  $HTTP["url"] =~ "^' . $path . '($|/)" {' . "\n";
				$path_options.= "\t" . 'dir-listing.activate = "enable"' . "\n";
				$path_options.= '  }' . "\n\n";
			}
			else
			{
				$path_options = $error_string;
			}

			if(customerHasPerlEnabled($domain['customerid'])
				&& $row['options_cgi'] != '0')
			{
				$path = makeCorrectDir(substr($row['path'], strlen($domain['documentroot']) - 1));
				mkDirWithCorrectOwnership($domain['documentroot'], $row['path'], $domain['guid'], $domain['guid']);				

				// We need to remove the last slash, otherwise the regex wouldn't work
				if($row['path'] != $domain['documentroot']) {
					$path = substr($path, 0, -1);
				}
				$path_options.= '  $HTTP["url"] =~ "^' . $path . '($|/)" {' . "\n";
				$path_options.= "\t" . 'cgi.assign = (' . "\n";
				$path_options.= "\t\t" . '".pl" => "'.makeCorrectFile($this->settings['system']['perl_path']).'",' . "\n";
				$path_options.= "\t\t" . '".cgi" => "'.makeCorrectFile($this->settings['system']['perl_path']).'"' . "\n";
				$path_options.= "\t" . ')' . "\n";
				$path_options.= '  }' . "\n\n";
			}
		}

		return $path_options;
	}

	protected function getDirOptions($domain)
	{
		$query = "SELECT * FROM " . TABLE_PANEL_HTPASSWDS . " WHERE `customerid`='" . $domain['customerid'] . "'";
		$result = $this->db->query($query);

		while($row_htpasswds = $this->db->fetch_array($result))
		{
			if($auth_backend_loaded[$domain['ipandport']] != 'yes'
			&& $auth_backend_loaded[$domain['ssl_ipandport']] != 'yes')
			{
				$filename = $domain['customerid'] . '.htpasswd';

				if($this->auth_backend_loaded[$domain['ipandport']] != 'yes')
				{
					$auth_backend_loaded[$domain['ipandport']] = 'yes';
					$diroption_text.= 'auth.backend = "htpasswd"' . "\n";
					$diroption_text.= 'auth.backend.htpasswd.userfile = "' . makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $filename) . '"' . "\n";
					$this->needed_htpasswds[$filename] = $row_htpasswds['username'] . ':' . $row_htpasswds['password'] . "\n";
					$diroption_text.= 'auth.require = ( ' . "\n";
					$previous_domain_id = '1';
				}
				elseif($this->auth_backend_loaded[$domain['ssl_ipandport']] != 'yes')
				{
					$auth_backend_loaded[$domain['ssl_ipandport']] = 'yes';
					$diroption_text.= 'auth.backend= "htpasswd"' . "\n";
					$diroption_text.= 'auth.backend.htpasswd.userfile = "' . makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $filename) . '"' . "\n";
					$this->needed_htpasswds[$filename] = $row_htpasswds['username'] . ':' . $row_htpasswds['password'] . "\n";
					$diroption_text.= 'auth.require = ( ' . "\n";
					$previous_domain_id = '1';
				}
			}

			$diroption_text.= '"' . makeCorrectDir($row_htpasswds['path']) . '" =>' . "\n";
			$diroption_text.= '(' . "\n";
			$diroption_text.= '   "method"  => "basic",' . "\n";
			$diroption_text.= '   "realm"   => "'.$row_htpasswds['authname'].'",' . "\n";
			$diroption_text.= '   "require" => "valid-user"' . "\n";
			$diroption_text.= ')' . "\n";

			if($this->auth_backend_loaded[$domain['ssl_ipandport']] == 'yes')
			{
				$this->needed_htpasswds[$domain['ssl_ipandport']].= $diroption_text;
			}

			if($this->auth_backend_loaded[$domain['ipandport']] != 'yes')
			{
				$this->needed_htpasswds[$domain['ipandport']].= $diroption_text;
			}
		}

		return '  auth.backend.htpasswd.userfile = "' . makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $filename) . '"' . "\n";
	}

	protected function getServerNames($domain)
	{
		$server_string = array();
		$domain_name = str_replace('.', '\.', $domain['domain']);

		if($domain['iswildcarddomain'] == '1')
		{
			$server_string[] = '(?:^|\.)' . $domain_name . '$';
		}
		else
		{
			if($domain['wwwserveralias'] == '1')
			{
				$server_string[] = '^(?:www\.|)' . $domain_name . '$';
			}
			else
			{
				$server_string[] = '^'.$domain_name.'$';
			}
		}

		$alias_domains = $this->db->query('SELECT `domain`, `iswildcarddomain`, `wwwserveralias` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `aliasdomain`=\'' . $domain['id'] . '\'');

		while(($alias_domain = $this->db->fetch_array($alias_domains)) !== false)
		{
			$alias_domain_name = ereg_replace('\.', '\.', $alias_domain['domain']);

			if($alias_domain['iswildcarddomain'] == '1')
			{
				$server_string[] = '(?:^|\.)' . $alias_domain_name . '$';
			}
			else
			{
				if($alias_domain['wwwserveralias'] == '1')
				{
					$server_string[] = '^(?:www\.|)' . $alias_domain_name . '$';
				}
				else
				{
					$server_string[] = '^'.$alias_domain_name . '$';
				}
			}
		}

		for ($i = 0;$i < sizeof($server_string);$i++)
		{
			$data = $server_string[$i];

			if(sizeof($server_string) > 1)
			{
				if($i == 0)
				{
					$servernames_text = '(' . $data . '|';
				}
				elseif(sizeof($server_string) - 1 == $i)
				{
					$servernames_text.= $data . ')';
				}
				else
				{
					$servernames_text.= $data . '|';
				}
			}
			else
			{
				$servernames_text = $data;
			}
		}

		unset($data);

		if($servernames_text != '') {
			$servernames_text = '$HTTP["host"] =~ "' . $servernames_text . '"';
		} else {
			$servernames_text = '$HTTP["host"] == "' . $domain['domain'] . '"';
		}

		return $servernames_text;
	}

	protected function getWebroot($domain, $ssl)
	{
		$webroot_text = '';

		if($domain['deactivated'] == '1'
		&& $this->settings['system']['deactivateddocroot'] != '')
		{
			$webroot_text.= '  # Using docroot for deactivated users...' . "\n";
			$webroot_text.= '  server.document-root = "' . makeCorrectDir($this->settings['system']['deactivateddocroot']) . "\"\n";
			$this->_deactivated = true;
		}
		else
		{
			if($ssl === false
			&& $domain['ssl_redirect'] == '1')
			{
				$redirect_domain = $this->idnaConvert->encode('https://' . $domain['domain']);
				$webroot_text.= '  url.redirect = ('."\n";
				$webroot_text.= "\t" . '"^/(.*)" => "' . $redirect_domain . '/$1",' . "\n";
				$webroot_text.= "\t" . '"" => "' . $redirect_domain . '",' . "\n";
				$webroot_text.= "\t" . '"/" => "' . $redirect_domain . '"' . "\n";
				$webroot_text.= '  )'."\n";
			}
			elseif(preg_match("#^https?://#i", $domain['documentroot']))
			{
				$redirect_domain = $this->idnaConvert->encode($domain['documentroot']);
				$webroot_text.= '  url.redirect = ('."\n";
				$webroot_text.= "\t" . '"^/(.*)" => "' . $redirect_domain . '/$1",' . "\n";
				$webroot_text.= "\t" . '"" => "' . $redirect_domain . '",' . "\n";
				$webroot_text.= "\t" . '"/" => "' . $redirect_domain . '"' . "\n";
				$webroot_text.= '  )'."\n";
			}
			else
			{
				$webroot_text.= '  server.document-root = "' . makeCorrectDir($domain['documentroot']) . "\"\n";
			}
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
					$stats_text.= '  alias.url = ( "/awstats/" => "'.makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['domain']).'" )' . "\n";
					$stats_text.= '  alias.url += ( "/awstats-icon" => "' . makeCorrectDir($this->settings['system']['awstats_icons']) . '" )' . "\n";
				}
				else
				{
					$stats_text.= '  alias.url = ( "/webalizer/" => "'.makeCorrectFile($domain['customerroot'] . '/webalizer/' . $domain['domain']).'/" )' . "\n";					
				}
			}
			else
			{
				if($this->settings['system']['awstats_enabled'] == '1')
				{
					$stats_text.= '  alias.url = ( "/awstats/" => "'.makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['parentdomain']).'" )' . "\n";
					$stats_text.= '  alias.url += ( "/awstats-icon" => "' . makeCorrectDir($this->settings['system']['awstats_icons']) . '" )' . "\n";
				}
				else
				{
					$stats_text.= '  alias.url = ( "/webalizer/" => "'.makeCorrectFile($domain['customerroot'] . '/webalizer/' . $domain['parentdomain']).'/" )' . "\n";
				}
			}
		}
		else
		{
			if($domain['customerroot'] != $domain['documentroot'])
			{
				if($this->settings['system']['awstats_enabled'] == '1')
				{
					$stats_text.= '  alias.url = ( "/awstats/" => "'.makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['domain']).'" )' . "\n";
					$stats_text.= '  alias.url += ( "/awstats-icon" => "' . makeCorrectDir($this->settings['system']['awstats_icons']) . '" )' . "\n";
				} 
				else
				{
					$stats_text.= '  alias.url = ( "/webalizer/" => "'.makeCorrectFile($domain['customerroot'] . '/webalizer/').'" )' . "\n";
				}
			}
			// if the docroots are equal, we still have to set an alias for awstats
			// because the stats are in /awstats/[domain], not just /awstats/
			// also, the awstats-icons are someplace else too!
			// -> webalizer does not need this!
			elseif($this->settings['system']['awstats_enabled'] == '1')
			{
				$stats_text.= '  alias.url = ( "/awstats/" => "'.makeCorrectFile($domain['documentroot'] . '/awstats/' . $domain['domain']).'" )' . "\n";
				$stats_text.= '  alias.url += ( "/awstats-icon" => "' . makeCorrectDir($this->settings['system']['awstats_icons']) . '" )' . "\n";
			}
		}

		return $stats_text;
	}

	public function writeConfigs()
	{
		fwrite($this->debugHandler, '  lighttpd::writeConfigs: rebuilding ' . $this->settings['system']['apacheconf_vhost'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "rebuilding " . $this->settings['system']['apacheconf_vhost']);

		if(!isConfigDir($this->settings['system']['apacheconf_vhost']))
		{
			// Save one big file
			$vhosts_file = '';

			// sort by filename so the order is:
			// 1. subdomains
			// 2. subdomains as main-domains
			// 3. main-domains
			// #437
			ksort($this->lighttpd_data);

			foreach($this->lighttpd_data as $vhosts_filename => $vhost_content)
			{
				$vhosts_file.= $vhost_content . "\n\n";
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
				fwrite($this->debugHandler, '  lighttpd::writeConfigs: mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])) . "\n");
				$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])));
				safe_exec('mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])));
			}

			// Write a single file for every vhost

			foreach($this->lighttpd_data as $vhosts_filename => $vhosts_file)
			{
				$this->known_filenames[] = basename($vhosts_filename);

				// Apply header

				$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;

				if(!empty($vhosts_filename))
				{
					$vhosts_file_handler = fopen($vhosts_filename, 'w');
					fwrite($vhosts_file_handler, $vhosts_file);
					fclose($vhosts_file_handler);
				}
			}

			$this->wipeOutOldConfigs();
		}

		// Write the diroptions

		if(isConfigDir($this->settings['system']['apacheconf_htpasswddir']))
		{
			foreach($this->needed_htpasswds as $key => $data)
			{
				if(!is_dir($this->settings['system']['apacheconf_htpasswddir']))
				{
					mkdir(makeCorrectDir($this->settings['system']['apacheconf_htpasswddir']));
				}

				$filename = makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $key);
				$htpasswd_handler = fopen($filename, 'w');
				fwrite($htpasswd_handler, $data);
				fclose($htpasswd_handler);
			}
		}
	}

	protected function wipeOutOldConfigs()
	{
		fwrite($this->debugHandler, '  lighttpd::wipeOutOldConfigs: cleaning ' . $this->settings['system']['apacheconf_vhost'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "cleaning " . $this->settings['system']['apacheconf_vhost']);

		if(isConfigDir($this->settings['system']['apacheconf_vhost'], true))
		{
			$vhost_file_dirhandle = opendir($this->settings['system']['apacheconf_vhost']);

			while(false !== ($vhost_filename = readdir($vhost_file_dirhandle)))
			{
				if($vhost_filename != '.'
				&& $vhost_filename != '..'
				&& !in_array($vhost_filename, $this->known_filenames)
				&& preg_match('/^(05|10|20|21|22|30|50|51)_(froxlor|syscp)_(dirfix|ipandport|normal_vhost|wildcard_vhost|ssl_vhost)_(.+)\.conf$/', $vhost_filename)
				&& file_exists(makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/' . $vhost_filename)))
				{
					fwrite($this->debugHandler, '  lighttpd::wipeOutOldConfigs: unlinking ' . $vhost_filename . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'unlinking ' . $vhost_filename);
					unlink(makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/' . $vhost_filename));
				}
			}
		}
	}
}
