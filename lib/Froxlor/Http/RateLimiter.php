<?php

namespace Froxlor\Http;

use Froxlor\Froxlor;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;

class RateLimiter
{
	private static int $limit_per_interval = 60;
	private static int $reset_time = 0;

	public static function run(bool $install_mode = false)
	{
		// default interval = 60 sec
		self::$reset_time = time() + 60;

		if (!$install_mode) {
			self::$limit_per_interval = Settings::Get('system.req_limit_per_interval') ?? 60;
			self::$reset_time = time() + Settings::Get('system.req_limit_interval') ?? 60;
		}

		// Get the remaining requests and reset time from the headers
		$remaining = isset($_SESSION['HTTP_X_RATELIMIT_REMAINING']) ? (int)$_SESSION['HTTP_X_RATELIMIT_REMAINING'] : self::$limit_per_interval;
		$reset = isset($_SESSION['HTTP_X_RATELIMIT_RESET']) ? (int)$_SESSION['HTTP_X_RATELIMIT_RESET'] : self::$reset_time;

		// check if reset time is due
		if (time() > $reset) {
			$remaining = self::$limit_per_interval;
			$reset = self::$reset_time;
		}

		// If we've hit the limit, return an error
		if ($remaining <= 0) {
			header('HTTP/1.1 429 Too Many Requests');
			header("Retry-After: $reset");
			UI::twig()->addGlobal('install_mode', '1');
			echo UI::twig()->render('Froxlor/misc/ratelimithint.html.twig', [
				'retry' => $reset,
				'installdir' => Froxlor::getInstallDir()
			]);
			die();
		}

		// Decrement the remaining requests and update the headers
		$remaining--;
		$_SESSION['HTTP_X_RATELIMIT_REMAINING'] = $remaining;
		$_SESSION['HTTP_X_RATELIMIT_RESET'] = $reset;

		header("X-RateLimit-Limit: " . self::$limit_per_interval);
		header("X-RateLimit-Remaining: " . $remaining);
		header("X-RateLimit-Reset: " . $reset);
	}
}
