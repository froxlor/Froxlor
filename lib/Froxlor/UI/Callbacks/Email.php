<?php

namespace Froxlor\UI\Callbacks;

use Froxlor\PhpHelper;
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
class Email
{
	public static function account(array $attributes)
	{
		return [
			'macro' => 'booleanWithInfo',
			'data' => [
				'checked' => $attributes['data'] != 0,
				'info' => $attributes['data'] != 0 ? PhpHelper::sizeReadable($attributes['fields']['mboxsize'], 'GiB', 'bi', '%01.' . (int)Settings::Get('panel.decimal_places') . 'f %s') : ''
			]
		];
	}
}
