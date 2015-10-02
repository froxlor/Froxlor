<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2011- the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2011-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Generates a random password
 *
 * @param boolean $isSalt
 *            optional, create a hash for a salt used in makeCryptPassword because crypt() does not like some special characters in its salts, default is false
 */
function generatePassword($isSalt = false)
{
    $alpha_lower = 'abcdefghijklmnopqrstuvwxyz';
    $alpha_upper = strtoupper($alpha_lower);
    $numeric = '0123456789';
    $special = Settings::Get('panel.password_special_char');
    $length = Settings::Get('panel.password_min_length') > 3 ? Settings::Get('panel.password_min_length') : 10;
    
    $pw = special_shuffle($alpha_lower);
    $n = floor(($length) / 4);
    
    if (Settings::Get('panel.password_alpha_upper')) {
        $pw .= mb_substr(special_shuffle($alpha_upper), 0, $n);
    }
    
    if (Settings::Get('panel.password_numeric')) {
        $pw .= mb_substr(special_shuffle($numeric), 0, $n);
    }
    
    if (Settings::Get('panel.password_special_char_required') && !$isSalt) {
        $pw .= mb_substr(special_shuffle($special), 0, $n);
    }
    
    $pw = mb_substr($pw, - $length);
    
    return special_shuffle($pw);
}

/**
 * multibyte-character safe shuffle function
 *
 * @param string $str            
 *
 * @return string
 */
function special_shuffle($str = null)
{
    $len = mb_strlen($str);
    $sploded = array();
    while ($len -- > 0) {
        $sploded[] = mb_substr($str, $len, 1);
    }
    shuffle($sploded);
    return join('', $sploded);
}
