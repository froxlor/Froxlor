<?php

/**
 * Logger - Froxlor-Logger Class
 *
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. This program is distributed in the
 * hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @license    http://www.gnu.org/licenses/gpl.txt
 * @package    Functions
 * @version    CVS: $Id: class.froxlorLogger.php 2724 2009-06-07 14:18:02Z flo $
 * @link       http://www.nutime.de/
 */

class FroxlorLogger
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
	 * Settings array
	 * @var settings
	 */

	private $settings = array();

	/**
	 * LogTypes Array
	 * @var logtypes
	 */

	static private $logtypes = null;

	/**
	 * Logger-Object-Array
	 * @var loggers
	 */

	static private $loggers = null;

	/**
	 * Class constructor.
	 *
	 * @param array userinfo
	 * @param array settings
	 */

	protected function __construct($userinfo, $db, $settings)
	{
		$this->userinfo = $userinfo;
		$this->db = $db;
		$this->settings = $settings;
		self::$logtypes = array();

		if(!isset($this->settings['logger']['logtypes'])
		   && (!isset($this->settings['logger']['logtypes']) || $this->settings['logger']['logtypes'] == '')
		   && isset($this->settings['logger']['enabled'])
		   && $this->settings['logger']['enabled'])
		{
			self::$logtypes[0] = 'syslog';
			self::$logtypes[1] = 'mysql';
		}
		else
		{
			if(isset($this->settings['logger']['logtypes'])
			   && $this->settings['logger']['logtypes'] != '')
			{
				self::$logtypes = explode(',', $this->settings['logger']['logtypes']);
			}
			else
			{
				self::$logtypes = null;
			}
		}
	}

	/**
	 * Singleton ftw ;-)
	 *
	 */

	static public function getInstanceOf($_usernfo, $_db, $_settings)
	{
		if(!isset($_usernfo)
		   || $_usernfo == null)
		{
			$_usernfo = array();
			$_usernfo['loginname'] = 'unknown';
		}

		if(!isset(self::$loggers[$_usernfo['loginname']]))
		{
			self::$loggers[$_usernfo['loginname']] = new FroxlorLogger($_usernfo, $_db, $_settings);
		}

		return self::$loggers[$_usernfo['loginname']];
	}

	public function logAction($action = USR_ACTION, $type = LOG_NOTICE, $text = null)
	{
		if(self::$logtypes == null)
		{
			return;
		}

		if($this->settings['logger']['log_cron'] == '0'
		   && $action == CRON_ACTION)
		{
			return;
		}

		foreach(self::$logtypes as $logger)
		{
			switch($logger)
			{
				case 'syslog':
					$_log = SysLogger::getInstanceOf($this->userinfo, $this->settings);
					break;
				case 'file':
					try
					{
						$_log = FileLogger::getInstanceOf($this->userinfo, $this->settings);
					}

					catch(Exception $e)
					{
						if($action != CRON_ACTION)
						{
							standard_error('logerror', $e->getMessage());
						}
						else
						{
							echo "Log-Error: " . $e->getMessage();
						}
					}

					break;
				case 'mysql':
					$_log = MysqlLogger::getInstanceOf($this->userinfo, $this->settings, $this->db);
					break;
				default:
					$_log = null;
					break;
			}

			if($_log != null)
			{
				try
				{
					$_log->logAction($action, $type, $text);
				}

				catch(Exception $e)
				{
					if($action != CRON_ACTION)
					{
						standard_error('logerror', $e->getMessage());
					}
					else
					{
						echo "Log-Error: " . $e->getMessage();
					}
				}
			}
		}
	}

	public function setCronLog($_cronlog = 0)
	{
		$_cronlog = (int)$_cronlog;

		if($_cronlog != 0
		   && $_cronlog != 1)
		{
			$_cronlog = 0;
		}

		$this->db->query("UPDATE `" . TABLE_PANEL_SETTINGS . "` 
				  SET `value`='" . $this->db->escape($_cronlog) . "' 
				  WHERE `settinggroup`='logger' 
				  AND `varname`='log_cron'");
		return true;
	}
}

?>
