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
 * @version    $Id$
 */

/**
 * check whether a maildir exists on the filesystem
 * 
 * @param array $result all mail-info of customer
 * 
 * @return boolean 
 */
function maildirExists($result = null)
{
	global $settings;

	if(is_array($result))
	{
		$loginname = getCustomerDetail($result['customerid'], 'loginname');
		if($loginname !== false) {
			$maildir = makeCorrectDir($settings['system']['vmail_homedir'] .'/'. $loginname .'/'. $result['email']);
			if(@file_exists($maildir)) {
				return true;
			}
		}
	}
	return false;
}
