<?php

namespace Froxlor\Cron\Traffic\Mail;

use DateTimeInterface;

/**
 * Parses postfix log file lines.
 *
 * This implementation counts incoming traffic and outgoing traffic and adds them to the traffic sink.
 * The domain filtering is performed within the sink.
 */
final class PostfixLogHandler extends AbstractLogHandler
{
	/**
	 * @var string[][]
	 */
	private $mails = [];

	public function handle(DateTimeInterface $timestamp, string $line)
	{
		if (preg_match('/postfix\/qmgr.*[:\]]\s([A-Z\d]+).*from=<?(?:.*@([a-zA-Z\d.\-]+))?>?, size=(\d+),/', $line, $matches)) {
			// from
			$this->mails[$matches[1]] = array(
				'domainFrom' => strtolower($matches[2]),
				'size' => $matches[3]
			);

			return;
		}

		if (preg_match('/postfix\/(?:pipe|smtp).*[:\]]\s([A-Z\d]+).*to=<?(?:.*@([a-zA-Z\d.\-]+))?>?,/', $line, $matches)) {
			// to
			if (array_key_exists($matches[1], $this->mails)) {
				$this->mails[$matches[1]]['domainTo'] = strtolower($matches[2]);

				// Only mails from/to outside the system should be added
				$mail = $this->mails[$matches[1]];
				// Outgoing traffic
				$this->addDomainTraffic($mail['domainFrom'], $mail['size'], $timestamp);
				// Incoming traffic
				$this->addDomainTraffic($mail['domainTo'], $mail['size'], $timestamp);

				unset($mail);
			}
		}
	}
}
