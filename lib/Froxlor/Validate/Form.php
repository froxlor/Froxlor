<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Validate;

class Form
{

	public static function validateFormDefinition($form)
	{
		$returnvalue = false;

		if (is_array($form) && !empty($form) && isset($form['groups']) && is_array($form['groups']) && !empty($form['groups'])) {
			$returnvalue = true;
		}

		return $returnvalue;
	}

	public static function validateFieldDefinition($field)
	{
		$returnvalue = false;

		if (is_array($field) && !empty($field) && isset($field['fields']) && is_array($field['fields']) && !empty($field['fields'])) {
			$returnvalue = true;
		}

		return $returnvalue;
	}

	public static function validateFormField($fieldname, $fielddata, $newfieldvalue)
	{
		$returnvalue = '';
		if (is_array($fielddata) && isset($fielddata['type']) && $fielddata['type'] != '' && method_exists('\\Froxlor\\Validate\\Form\\Data', 'validateFormField' . ucfirst($fielddata['type']))) {
			$returnvalue = call_user_func([
				'\\Froxlor\\Validate\\Form\\Data',
				'validateFormField' . ucfirst($fielddata['type'])
			], $fieldname, $fielddata, $newfieldvalue);
		} else {
			$returnvalue = 'validation method not found';
		}
		return $returnvalue;
	}
}
