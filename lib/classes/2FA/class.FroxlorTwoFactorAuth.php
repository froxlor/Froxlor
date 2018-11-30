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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    API
 * @since      0.10.0
 *
 */
require_once __DIR__ . '/lib/TwoFactorAuthException.php';
require_once __DIR__ . '/lib/Providers/Rng/RNGException.php';
require_once __DIR__ . '/lib/Providers/Rng/IRNGProvider.php';
require_once __DIR__ . '/lib/Providers/Rng/CSRNGProvider.php';
require_once __DIR__ . '/lib/Providers/Rng/HashRNGProvider.php';
require_once __DIR__ . '/lib/Providers/Rng/MCryptRNGProvider.php';
require_once __DIR__ . '/lib/Providers/Rng/OpenSSLRNGProvider.php';
require_once __DIR__ . '/lib/Providers/Qr/QRException.php';
require_once __DIR__ . '/lib/Providers/Qr/IQRCodeProvider.php';
require_once __DIR__ . '/lib/Providers/Qr/BaseHTTPQRCodeProvider.php';
require_once __DIR__ . '/lib/Providers/Qr/GoogleQRCodeProvider.php';
require_once __DIR__ . '/lib/Providers/Time/TimeException.php';
require_once __DIR__ . '/lib/Providers/Time/ITimeProvider.php';
require_once __DIR__ . '/lib/Providers/Time/LocalMachineTimeProvider.php';
require_once __DIR__ . '/lib/Providers/Time/HttpTimeProvider.php';
require_once __DIR__ . '/lib/Providers/Time/NTPTimeProvider.php';
require_once __DIR__ . '/lib/TwoFactorAuth.php';

class FroxlorTwoFactorAuth extends \RobThree\Auth\TwoFactorAuth
{
}
