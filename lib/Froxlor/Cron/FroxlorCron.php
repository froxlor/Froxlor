<?php
namespace Froxlor\Cron;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 * @since 0.10.0
 *       
 */
abstract class FroxlorCron
{

	abstract public static function run();

	protected static $cronlog = null;

	protected static $lockfile = null;

	public static function getLockfile()
	{
		return static::$lockfile;
	}

	public static function setLockfile($lockfile = null)
	{
		static::$lockfile = $lockfile;
	}
}
