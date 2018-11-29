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

class MysqlLogger extends AbstractLogger {

	/**
	 * Userinfo
	 * @var array
	 */
	private $userinfo = array();

	/**
	 * Syslogger Objects Array
	 * @var MysqlLogger[]
	 */
	static private $loggers = array();

	/**
	 * Class constructor.
	 *
	 * @param array userinfo
	 */
	protected function __construct($userinfo) {
		parent::setupLogger();
		$this->userinfo = $userinfo;
	}

	/**
	 * Singleton ftw ;-)
	 */
	static public function getInstanceOf($_usernfo) {
		if (!isset(self::$loggers[$_usernfo['loginname']])) {
			self::$loggers[$_usernfo['loginname']] = new MysqlLogger($_usernfo);
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
	public function logAction($action = USR_ACTION, $type = LOG_NOTICE, $text = null) {

		if (parent::isEnabled()) {

			if (parent::getSeverity() <= 1
			   && $type == LOG_NOTICE
			) {
				return;
			}

			if (!isset($this->userinfo['loginname'])
			   || $this->userinfo['loginname'] == ''
			) {
				$name = 'unknown';
			} else {
				$name = $this->userinfo['loginname'];
			}

			$now = time();

			$stmt = Database::prepare("
					INSERT INTO `panel_syslog` SET
					`type` = :type,
					`date` = :now,
					`action` = :action,
					`user` = :user,
					`text` = :text"
			);

			$ins_data = array(
					'type' => $type,
					'now' => $now,
					'action' => $action,
					'user' => $name
			);

			if ($text != null
			   && $text != ''
			) {
				$ins_data['text'] = $text;
				Database::pexecute($stmt, $ins_data);
			} else {
				$ins_data['text'] = 'No text given!!! Check scripts!';
				Database::pexecute($stmt, $ins_data);
			}
		}
	}
}
