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

function validateFormFieldHiddenString($fieldname, $fielddata, $newfieldvalue)
{
	if(isset($fielddata['string_delimiter']) && $fielddata['string_delimiter'] != '')
	{
		$newfieldvalues = explode($fielddata['string_delimiter'], $newfieldvalue);
		unset($fielddata['string_delimiter']);

		$returnvalue = true;
		foreach($newfieldvalues as $single_newfieldvalue)
		{
			/**
	 		 * don't use tabs in value-fields, #81
	 		 */
			$single_newfieldvalue = str_replace("\t", " ", $single_newfieldvalue);
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

		/**
 		 * don't use tabs in value-fields, #81
 		 */
		$newfieldvalue = str_replace("\t", " ", $newfieldvalue);

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
			// add trailing slash to validate path if needed
			// refs #331
			if(substr($newfieldvalue, -1) != '/') {
				$newfieldvalue.= '/';
			}
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