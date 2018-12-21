<?php
namespace Froxlor\I18N;

class Lang
{

	private static $lng = array();

	/**
	 *
	 * @param array $lng
	 */
	public static function setLanguageArray($lng = array())
	{
		self::$lng = $lng;
	}

	/**
	 *
	 * @return array
	 */
	public static function getAll()
	{
		return self::$lng;
	}

}