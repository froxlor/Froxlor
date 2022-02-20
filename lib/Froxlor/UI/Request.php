<?php
namespace Froxlor\UI;

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
 * @package    API
 *
 */
class Request
{
    /**
     * Get key from current request.
     *
     * @param $key
     * @param string|null $default
     * @return mixed|string|null
     */
    public static function get($key, string $default = null)
    {
        return $_GET[$key] ?? $_POST[$key] ?? $default;
    }

    /**
     * Check if key is existing in current request.
     *
     * @param $key
     * @return bool|mixed
     */
    public static function exist($key)
    {
        return (bool) $_GET[$key] ?? $_POST[$key] ?? false;
    }
}
