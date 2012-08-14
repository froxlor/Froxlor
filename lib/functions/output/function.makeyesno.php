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
 * Returns HTML Code for two radio buttons with two choices: yes and no
 *
 * @param string Name of HTML-Variable
 * @param string Value which will be returned if user chooses yes
 * @param string Value which will be returned if user chooses no
 * @param string Value which is chosen by default
 * @param bool   Whether this element is disabled or not (default: false)
 * @return string HTML Code
 * @author Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 */

function makeyesno($name, $yesvalue, $novalue = '', $yesselected = '', $disabled = false)
{
	global $lng, $theme;
	
	if($disabled) {
		$d = ' disabled="disabled"';
	} else {
		$d = '';
	}
	
	if (isset($_SESSION['requestData'])) {
		$yesselected = $yesselected & $_SESSION['requestData'][$name];
	}
	
	return '<select class="dropdown_noborder" id="' . $name . '" name="' . $name . '"'
	.$d.'>
	<option value="' . $yesvalue . '"' . ($yesselected ? ' selected="selected"' : '') . '>' 
	. $lng['panel']['yes'] . '</option><option value="' . $novalue . '"' 
	. ($yesselected ? '' : ' selected="selected"') . '>' . $lng['panel']['no'] . '</option></select>';
}
