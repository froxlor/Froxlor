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
 * @package    Listing
 *
 */

class Impersonate
{
    public static function admin(string $data, array $attributes): array
    {
        $linker = UI::getLinker();
        return [
            'type' => 'link',
            'data' => [
                'text' => $data,
                'href' => $linker->getLink([
                    'section' => 'admins',
                    'page' => 'admins',
                    'action' => 'su',
                    'id' => $attributes['adminid'],
                ]),
            ]
        ];
    }

    public static function customer(string $data, array $attributes): array
    {
        $linker = UI::getLinker();
        return [
            'type' => 'link',
            'data' => [
                'text' => $data,
                'href' => $linker->getLink([
                    'section' => 'customers',
                    'page' => 'customers',
                    'action' => 'su',
                    'sort' => $attributes['loginname'],
                    'id' => $attributes['customerid'],
                ]),
            ]
        ];
    }
}
