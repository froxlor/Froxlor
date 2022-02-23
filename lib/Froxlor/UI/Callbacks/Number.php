<?php
namespace Froxlor\UI\Callbacks;

use Froxlor\PhpHelper;
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
class Number
{
    /**
     * Formats the diskspace to human-readable number
     *
     * @param string $data
     * @return string
     */
    public static function diskspace(string $data): string
    {
        return $data >= 0 ? PhpHelper::sizeReadable($data * 1024, null, 'bi') : UI::getLng('panel.unlimited');
    }

    /**
     * Formats the traffic to human-readable number
     *
     * @param string $data
     * @return string
     */
    public static function traffic(string $data): string
    {
        return $data >= 0 ? PhpHelper::sizeReadable($data * (1024 * 1024), null, 'bi') : UI::getLng('panel.unlimited');
    }
}
