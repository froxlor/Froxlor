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

function getTemplate($template, $noarea = 0)
{
	global $templatecache, $theme;

	if(!isset($theme) || $theme == '')
	{
		$theme = 'Froxlor';
	}

	if($noarea != 1)
	{
		$template = AREA . '/' . $template;
	}

	if(!isset($templatecache[$theme][$template]))
	{
		$filename = './templates/' . $theme . '/' . $template . '.tpl';

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
		elseif(file_exists('./templates/' . $template . '.tpl') && is_readable('./templates/' . $template . '.tpl'))
		{
			$filename = './templates/' . $template . '.tpl';
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

		$output = $templatefile; // Minify_HTML::minify($templatefile, array('cssMinifier', 'jsMinifier'));
		$templatecache[$theme][$template] = $output;
	}

	return $templatecache[$theme][$template];
}
