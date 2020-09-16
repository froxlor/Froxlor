<?php

namespace Froxlor\Test\Cron\Traffic;

use DateTimeImmutable;
use Froxlor\Cron\Traffic\Mail\TrafficSink;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Froxlor\Cron\Traffic\Mail\TrafficSink
 */
class TrafficTest extends TestCase
{
	public function testReturnsEmptyArrayWhenNoLogExists()
	{
		$sink = new TrafficSink(['example.org'], new DateTimeImmutable('1999-01-01T00:00:00'));

		self::assertSame([], $sink->getDomainTraffic('example.org'));
	}

	public function testReturnsAllEntriesAsDayArrayForDomain()
	{
		$sink = new TrafficSink(['example.org'], new DateTimeImmutable('1999-01-01T00:00:00'));

		$sink->addDomainTraffic('example.org', 20000101, new DateTimeImmutable('2000-01-01T00:00:00'));
		$sink->addDomainTraffic('example.org', 20000102, new DateTimeImmutable('2000-01-02T00:00:00'));

		self::assertSame(
			[
				'2000-01-01' => 20000101,
				'2000-01-02' => 20000102,
			],
			$sink->getDomainTraffic('example.org')
		);
	}

	public function testIgnoresUnknownDomain()
	{
		$sink = new TrafficSink([], new DateTimeImmutable('1999-01-01T00:00:00'));

		$sink->addDomainTraffic('example.org', 20000101, new DateTimeImmutable('2000-01-01T00:00:00'));

		self::assertSame([], $sink->getDomainTraffic('example.org'));
	}

	public function testIgnoresTooOldTimestamp()
	{
		$sink = new TrafficSink(['example.org'], new DateTimeImmutable('2000-01-01T10:00:00'));

		$sink->addDomainTraffic('example.org', 20000101, new DateTimeImmutable('2000-01-01T00:00:00'));
		$sink->addDomainTraffic('example.org', 20000102, new DateTimeImmutable('2000-01-02T00:00:00'));

		self::assertSame(
			[
				'2000-01-02' => 20000102,
			],
			$sink->getDomainTraffic('example.org')
		);
	}
}
