<?php
namespace Froxlor\Cron\Http\Php;

use Froxlor\Database\Database;
use Froxlor\Settings;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 * @link http://www.nutime.de/
 * @since 0.9.16
 *       
 */
class Fpm
{

	/**
	 * Domain-Data array
	 *
	 * @var array
	 */
	private $domain = array();

	/**
	 * fpm config
	 *
	 * @var array
	 */
	private $fpm_cfg = array();

	/**
	 * Admin-Date cache array
	 *
	 * @var array
	 */
	private $admin_cache = array();

	/**
	 * defines what can be used for pool-config from php.ini
	 * Mostly taken from http://php.net/manual/en/ini.list.php
	 *
	 * @var array
	 */
	private $ini = array();

	/**
	 * main constructor
	 */
	public function __construct($domain)
	{
		if (! isset($domain['fpm_config_id']) || empty($domain['fpm_config_id'])) {
			$domain['fpm_config_id'] = 1;
		}
		$this->domain = $domain;
		$this->readFpmConfig($domain['fpm_config_id']);
		$this->buildIniMapping();
	}

	private function buildIniMapping()
	{
		$this->ini = array(
			'php_flag' => explode("\n", Settings::Get('phpfpm.ini_flags')),
			'php_value' => explode("\n", Settings::Get('phpfpm.ini_values')),
			'php_admin_flag' => explode("\n", Settings::Get('phpfpm.ini_admin_flags')),
			'php_admin_value' => explode("\n", Settings::Get('phpfpm.ini_admin_values'))
		);
	}

	private function readFpmConfig($fpm_config_id)
	{
		$stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_FPMDAEMONS . "` WHERE `id` = :id");
		$this->fpm_cfg = Database::pexecute_first($stmt, array(
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
				$this->fpm_cfg['pm'] = $phpconfig['pm'];
				$this->fpm_cfg['max_children'] = $phpconfig['max_children'];
				$this->fpm_cfg['start_servers'] = $phpconfig['start_servers'];
				$this->fpm_cfg['min_spare_servers'] = $phpconfig['min_spare_servers'];
				$this->fpm_cfg['max_spare_servers'] = $phpconfig['max_spare_servers'];
				$this->fpm_cfg['max_requests'] = $phpconfig['max_requests'];
				$this->fpm_cfg['idle_timeout'] = $phpconfig['idle_timeout'];
				$this->fpm_cfg['limit_extensions'] = $phpconfig['limit_extensions'];
			}

			$fpm_pm = $this->fpm_cfg['pm'];
			$fpm_children = (int) $this->fpm_cfg['max_children'];
			$fpm_start_servers = (int) $this->fpm_cfg['start_servers'];
			$fpm_min_spare_servers = (int) $this->fpm_cfg['min_spare_servers'];
			$fpm_max_spare_servers = (int) $this->fpm_cfg['max_spare_servers'];
			$fpm_requests = (int) $this->fpm_cfg['max_requests'];
			$fpm_process_idle_timeout = (int) $this->fpm_cfg['idle_timeout'];
			$fpm_limit_extensions = $this->fpm_cfg['limit_extensions'];

			if ($fpm_children == 0) {
				$fpm_children = 1;
			}

			$fpm_config = ';PHP-FPM configuration for "' . $this->domain['domain'] . '" created on ' . date("Y.m.d H:i:s") . "\n";
			$fpm_config .= '[' . $this->domain['domain'] . ']' . "\n";
			$fpm_config .= 'listen = ' . $this->getSocketFile() . "\n";
			if ($this->domain['loginname'] == 'froxlor.panel') {
				$fpm_config .= 'listen.owner = ' . $this->domain['guid'] . "\n";
				$fpm_config .= 'listen.group = ' . $this->domain['guid'] . "\n";
			} else {
				$fpm_config .= 'listen.owner = ' . $this->domain['loginname'] . "\n";
				$fpm_config .= 'listen.group = ' . $this->domain['loginname'] . "\n";
			}
			// see #1418 why this is 0660
			$fpm_config .= 'listen.mode = 0660' . "\n";

			if ($this->domain['loginname'] == 'froxlor.panel') {
				$fpm_config .= 'user = ' . $this->domain['guid'] . "\n";
				$fpm_config .= 'group = ' . $this->domain['guid'] . "\n";
			} else {
				$fpm_config .= 'user = ' . $this->domain['loginname'] . "\n";
				$fpm_config .= 'group = ' . $this->domain['loginname'] . "\n";
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
				$slowlog = \Froxlor\FileDir::makeCorrectFile(Settings::Get('system.logfiles_directory') . '/' . $this->domain['loginname'] . '-php-slow.log');
				$fpm_config .= 'slowlog = ' . $slowlog . "\n";
				$fpm_config .= 'catch_workers_output = yes' . "\n";
			}

			$fpm_config .= ';chroot = ' . \Froxlor\FileDir::makeCorrectDir($this->domain['documentroot']) . "\n";
			$fpm_config .= 'security.limit_extensions = ' . $fpm_limit_extensions . "\n";

			$tmpdir = \Froxlor\FileDir::makeCorrectDir(Settings::Get('phpfpm.tmpdir') . '/' . $this->domain['loginname'] . '/');
			if (! is_dir($tmpdir)) {
				$this->getTempDir();
			}

			$env_path = Settings::Get('phpfpm.envpath');
			if (! empty($env_path)) {
				$fpm_config .= 'env[PATH] = ' . $env_path . "\n";
			}
			$fpm_config .= 'env[TMP] = ' . $tmpdir . "\n";
			$fpm_config .= 'env[TMPDIR] = ' . $tmpdir . "\n";
			$fpm_config .= 'env[TEMP] = ' . $tmpdir . "\n";

			$openbasedir = '';
			if ($this->domain['loginname'] != 'froxlor.panel') {
				if ($this->domain['openbasedir'] == '1') {
					$_phpappendopenbasedir = '';
					$_custom_openbasedir = explode(':', Settings::Get('phpfpm.peardir'));
					foreach ($_custom_openbasedir as $cobd) {
						$_phpappendopenbasedir .= \Froxlor\Domain\Domain::appendOpenBasedirPath($cobd);
					}

					$_custom_openbasedir = explode(':', Settings::Get('system.phpappendopenbasedir'));
					foreach ($_custom_openbasedir as $cobd) {
						$_phpappendopenbasedir .= \Froxlor\Domain\Domain::appendOpenBasedirPath($cobd);
					}

					if ($this->domain['openbasedir_path'] == '0' && strstr($this->domain['documentroot'], ":") === false) {
						$openbasedir = \Froxlor\Domain\Domain::appendOpenBasedirPath($this->domain['documentroot'], true);
					} else {
						$openbasedir = \Froxlor\Domain\Domain::appendOpenBasedirPath($this->domain['customerroot'], true);
					}

					$openbasedir .= \Froxlor\Domain\Domain::appendOpenBasedirPath($this->getTempDir());
					$openbasedir .= $_phpappendopenbasedir;
				}
			}
			$fpm_config .= 'php_admin_value[session.save_path] = ' . \Froxlor\FileDir::makeCorrectDir(Settings::Get('phpfpm.tmpdir') . '/' . $this->domain['loginname'] . '/') . "\n";
			$fpm_config .= 'php_admin_value[upload_tmp_dir] = ' . \Froxlor\FileDir::makeCorrectDir(Settings::Get('phpfpm.tmpdir') . '/' . $this->domain['loginname'] . '/') . "\n";

			$admin = $this->getAdminData($this->domain['adminid']);
			$php_ini_variables = array(
				'SAFE_MODE' => 'Off', // keep this for compatibility, just in case
				'PEAR_DIR' => Settings::Get('phpfpm.peardir'),
				'TMP_DIR' => $this->getTempDir(),
				'CUSTOMER_EMAIL' => $this->domain['email'],
				'ADMIN_EMAIL' => $admin['email'],
				'DOMAIN' => $this->domain['domain'],
				'CUSTOMER' => $this->domain['loginname'],
				'ADMIN' => $admin['loginname'],
				'OPEN_BASEDIR' => $openbasedir,
				'OPEN_BASEDIR_C' => '',
				'OPEN_BASEDIR_GLOBAL' => Settings::Get('system.phpappendopenbasedir'),
				'DOCUMENT_ROOT' => \Froxlor\FileDir::makeCorrectDir($this->domain['documentroot']),
				'CUSTOMER_HOMEDIR' => \Froxlor\FileDir::makeCorrectDir($this->domain['customerroot'])
			);

			$phpini = \Froxlor\PhpHelper::replaceVariables($phpconfig['phpsettings'], $php_ini_variables);
			$phpini_array = explode("\n", $phpini);

			$fpm_config .= "\n\n";
			foreach ($phpini_array as $inisection) {
				$is = explode("=", $inisection);
				foreach ($this->ini as $sec => $possibles) {
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
				$fpm_config .= 'php_admin_value[sendmail_path] = /usr/sbin/sendmail -t -i -f ' . $this->domain['email'] . "\n";
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
		$configdir = $this->fpm_cfg['config_dir'];
		$config = \Froxlor\FileDir::makeCorrectFile($configdir . '/' . $this->domain['domain'] . '.conf');

		if (! is_dir($configdir) && $createifnotexists) {
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($configdir));
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
		$socketdir = \Froxlor\FileDir::makeCorrectDir(Settings::Get('phpfpm.fastcgi_ipcdir'));
		// add fpm-config-id to filename so it's unique for the fpm-daemon and doesn't interfere with running configs when reuilding
		$socket = strtolower(\Froxlor\FileDir::makeCorrectFile($socketdir . '/' . $this->domain['fpm_config_id'] . '-' . $this->domain['loginname'] . '-' . $this->domain['domain'] . '-php-fpm.socket'));

		if (! is_dir($socketdir) && $createifnotexists) {
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($socketdir));
			\Froxlor\FileDir::safe_exec('chown -R ' . Settings::Get('system.httpuser') . ':' . Settings::Get('system.httpgroup') . ' ' . escapeshellarg($socketdir));
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
		$tmpdir = \Froxlor\FileDir::makeCorrectDir(Settings::Get('phpfpm.tmpdir') . '/' . $this->domain['loginname'] . '/');

		if (! is_dir($tmpdir) && $createifnotexists) {
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
			\Froxlor\FileDir::safe_exec('chown -R ' . $this->domain['guid'] . ':' . $this->domain['guid'] . ' ' . escapeshellarg($tmpdir));
			\Froxlor\FileDir::safe_exec('chmod 0750 ' . escapeshellarg($tmpdir));
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

		$configdir = \Froxlor\FileDir::makeCorrectDir(Settings::Get('phpfpm.aliasconfigdir') . '/' . $this->domain['loginname'] . '/' . $this->domain['domain'] . '/');
		if (! is_dir($configdir) && $createifnotexists) {
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($configdir));
			\Froxlor\FileDir::safe_exec('chown ' . $this->domain['guid'] . ':' . $this->domain['guid'] . ' ' . escapeshellarg($configdir));
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
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($configdir));
		}
		$config = \Froxlor\FileDir::makeCorrectFile($configdir . '/dummy.conf');
		$dummy = "[dummy]
user = " . Settings::Get('system.httpuser') . "
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
	private function getAdminData($adminid)
	{
		$adminid = intval($adminid);

		if (! isset($this->admin_cache[$adminid])) {
			$stmt = Database::prepare("
					SELECT `email`, `loginname` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid` = :id");
			$this->admin_cache[$adminid] = Database::pexecute_first($stmt, array(
				'id' => $adminid
			));
		}
		return $this->admin_cache[$adminid];
	}
}
