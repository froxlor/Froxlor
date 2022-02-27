<?php

namespace Froxlor\UI\Callbacks;

use Froxlor\FileDir;
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
 * @package    Froxlor\UI\Callbacks
 *
 */
class Domain
{
	public static function domainTarget(array $attributes)
	{
		if (empty($attributes['fields']['aliasdomain'])) {
			// path or redirect
			if (preg_match('/^https?\:\/\//', $attributes['fields']['documentroot'])) {
				return [
					'type' => 'link',
					'data' => [
						'text' => $attributes['fields']['documentroot'],
						'href' => $attributes['fields']['documentroot'],
						'target' => '_blank'
					]
				];
			} else {
				// show docroot nicely
				if (strpos($attributes['fields']['documentroot'], UI::getCurrentUser()['documentroot']) === 0) {
					$attributes['fields']['documentroot'] = FileDir::makeCorrectDir(str_replace(UI::getCurrentUser()['documentroot'], "/", $attributes['fields']['documentroot']));
				}
				return $attributes['fields']['documentroot'];
			}
		}
		return UI::getLng('domains.aliasdomain') . ' ' . $attributes['fields']['aliasdomain'];
	}
}
