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
 * Build Navigation Sidebar
 * @param array navigation data
 * @param array userinfo the userinfo of the user
 * @return string the content of the navigation bar
 *
 * @author Florian Lippert <flo@syscp.org>
 */

function buildNavigation($navigation, $userinfo)
{
	global $theme;

	$returnvalue = '';
	
	foreach($navigation as $box)
	{
		if((!isset($box['show_element']) || $box['show_element'] === true) &&
			(!isset($box['required_resources']) || $box['required_resources'] == '' || (isset($userinfo[$box['required_resources']]) && ((int)$userinfo[$box['required_resources']] > 0 || $userinfo[$box['required_resources']] == '-1'))))
		{
			$navigation_links = '';
			foreach($box['elements'] as $element_id => $element)
			{
				if((!isset($element['show_element']) || $element['show_element'] === true) &&
					(!isset($element['required_resources']) || $element['required_resources'] == '' || (isset($userinfo[$element['required_resources']]) && ((int)$userinfo[$element['required_resources']] > 0 || $userinfo[$element['required_resources']] == '-1'))))
				{
					if(isset($element['url']) && trim($element['url']) != '')
					{
						// append sid only to local
				
						if(!preg_match('/^https?\:\/\//', $element['url'])
						   && (isset($userinfo['hash']) && $userinfo['hash'] != ''))
						{
							// generate sid with ? oder &
				
							if(strpos($element['url'], '?') !== false)
							{
								$element['url'].= '&s=' . $userinfo['hash'];
							}
							else
							{
								$element['url'].= '?s=' . $userinfo['hash'];
							}
						}
				
						$target = '';
				
						if(isset($element['new_window']) && $element['new_window'] == true)
						{
							$target = ' target="_blank"';
						}
				
						$completeLink = '<a href="' . htmlspecialchars($element['url']) . '"' . $target . ' class="menu">' . $element['label'] . '</a>';
					}
					else
					{
						$completeLink = $element['label'];
					}
				
					eval("\$navigation_links .= \"" . getTemplate("navigation_link", 1) . "\";");
				}
			}
	
			if($navigation_links != '')
			{
				if(isset($box['url']) && trim($box['url']) != '')
				{
					// append sid only to local
			
					if(!preg_match('/^https?\:\/\//', $box['url'])
					   && (isset($userinfo['hash']) && $userinfo['hash'] != ''))
					{
						// generate sid with ? oder &
			
						if(strpos($box['url'], '?') !== false)
						{
							$box['url'].= '&s=' . $userinfo['hash'];
						}
						else
						{
							$box['url'].= '?s=' . $userinfo['hash'];
						}
					}
			
					$target = '';
			
					if(isset($box['new_window']) && $box['new_window'] == true)
					{
						$target = ' target="_blank"';
					}
			
					$completeLink = '<a href="' . htmlspecialchars($box['url']) . '"' . $target . ' class="menu">' . $box['label'] . '</a>';
				}
				else
				{
					$completeLink = $box['label'];
				}
			
				eval("\$returnvalue .= \"" . getTemplate("navigation_element", 1) . "\";");
			}
		}
	}
	
	return $returnvalue;
}
