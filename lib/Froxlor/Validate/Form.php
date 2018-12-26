<?php
namespace Froxlor\Validate;

class Form
{

	public static function validateFormDefinition($form)
	{
		$returnvalue = false;

		if (is_array($form) && ! empty($form) && isset($form['groups']) && is_array($form['groups']) && ! empty($form['groups'])) {
			$returnvalue = true;
		}

		return $returnvalue;
	}

	public static function validateFieldDefinition($field)
	{
		$returnvalue = false;

		if (is_array($field) && ! empty($field) && isset($field['fields']) && is_array($field['fields']) && ! empty($field['fields'])) {
			$returnvalue = true;
		}

		return $returnvalue;
	}

	public static function validateFormField($fieldname, $fielddata, $newfieldvalue)
	{
		$returnvalue = '';
		if (is_array($fielddata) && isset($fielddata['type']) && $fielddata['type'] != '' && method_exists('\\Froxlor\\Validate\\Form\\Data', 'validateFormField' . ucfirst($fielddata['type']))) {
			$returnvalue = call_user_func(array(
				'\\Froxlor\\Validate\\Form\\Data',
				'validateFormField' . ucfirst($fielddata['type'])
			), $fieldname, $fielddata, $newfieldvalue);
		} else {
			$returnvalue = 'validation method not found';
		}
		return $returnvalue;
	}
}
