<?php

namespace Froxlor\UI\Callbacks;

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
class SSLCertificate
{
	public static function domainWithSan(array $attributes): array
	{
		return [
			'type' => 'domainWithSan',
			'data' => [
				'domain' => $attributes['data'],
				'san' => implode(', ', $attributes['fields']['san'] ?? []),
			]
		];
	}

	public function canDelete(array $attributes): bool
	{
		return false;
	}
}
