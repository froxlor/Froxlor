<?php
namespace Froxlor\UI;

class HTML
{

	/**
	 * Build Navigation Sidebar
	 *
	 * @param
	 *        	array navigation data
	 * @param
	 *        	array userinfo the userinfo of the user
	 * @return string the content of the navigation bar
	 *        
	 * @author Florian Lippert <flo@syscp.org>
	 */
	public static function buildNavigation($navigation, $userinfo)
	{
		global $theme;

		$returnvalue = '';

		// sanitize user-given input (url-manipulation)
		if (isset($_GET['page']) && is_array($_GET['page'])) {
			$_GET['page'] = (string) $_GET['page'][0];
		}
		if (isset($_GET['action']) && is_array($_GET['action'])) {
			$_GET['action'] = (string) $_GET['action'][0];
		}

		foreach ($navigation as $box) {
			if ((! isset($box['show_element']) || $box['show_element'] === true) && (! isset($box['required_resources']) || $box['required_resources'] == '' || (isset($userinfo[$box['required_resources']]) && ((int) $userinfo[$box['required_resources']] > 0 || $userinfo[$box['required_resources']] == '-1')))) {
				$navigation_links = '';
				foreach ($box['elements'] as $element_id => $element) {
					if ((! isset($element['show_element']) || $element['show_element'] === true) && (! isset($element['required_resources']) || $element['required_resources'] == '' || (isset($userinfo[$element['required_resources']]) && ((int) $userinfo[$element['required_resources']] > 0 || $userinfo[$element['required_resources']] == '-1')))) {
						$target = '';
						$active = '';
						$navurl = '#';
						if (isset($element['url']) && trim($element['url']) != '') {
							// append sid only to local

							if (! preg_match('/^https?\:\/\//', $element['url']) && (isset($userinfo['hash']) && $userinfo['hash'] != '')) {
								// generate sid with ? oder &

								if (strpos($element['url'], '?') !== false) {
									$element['url'] .= '&s=' . $userinfo['hash'];
								} else {
									$element['url'] .= '?s=' . $userinfo['hash'];
								}
							}

							if (isset($element['new_window']) && $element['new_window'] == true) {
								$target = ' target="_blank"';
							}

							if (isset($_GET['page']) && substr_count($element['url'], "page=" . $_GET['page']) > 0 && substr_count($element['url'], basename($_SERVER["SCRIPT_FILENAME"])) > 0 && isset($_GET['action']) && substr_count($element['url'], "action=" . $_GET['action']) > 0) {
								$active = ' active';
							} elseif (isset($_GET['page']) && substr_count($element['url'], "page=" . $_GET['page']) > 0 && substr_count($element['url'], basename($_SERVER["SCRIPT_FILENAME"])) > 0 && substr_count($element['url'], "action=") == 0 && ! isset($_GET['action'])) {
								$active = ' active';
							}

							$navurl = htmlspecialchars($element['url']);
							$navlabel = $element['label'];
						} else {
							$navlabel = $element['label'];
						}

						eval("\$navigation_links .= \"" . \Froxlor\UI\Template::getTemplate("navigation_link", 1) . "\";");
					}
				}

				if ($navigation_links != '') {
					$target = '';
					if (isset($box['url']) && trim($box['url']) != '') {
						// append sid only to local

						if (! preg_match('/^https?\:\/\//', $box['url']) && (isset($userinfo['hash']) && $userinfo['hash'] != '')) {
							// generate sid with ? oder &

							if (strpos($box['url'], '?') !== false) {
								$box['url'] .= '&s=' . $userinfo['hash'];
							} else {
								$box['url'] .= '?s=' . $userinfo['hash'];
							}
						}

						if (isset($box['new_window']) && $box['new_window'] == true) {
							$target = ' target="_blank"';
						}

						$navurl = htmlspecialchars($box['url']);
						$navlabel = $box['label'];
					} else {
						$navurl = "#";
						$navlabel = $box['label'];
					}

					eval("\$returnvalue .= \"" . \Froxlor\UI\Template::getTemplate("navigation_element", 1) . "\";");
				}
			}
		}

		return $returnvalue;
	}

	/**
	 * Return HTML Code for a checkbox
	 *
	 * @param string $name
	 *        	The fieldname
	 * @param string $title
	 *        	The captions
	 * @param string $value
	 *        	The Value which will be returned
	 * @param bool $break
	 *        	Add a <br /> at the end of the checkbox
	 * @param string $selvalue
	 *        	Values which will be selected by default
	 * @param bool $title_trusted
	 *        	Whether the title may contain html or not
	 * @param bool $value_trusted
	 *        	Whether the value may contain html or not
	 *        	
	 * @return string HTML Code
	 */
	public static function makecheckbox($name, $title, $value, $break = false, $selvalue = null, $title_trusted = false, $value_trusted = false)
	{
		if ($selvalue !== null && $value == $selvalue) {
			$checked = 'checked="checked"';
		} elseif (isset($_SESSION['requestData'][$name])) {
			$checked = 'checked="checked"';
		} else {
			$checked = '';
		}

		if (! $title_trusted) {
			$title = htmlspecialchars($title);
		}

		if (! $value_trusted) {
			$value = htmlspecialchars($value);
		}

		$checkbox = '<label class="nobr"><input type="checkbox" name="' . $name . '" value="' . $value . '" ' . $checked . ' />&nbsp;' . $title . '</label>';

		if ($break) {
			$checkbox .= '<br />';
		}

		return $checkbox;
	}

	/**
	 * Return HTML Code for an option within a <select>
	 *
	 * @param string $title
	 *        	The caption
	 * @param string $value
	 *        	The Value which will be returned
	 * @param string $selvalue
	 *        	Values which will be selected by default.
	 * @param bool $title_trusted
	 *        	Whether the title may contain html or not
	 * @param bool $value_trusted
	 *        	Whether the value may contain html or not
	 * @param int $id
	 * @param bool $disabled
	 *
	 * @return string HTML Code
	 */
	public static function makeoption($title, $value, $selvalue = null, $title_trusted = false, $value_trusted = false, $id = null, $disabled = false)
	{
		if ($selvalue !== null && ((is_array($selvalue) && in_array($value, $selvalue)) || $value == $selvalue)) {
			$selected = 'selected="selected"';
		} else {
			$selected = '';
		}

		if ($disabled) {
			$selected .= ' disabled="disabled"';
		}

		if (! $title_trusted) {
			$title = htmlspecialchars($title);
		}

		if (! $value_trusted) {
			$value = htmlspecialchars($value);
		}

		$id_str = ' ';
		if ($id !== null) {
			$id_str = 'id="' . $id . '"';
		}

		$option = '<option value="' . $value . '" ' . $id_str . $selected . ' >' . $title . '</option>';
		return $option;
	}

	/**
	 * Returns HTML Code for two radio buttons with two choices: yes and no
	 *
	 * @param
	 *        	string Name of HTML-Variable
	 * @param
	 *        	string Value which will be returned if user chooses yes
	 * @param
	 *        	string Value which will be returned if user chooses no
	 * @param
	 *        	string Value which is chosen by default
	 * @param
	 *        	bool Whether this element is disabled or not (default: false)
	 * @return string HTML Code
	 * @author Florian Lippert <flo@syscp.org> (2003-2009)
	 * @author Froxlor team <team@froxlor.org> (2010-)
	 */
	public static function makeyesno($name, $yesvalue, $novalue = '', $yesselected = '', $disabled = false)
	{
		global $lng, $theme;

		if ($disabled) {
			$d = ' disabled="disabled"';
		} else {
			$d = '';
		}

		if (isset($_SESSION['requestData'])) {
			$yesselected = $yesselected & $_SESSION['requestData'][$name];
		}

		return '<select class="dropdown_noborder" id="' . $name . '" name="' . $name . '"' . $d . '>
	<option value="' . $yesvalue . '"' . ($yesselected ? ' selected="selected"' : '') . '>' . $lng['panel']['yes'] . '</option><option value="' . $novalue . '"' . ($yesselected ? '' : ' selected="selected"') . '>' . $lng['panel']['no'] . '</option></select>';
	}

	/**
	 * Prints Question on screen
	 *
	 * @param string $text
	 *        	The question
	 * @param string $yesfile
	 *        	File which will be called with POST if user clicks yes
	 * @param array $params
	 *        	Values which will be given to $yesfile. Format: array(variable1=>value1, variable2=>value2, variable3=>value3)
	 * @param string $targetname
	 *        	Name of the target eg Domain or eMail address etc.
	 * @param int $back_nr
	 *        	Number of steps to go back when "No" is pressed
	 *        	
	 * @author Florian Lippert <flo@syscp.org>
	 * @author Froxlor team <team@froxlor.org> (2010-)
	 *        
	 * @return string outputs parsed question_yesno template
	 */
	public static function askYesNo($text, $yesfile, $params = array(), $targetname = '', $back_nr = 1)
	{
		global $userinfo, $s, $header, $footer, $lng, $theme;

		$hiddenparams = '';

		if (is_array($params)) {
			foreach ($params as $field => $value) {
				$hiddenparams .= '<input type="hidden" name="' . htmlspecialchars($field) . '" value="' . htmlspecialchars($value) . '" />' . "\n";
			}
		}

		if (isset($lng['question'][$text])) {
			$text = $lng['question'][$text];
		}

		$text = strtr($text, array(
			'%s' => htmlspecialchars($targetname)
		));
		eval("echo \"" . Template::getTemplate('misc/question_yesno', '1') . "\";");
		exit();
	}

	public static function askYesNoWithCheckbox($text, $chk_text, $yesfile, $params = array(), $targetname = '', $show_checkbox = true)
	{
		global $userinfo, $s, $header, $footer, $lng, $theme;

		$hiddenparams = '';

		if (is_array($params)) {
			foreach ($params as $field => $value) {
				$hiddenparams .= '<input type="hidden" name="' . htmlspecialchars($field) . '" value="' . htmlspecialchars($value) . '" />' . "\n";
			}
		}

		if (isset($lng['question'][$text])) {
			$text = $lng['question'][$text];
		}

		if (isset($lng['question'][$chk_text])) {
			$chk_text = $lng['question'][$chk_text];
		}

		if ($show_checkbox) {
			$checkbox = self::makecheckbox('delete_userfiles', $chk_text, '1', false, '0', true, true);
		} else {
			$checkbox = '<input type="hidden" name="delete_userfiles" value="0" />' . "\n";
		}

		$text = strtr($text, array(
			'%s' => htmlspecialchars($targetname)
		));
		eval("echo \"" . Template::getTemplate('misc/question_yesno_checkbox', '1') . "\";");
		exit();
	}
}
