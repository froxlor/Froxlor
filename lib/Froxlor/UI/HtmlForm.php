<?php
namespace Froxlor\UI;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Classes
 *         
 */
class HtmlForm
{

	/**
	 * internal tmp-variable to store form
	 *
	 * @var string
	 */
	private static $form = '';

	private static $filename = '';

	public static function genHTMLForm($data = array())
	{
		global $lng, $theme;
		$nob = false;

		self::$form = '';

		foreach ($data as $fdata) {
			$sections = $fdata['sections'];

			foreach ($sections as $section) {
				/*
				 * here be section title & image
				 */
				$title = $section['title'];
				$image = $section['image'];

				if (isset($section['visible']) && $section['visible'] === false) {
					continue;
				}

				if (! isset($section['nobuttons']) || $section['nobuttons'] == false) {
					eval("self::\$form .= \"" . Template::getTemplate("misc/form/table_section", "1") . "\";");
				} else {
					$nob = true;
				}

				$nexto = false;
				foreach ($section['fields'] as $fieldname => $fielddata) {
					if (isset($fielddata['visible']) && $fielddata['visible'] === false) {
						continue;
					}

					if ($nexto === false || (isset($fielddata['next_to']) && $nexto['field'] != $fielddata['next_to'])) {
						$label = $fielddata['label'];
						$desc = (isset($fielddata['desc']) ? $fielddata['desc'] : '');
						$style = (isset($fielddata['style']) ? ' class="' . $fielddata['style'] . '"' : '');
						$mandatory = self::getMandatoryFlag($fielddata);
						$data_field = self::parseDataField($fieldname, $fielddata);
						if (isset($fielddata['has_nextto'])) {
							$nexto = array(
								'field' => $fieldname
							);
							$data_field .= '{NEXTTOFIELD_' . $fieldname . '}';
						} else {
							$nexto = false;
						}
						eval("self::\$form .= \"" . Template::getTemplate("misc/form/table_row", "1") . "\";");
					} else {
						$data_field = self::parseDataField($fieldname, $fielddata);
						$data_field = str_replace("\t", "", $data_field);
						$data_field = $fielddata['next_to_prefix'] . $data_field;
						self::$form = str_replace('{NEXTTOFIELD_' . $fielddata['next_to'] . '}', $data_field, self::$form);
						$nexto = false;
					}
				}
			}
		}

		// add save/reset buttons at the end of the form
		if (! $nob) {
			eval("self::\$form .= \"" . Template::getTemplate("misc/form/table_end", "1") . "\";");
		}

		return self::$form;
	}

	private static function parseDataField($fieldname, $data = array())
	{
		switch ($data['type']) {
			case 'text':
				return self::textBox($fieldname, $data);
				break;
			case 'textul':
				return self::textBox($fieldname, $data, 'text', true);
				break;
			case 'password':
				return self::textBox($fieldname, $data, 'password');
				break;
			case 'hidden':
				return self::textBox($fieldname, $data, 'hidden');
				break;
			case 'yesno':
				return self::yesnoBox($data);
				break;
			case 'select':
				return self::selectBox($fieldname, $data);
				break;
			case 'label':
				return self::labelField($data);
				break;
			case 'textarea':
				return self::textArea($fieldname, $data);
				break;
			case 'checkbox':
				return self::checkbox($fieldname, $data);
				break;
			case 'file':
				return self::file($fieldname, $data);
				break;
			case 'int':
				return self::int($fieldname, $data);
				break;
		}
	}

	private static function getMandatoryFlag($data = array())
	{
		if (isset($data['mandatory'])) {
			return '&nbsp;<span class="red">*</span>';
		} elseif (isset($data['mandatory_ex'])) {
			return '&nbsp;<span class="red">**</span>';
		}
		return '';
	}

	private static function textBox($fieldname = '', $data = array(), $type = 'text', $unlimited = false)
	{
		$return = '';
		$extras = '';
		if (isset($data['maxlength'])) {
			$extras .= ' maxlength="' . $data['maxlength'] . '"';
		}
		if (isset($data['size'])) {
			$extras .= ' size="' . $data['size'] . '"';
		}
		if (isset($data['autocomplete'])) {
			$extras .= ' autocomplete="' . $data['autocomplete'] . '"';
		}

		// add support to save reloaded forms
		if (isset($data['value'])) {
			$value = $data['value'];
		} elseif (isset($_SESSION['requestData'][$fieldname])) {
			$value = $_SESSION['requestData'][$fieldname];
		} else {
			$value = '';
		}

		$ulfield = ($unlimited == true ? '&nbsp;' . $data['ul_field'] : '');
		if (isset($data['display']) && $data['display'] != '') {
			$ulfield = '<strong>' . $data['display'] . '</strong>';
		}

		eval("\$return = \"" . Template::getTemplate("misc/form/input_text", "1") . "\";");
		return $return;
	}

	private static function textArea($fieldname = '', $data = array())
	{
		$return = '';
		$extras = '';
		if (isset($data['cols'])) {
			$extras .= ' cols="' . $data['cols'] . '"';
		}
		if (isset($data['rows'])) {
			$extras .= ' rows="' . $data['rows'] . '"';
		}

		// add support to save reloaded forms
		if (isset($data['value'])) {
			$value = $data['value'];
		} elseif (isset($_SESSION['requestData'][$fieldname])) {
			$value = $_SESSION['requestData'][$fieldname];
		} else {
			$value = '';
		}
		trim($value);

		eval("\$return = \"" . Template::getTemplate("misc/form/input_textarea", "1") . "\";");
		return $return;
	}

	private static function yesnoBox($data = array())
	{
		return $data['yesno_var'];
	}

	private static function labelField($data = array())
	{
		return $data['value'];
	}

	private static function selectBox($fieldname = '', $data = array())
	{
		// add support to save reloaded forms
		if (isset($data['select_var'])) {
			$select_var = $data['select_var'];
		} elseif (isset($_SESSION['requestData'][$fieldname])) {
			$select_var = $_SESSION['requestData'][$fieldname];
		} else {
			$select_var = '';
		}

		return '<select
				id="' . $fieldname . '"
						name="' . $fieldname . '"
								' . (isset($data['class']) ? ' class="' . $data['class'] . '" ' : '') . '
										>' . $select_var . '</select>';
	}

	/**
	 * Function to generate checkboxes.
	 *
	 * <code>
	 * $data = array(
	 * 'label' => $lng['customer']['email_imap'],
	 * 'type' => 'checkbox',
	 * 'values' => array(
	 * array( 'label' => 'active',
	 * 'value' => '1'
	 * )
	 * ),
	 * 'value' => array('1'),
	 * 'mandatory' => true
	 * )
	 * </code>
	 *
	 * @param string $fieldname
	 *        	contains the fieldname
	 * @param array $data
	 *        	contains the data array
	 */
	private static function checkbox($fieldname = '', $data = array())
	{
		// $data['value'] contains checked items
		$checked = array();
		if (isset($data['value'])) {
			$checked = $data['value'];
		}

		if (isset($_SESSION['requestData'])) {
			if (isset($_SESSION['requestData'][$fieldname])) {
				$checked = array(
					$_SESSION['requestData'][$fieldname]
				);
			}
		}

		// default value is none, so the checkbox isn't an array
		$isArray = '';

		if (count($data['values']) > 1 || (isset($data['is_array']) && $data['is_array'] == 1)) {
			$isArray = '[]';
		}

		// will contain the output
		$output = "";
		foreach ($data['values'] as $val) {
			$key = $val['label'];
			// is this box checked?
			$isChecked = '';
			if (is_array($checked) && count($checked) > 0) {
				foreach ($checked as $tmp) {
					if ($tmp == $val['value']) {
						$isChecked = ' checked="checked" ';
						break;
					}
				}
			}
			$output .= '<label>';
			if (empty($isArray)) {
				$output .= '<input type="hidden" name="' . $fieldname . '" value="0" />';
			}
			$output .= '<input type="checkbox" name="' . $fieldname . $isArray . '" value="' . $val['value'] . '" ' . $isChecked . '/>';
			$output .= $key . '</label>';
		}

		return $output;
	}

	private static function file($fieldname = '', $data = array())
	{
		$return = '';
		$extras = '';
		if (isset($data['maxlength'])) {
			$extras .= ' maxlength="' . $data['maxlength'] . '"';
		}

		// add support to save reloaded forms
		if (isset($data['value'])) {
			$value = $data['value'];
		} elseif (isset($_SESSION['requestData'][$fieldname])) {
			$value = $_SESSION['requestData'][$fieldname];
		} else {
			$value = '';
		}

		if (isset($data['display']) && $data['display'] != '') {
			$ulfield = '<strong>' . $data['display'] . '</strong>';
		}

		eval("\$return = \"" . Template::getTemplate("misc/form/input_file", "1") . "\";");
		return $return;
	}

	private static function int($fieldname = '', $data = array())
	{
		$return = '';
		$extras = '';
		if (isset($data['int_min'])) {
			$extras .= ' min="' . $data['int_min'] . '"';
		}
		if (isset($data['int_max'])) {
			$extras .= ' max="' . $data['int_max'] . '"';
		}

		// add support to save reloaded forms
		if (isset($data['value'])) {
			$value = $data['value'];
		} elseif (isset($_SESSION['requestData'][$fieldname])) {
			$value = $_SESSION['requestData'][$fieldname];
		} else {
			$value = '';
		}

		$type = 'number';
		$ulfield = '';
		eval("\$return = \"" . Template::getTemplate("misc/form/input_text", "1") . "\";");
		return $return;
	}
}
