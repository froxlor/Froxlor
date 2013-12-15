<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2013 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <d00p@froxlor.org>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    AJAX
 *
 */

function checkPhpInterfaceSetting($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues) {

	$returnvalue = array(FORMFIELDS_PLAUSIBILITY_CHECK_OK);

	if ((int)Settings::Get('system.mod_fcgid') == 1) {
		// now check if we enable a webserver != apache
		if (strtolower($newfieldvalue) != 'apache2') {
			$returnvalue = array(FORMFIELDS_PLAUSIBILITY_CHECK_ERROR, 'fcgidstillenableddeadlock');
		}
	}

	return $returnvalue;
}
