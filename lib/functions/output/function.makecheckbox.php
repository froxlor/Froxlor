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
 * Return HTML Code for a checkbox
 *
 * @param string The fieldname
 * @param string The captions
 * @param string The Value which will be returned
 * @param bool Add a <br /> at the end of the checkbox
 * @param string Values which will be selected by default
 * @param bool Whether the title may contain html or not
 * @param bool Whether the value may contain html or not
 * @return string HTML Code
 * @author Michael Kaufmann <mkaufmann@nutime.de>
 */

function makecheckbox($name, $title, $value, $break = false, $selvalue = NULL, $title_trusted = false, $value_trusted = false)
{
	if($selvalue !== NULL
	   && $value == $selvalue)
	{
		$checked = 'checked="checked"';
	}
	else if(isset($_SESSION['requestData'][$name]))
	{
		$checked = 'checked="checked"';
	}
	else
	{
		$checked = '';
	}

	if(!$title_trusted)
	{
		$title = htmlspecialchars($title);
	}

	if(!$value_trusted)
	{
		$value = htmlspecialchars($value);
	}

	$checkbox = '<label class="nobr"><input type="checkbox" name="' . $name . '" value="' . $value . '" ' . $checked . ' />&nbsp;' . $title . '</label>';

	if($break)
	{
		$checkbox.= '<br />';
	}

	return $checkbox;
}
