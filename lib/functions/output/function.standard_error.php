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
 * Prints one ore more errormessages on screen
 *
 * @param array Errormessages
 * @param string A %s in the errormessage will be replaced by this string.
 * @author Florian Lippert <flo@syscp.org>
 * @author Ron Brand <ron.brand@web.de>
 */

function standard_error($errors = '', $replacer = '')
{
	global $db, $userinfo, $s, $header, $footer, $lng, $theme;
	$_SESSION['requestData'] = $_POST;
	$replacer = htmlentities($replacer);

	if(!is_array($errors))
	{
		$errors = array(
			$errors
		);
	}
	
	if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) !== false) {
		$link = '<a href="'.$_SERVER['HTTP_REFERER'].'">'.$lng['panel']['back'].'</a>';
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
