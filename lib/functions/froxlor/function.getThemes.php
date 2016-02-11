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
 * @package    Functions
 *
 */

/**
 * returns an array for the settings-array
 *
 * @return array
 */
function getThemes() {

	$themespath = makeCorrectDir(FROXLOR_INSTALL_DIR.'/templates/');
	$themes_available = array();

	if (is_dir($themespath)) {
		$its = new DirectoryIterator($themespath);

		foreach ($its as $it) {
			if ($it->isDir() 
				&& $it->getFilename() != '.' 
				&& $it->getFilename() != '..'
				&& $it->getFilename() != 'misc'
			) {
				$theme = $themespath . $it->getFilename();
				if (file_exists($theme . '/config.json')) {
					$themeconfig = json_decode(file_get_contents($theme . '/config.json'), true);
					if (array_key_exists('variants', $themeconfig) && is_array($themeconfig['variants'])) {
						foreach ($themeconfig['variants'] as $variant => $data) {
							if ($variant == "default") {
								$themes_available[$it->getFilename()] = $it->getFilename();
							} elseif (array_key_exists('description', $data)) {
								$themes_available[$it->getFilename() . '_' . $variant] = $data['description'];
							} else {
								$themes_available[$it->getFilename() . '_' . $variant] = $it->getFilename() . ' (' . $variant . ')';
							}
						}
					} else {
						$themes_available[$it->getFilename()] = $it->getFilename();
					}
				}
			}
		}
	}
	return $themes_available;
}
