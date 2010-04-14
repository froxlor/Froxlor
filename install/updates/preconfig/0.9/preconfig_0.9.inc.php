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
 * @package    Language
 * @version    $Id$
 */

/**
 * checks if the new-version has some updating to do
 * 
 * @param boolean $has_preconfig   pointer to check if any preconfig has to be output
 * @param string  $return          pointer to output string
 * @param string  $current_version current froxlor version
 * 
 * @return null
 */
function parseAndOutputPreconfig(&$has_preconfig, &$return, $current_version)
{
	if(versionInUpdate($current_version, '0.9.4-svn2'))
	{
		$has_preconfig = true;
		$return .= 'Froxlor-0.9.4-svn2 now enabled the usage of a domain-wildcard entry and subdomains for this domain at once (subdomains are parsed before the main vhost container). ';
		$return .= 'This makes it possible to catch all non-existing subdomains with the main vhost but also have the ability to use subdomains for that domain.<br />';
		$return .= 'If you would like Froxlor to do so with your domains, the update script can set the correct values for existing domains for you. Note: future domains will have wildcard-entries enabled by default no matter how you decide here.<br /><br />';
		$return .= '<strong>Do you want to use wildcard-entries for existing domains?:</strong>&nbsp;';
		$return .= makeyesno('update_domainwildcardentry', '1', '0', '1').'<br /><br />';
	}
}
