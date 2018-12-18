<?php
namespace Froxlor;

final class Froxlor
{

	// Main version variable
	const VERSION = '0.10.0';

	// Database version (YYYYMMDDC where C is a daily counter)
	const DBVERSION = '201812170';

	// Distribution branding-tag (used for Debian etc.)
	const BRANDING = '';

	/**
	 * return path to where froxlor is installed, e.g.
	 * /var/www/froxlor
	 *
	 * @return string
	 */
	public static function getInstallDir()
	{
		return dirname(dirname(__DIR__));
	}

	/**
	 * return basic version
	 *
	 * @return string
	 */
	public static function getVersion()
	{
		return self::VERSION;
	}

	/**
	 * return version + branding
	 *
	 * @return string
	 */
	public static function getFullVersion()
	{
		return self::VERSION . self::BRANDING;
	}

	/**
	 * return version + branding and database-version
	 *
	 * @return string
	 */
	public static function getVersionString()
	{
		return self::getFullVersion() . ' (' . self::DBVERSION . ')';
	}
}
