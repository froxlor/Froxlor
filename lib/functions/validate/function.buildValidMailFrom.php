<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id: function.buildValidMailFrom.php 2724 2009-06-07 14:18:02Z flo $
 */

/**
 * Create a valid from/to - mailheader (remove carriage-returns)
 *
 * @param string The name of the recipient
 * @param string The mailaddress
 * @return string A valid header-entry
 * @author Florian Aders <eleras@syscp.org>
 */

function buildValidMailFrom($name, $mailaddress)
{
	$mailfrom = str_replace(array("\r", "\n"), '', $name) . ' <' . str_replace(array("\r", "\n"), '', $mailaddress) . '>';
	return $mailfrom;
}
