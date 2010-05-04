<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id$
 */

/**
 * Returns whether a URL is in a correct format or not
 *
 * @param string URL to be tested
 * @return bool
 * @author Christian Hoffmann
 *
 */

function validateUrl($url)
{
	if(strtolower(substr($url, 0, 7)) != "http://"
	&& strtolower(substr($url, 0, 8)) != "https://")
	{
		$url = 'http://' . $url;
	}

	// there is a bug in php 5.2.13 - 5.3.2 which
	// lets filter_var fail if the domain has
	// a dash (-) in it. As the PHP_VERSION constant
	// gives also patch-brandings, e.g. '5.3.2-pl0-gentoo'
	// we just always use our regex
	$pattern = '/^https?:\/\/([a-z0-9]([a-z0-9\-]{0,61}[a-z0-9])?\.)+[a-z]{2,6}$/i';
	if(preg_match($pattern, $url))
	{
		return true;
	}

	// not an fqdn
	if(strtolower(substr($url, 0, 7)) == "http://"
		|| strtolower(substr($url, 0, 8)) == "https://")
	{
		if(strtolower(substr($url, 0, 7)) == "http://")
		{
			$ip = strtolower(substr($url, 7));
		}

		if(strtolower(substr($url, 0, 8)) == "https://")
		{
			$ip = strtolower(substr($url, 8));
		}

		$ip = substr($ip, 0, strpos($ip, '/'));

		if(validate_ip($ip, true) !== false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

