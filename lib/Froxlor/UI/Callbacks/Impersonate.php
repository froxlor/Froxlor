<?php

namespace Froxlor\UI\Callbacks;

use Froxlor\UI\Panel\UI;

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
class Impersonate
{
	public static function admin(array $attributes)
	{
		if (UI::getCurrentUser()['adminid'] != $attributes['fields']['adminid']) {
			$linker = UI::getLinker();
			return [
				'type' => 'link',
				'data' => [
					'text' => $attributes['data'],
					'href' => $linker->getLink([
						'section' => 'admins',
						'page' => 'admins',
						'action' => 'su',
						'id' => $attributes['fields']['adminid'],
					]),
				]
			];
		}
		return $attributes['data'];
	}

	public static function customer(array $attributes): array
	{
		$linker = UI::getLinker();
		return [
			'type' => 'link',
			'data' => [
				'text' => $attributes['data'],
				'href' => $linker->getLink([
					'section' => 'customers',
					'page' => 'customers',
					'action' => 'su',
					'sort' => $attributes['fields']['loginname'],
					'id' => $attributes['fields']['customerid'],
				]),
			]
		];
	}
}
