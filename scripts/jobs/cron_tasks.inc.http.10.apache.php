<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

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

class apache {
	private $logger = false;
	private $debugHandler = false;
	private $idnaConvert = false;

	// protected
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

	public function __construct($logger, $debugHandler, $idnaConvert) {
		$this->logger = $logger;
		$this->debugHandler = $debugHandler;
		$this->idnaConvert = $idnaConvert;

	}


	public function reload() {
		if ((int)Settings::Get('phpfpm.enabled') == 1) {
			fwrite($this->debugHandler, '   apache::reload: reloading php-fpm' . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading php-fpm');
			safe_exec(escapeshellcmd(Settings::Get('phpfpm.reload')));
		}
		fwrite($this->debugHandler, '   apache::reload: reloading apache' . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, 'reloading apache');
		safe_exec(escapeshellcmd(Settings::Get('system.apachereload_command')));
	}


	/**
	 * define a standard <Directory>-statement, bug #32
	 */
	private function _createStandardDirectoryEntry() {
		$vhosts_folder = '';
		if (is_dir(Settings::Get('system.apacheconf_vhost'))) {
			$vhosts_folder = makeCorrectDir(Settings::Get('system.apacheconf_vhost'));
		} else {
			$vhosts_folder = makeCorrectDir(dirname(Settings::Get('system.apacheconf_vhost')));
		}
		$vhosts_filename = makeCorrectFile($vhosts_folder . '/05_froxlor_dirfix_nofcgid.conf');

		if (Settings::Get('system.mod_fcgid') == '1'
			|| Settings::Get('phpfpm.enabled') == '1'
		) {
			// if we use fcgid or php-fpm we don't need this file
			if (file_exists($vhosts_filename)) {
				fwrite($this->debugHandler, '  apache::_createStandardDirectoryEntry: unlinking ' . basename($vhosts_filename) . "\n");
				$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'unlinking ' . basename($vhosts_filename));
				unlink(makeCorrectFile($vhosts_filename));
			}
		} else {
			if (!isset($this->virtualhosts_data[$vhosts_filename])) {
				$this->virtualhosts_data[$vhosts_filename] = '';
			}

			$this->virtualhosts_data[$vhosts_filename].= '  <Directory "' . makeCorrectDir(Settings::Get('system.documentroot_prefix')) . '">' . "\n";
			// >=apache-2.4 enabled?
			if (Settings::Get('system.apache24') == '1') {
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

			if (!isset($this->virtualhosts_data[$vhosts_filename])) {
				$this->virtualhosts_data[$vhosts_filename] = '';
			}

			$statusCodes = array('401', '403', '404', '500');
			foreach ($statusCodes as $statusCode) {
				if (Settings::Get('defaultwebsrverrhandler.err' . $statusCode) != '') {
					$defhandler = Settings::Get('defaultwebsrverrhandler.err' . $statusCode);
					if (!validateUrl($defhandler)) {
						if (substr($defhandler, 0, 1) != '"' && substr($defhandler, -1, 1) != '"') {
							$defhandler = '"'.makeCorrectFile($defhandler).'"';
						}
					}
					$this->virtualhosts_data[$vhosts_filename] .= 'ErrorDocument ' . $statusCode . ' ' . $defhandler . "\n";
				}
			}
		}
	}


	public function createIpPort() {
		$result_ipsandports_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "` ORDER BY `ip` ASC, `port` ASC");

		while ($row_ipsandports = $result_ipsandports_stmt->fetch(PDO::FETCH_ASSOC)) {
			if (filter_var($row_ipsandports['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
				$ipport = '[' . $row_ipsandports['ip'] . ']:' . $row_ipsandports['port'];
			} else {
				$ipport = $row_ipsandports['ip'] . ':' . $row_ipsandports['port'];
			}

			fwrite($this->debugHandler, '  apache::createIpPort: creating ip/port settings for  ' . $ipport . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'creating ip/port settings for  ' . $ipport);
			$vhosts_filename = makeCorrectFile(Settings::Get('system.apacheconf_vhost') . '/10_froxlor_ipandport_' . trim(str_replace(':', '.', $row_ipsandports['ip']), '.') . '.' . $row_ipsandports['port'] . '.conf');

			if (!isset($this->virtualhosts_data[$vhosts_filename])) {
				$this->virtualhosts_data[$vhosts_filename] = '';
			}

			if ($row_ipsandports['listen_statement'] == '1') {
				$this->virtualhosts_data[$vhosts_filename] .= 'Listen ' . $ipport . "\n";
				$this->logger->logAction(CRON_ACTION, LOG_DEBUG, $ipport . ' :: inserted listen-statement');
			}

			if ($row_ipsandports['namevirtualhost_statement'] == '1') {
				// >=apache-2.4 enabled?
				if (Settings::Get('system.apache24') == '1') {
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, $ipport . ' :: namevirtualhost-statement no longer needed for apache-2.4');
				} else {
					$this->virtualhosts_data[$vhosts_filename].= 'NameVirtualHost ' . $ipport . "\n";
					$this->logger->logAction(CRON_ACTION, LOG_DEBUG, $ipport . ' :: inserted namevirtualhost-statement');
				}
			}

			if ($row_ipsandports['vhostcontainer'] == '1') {
				$this->virtualhosts_data[$vhosts_filename] .= '<VirtualHost ' . $ipport . '>' . "\n";

				if ($row_ipsandports['docroot'] == '') {
					/**
					 * add 'real'-vhost content here, like doc-root :)
					 */
					if (Settings::Get('system.froxlordirectlyviahostname')) {
						$mypath = makeCorrectDir(dirname(dirname(dirname(__FILE__))));
					} else {
						$mypath = makeCorrectDir(dirname(dirname(dirname(dirname(__FILE__)))));
					}
				} else {
					// user-defined docroot, #417
					$mypath = makeCorrectDir($row_ipsandports['docroot']);
				}

				$this->virtualhosts_data[$vhosts_filename] .= 'DocumentRoot "'.$mypath.'"'."\n";

				if ($row_ipsandports['vhostcontainer_servername_statement'] == '1') {
					$this->virtualhosts_data[$vhosts_filename] .= ' ServerName ' . Settings::Get('system.hostname') . "\n";
				}

				// create fcgid <Directory>-Part (starter is created in apache_fcgid)
				if (Settings::Get('system.mod_fcgid_ownvhost') == '1'
					&& Settings::Get('system.mod_fcgid') == '1'
				) {
					$configdir = makeCorrectDir(Settings::Get('system.mod_fcgid_configdir') . '/froxlor.panel/' . Settings::Get('system.hostname'));
					$this->virtualhosts_data[$vhosts_filename] .= '  FcgidIdleTimeout ' . Settings::Get('system.mod_fcgid_idle_timeout') . "\n";
					if ((int)Settings::Get('system.mod_fcgid_wrapper') == 0) {
						$this->virtualhosts_data[$vhosts_filename] .= '  SuexecUserGroup "' . Settings::Get('system.mod_fcgid_httpuser') . '" "' . Settings::Get('system.mod_fcgid_httpgroup') . '"' . "\n";
						$this->virtualhosts_data[$vhosts_filename] .= '  ScriptAlias /php/ ' . $configdir . "\n";
					} else {
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
							'documentroot' => $mypath
						);
						$php = new phpinterface($domain);
						$phpconfig = $php->getPhpConfig(Settings::Get('system.mod_fcgid_defaultini_ownvhost'));

						$starter_filename = makeCorrectFile($configdir . '/php-fcgi-starter');
						$this->virtualhosts_data[$vhosts_filename] .= '  SuexecUserGroup "' . Settings::Get('system.mod_fcgid_httpuser') . '" "' . Settings::Get('system.mod_fcgid_httpgroup') . '"' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= '  <Directory "' . $mypath . '">' . "\n";
						$file_extensions = explode(' ', $phpconfig['file_extensions']);
						$this->virtualhosts_data[$vhosts_filename].= '    <FilesMatch "\.(' . implode('|', $file_extensions) . ')$">' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= '      SetHandler fcgid-script' . "\n";
						foreach ($file_extensions as $file_extension) {
							$this->virtualhosts_data[$vhosts_filename].= '      FcgidWrapper ' . $starter_filename . ' .' . $file_extension . "\n";
						}
						$this->virtualhosts_data[$vhosts_filename].= '      Options +ExecCGI' . "\n";
						$this->virtualhosts_data[$vhosts_filename].= '    </FilesMatch>' . "\n";
						// >=apache-2.4 enabled?
						if (Settings::Get('system.apache24') == '1') {
							$this->virtualhosts_data[$vhosts_filename].= '    Require all granted' . "\n";
						} else {
							$this->virtualhosts_data[$vhosts_filename].= '    Order allow,deny' . "\n";
							$this->virtualhosts_data[$vhosts_filename].= '    allow from all' . "\n";
						}
						$this->virtualhosts_data[$vhosts_filename].= '  </Directory>' . "\n";
					}
				}
				// create php-fpm <Directory>-Part (config is created in apache_fcgid)
				elseif (Settings::Get('phpfpm.enabled') == '1') {
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
					$phpconfig = $php->getPhpConfig(Settings::Get('phpfpm.vhost_defaultini'));
					$srvName = substr(md5($ipport),0,4).'.fpm.external';
					if ($row_ipsandports['ssl']) {
						$srvName = substr(md5($ipport),0,4).'.ssl-fpm.external';
					}
					$this->virtualhosts_data[$vhosts_filename] .= '  FastCgiExternalServer ' . $php->getInterface()->getAliasConfigDir() . $srvName .' -socket ' . $php->getInterface()->getSocketFile() . ' -idle-timeout ' . Settings::Get('phpfpm.idle_timeout') . "\n";
					$this->virtualhosts_data[$vhosts_filename] .= '  <Directory "' . $mypath . '">' . "\n";
					$file_extensions = explode(' ', $phpconfig['file_extensions']);
					$this->virtualhosts_data[$vhosts_filename] .= '   <FilesMatch "\.(' . implode('|', $file_extensions) . ')$">' . "\n";
					$this->virtualhosts_data[$vhosts_filename] .= '     AddHandler php5-fastcgi .php'. "\n";
					$this->virtualhosts_data[$vhosts_filename] .= '     Action php5-fastcgi /fastcgiphp' . "\n";
					$this->virtualhosts_data[$vhosts_filename].= '      Options +ExecCGI' . "\n";
					$this->virtualhosts_data[$vhosts_filename].= '    </FilesMatch>' . "\n";
					// >=apache-2.4 enabled?
					if (Settings::Get('system.apache24') == '1') {
						$this->virtualhosts_data[$vhosts_filename] .= '    Require all granted' . "\n";
					} else {
						$this->virtualhosts_data[$vhosts_filename] .= '    Order allow,deny' . "\n";
						$this->virtualhosts_data[$vhosts_filename] .= '    allow from all' . "\n";
					}
					$this->virtualhosts_data[$vhosts_filename] .= '  </Directory>' . "\n";
					$this->virtualhosts_data[$vhosts_filename] .= '  Alias /fastcgiphp ' . $php->getInterface()->getAliasConfigDir() . $srvName . "\n";
				}

				/**
				 * dirprotection, see #72
				 * @TODO deferred until 0.9.5, needs more testing
				 $this->virtualhosts_data[$vhosts_filename] .= "\t<Directory \"'.$mypath.'(images|packages|templates)\">\n";
				 $this->virtualhosts_data[$vhosts_filename] .= "\t\tAllow from all\n";
				 $this->virtualhosts_data[$vhosts_filename] .= "\t\tOptions -Indexes\n";
				 $this->virtualhosts_data[$vhosts_filename] .= "\t</Directory>\n";

				 $this->virtualhosts_data[$vhosts_filename] .= "\t<Directory \"'.$mypath.'*\">\n";
				 $this->virtualhosts_data[$vhosts_filename] .= "\t\tOrder Deny,Allow\n";
				 $this->virtualhosts_data[$vhosts_filename] .= "\t\tDeny from All\n";
				 $this->virtualhosts_data[$vhosts_filename] .= "\t</Directory>\n";
				 * end of dirprotection
				 */

				if ($row_ipsandports['specialsettings'] != '') {
					$this->virtualhosts_data[$vhosts_filename] .= $row_ipsandports['specialsettings'] . "\n";
				}

				if ($row_ipsandports['ssl'] == '1' && Settings::Get('system.use_ssl') == '1') {
					if ($row_ipsandports['ssl_cert_file'] == '') {
						$row_ipsandports['ssl_cert_file'] = Settings::Get('system.ssl_cert_file');
					}

					if ($row_ipsandports['ssl_key_file'] == '') {
						$row_ipsandports['ssl_key_file'] = Settings::Get('system.ssl_key_file');
					}

					if ($row_ipsandports['ssl_ca_file'] == '') {
						$row_ipsandports['ssl_ca_file'] = Settings::Get('system.ssl_ca_file');
					}

					// #418
					if ($row_ipsandports['ssl_cert_chainfile'] == '') {
						$row_ipsandports['ssl_cert_chainfile'] = Settings::Get('system.ssl_cert_chainfile');
					}

					if ($row_ipsandports['ssl_cert_file'] != '') {
						$this->virtualhosts_data[$vhosts_filename] .= ' SSLEngine On' . "\n";
						// this makes it more secure, thx to Marcel (08/2013)
						$this->virtualhosts_data[$vhosts_filename] .= ' SSLHonorCipherOrder On' . "\n";
						$this->virtualhosts_data[$vhosts_filename] .= ' SSLCipherSuite ' . Settings::Get('system.ssl_cipher_list') . "\n";
						$this->virtualhosts_data[$vhosts_filename] .= ' SSLVerifyDepth 10' . "\n";
						$this->virtualhosts_data[$vhosts_filename] .= ' SSLCertificateFile ' . makeCorrectFile($row_ipsandports['ssl_cert_file']) . "\n";

						if ($row_ipsandports['ssl_key_file'] != '') {
							$this->virtualhosts_data[$vhosts_filename] .= ' SSLCertificateKeyFile ' . makeCorrectFile($row_ipsandports['ssl_key_file']) . "\n";
						}

						if ($row_ipsandports['ssl_ca_file'] != '') {
							$this->virtualhosts_data[$vhosts_filename] .= ' SSLCACertificateFile ' . makeCorrectFile($row_ipsandports['ssl_ca_file']) . "\n";
						}

						// #418
						if ($row_ipsandports['ssl_cert_chainfile'] != '') {
							$this->virtualhosts_data[$vhosts_filename] .= '  SSLCertificateChainFile ' . makeCorrectFile($row_ipsandports['ssl_cert_chainfile']) . "\n";
						}
					}
				}

				$this->virtualhosts_data[$vhosts_filename] .= '</VirtualHost>' . "\n";
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


	/**
	 * We put together the needed php options in the virtualhost entries
	 *
	 * @param array $domain
	 * @param bool $ssl_vhost
	 *
	 * @return string
	 */
	protected function composePhpOptions($domain, $ssl_vhost = false) {
		$php_options_text = '';

		if ($domain['phpenabled'] == '1') {
			// This vHost has PHP enabled and we are using the regular mod_php

			if ($domain['openbasedir'] == '1') {
				$_phpappendopenbasedir = appendOpenBasedirPath($domain['customerroot'], true);

				$_custom_openbasedir = explode(':', Settings::Get('system.phpappendopenbasedir'));
				foreach ($_custom_openbasedir as $cobd) {
					$_phpappendopenbasedir .= appendOpenBasedirPath($cobd);
				}

				$php_options_text .= '  php_admin_value open_basedir "' . $_phpappendopenbasedir . '"'."\n";
			}
		} else {
			$php_options_text .= '  # PHP is disabled for this vHost' . "\n";
			$php_options_text .= '  php_flag engine off' . "\n";
		}

		return $php_options_text;
	}


	public function createOwnVhostStarter() {}


	/**
	 * We collect all servernames and Aliases
	 */
	protected function getServerNames($domain) {
		$servernames_text = '  ServerName ' . $domain['domain'] . "\n";

		$server_alias = '';
		if ($domain['iswildcarddomain'] == '1') {
			$server_alias = '*.' . $domain['domain'];
		} elseif ($domain['wwwserveralias'] == '1') {
			$server_alias = 'www.' . $domain['domain'];
		}

		if (trim($server_alias) != '') {
			$servernames_text .= '  ServerAlias ' . $server_alias . "\n";
		}

		$alias_domains_stmt = Database::prepare("
			SELECT `domain`, `iswildcarddomain`, `wwwserveralias`
			FROM `" . TABLE_PANEL_DOMAINS . "`
			WHERE `aliasdomain`= :domainid
		");
		Database::pexecute($alias_domains_stmt, array('domainid' => $domain['id']));

		while (($alias_domain = $alias_domains_stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
			$server_alias = '  ServerAlias ' . $alias_domain['domain'];

			if ($alias_domain['iswildcarddomain'] == '1') {
				$server_alias .= ' *.' . $alias_domain['domain'];
			} else {
				if ($alias_domain['wwwserveralias'] == '1') {
					$server_alias .= ' www.' . $alias_domain['domain'];
				}
			}

			$servernames_text .= $server_alias . "\n";
		}

		$servernames_text .= '  ServerAdmin ' . $domain['email'] . "\n";
		return $servernames_text;
	}


	/**
	 * Let's get the webroot
	 */
	protected function getWebroot($domain) {
		$webroot_text = '';
		$domain['customerroot'] = makeCorrectDir($domain['customerroot']);
		$domain['documentroot'] = makeCorrectDir($domain['documentroot']);

		if ($domain['deactivated'] == '1'
			&& Settings::Get('system.deactivateddocroot') != ''
		) {
			$webroot_text .= '  # Using docroot for deactivated users...' . "\n";
			$webroot_text .= '  DocumentRoot "' . makeCorrectDir(Settings::Get('system.deactivateddocroot')) . "\"\n";
			$this->_deactivated = true;
		} else {
			$webroot_text .= '  DocumentRoot "' . $domain['documentroot'] . "\"\n";
			$this->_deactivated = false;
		}

		return $webroot_text;
	}


	/**
	 * Lets set the text part for the stats software
	 */
	protected function getStats($domain) {
		$stats_text = '';

		if ($domain['speciallogfile'] == '1') {
			$statDomain = ($domain['parentdomainid'] == '0') ? $domain['domain'] : $domain['parentdomain'];
			if (Settings::Get('system.awstats_enabled') == '1') {
				$stats_text .= '  Alias /awstats "' . makeCorrectFile($domain['customerroot'] . '/awstats/' . $statDomain) . '"' . "\n";
				$stats_text .= '  Alias /awstats-icon "' . makeCorrectDir(Settings::Get('system.awstats_icons')) . '"' . "\n";
			} else {
				$stats_text .= '  Alias /webalizer "' . makeCorrectFile($domain['customerroot'] . '/webalizer/' . $statDomain) . '"' . "\n";
			}
		} else {
			if ($domain['customerroot'] != $domain['documentroot']) {
				if (Settings::Get('system.awstats_enabled') == '1') {
					$stats_text.= '  Alias /awstats "' . makeCorrectFile($domain['customerroot'] . '/awstats/' . $domain['domain']) . '"' . "\n";
					$stats_text.= '  Alias /awstats-icon "' . makeCorrectDir(Settings::Get('system.awstats_icons')) . '"' . "\n";
				} else {
					$stats_text.= '  Alias /webalizer "' . makeCorrectFile($domain['customerroot'] . '/webalizer') . '"' . "\n";
				}
			}
			// if the docroots are equal, we still have to set an alias for awstats
			// because the stats are in /awstats/[domain], not just /awstats/
			// also, the awstats-icons are someplace else too!
			// -> webalizer does not need this!
			elseif (Settings::Get('system.awstats_enabled') == '1') {
				$stats_text.= '  Alias /awstats "' . makeCorrectFile($domain['documentroot'] . '/awstats/' . $domain['domain']) . '"' . "\n";
				$stats_text.= '  Alias /awstats-icon "' . makeCorrectDir(Settings::Get('system.awstats_icons')) . '"' . "\n";
			}
		}

		return $stats_text;
	}


	/**
	 * Lets set the logfiles
	 */
	protected function getLogfiles($domain) {

		$logfiles_text = '';

		if ($domain['speciallogfile'] == '1') {
			if ($domain['parentdomainid'] == '0') {
				$speciallogfile = '-' . $domain['domain'];
			} else {
				$speciallogfile = '-' . $domain['parentdomain'];
			}
		} else {
			$speciallogfile = '';
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

		$logfiles_text .= '  ErrorLog "' . $error_log . "\"\n";
		$logfiles_text .= '  CustomLog "' . $access_log .'" combined' . "\n";

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
						$server_alias .= '*.' . $alias_domain['domain'];
					} elseif ($alias_domain['wwwserveralias'] == '1') {
						$server_alias .= 'www.' . $alias_domain['domain'];
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


	/**
	 * Get the filename for the virtualhost
	 */
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


	/**
	 * We compose the virtualhost entry for one domain
	 */
	protected function getVhostContent($domain, $ssl_vhost = false) {
		if ($ssl_vhost === true
			&& ($domain['ssl_redirect'] != '1'
				&& $domain['ssl'] != '1')
		) {
			return '';
		}

		$query = "SELECT * FROM `".TABLE_PANEL_IPSANDPORTS."` `i`, `".TABLE_DOMAINTOIP."` `dip`
			WHERE dip.id_domain = :domainid AND i.id = dip.id_ipandports ";

		if ($ssl_vhost === true
			&& ($domain['ssl'] == '1' || $domain['ssl_redirect'] == '1')
		) {
			// by ordering by cert-file the row with filled out SSL-Fields will be shown last, thus it is enough to fill out 1 set of SSL-Fields
			$query .= "AND i.ssl = '1' ORDER BY i.ssl_cert_file ASC;";
		} else {
			$query .= "AND i.ssl = '0';";
		}

		$vhost_content = '';
		$result_stmt = Database::prepare($query);
		Database::pexecute($result_stmt, array('domainid' => $domain['id']));

		$ipportlist = '';
		$_vhost_content = '';
		while ($ipandport = $result_stmt->fetch(PDO::FETCH_ASSOC)) {

			$ipport = '';
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
				$ipport = '['.$domain['ip'].']:'.$domain['port']. ' ';
			} else {
				$ipport = $domain['ip'].':'.$domain['port'].' ';
			}

			if ($ipandport['default_vhostconf_domain'] != '') {
				$_vhost_content .= $ipandport['default_vhostconf_domain'] . "\n";
			}
			$ipportlist .= $ipport;
		}

		$vhost_content .= '<VirtualHost ' . trim($ipportlist) . '>' . "\n";
		$vhost_content.= $this->getServerNames($domain);

		if (($ssl_vhost == false
				&& $domain['ssl'] == '1'
				&& $domain['ssl_redirect'] == '1')
		) {
			// We must not check if our port differs from port 443,
			// but if there is a destination-port != 443
			$_sslport = '';
			// This returns the first port that is != 443 with ssl enabled, if any
			// ordered by ssl-certificate (if any) so that the ip/port combo
			// with certificate is used
			$ssldestport_stmt = Database::prepare("
				SELECT `ip`.`port` FROM ".TABLE_PANEL_IPSANDPORTS." `ip`
				LEFT JOIN `".TABLE_DOMAINTOIP."` `dip` ON (`ip`.`id` = `dip`.`id_ipandports`)
				WHERE `dip`.`id_domain` = :domainid
				AND `ip`.`ssl` = '1'  AND `ip`.`port` != 443
				ORDER BY `ip`.`ssl_cert_file` DESC, `ip`.`port` LIMIT 1;
			");
			$ssldestport = Database::pexecute_first($ssldestport_stmt, array('domainid' => $domain['id']));

			if ($ssldestport['port'] != '') {
				$_sslport = ":".$ssldestport['port'];
			}

			$domain['documentroot'] = 'https://' . $domain['domain'] . $_sslport . '/';
		}

		if ($ssl_vhost === true
			&& $domain['ssl'] == '1'
			&& Settings::Get('system.use_ssl') == '1'
		) {
			if ($domain['ssl_cert_file'] == '') {
				$domain['ssl_cert_file'] = Settings::Get('system.ssl_cert_file');
			}

			if ($domain['ssl_key_file'] == '') {
				$domain['ssl_key_file'] = Settings::Get('system.ssl_key_file');
			}

			if ($domain['ssl_ca_file'] == '') {
				$domain['ssl_ca_file'] = Settings::Get('system.ssl_ca_file');
			}

			if ($domain['ssl_cert_chainfile'] == '') {
				$domain['ssl_cert_chainfile'] = Settings::Get('system.ssl_cert_chainfile');
			}

			if ($domain['ssl_cert_file'] != '') {
				$vhost_content .= '  SSLEngine On' . "\n";
				// this makes it more secure, thx to Marcel (08/2013)
				$vhost_content .= '  SSLHonorCipherOrder On' . "\n";
				$vhost_content .= '  SSLCipherSuite ' . Settings::Get('system.ssl_cipher_list') . "\n";
				$vhost_content .= '  SSLVerifyDepth 10' . "\n";
				$vhost_content .= '  SSLCertificateFile ' . makeCorrectFile($domain['ssl_cert_file']) . "\n";

				if ($domain['ssl_key_file'] != '') {
					$vhost_content .= '  SSLCertificateKeyFile ' . makeCorrectFile($domain['ssl_key_file']) . "\n";
				}

				if ($domain['ssl_ca_file'] != '') {
					$vhost_content .= '  SSLCACertificateFile ' . makeCorrectFile($domain['ssl_ca_file']) . "\n";
				}

				if ($domain['ssl_cert_chainfile'] != '') {
					$vhost_content .= '  SSLCertificateChainFile ' . makeCorrectFile($domain['ssl_cert_chainfile']) . "\n";
				}
			}
		}

		if (preg_match('/^https?\:\/\//', $domain['documentroot'])) {
			$corrected_docroot = $this->idnaConvert->encode($domain['documentroot']);

			// Get domain's redirect code
			$code = getDomainRedirectCode($domain['id']);
			$modrew_red = '';
			if ($code != '') {
				$modrew_red = '[R='. $code . ';L]';
			}

			// redirect everything, not only root-directory, #541
			$vhost_content .= '  <IfModule mod_rewrite.c>'."\n";
			$vhost_content .= '    RewriteEngine On' . "\n";
			$vhost_content .= '    RewriteCond %{HTTPS} off' . "\n";
			$vhost_content .= '    RewriteRule ^/(.*) '. $corrected_docroot.'$1 ' . $modrew_red . "\n";
			$vhost_content .= '  </IfModule>' . "\n";

			$code = getDomainRedirectCode($domain['id']);
			$vhost_content .= '  Redirect '.$code.' / ' . $this->idnaConvert->encode($domain['documentroot']) . "\n";

		} else {

			mkDirWithCorrectOwnership($domain['customerroot'], $domain['documentroot'], $domain['guid'], $domain['guid'], true, true);
			$vhost_content .= $this->getWebroot($domain);
			if ($this->_deactivated == false) {
				$vhost_content .= $this->composePhpOptions($domain,$ssl_vhost);
				$vhost_content .= $this->getStats($domain);
			}
			$vhost_content .= $this->getLogfiles($domain);

			if ($domain['specialsettings'] != '') {
				$vhost_content .= $domain['specialsettings'] . "\n";
			}

			if ($_vhost_content != '') {
				$vhost_content .= $_vhost_content;
			}

			if (Settings::Get('system.default_vhostconf') != '') {
				$vhost_content .= Settings::Get('system.default_vhostconf') . "\n";
			}
		}

		$vhost_content .= '</VirtualHost>' . "\n";

		return $vhost_content;
	}


	/**
	 * We compose the virtualhost entries for the domains
	 */
	public function createVirtualHosts() {

		$domains = WebserverBase::getVhostsToCreate();
		foreach ($domains as $domain) {

			fwrite($this->debugHandler, '  apache::createVirtualHosts: creating vhost container for domain ' . $domain['id'] . ', customer ' . $domain['loginname'] . "\n");
			$this->logger->logAction(CRON_ACTION, LOG_INFO, 'creating vhost container for domain ' . $domain['id'] . ', customer ' . $domain['loginname']);
			$vhosts_filename = $this->getVhostFilename($domain);

			// Apply header
			$this->virtualhosts_data[$vhosts_filename] = '# Domain ID: ' . $domain['id'] . ' - CustomerID: ' . $domain['customerid'] . ' - CustomerLogin: ' . $domain['loginname'] . "\n";

			if ($domain['deactivated'] != '1'
				|| Settings::Get('system.deactivateddocroot') != ''
			) {
				// Create vhost without ssl
				$this->virtualhosts_data[$vhosts_filename].= $this->getVhostContent($domain, false);

				if ($domain['ssl'] == '1' || $domain['ssl_redirect'] == '1') {
					// Adding ssl stuff if enabled
					$vhosts_filename_ssl = $this->getVhostFilename($domain, true);
					$this->virtualhosts_data[$vhosts_filename_ssl] = '# Domain ID: ' . $domain['id'] . ' (SSL) - CustomerID: ' . $domain['customerid'] . ' - CustomerLogin: ' . $domain['loginname'] . "\n";
					$this->virtualhosts_data[$vhosts_filename_ssl] .= $this->getVhostContent($domain, true);
				}
			} else {
				$this->virtualhosts_data[$vhosts_filename] .= '# Customer deactivated and a docroot for deactivated users hasn\'t been set.' . "\n";
			}
		}
	}


	/**
	 * We compose the diroption entries for the paths
	 */
	public function createFileDirOptions() {
		$result_stmt = Database::query("
			SELECT `htac`.*, `c`.`guid`, `c`.`documentroot` AS `customerroot`
			FROM `" . TABLE_PANEL_HTACCESS . "` `htac`
			LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING (`customerid`)
			ORDER BY `htac`.`path`
		");
		$diroptions = array();

		while ($row_diroptions = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($row_diroptions['customerid'] != 0
				&& isset($row_diroptions['customerroot'])
				&& $row_diroptions['customerroot'] != ''
			) {
				$diroptions[$row_diroptions['path']] = $row_diroptions;
				$diroptions[$row_diroptions['path']]['htpasswds'] = array();
			}
		}

		$result_stmt = Database::query("
			SELECT `htpw`.*, `c`.`guid`, `c`.`documentroot` AS `customerroot`
			FROM `" . TABLE_PANEL_HTPASSWDS . "` `htpw`
			LEFT JOIN `" . TABLE_PANEL_CUSTOMERS . "` `c` USING (`customerid`)
			ORDER BY `htpw`.`path`, `htpw`.`username`
		");

		while ($row_htpasswds = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($row_htpasswds['customerid'] != 0
				&& isset($row_htpasswds['customerroot'])
				&& $row_htpasswds['customerroot'] != ''
			) {
				if (!isset($diroptions[$row_htpasswds['path']]) || !is_array($diroptions[$row_htpasswds['path']])) {
					$diroptions[$row_htpasswds['path']] = array();
				}

				$diroptions[$row_htpasswds['path']]['path'] = $row_htpasswds['path'];
				$diroptions[$row_htpasswds['path']]['guid'] = $row_htpasswds['guid'];
				$diroptions[$row_htpasswds['path']]['customerroot'] = $row_htpasswds['customerroot'];
				$diroptions[$row_htpasswds['path']]['customerid'] = $row_htpasswds['customerid'];
				$diroptions[$row_htpasswds['path']]['htpasswds'][] = $row_htpasswds;
			}
		}

		foreach ($diroptions as $row_diroptions) {
			$row_diroptions['path'] = makeCorrectDir($row_diroptions['path']);
			mkDirWithCorrectOwnership($row_diroptions['customerroot'], $row_diroptions['path'], $row_diroptions['guid'], $row_diroptions['guid']);
			$diroptions_filename = makeCorrectFile(Settings::Get('system.apacheconf_diroptions') . '/40_froxlor_diroption_' . md5($row_diroptions['path']) . '.conf');

			if (!isset($this->diroptions_data[$diroptions_filename])) {
				$this->diroptions_data[$diroptions_filename] = '';
			}

			if (is_dir($row_diroptions['path'])) {
				$cperlenabled = customerHasPerlEnabled($row_diroptions['customerid']);

				$this->diroptions_data[$diroptions_filename] .= '<Directory "' . $row_diroptions['path'] . '">' . "\n";

				if (isset($row_diroptions['options_indexes'])
					&& $row_diroptions['options_indexes'] == '1'
				) {
					$this->diroptions_data[$diroptions_filename] .= '  Options +Indexes';

					// add perl options if enabled
					if ($cperlenabled
						&& isset($row_diroptions['options_cgi'])
						&& $row_diroptions['options_cgi'] == '1'
					) {
						$this->diroptions_data[$diroptions_filename] .= ' +ExecCGI -MultiViews +SymLinksIfOwnerMatch +FollowSymLinks'."\n";
					} else {
						$this->diroptions_data[$diroptions_filename] .= "\n";
					}
					fwrite($this->debugHandler, '  cron_tasks: Task3 - Setting Options +Indexes' . "\n");
				}

				if (isset($row_diroptions['options_indexes'])
					&& $row_diroptions['options_indexes'] == '0'
				) {
					$this->diroptions_data[$diroptions_filename] .= '  Options -Indexes';

					// add perl options if enabled
					if ($cperlenabled
						&& isset($row_diroptions['options_cgi'])
						&& $row_diroptions['options_cgi'] == '1'
					) {
						$this->diroptions_data[$diroptions_filename] .= ' +ExecCGI -MultiViews +SymLinksIfOwnerMatch +FollowSymLinks'."\n";
					} else {
						$this->diroptions_data[$diroptions_filename] .= "\n";
					}
					fwrite($this->debugHandler, '  cron_tasks: Task3 - Setting Options -Indexes' . "\n");
				}

				$statusCodes = array('404', '403', '500');
				foreach ($statusCodes as $statusCode) {
					if (isset($row_diroptions['error' . $statusCode . 'path'])
						&& $row_diroptions['error' . $statusCode . 'path'] != ''
					) {
						$defhandler = $row_diroptions['error' . $statusCode . 'path'];
						if (!validateUrl($defhandler)) {
							if (substr($defhandler, 0, 1) != '"' && substr($defhandler, -1, 1) != '"') {
								$defhandler = '"'.makeCorrectFile($defhandler).'"';
							}
						}
						$this->diroptions_data[$diroptions_filename].= '  ErrorDocument ' . $statusCode . ' ' . $defhandler . "\n";
					}
				}

				if ($cperlenabled
					&& isset($row_diroptions['options_cgi'])
					&& $row_diroptions['options_cgi'] == '1'
				) {
					$this->diroptions_data[$diroptions_filename] .= '  AllowOverride None' . "\n";
					$this->diroptions_data[$diroptions_filename] .= '  AddHandler cgi-script .cgi .pl' . "\n";
					// >=apache-2.4 enabled?
					if (Settings::Get('system.apache24') == '1') {
						$this->diroptions_data[$diroptions_filename] .= '  Require all granted' . "\n";
					} else {
						$this->diroptions_data[$diroptions_filename] .= '  Order allow,deny' . "\n";
						$this->diroptions_data[$diroptions_filename] .= '  Allow from all' . "\n";
					}
					fwrite($this->debugHandler, '  cron_tasks: Task3 - Enabling perl execution' . "\n");

					// check for suexec-workaround, #319
					if ((int)Settings::Get('perl.suexecworkaround') == 1) {
						// symlink this directory to suexec-safe-path
						$loginname = getCustomerDetail($row_diroptions['customerid'], 'loginname');
						$suexecpath = makeCorrectDir(Settings::Get('perl.suexecpath').'/'.$loginname.'/'.md5($row_diroptions['path']).'/');

						if (!file_exists($suexecpath)) {
							safe_exec('mkdir -p '.escapeshellarg($suexecpath));
							safe_exec('chown -R '.escapeshellarg($row_diroptions['guid']).':'.escapeshellarg($row_diroptions['guid']).' '.escapeshellarg($suexecpath));
						}

						// symlink to {$givenpath}/cgi-bin
						// NOTE: symlinks are FILES, so do not append a / here
						$perlsymlink = makeCorrectFile($row_diroptions['path'].'/cgi-bin');
						if (!file_exists($perlsymlink)) {
							safe_exec('ln -s '.escapeshellarg($suexecpath).' '.escapeshellarg($perlsymlink));
						}
						safe_exec('chown '.escapeshellarg($row_diroptions['guid']).':'.escapeshellarg($row_diroptions['guid']).' '.escapeshellarg($perlsymlink));
					}
				} else {
					// if no perl-execution is enabled but the workaround is,
					// we have to remove the symlink and folder in suexecpath
					if ((int)Settings::Get('perl.suexecworkaround') == 1) {
						$loginname = getCustomerDetail($row_diroptions['customerid'], 'loginname');
						$suexecpath = makeCorrectDir(Settings::Get('perl.suexecpath').'/'.$loginname.'/'.md5($row_diroptions['path']).'/');
						$perlsymlink = makeCorrectFile($row_diroptions['path'].'/cgi-bin');

						// remove symlink
						if (file_exists($perlsymlink)) {
							safe_exec('rm -f '.escapeshellarg($perlsymlink));
						}
						// remove folder in suexec-path
						if (file_exists($suexecpath)) {
							safe_exec('rm -rf '.escapeshellarg($suexecpath));
						}
					}
				}

				if (count($row_diroptions['htpasswds']) > 0) {
					$htpasswd_filename = makeCorrectFile(Settings::Get('system.apacheconf_htpasswddir') . '/' . $row_diroptions['customerid'] . '-' . md5($row_diroptions['path']) . '.htpasswd');

					if (!isset($this->htpasswds_data[$htpasswd_filename])) {
						$this->htpasswds_data[$htpasswd_filename] = '';
					}

					foreach ($row_diroptions['htpasswds'] as $row_htpasswd) {
						$this->htpasswds_data[$htpasswd_filename] .= $row_htpasswd['username'] . ':' . $row_htpasswd['password'] . "\n";
					}

					$this->diroptions_data[$diroptions_filename] .= '  AuthType Basic' . "\n";
					$this->diroptions_data[$diroptions_filename] .= '  AuthName "'.$row_htpasswd['authname'].'"' . "\n";
					$this->diroptions_data[$diroptions_filename] .= '  AuthUserFile ' . $htpasswd_filename . "\n";
					$this->diroptions_data[$diroptions_filename] .= '  require valid-user' . "\n";
				}

				$this->diroptions_data[$diroptions_filename] .= '</Directory>' . "\n";
			}
		}
	}


	/**
	 * We write the configs
	 */
	public function writeConfigs() {
		// Write diroptions
		fwrite($this->debugHandler, '  apache::writeConfigs: rebuilding ' . Settings::Get('system.apacheconf_diroptions') . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "rebuilding " . Settings::Get('system.apacheconf_diroptions'));

		if (count($this->diroptions_data) > 0) {
			if (!isConfigDir(Settings::Get('system.apacheconf_diroptions'))) {
				// Save one big file
				$diroptions_file = '';

				foreach ($this->diroptions_data as $diroptions_filename => $diroptions_content) {
					$diroptions_file.= $diroptions_content . "\n\n";
				}

				$diroptions_filename = Settings::Get('system.apacheconf_diroptions');

				// Apply header
				$diroptions_file = '# ' . basename($diroptions_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $diroptions_file;
				$diroptions_file_handler = fopen($diroptions_filename, 'w');
				fwrite($diroptions_file_handler, $diroptions_file);
				fclose($diroptions_file_handler);
			} else {
				if (!file_exists(Settings::Get('system.apacheconf_diroptions'))) {
					fwrite($this->debugHandler, '  apache::writeConfigs: mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_diroptions'))) . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_diroptions'))));
					safe_exec('mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_diroptions'))));
				}

				// Write a single file for every diroption
				foreach ($this->diroptions_data as $diroptions_filename => $diroptions_file) {
					$this->known_diroptionsfilenames[] = basename($diroptions_filename);

					// Apply header
					$diroptions_file = '# ' . basename($diroptions_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $diroptions_file;
					$diroptions_file_handler = fopen($diroptions_filename, 'w');
					fwrite($diroptions_file_handler, $diroptions_file);
					fclose($diroptions_file_handler);
				}
			}
		}

		// Write htpasswds
		fwrite($this->debugHandler, '  apache::writeConfigs: rebuilding ' . Settings::Get('system.apacheconf_htpasswddir') . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "rebuilding " . Settings::Get('system.apacheconf_htpasswddir'));

		if (count($this->htpasswds_data) > 0) {
			if (!file_exists(Settings::Get('system.apacheconf_htpasswddir'))) {
				$umask = umask();
				umask(0000);
				mkdir(Settings::Get('system.apacheconf_htpasswddir'), 0751);
				umask($umask);
			}

			if (isConfigDir(Settings::Get('system.apacheconf_htpasswddir'), true)) {
				foreach ($this->htpasswds_data as $htpasswd_filename => $htpasswd_file) {
					$this->known_htpasswdsfilenames[] = basename($htpasswd_filename);
					$htpasswd_file_handler = fopen($htpasswd_filename, 'w');
					fwrite($htpasswd_file_handler, $htpasswd_file);
					fclose($htpasswd_file_handler);
				}
			} else {
				fwrite($this->debugHandler, '  cron_tasks: WARNING!!! ' . Settings::Get('system.apacheconf_htpasswddir') . ' is not a directory. htpasswd directory protection is disabled!!!' . "\n");
				echo 'WARNING!!! ' . Settings::Get('system.apacheconf_htpasswddir') . ' is not a directory. htpasswd directory protection is disabled!!!';
				$this->logger->logAction(CRON_ACTION, LOG_WARNING, 'WARNING!!! ' . Settings::Get('system.apacheconf_htpasswddir') . ' is not a directory. htpasswd directory protection is disabled!!!');
			}
		}

		// Write virtualhosts
		fwrite($this->debugHandler, '  apache::writeConfigs: rebuilding ' . Settings::Get('system.apacheconf_vhost') . "\n");
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "rebuilding " . Settings::Get('system.apacheconf_vhost'));

		if (count($this->virtualhosts_data) > 0) {
			if (!isConfigDir(Settings::Get('system.apacheconf_vhost'))) {
				// Save one big file
				$vhosts_file = '';

				// sort by filename so the order is:
				// 1. subdomains                  20
				// 2. subdomains as main-domains  21
				// 3. main-domains                22
				// #437
				ksort($this->virtualhosts_data);

				foreach ($this->virtualhosts_data as $vhosts_filename => $vhost_content) {
					$vhosts_file.= $vhost_content . "\n\n";
				}

				// Include diroptions file in case it exists
				if (file_exists(Settings::Get('system.apacheconf_diroptions'))) {
					$vhosts_file.= "\n" . 'Include ' . Settings::Get('system.apacheconf_diroptions') . "\n\n";
				}

				$vhosts_filename = Settings::Get('system.apacheconf_vhost');

				// Apply header
				$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;
				$vhosts_file_handler = fopen($vhosts_filename, 'w');
				fwrite($vhosts_file_handler, $vhosts_file);
				fclose($vhosts_file_handler);
			} else {
				if (!file_exists(Settings::Get('system.apacheconf_vhost'))) {
					fwrite($this->debugHandler, '  apache::writeConfigs: mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost'))) . "\n");
					$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost'))));
					safe_exec('mkdir ' . escapeshellarg(makeCorrectDir(Settings::Get('system.apacheconf_vhost'))));
				}

				// Write a single file for every vhost
				foreach ($this->virtualhosts_data as $vhosts_filename => $vhosts_file) {
					$this->known_vhostfilenames[] = basename($vhosts_filename);

					// Apply header
					$vhosts_file = '# ' . basename($vhosts_filename) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" . '# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n" . "\n" . $vhosts_file;
					$vhosts_file_handler = fopen($vhosts_filename, 'w');
					fwrite($vhosts_file_handler, $vhosts_file);
					fclose($vhosts_file_handler);
				}
			}
		}
	}


}
