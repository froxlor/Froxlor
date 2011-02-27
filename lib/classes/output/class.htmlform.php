<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 * @version    $Id: class.htmlform.php 130 2010-12-22 00:54:11Z d00p $
 */

class htmlform 
{
	/**
	 * internal tmp-variable to store form
	 * @var string
	 */
	private static $_form = '';
	private static $_filename = '';

	public static function genHTMLForm($data = array())
	{
		global $lng;

		self::$_form = '';

		foreach($data as $fdata)
		{
			$sections = $fdata['sections'];

			foreach($sections as $section)
			{
				/*
				 * here be section title & image
				 */
				$title = $section['title'];
				$image = $section['image'];

				if(isset($section['visible']) && $section['visible'] === false)
				{
					continue;
				}
	
				eval("self::\$_form .= \"" . getTemplate("misc/form/table_section", "1") . "\";");

				$nexto = false;
				foreach($section['fields'] as $fieldname => $fielddata)
				{
					if(isset($fielddata['visible']) && $fielddata['visible'] === false)
					{
						continue;
					}

					if ($nexto === false || (isset($fielddata['next_to']) && $nexto['field'] != $fielddata['next_to'])) {
						$label = $fielddata['label'];
						$desc = (isset($fielddata['desc']) ? $fielddata['desc'] : '');
						$style = (isset($fielddata['style']) ? ' style="'.$fielddata['style'].'"' : '');
						$mandatory = self::_getMandatoryFlag($fielddata);
						$data_field = self::_parseDataField($fieldname, $fielddata);
						$data_field = str_replace("\n", "", $data_field);
						$data_field = str_replace("\t", "", $data_field);
						if (isset($fielddata['has_nextto'])) {
							$nexto = array('field' => $fieldname);
							$data_field.='{NEXTTOFIELD_'.$fieldname.'}';
						} else {
							$nexto = false;
						}
						eval("self::\$_form .= \"" . getTemplate("misc/form/table_row", "1") . "\";");
					} else {
						$data_field = self::_parseDataField($fieldname, $fielddata);
						$data_field = str_replace("\n", "", $data_field);
						$data_field = str_replace("\t", "", $data_field);
						$data_field = $fielddata['next_to_prefix'].$data_field;
						self::$_form = str_replace(
							'{NEXTTOFIELD_'.$fielddata['next_to'].'}',
							$data_field,
							self::$_form
						);
						$nexto = false;
					}
				}
			}
		}
		
		return self::$_form;
	}

	private static function _parseDataField($fieldname, $data = array())
	{
		switch($data['type'])
		{
			case 'text':
				return self::_textBox($fieldname, $data); break;
			case 'textul':
				return self::_textBox($fieldname, $data, 'text', true); break;
			case 'password':
				return self::_textBox($fieldname, $data, 'password'); break;
			case 'hidden':
				return self::_textBox($fieldname, $data, 'hidden'); break;
			case 'yesno':
				return self::_yesnoBox($data); break;
			case 'select':
				return self::_selectBox($fieldname, $data); break;
			case 'label':
				return self::_labelField($data); break;
			case 'textarea':
				return self::_textArea($fieldname, $data); break;
		}
	}

	private static function _getMandatoryFlag($data = array())
	{
		if(isset($data['mandatory']))
		{
			return '&nbsp;<span style="color:#ff0000;">*</span>';
		}
		elseif(isset($data['mandatory_ex']))
		{
			return '&nbsp;<span style="color:#ff0000;">**</span>';
		}
		return '';
	}

	private static function _textBox($fieldname = '', $data = array(), $type = 'text', $unlimited = false)
	{
		$return = '';
		$extras = '';
		if(isset($data['maxlength'])) {
			$extras .= ' maxlength="'.$data['maxlength'].'"';
		}
		if(isset($data['size'])) {
			$extras .= ' size="'.$data['size'].'"';
		}

		$value = isset($data['value']) ? $data['value'] : '';
		$ulfield = ($unlimited == true ? '&nbsp;'.$data['ul_field'] : '');
		if(isset($data['display']) && $data['display'] != '')
		{
			$ulfield = '<strong>'.$data['display'].'</strong>';
		}

		eval("\$return = \"" . getTemplate("misc/form/input_text", "1") . "\";");
		return $return;
	}

	private static function _textArea($fieldname = '', $data = array())
	{
		$return = '';
		$extras = '';
		if(isset($data['cols'])) {
			$extras .= ' cols="'.$data['cols'].'"';
		}
		if(isset($data['rows'])) {
			$extras .= ' rows="'.$data['rows'].'"';
		}
		$value = isset($data['value']) ? $data['value'] : '';

		eval("\$return = \"" . getTemplate("misc/form/input_textarea", "1") . "\";");
		return $return;
	}

	private static function _yesnoBox($data = array())
	{
		return $data['yesno_var'];
	}
	
	private static function _labelField($data = array())
	{
		return $data['value'];
	}

	private static function _selectBox($fieldname = '', $data = array())
	{
		return '<select 
			id="'.$fieldname.'" 
			name="'.$fieldname.'" 
			'.(isset($data['class']) ? ' class="'.$data['class'] .'" ' : '').'
			>'
			.$data['select_var'].
			'</select>';
	}
}
