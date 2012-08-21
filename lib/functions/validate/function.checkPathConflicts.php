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

function checkPathConflicts($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
{
	global $settings, $theme;
	if((int)$settings['system']['mod_fcgid'] == 1)
	{
		/**
		 * fcgid-configdir has changed ->
		 * check against customer-doc-prefix
		 */
		if($fieldname == "system_mod_fcgid_configdir") 
		{
			$newdir = makeCorrectDir($newfieldvalue);
			$cdir = makeCorrectDir($settings['system']['documentroot_prefix']);
		}
		/**
		 * customer-doc-prefix has changed ->
		 * check against fcgid-configdir
		 */
		elseif($fieldname == "system_documentroot_prefix")
		{
			$newdir = makeCorrectDir($newfieldvalue);
			$cdir = makeCorrectDir($settings['system']['mod_fcgid_configdir']);
		}

		// neither dir can be within the other nor can they be equal
		if(substr($newdir, 0, strlen($cdir)) == $cdir
			|| substr($cdir, 0, strlen($newdir)) == $newdir
			|| $newdir == $cdir
		) {
			$returnvalue = array(FORMFIELDS_PLAUSIBILITY_CHECK_ERROR, 'fcgidpathcannotbeincustomerdoc');
		}
		else
		{
			$returnvalue = array(FORMFIELDS_PLAUSIBILITY_CHECK_OK);
		}
	}
	else
	{
		$returnvalue = array(FORMFIELDS_PLAUSIBILITY_CHECK_OK);
	}

	return $returnvalue;
}
