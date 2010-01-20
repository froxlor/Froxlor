<?php

/**
 * Logger - Abstract-Logger-Class
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
 * @version    CVS: $Id: abstract.AbstractLogger.php 2724 2009-06-07 14:18:02Z flo $
 * @link       http://www.nutime.de/
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

abstract class AbstractLogger
{
	/**
	 * Settings array
	 * @var settings
	 */

	private $settings = array();

	/** 
	 * Enable/Disable Logging
	 * @var logenabled
	 */

	private $logenabled = false;

	/** 
	 * Enable/Disable Cronjob-Logging
	 * @var logcronjob
	 */

	private $logcronjob = false;

	/** 
	 * Loggin-Severity
	 * @var severity
	 */

	private $severity = 1;

	// normal

	/**
	 * setup the main logger
	 *
	 * @param array settings
	 */

	protected function setupLogger($settings)
	{
		$this->settings = $settings;
		$this->logenabled = $this->settings['logger']['enabled'];
		$this->logcronjob = $this->settings['logger']['log_cron'];
		$this->severity = $this->settings['logger']['severity'];
	}

	protected function isEnabled()
	{
		return $this->logenabled;
	}

	protected function getSeverity()
	{
		return $this->severity;
	}

	protected function logCron()
	{
		return $this->logcronjob;
	}

	abstract public function logAction();
}

?>