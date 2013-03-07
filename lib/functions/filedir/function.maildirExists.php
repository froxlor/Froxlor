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
 * check whether a maildir exists on the filesystem
 * 
 * @param array $result all mail-info of customer
 * 
 * @return boolean 
 */
function maildirExists($result = null)
{
	global $settings, $theme;

	if(is_array($result))
	{
		$loginname = getCustomerDetail($result['customerid'], 'loginname');
		if($loginname !== false) {
			$email_user=substr($result['email_full'],0,strrpos($result['email_full'],"@"));
			$email_domain=substr($result['email_full'],strrpos($result['email_full'],"@")+1);
			$maildirname=trim($settings['system']['vmail_maildirname']);
			$maildir = makeCorrectDir($settings['system']['vmail_homedir'] .'/'. $loginname .'/'. $email_domain .'/'. $email_user . (!empty($maildirname)?'/'.$maildirname:''));
			if(@file_exists($maildir)) {
				return true;
			} else {
				// backward-compatibility for old folder-structure
				$maildir_old = makeCorrectDir($settings['system']['vmail_homedir'] .'/'. $loginname .'/'. $email_user);
				if (@file_exists($maildir_old)) {
					return true;
				}
			}
		}
	}
	return false;
}
