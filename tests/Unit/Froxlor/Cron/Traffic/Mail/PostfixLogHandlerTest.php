<?php

namespace Froxlor\Test\Froxlor\Cron\Traffic\Mail;

use DateTimeImmutable;
use Froxlor\Cron\Traffic\Mail\PostfixLogHandler;
use Froxlor\Cron\Traffic\Mail\TrafficSink;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Froxlor\Cron\Traffic\Mail\AbstractLogHandler
 * @covers \Froxlor\Cron\Traffic\Mail\PostfixLogHandler
 */
class PostfixLogHandlerTest extends TestCase
{
	public function testParsesLogLines()
	{
		$yesterday = new DateTimeImmutable('yesterday');

		$sink = new TrafficSink(['example.org'], $yesterday);

		$tomorrow = new DateTimeImmutable('tomorrow');

		$parser = new PostfixLogHandler($sink, $tomorrow);

		$parser->handle(
			$yesterday->modify('12:36:29'),
			'server postfix/qmgr[2345]: A01234567890: from=<test@example.com>, size=12345, nrcpt=1 (queue active)'
		);
		$parser->handle(
			$yesterday->modify('12:36:30'),
			'server postfix/smtp[1234]: A01234567890: to=<test@example.org>, relay=127.0.0.1[127.0.0.1]:10024, delay=0, delays=0/0/0/0, dsn=2.0.0, status=sent (250 2.0.0 from MTA(smtp:[127.0.0.1]:10025): 250 2.0.0 Ok: queued as B01234567890)'
		);

		self::assertSame(
			[
				$yesterday->format('Y-m-d') => 12345
			],
			$sink->getDomainTraffic('example.org')
		);
	}

	public function testParsesLogLinesWhenYearChanged()
	{
		$sink = new TrafficSink(['example.org'], $newYearEve = new DateTimeImmutable('last day of December last year'));

		$tomorrow = new DateTimeImmutable('tomorrow');

		$parser = new PostfixLogHandler($sink, $tomorrow);

		$parser->handle(
			$newYearEve->modify('12:36:29'),
			'server postfix/qmgr[2345]: A01234567890: from=<test@example.com>, size=12345, nrcpt=1 (queue active)'
		);
		$parser->handle(
			$newYearEve->modify('12:36:30'),
			'server postfix/smtp[1234]: A01234567890: to=<test@example.org>, relay=127.0.0.1[127.0.0.1]:10024, delay=0, delays=0/0/0/0, dsn=2.0.0, status=sent (250 2.0.0 from MTA(smtp:[127.0.0.1]:10025): 250 2.0.0 Ok: queued as B01234567890)'
		);

		self::assertSame(
			[
				($tomorrow->modify('-1 years')->format('Y')) . '-12-31' => 12345
			],
			$sink->getDomainTraffic('example.org')
		);
	}
}
