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
 * @link       http://www.nutime.de/
 * @since      0.9.17-svn2
 *
 */

class docrootsettings
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
	 * main constructor
	 */
	public function __construct($db, $settings)
	{
		$this->_db = $db;
		$this->_settings = $settings;
	}

	/**
	 * this function lets you add docroot-settings for a given domain (by ID)
	 * 
	 * @param int    $domainid  id of the domain to add the settings for
	 * @param string $ssettings docrootsettings to add for the domain
	 * 
	 * @return boolean
	 */
	public function addDomainDocrootsettings($domainid = 0, $ssettings = '')
	{
		return $this->_addDocrootSetting(TABLE_PANEL_DOMDOCROOTSETTINGS, $domainid, $ssettings);
	}

	/**
	 * this function lets you update docroot-settings for a given domain (by ID)
	 * 
	 * @param int    $domainid  id of the domain to update the settings from
	 * @param string $ssettings docrootsettings to update for the domain
	 * 
	 * @return boolean
	 */
	public function updateDomainDocrootsettings($domainid = 0, $ssettings = '')
	{
		return $this->_updateDocrootSetting(TABLE_PANEL_DOMDOCROOTSETTINGS, $domainid, $ssettings);
	}

	/**
	 * this function lets you add docroot-settings for a given ip/port combo (by ID)
	 * 
	 * @param int    $ipandportid id of the domain to add the settings for
	 * @param string $ssettings   docrootsettings to add for the domain
	 * 
	 * @return boolean
	 */
	public function addIpsAndPortsDocrootsettings($ipandportid = 0, $ssettings = '')
	{
		return $this->_addDocrootSetting(TABLE_PANEL_IPDOCROOTSETTINGS, $ipandportid, $ssettings);
	}

	/**
	 * this function lets you update docroot-settings for a given ip/port combo (by ID)
	 * 
	 * @param int    $ipandportid id of the domain to update the settings from
	 * @param string $ssettings   docrootsettings to update for the domain
	 * 
	 * @return boolean
	 */
	public function updateIpsAndPortsDocrootsettings($ipandportid = 0, $ssettings = '')
	{
		return $this->_updateDocrootSetting(TABLE_PANEL_IPDOCROOTSETTINGS, $ipandportid, $ssettings);
	}

	/**
	 * returns the docroot-setting
	 * for a given domain (by ID)
	 * 
	 * @param int $domainid the id of the domain
	 * 
	 * @return string the settings or empty if not set
	 */
	public function getDomainDocrootsettings($domainid = 0)
	{
		return $this->_getDocrootSettingById(TABLE_PANEL_DOMDOCROOTSETTINGS, $domainid);
	}

	/**
	 * returns the docroot-setting
	 * for a given ip/port combination (by ID)
	 * 
	 * @param int $ipandportid the id of the ip/port combo
	 * 
	 * @return string the settings or empty if not set
	 */
	public function getIpsAndPortsDocrootsettings($ipandportid = 0)
	{
		return $this->_getDocrootSettingById(TABLE_PANEL_IPDOCROOTSETTINGS, $ipandportid);
	}

	/**
	 * this function is called by addDomainDocrootsettings() and
	 * addIpsAndPortsDocrootsettings() to add docroot settings for an object
	 * 
	 * @param string $table     table to add the settings to
	 * @param int    $fid       foreign id / object id
	 * @param string $ssettings docroot-settings
	 * 
	 * @return boolean
	 */
	private function _addDocrootSetting($table, $fid, $ssettings)
	{
		$query = "INSERT INTO `".$table."` SET
			`fid` = '".(int)$fid."',
			`docrootsettings` = '".$db->escape($ssettings)."';";
		$this->_db->query($query);
		return true;
	}

	/**
	 * this function is called by updateDomainDocrootsettings() and
	 * updateIpsAndPortsDocrootsettings() to update docroot settings for an object
	 * 
	 * if new value is an empty string, entry is being removed
	 * 
	 * @param string $table     table to update the settings from
	 * @param int    $fid       foreign id / object id
	 * @param string $ssettings docroot-settings
	 * 
	 * @return boolean
	 */
	private function _updateDocrootSetting($table, $fid, $ssettings)
	{
		// check if this object has an entry for docrootsettings
		if($this->_getDocrootSettingById($table, $fid) != '')
		{
			if($ssettings != '')
			{
				// update if new value has been set
				$query = "UPDATE `".$table."` SET
					`docrootsettings` = '".$db->escape($ssettings)."' 
					WHERE `fid` = '".(int)$fid."';";
			}
			else
			{
				// remove if new value is empty
				$query = "DELETE FROM `".$table."` WHERE `fid` = '".(int)$fid."';";
			}
			// run query
			$this->_db->query($query);
			return true;
		}
		// this object has no entry for docrootsettings yet
		return false;
	}

	/**
	 * read the docrootsetting field of given table
	 * for given id
	 * 
	 * @param string $table table where to read from
	 * @param int    $id    id of the object
	 * 
	 * @return string string the settings or empty if not set
	 */
	private function _getDocrootSettingById($table = null, $id = 0)
	{
		$query = "SELECT `docrootsettings` FROM `".$table."` WHERE `fid`='".(int)$id."';";
		$result = $this->_db->query_first($query);
		if($result !== false && isset($result['docrootsettings']))
		{
			return $result['docrootsettings'];
		}
		return '';
	}
}
