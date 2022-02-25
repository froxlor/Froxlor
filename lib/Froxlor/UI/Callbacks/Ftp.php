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

class Ftp
{
	public static function pathRelative(string $data, array $attributes): string
	{
		if (strpos($data, UI::getCurrentUser()['documentroot']) === 0) {
			$data = str_replace(UI::getCurrentUser()['documentroot'], "/", $data);
		}
		$data = \Froxlor\FileDir::makeCorrectDir($data);

		return $data;
	}
}
