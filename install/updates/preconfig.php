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
 * Function getPreConfig
 *
 * outputs various content before the update process
 * can be continued (askes for agreement whatever is being asked)
 *
 * @param string version
 *
 * @return string
 */
function getPreConfig($version)
{
	$has_preconfig = false;
	$return = '<div class="preconfig"><h3 style="color:#ff0000;">PLEASE NOTE - Important update notifications</h3>';

	if($version == '0.9.4-svn2')
	{
		$has_preconfig = true;
		$return .= 'Froxlor-0.9.4-svn2 now enabled the usage of a domain-wildcard entry and subdomains for this domain at once (subdomains are parsed before the main vhost container). ';
		$return .= 'This makes it possible to catch all non-existing subdomains with the main vhost but also have the ability to use subdomains for that domain.<br />';
		$return .= 'If you would like Froxlor to do so with your domains, the update script can set the correct values for existing domains for you. Note: future domains will have wildcard-entries enabled by default no matter how you decide here.<br /><br />';
		$return .= '<strong>Do you want to use wildcard-entries for existing domains?:</strong>&nbsp;';
		$return .= makeyesno('update_domainwildcardentry', '1', '0', '1');
	}

	$return .= '<br /><br />'.makecheckbox('update_changesagreed', '<strong>I have read the update notifications and I am aware of the changes made to my system.</strong>', '1', true, '0', true);
	$return .= '</div>';
	$return .= '<input type="hidden" name="update_preconfig" value="1" />';

	if($has_preconfig) {
		return $return;
	} else {
		return '';
	}
}
