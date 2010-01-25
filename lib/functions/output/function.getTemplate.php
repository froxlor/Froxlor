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
 * @version    $Id$
 */

/**
 * Get template from filesystem
 *
 * @param string Templatename
 * @param string noarea If area should be used to get template
 * @return string The Template
 * @author Florian Lippert <flo@syscp.org>
 */

function getTemplate($template, $noarea = 0)
{
	global $templatecache;

	if($noarea != 1)
	{
		$template = AREA . '/' . $template;
	}

	if(!isset($templatecache[$template]))
	{
		$filename = './templates/' . $template . '.tpl';

		if(file_exists($filename)
		   && is_readable($filename))
		{
			$templatefile = addcslashes(file_get_contents($filename), '"\\');

			// loop through template more than once in case we have an "if"-statement in another one

			while(preg_match('/<if[ \t]*(.*)>(.*)(<\/if>|<else>(.*)<\/if>)/Uis', $templatefile))
			{
				$templatefile = preg_replace('/<if[ \t]*(.*)>(.*)(<\/if>|<else>(.*)<\/if>)/Uis', '".( ($1) ? ("$2") : ("$4") )."', $templatefile);
			}
		}
		else
		{
			$templatefile = 'TEMPLATE NOT FOUND: ' . $filename;
		}

		$templatecache[$template] = $templatefile;
	}

	return $templatecache[$template];
}
