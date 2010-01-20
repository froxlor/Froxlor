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
 * @version    $Id: function.getFormFieldOutputOption.php 2724 2009-06-07 14:18:02Z flo $
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
