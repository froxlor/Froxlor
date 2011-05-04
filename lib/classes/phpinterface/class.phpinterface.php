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

class phpinterface
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
	 * Interface object
	 * @var object
	 */
	private $_interface = null;

	/**
	 * Admin-User data array
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
		$this->_setInterface();
	}

	/**
	 * returns the interface-object
	 * from where we can control it
	 */
	public function getInterface()
	{
		return $this->_interface;
	}
	
	/**
	 * set interface-object by type of
	 * php-interface: fcgid or php-fpm
	 * sets private $_interface variable
	 */
	private function _setInterface()
	{
		// php-fpm
		if((int)$this->_settings['phpfpm']['enabled'] == 1)
		{
			$this->_interface = new phpinterface_fpm($this->_db, $this->_settings, $this->_domain);
		}
		elseif((int)$this->_settings['system']['mod_fcgid'] == 1)
		{
			$this->_interface = new phpinterface_fcgid($this->_db, $this->_settings, $this->_domain);
		}
	}

	/**
	 * return the php-configuration from the database
	 * 
	 * @param int $php_config_id id of the php-configuration
	 * 
	 * @return array
	 */
	public function getPhpConfig($php_config_id)
	{
		$php_config_id = intval($php_config_id);

		// If domain has no config, we will use the default one.

		if($php_config_id == 0)
		{
			$php_config_id = 1;
		}

		if(!isset($this->php_configs_cache[$php_config_id]))
		{
			$this->_php_configs_cache[$php_config_id] = $this->_db->query_first(
				"SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` 
				WHERE `id` = " . (int)$php_config_id
			);
		}

		return $this->_php_configs_cache[$php_config_id];
	}

}
