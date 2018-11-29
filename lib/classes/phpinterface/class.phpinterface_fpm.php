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
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 * @link       http://www.nutime.de/
 * @since      0.9.16
 *
 */
class phpinterface_fpm
{

	/**
	 * Domain-Data array
	 *
	 * @var array
	 */
	private $_domain = array();

	/**
	 * fpm config
	 *
	 * @var array
	 */
	private $_fpm_cfg = array();

	/**
	 * Admin-Date cache array
	 *
	 * @var array
	 */
	private $_admin_cache = array();

	/**
	 * defines what can be used for pool-config from php.ini
	 * Mostly taken from http://php.net/manual/en/ini.list.php
	 *
	 * @var array
	 */
	private $_ini = array();

	/**
	 * main constructor
	 */
	public function __construct($domain)
	{
		if (!isset($domain['fpm_config_id']) || empty($domain['fpm_config_id'])) {
			$domain['fpm_config_id'] = 1;
		}
		$this->_domain = $domain;
		$this->_readFpmConfig($domain['fpm_config_id']);
		$this->_buildIniMapping();
	}

	private function _buildIniMapping()
	{
		$this->_ini = array(
			'php_flag' => explode("\n", Settings::Get('phpfpm.ini_flags')),
			'php_value' => explode("\n", Settings::Get('phpfpm.ini_values')),
			'php_admin_flag' => explode("\n", Settings::Get('phpfpm.ini_admin_flags')),
			'php_admin_value' => explode("\n", Settings::Get('phpfpm.ini_admin_values'))
		);
	}

	private function _readFpmConfig($fpm_config_id)
	{
		$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` WHERE `id` = :id");
		$this->_fpm_cfg = Database::pexecute_first($stmt, array(
			'id' => $fpm_config_id
		));
	}

	/**
	 * create fpm-pool config
	 *
	 * @param array $phpconfig
	 */
	public function createConfig($phpconfig)
	{
		$fh = @fopen($this->getConfigFile(), 'w');
		
		if ($fh) {
			
			if ($phpconfig['override_fpmconfig'] == 1) {
				$this->_fpm_cfg['pm'] = $phpconfig['pm'];
				$this->_fpm_cfg['max_children'] = $phpconfig['max_children'];
				$this->_fpm_cfg['start_servers'] = $phpconfig['start_servers'];
				$this->_fpm_cfg['min_spare_servers'] = $phpconfig['min_spare_servers'];
				$this->_fpm_cfg['max_spare_servers'] = $phpconfig['max_spare_servers'];
				$this->_fpm_cfg['max_requests'] = $phpconfig['max_requests'];
				$this->_fpm_cfg['idle_timeout'] = $phpconfig['idle_timeout'];
				$this->_fpm_cfg['limit_extensions'] = $phpconfig['limit_extensions'];
			}
			
			$fpm_pm = $this->_fpm_cfg['pm'];
			$fpm_children = (int) $this->_fpm_cfg['max_children'];
			$fpm_start_servers = (int) $this->_fpm_cfg['start_servers'];
			$fpm_min_spare_servers = (int) $this->_fpm_cfg['min_spare_servers'];
			$fpm_max_spare_servers = (int) $this->_fpm_cfg['max_spare_servers'];
			$fpm_requests = (int) $this->_fpm_cfg['max_requests'];
			$fpm_process_idle_timeout = (int) $this->_fpm_cfg['idle_timeout'];
			$fpm_limit_extensions = $this->_fpm_cfg['limit_extensions'];
			
			if ($fpm_children == 0) {
				$fpm_children = 1;
			}
			
			$fpm_config = ';PHP-FPM configuration for "' . $this->_domain['domain'] . '" created on ' . date("Y.m.d H:i:s") . "\n";
			$fpm_config .= '[' . $this->_domain['domain'] . ']' . "\n";
			$fpm_config .= 'listen = ' . $this->getSocketFile() . "\n";
			if ($this->_domain['loginname'] == 'froxlor.panel') {
				$fpm_config .= 'listen.owner = ' . $this->_domain['guid'] . "\n";
				$fpm_config .= 'listen.group = ' . $this->_domain['guid'] . "\n";
			} else {
				$fpm_config .= 'listen.owner = ' . $this->_domain['loginname'] . "\n";
				$fpm_config .= 'listen.group = ' . $this->_domain['loginname'] . "\n";
			}
			// see #1418 why this is 0660
			$fpm_config .= 'listen.mode = 0660' . "\n";
			
			if ($this->_domain['loginname'] == 'froxlor.panel') {
				$fpm_config .= 'user = ' . $this->_domain['guid'] . "\n";
				$fpm_config .= 'group = ' . $this->_domain['guid'] . "\n";
			} else {
				$fpm_config .= 'user = ' . $this->_domain['loginname'] . "\n";
				$fpm_config .= 'group = ' . $this->_domain['loginname'] . "\n";
			}
			
			$fpm_config .= 'pm = ' . $fpm_pm . "\n";
			$fpm_config .= 'pm.max_children = ' . $fpm_children . "\n";
			
			if ($fpm_pm == 'dynamic') {
				// honor max_children
				if ($fpm_children < $fpm_min_spare_servers) {
					$fpm_min_spare_servers = $fpm_children;
				}
				if ($fpm_children < $fpm_max_spare_servers) {
					$fpm_max_spare_servers = $fpm_children;
				}
				// failsafe, refs #955
				if ($fpm_start_servers < $fpm_min_spare_servers) {
					$fpm_start_servers = $fpm_min_spare_servers;
				}
				if ($fpm_start_servers > $fpm_max_spare_servers) {
					$fpm_start_servers = $fpm_max_spare_servers;
				}
				$fpm_config .= 'pm.start_servers = ' . $fpm_start_servers . "\n";
				$fpm_config .= 'pm.min_spare_servers = ' . $fpm_min_spare_servers . "\n";
				$fpm_config .= 'pm.max_spare_servers = ' . $fpm_max_spare_servers . "\n";
			} elseif ($fpm_pm == 'ondemand') {
				$fpm_config .= 'pm.process_idle_timeout = ' . $fpm_process_idle_timeout . "\n";
			}
			
			$fpm_config .= 'pm.max_requests = ' . $fpm_requests . "\n";
			
			// possible slowlog configs
			if ($phpconfig['fpm_slowlog'] == '1') {
				$fpm_config .= 'request_terminate_timeout = ' . $phpconfig['fpm_reqterm'] . "\n";
				$fpm_config .= 'request_slowlog_timeout = ' . $phpconfig['fpm_reqslow'] . "\n";
				$slowlog = makeCorrectFile(Settings::Get('system.logfiles_directory') . '/' . $this->_domain['loginname'] . '-php-slow.log');
				$fpm_config .= 'slowlog = ' . $slowlog . "\n";
				$fpm_config .= 'catch_workers_output = yes' . "\n";
			}
			
			$fpm_config .= ';chroot = ' . makeCorrectDir($this->_domain['documentroot']) . "\n";
			$fpm_config .= 'security.limit_extensions = '.$fpm_limit_extensions . "\n";
			
			$tmpdir = makeCorrectDir(Settings::Get('phpfpm.tmpdir') . '/' . $this->_domain['loginname'] . '/');
			if (! is_dir($tmpdir)) {
				$this->getTempDir();
			}
			
			$env_path = Settings::Get('phpfpm.envpath');
			if (!empty($env_path)) {
				$fpm_config .= 'env[PATH] = ' . $env_path . "\n";
			}
			$fpm_config .= 'env[TMP] = ' . $tmpdir . "\n";
			$fpm_config .= 'env[TMPDIR] = ' . $tmpdir . "\n";
			$fpm_config .= 'env[TEMP] = ' . $tmpdir . "\n";
			
			$openbasedir = '';
			if ($this->_domain['loginname'] != 'froxlor.panel') {
				if ($this->_domain['openbasedir'] == '1') {
					$_phpappendopenbasedir = '';
					$_custom_openbasedir = explode(':', Settings::Get('phpfpm.peardir'));
					foreach ($_custom_openbasedir as $cobd) {
						$_phpappendopenbasedir .= appendOpenBasedirPath($cobd);
					}
					
					$_custom_openbasedir = explode(':', Settings::Get('system.phpappendopenbasedir'));
					foreach ($_custom_openbasedir as $cobd) {
						$_phpappendopenbasedir .= appendOpenBasedirPath($cobd);
					}
					
					if ($this->_domain['openbasedir_path'] == '0' && strstr($this->_domain['documentroot'], ":") === false) {
						$openbasedir = appendOpenBasedirPath($this->_domain['documentroot'], true);
					} else {
						$openbasedir = appendOpenBasedirPath($this->_domain['customerroot'], true);
					}
					
					$openbasedir .= appendOpenBasedirPath($this->getTempDir());
					$openbasedir .= $_phpappendopenbasedir;
				}
			}
			$fpm_config .= 'php_admin_value[session.save_path] = ' . makeCorrectDir(Settings::Get('phpfpm.tmpdir') . '/' . $this->_domain['loginname'] . '/') . "\n";
			$fpm_config .= 'php_admin_value[upload_tmp_dir] = ' . makeCorrectDir(Settings::Get('phpfpm.tmpdir') . '/' . $this->_domain['loginname'] . '/') . "\n";
			
			$admin = $this->_getAdminData($this->_domain['adminid']);
			$php_ini_variables = array(
				'SAFE_MODE' => 'Off', // keep this for compatibility, just in case
				'PEAR_DIR' => Settings::Get('phpfpm.peardir'),
				'TMP_DIR' => $this->getTempDir(),
				'CUSTOMER_EMAIL' => $this->_domain['email'],
				'ADMIN_EMAIL' => $admin['email'],
				'DOMAIN' => $this->_domain['domain'],
				'CUSTOMER' => $this->_domain['loginname'],
				'ADMIN' => $admin['loginname'],
				'OPEN_BASEDIR' => $openbasedir,
				'OPEN_BASEDIR_C' => '',
				'OPEN_BASEDIR_GLOBAL' => Settings::Get('system.phpappendopenbasedir'),
				'DOCUMENT_ROOT' => makeCorrectDir($this->_domain['documentroot']),
				'CUSTOMER_HOMEDIR' => makeCorrectDir($this->_domain['customerroot'])
			);
			
			$phpini = replace_variables($phpconfig['phpsettings'], $php_ini_variables);
			$phpini_array = explode("\n", $phpini);
			
			$fpm_config .= "\n\n";
			foreach ($phpini_array as $inisection) {
				$is = explode("=", $inisection);
				foreach ($this->_ini as $sec => $possibles) {
					if (in_array(trim($is[0]), $possibles)) {
						// check explicitly for open_basedir
						if (trim($is[0]) == 'open_basedir' && $openbasedir == '') {
							continue;
						}
						$fpm_config .= $sec . '[' . trim($is[0]) . '] = ' . trim($is[1]) . "\n";
					}
				}
			}
			
			// now check if 'sendmail_path' has not beed set in the custom-php.ini
			// if not we use our fallback-default as usual
			if (strpos($fpm_config, 'php_admin_value[sendmail_path]') === false) {
				$fpm_config .= 'php_admin_value[sendmail_path] = /usr/sbin/sendmail -t -i -f ' . $this->_domain['email'] . "\n";
			}
			
			fwrite($fh, $fpm_config, strlen($fpm_config));
			fclose($fh);
		}
	}

	/**
	 * this is done via createConfig as php-fpm defines
	 * the ini-values/flags in its pool-config
	 *
	 * @param string $phpconfig
	 */
	public function createIniFile($phpconfig)
	{
		return;
	}

	/**
	 * fpm-config file
	 *
	 * @param boolean $createifnotexists
	 *        	create the directory if it does not exist
	 *        	
	 * @return string the full path to the file
	 */
	public function getConfigFile($createifnotexists = true)
	{
		$configdir = $this->_fpm_cfg['config_dir'];
		$config = makeCorrectFile($configdir . '/' . $this->_domain['domain'] . '.conf');
		
		if (! is_dir($configdir) && $createifnotexists) {
			safe_exec('mkdir -p ' . escapeshellarg($configdir));
		}
		
		return $config;
	}

	/**
	 * return path of fpm-socket file
	 *
	 * @param boolean $createifnotexists
	 *        	create the directory if it does not exist
	 *        	
	 * @return string the full path to the socket
	 */
	public function getSocketFile($createifnotexists = true)
	{
		$socketdir = makeCorrectDir(Settings::Get('phpfpm.fastcgi_ipcdir'));
		// add fpm-config-id to filename so it's unique for the fpm-daemon and doesn't interfere with running configs when reuilding
		$socket = strtolower(makeCorrectFile($socketdir . '/' . $this->_domain['fpm_config_id'] . '-' . $this->_domain['loginname'] . '-' . $this->_domain['domain'] . '-php-fpm.socket'));
		
		if (! is_dir($socketdir) && $createifnotexists) {
			safe_exec('mkdir -p ' . escapeshellarg($socketdir));
			safe_exec('chown -R ' . Settings::Get('system.httpuser') . ':' . Settings::Get('system.httpgroup') . ' ' . escapeshellarg($socketdir));
		}
		
		return $socket;
	}

	/**
	 * fpm-temp directory
	 *
	 * @param boolean $createifnotexists
	 *        	create the directory if it does not exist
	 *        	
	 * @return string the directory
	 */
	public function getTempDir($createifnotexists = true)
	{
		$tmpdir = makeCorrectDir(Settings::Get('phpfpm.tmpdir') . '/' . $this->_domain['loginname'] . '/');
		
		if (! is_dir($tmpdir) && $createifnotexists) {
			safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
			safe_exec('chown -R ' . $this->_domain['guid'] . ':' . $this->_domain['guid'] . ' ' . escapeshellarg($tmpdir));
			safe_exec('chmod 0750 ' . escapeshellarg($tmpdir));
		}
		
		return $tmpdir;
	}

	/**
	 * fastcgi-fakedirectory directory
	 *
	 * @param boolean $createifnotexists
	 *        	create the directory if it does not exist
	 *        	
	 * @return string the directory
	 */
	public function getAliasConfigDir($createifnotexists = true)
	{
		
		// ensure default...
		if (Settings::Get('phpfpm.aliasconfigdir') == null) {
			Settings::Set('phpfpm.aliasconfigdir', '/var/www/php-fpm');
		}
		
		$configdir = makeCorrectDir(Settings::Get('phpfpm.aliasconfigdir') . '/' . $this->_domain['loginname'] . '/' . $this->_domain['domain'] . '/');
		if (! is_dir($configdir) && $createifnotexists) {
			safe_exec('mkdir -p ' . escapeshellarg($configdir));
			safe_exec('chown ' . $this->_domain['guid'] . ':' . $this->_domain['guid'] . ' ' . escapeshellarg($configdir));
		}
		
		return $configdir;
	}

	/**
	 * create a dummy fpm pool config with minimal configuration
	 * (this is used whenever a config directory is empty but needs at least one pool to startup/restart)
	 *
	 * @param string $configdir
	 */
	public static function createDummyPool($configdir)
	{
		if (! is_dir($configdir)) {
			safe_exec('mkdir -p ' . escapeshellarg($configdir));
		}
		$config = makeCorrectFile($configdir . '/dummy.conf');
		$dummy = "[dummy]
user = ".Settings::Get('system.httpuser')."
listen = /run/" . md5($configdir) . "-fpm.sock
pm = static
pm.max_children = 1
";
		file_put_contents($config, $dummy);
	}

	/**
	 * return the admin-data of a specific admin
	 *
	 * @param int $adminid
	 *        	id of the admin-user
	 *        	
	 * @return array
	 */
	private function _getAdminData($adminid)
	{
		$adminid = intval($adminid);
		
		if (! isset($this->_admin_cache[$adminid])) {
			$stmt = Database::prepare("
					SELECT `email`, `loginname` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid` = :id");
			$this->_admin_cache[$adminid] = Database::pexecute_first($stmt, array(
				'id' => $adminid
			));
		}
		return $this->_admin_cache[$adminid];
	}
}
