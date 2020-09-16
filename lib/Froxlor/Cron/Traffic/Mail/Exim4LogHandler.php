<?php

namespace Froxlor\Cron\Traffic\Mail;

use DateTimeInterface;

/**
 * Parses exim 4 smtp log file lines.
 */
final class Exim4LogHandler extends AbstractLogHandler
{
	public function handle(DateTimeInterface $timestamp, string $line)
	{
		// Outgoing traffic
		if (preg_match('/<= .*@([a-z0-9.\-]+) .*S=(\d+)/i', $line, $matches)) {
			$this->addDomainTraffic($matches[1], $matches[2], $timestamp);
			return;
		}
		// Incoming traffic
		if (preg_match('/=> .*<?.*@([a-z0-9.\-]+)>? .*S=(\d+)/i', $line, $matches)) {
			$this->addDomainTraffic($matches[1], $matches[2], $timestamp);
		}
	}
}
