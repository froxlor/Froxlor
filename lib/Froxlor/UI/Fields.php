<?php
namespace Froxlor\UI;

class Fields
{

	public static function getFormFieldOutputText($fieldname, $fielddata, $do_show = true)
	{
		$label = $fielddata['label'];
		$value = htmlentities($fielddata['value']);
		eval("\$returnvalue = \"" . \Froxlor\UI\Template::getTemplate("formfields/text", true) . "\";");
		return $returnvalue;
	}

	public static function getFormFieldOutputString($fieldname, $fielddata, $do_show = true)
	{
		$label = $fielddata['label'];
		$value = htmlentities($fielddata['value']);
		eval("\$returnvalue = \"" . \Froxlor\UI\Template::getTemplate("formfields/string", true) . "\";");
		return $returnvalue;
	}

	public static function getFormFieldOutputOption($fieldname, $fielddata, $do_show = true)
	{
		$returnvalue = '';

		if (isset($fielddata['option_options']) && is_array($fielddata['option_options']) && ! empty($fielddata['option_options'])) {
			if (isset($fielddata['option_mode']) && $fielddata['option_mode'] == 'multiple') {
				$multiple = true;
				$fielddata['value'] = explode(',', $fielddata['value']);
			} else {
				$multiple = false;
			}

			$label = $fielddata['label'];
			$options_array = $fielddata['option_options'];
			$options = '';
			foreach ($options_array as $value => $title) {
				$options .= \Froxlor\UI\HTML::makeoption($title, $value, $fielddata['value']);
			}
			eval("\$returnvalue = \"" . \Froxlor\UI\Template::getTemplate("formfields/option", true) . "\";");
		}

		return $returnvalue;
	}

	public static function prefetchFormFieldDataOption($fieldname, $fielddata)
	{
		$returnvalue = array();

		if ((! isset($fielddata['option_options']) || ! is_array($fielddata['option_options']) || empty($fielddata['option_options'])) && (isset($fielddata['option_options_method']))) {
			$returnvalue['options'] = call_user_func($fielddata['option_options_method']);
		}

		return $returnvalue;
	}

	public static function getFormFieldOutputInt($fieldname, $fielddata, $do_show = true)
	{
		return self::getFormFieldOutputString($fieldname, $fielddata, $do_show);
	}

	public static function getFormFieldOutputHiddenString($fieldname, $fielddata, $do_show = true)
	{
		$label = $fielddata['label'];
		$value = htmlentities($fielddata['value']);
		eval("\$returnvalue = \"" . \Froxlor\UI\Template::getTemplate("formfields/hiddenstring", true) . "\";");
		return $returnvalue;
	}

	public static function getFormFieldOutputHidden($fieldname, $fielddata)
	{
		$returnvalue = '<input type="hidden" name="' . $fieldname . '" value="' . htmlentities($fielddata['value']) . '" />';

		if (isset($fielddata['label']) && $fielddata['label'] != '') {
			$label = $fielddata['label'];
			$value = htmlentities($fielddata['value']);
			eval("\$returnvalue .= \"" . \Froxlor\UI\Template::getTemplate("formfields/hidden", true) . "\";");
		}

		return $returnvalue;
	}

	public static function getFormFieldOutputFile($fieldname, $fielddata, $do_show = true)
	{
		$label = $fielddata['label'];
		$value = htmlentities($fielddata['value']);
		eval("\$returnvalue = \"" . \Froxlor\UI\Template::getTemplate("formfields/text", true) . "\";");
		return $returnvalue;
	}

	public static function getFormFieldOutputDate($fieldname, $fielddata, $do_show = true)
	{
		if (isset($fielddata['date_timestamp']) && $fielddata['date_timestamp'] === true) {
			$fielddata['value'] = date('Y-m-d', $fielddata['value']);
		}

		return self::getFormFieldOutputString($fieldname, $fielddata, $do_show);
	}

	public static function getFormFieldOutputBool($fieldname, $fielddata, $do_show = true)
	{
		$label = $fielddata['label'];
		$boolswitch = \Froxlor\UI\HTML::makeyesno($fieldname, '1', '0', $fielddata['value']);
		eval("\$returnvalue = \"" . \Froxlor\UI\Template::getTemplate("formfields/bool", true) . "\";");
		return $returnvalue;
	}
}
