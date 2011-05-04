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

class phpinterface_fcgid
{
	/**
	 * Database handler
	 * @var object
	 */
	private $_db = false;

	/**
	 * Settings array
	 * @var array
	 */
	private $_settings = array();

	/**
	 * Domain-Data array
	 * @var array
	 */
	private $_domain = array();

	/**
	 * Admin-Date cache array
	 * @var array
	 */
	private $_admin_cache = array();

	/**
	 * main constructor
	 */
	public function __construct($db, $settings, $domain)
	{
		$this->_db = $db;
		$this->_settings = $settings;
		$this->_domain = $domain;
	}

	public function createConfig($phpconfig)
	{
		// create starter
		$starter_file = "#!/bin/sh\n\n";
		$starter_file.= "#\n";
		$starter_file.= "# starter created/changed on " . date("Y.m.d H:i:s") . " for domain '" . $this->_domain['domain'] . "' with id #" . $this->_domain['id'] . " from php template '" . $phpconfig['description'] . "' with id #" . $phpconfig['id'] . "\n";
		$starter_file.= "# Do not change anything in this file, it will be overwritten by the Froxlor Cronjob!\n";
		$starter_file.= "#\n\n";
		$starter_file.= "umask 022\n";
		$starter_file.= "PHPRC=" . escapeshellarg($this->getConfigDir()) . "\n";
		$starter_file.= "export PHPRC\n";

		// set number of processes for one domain
		if((int)$this->_domain['mod_fcgid_starter'] != - 1)
		{
			$starter_file.= "PHP_FCGI_CHILDREN=" . (int)$this->_domain['mod_fcgid_starter'] . "\n";
		}
		else
		{
			if((int)$phpconfig['mod_fcgid_starter'] != - 1)
			{
				$starter_file.= "PHP_FCGI_CHILDREN=" . (int)$phpconfig['mod_fcgid_starter'] . "\n";
			}
			else
			{
				$starter_file.= "PHP_FCGI_CHILDREN=" . (int)$this->_settings['system']['mod_fcgid_starter'] . "\n";
			}
		}

		$starter_file.= "export PHP_FCGI_CHILDREN\n";

		// set number of maximum requests for one domain
		if((int)$this->_domain['mod_fcgid_maxrequests'] != - 1)
		{
			$starter_file.= "PHP_FCGI_MAX_REQUESTS=" . (int)$this->_domain['mod_fcgid_maxrequests'] . "\n";
		}
		else
		{
			if((int)$phpconfig['mod_fcgid_maxrequests'] != - 1)
			{
				$starter_file.= "PHP_FCGI_MAX_REQUESTS=" . (int)$phpconfig['mod_fcgid_maxrequests'] . "\n";
			}
			else
			{
				$starter_file.= "PHP_FCGI_MAX_REQUESTS=" . (int)$this->_settings['system']['mod_fcgid_maxrequests'] . "\n";
			}
		}

		$starter_file.= "export PHP_FCGI_MAX_REQUESTS\n";

		// Set Binary
		$starter_file.= "exec " . $phpconfig['binary'] . " -c " . escapeshellarg($this->getConfigDir()) . "\n";

		//remove +i attibute, so starter can be overwritten
		if(file_exists($this->getStarterFile()))
		{
			removeImmutable($this->getStarterFile());
		}

		$starter_file_handler = fopen($this->getStarterFile(), 'w');
		fwrite($starter_file_handler, $starter_file);
		fclose($starter_file_handler);
		safe_exec('chmod 750 ' . escapeshellarg($this->getStarterFile()));
		safe_exec('chown ' . $this->_domain['guid'] . ':' . $this->_domain['guid'] . ' ' . escapeshellarg($this->getStarterFile()));
		setImmutable($this->getStarterFile());
	}

	public function createIniFile($phpconfig)
	{
		$openbasedir = '';
		$openbasedirc = ';';

		if($this->_domain['openbasedir'] == '1')
		{
			$openbasedirc = '';
			$_phpappendopenbasedir = '';

			$_custom_openbasedir = explode(':', $this->_settings['system']['mod_fcgid_peardir']);
			foreach($_custom_openbasedir as $cobd)
			{
				$_phpappendopenbasedir .= appendOpenBasedirPath($cobd);
			}

			$_custom_openbasedir = explode(':', $this->_settings['system']['phpappendopenbasedir']);
			foreach($_custom_openbasedir as $cobd)
			{
				$_phpappendopenbasedir .= appendOpenBasedirPath($cobd);
			}

			if($this->_domain['openbasedir_path'] == '0' && strstr($this->_domain['documentroot'], ":") === false)
			{
				$openbasedir = appendOpenBasedirPath($this->_domain['documentroot'], true);
			}
			else
			{
				$openbasedir = appendOpenBasedirPath($this->_domain['customerroot'], true);
			}

			$openbasedir .= appendOpenBasedirPath($this->getTempDir());
			$openbasedir .= $_phpappendopenbasedir;

			$openbasedir = explode(':', $openbasedir);
			$clean_openbasedir = array();
			foreach($openbasedir as $number => $path)
			{
				if(trim($path) != '/')
				{
					$clean_openbasedir[] = makeCorrectDir($path);
				}
			}
			$openbasedir = implode(':', $clean_openbasedir);
		}
		else
		{
			$openbasedir = 'none';
			$openbasedirc = ';';
		}

		$admin = $this->_getAdminData($this->_domain['adminid']);
		$php_ini_variables = array(
			'SAFE_MODE' => ($this->_domain['safemode'] == '0' ? 'Off' : 'On'),
			'PEAR_DIR' => $this->_settings['system']['mod_fcgid_peardir'],
			'OPEN_BASEDIR' => $openbasedir,
			'OPEN_BASEDIR_C' => $openbasedirc,
			'OPEN_BASEDIR_GLOBAL' => $this->_settings['system']['phpappendopenbasedir'],
			'TMP_DIR' => $this->getTempDir(),
			'CUSTOMER_EMAIL' => $this->_domain['email'],
			'ADMIN_EMAIL' => $admin['email'],
			'DOMAIN' => $this->_domain['domain'],
			'CUSTOMER' => $this->_domain['loginname'],
			'ADMIN' => $admin['loginname']
		);

		//insert a small header for the file

		$phpini_file = ";\n";
		$phpini_file.= "; php.ini created/changed on " . date("Y.m.d H:i:s") . " for domain '" . $this->_domain['domain'] . "' with id #" . $this->_domain['id'] . " from php template '" . $phpconfig['description'] . "' with id #" . $phpconfig['id'] . "\n";
		$phpini_file.= "; Do not change anything in this file, it will be overwritten by the Froxlor Cronjob!\n";
		$phpini_file.= ";\n\n";
		$phpini_file.= replace_variables($phpconfig['phpsettings'], $php_ini_variables);
		$phpini_file = str_replace('"none"', 'none', $phpini_file);
		$phpini_file = preg_replace('/\"+/', '"', $phpini_file);
		$phpini_file_handler = fopen($this->getIniFile(), 'w');
		fwrite($phpini_file_handler, $phpini_file);
		fclose($phpini_file_handler);
		safe_exec('chown root:0 ' . escapeshellarg($this->getIniFile()));
		safe_exec('chmod 0644 ' . escapeshellarg($this->getIniFile()));
	}

	/**
	 * fcgid-config directory
	 * 
	 * @param boolean $createifnotexists create the directory if it does not exist
	 * 
	 * @return string the directory
	 */
	public function getConfigDir($createifnotexists = true)
	{
		$configdir = makeCorrectDir($this->_settings['system']['mod_fcgid_configdir'] . '/' . $this->_domain['loginname'] . '/' . $this->_domain['domain'] . '/');

		if(!is_dir($configdir) && $createifnotexists)
		{
			safe_exec('mkdir -p ' . escapeshellarg($configdir));
			safe_exec('chown ' . $this->_domain['guid'] . ':' . $this->_domain['guid'] . ' ' . escapeshellarg($configdir));
		}

		return $configdir;
	}

	/**
	 * fcgid-temp directory
	 * 
	 * @param boolean $createifnotexists create the directory if it does not exist
	 * 
	 * @return string the directory
	 */
	public function getTempDir($createifnotexists = true)
	{
		$tmpdir = makeCorrectDir($this->_settings['system']['mod_fcgid_tmpdir'] . '/' . $this->_domain['loginname'] . '/');

		if(!is_dir($tmpdir) && $createifnotexists)
		{
			safe_exec('mkdir -p ' . escapeshellarg($tmpdir));
			safe_exec('chown -R ' . $this->_domain['guid'] . ':' . $this->_domain['guid'] . ' ' . escapeshellarg($tmpdir));
			safe_exec('chmod 0750 ' . escapeshellarg($tmpdir));
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
		$starter_filename = makeCorrectFile($this->getConfigDir() . '/php-fcgi-starter');
		return $starter_filename;
	}

	/**
	 * return path of php.ini file
	 * 
	 * @return string full with path file-name
	 */
	public function getIniFile()
	{
		$phpini_filename = makeCorrectFile($this->getConfigDir() . '/php.ini');
		return $phpini_filename;
	}

	/**
	 * return the admin-data of a specific admin
	 * 
	 * @param int $adminid id of the admin-user
	 * 
	 * @return array
	 */
	private function _getAdminData($adminid)
	{
		$adminid = intval($adminid);

		if(!isset($this->_admin_cache[$adminid]))
		{
			$this->_admin_cache[$adminid] = $this->_db->query_first(
				"SELECT `email`, `loginname` FROM `" . TABLE_PANEL_ADMINS . "` 
				WHERE `adminid` = " . (int)$adminid
			);
		}

		return $this->_admin_cache[$adminid];
	}
}
