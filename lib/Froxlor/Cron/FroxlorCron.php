<?php
namespace Froxlor\Cron;

abstract class FroxlorCron
{

	abstract public static function run();

	private static $lockfile = null;

	public static function getLockfile()
	{
		return static::$lockfile;
	}

	public static function setLockfile($lockfile = null)
	{
		static::$lockfile = $lockfile;
	}
}