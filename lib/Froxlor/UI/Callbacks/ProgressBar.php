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
class ProgressBar
{
    /**
     * TODO: use twig for html templates ...
     *
     * @param string $data
     * @param array $attributes
     * @return string
     */
    public static function diskspace(string $data, array $attributes): string
    {
        $percentage = $attributes['diskspace_used'] ? round(100 * $attributes['diskspace_used'] / $attributes['diskspace']) : 0;
        $text = Number::diskspace($attributes['diskspace_used']) . ' / ' . Number::diskspace($attributes['diskspace']);

        return '<div class="progress progress-thin"><div class="progress-bar bg-info" style="width: ' . $percentage . '%;"></div></div><div class="text-end">' . $text . '</div>';
    }

    /**
     * TODO: use twig for html templates ...
     *
     * @param string $data
     * @param array $attributes
     * @return string
     */
    public static function traffic(string $data, array $attributes): string
    {
        $percentage = $attributes['traffic_used'] ? round(100 * $attributes['traffic_used'] / $attributes['traffic']) : 0;
        $text = Number::traffic($attributes['traffic_used']) . ' / ' . Number::traffic($attributes['traffic']);

        return '<div class="progress progress-thin"><div class="progress-bar bg-info" style="width: ' . $percentage . '%;"></div></div><div class="text-end">' . $text . '</div>';
    }
}