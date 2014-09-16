<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

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

class nginx {
	private $logger = false;
	private $debugHandler = false;
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

	public function __construct($logger, $debugHandler, $idnaConvert, $nginx_server=array()) {
		$this->logger = $logger;
		$this->debugHandler = $debugHandler;
		$this->idnaConvert = $idnaConvert;
		$this->nginx_server = $nginx_server;
	}


	public function reload() {
		fwrite($this->debugHandler, '   nginx::reload: reloading nginx' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading nginx');
		safe_exec(Settings::Get('system.apachereload_command'));

		/**
		 * nginx does not auto-spawn fcgi-processes
		 */
		if (Settings::Get('system.phpreload_command') != ''
			&& (int)Settings::Get('phpfpm.enabled') == 0
		) {
			fwrite($this->debugHandler, '   nginx::reload: restarting php processes' . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'restarting php processes');
			safe_exec(Settings::Get('system.phpreload_command'));
		} elseif ((int)Settings::Get('phpfpm.enabled') == 1) {
			fwrite($this->debugHandler, '   nginx::reload: reloading php-fpm' . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading php-fpm');
			safe_exec(escapeshellcmd(Settings::Get('phpfpm.reload')));
		}
	}


	/**
	 * define a default ErrorDocument-statement, bug #unknown-yet
	 */
	private function _createStandardErrorHandler() {
		if (Settings::Get('defaultwebsrverrhandler.enabled') == '1'
			&& (Settings::Get('defaultwebsrverrhandler.err401') != ''
				|| Settings::Get('defaultwebsrverrhandler.err403') != ''
				|| Settings::Get('defaultwebsrverrhandler.err404') != ''
				|| Settings::Get('defaultwebsrverrhandler.err500') != '')
		) {
			$vhosts_folder = '';
			if (is_dir(Settings::Get('system.apacheconf_vhost'))) {
				$vhosts_folder = makeCorrectDir(Settings::Get('system.apacheconf_vhost'));
			} else {
				$vhosts_folder = makeCorrectDir(dirname(Settings::Get('system.apacheconf_vhost')));
			}

			$vhosts_filename = makeCorrectFile($vhosts_folder . '/05_froxlor_default_errorhandler.conf');

			if (!isset($this->nginx_data[$vhosts_filename])) {
				$this->nginx_data[$vhosts_filename] = '';
			}

			$statusCodes = array('401', '403', '404', '500');
			foreach ($statusCodes as $statusCode) {
				if (Settings::Get('defaultwebsrverrhandler.err' . $statusCode) != '') {
					$defhandler = Settings::Get('defaultwebsrverrhandler.err' . $statusCode);
					if (!validateUrl($defhandler)) {
						$defhandler = makeCorrectFile($defhandler);
					}
					$this->nginx_data[$vhosts_filename].= 'error_page ' . $statusCode . ' ' . $defhandler . ';' . "\n";
				}
			}
		}
	}


	public function createVirtualHosts() {
	}


	public function createFileDirOptions() {
	}


	public function createIpPort() {
		$result_ipsandports_stmt = Database::query("
			SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `ip` ASC, `port` ASC
		");

		while ($row_ipsandports = $result_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (filter_var($row_ipsandports['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$ip = '[' . $row_ipsandports['ip'] . ']';
			} else {
				$ip = $row_ipsandports['ip'];
			}
			$port = $row_ipsandports['port'];

			fwrite($this->debugHandler, '  nginx::createIpPort: creating ip/port settings for  ' . $ip . ":" . $port . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'creating ip/port settings for  ' . $ip . ":" . $port);
			$vhost_filename = makeCorrectFile(Settings::Get('system.apacheconf_vhost') . '/10_froxlor_ipandport_' . trim(str_replace(':', '.', $row_ipsandports['ip']), '.') . '.' . $row_ipsandports['port'] . '.conf');

			if (!isset($this->nginx_data[$vhost_filename])) {
				$this->nginx_data[$vhost_filename] = '';
			}

			if ($row_ipsandports['vhostcontainer'] == '1') {

				$this->nginx_data[$vhost_filename] .= 'server { ' . "\n";

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
					if ($row_ipsandports['ssl_cert_file'] != '') {
						$ssl_vhost = true;
					}
				}

				/**
				 * this HAS to be set for the default host in nginx or else no vhost will work
				 */
				$this->nginx_data[$vhost_filename] .= "\t". 'listen    ' . $ip . ':' . $port . ' default'. ($ssl_vhost == true ? ' ssl' : '') . ';' . "\n";

				$this->nginx_data[$vhost_filename] .= "\t".'# Froxlor default vhost' . "\n";
				$this->nginx_data[$vhost_filename] .= "\t".'server_name    ' . Settings::Get('system.hostname') . ';' . "\n";
				$this->nginx_data[$vhost_filename] .= "\t".'access_log      /var/log/nginx/access.log;' . "\n";

				$mypath = '';

				// no custom docroot set?
				if ($row_ipsandports['docroot'] == '') {
					// check whether the hostname should directly point to
					// the froxlor-installation or not
					if (Settings::Get('system.froxlordirectlyviahostname')) {
						$mypath = makeCorrectDir(dirname(dirname(dirname(__FILE__))));
					} else {
						$mypath = makeCorrectDir(dirname(dirname(dirname(dirname(__FILE__)))));
					}
				} else {
					// user-defined docroot, #417
					$mypath = makeCorrectDir($row_ipsandports['docroot']);
				}

				$this->nginx_data[$vhost_filename] .= "\t".'root     '.$mypath.';'."\n";
				$this->nginx_data[$vhost_filename] .= "\t".'location / {'."\n";
				$this->nginx_data[$vhost_filename] .= "\t\t".'index    index.php index.html index.htm;'."\n";
				$this->nginx_data[$vhost_filename] .= "\t".'}'."\n";

				if ($row_ipsandports['specialsettings'] != '') {
					$this->nginx_data[$vhost_filename].= $row_ipsandports['specialsettings'] . "\n";
				}

				/**
				 * SSL config options
				 */
				if ($row_ipsandports['ssl'] == '1') {
					$this->nginx_data[$vhost_filename].=$this->composeSslSettings($row_ipsandports);
				}

				$this->nginx_data[$vhost_filename] .= "\tlocation ~ \.php {\n";
				$this->nginx_data[$vhost_filename] .= "\t\tfastcgi_split_path_info ^(.+\.php)(/.+)\$;\n";
				$this->nginx_data[$vhost_filename] .= "\t\tinclude fastcgi_params;\n";
				$this->nginx_data[$vhost_filename] .= "\t\tinclude ".Settings::Get('nginx.fastcgiparams').";\n";
				$this->nginx_data[$vhost_filename] .= "\t\tfastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;\n";
				$this->nginx_data[$vhost_filename] .= "\t\tfastcgi_param PATH_INFO \$fastcgi_path_info;\n";
				$this->nginx_data[$vhost_filename] .= "\t\tif (!-e \$document_root\$fastcgi_script_name) {\n";
				$this->nginx_data[$vhost_filename] .= "\t\t\treturn 404;\n";
				$this->nginx_data[$vhost_filename] .= "\t\t}\n";
				
				if ($row_ipsandports['ssl'] == '1') {
					$this->nginx_data[$vhost_filename] .= "\t\tfastcgi_param HTTPS on;\n";
				}
				
				if ((int)Settings::Get('phpfpm.enabled') == 1 && (int)Settings::Get('phpfpm.enabled_ownvhost') == 1) {
					$domain = array(
						'id' => 'none',
						'domain' => Settings::Get('system.hostname'),
						'adminid' => 1, /* first admin-user (superadmin) */
						'mod_fcgid_starter' => -1,
						'mod_fcgid_maxrequests' => -1,
						'guid' => Settings::Get('phpfpm.vhost_httpuser'),
						'openbasedir' => 0,
						'email' => Settings::Get('panel.adminmail'),
						'loginname' => 'froxlor.panel',
						'documentroot' => $mypath,
					);
					
					$php = new phpinterface($domain);
					$this->nginx_data[$vhost_filename] .= "\t\tfastcgi_pass unix:".$php->getInterface()->getSocketFile().";\n";
				} else {
					$this->nginx_data[$vhost_filename] .= "\t\tfastcgi_pass ".Settings::Get('system.nginx_php_backend').";\n";
				}
				
				$this->nginx_data[$vhost_filename] .= "\t\tfastcgi_index index.php;\n";
				$this->nginx_data[$vhost_filename] .= "\t}\n";
				
				$this->nginx_data[$vhost_filename] .= "}\n\n";
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
	protected function createNginxHosts() {

		$domains = WebserverBase::getVhostsToCreate();
		foreach ($domains as $domain) {

			if (is_dir(Settings::Get('system.apacheconf_vhost'))) {
				safe_exec('mkdir -p '.escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost'))));
			}

			$vhost_filename = $this->getVhostFilename($domain);

			if (!isset($this->nginx_data[$vhost_filename])) {
				$this->nginx_data[$vhost_filename] = '';
			}

			if ((empty($this->nginx_data[$vhost_filename])
					&& !is_dir(Settings::Get('system.apacheconf_vhost')))
				|| is_dir(Settings::Get('system.apacheconf_vhost'))
			) {
				// Create non-ssl host
				$this->nginx_data[$vhost_filename].= $this->getVhostContent($domain, false);
				if ($domain['ssl'] == '1' || $domain['ssl_redirect'] == '1') {
					$vhost_filename_ssl = $this->getVhostFilename($domain, true);
					if (!isset($this->nginx_data[$vhost_filename_ssl])) {
						$this->nginx_data[$vhost_filename_ssl] = '';
					}
					// Now enable ssl stuff
					$this->nginx_data[$vhost_filename_ssl] .= $this->getVhostContent($domain, true);
				}
			}
		}
	}


	protected function getVhostFilename($domain, $ssl_vhost = false) {
		if ((int)$domain['parentdomainid'] == 0
			&& isCustomerStdSubdomain((int)$domain['id']) == false
			&& ((int)$domain['ismainbutsubto'] == 0
				|| domainMainToSubExists($domain['ismainbutsubto']) == false)
		) {
			$vhost_no = '22';
		} elseif ((int)$domain['parentdomainid'] == 0
			&& isCustomerStdSubdomain((int)$domain['id']) == false
			&& (int)$domain['ismainbutsubto'] > 0
		) {
			$vhost_no = '21';
		} else {
			$vhost_no = '20';
		}

		if ($ssl_vhost === true) {
			$vhost_filename = makeCorrectFile(Settings::Get('system.apacheconf_vhost') . '/'.$vhost_no.'_froxlor_ssl_vhost_' . $domain['domain'] . '.conf');
		} else {
			$vhost_filename = makeCorrectFile(Settings::Get('system.apacheconf_vhost') . '/'.$vhost_no.'_froxlor_normal_vhost_' . $domain['domain'] . '.conf');
		}

		return $vhost_filename;
	}


	protected function getVhostContent($domain, $ssl_vhost = false) {
		if ($ssl_vhost === true
			&& $domain['ssl'] != '1'
			&& $domain['ssl_redirect'] != '1'
		) {
			return '';
		}

		$vhost_content = '';
		$_vhost_content = '';

		$query = "SELECT * FROM `".TABLE_PANEL_IPSANDPORTS."` `i`, `".TABLE_DOMAINTOIP."` `dip`
			WHERE dip.id_domain = :domainid AND i.id = dip.id_ipandports ";

		if ($ssl_vhost === true
			&& ($domain['ssl'] == '1' || $domain['ssl_redirect'] == '1')
		) {
			// by ordering by cert-file the row with filled out SSL-Fields will be shown last,
			// thus it is enough to fill out 1 set of SSL-Fields
			$query .= "AND i.ssl = 1 ORDER BY i.ssl_cert_file ASC;";
		} else {
			$query .= "AND i.ssl = '0';";
		}

		// start vhost
		$vhost_content.= 'server { ' . "\n";

		$result_stmt = Database::prepare($query);
		Database::pexecute($result_stmt, array('domainid' => $domain['id']));

		while ($ipandport = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			$domain['ip'] = $ipandport['ip'];
			$domain['port'] = $ipandport['port'];
			if ($domain['ssl'] == '1') {
				$domain['ssl_cert_file'] = $ipandport['ssl_cert_file'];
				$domain['ssl_key_file'] = $ipandport['ssl_key_file'];
				$domain['ssl_ca_file'] = $ipandport['ssl_ca_file'];
				$domain['ssl_cert_chainfile'] = $ipandport['ssl_cert_chainfile'];

				// SSL STUFF
				$dssl = new DomainSSL();
				// this sets the ssl-related array-indices in the $domain array
				// if the domain has customer-defined ssl-certificates
				$dssl->setDomainSSLFilesArray($domain);
			}

			if (filter_var($domain['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$ipport = '[' . $domain['ip'] . ']:' . $domain['port'];
			} else {
				$ipport = $domain['ip'] . ':' . $domain['port'];
			}

			if ($ipandport['default_vhostconf_domain'] != '') {
				$_vhost_content .= $ipandport['default_vhostconf_domain'] . "\n";
			}

			$vhost_content.= "\t" . 'listen ' . $ipport . ($ssl_vhost == true ? ' ssl' : '') . ';' . "\n";
		}

		// get all server-names
		$vhost_content .= $this->getServerNames($domain);

		// respect ssl_redirect settings, #542
		if ($ssl_vhost == false
			&& $domain['ssl'] == '1'
			&& $domain['ssl_redirect'] == '1') {
			// We must not check if our port differs from port 443,
			// but if there is a destination-port != 443
			$_sslport = '';
			// This returns the first port that is != 443 with ssl enabled, if any
			// ordered by ssl-certificate (if any) so that the ip/port combo
			// with certificate is used
			$ssldestport_stmt = Database::prepare(
				"SELECT `ip`.`port` FROM ".TABLE_PANEL_IPSANDPORTS." `ip`
				LEFT JOIN `".TABLE_DOMAINTOIP."` `dip` ON (`ip`.`id` = `dip`.`id_ipandports`)
				WHERE `dip`.`id_domain` = :domainid
				AND `ip`.`ssl` = '1'  AND `ip`.`port` != 443
				ORDER BY `ip`.`ssl_cert_file` DESC, `ip`.`port` LIMIT 1;"
			);
			$ssldestport = Database::pexecute_first($ssldestport_stmt, array('domainid' => $domain['id']));

			if ($ssldestport['port'] != '') {
				$_sslport = ":".$ssldestport['port'];
			}

			$domain['documentroot'] = 'https://' . $domain['domain'] . $_sslport . '/';
		}

		// if the documentroot is an URL we just redirect
		if (preg_match('/^https?\:\/\//', $domain['documentroot'])) {
			$uri = $this->idnaConvert->encode($domain['documentroot']);
			if (substr($uri, -1) == '/') {
				$uri = substr($uri, 0, -1);
			}
			$vhost_content .= "\t".'rewrite ^(.*) '.$uri.'$1 permanent;'."\n";
		} else {
			mkDirWithCorrectOwnership($domain['customerroot'], $domain['documentroot'], $domain['guid'], $domain['guid'], true);

			$vhost_content .= $this->getLogFiles($domain);
			$vhost_content .= $this->getWebroot($domain, $ssl_vhost);

			if ($this->_deactivated == false) {

				if ($ssl_vhost === true
					&& $domain['ssl'] == '1'
					&& Settings::Get('system.use_ssl') == '1'
				) {
					$vhost_content.= $this->composeSslSettings($domain);
				}
				$vhost_content.= $this->create_pathOptions($domain);
				$vhost_content.= $this->composePhpOptions($domain, $ssl_vhost);

				$vhost_content.= isset($this->needed_htpasswds[$domain['id']]) ? $this->needed_htpasswds[$domain['id']] . "\n" : '';

				if ($domain['specialsettings'] != "") {
					$vhost_content .= $domain['specialsettings'] . "\n";
				}

				if ($_vhost_content != '') {
					$vhost_content .= $_vhost_content;
				}

				if (Settings::Get('system.default_vhostconf') != '') {
					$vhost_content .= Settings::Get('system.default_vhostconf') . "\n";
				}
			}
		}
		$vhost_content .= '}' . "\n\n";

		return $this->mergeVhostBlocks($vhost_content);
	}


	protected function mergeVhostBlocks($vhost_content) {
		$vhost_content = str_replace("\r", "\n", $vhost_content); // Remove windows linebreaks
		$vhost_content = preg_replace('/^[\s\t]*#.*/m', "", $vhost_content); // Remove comments
		$vhost_content = str_replace(array("{", "}"), array("{\n", "\n}"), $vhost_content); // Break blocks into lines
		$vhost_content = explode("\n", preg_replace('/[ \t]+/', ' ', trim(preg_replace('/\t+/', '', $vhost_content))));
		$vhost_content = array_filter($vhost_content, create_function('$a','return preg_match("#\S#", $a);'));

		// Merge similar blocks
		$new_vhost_content = array();
		$isOpen = false;
		$addAfter = false;
		foreach ($vhost_content as $line) {
			$line = trim($line);

			if (substr_count($line, "{") != 0 && substr_count($line, "}") == 0 && substr_count($line, "server") == 0 && $isOpen === false) {
				$isOpen = true;
				$addAfter = array_search($line, $new_vhost_content);
				if ($addAfter === false) {
					$new_vhost_content[] = $line;
				}
			} elseif ($isOpen === true) {
				if (substr_count($line, "}") != 0 && substr_count($line, "{") == 0) {
					$isOpen = false;
					if ($addAfter === false) {
						$new_vhost_content[] = "}";
					} else {
						$addAfter = false;
					}
				} else {
					if ($addAfter != false) {
						for ($i = $addAfter; $i < count($new_vhost_content); $i++) {
							if ($new_vhost_content[$i] == "}") {
								$addAt = $i;
								break;
							}
						}
						array_splice($new_vhost_content, $addAt, 0, $line);
					} else {
						$new_vhost_content[] = $line;
					}
				}
			} else {
				$new_vhost_content[] = $line;
			}
		}

		// Fix idention
		$nextLevel = 0;
		for ($i = 0; $i < count($new_vhost_content); $i++) {
			if (substr_count($new_vhost_content[$i], "}") != 0 && substr_count($new_vhost_content[$i], "{") == 0) {
				$nextLevel -= 1;
			}
			if ($nextLevel > 0) {
				for ($j = 0; $j < $nextLevel; $j++) {
					$new_vhost_content[$i] = "	" . $new_vhost_content[$i];
				}
			}
			if (substr_count($new_vhost_content[$i], "{") != 0 && substr_count($new_vhost_content[$i], "}") == 0) {
				$nextLevel += 1;
			}
		}

		return implode("\n", $new_vhost_content);
	}


	protected function composeSslSettings($domain) {

		$sslsettings = '';

		if ($domain['ssl_cert_file'] == '') {
			$domain['ssl_cert_file'] = Settings::Get('system.ssl_cert_file');
		}

		if ($domain['ssl_key_file'] == '') {
			$domain['ssl_key_file'] = Settings::Get('system.ssl_key_file');
		}

		if ($domain['ssl_ca_file'] == '') {
			$domain['ssl_ca_file'] = Settings::Get('system.ssl_ca_file');
		}

		// #418
		if ($domain['ssl_cert_chainfile'] == '') {
			$domain['ssl_cert_chainfile'] = Settings::Get('system.ssl_cert_chainfile');
		}

		if ($domain['ssl_cert_file'] != '') {
			// obsolete: ssl on now belongs to the listen block as 'ssl' at the end
			//$sslsettings .= "\t" . 'ssl on;' . "\n";
			$sslsettings .= "\t" . 'ssl_protocols SSLv3 TLSv1 TLSv1.1 TLSv1.2;' . "\n";
			$sslsettings .= "\t" . 'ssl_ciphers ' . Settings::Get('system.ssl_cipher_list') . ';' . "\n";
			$sslsettings .= "\t" . 'ssl_prefer_server_ciphers on;' . "\n";
			$sslsettings .= "\t" . 'ssl_certificate ' . makeCorrectFile($domain['ssl_cert_file']) . ';' . "\n";

			if ($domain['ssl_key_file'] != '') {
				$sslsettings .= "\t" . 'ssl_certificate_key ' .makeCorrectFile($domain['ssl_key_file']) . ';' .  "\n";
			}

			if ($domain['ssl_ca_file'] != '') {
				$sslsettings.= "\t" . 'ssl_client_certificate ' . makeCorrectFile($domain['ssl_ca_file']) . ';' . "\n";
			}
		}

		return $sslsettings;
	}


	protected function create_pathOptions($domain) {
		$has_location = false;

		$result_stmt = Database::prepare("
			SELECT * FROM " . TABLE_PANEL_HTACCESS . "
			WHERE `path` LIKE :docroot
		");
		Database::pexecute($result_stmt, array('docroot' => $domain['documentroot'] . '%'));

		$path_options = '';
		$htpasswds = $this->getHtpasswds($domain);

		// for each entry in the htaccess table
		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (!empty($row['error404path'])) {
				$defhandler = $row['error404path'];
				if (!validateUrl($defhandler)) {
					$defhandler = makeCorrectFile($defhandler);
				}
				$path_options .= "\t".'error_page   404    ' . $defhandler . ';' . "\n";
			}

			if (!empty($row['error403path'])) {
				$defhandler = $row['error403path'];
				if (!validateUrl($defhandler)) {
					$defhandler = makeCorrectFile($defhandler);
				}
				$path_options .= "\t".'error_page   403    ' . $defhandler . ';' . "\n";
			}

			if (!empty($row['error500path'])) {
				$defhandler = $row['error500path'];
				if (!validateUrl($defhandler)) {
					$defhandler = makeCorrectFile($defhandler);
				}
				$path_options .= "\t".'error_page   500 502 503 504    ' . $defhandler . ';' . "\n";
			}

			//   if ($row['options_indexes'] != '0') {
			$path = makeCorrectDir(substr($row['path'], strlen($domain['documentroot']) - 1));

			mkDirWithCorrectOwnership($domain['documentroot'], $row['path'], $domain['guid'], $domain['guid']);

			$path_options .= "\t".'# '.$path."\n";
			if ($path == '/') {
				if ($row['options_indexes'] != '0') {
					$this->vhost_root_autoindex = true;
				}
				$path_options .= "\t".'location ' . $path . ' {' . "\n";
				if ($this->vhost_root_autoindex) {
					$path_options .= "\t\t" . 'autoindex  on;' . "\n";
					$this->vhost_root_autoindex = false;
				}
				else {
					$path_options.= "\t\t" . 'index    index.php index.html index.htm;'."\n";
				}
				//     $path_options.= "\t\t" . 'try_files $uri $uri/ @rewrites;'."\n";
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
								$path_options .= "\t\t" . 'auth_basic            "Restricted Area";' . "\n";
								$path_options .= "\t\t" . 'auth_basic_user_file  ' . makeCorrectFile($single['usrf']) . ';'."\n";
								// remove already used entries so we do not have doubles
								unset($htpasswds[$idx]);
							}
						}
					}
				}
				$path_options .= "\t".'}' . "\n";

				$this->vhost_root_autoindex = false;
			} else {
				$path_options .= "\t".'location ' . $path . ' {' . "\n";
				if ($this->vhost_root_autoindex || $row['options_indexes'] != '0') {
					$path_options .= "\t\t" . 'autoindex  on;' . "\n";
					$this->vhost_root_autoindex = false;
				}
				else {
					$path_options .= "\t\t" . 'index    index.php index.html index.htm;'."\n";
				}
				$path_options .= "\t".'} ' . "\n";
			}
			//   }

			/**
			 * Perl support
			 * required the fastCGI wrapper to be running to receive the CGI requests.
			 */
			if (customerHasPerlEnabled($domain['customerid'])
				&& $row['options_cgi'] != '0'
			) {
				$path = makeCorrectDir(substr($row['path'], strlen($domain['documentroot']) - 1));
				mkDirWithCorrectOwnership($domain['documentroot'], $row['path'], $domain['guid'], $domain['guid']);

				// We need to remove the last slash, otherwise the regex wouldn't work
				if ($row['path'] != $domain['documentroot']) {
					$path = substr($path, 0, -1);
				}
				$path_options .= "\t" . 'location ~ \(.pl|.cgi)$ {' . "\n";
				$path_options .= "\t\t" . 'gzip off; #gzip makes scripts feel slower since they have to complete before getting gzipped' . "\n";
				$path_options .= "\t\t" . 'fastcgi_pass  '. Settings::Get('system.perl_server') . ';' . "\n";
				$path_options .= "\t\t" . 'fastcgi_index index.cgi;' . "\n";
				$path_options .= "\t\t" . 'include '.Settings::Get('nginx.fastcgiparams').';'."\n";
				$path_options .= "\t" . '}' . "\n";
			}

		}

		// now the rest of the htpasswds
		if (count($htpasswds) > 0) {
			foreach ($htpasswds as $idx => $single) {
				//if ($single['path'] != '/') {
				switch ($single['path']) {
				case '/awstats/':
				case '/webalizer/':
					$path_options .= $this->getStats($domain,$single);
					unset($htpasswds[$idx]);
					break;
				default:
					$path_options .= "\t" . 'location ' . makeCorrectDir($single['path']) . ' {' . "\n";
					$path_options .= "\t\t" . 'auth_basic            "Restricted Area";' . "\n";
					$path_options .= "\t\t" . 'auth_basic_user_file  ' . makeCorrectFile($single['usrf']) . ';'."\n";
					$path_options .= "\t".'}' . "\n";
				}
				//}
				unset($htpasswds[$idx]);
			}
		}

		return $path_options;
	}


	protected function getHtpasswds($domain) {

		$result_stmt = Database::prepare("
			SELECT DISTINCT *
			FROM `" . TABLE_PANEL_HTPASSWDS . "` AS a
			JOIN `" . TABLE_PANEL_DOMAINS . "` AS b USING (`customerid`)
			WHERE b.customerid = :customerid AND b.domain = :domain
		");
		Database::pexecute($result_stmt, array('customerid' => $domain['customerid'], 'domain' => $domain['domain']));

		$returnval = array();
		$x = 0;
		while ($row_htpasswds = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (count($row_htpasswds) > 0) {
				$htpasswd_filename = makeCorrectFile(Settings::Get('system.apacheconf_htpasswddir') . '/' . $row_htpasswds['customerid'] . '-' . md5($row_htpasswds['path']) . '.htpasswd');

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


	protected function composePhpOptions($domain, $ssl_vhost = false) {
		$phpopts = '';
		if ($domain['phpenabled'] == '1') {
			$phpopts = "\tlocation ~ \.php {\n";
			$phpopts .= "\t\tfastcgi_split_path_info ^(.+\.php)(/.+)\$;\n";
			$phpopts .= "\t\tinclude ".Settings::Get('nginx.fastcgiparams').";\n";
			$phpopts .= "\t\tfastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;\n";
			$phpopts .= "\t\tfastcgi_param PATH_INFO \$fastcgi_path_info;\n";
			$phpopts .= "\t\tif (!-e \$document_root\$fastcgi_script_name) {\n";
			$phpopts .= "\t\t\treturn 404;\n";
			$phpopts .= "\t\t}\n";
			$phpopts .= "\t\tfastcgi_pass ".Settings::Get('system.nginx_php_backend').";\n";
			$phpopts .= "\t\tfastcgi_index index.php;\n";
			if ($domain['ssl'] == '1' && $ssl_vhost) {
				$phpopts .= "\t\tfastcgi_param HTTPS on;\n";
			}
			$phpopts .= "\t}\n\n";
			
		}
		return $phpopts;
	}
	

	protected function getWebroot($domain, $ssl) {
		$webroot_text = '';

		if ($domain['deactivated'] == '1'
			&& Settings::Get('system.deactivateddocroot') != ''
		) {
			$webroot_text .= "\t".'# Using docroot for deactivated users...' . "\n";
			$webroot_text .= "\t".'root     '.makeCorrectDir(Settings::Get('system.deactivateddocroot')).';'."\n";
			$this->_deactivated = true;
		} else {
			$webroot_text .= "\t".'root     '.makeCorrectDir($domain['documentroot']).';'."\n";
			$this->_deactivated = false;
		}

		$webroot_text .= "\n\t".'location / {'."\n";
		$webroot_text .= "\t\t".'index    index.php index.html index.htm;'."\n";
		$webroot_text .= "\t\t" . 'try_files $uri $uri/ @rewrites;'."\n";

		if ($this->vhost_root_autoindex) {
			$webroot_text .= "\t\t".'autoindex on;'."\n";
			$this->vhost_root_autoindex = false;
		}

		$webroot_text .= "\t".'}'."\n\n";
		$webroot_text .= "\tlocation @rewrites {\n";
		$webroot_text .= "\t\trewrite ^ /index.php last;\n";
		$webroot_text .= "\t}\n\n";

		return $webroot_text;
	}


	protected function getStats($domain, $single) {
		$stats_text = '';

		// define basic path to the stats
		if (Settings::Get('system.awstats_enabled') == '1') {
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

		if (Settings::Get('system.awstats_enabled') == '1') {
			// awstats
			$stats_text .= "\t" . 'location /awstats {' . "\n";
		} else {
			// webalizer
			$stats_text .= "\t" . 'location /webalizer {' . "\n";
		}

		$stats_text .= "\t\t" . 'alias ' . $alias_dir . ';' . "\n";
		$stats_text .= "\t\t" . 'auth_basic            "Restricted Area";' . "\n";
		$stats_text .= "\t\t" . 'auth_basic_user_file  ' . makeCorrectFile($single['usrf']) . ';'."\n";
		$stats_text .= "\t" . '}' . "\n\n";

		// awstats icons
		if (Settings::Get('system.awstats_enabled') == '1') {
			$stats_text .= "\t" . 'location ~ ^/awstats-icon/(.*)$ {' . "\n";
			$stats_text .= "\t\t" . 'alias ' . makeCorrectDir(Settings::Get('system.awstats_icons')) . '$1;' . "\n";
			$stats_text .= "\t" . '}' . "\n\n";
		}

		return $stats_text;
	}


	protected function getLogFiles($domain) {
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
		$error_log = makeCorrectFile(Settings::Get('system.logfiles_directory') . $domain['loginname'] . $speciallogfile . '-error.log');
		// Create the logfile if it does not exist (fixes #46)
		touch($error_log);
		chown($error_log, Settings::Get('system.httpuser'));
		chgrp($error_log, Settings::Get('system.httpgroup'));

		$access_log = makeCorrectFile(Settings::Get('system.logfiles_directory') . $domain['loginname'] . $speciallogfile . '-access.log');
		// Create the logfile if it does not exist (fixes #46)
		touch($access_log);
		chown($access_log, Settings::Get('system.httpuser'));
		chgrp($access_log, Settings::Get('system.httpgroup'));

		$logfiles_text .= "\t".'access_log    ' . $access_log . ' combined;' . "\n";
		$logfiles_text .= "\t".'error_log    ' . $error_log . ' error;' . "\n";

		if (Settings::Get('system.awstats_enabled') == '1') {
			if ((int)$domain['parentdomainid'] == 0) {
				// prepare the aliases and subdomains for stats config files
				$server_alias = '';
				$alias_domains_stmt = Database::prepare("
					SELECT `domain`, `iswildcarddomain`, `wwwserveralias`
					FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `aliasdomain` = :domainid OR `parentdomainid` = :domainid
				");
				Database::pexecute($alias_domains_stmt, array('domainid' => $domain['id']));

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
				createAWStatsConf(Settings::Get('system.logfiles_directory') . $domain['loginname'] . $speciallogfile . '-access.log', $domain['domain'], $alias . $server_alias, $domain['customerroot'], $domain);
			}
		}

		return $logfiles_text;
	}


	public function createOwnVhostStarter() {
	}


	protected function getServerNames($domain) {
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
		Database::pexecute($alias_domains_stmt, array('domainid' => $domain['id']));

		while (($alias_domain = $alias_domains_stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
			$server_alias .= ' ' . $alias_domain['domain'];

			if ($alias_domain['iswildcarddomain'] == '1') {
				$server_alias .= ' *.' . $alias_domain['domain'];
			} elseif ($alias_domain['wwwserveralias'] == '1') {
				$server_alias.= ' www.' . $alias_domain['domain'];
			}
		}

		$servernames_text = "\t".'server_name    '.$domain['domain'];
		if (trim($server_alias) != '') {
			$servernames_text .= ' '.$server_alias;
		}
		$servernames_text .= ';' . "\n";

		return $servernames_text;
	}


	public function writeConfigs() {
		fwrite($this->debugHandler, '  nginx::writeConfigs: rebuilding ' . Settings::Get('system.apacheconf_vhost') . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "rebuilding " . Settings::Get('system.apacheconf_vhost'));

		if (!isConfigDir(Settings::Get('system.apacheconf_vhost'))) {
			// Save one big file
			$vhosts_file = '';

			// sort by filename so the order is:
			// 1. subdomains
			// 2. subdomains as main-domains
			// 3. main-domains
			ksort($this->nginx_data);

			foreach ($this->nginx_data as $vhosts_filename => $vhost_content) {
				$vhosts_file.= $vhost_content . "\n\n";
			}

			$vhosts_filename = Settings::Get('system.apacheconf_vhost');

			// Apply header
			$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;
			$vhosts_file_handler = fopen($vhosts_filename, 'w');
			fwrite($vhosts_file_handler, $vhosts_file);
			fclose($vhosts_file_handler);
		} else {
			if (!file_exists(Settings::Get('system.apacheconf_vhost'))) {
				fwrite($this->debugHandler, '  nginx::writeConfigs: mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost'))) . "\n");
				$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost'))));
				safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost'))));
			}

			// Write a single file for every vhost
			foreach ($this->nginx_data as $vhosts_filename => $vhosts_file) {
				$this->known_filenames[] = basename($vhosts_filename);

				// Apply header
				$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;

				if (!empty($vhosts_filename)) {
					$vhosts_file_handler = fopen($vhosts_filename, 'w');
					fwrite($vhosts_file_handler, $vhosts_file);
					fclose($vhosts_file_handler);
				}

			}
		}

		// htaccess stuff
		if (count($this->htpasswds_data) > 0) {
			if (!file_exists(Settings::Get('system.apacheconf_htpasswddir'))) {
				$umask = umask();
				umask(0000);
				mkdir(Settings::Get('system.apacheconf_htpasswddir'), 0751);
				umask($umask);
			} elseif (!is_dir(Settings::Get('system.apacheconf_htpasswddir'))) {
				fwrite($this->debugHandler, '  cron_tasks: WARNING!!! ' . Settings::Get('system.apacheconf_htpasswddir') . ' is not a directory. htpasswd directory protection is disabled!!!' . "\n");
				echo 'WARNING!!! ' . Settings::Get('system.apacheconf_htpasswddir') . ' is not a directory. htpasswd directory protection is disabled!!!';
				$this->logger->logAction(CRON_ACTION, LOG_WARNING, 'WARNING!!! ' . Settings::Get('system.apacheconf_htpasswddir') . ' is not a directory. htpasswd directory protection is disabled!!!');
			}

			if (is_dir(Settings::Get('system.apacheconf_htpasswddir'))) {
				foreach ($this->htpasswds_data as $htpasswd_filename => $htpasswd_file) {
					$this->known_htpasswdsfilenames[] = basename($htpasswd_filename);
					$htpasswd_file_handler = fopen($htpasswd_filename, 'w');
					fwrite($htpasswd_file_handler, $htpasswd_file);
					fclose($htpasswd_file_handler);
				}
			}
		}
	}


}
