<?php

namespace Froxlor\UI;

class Data
{

	public static function getFormFieldDataEmail($fieldname, $fielddata, $input)
	{
		return self::getFormFieldDataText($fieldname, $fielddata, $input);
	}

	public static function getFormFieldDataUrl($fieldname, $fielddata, $input)
	{
		return self::getFormFieldDataText($fieldname, $fielddata, $input);
	}

	public static function getFormFieldDataText($fieldname, $fielddata, $input)
	{
		if (isset($input[$fieldname])) {
			$newfieldvalue = str_replace("\r\n", "\n", $input[$fieldname]);
		} else {
			$newfieldvalue = $fielddata['default'];
		}

		return $newfieldvalue;
	}

	public static function getFormFieldDataSelect($fieldname, $fielddata, $input)
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

	public static function getFormFieldDataNumber($fieldname, $fielddata, $input)
	{
		if (isset($input[$fieldname])) {
			$newfieldvalue = (int) $input[$fieldname];
		} else {
			$newfieldvalue = (int) $fielddata['default'];
		}

		return $newfieldvalue;
	}

	public static function getFormFieldDataCheckbox($fieldname, $fielddata, $input)
	{
		if (isset($input[$fieldname]) && ($input[$fieldname] === '1' || $input[$fieldname] === 1 || $input[$fieldname] === true || strtolower($input[$fieldname]) === 'yes' || strtolower($input[$fieldname]) === 'ja')) {
			$newfieldvalue = '1';
		} else {
			$newfieldvalue = '0';
		}

		return $newfieldvalue;
	}

	public static function getFormFieldDataImage($fieldname, $fielddata, $input)
	{
		// We always make the system think we have new data to trigger the save function where we actually check everything
		return time();
	}

	public static function manipulateFormFieldDataDate($fieldname, $fielddata, $newfieldvalue)
	{
		if (isset($fielddata['date_timestamp']) && $fielddata['date_timestamp'] === true) {
			$newfieldvalue = strtotime($newfieldvalue);
		}

		return $newfieldvalue;
	}
}
