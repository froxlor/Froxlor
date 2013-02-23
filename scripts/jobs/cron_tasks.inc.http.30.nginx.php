<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright		(c) the authors
 * @author			Froxlor team <team@froxlor.org> (2010-)
 * @contributor	byteworkshosting <info@byteworkshosting.net>
 * @license			GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @date				2013-02-16
 * @package			Cron
 *
 **/


if ( @php_sapi_name() != 'cli'
		 && @php_sapi_name() != 'cgi'
		 && @php_sapi_name() != 'cgi-fcgi' ) {

	exit('This script only works in the shell.');

}


class nginx {


	# private
	private $db = false;
	private $logger = false;
	private $debugHandler = false;
	private $idnaConvert = false;
	private $nginx_server = array();

	# protected
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


	public function __construct( $db, $logger, $debugHandler, $idnaConvert, $settings, $nginx_server=array(), $known_vhostfilenames=array() )
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


	/**
	 * TODO
	 * this is a ugly workaround for replacing hardcoded path to nginx (fixes # )
	 * there should be a place in mysql table `panel_settings` for this
	 *
	 * @brief determines the path of nginx (has different paths depending on OS)
	 *				for including file fastcgi_params on right place
	 *				while creating vhost-files
	 *
	 * @return (string) $this->settings['nginx_dir']
	 **/
	public function _pathOfNginx() {

		$os = safe_exec('uname -s');

		switch ( $os[0] ) {

			case 'Linux': (string) $this->settings['nginx_dir'] = '/etc/nginx'; break;
			case 'FreeBSD': (string) $this->settings['nginx_dir'] = '/usr/local/etc/nginx'; break;
			default: (string) $this->settings['nginx_dir'] = '/etc/nginx'; break;

		}

		return $this->settings['nginx_dir'];

	}


	public function reload()
	{
		fwrite( $this->debugHandler, '   nginx::reload: reloading nginx' . "\n" );
		$this->logger->logAction( CRON_ACTION, LOG_INFO, 'reloading nginx' );
		safe_exec( $this->settings['system']['apachereload_command'] );

		/**
		 * nginx does not auto-spawn fcgi-processes
		 */
		if ( $this->settings['system']['phpreload_command'] != ''
			&& (int) $this->settings['phpfpm']['enabled'] == 0
		 ) {
		 	fwrite( $this->debugHandler, '   nginx::reload: restarting php processes' . "\n" );
			$this->logger->logAction( CRON_ACTION, LOG_INFO, 'restarting php processes' );
			safe_exec( $this->settings['system']['phpreload_command'] );
		}
		elseif ( (int) $this->settings['phpfpm']['enabled'] == 1 )
		{
			fwrite( $this->debugHandler, '   nginx::reload: reloading php-fpm' . "\n" );
			$this->logger->logAction( CRON_ACTION, LOG_INFO, 'reloading php-fpm' );
			safe_exec( escapeshellcmd($this->settings['phpfpm']['reload']) );
		}
	}


	/**
	 * define a default ErrorDocument-statement, bug #unknown-yet
	 */
	private function _createStandardErrorHandler()
	{
		if ( $this->settings['defaultwebsrverrhandler']['enabled'] == '1'
			&& ( $this->settings['defaultwebsrverrhandler']['err401'] != ''
			|| $this->settings['defaultwebsrverrhandler']['err403'] != ''
			|| $this->settings['defaultwebsrverrhandler']['err404'] != ''
			|| $this->settings['defaultwebsrverrhandler']['err500'] != '' )
		 ) {
			$vhosts_folder = '';
			if ( is_dir($this->settings['system']['apacheconf_vhost']) )
			{
				$vhosts_folder = makeCorrectDir( $this->settings['system']['apacheconf_vhost'] );
			} else {
				$vhosts_folder = makeCorrectDir( dirname($this->settings['system']['apacheconf_vhost']) );
			}

			$vhosts_filename = makeCorrectFile( $vhosts_folder . '/05_froxlor_default_errorhandler.conf' );

			if ( !isset( $this->nginx_data[$vhosts_filename] ) )
			{
				$this->nginx_data[$vhosts_filename] = '';
			}

			if ( $this->settings['defaultwebsrverrhandler']['err401'] != '' )
			{
				$this->nginx_data[$vhosts_filename].= 'error_page 401 ' . $this->settings['defaultwebsrverrhandler']['err401'] . ';' . PHP_EOL;
			}

			if ( $this->settings['defaultwebsrverrhandler']['err403'] != '' )
			{
				$this->nginx_data[$vhosts_filename].= 'error_page 403 ' . $this->settings['defaultwebsrverrhandler']['err403'] . ';' . PHP_EOL;
			}

			if ( $this->settings['defaultwebsrverrhandler']['err404'] != '' )
			{
				$this->nginx_data[$vhosts_filename].= 'error_page 404 ' . $this->settings['defaultwebsrverrhandler']['err404'] . ';' . PHP_EOL;
			}

			if ( $this->settings['defaultwebsrverrhandler']['err500'] != '' )
			{
				$this->nginx_data[$vhosts_filename].= 'error_page 500 ' . $this->settings['defaultwebsrverrhandler']['err500'] . ';' . PHP_EOL;
			}

		}
	}


 	public function createVirtualHosts() {
	}


	public function createFileDirOptions() {
	}


	public function createIpPort()
	{
		$query = "SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `ip` ASC, `port` ASC";
		$result_ipsandports = $this->db->query($query);

		while( $row_ipsandports = $this->db->fetch_array($result_ipsandports) )
		{
			if ( filter_var($row_ipsandports['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) )
			{
				$ip = '[' . $row_ipsandports['ip'] . ']';
				$port = $row_ipsandports['port'];
			}
			else
			{
				$ip = $row_ipsandports['ip'];
				$port = $row_ipsandports['port'];
			}

			fwrite( $this->debugHandler, '  nginx::createIpPort: creating ip/port settings for  ' . $ip . ":" . $port . "\n" );
			$this->logger->logAction( CRON_ACTION, LOG_INFO, 'creating ip/port settings for  ' . $ip . ":" . $port );
			$vhost_filename = makeCorrectFile( $this->settings['system']['apacheconf_vhost'] . '/10_froxlor_ipandport_' . trim(str_replace(':', '.', $row_ipsandports['ip']), '.') . '.' . $row_ipsandports['port'] . '.conf' );

			if ( !isset($this->nginx_data[$vhost_filename]) )
			{
				$this->nginx_data[$vhost_filename] = '';
			}

			$this->nginx_data[$vhost_filename].= 'server {' . PHP_EOL . PHP_EOL;

			/**
			 * this HAS to be set for the default host in nginx or else no vhost will work
			 */
			$this->nginx_data[$vhost_filename].= "\t". 'listen'. "\t\t" . $ip . ':' . $port . ' default;' . PHP_EOL;

			if ( $row_ipsandports['vhostcontainer'] == '1' )
			{
				$this->nginx_data[$vhost_filename].= "\t".'# Froxlor default vhost' . PHP_EOL;
				$this->nginx_data[$vhost_filename].= "\t".'server_name' . "\t" . $this->settings['system']['hostname'] . ';' . PHP_EOL;
			}

			$this->nginx_data[$vhost_filename].= "\t".'access_log' . "\t" . '/var/log/nginx/access.log;' . PHP_EOL;

			$mypath = '';
			if ( $row_ipsandports['vhostcontainer'] == '1' )
			{
				$mypath = makeCorrectDir( dirname(dirname(dirname(__FILE__))) );
				$this->nginx_data[$vhost_filename].= "\t" . 'root'. "\t" . $mypath .';' . PHP_EOL . PHP_EOL;
				$this->nginx_data[$vhost_filename].= "\t" . 'location / {' . PHP_EOL;
				$this->nginx_data[$vhost_filename].= "\t\t" . 'index'. "\t" .'index.php index.html index.htm;' . PHP_EOL;
				$this->nginx_data[$vhost_filename].= "\t" . '}' . PHP_EOL . PHP_EOL;

				if ( $row_ipsandports['specialsettings'] != '' )
				{
					$this->nginx_data[$vhost_filename].= $row_ipsandports['specialsettings'] . PHP_EOL;
				}
			}

			/**
			 * SSL config options
			 */
			if ( $row_ipsandports['ssl'] == '1' )
			{
				if ( $row_ipsandports['ssl_cert_file'] == '' )
				{
					$row_ipsandports['ssl_cert_file'] = $this->settings['system']['ssl_cert_file'];
				}

				if ( $row_ipsandports['ssl_key_file'] == '' )
				{
					$row_ipsandports['ssl_key_file'] = $this->settings['system']['ssl_key_file'];
				}

				if ( $row_ipsandports['ssl_ca_file'] == '' )
				{
					$row_ipsandports['ssl_ca_file'] = $this->settings['system']['ssl_ca_file'];
				}

				if ( $row_ipsandports['ssl_cert_file'] != '' )
				{
					$this->nginx_data[$vhost_filename].= "\t" . 'ssl on;' . PHP_EOL;
					$this->nginx_data[$vhost_filename].= "\t" . 'ssl_certificate ' . makeCorrectFile( $row_ipsandports['ssl_cert_file'] ) . ';' . PHP_EOL;
					$this->nginx_data[$vhost_filename].= "\t" . 'ssl_certificate_key ' .makeCorrectFile( $row_ipsandports['ssl_key_file'] ) . ';' .  "\n";

					if ( $row_ipsandports['ssl_ca_file'] != '' )
					{
						$this->nginx_data[$vhost_filename].= 'ssl_client_certificate ' . makeCorrectFile( $row_ipsandports['ssl_ca_file'] ) . ';' . PHP_EOL;
					}
				}
			}

			$this->nginx_data[$vhost_filename].= "\t".'location ~ \.php$ {' . PHP_EOL;
			$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_index index.php;' . PHP_EOL;
			$this->nginx_data[$vhost_filename] .= "\t\t" . 'include ' . $this->_pathOfNginx() . '/fastcgi_params;' . PHP_EOL;
			$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;' . PHP_EOL;
			if ( $row_ipsandports['ssl'] == '1' ) {
				$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_param HTTPS on;' . PHP_EOL;
			}
			if ( (int) $this->settings['phpfpm']['enabled'] == 1
				&& (int) $this->settings['phpfpm']['enabled_ownvhost'] == 1
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

				$php = new phpinterface( $this->getDB(), $this->settings, $domain );
				$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_pass unix:' . $php->getInterface()->getSocketFile() . ';' . PHP_EOL;
			}
			else
			{
				$this->nginx_data[$vhost_filename].= "\t\t".'fastcgi_pass ' . $this->settings['system']['nginx_php_backend'] . ';' . PHP_EOL;
			}
			$this->nginx_data[$vhost_filename].= "\t".'}' . PHP_EOL;

			$this->nginx_data[$vhost_filename].= '}' . PHP_EOL . PHP_EOL;
			// End of Froxlor server{}-part

			$this->createNginxHosts( $row_ipsandports['ip'], $row_ipsandports['port'], $row_ipsandports['ssl'], $vhost_filename );
		}

		/**
		 * standard error pages
		 */
		$this->_createStandardErrorHandler();
	}


	protected function createNginxHosts( $ip, $port, $ssl, $vhost_filename )
	{
		$query = "SELECT * FROM " . TABLE_PANEL_IPSANDPORTS . " WHERE `ip`='" . $ip . "' AND `port`='" . $port . "'";
		$ipandport = $this->db->query_first($query);

		if ( $ssl == '0' )
		{
			$query2 = "SELECT `d`.*, `pd`.`domain` AS `parentdomain`, `c`.`loginname`, `c`.`guid`, `c`.`email`, `c`.`documentroot` AS `customerroot`, `c`.`deactivated`, `c`.`phpenabled` AS `phpenabled` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`) LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `pd` ON (`pd`.`id` = `d`.`parentdomainid`) WHERE `d`.`ipandport`='" . $ipandport['id'] . "' AND `d`.`aliasdomain` IS NULL AND `d`.`email_only` <> 1 ORDER BY `d`.`iswildcarddomain`, `d`.`domain` ASC";
		}
		else
		{
			$query2 = "SELECT `d`.*, `pd`.`domain` AS `parentdomain`, `c`.`loginname`, `c`.`guid`, `c`.`email`, `c`.`documentroot` AS `customerroot`, `c`.`deactivated`, `c`.`phpenabled` AS `phpenabled` FROM `" . TABLE_PANEL_DOMAINS . "` `d` LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING(`customerid`) LEFT JOIN `" . TABLE_PANEL_DOMAINS . "` `pd` ON (`pd`.`id` = `d`.`parentdomainid`) WHERE `d`.`ssl_ipandport`='" . $ipandport['id'] . "' AND `d`.`aliasdomain` IS NULL AND `d`.`email_only` <> 1 ORDER BY `d`.`iswildcarddomain`, `d`.`domain` ASC";
		}

		$included_vhosts = array();
		$result_domains = $this->db->query($query2);
		while( $domain = $this->db->fetch_array($result_domains) )
		{
			if ( is_dir( $this->settings['system']['apacheconf_vhost'] ) )
			{
				safe_exec( 'mkdir -p '.escapeshellarg( makeCorrectDir( $this->settings['system']['apacheconf_vhost'] ) ) );
				$vhost_filename = $this->getVhostFilename( $domain );
			}

			if ( !isset( $this->nginx_data[$vhost_filename] ) )
			{
				$this->nginx_data[$vhost_filename] = '';
			}

			$query = "SELECT * FROM " . TABLE_PANEL_IPSANDPORTS . " WHERE `id`='" . $domain['ipandport'] . "'";
			$ipandport = $this->db->query_first($query);
			$domain['ip'] = $ipandport['ip'];
			$domain['port'] = $ipandport['port'];
			$domain['ssl_cert_file'] = $ipandport['ssl_cert_file'];

			if ( (!empty( $this->nginx_data[$vhost_filename]) && !is_dir($this->settings['system']['apacheconf_vhost']) )
						|| is_dir($this->settings['system']['apacheconf_vhost']) )
			{
				if ( $ssl == '1' )
				{
					$ssl_vhost = true;
					$ips_and_ports_index = 'ssl_ipandport';
				}
				else
				{
					$ssl_vhost = false;
					$ips_and_ports_index = 'ipandport';
				}

				$this->nginx_data[$vhost_filename] .= $this->getVhostContent( $domain, $ssl_vhost );
				$this->nginx_data[$vhost_filename] .= isset($this->needed_htpasswds[$domain[$ips_and_ports_index]]) ? $this->needed_htpasswds[$domain[$ips_and_ports_index]] . PHP_EOL : null;
			}
		}
	}


	protected function getVhostFilename( $domain, $ssl_vhost = false )
	{
		if ( (int) $domain['parentdomainid'] == 0
		&& isCustomerStdSubdomain( (int) $domain['id'] ) == false
		&& ( (int) $domain['ismainbutsubto'] == 0
		|| domainMainToSubExists( $domain['ismainbutsubto'] ) == false )
		 ) {
			$vhost_no = '22';
		}
		elseif ( (int) $domain['parentdomainid'] == 0
		&& isCustomerStdSubdomain( (int) $domain['id'] ) == false
		&& (int) $domain['ismainbutsubto'] > 0
		 ) {
			$vhost_no = '21';
		}
		else
		{
			$vhost_no = '20';
		}

		if ( $ssl_vhost === true )
		{
			$vhost_filename = makeCorrectFile( $this->settings['system']['apacheconf_vhost'] . '/'.$vhost_no.'_froxlor_ssl_vhost_' . $domain['domain'] . '.conf' );
		}
		else
		{
			$vhost_filename = makeCorrectFile( $this->settings['system']['apacheconf_vhost'] . '/'.$vhost_no.'_froxlor_normal_vhost_' . $domain['domain'] . '.conf' );
		}

		return $vhost_filename;
	}


	protected function getVhostContent( $domain, $ssl_vhost = false )
	{
		if ( $ssl_vhost === true
		&& $domain['ssl'] != '1' )
		{
			return '';
		}

		if ( $ssl_vhost === true
		&& $domain['ssl'] == '1' )
		{
			$query = "SELECT * FROM " . TABLE_PANEL_IPSANDPORTS . " WHERE `id`='" . $domain['ssl_ipandport'] . "'";
		}
		else
		{
			$query = "SELECT * FROM " . TABLE_PANEL_IPSANDPORTS . " WHERE `id`='" . $domain['ipandport'] . "'";
		}

		$ipandport = $this->db->query_first( $query );
		$domain['ip'] = $ipandport['ip'];
		$domain['port'] = $ipandport['port'];
		$domain['ssl_cert_file'] = $ipandport['ssl_cert_file'];

		if ( filter_var($domain['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) )
		{
			$ipport = '[' . $domain['ip'] . ']:' . $domain['port'];
		}
		else
		{
			$ipport = $domain['ip'] . ':' . $domain['port'];
		}


		(string) $vhost_content = null;

		$vhost_content .= 'server { ' . PHP_EOL . PHP_EOL;
		$vhost_content .= "\t" . 'listen' . "\t\t" . $ipport . ';' . PHP_EOL;

		$vhost_content .= $this->getServerNames( $domain );

		// respect ssl_redirect settings, #542
		if ( $ssl_vhost == false
			&& $domain['ssl'] == '1'
			&& $domain['ssl_redirect'] == '1'
		 ) {
			$domain['documentroot'] = 'https://' . $domain['domain'] . '/';
		}

		if ( preg_match('/^https?\:\/\//', $domain['documentroot']) )
		{
			$vhost_content.= "\t".'rewrite' . "\t\t" . '^(.*) '.$this->idnaConvert->encode($domain['documentroot']).'$1 permanent;' . PHP_EOL;
		}
		else
		{
			mkDirWithCorrectOwnership( $domain['customerroot'], $domain['documentroot'], $domain['guid'], $domain['guid'], true );

			$vhost_content .= $this->getLogFiles( $domain );
			$vhost_content .= $this->getWebroot( $domain, $ssl_vhost );

			if ( $this->_deactivated == false ) {
				$vhost_content .= $this->create_pathOptions( $domain );
				$vhost_content .= $this->composePhpOptions( $domain, $ssl_vhost );

				$l_regex1="/( location\ \/\ \{ )( .* )( \} )/smU";
				$l_regex2="/( location\ \/\ \{.*\} )/smU";
				$replace_by="";
				$replacements=preg_match_all( $l_regex1,$vhost_content,$out );
				if ( $replacements>1 ){
					foreach ( $out[2] as $val ) {
						$replace_by.=$val."\n";
					}
					$vhost_content = preg_replace($l_regex2, null, $vhost_content, $replacements - 1);
					$vhost_content = preg_replace($l_regex2, 'location / {' . "\n\t\t" . $replace_by . "\t}" . "\n", $vhost_content);
				}

				if ( $domain['specialsettings'] != "" ) {
					$vhost_content .= $domain['specialsettings'] . PHP_EOL;
				}
			}
		}
		$vhost_content .= '}' . PHP_EOL . PHP_EOL;

		return $vhost_content;
	}


	protected function create_pathOptions( $domain )
	{
		$has_location = false;

		$query = "SELECT * FROM " . TABLE_PANEL_HTACCESS . " WHERE `path` LIKE '" . $domain['documentroot'] . "%'";
		$result = $this->db->query($query);

		$path_options = '';

		$htpasswds = $this->getHtpasswds( $domain );

		while( $row = $this->db->fetch_array( $result ) )
		{
			if ( !empty( $row['error404path'] ) )
			{
				$path_options.= "\t".'error_page   404    ' . $row['error404path'] . ';' . PHP_EOL;
			}

			if ( !empty( $row['error403path'] ) )
			{
				$path_options.= "\t".'error_page   403    ' . $row['error403path'] . ';' . PHP_EOL;
			}

			if ( !empty( $row['error500path'] ) )
			{
				$path_options.= "\t".'error_page   502 503 504    ' . $row['error500path'] . ';' . PHP_EOL;
			}

//			if ( $row['options_indexes'] != '0' )
//			{
				$path = makeCorrectDir( substr($row['path'], strlen( $domain['documentroot']) - 1) );

				mkDirWithCorrectOwnership( $domain['documentroot'], $row['path'], $domain['guid'], $domain['guid'] );

				$path_options.= "\t" . '# ' . $path . PHP_EOL;

				if ( $path == '/' ) {

					$this->vhost_root_autoindex = true;

					$path_options.= "\t" . 'location ' . $path . ' {' . PHP_EOL;

					if ( $this->vhost_root_autoindex ) {

						$path_options.= "\t\t" . 'autoindex' . "\t\t" . 'on;' . PHP_EOL;
						$this->vhost_root_autoindex = false;

					}

					$path_options.= "\t\t" . 'index' . "\t\t" . 'index.php index.html index.htm;' . PHP_EOL;
					//$path_options.= "\t\t" . 'try_files $uri $uri/ @rewrites;' . PHP_EOL;

					# check if we have a htpasswd for this path
					# (nginx does not like more than one 'location'-part with the same path )
					if ( count($htpasswds) > 0 ) {

						foreach( $htpasswds as $idx => $single ) {

							switch( $single['path'] ) {

								case '/awstats/':
								case '/webalizer/':
									$path_options .= $this->getStats( $domain, $single ); break;

								default:

									if ( $single['path'] == '/' ) {

										$path_options .= "\t\t" . 'auth_basic' . "\t\t" . '"Restricted Area";' . PHP_EOL;
										$path_options .= "\t\t" . 'auth_basic_user_file' . "\t" . $single['usrf'] . ';' . PHP_EOL;

									}

									break;

							}

							# remove already used entries so we do not have doubles
							unset($htpasswds[$idx]);

						}

					}

					$path_options .= "\t" . '}' . PHP_EOL . PHP_EOL;

					$this->vhost_root_autoindex = false;

				} elseif ( count($htpasswds) == 0 ) {

					$path_options .= "\t".'location ' . $path . ' {' . PHP_EOL;

					if ( $this->vhost_root_autoindex ) {

						$path_options .= "\t\t" . 'autoindex' . "\t\t" . 'on;' . PHP_EOL;
						$this->vhost_root_autoindex = false;

					}

					$path_options .= "\t\t" . 'index' . "\t\t" . 'index.php index.html index.htm;' . PHP_EOL;
					$path_options .= "\t" . '}' . PHP_EOL . PHP_EOL;

				}
				//}

			/**
			 * Perl support
			 * required the fastCGI wrapper to be running to receive the CGI requests.
			 */
			if ( customerHasPerlEnabled($domain['customerid'])
			&& $row['options_cgi'] != '0' )
			{
				$path = makeCorrectDir( substr($row['path'], strlen($domain['documentroot']) - 1) );
				mkDirWithCorrectOwnership( $domain['documentroot'], $row['path'], $domain['guid'], $domain['guid'] );

				// We need to remove the last slash, otherwise the regex wouldn't work
				if ( $row['path'] != $domain['documentroot'] ) {
					$path = substr( $path, 0, -1 );
				}
				$path_options .= "\t" . 'location ~ \(.pl|.cgi)$ {' . PHP_EOL;
				$path_options .= "\t\t" . 'gzip off; #gzip makes scripts feel slower since they have to complete before getting gzipped' . PHP_EOL;
				$path_options .= "\t\t" . 'fastcgi_pass  '. $this->settings['system']['perl_server'] . ';' . PHP_EOL;
				$path_options .= "\t\t" . 'fastcgi_index index.cgi;' . PHP_EOL;
				$path_options .= "\t\t" . 'include ' . $this->_pathOfNginx() . '/fastcgi_params;' . PHP_EOL;
				$path_options .= "\t" . '}' . PHP_EOL;
			}

		}

		/*
		 * now the rest of the htpasswds
		 */
		if ( count($htpasswds) > 0 ) {

			foreach( $htpasswds as $idx => $single ) {

				switch( $single['path'] ) {

					case '/awstats/':
					case '/webalizer/':
						$path_options .= $this->getStats( $domain, $single ); break;

					default:

						if ( $single['path'] == '/' ) {

							$path_options .= "\t\t" . 'auth_basic' . "\t\t" . '"Restricted Area";' . PHP_EOL;
							$path_options .= "\t\t" . 'auth_basic_user_file' . "\t" . $single['usrf'] . ';' . PHP_EOL;

						}

						break;

				}

				# remove already used entries so we do not have doubles
				unset($htpasswds[$idx]);

			}

			return (string) $path_options;

		}

	}


	/**
	 * @brief ...
	 *
	 * @param (array) $domain
	 * @return (array) $return
	 **/
	protected function getHtpasswds( array $domain ) {

		$return = array();

		(string) $query = 'SELECT DISTINCT *
											 FROM ' . TABLE_PANEL_HTPASSWDS . ' AS a
											 JOIN ' . TABLE_PANEL_DOMAINS . ' AS b
											 USING (`customerid`)
											 WHERE b.customerid=' . $domain['customerid'] . ' AND b.domain="' . $domain['domain'] . '";';


		$result = $this->db->query($query);

		# loop counter
		(int) $i = 0;

		while( $row_htpasswds = $this->db->fetch_array($result) ) {

			if ( count($row_htpasswds) > 0 ) {

				# htpasswd filename
				$htpasswd_filename = makeCorrectFile( $this->settings['system']['apacheconf_htpasswddir'] . '/' . $row_htpasswds['customerid'] . '-' . md5($row_htpasswds['path']) . '.htpasswd');

				if ( isset( $this->htpasswds_data[$htpasswd_filename]) ) {

					$this->htpasswds_data[$htpasswd_filename] .= $row_htpasswds['username'] . ':' . $row_htpasswds['password'] . PHP_EOL;

				} else {

					$this->htpasswds_data[$htpasswd_filename] = false;

				}


				# if the domains and their web contents are located in a subdirectory of
				# the nginx user, we have to evaluate the right path which is to protect
				if ( stripos($row_htpasswds['path'], $domain['documentroot']) !== false ) {

					# if the website contents is located in the user directory
					(string) $path = makeCorrectDir( substr($row_htpasswds['path'], strlen($domain['documentroot']) - 1) );

				} else {

					# if the website contents is located in a subdirectory of the user
					preg_match('/^([\/[:print:]]*\/)([[:print:]\/]+){1}$/i', $row_htpasswds['path'], $matches);
					(string) $path = makeCorrectDir( substr($row_htpasswds['path'], strlen($matches[1]) - 1) );

				}


				# return
				(string) $return[$i]['path'] = $path;
				(string) $return[$i]['root'] = makeCorrectDir( $domain['documentroot'] );
				(string) $return[$i]['usrf'] = $htpasswd_filename;

				# increment loop counter
				(int) $i++;

			}

		}

		return (array) $return;

	}


	protected function getWebroot( $domain, $ssl )
	{
		$webroot_text = '';

		if ( $domain['deactivated'] == '1'
		&& $this->settings['system']['deactivateddocroot'] != '' )
		{
			$webroot_text .= "\t" . '# Using docroot for deactivated users...' . PHP_EOL;
			$webroot_text .= "\t" . 'root' . "\t\t" . $this->settings['system']['deactivateddocroot'] . ';' . PHP_EOL . PHP_EOL;
			(bool) $this->_deactivated = true;
		}
		else
		{
			$webroot_text .= "\t" . 'root' . "\t\t" . makeCorrectDir( $domain['documentroot'] ) . ';' . PHP_EOL . PHP_EOL;
			(bool) $this->_deactivated = false;
		}

		$webroot_text .= "\t" . 'location / {' . PHP_EOL;
		$webroot_text .= "\t\t" . 'index' . "\t\t" . 'index.php index.html index.htm;' . PHP_EOL;
		$webroot_text .= "\t\t" . 'try_files' . "\t" . '$uri $uri/ @rewrites;' . PHP_EOL;

		if ( $this->vhost_root_autoindex ) {
			$webroot_text.= "\t\t" . 'autoindex'. "\t" .'on;' . PHP_EOL;
			$this->vhost_root_autoindex = false;
		}

		$webroot_text.= "\t" .'}' . PHP_EOL . PHP_EOL;

		$webroot_text.= "\t" . 'location @rewrites {' . PHP_EOL;
		$webroot_text.= "\t\t" . 'rewrite' . "\t\t" .'^ /index.php last;' . PHP_EOL;
		$webroot_text.= "\t" . '}' . PHP_EOL . PHP_EOL;

		return $webroot_text;
	}


	/**
	 * @brief Awstats, Webalizer
	 *
	 * @param (array) $domain
	 * @param (array) $single
	 * @return (string) $stats_text
	 **/
	protected function getStats( array $domain, array $single ) {

		(string) $stats_text = null;

		if ( $domain['speciallogfile'] ) {

			if ( $this->settings['system']['awstats_enabled'] ) {

				# container for awstats
				$stats_text .= "\t" . '# Awstats' . PHP_EOL;
				$stats_text .= "\t" . 'location /awstats {' . PHP_EOL;
				$stats_text .= "\t\t" . 'alias' . "\t\t\t" . makeCorrectFile( $domain['customerroot'] . '/awstats/' . ( $domain['parentdomainid'] == 0 ? $domain['domain'] : $domain['parentdomain'] ) ) . ';' . PHP_EOL;
				$stats_text .= "\t\t" . 'auth_basic' . "\t\t" . '"Restricted Area";' . PHP_EOL;
				$stats_text .= "\t\t" . 'auth_basic_user_file' . "\t" . $single['usrf'] . ';' . PHP_EOL;
				$stats_text .= "\t" . '}' . PHP_EOL . PHP_EOL;
				$stats_text .= "\t" . 'location /awstats-icon {' . PHP_EOL;
				$stats_text .= "\t\t" . 'alias' . "\t\t\t" . makeCorrectDir( $this->settings['system']['awstats_icons'] ) . ';' . PHP_EOL;
				$stats_text .= "\t" . '}' . PHP_EOL . PHP_EOL;

			} elseif ( !$this->settings['system']['awstats_enabled'] ) {

				# container for webalizer
				$stats_text .= "\t" . '# Webalizer' . PHP_EOL;
				$stats_text .= "\t" . 'location /webalizer {' . PHP_EOL;
				$stats_text .= "\t\t" . 'alias' . "\t\t\t" .makeCorrectFile( $domain['customerroot'] . '/webalizer/' . ( $domain['parentdomainid'] == 0 ? $domain['domain'] : $domain['parentdomain'] ) ) . ';' . PHP_EOL;
				$stats_text .= "\t\t" . 'auth_basic' . "\t\t" . '"Restricted Area";' . PHP_EOL;
				$stats_text .= "\t\t" . 'auth_basic_user_file' . "\t" . $single['usrf'] . ';' . PHP_EOL;
				$stats_text .= "\t" . '}' . PHP_EOL . PHP_EOL;

			}

		}

		return $stats_text;

	}


	/**
	 * @TODO mod_log_sql
	 */
	protected function getLogFiles( $domain )
	{
		$logfiles_text = '';

		if ( $domain['speciallogfile'] == '1'
		&& $this->settings['system']['mod_log_sql'] != '1' )
		{
			if ( $domain['parentdomainid'] == '0' )
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
		$error_log = makeCorrectFile( $this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-error.log' );
		// Create the logfile if it does not exist (fixes #46)
		touch($error_log);
		chown($error_log, $this->settings['system']['httpuser']);
		chgrp($error_log, $this->settings['system']['httpgroup']);

		$access_log = makeCorrectFile( $this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-access.log' );
		// Create the logfile if it does not exist (fixes #46)
		touch($access_log);
		chown($access_log, $this->settings['system']['httpuser']);
		chgrp($access_log, $this->settings['system']['httpgroup']);

		$logfiles_text.= "\t".'access_log' . "\t" . $access_log . ' combined;' . PHP_EOL;
		$logfiles_text.= "\t".'error_log' . "\t" . $error_log . ' error;' . PHP_EOL;

		if ( $this->settings['system']['awstats_enabled'] == '1' )
		{
			if ( (int) $domain['parentdomainid'] == 0 )
			{
				// prepare the aliases and subdomains for stats config files

				$server_alias = '';
				$alias_domains = $this->db->query('SELECT `domain`, `iswildcarddomain`, `wwwserveralias`
																					FROM `' . TABLE_PANEL_DOMAINS . '`
																					WHERE `aliasdomain`=\'' . $domain['id'] . '\'
																					OR `parentdomainid` =\''. $domain['id']. '\'');

				while( ($alias_domain = $this->db->fetch_array($alias_domains)) !== false )
				{
					$server_alias.= ' ' . $alias_domain['domain'] . ' ';

					if ( $alias_domain['iswildcarddomain'] == '1' )
					{
						$server_alias.= '*.' . $domain['domain'];
					}
					else
					{
						if ( $alias_domain['wwwserveralias'] == '1' )
						{
							$server_alias.= 'www.' . $alias_domain['domain'];
						}
						else
						{
							$server_alias.= '';
						}
					}
				}

				if ( $domain['iswildcarddomain'] == '1' )
				{
					$alias = '*.' . $domain['domain'];
				}
				else
				{
					if ( $domain['wwwserveralias'] == '1' )
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
				createAWStatsConf( $this->settings['system']['logfiles_directory'] . $domain['loginname'] . $speciallogfile . '-access.log', $domain['domain'], $alias . $server_alias, $domain['customerroot'], $domain );
			}
		}

		return $logfiles_text;
	}

	public function createOwnVhostStarter()
	{
	}

	protected function getServerNames( $domain )
	{
		$server_alias = '';

		if ( $domain['iswildcarddomain'] == '1' )
		{
			$server_alias = '*.' . $domain['domain'];
		}
		else
		{
			if ( $domain['wwwserveralias'] == '1' )
			{
				$server_alias = 'www.' . $domain['domain'];
			}
			else
			{
				$server_alias = '';
			}
		}

		$alias_domains = $this->db->query('SELECT `domain`, `iswildcarddomain`, `wwwserveralias`
																			FROM `' . TABLE_PANEL_DOMAINS . '`
																			WHERE `aliasdomain`=\'' . $domain['id'] . '\'');

		while( ($alias_domain = $this->db->fetch_array($alias_domains)) !== false )
		{
			$server_alias.= ' ' . $alias_domain['domain'];

			if ( $alias_domain['iswildcarddomain'] == '1' )
			{
				$server_alias.= ' *.' . $alias_domain['domain'];
			}
			else
			{
				if ( $alias_domain['wwwserveralias'] == '1' )
				{
					$server_alias.= ' www.' . $alias_domain['domain'];
				}
			}
		}

		$servernames_text = "\t".'server_name' . "\t" . $domain['domain'];
		if ( trim($server_alias) != '' )
		{
			$servernames_text.=  ' '.$server_alias;
		}
		$servernames_text.= ';' . PHP_EOL;

		return $servernames_text;
	}

	public function writeConfigs()
	{
		fwrite( $this->debugHandler, '  nginx::writeConfigs: rebuilding ' . $this->settings['system']['apacheconf_vhost'] . "\n" );
		$this->logger->logAction( CRON_ACTION, LOG_INFO, "rebuilding " . $this->settings['system']['apacheconf_vhost'] );

		if ( !isConfigDir( $this->settings['system']['apacheconf_vhost'] ) )
		{
			// Save one big file
			$vhosts_file = '';

			// sort by filename so the order is:
			// 1. subdomains
			// 2. subdomains as main-domains
			// 3. main-domains
			ksort($this->nginx_data);

			foreach( $this->nginx_data as $vhosts_filename => $vhost_content )
			{
				$vhosts_file.= $vhost_content . PHP_EOL . PHP_EOL;
			}

			$vhosts_filename = $this->settings['system']['apacheconf_vhost'];

			// Apply header

			$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date( 'd.m.Y H:i' ) . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;
			$vhosts_file_handler = fopen($vhosts_filename, 'w');
			fwrite($vhosts_file_handler, $vhosts_file);
			fclose($vhosts_file_handler);
		}
		else
		{
			if ( !file_exists($this->settings['system']['apacheconf_vhost']) )
			{
				fwrite( $this->debugHandler, '  nginx::writeConfigs: mkdir ' . escapeshellarg( makeCorrectDir( $this->settings['system']['apacheconf_vhost'] ) ) . "\n" );
				$this->logger->logAction( CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg( makeCorrectDir( $this->settings['system']['apacheconf_vhost'] ) ) );
				safe_exec( 'mkdir -p ' . escapeshellarg( makeCorrectDir( $this->settings['system']['apacheconf_vhost'] ) ) );
			}

			// Write a single file for every vhost

			foreach( $this->nginx_data as $vhosts_filename => $vhosts_file )
			{
				$this->known_filenames[] = basename($vhosts_filename);

				// Apply header

				$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;

				if ( !empty($vhosts_filename) )
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
		if ( count($this->htpasswds_data) > 0 )
		{
			if ( !file_exists($this->settings['system']['apacheconf_htpasswddir']) )
			{
				$umask = umask();
				umask( 0000 );
				mkdir( $this->settings['system']['apacheconf_htpasswddir'], 0751 );
				umask( $umask );
			}
			elseif ( !is_dir($this->settings['system']['apacheconf_htpasswddir']) )
			{
				fwrite( $this->debugHandler, '  cron_tasks: WARNING!!! ' . $this->settings['system']['apacheconf_htpasswddir'] . ' is not a directory. htpasswd directory protection is disabled!!!' . "\n" );
				echo 'WARNING!!! ' . $this->settings['system']['apacheconf_htpasswddir'] . ' is not a directory. htpasswd directory protection is disabled!!!';
				$this->logger->logAction( CRON_ACTION, LOG_WARNING, 'WARNING!!! ' . $this->settings['system']['apacheconf_htpasswddir'] . ' is not a directory. htpasswd directory protection is disabled!!!' );
			}

			if ( is_dir($this->settings['system']['apacheconf_htpasswddir']) )
			{
				foreach( $this->htpasswds_data as $htpasswd_filename => $htpasswd_file )
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
		fwrite( $this->debugHandler, '  nginx::wipeOutOldVhostConfigs: cleaning ' . $this->settings['system']['apacheconf_vhost'] . "\n" );
		$this->logger->logAction( CRON_ACTION, LOG_INFO, "cleaning " . $this->settings['system']['apacheconf_vhost'] );

		if ( isConfigDir($this->settings['system']['apacheconf_vhost'], true) )
		{
			$vhost_file_dirhandle = opendir( $this->settings['system']['apacheconf_vhost'] );

			while( false !== ($vhost_filename = readdir($vhost_file_dirhandle)) )
			{
				if ( $vhost_filename != '.'
				&& $vhost_filename != '..'
				&& !in_array($vhost_filename, $this->known_filenames)
				&& preg_match('/^(05|10|20|21|22|30|50|51)_(froxlor|syscp)_(dirfix|ipandport|normal_vhost|wildcard_vhost|ssl_vhost)_(.+)\.conf$/', $vhost_filename)
				&& file_exists( makeCorrectFile( $this->settings['system']['apacheconf_vhost'] . '/' . $vhost_filename )) )
				{
					fwrite($this->debugHandler, '  nginx::wipeOutOldVhostConfigs: unlinking ' . $vhost_filename . "\n");
					$this->logger->logAction( CRON_ACTION, LOG_NOTICE, 'unlinking ' . $vhost_filename );
					unlink(makeCorrectFile( $this->settings['system']['apacheconf_vhost'] . '/' . $vhost_filename ));
				}
			}
		}
		if ( $this->settings['phpfpm']['enabled'] == '1' )
		{
			foreach( $this->known_vhostfilenames as $vhostfilename ){
				$known_phpfpm_files[]=preg_replace('/^( 05|10|20|21|22|30|50|51)_(froxlor|syscp)_(dirfix|ipandport|normal_vhost|wildcard_vhost|ssl_vhost)_/', '', $vhostfilename);
			}

			$configdir = $this->settings['phpfpm']['configdir'];
			$phpfpm_file_dirhandle = opendir($this->settings['phpfpm']['configdir']);

			if ( $phpfpm_file_dirhandle !== false ) {

				while ( false !== ($phpfpm_filename = readdir($phpfpm_file_dirhandle)) ) {

					if ( is_array( $known_phpfpm_files )
						&& $phpfpm_filename != '.'
						&& $phpfpm_filename != '..'
						&& isset($known_phpfpm_files)
						&& !in_array($phpfpm_filename, $known_phpfpm_files)
						&& file_exists(makeCorrectFile( $this->settings['phpfpm']['configdir'] . '/' . $phpfpm_filename ))
					 ) {
						fwrite($this->debugHandler, '  nginx::wipeOutOldVhostConfigs: unlinking PHP5-FPM ' . $phpfpm_filename . "\n");
						$this->logger->logAction( CRON_ACTION, LOG_NOTICE, 'unlinking ' . $phpfpm_filename );
						unlink(makeCorrectFile( $this->settings['phpfpm']['configdir'] . '/' . $phpfpm_filename ));
					}
					if ( !is_array($known_phpfpm_files) ) {
						$this->logger->logAction( CRON_ACTION, LOG_WARNING, "WARNING!! PHP-FPM Configs Not written!!" );
					}
				}
			} else {
				$this->logger->logAction( CRON_ACTION, LOG_WARNING, "WARNING!! PHP-FPM configuration path could not be read (".$this->settings['phpfpm']['configdir'].")" );
			}
		}
	}

	/*
	 *	We remove old htpasswd config files
	 */
	protected function wipeOutOldHtpasswdConfigs()
	{
		fwrite( $this->debugHandler, '  nginx::wipeOutOldHtpasswdConfigs: cleaning ' . $this->settings['system']['apacheconf_htpasswddir'] . "\n" );
		$this->logger->logAction( CRON_ACTION, LOG_INFO, "cleaning " . $this->settings['system']['apacheconf_htpasswddir'] );

		if ( isConfigDir( $this->settings['system']['apacheconf_htpasswddir'] )
		&& file_exists($this->settings['system']['apacheconf_htpasswddir'])
		&& is_dir($this->settings['system']['apacheconf_htpasswddir']) )
		{
			$htpasswds_file_dirhandle = opendir( $this->settings['system']['apacheconf_htpasswddir'] );

			while( false !== ( $htpasswd_filename = readdir( $htpasswds_file_dirhandle ) ) )
			{
				if ( $htpasswd_filename != '.'
				&& $htpasswd_filename != '..'
				&& !in_array($htpasswd_filename, $this->known_htpasswdsfilenames)
				&& file_exists(makeCorrectFile( $this->settings['system']['apacheconf_htpasswddir'] . '/' . $htpasswd_filename )) )
				{
					fwrite($this->debugHandler, '  nginx::wipeOutOldHtpasswdConfigs: unlinking ' . $htpasswd_filename . "\n");
					$this->logger->logAction( CRON_ACTION, LOG_NOTICE, 'unlinking ' . $htpasswd_filename );
					unlink(makeCorrectFile( $this->settings['system']['apacheconf_htpasswddir'] . '/' . $htpasswd_filename ));
				}
			}
		}
	}
}

?>