<?php

use Froxlor\Api\Api;
use voku\helper\AntiXSS;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/lib/tables.inc.php';

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

// Return response
try {
    echo (new Api)->handle(@file_get_contents('php://input'));
} catch (Exception $e) {
    echo \Froxlor\Api\Response::jsonErrorResponse($e->getMessage(), $e->getCode());
}
