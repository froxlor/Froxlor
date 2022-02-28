<?php

namespace Froxlor\UI\Callbacks;

use Froxlor\Settings;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Froxlor\UI\Callbacks
 *
 */
class Customer
{
	public static function isLocked(array $attributes)
	{
		return $attributes['fields']['loginfail_count'] >= Settings::Get('login.maxloginattempts')
			&& $attributes['fields']['lastlogin_fail'] > (time() - Settings::Get('login.deactivatetime'));
	}
}
