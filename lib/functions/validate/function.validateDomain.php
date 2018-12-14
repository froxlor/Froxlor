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
 * @package    Functions
 *
 */

/**
 * Check if the submitted string is a valid domainname
 *
 * @param string $domainname
 *        	The domainname which should be checked.
 * @param bool $allow_underscore
 *        	optional if true, allowes the underscore character in a domain label (DKIM etc.)
 *        	
 * @return string|boolean the domain-name if the domain is valid, false otherwise
 */
function validateDomain($domainname, $allow_underscore = false)
{
	if (is_string($domainname)) {
		$char_validation = '([a-z\d](-*[a-z\d])*)(\.?([a-z\d](-*[a-z\d])*))*\.([a-z\d])+';
		if ($allow_underscore) {
			$char_validation = '([a-z\d\_](-*[a-z\d\_])*)(\.([a-z\d\_](-*[a-z\d])*))*(\.?([a-z\d](-*[a-z\d])*))+\.([a-z\d])+';
		}

		if (preg_match("/^" . $char_validation . "$/i", $domainname) && // valid chars check
		preg_match("/^.{1,253}$/", $domainname) && // overall length check
		preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domainname)) // length of each label
		{
			return $domainname;
		}
	}
	return false;
}

/**
 * validate a local-hostname by regex
 *
 * @param string $hostname
 *
 * @return string|boolean hostname on success, else false
 */
function validateLocalHostname($hostname)
{
	$pattern = '/^([a-zA-Z0-9\-])+$/i';
	if (preg_match($pattern, $hostname)) {
		return $hostname;
	}
	return false;
}
