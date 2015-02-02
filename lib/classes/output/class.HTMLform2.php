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
 * @author     Roman Schmerold <team@froxlor.org> (2015-)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 */
 
class HTMLform2 {
	// Internal var to store form
	private static $_form = '';
	
	/**
	 * genHTMLform function.
	 * 
	 * @access public
	 * @static
	 * @param array $formdata (default: array())
	 * @param array $data (default: array())
	 * @return void
	 */
	public static function genHTMLform($formdata = array(), $data = array()) {
		global $lng, $theme;
		self::$_form = '';
		
		// Parse each group
		foreach ($formdata as $groupdata) {
			if (!isset($groupdata['visible']) || $groupdata['visible'] !== false) {
				// Output Section Heading
				if (isset($groupdata['title'])) {
					$grouptitle = $groupdata['title'];
					eval("self::\$_form .= \"" . getTemplate("htmlform/group_heading", "1") . "\";");
				}

				// Generate Group Fields
				foreach($groupdata['fields'] as $fieldname => $fielddata) {
					if (isset($fielddata['visible'])) {
						if ($fielddata['visible'] == false) {
							continue;
						} elseif ($fielddata['visible'] === 'new' && !empty($data)) {
							continue;
						} elseif ($fielddata['visible'] === 'edit' && empty($data)) {
							continue;
						}
					}
					
					// Set value if given
					if (!empty($data)) {
						$fielddata = self::_setValue($fieldname, $fielddata, $data);
					}
					
					$field = self::_parseDataField($fieldname, $fielddata);
					
					$label = $fielddata['label'] . self::_getMandatoryFlag($fielddata);
					if (isset($fielddata['desc']) && $fielddata['desc'] != "") {
						$desc = $fielddata['desc'];
					} else {
						$desc = '';
					}
					eval("self::\$_form .= \"" . getTemplate("htmlform/skeleton", "1") . "\";");
				}
			}
		}
		
		eval("self::\$_form .= \"" . getTemplate("htmlform/form_end", "1") . "\";");
		
		return self::$_form;
	}
	
	private static function _setValue($fieldname, $fielddata, $data) {
		if (isset($data[$fieldname])) {
			switch($fielddata['type']) {
				case 'checkbox':
					$fielddata['attributes']['checked'] = ($data[$fieldname] == 1) ? true : false;			
					break;
				case 'select':
					$fielddata['selected'] = $data[$fieldname];
					break;
				default:
					$fielddata['value'] = $data[$fieldname];
					break;
			}
		}
		
		return $fielddata;
	}
	
	private static function _parseDataField($fieldname, $fielddata) {
		switch($fielddata['type']) {
			case 'button':
			case 'submit':
			case 'reset':
				return self::_button($fieldname, $fielddata);
				break;
			case 'text':
			case 'password':
			case 'hidden':
			case 'file':
			case 'email':
				return self::_input($fieldname, $fielddata);
				break;
			case 'textul':
				return self::_inputUl($fieldname, $fielddata);
				break;
			case 'radio':
				return self::_inputRadio($fieldname, $fielddata);
				break;
			case 'checkbox':
				return self::_inputCheckbox($fieldname, $fielddata);
				break;
			case 'static':
				return self::_static($fieldname, $fielddata);
				break;
			case 'select':
				return self::_select($fieldname, $fielddata);
				break;
			case 'textarea':
				return self::_textarea($fieldname, $fielddata);
				break;
		}
	}
	
	/**
	 * _parseAttributes function.
	 * 
	 * @access private
	 * @static
	 * @param string $fieldname
	 * @param array $fielddata
	 * @return void
	 */
	private static function _parseAttributes($fieldname, $fielddata) {
		$attributes = array();
		
		// name
		$attributes['name'] = $fieldname;
		$attributes['id'] = $fieldname;
		
		// value
		if (isset($_SESSION['requestData'][$fieldname])) {
			$attributes['value'] = $_SESSION['requestData'][$fieldname];
		} elseif (isset($fielddata['value'])) {
			$attributes['value'] = $fielddata['value'];
		}
		
		if (isset($fielddata['attributes'])) {
			if (isset($fielddata['attributes']['checked']) && $fielddata['attributes']['checked'] !== true) {
				unset($fielddata['attributes']['checked']);
			}
			if (isset($fielddata['attributes']['selected']) && $fielddata['attributes']['selected'] !== true) {
				unset($fielddata['attributes']['selected']);
			}
			if (isset($fielddata['attributes']['readonly']) && $fielddata['attributes']['readonly'] !== true) {
				unset($fielddata['attributes']['readonly']);
			}
			return array_merge($attributes, $fielddata['attributes']);
		} else {
			return $attributes;
		}
	}
	
	/**
	 * _glueAttributes function.
	 * 
	 * @access private
	 * @static
	 * @param array $attributes
	 * @return void
	 */
	private static function _glueAttributes($attributes) {
		$glued = array();
		foreach($attributes as $name => $value) {
			$glued[] = $name . "=\"" . $value . "\"";
		}
		return implode(" ", $glued);
	}
	
	/**
	 * _getMandatoryFlag function.
	 * 
	 * @access private
	 * @static
	 * @param array $fielddata
	 * @return void
	 */
	private static function _getMandatoryFlag($fielddata) {
		if (isset($fielddata['mandatory'])) {
			return '&nbsp;<span class="red">*</span>';
		} elseif (isset($fielddata['mandatory_ex'])) {
			return '&nbsp;<span class="red">**</span>';
		}
		return '';
	}
	
	/**
	 * _button function.
	 * 
	 * @access private
	 * @static
	 * @param string $fieldname
	 * @param array $fielddata (default: array())
	 * @param string $type (default: 'button')
	 * @return void
	 */
	private static function _button($fieldname, $fielddata = array()) {
		$attributes = self::_parseAttributes($fieldname, $fielddata);
		$attributes['type'] = $fielddata['type'];
		$attributes = self::_glueAttributes($attributes);
		
		eval("\$return = \"" . getTemplate("htmlform/button", "1") . "\";");
		return "";
	}
	
	
	/**
	 * _input function.
	 * 
	 * @access private
	 * @static
	 * @param string $fieldname
	 * @param array $fielddata (default: array())
	 * @param string $type (default: "text")
	 * @return void
	 */
	private static function _input($fieldname, $fielddata = array()) {
		$attributes = self::_parseAttributes($fieldname, $fielddata);
		$attributes['type'] = $fielddata['type'];
		$attributes = self::_glueAttributes($attributes);
		
		eval("\$return = \"" . getTemplate("htmlform/input", "1") . "\";");
		return $return;
	}
	
	/**
	 * _inputUl function.
	 * 
	 * @access private
	 * @static
	 * @param string $fieldname
	 * @param array $fielddata (default: array())
	 * @return void
	 */
	private static function _inputUl($fieldname, $fielddata = array()) {
		global $lng;
		
		// Input
		$inputdata = $fielddata;
		$inputdata['value'] = ($inputdata['value'] == -1) ? '' : $inputdata['value'];
		$inputdata['type'] = "text";
		$input = self::_input($fieldname, $inputdata);
		
		// Checkbox
		$checkboxdata = array(
			//'label' => $lng['admin']['stdsubdomain_add'].'?',
			'type' => 'checkbox',
			'sublabel' => $lng['customer']['unlimited'],
			'value' => '-1',
			'attributes' => array(
				'checked' => ($fielddata['value'] == '-1') ? true : false
			)
		);
		
		$checkbox = self::_inputCheckbox($fieldname . "_ul", $checkboxdata);
		
		eval("\$return = \"" . getTemplate("htmlform/textul", "1") . "\";");
		
		return $return;
	}
	
	/**
	 * _inputRadio function.
	 * 
	 * @access private
	 * @static
	 * @param string $fieldname
	 * @param array $fielddata (default: array())
	 * @return void
	 */
	private static function _inputRadio($fieldname, $fielddata = array()) {
		$attributes = self::_parseAttributes($fieldname, $fielddata);
		$attributes['type'] = $fielddata['type'];
		$attributes = self::_glueAttributes($attributes);
		
		// ToDo
		
		eval("\$return = \"" . getTemplate("htmlform/radio", "1") . "\";");
		return $return;
	}
	
	/**
	 * _inputCheckbox function.
	 * 
	 * @access private
	 * @static
	 * @param string $fieldname
	 * @param array $fielddata (default: array())
	 * @return void
	 */
	private static function _inputCheckbox($fieldname, $fielddata = array()) {
		$attributes = self::_parseAttributes($fieldname, $fielddata);
		$attributes['type'] = $fielddata['type'];
		$attributes = self::_glueAttributes($attributes);
		
		$sublabel = $fielddata['sublabel'];
		eval("\$return = \"" . getTemplate("htmlform/checkbox", "1") . "\";");
		return $return;
	}
	
	/**
	 * _static function.
	 * 
	 * @access private
	 * @static
	 * @param string $fieldname
	 * @param array $fielddata (default: array())
	 * @return void
	 */
	private static function _static($fieldname, $fielddata = array()) {
		$value = $fielddata['value'];
		eval("\$return = \"" . getTemplate("htmlform/static", "1") . "\";");
		return $return;
	}
	
	/**
	 * _select function.
	 * 
	 * @access private
	 * @static
	 * @param string $fieldname
	 * @param array $fielddata (default: array())
	 * @return void
	 */
	private static function _select($fieldname, $fielddata = array()) {
		$attributes = self::_parseAttributes($fieldname, $fielddata);
		$attributes = self::_glueAttributes($attributes);
		
		if (isset($fielddata['generate'])) {
			switch($fielddata['generate']) {
				case 'genders':
					$fielddata['values'] = self::_generateGenders($fielddata['selected']);
					break;
				case 'languages':
					$fielddata['values'] = self::_generateLanguages($fielddata['selected']);
					break;
			}
		}
		
		$values = "";
		if (is_array($fielddata['values'])) {
			foreach($fielddata['values'] as $value) {
				$selected = "";
				if ((isset($value['selected']) && $value['selected'] == true) || (isset($fielddata['default']) && $value['value'] == $fielddata['default'])) {
					$selected = " selected";
				}
				$values .= "<option value=\"{$value['value']}\"$selected>{$value['label']}</option>";
			}
		} else {
			$values = $fielddata['values'];
		}
		eval("\$return = \"" . getTemplate("htmlform/select", "1") . "\";");
		return $return;
	}
	
	/**
	 * _textarea function.
	 * 
	 * @access private
	 * @static
	 * @param string $fieldname
	 * @param array $fielddata (default: array())
	 * @return void
	 */
	private static function _textarea($fieldname, $fielddata = array()) {
		$attributes = self::_parseAttributes($fieldname, $fielddata);
		unset($attributes['value']);
		$attributes = self::_glueAttributes($attributes);

		$value = isset($fielddata['value']) ? $fielddata['value'] : "";
		eval("\$return = \"" . getTemplate("htmlform/textarea", "1") . "\";");
		return $return;
	}
	
	private static function _generateGenders($selected = "") {
		global $lng;
		
		$genders = array(
			array(
				"value" => 0,
				"label" => $lng['gender']['undef'],
			),
			array(
				"value" => 1,
				"label" => $lng['gender']['male']
			),
			array(
				"value" => 2,
				"label" => $lng['gender']['female']
			)
		);
		
		// Check if something is selected
		if ($selected != "") {
			foreach ($genders as $key => $value) {
				if ($value['value'] == $selected) {
					$genders[$key]['selected'] = true;
					continue;
				}
			}
		}
		
		return $genders;
	}
	
	private static function _generateLanguages($selected = "") {
		global $languages;
		$retlanguages = array();
		while (list($language_file, $language_name) = each($languages)) {
			$newlng = array(
				"value" => $language_file,
				"label" => $language_name
			);
			
			if ($language_file == $selected) {
				$newlng['selected'] = true;
			}
			
			$retlanguages[] = $newlng;
			
					//$language_options.= makeoption($language_name, $language_file, Settings::Get('panel.standardlanguage'), true);
		}
		
		return $retlanguages;
	}
	
}
