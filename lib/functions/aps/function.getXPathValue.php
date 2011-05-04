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
 * @package    APS
 *
 */

function getXPathValue($xmlobj = null, $path = null, $single = true)
{
	$result = null;
	
	$tmpxml = new DynamicProperties;
	$tmpxml = ($xmlobj->xpath($path)) ? $xmlobj->xpath($path) : false;

	if($result !== false)
	{
		$result = ($single == true) ? (string)$tmpxml[0] : $tmpxml;
	}
	return $result;
}
