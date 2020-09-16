<?php

namespace Froxlor\Cron\Traffic\Mail;

use DateTimeInterface;

class TrafficSink
{
	/**
	 * List of domains.
	 *
	 * @var string[]
	 */
	private $myDomains;

	/**
	 * @var int[][]
	 */
	private $domainTraffic = [];

	/**
	 * @var DateTimeInterface
	 */
	private $lastRun;

	/**
	 * Create a new instance.
	 *
	 * @param string[]          $myDomains The known domains.
	 * @param DateTimeInterface $lastRun   The time stamp of the last run - any date older than this is ignored.
	 */
	public function __construct(array $myDomains, DateTimeInterface $lastRun)
	{
		$this->myDomains = $myDomains;
		$this->lastRun   = $lastRun;
	}

	public function acceptsTime(DateTimeInterface $timestamp): bool
	{
		return $timestamp >= $this->lastRun;
	}

	/**
	 * Adds the traffic to the domain array if we own the domain.
	 */
	public function addDomainTraffic(string $domain, int $traffic, DateTimeInterface $timestamp)
	{
		if (!$this->acceptsTime($timestamp) || !in_array($domain, $this->myDomains)) {
			return;
		}

		if (!array_key_exists($domain, $this->domainTraffic)) {
			$this->domainTraffic[$domain] = [];
		}
		$date = $timestamp->format('Y-m-d');
		if (!array_key_exists($date, $this->domainTraffic[$domain])) {
			$this->domainTraffic[$domain][$date] = 0;
		}

		$this->domainTraffic[$domain][$date] += $traffic;
	}

	/**
	 * Returns an array containing the traffic of a given domain indexed by date or empty array if the domain has no traffic.
	 *
	 * @return int[]
	 */
	public function getDomainTraffic(string $domain): array
	{
		if (array_key_exists($domain, $this->domainTraffic)) {
			return $this->domainTraffic[$domain];
		}

		return [];
	}
}
