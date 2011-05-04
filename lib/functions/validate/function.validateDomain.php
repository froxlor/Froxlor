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
 *
 */

/**
 * Check if the submitted string is a valid domainname, i.e.
 * it consists only of the following characters ([a-z0-9][a-z0-9\-]+\.)+[a-z]{2,4}
 *
 * @param string The domainname which should be checked.
 * @return boolean True if the domain is valid, false otherwise
 * @author Florian Lippert <flo@syscp.org>
 * @author Michael Duergner
 *
 */

function validateDomain($domainname)
{
	// we add http:// because this makes a domain valid for the filter;

	$domainname_tmp = 'http://' . $domainname;

	// If FILTER_VALIDATE_URL is good, but FILTER_VALIDATE_URL with FILTER_FLAG_PATH_REQUIRED or FILTER_FLAG_QUERY_REQUIRED is also good, it isn't just a domain.
	// This is a ugly hack, maybe a good regex would be better?

	// there is a bug in php 5.2.13 - 5.3.2 which
	// lets filter_var fail if the domain has
	// a dash (-) in it. As the PHP_VERSION constant
	// gives also patch-brandings, e.g. '5.3.2-pl0-gentoo'
	// we just always use our regex
	$pattern = '/^http:\/\/([a-z0-9]([a-z0-9\-]{0,61}[a-z0-9])?\.)+[a-z]{2,6}$/i';
	if(preg_match($pattern, $domainname_tmp))
	{	
		return $domainname;
	}
	return false;
}

function validateLocalHostname($hostname)
{
	$pattern = '/^([a-zA-Z0-9\-])+$/i';
	if(preg_match($pattern, $hostname))
	{	
		return $hostname;
	}
	return false;
}
