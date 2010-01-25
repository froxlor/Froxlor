<?php

/**
 * Logger - SysLog-Logger-Class
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

class SysLogger extends AbstractLogger
{
	/**
	 * Userinfo
	 * @var array
	 */

	private $userinfo = array();

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
	 */

	protected function __construct($userinfo, $settings)
	{
		parent::setupLogger($settings);
		$this->userinfo = $userinfo;
	}

	/**
	 * Singleton ftw ;-)
	 *
	 */

	static public function getInstanceOf($_usernfo, $_settings)
	{
		if(!isset(self::$loggers[$_usernfo['loginname']]))
		{
			self::$loggers[$_usernfo['loginname']] = new SysLogger($_usernfo, $_settings);
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

			$_action = 'unknown';

			switch($action)
			{
				case USR_ACTION:
					$_action = 'customer';
					break;
				case RES_ACTION:
					$_action = 'reseller';
					break;
				case ADM_ACTION:
					$_action = 'administrator';
					break;
				case CRON_ACTION:
					$_action = 'cronjob';
					break;
				case LOG_ERROR:
					$_action = 'internal';
					break;
				default:
					$_action = 'unknown';
					break;
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

			openlog("Froxlor", LOG_NDELAY, LOG_USER);

			if($text != null
			   && $text != '')
			{
				syslog((int)$type, "[" . ucfirst($_action) . " Action" . $name . "] " . $text);
			}
			else
			{
				syslog((int)$type, "[" . ucfirst($_action) . " Action" . $name . "] No text given!!! Check scripts!");
			}

			closelog();
		}
	}
}

?>
