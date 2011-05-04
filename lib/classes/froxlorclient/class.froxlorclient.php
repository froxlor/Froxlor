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
 * @package    Multiserver
 *
 * @link       http://www.nutime.de/
 * @since      0.9.14-svn8
 *
 * Multiserver - FroxlorClient-Class
 */

class froxlorclient
{
	/**
	 * Userinfo
	 * @var array
	 */
	private $userinfo = array();

	/**
	 * Database handler
	 * @var db
	 */
	private $db = false;

	/**
	 * Client ID
	 * @var cid
	 */
	private $cid = -1;

	/**
	 * Client Data Array
	 * @var c_data
	 */
	private $c_data = array();

	/**
	 * Client Settings_Data Array
	 * @var s_data
	 */
	private $s_data = array();

	/**
	 * Client-Object-Array
	 * @var clients
	 */
	static private $clients = array();

	/**
	 * Class constructor.
	 *
	 * @param array    $userinfo userdetails array of logged in user
	 * @param resource $db       database-object
	 * @param int      $cid      client-id
	 */
	private function __construct($userinfo, $db, $cid = -1)
	{
		$this->userinfo = $userinfo;
		$this->db = $db;
		$this->cid = $cid;

		// read data from database
		$this->_readData();
	}

	/**
	 * static function to initialize the class using
	 * singleton design pattern
	 * 
	 * @param array    $_usernfo  userdetails array of logged in user
	 * @param resource $_db       database-object
	 * @param int      $_cid      client-id
	 */
	static public function getInstance($_usernfo, $_db, $_cid)
	{
		if(!isset(self::$clients[$_cid]))
		{
			self::$clients[$_cid] = new froxlorclient($_usernfo, $_db, $_cid);
		}

		return self::$clients[$_cid];
	}

	/**
	 * return an array of enabled froxlor-client ids
	 * 
	 * @param resource mysql-object
	 * 
	 * @return array
	 */
	static public function getFroxlorClients($_db = null)
	{
		$sql = "SELECT `id` FROM `".TABLE_FROXLOR_CLIENTS."` WHERE `enabled` = '1';";
		$res = $_db->query($sql);
		$result = array();
		while($_r = mysql_fetch_array($res))
		{
			$result[] = $_r['id'];
		}
		return $result;
	}

	/**
	 * Insert new client to database
	 */
	public function Insert()
	{
		$this->db->query("INSERT INTO  
			`" . TABLE_FROXLOR_CLIENTS . "` 
		SET
			`name` = '" . $this->db->escape($this->Get('name')) . "',  
			`desc` = '" . $this->db->escape($this->Get('desc')) . "', 
			`enabled` = '" . (int)$this->Get('enabled') . "';
		");
		$this->cid = $this->db->insert_id();
		return $this->cid;
	}

	/**
	 * Update data in database
	 */
	public function Update()
	{
		$this->db->query("UPDATE 
			`" . TABLE_FROXLOR_CLIENTS . "` 
		SET
			`name` = '" . $this->db->escape($this->Get('name')) . "',  
			`desc` = '" . $this->db->escape($this->Get('desc')) . "', 
			`enabled` = '" . (int)$this->Get('enabled') . "'
		WHERE 
			`id` = '" . (int)$this->cid . "';
		");
		return true;
	}

	/**
	 * This function removes a Froxlor-Client and its settings
	 * from the database. Optionally the Froxlor-Client data
	 * can be removed by setting the $delete_me parameter
	 * 
	 * @param bool $delete_me removes client-data (not customer data) on the client
	 * 
	 * @return bool
	 * 
	 * @TODO 
	 * - remove client settings in panel_settings (sid = client-id)
	 * - implement $delete_me parameter
	 */
	public function Delete($delete_me = false)
	{
		// delete froxlor-client from the database
		$this->db->query('DELETE FROM 
			`' . TABLE_FROXLOR_CLIENTS . '` 
		WHERE 
			`id` = "' . (int)$this->cid . '";
		');

		// Delete settings from panel_settings
		$this->db->query('DELETE FROM 
			`' . TABLE_PANEL_SETTINGS . '` 
		WHERE 
			`sid` = "' . (int)$this->cid . '";
		');

		return true;
	}

	/**
	 * return the complete client-settings array
	 * for the settings page
	 */
	public function getSettingsArray()
	{
		return $this->Get('settings');
	}

	/**
	 * get a value from the internal data array
	 * 
	 * @param string $_var
	 * @param string $_vartrusted
	 * 
	 * @return mixed or null if not found
	 */
	public function Get($_var = '', $_vartrusted = false)
	{
		if($_var != '')
		{
			if(!$_vartrusted)
			{
				$_var = htmlspecialchars($_var);
			}

			if(isset($this->c_data[$_var]))
			{
				return $this->c_data[$_var];
			}
			else
			{
				return null;
			}
		}
	}

	/**
	 * set a value in the internal data array
	 * 
	 * @param string $_var
	 * @param string $_value
	 * @param bool   $_vartrusted
	 * @param bool   $_valuetrusted
	 */
	public function Set($_var = '', $_value = '', $_vartrusted = false, $_valuetrusted = false)
	{
		if($_var != ''
			&& $_value != ''
		) {
			if(!$_vartrusted)
			{
				$_var = htmlspecialchars($_var);
			}

			if(!$_valuetrusted)
			{
				$_value = htmlspecialchars($_value);
			}

			$this->c_data[$_var] = $_value;
		}
	}

	/**
	 * get a value from the internal settings array
	 *
	 * @param string $_grp
	 * @param string $_var
	 * @param bool   $_grptrusted
	 * @param bool   $_vartrusted
	 * 
	 * @return mixed or null if not found
	 */
	public function getSetting($_grp = '', $_var = '', $_grptrusted = false, $_vartrusted = false)
	{
		if($_grp != ''
			&& $_var != ''
		) {

			if(!$_grptrusted)
			{
				$_grp = htmlspecialchars($_grp);
			}

			if(!$_vartrusted)
			{
				$_var = htmlspecialchars($_var);
			}

			if(isset($this->c_data['settings'][$_grp][$_var]))
			{
				return $this->c_data['settings'][$_grp][$_var];
			}
			else
			{
				return null;
			}
		}
	}

	/**
	 * set a value in the internal settings array
	 *
	 * @param string $_grp
	 * @param string $_var
	 * @param string $_value
	 * @param bool   $_grptrusted
	 * @param bool   $_vartrusted
	 * @param bool   $_valuetrusted
	 */
	public function setSetting($_grp = '', $_var = '', $_value = '', $_grptrusted = false, $_vartrusted = false, $_valuetrusted = false)
	{
		if($_grp != ''
			&& $_var != ''
			&& $_value != ''
		) {
			if(!$_grptrusted)
			{
				$_grp = htmlspecialchars($_grp);
			}

			if(!$_vartrusted)
			{
				$_var = htmlspecialchars($_var);
			}

			if(!$_valuetrusted)
			{
				$_value = htmlspecialchars($_value);
			}

			if(!isset($this->c_data['settings']) || !is_array($this->c_data['settings'])) {
				$this->c_data['settings'] = array();
			}

			if(!isset($this->c_data['settings'][$_grp]) || !is_array($this->c_data['settings'][$_grp])) {
				$this->c_data['settings'][$_grp] = array();
			}

			$this->c_data['settings'][$_grp][$_var] = $_value;
		}
	}

	/**
	 * read client settings from database
	 */
	private function _readSettings()
	{
		if(isset($this->cid)
			&& $this->cid != - 1
		) {
			$spath = makeCorrectDir(dirname(dirname(dirname(dirname(__FILE__)))));
			$this->s_data = loadConfigArrayDir(
								makeCorrectDir($spath.'/actions/admin/settings/'),
								makeCorrectDir($spath.'/actions/multiserver/clientsettings/')
							);
			$settings = loadSettings($this->s_data, $this->db, $this->cid);

			foreach($settings as $group => $fv)
			{
				foreach($fv as $field => $value)
				{
					$this->setSetting($group, $field, $value, true, true, true);					
				}
			}
		}
	}

	/**
	 * Read client data from database.
	 */
	private function _readData()
	{
		if(isset($this->cid)
			&& $this->cid != - 1
		) {
			$_client = $this->db->query_first('SELECT * FROM `' . TABLE_FROXLOR_CLIENTS . '` WHERE `id` = "' . $this->cid . '"');

			foreach($_client as $field => $value)
			{
				$this->Set($field, $value, true, true);
			}

			// after we have details about the client, 
			// we need its settings too
			$this->_readSettings();
		}
	}
}
