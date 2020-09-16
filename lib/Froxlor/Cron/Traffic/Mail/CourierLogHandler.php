<?php

namespace Froxlor\Cron\Traffic\Mail;

use DateTimeInterface;

/**
 * Parses the courier imap/pop3 traffic from logfile.
 */
final class CourierLogHandler extends AbstractLogHandler
{
	public function handle(DateTimeInterface $timestamp, string $line)
	{
		// IMAP & POP3
		if (preg_match('/(?:imapd|pop3d)(?:-ssl)?.*[:\]].*user=.*@([a-z0-9.\-]+),.*rcvd=(\d+), sent=(\d+),/i', $line, $matches)) {
			$this->addDomainTraffic($matches[1], (int) $matches[2] + (int) $matches[3], $timestamp);
		}
	}
}
