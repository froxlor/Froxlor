<?php

if (! defined('MASTER_CRONJOB'))
	die('You cannot access this file directly!');

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *
 */

require_once (dirname(__FILE__) . '/../classes/class.HttpConfigBase.php');

class nginx_proxy extends HttpConfigBase
{

	private $logger = false;

	private $idnaConvert = false;

	private $nginx_server = array();

	// protected
	protected $nginx_data = array();

	protected $needed_htpasswds = array();

	protected $auth_backend_loaded = false;

	protected $htpasswds_data = array();

	protected $known_htpasswdsfilenames = array();

	protected $mod_accesslog_loaded = '0';

	protected $vhost_root_autoindex = false;

	protected $known_vhostfilenames = array();

	/**
	 * indicator whether a customer is deactivated or not
	 * if yes, only the webroot will be generated
	 *
	 * @var bool
	 */
	private $_deactivated = false;

	public function __construct($logger, $idnaConvert, $nginx_server = array())
	{
		$this->logger = $logger;
		$this->idnaConvert = $idnaConvert;
		$this->nginx_server = $nginx_server;
	}

	public function reload()
	{
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'nginx::reload: reloading nginx');
		safe_exec(Settings::Get('system.proxyreload_command'));
	}

	/**
	 * define a default ErrorDocument-statement, bug #unknown-yet
	 */
	private function _createStandardErrorHandler()
	{
		if (Settings::Get('defaultwebsrverrhandler.enabled') == '1' && (Settings::Get('defaultwebsrverrhandler.err401') != '' || Settings::Get('defaultwebsrverrhandler.err403') != '' || Settings::Get('defaultwebsrverrhandler.err404') != '' || Settings::Get('defaultwebsrverrhandler.err500') != '')) {
			$vhosts_folder = '';
			if (is_dir(Settings::Get('system.proxyconf_vhost'))) {
				$vhosts_folder = makeCorrectDir(Settings::Get('system.proxyconf_vhost'));
			} else {
				$vhosts_folder = makeCorrectDir(dirname(Settings::Get('system.proxyconf_vhost')));
			}

			$vhosts_filename = makeCorrectFile($vhosts_folder . '/05_froxlor_default_errorhandler.conf');

			if (! isset($this->nginx_data[$vhosts_filename])) {
				$this->nginx_data[$vhosts_filename] = '';
			}

			$statusCodes = array(
				'401',
				'403',
				'404',
				'500'
			);
			foreach ($statusCodes as $statusCode) {
				if (Settings::Get('defaultwebsrverrhandler.err' . $statusCode) != '') {
					$defhandler = Settings::Get('defaultwebsrverrhandler.err' . $statusCode);
					if (! validateUrl($defhandler)) {
						$defhandler = makeCorrectFile($defhandler);
					}
					$this->nginx_data[$vhosts_filename] .= 'error_page ' . $statusCode . ' ' . $defhandler . ';' . "\n";
				}
			}
		}
	}

	protected function processSpecialConfigTemplate($template, $domain, $ip, $port, $is_ssl_vhost, $extravars = array())
        {
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                                $ip = '[' . $ip . ']';
		}
                if (in_array('PROXY_IP', $extravars) && filter_var($extravars['PROXY_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                                $extravars['PROXY_IP'] = '[' . $extravars['PROXY_IP'] . ']';
                }
                $templateVars = array(
                        'DOMAIN' => $domain['domain'],
                        'CUSTOMER' => $domain['loginname'],
                        'IP' => $ip,
                        'PORT' => $port,
                        'SCHEME' => ($is_ssl_vhost) ? 'https' : 'http',
                        'DOCROOT' => $domain['documentroot']
                );
                $templateVars = array_merge($templateVars, $extravars);
                return replace_variables($template, $templateVars);
        }

	public function createVirtualHosts()
	{}

	public function createFileDirOptions()
	{}

	private function acmeConf() {
		$conf = "\tlocation /.well-known/acme-challenge {\n";
		$conf .= "\t\talias ". Settings::Get('system.letsencryptchallengepath') ."/.well-known/acme-challenge;\n";
		$conf .= "\t\tlocation ~ /.well-known/acme-challenge/(.*) {\n";
		$conf .= "\t\t\tdefault_type text/plain;\n";
		$conf .= "\t\t}\n";
		$conf .= "\t}\n";
		return $conf;
	}

	private function proxyConf($domain, $proxy_ip, $proxy_port) {
		$conf = "\tlocation ~ /\.ht {\n";
                $conf .= "\t\tdeny all;\n";
        	$conf .= "\t}\n";
        	$conf .= "\tlocation / {\n";
		$conf .= "\t\ttry_files \$uri \$uri/ @proxy;\n";
		$conf .= "\t}\n\n";
        	$conf .= "\tlocation @proxy {\n";
                $conf .= "\t\tproxy_pass {SCHEME}://{IP}:{PORT}\$request_uri;\n";
	        $conf .= "\t\tproxy_set_header Host \$host;\n";
        	$conf .= "\t\tproxy_set_header X-Real-IP \$remote_addr;\n";
	        $conf .= "\t\tproxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;\n";
        	$conf .= "\t\tproxy_set_header X-Forwarded-Proto \$scheme;\n";
		$conf .= "\t\tinclude ". Settings::Get('system.proxyconf_vhost') ."proxy[.]conf;\n";
       		$conf .= "\t}\n";
		return $conf;
	}

	protected function makeSSLBundle($domain) {
		$bundlepath = makeCorrectFile(Settings::Get('system.customer_ssl_path') .'/'.$domain['domain'].'_bundle.pem');
                // get cert, ca and chain
		$cert_bundle = '';
                if(file_exists($domain['ssl_cert_file']))
                        $cert_bundle = file_get_contents($domain['ssl_cert_file'])."\n";
                if(file_exists($domain['ssl_ca_file']))
                        $cert_bundle .= file_get_contents($domain['ssl_ca_file'])."\n";
                if(file_exists($domain['ssl_cert_chainfile']))
                        $cert_bundle .= file_get_contents($domain['ssl_cert_chainfile'])."\n";
		if(!empty($cert_bundle)) {
			file_put_contents($bundlepath, $cert_bundle, LOCK_EX);
			chmod($bundlepath, 0600);
			return $bundlepath;
		} else {
			return '';
		}
	}

	public function createIpPort()
	{
		$result_ipsandports_stmt = Database::query("
			SELECT *, CONCAT(proxy_ip, ':', proxy_port) AS ip_port FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE proxy_port != '0' GROUP BY ip_port  ORDER BY `ip` ASC, `port` ASC
		");

		while ($row_ipsandports = $result_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
			$ip = $row_ipsandports['ip'];
			$port = $row_ipsandports['port'];
                        $proxy_ip = $row_ipsandports['proxy_ip'] == '' ? $ip : $row_ipsandports['proxy_ip'];
                        $proxy_port = $row_ipsandports['proxy_port'];
			if (filter_var($proxy_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$ipport = '[' . $proxy_ip . ']:'.$proxy_port;
			} else {
				$ipport = $proxy_ip .':'. $proxy_port;
			}

			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'nginx::createIpPort: creating ip/port settings for  ' . $proxy_ip . ":" . $proxy_port);
			$vhost_filename = makeCorrectFile(Settings::Get('system.proxyconf_vhost') . '/10_froxlor_ipandport_' . trim(str_replace(':', '.', $proxy_ip), '.') . '.' . $proxy_port . '.conf');

			if (! isset($this->nginx_data[$vhost_filename])) {
				$this->nginx_data[$vhost_filename] = '';
			}

			$domain = array(
                        'id' => 0,
                        'domain' => Settings::Get('system.hostname'),
                        'adminid' => 1, /* first admin-user (superadmin) */
                        'loginname' => 'froxlor.panel',
                        'documentroot' => $this->getMyPath($row_ipsandports),
                        'parentdomainid' => 0,
			'ip' => $ip,
			'port' => $port,
                        'proxy_ip' => $proxy_ip,
                        'proxy_port' => $proxy_port,
                        );

			if ($row_ipsandports['vhostcontainer'] == '1') {
					
				$this->nginx_data[$vhost_filename] .= 'server { ' . "\n";

				$mypath = $this->getMyPath($row_ipsandports);

				// check for ssl before anything else so
				// we know whether it's an ssl vhost or not
				$ssl_vhost = false;
				if ($row_ipsandports['ssl'] == '1') {
					if ($row_ipsandports['ssl_cert_file'] == '') {
						$row_ipsandports['ssl_cert_file'] = Settings::Get('system.ssl_cert_file');
					}
					if ($row_ipsandports['ssl_key_file'] == '') {
						$row_ipsandports['ssl_key_file'] = Settings::Get('system.ssl_key_file');
					}
					if ($row_ipsandports['ssl_ca_file'] == '') {
						$row_ipsandports['ssl_ca_file'] = Settings::Get('system.ssl_ca_file');
					}
					if ($row_ipsandports['ssl_cert_file'] != '' && file_exists($row_ipsandports['ssl_cert_file'])) {
						$ssl_vhost = true;
					}
					// override corresponding array values
					$domain['ssl_cert_file'] = $row_ipsandports['ssl_cert_file'];
					$domain['ssl_key_file'] = $row_ipsandports['ssl_key_file'];
					$domain['ssl_ca_file'] = $row_ipsandports['ssl_ca_file'];
					$domain['ssl_cert_chainfile'] = $row_ipsandports['ssl_cert_chainfile'];

					// SSL STUFF
					$dssl = new DomainSSL();
					// this sets the ssl-related array-indices in the $domain array
					// if the domain has customer-defined ssl-certificates
					$dssl->setDomainSSLFilesArray($domain, false);

					if ($domain['ssl_cert_file'] != '' && file_exists($domain['ssl_cert_file'])) {
						// override corresponding array values
						$row_ipsandports['ssl_cert_file'] = $domain['ssl_cert_file'];
						$row_ipsandports['ssl_key_file'] = $domain['ssl_key_file'];
						$row_ipsandports['ssl_ca_file'] = $domain['ssl_ca_file'];
						$row_ipsandports['ssl_cert_chainfile'] = $domain['ssl_cert_chainfile'];
						$ssl_vhost = true;
					}
				}

				$http2 = $ssl_vhost == true && Settings::Get('system.http2_support') == '1';

                        	if (filter_var($proxy_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                                	$ipport = '[' . $proxy_ip . ']:' . $proxy_port;
                        	} else {
                                	$ipport = $proxy_ip . ':' . $proxy_port;
                        	}
				/**
				 * this HAS to be set for the default host in nginx or else no vhost will work
				 */
				$this->nginx_data[$vhost_filename] .= "\t" . 'listen    ' . $ipport . ' default_server' . ($ssl_vhost == true ? ' ssl' : '') . ($http2 == true ? ' http2' : '') . ';' . "\n";

				$this->nginx_data[$vhost_filename] .= "\t" . '# Froxlor default vhost' . "\n";
				$this->nginx_data[$vhost_filename] .= "\t" . 'server_name    ' . Settings::Get('system.hostname') . ';' . "\n";
				$this->nginx_data[$vhost_filename] .= "\t" . 'access_log      /var/log/nginx/access.log;' . "\n";

				if (Settings::Get('system.use_ssl') == '1' && Settings::Get('system.leenabled') == '1' && Settings::Get('system.le_froxlor_enabled') == '1') {
					$this->nginx_data[$vhost_filename] .= $this->acmeConf(). "\n";
				}

				$is_redirect = false;
				// check for SSL redirect
				if ($row_ipsandports['ssl'] == '0' && Settings::Get('system.le_froxlor_redirect') == '1') {
					$is_redirect = true;
					// check whether froxlor uses Let's Encrypt and not cert is being generated yet
					// or a renew is ongoing - disable redirect
					if (Settings::Get('system.le_froxlor_enabled') && ($this->froxlorVhostHasLetsEncryptCert() == false || $this->froxlorVhostLetsEncryptNeedsRenew())) {
						$this->nginx_data[$vhost_filename] .= '# temp. disabled ssl-redirect due to Let\'s Encrypt certificate generation.' . PHP_EOL;
						$is_redirect = false;
					} else {
						$_sslport = $this->checkAlternativeSslPort();
						$mypath = 'https://' . Settings::Get('system.hostname') . $_sslport . '/';
						$this->nginx_data[$vhost_filename] .= "\t" . 'if ($request_uri !~ ^/.well-known/acme-challenge/\w+$) {' . "\n";
						$this->nginx_data[$vhost_filename] .= "\t\t" . 'return 301 ' . $mypath . '$request_uri;' . "\n";
						$this->nginx_data[$vhost_filename] .= "\t" . '}' . "\n";
					}
				}

				if (! $is_redirect) {
					$this->nginx_data[$vhost_filename] .= "\t" . 'root     ' . $mypath . ';' . "\n";
					$this->nginx_data[$vhost_filename] .= "\t" . 'index    index.php index.html index.htm;' . "\n\n";
					#$this->nginx_data[$vhost_filename] .= "\t" . 'location / {' . "\n";
					#$this->nginx_data[$vhost_filename] .= "\t" . '}' . "\n";
				}
	
				$config_vars = array(
                                                        'PROXY_IP' => $domain['proxy_ip'],
                                                        'PROXY_PORT' => $domain['proxy_port'],
                                                );
				$config = $this->processSpecialConfigTemplate($this->proxyConf($domain, $proxy_ip, $proxy_port),
						$domain, $ip, $port, $ssl_vhost, $config_vars) ."\n";

				if (Settings::Get('system.default_proxyconf') != '') {
                                        $config = $this->mergeVhostCustom($config, $this->processSpecialConfigTemplate(Settings::Get('system.default_proxyconf'), 
						$domain,  $ip, $port, $row_ipsandports['ssl'] == '1', $config_vars) . "\n");
                                }

				if ($row_ipsandports['proxy_conf_ip'] != '') {
					$config = $this->mergeVhostCustom($config, $this->processSpecialConfigTemplate($row_ipsandports['proxy_conf_ip'], 
						$domain, $ip, $port, $row_ipsandports['ssl'] == '1', $config_vars) . "\n") ."\n";
				}
				$this->nginx_data[$vhost_filename] .= $config;


				/**
				 * SSL config options
				 */
				if ($row_ipsandports['ssl'] == '1') {
					$row_ipsandports['domain'] = Settings::Get('system.hostname');
					$this->nginx_data[$vhost_filename] .= $this->composeSslSettings($row_ipsandports);
				}

				$this->nginx_data[$vhost_filename] .= "\n}\n\n";
				// End of Froxlor server{}-part
			}
		}

		$this->createNginxHosts();

		/**
		 * standard error pages
		 */
		$this->_createStandardErrorHandler();
	}

	/**
	 * create vhosts
	 */
	protected function createNginxHosts()
	{
		$domains = WebserverBase::getVhostsToCreate();
		foreach ($domains as $domain) {

			if (is_dir(Settings::Get('system.proxyconf_vhost'))) {
				safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir(Settings::Get('system.proxyconf_vhost'))));
			}

			$vhost_filename = $this->getVhostFilename($domain);

			if (! isset($this->nginx_data[$vhost_filename])) {
				$this->nginx_data[$vhost_filename] = '';
			}
			if ((empty($this->nginx_data[$vhost_filename]) && ! is_dir(Settings::Get('system.proxyconf_vhost'))) || is_dir(Settings::Get('system.proxyconf_vhost'))) {
				$domain['nonexistinguri'] = '/' . md5(uniqid(microtime(), 1)) . '.htm';
				// Create non-ssl host
				$this->nginx_data[$vhost_filename] .= $this->getVhostContent($domain, false);
				if ($domain['ssl'] == '1' || $domain['ssl_redirect'] == '1') {
					$vhost_filename_ssl = $this->getVhostFilename($domain, true);
					if (! isset($this->nginx_data[$vhost_filename_ssl])) {
						$this->nginx_data[$vhost_filename_ssl] = '';
					}
					// Now enable ssl stuff
					$this->nginx_data[$vhost_filename_ssl] .= $this->getVhostContent($domain, true);
				}
			}
		}
	}

	protected function getVhostFilename($domain, $ssl_vhost = false)
	{
		if ((int) $domain['parentdomainid'] == 0 && isCustomerStdSubdomain((int) $domain['id']) == false && ((int) $domain['ismainbutsubto'] == 0 || domainMainToSubExists($domain['ismainbutsubto']) == false)) {
			$vhost_no = '35';
		} elseif ((int) $domain['parentdomainid'] == 0 && isCustomerStdSubdomain((int) $domain['id']) == false && (int) $domain['ismainbutsubto'] > 0) {
			$vhost_no = '30';
		} else {
			// number of dots in a domain specifies it's position (and depth of subdomain) starting at 29 going downwards on higher depth
			$vhost_no = (string) (30 - substr_count($domain['domain'], ".") + 1);
		}

		if ($ssl_vhost === true) {
			$vhost_filename = makeCorrectFile(Settings::Get('system.proxyconf_vhost') . '/' . $vhost_no . '_froxlor_ssl_vhost_' . $domain['domain'] . '.conf');
		} else {
			$vhost_filename = makeCorrectFile(Settings::Get('system.proxyconf_vhost') . '/' . $vhost_no . '_froxlor_normal_vhost_' . $domain['domain'] . '.conf');
		}

		return $vhost_filename;
	}

	protected function getVhostContent($domain, $ssl_vhost = false)
	{
		if ($ssl_vhost === true && $domain['ssl'] != '1' && $domain['ssl_redirect'] != '1') {
			return '';
		}

		// check whether the customer is deactivated and NO docroot for deactivated users has been set#
		$ddr = Settings::Get('system.deactivateddocroot');
		if ($domain['deactivated'] == '1' && empty($ddr)) {
			return '# Customer deactivated and a docroot for deactivated users hasn\'t been set.' . "\n";
		}

		$vhost_content = '';
		$_vhost_content = '';

		$query = "SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` `i`, `" . TABLE_DOMAINTOIP . "` `dip`
			WHERE dip.id_domain = :domainid AND i.id = dip.id_ipandports AND proxy_port != '0' ";

		if ($ssl_vhost === true && ($domain['ssl'] == '1' || $domain['ssl_redirect'] == '1')) {
			// by ordering by cert-file the row with filled out SSL-Fields will be shown last,
			// thus it is enough to fill out 1 set of SSL-Fields
			$query .= "AND i.ssl = 1 ORDER BY i.ssl_cert_file ASC;";
		} else {
			$query .= "AND i.ssl = '0';";
		}
		$result_stmt = Database::prepare($query);
		Database::pexecute($result_stmt, array(
			'domainid' => $domain['id']
		));

		$_vhost_default = '';
		$listen = '';
		while ($ipandport = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $domain['ip'] = $ipandport['ip'];
                        $domain['port'] = $ipandport['port'];
			$domain['proxy_ip'] = $ipandport['proxy_ip'];
			$domain['proxy_port'] = $ipandport['proxy_port'];
			if ($domain['ssl'] == '1') {
				$domain['ssl_cert_file'] = $ipandport['ssl_cert_file'];
				$domain['ssl_key_file'] = $ipandport['ssl_key_file'];
				$domain['ssl_ca_file'] = $ipandport['ssl_ca_file'];
				$domain['ssl_cert_chainfile'] = $ipandport['ssl_cert_chainfile'];
				
				// SSL STUFF
				$dssl = new DomainSSL();
				// this sets the ssl-related array-indices in the $domain array
				// if the domain has customer-defined ssl-certificates
				$dssl->setDomainSSLFilesArray($domain,false);
			}

			if (filter_var($domain['proxy_ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$ipport = '[' . $domain['proxy_ip'] . ']:' . $domain['proxy_port'];
			} else {
				$ipport = $domain['proxy_ip'] . ':' . $domain['proxy_port'];
			}



			if ($ipandport['proxy_conf_domain'] != '') {
				$_vhost_content .= $this->processSpecialConfigTemplate($ipandport['proxy_conf_domain'], $domain, $domain['ip'], $domain['port'], $ssl_vhost, array(
                                                'PROXY_IP' => $domain['proxy_ip'],
                                                'PROXY_PORT' => $domain['proxy_port'],
                                        )) . "\n";
			}

			$http2 = $ssl_vhost == true && (isset($domain['http2']) && $domain['http2'] == '1' && Settings::Get('system.http2_support') == '1');

		        $listen .= "\t" . 'listen ' . $ipport . ($ssl_vhost == true ? ' ssl' : '') . ($http2 == true ? ' http2' : '') . ';' . "\n";
		}

		// respect ssl_redirect settings, #542
                if ($ssl_vhost == false && $domain['ssl'] == '1' && $domain['ssl_redirect'] == '1') {
                        // We must not check if our port differs from port 443,
                        // but if there is a destination-port != 443
                        $_sslport = '';
                        // This returns the first port that is != 443 with ssl enabled, if any
                        // ordered by ssl-certificate (if any) so that the ip/port combo
                        // with certificate is used
                        $ssldestport_stmt = Database::prepare("SELECT `ip`.`port` FROM " . TABLE_PANEL_IPSANDPORTS . " `ip`
                                LEFT JOIN `" . TABLE_DOMAINTOIP . "` `dip` ON (`ip`.`id` = `dip`.`id_ipandports`)
                                WHERE `dip`.`id_domain` = :domainid
                                AND `ip`.`ssl` = '1'  AND `ip`.`proxy_port` != 443
                                ORDER BY `ip`.`ssl_cert_file` DESC, `ip`.`proxy_port` LIMIT 1;");
                        $ssldestport = Database::pexecute_first($ssldestport_stmt, array(
                                'domainid' => $domain['id']
                        ));

                        if ($ssldestport['proxy_port'] != '') {
                                $_sslport = ":" . $ssldestport['proxy_port'];
                        }

                        $domain['documentroot'] = 'https://$host' . $_sslport . '/';
                }

                // avoid using any whitespaces
                $domain['documentroot'] = trim($domain['documentroot']);

		if($listen == '') return '';

		$vhost_content .= 'server { ' . "\n";
		$vhost_content .= $listen; 
		// get all server-names
		$vhost_content .= $this->getServerNames($domain) ."\n";

		// create ssl settings first since they are required for normal and redirect vhosts
		if ($ssl_vhost === true && $domain['ssl'] == '1' && Settings::Get('system.use_ssl') == '1') {
			$vhost_content .= $this->composeSslSettings($domain) . "\n";
		}

		if (Settings::Get('system.use_ssl') == '1' && Settings::Get('system.leenabled') == '1') {
			$vhost_content .= $this->acmeConf() . "\n";
		}

		// if the documentroot is an URL we just redirect
		if (preg_match('/^https?\:\/\//', $domain['documentroot'])) {
			$uri = $domain['documentroot'];
			if (substr($uri, - 1) == '/') {
				$uri = substr($uri, 0, - 1);
			}

			// Get domain's redirect code
			$code = getDomainRedirectCode($domain['id'], '301');

			$vhost_content .= "\t" . 'if ($request_uri !~ ^/.well-known/acme-challenge/\w+$) {' . "\n";
			$vhost_content .= "\t\t" . 'return ' . $code .' ' . $uri . '$request_uri;' . "\n";
			$vhost_content .= "\t" . '}' . "\n";
		} else {
			// already done by apache
			//mkDirWithCorrectOwnership($domain['customerroot'], $domain['documentroot'], $domain['guid'], $domain['guid'], true);

			$vhost_content .= $this->getLogFiles($domain);
			$vhost_content .= $this->getWebroot($domain, $ssl_vhost);

			if ($this->_deactivated == false) {

				$vhost_content = $this->mergeVhostCustom($vhost_content, $this->create_pathOptions($domain)) . "\n";

				$vhost_content .= isset($this->needed_htpasswds[$domain['id']]) ? $this->needed_htpasswds[$domain['id']] . "\n" : '';
				/////
				///// introduce special proxy settings??
				/////
				//if ($domain['specialsettings'] != "") {
				//	$vhost_content = $this->mergeVhostCustom($vhost_content, $this->processSpecialConfigTemplate($domain['specialsettings'], $domain, $domain['ip'], $domain['port'], $ssl_vhost));
				//}
				$vhost_content = $this->mergeVhostCustom($vhost_content, 
					$this->processSpecialConfigTemplate($this->proxyConf($domain, $domain['ip'],$domain['port']), $domain, $domain['ip'], $domain['port'],  $ssl_vhost, array(
					        'PROXY_IP' => $domain['proxy_ip'],
                                                'PROXY_PORT' => $domain['proxy_port']
					)) ."\n");
				if ($_vhost_content != '') {
					$vhost_content = $this->mergeVhostCustom($vhost_content, $_vhost_content);
				}

				if (Settings::Get('system.default_proxyconf') != '') {
					$vhost_content = $this->mergeVhostCustom($vhost_content, $this->processSpecialConfigTemplate(Settings::Get('system.default_proxyconf'), $domain, $domain['ip'], $domain['port'], $ssl_vhost, array(
                                                'PROXY_IP' => $domain['proxy_ip'],
                                                'PROXY_PORT' => $domain['proxy_port'],
                                        )) . "\n");
				}
			}
		}
		$vhost_content .= "\n}\n\n";

		return $vhost_content;
	}

	protected function mergeVhostCustom($vhost_frx, $vhost_usr)
	{
		// Clean froxlor defined settings
		$vhost_frx = explode("\n", preg_replace('/[ \t]+/', ' ', trim(preg_replace('/\t+/', '', $vhost_frx)))); // Break into array items
		$vhost_frx = array_map("trim", $vhost_frx); // remove unnecessary whitespaces

		// Clean user defined settings
		$vhost_usr = str_replace("\r", "\n", $vhost_usr); // Remove windows linebreaks
		$vhost_usr = str_replace(array(
			"{ ",
			" }"
		), array(
			"{\n",
			"\n}"
		), $vhost_usr); // Break blocks into lines
		$vhost_usr = explode("\n", preg_replace('/[ \t]+/', ' ', trim(preg_replace('/\t+/', '', $vhost_usr)))); // Break into array items
		$vhost_usr = array_filter($vhost_usr, create_function('$a', 'return preg_match("#\S#", $a);')); // Remove empty lines

		// Cycle through the user defined settings
		$currentBlock = array();
		$blockLevel = 0;
		foreach ($vhost_usr as $line) {
			$line = trim($line);
			$currentBlock[] = $line;

			if (strpos($line, "{") !== false) {
				$blockLevel ++;
			}
			if (strpos($line, "}") !== false && $blockLevel > 0) {
				$blockLevel --;
			}

			if ($line == "}" && $blockLevel == 0) {
				if (in_array($currentBlock[0], $vhost_frx)) {
					// Add to existing block
					$pos = array_search($currentBlock[0], $vhost_frx);
					do {
						$pos ++;
					} while ($vhost_frx[$pos] != "}");

					for ($i = 1; $i < count($currentBlock) - 1; $i ++) {
						array_splice($vhost_frx, $pos + $i - 1, 0, $currentBlock[$i]);
					}
				} else {
					// Add to end
					array_splice($vhost_frx, count($vhost_frx), 0, $currentBlock);
				}
				$currentBlock = array();
			} elseif ($blockLevel == 0) {
				array_splice($vhost_frx, count($vhost_frx), 0, $currentBlock);
				$currentBlock = array();
			}
		}

		$nextLevel = 0;
		for ($i = 0; $i < count($vhost_frx); $i ++) {
			if (substr_count($vhost_frx[$i], "}") != 0 && substr_count($vhost_frx[$i], "{") == 0) {
				$nextLevel -= 1;
				$vhost_frx[$i] .= "\n";
			}
			if ($nextLevel > 0) {
				for ($j = 0; $j < $nextLevel; $j ++) {
					$vhost_frx[$i] = "	" . $vhost_frx[$i];
				}
			}
			if (substr_count($vhost_frx[$i], "{") != 0 && substr_count($vhost_frx[$i], "}") == 0) {
				$nextLevel += 1;
			}
		}

		return implode("\n", $vhost_frx);
	}

	protected function composeSslSettings($domain_or_ip)
	{
		$sslsettings = '';

		if ($domain_or_ip['ssl_cert_file'] == '') {
			$domain_or_ip['ssl_cert_file'] = Settings::Get('system.ssl_cert_file');
		}

		if ($domain_or_ip['ssl_key_file'] == '') {
			$domain_or_ip['ssl_key_file'] = Settings::Get('system.ssl_key_file');
		}

		if ($domain_or_ip['ssl_ca_file'] == '') {
			$domain_or_ip['ssl_ca_file'] = Settings::Get('system.ssl_ca_file');
		}

		// #418
		if ($domain_or_ip['ssl_cert_chainfile'] == '') {
			$domain_or_ip['ssl_cert_chainfile'] = Settings::Get('system.ssl_cert_chainfile');
		}

		if ($domain_or_ip['ssl_cert_file'] != '') {

			// check for existence, #1485
			if (! file_exists($domain_or_ip['ssl_cert_file'])) {
				$this->logger->logAction(CRON_ACTION, LOG_ERR, $domain_or_ip['domain'] . ' :: certificate file "' . $domain_or_ip['ssl_cert_file'] . '" does not exist! Cannot create ssl-directives');
			} else {
				$cert = $this->makeSSLBundle($domain_or_ip);
				// obsolete: ssl on now belongs to the listen block as 'ssl' at the end
				// $sslsettings .= "\t" . 'ssl on;' . "\n";
				$sslsettings .= "\t" . 'ssl_protocols ' . str_replace(",", " ", Settings::Get('system.ssl_protocols')) . ';' . "\n";
				$sslsettings .= "\t" . 'ssl_ciphers ' . Settings::Get('system.ssl_cipher_list') . ';' . "\n";
				$sslsettings .= "\t" . 'ssl_ecdh_curve secp384r1;' . "\n";
				$sslsettings .= "\t" . 'ssl_prefer_server_ciphers on;' . "\n";
				$sslsettings .= "\t" . 'ssl_certificate ' . makeCorrectFile($cert) . ';' . "\n";

				if ($domain_or_ip['ssl_key_file'] != '') {
					// check for existence, #1485
					if (! file_exists($domain_or_ip['ssl_key_file'])) {
						$this->logger->logAction(CRON_ACTION, LOG_ERR, $domain_or_ip['domain'] . ' :: certificate key file "' . $domain_or_ip['ssl_key_file'] . '" does not exist! Cannot create ssl-directives');
					} else {
						$sslsettings .= "\t" . 'ssl_certificate_key ' . makeCorrectFile($domain_or_ip['ssl_key_file']) . ';' . "\n";
					}
				}

				if (isset($domain_or_ip['hsts']) && $domain_or_ip['hsts'] >= 0) {
					$sslsettings .= 'add_header Strict-Transport-Security "max-age=' . $domain_or_ip['hsts'];
					if ($domain_or_ip['hsts_sub'] == 1) {
						$sslsettings .= '; includeSubDomains';
					}
					if ($domain_or_ip['hsts_preload'] == 1) {
						$sslsettings .= '; preload';
					}
					$sslsettings .= '";' . "\n";
				}

				if ((isset($domain_or_ip['ocsp_stapling']) && $domain_or_ip['ocsp_stapling'] == "1") ||
						(isset($domain_or_ip['letsencrypt']) && $domain_or_ip['letsencrypt'] == "1") ) {
					$sslsettings .= "\t" . 'ssl_stapling on;' . "\n";
					$sslsettings .= "\t" . 'ssl_stapling_verify on;' . "\n";
					$sslsettings .= "\t" . 'ssl_trusted_certificate ' .
							makeCorrectFile($domain_or_ip['ssl_cert_file']) . ';' . "\n";
				}
			}
		}

		return $sslsettings;
	}

	protected function create_pathOptions($domain)
	{
		$has_location = false;

		$result_stmt = Database::prepare("
			SELECT * FROM " . TABLE_PANEL_HTACCESS . "
			WHERE `path` LIKE :docroot
		");
		Database::pexecute($result_stmt, array(
			'docroot' => $domain['documentroot'] . '%'
		));

		$path_options = '';
		$htpasswds = $this->getHtpasswds($domain);

		// for each entry in the htaccess table
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (! empty($row['error404path'])) {
				$defhandler = $row['error404path'];
				if (! validateUrl($defhandler)) {
					$defhandler = makeCorrectFile($defhandler);
				}
				$path_options .= "\t" . 'error_page   404    ' . $defhandler . ';' . "\n";
			}

			if (! empty($row['error403path'])) {
				$defhandler = $row['error403path'];
				if (! validateUrl($defhandler)) {
					$defhandler = makeCorrectFile($defhandler);
				}
				$path_options .= "\t" . 'error_page   403    ' . $defhandler . ';' . "\n";
			}

			if (! empty($row['error500path'])) {
				$defhandler = $row['error500path'];
				if (! validateUrl($defhandler)) {
					$defhandler = makeCorrectFile($defhandler);
				}
				$path_options .= "\t" . 'error_page   500 502 503 504    ' . $defhandler . ';' . "\n";
			}

			// if ($row['options_indexes'] != '0') {
			$path = makeCorrectDir(substr($row['path'], strlen($domain['documentroot']) - 1));

			mkDirWithCorrectOwnership($domain['documentroot'], $row['path'], $domain['guid'], $domain['guid']);

			$path_options .= "\t" . '# ' . $path . "\n";
			if ($path == '/') {
				if ($row['options_indexes'] != '0') {
					$this->vhost_root_autoindex = true;
				}
				$path_options .= "\t" . 'location ' . $path . ' {' . "\n";
				if ($this->vhost_root_autoindex) {
					$path_options .= "\t\t" . 'autoindex  on;' . "\n";
					$this->vhost_root_autoindex = false;
				}

				// check if we have a htpasswd for this path
				// (damn nginx does not like more than one
				// 'location'-part with the same path)
				if (count($htpasswds) > 0) {
					foreach ($htpasswds as $idx => $single) {
						switch ($single['path']) {
							case '/awstats/':
							case '/webalizer/':
								// no stats-alias in "location /"-context
								break;
							default:
								if ($single['path'] == '/') {
									$path_options .= "\t\t" . 'auth_basic            "' . $single['authname'] . '";' . "\n";
									$path_options .= "\t\t" . 'auth_basic_user_file  ' . makeCorrectFile($single['usrf']) . ';' . "\n";
									if ($domain['phpenabled_customer'] == 1 && $domain['phpenabled_vhost'] == '1') {
										$path_options .= "\t\t" . 'index    index.php index.html index.htm;' . "\n";
									} else {
										$path_options .= "\t\t" . 'index    index.html index.htm;' . "\n";
									}
									$path_options .= "\t\t" . 'location ~ ^(.+?\.php)(/.*)?$ {' . "\n";
									$path_options .= "\t\t\t" . 'try_files ' . $domain['nonexistinguri'] . ' @php;' . "\n";
									$path_options .= "\t\t" . '}' . "\n";
									// remove already used entries so we do not have doubles
									unset($htpasswds[$idx]);
								}
						}
					}
				}
				$path_options .= "\t" . '}' . "\n";

				$this->vhost_root_autoindex = false;
			} else {
				$path_options .= "\t" . 'location ' . $path . ' {' . "\n";
				if ($this->vhost_root_autoindex || $row['options_indexes'] != '0') {
					$path_options .= "\t\t" . 'autoindex  on;' . "\n";
					$this->vhost_root_autoindex = false;
				}
				$path_options .= "\t" . '} ' . "\n";
			}
			// }

		}

		// now the rest of the htpasswds
		if (count($htpasswds) > 0) {
			foreach ($htpasswds as $idx => $single) {
				// if ($single['path'] != '/') {
				switch ($single['path']) {
					case '/awstats/':
					case '/webalizer/':
						$path_options .= $this->getStats($domain, $single);
						unset($htpasswds[$idx]);
						break;
					default:
						$path_options .= "\t" . 'location ' . makeCorrectDir($single['path']) . ' {' . "\n";
						$path_options .= "\t\t" . 'auth_basic            "' . $single['authname'] . '";' . "\n";
						$path_options .= "\t\t" . 'auth_basic_user_file  ' . makeCorrectFile($single['usrf']) . ';' . "\n";
						if ($domain['phpenabled_customer'] == 1 && $domain['phpenabled_vhost'] == '1') {
							$path_options .= "\t\t" . 'index    index.php index.html index.htm;' . "\n";
						} else {
							$path_options .= "\t\t" . 'index    index.html index.htm;' . "\n";
						}
						$path_options .= "\t\t" . 'location ~ ^(.+?\.php)(/.*)?$ {' . "\n";
						$path_options .= "\t\t\t" . 'try_files ' . $domain['nonexistinguri'] . ' @php;' . "\n";
						$path_options .= "\t\t" . '}' . "\n";
						$path_options .= "\t" . '}' . "\n";
				}
				// }
				unset($htpasswds[$idx]);
			}
		}

		return $path_options;
	}

	protected function getHtpasswds($domain)
	{
		$result_stmt = Database::prepare("
			SELECT *
			FROM `" . TABLE_PANEL_HTPASSWDS . "` AS a
			JOIN `" . TABLE_PANEL_DOMAINS . "` AS b USING (`customerid`)
			WHERE b.customerid = :customerid AND b.domain = :domain
		");
		Database::pexecute($result_stmt, array(
			'customerid' => $domain['customerid'],
			'domain' => $domain['domain']
		));

		$returnval = array();
		$x = 0;
		while ($row_htpasswds = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (count($row_htpasswds) > 0) {
				$htpasswd_filename = makeCorrectFile(Settings::Get('system.apacheconf_htpasswddir') . '/' . $row_htpasswds['customerid'] . '-' . md5($row_htpasswds['path']) . '.htpasswd');

				// ensure we can write to the array with index $htpasswd_filename
				if (! isset($this->htpasswds_data[$htpasswd_filename])) {
					$this->htpasswds_data[$htpasswd_filename] = '';
				}

				$this->htpasswds_data[$htpasswd_filename] .= $row_htpasswds['username'] . ':' . $row_htpasswds['password'] . "\n";

				// if the domains and their web contents are located in a subdirectory of
				// the nginx user, we have to evaluate the right path which is to protect
				if (stripos($row_htpasswds['path'], $domain['documentroot']) !== false) {
					// if the website contents is located in the user directory
					$path = makeCorrectDir(substr($row_htpasswds['path'], strlen($domain['documentroot']) - 1));
				} else {
					// if the website contents is located in a subdirectory of the user
					preg_match('/^([\/[:print:]]*\/)([[:print:]\/]+){1}$/i', $row_htpasswds['path'], $matches);
					$path = makeCorrectDir(substr($row_htpasswds['path'], strlen($matches[1]) - 1));
				}

				$returnval[$x]['path'] = $path;
				$returnval[$x]['root'] = makeCorrectDir($domain['documentroot']);

				// Ensure there is only one auth name per password block, otherwise
				// the directives are inserted multiple times -> invalid config
				$authname = $row_htpasswds['authname'];
				for ($i = 0; $i < $x; $i ++) {
					if ($returnval[$i]['usrf'] == $htpasswd_filename) {
						$authname = $returnval[$i]['authname'];
						break;
					}
				}
				$returnval[$x]['authname'] = $authname;

				$returnval[$x]['usrf'] = $htpasswd_filename;
				$x ++;
			}
		}

		// Remove duplicate entries
		$returnval = array_map("unserialize", array_unique(array_map("serialize", $returnval)));

		return $returnval;
	}

	protected function getWebroot($domain, $ssl)
	{
		$webroot_text = '';

		if ($domain['deactivated'] == '1' && Settings::Get('system.deactivateddocroot') != '') {
			$webroot_text .= "\t" . '# Using docroot for deactivated users...' . "\n";
			$webroot_text .= "\t" . 'root     ' . makeCorrectDir(Settings::Get('system.deactivateddocroot')) . ';' . "\n";
			$this->_deactivated = true;
		} else {
			$webroot_text .= "\t" . 'root     ' . makeCorrectDir($domain['documentroot']) . ';' . "\n";
			$this->_deactivated = false;
		}

		#$webroot_text .= "\n\t" . 'location / {' . "\n";

		#if ($domain['phpenabled_customer'] == 1 && $domain['phpenabled_vhost'] == '1') {
		#	$webroot_text .= "\t" . 'index    index.php index.html index.htm;' . "\n";
		#	if ($domain['notryfiles'] != 1) {
		#		$webroot_text .= "\t\t" . 'try_files $uri $uri/ @rewrites;' . "\n";
		#	}
		#} else {
		#	$webroot_text .= "\t" . 'index    index.html index.htm;' . "\n";
		#}

		#if ($this->vhost_root_autoindex) {
		#	$webroot_text .= "\t\t" . 'autoindex on;' . "\n";
		#	$this->vhost_root_autoindex = false;
		#}

		#$webroot_text .= "\t" . '}' . "\n\n";
		if ($domain['phpenabled_customer'] == 1 && $domain['phpenabled_vhost'] == '1' && $domain['notryfiles'] != 1) {
			$webroot_text .= "\tlocation @rewrites {\n";
			$webroot_text .= "\t\trewrite ^ /index.php last;\n";
			$webroot_text .= "\t}\n\n";
		}

		return $webroot_text;
	}

	protected function getStats($domain, $single)
	{
		$stats_text = '';

		// define basic path to the stats
		if (Settings::Get('system.awstats_enabled') == '1') {
			$alias_dir = makeCorrectFile($domain['customerroot'] . '/awstats/');
		} else {
			$alias_dir = makeCorrectFile($domain['customerroot'] . '/webalizer/');
		}

		// if this is a parentdomain, we use this domain-name
		if ($domain['parentdomainid'] == '0') {
			$alias_dir = makeCorrectDir($alias_dir . '/' . $domain['domain']);
		} else {
			$alias_dir = makeCorrectDir($alias_dir . '/' . $domain['parentdomain']);
		}

		if (Settings::Get('system.awstats_enabled') == '1') {
			// awstats
			$stats_text .= "\t" . 'location /awstats {' . "\n";
		} else {
			// webalizer
			$stats_text .= "\t" . 'location /webalizer {' . "\n";
		}

		$stats_text .= "\t\t" . 'alias ' . $alias_dir . ';' . "\n";
		$stats_text .= "\t\t" . 'auth_basic            "' . $single['authname'] . '";' . "\n";
		$stats_text .= "\t\t" . 'auth_basic_user_file  ' . makeCorrectFile($single['usrf']) . ';' . "\n";
		$stats_text .= "\t" . '}' . "\n\n";

		// awstats icons
		if (Settings::Get('system.awstats_enabled') == '1') {
			$stats_text .= "\t" . 'location ~ ^/awstats-icon/(.*)$ {' . "\n";
			$stats_text .= "\t\t" . 'alias ' . makeCorrectDir(Settings::Get('system.awstats_icons')) . '$1;' . "\n";
			$stats_text .= "\t" . '}' . "\n\n";
		}

		return $stats_text;
	}

	protected function getLogFiles($domain)
	{
		$logfiles_text = '';

		$speciallogfile = '';
		if ($domain['speciallogfile'] == '1') {
			if ($domain['parentdomainid'] == '0') {
				$speciallogfile = '-' . $domain['domain'];
			} else {
				$speciallogfile = '-' . $domain['parentdomain'];
			}
		}

		// The normal access/error - logging is enabled
		$error_log = makeCorrectFile(Settings::Get('system.logfiles_directory') . $domain['loginname'] . $speciallogfile . '-proxy-error.log');
		// Create the logfile if it does not exist (fixes #46)
		touch($error_log);
		chown($error_log, Settings::Get('system.httpuser'));
		chgrp($error_log, Settings::Get('system.httpgroup'));

		$access_log = makeCorrectFile(Settings::Get('system.logfiles_directory') . $domain['loginname'] . $speciallogfile . '-proxy-access.log');
		// Create the logfile if it does not exist (fixes #46)
		touch($access_log);
		chown($access_log, Settings::Get('system.httpuser'));
		chgrp($access_log, Settings::Get('system.httpgroup'));

		$logfiles_text .= "\t" . 'access_log    ' . $access_log . ' combined;' . "\n";
		$logfiles_text .= "\t" . 'error_log    ' . $error_log . ' error;' . "\n";

		if (Settings::Get('system.awstats_enabled') == '1') {
			if ((int) $domain['parentdomainid'] == 0) {
				// prepare the aliases and subdomains for stats config files
				$server_alias = '';
				$alias_domains_stmt = Database::prepare("
					SELECT `domain`, `iswildcarddomain`, `wwwserveralias`
					FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `aliasdomain` = :domainid OR `parentdomainid` = :domainid
				");
				Database::pexecute($alias_domains_stmt, array(
					'domainid' => $domain['id']
				));

				while (($alias_domain = $alias_domains_stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
					$server_alias .= ' ' . $alias_domain['domain'] . ' ';

					if ($alias_domain['iswildcarddomain'] == '1') {
						$server_alias .= '*.' . $domain['domain'];
					} else {
						if ($alias_domain['wwwserveralias'] == '1') {
							$server_alias .= 'www.' . $alias_domain['domain'];
						} else {
							$server_alias .= '';
						}
					}
				}

				$alias = '';
				if ($domain['iswildcarddomain'] == '1') {
					$alias = '*.' . $domain['domain'];
				} elseif ($domain['wwwserveralias'] == '1') {
					$alias = 'www.' . $domain['domain'];
				}

				// After inserting the AWStats information,
				// be sure to build the awstats conf file as well
				// and chown it using $awstats_params, #258
				// Bug 960 + Bug 970 : Use full $domain instead of custom $awstats_params as following classes depend on the informations
				createAWStatsConf(Settings::Get('system.logfiles_directory') . $domain['loginname'] . $speciallogfile . '-proxy-access.log', $domain['domain'], $alias . $server_alias, $domain['customerroot'], $domain);
			}
		}

		return $logfiles_text;
	}

	public function createOwnVhostStarter()
	{}

	protected function getServerNames($domain)
	{
		$server_alias = '';

		if ($domain['iswildcarddomain'] == '1') {
			$server_alias = '*.' . $domain['domain'];
		} elseif ($domain['wwwserveralias'] == '1') {
			$server_alias = 'www.' . $domain['domain'];
		}

		$alias_domains_stmt = Database::prepare("
			SELECT `domain`, `iswildcarddomain`, `wwwserveralias`
			FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE `aliasdomain` = :domainid
		");
		Database::pexecute($alias_domains_stmt, array(
			'domainid' => $domain['id']
		));

		while (($alias_domain = $alias_domains_stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
			$server_alias .= ' ' . $alias_domain['domain'];

			if ($alias_domain['iswildcarddomain'] == '1') {
				$server_alias .= ' *.' . $alias_domain['domain'];
			} elseif ($alias_domain['wwwserveralias'] == '1') {
				$server_alias .= ' www.' . $alias_domain['domain'];
			}
		}

		$servernames_text = "\t" . 'server_name    ' . $domain['domain'];
		if (trim($server_alias) != '') {
			$servernames_text .= ' ' . $server_alias;
		}
		$servernames_text .= ';' . "\n";

		return $servernames_text;
	}

	public function writeConfigs()
	{
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "nginx::writeConfigs: rebuilding " . Settings::Get('system.proxyconf_vhost'));

		$vhostDir = new frxDirectory(Settings::Get('system.proxyconf_vhost'));
		if (! $vhostDir->isConfigDir()) {
			// Save one big file
			$vhosts_file = '';

			// sort by filename so the order is:
			// 1. subdomains
			// 2. subdomains as main-domains
			// 3. main-domains
			ksort($this->nginx_data);

			foreach ($this->nginx_data as $vhosts_filename => $vhost_content) {
				$vhosts_file .= $vhost_content . "\n\n";
			}

			$vhosts_filename = Settings::Get('system.proxyconf_vhost');

			// Apply header
			$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;
			$vhosts_file_handler = fopen($vhosts_filename, 'w');
			fwrite($vhosts_file_handler, $vhosts_file);
			fclose($vhosts_file_handler);
		} else {
			if (! file_exists(Settings::Get('system.proxyconf_vhost'))) {
				$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'nginx::writeConfigs: mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.proxyconf_vhost'))));
				safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir(Settings::Get('system.proxyconf_vhost'))));
			}

			// Write a single file for every vhost
			foreach ($this->nginx_data as $vhosts_filename => $vhosts_file) {
				$this->known_filenames[] = basename($vhosts_filename);
				if (! empty($vhosts_filename) && ! empty($vhosts_file)) {
					$header = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n";
					$vhosts_file_handler = fopen($vhosts_filename, 'w');
					fwrite($vhosts_file_handler, $header.$vhosts_file);
					fclose($vhosts_file_handler);
				}
			}
		}

		/***
		THIS IS ALREADY DONE BY APACHE TASK
		// htaccess stuff
		if (count($this->htpasswds_data) > 0) {
			if (! file_exists(Settings::Get('system.apacheconf_htpasswddir'))) {
				$umask = umask();
				umask(0000);
				mkdir(Settings::Get('system.apacheconf_htpasswddir'), 0751);
				umask($umask);
			} elseif (! is_dir(Settings::Get('system.apacheconf_htpasswddir'))) {
				$this->logger->logAction(CRON_ACTION, LOG_WARNING, 'WARNING!!! ' . Settings::Get('system.apacheconf_htpasswddir') . ' is not a directory. htpasswd directory protection is disabled!!!');
			}

			if (is_dir(Settings::Get('system.apacheconf_htpasswddir'))) {
				foreach ($this->htpasswds_data as $htpasswd_filename => $htpasswd_file) {
					$this->known_htpasswdsfilenames[] = basename($htpasswd_filename);
					$htpasswd_file_handler = fopen($htpasswd_filename, 'w');
					// Filter duplicate pairs of username and password
					$htpasswd_file = implode("\n", array_unique(explode("\n", $htpasswd_file)));
					fwrite($htpasswd_file_handler, $htpasswd_file);
					fclose($htpasswd_file_handler);
				}
			}
		}
		****/
	}
}
