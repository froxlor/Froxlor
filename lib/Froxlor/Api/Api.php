<?php
namespace Froxlor\Api;

use Exception;
use voku\helper\AntiXSS;

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
class Api
{
    protected array $headers;

    /**
     * Api constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->headers = getallheaders();

        // set header for the response
        header("Accept: application/json");
        header("Content-Type: application/json");

        // check whether API interface is enabled after all
        if (\Froxlor\Settings::Get('api.enabled') != 1) {
            throw new Exception('API is not enabled. Please contact the administrator if you think this is wrong.', 400);
        }
    }

    /**
     * Handle incoming api request to our backend.
     *
     * @param mixed $request
     * @throws Exception
     */
    public function handle($request)
    {
        // validate content
        $request = \Froxlor\Api\FroxlorRPC::validateRequest($request);
        $request = (new AntiXSS())->xss_clean(
            $this->stripcslashesDeep($request)
        );

        // now actually do it
        $cls = "\\Froxlor\\Api\\Commands\\" . $request['command']['class'];
        $method = $request['command']['method'];
        $apiObj = new $cls([
            'apikey' => $_SERVER['PHP_AUTH_USER'],
            'secret' => $_SERVER['PHP_AUTH_PW']
        ], $request['params']);

        // call the method with the params if any
        return $apiObj->$method();
    }

    private function stripcslashesDeep($value)
    {
        return is_array($value) ? array_map([$this, 'stripcslashesDeep'], $value) : stripcslashes($value);
    }
}
