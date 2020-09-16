<?php

namespace Froxlor\Cron\Traffic\Mail;

use DateTimeInterface;

/**
 * Parses the dovecot imap/pop3 traffic from logfile.
 */
final class DovecotLogHandler extends AbstractLogHandler
{
	public function handle(DateTimeInterface $timestamp, string $line)
	{
		// IMAP
		if (preg_match('/dovecot.*[:\]] imap\(.*@([a-z0-9.\-]+)\)(?:<\d+><[a-z0-9+\/=]+>)?:.*(?:in=(\d+) out=(\d+)|bytes=(\d+)\/(\d+))/i', $line, $matches)) {
			$this->addDomainTraffic($matches[1], (int) $matches[2] + (int) $matches[3], $timestamp);

			return;
		}

		// POP3
		if (preg_match('/dovecot.*[:\]] pop3\(.*@([a-z0-9.\-]+)\)(?:<\d+><[a-z0-9+\/=]+>)?:.*in=(\d+).*out=(\d+)/i', $line, $matches)) {
			$this->addDomainTraffic($matches[1], (int) $matches[2] + (int) $matches[3], $timestamp);
		}
	}
}
