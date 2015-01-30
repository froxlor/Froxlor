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
 * Get template from filesystem
 *
 * @param string Templatename
 * @param string noarea If area should be used to get template
 * @return string The Template
 * @author Florian Lippert <flo@syscp.org>
 */

function getTemplate($template, $noarea = 0) {

	global $templatecache, $theme;

	$fallback_theme = 'Sparkle';

	if (!isset($theme) || $theme == '') {
		$theme = $fallback_theme;
	}

	if ($noarea != 1) {
		$template = AREA . '/' . $template;
	}

	if (!isset($templatecache[$theme][$template])) {

		$filename = './templates/' . $theme . '/' . $template . '.tpl';

		// check the current selected theme for the template
		$templatefile = _checkAndParseTpl($filename);

		if ($templatefile == false && $theme != $fallback_theme) {
			// check fallback
			$_filename = './templates/' . $fallback_theme . '/' . $template . '.tpl';
			$templatefile = _checkAndParseTpl($_filename);

			if ($templatefile == false) {
				// check for old layout
				$_filename = './templates/' . $template . '.tpl';
				$templatefile = _checkAndParseTpl($_filename);

				if ($templatefile == false) {
					// not found
					$templatefile = 'TEMPLATE NOT FOUND: ' . $filename;
				}
			}
		}

		$output = $templatefile;
		$templatecache[$theme][$template] = $output;
	}

	return $templatecache[$theme][$template];
}

/**
 * check whether a tpl file exists and if so, return it's content or else return false
 *
 * @param string $filename
 *
 * @return string|bool content on success, else false
 */
function _checkAndParseTpl($filename) {

	$templatefile = "";

	if (file_exists($filename)
		&& is_readable($filename)
	) {

		$templatefile = addcslashes(file_get_contents($filename), '"\\');

		// loop through template more than once in case we have an "if"-statement in another one
		while (preg_match('/<if[ \t]*(.*)>(.*)(<\/if>|<else>(.*)<\/if>)/Uis', $templatefile)) {
			$templatefile = preg_replace('/<if[ \t]*(.*)>(.*)(<\/if>|<else>(.*)<\/if>)/Uis', '".( ($1) ? ("$2") : ("$4") )."', $templatefile);
		}

		return $templatefile;
	}
	return false;
}
