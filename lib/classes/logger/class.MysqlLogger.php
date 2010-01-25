<?php

/**
 * Logger - MySQL-Logger-Class
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
 * @version    CVS: $Id$
 * @link       http://www.nutime.de/
 */

class MysqlLogger extends AbstractLogger
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
	 * Syslogger Objects Array
	 * @var loggers
	 */

	static private $loggers = array();

	/**
	 * Class constructor.
	 *
	 * @param array userinfo
	 * @param array settings
	 * @param resource database
	 */

	protected function __construct($userinfo, $settings, $db)
	{
		parent::setupLogger($settings);
		$this->userinfo = $userinfo;
		$this->db = $db;
	}

	/**
	 * Singleton ftw ;-)
	 *
	 */

	static public function getInstanceOf($_usernfo, $_settings, $_db)
	{
		if(!isset(self::$loggers[$_usernfo['loginname']]))
		{
			self::$loggers[$_usernfo['loginname']] = new MysqlLogger($_usernfo, $_settings, $_db);
		}

		return self::$loggers[$_usernfo['loginname']];
	}

	public function logAction($action = USR_ACTION, $type = LOG_NOTICE, $text = null)
	{
		if(parent::isEnabled())
		{
			if(parent::getSeverity() <= 1
			   && $type == LOG_NOTICE)
			{
				return;
			}

			if(!isset($this->userinfo['loginname'])
			   || $this->userinfo['loginname'] == '')
			{
				$name = 'unknown';
			}
			else
			{
				$name = " (" . $this->userinfo['loginname'] . ")";
			}

			$now = time();

			if($text != null
			   && $text != '')
			{
				$this->db->query("INSERT INTO `panel_syslog` (`type`, `date`, `action`, `user`, `text`)
                          VALUES ('" . (int)$type . "', '" . $now . "', '" . (int)$action . "', '" . $this->db->escape($name) . "', '" . $this->db->escape($text) . "')");
			}
			else
			{
				$this->db->query("INSERT INTO `panel_syslog` (`type`, `date`, `action`, `userid`, `text`)
                          VALUES ('" . (int)$type . "', '" . $now . "', '" . (int)$action . "', '" . $this->db->escape($name) . "', 'No text given!!! Check scripts!')");
			}
		}
	}
}

?>
