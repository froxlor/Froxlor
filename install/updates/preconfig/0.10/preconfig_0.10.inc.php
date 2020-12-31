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
 * @package    Updater
 *
 */

/**
 * checks if the new-version has some updating to do
 *
 * @param boolean $has_preconfig
 *        	pointer to check if any preconfig has to be output
 * @param string $return
 *        	pointer to output string
 * @param string $current_version
 *        	current froxlor version
 *        	
 * @return null
 */
function parseAndOutputPreconfig2(&$has_preconfig, &$return, $current_version, $current_db_version)
{
	global $lng;

	if (versionInUpdate($current_db_version, '202004140')) {
		$has_preconfig = true;
		$description = 'Froxlor can now optionally validate the dns entries of domains that request Lets Encrypt certificates to reduce dns-related problems (e.g. freshly registered domain or updated a-record).<br />';
		$question = '<strong>Validate DNS of domains when using Lets Encrypt&nbsp;';
		$question .= \Froxlor\UI\HTML::makeyesno('system_le_domain_dnscheck', '1', '0', '1');

		eval("\$return.=\"" . \Froxlor\UI\Template::getTemplate("update/preconfigitem") . "\";");
	}
}
