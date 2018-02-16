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
 * Logger - Abstract-Logger-Class
 */

/* We're using the syslog constants for all the loggers (partly implemented)

LOG_EMERG  	  system is unusable
LOG_ALERT 	  action must be taken immediately
LOG_CRIT 	    critical conditions
LOG_ERR 	    error conditions
LOG_WARNING 	warning conditions
LOG_NOTICE 	  normal, but significant, condition
LOG_INFO 	    informational message
LOG_DEBUG 	  debug-level message

*/

abstract class AbstractLogger {

	/** 
	 * Enable/Disable Logging
	 * @var boolean
	 */
	private $logenabled = false;

	/** 
	 * Enable/Disable Cronjob-Logging
	 * @var boolean
	 */
	private $logcronjob = false;

	/** 
	 * Loggin-Severity
	 * @var int
	 */
	private $severity = 1;

	/**
	 * setup the main logger
	 */
	protected function setupLogger() {
		$this->logenabled = Settings::Get('logger.enabled');
		$this->logcronjob = Settings::Get('logger.log_cron');
		$this->severity = Settings::Get('logger.severity');
	}

	/**
	 * return whether this logging is enabled
	 *
	 * @return bool
	 */
	protected function isEnabled() {
		return $this->logenabled;
	}

	/**
	 * return the log severity
	 *
	 * @return int
	 */
	protected function getSeverity() {
		return $this->severity;
	}

	/**
	 * whether to log cron-runs or not
	 *
	 * @return bool
	 */
	protected function logCron() {
		return $this->logcronjob;
	}

	/**
	 * logs a given text
	 */
	abstract public function logAction();

}
