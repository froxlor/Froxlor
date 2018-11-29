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
 * Logger - Froxlor-Base-Logger-Class
 */

class FroxlorLogger {

	/**
	 * Userinfo
	 * @var array
	 */
	private $userinfo = array();

	/**
	 * LogTypes Array
	 * @var array
	 */
	static private $logtypes = null;

	/**
	 * Logger-Object-Array
	 * @var FroxlorLogger[]
	 */
	static private $loggers = null;

	/**
	 * whether to output log-messages to STDOUT (cron)
	 * @var bool
	 */
	static private $crondebug_flag = false;

	/**
	 * Class constructor.
	 *
	 * @param array userinfo
	 */
	protected function __construct($userinfo) {
		$this->userinfo = $userinfo;
		self::$logtypes = array();

		if ((Settings::Get('logger.logtypes') == null || Settings::Get('logger.logtypes') == '')
		   && (Settings::Get('logger.enabled') !== null && Settings::Get('logger.enabled'))
		) {
			self::$logtypes[0] = 'syslog';
			self::$logtypes[1] = 'mysql';
		}  else {
			if (Settings::Get('logger.logtypes') !== null
			   && Settings::Get('logger.logtypes') != ''
			) {
				self::$logtypes = explode(',', Settings::Get('logger.logtypes'));
			} else {
				self::$logtypes = null;
			}
		}
	}

	/**
	 * Singleton ftw ;-)
	 *
	 */
	static public function getInstanceOf($_usernfo) {

		if (!isset($_usernfo)
		   || $_usernfo == null
		) {
			$_usernfo = array();
			$_usernfo['loginname'] = 'unknown';
		}

		if (!isset(self::$loggers[$_usernfo['loginname']])) {
			self::$loggers[$_usernfo['loginname']] = new FroxlorLogger($_usernfo);
		}

		return self::$loggers[$_usernfo['loginname']];
	}

	/**
	 * logs a given text to all enabled logger-facilities
	 *
	 * @param int $action
	 * @param int $type
	 * @param string $text
	 */
	public function logAction ($action = USR_ACTION, $type = LOG_NOTICE, $text = null) {

		if (self::$logtypes == null) {
			return;
		}

		if (self::$crondebug_flag
			|| ($action == CRON_ACTION && $type <= LOG_WARNING)) {
			echo "[".getLogLevelDesc($type)."] ".$text.PHP_EOL;
		}

		if (Settings::Get('logger.log_cron') == '0'
			&& $action == CRON_ACTION
			&& $type > LOG_WARNING // warnings, errors and critical mesages WILL be logged
		) {
			return;
		}

		foreach (self::$logtypes as $logger) {

			switch ($logger)
			{
				case 'syslog':
					$_log = SysLogger::getInstanceOf($this->userinfo);
					break;
				case 'file':
					try
					{
						$_log = FileLogger::getInstanceOf($this->userinfo);
					}
					catch(Exception $e)
					{
						if ($action != CRON_ACTION) {
							standard_error('logerror', $e->getMessage());
						} else {
							echo "Log-Error: " . $e->getMessage();
						}
					}
					break;
				case 'mysql':
					$_log = MysqlLogger::getInstanceOf($this->userinfo);
					break;
				default:
					$_log = null;
					break;
			}

			if ($_log != null) {
				try {
					$_log->logAction($action, $type, $text);
				} catch(Exception $e) {
					if ($action != CRON_ACTION) {
						standard_error('logerror', $e->getMessage());
					} else {
						echo "Log-Error: " . $e->getMessage();
					}
				}
			}
		}
	}

	/**
	 * Set whether to log cron-runs
	 *
	 * @param bool $_cronlog
	 *
	 * @return boolean
	 */
	public function setCronLog($_cronlog = 0) {

		$_cronlog = (int)$_cronlog;

		if ($_cronlog < 0 || $_cronlog > 2) {
			$_cronlog = 0;
		}
		Settings::Set('logger.log_cron', $_cronlog);
		return $_cronlog;
	}

	/**
	 * setter for crondebug-flag
	 *
	 * @param bool $_flag
	 *
	 * @return void
	 */
	public function setCronDebugFlag($_flag = false) {
	    self::$crondebug_flag = (bool)$_flag;
	}
}
