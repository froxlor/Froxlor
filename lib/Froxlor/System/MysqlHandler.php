<?php
namespace Froxlor\System;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class MysqlHandler extends AbstractProcessingHandler
{

	protected $pdoStatement = null;

	protected static $froxlorLevels = array(
		Logger::DEBUG => LOG_DEBUG,
		Logger::INFO => LOG_INFO,
		Logger::NOTICE => LOG_NOTICE,
		Logger::WARNING => LOG_WARNING,
		Logger::ERROR => LOG_ERR,
		Logger::CRITICAL => LOG_ERR,
		Logger::ALERT => LOG_ERR,
		Logger::EMERGENCY => LOG_ERR
	);

	/**
	 * Constructor
	 *
	 * @param bool|int $level
	 *        	Debug level which this handler should store
	 * @param bool $bubble
	 */
	public function __construct($level = Logger::DEBUG, $bubble = true)
	{
		parent::__construct($level, $bubble);
	}

	/**
	 * Insert the data to the logger table
	 *
	 * @param array $data
	 * @return bool
	 */
	protected function insert(array $data)
	{
		if ($this->pdoStatement === null) {
			$sql = "INSERT INTO `panel_syslog` SET `text` = :message, `user` = :contextUser, `action` = :contextAction, `type` = :level, `date` = :datetime";
			$this->pdoStatement = \Froxlor\Database\Database::prepare($sql);
		}
		return $this->pdoStatement->execute($data);
	}

	/**
	 * Writes the record down to the log
	 *
	 * @param array $record
	 * @return void
	 */
	protected function write(array $record)
	{
		$this->insert([
			':message' => $record['message'],
			':contextUser' => (isset($record['context']['loginname']) ? $record['context']['loginname'] : 'unknown'),
			':contextAction' => (isset($record['context']['action']) ? $record['context']['action'] : '0'),
			':level' => self::$froxlorLevels[$record['level']],
			':datetime' => $record['datetime']->format('U')
		]);
	}
}
