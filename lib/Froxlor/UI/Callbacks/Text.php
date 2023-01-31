<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\UI\Callbacks;

use Froxlor\Froxlor;
use Froxlor\PhpHelper;
use Froxlor\UI\Panel\UI;
use Froxlor\User;

class Text
{
	public static function boolean(array $attributes): array
	{
		return [
			'macro' => 'boolean',
			'data' => (bool)$attributes['data']
		];
	}

	public static function customerfullname(array $attributes): string
	{
		return User::getCorrectFullUserDetails($attributes['fields'], true);
	}

	public static function size(array $attributes): string
	{
		return PhpHelper::sizeReadable($attributes['data'], null, 'bi');
	}

	public static function timestamp(array $attributes): string
	{
		return (int)$attributes['data'] > 0 ? date('d.m.Y H:i', (int)$attributes['data']) : lng('panel.never');
	}

	public static function timestampUntil(array $attributes): string
	{
		return (int)$attributes['data'] > 0 ? date('d.m.Y H:i', (int)$attributes['data']) : lng('panel.unlimited');
	}

	public static function crondesc(array $attributes): string
	{
		return lng('crondesc.' . $attributes['data']);
	}

	public static function shorten(array $attributes): string
	{
		return substr($attributes['data'], 0, 20) . '...';
	}

	public static function wordwrap(array $attributes): string
	{
		return wordwrap($attributes['data'], 100, '<br>', true);
	}

	public static function customerNoteDetailModal(array $attributes): array
	{
		$note = $attributes['fields']['custom_notes'] ?? '';
		return [
			'entry' => $attributes['fields']['id'],
			'id' => 'cnModal' . $attributes['fields']['id'],
			'title' => lng('usersettings.custom_notes.title') . ': ' . ($attributes['fields']['loginname'] ?? $attributes['fields']['adminname']),
			'body' => nl2br($note)
		];
	}

	public static function apikeyDetailModal(array $attributes): array
	{
		$linker = UI::getLinker();
		$result = $attributes['fields'];
		$apikey_data = include Froxlor::getInstallDir() . '/lib/formfields/formfield.api_key.php';

		$body = UI::twig()->render(UI::validateThemeTemplate('/user/inline-form.html.twig'), [
			'formaction' => $linker->getLink(['section' => 'index', 'page' => 'apikeys']),
			'formdata' => $apikey_data['apikey'],
			'editid' => $attributes['fields']['id']
		]);
		return [
			'entry' => $attributes['fields']['id'],
			'id' => 'akModal' . $attributes['fields']['id'],
			'title' => 'API-key ' . ($attributes['fields']['loginname'] ?? $attributes['fields']['adminname']),
			'action' => 'apikeys',
			'body' => $body
		];
	}
}
