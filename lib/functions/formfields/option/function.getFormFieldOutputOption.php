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

function getFormFieldOutputOption($fieldname, $fielddata)
{
	$returnvalue = '';
	
	if(isset($fielddata['option_options']) && is_array($fielddata['option_options']) && !empty($fielddata['option_options']))
	{
		if(isset($fielddata['option_mode']) && $fielddata['option_mode'] == 'multiple')
		{
			$multiple = true;
			$fielddata['value'] = explode(',', $fielddata['value']);
		}
		else
		{
			$multiple = false;
		}

		$label = $fielddata['label'];
		$options_array = $fielddata['option_options'];
		$options = '';
		foreach($options_array as $value => $title)
		{
			$options .= makeoption($title, $value, $fielddata['value']);
		}
		eval("\$returnvalue = \"" . getTemplate("formfields/option", true) . "\";");
	}

	return $returnvalue;
}
