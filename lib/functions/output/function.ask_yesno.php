<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Prints Question on screen
 *
 * @param string $text       The question
 * @param string $yesfile    File which will be called with POST if user clicks yes
 * @param array  $params     Values which will be given to $yesfile. Format: array(variable1=>value1, variable2=>value2, variable3=>value3)
 * @param string $targetname Name of the target eg Domain or eMail address etc.
 * @param int    $back_nr    Number of steps to go back when "No" is pressed
 * 
 * @author Florian Lippert <flo@syscp.org>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * 
 * @return string outputs parsed question_yesno template
 */

function ask_yesno($text, $yesfile, $params = array(), $targetname = '', $back_nr = 1)
{
	global $userinfo, $db, $s, $header, $footer, $lng, $theme;

	$hiddenparams = '';

	if(is_array($params))
	{
		foreach($params as $field => $value)
		{
			$hiddenparams.= '<input type="hidden" name="' . htmlspecialchars($field) . '" value="' . htmlspecialchars($value) . '" />' . "\n";
		}
	}

	if(isset($lng['question'][$text]))
	{
		$text = $lng['question'][$text];
	}

	$text = strtr($text, array('%s' => $targetname));
	eval("echo \"" . getTemplate('misc/question_yesno', '1') . "\";");
	exit;
}

function ask_yesno_withcheckbox($text, $chk_text, $yesfile, $params = array(), $targetname = '', $show_checkbox = true)
{
	global $userinfo, $db, $s, $header, $footer, $lng, $theme;

	$hiddenparams = '';

	if(is_array($params))
	{
		foreach($params as $field => $value)
		{
			$hiddenparams.= '<input type="hidden" name="' . htmlspecialchars($field) . '" value="' . htmlspecialchars($value) . '" />' . "\n";
		}
	}

	if(isset($lng['question'][$text]))
	{
		$text = $lng['question'][$text];
	}
	
	if(isset($lng['question'][$chk_text]))
	{
		$chk_text = $lng['question'][$chk_text];
	}

	if ($show_checkbox) {
		$checkbox = makecheckbox('delete_userfiles', $chk_text, '1', false, '0', true, true);
	} else {
		$checkbox = '<input type="hidden" name="delete_userfiles" value="0" />' . "\n";;
	}

	$text = strtr($text, array('%s' => $targetname));
	eval("echo \"" . getTemplate('misc/question_yesno_checkbox', '1') . "\";");
	exit;
}

