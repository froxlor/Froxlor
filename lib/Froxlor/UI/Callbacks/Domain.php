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
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Listing
 *
 */

class Domain
{
	public static function domainTarget(string $data, array $attributes): mixed
	{
		if (empty($attributes['aliasdomain'])) {
			// path or redirect
			if (preg_match('/^https?\:\/\//', $attributes['documentroot'])) {
				return [
					'type' => 'link',
					'data' => [
						'text' => $attributes['documentroot'],
						'href' => $attributes['documentroot'],
						'target' => '_blank'
					]
				];
			} else {
				// show docroot nicely
				if (strpos($attributes['documentroot'], UI::getCurrentUser()['documentroot']) === 0) {
					$attributes['documentroot'] = \Froxlor\FileDir::makeCorrectDir(str_replace(UI::getCurrentUser()['documentroot'], "/", $attributes['documentroot']));
				}
				return $attributes['documentroot'];
			}
		}
		return UI::getLng('domains.aliasdomain') . ' ' . $attributes['aliasdomain'];
	}
}
