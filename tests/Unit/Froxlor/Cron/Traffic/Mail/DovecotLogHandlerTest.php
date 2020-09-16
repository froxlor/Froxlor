<?php

namespace Froxlor\Test\Froxlor\Cron\Traffic\Mail;

use DateTimeImmutable;
use Froxlor\Cron\Traffic\Mail\DovecotLogHandler;
use Froxlor\Cron\Traffic\Mail\TrafficSink;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Froxlor\Cron\Traffic\Mail\AbstractLogHandler
 * @covers \Froxlor\Cron\Traffic\Mail\DovecotLogHandler
 */
class DovecotLogHandlerTest extends TestCase
{
	public function testParsesLogLines()
	{
		$yesterday = new DateTimeImmutable('yesterday');

		$sink = new TrafficSink(['example.org'], $yesterday);

		$tomorrow = new DateTimeImmutable('tomorrow');

		$parser = new DovecotLogHandler($sink, $tomorrow);

		$parser->handle(
			$yesterday->modify('12:36:29'),
			'server dovecot: imap(test-imap@example.org)<12345><sessionid>: Logged out in=512 out=512 deleted=0 expunged=0 trashed=0 hdr_count=0 hdr_bytes=0 body_count=0 body_bytes=0'
		);
		$parser->handle(
			$yesterday->modify('12:36:30'),
			'server dovecot: pop3(test-pop@example.org)<23456><sessionid2>: Disconnected: Logged out in=512 out=512 top=0/0, retr=1/21618, del=1/1, size=21583'
		);

		self::assertSame(
			[
				$yesterday->format('Y-m-d') => 2048
			],
			$sink->getDomainTraffic('example.org')
		);
	}

	public function testParsesLogLinesWhenYearChanged()
	{
		$sink = new TrafficSink(['example.org'], $newYearEve = new DateTimeImmutable('last day of December last year'));

		$tomorrow = new DateTimeImmutable('tomorrow');

		$parser = new DovecotLogHandler($sink, $tomorrow);

		$parser->handle(
			$newYearEve->modify('12:36:29'),
			'server dovecot: imap(test-imap@example.org)<12345><sessionid>: Logged out in=512 out=512 deleted=0 expunged=0 trashed=0 hdr_count=0 hdr_bytes=0 body_count=0 body_bytes=0'
		);
		$parser->handle(
			$newYearEve->modify('12:36:30'),
			'server dovecot: pop3(test-pop@example.org)<23456><sessionid2>: Disconnected: Logged out in=512 out=512 top=0/0, retr=1/21618, del=1/1, size=21583'
		);

		self::assertSame(
			[
				($tomorrow->modify('-1 years')->format('Y')) . '-12-31' => 2048
			],
			$sink->getDomainTraffic('example.org')
		);
	}
}
