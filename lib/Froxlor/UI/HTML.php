<?php
namespace Froxlor\UI;

class HTML
{

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
		if ($selvalue !== NULL && $value == $selvalue) {
			$checked = 'checked="checked"';
		} else if (isset($_SESSION['requestData'][$name])) {
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
	public static function ask_yesno($text, $yesfile, $params = array(), $targetname = '', $back_nr = 1)
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
			'%s' => $targetname
		));
		eval("echo \"" . Template::getTemplate('misc/question_yesno', '1') . "\";");
		exit();
	}

	public static function ask_yesno_withcheckbox($text, $chk_text, $yesfile, $params = array(), $targetname = '', $show_checkbox = true)
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
			;
		}

		$text = strtr($text, array(
			'%s' => $targetname
		));
		eval("echo \"" . Template::getTemplate('misc/question_yesno_checkbox', '1') . "\";");
		exit();
	}
}