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
 * Logger - File-Logger-Class
 */

class FileLogger extends AbstractLogger
{
	/**
	 * Userinfo
	 * @var array
	 */

	private $userinfo = array();

	/** 
	 * Logfile
	 * @var logfile
	 */

	private $logfile = null;

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
		$this->setLogFile($settings['logger']['logfile']);
	}

	/**
	 * Singleton ftw ;-)
	 *
	 */

	static public function getInstanceOf($_usernfo, $_settings)
	{
		if(!isset(self::$loggers[$_usernfo['loginname']]))
		{
			self::$loggers[$_usernfo['loginname']] = new FileLogger($_usernfo, $_settings);
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

			$_type = 'unknown';

			switch($type)
			{
				case LOG_INFO:
					$_type = 'information';
					break;
				case LOG_NOTICE:
					$_type = 'notice';
					break;
				case LOG_WARNING:
					$_type = 'warning';
					break;
				case LOG_ERR:
					$_type = 'error';
					break;
				case LOG_CRIT:
					$_type = 'critical';
					break;
				default:
					$_type = 'unknown';
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

			$fp = @fopen($this->logfile, 'a');

			if($fp !== false)
			{
				$now = time();

				if($text != null
				   && $text != '')
				{
					fwrite($fp, date("d.m.Y H:i:s", $now) . " [" . $_type . "] [" . $_action . "-action" . $name . "] " . $text . "\n");
				}
				else
				{
					fwrite($fp, date("d.m.Y H:i:s", $now) . " [" . $_type . "] [" . $_action . "-action" . $name . "] No text given!!! Check scripts!\n");
				}

				fclose($fp);
			}
			else
			{
				if($this->logfile != null
				   || $this->logfile != '')
				{
					throw new Exception("Cannot open logfile '" . $this->logfile . "' for writing!");
				}
			}
		}
	}

	public function setLogFile($filename = null)
	{
		if($filename != null
		   && $filename != ''
		   && $filename != "."
		   && $filename != ".."
		   && !is_dir($filename))
		{
			$this->logfile = $filename;
			return true;
		}

		return false;
	}
}

?>
