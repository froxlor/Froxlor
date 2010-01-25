<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id$
 */

/**
 * Prints one ore more errormessages on screen
 *
 * @param array Errormessages
 * @param string A %s in the errormessage will be replaced by this string.
 * @author Florian Lippert <flo@syscp.org>
 */

function standard_success($success_message = '', $replacer = '', $params = array())
{
	global $s, $header, $footer, $lng;

	if(isset($lng['success'][$success_message]))
	{
		$success_message = strtr($lng['success'][$success_message], array('%s' => htmlentities($replacer)));
	}
	
	if(is_array($params) && isset($params['filename']))
	{
		$redirect_url = $params['filename'] . '?s=' . $s;
		unset($params['filename']);
		
		foreach($params as $varname => $value)
		{
			if($value != '')
			{
				$redirect_url .= '&amp;' . $varname . '=' . $value;
			}
		}
	}
	else
	{
		$redirect_url = '';
	}

	eval("echo \"" . getTemplate('misc/success', '1') . "\";");
	exit;
}
