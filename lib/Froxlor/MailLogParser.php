<?php
namespace Froxlor;

use DateTimeImmutable;
use Froxlor\Cron\Traffic\Mail\AbstractLogHandler;
use Froxlor\Cron\Traffic\Mail\CourierLogHandler;
use Froxlor\Cron\Traffic\Mail\DovecotLogHandler;
use Froxlor\Cron\Traffic\Mail\Exim4LogHandler;
use Froxlor\Cron\Traffic\Mail\PostfixLogHandler;
use Froxlor\Cron\Traffic\Mail\TrafficSink;
use Froxlor\Database\Database;
use InvalidArgumentException;

class MailLogParser
{
	/**
	 * @var TrafficSink
	 */
	private $sink;

	/**
	 * @var DateTimeImmutable
	 */
	private $tomorrow;

	private $startTime;

	/**
	 * constructor
	 *
	 * @param
	 *        	string logFile
	 * @param
	 *        	int startTime
	 * @param
	 *        	string logFileExim
	 */
	public function __construct($startTime = 0)
	{
		$this->startTime = $startTime;

		$this->sink = new TrafficSink($this->getMyDomains(), new DateTimeImmutable('@' . $startTime));
		$this->tomorrow = new DateTimeImmutable('tomorrow');

		// Parse MTA traffic
		$mtaLogFile    = Settings::Get('system.mtalog');
		$mtaLogHandler = $this->getMtaHandler(Settings::Get('system.mtaserver'));
		$mtaLogHandler->handleFile($mtaLogFile);
		$mtaLogHandler->handleFile($mtaLogFile . '.1');

		// Parse MDA traffic
		$mdaLogFile    = Settings::Get('system.mdalog');
		$mdaLogHandler = $this->getMdaHandler(Settings::Get('system.mdaserver'));
		$mdaLogHandler->handleFile($mdaLogFile);
		$mdaLogHandler->handleFile($mdaLogFile . '.1');
	}

	/**
	 * getDomainTraffic
	 * returns the traffic of a given domain or 0 if the domain has no traffic
	 *
	 * @param
	 *        	string domain
	 *        	return array
	 */
	public function getDomainTraffic($domain)
	{
		return $this->sink->getDomainTraffic($domain);
	}

	private function getMyDomains(): array
	{
		// Get all domains from Database
		$stmt = Database::prepare('SELECT domain FROM `' . TABLE_PANEL_DOMAINS . '`');
		Database::pexecute($stmt, []);
		$myDomains = [];
		while ($domain_row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$myDomains[] = $domain_row['domain'];
		}

		return $myDomains;
	}

	private function getMtaHandler(string $handlerName): AbstractLogHandler
	{
		switch ($handlerName) {
			case 'postfix':
				return new PostfixLogHandler($this->sink, $this->tomorrow);
			case 'exim4':
				return new Exim4LogHandler($this->sink, $this->tomorrow);
			default:
		}
		throw new InvalidArgumentException('Unknown implementation: ' . $handlerName);
	}

	private function getMdaHandler(string $handlerName): AbstractLogHandler
	{
		switch ($handlerName) {
			case 'dovecot':
				return new DovecotLogHandler($this->sink, $this->tomorrow);
			case 'courier':
				return new CourierLogHandler($this->sink, $this->tomorrow);
			default:
		}
		throw new InvalidArgumentException('Unknown implementation: ' . $handlerName);
	}
}
