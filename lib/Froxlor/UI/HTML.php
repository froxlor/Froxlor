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
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    UI
 */
class HTML
{

	/**
	 * Build Navigation Sidebar
	 *
	 * @param
	 *        	array navigation data
	 * @param
	 *        	array userinfo the userinfo of the user
	 * @return array the content of the navigation bar according to user-permissions
	 */
	public static function buildNavigation(array $navigation, array $userinfo)
	{
		$returnvalue = [];

		// sanitize user-given input (url-manipulation)
		if (isset($_GET['page']) && is_array($_GET['page'])) {
			$_GET['page'] = (string) $_GET['page'][0];
		}
		if (isset($_GET['action']) && is_array($_GET['action'])) {
			$_GET['action'] = (string) $_GET['action'][0];
		}

		foreach ($navigation as $box) {
			if ((!isset($box['show_element']) || $box['show_element'] === true) && (!isset($box['required_resources']) || $box['required_resources'] == '' || (isset($userinfo[$box['required_resources']]) && ((int) $userinfo[$box['required_resources']] > 0 || $userinfo[$box['required_resources']] == '-1')))) {
				$navigation_links = [];
				$box_active = false;
				foreach ($box['elements'] as $element) {
					if ((!isset($element['show_element']) || $element['show_element'] === true) && (!isset($element['required_resources']) || $element['required_resources'] == '' || (isset($userinfo[$element['required_resources']]) && ((int) $userinfo[$element['required_resources']] > 0 || $userinfo[$element['required_resources']] == '-1')))) {
						$target = '';
						$active = false;
						$navurl = '#';
						if (isset($element['url']) && trim($element['url']) != '') {

							if (isset($element['new_window']) && $element['new_window'] == true) {
								$target = ' target="_blank"';
							}

							if (isset($_GET['page']) && substr_count($element['url'], "page=" . $_GET['page']) > 0 && substr_count($element['url'], basename($_SERVER["SCRIPT_FILENAME"])) > 0) {
								$active = true;
								$box_active = true;
							}

							$navurl = htmlspecialchars($element['url']);
							$navlabel = $element['label'];
							$icon = $element['icon'] ?? null;
						} else {
							$navlabel = $element['label'];
							$icon = $element['icon'] ?? null;
						}

						$navigation_links[] = [
							'url' => $navurl,
							'target' => $target,
							'active' => $active,
							'label' => $navlabel,
							'icon' => $icon
						];
					}
				}

				if (!empty($navigation_links)) {
					$target = '';
					if (isset($box['url']) && trim($box['url']) != '') {

						if (isset($box['new_window']) && $box['new_window'] == true) {
							$target = ' target="_blank"';
						}

						$navurl = htmlspecialchars($box['url']);
						$navlabel = $box['label'];
						$icon = $box['icon'] ?? null;
					} else {
						$navurl = "#";
						$navlabel = $box['label'];
						$icon = $box['icon'] ?? null;
					}

					$returnvalue[] = [
						'url' => $navurl,
						'target' => $target,
						'label' => $navlabel,
						'icon' => $icon,
						'items' => $navigation_links,
						'active' => $box_active
					];
				}
			}
		}

		return $returnvalue;
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
	 * 
	 * @deprecated
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

		if (!$title_trusted) {
			$title = htmlspecialchars($title);
		}

		if (!$value_trusted) {
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
	 * Output boolean confirm-dialog
	 *
	 * @param string $text
	 *        	The question
	 * @param string $yesfile
	 *        	File which will be called with POST if user clicks yes
	 * @param array $params
	 *        	Values which will be given to $yesfile. Format: array(variable1=>value1, variable2=>value2, variable3=>value3)
	 * @param string $replacer
	 *        	value of a possible existing string-replacer in the question
	 *        	
	 * @author Froxlor team <team@froxlor.org> (2010-)
	 *        
	 * @return string
	 */
	public static function askYesNo(string $text, string $yesfile, array $params = [], string $replacer = '')
	{
		global $lng;

		if (isset($lng['question'][$text])) {
			$text = $lng['question'][$text];
		}

		$text = strtr($text, array(
			'%s' => htmlspecialchars($replacer)
		));

		Panel\UI::twigBuffer('form/yesnoquestion.html.twig', [
			'action' => $yesfile,
			'url_params' => $params,
			'question' => $text
		]);
		Panel\UI::twigOutputBuffer();
		exit();
	}

	public static function askYesNoWithCheckbox(string $text, string $chk_text, string $yesfile, array $params = [], string $replacer = '', bool $show_checkbox = true)
	{
		global $lng;

		if (isset($lng['question'][$text])) {
			$text = $lng['question'][$text];
		}
		$text = strtr($text, array(
			'%s' => htmlspecialchars($replacer)
		));

		if (isset($lng['question'][$chk_text])) {
			$chk_text = $lng['question'][$chk_text];
		}

		Panel\UI::twigBuffer('form/yesnoquestion.html.twig', [
			'action' => $yesfile,
			'url_params' => $params,
			'question' => $text,
			'with_checkbox' => [
				'chk_text' => $chk_text,
				'show' => $show_checkbox
			]
		]);
		Panel\UI::twigOutputBuffer();
		exit();
	}
}
