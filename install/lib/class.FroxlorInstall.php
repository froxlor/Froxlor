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
 * @package    Classes
 *
 * @since      0.9.29.1
 *
 */

/**
 * Class FroxlorInstall
 *
 * Does the dirty work
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
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
	 * theme to use for the installation process
	 *
	 * @var string
	 */
	private $_theme = 'Sparkle';

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
		$this->_basepath = dirname(dirname(dirname(__FILE__)));
		$this->_data = array();
	}

	/**
	 * FC
	 */
	public function run()
	{
		// send headers
		$this->_sendHeaders();
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
		// set theme for templates
		$theme = $this->_theme;
		eval("echo \"" . $this->_getTemplate("header") . "\";");
		// check install-state
		if ((isset($_POST['installstep']) && $_POST['installstep'] == '1') || (isset($_GET['check']) && $_GET['check'] == '1')) {
			$pagetitle = $this->_lng['install']['title'];
			if ($this->_checkPostData()) {
				// ceck data and create userdata etc.etc.etc.
				$result = $this->_doInstall();
			} elseif (isset($_GET['check']) && $_GET['check'] == '1') {
				// gather data
				$result = $this->_showDataForm();
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
		eval("echo \"" . $this->_getTemplate("page") . "\";");
		$current_year = date('Y', time());
		eval("echo \"" . $this->_getTemplate("footer") . "\";");
	}

	/**
	 * gather data from $_POST if set; return true if all is set,
	 * false otherwise
	 *
	 * @return boolean
	 */
	private function _checkPostData()
	{
		$this->_guessServerName();
		$this->_guessServerIP();
		$this->_guessWebserver();

		$this->_getPostField('mysql_host', '127.0.0.1');
		$this->_getPostField('mysql_database', 'froxlor');
		$this->_getPostField('mysql_unpriv_user', 'froxlor');
		$this->_getPostField('mysql_unpriv_pass');
		$this->_getPostField('mysql_root_user', 'root');
		$this->_getPostField('mysql_root_pass');
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
			$this->_data['servername'] = '';
		}

		if (empty($this->_data['serverip']) || $this->_validate_ip($this->_data['serverip']) == false) {
			return false;
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
		$content = "<table class=\"noborder\">";

		// check for mysql-root-connection
		$content .= $this->_status_message('begin', $this->_lng['install']['testing_mysql']);

		$options = array(
			'PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET names utf8'
		);
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
				$content .= $this->_status_message('red', $e->getMessage());
				$fatal_fail = true;
			}
		}

		if (! $fatal_fail) {
			$version_server = $db_root->getAttribute(PDO::ATTR_SERVER_VERSION);
			$sql_mode = 'NO_ENGINE_SUBSTITUTION';
			if (version_compare($version_server, '8.0.11', '<')) {
				$sql_mode .= ',NO_AUTO_CREATE_USER';
			}
			$db_root->exec('SET sql_mode = "' . $sql_mode . '"');

			// ok, if we are here, the database connection is up and running
			$content .= $this->_status_message('green', "OK");
			// check for existing db and create backup if so
			$content .= $this->_backupExistingDatabase($db_root);
			// create unprivileged user and the database itself
			$content .= $this->_createDatabaseAndUser($db_root);
			// importing data to new database
			$content .= $this->_importDatabaseData();
			if (! $this->_abort) {
				// create DB object for new database
				$options = array(
					'PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET names utf8'
				);
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
					// dafuq? this should have happened in _importDatabaseData()
					$content .= $this->_status_message('red', $e->getMessage());
					$another_fail = true;
				}

				if (! $another_fail) {
					// change settings accordingly
					$content .= $this->_doSettings($db);
					// create entries
					$content .= $this->_doDataEntries($db);
					$db = null;
					// create config-file
					$content .= $this->_createUserdataConf();
				}
			}
		}

		$content .= "</table>";

		// check if we have unrecoverable errors
		if ($fatal_fail || $another_fail || $this->_abort) {
			// D'oh
			$navigation = '';
			$msgcolor = 'red';
			$message = $this->_lng['install']['testing_mysql_fail'];
			$link = 'install.php?check=1';
			$linktext = $this->_lng['click_here_to_goback'];
		} else {
			// all good
			$navigation = '';
			$msgcolor = 'green';
			$message = $this->_lng['install']['froxlor_succ_installed'];
			$link = '../index.php';
			$linktext = $this->_lng['click_here_to_login'];
		}

		eval("\$navigation .= \"" . $this->_getTemplate("pagebottom") . "\";");

		return array(
			'pagecontent' => $content,
			'pagenavigation' => $navigation
		);
	}

	/**
	 * Create userdata.inc.php file
	 */
	private function _createUserdataConf()
	{
		$content = "";

		$content .= $this->_status_message('begin', $this->_lng['install']['creating_configfile']);
		$userdata = "<?php\n";
		$userdata .= "// automatically generated userdata.inc.php for Froxlor\n";
		$userdata .= "\$sql['host']='" . addcslashes($this->_data['mysql_host'], "'\\") . "';\n";
		$userdata .= "\$sql['user']='" . addcslashes($this->_data['mysql_unpriv_user'], "'\\") . "';\n";
		$userdata .= "\$sql['password']='" . addcslashes($this->_data['mysql_unpriv_pass'], "'\\") . "';\n";
		$userdata .= "\$sql['db']='" . addcslashes($this->_data['mysql_database'], "'\\") . "';\n";
		$userdata .= "\$sql_root[0]['caption']='Default';\n";
		$userdata .= "\$sql_root[0]['host']='" . addcslashes($this->_data['mysql_host'], "'\\") . "';\n";
		$userdata .= "\$sql_root[0]['user']='" . addcslashes($this->_data['mysql_root_user'], "'\\") . "';\n";
		$userdata .= "\$sql_root[0]['password']='" . addcslashes($this->_data['mysql_root_pass'], "'\\") . "';\n";
		$userdata .= "// enable debugging to browser in case of SQL errors\n";
		$userdata .= "\$sql['debug'] = false;\n";
		$userdata .= "?>";

		// test if we can store the userdata.inc.php in ../lib
		$userdata_file = dirname(dirname(dirname(__FILE__))) . '/lib/userdata.inc.php';
		if ($fp = @fopen($userdata_file, 'w')) {
			$result = @fputs($fp, $userdata, strlen($userdata));
			@fclose($fp);
			$content .= $this->_status_message('green', 'OK');
			chmod($userdata_file, 0440);
		} else {
			// try creating it in a temporary file
			$temp_file = tempnam(sys_get_temp_dir(), 'fx');
			if (touch($temp_file)) {
				chmod($temp_file, 0400);
				$fp = @fopen($temp_file, 'w');
				$result = @fputs($fp, $userdata, strlen($userdata));
				@fclose($fp);
				$content .= $this->_status_message('orange', sprintf($this->_lng['install']['creating_configfile_temp'], $temp_file));
			} else {
				$content .= $this->_status_message('red', $this->_lng['install']['creating_configfile_failed']);
				$escpduserdata = nl2br(htmlspecialchars($userdata));
				eval("\$content .= \"" . $this->_getTemplate("textarea") . "\";");
			}
		}

		return $content;
	}

	/**
	 * create corresponding entries in froxlor database
	 *
	 * @param object $db
	 *
	 * @return string status messages
	 */
	private function _doDataEntries(&$db)
	{
		$content = "";

		$content .= $this->_status_message('begin', $this->_lng['install']['creating_entries']);

		// and lets insert the default ip and port
		$stmt = $db->prepare("
				INSERT INTO `" . TABLE_PANEL_IPSANDPORTS . "` SET
				`ip`= :serverip,
				`port` = '80',
				`namevirtualhost_statement` = '1',
				`vhostcontainer` = '1',
				`vhostcontainer_servername_statement` = '1'
				");
		$stmt->execute(array(
			'serverip' => $this->_data['serverip']
		));
		$defaultip = $db->lastInsertId();

		// insert the defaultip
		$upd_stmt = $db->prepare("
				UPDATE `" . TABLE_PANEL_SETTINGS . "` SET
				`value` = :defaultip
				WHERE `settinggroup` = 'system' AND `varname` = 'defaultip'
				");
		$upd_stmt->execute(array(
			'defaultip' => $defaultip
		));

		$content .= $this->_status_message('green', 'OK');

		// last but not least create the main admin
		$content .= $this->_status_message('begin', $this->_lng['install']['adding_admin_user']);
		$ins_data = array(
			'loginname' => $this->_data['admin_user'],
				/* use SHA256 default crypt */
				'password' => crypt($this->_data['admin_pass1'], '$5$' . md5(uniqid(microtime(), 1)) . md5(uniqid(microtime(), 1))),
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

		$content .= $this->_status_message('green', 'OK');

		return $content;
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
	 *
	 * @return string status messages
	 */
	private function _doSettings(&$db)
	{
		$content = "";

		$content .= $this->_status_message('begin', $this->_lng['install']['changing_data']);
		$upd_stmt = $db->prepare("
				UPDATE `" . TABLE_PANEL_SETTINGS . "` SET
				`value` = :value
				WHERE `settinggroup` = :group AND `varname` = :varname
				");

		$this->_updateSetting($upd_stmt, 'admin@' . $this->_data['servername'], 'panel', 'adminmail');
		$this->_updateSetting($upd_stmt, $this->_data['serverip'], 'system', 'ipaddress');
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
			$this->_updateSetting($upd_stmt, '/etc/init.d/lighttpd reload', 'system', 'apachereload_command');
			$this->_updateSetting($upd_stmt, '/etc/lighttpd/lighttpd.pem', 'system', 'ssl_cert_file');
			$this->_updateSetting($upd_stmt, '/var/run/lighttpd/', 'phpfpm', 'fastcgi_ipcdir');
		} elseif ($this->_data['webserver'] == "nginx") {
			$this->_updateSetting($upd_stmt, '/etc/nginx/sites-enabled/', 'system', 'apacheconf_vhost');
			$this->_updateSetting($upd_stmt, '/etc/nginx/sites-enabled/', 'system', 'apacheconf_diroptions');
			$this->_updateSetting($upd_stmt, '/etc/nginx/froxlor-htpasswd/', 'system', 'apacheconf_htpasswddir');
			$this->_updateSetting($upd_stmt, '/etc/init.d/nginx reload', 'system', 'apachereload_command');
			$this->_updateSetting($upd_stmt, '/etc/nginx/nginx.pem', 'system', 'ssl_cert_file');
			$this->_updateSetting($upd_stmt, '/var/run/', 'phpfpm', 'fastcgi_ipcdir');
			$this->_updateSetting($upd_stmt, 'error', 'system', 'errorlog_level');
		}

		$this->_updateSetting($upd_stmt, $this->_data['activate_newsfeed'], 'admin', 'show_news_feed');
		$this->_updateSetting($upd_stmt, dirname(dirname(dirname(__FILE__))), 'system', 'letsencryptchallengepath');

		// insert the lastcronrun to be the installation date
		$this->_updateSetting($upd_stmt, time(), 'system', 'lastcronrun');

		// set specific times for some crons (traffic only at night, etc.)
		$ts = mktime(0, 0, 0, date('m', time()), date('d', time()), date('Y', time()));
		$db->query("UPDATE `" . TABLE_PANEL_CRONRUNS . "` SET `lastrun` = '" . $ts . "' WHERE `cronfile` ='cron_traffic';");

		// insert task 99 to generate a correct cron.d-file automatically
		$db->query("INSERT INTO `" . TABLE_PANEL_TASKS . "` SET `type` = '99';");

		$content .= $this->_status_message('green', 'OK');

		return $content;
	}

	/**
	 * Import froxlor.sql into database
	 *
	 * @param object $db_root
	 *
	 * @return string status messages
	 */
	private function _importDatabaseData()
	{
		$content = "";
		$content .= $this->_status_message('begin', $this->_lng['install']['testing_new_db']);
		$options = array(
			'PDO::MYSQL_ATTR_INIT_COMMAND' => 'SET names utf8'
		);
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
			$content .= $this->_status_message('red', $e->getMessage());
			$fatal_fail = true;
		}

		if (! $fatal_fail) {

			$content .= $this->_status_message('green', 'OK');

			$content .= $this->_status_message('begin', $this->_lng['install']['importing_data']);
			$db_schema = dirname(dirname(__FILE__)) . '/froxlor.sql';
			$sql_query = @file_get_contents($db_schema);
			$sql_query = $this->_remove_remarks($sql_query);
			$sql_query = $this->_split_sql_file($sql_query, ';');
			for ($i = 0; $i < sizeof($sql_query); $i ++) {
				if (trim($sql_query[$i]) != '') {
					try {
						$result = $db->query($sql_query[$i]);
					} catch (\PDOException $e) {
						$content .= $this->_status_message('red', $e->getMessage());
						$fatal_fail = true;
						$this->_abort = true;
						break;
					}
				}
			}

			if (! $fatal_fail) {
				$content .= $this->_status_message('green', 'OK');
			}
			$db = null;
		}

		return $content;
	}

	/**
	 * Create database and database-user
	 *
	 * @param object $db_root
	 *
	 * @return string status messages
	 */
	private function _createDatabaseAndUser(&$db_root)
	{
		$content = "";

		// so first we have to delete the database and
		// the user given for the unpriv-user if they exit
		$content .= $this->_status_message('begin', $this->_lng['install']['prepare_db']);

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
		$content .= $this->_status_message('green', 'OK');

		// we have to create a new user and database for the froxlor unprivileged mysql access
		$content .= $this->_status_message('begin', $this->_lng['install']['create_mysqluser_and_db']);
		$ins_stmt = $db_root->prepare("CREATE DATABASE `" . str_replace('`', '', $this->_data['mysql_database']) . "` CHARACTER SET=utf8 COLLATE=utf8_general_ci");
		$ins_stmt->execute();

		$mysql_access_host_array = array_map('trim', explode(',', $this->_data['mysql_access_host']));

		if (in_array('127.0.0.1', $mysql_access_host_array) && ! in_array('localhost', $mysql_access_host_array)) {
			$mysql_access_host_array[] = 'localhost';
		}

		if (! in_array('127.0.0.1', $mysql_access_host_array) && in_array('localhost', $mysql_access_host_array)) {
			$mysql_access_host_array[] = '127.0.0.1';
		}

		$mysql_access_host_array[] = $this->_data['serverip'];
		foreach ($mysql_access_host_array as $mysql_access_host) {
			$frox_db = str_replace('`', '', $this->_data['mysql_database']);
			$this->_grantDbPrivilegesTo($db_root, $frox_db, $this->_data['mysql_unpriv_user'], $this->_data['mysql_unpriv_pass'], $mysql_access_host);
		}

		$db_root->query("FLUSH PRIVILEGES;");
		$this->_data['mysql_access_host'] = implode(',', $mysql_access_host_array);
		$content .= $this->_status_message('green', 'OK');

		return $content;
	}

	private function _grantDbPrivilegesTo(&$db_root, $database, $username, $password, $access_host)
	{
		// mysql8 compatibility
		if (version_compare($db_root->getAttribute(\PDO::ATTR_SERVER_VERSION), '8.0.11', '>=')) {
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
	 *
	 * @return string status messages
	 */
	private function _backupExistingDatabase(&$db_root)
	{
		$content = "";

		// check for existing of former database
		$tables_exist = false;
		$sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :database";
		$result_stmt = $db_root->prepare($sql);
		$result_stmt->execute(array(
			'database' => $this->_data['mysql_database']
		));
		$rows = $db_root->query("SELECT FOUND_ROWS()")->fetchColumn();

		// check result
		if ($result_stmt !== false && $rows > 0) {
			$tables_exist = true;
		}

		if ($tables_exist) {
			// tell whats going on
			$content .= $this->_status_message('begin', $this->_lng['install']['backup_old_db']);

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

			if ($do_backup) {
				$command = $mysql_dump . " " . escapeshellarg($this->_data['mysql_database']) . " -u " . escapeshellarg($this->_data['mysql_root_user']) . " --password='" . $this->_data['mysql_root_pass'] . "' --result-file=" . $filename;
				$output = exec($command);
				if (stristr($output, "error")) {
					$content .= $this->_status_message('red', $this->_lng['install']['backup_failed']);
				} else {
					$content .= $this->_status_message('green', 'OK (' . $filename . ')');
				}
			} else {
				$content .= $this->_status_message('red', $this->_lng['install']['backup_binary_missing']);
			}
		}

		return $content;
	}

	/**
	 * show form to collect all needed data for the install
	 */
	private function _showDataForm()
	{
		$content = "";
		// form action
		$formaction = htmlspecialchars($_SERVER['PHP_SELF']);
		if (isset($_GET['check'])) {
			$formaction .= '?check=' . (int) $_GET['check'];
		}
		// language selection
		$language_options = '';
		foreach ($this->_languages as $language_name => $language_file) {
			$language_options .= \Froxlor\UI\HTML::makeoption($language_name, $language_file, $this->_activelng, true, true);
		}
		// get language-form-template
		eval("\$content .= \"" . $this->_getTemplate("lngform") . "\";");

		// form-data
		$formdata = "";
		/**
		 * Database
		 */
		$section = $this->_lng['install']['database'];
		eval("\$formdata .= \"" . $this->_getTemplate("datasection") . "\";");
		// host
		$formdata .= $this->_getSectionItemString('mysql_host', true);
		// database
		$formdata .= $this->_getSectionItemString('mysql_database', true);
		// unpriv-user has to be different from root
		if ($this->_data['mysql_unpriv_user'] == $this->_data['mysql_root_user']) {
			$style = 'blue';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('mysql_unpriv_user', true, $style);
		// is we posted and no password was given -> red
		if (! empty($_POST['installstep']) && $this->_data['mysql_unpriv_pass'] == '') {
			$style = 'red';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('mysql_unpriv_pass', true, $style, 'password');
		// unpriv-user has to be different from root
		if ($this->_data['mysql_unpriv_user'] == $this->_data['mysql_root_user']) {
			$style = 'blue';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('mysql_root_user', true, $style);
		// is we posted and no password was given -> red
		if (! empty($_POST['installstep']) && $this->_data['mysql_root_pass'] == '') {
			$style = 'red';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('mysql_root_pass', true, $style, 'password');

		/**
		 * admin data
		 */
		$section = $this->_lng['install']['admin_account'];
		eval("\$formdata .= \"" . $this->_getTemplate("datasection") . "\";");
		// user
		$formdata .= $this->_getSectionItemString('admin_user', true);
		// check for admin passwords to be equal
		if (! empty($_POST['installstep']) && ($this->_data['admin_pass1'] == '' || $this->_data['admin_pass1'] != $this->_data['admin_pass2'])) {
			$style = 'color:red;';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('admin_pass1', true, $style, 'password');
		// check for admin passwords to be equal
		if (! empty($_POST['installstep']) && ($this->_data['admin_pass2'] == '' || $this->_data['admin_pass1'] != $this->_data['admin_pass2'])) {
			$style = 'color:red;';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('admin_pass2', true, $style, 'password');
		// activate newsfeed?
		$formdata .= $this->_getSectionItemYesNo('activate_newsfeed', true);

		/**
		 * Server data
		 */
		$section = $this->_lng['install']['serversettings'];
		eval("\$formdata .= \"" . $this->_getTemplate("datasection") . "\";");
		// servername
		if (! empty($_POST['installstep']) && $this->_data['servername'] == '') {
			$style = 'color:red;';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('servername', true, $style);
		// serverip
		if (! empty($_POST['installstep']) && ($this->_data['serverip'] == '' || $this->_validate_ip($this->_data['serverip']) == false)) {
			$style = 'color:red;';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('serverip', true, $style);
		// webserver
		if (! empty($_POST['installstep']) && $this->_data['webserver'] == '') {
			$websrvstyle = 'color:red;';
		} else {
			$websrvstyle = '';
		}
		// apache
		$formdata .= $this->_getSectionItemCheckbox('apache2', ($this->_data['webserver'] == 'apache2'), $websrvstyle);
		$formdata .= $this->_getSectionItemCheckbox('apache24', ($this->_data['webserver'] == 'apache24'), $websrvstyle);
		// lighttpd
		$formdata .= $this->_getSectionItemCheckbox('lighttpd', ($this->_data['webserver'] == 'lighttpd'), $websrvstyle);
		// nginx
		$formdata .= $this->_getSectionItemCheckbox('nginx', ($this->_data['webserver'] == 'nginx'), $websrvstyle);
		// webserver-user
		if (! empty($_POST['installstep']) && $this->_data['httpuser'] == '') {
			$style = 'color:red;';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('httpuser', true, $style);
		// webserver-group
		if (! empty($_POST['installstep']) && $this->_data['httpgroup'] == '') {
			$style = 'color:red;';
		} else {
			$style = '';
		}
		$formdata .= $this->_getSectionItemString('httpgroup', true, $style);

		// get data-form-template
		$language = htmlspecialchars($this->_activelng);
		eval("\$content .= \"" . $this->_getTemplate("dataform2") . "\";");

		$navigation = '';
		return array(
			'pagecontent' => $content,
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
	 * @return string
	 */
	private function _getSectionItemString($fieldname = null, $required = false, $style = "", $type = 'text')
	{
		$fieldlabel = $this->_lng['install'][$fieldname];
		$fieldvalue = htmlspecialchars($this->_data[$fieldname]);
		if ($required) {
			$required = ' required="required"';
		}
		$sectionitem = "";
		eval("\$sectionitem .= \"" . $this->_getTemplate("dataitem") . "\";");
		return $sectionitem;
	}

	/**
	 * generate form radio field for webserver-selection
	 *
	 * @param string $fieldname
	 * @param boolean $checked
	 * @param string $style
	 *
	 * @return string
	 */
	private function _getSectionItemCheckbox($fieldname = null, $checked = false, $style = "")
	{
		$fieldlabel = $this->_lng['install'][$fieldname];
		if ($checked) {
			$checked = 'checked="checked"';
		}
		$sectionitem = "";
		eval("\$sectionitem .= \"" . $this->_getTemplate("dataitemchk") . "\";");
		return $sectionitem;
	}

	/**
	 * generate form checkbox field
	 *
	 * @param string $fieldname
	 * @param boolean $checked
	 * @param string $style
	 *
	 * @return string
	 */
	private function _getSectionItemYesNo($fieldname = null, $checked = false, $style = "")
	{
		$fieldlabel = $this->_lng['install'][$fieldname];
		if ($checked) {
			$checked = 'checked="checked"';
		}
		$sectionitem = "";
		eval("\$sectionitem .= \"" . $this->_getTemplate("dataitemyesno") . "\";");
		return $sectionitem;
	}

	/**
	 * check for requirements froxlor needs
	 */
	private function _requirementCheck()
	{

		// indicator whether we need to abort or not
		$_die = false;

		$content = "<table class=\"noborder\">";

		// check for correct php version
		$content .= $this->_status_message('begin', $this->_lng['requirements']['phpversion']);

		if (version_compare("7.0.0", PHP_VERSION, ">=")) {
			$content .= $this->_status_message('red', $this->_lng['requirements']['notfound'] . ' (' . PHP_VERSION . ')');
			$_die = true;
		} else {
			if (version_compare("7.1.0", PHP_VERSION, ">=")) {
				$content .= $this->_status_message('orange', $this->_lng['requirements']['newerphpprefered'] . ' (' . PHP_VERSION . ')');
			} else {
				$content .= $this->_status_message('green', PHP_VERSION);
			}
		}

		// check for php_pdo and pdo_mysql
		$content .= $this->_status_message('begin', $this->_lng['requirements']['phppdo']);

		if (! extension_loaded('pdo') || in_array("mysql", PDO::getAvailableDrivers()) == false) {
			$content .= $this->_status_message('red', $this->_lng['requirements']['notinstalled']);
			$_die = true;
		} else {
			$content .= $this->_status_message('green', $this->_lng['requirements']['installed']);
		}

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

		// check for bcmath extension
		$this->_requirementCheckFor($content, $_die, 'bcmath', true, 'phpbcmath', 'bcmathdescription');

		// check for zip extension
		$this->_requirementCheckFor($content, $_die, 'zip', true, 'phpzip', 'zipdescription');

		// check for open_basedir
		$content .= $this->_status_message('begin', $this->_lng['requirements']['openbasedir']);
		$php_ob = @ini_get("open_basedir");
		if (! empty($php_ob) && $php_ob != '') {
			$content .= $this->_status_message('orange', $this->_lng['requirements']['activated'] . "<br />" . $this->_lng['requirements']['openbasedirenabled']);
		} else {
			$content .= $this->_status_message('green', 'off');
		}

		// check for mysqldump binary in order to backup existing database
		$content .= $this->_status_message('begin', $this->_lng['requirements']['mysqldump']);

		if (file_exists("/usr/bin/mysqldump") || file_exists("/usr/local/bin/mysqldump")) {
			$content .= $this->_status_message('green', $this->_lng['requirements']['installed']);
		} else {
			$content .= $this->_status_message('orange', $this->_lng['requirements']['notinstalled'] . "<br />" . $this->_lng['requirements']['mysqldumpmissing']);
		}

		$content .= "</table>";

		// check if we have unrecoverable errors
		$navigation = '';
		if ($_die) {
			$msgcolor = 'red';
			$message = $this->_lng['requirements']['diedbecauseofrequirements'];
			$link = htmlspecialchars($_SERVER['PHP_SELF']);
			$linktext = $this->_lng['click_here_to_refresh'];
		} else {
			$msgcolor = 'green';
			$message = $this->_lng['requirements']['froxlor_succ_checks'];
			$link = htmlspecialchars($_SERVER['PHP_SELF']) . '?check=1';
			$linktext = $this->_lng['click_here_to_continue'];
		}
		eval("\$navigation .= \"" . $this->_getTemplate("pagebottom") . "\";");

		return array(
			'pagecontent' => $content,
			'pagenavigation' => $navigation
		);
	}

	private function _requirementCheckFor(&$content, &$_die, $ext = '', $optional = false, $lng_txt = "", $lng_desc = "")
	{
		$content .= $this->_status_message('begin', $this->_lng['requirements'][$lng_txt]);

		if (! extension_loaded($ext)) {
			if (! $optional) {
				$content .= $this->_status_message('red', $this->_lng['requirements']['notinstalled']);
				$_die = true;
			} else {
				$content .= $this->_status_message('orange', $this->_lng['requirements']['notinstalled'] . "<br />" . $this->_lng['requirements'][$lng_desc]);
			}
		} else {
			$content .= $this->_status_message('green', $this->_lng['requirements']['installed']);
		}
	}

	/**
	 * send no-caching headers and set the default timezone
	 */
	private function _sendHeaders()
	{
		if (@php_sapi_name() !== 'cli') {
			// no caching
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Pragma: no-cache");
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s \G\M\T', time()));
			header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time()));
		}
		// ensure that default timezone is set
		if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get")) {
			@date_default_timezone_set(@date_default_timezone_get());
		}
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
				// use sparkle theme for the notice
				$installed_hint = file_get_contents($this->_basepath . '/templates/Sparkle/misc/alreadyinstalledhint.tpl');
				$installed_hint = str_replace("<CURRENT_YEAR>", date('Y', time()), $installed_hint);
				die($installed_hint);
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
	}

	/**
	 * Get template from filesystem
	 *
	 * @param string $template
	 *        	name of the template including subdirectory
	 *        	
	 * @return string
	 */
	private function _getTemplate($template = null)
	{
		// build filename
		$filename = $this->_basepath . '/install/templates/' . $template . '.tpl';
		// check existence
		if (file_exists($filename) && is_readable($filename)) {
			$templatefile = addcslashes(file_get_contents($filename), '"\\');
			// loop through template more than once in case we have an "if"-statement in another one
			while (preg_match('/<if[ \t]*(.*)>(.*)(<\/if>|<else>(.*)<\/if>)/Uis', $templatefile)) {
				$templatefile = preg_replace('/<if[ \t]*(.*)>(.*)(<\/if>|<else>(.*)<\/if>)/Uis', '".( ($1) ? ("$2") : ("$4") )."', $templatefile);
			}
		} else {
			$templatefile = 'TEMPLATE NOT FOUND: ' . $filename;
		}

		return $templatefile;
	}

	/**
	 * output status
	 *
	 * @param string $case
	 * @param string $text
	 *
	 * @return string
	 */
	private function _status_message($case, $text)
	{
		if ($case == 'begin') {
			return '<tr><td class="install-step">' . $text;
		} else {
			return '</td><td><span class="' . $case . '">' . $text . '</span></td></tr>';
		}
	}

	/**
	 * get/guess servername
	 */
	private function _guessServerName()
	{
		// from form?
		if (! empty($_POST['servername'])) {
			$this->_data['servername'] = $_POST['servername'];
			return;
			// from $_SERVER
		} else if (! empty($_SERVER['SERVER_NAME'])) {
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
		if (! empty($_POST['serverip'])) {
			$this->_data['serverip'] = $_POST['serverip'];
			return;
			// from $_SERVER
		} elseif (! empty($_SERVER['SERVER_ADDR'])) {
			$this->_data['serverip'] = $_SERVER['SERVER_ADDR'];
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
		if (! empty($_POST['webserver'])) {
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
		if (! empty($_POST[$fieldname])) {
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
		for ($i = 0; $i < $linecount; $i ++) {
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
		for ($i = 0; $i < $token_count; $i ++) {
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
					for ($j = $i + 1; (! $complete_stmt && ($j < $token_count)); $j ++) {
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
