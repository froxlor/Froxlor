<?php
namespace Froxlor\Api;

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
class Response
{
    public static function jsonResponse($data = null, int $response_code = 200)
    {
        http_response_code($response_code);

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public static function jsonDataResponse($data = null, int $response_code = 200)
    {
        return self::jsonResponse(['data' => $data], $response_code);
    }

    public static function jsonErrorResponse($message = null, int $response_code = 200)
    {
        return self::jsonResponse(['message' => $message], $response_code);
    }
}
