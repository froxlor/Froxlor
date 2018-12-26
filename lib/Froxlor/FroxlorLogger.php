<?php
namespace Froxlor;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogHandler;
use Froxlor\System\MysqlHandler;

/**
 * Class FroxlorLogger
 */
class FroxlorLogger
{

	/**
	 * current \Monolog\Logger object
	 *
	 * @var \Monolog\Logger
	 */
	private static $ml = null;

	/**
	 * LogTypes Array
	 *
	 * @var array
	 */
	private static $logtypes = null;

	/**
	 * whether to output log-messages to STDOUT (cron)
	 *
	 * @var bool
	 */
	private static $crondebug_flag = false;

	/**
	 * user info of logged in user
	 *
	 * @var array
	 */
	private static $userinfo = array();

	const USR_ACTION = '10';

	const RES_ACTION = '20';

	const ADM_ACTION = '30';

	const CRON_ACTION = '40';

	const LOGIN_ACTION = '50';

	const LOG_ERROR = '99';

	/**
	 * Class constructor.
	 */
	protected function __construct($userinfo = array())
	{
		$this->initMonolog();
		self::$userinfo = $userinfo;
		self::$logtypes = array();

		if ((Settings::Get('logger.logtypes') == null || Settings::Get('logger.logtypes') == '') && (Settings::Get('logger.enabled') !== null && Settings::Get('logger.enabled'))) {
			self::$logtypes[0] = 'syslog';
			self::$logtypes[1] = 'mysql';
		} else {
			if (Settings::Get('logger.logtypes') !== null && Settings::Get('logger.logtypes') != '') {
				self::$logtypes = explode(',', Settings::Get('logger.logtypes'));
			} else {
				self::$logtypes = null;
			}
		}

		foreach (self::$logtypes as $logger) {

			switch ($logger) {
				case 'syslog':
					self::$ml->pushHandler(new SyslogHandler('froxlor', LOG_USER, Logger::DEBUG));
					break;
				case 'file':
					self::$ml->pushHandler(new StreamHandler(Settings::Get('logger.logfile'), Logger::DEBUG));
					break;
				case 'mysql':
					self::$ml->pushHandler(new MysqlHandler(Logger::DEBUG));
					break;
			}
		}
	}

	/**
	 * return FroxlorLogger instance
	 *
	 * @param array $userinfo
	 *
	 * @return FroxlorLogger
	 */
	public static function getInstanceOf($userinfo = array())
	{
		if (empty($userinfo)) {
			$userinfo = array(
				'loginname' => 'system'
			);
		}
		return new FroxlorLogger($userinfo);
	}

	/**
	 * initiate monolog object
	 *
	 * @return \Monolog\Logger
	 */
	private function initMonolog()
	{
		if (empty(self::$ml)) {
			// get Theme object
			self::$ml = new Logger('froxlor');
		}
		return self::$ml;
	}

	/**
	 * logs a given text to all enabled logger-facilities
	 *
	 * @param int $action
	 * @param int $type
	 * @param string $text
	 */
	public function logAction($action = \Froxlor\FroxlorLogger::USR_ACTION, $type = LOG_NOTICE, $text = null)
	{
		// not logging normal stuff if not set to "paranoid" logging
		if (! self::$crondebug_flag && Settings::Get('logger.severity') == '1' && $type > LOG_NOTICE) {
			return;
		}

		if (empty(self::$ml)) {
			$this->initMonolog();
		}

		if (self::$crondebug_flag || ($action == \Froxlor\FroxlorLogger::CRON_ACTION && $type <= LOG_WARNING)) {
			echo "[" . $this->getLogLevelDesc($type) . "] " . $text . PHP_EOL;
		}

		// warnings, errors and critical mesages WILL be logged
		if (Settings::Get('logger.log_cron') == '0' && $action == \Froxlor\FroxlorLogger::CRON_ACTION && $type > LOG_WARNING) {
			return;
		}

		$logExtra = array(
			'source' => $this->getActionTypeDesc($action),
			'action' => $action,
			'user' => self::$userinfo['loginname']
		);

		switch ($type) {
			case LOG_DEBUG:
				self::$ml->addDebug($text, $logExtra);
				break;
			case LOG_INFO:
				self::$ml->addInfo($text, $logExtra);
				break;
			case LOG_NOTICE:
				self::$ml->addNotice($text, $logExtra);
				break;
			case LOG_WARNING:
				self::$ml->addWarning($text, $logExtra);
				break;
			case LOG_ERR:
				self::$ml->addError($text, $logExtra);
				break;
			default:
				self::$ml->addDebug($text, $logExtra);
		}
	}

	/**
	 * Set whether to log cron-runs
	 *
	 * @param bool $_cronlog
	 *
	 * @return boolean
	 */
	public function setCronLog($_cronlog = 0)
	{
		$_cronlog = (int) $_cronlog;

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
	public function setCronDebugFlag($_flag = false)
	{
		self::$crondebug_flag = (bool) $_flag;
	}

	public function getLogLevelDesc($type)
	{
		switch ($type) {
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
			case LOG_DEBUG:
				$_type = 'debug';
				break;
			default:
				$_type = 'unknown';
				break;
		}
		return $_type;
	}

	private function getActionTypeDesc($action)
	{
		switch ($action) {
			case \Froxlor\FroxlorLogger::USR_ACTION:
				$_action = 'user';
				break;
			case \Froxlor\FroxlorLogger::ADM_ACTION:
				$_action = 'admin';
				break;
			case \Froxlor\FroxlorLogger::RES_ACTION:
				$_action = 'reseller';
				break;
			case \Froxlor\FroxlorLogger::CRON_ACTION:
				$_action = 'cron';
				break;
			case \Froxlor\FroxlorLogger::LOGIN_ACTION:
				$_action = 'login';
				break;
			default:
				$_action = 'unknown';
				break;
		}
		return $_action;
	}
}
