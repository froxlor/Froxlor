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
 * @version    $Id$
 * @link       http://www.nutime.de/
 * @since      0.9.16
 *
 */

class phpinterface_fpm
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
		$fh = @fopen($this->getConfigFile(), 'w');
		if($fh)
		{
			$fpm_pm = $this->_settings['phpfpm']['pm'];
			$fpm_children = (int)$this->_settings['phpfpm']['max_children'];
			$fpm_start_servers = (int)$this->_settings['phpfpm']['start_servers'];
			$fpm_min_spare_servers = (int)$this->_settings['phpfpm']['min_spare_servers'];
			$fpm_max_spare_servers = (int)$this->_settings['phpfpm']['max_spare_servers'];
			$fpm_requests = (int)$this->_settings['phpfpm']['max_requests'];

			if($fpm_children == 0) {
				$fpm_children = 1;
			}

			$fpm_config = ';PHP-FPM configuration for "'.$this->_domain['domain'].'" created on ' . date("Y.m.d H:i:s") . "\n\n";
			$fpm_config.= '['.$this->_domain['domain'].']'."\n";
			$fpm_config.= 'listen = '.$this->getSocketFile()."\n";
			if($this->_domain['loginname'] == 'froxlor.panel')
			{
				$fpm_config.= 'listen.owner = '.$this->_domain['guid']."\n";
				$fpm_config.= 'listen.group = '.$this->_domain['guid']."\n";
			}
			else
			{
				$fpm_config.= 'listen.owner = '.$this->_domain['loginname']."\n";
				$fpm_config.= 'listen.group = '.$this->_domain['loginname']."\n";
			}
			$fpm_config.= 'listen.mode = 0666'."\n\n";

			if($this->_domain['loginname'] == 'froxlor.panel')
			{
				$fpm_config.= 'user = '.$this->_domain['guid']."\n";
				$fpm_config.= 'group = '.$this->_domain['guid']."\n\n";
			}
			else
			{
				$fpm_config.= 'user = '.$this->_domain['loginname']."\n";
				$fpm_config.= 'group = '.$this->_domain['loginname']."\n\n";
			}

			$fpm_config.= 'pm = '.$fpm_pm."\n";
			$fpm_config.= 'pm.max_children = '.$fpm_children."\n";
			if($fpm_pm == 'dynamic') {
				$fpm_config.= 'pm.start_servers = '.$fpm_start_servers."\n";
				$fpm_config.= 'pm.min_spare_servers = '.$fpm_min_spare_servers."\n";
				$fpm_config.= 'pm.max_spare_servers = '.$fpm_max_spare_servers."\n";
			}
			$fpm_config.= 'pm.max_requests = '.$fpm_requests."\n\n";

			$fpm_config.= ';chroot = '.makeCorrectDir($this->_domain['documentroot'])."\n\n";

			$tmpdir = makeCorrectDir($this->_settings['phpfpm']['tmpdir'] . '/' . $this->_domain['loginname'] . '/');
			//$slowlog = makeCorrectFile($this->_settings['system']['logfiles_directory'] . $this->_domain['loginname'] . '/php-fpm_slow.log');

			$fpm_config.= 'env[TMP] = '.$tmpdir."\n";
			$fpm_config.= 'env[TMPDIR] = '.$tmpdir."\n";
			$fpm_config.= 'env[TEMP] = '.$tmpdir."\n\n";

			$fpm_config.= 'php_admin_value[sendmail_path] = /usr/sbin/sendmail -t -i -f '.$this->_domain['email']."\n\n";
			if($this->_domain['loginname'] != 'froxlor.panel')
			{
				$fpm_config.= 'php_admin_value[open_basedir] = ' . $this->_settings['system']['documentroot_prefix'] . $this->_domain['loginname'] . '/:' . $this->_settings['phpfpm']['tmpdir'] . '/' . $this->_domain['loginname'] . '/:' . $this->_settings['phpfpm']['peardir'] . "\n";
			}
			$fpm_config.= 'php_admin_value[session.save_path] = ' . $this->_settings['phpfpm']['tmpdir'] . '/' . $this->_domain['loginname'] . '/' . "\n";
			$fpm_config.= 'php_admin_value[upload_tmp_dir] = ' . $this->_settings['phpfpm']['tmpdir'] . '/' . $this->_domain['loginname'] . '/' . "\n\n";

			fwrite($fh, $fpm_config, strlen($fpm_config));
			fclose($fh);
		}
	}

	public function createIniFile($phpconfig)
	{
		return;
	}

	/**
	 * fpm-config file
	 * 
	 * @param boolean $createifnotexists create the directory if it does not exist
	 * 
	 * @return string the full path to the file
	 */
	public function getConfigFile($createifnotexists = true)
	{
		$configdir = makeCorrectDir($this->_settings['phpfpm']['configdir']);
		$config = makeCorrectFile($configdir.'/'.$this->_domain['domain'].'.conf');

		if(!is_dir($configdir) && $createifnotexists)
		{
			safe_exec('mkdir -p ' . escapeshellarg($configdir));
		}

		return $config;
	}

	/**
	 * return path of fpm-socket file
	 * 
	 * @param boolean $createifnotexists create the directory if it does not exist
	 * 
	 * @return string the full path to the socket
	 */
	public function getSocketFile($createifnotexists = true)
	{
		$socketdir = makeCorrectDir('/var/run/'.$this->_settings['system']['webserver'].'/');
		$socket = makeCorrectFile($socketdir.'/'.$this->_domain['loginname'].'-'.$this->_domain['domain'].'-php-fpm.socket');

		if(!is_dir($socketdir) && $createifnotexists)
		{
			safe_exec('mkdir -p '.$socketdir);
			safe_exec('chown -R '.$this->_settings['system']['httpuser'].':'.$this->_settings['system']['httpgroup'].' '.$socketdir);
		}

		return $socket;
	}
}
