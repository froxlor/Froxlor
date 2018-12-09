<?php

if (! defined('MASTER_CRONJOB'))
	die('You cannot access this file directly!');

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Florian Lippert <flo@syscp.org> (2003-2009)
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *
 * @todo ssl-redirect to non-standard port
 */

require_once (dirname(__FILE__) . '/../classes/class.HttpConfigBase.php');

class lighttpd extends HttpConfigBase
{

	private $logger = false;

	private $idnaConvert = false;

	// protected
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

	public function __construct($logger, $idnaConvert)
	{
		$this->logger = $logger;
		$this->idnaConvert = $idnaConvert;
	}

	public function reload()
	{
		if ((int) Settings::Get('phpfpm.enabled') == 1) {
			// get all start/stop commands
			$startstop_sel = Database::prepare("SELECT reload_cmd, config_dir FROM `" . TABLE_PANEL_FPMDAEMONS . "`");
			Database::pexecute($startstop_sel);
			$restart_cmds = $startstop_sel->fetchAll(PDO::FETCH_ASSOC);
			// restart all php-fpm instances
			foreach ($restart_cmds as $restart_cmd) {
				// check whether the config dir is empty (no domains uses this daemon)
				// so we need to create a dummy
				$_conffiles = glob(makeCorrectFile($restart_cmd['config_dir'] . "/*.conf"));
				if ($_conffiles === false || empty($_conffiles)) {
					$this->logger->logAction(CRON_ACTION, LOG_INFO, 'lighttpd::reload: fpm config directory "' . $restart_cmd['config_dir'] . '" is empty. Creating dummy.');
					phpinterface_fpm::createDummyPool($restart_cmd['config_dir']);
				}
				$this->logger->logAction(CRON_ACTION, LOG_INFO, 'lighttpd::reload: running ' . $restart_cmd['reload_cmd']);
				safe_exec(escapeshellcmd($restart_cmd['reload_cmd']));
			}
		}
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'lighttpd::reload: reloading lighttpd');
		safe_exec(escapeshellcmd(Settings::Get('system.apachereload_command')));
	}

	public function createIpPort()
	{
		$result_ipsandports_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `ip` ASC, `port` ASC");

		while ($row_ipsandports = $result_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (filter_var($row_ipsandports['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$ip = '[' . $row_ipsandports['ip'] . ']';
				$port = $row_ipsandports['port'];
				$ipv6 = 'server.use-ipv6 = "enable"' . "\n";
			} else {
				$ip = $row_ipsandports['ip'];
				$port = $row_ipsandports['port'];
				$ipv6 = '';
			}

			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'lighttpd::createIpPort: creating ip/port settings for  ' . $ip . ":" . $port);
			$vhost_filename = makeCorrectFile(Settings::Get('system.apacheconf_vhost') . '/10_froxlor_ipandport_' . trim(str_replace(':', '.', $row_ipsandports['ip']), '.') . '.' . $row_ipsandports['port'] . '.conf');

			if (! isset($this->lighttpd_data[$vhost_filename])) {
				$this->lighttpd_data[$vhost_filename] = '';
			}

			$this->lighttpd_data[$vhost_filename] .= '$SERVER["socket"] == "' . $ip . ':' . $port . '" {' . "\n";

			if ($row_ipsandports['listen_statement'] == '1') {
				$this->lighttpd_data[$vhost_filename] .= 'server.port = ' . $port . "\n";
				$this->lighttpd_data[$vhost_filename] .= 'server.bind = "' . $ip . '"' . "\n";
				$this->lighttpd_data[$vhost_filename] .= $ipv6;
			}

			if ($row_ipsandports['vhostcontainer'] == '1') {
				$myhost = str_replace('.', '\.', Settings::Get('system.hostname'));
				$this->lighttpd_data[$vhost_filename] .= '# Froxlor default vhost' . "\n";
				$this->lighttpd_data[$vhost_filename] .= '$HTTP["host"] =~ "^(?:www\.|)' . $myhost . '$" {' . "\n";

				$mypath = $this->getMyPath($row_ipsandports);

				$this->lighttpd_data[$vhost_filename] .= '  server.document-root = "' . $mypath . '"' . "\n";

				$is_redirect = false;
				// check for SSL redirect
				if ($row_ipsandports['ssl'] == '0' && Settings::Get('system.le_froxlor_redirect') == '1') {
					$is_redirect = true;
					// check whether froxlor uses Let's Encrypt and not cert is being generated yet
					// or a renew is ongoing - disable redirect
					if (Settings::Get('system.le_froxlor_enabled') && ($this->froxlorVhostHasLetsEncryptCert() == false || $this->froxlorVhostLetsEncryptNeedsRenew())) {
						$this->lighttpd_data[$vhost_filename] .= '# temp. disabled ssl-redirect due to Let\'s Encrypt certificate generation.' . PHP_EOL;
						$is_redirect = false;
					} else {
						$_sslport = $this->checkAlternativeSslPort();
						$mypath = 'https://' . Settings::Get('system.hostname') . $_sslport . '/';

						$this->lighttpd_data[$vhost_filename] .= '  url.redirect = (' . "\n";
						$this->lighttpd_data[$vhost_filename] .= '     "^/(.*)$" => "' . $mypath . '$1"' . "\n";
						$this->lighttpd_data[$vhost_filename] .= '  )' . "\n";
					}
				}

				if (!$is_redirect) {
					/**
					 * dirprotection, see #72
					 *
					 * @todo use better regex for this, deferred until 0.9.5
					 *
					 *       $this->lighttpd_data[$vhost_filename].= ' $HTTP["url"] =~ "^/(.+)\/(.+)\.php" {' . "\n";
					 *       $this->lighttpd_data[$vhost_filename].= ' url.access-deny = ("")' . "\n";
					 *       $this->lighttpd_data[$vhost_filename].= ' }' . "\n";
					 */

					/**
					 * own php-fpm vhost
					 */
					if ((int) Settings::Get('phpfpm.enabled') == 1 && (int) Settings::Get('phpfpm.enabled_ownvhost') == 1) {
						// get fpm config
						$fpm_sel_stmt = Database::prepare("
							SELECT f.id FROM `" . TABLE_PANEL_FPMDAEMONS . "` f
							LEFT JOIN `" . TABLE_PANEL_PHPCONFIGS . "` p ON p.fpmsettingid = f.id
							WHERE p.id = :phpconfigid
						");
						$fpm_config = Database::pexecute_first($fpm_sel_stmt, array(
							'phpconfigid' => Settings::Get('phpfpm.vhost_defaultini')
						));
						$domain = array(
							'id' => 'none',
							'domain' => Settings::Get('system.hostname'),
							'adminid' => 1, /* first admin-user (superadmin) */
							'mod_fcgid_starter' => - 1,
							'mod_fcgid_maxrequests' => - 1,
							'guid' => Settings::Get('phpfpm.vhost_httpuser'),
							'openbasedir' => 0,
							'email' => Settings::Get('panel.adminmail'),
							'loginname' => 'froxlor.panel',
							'documentroot' => $mypath,
							'customerroot' => $mypath,
							'fpm_config_id' => isset($fpm_config['id']) ? $fpm_config['id'] : 1
						);

						$php = new phpinterface($domain);

						$this->lighttpd_data[$vhost_filename] .= '  fastcgi.server = ( ' . "\n";
						$this->lighttpd_data[$vhost_filename] .= "\t" . '".php" => (' . "\n";
						$this->lighttpd_data[$vhost_filename] .= "\t\t" . '"localhost" => (' . "\n";
						$this->lighttpd_data[$vhost_filename] .= "\t\t" . '"socket" => "' . $php->getInterface()->getSocketFile() . '",' . "\n";
						$this->lighttpd_data[$vhost_filename] .= "\t\t" . '"check-local" => "enable",' . "\n";
						$this->lighttpd_data[$vhost_filename] .= "\t\t" . '"disable-time" => 1' . "\n";
						$this->lighttpd_data[$vhost_filename] .= "\t" . ')' . "\n";
						$this->lighttpd_data[$vhost_filename] .= "\t" . ')' . "\n";
						$this->lighttpd_data[$vhost_filename] .= '  )' . "\n";
					} else {
						$domain = array(
							'id' => 'none',
							'domain' => Settings::Get('system.hostname'),
							'adminid' => 1, /* first admin-user (superadmin) */
							'guid' => Settings::Get('system.httpuser'),
							'openbasedir' => 0,
							'email' => Settings::Get('panel.adminmail'),
							'loginname' => 'froxlor.panel',
							'documentroot' => $mypath,
							'customerroot' => $mypath
						);
					}
				} else {
					// fallback of froxlor domain-data for processSpecialConfigTemplate()
					$domain = array(
						'domain' => Settings::Get('system.hostname'),
						'loginname' => 'froxlor.panel',
						'documentroot' => $mypath,
						'customerroot' => $mypath
					);
				}

				if ($row_ipsandports['specialsettings'] != '') {
					$this->lighttpd_data[$vhost_filename] .= $this->processSpecialConfigTemplate($row_ipsandports['specialsettings'], $domain, $row_ipsandports['ip'], $row_ipsandports['port'], $row_ipsandports['ssl'] == '1') . "\n";
				}

				$this->lighttpd_data[$vhost_filename] .= '}' . "\n";
			}

			if ($row_ipsandports['ssl'] == '1') {
				if ($row_ipsandports['ssl_cert_file'] == '') {
					$row_ipsandports['ssl_cert_file'] = Settings::Get('system.ssl_cert_file');
				}

				if ($row_ipsandports['ssl_ca_file'] == '') {
					$row_ipsandports['ssl_ca_file'] = Settings::Get('system.ssl_ca_file');
				}

				$domain = array(
					'id' => 0,
					'domain' => Settings::Get('system.hostname'),
					'adminid' => 1, /* first admin-user (superadmin) */
					'loginname' => 'froxlor.panel',
					'documentroot' => $mypath,
					'customerroot' => $mypath,
					'parentdomainid' => 0,
				);

				// override corresponding array values
				$domain['ssl_cert_file'] = $row_ipsandports['ssl_cert_file'];
				$domain['ssl_key_file'] = $row_ipsandports['ssl_key_file'];
				$domain['ssl_ca_file'] = $row_ipsandports['ssl_ca_file'];
				$domain['ssl_cert_chainfile'] = $row_ipsandports['ssl_cert_chainfile'];

				// SSL STUFF
				$dssl = new DomainSSL();
				// this sets the ssl-related array-indices in the $domain array
				// if the domain has customer-defined ssl-certificates
				$dssl->setDomainSSLFilesArray($domain);

				if ($domain['ssl_cert_file'] != '') {

					// check for existence, #1485
					if (! file_exists($domain['ssl_cert_file'])) {
						$this->logger->logAction(CRON_ACTION, LOG_ERR, $ip . ':' . $port . ' :: certificate file "' . $domain['ssl_cert_file'] . '" does not exist! Cannot create ssl-directives');
						echo $ip . ':' . $port . ' :: certificate file "' . $domain['ssl_cert_file'] . '" does not exist! Cannot create SSL-directives' . "\n";
					} else {
						$this->lighttpd_data[$vhost_filename] .= 'ssl.engine = "enable"' . "\n";
						$this->lighttpd_data[$vhost_filename] .= 'ssl.use-compression = "disable"' . "\n";
						if (!empty(Settings::Get('system.dhparams_file'))) {
							$dhparams = makeCorrectFile(Settings::Get('system.dhparams_file'));
							if (!file_exists($dhparams)) {
								safe_exec('openssl dhparam -out '.escapeshellarg($dhparams).' 4096');
							}
							$this->lighttpd_data[$vhost_filename] .= 'ssl.dh-file = "' . $dhparams . '"' . "\n";
							$this->lighttpd_data[$vhost_filename] .= 'ssl.ec-curve = "secp384r1"' . "\n";
						}
						$this->lighttpd_data[$vhost_filename] .= 'ssl.use-sslv2 = "disable"' . "\n";
						$this->lighttpd_data[$vhost_filename] .= 'ssl.use-sslv3 = "disable"' . "\n";
						$this->lighttpd_data[$vhost_filename] .= 'ssl.cipher-list = "' . Settings::Get('system.ssl_cipher_list') . '"' . "\n";
						$this->lighttpd_data[$vhost_filename] .= 'ssl.honor-cipher-order = "enable"' . "\n";
						$this->lighttpd_data[$vhost_filename] .= 'ssl.pemfile = "' . makeCorrectFile($domain['ssl_cert_file']) . '"' . "\n";

						if ($domain['ssl_ca_file'] != '') {
							// check for existence, #1485
							if (! file_exists($domain['ssl_ca_file'])) {
								$this->logger->logAction(CRON_ACTION, LOG_ERR, $ip . ':' . $port . ' :: certificate CA file "' . $domain['ssl_ca_file'] . '" does not exist! Cannot create ssl-directives');
								echo $ip . ':' . port . ' :: certificate CA file "' . $domain['ssl_ca_file'] . '" does not exist! SSL-directives might not be working' . "\n";
							} else {
								$this->lighttpd_data[$vhost_filename] .= 'ssl.ca-file = "' . makeCorrectFile($domain['ssl_ca_file']) . '"' . "\n";
							}
						}
					}
				}
			}

			/**
			 * this function will create a new file which will be included
			 * if Settings::Get('system.apacheconf_vhost') is a folder
			 * refs #70
			 */
			$vhosts = $this->createLighttpdHosts($row_ipsandports['id'], $row_ipsandports['ssl'], $vhost_filename);
			if ($vhosts !== null && is_array($vhosts) && isset($vhosts[0])) {
				// sort vhosts by number (subdomains first!)
				sort($vhosts);

				foreach ($vhosts as $vhost) {
					$this->lighttpd_data[$vhost_filename] .= ' include "' . $vhost . '"' . "\n";
				}
			}

			$this->lighttpd_data[$vhost_filename] .= '}' . "\n";
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
		if (Settings::Get('defaultwebsrverrhandler.enabled') == '1' && Settings::Get('defaultwebsrverrhandler.err404') != '') {
			$vhost_filename = makeCorrectFile(Settings::Get('system.apacheconf_vhost') . '/05_froxlor_default_errorhandler.conf');

			if (! isset($this->lighttpd_data[$vhost_filename])) {
				$this->lighttpd_data[$vhost_filename] = '';
			}

			$defhandler = Settings::Get('defaultwebsrverrhandler.err404');
			if (! validateUrl($defhandler)) {
				$defhandler = makeCorrectFile($defhandler);
			}
			$this->lighttpd_data[$vhost_filename] = 'server.error-handler-404 = "' . $defhandler . '"';
		}
	}

	protected function create_htaccess($domain)
	{
		$needed_htpasswds = array();
		$result_htpasswds_stmt = Database::prepare("
			SELECT * FROM " . TABLE_PANEL_HTPASSWDS . "
			WHERE `path` LIKE :docroot
		");
		Database::pexecute($result_htpasswds_stmt, array(
			'docroot' => $domain['documentroot'] . '%'
		));

		$htaccess_text = '';
		while ($row_htpasswds = $result_htpasswds_stmt->fetch(PDO::FETCH_ASSOC)) {
			$row_htpasswds['path'] = makeCorrectDir($row_htpasswds['path']);
			mkDirWithCorrectOwnership($domain['documentroot'], $row_htpasswds['path'], $domain['guid'], $domain['guid']);

			$filename = $row_htpasswds['customerid'] . '-' . md5($row_htpasswds['path']) . '.htpasswd';

			if (! in_array($row_htpasswds['path'], $needed_htpasswds)) {
				if (! isset($this->needed_htpasswds[$filename])) {
					$this->needed_htpasswds[$filename] = '';
				}

				if (! strstr($this->needed_htpasswds[$filename], $row_htpasswds['username'] . ':' . $row_htpasswds['password'])) {
					$this->needed_htpasswds[$filename] .= $row_htpasswds['username'] . ':' . $row_htpasswds['password'] . "\n";
				}

				$htaccess_path = substr($row_htpasswds['path'], strlen($domain['documentroot']) - 1);
				$htaccess_path = makeCorrectDir($htaccess_path);

				$htaccess_text .= '  $HTTP["url"] =~ "^' . $htaccess_path . '" {' . "\n";
				$htaccess_text .= '    auth.backend = "htpasswd"' . "\n";
				$htaccess_text .= '    auth.backend.htpasswd.userfile = "' . makeCorrectFile(Settings::Get('system.apacheconf_htpasswddir') . '/' . $filename) . '"' . "\n";
				$htaccess_text .= '    auth.require = ( ' . "\n";
				$htaccess_text .= '      "' . $htaccess_path . '" =>' . "\n";
				$htaccess_text .= '      (' . "\n";
				$htaccess_text .= '         "method"  => "basic",' . "\n";
				$htaccess_text .= '         "realm"   => "' . $row_htpasswds['authname'] . '",' . "\n";
				$htaccess_text .= '         "require" => "valid-user"' . "\n";
				$htaccess_text .= '      )' . "\n";
				$htaccess_text .= '    )' . "\n";
				$htaccess_text .= '  }' . "\n";

				$needed_htpasswds[] = $row_htpasswds['path'];
			}
		}

		return $htaccess_text;
	}

	public function createVirtualHosts()
	{}

	public function createFileDirOptions()
	{}

	protected function composePhpOptions($domain)
	{}

	public function createOwnVhostStarter()
	{}

	protected function createLighttpdHosts($ipid, $ssl, $vhost_filename)
	{
		$domains = WebserverBase::getVhostsToCreate();
		foreach ($domains as $domain) {

			if (is_dir(Settings::Get('system.apacheconf_vhost'))) {
				safe_exec('mkdir -p ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost') . '/vhosts/')));

				// determine correct include-path:
				// e.g. '/etc/lighttpd/conf-enabled/vhosts/ has to become'
				// 'conf-enabled/vhosts/' (damn debian, but luckily works too on other distros)
				$_tmp_path = substr(makeCorrectDir(Settings::Get('system.apacheconf_vhost')), 0, - 1);
				$_pos = strrpos($_tmp_path, '/');
				$_inc_path = substr($_tmp_path, $_pos + 1);

				// maindomain
				if ((int) $domain['parentdomainid'] == 0 && isCustomerStdSubdomain((int) $domain['id']) == false && ((int) $domain['ismainbutsubto'] == 0 || domainMainToSubExists($domain['ismainbutsubto']) == false)) {
					$vhost_no = '50';
				}				// sub-but-main-domain
				elseif ((int) $domain['parentdomainid'] == 0 && isCustomerStdSubdomain((int) $domain['id']) == false && (int) $domain['ismainbutsubto'] > 0) {
					$vhost_no = '51';
				} 				// subdomains
				else {
					// number of dots in a domain specifies it's position (and depth of subdomain) starting at 89 going downwards on higher depth
					$vhost_no = (string) (90 - substr_count($domain['domain'], ".") + 1);
				}

				if ($ssl == '1') {
					$vhost_no = (int) $vhost_no += 10;
				}

				$vhost_filename = makeCorrectFile(Settings::Get('system.apacheconf_vhost') . '/vhosts/' . $vhost_no . '_' . $domain['domain'] . '.conf');
				$included_vhosts[] = $_inc_path . '/vhosts/' . $vhost_no . '_' . $domain['domain'] . '.conf';
			}

			if (! isset($this->lighttpd_data[$vhost_filename])) {
				$this->lighttpd_data[$vhost_filename] = '';
			}

			if ((! empty($this->lighttpd_data[$vhost_filename]) && ! is_dir(Settings::Get('system.apacheconf_vhost'))) || is_dir(Settings::Get('system.apacheconf_vhost'))) {
				if ($ssl == '1') {
					$ssl_vhost = true;
					$ips_and_ports_index = 'ssl_ipandport';
				} else {
					$ssl_vhost = false;
					$ips_and_ports_index = 'ipandport';
				}

				// FIXME we get duplicate entries of a vhost if it has assigned more than one IP
				// checking if the lightt_data for that filename is empty *might* be correct
				if ($this->lighttpd_data[$vhost_filename] == '') {
					$this->lighttpd_data[$vhost_filename] .= $this->getVhostContent($domain, $ssl_vhost, $ipid);
				}
			}
		}
		return $included_vhosts;
	}

	protected function getVhostContent($domain, $ssl_vhost = false, $ipid)
	{
		if ($ssl_vhost === true && $domain['ssl'] != '1' && $domain['ssl_redirect'] != '1') {
			return '';
		}

		$vhost_content = '';
		$vhost_content .= $this->getServerNames($domain) . " {\n";

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
				AND `ip`.`ssl` = '1'  AND `ip`.`port` != 443
				ORDER BY `ip`.`ssl_cert_file` DESC, `ip`.`port` LIMIT 1;");
			$ssldestport = Database::pexecute_first($ssldestport_stmt, array(
				'domainid' => $domain['id']
			));

			if ($ssldestport['port'] != '') {
				$_sslport = ":" . $ssldestport['port'];
			}

			$domain['documentroot'] = 'https://%1' . $_sslport . '/';
		}

		// avoid using any whitespaces
		$domain['documentroot'] = trim($domain['documentroot']);

		if (preg_match('/^https?\:\/\//', $domain['documentroot'])) {
			$uri = $domain['documentroot'];

			// Get domain's redirect code
			$code = getDomainRedirectCode($domain['id']);

			$vhost_content .= '  url.redirect-code = ' . $code. "\n";
			$vhost_content .= '  url.redirect = (' . "\n";
			$vhost_content .= '     "^/(.*)$" => "' . $uri . '$1"' . "\n";
			$vhost_content .= '  )' . "\n";
		} else {

			mkDirWithCorrectOwnership($domain['customerroot'], $domain['documentroot'], $domain['guid'], $domain['guid'], true, true);

			$only_webroot = false;
			if ($ssl_vhost === false && $domain['ssl_redirect'] == '1') {
				$only_webroot = true;
			}

			$vhost_content .= $this->getWebroot($domain, $ssl_vhost);
			if (! $only_webroot) {
				if ($this->_deactivated == false) {
					$vhost_content .= $this->create_htaccess($domain);
					$vhost_content .= $this->create_pathOptions($domain);
					$vhost_content .= $this->composePhpOptions($domain);
					$vhost_content .= $this->getStats($domain);

					$ipandport_stmt = Database::prepare("
						SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "`
						WHERE `id` = :id
					");
					$ipandport = Database::pexecute_first($ipandport_stmt, array(
						'id' => $ipid
					));

					$domain['ip'] = $ipandport['ip'];
					$domain['port'] = $ipandport['port'];
					$domain['ssl_cert_file'] = $ipandport['ssl_cert_file'];
					$domain['ssl_key_file'] = $ipandport['ssl_key_file'];
					$domain['ssl_ca_file'] = $ipandport['ssl_ca_file'];
					// #418
					$domain['ssl_cert_chainfile'] = $ipandport['ssl_cert_chainfile'];

					// SSL STUFF
					$dssl = new DomainSSL();
					// this sets the ssl-related array-indices in the $domain array
					// if the domain has customer-defined ssl-certificates
					$dssl->setDomainSSLFilesArray($domain);

					$vhost_content .= $this->getSslSettings($domain, $ssl_vhost);

					if ($domain['specialsettings'] != "") {
						$vhost_content .= $this->processSpecialConfigTemplate($domain['specialsettings'], $domain, $domain['ip'], $domain['port'], $ssl_vhost) . "\n";
					}

					if ($ipandport['default_vhostconf_domain'] != '') {
						$vhost_content .= $this->processSpecialConfigTemplate($ipandport['default_vhostconf_domain'], $domain, $domain['ip'], $domain['port'], $ssl_vhost) . "\n";
					}

					if (Settings::Get('system.default_vhostconf') != '') {
						$vhost_content .= $this->processSpecialConfigTemplate(Settings::Get('system.default_vhostconf'), $domain, $domain['ip'], $domain['port'], $ssl_vhost) . "\n";
					}
				}
				$vhost_content .= $this->getLogFiles($domain);
			}
		}

		$vhost_content .= '}' . "\n";

		return $vhost_content;
	}

	protected function getSslSettings($domain, $ssl_vhost)
	{
		$ssl_settings = '';

		if ($ssl_vhost === true && $domain['ssl'] == '1' && (int) Settings::Get('system.use_ssl') == 1) {
			if ($domain['ssl_cert_file'] == '') {
				$domain['ssl_cert_file'] = Settings::Get('system.ssl_cert_file');
			}

			if ($domain['ssl_ca_file'] == '') {
				$domain['ssl_ca_file'] = Settings::Get('system.ssl_ca_file');
			}

			if ($domain['ssl_cert_file'] != '') {

				// ssl.engine only necessary once in the ip/port vhost (SERVER['socket'] condition)
				//$ssl_settings .= 'ssl.engine = "enable"' . "\n";
				$ssl_settings .= 'ssl.use-compression = "disable"' . "\n";
				if (!empty(Settings::Get('system.dhparams_file'))) {
					$dhparams = makeCorrectFile(Settings::Get('system.dhparams_file'));
					if (!file_exists($dhparams)) {
						safe_exec('openssl dhparam -out '.escapeshellarg($dhparams).' 4096');
					}
					$ssl_settings .= 'ssl.dh-file = "' . $dhparams . '"' . "\n";
					$ssl_settings .= 'ssl.ec-curve = "secp384r1"' . "\n";
				}
				$ssl_settings .= 'ssl.use-sslv2 = "disable"' . "\n";
				$ssl_settings .= 'ssl.use-sslv3 = "disable"' . "\n";
				$ssl_settings .= 'ssl.cipher-list = "' . Settings::Get('system.ssl_cipher_list') . '"' . "\n";
				$ssl_settings .= 'ssl.honor-cipher-order = "enable"' . "\n";
				$ssl_settings .= 'ssl.pemfile = "' . makeCorrectFile($domain['ssl_cert_file']) . '"' . "\n";

				if ($domain['ssl_ca_file'] != '') {
					$ssl_settings .= 'ssl.ca-file = "' . makeCorrectFile($domain['ssl_ca_file']) . '"' . "\n";
				}

				if ($domain['hsts'] >= 0) {

					$ssl_settings .= '$HTTP["scheme"] == "https" { setenv.add-response-header  = ( "Strict-Transport-Security" => "max-age=' . $domain['hsts'];
					if ($domain['hsts_sub'] == 1) {
						$ssl_settings .= '; includeSubDomains';
					}
					if ($domain['hsts_preload'] == 1) {
						$ssl_settings .= '; preload';
					}
					$ssl_settings .= '") }' . "\n";
				}
			}
		}
		return $ssl_settings;
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
		// error log cannot be set conditionally see
		// https://redmine.lighttpd.net/issues/665
		$access_log = makeCorrectFile(Settings::Get('system.logfiles_directory') . $domain['loginname'] . $speciallogfile . '-access.log');
		// Create the logfile if it does not exist (fixes #46)
		touch($access_log);
		chown($access_log, Settings::Get('system.httpuser'));
		chgrp($access_log, Settings::Get('system.httpgroup'));

		$logfiles_text .= '  accesslog.filename	= "' . $access_log . '"' . "\n";

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

				if ($domain['iswildcarddomain'] == '1') {
					$alias = '*.' . $domain['domain'];
				} else {
					if ($domain['wwwserveralias'] == '1') {
						$alias = 'www.' . $domain['domain'];
					} else {
						$alias = '';
					}
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

	protected function create_pathOptions($domain)
	{
		$result_stmt = Database::prepare("
			SELECT * FROM " . TABLE_PANEL_HTACCESS . "
			WHERE `path` LIKE :docroot
		");
		Database::pexecute($result_stmt, array(
			'docroot' => $domain['documentroot'] . '%'
		));

		$path_options = '';
		$error_string = '';

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			if (! empty($row['error404path'])) {
				$defhandler = $row['error404path'];
				if (! validateUrl($defhandler)) {
					$defhandler = makeCorrectFile($domain['documentroot'] . '/' . $defhandler);
				}
				$error_string .= '  server.error-handler-404 = "' . $defhandler . '"' . "\n\n";
			}

			if ($row['options_indexes'] != '0') {
				if (! empty($error_string)) {
					$path_options .= $error_string;
					// reset $error_string here to prevent duplicate entries
					$error_string = '';
				}

				$path = makeCorrectDir(substr($row['path'], strlen($domain['documentroot']) - 1));
				mkDirWithCorrectOwnership($domain['documentroot'], $row['path'], $domain['guid'], $domain['guid']);

				// We need to remove the last slash, otherwise the regex wouldn't work
				if ($row['path'] != $domain['documentroot']) {
					$path = substr($path, 0, - 1);
				}
				$path_options .= '  $HTTP["url"] =~ "^' . $path . '($|/)" {' . "\n";
				$path_options .= "\t" . 'dir-listing.activate = "enable"' . "\n";
				$path_options .= '  }' . "\n\n";
			} else {
				$path_options = $error_string;
			}

			if (customerHasPerlEnabled($domain['customerid']) && $row['options_cgi'] != '0') {
				$path = makeCorrectDir(substr($row['path'], strlen($domain['documentroot']) - 1));
				mkDirWithCorrectOwnership($domain['documentroot'], $row['path'], $domain['guid'], $domain['guid']);

				// We need to remove the last slash, otherwise the regex wouldn't work
				if ($row['path'] != $domain['documentroot']) {
					$path = substr($path, 0, - 1);
				}
				$path_options .= '  $HTTP["url"] =~ "^' . $path . '($|/)" {' . "\n";
				$path_options .= "\t" . 'cgi.assign = (' . "\n";
				$path_options .= "\t\t" . '".pl" => "' . makeCorrectFile(Settings::Get('system.perl_path')) . '",' . "\n";
				$path_options .= "\t\t" . '".cgi" => "' . makeCorrectFile(Settings::Get('system.perl_path')) . '"' . "\n";
				$path_options .= "\t" . ')' . "\n";
				$path_options .= '  }' . "\n\n";
			}
		}

		return $path_options;
	}

	protected function getDirOptions($domain)
	{
		$result_stmt = Database::prepare("
			SELECT * FROM " . TABLE_PANEL_HTPASSWDS . "
			WHERE `customerid` = :customerid
		");
		Database::pexecute($result_stmt, array(
			'customerid' => $domain['customerid']
		));

		while ($row_htpasswds = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($auth_backend_loaded[$domain['ipandport']] != 'yes' && $auth_backend_loaded[$domain['ssl_ipandport']] != 'yes') {
				$filename = $domain['customerid'] . '.htpasswd';

				if ($this->auth_backend_loaded[$domain['ipandport']] != 'yes') {
					$auth_backend_loaded[$domain['ipandport']] = 'yes';
					$diroption_text .= 'auth.backend = "htpasswd"' . "\n";
					$diroption_text .= 'auth.backend.htpasswd.userfile = "' . makeCorrectFile(Settings::Get('system.apacheconf_htpasswddir') . '/' . $filename) . '"' . "\n";
					$this->needed_htpasswds[$filename] = $row_htpasswds['username'] . ':' . $row_htpasswds['password'] . "\n";
					$diroption_text .= 'auth.require = ( ' . "\n";
					$previous_domain_id = '1';
				} elseif ($this->auth_backend_loaded[$domain['ssl_ipandport']] != 'yes') {
					$auth_backend_loaded[$domain['ssl_ipandport']] = 'yes';
					$diroption_text .= 'auth.backend= "htpasswd"' . "\n";
					$diroption_text .= 'auth.backend.htpasswd.userfile = "' . makeCorrectFile(Settings::Get('system.apacheconf_htpasswddir') . '/' . $filename) . '"' . "\n";
					$this->needed_htpasswds[$filename] = $row_htpasswds['username'] . ':' . $row_htpasswds['password'] . "\n";
					$diroption_text .= 'auth.require = ( ' . "\n";
					$previous_domain_id = '1';
				}
			}

			$diroption_text .= '"' . makeCorrectDir($row_htpasswds['path']) . '" =>' . "\n";
			$diroption_text .= '(' . "\n";
			$diroption_text .= '   "method"  => "basic",' . "\n";
			$diroption_text .= '   "realm"   => "' . $row_htpasswds['authname'] . '",' . "\n";
			$diroption_text .= '   "require" => "valid-user"' . "\n";
			$diroption_text .= ')' . "\n";

			if ($this->auth_backend_loaded[$domain['ssl_ipandport']] == 'yes') {
				$this->needed_htpasswds[$domain['ssl_ipandport']] .= $diroption_text;
			}

			if ($this->auth_backend_loaded[$domain['ipandport']] != 'yes') {
				$this->needed_htpasswds[$domain['ipandport']] .= $diroption_text;
			}
		}

		return '  auth.backend.htpasswd.userfile = "' . makeCorrectFile(Settings::Get('system.apacheconf_htpasswddir') . '/' . $filename) . '"' . "\n";
	}

	protected function getServerNames($domain)
	{
		$server_string = array();
		$domain_name = str_replace('.', '\.', $domain['domain']);

		if ($domain['iswildcarddomain'] == '1') {
			$server_string[] = '(?:^|\.)' . $domain_name . '$';
		} else {
			if ($domain['wwwserveralias'] == '1') {
				$server_string[] = '^(?:www\.|)' . $domain_name . '$';
			} else {
				$server_string[] = '^' . $domain_name . '$';
			}
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
			$alias_domain_name = str_replace('.', '\.', $alias_domain['domain']);

			if ($alias_domain['iswildcarddomain'] == '1') {
				$server_string[] = '(?:^|\.)' . $alias_domain_name . '$';
			} else {
				if ($alias_domain['wwwserveralias'] == '1') {
					$server_string[] = '^(?:www\.|)' . $alias_domain_name . '$';
				} else {
					$server_string[] = '^' . $alias_domain_name . '$';
				}
			}
		}

		for ($i = 0; $i < sizeof($server_string); $i ++) {
			$data = $server_string[$i];

			if (sizeof($server_string) > 1) {
				if ($i == 0) {
					$servernames_text = '(' . $data . '|';
				} elseif (sizeof($server_string) - 1 == $i) {
					$servernames_text .= $data . ')';
				} else {
					$servernames_text .= $data . '|';
				}
			} else {
				$servernames_text = $data;
			}
		}

		unset($data);

		if ($servernames_text != '') {
			$servernames_text = '$HTTP["host"] =~ "' . $servernames_text . '"';
		} else {
			$servernames_text = '$HTTP["host"] == "' . $domain['domain'] . '"';
		}

		return $servernames_text;
	}

	protected function getWebroot($domain, $ssl)
	{
		$webroot_text = '';

		if ($domain['deactivated'] == '1' && Settings::Get('system.deactivateddocroot') != '') {
			$webroot_text .= '  # Using docroot for deactivated users...' . "\n";
			$webroot_text .= '  server.document-root = "' . makeCorrectDir(Settings::Get('system.deactivateddocroot')) . "\"\n";
			$this->_deactivated = true;
		} else {
			if ($ssl === false && $domain['ssl_redirect'] == '1') {
				$redirect_domain = $this->idnaConvert->encode('https://' . $domain['domain']);
				$webroot_text .= '  url.redirect = (' . "\n";
				$webroot_text .= "\t" . '"^/(.*)" => "' . $redirect_domain . '/$1",' . "\n";
				$webroot_text .= "\t" . '"" => "' . $redirect_domain . '",' . "\n";
				$webroot_text .= "\t" . '"/" => "' . $redirect_domain . '"' . "\n";
				$webroot_text .= '  )' . "\n";
			} elseif (preg_match("#^https?://#i", $domain['documentroot'])) {
				$redirect_domain = $this->idnaConvert->encode($domain['documentroot']);
				$webroot_text .= '  url.redirect = (' . "\n";
				$webroot_text .= "\t" . '"^/(.*)" => "' . $redirect_domain . '/$1",' . "\n";
				$webroot_text .= "\t" . '"" => "' . $redirect_domain . '",' . "\n";
				$webroot_text .= "\t" . '"/" => "' . $redirect_domain . '"' . "\n";
				$webroot_text .= '  )' . "\n";
			} else {
				$webroot_text .= '  server.document-root = "' . makeCorrectDir($domain['documentroot']) . "\"\n";
			}
			$this->_deactivated = false;
		}

		return $webroot_text;
	}

	/**
	 * Lets set the text part for the stats software
	 */
	protected function getStats($domain)
	{
		$stats_text = '';

		if ($domain['speciallogfile'] == '1') {
			if ($domain['parentdomainid'] == '0') {
				if (Settings::Get('system.awstats_enabled') == '1') {
					$stats_text .= '  alias.url = ( "/awstats/" => "' . makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['domain']) . '" )' . "\n";
					$stats_text .= '  alias.url += ( "/awstats-icon" => "' . makeCorrectDir(Settings::Get('system.awstats_icons')) . '" )' . "\n";
				} else {
					$stats_text .= '  alias.url = ( "/webalizer/" => "' . makeCorrectFile($domain['customerroot'] . '/webalizer/' . $domain['domain']) . '/" )' . "\n";
				}
			} else {
				if (Settings::Get('system.awstats_enabled') == '1') {
					$stats_text .= '  alias.url = ( "/awstats/" => "' . makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['parentdomain']) . '" )' . "\n";
					$stats_text .= '  alias.url += ( "/awstats-icon" => "' . makeCorrectDir(Settings::Get('system.awstats_icons')) . '" )' . "\n";
				} else {
					$stats_text .= '  alias.url = ( "/webalizer/" => "' . makeCorrectFile($domain['customerroot'] . '/webalizer/' . $domain['parentdomain']) . '/" )' . "\n";
				}
			}
		} else {
			if ($domain['customerroot'] != $domain['documentroot']) {
				if (Settings::Get('system.awstats_enabled') == '1') {
					$stats_text .= '  alias.url = ( "/awstats/" => "' . makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['domain']) . '" )' . "\n";
					$stats_text .= '  alias.url += ( "/awstats-icon" => "' . makeCorrectDir(Settings::Get('system.awstats_icons')) . '" )' . "\n";
				} else {
					$stats_text .= '  alias.url = ( "/webalizer/" => "' . makeCorrectFile($domain['customerroot'] . '/webalizer/') . '" )' . "\n";
				}
			}			// if the docroots are equal, we still have to set an alias for awstats
			// because the stats are in /awstats/[domain], not just /awstats/
			// also, the awstats-icons are someplace else too!
			// -> webalizer does not need this!
			elseif (Settings::Get('system.awstats_enabled') == '1') {
				$stats_text .= '  alias.url = ( "/awstats/" => "' . makeCorrectFile($domain['documentroot'] . '/awstats/' . $domain['domain']) . '" )' . "\n";
				$stats_text .= '  alias.url += ( "/awstats-icon" => "' . makeCorrectDir(Settings::Get('system.awstats_icons')) . '" )' . "\n";
			}
		}

		return $stats_text;
	}

	public function writeConfigs()
	{
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "lighttpd::writeConfigs: rebuilding " . Settings::Get('system.apacheconf_vhost'));

		$vhostDir = new frxDirectory(Settings::Get('system.apacheconf_vhost'));
		if (! $vhostDir->isConfigDir()) {
			// Save one big file
			$vhosts_file = '';

			// sort by filename so the order is:
			// 1. main-domains
			// 2. subdomains as main-domains
			// 3. subdomains
			// (former #437) - #833 (the numbering is done in createLighttpdHosts())
			ksort($this->lighttpd_data);

			foreach ($this->lighttpd_data as $vhosts_filename => $vhost_content) {
				$vhosts_file .= $vhost_content . "\n\n";
			}

			$vhosts_filename = Settings::Get('system.apacheconf_vhost');

			// Apply header
			$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;
			$vhosts_file_handler = fopen($vhosts_filename, 'w');
			fwrite($vhosts_file_handler, $vhosts_file);
			fclose($vhosts_file_handler);
		} else {
			if (! file_exists(Settings::Get('system.apacheconf_vhost'))) {
				$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'lighttpd::writeConfigs: mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost'))));
				safe_exec('mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost'))));
			}

			// Write a single file for every vhost
			foreach ($this->lighttpd_data as $vhosts_filename => $vhosts_file) {
				$this->known_filenames[] = basename($vhosts_filename);

				// Apply header
				$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;

				if (! empty($vhosts_filename)) {
					$vhosts_file_handler = fopen($vhosts_filename, 'w');
					fwrite($vhosts_file_handler, $vhosts_file);
					fclose($vhosts_file_handler);
				}
			}
		}

		// Write the diroptions
		$htpasswdDir = new frxDirectory(Settings::Get('system.apacheconf_htpasswddir'));
		if ($htpasswdDir->isConfigDir()) {
			foreach ($this->needed_htpasswds as $key => $data) {
				if (! is_dir(Settings::Get('system.apacheconf_htpasswddir'))) {
					mkdir(makeCorrectDir(Settings::Get('system.apacheconf_htpasswddir')));
				}

				$filename = makeCorrectFile(Settings::Get('system.apacheconf_htpasswddir') . '/' . $key);
				$htpasswd_handler = fopen($filename, 'w');
				fwrite($htpasswd_handler, $data);
				fclose($htpasswd_handler);
			}
		}
	}
}
