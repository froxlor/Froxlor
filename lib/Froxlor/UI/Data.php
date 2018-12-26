<?php
namespace Froxlor\UI;

class Data
{

	public static function getFormFieldDataText($fieldname, $fielddata, $input)
	{
		if (isset($input[$fieldname])) {
			$newfieldvalue = str_replace("\r\n", "\n", $input[$fieldname]);
		} else {
			$newfieldvalue = $fielddata['default'];
		}

		return $newfieldvalue;
	}

	public static function getFormFieldDataOption($fieldname, $fielddata, $input)
	{
		if (isset($input[$fieldname])) {
			$newfieldvalue = $input[$fieldname];
		} else {
			$newfieldvalue = $fielddata['default'];
		}

		if (is_array($newfieldvalue)) {
			$newfieldvalue = implode(',', $newfieldvalue);
		}

		return $newfieldvalue;
	}

	public static function getFormFieldDataInt($fieldname, $fielddata, $input)
	{
		if (isset($input[$fieldname])) {
			$newfieldvalue = (int) $input[$fieldname];
		} else {
			$newfieldvalue = (int) $fielddata['default'];
		}

		return $newfieldvalue;
	}

	public static function getFormFieldDataBool($fieldname, $fielddata, $input)
	{
		if (isset($input[$fieldname]) && ($input[$fieldname] === '1' || $input[$fieldname] === 1 || $input[$fieldname] === true || strtolower($input[$fieldname]) === 'yes' || strtolower($input[$fieldname]) === 'ja')) {
			$newfieldvalue = '1';
		} else {
			$newfieldvalue = '0';
		}

		return $newfieldvalue;
	}

	public static function manipulateFormFieldDataDate($fieldname, $fielddata, $newfieldvalue)
	{
		if (isset($fielddata['date_timestamp']) && $fielddata['date_timestamp'] === true) {
			$newfieldvalue = strtotime($newfieldvalue);
		}

		return $newfieldvalue;
	}
}
