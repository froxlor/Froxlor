<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2015 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Oskar Eisemuth
 * @author     Froxlor team <team@froxlor.org> (2015-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Logger
 *
 */

class LoggerTee {
	/**
	 * 
	 * @param AbstractLogger[] $loggers array of logger instances
	 */
	private $loggerinstances = array();
	
	private $preText;

	public function __construct($loggers) {
		$this->loggerinstances = (array)$loggers;
	}
	
	public function addLogger($logger) {
		$this->loggerinstances[] = $logger;
	}
	
	public function setPreText($text) {
		$this->preText = $text;
	}
	
	public function logAction($action = USR_ACTION, $type = LOG_NOTICE, $text = null) {
		if ($this->preText) {
			$text = $this->preText.(string)$text;
		}
		foreach ($this->loggerinstances as $loginstance) {
			$loginstance->logAction($action, $type, $text);
		}
	}
	
	public function __call($name, $arguments) {
		foreach ($this->loggerinstances as $loginstance) {
			call_user_func_array(array($loginstance, $name), $arguments);
		}
	}
}
