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
 */

function createPassword($length, $chars, $verifyRegEx)
{
        $password = "";
        while (strlen($password) < $length)
        {
                $char = $chars{mt_rand(0,strlen($chars))};

                if (ord($char) > 0)
                {
                        $password .= $char;
                }
        }
        
        if (preg_match($verifyRegEx, $password) == TRUE)
        {
                return $password;
        }
        else
        {
                return createPassword($length, $chars, $verifyRegEx);
        }
}

function generatePassword()
{
        $chars = "23456789abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";
        $verifyRegEx = "/(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$/";
        return createPassword(15, $chars, $verifyRegEx);
}

?>
