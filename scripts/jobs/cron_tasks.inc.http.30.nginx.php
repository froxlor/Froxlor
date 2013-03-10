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

if(@php_sapi_name() != 'cli'
&& @php_sapi_name() != 'cgi'
&& @php_sapi_name() != 'cgi-fcgi')
{
	die('This script only works in the shell.');
}

class nginx
{
	private $db = false;
	private $logger = false;
	private $debugHandler = false;
	private $idnaConvert = false;
	private $nginx_server = array();

	//	protected

	protected $settings = array();
	protected $nginx_data = array();
	protected $needed_htpasswds = array();
	protected $auth_backend_loaded = false;
	protected $htpasswds_data = array();
	protected $known_htpasswdsfilenames = array();
	protected $mod_accesslog_loaded = "0";
	protected $vhost_root_autoindex = false;
	protected $known_vhostfilenames = array();
	/**
	 * indicator whether a customer is deactivated or not
	 * if yes, only the webroot will be generated
	 *
	 * @var bool
	 */
	private $_deactivated = false;

	public function __construct($db, $logger, $debugHandler, $idnaConvert, $settings, $nginx_server=array())
	{
		$this->db = $db;
		$this->logger = $logger;
		$this->debugHandler = $debugHandler;
		$this->idnaConvert = $idnaConvert;
		$this->settings = $settings;
		$this->nginx_server = $nginx_server;
	}

	protected function getDB()
	{
		return $this->db;
	}

	public function reload()
	{
		fwrite($this->debugHandler, '   nginx::reload: reloading nginx' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading nginx');
		safe_exec($this->settings['system']['apachereload_command']);

		/**
		 * nginx does not auto-spawn fcgi-processes
		 */
		if ($this->settings['system']['phpreload_command'] != ''
			&& (int)$this->settings['phpfpm']['enabled'] == 0
		) {
		 	fwrite($this->debugHandler, '   nginx::reload: restarting php processes' . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'restarting php processes');
			safe_exec($this->settings['system']['phpreload_command']);
		}
		elseif((int)$this->settings['phpfpm']['enabled'] == 1)
		{
			fwrite($this->debugHandler, '   nginx::reload: reloading php-fpm' . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading php-fpm');
			safe_exec(escapeshellcmd($this->settings['phpfpm']['reload']));
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

			if(!isset($this->nginx_data[$vhosts_filename]))
			{
				$this->nginx_data[$vhosts_filename] = '';
			}
	
			if($this->settings['defaultwebsrverrhandler']['err401'] != '')
			{
				$this->nginx_data[$vhosts_filename].= 'error_page 401 ' . makeCorrectFile($this->settings['defaultwebsrverrhandler']['err401']) . ';' . "\n";
			}

			if($this->settings['defaultwebsrverrhandler']['err403'] != '')
			{
				$this->nginx_data[$vhosts_filename].= 'error_page 403 ' . makeCorrectFile($this->settings['defaultwebsrverrhandler']['err403']) . ';' . "\n";
			}

			if($this->settings['defaultwebsrverrhandler']['err404'] != '')
			{
				$this->nginx_data[$vhosts_filename].= 'error_page 404 ' . makeCorrectFile($this->settings['defaultwebsrverrhandler']['err404']) . ';' . "\n";
			}
			
			if($this->settings['defaultwebsrverrhandler']['err500'] != '')
			{
				$this->nginx_data[$vhosts_filename].= 'error_page 500 ' . makeCorrectFile($this->settings['defaultwebsrverrhandler']['err500']) . ';' . "\n";
			}

		}
	}
 	public function createVirtualHosts(){
	}
	public function createFileDirOptions(){
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
			}
			else
			{
				$ip = $row_ipsandports['ip'];
				$port = $row_ipsandports['port'];
			}

			fwrite($this->debugHandler, '  nginx::createIpPort: creating ip/port settings for  ' . $ip . ":" . $port . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'creating ip/port settings for  ' . $ip . ":" . $port);
			$vhost_filename = makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/10_froxlor_ipandport_' . trim(str_replace(':', '.', $row_ipsandports['ip']), '.') . '.' . $row_ipsandports['port'] . '.conf');

			if(!isset($this->nginx_data[$vhost_filename]))
			{
				$this->nginx_data[$vhost_filename] = '';
			}

			$this->nginx_data[$vhost_filename].= 'server { ' . "\n";

			/**
			 * this HAS to be set for the default host in nginx or else no vhost will work
			 */
			$this->nginx_data[$vhost_filename].= "\t". 'listen    ' . $ip . ':' . $port . ' default;' . "\n";

			if($row_ipsandports['vhostcontainer'] == '1')
			{
				$this->nginx_data[$vhost_filename].= "\t".'# Froxlor default vhost' . "\n";
				$this->nginx_data[$vhost_filename].= "\t".'server_name    ' . $this->settings['system']['hostname'] . ';' . "\n";
			}

			$this->nginx_data[$vhost_filename].= "\t".'access_log      /var/log/nginx/access.log;' . "\n";

			$mypath = '';
			if($row_ipsandports['vhostcontainer'] == '1')
			{
				$mypath = makeCorrectDir(dirname(dirname(dirname(__FILE__))));
				$this->nginx_data[$vhost_filename].= "\t".'root     '.$mypath.';'."\n";
				$this->nginx_data[$vhost_filename].= "\t".'location / {'."\n";
				$this->nginx_data[$vhost_filename].= "\t\t".'index    index.php index.html index.htm;'."\n";
				$this->nginx_data[$vhost_filename].= "\t".'}'."\n";

				if($row_ipsandports['specialsettings'] != '')
				{
					$this->nginx_data[$vhost_filename].= $row_ipsandports['specialsettings'] . "\n";
				}
			}
				
			/**
			 * SSL config options
			 */
			if($row_ipsandports['ssl'] == '1')
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
					$this->nginx_data[$vhost_filename].= "\t" . 'ssl on;' . "\n";
					$this->nginx_data[$vhost_filename].= "\t" . 'ssl_certificate ' . makeCorrectFile($row_ipsandports['ssl_cert_file']) . ';' . "\n";
					$this->nginx_data[$vhost_filename].= "\t" . 'ssl_certificate_key ' .makeCorrectFile($row_ipsandports['ssl_key_file']) . ';' .  "\n";
						
					if($row_ipsandports['ssl_ca_file'] != '')
					{
						$this->nginx_data[$vhost_filename].= 'ssl_client_certificate ' . makeCorrectFile($row_ipsandports['ssl_ca_file']) . ';' . "\n";
					}
				}
			}
			
			$this->nginx_data[$vhost_filename].= "\t".'location ~ \.php$ {'."\n";
			$this->nginx_data[$vhost_filename].= "\t\t".' if (!-f $request_filename) {'."\n";
			$this->nginx_data[$vhost_filename].= "\t\t\t".'return 404;'."\n";
			$this->nginx_data[$vhost_filename].= "\t\t".'}'."\n";
			$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_index index.php;'."\n";
			$this->nginx_data[$vhost_filename].= "\t\t".'include '.$this->settings['nginx']['fastcgiparams'].';'."\n";
			$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;'."\n";
			if ($row_ipsandports['ssl'] == '1') {
				$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_param HTTPS on;'."\n";
			}
			if((int)$this->settings['phpfpm']['enabled'] == 1
				&& (int)$this->settings['phpfpm']['enabled_ownvhost'] == 1
			) {
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
				$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_pass unix:' . $php->getInterface()->getSocketFile() . ';' . "\n";
			}
			else
			{
				$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_pass ' . $this->settings['system']['nginx_php_backend'] . ';' . "\n";
			}
			$this->nginx_data[$vhost_filename].= "\t".'}'."\n";

			$this->nginx_data[$vhost_filename].= '}' . "\n\n";
			// End of Froxlor server{}-part

			$this->createNginxHosts($row_ipsandports['ip'], $row_ipsandports['port'], $row_ipsandports['ssl'], $vhost_filename);
		}
		
		/**
		 * standard error pages
		 */
		$this->_createStandardErrorHandler();
	}

	protected function createNginxHosts($ip, $port, $ssl, $vhost_filename)
	{
		$query = "SELECT * FROM " . TABLE_PANEL_IPSANDPORTS . " WHERE `ip`='" . $ip . "' AND `port`='" . $port . "'";
		$ipandport = $this->db->query_first($query);

		if($ssl == '0')
		{
			$query2 = "SELECT `d`.*, `pd`.`domain` AS `parentdomain`, `c`.`loginname`, `c`.`guid`, `c`.`email`, `c`.`documentroot` AS `customerroot`, `c`.`deactivated`, `c`.`phpenabled` AS `phpenabled` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`) LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `pd` ON (`pd`.`id` = `d`.`parentdomainid`) WHERE `d`.`ipandport`='" . $ipandport['id'] . "' AND `d`.`aliasdomain` IS NULL AND `d`.`email_only` <> 1 ORDER BY `d`.`iswildcarddomain`, `d`.`domain` ASC";
		}
		else
		{
			$query2 = "SELECT `d`.*, `pd`.`domain` AS `parentdomain`, `c`.`loginname`, `c`.`guid`, `c`.`email`, `c`.`documentroot` AS `customerroot`, `c`.`deactivated`, `c`.`phpenabled` AS `phpenabled` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`) LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `pd` ON (`pd`.`id` = `d`.`parentdomainid`) WHERE `d`.`ssl_ipandport`='" . $ipandport['id'] . "' AND `d`.`aliasdomain` IS NULL AND `d`.`email_only` <> 1 ORDER BY `d`.`iswildcarddomain`, `d`.`domain` ASC";
		}

		$included_vhosts = array();
		$result_domains = $this->db->query($query2);
		while($domain = $this->db->fetch_array($result_domains))
		{
			if (is_dir($this->settings['system']['apacheconf_vhost']))
			{
				safe_exec('mkdir -p '.escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])));
				$vhost_filename = $this->getVhostFilename($domain);
			}

			if(!isset($this->nginx_data[$vhost_filename]))
			{
				$this->nginx_data[$vhost_filename] = '';
			}

			$query = "SELECT * FROM " . TABLE_PANEL_IPSANDPORTS . " WHERE `id`='" . $domain['ipandport'] . "'";
			$ipandport = $this->db->query_first($query);
			$domain['ip'] = $ipandport['ip'];
			$domain['port'] = $ipandport['port'];
			$domain['ssl_cert_file'] = $ipandport['ssl_cert_file'];

			if( (!empty($this->nginx_data[$vhost_filename]) && !is_dir($this->settings['system']['apacheconf_vhost']))
			|| is_dir($this->settings['system']['apacheconf_vhost']))
			{
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

				$this->nginx_data[$vhost_filename].= $this->getVhostContent($domain, $ssl_vhost);
				$this->nginx_data[$vhost_filename].= isset($this->needed_htpasswds[$domain[$ips_and_ports_index]]) ? $this->needed_htpasswds[$domain[$ips_and_ports_index]] . "\n" : '';
			}
		}
	}

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

		if(filter_var($domain['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
		{
			$ipport = '[' . $domain['ip'] . ']:' . $domain['port'];
		}
		else
		{
			$ipport = $domain['ip'] . ':' . $domain['port'];
		}

		$vhost_content = '';
		$vhost_content.= 'server { ' . "\n";
		$vhost_content.= "\t" . 'listen ' . $ipport . ';' . "\n";

		$vhost_content.= $this->getServerNames($domain);

		// respect ssl_redirect settings, #542
		if($ssl_vhost == false
			&& $domain['ssl'] == '1'
			&& $domain['ssl_redirect'] == '1'
		) {
			$domain['documentroot'] = 'https://' . $domain['domain'] . '/';
		}

		if(preg_match('/^https?\:\/\//', $domain['documentroot']))
		{
			$vhost_content.= "\t".'rewrite ^(.*) '.$this->idnaConvert->encode($domain['documentroot']).'$1 permanent;'."\n";
		}
		else
		{
			mkDirWithCorrectOwnership($domain['customerroot'], $domain['documentroot'], $domain['guid'], $domain['guid'], true);

			$vhost_content.= $this->getLogFiles($domain);
			$vhost_content.= $this->getWebroot($domain, $ssl_vhost);
			
			if ($this->_deactivated == false) {
				$vhost_content.= $this->create_pathOptions($domain);
				$vhost_content.= $this->composePhpOptions($domain, $ssl_vhost);

				$l_regex1="/(location\ \/\ \{)(.*)(\})/smU";
				$l_regex2="/(location\ \/\ \{.*\})/smU";
				$replace_by="";
				$replacements=preg_match_all($l_regex1,$vhost_content,$out);
				if ($replacements>1){
					foreach ($out[2] as $val) {
						$replace_by.=$val."\n";
					}
					$vhost_content=preg_replace($l_regex2,"",$vhost_content,$replacements-1);
					$vhost_content=preg_replace($l_regex2,"location / {"."\n\t\t". $replace_by ."\t}"."\n",$vhost_content);
				}
				
				if ($domain['specialsettings'] != "") {
					$vhost_content.= $domain['specialsettings'] . "\n";
				}
			}
		}
		$vhost_content.= '}' . "\n\n";

		return $vhost_content;
	}

	protected function create_pathOptions($domain) {
		$has_location = false;

		$query = "SELECT * FROM " . TABLE_PANEL_HTACCESS . " WHERE `path` LIKE '" . $domain['documentroot'] . "%'";
		$result = $this->db->query($query);

		$path_options = '';
		$htpasswds = $this->getHtpasswds($domain);

		// for each entry in the htaccess table
		while ($row = $this->db->fetch_array($result)) {

			if (!empty($row['error404path'])) {
				$path_options.= "\t".'error_page   404    ' . makeCorrectFile($row['error404path']) . ';' . "\n";
			}

			if (!empty($row['error403path'])) {
				$path_options.= "\t".'error_page   403    ' . makeCorrectFile($row['error403path']) . ';' . "\n";
			}

			if (!empty($row['error500path'])) {
				$path_options.= "\t".'error_page   502 503 504    ' . makeCorrectFile($row['error500path']) . ';' . "\n";
			}

//			if($row['options_indexes'] != '0')
//			{
				$path = makeCorrectDir(substr($row['path'], strlen($domain['documentroot']) - 1));

				mkDirWithCorrectOwnership($domain['documentroot'], $row['path'], $domain['guid'], $domain['guid']);

				$path_options.= "\t".'# '.$path."\n";
				if ($path == '/') {
					$this->vhost_root_autoindex = true;
					$path_options.= "\t".'location ' . $path . ' {' . "\n";
					if($this->vhost_root_autoindex) {
						$path_options.= "\t\t" . 'autoindex  on;' . "\n";
						$this->vhost_root_autoindex = false;
					}
					$path_options.= "\t\t" . 'index    index.php index.html index.htm;'."\n";
//					$path_options.= "\t\t" . 'try_files $uri $uri/ @rewrites;'."\n";
					// check if we have a htpasswd for this path
					// (damn nginx does not like more than one
					// 'location'-part with the same path)
					if(count($htpasswds) > 0)
					{
						foreach($htpasswds as $idx => $single)
						{
							switch($single['path']){
								case '/awstats/':
								case '/webalizer/':
									// no stats-alias in "location /"-context
									break;
								default:
									if ($single['path']=='/'){
										$path_options.= "\t\t" . 'auth_basic            "Restricted Area";' . "\n";
										$path_options.= "\t\t" . 'auth_basic_user_file  ' . makeCorrectFile($single['usrf']) . ';'."\n";
										// remove already used entries so we do not have doubles
										unset($htpasswds[$idx]);
									}
							}
						}
					}
					$path_options.= "\t".'}' . "\n";

					$this->vhost_root_autoindex = false;
				}
				 else
				{
					$path_options.= "\t".'location ' . $path . ' {' . "\n";
					if($this->vhost_root_autoindex) {
						$path_options.= "\t\t" . 'autoindex  on;' . "\n";
						$this->vhost_root_autoindex = false;
					}
					$path_options.= "\t\t" . 'index    index.php index.html index.htm;'."\n";
					$path_options.= "\t".'} ' . "\n";
				}
//			}
			
			/**
			 * Perl support
			 * required the fastCGI wrapper to be running to receive the CGI requests.
			 */
			if(customerHasPerlEnabled($domain['customerid'])
			&& $row['options_cgi'] != '0')
			{
				$path = makeCorrectDir(substr($row['path'], strlen($domain['documentroot']) - 1));
				mkDirWithCorrectOwnership($domain['documentroot'], $row['path'], $domain['guid'], $domain['guid']);

				// We need to remove the last slash, otherwise the regex wouldn't work
				if($row['path'] != $domain['documentroot']) {
					$path = substr($path, 0, -1);
				}
				$path_options.= "\t" . 'location ~ \(.pl|.cgi)$ {' . "\n";
				$path_options.= "\t\t" . 'gzip off; #gzip makes scripts feel slower since they have to complete before getting gzipped' . "\n";
	    		$path_options.= "\t\t" . 'fastcgi_pass  '. $this->settings['system']['perl_server'] . ';' . "\n";
   				$path_options.= "\t\t" . 'fastcgi_index index.cgi;' . "\n";
				$path_options.= "\t\t" . 'include '.$this->settings['nginx']['fastcgiparams'].';'."\n";
				$path_options.= "\t" . '}' . "\n";
			}
			
		}

		/*
		 * now the rest of the htpasswds
		 */
		if(count($htpasswds) > 0)
		{
			foreach($htpasswds as $idx => $single)
			{
				//if($single['path'] != "/")
				//{
					switch($single['path'])
					{
						case '/awstats/':
						case '/webalizer/':
							$path_options.= $this->getStats($domain,$single);
							unset($htpasswds[$idx]);
						break;
						default:
							$path_options.= "\t" . 'location ' . makeCorrectDir($single['path']) . ' {' . "\n";
							$path_options.= "\t\t" . 'auth_basic            "Restricted Area";' . "\n";
							$path_options.= "\t\t" . 'auth_basic_user_file  ' . makeCorrectFile($single['usrf']) . ';'."\n";
							$path_options.= "\t".'}' . "\n";
					}
				//}
				unset($htpasswds[$idx]);
			}
		}

		return $path_options;
	}

	protected function getHtpasswds($domain) {

		$query = 'SELECT DISTINCT *
			FROM ' . TABLE_PANEL_HTPASSWDS . ' AS a
			JOIN ' . TABLE_PANEL_DOMAINS . ' AS b
			USING (`customerid`)
			WHERE b.customerid=' . $domain['customerid'] . ' AND b.domain="' . $domain['domain'] . '";';

		$result = $this->db->query($query);

		$returnval = array();
		$x = 0;
		while ($row_htpasswds = $this->db->fetch_array($result)) {

			if (count($row_htpasswds) > 0) {
				$htpasswd_filename = makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $row_htpasswds['customerid'] . '-' . md5($row_htpasswds['path']) . '.htpasswd');

				// ensure we can write to the array with index $htpasswd_filename
				if (!isset($this->htpasswds_data[$htpasswd_filename])) {
					$this->htpasswds_data[$htpasswd_filename] = '';
				}

				$this->htpasswds_data[$htpasswd_filename].= $row_htpasswds['username'] . ':' . $row_htpasswds['password'] . "\n";

				// if the domains and their web contents are located in a subdirectory of
				// the nginx user, we have to evaluate the right path which is to protect
				if (stripos($row_htpasswds['path'], $domain['documentroot']) !== false ) {
					// if the website contents is located in the user directory
					$path = makeCorrectDir(substr($row_htpasswds['path'], strlen($domain['documentroot']) - 1));
				} else {
					// if the website contents is located in a subdirectory of the user
					preg_match('/^([\/[:print:]]*\/)([[:print:]\/]+){1}$/i', $row_htpasswds['path'], $matches);
					$path = makeCorrectDir(substr($row_htpasswds['path'], strlen($matches[1]) - 1));
				}

				$returnval[$x]['path'] = $path;
				$returnval[$x]['root'] = makeCorrectDir($domain['documentroot']);
				$returnval[$x]['usrf'] = $htpasswd_filename;
				$x++;
			}
		}
		return $returnval;
	}

	protected function composePhpOptions($domain, $ssl_vhost = false)
	{
		$phpopts = '';
		if($domain['phpenabled'] == '1')
		{
			$phpopts = "\t".'location ~ \.php$ {'."\n";
			$phpopts.= "\t\t".'try_files $uri =404;'."\n";
			$phpopts.= "\t\t".'fastcgi_split_path_info ^(.+\.php)(/.+)$;'."\n";
			$phpopts.= "\t\t".'fastcgi_index index.php;'."\n";
			$phpopts.= "\t\t".'fastcgi_pass ' . $this->settings['system']['nginx_php_backend'] . ';' . "\n";
			$phpopts.= "\t\t".'fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;'."\n";
			$phpopts.= "\t\t".'include '.$this->settings['nginx']['fastcgiparams'].';'."\n";
			if ($domain['ssl'] == '1' && $ssl_vhost) {
				$phpopts.= "\t\t".'fastcgi_param HTTPS on;'."\n";
			}
			$phpopts.= "\t".'}'."\n";
		}
		return $phpopts;
	}

	protected function getWebroot($domain, $ssl)
	{
		$webroot_text = '';

		if($domain['deactivated'] == '1'
		&& $this->settings['system']['deactivateddocroot'] != '')
		{
			$webroot_text.= "\t".'# Using docroot for deactivated users...' . "\n";
			$webroot_text.= "\t".'root     '.makeCorrectDir($this->settings['system']['deactivateddocroot']).';'."\n";
			$this->_deactivated = true;
		}
		else
		{
			$webroot_text.= "\t".'root     '.makeCorrectDir($domain['documentroot']).';'."\n";
			$this->_deactivated = false;
		}

		$webroot_text.= "\n\t".'location / {'."\n";
		$webroot_text.= "\t\t".'index    index.php index.html index.htm;'."\n";
		$webroot_text.= "\t\t" . 'try_files $uri $uri/ @rewrites;'."\n";

		if($this->vhost_root_autoindex) {
			$webroot_text.= "\t\t".'autoindex on;'."\n";
			$this->vhost_root_autoindex = false;
		}

		$webroot_text.= "\t".'}'."\n\n";
		$webroot_text.= "\tlocation @rewrites {\n";
		$webroot_text.= "\t\trewrite ^ /index.php last;\n";
		$webroot_text.= "\t}\n\n";

		return $webroot_text;
	}

	protected function getStats($domain, $single) {

		$stats_text = '';

		// define basic path to the stats
		if ($this->settings['system']['awstats_enabled'] == '1') {
			$alias_dir = makeCorrectFile($domain['customerroot'] . '/awstats/');
		} else {
			$alias_dir = makeCorrectFile($domain['customerroot'] . '/webalizer/');
		}

		// if this is a parentdomain, we use this domain-name
		if ($domain['parentdomainid'] == '0') {
			$alias_dir = makeCorrectDir($alias_dir.'/'.$domain['domain']);
		} else {
			$alias_dir = makeCorrectDir($alias_dir.'/'.$domain['parentdomain']);
		}

		if ($this->settings['system']['awstats_enabled'] == '1') {
			// awstats
			$stats_text.= "\t" . 'location /awstats {' . "\n";
		} else {
			// webalizer
			$stats_text.= "\t" . 'location /webalizer {' . "\n";
		}

		$stats_text.= "\t\t" . 'alias ' . $alias_dir . ';' . "\n";
		$stats_text.= "\t\t" . 'auth_basic            "Restricted Area";' . "\n";
		$stats_text.= "\t\t" . 'auth_basic_user_file  ' . makeCorrectFile($single['usrf']) . ';'."\n";
		$stats_text.= "\t" . '}' . "\n\n";

		return $stats_text;
	}

	/**
	 * @TODO mod_log_sql
	 */
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

		$logfiles_text.= "\t".'access_log    ' . $access_log . ' combined;' . "\n";
		$logfiles_text.= "\t".'error_log    ' . $error_log . ' error;' . "\n";

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

	public function createOwnVhostStarter()
	{
	}

	protected function getServerNames($domain)
	{
		$server_alias = '';

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

		$servernames_text = "\t".'server_name    '.$domain['domain'];
		if(trim($server_alias) != '')
		{
			$servernames_text.=  ' '.$server_alias;
		}
		$servernames_text.= ';' . "\n";

		return $servernames_text;
	}

	public function writeConfigs()
	{
		fwrite($this->debugHandler, '  nginx::writeConfigs: rebuilding ' . $this->settings['system']['apacheconf_vhost'] . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "rebuilding " . $this->settings['system']['apacheconf_vhost']);

		if(!isConfigDir($this->settings['system']['apacheconf_vhost']))
		{
			// Save one big file
			$vhosts_file = '';
				
			// sort by filename so the order is:
			// 1. subdomains
			// 2. subdomains as main-domains
			// 3. main-domains
			ksort($this->nginx_data);
				
			foreach($this->nginx_data as $vhosts_filename => $vhost_content)
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
				fwrite($this->debugHandler, '  nginx::writeConfigs: mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])) . "\n");
				$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])));
				safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir($this->settings['system']['apacheconf_vhost'])));
			}

			// Write a single file for every vhost

			foreach($this->nginx_data as $vhosts_filename => $vhosts_file)
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
				
			$this->wipeOutOldVhostConfigs();
				
		}

		/*
		 * htaccess stuff
		 */
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
	}

	protected function wipeOutOldVhostConfigs()
	{
		fwrite($this->debugHandler, '  nginx::wipeOutOldVhostConfigs: cleaning ' . $this->settings['system']['apacheconf_vhost'] . "\n");
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
					fwrite($this->debugHandler, '  nginx::wipeOutOldVhostConfigs: unlinking ' . $vhost_filename . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'unlinking ' . $vhost_filename);
					unlink(makeCorrectFile($this->settings['system']['apacheconf_vhost'] . '/' . $vhost_filename));
				}
			}
		}
	}

	/*
	 *	We remove old htpasswd config files
	 */
	protected function wipeOutOldHtpasswdConfigs()
	{
		fwrite($this->debugHandler, '  nginx::wipeOutOldHtpasswdConfigs: cleaning ' . $this->settings['system']['apacheconf_htpasswddir'] . "\n");
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
					fwrite($this->debugHandler, '  nginx::wipeOutOldHtpasswdConfigs: unlinking ' . $htpasswd_filename . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'unlinking ' . $htpasswd_filename);
					unlink(makeCorrectFile($this->settings['system']['apacheconf_htpasswddir'] . '/' . $htpasswd_filename));
				}
			}
		}
	}
}
