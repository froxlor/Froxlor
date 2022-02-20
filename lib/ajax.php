<?php
namespace Froxlor;

use Exception;
use Froxlor\Ajax\Ajax;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
 * @package    AJAX
 *
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Load the user settings
if (!file_exists('./userdata.inc.php')) {
    die();
}
require './userdata.inc.php';
require './tables.inc.php';

// Return response
try {
    echo (new Ajax)->handle();
} catch (Exception $e) {
    echo \Froxlor\Api\Response::jsonErrorResponse($e->getMessage(), 500);
}
