<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

use Froxlor\Froxlor;
use Froxlor\FileDir;
use Froxlor\Config\ConfigParser;
use Froxlor\UI\Panel\UI;

/**
 * Class FroxlorInstall
 *
 * Setup froxlor's database and populate with data from install process
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 https://files.froxlor.org/misc/COPYING.txt
 * @package Install
 *
 */
class FroxlorInstall
{

	/**
	 * define froxlor basepath e.g.
	 * /var/www/froxlor
	 *
	 * @var string
	 */
	private $_basepath = null;

	/**
	 * language array
	 *
	 * @var array
	 */
	private $_lng = null;

	/**
	 * install data
	 *
	 * @var array
	 */
	private $_data = null;

	/**
	 * supported languages for install
	 */
	private $_languages = array(
		'german' => 'Deutsch',
		'english' => 'English',
		'french' => 'Français'
	);

	/**
	 * currently used language
	 *
	 * @var string
	 */
	private $_activelng = 'english';

	/**
	 * check whether to abort due to errors
	 *
	 * @var bool
	 */
	private $_abort = false;

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_basepath = dirname(__FILE__, 3);
		$this->_data = array();
	}

	/**
	 * FC
	 */
	public function run()
	{
		// check if we have a valid installation already
		$this->_checkUserdataFile();
		// include the MySQL-Table-Definitions
		require_once $this->_basepath . '/lib/tables.inc.php';
		// include language
		$this->_includeLanguageFile();
		// show the action
		$this->_showPage();
	}

	/**
	 * build up and show the install-process-pages
	 */
	private function _showPage()
	{
		// check install-state
		if ((isset($_POST['installstep']) && $_POST['installstep'] == '1') || (isset($_GET['check']) && $_GET['check'] == '1')) {
			$pagetitle = $this->_lng['install']['title'];
			$check_result = null;
			if (!empty($_POST) && $this->_checkPostData($check_result)) {
				// check data and create userdata etc.etc.etc.
				$result = $this->_doInstall();
			} elseif (isset($_GET['check']) && $_GET['check'] == '1') {
				// gather data
				$result = $this->_showDataForm($check_result);
			} else {
				// this should not happen
				$result = array(
					'pagecontent' => "How did you manage to get here? Well, you shouldn't be here. Go back!",
					'pagenavigation' => ''
				);
			}
		} else {
			// check for system-requirements first
			$pagetitle = $this->_lng['requirements']['title'];
			$result = $this->_requirementCheck();
		}
		// output everything
		$pagecontent = $result['pagecontent'];
		$pagenavigation = $result['pagenavigation'];

		UI::twigBuffer('/install/index.html.twig', [
			'pagetitle' => $pagetitle,
			'pagecontent' => $pagecontent,
			'pagenavigation' => $pagenavigation
		]);
	}

	/**
	 * gather data from $_POST if set; return true if all is set,
	 * false otherwise
	 *
	 * @return boolean
	 */
	private function _checkPostData(&$check_result)
	{
		$this->_guessServerName();
		$this->_guessServerIP();
		$this->_guessWebserver();
		$this->_guessDistribution();

		$this->_getPostField('use_ssl', 1);
		$this->_getPostField('mysql_host', '127.0.0.1');
		$this->_getPostField('mysql_database', 'froxlor');
		$this->_getPostField('mysql_forcecreate', '0');
		$this->_getPostField('mysql_unpriv_user', 'froxlor');
		$this->_getPostField('mysql_unpriv_pass');
		$this->_getPostField('mysql_root_user', 'root');
		$this->_getPostField('mysql_root_pass');
		$this->_getPostField('mysql_ssl_ca_file');
		$this->_getPostField('mysql_ssl_verify_server_certificate', 0);
		$this->_getPostField('admin_user', 'admin');
		$this->_getPostField('admin_pass1');
		$this->_getPostField('admin_pass2');
		$this->_getPostField('activate_newsfeed', 1);
		$posixusername = posix_getpwuid(posix_getuid());
		$this->_getPostField('httpuser', $posixusername['name']);
		$posixgroup = posix_getgrgid(posix_getgid());
		$this->_getPostField('httpgroup', $posixgroup['name']);

		if ($this->_data['mysql_host'] == 'localhost' || $this->_data['mysql_host'] == '127.0.0.1') {
			$this->_data['mysql_access_host'] = $this->_data['mysql_host'];
		} else {
			$this->_data['mysql_access_host'] = $this->_data['serverip'];
		}

		// check system-hostname to be a FQDN
		if ($this->_validate_ip($this->_data['servername']) !== false) {
			$check_result[] = "Invalid hostname";
			$this->_data['servername'] = '';
		}

		if (empty($this->_data['serverip']) || $this->_validate_ip($this->_data['serverip']) == false) {
			$check_result[] = "Invalid IP address";
		}

		$nonempty = [
			'admin_pass1' => 'admin-user password',
			'mysql_unpriv_pass' => 'unprivileged mysql-user password',
			'mysql_root_pass' => 'mysql root-user password',
			'servername' => 'servername',
			'serverip' => 'server IP address',
			'httpuser' => 'webserver user',
			'httpgroup' => 'webserver group'
		];
		foreach ($nonempty as $necheck => $msg) {
			if ($this->_data[$necheck] == '') {
				$check_result[] = $msg . " cannot be empty";
			}
		}

		if ($this->_data['admin_pass1'] != $this->_data['admin_pass2']) {
			$check_result[] = "admin-user passwords do not match";
		}

		if ($this->_data['mysql_unpriv_user'] == $this->_data['mysql_root_user']) {
			$check_result[] = "unprivileged mysql-user and mysql root-user must not be the same";
		}

		if (isset($_POST['installstep']) && $_POST['installstep'] == '1' && $this->_data['admin_pass1'] == $this->_data['admin_pass2'] && $this->_data['admin_pass1'] != '' && $this->_data['admin_pass2'] != '' && $this->_data['mysql_unpriv_pass'] != '' && $this->_data['mysql_root_pass'] != '' && $this->_data['servername'] != '' && $this->_data['serverip'] != '' && $this->_data['httpuser'] != '' && $this->_data['httpgroup'] != '' && $this->_data['mysql_unpriv_user'] != $this->_data['mysql_root_user']) {
			return true;
		}
		return false;
	}

	/**
	 * no missing fields or data -> perform actual install
	 *
	 * @return array
	 */
	private function _doInstall()
	{
		// check results
		$content = [];

		// check for mysql-root-connection
		$check = [
			'title' => $this->_lng['install']['testing_mysql'],
			'result' => 0
		];

		$options = array(
			'PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET names utf8'
		);

		if (!empty($this->_data['mysql_ssl_ca_file'])) {
			$options[\PDO::MYSQL_ATTR_SSL_CA] = $this->_data['mysql_ssl_ca_file'];
			$options[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = (bool) $this->_data['mysql_ssl_verify_server_certificate'];
		}

		$dsn = "mysql:host=" . $this->_data['mysql_host'] . ";";
		$fatal_fail = false;
		try {
			$db_root = new PDO($dsn, $this->_data['mysql_root_user'], $this->_data['mysql_root_pass'], $options);
		} catch (PDOException $e) {
			// possibly without passwd?
			try {
				$db_root = new PDO($dsn, $this->_data['mysql_root_user'], '', $options);
				// set the given password
				$passwd_stmt = $db_root->prepare("
					SET PASSWORD = PASSWORD(:passwd)
				");
				$passwd_stmt->execute(array(
					'passwd' => $this->_data['mysql_root_pass']
				));
			} catch (PDOException $e) {
				// nope
				$check['result'] = 1;
				$check['result_txt'] = $this->_lng['install']['failed'];
				$check['result_desc'] = $e->getMessage();
				$fatal_fail = true;
				$content[] = $check;
			}
		}

		if (!$fatal_fail) {
			$version_server = $db_root->getAttribute(PDO::ATTR_SERVER_VERSION);
			$sql_mode = 'NO_ENGINE_SUBSTITUTION';
			if (version_compare($version_server, '8.0.11', '<')) {
				$sql_mode .= ',NO_AUTO_CREATE_USER';
			}
			$db_root->exec('SET sql_mode = "' . $sql_mode . '"');

			// ok, if we are here, the database connection is up and running
			$check['result_txt'] = "OK";
			$content[] = $check;

			// check for existing db and create backup if so
			$this->_backupExistingDatabase($db_root, $content);
			if (!$this->_abort) {
				// create unprivileged user and the database itself
				$this->_createDatabaseAndUser($db_root, $content);
				// importing data to new database
				$this->_importDatabaseData($content);
			}
			if (!$this->_abort) {
				// create DB object for new database
				$options = array(
					'PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET names utf8'
				);

				if (!empty($this->_data['mysql_ssl_ca_file'])) {
					$options[\PDO::MYSQL_ATTR_SSL_CA] = $this->_data['mysql_ssl_ca_file'];
					$options[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = (bool) $this->_data['mysql_ssl_verify_server_certificate'];
				}

				$dsn = "mysql:host=" . $this->_data['mysql_host'] . ";dbname=" . $this->_data['mysql_database'] . ";";
				$another_fail = false;
				try {
					$db = new PDO($dsn, $this->_data['mysql_unpriv_user'], $this->_data['mysql_unpriv_pass'], $options);
					$version_server = $db->getAttribute(PDO::ATTR_SERVER_VERSION);
					$sql_mode = 'NO_ENGINE_SUBSTITUTION';
					if (version_compare($version_server, '8.0.11', '<')) {
						$sql_mode .= ',NO_AUTO_CREATE_USER';
					}
					$db->exec('SET sql_mode = "' . $sql_mode . '"');
				} catch (PDOException $e) {
					// this should have happened in _importDatabaseData()
					$check = [
						'title' => 'Unexpected exception occured',
						'result' => 1,
						'result_txt' => '!!!',
						'result_desc' => $e->getMessage()
					];
					$content[] = $check;
					$another_fail = true;
				}

				if (!$another_fail) {
					// change settings accordingly
					$this->_doSettings($db, $content);
					// create entries
					$this->_doDataEntries($db, $content);
					$db = null;
					// create config-file
					$this->_createUserdataConf($content);
				}
			}
		}

		// check if we have unrecoverable errors
		if ($fatal_fail || isset($another_fail) && $another_fail || $this->_abort) {
			// D'oh
			$_die = true;
			$message = $this->_lng['install']['testing_mysql_fail'];
			$link = 'install.php?check=1';
			$linktext = $this->_lng['click_here_to_goback'];
		} else {
			// all good
			$_die = false;
			$message = $this->_lng['install']['froxlor_succ_installed'];
			$link = '../index.php';
			$linktext = $this->_lng['click_here_to_login'];
		}

		return array(
			'pagecontent' => [
				'installprocess' => $content
			],
			'pagenavigation' => [
				'bad' => $_die,
				'message' => $message,
				'link' => $link,
				'linktext' => $linktext
			]
		);
	}

	/**
	 * Create userdata.inc.php file
	 *
	 * @param array $content
	 *
	 * @return void
	 */
	private function _createUserdataConf(&$content)
	{
		$check = [
			'title' => $this->_lng['install']['creating_configfile'],
			'result' => 0
		];

		$userdata = "<?php\n";
		$userdata .= "// automatically generated userdata.inc.php for Froxlor\n";
		$userdata .= "\$sql['host']='" . addcslashes($this->_data['mysql_host'], "'\\") . "';\n";
		$userdata .= "\$sql['user']='" . addcslashes($this->_data['mysql_unpriv_user'], "'\\") . "';\n";
		$userdata .= "\$sql['password']='" . addcslashes($this->_data['mysql_unpriv_pass'], "'\\") . "';\n";
		$userdata .= "\$sql['db']='" . addcslashes($this->_data['mysql_database'], "'\\") . "';\n";
		$userdata .= "\$sql['ssl']['caFile']='" . addcslashes($this->_data['mysql_ssl_ca_file'], "'\\") . "';\n";
		$userdata .= "\$sql['ssl']['verifyServerCertificate']='" . addcslashes($this->_data['mysql_ssl_verify_server_certificate'], "'\\") . "';\n";
		$userdata .= "\$sql_root[0]['caption']='Default';\n";
		$userdata .= "\$sql_root[0]['host']='" . addcslashes($this->_data['mysql_host'], "'\\") . "';\n";
		$userdata .= "\$sql_root[0]['user']='" . addcslashes($this->_data['mysql_root_user'], "'\\") . "';\n";
		$userdata .= "\$sql_root[0]['password']='" . addcslashes($this->_data['mysql_root_pass'], "'\\") . "';\n";
		$userdata .= "\$sql_root[0]['ssl']['caFile']='" . addcslashes($this->_data['mysql_ssl_ca_file'], "'\\") . "';\n";
		$userdata .= "\$sql_root[0]['ssl']['verifyServerCertificate']='" . addcslashes($this->_data['mysql_ssl_verify_server_certificate'], "'\\") . "';\n";
		$userdata .= "// enable debugging to browser in case of SQL errors\n";
		$userdata .= "\$sql['debug'] = false;\n";
		$userdata .= "?>";

		// test if we can store the userdata.inc.php in ../lib
		$umask = @umask(077);
		$userdata_file = dirname(__FILE__, 3) . '/lib/userdata.inc.php';
		if (@touch($userdata_file) && @is_writable($userdata_file)) {
			$fp = @fopen($userdata_file, 'w');
			@fputs($fp, $userdata, strlen($userdata));
			@fclose($fp);
		} else {
			@unlink($userdata_file);
			// try creating it in a temporary file
			$temp_file = @tempnam(sys_get_temp_dir(), 'fx');
			if ($temp_file) {
				$fp = @fopen($temp_file, 'w');
				@fputs($fp, $userdata, strlen($userdata));
				@fclose($fp);
				$check['result'] = 2;
				$check['result_txt'] = sprintf($this->_lng['install']['creating_configfile_temp'], $temp_file);
			} else {
				$check['result'] = 1;
				$check['result_txt'] = $this->_lng['install']['creating_configfile_failed'];
				$check['result_desc'] = nl2br(htmlspecialchars($userdata));
			}
		}
		@umask($umask);

		$content[] = $check;
	}

	/**
	 * create corresponding entries in froxlor database
	 *
	 * @param object $db
	 * @param array $content
	 *
	 * @return void
	 */
	private function _doDataEntries(&$db, &$content)
	{
		$check = [
			'title' => $this->_lng['install']['creating_entries'],
			'result' => 0
		];

		// and lets insert the default ip and port
		$stmt = $db->prepare("
			INSERT INTO `" . TABLE_PANEL_IPSANDPORTS . "` SET
			`ip`= :serverip,
			`port` = :serverport,
			`namevirtualhost_statement` = :nvh,
			`vhostcontainer` = '1',
			`vhostcontainer_servername_statement` = '1'
		");
		$nvh = $this->_data['webserver'] == 'apache2' ? '1' : '0';
		$stmt->execute(array(
			'nvh' => $nvh,
			'serverip' => $this->_data['serverip'],
			'serverport' => 80
		));
		$defaultip = $db->lastInsertId();

		$defaultsslip = false;
		if ($this->_data['use_ssl']) {
			$stmt->execute(array(
				'nvh' => $this->_data['webserver'] == 'apache2' ? '1' : '0',
				'serverip' => $this->_data['serverip'],
				'serverport' => 443
			));
			$defaultsslip = $db->lastInsertId();
		}

		// insert the defaultip
		$upd_stmt = $db->prepare("
			UPDATE `" . TABLE_PANEL_SETTINGS . "` SET
			`value` = :defaultip
			WHERE `settinggroup` = 'system' AND `varname` = :defipfld
		");
		$upd_stmt->execute(array(
			'defaultip' => $defaultip,
			'defipfld' => 'defaultip'
		));

		if ($defaultsslip) {
			$upd_stmt->execute(array(
				'defaultip' => $defaultsslip,
				'defipfld' => 'defaultsslip'
			));
		}

		$content[] = $check;

		// last but not least create the main admin
		$check = [
			'title' => $this->_lng['install']['adding_admin_user'],
			'result' => 0
		];
		$ins_data = array(
			'loginname' => $this->_data['admin_user'],
			/* use system default crypt */
			'password' => password_hash($this->_data['admin_pass1'], PASSWORD_DEFAULT),
			'email' => 'admin@' . $this->_data['servername'],
			'deflang' => $this->_languages[$this->_activelng]
		);
		$ins_stmt = $db->prepare("
			INSERT INTO `" . TABLE_PANEL_ADMINS . "` SET
			`loginname` = :loginname,
			`password` = :password,
			`name` = 'Froxlor-Administrator',
			`email` = :email,
			`def_language` = :deflang,
			`api_allowed` = 1,
			`customers` = -1,
			`customers_see_all` = 1,
			`caneditphpsettings` = 1,
			`domains` = -1,
			`domains_see_all` = 1,
			`change_serversettings` = 1,
			`diskspace` = -1024,
			`mysqls` = -1,
			`emails` = -1,
			`email_accounts` = -1,
			`email_forwarders` = -1,
			`email_quota` = -1,
			`ftps` = -1,
			`subdomains` = -1,
			`traffic` = -1048576
		");

		$ins_stmt->execute($ins_data);

		$content[] = $check;
	}

	/**
	 * execute prepared statement to update settings
	 *
	 * @param PDOStatement $stmt
	 * @param string $group
	 * @param string $varname
	 * @param string $value
	 */
	private function _updateSetting(&$stmt = null, $value = null, $group = null, $varname = null)
	{
		$stmt->execute(array(
			'group' => $group,
			'varname' => $varname,
			'value' => $value
		));
	}

	/**
	 * change settings according to users input
	 *
	 * @param object $db
	 * @param array $content
	 *
	 * @return void
	 */
	private function _doSettings(&$db, &$content)
	{
		$check = [
			'title' => $this->_lng['install']['changing_data'],
			'result' => 0
		];

		$upd_stmt = $db->prepare("
			UPDATE `" . TABLE_PANEL_SETTINGS . "` SET
			`value` = :value
			WHERE `settinggroup` = :group AND `varname` = :varname
		");

		$this->_updateSetting($upd_stmt, 'admin@' . $this->_data['servername'], 'panel', 'adminmail');
		$this->_updateSetting($upd_stmt, $this->_data['serverip'], 'system', 'ipaddress');
		if ($this->_data['use_ssl']) {
			$this->_updateSetting($upd_stmt, 1, 'system', 'use_ssl');
		}
		$this->_updateSetting($upd_stmt, $this->_data['servername'], 'system', 'hostname');
		$this->_updateSetting($upd_stmt, $this->_languages[$this->_activelng], 'panel', 'standardlanguage');
		$this->_updateSetting($upd_stmt, $this->_data['mysql_access_host'], 'system', 'mysql_access_host');
		$this->_updateSetting($upd_stmt, $this->_data['webserver'], 'system', 'webserver');
		$this->_updateSetting($upd_stmt, $this->_data['httpuser'], 'system', 'httpuser');
		$this->_updateSetting($upd_stmt, $this->_data['httpgroup'], 'system', 'httpgroup');

		// necessary changes for webservers != apache2
		if ($this->_data['webserver'] == "apache24") {
			$this->_updateSetting($upd_stmt, 'apache2', 'system', 'webserver');
			$this->_updateSetting($upd_stmt, '1', 'system', 'apache24');
		} elseif ($this->_data['webserver'] == "lighttpd") {
			$this->_updateSetting($upd_stmt, '/etc/lighttpd/conf-enabled/', 'system', 'apacheconf_vhost');
			$this->_updateSetting($upd_stmt, '/etc/lighttpd/froxlor-diroptions/', 'system', 'apacheconf_diroptions');
			$this->_updateSetting($upd_stmt, '/etc/lighttpd/froxlor-htpasswd/', 'system', 'apacheconf_htpasswddir');
			$this->_updateSetting($upd_stmt, 'service lighttpd reload', 'system', 'apachereload_command');
			$this->_updateSetting($upd_stmt, '/etc/lighttpd/lighttpd.pem', 'system', 'ssl_cert_file');
			$this->_updateSetting($upd_stmt, '/var/run/lighttpd/', 'phpfpm', 'fastcgi_ipcdir');
		} elseif ($this->_data['webserver'] == "nginx") {
			$this->_updateSetting($upd_stmt, '/etc/nginx/sites-enabled/', 'system', 'apacheconf_vhost');
			$this->_updateSetting($upd_stmt, '/etc/nginx/sites-enabled/', 'system', 'apacheconf_diroptions');
			$this->_updateSetting($upd_stmt, '/etc/nginx/froxlor-htpasswd/', 'system', 'apacheconf_htpasswddir');
			$this->_updateSetting($upd_stmt, 'service nginx reload', 'system', 'apachereload_command');
			$this->_updateSetting($upd_stmt, '/etc/nginx/nginx.pem', 'system', 'ssl_cert_file');
			$this->_updateSetting($upd_stmt, '/var/run/', 'phpfpm', 'fastcgi_ipcdir');
			$this->_updateSetting($upd_stmt, 'error', 'system', 'errorlog_level');
		}

		$distros = glob(FileDir::makeCorrectDir(Froxlor::getInstallDir() . '/lib/configfiles/') . '*.xml');
		foreach ($distros as $_distribution) {
			if ($this->_data['distribution'] == str_replace(".xml", "", strtolower(basename($_distribution)))) {
				$dist = new ConfigParser($_distribution);
				$defaults = $dist->getDefaults();
				if (!empty($defaults)) {
					foreach ($defaults as $property) {
						$this->_updateSetting($upd_stmt, $property->attributes()->value, $property->attributes()->settinggroup, $property->attributes()->varname);
					}
				}
			}
		}

		$this->_updateSetting($upd_stmt, $this->_data['activate_newsfeed'], 'admin', 'show_news_feed');
		$this->_updateSetting($upd_stmt, dirname(__FILE__, 3), 'system', 'letsencryptchallengepath');

		// insert the lastcronrun to be the installation date
		$this->_updateSetting($upd_stmt, time(), 'system', 'lastcronrun');

		// check currently used php version and set values of fpm/fcgid accordingly
		if (defined('PHP_MAJOR_VERSION') && defined('PHP_MINOR_VERSION')) {
			$reload = "service php" . PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION . "-fpm restart";
			$config_dir = "/etc/php/" . PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION . "/fpm/pool.d/";
			$db->query("UPDATE `" . TABLE_PANEL_FPMDAEMONS . "` SET `reload_cmd` = '" . $reload . "', `config_dir` = '" . $config_dir . "' WHERE `id` ='1';");
		}

		// set specific times for some crons (traffic only at night, etc.)
		$ts = mktime(0, 0, 0, date('m', time()), date('d', time()), date('Y', time()));
		$db->query("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `lastrun` = '" . $ts . "' WHERE `cronfile` ='cron_traffic';");

		// insert task 99 to generate a correct cron.d-file automatically
		$db->query("INSERT INTO `" . TABLE_PANEL_TASKS . "` SET `type` = '99';");

		$content[] = $check;
	}

	/**
	 * Import froxlor.sql into database
	 *
	 * @param array $content
	 *
	 * @return void
	 */
	private function _importDatabaseData(&$content)
	{
		$check = [
			'title' => $this->_lng['install']['testing_new_db'],
			'result' => 0
		];
		$options = array(
			'PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET names utf8'
		);

		if (!empty($this->_data['mysql_ssl_ca_file'])) {
			$options[\PDO::MYSQL_ATTR_SSL_CA] = $this->_data['mysql_ssl_ca_file'];
			$options[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = (bool) $this->_data['mysql_ssl_verify_server_certificate'];
		}

		$dsn = "mysql:host=" . $this->_data['mysql_host'] . ";dbname=" . $this->_data['mysql_database'] . ";";
		$fatal_fail = false;
		try {
			$db = new PDO($dsn, $this->_data['mysql_unpriv_user'], $this->_data['mysql_unpriv_pass'], $options);
			$attributes = array(
				'ATTR_ERRMODE' => 'ERRMODE_EXCEPTION'
			);
			// set attributes
			foreach ($attributes as $k => $v) {
				$db->setAttribute(constant("PDO::" . $k), constant("PDO::" . $v));
			}
			$version_server = $db->getAttribute(PDO::ATTR_SERVER_VERSION);
			$sql_mode = 'NO_ENGINE_SUBSTITUTION';
			if (version_compare($version_server, '8.0.11', '<')) {
				$sql_mode .= ',NO_AUTO_CREATE_USER';
			}
			$db->exec('SET sql_mode = "' . $sql_mode . '"');
		} catch (PDOException $e) {
			$check['result'] = 1;
			$check['result_txt'] = $this->_lng['install']['failed'];
			$check['result_desc'] = $e->getMessage();
			$fatal_fail = true;
			$this->_abort = true;
			$content[] = $check;
		}

		if (!$fatal_fail) {

			$content[] = $check;

			$check = [
				'title' => $this->_lng['install']['importing_data'],
				'result' => 0
			];
			$db_schema = dirname(__FILE__, 2) . '/froxlor.sql.php';
			$sql_query = @file_get_contents($db_schema);
			$sql_query = $this->_remove_remarks($sql_query);
			$sql_query = $this->_split_sql_file($sql_query, ';');
			for ($i = 0; $i < sizeof($sql_query); $i++) {
				if (trim($sql_query[$i]) != '') {
					try {
						$db->query($sql_query[$i]);
					} catch (\PDOException $e) {
						$check['result'] = 1;
						$check['result_txt'] = $this->_lng['install']['failed'];
						$check['result_desc'] = $e->getMessage();
						$fatal_fail = true;
						$this->_abort = true;
						break;
					}
				}
			}
			$db = null;
		}
		$content[] = $check;
	}

	/**
	 * Create database and database-user
	 *
	 * @param object $db_root
	 * @param array $content
	 *
	 * @return void
	 */
	private function _createDatabaseAndUser(&$db_root, &$content)
	{
		// so first we have to delete the database and
		// the user given for the unpriv-user if they exit
		$check = [
			'title' => $this->_lng['install']['prepare_db'],
			'result' => 0
		];

		$del_stmt = $db_root->prepare("DELETE FROM `mysql`.`user` WHERE `User` = :user AND `Host` = :accesshost");
		$del_stmt->execute(array(
			'user' => $this->_data['mysql_unpriv_user'],
			'accesshost' => $this->_data['mysql_access_host']
		));

		$del_stmt = $db_root->prepare("DELETE FROM `mysql`.`db` WHERE `User` = :user AND `Host` = :accesshost");
		$del_stmt->execute(array(
			'user' => $this->_data['mysql_unpriv_user'],
			'accesshost' => $this->_data['mysql_access_host']
		));

		$del_stmt = $db_root->prepare("DELETE FROM `mysql`.`tables_priv` WHERE `User` = :user AND `Host` =:accesshost");
		$del_stmt->execute(array(
			'user' => $this->_data['mysql_unpriv_user'],
			'accesshost' => $this->_data['mysql_access_host']
		));

		$del_stmt = $db_root->prepare("DELETE FROM `mysql`.`columns_priv` WHERE `User` = :user AND `Host` = :accesshost");
		$del_stmt->execute(array(
			'user' => $this->_data['mysql_unpriv_user'],
			'accesshost' => $this->_data['mysql_access_host']
		));

		$del_stmt = $db_root->prepare("DROP DATABASE IF EXISTS `" . str_replace('`', '', $this->_data['mysql_database']) . "`;");
		$del_stmt->execute();

		$db_root->query("FLUSH PRIVILEGES;");
		$content[] = $check;

		// we have to create a new user and database for the froxlor unprivileged mysql access
		$check = [
			'title' => $this->_lng['install']['create_mysqluser_and_db'],
			'result' => 0
		];
		$ins_stmt = $db_root->prepare("CREATE DATABASE `" . str_replace('`', '', $this->_data['mysql_database']) . "` CHARACTER SET=utf8 COLLATE=utf8_general_ci");
		$ins_stmt->execute();

		$mysql_access_host_array = array_map('trim', explode(',', $this->_data['mysql_access_host']));

		if (in_array('127.0.0.1', $mysql_access_host_array) && !in_array('localhost', $mysql_access_host_array)) {
			$mysql_access_host_array[] = 'localhost';
		}

		if (!in_array('127.0.0.1', $mysql_access_host_array) && in_array('localhost', $mysql_access_host_array)) {
			$mysql_access_host_array[] = '127.0.0.1';
		}

		if (!in_array($this->_data['serverip'], $mysql_access_host_array)) {
			$mysql_access_host_array[] = $this->_data['serverip'];
		}

		$mysql_access_host_array = array_unique($mysql_access_host_array);

		foreach ($mysql_access_host_array as $mysql_access_host) {
			$frox_db = str_replace('`', '', $this->_data['mysql_database']);
			$this->_grantDbPrivilegesTo($db_root, $frox_db, $this->_data['mysql_unpriv_user'], $this->_data['mysql_unpriv_pass'], $mysql_access_host);
		}

		$db_root->query("FLUSH PRIVILEGES;");
		$this->_data['mysql_access_host'] = implode(',', $mysql_access_host_array);
		$content[] = $check;
	}

	private function _grantDbPrivilegesTo(&$db_root, $database, $username, $password, $access_host)
	{
		// mariadb
		if (version_compare($db_root->getAttribute(\PDO::ATTR_SERVER_VERSION), '10.0.0', '>=')) {
			// create user
			$stmt = $db_root->prepare("
				CREATE USER '" . $username . "'@'" . $access_host . "' IDENTIFIED BY :password
			");
			$stmt->execute(array(
				"password" => $password
			));
			// grant privileges
			$stmt = $db_root->prepare("
				GRANT ALL ON `" . $database . "`.* TO :username@:host
			");
			$stmt->execute(array(
				"username" => $username,
				"host" => $access_host
			));
		}
		// mysql8 compatibility
		elseif (version_compare($db_root->getAttribute(\PDO::ATTR_SERVER_VERSION), '8.0.11', '>=')) {
			// create user
			$stmt = $db_root->prepare("
				CREATE USER '" . $username . "'@'" . $access_host . "' IDENTIFIED WITH mysql_native_password BY :password
			");
			$stmt->execute(array(
				"password" => $password
			));
			// grant privileges
			$stmt = $db_root->prepare("
				GRANT ALL ON `" . $database . "`.* TO :username@:host
			");
			$stmt->execute(array(
				"username" => $username,
				"host" => $access_host
			));
		} else {
			// grant privileges
			$stmt = $db_root->prepare("
				GRANT ALL PRIVILEGES ON `" . $database . "`.* TO :username@:host IDENTIFIED BY :password
			");
			$stmt->execute(array(
				"username" => $username,
				"host" => $access_host,
				"password" => $password
			));
		}
	}

	/**
	 * Check if an old database exists and back it up if necessary
	 *
	 * @param object $db_root
	 * @param array $content
	 *
	 * @return void
	 */
	private function _backupExistingDatabase(&$db_root, &$content)
	{
		// check for existing of former database
		$tables_exist = false;
		$sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :database";
		$result_stmt = $db_root->prepare($sql);
		$result_stmt->execute(array(
			'database' => $this->_data['mysql_database']
		));
		$rows = $db_root->query("SELECT FOUND_ROWS()")->fetchColumn();

		$check = [
			'title' => $this->_lng['install']['check_db_exists'],
			'result' => 0
		];

		// check result
		if ($result_stmt !== false && $rows > 0) {
			$tables_exist = true;
		}

		if ($tables_exist) {
			if ((int) $this->_data['mysql_forcecreate'] > 0) {
				// set status
				$check['result'] = 2;
				$check['result_txt'] = 'exists (' . $this->_data['mysql_database'] . ')';
				$content[] = $check;

				// tell what's going on
				$check = [
					'title' => $this->_lng['install']['backup_old_db'],
					'result' => 0
				];

				// create temporary backup-filename
				$filename = "/tmp/froxlor_backup_" . date('YmdHi') . ".sql";

				// look for mysqldump
				$do_backup = false;
				if (file_exists("/usr/bin/mysqldump")) {
					$do_backup = true;
					$mysql_dump = '/usr/bin/mysqldump';
				} elseif (file_exists("/usr/local/bin/mysqldump")) {
					$do_backup = true;
					$mysql_dump = '/usr/local/bin/mysqldump';
				}

				// create temporary .cnf file
				$cnffilename = "/tmp/froxlor_dump.cnf";
				$dumpcnf = "[mysqldump]" . PHP_EOL . "password=\"" . $this->_data['mysql_root_pass'] . "\"" . PHP_EOL;
				file_put_contents($cnffilename, $dumpcnf);

				if ($do_backup) {
					$command = $mysql_dump . " --defaults-extra-file=" . $cnffilename . " " . escapeshellarg($this->_data['mysql_database']) . " -u " . escapeshellarg($this->_data['mysql_root_user']) . " --result-file=" . $filename;
					$output = [];
					exec($command, $output);
					@unlink($cnffilename);
					if (stristr(implode(" ", $output), "error") || !file_exists($filename)) {
						$check['result'] = 1;
						$check['result_txt'] = $this->_lng['install']['backup_failed'];
						$this->_abort = true;
					}
				} else {
					$check['result'] = 1;
					$check['result_txt'] = $this->_lng['install']['backup_binary_missing'];
					$this->_abort = true;
				}
				$content[] = $check;
			} else {
				$check['result'] = 1;
				$check['result_txt'] = $this->_lng['install']['db_exists'];
				$this->_abort = true;
			}
		}
		$content[] = $check;
	}

	/**
	 * show form to collect all needed data for the install
	 */
	private function _showDataForm($check_result = null)
	{
		// form action
		$formaction = htmlspecialchars($_SERVER['PHP_SELF']);
		if (isset($_GET['check'])) {
			$formaction .= '?check=' . (int) $_GET['check'];
		}

		// prefill whatever we can
		$cpdr = [];
		$this->_checkPostData($cpdr);

		// form-data
		$formdata = [];
		/**
		 * Database
		 */
		$formdata['db'] = [
			'title' => $this->_lng['install']['database'],
			'fields' => [
				$this->_getSectionItemString('mysql_host', true),
				$this->_getSectionItemString('mysql_database', true),
				$this->_getSectionItemYesNo('mysql_forcecreate', false),
				$this->_getSectionItemString('mysql_unpriv_user', true, (!empty($this->_data['mysql_unpriv_user'] ?? "") && $this->_data['mysql_unpriv_user'] == $this->_data['mysql_root_user']) ? 'red' : ''),
				$this->_getSectionItemString('mysql_unpriv_pass', true, (!empty($_POST['installstep']) && $this->_data['mysql_unpriv_pass'] == '') ? 'red' : '', 'password'),
				$this->_getSectionItemString('mysql_root_user', true, (!empty($this->_data['mysql_unpriv_user'] ?? "") && $this->_data['mysql_unpriv_user'] == $this->_data['mysql_root_user']) ? 'red' : ''),
				$this->_getSectionItemString('mysql_root_pass', true, (!empty($_POST['installstep']) && $this->_data['mysql_root_pass'] == '') ? 'red' : '', 'password'),
				$this->_getSectionItemString('mysql_ssl_ca_file', false),
				$this->_getSectionItemYesNo('mysql_ssl_verify_server_certificate', false)
			]
		];

		/**
		 * admin data
		 */
		$formdata['admin'] = [
			'title' => $this->_lng['install']['admin_account'],
			'fields' => [
				$this->_getSectionItemString('admin_user', true),
				$this->_getSectionItemString('admin_pass1', true, (!empty($_POST['installstep']) && ($this->_data['admin_pass1'] == '' || $this->_data['admin_pass1'] != $this->_data['admin_pass2'])) ? 'red' : '', 'password'),
				$this->_getSectionItemString('admin_pass2', true, (!empty($_POST['installstep']) && ($this->_data['admin_pass2'] == '' || $this->_data['admin_pass1'] != $this->_data['admin_pass2'])) ? 'red' : '', 'password'),
				$this->_getSectionItemYesNo('activate_newsfeed', true)
			]
		];

		/**
		 * Server data
		 */

		// show list of available distro's
		$distributions_select_data = [];
		$distros = glob(\Froxlor\FileDir::makeCorrectDir(\Froxlor\Froxlor::getInstallDir() . '/lib/configfiles/') . '*.xml');
		foreach ($distros as $_distribution) {
			$dist = new \Froxlor\Config\ConfigParser($_distribution);
			$dist_display = $dist->distributionName . " " . $dist->distributionCodename . " (" . $dist->distributionVersion . ")";
			if ($dist->deprecated) {
				$dist_display .= " [deprecated]";
			}
			$distributions_select_data[] = [
				'label' => $dist_display,
				'value' => str_replace(".xml", "", strtolower(basename($_distribution))),
				'selected' => (str_replace(".xml", "", strtolower(basename($_distribution))) == ($this->_data['distribution'] ?? "")) ? true : false
			];
		}

		// sort by distribution name
		sort($distributions_select_data);

		$formdata['server'] = [
			'title' => $this->_lng['install']['serversettings'],
			'fields' => [
				$this->_getSectionItemSelectbox('distribution', $distributions_select_data, (!empty($_POST['installstep']) && $this->_data['distribution'] == '') ? 'red' : ''),
				$this->_getSectionItemString('servername', true, (!empty($_POST['installstep']) && $this->_data['servername'] == '') ? 'red' : ''),
				$this->_getSectionItemString('serverip', true, (!empty($_POST['installstep']) && ($this->_data['serverip'] == '' || $this->_validate_ip($this->_data['serverip']) == false)) ? 'red' : ''),
				$this->_getSectionItemYesNo('use_ssl', true),
				[
					'label' => $this->_lng['install']['webserver'],
					'fields' => [
						$this->_getSectionItemCheckbox('webserver', 'apache2', (isset($this->_data['webserver']) && $this->_data['webserver'] == 'apache2'), (!empty($_POST['installstep']) && $this->_data['webserver'] == '') ? 'red' : ''),
						$this->_getSectionItemCheckbox('webserver', 'apache24', (isset($this->_data['webserver']) && $this->_data['webserver'] == 'apache24'), (!empty($_POST['installstep']) && $this->_data['webserver'] == '') ? 'red' : ''),
						$this->_getSectionItemCheckbox('webserver', 'lighttpd', (isset($this->_data['webserver']) && $this->_data['webserver'] == 'lighttpd'), (!empty($_POST['installstep']) && $this->_data['webserver'] == '') ? 'red' : ''),
						$this->_getSectionItemCheckbox('webserver', 'nginx', (isset($this->_data['webserver']) && $this->_data['webserver'] == 'nginx'), (!empty($_POST['installstep']) && $this->_data['webserver'] == '') ? 'red' : '')
					]
				],
				$this->_getSectionItemString('httpuser', true, (!empty($_POST['installstep']) && $this->_data['httpuser'] == '') ? 'red' : ''),
				$this->_getSectionItemString('httpgroup', true, (!empty($_POST['installstep']) && $this->_data['httpgroup'] == '') ? 'red' : '')
			]
		];

		$navigation = '';
		return array(
			'pagecontent' => [
				'form' => [
					'formaction' => $formaction,
					'languages' => $this->_languages,
					'activelang' => $this->_activelng,
					'data' => $formdata,
					'result' => $check_result
				]
			],
			'pagenavigation' => $navigation
		);
	}

	/**
	 * generate form input field
	 *
	 * @param string $fieldname
	 * @param boolean $required
	 * @param string $style
	 *        	optional css
	 * @param string $type
	 *        	optional type of input-box (default: text)
	 *
	 * @return array
	 */
	private function _getSectionItemString($fieldname = null, $required = false, $style = "", $type = 'text')
	{
		return [
			'type' => $type,
			'id' => $fieldname,
			'name' => $fieldname,
			'value' => htmlspecialchars(($this->_data[$fieldname] ?? "")),
			'label' => $this->_lng['install'][$fieldname],
			'required' => $required,
			'style' => $style
		];
	}

	/**
	 * generate form radio field
	 *
	 * @param string $fieldname
	 * @param boolean $checked
	 * @param string $style
	 *
	 * @return array
	 */
	private function _getSectionItemCheckbox($groupname = null, $fieldname = null, $checked = false, $style = "")
	{
		return [
			'type' => 'radio',
			'id' => $fieldname,
			'name' => $groupname,
			'value' => $fieldname,
			'label' => $this->_lng['install'][$fieldname],
			'checked' => $checked,
			'style' => $style
		];
	}

	/**
	 * generate form selectbox
	 *
	 * @param string $fieldname
	 * @param boolean $options
	 * @param string $style
	 *
	 * @return array
	 */
	private function _getSectionItemSelectbox($fieldname = null, array $options = [], $style = "")
	{
		return [
			'type' => 'select',
			'id' => $fieldname,
			'name' => $fieldname,
			'label' => $this->_lng['install'][$fieldname],
			'options' => $options,
			'style' => $style
		];
	}

	/**
	 * generate form checkbox field
	 *
	 * @param string $fieldname
	 * @param boolean $checked
	 * @param string $style
	 *
	 * @return array
	 */
	private function _getSectionItemYesNo($fieldname = null, $checked = false, $style = "")
	{
		return [
			'type' => 'checkbox',
			'id' => $fieldname,
			'name' => $fieldname,
			'label' => $this->_lng['install'][$fieldname],
			'value' => 1,
			'checked' => $checked,
			'style' => $style
		];
	}

	/**
	 * check for requirements froxlor needs
	 */
	private function _requirementCheck()
	{
		// indicator whether we need to abort or not
		$_die = false;

		// check results
		$content = [];

		// check for correct php version
		$check = [
			'title' => $this->_lng['requirements']['phpversion'],
			'result' => 0
		];

		if (version_compare("7.4.0", PHP_VERSION, ">=")) {
			$check['result'] = 1;
			$check['result_txt'] = $this->_lng['requirements']['notfound'] . ' (' . PHP_VERSION . ')';
			$_die = true;
		} else {
			if (version_compare("8.0.0", PHP_VERSION, ">=")) {
				$check['result'] = 2;
				$check['result_txt'] = $this->_lng['requirements']['newerphpprefered'] . ' (' . PHP_VERSION . ')';
			} else {
				$check['result_txt'] = PHP_VERSION;
			}
		}
		$content[] = $check;

		// check for php_pdo and pdo_mysql
		$check = [
			'title' => $this->_lng['requirements']['phppdo'],
			'result' => 0
		];

		if (!extension_loaded('pdo') || in_array("mysql", PDO::getAvailableDrivers()) == false) {
			$check['result'] = 1;
			$check['result_txt'] = $this->_lng['requirements']['notinstalled'];
			$_die = true;
		} else {
			$check['result_txt'] = $this->_lng['requirements']['installed'];
		}
		$content[] = $check;

		// check for session-extension
		$this->_requirementCheckFor($content, $_die, 'session', false, 'phpsession');

		// check for ctype-extension
		$this->_requirementCheckFor($content, $_die, 'ctype', false, 'phpctype');

		// check for SimpleXML-extension
		$this->_requirementCheckFor($content, $_die, 'simplexml', false, 'phpsimplexml');

		// check for xml-extension
		$this->_requirementCheckFor($content, $_die, 'xml', false, 'phpxml');

		// check for filter-extension
		$this->_requirementCheckFor($content, $_die, 'filter', false, 'phpfilter');

		// check for posix-extension
		$this->_requirementCheckFor($content, $_die, 'posix', false, 'phpposix');

		// check for mbstring-extension
		$this->_requirementCheckFor($content, $_die, 'mbstring', false, 'phpmbstring');

		// check for curl extension
		$this->_requirementCheckFor($content, $_die, 'curl', false, 'phpcurl');

		// check for json extension
		$this->_requirementCheckFor($content, $_die, 'json', false, 'phpjson');

		// check for gmp extension
		$this->_requirementCheckFor($content, $_die, 'gmp', false, 'phpgmp');

		// check for bcmath extension
		$this->_requirementCheckFor($content, $_die, 'bcmath', true, 'phpbcmath', 'bcmathdescription');

		// check for zip extension
		$this->_requirementCheckFor($content, $_die, 'zip', true, 'phpzip', 'zipdescription');

		// check for open_basedir
		$check = [
			'title' => $this->_lng['requirements']['openbasedir'],
			'result' => 0
		];
		$php_ob = @ini_get("open_basedir");
		if (!empty($php_ob) && $php_ob != '') {
			$check['result'] = 2;
			$check['result_txt'] = $this->_lng['requirements']['activated'];
			$check['result_desc'] = $this->_lng['requirements']['openbasedirenabled'];
		} else {
			$check['result_txt'] = 'off';
		}
		$content[] = $check;

		// check for mysqldump binary in order to backup existing database
		$check = [
			'title' => $this->_lng['requirements']['mysqldump'],
			'result' => 0
		];
		if (file_exists("/usr/bin/mysqldump") || file_exists("/usr/local/bin/mysqldump")) {
			$check['result_txt'] = $this->_lng['requirements']['installed'];
		} else {
			$check['result'] = 2;
			$check['result_txt'] = $this->_lng['requirements']['notinstalled'];
			$check['result_desc'] = $this->_lng['requirements']['mysqldumpmissing'];
		}
		$content[] = $check;

		// check if we have unrecoverable errors
		$navigation = '';
		if ($_die) {
			$message = $this->_lng['requirements']['diedbecauseofrequirements'];
			$link = htmlspecialchars($_SERVER['PHP_SELF']);
			$linktext = $this->_lng['click_here_to_refresh'];
		} else {
			$message = $this->_lng['requirements']['froxlor_succ_checks'];
			$link = htmlspecialchars($_SERVER['PHP_SELF']) . '?check=1';
			$linktext = $this->_lng['click_here_to_continue'];
		}

		return array(
			'pagecontent' => [
				'checks' => $content
			],
			'pagenavigation' => [
				'bad' => $_die,
				'message' => $message,
				'link' => $link,
				'linktext' => $linktext
			]
		);
	}

	private function _requirementCheckFor(array &$content, bool &$_die, string $ext = "", bool $optional = false, string $lng_txt = "", string $lng_desc = "")
	{
		$check = [
			'title' => $this->_lng['requirements'][$lng_txt],
			'result' => 0,
			'result_txt' => '',
			'result_desc' => ''
		];

		if (!extension_loaded($ext)) {
			if (!$optional) {
				$check['result'] = 1;
				$check['result_txt'] = $this->_lng['requirements']['notinstalled'];
				$_die = true;
			} else {
				$check['result'] = 2;
				$check['result_txt'] = $this->_lng['requirements']['notinstalled'];
				$check['result_desc'] = $this->_lng['requirements'][$lng_desc];
			}
		} else {
			$check['result_txt'] = $this->_lng['requirements']['installed'];
		}

		$content[] = $check;
	}

	/**
	 * check for the userdata - if it exists then froxlor is
	 * already installed and we show a nice note
	 */
	private function _checkUserDataFile()
	{
		$userdata = $this->_basepath . '/lib/userdata.inc.php';
		if (file_exists($userdata)) {
			// includes the usersettings (MySQL-Username/Passwort)
			// to test if Froxlor is already installed
			require_once $this->_basepath . '/lib/userdata.inc.php';

			if (isset($sql) && is_array($sql)) {
				// installation not necessary - redirect to login
				header("Location: ../index.php");
				exit();
			}
		}
	}

	/**
	 * include the chose language or else default (english)
	 */
	private function _includeLanguageFile()
	{
		// set default
		$standardlanguage = 'english';

		// check either _GET or _POST
		if (isset($_GET['language']) && isset($this->_languages[$_GET['language']])) {
			$this->_activelng = $_GET['language'];
		} elseif (isset($_POST['language']) && isset($this->_languages[$_POST['language']])) {
			$this->_activelng = $_POST['language'];
		} else {
			// try to guess the right language
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			switch ($lang) {
				case "de":
					$this->_activelng = 'german';
					break;
				case "fr":
					$this->_activelng = 'french';
					break;
				default:
					$this->_activelng = $standardlanguage;
					break;
			}
		}

		// require english base language as fallback
		$lngfile = $this->_basepath . '/install/lng/' . $standardlanguage . '.lng.php';
		if (file_exists($lngfile)) {
			// includes file /lng/$language.lng.php if it exists
			require_once $lngfile;
			$this->_lng = $lng;
		}

		// require chosen language if not english
		if ($this->_activelng != $standardlanguage) {
			$lngfile = $this->_basepath . '/install/lng/' . $this->_activelng . '.lng.php';
			if (file_exists($lngfile)) {
				// includes file /lng/$language.lng.php if it exists
				require_once $lngfile;
				$this->_lng = $lng;
			}
		}

		UI::setLng($lng);
	}

	/**
	 * get/guess servername
	 */
	private function _guessServerName()
	{
		// from form?
		if (!empty($_POST['servername'])) {
			$this->_data['servername'] = $_POST['servername'];
			return;
			// from $_SERVER
		} else if (!empty($_SERVER['SERVER_NAME'])) {
			// no ips
			if ($this->_validate_ip($_SERVER['SERVER_NAME']) == false) {
				$this->_data['servername'] = $_SERVER['SERVER_NAME'];
				return;
			}
		}
		// empty
		$this->_data['servername'] = '';
	}

	/**
	 * get/guess serverip
	 */
	private function _guessServerIP()
	{
		// from form
		if (!empty($_POST['serverip'])) {
			$this->_data['serverip'] = $_POST['serverip'];
			$this->_data['serverip'] = inet_ntop(inet_pton($this->_data['serverip']));
			return;
			// from $_SERVER
		} elseif (!empty($_SERVER['SERVER_ADDR'])) {
			$this->_data['serverip'] = $_SERVER['SERVER_ADDR'];
			$this->_data['serverip'] = inet_ntop(inet_pton($this->_data['serverip']));
			return;
		}
		// empty
		$this->_data['serverip'] = '';
	}

	/**
	 * get/guess webserver-software
	 */
	private function _guessWebserver()
	{
		// post
		if (!empty($_POST['webserver'])) {
			$this->_data['webserver'] = $_POST['webserver'];
		} else {
			if (strtoupper(@php_sapi_name()) == "APACHE2HANDLER" || stristr($_SERVER['SERVER_SOFTWARE'], "apache/2")) {
				$this->_data['webserver'] = 'apache24';
			} elseif (substr(strtoupper(@php_sapi_name()), 0, 8) == "LIGHTTPD" || stristr($_SERVER['SERVER_SOFTWARE'], "lighttpd")) {
				$this->_data['webserver'] = 'lighttpd';
			} elseif (substr(strtoupper(@php_sapi_name()), 0, 8) == "NGINX" || stristr($_SERVER['SERVER_SOFTWARE'], "nginx")) {
				$this->_data['webserver'] = 'nginx';
			} else {
				// we don't need to bail out, since unknown does not affect any critical installation routines
				$this->_data['webserver'] = 'unknown';
			}
		}
	}

	/**
	 * get/guess linux distribution
	 */
	private function _guessDistribution()
	{
		// post
		if (!empty($_POST['distribution'])) {
			$this->_data['distribution'] = $_POST['distribution'];
		} else {
			// set default os.
			$os_dist = array(
				'ID' => 'bullseye'
			);
			$os_version = array(
				'0' => '11'
			);

			// read os-release
			if (file_exists('/etc/os-release')) {
				$os_dist_content = file_get_contents('/etc/os-release');
				$os_dist_arr = explode("\n", $os_dist_content);
				$os_dist = [];
				foreach ($os_dist_arr as $os_dist_line) {
					if (empty(trim($os_dist_line)))
						continue;
					$tmp = explode("=", $os_dist_line);
					$os_dist[$tmp[0]] = str_replace('"', "", trim($tmp[1]));
				}
				if (is_array($os_dist) && array_key_exists('ID', $os_dist) && array_key_exists('VERSION_ID', $os_dist)) {
					$os_version = explode('.', $os_dist['VERSION_ID'])[0];
				}
			}

			$distros = glob(\Froxlor\FileDir::makeCorrectDir(\Froxlor\Froxlor::getInstallDir() . '/lib/configfiles/') . '*.xml');
			foreach ($distros as $_distribution) {
				$dist = new \Froxlor\Config\ConfigParser($_distribution);
				$ver = explode('.', $dist->distributionVersion)[0];
				if (strtolower($os_dist['ID']) == strtolower($dist->distributionName) && $os_version == $ver) {
					$this->_data['distribution'] = str_replace(".xml", "", strtolower(basename($_distribution)));
				}
			}
		}
	}

	/**
	 * check if POST field is set and get value for the
	 * internal data array, if not set use either '' or $default if != null
	 *
	 * @param string $fieldname
	 * @param string $default
	 *
	 */
	private function _getPostField($fieldname = null, $default = null)
	{
		// initialize
		$this->_data[$fieldname] = '';
		// set default
		if ($default !== null) {
			$this->_data[$fieldname] = $default;
		}
		// check field
		if (!empty($_POST[$fieldname])) {
			$this->_data[$fieldname] = $_POST[$fieldname];
		}
	}

	/**
	 * check whether the given parameter is an ip-address or not
	 *
	 * @param string $ip
	 *
	 * @return boolean|string
	 */
	private function _validate_ip($ip = null)
	{
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE) === false) {
			return false;
		}
		return $ip;
	}

	/**
	 * remove marks from sql
	 *
	 * @param string $sql
	 *
	 * @return string
	 */
	private function _remove_remarks($sql)
	{
		$lines = explode("\n", $sql);
		// try to keep mem. use down
		$sql = "";
		$linecount = count($lines);
		$output = "";
		for ($i = 0; $i < $linecount; $i++) {
			if ($i != ($linecount - 1) || strlen($lines[$i]) > 0) {
				if (substr($lines[$i], 0, 1) != "#") {
					$output .= $lines[$i] . "\n";
				} else {
					$output .= "\n";
				}
				// Trading a bit of speed for lower mem. use here.
				$lines[$i] = "";
			}
		}
		return $output;
	}

	/**
	 * split_sql_file will split an uploaded sql file into single sql statements.
	 * Note: expects trim() to have already been run on $sql
	 *
	 * The whole function has been taken from the phpbb installer,
	 * copyright by the phpbb team, phpbb in summer 2004.
	 */
	private function _split_sql_file($sql, $delimiter)
	{

		// Split up our string into "possible" SQL statements.
		$tokens = explode($delimiter, $sql);

		// try to save mem.
		$sql = "";
		$output = array();

		// we don't actually care about the matches preg gives us.
		$matches = array();

		// this is faster than calling count($tokens) every time through the loop.
		$token_count = count($tokens);
		for ($i = 0; $i < $token_count; $i++) {
			// Don't want to add an empty string as the last thing in the array.
			if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0))) {
				// This is the total number of single quotes in the token.
				$total_quotes = preg_match_all("/'/", $tokens[$i], $matches);

				// Counts single quotes that are preceded by an odd number of backslashes,
				// which means they're escaped quotes.
				$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
				$unescaped_quotes = $total_quotes - $escaped_quotes;

				// If the number of unescaped quotes is even, then the delimiter
				// did NOT occur inside a string literal.
				if (($unescaped_quotes % 2) == 0) {
					// It's a complete sql statement.
					$output[] = $tokens[$i];
					// save memory.
					$tokens[$i] = "";
				} else {
					// incomplete sql statement. keep adding tokens until we have a complete one.
					// $temp will hold what we have so far.
					$temp = $tokens[$i] . $delimiter;
					// save memory..
					$tokens[$i] = "";
					// Do we have a complete statement yet?
					$complete_stmt = false;
					for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++) {
						// This is the total number of single quotes in the token.
						$total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
						// Counts single quotes that are preceded by an odd number of backslashes,
						// which means they're escaped quotes.
						$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
						$unescaped_quotes = $total_quotes - $escaped_quotes;

						if (($unescaped_quotes % 2) == 1) {
							// odd number of unescaped quotes. In combination with the previous incomplete
							// statement(s), we now have a complete statement. (2 odds always make an even)
							$output[] = $temp . $tokens[$j];
							// save memory.
							$tokens[$j] = "";
							$temp = "";
							// exit the loop.
							$complete_stmt = true;
							// make sure the outer loop continues at the right point.
							$i = $j;
						} else {
							// even number of unescaped quotes. We still don't have a complete statement.
							// (1 odd and 1 even always make an odd)
							$temp .= $tokens[$j] . $delimiter;
							// save memory.
							$tokens[$j] = "";
						}
					} // for..
				} // else
			}
		}
		return $output;
	}
}
