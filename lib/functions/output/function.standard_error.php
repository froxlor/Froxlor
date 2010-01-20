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
 * @version    $Id: function.standard_error.php 2724 2009-06-07 14:18:02Z flo $
 */

/**
 * Prints one ore more errormessages on screen
 *
 * @param array Errormessages
 * @param string A %s in the errormessage will be replaced by this string.
 * @author Florian Lippert <flo@syscp.org>
 * @author Ron Brand <ron.brand@web.de>
 */

function standard_error($errors = '', $replacer = '')
{
	global $db, $userinfo, $s, $header, $footer, $lng;
	$replacer = htmlentities($replacer);

	if(!is_array($errors))
	{
		$errors = array(
			$errors
		);
	}

	$error = '';
	foreach($errors as $single_error)
	{
		if(isset($lng['error'][$single_error]))
		{
			$single_error = $lng['error'][$single_error];
			$single_error = strtr($single_error, array('%s' => $replacer));
		}
		else
		{
			$error = 'Unknown Error (' . $single_error . '): ' . $replacer;
			break;
		}

		if(empty($error))
		{
			$error = $single_error;
		}
		else
		{
			$error.= ' ' . $single_error;
		}
	}

	eval("echo \"" . getTemplate('misc/error', '1') . "\";");
	exit;
}
