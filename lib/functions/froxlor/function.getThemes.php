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
function getThemes()
{
	$themespath = makeCorrectDir(dirname(dirname(dirname(dirname(__FILE__)))).'/templates/');
	$themes_available = array();

	if (is_dir($themespath))
	{
		$its = new DirectoryIterator($themespath);

		foreach ($its as $it)
		{
			if ($it->isDir() 
				&& $it->getFilename() != '.' 
				&& $it->getFilename() != '..'
				&& $it->getFilename() != '.svn'
				&& $it->getFilename() != 'misc'
			) {
				$themes_available[$it->getFilename()] = $it->getFilename();
			}
		}
	}
	return $themes_available;
}
