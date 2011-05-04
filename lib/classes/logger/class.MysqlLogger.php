<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
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
 * @package    Logger
 *
 * @link       http://www.nutime.de/
 * 
 * Logger - MySQL-Logger-Class
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
