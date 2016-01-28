<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2016-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Function randomStr
 *
 * generate a pseudo-random string of bytes
 *
 * @param int $length            
 *
 * @return string
 */
function randomStr($length)
{
    if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
        return random_bytes($length);
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        return openssl_random_pseudo_bytes($length);
    } else {
        $pr_bits = '';
        $fp = @fopen('/dev/urandom', 'rb');
        if ($fp !== false) {
            $pr_bits .= @fread($fp, $length);
            @fclose($fp);
        } else {
            $pr_bits = substr(rand(time()).rand(time()), 0, $length);
        }
        return $pr_bits;
    }
}
