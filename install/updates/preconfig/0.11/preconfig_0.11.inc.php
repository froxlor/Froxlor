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
 * @package    Updater
 *
 */

/**
 * checks if the new-version has some updating to do
 *
 * @param boolean $has_preconfig
 *        	pointer to check if any preconfig has to be output
 * @param string $return
 *        	pointer to output string
 * @param string $current_version
 *        	current froxlor version
 *        	
 * @return void
 */
function parseAndOutputPreconfig011(&$has_preconfig, &$return, $current_version, $current_db_version)
{
	global $lng;

	if (versionInUpdate($current_version, '0.10.99')) {
		$has_preconfig = true;
		$description = 'We have rearranged the settings and split them into basic and advanced categories. This makes it easier for users who do not need all the detailed or very specific settings and options and gives a better overview of the basic/mostly used settings.';
		$return['panel_settings_mode_note'] = ['type' => 'infotext', 'value' => $description];
		$question = '<strong>Chose settings mode (you can change that at any time)</strong>';
		$return['panel_settings_mode'] = [
			'type' => 'select',
			'select_var' => [
				0 => 'Basic',
				1 => 'Advanced'
			],
			'selected' => 1,
			'label' => $question
		];
	}
}
