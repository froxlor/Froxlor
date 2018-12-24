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
class Fcgid
{

	/**
	 * Domain-Data array
	 *
	 * @var array
	 */
	private $domain = array();

	/**
	 * Admin-Date cache array
	 *
	 * @var array
	 */
	private $admin_cache = array();

	/**
	 * main constructor
	 */
	public function __construct($domain)
	{
		$this->domain = $domain;
	}

	/**
	 * create fcgid-starter-file
	 *
	 * @param array $phpconfig
	 */
	public function createConfig($phpconfig)
	{

		// create starter
		$starter_file = "#!/bin/sh\n\n";
		$starter_file .= "#\n";
		$starter_file .= "# starter created/changed on " . date("Y.m.d H:i:s") . " for domain '" . $this->domain['domain'] . "' with id #" . $this->domain['id'] . " from php template '" . $phpconfig['description'] . "' with id #" . $phpconfig['id'] . "\n";
		$starter_file .= "# Do not change anything in this file, it will be overwritten by the Froxlor Cronjob!\n";
		$starter_file .= "#\n\n";
		$starter_file .= "umask " . $phpconfig['mod_fcgid_umask'] . "\n";
		$starter_file .= "PHPRC=" . escapeshellarg($this->getConfigDir()) . "\n";
		$starter_file .= "export PHPRC\n";

		// set number of processes for one domain
		if ((int) $this->domain['mod_fcgid_starter'] != - 1) {
			$starter_file .= "PHP_FCGI_CHILDREN=" . (int) $this->domain['mod_fcgid_starter'] . "\n";
		} else {
			if ((int) $phpconfig['mod_fcgid_starter'] != - 1) {
				$starter_file .= "PHP_FCGI_CHILDREN=" . (int) $phpconfig['mod_fcgid_starter'] . "\n";
			} else {
				$starter_file .= "PHP_FCGI_CHILDREN=" . (int) Settings::Get('system.mod_fcgid_starter') . "\n";
			}
		}

		$starter_file .= "export PHP_FCGI_CHILDREN\n";

		// set number of maximum requests for one domain
		if ((int) $this->domain['mod_fcgid_maxrequests'] != - 1) {
			$starter_file .= "PHP_FCGI_MAX_REQUESTS=" . (int) $this->domain['mod_fcgid_maxrequests'] . "\n";
		} else {
			if ((int) $phpconfig['mod_fcgid_maxrequests'] != - 1) {
				$starter_file .= "PHP_FCGI_MAX_REQUESTS=" . (int) $phpconfig['mod_fcgid_maxrequests'] . "\n";
			} else {
				$starter_file .= "PHP_FCGI_MAX_REQUESTS=" . (int) Settings::Get('system.mod_fcgid_maxrequests') . "\n";
			}
		}

		$starter_file .= "export PHP_FCGI_MAX_REQUESTS\n";

		// Set Binary
		$starter_file .= "exec " . $phpconfig['binary'] . " -c " . escapeshellarg($this->getConfigDir()) . "\n";

		// remove +i attibute, so starter can be overwritten
		if (file_exists($this->getStarterFile())) {
			\Froxlor\FileDir::removeImmutable($this->getStarterFile());
		}

		$starter_file_handler = fopen($this->getStarterFile(), 'w');
		fwrite($starter_file_handler, $starter_file);
		fclose($starter_file_handler);
		\Froxlor\FileDir::safe_exec('chmod 750 ' . escapeshellarg($this->getStarterFile()));
		\Froxlor\FileDir::safe_exec('chown ' . $this->domain['guid'] . ':' . $this->domain['guid'] . ' ' . escapeshellarg($this->getStarterFile()));
		\Froxlor\FileDir::setImmutable($this->getStarterFile());
	}

	/**
	 * create customized php.ini
	 *
	 * @param array $phpconfig
	 */
	public function createIniFile($phpconfig)
	{
		$openbasedir = '';
		$openbasedirc = ';';

		if ($this->domain['openbasedir'] == '1') {

			$openbasedirc = '';
			$_phpappendopenbasedir = '';

			$_custom_openbasedir = explode(':', Settings::Get('system.mod_fcgid_peardir'));
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
		} else {
			$openbasedir = 'none';
			$openbasedirc = ';';
		}

		$admin = $this->getAdminData($this->domain['adminid']);
		$php_ini_variables = array(
			'SAFE_MODE' => 'Off', // keep this for compatibility, just in case
			'PEAR_DIR' => Settings::Get('system.mod_fcgid_peardir'),
			'TMP_DIR' => $this->getTempDir(),
			'CUSTOMER_EMAIL' => $this->domain['email'],
			'ADMIN_EMAIL' => $admin['email'],
			'DOMAIN' => $this->domain['domain'],
			'CUSTOMER' => $this->domain['loginname'],
			'ADMIN' => $admin['loginname'],
			'OPEN_BASEDIR' => $openbasedir,
			'OPEN_BASEDIR_C' => $openbasedirc,
			'OPEN_BASEDIR_GLOBAL' => Settings::Get('system.phpappendopenbasedir'),
			'DOCUMENT_ROOT' => \Froxlor\FileDir::makeCorrectDir($this->domain['documentroot']),
			'CUSTOMER_HOMEDIR' => \Froxlor\FileDir::makeCorrectDir($this->domain['customerroot'])
		);

		// insert a small header for the file
		$phpini_file = ";\n";
		$phpini_file .= "; php.ini created/changed on " . date("Y.m.d H:i:s") . " for domain '" . $this->domain['domain'] . "' with id #" . $this->domain['id'] . " from php template '" . $phpconfig['description'] . "' with id #" . $phpconfig['id'] . "\n";
		$phpini_file .= "; Do not change anything in this file, it will be overwritten by the Froxlor Cronjob!\n";
		$phpini_file .= ";\n\n";
		$phpini_file .= \Froxlor\PhpHelper::replaceVariables($phpconfig['phpsettings'], $php_ini_variables);
		$phpini_file = str_replace('"none"', 'none', $phpini_file);
		// $phpini_file = preg_replace('/\"+/', '"', $phpini_file);
		$phpini_file_handler = fopen($this->getIniFile(), 'w');
		fwrite($phpini_file_handler, $phpini_file);
		fclose($phpini_file_handler);
		\Froxlor\FileDir::safe_exec('chown root:0 ' . escapeshellarg($this->getIniFile()));
		\Froxlor\FileDir::safe_exec('chmod 0644 ' . escapeshellarg($this->getIniFile()));
	}

	/**
	 * fcgid-config directory
	 *
	 * @param boolean $createifnotexists
	 *        	create the directory if it does not exist
	 *        	
	 * @return string the directory
	 */
	public function getConfigDir($createifnotexists = true)
	{
		$configdir = \Froxlor\FileDir::makeCorrectDir(Settings::Get('system.mod_fcgid_configdir') . '/' . $this->domain['loginname'] . '/' . $this->domain['domain'] . '/');

		if (! is_dir($configdir) && $createifnotexists) {
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($configdir));
			\Froxlor\FileDir::safe_exec('chown ' . $this->domain['guid'] . ':' . $this->domain['guid'] . ' ' . escapeshellarg($configdir));
		}

		return $configdir;
	}

	/**
	 * fcgid-temp directory
	 *
	 * @param boolean $createifnotexists
	 *        	create the directory if it does not exist
	 *        	
	 * @return string the directory
	 */
	public function getTempDir($createifnotexists = true)
	{
		$tmpdir = \Froxlor\FileDir::makeCorrectDir(Settings::Get('system.mod_fcgid_tmpdir') . '/' . $this->domain['loginname'] . '/');

		if (! is_dir($tmpdir) && $createifnotexists) {
			\Froxlor\FileDir::safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
			\Froxlor\FileDir::safe_exec('chown -R ' . $this->domain['guid'] . ':' . $this->domain['guid'] . ' ' . escapeshellarg($tmpdir));
			\Froxlor\FileDir::safe_exec('chmod 0750 ' . escapeshellarg($tmpdir));
		}

		return $tmpdir;
	}

	/**
	 * return path of php-starter file
	 *
	 * @return string the directory
	 */
	public function getStarterFile()
	{
		$starter_filename = \Froxlor\FileDir::makeCorrectFile($this->getConfigDir() . '/php-fcgi-starter');
		return $starter_filename;
	}

	/**
	 * return path of php.ini file
	 *
	 * @return string full with path file-name
	 */
	public function getIniFile()
	{
		$phpini_filename = \Froxlor\FileDir::makeCorrectFile($this->getConfigDir() . '/php.ini');
		return $phpini_filename;
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
