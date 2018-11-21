#!/usr/bin/php
<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2018 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2018-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 */

// Check if we're in the CLI
if (@php_sapi_name() !== 'cli') {
	die('This script will only work in the shell.');
}

require dirname(dirname(__DIR__)) . '/lib/classes/output/class.CmdLineHandler.php';

class ConfigServicesCmd extends CmdLineHandler
{

	/**
	 * list of valid switches
	 *
	 * @var array
	 */
	public static $switches = array(
		'h'
	);

	/**
	 * list of valid parameters
	 *
	 * @var array
	 */
	public static $params = array(
		'create',
		'apply',
		'import-settings',
		'daemon',
		'list-daemons',
		'froxlor-dir',
		'help'
	);

	public static $action_class = 'Action';

	public static function printHelp()
	{
		self::println("");
		self::println("Help / command line parameters:");
		self::println("");
		// commands
		self::println("--create\t\tlets you create a services list configuration for the 'apply' command");
		self::println("");
		self::println("--apply\t\t\tconfigure your services by given configuration file. To create one run the --create command");
		self::println("\t\t\tExample: --apply=/path/to/my-config.json or --apply=http://domain.tld/my-config.json");
		self::println("");
		self::println("--list-daemons\t\tOutput the services that are going to be configured using a given config file. No services will be configured.");
		self::println("\t\t\tExample: --apply=/path/to/my-config.json --list-daemons");
		self::println("");
		self::println("--daemon\t\tWhen running --apply you can specify a daemon. This will be the only service that gets configured");
		self::println("\t\t\tExample: --apply=/path/to/my-config.json --daemon=apache24");
		self::println("");
		self::println("--import-settings\tImport settings from another froxlor installation. This should be done prior to running --apply or alternatively in the same command together.");
		self::println("\t\t\tExample: --import-settings=/path/to/Froxlor_settings-[version]-[dbversion]-[date].json or --import-settings=http://domain.tld/Froxlor_settings-[version]-[dbversion]-[date].json");
		self::println("");
		self::println("--froxlor-dir\t\tpath to froxlor installation");
		self::println("\t\t\tExample: --froxlor-dir=/var/www/froxlor/");
		self::println("");
		self::println("--help\t\t\tshow help screen (this)");
		self::println("");
		// switches
		// self::println("-d\t\t\tenable debug output");
		self::println("-h\t\t\tsame as --help");
		self::println("");
		
		die(); // end of execution
	}
}

class Action
{

	private $_args = null;

	private $_name = null;

	private $_db = null;

	public function __construct($args)
	{
		$this->_args = $args;
		$this->_validate();
	}

	public function getActionName()
	{
		return $this->_name;
	}

	/**
	 * validates the parsed command line parameters
	 *
	 * @throws Exception
	 */
	private function _validate()
	{
		$this->_checkConfigParam(true);
		$this->_parseConfig();
		
		require FROXLOR_INSTALL_DIR . '/lib/tables.inc.php';
		require FROXLOR_INSTALL_DIR . '/lib/functions.php';
		require FROXLOR_INSTALL_DIR . '/lib/classes/settings/class.Settings.php';
		require FROXLOR_INSTALL_DIR . '/lib/classes/settings/class.SImExporter.php';
		require FROXLOR_INSTALL_DIR . '/lib/classes/config/class.ConfigParser.php';
		require FROXLOR_INSTALL_DIR . '/lib/classes/config/class.ConfigService.php';
		require FROXLOR_INSTALL_DIR . '/lib/classes/config/class.ConfigDaemon.php';
		
		if (array_key_exists("import-settings", $this->_args)) {
			$this->_importSettings();
		}
		
		if (array_key_exists("create", $this->_args)) {
			$this->_createConfig();
		} elseif (array_key_exists("apply", $this->_args)) {
			$this->_applyConfig();
		} elseif (array_key_exists("list-daemons", $this->_args) || array_key_exists("daemon", $this->_args)) {
			CmdLineHandler::printwarn("--list-daemons and --daemon only work together with --apply");
		}
	}

	private function _importSettings()
	{
		if (strtoupper(substr($this->_args["import-settings"], 0, 4)) == 'HTTP') {
			echo "Settings file seems to be an URL, trying to download" . PHP_EOL;
			$target = "/tmp/froxlor-import-settings-" . time() . ".json";
			if (@file_exists($target)) {
				@unlink($target);
			}
			$this->downloadFile($this->_args["import-settings"], $target);
			$this->_args["import-settings"] = $target;
		}
		if (! is_file($this->_args["import-settings"])) {
			throw new Exception("Given settings file is not a file");
		} elseif (! file_exists($this->_args["import-settings"])) {
			throw new Exception("Given settings file cannot be found ('" . $this->_args["import-settings"] . "')");
		} elseif (! is_readable($this->_args["import-settings"])) {
			throw new Exception("Given settings file cannot be read ('" . $this->_args["import-settings"] . "')");
		}
		$imp_content = file_get_contents($this->_args["import-settings"]);
		SImExporter::import($imp_content);
		CmdLineHandler::printsucc("Successfully imported settings from '" . $this->_args["import-settings"] . "'");
	}

	private function _createConfig()
	{
		$_daemons_config = array(
			'distro' => ""
		);
		
		$config_dir = FROXLOR_INSTALL_DIR . '/lib/configfiles/';
		// show list of available distro's
		$distros = glob($config_dir . '*.xml');
		// tmp array
		$distributions_select_data = array();
		// read in all the distros
		foreach ($distros as $_distribution) {
			// get configparser object
			$dist = new ConfigParser($_distribution);
			// get distro-info
			$dist_display = $this->getCompleteDistroName($dist);
			// store in tmp array
			$distributions_select_data[$dist_display] = str_replace(".xml", "", strtolower(basename($_distribution)));
		}
		
		// sort by distribution name
		ksort($distributions_select_data);
		
		// list all distributions
		$mask = "|%-50.50s |%-50.50s |\n";
		printf($mask, str_repeat("-", 50), str_repeat("-", 50));
		printf($mask, 'dist', 'name');
		printf($mask, str_repeat("-", 50), str_repeat("-", 50));
		foreach ($distributions_select_data as $name => $filename) {
			printf($mask, $filename, $name);
		}
		printf($mask, str_repeat("-", 50), str_repeat("-", 50));
		echo PHP_EOL;
		
		while (! in_array($_daemons_config['distro'], $distributions_select_data)) {
			$_daemons_config['distro'] = CmdLineHandler::getInput("choose distribution", "stretch");
		}
		
		// go through all services and let user check whether to include it or not
		$configfiles = new ConfigParser($config_dir . '/' . $_daemons_config['distro'] . ".xml");
		$services = $configfiles->getServices();
		
		foreach ($services as $si => $service) {
			echo PHP_EOL . "--- " . strtoupper($si) . " ---" . PHP_EOL . PHP_EOL;
			$_daemons_config[$si] = "";
			
			$daemons = $service->getDaemons();
			$mask = "|%-50.50s |%-50.50s |\n";
			printf($mask, str_repeat("-", 50), str_repeat("-", 50));
			printf($mask, 'value', 'name');
			printf($mask, str_repeat("-", 50), str_repeat("-", 50));
			$default_daemon = "";
			foreach ($daemons as $di => $dd) {
				$title = $dd->title;
				if ($dd->default) {
					$default_daemon = $di;
					$title = $title . " (default)";
				}
				printf($mask, $di, $title);
			}
			printf($mask, "x", "No " . $si);
			$daemons['x'] = 'x';
			printf($mask, str_repeat("-", 50), str_repeat("-", 50));
			echo PHP_EOL;
			if ($si == 'system') {
				$_daemons_config[$si] = array();
				// for the system/other services we need a multiple choice possibility
				CmdLineHandler::println("Select every service you need. Enter empty value when done");
				$sysservice = "";
				do {
					$sysservice = CmdLineHandler::getInput("choose service");
					if (! empty($sysservice)) {
						$_daemons_config[$si][] = $sysservice;
					}
				} while (! empty($sysservice));
			} else {
				// for all others -> only one value
				while (! array_key_exists($_daemons_config[$si], $daemons)) {
					$_daemons_config[$si] = CmdLineHandler::getInput("choose service", $default_daemon);
				}
			}
		}
		
		echo PHP_EOL . PHP_EOL;
		$daemons_config = json_encode($_daemons_config);
		$output = CmdLineHandler::getInput("choose output-filename", "/tmp/froxlor-config-" . date('Ymd') . ".json");
		file_put_contents($output, $daemons_config);
		CmdLineHandler::printsucc("Successfully generated service-configfile '" . $output . "'");
	}

	private function getCompleteDistroName($cparser)
	{
		// get distro-info
		$dist_display = $cparser->distributionName;
		if ($cparser->distributionCodename != '') {
			$dist_display .= " " . $cparser->distributionCodename;
		}
		if ($cparser->distributionVersion != '') {
			$dist_display .= " (" . $cparser->distributionVersion . ")";
		}
		if ($cparser->deprecated) {
			$dist_display .= " [deprecated]";
		}
		return $dist_display;
	}

	private function _applyConfig()
	{
		if (strtoupper(substr($this->_args["apply"], 0, 4)) == 'HTTP') {
			echo "Config file seems to be an URL, trying to download" . PHP_EOL;
			$target = "/tmp/froxlor-config-" . time() . ".json";
			if (@file_exists($target)) {
				@unlink($target);
			}
			$this->downloadFile($this->_args["apply"], $target);
			$this->_args["apply"] = $target;
		}
		if (! is_file($this->_args["apply"])) {
			throw new Exception("Given config file is not a file");
		} elseif (! file_exists($this->_args["apply"])) {
			throw new Exception("Given config file cannot be found ('" . $this->_args["apply"] . "')");
		} elseif (! is_readable($this->_args["apply"])) {
			throw new Exception("Given config file cannot be read ('" . $this->_args["apply"] . "')");
		}
		
		$config = file_get_contents($this->_args["apply"]);
		$decoded_config = json_decode($config, true);
		
		if (array_key_exists("list-daemons", $this->_args)) {
			$mask = "|%-50.50s |%-50.50s |\n";
			printf($mask, str_repeat("-", 50), str_repeat("-", 50));
			printf($mask, 'service', 'daemon');
			printf($mask, str_repeat("-", 50), str_repeat("-", 50));
			foreach ($decoded_config as $service => $daemon) {
				if (is_array($daemon) && count($daemon) > 0) {
					foreach ($daemon as $sysdaemon) {
						printf($mask, $service, $sysdaemon);
					}
				} else {
					if ($daemon == 'x') {
						$daemon = '--- skipped ---';
					}
					printf($mask, $service, $daemon);
				}
			}
			printf($mask, str_repeat("-", 50), str_repeat("-", 50));
			echo PHP_EOL;
			exit();
		}
		
		$only_daemon = null;
		if (array_key_exists("daemon", $this->_args)) {
			$only_daemon = $this->_args['daemon'];
		}
		
		if (! empty($decoded_config)) {
			$config_dir = FROXLOR_INSTALL_DIR . '/lib/configfiles/';
			$configfiles = new ConfigParser($config_dir . '/' . $decoded_config['distro'] . ".xml");
			$services = $configfiles->getServices();
			$replace_arr = $this->_getReplacerArray();
			
			foreach ($services as $si => $service) {
				echo PHP_EOL . "--- Configuring: " . strtoupper($si) . " ---" . PHP_EOL . PHP_EOL;
				if (! isset($decoded_config[$si]) || $decoded_config[$si] == 'x') {
					CmdLineHandler::printwarn("Skipping " . strtoupper($si) . " configuration as desired");
					continue;
				}
				$daemons = $service->getDaemons();
				foreach ($daemons as $di => $dd) {
					// check for desired service
					if (($si != 'system' && $decoded_config[$si] != $di) || (is_array($decoded_config[$si]) && ! in_array($di, $decoded_config[$si]))) {
						continue;
					}
					CmdLineHandler::println("Configuring '" . $di . "'");
					
					if (! empty($only_daemon) && $only_daemon != $di) {
						CmdLineHandler::printwarn("Skipping " . $di . " configuration as desired");
						continue;
					}
					// run all cmds
					$confarr = $dd->getConfig();
					foreach ($confarr as $idx => $action) {
						switch ($action['type']) {
							case "install":
								CmdLineHandler::println("Installing required packages");
								passthru(strtr($action['content'], $replace_arr), $result);
								if (strlen($result) > 1) {
									echo $result;
								}
								break;
							case "command":
								exec(strtr($action['content'], $replace_arr));
								break;
							case "file":
								if (array_key_exists('content', $action)) {
									CmdLineHandler::printwarn("Creating file '" . $action['name'] . "'");
									file_put_contents($action['name'], trim(strtr($action['content'], $replace_arr)));
								} elseif (array_key_exists('subcommands', $action)) {
									foreach ($action['subcommands'] as $fileaction) {
										if (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "pre") {
											exec(strtr($fileaction['content'], $replace_arr));
										} elseif (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "post") {
											exec(strtr($fileaction['content'], $replace_arr));
										} elseif ($fileaction['type'] == 'file') {
											CmdLineHandler::printwarn("Creating file '" . $fileaction['name'] . "'");
											file_put_contents($fileaction['name'], trim(strtr($fileaction['content'], $replace_arr)));
										}
									}
								}
								break;
						}
					}
				}
			}
			// run cronjob at the end to ensure configs are all up to date
			exec('php ' . FROXLOR_INSTALL_DIR . '/scripts/froxlor_master_cronjob.php --force');
			// and done
			CmdLineHandler::printsucc("All services have been configured");
		} else {
			CmdLineHandler::printerr("Unable to decode given JSON file");
		}
	}

	private function _getReplacerArray()
	{
		$customer_tmpdir = '/tmp/';
		if (Settings::Get('system.mod_fcgid') == '1' && Settings::Get('system.mod_fcgid_tmpdir') != '') {
			$customer_tmpdir = Settings::Get('system.mod_fcgid_tmpdir');
		} elseif (Settings::Get('phpfpm.enabled') == '1' && Settings::Get('phpfpm.tmpdir') != '') {
			$customer_tmpdir = Settings::Get('phpfpm.tmpdir');
		}
		
		// try to convert namserver hosts to ip's
		$ns_ips = "";
		if (Settings::Get('system.nameservers') != '') {
			$nameservers = explode(',', Settings::Get('system.nameservers'));
			foreach ($nameservers as $nameserver) {
				$nameserver = trim($nameserver);
				$nameserver_ips = gethostbynamel6($nameserver);
				if (is_array($nameserver_ips) && count($nameserver_ips) > 0) {
					$ns_ips .= implode(",", $nameserver_ips);
				}
			}
		}
		
		Database::needSqlData();
		$sql = Database::getSqlData();
		
		$replace_arr = array(
			'<SQL_UNPRIVILEGED_USER>' => $sql['user'],
			'<SQL_UNPRIVILEGED_PASSWORD>' => $sql['passwd'],
			'<SQL_DB>' => $sql['db'],
			'<SQL_HOST>' => $sql['host'],
			'<SQL_SOCKET>' => isset($sql['socket']) ? $sql['socket'] : null,
			'<SERVERNAME>' => Settings::Get('system.hostname'),
			'<SERVERIP>' => Settings::Get('system.ipaddress'),
			'<NAMESERVERS>' => Settings::Get('system.nameservers'),
			'<NAMESERVERS_IP>' => $ns_ips,
			'<AXFRSERVERS>' => Settings::Get('system.axfrservers'),
			'<VIRTUAL_MAILBOX_BASE>' => Settings::Get('system.vmail_homedir'),
			'<VIRTUAL_UID_MAPS>' => Settings::Get('system.vmail_uid'),
			'<VIRTUAL_GID_MAPS>' => Settings::Get('system.vmail_gid'),
			'<SSLPROTOCOLS>' => (Settings::Get('system.use_ssl') == '1') ? 'imaps pop3s' : '',
			'<CUSTOMER_TMP>' => makeCorrectDir($customer_tmpdir),
			'<BASE_PATH>' => makeCorrectDir(FROXLOR_INSTALL_DIR),
			'<BIND_CONFIG_PATH>' => makeCorrectDir(Settings::Get('system.bindconf_directory')),
			'<WEBSERVER_RELOAD_CMD>' => Settings::Get('system.apachereload_command'),
			'<CUSTOMER_LOGS>' => makeCorrectDir(Settings::Get('system.logfiles_directory')),
			'<FPM_IPCDIR>' => makeCorrectDir(Settings::Get('phpfpm.fastcgi_ipcdir')),
			'<WEBSERVER_GROUP>' => Settings::Get('system.httpgroup')
		);
		return $replace_arr;
	}

	private function _parseConfig()
	{
		define('FROXLOR_INSTALL_DIR', $this->_args['froxlor-dir']);
		if (! file_exists(FROXLOR_INSTALL_DIR . '/lib/classes/database/class.Database.php')) {
			throw new Exception("Could not find froxlor's Database class. Is froxlor really installed to '" . FROXLOR_INSTALL_DIR . "'?");
		}
		if (! file_exists(FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php')) {
			throw new Exception("Could not find froxlor's userdata.inc.php file. You should use this script only with a fully installed and setup froxlor system.");
		}
		require FROXLOR_INSTALL_DIR . '/lib/classes/database/class.Database.php';
	}

	private function _checkConfigParam($needed = false)
	{
		if ($needed) {
			if (! isset($this->_args["froxlor-dir"])) {
				throw new Exception("No configuration given (missing --froxlor-dir parameter?)");
			} elseif (! is_dir($this->_args["froxlor-dir"])) {
				throw new Exception("Given --froxlor-dir parameter is not a directory");
			} elseif (! file_exists($this->_args["froxlor-dir"])) {
				throw new Exception("Given froxlor directory cannot be found ('" . $this->_args["froxlor-dir"] . "')");
			} elseif (! is_readable($this->_args["froxlor-dir"])) {
				throw new Exception("Given froxlor direcotry cannot be read ('" . $this->_args["froxlor-dir"] . "')");
			}
		}
	}

	private function downloadFile($src, $dest)
	{
		set_time_limit(0);
		// This is the file where we save the information
		$fp = fopen($dest, 'w+');
		// Here is the file we are downloading, replace spaces with %20
		$ch = curl_init(str_replace(" ", "%20", $src));
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// write curl response to file
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// get curl response
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}
}

// give control to command line handler
try {
	ConfigServicesCmd::processParameters($argc, $argv);
} catch (Exception $e) {
	ConfigServicesCmd::printerr($e->getMessage());
}
