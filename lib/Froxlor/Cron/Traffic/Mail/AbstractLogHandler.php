<?php

namespace Froxlor\Cron\Traffic\Mail;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

abstract class AbstractLogHandler
{
	/**
	 * @var TrafficSink
	 */
	private $sink;

	/**
	 * Marker for calculating when a log line originates from last year.
	 *
	 * @var DateTimeInterface
	 */
	private $tomorrow;

	/**
	 * Create a new instance.
	 *
	 * @param TrafficSink $sink
	 */
	public function __construct(TrafficSink $sink, DateTimeInterface $tomorrow)
	{
		$this->sink     = $sink;
		$this->tomorrow = new DateTimeImmutable($tomorrow->format('Y-m-d') . ' 23:59:59.999999');
	}

	/**
	 * Parse a log file.
	 *
	 * @param string $logFile The absolute path to the log.
	 *
	 * @return void
	 *
	 * @throws \Exception When the file can not be opened.
	 */
	public function handleFile(string $logFile)
	{
		// Check if file exists
		if (! file_exists($logFile)) {
			return;
		}
		// Open the log file
		$file_handle = fopen($logFile, 'rb');
		if (! $file_handle) {
			throw new \Exception('Could not open file ' . $logFile);
		}

		try {
			while (!feof($file_handle)) {
				if (false === $line = fgets($file_handle)) {
					return;
				}
				try {
					$timestamp = $this->getLogTimestamp($line);
				} catch (InvalidArgumentException $exception) {
					// Failed to extract timestamp from log.
					// FIXME: add warning here?
					return;
				}

				// Newer than last run, must have been already processed during last run then.
				if (!$this->sink->acceptsTime($timestamp)) {
					return;
				}

				$this->handle($timestamp, $line);
			}
		} finally {
			fclose($file_handle);
		}
	}

	/**
	 * Process a single log line.
	 *
	 * @param DateTimeInterface $timestamp The timestamp the log line was produced at.
	 * @param string            $line      The line to process.
	 *
	 * @return void
	 */
	abstract public function handle(DateTimeInterface $timestamp, string $line);

	/**
	 * Add traffic for a given domain.
	 *
	 * @param string            $domain    The domain to record the traffic for.
	 * @param int               $traffic   The amount of bytes to record.
	 * @param DateTimeInterface $timestamp The timestamp the traffic was produced.
	 *
	 * @return void
	 */
	protected function addDomainTraffic(string $domain, int $traffic, DateTimeInterface $timestamp)
	{
		$this->sink->addDomainTraffic($domain, $traffic, $timestamp);
	}

	/**
	 * Convert a date time string to a DateTimeInterface.
	 *
	 * If the date is in the future, we move it to the last year.
	 */
	protected function getLogTimestamp(string &$line): DateTimeInterface
	{
		$matches = null;
		if (preg_match('/^((?:[A-Z]{3}\s{1,2}\d{1,2}|\d{4}-\d{2}-\d{2}) \d{2}:\d{2}:\d{2})/i', $line, $matches)) {
			$timestamp = new DateTimeImmutable($matches[1]);
			// If timestamp is in future, we encountered a year skip between last run and this run - let's compensate.
			if ($timestamp > $this->tomorrow) {
				return $timestamp->modify('-1 year');
			}
			return $timestamp;
		}

		throw new InvalidArgumentException('Could not extract date from: ' . $line);
	}
}
