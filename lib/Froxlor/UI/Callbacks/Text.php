<?php

namespace Froxlor\UI\Callbacks;

use Froxlor\PhpHelper;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\User;

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
 * @author     Maurice Preuß <hello@envoyr.com>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Froxlor\UI\Callbacks
 *
 */
class Text
{
	public static function boolean(array $attributes): array
	{
		return [
			'type' => 'boolean',
			'data' => (bool)$attributes['data']
		];
	}

	public static function customerfullname(array $attributes): string
	{
		return User::getCorrectFullUserDetails($attributes['fields']);
	}

	public static function size(array $attributes): string
	{
		return PhpHelper::sizeReadable($attributes['data'], null, 'bi');
	}

	public static function timestamp(array $attributes): string
	{
		return (int)$attributes['data'] > 0 ? date('d.m.Y H:i', (int)$attributes['data']) : UI::getLng('panel.never');
	}

	public static function crondesc(array $attributes): string
	{
		return UI::getLng('crondesc.' . $attributes['data']);
	}
}
