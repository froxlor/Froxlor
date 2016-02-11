<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2015 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2014-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 * @since      0.9.33.1
 */

/**
 * return an array of available hashes for the crypt() function
 *
 * @return array
 */
function getAvailablePasswordHashes()
{
    global $lng;
    
    // get available pwd-hases
    $available_pwdhashes = array(
        0 => $lng['serversettings']['systemdefault']
    );
    if (defined('CRYPT_MD5') && CRYPT_MD5 == 1) {
        $available_pwdhashes[1] = 'MD5';
    }
    if (defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH == 1) {
        $available_pwdhashes[2] = 'BLOWFISH';
    }
    if (defined('CRYPT_SHA256') && CRYPT_SHA256 == 1) {
        $available_pwdhashes[3] = 'SHA-256';
    }
    if (defined('CRYPT_SHA512') && CRYPT_SHA512 == 1) {
        $available_pwdhashes[4] = 'SHA-512';
    }
    
    return $available_pwdhashes;
}
