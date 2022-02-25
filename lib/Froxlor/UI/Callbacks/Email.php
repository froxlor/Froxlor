<?php

namespace Froxlor\UI\Callbacks;

use Froxlor\Settings;
use Froxlor\PhpHelper;

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
 * @package    Listing
 *
 */

class Email
{
	public static function account(string $data, array $attributes): mixed
	{
		return [
			'type' => 'booleanWithInfo',
			'data' => [
				'checked' => $data != 0,
				'info' => $data != 0 ? PhpHelper::sizeReadable($attributes['mboxsize'], 'GiB', 'bi', '%01.' . (int) Settings::Get('panel.decimal_places') . 'f %s') : ''
			]
		];
	}
}
