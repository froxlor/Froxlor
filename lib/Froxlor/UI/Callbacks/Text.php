<?php

namespace Froxlor\UI\Callbacks;

use Froxlor\PhpHelper;
use Froxlor\UI\Panel\UI;
use Froxlor\Froxlor;
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
			'macro' => 'boolean',
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

	public static function timestampUntil(array $attributes): string
	{
		return (int)$attributes['data'] > 0 ? date('d.m.Y H:i', (int)$attributes['data']) : UI::getLng('panel.unlimited');
	}

	public static function crondesc(array $attributes): string
	{
		return UI::getLng('crondesc.' . $attributes['data']);
	}

	public static function shorten(array $attributes): string
	{
		return substr($attributes['data'], 0, 20) . '...';
	}

	public static function wordwrap(array $attributes): string
	{
		return wordwrap($attributes['data'], 100, '<br>', true);
	}

	public static function apikeyDetailModal(array $attributes): array
	{
		$linker = UI::getLinker();
		$result = $attributes['fields'];
		$apikey_data = include Froxlor::getInstallDir() . '/lib/formfields/formfield.api_key.php';

		$body = UI::twig()->render(UI::getTheme().'/user/inline-form.html.twig', [
			'formaction' => $linker->getLink(array('section' => 'index', 'page' => 'apikeys')),
			'formdata' => $apikey_data['apikey'],
			'editid' => $attributes['fields']['id']
		]);
		return [
			'entry' => $attributes['fields']['id'],
			'id' => 'akModal' . $attributes['fields']['id'],
			'title' => 'API-key ' . ($attributes['fields']['loginname'] ?? $attributes['fields']['adminname']),
			'body' => $body
		];
	}
}
