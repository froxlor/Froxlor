<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id$
 */

/**
 * Returns HTML Code for two radio buttons with two choices: yes and no
 *
 * @param string Name of HTML-Variable
 * @param string Value which will be returned if user chooses yes
 * @param string Value which will be returned if user chooses no
 * @param string Value which is chosen by default
 * @return string HTML Code
 * @author Florian Lippert <flo@syscp.org>
 */

function makeyesno($name, $yesvalue, $novalue = '', $yesselected = '')
{
	global $lng;
	return '<select class="dropdown_noborder" name="' . $name . '"><option value="' . $yesvalue . '"' . ($yesselected ? ' selected="selected"' : '') . '>' . $lng['panel']['yes'] . '</option><option value="' . $novalue . '"' . ($yesselected ? '' : ' selected="selected"') . '>' . $lng['panel']['no'] . '</option></select>';
}
