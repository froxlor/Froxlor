<?php

namespace Froxlor\Cron;

use Froxlor\Database\Database;
use Froxlor\FroxlorLogger;

trait Forkable
{
	public static function runFork($closure, array $attributes = [], int $concurrentChildren = 3)
	{
		$childrenPids = [];

		// We only fork if pcntl_fork is available and nofork flag is not set
		if (function_exists('pcntl_fork') && !defined('CRON_NOFORK_FLAG')) {
			foreach ($attributes as $closureAttributes) {
				// We close the database - connection before we fork, so we don't share resources with the child
				Database::needRoot(false); // this forces the connection to be set to null
				$pid = pcntl_fork();

				if ($pid == -1) {
					exit("Error forking...\n");
				} elseif ($pid == 0) {
					// re-create db
					Database::needRoot(false);
					$closure($closureAttributes);
					exit();
				} else {
					$childrenPids[] = $pid;
					while (count($childrenPids) >= $concurrentChildren) {
						foreach ($childrenPids as $key => $pid) {
							$res = pcntl_waitpid($pid, $status, WNOHANG);
							// If the process has already exited
							if ($res == -1 || $res > 0) {
								unset($childrenPids[$key]);
							}
						}
						sleep(1);
					}
				}
			}
			while (pcntl_waitpid(0, $status) != -1);
		} else {
			if (!defined('CRON_NOFORK_FLAG')) {
				if (extension_loaded('pcntl')) {
					$msg = "PHP compiled with pcntl but pcntl_fork function is not available.";
				} else {
					$msg = "PHP compiled without pcntl.";
				}
				FroxlorLogger::getInstanceOf()->logAction(FroxlorLogger::CRON_ACTION, LOG_WARNING, $msg . " Not forking " . self::class . ", this may take a long time!");
			}
			foreach ($attributes as $closureAttributes) {
				$closure($closureAttributes);
			}
		}
	}
}
