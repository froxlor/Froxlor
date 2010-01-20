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
 * @version    $Id: function.validateFormFieldString.php 2724 2009-06-07 14:18:02Z flo $
 */

function validateFormFieldString($fieldname, $fielddata, $newfieldvalue)
{
	if(isset($fielddata['string_delimiter']) && $fielddata['string_delimiter'] != '')
	{
		$newfieldvalues = explode($fielddata['string_delimiter'], $newfieldvalue);
		unset($fielddata['string_delimiter']);

		$returnvalue = true;
		foreach($newfieldvalues as $single_newfieldvalue)
		{
			$single_returnvalue = validateFormFieldString($fieldname, $fielddata, $single_newfieldvalue);
			if($single_returnvalue !== true)
			{
				$returnvalue = $single_returnvalue;
				break;
			}
		}
	}
	else
	{
		$returnvalue = false;

		if(isset($fielddata['string_type']) && $fielddata['string_type'] == 'mail')
		{
			$returnvalue = (filter_var($newfieldvalue, FILTER_VALIDATE_EMAIL) == $newfieldvalue);
		}
		elseif(isset($fielddata['string_type']) && $fielddata['string_type'] == 'url')
		{
			$returnvalue = validateUrl($newfieldvalue);
		}
		elseif(isset($fielddata['string_type']) && $fielddata['string_type'] == 'dir')
		{
			$returnvalue = ($newfieldvalue == makeCorrectDir($newfieldvalue));
		}
		elseif(isset($fielddata['string_type']) && $fielddata['string_type'] == 'file')
		{
			$returnvalue = ($newfieldvalue == makeCorrectFile($newfieldvalue));
		}
		elseif(isset($fielddata['string_type']) && $fielddata['string_type'] == 'filedir')
		{
			$returnvalue = (($newfieldvalue == makeCorrectDir($newfieldvalue)) || ($newfieldvalue == makeCorrectFile($newfieldvalue)));
		}
		elseif(preg_match('/^[^\r\n\t\f\0]*$/D', $newfieldvalue))
		{
			$returnvalue = true;
		}

		if(isset($fielddata['string_regexp']) && $fielddata['string_regexp'] != '')
		{
			if(preg_match($fielddata['string_regexp'], $newfieldvalue))
			{
				$returnvalue = true;
			}
			else
			{
				$returnvalue = false;
			}
		}

		if(isset($fielddata['string_emptyallowed']) && $fielddata['string_emptyallowed'] === true && $newfieldvalue === '')
		{
			$returnvalue = true;
		}
		elseif(isset($fielddata['string_emptyallowed']) && $fielddata['string_emptyallowed'] === false && $newfieldvalue === '')
		{
			$returnvalue = 'stringmustntbeempty';
		}
	}
	
	if($returnvalue === true)
	{
		return true;
	}
	elseif($returnvalue === false)
	{
		return 'stringformaterror';
	}
	else
	{
		return $returnvalue;
	}
}
