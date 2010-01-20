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
 * @version    $Id: function.makeoption.php 2724 2009-06-07 14:18:02Z flo $
 */

/**
 * Return HTML Code for an option within a <select>
 *
 * @param string The caption
 * @param string The Value which will be returned
 * @param string Values which will be selected by default.
 * @param bool Whether the title may contain html or not
 * @param bool Whether the value may contain html or not
 * @return string HTML Code
 * @author Florian Lippert <flo@syscp.org>
 */

function makeoption($title, $value, $selvalue = NULL, $title_trusted = false, $value_trusted = false)
{
	if($selvalue !== NULL
	   && ((is_array($selvalue) && in_array($value, $selvalue)) || $value == $selvalue))
	{
		$selected = 'selected="selected"';
	}
	else
	{
		$selected = '';
	}

	if(!$title_trusted)
	{
		$title = htmlspecialchars($title);
	}

	if(!$value_trusted)
	{
		$value = htmlspecialchars($value);
	}

	$option = '<option value="' . $value . '" ' . $selected . ' >' . $title . '</option>';
	return $option;
}
