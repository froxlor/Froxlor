<?php
namespace Froxlor\Cli\Action;

use Froxlor\Database\Database;
use Froxlor\SImExporter;
use Froxlor\Settings;
use Froxlor\Cli\ConfigServicesCmd;

class ConfigServicesAction extends \Froxlor\Cli\Action
{

	public function __construct($args)
	{
		parent::__construct($args);
	}

	public function run()
	{
		$this->validate();
	}

	/**
	 * validates the parsed command line parameters
	 *
	 * @throws \Exception
	 */
	private function validate()
	{
		global $lng;

		$this->checkConfigParam(true);
		$this->parseConfig();

		require FROXLOR_INSTALL_DIR . '/lib/tables.inc.php';

		include_once FROXLOR_INSTALL_DIR . '/lng/english.lng.php';
		include_once FROXLOR_INSTALL_DIR . '/lng/lng_references.php';

		if (array_key_exists("import-settings", $this->_args)) {
			$this->importSettings();
		}

		if (array_key_exists("create", $this->_args)) {
			$this->createConfig();
		} elseif (array_key_exists("apply", $this->_args)) {
			$this->applyConfig();
		} elseif (array_key_exists("list-daemons", $this->_args) || array_key_exists("daemon", $this->_args)) {
			ConfigServicesCmd::printwarn("--list-daemons and --daemon only work together with --apply");
		}
	}

	private function importSettings()
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
			throw new \Exception("Given settings file is not a file");
		} elseif (! file_exists($this->_args["import-settings"])) {
			throw new \Exception("Given settings file cannot be found ('" . $this->_args["import-settings"] . "')");
		} elseif (! is_readable($this->_args["import-settings"])) {
			throw new \Exception("Given settings file cannot be read ('" . $this->_args["import-settings"] . "')");
		}
		$imp_content = file_get_contents($this->_args["import-settings"]);
		SImExporter::import($imp_content);
		ConfigServicesCmd::printsucc("Successfully imported settings from '" . $this->_args["import-settings"] . "'");
	}

	private function createConfig()
	{
		$_daemons_config = array(
			'distro' => ""
		);

		$config_dir = FROXLOR_INSTALL_DIR . '/lib/configfiles/';
		// show list of available distro's
		$distros = glob($config_dir . '*.xml');
		// tmp array
		$distributions_select_data = array();

		//set default os.
		$os_dist = array('ID' => 'buster');
		$os_version = array('0' => '10');
		$os_default = $os_dist['ID'];

		//read os-release
		if(file_exists('/etc/os-release')) {
			$os_dist = parse_ini_file('/etc/os-release', false);
			if(is_array($os_dist) && array_key_exists('ID', $os_dist) && array_key_exists('VERSION_ID', $os_dist)) {
				$os_version = explode('.',$os_dist['VERSION_ID'])[0];
			}
		}

		// read in all the distros
		foreach ($distros as $_distribution) {
			// get configparser object
			$dist = new \Froxlor\Config\ConfigParser($_distribution);
			// get distro-info
			$dist_display = $this->getCompleteDistroName($dist);
			// store in tmp array
			$distributions_select_data[$dist_display] = str_replace(".xml", "", strtolower(basename($_distribution)));
			
			//guess if this is the current distro.
			$ver = explode('.', $dist->distributionVersion)[0];
			if (strtolower($os_dist['ID']) == strtolower($dist->distributionName) && $os_version == $ver) {
				$os_default = str_replace(".xml", "", strtolower(basename($_distribution)));
			}
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
			$_daemons_config['distro'] = ConfigServicesCmd::getInput("choose distribution", $os_default);
		}

		// go through all services and let user check whether to include it or not
		$configfiles = new \Froxlor\Config\ConfigParser($config_dir . '/' . $_daemons_config['distro'] . ".xml");
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
				ConfigServicesCmd::println("Select every service you need. Enter empty value when done");
				$sysservice = "";
				do {
					$sysservice = ConfigServicesCmd::getInput("choose service");
					if (! empty($sysservice)) {
						$_daemons_config[$si][] = $sysservice;
					}
				} while (! empty($sysservice));
				// add 'cron' as fixed part (doesn't hurt if it exists)
				if (! in_array('cron', $_daemons_config[$si])) {
					$_daemons_config[$si][] = 'cron';
				}
			} else {
				// for all others -> only one value
				while (! array_key_exists($_daemons_config[$si], $daemons)) {
					$_daemons_config[$si] = ConfigServicesCmd::getInput("choose service", $default_daemon);
				}
			}
		}

		echo PHP_EOL . PHP_EOL;
		$daemons_config = json_encode($_daemons_config);
		$output = ConfigServicesCmd::getInput("choose output-filename", "/tmp/froxlor-config-" . date('Ymd') . ".json");
		file_put_contents($output, $daemons_config);
		ConfigServicesCmd::printsucc("Successfully generated service-configfile '" . $output . "'");
		echo PHP_EOL;
		ConfigServicesCmd::printsucc("You can now apply this config running:" . PHP_EOL . "php " . FROXLOR_INSTALL_DIR . "install/scripts/config-services.php --apply=" . $output);
		echo PHP_EOL;
		$proceed = ConfigServicesCmd::getYesNo("Do you want to apply the config now? [y/N]", 0);
		if ($proceed) {
			passthru("php " . FROXLOR_INSTALL_DIR . "install/scripts/config-services.php --apply=" . $output);
		}
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

	private function applyConfig()
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
			throw new \Exception("Given config file is not a file");
		} elseif (! file_exists($this->_args["apply"])) {
			throw new \Exception("Given config file cannot be found ('" . $this->_args["apply"] . "')");
		} elseif (! is_readable($this->_args["apply"])) {
			throw new \Exception("Given config file cannot be read ('" . $this->_args["apply"] . "')");
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
			$configfiles = new \Froxlor\Config\ConfigParser($config_dir . '/' . $decoded_config['distro'] . ".xml");
			$services = $configfiles->getServices();
			$replace_arr = $this->getReplacerArray();

			foreach ($services as $si => $service) {
				echo PHP_EOL . "--- Configuring: " . strtoupper($si) . " ---" . PHP_EOL . PHP_EOL;
				if (! isset($decoded_config[$si]) || $decoded_config[$si] == 'x') {
					ConfigServicesCmd::printwarn("Skipping " . strtoupper($si) . " configuration as desired");
					continue;
				}
				$daemons = $service->getDaemons();
				foreach ($daemons as $di => $dd) {
					// check for desired service
					if (($si != 'system' && $decoded_config[$si] != $di) || (is_array($decoded_config[$si]) && ! in_array($di, $decoded_config[$si]))) {
						continue;
					}
					ConfigServicesCmd::println("Configuring '" . $di . "'");

					if (! empty($only_daemon) && $only_daemon != $di) {
						ConfigServicesCmd::printwarn("Skipping " . $di . " configuration as desired");
						continue;
					}
					// run all cmds
					$confarr = $dd->getConfig();
					foreach ($confarr as $action) {
						switch ($action['type']) {
							case "install":
								ConfigServicesCmd::println("Installing required packages");
								$result = null;
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
									ConfigServicesCmd::printwarn("Creating file '" . $action['name'] . "'");
									file_put_contents($action['name'], trim(strtr($action['content'], $replace_arr)));
								} elseif (array_key_exists('subcommands', $action)) {
									foreach ($action['subcommands'] as $fileaction) {
										if (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "pre") {
											exec(strtr($fileaction['content'], $replace_arr));
										} elseif (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "post") {
											exec(strtr($fileaction['content'], $replace_arr));
										} elseif ($fileaction['type'] == 'file') {
											ConfigServicesCmd::printwarn("Creating file '" . $fileaction['name'] . "'");
											file_put_contents($fileaction['name'], trim(strtr($fileaction['content'], $replace_arr)));
										}
									}
								}
								break;
						}
					}
				}
			}
			// set is_configured flag
			Settings::Set('panel.is_configured', '1', true);
			// run cronjob at the end to ensure configs are all up to date
			exec('php ' . FROXLOR_INSTALL_DIR . '/scripts/froxlor_master_cronjob.php --force');
			// and done
			ConfigServicesCmd::printsucc("All services have been configured");
		} else {
			ConfigServicesCmd::printerr("Unable to decode given JSON file");
		}
	}

	private function getReplacerArray()
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
				$nameserver_ips = \Froxlor\PhpHelper::gethostbynamel6($nameserver);
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
			'<CUSTOMER_TMP>' => \Froxlor\FileDir::makeCorrectDir($customer_tmpdir),
			'<BASE_PATH>' => \Froxlor\FileDir::makeCorrectDir(FROXLOR_INSTALL_DIR),
			'<BIND_CONFIG_PATH>' => \Froxlor\FileDir::makeCorrectDir(Settings::Get('system.bindconf_directory')),
			'<WEBSERVER_RELOAD_CMD>' => Settings::Get('system.apachereload_command'),
			'<CUSTOMER_LOGS>' => \Froxlor\FileDir::makeCorrectDir(Settings::Get('system.logfiles_directory')),
			'<FPM_IPCDIR>' => \Froxlor\FileDir::makeCorrectDir(Settings::Get('phpfpm.fastcgi_ipcdir')),
			'<WEBSERVER_GROUP>' => Settings::Get('system.httpgroup')
		);
		return $replace_arr;
	}

	private function parseConfig()
	{
		define('FROXLOR_INSTALL_DIR', $this->_args['froxlor-dir']);
		if (! class_exists('\\Froxlor\\Database\\Database')) {
			throw new \Exception("Could not find froxlor's Database class. Is froxlor really installed to '" . FROXLOR_INSTALL_DIR . "'?");
		}
		if (! file_exists(FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php')) {
			throw new \Exception("Could not find froxlor's userdata.inc.php file. You should use this script only with a fully installed and setup froxlor system.");
		}
	}

	private function checkConfigParam($needed = false)
	{
		if ($needed) {
			if (! isset($this->_args["froxlor-dir"])) {
				$this->_args["froxlor-dir"] = \Froxlor\Froxlor::getInstallDir();
			} elseif (! is_dir($this->_args["froxlor-dir"])) {
				throw new \Exception("Given --froxlor-dir parameter is not a directory");
			} elseif (! file_exists($this->_args["froxlor-dir"])) {
				throw new \Exception("Given froxlor directory cannot be found ('" . $this->_args["froxlor-dir"] . "')");
			} elseif (! is_readable($this->_args["froxlor-dir"])) {
				throw new \Exception("Given froxlor direcotry cannot be read ('" . $this->_args["froxlor-dir"] . "')");
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
