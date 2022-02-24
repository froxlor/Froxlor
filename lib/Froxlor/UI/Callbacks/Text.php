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
 * @package    Listing
 *
 */
class Text
{
    public static function boolean(?string $data): array
    {
        return [
            'type' => 'boolean',
            'data' => (bool) $data
        ];
    }

    public static function domainWithSan(string $data, array $attributes): array
    {
        return [
            'type' => 'domainWithSan',
            'data' => [
                'domain' => $data,
                'san' => implode(', ', $attributes['san'] ?? []),
            ]
        ];
    }
}
